<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HikersController extends Controller
{
    public function index()
    {
        return view('Dashboard.pages.hikers.index');
    }

    public function getData(Request $request)
    {
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mb.checkin_time');
        $orderDir = $request->get('order_dir', 'desc');

        $query = DB::table('mountain_bookings as mb')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mb.mountain_id', '=', 'm.id')
            ->select(
                'u.id as user_id',
                'u.name as user_name',
                'u.email',
                'm.name as mountain_name',
                'mb.checkin_time',
                'mb.checkout_time',
                'mb.status',
                'mb.id as booking_id'
            );

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('mb.status', 'LIKE', "%{$search}%");
            });
        }

        // Get total count before pagination
        $totalRecords = $query->count();

        // Apply ordering and pagination
        $hikers = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format the data for DataTables
        $data = $hikers->map(function ($hiker) {
            return [
                'user_name' => $hiker->user_name,
                'email' => $hiker->email,
                'mountain_name' => $hiker->mountain_name,
                'checkin_time' => $hiker->checkin_time ? date('Y-m-d H:i', strtotime($hiker->checkin_time)) : '-',
                'checkout_time' => $hiker->checkout_time ? date('Y-m-d H:i', strtotime($hiker->checkout_time)) : '-',
                'status' => $hiker->status,
                'booking_id' => $hiker->booking_id
            ];
        });

        return response()->json([
            'draw' => intval($request->get('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }
}
