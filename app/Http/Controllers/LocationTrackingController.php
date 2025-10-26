<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocationTrackingController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.location-tracking.index');
    }

    public function getActiveHikers()
    {
        $activeHikers = DB::table('mountain_hiking_histories as mh')
            ->join('users as u', 'mh.user_id', '=', 'u.id')
            ->join('mountains as m', 'mh.mountain_id', '=', 'm.id')
            ->leftJoin('mountain_location_logs as mll', function ($join) {
                $join->on('mh.booking_id', '=', 'mll.booking_id')
                    ->whereRaw('mll.id = (SELECT MAX(id) FROM mountain_location_logs WHERE booking_id = mh.booking_id)');
            })
            ->select(
                'mh.booking_id',
                'u.name as user_name',
                'u.email',
                'u.phone',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mh.start_time',
                'mh.status',
                'mll.latitude',
                'mll.longitude',
                'mll.timestamp as last_location_update'
            )
            ->where('mh.status', 'active')
            ->get();

        return response()->json($activeHikers);
    }

    public function getHikerLocationHistory($bookingId)
    {
        $locations = DB::table('mountain_location_logs as mll')
            ->join('mountain_hiking_histories as mh', 'mll.booking_id', '=', 'mh.booking_id')
            ->join('users as u', 'mh.user_id', '=', 'u.id')
            ->join('mountains as m', 'mll.mountain_id', '=', 'm.id')
            ->select(
                'u.name as user_name',
                'm.name as mountain_name',
                'mll.latitude',
                'mll.longitude',
                'mll.timestamp'
            )
            ->where('mll.booking_id', $bookingId)
            ->orderBy('mll.timestamp', 'desc')
            ->limit(100)
            ->get();

        if ($locations->isEmpty()) {
            return response()->json(['error' => 'Data lokasi tidak ditemukan'], 404);
        }

        return response()->json([
            'hiker_info' => [
                'name' => $locations->first()->user_name,
                'mountain' => $locations->first()->mountain_name
            ],
            'locations' => $locations
        ]);
    }

    public function getLocationStats()
    {
        $totalActiveHikers = DB::table('mountain_hiking_histories')
            ->where('status', 'active')
            ->count();

        $hikersWithRecentLocation = DB::table('mountain_hiking_histories as mh')
            ->join('mountain_location_logs as mll', 'mh.booking_id', '=', 'mll.booking_id')
            ->where('mh.status', 'active')
            ->where('mll.timestamp', '>=', Carbon::now()->subMinutes(30))
            ->distinct('mh.booking_id')
            ->count();

        $offlineHikers = $totalActiveHikers - $hikersWithRecentLocation;

        $hikersByMountain = DB::table('mountain_hiking_histories as mh')
            ->join('mountains as m', 'mh.mountain_id', '=', 'm.id')
            ->select('m.name as mountain_name', DB::raw('COUNT(*) as hiker_count'))
            ->where('mh.status', 'active')
            ->groupBy('m.id', 'm.name')
            ->get();

        return response()->json([
            'total_active' => $totalActiveHikers,
            'online_hikers' => $hikersWithRecentLocation,
            'offline_hikers' => $offlineHikers,
            'hikers_by_mountain' => $hikersByMountain
        ]);
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:mountain_hiking_histories,booking_id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        $booking = DB::table('mountain_hiking_histories')
            ->where('booking_id', $request->booking_id)
            ->first();

        if (!$booking) {
            return response()->json(['error' => 'Data pendakian tidak ditemukan'], 404);
        }

        DB::table('mountain_location_logs')->insert([
            'booking_id' => $request->booking_id,
            'mountain_id' => $booking->mountain_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timestamp' => Carbon::now()
        ]);

        return response()->json(['success' => 'Lokasi berhasil diperbarui']);
    }

    public function getGeofenceAlerts()
    {
        $alerts = DB::table('mountain_geofence_alerts as mga')
            ->join('users as u', 'mga.user_id', '=', 'u.id')
            ->join('mountains as m', 'mga.mountain_id', '=', 'm.id')
            ->select(
                'mga.id',
                'u.name as user_name',
                'm.name as mountain_name',
                'mga.latitude',
                'mga.longitude',
                'mga.message',
                'mga.created_at'
            )
            ->orderBy('mga.created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json(['alerts' => $alerts]);
    }

    public function exportLocationData($bookingId)
    {
        $locations = DB::table('mountain_location_logs as mll')
            ->join('mountain_hiking_histories as mh', 'mll.booking_id', '=', 'mh.booking_id')
            ->join('users as u', 'mh.user_id', '=', 'u.id')
            ->join('mountains as m', 'mll.mountain_id', '=', 'm.id')
            ->select(
                'u.name as hiker_name',
                'm.name as mountain_name',
                'mll.latitude',
                'mll.longitude',
                'mll.timestamp'
            )
            ->where('mll.booking_id', $bookingId)
            ->orderBy('mll.timestamp', 'asc')
            ->get();

        $filename = "hiker_location_data_" . $bookingId . "_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($locations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Hiker Name', 'Mountain', 'Latitude', 'Longitude', 'Timestamp']);

            foreach ($locations as $location) {
                fputcsv($file, [
                    $location->hiker_name,
                    $location->mountain_name,
                    $location->latitude,
                    $location->longitude,
                    $location->timestamp
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
