<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthMonitoringController extends Controller
{
    public function index()
    {
        return view('Dashboard.pages.health-monitoring.index');
    }

    public function getData(Request $request)
    {
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mhl.timestamp');
        $orderDir = $request->get('order_dir', 'desc');

        $query = DB::table('mountain_health_logs as mhl')
            ->join('mountain_bookings as mb', 'mhl.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mhl.mountain_id', '=', 'm.id')
            ->select(
                'mhl.id as log_id',
                'u.name as user_name',
                'u.email',
                'm.name as mountain_name',
                'mhl.heart_rate',
                'mhl.body_temperature',
                'mhl.timestamp',
                'mb.id as booking_id',
                'mb.status as booking_status'
            );

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%");
            });
        }

        // Only show active bookings
        $query->where('mb.status', 'active');

        // Get total count before pagination
        $totalRecords = $query->count();

        // Apply ordering and pagination
        $healthLogs = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format the data for DataTables
        $data = $healthLogs->map(function ($log) {
            return [
                'user_name' => $log->user_name,
                'email' => $log->email,
                'mountain_name' => $log->mountain_name,
                'heart_rate' => $log->heart_rate,
                'body_temperature' => $log->body_temperature,
                'timestamp' => date('Y-m-d H:i:s', strtotime($log->timestamp)),
                'health_status' => $this->getHealthStatus($log->heart_rate, $log->body_temperature),
                'log_id' => $log->log_id,
                'booking_id' => $log->booking_id
            ];
        });

        return response()->json([
            'draw' => intval($request->get('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function getHikerHealth($bookingId)
    {
        $healthData = DB::table('mountain_health_logs as mhl')
            ->join('mountain_bookings as mb', 'mhl.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mhl.mountain_id', '=', 'm.id')
            ->select(
                'u.name as user_name',
                'u.email',
                'm.name as mountain_name',
                'mhl.heart_rate',
                'mhl.body_temperature',
                'mhl.timestamp'
            )
            ->where('mhl.booking_id', $bookingId)
            ->orderBy('mhl.timestamp', 'desc')
            ->limit(24) // Last 24 readings
            ->get();

        if ($healthData->isEmpty()) {
            return response()->json(['error' => 'No health data found'], 404);
        }

        // Calculate averages and trends
        $avgHeartRate = $healthData->avg('heart_rate');
        $avgTemperature = $healthData->avg('body_temperature');
        $latestReading = $healthData->first();

        return response()->json([
            'hiker_info' => [
                'name' => $latestReading->user_name,
                'email' => $latestReading->email,
                'mountain' => $latestReading->mountain_name
            ],
            'current_status' => $this->getHealthStatus($latestReading->heart_rate, $latestReading->body_temperature),
            'latest_reading' => [
                'heart_rate' => $latestReading->heart_rate,
                'body_temperature' => $latestReading->body_temperature,
                'timestamp' => $latestReading->timestamp
            ],
            'averages' => [
                'heart_rate' => round($avgHeartRate, 1),
                'body_temperature' => round($avgTemperature, 1)
            ],
            'readings' => $healthData
        ]);
    }

    public function getHealthStats()
    {
        // Get current health statistics
        $totalActiveHikers = DB::table('mountain_bookings')
            ->where('status', 'active')
            ->count();

        $criticalHikers = DB::table('mountain_health_logs as mhl')
            ->join('mountain_bookings as mb', 'mhl.booking_id', '=', 'mb.id')
            ->where('mb.status', 'active')
            ->where(function ($q) {
                $q->where('mhl.heart_rate', '>', 120)
                    ->orWhere('mhl.heart_rate', '<', 50)
                    ->orWhere('mhl.body_temperature', '>', 38.5)
                    ->orWhere('mhl.body_temperature', '<', 35.0);
            })
            ->distinct('mhl.booking_id')
            ->count();

        $recentAlerts = DB::table('mountain_health_logs as mhl')
            ->join('mountain_bookings as mb', 'mhl.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mhl.mountain_id', '=', 'm.id')
            ->select(
                'u.name as user_name',
                'm.name as mountain_name',
                'mhl.heart_rate',
                'mhl.body_temperature',
                'mhl.timestamp'
            )
            ->where('mb.status', 'active')
            ->where(function ($q) {
                $q->where('mhl.heart_rate', '>', 120)
                    ->orWhere('mhl.heart_rate', '<', 50)
                    ->orWhere('mhl.body_temperature', '>', 38.5)
                    ->orWhere('mhl.body_temperature', '<', 35.0);
            })
            ->where('mhl.timestamp', '>=', now()->subHours(1))
            ->orderBy('mhl.timestamp', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'total_active' => $totalActiveHikers,
            'critical_hikers' => $criticalHikers,
            'recent_alerts' => $recentAlerts->count(),
            'alert_details' => $recentAlerts
        ]);
    }

    public function getChartData($bookingId)
    {
        $data = DB::table('mountain_health_logs')
            ->select('heart_rate', 'body_temperature', 'timestamp')
            ->where('booking_id', $bookingId)
            ->orderBy('timestamp', 'desc')
            ->limit(48) // Last 48 readings (24 hours if every 30 min)
            ->get()
            ->reverse()
            ->values();

        return response()->json($data);
    }

    private function getHealthStatus($heartRate, $bodyTemperature)
    {
        // Critical conditions
        if ($heartRate > 120 || $heartRate < 50 || $bodyTemperature > 38.5 || $bodyTemperature < 35.0) {
            return 'critical';
        }
        
        // Warning conditions
        if ($heartRate > 100 || $heartRate < 60 || $bodyTemperature > 37.8 || $bodyTemperature < 35.5) {
            return 'warning';
        }
        
        return 'normal';
    }

    public function sendHealthAlert(Request $request)
    {
        // This would integrate with notification system
        // For now, just log the alert
        DB::table('health_alerts')->insert([
            'booking_id' => $request->booking_id,
            'alert_type' => $request->alert_type,
            'message' => $request->message,
            'created_at' => now()
        ]);

        return response()->json(['success' => 'Alert sent successfully']);
    }
}