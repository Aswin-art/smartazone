<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HikersController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.hikers.index');
    }

public function getData(Request $request)
{
    $mountainId = Auth::user()->mountain_id;

    $search = $request->get('search', '');
    $start = $request->get('start', 0);
    $length = $request->get('length', 10);
    $orderColumn = $request->get('order_column', 'mb.hike_date');
    $orderDir = $request->get('order_dir', 'desc');

    $query = DB::table('mountain_bookings as mb')
        ->join('users as u', 'mb.user_id', '=', 'u.id')
        ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
        ->leftJoin('mountain_feedbacks as f', 'mb.id', '=', 'f.booking_id')
        ->leftJoin('mountain_hiker_status as hs', 'mb.id', '=', 'hs.booking_id')
        ->leftJoin('mountain_hiker_logs as hl', 'hs.device_id', '=', 'hl.device_id')
        ->select(
            'u.id as user_id',
            'u.name as user_name',
            'u.email',
            'm.name as mountain_name',
            'm.location as mountain_location',
            'mb.hike_date',
            'mb.return_date',
            'mb.checkin_time',
            'mb.checkout_time',
            'mb.total_duration_minutes',
            'mb.status as hike_status',
            DB::raw('ROUND(AVG(COALESCE(f.rating, 0)), 1) as avg_rating'),
            DB::raw('COUNT(DISTINCT f.id) as total_feedbacks'),
            DB::raw('ROUND(AVG(COALESCE(hl.spo2, 0)), 1) as avg_spo2'),
            DB::raw('ROUND(AVG(COALESCE(hl.stress_level, 0)), 1) as avg_stress')
        )
        ->when($mountainId, fn($q) => $q->where('mb.mountain_id', $mountainId))
        ->groupBy(
            'u.id', 'u.name', 'u.email',
            'm.name', 'm.location',
            'mb.hike_date', 'mb.return_date',
            'mb.checkin_time', 'mb.checkout_time',
            'mb.total_duration_minutes', 'mb.status'
        );

    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('u.name', 'LIKE', "%{$search}%")
                ->orWhere('u.email', 'LIKE', "%{$search}%")
                ->orWhere('m.name', 'LIKE', "%{$search}%")
                ->orWhere('mb.status', 'LIKE', "%{$search}%");
        });
    }

    $totalRecords = $query->count();

    $hikers = $query->orderBy($orderColumn, $orderDir)
        ->skip($start)
        ->take($length)
        ->get();

    $data = $hikers->map(function ($hiker) {
        return [
            'user_name' => $hiker->user_name,
            'email' => $hiker->email,
            'mountain_name' => $hiker->mountain_name,
            'hike_date' => $hiker->hike_date ? date('Y-m-d', strtotime($hiker->hike_date)) : '-',
            'return_date' => $hiker->return_date ? date('Y-m-d', strtotime($hiker->return_date)) : '-',
            'duration_hours' => $hiker->total_duration_minutes
                ? round($hiker->total_duration_minutes / 60, 1) . ' jam'
                : '-',
            'avg_rating' => $hiker->avg_rating ?? '-',
            'avg_spo2' => $hiker->avg_spo2 ? $hiker->avg_spo2 . '%' : '-',
            'avg_stress' => $hiker->avg_stress ?? '-',
            'status' => ucfirst($hiker->hike_status)
        ];
    });

    return response()->json([
        'draw' => intval($request->get('draw', 1)),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $data
    ]);
}

    
}
