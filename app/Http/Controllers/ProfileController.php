<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    public function bookingHistory()
    {
        $userId = Auth::id();

        $bookings = DB::table('mountain_bookings as mb')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->leftJoin('mountain_feedbacks as f', 'mb.id', '=', 'f.booking_id')
            ->select(
                'mb.id',
                'm.name as mountain_name',
                'mb.hike_date as start_time',
                'mb.return_date as end_time',
                'mb.total_duration_minutes',
                'mb.status',
                'mb.team_size',
                DB::raw('ROUND(AVG(COALESCE(f.rating, 0)), 1) as avg_rating')
            )
            ->where('mb.user_id', $userId)
            ->groupBy(
                'mb.id',
                'm.name',
                'mb.hike_date',
                'mb.return_date',
                'mb.total_duration_minutes',
                'mb.status',
                'mb.team_size'
            )
            ->orderBy('mb.hike_date', 'desc')
            ->get();

        return view('booking-history', compact('bookings'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile-edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function helpSupport()
    {
        return view('help-support');
    }
}
