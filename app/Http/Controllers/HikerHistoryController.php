<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;

class HikerHistoryController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.hiker-history.index');
    }

    // public function getData(Request $request)
    // {
    //     $mountainId = Auth::user()->mountain_id;
    //     $search = $request->get('search', '');
    //     $start  = $request->get('start', 0);
    //     $length = $request->get('length', 10);
    //     $orderColumn = $request->get('order_column', 'mb.hike_date');
    //     $orderDir    = $request->get('order_dir', 'desc');

    //     $query = DB::table('mountain_bookings as mb')
    //         ->join('users as u', 'mb.user_id', '=', 'u.id')
    //         ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
    //         ->leftJoin('mountain_feedbacks as f', 'mb.id', '=', 'f.booking_id')
    //         ->select(
    //             'u.id as user_id',
    //             'u.name as user_name',
    //             'u.email',
    //             'u.phone',
    //             'm.name as mountain_name',
    //             'm.location as mountain_location',
    //             'mb.id as booking_id',
    //             'mb.status',
    //             'mb.hike_date as start_time',
    //             'mb.return_date as end_time',
    //             'mb.total_duration_minutes',
    //             'mb.checkin_time',
    //             'mb.checkout_time',
    //             DB::raw('ROUND(AVG(COALESCE(f.rating, 0)), 1) as avg_rating')
    //         )
    //         ->when($mountainId, fn($q) => $q->where('mb.mountain_id', $mountainId))
    //         ->where('u.user_type', 'pendaki')
    //         ->groupBy(
    //             'u.id',
    //             'u.name',
    //             'u.email',
    //             'u.phone',
    //             'm.name',
    //             'm.location',
    //             'mb.id',
    //             'mb.status',
    //             'mb.hike_date',
    //             'mb.return_date',
    //             'mb.total_duration_minutes',
    //             'mb.checkin_time',
    //             'mb.checkout_time'
    //         );


    //     if (!empty($search)) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('u.name', 'LIKE', "%{$search}%")
    //                 ->orWhere('u.email', 'LIKE', "%{$search}%")
    //                 ->orWhere('u.phone', 'LIKE', "%{$search}%")
    //                 ->orWhere('m.name', 'LIKE', "%{$search}%")
    //                 ->orWhere('m.location', 'LIKE', "%{$search}%")
    //                 ->orWhere('mb.status', 'LIKE', "%{$search}%");
    //         });
    //     }

    //     $totalRecords = $query->count();

    //     $histories = $query->orderBy($orderColumn, $orderDir)
    //         ->skip($start)
    //         ->take($length)
    //         ->get();

    //     $data = $histories->map(function ($history) {
    //         $durationText = '-';
    //         if ($history->total_duration_minutes) {
    //             $hours = floor($history->total_duration_minutes / 60);
    //             $minutes = $history->total_duration_minutes % 60;
    //             $durationText = "{$hours} jam {$minutes} menit";
    //         }

    //         return [
    //             'user_name'        => $history->user_name,
    //             'email'            => $history->email,
    //             'phone'            => $history->phone,
    //             'mountain_name'    => $history->mountain_name,
    //             'mountain_location' => $history->mountain_location,
    //             'start_time'       => $history->start_time ? date('d/m/Y', strtotime($history->start_time)) : '-',
    //             'end_time'         => $history->end_time ? date('d/m/Y', strtotime($history->end_time)) : '-',
    //             'total_duration'   => $durationText,
    //             'avg_rating'       => $history->avg_rating,
    //             'status'           => ucfirst($history->status),
    //             'booking_id'       => $history->booking_id
    //         ];
    //     });

    //     return response()->json([
    //         'draw'            => intval($request->get('draw', 1)),
    //         'recordsTotal'    => $totalRecords,
    //         'recordsFiltered' => $totalRecords,
    //         'data'            => $data
    //     ]);
    // }

    public function getData(Request $request)
{
    $mountainId = Auth::user()->mountain_id;
    $search = $request->get('search', '');
    $start  = $request->get('start', 0);
    $length = $request->get('length', 10);
    $orderColumn = $request->get('order_column', 'mb.hike_date');
    $orderDir    = $request->get('order_dir', 'desc');

    $feedbackAvg = DB::table('mountain_feedbacks')
        ->select('booking_id', DB::raw('ROUND(AVG(rating), 1) AS avg_rating'))
        ->groupBy('booking_id');

    $query = DB::table('mountain_bookings as mb')
        ->join('users as u', 'mb.user_id', '=', 'u.id')
        ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
        ->leftJoinSub($feedbackAvg, 'f', function ($join) {
            $join->on('mb.id', '=', 'f.booking_id');
        })
        ->select(
            'u.id as user_id',
            'u.name as user_name',
            'u.email',
            'u.phone',
            'm.name as mountain_name',
            'm.location as mountain_location',
            'mb.id as booking_id',
            'mb.status',
            'mb.hike_date as start_time',
            'mb.return_date as end_time',
            'mb.total_duration_minutes',
            'mb.checkin_time',
            'mb.checkout_time',
            DB::raw('COALESCE(f.avg_rating, 0) AS avg_rating')
        )
        ->when($mountainId, fn($q) => $q->where('mb.mountain_id', $mountainId))
        ->where('u.user_type', 'pendaki');

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('u.name', 'LIKE', "%{$search}%")
                ->orWhere('u.email', 'LIKE', "%{$search}%")
                ->orWhere('u.phone', 'LIKE', "%{$search}%")
                ->orWhere('m.name', 'LIKE', "%{$search}%")
                ->orWhere('m.location', 'LIKE', "%{$search}%")
                ->orWhere('mb.status', 'LIKE', "%{$search}%");
        });
    }

    $totalRecords = $query->count();

    $histories = $query->orderBy($orderColumn, $orderDir)
        ->skip($start)
        ->take($length)
        ->get();

    $data = $histories->map(function ($history) {
        $durationText = '-';
        if ($history->total_duration_minutes) {
            $hours = floor($history->total_duration_minutes / 60);
            $minutes = $history->total_duration_minutes % 60;
            $durationText = "{$hours} jam {$minutes} menit";
        }

        return [
            'user_name'        => $history->user_name,
            'email'            => $history->email,
            'phone'            => $history->phone,
            'mountain_name'    => $history->mountain_name,
            'mountain_location' => $history->mountain_location,
            'start_time'       => $history->start_time ? date('d/m/Y', strtotime($history->start_time)) : '-',
            'end_time'         => $history->end_time ? date('d/m/Y', strtotime($history->end_time)) : '-',
            'total_duration'   => $durationText,
            'avg_rating'       => $history->avg_rating,
            'status'           => ucfirst($history->status),
            'booking_id'       => $history->booking_id
        ];
    });

    return response()->json([
        'draw'            => intval($request->get('draw', 1)),
        'recordsTotal'    => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data'            => $data
    ]);
}


    public function show($bookingId)
    {
        $history = DB::table('mountain_bookings as mb')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->select(
                'u.name as user_name',
                'u.email',
                'u.phone',
                'u.emergency_contact',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.*'
            )
            ->where('mb.id', $bookingId)
            ->first();

        if (!$history) {
            return response()->json(['error' => 'Data pendakian tidak ditemukan'], 404);
        }

        $hikerLogs = DB::table('mountain_hiker_logs')
            ->where('booking_id', $bookingId)
            ->orderBy('timestamp', 'asc')
            ->get();

        $equipmentRentals = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
            ->select('me.name', 'mer.quantity', 'mer.status')
            ->where('mer.booking_id', $bookingId)
            ->get();

        $feedback = DB::table('mountain_feedbacks')
            ->where('booking_id', $bookingId)
            ->select('rating', 'comment', 'image_url', 'created_at')
            ->first();

        $totalDuration = null;
        if ($history->checkin_time && $history->checkout_time) {
            $start = new DateTime($history->checkin_time);
            $end   = new DateTime($history->checkout_time);
            $interval = $start->diff($end);
            $totalDuration = [
                'days' => $interval->d,
                'hours' => $interval->h,
                'minutes' => $interval->i,
                'total_minutes' => $interval->days * 24 * 60 + $interval->h * 60 + $interval->i
            ];
        }

        return response()->json([
            'history'          => $history,
            'hiker_logs'       => $hikerLogs,
            'equipment_rentals' => $equipmentRentals,
            'feedback'         => $feedback,
            'total_duration'   => $totalDuration
        ]);
    }

    public function getTrackingRoute($bookingId)
    {
        $logs = DB::table('mountain_hiker_logs')
            ->where('booking_id', $bookingId)
            ->orderBy('timestamp', 'asc')
            ->select('latitude', 'longitude', 'timestamp')
            ->get();

        return response()->json([
            'route' => $logs->map(fn($log) => [
                'lat' => floatval($log->latitude),
                'lng' => floatval($log->longitude),
                'timestamp' => $log->timestamp
            ])
        ]);
    }
}
