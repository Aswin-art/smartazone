<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MountainHikerController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.mountain_hikers.index');
    }

    public function getList(Request $request)
    {
        $mountainId = Auth::user()->mountain_id;
        $bookings = DB::table('mountain_bookings as mb')
            ->join('users as u', 'u.id', '=', 'mb.user_id')
            ->select(
                'mb.id as booking_id',
                'u.name as user_name',
                'u.phone',
                'mb.hike_date',
                'mb.return_date',
                'mb.team_size'
            )
            ->where('mb.mountain_id', $mountainId)
            ->where('mb.status', 'active')
            ->get();

        $data = $bookings->map(function ($b) {
            $lastLog = DB::table('mountain_hiker_logs')
                ->where('booking_id', $b->booking_id)
                ->orderByDesc('timestamp')
                ->first(['latitude', 'longitude', 'timestamp']);

            $b->latitude = $lastLog->latitude ?? null;
            $b->longitude = $lastLog->longitude ?? null;
            $b->timestamp = $lastLog->timestamp ?? null;
            return $b;
        });

        return response()->json(['data' => $data]);
    }

public function getLogs(Request $request)
    {
        $bookingId = $request->get('booking_id');

        $logs = DB::table('mountain_hiker_logs')
            ->where('booking_id', $bookingId)
            ->orderByDesc('timestamp')
            ->limit(50)
            ->get(['latitude', 'longitude', 'timestamp', 'heart_rate', 'spo2', 'stress_level']);

        return response()->json(['logs' => $logs]);
    }
}
