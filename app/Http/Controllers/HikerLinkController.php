<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HikerLinkController extends Controller
{
    public function index()
    {
        $mountainId = Auth::user()->mountain_id;
        $bookings = DB::table('mountain_bookings')
            ->where('mountain_id', $mountainId)
            ->select('id', 'members', 'mountain_id', 'qr_code', 'team_size')
            ->orderByDesc('id')
            ->get()
            ->map(function ($b) {
                $b->members = json_decode($b->members, true) ?: [];
                return $b;
            });
        $devices = DB::table('mountain_devices')
            ->select('id', 'battery_level')
            ->orderBy('id')
            ->get();

        $linked = DB::table('mountain_hiker_status as hs')
            ->join('mountain_devices as d', 'hs.device_id', '=', 'd.id')
            ->join('mountain_bookings as b', 'hs.booking_id', '=', 'b.id')
            ->select('hs.*', 'd.battery_level', 'b.mountain_id')
            ->orderByDesc('hs.id')
            ->get();

        return view('dashboard.pages.hiker_link.index', compact('bookings', 'devices', 'linked'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'device_id' => 'required|integer',
            'member_name' => 'required|string',
            'member_nik' => 'nullable|string',
            'member_phone' => 'nullable|string',
        ]);

        $booking = DB::table('mountain_bookings')->where('id', $request->booking_id)->first();

        DB::table('mountain_hiker_status')->insert([
            'booking_id' => $booking->id,
            'mountain_id' => $booking->mountain_id,
            'device_id' => $request->device_id,
            'hiker_name' => $request->member_name,
            'hiker_nik' => $request->member_nik ?? '',
            'hiker_phone' => $request->member_phone ?? '',
            'status' => 'active',
            'started_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('hiker.link')->with('success', 'Hiker linked successfully.');
    }
}
