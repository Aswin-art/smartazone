<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HikerHistoryController extends Controller
{
    public function index()
    {
        return view('Dashboard.pages.hiker-history.index');
    }

    public function getData(Request $request)
    {
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mb.hike_date');
        $orderDir = $request->get('order_dir', 'desc');

        $query = DB::table('mountain_bookings as mb')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->leftJoin('mountain_location_logs as mll', function($join) {
                $join->on('mb.id', '=', 'mll.booking_id')
                     ->whereRaw('mll.id = (SELECT MIN(id) FROM mountain_location_logs WHERE booking_id = mb.id)');
            })
            ->leftJoin('mountain_location_logs as mll_end', function($join) {
                $join->on('mb.id', '=', 'mll_end.booking_id')
                     ->whereRaw('mll_end.id = (SELECT MAX(id) FROM mountain_location_logs WHERE booking_id = mb.id)');
            })
            ->select(
                'u.id as user_id',
                'u.name as user_name',
                'u.email',
                'u.phone',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.hike_date',
                'mb.return_date',
                'mb.checkin_time',
                'mb.checkout_time',
                'mb.total_duration_minutes',
                'mb.status',
                'mb.id as booking_id',
                'mb.team_size',
                'mb.members',
                DB::raw('CASE 
                    WHEN mb.checkin_time IS NOT NULL AND mb.checkout_time IS NOT NULL 
                    THEN TIMESTAMPDIFF(MINUTE, mb.checkin_time, mb.checkout_time)
                    ELSE mb.total_duration_minutes 
                END as actual_duration_minutes'),
                DB::raw('COUNT(DISTINCT mll.id) as total_tracking_points'),
                'mll.latitude as start_latitude',
                'mll.longitude as start_longitude',
                'mll_end.latitude as end_latitude',
                'mll_end.longitude as end_longitude'
            )
            ->where('u.user_type', 'pendaki')
            ->groupBy(
                'u.id', 'u.name', 'u.email', 'u.phone',
                'm.name', 'm.location', 
                'mb.hike_date', 'mb.return_date', 
                'mb.checkin_time', 'mb.checkout_time', 
                'mb.total_duration_minutes', 'mb.status', 
                'mb.id', 'mb.team_size', 'mb.members',
                'mll.latitude', 'mll.longitude',
                'mll_end.latitude', 'mll_end.longitude'
            );

        // Apply search filter
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

        // Get total count before pagination
        $totalRecords = $query->count();

        // Apply ordering and pagination
        $hikerHistory = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format the data for DataTables
        $data = $hikerHistory->map(function ($history) {
            // Calculate duration in hours and minutes
            $durationMinutes = $history->actual_duration_minutes;
            $durationHours = 0;
            $durationMins = 0;
            
            if ($durationMinutes) {
                $durationHours = floor($durationMinutes / 60);
                $durationMins = $durationMinutes % 60;
            }

            $durationText = '';
            if ($durationHours > 0 || $durationMins > 0) {
                $durationText = "{$durationHours} jam {$durationMins} menit";
            } else {
                $durationText = '-';
            }

            // Parse team members
            $members = [];
            if ($history->members) {
                $membersData = json_decode($history->members, true);
                if (is_array($membersData)) {
                    $members = $membersData;
                }
            }

            // Format tracking route info
            $trackingInfo = '';
            if ($history->total_tracking_points > 0) {
                $trackingInfo = "Ya ({$history->total_tracking_points} titik)";
            } else {
                $trackingInfo = 'Tidak ada tracking';
            }

            return [
                'user_name' => $history->user_name,
                'email' => $history->email,
                'phone' => $history->phone,
                'mountain_name' => $history->mountain_name,
                'mountain_location' => $history->mountain_location,
                'hike_date' => $history->hike_date ? date('d/m/Y', strtotime($history->hike_date)) : '-',
                'return_date' => $history->return_date ? date('d/m/Y', strtotime($history->return_date)) : '-',
                'checkin_time' => $history->checkin_time ? date('d/m/Y H:i', strtotime($history->checkin_time)) : '-',
                'checkout_time' => $history->checkout_time ? date('d/m/Y H:i', strtotime($history->checkout_time)) : '-',
                'total_duration' => $durationText,
                'status' => ucfirst($history->status),
                'team_size' => $history->team_size,
                'members_count' => count($members),
                'has_tracking' => $history->total_tracking_points > 0,
                'tracking_info' => $trackingInfo,
                'booking_id' => $history->booking_id,
                'actions' => $history->booking_id
            ];
        });

        return response()->json([
            'draw' => intval($request->get('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function show($bookingId)
    {
        $booking = DB::table('mountain_bookings as mb')
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

        if (!$booking) {
            return response()->json(['error' => 'Booking tidak ditemukan'], 404);
        }

        // Get location tracking data
        $locationLogs = DB::table('mountain_location_logs')
            ->where('booking_id', $bookingId)
            ->orderBy('timestamp', 'asc')
            ->get();

        // Get health logs
        $healthLogs = DB::table('mountain_health_logs')
            ->where('booking_id', $bookingId)
            ->orderBy('timestamp', 'desc')
            ->limit(10)
            ->get();

        // Get equipment rentals
        $equipmentRentals = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
            ->select('me.name', 'mer.quantity', 'mer.status')
            ->where('mer.booking_id', $bookingId)
            ->get();

        // Parse members
        $members = [];
        if ($booking->members) {
            $members = json_decode($booking->members, true) ?: [];
        }

        // Calculate total duration
        $totalDuration = null;
        if ($booking->checkin_time && $booking->checkout_time) {
            $checkin = new \DateTime($booking->checkin_time);
            $checkout = new \DateTime($booking->checkout_time);
            $interval = $checkin->diff($checkout);
            $totalDuration = [
                'days' => $interval->d,
                'hours' => $interval->h,
                'minutes' => $interval->i,
                'total_minutes' => $interval->days * 24 * 60 + $interval->h * 60 + $interval->i
            ];
        }

        return response()->json([
            'booking' => $booking,
            'members' => $members,
            'location_logs' => $locationLogs,
            'health_logs' => $healthLogs,
            'equipment_rentals' => $equipmentRentals,
            'total_duration' => $totalDuration
        ]);
    }

    public function getTrackingRoute($bookingId)
    {
        $locationLogs = DB::table('mountain_location_logs')
            ->where('booking_id', $bookingId)
            ->orderBy('timestamp', 'asc')
            ->select('latitude', 'longitude', 'timestamp')
            ->get();

        return response()->json([
            'route' => $locationLogs->map(function ($log) {
                return [
                    'lat' => floatval($log->latitude),
                    'lng' => floatval($log->longitude),
                    'timestamp' => $log->timestamp
                ];
            })
        ]);
    }
}