<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('booking', compact('user'));
    }

    public function booking(){
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk untuk melakukan booking.');
        }

        request()->validate([
            'mountain_id' => ['required', 'integer'],
            'hike_date' => ['required', 'date'],
            'return_date' => ['required', 'date', 'after_or_equal:hike_date'],
            'team_size' => ['required', 'integer', 'min:1'],
            'members' => ['nullable', 'string'], // Changed from array to string (JSON)
        ]);

        $userId = Auth::id();
        $mountainId = (int) request('mountain_id', 1);
        $hike_date = Carbon::parse(request('hike_date'));
        $return_date = Carbon::parse(request('return_date'));
        $teamSize = (int) request('team_size');
        
        // Decode the JSON string members
        $members = json_decode(request('members', '[]'), true);

        $totalDurationMinutes = $return_date->diffInMinutes($hike_date);

        DB::table('mountain_bookings')->insert([
            'user_id' => $userId,
            'mountain_id' => $mountainId,
            'hike_date' => $hike_date->toDateString(),
            'return_date' => $return_date->toDateString(),
            'team_size' => $teamSize,
            'members' => json_encode($members),
            'status' => 'active',
            'qr_code' => '',
            'checkin_time' => null,
            'checkout_time' => null,
            'total_duration_minutes' => $totalDurationMinutes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('booking-history')->with('success', 'Booking berhasil dibuat.');
    }

    public function downloadTicket($id)
    {
        $booking = DB::table('mountain_bookings as mb')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->select(
                'mb.*',
                'm.name as mountain_name'
            )
            ->where('mb.id', $id)
            ->where('mb.user_id', Auth::id())
            ->first();

        if (!$booking) {
            abort(404);
        }

        return view('booking-ticket', compact('booking'));
    }
}
