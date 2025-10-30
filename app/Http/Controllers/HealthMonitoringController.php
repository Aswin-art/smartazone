<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HealthMonitoringController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.health-monitoring.index');
    }

    public function getData(Request $request)
    {
        $mountainId = Auth::user()->mountain_id;
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);

        $allowedColumns = [
            'hl.timestamp',
            'u.name',
            'u.email',
            'm.name',
            'hl.heart_rate',
            'hl.spo2',
            'hl.stress_level'
        ];

        $orderColumn = $request->get('order_column', 'hl.timestamp');
        if (!in_array($orderColumn, $allowedColumns)) {
            $orderColumn = 'hl.timestamp';
        }

        $orderDir = $request->get('order_dir', 'desc');

        // Subquery untuk mendapatkan log terbaru per booking
        $subquery = DB::table('mountain_hiker_logs as hl')
            ->select(
                'hl.booking_id',
                DB::raw('MAX(hl.timestamp) as latest_time')
            )
            ->groupBy('hl.booking_id');

        // Query utama
        $baseQuery = DB::table('mountain_bookings as mb')
            ->leftJoinSub($subquery, 'latest', function ($join) {
                $join->on('mb.id', '=', 'latest.booking_id');
            })
            ->leftJoin('mountain_hiker_logs as hl', function ($join) {
                $join->on('mb.id', '=', 'hl.booking_id')
                    ->on('hl.timestamp', '=', 'latest.latest_time');
            })
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->when($mountainId, fn($q) => $q->where('mb.mountain_id', $mountainId))
            ->where('mb.status', 'active')
            ->select(
                'mb.id as booking_id',
                'u.name as user_name',
                'u.email',
                'm.name as mountain_name',
                DB::raw('COALESCE(hl.heart_rate, 0) as heart_rate'),
                DB::raw('COALESCE(hl.spo2, 0) as spo2'),
                DB::raw('COALESCE(hl.stress_level, 0) as stress_level'),
                DB::raw('hl.timestamp as timestamp')
            );

        if ($search !== '') {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('u.name', 'like', "%{$search}%")
                    ->orWhere('u.email', 'like', "%{$search}%")
                    ->orWhere('m.name', 'like', "%{$search}%");
            });
        }

        $totalRecords = (clone $baseQuery)->distinct('mb.id')->count('mb.id');

        $logs = $baseQuery
            ->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $data = $logs->map(function ($log) {
            return [
                'user_name' => $log->user_name,
                'email' => $log->email,
                'mountain_name' => $log->mountain_name,
                'heart_rate' => $log->heart_rate > 0 ? "{$log->heart_rate} bpm" : '-',
                'spo2' => $log->spo2 > 0 ? "{$log->spo2}%" : '-',
                'stress_level' => $log->stress_level > 0 ? $log->stress_level : '-',
                'timestamp' => $log->timestamp
                    ? \Carbon\Carbon::parse($log->timestamp)->format('d/m/Y H:i:s')
                    : '-',
                'health_status' => $this->getHealthStatus($log->heart_rate, $log->spo2, $log->stress_level),
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

    public function getHealthStats()
    {
        $mountainId = Auth::user()->mountain_id;

        $subquery = DB::table('mountain_hiker_logs as hl')
            ->select(
                'hl.booking_id',
                DB::raw('MAX(hl.timestamp) as latest_time')
            )
            ->groupBy('hl.booking_id');

        $baseBookings = DB::table('mountain_bookings as mb')
            ->leftJoinSub($subquery, 'latest', function ($join) {
                $join->on('mb.id', '=', 'latest.booking_id');
            })
            ->leftJoin('mountain_hiker_logs as hl', function ($join) {
                $join->on('mb.id', '=', 'hl.booking_id')
                    ->on('hl.timestamp', '=', 'latest.latest_time');
            })
            ->when($mountainId, fn($q) => $q->where('mb.mountain_id', $mountainId))
            ->where('mb.status', 'active');

        $totalActiveHikers = (clone $baseBookings)
            ->distinct('mb.id')
            ->count('mb.id');

        $criticalHikers = (clone $baseBookings)
            ->where(function ($q) {
                $q->where('hl.heart_rate', '>', 120)
                    ->orWhere('hl.heart_rate', '<', 50)
                    ->orWhere('hl.spo2', '<', 90)
                    ->orWhere('hl.stress_level', '>', 7);
            })
            ->distinct('mb.id')
            ->count('mb.id');

        $recentAlerts = (clone $baseBookings)
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->select(
                'u.name as user_name',
                'm.name as mountain_name',
                'hl.heart_rate',
                'hl.spo2',
                'hl.stress_level',
                'hl.timestamp'
            )
            ->where(function ($q) {
                $q->where('hl.heart_rate', '>', 120)
                    ->orWhere('hl.heart_rate', '<', 50)
                    ->orWhere('hl.spo2', '<', 90)
                    ->orWhere('hl.stress_level', '>', 7);
            })
            ->where('hl.timestamp', '>=', now()->subHour())
            ->orderByDesc('hl.timestamp')
            ->limit(10)
            ->get();

        return response()->json([
            'total_active' => $totalActiveHikers,
            'critical_hikers' => $criticalHikers,
            'recent_alerts' => $recentAlerts->count(),
            'alert_details' => $recentAlerts
        ]);
    }

    public function getHikerHealth($bookingId)
    {
        $healthData = DB::table('mountain_hiker_logs as hl')
            ->join('mountain_bookings as mb', 'hl.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'hl.mountain_id', '=', 'm.id')
            ->select(
                'u.name as user_name',
                'u.email',
                'm.name as mountain_name',
                'hl.heart_rate',
                'hl.spo2',
                'hl.stress_level',
                'hl.timestamp'
            )
            ->where('hl.booking_id', $bookingId)
            ->orderBy('hl.timestamp', 'desc')
            ->limit(48)
            ->get();

        if ($healthData->isEmpty()) {
            return response()->json(['error' => 'Tidak ada data kesehatan'], 404);
        }

        $avgHeartRate = $healthData->avg('heart_rate');
        $avgSpo2 = $healthData->avg('spo2');
        $avgStress = $healthData->avg('stress_level');
        $latest = $healthData->first();

        return response()->json([
            'hiker_info' => [
                'name' => $latest->user_name,
                'email' => $latest->email,
                'mountain' => $latest->mountain_name
            ],
            'current_status' => $this->getHealthStatus($latest->heart_rate, $latest->spo2, $latest->stress_level),
            'latest_reading' => [
                'heart_rate' => $latest->heart_rate,
                'spo2' => $latest->spo2,
                'stress_level' => $latest->stress_level,
                'timestamp' => $latest->timestamp
            ],
            'averages' => [
                'heart_rate' => round($avgHeartRate, 1),
                'spo2' => round($avgSpo2, 1),
                'stress_level' => round($avgStress, 1)
            ],
            'readings' => $healthData
        ]);
    }

    public function getChartData($bookingId)
    {
        $data = DB::table('mountain_hiker_logs')
            ->select('heart_rate', 'spo2', 'stress_level', 'timestamp')
            ->where('booking_id', $bookingId)
            ->orderBy('timestamp', 'desc')
            ->limit(48)
            ->get()
            ->reverse()
            ->values();

        return response()->json($data);
    }

    private function getHealthStatus($heartRate, $spo2, $stress)
    {
        if ($heartRate > 120 || $heartRate < 50 || $spo2 < 90 || $stress > 7) {
            return 'critical';
        }
        if ($heartRate > 100 || $heartRate < 60 || $spo2 < 94 || $stress > 5) {
            return 'warning';
        }
        return 'normal';
    }

    public function sendHealthAlert(Request $request)
    {
        DB::table('mountain_sos_signals')->insert([
            'booking_id' => $request->booking_id,
            'mountain_id' => Auth::user()->mountain_id,
            'timestamp' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'message' => $request->message ?? 'Peringatan kesehatan otomatis: kondisi vital tidak normal'
        ]);

        return response()->json(['success' => 'Peringatan kesehatan berhasil dikirim']);
    }
}
