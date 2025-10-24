<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationTrackingController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.location-tracking.index');
    }

    public function getActiveHikers()
    {
        $activeHikers = DB::table('mountain_bookings as mb')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->leftJoin('mountain_location_logs as mll', function($join) {
                $join->on('mb.id', '=', 'mll.booking_id')
                     ->whereRaw('mll.id = (SELECT MAX(id) FROM mountain_location_logs WHERE booking_id = mb.id)');
            })
            ->select(
                'mb.id as booking_id',
                'u.name as user_name',
                'u.email',
                'u.phone',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.checkin_time',
                'mb.team_size',
                'mll.latitude',
                'mll.longitude',
                'mll.timestamp as last_location_update'
            )
            ->where('mb.status', 'active')
            ->get();

        return response()->json($activeHikers);
    }

    public function getHikerLocationHistory($bookingId)
    {
        $locations = DB::table('mountain_location_logs as mll')
            ->join('mountain_bookings as mb', 'mll.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
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
            ->limit(100) // Last 100 location points
            ->get();

        if ($locations->isEmpty()) {
            return response()->json(['error' => 'No location data found'], 404);
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
        $totalActiveHikers = DB::table('mountain_bookings')
            ->where('status', 'active')
            ->count();

        $hikersWithRecentLocation = DB::table('mountain_bookings as mb')
            ->join('mountain_location_logs as mll', 'mb.id', '=', 'mll.booking_id')
            ->where('mb.status', 'active')
            ->where('mll.timestamp', '>=', now()->subMinutes(30))
            ->distinct('mb.id')
            ->count();

        $offlineHikers = $totalActiveHikers - $hikersWithRecentLocation;

        // Get hikers by mountain
        $hikersByMountain = DB::table('mountain_bookings as mb')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->select('m.name as mountain_name', DB::raw('COUNT(*) as hiker_count'))
            ->where('mb.status', 'active')
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
            'booking_id' => 'required|exists:mountain_bookings,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        // Get mountain_id from booking
        $booking = DB::table('mountain_bookings')
            ->where('id', $request->booking_id)
            ->first();

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        DB::table('mountain_location_logs')->insert([
            'booking_id' => $request->booking_id,
            'mountain_id' => $booking->mountain_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'timestamp' => now()
        ]);

        return response()->json(['success' => 'Location updated successfully']);
    }

    public function getGeofenceAlerts()
    {
        // This would check if hikers are outside safe zones
        // For now, return mock data
        return response()->json([
            'alerts' => []
        ]);
    }

    public function exportLocationData($bookingId)
    {
        $locations = DB::table('mountain_location_logs as mll')
            ->join('mountain_bookings as mb', 'mll.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
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

        $filename = "hiker_location_data_" . $bookingId . "_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use($locations) {
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