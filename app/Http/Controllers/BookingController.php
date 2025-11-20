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
            'members' => ['nullable', 'array'],
        ]);

        $userId = Auth::id();
        $mountainId = (int) request('mountain_id', 1); // Assumption: default mountain id 1 when not provided
        $hikeDate = Carbon::parse(request('hike_date'));
        $returnDate = Carbon::parse(request('return_date'));
        $teamSize = (int) request('team_size');
        $members = request('members', []);

        $totalDurationMinutes = $returnDate->diffInMinutes($hikeDate);

        DB::table('mountain_bookings')->insert([
            'user_id' => $userId,
            'mountain_id' => $mountainId,
            'hike_date' => $hikeDate->toDateString(),
            'return_date' => $returnDate->toDateString(),
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
}
