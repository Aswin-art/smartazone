<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SOSMonitoringController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.sos-monitoring.index');
    }

    public function getData(Request $request)
    {
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mss.timestamp');
        $orderDir = $request->get('order_dir', 'desc');
        $status = $request->get('status', '');

        $query = DB::table('mountain_sos_signals as mss')
            ->join('mountain_hiking_histories as mh', 'mss.booking_id', '=', 'mh.booking_id')
            ->join('users as u', 'mh.user_id', '=', 'u.id')
            ->join('mountains as m', 'mss.mountain_id', '=', 'm.id')
            ->leftJoin('sos_responses as sr', 'mss.id', '=', 'sr.sos_signal_id')
            ->select(
                'mss.id as sos_id',
                'u.name as user_name',
                'u.email',
                'u.phone',
                'm.name as mountain_name',
                'mss.latitude',
                'mss.longitude',
                'mss.message',
                'mss.timestamp',
                'mh.booking_id',
                'mh.status as hike_status',
                'sr.status as response_status',
                'sr.responded_at',
                'sr.responder_name'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('mss.message', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($status) && $status !== 'all') {
            if ($status === 'pending') {
                $query->whereNull('sr.status');
            } else {
                $query->where('sr.status', $status);
            }
        }

        $totalRecords = $query->count();

        $sosSignals = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $data = $sosSignals->map(function ($signal) {
            return [
                'user_name' => $signal->user_name,
                'email' => $signal->email,
                'phone' => $signal->phone,
                'mountain_name' => $signal->mountain_name,
                'latitude' => $signal->latitude,
                'longitude' => $signal->longitude,
                'message' => $signal->message ?: 'Emergency assistance needed',
                'timestamp' => Carbon::parse($signal->timestamp)->format('Y-m-d H:i:s'),
                'status' => $signal->response_status ?: 'pending',
                'responded_at' => $signal->responded_at ? Carbon::parse($signal->responded_at)->format('Y-m-d H:i:s') : null,
                'responder_name' => $signal->responder_name,
                'sos_id' => $signal->sos_id,
                'booking_id' => $signal->booking_id,
                'priority' => $this->calculatePriority($signal)
            ];
        });

        return response()->json([
            'draw' => intval($request->get('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $sosSignal = DB::table('mountain_sos_signals as mss')
            ->join('mountain_hiking_histories as mh', 'mss.booking_id', '=', 'mh.booking_id')
            ->join('users as u', 'mh.user_id', '=', 'u.id')
            ->join('mountains as m', 'mss.mountain_id', '=', 'm.id')
            ->leftJoin('sos_responses as sr', 'mss.id', '=', 'sr.sos_signal_id')
            ->select(
                'mss.*',
                'u.name as user_name',
                'u.email',
                'u.phone',
                'u.emergency_contact',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mh.start_time',
                'mh.end_time',
                'mh.status as hike_status',
                'sr.status as response_status',
                'sr.responded_at',
                'sr.responder_name',
                'sr.response_notes'
            )
            ->where('mss.id', $id)
            ->first();

        if (!$sosSignal) {
            return response()->json(['error' => 'SOS signal tidak ditemukan'], 404);
        }

        $latestLocation = DB::table('mountain_location_logs')
            ->where('booking_id', $sosSignal->booking_id)
            ->orderBy('timestamp', 'desc')
            ->first();

        return response()->json([
            'sos_signal' => $sosSignal,
            'latest_location' => $latestLocation
        ]);
    }

    public function respondToSOS(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:responded,resolved,false_alarm',
            'responder_name' => 'required|string|max:255',
            'response_notes' => 'nullable|string'
        ]);

        $existingResponse = DB::table('sos_responses')->where('sos_signal_id', $id)->first();

        if ($existingResponse) {
            DB::table('sos_responses')
                ->where('sos_signal_id', $id)
                ->update([
                    'status' => $request->status,
                    'responder_name' => $request->responder_name,
                    'response_notes' => $request->response_notes,
                    'responded_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
        } else {
            DB::table('sos_responses')->insert([
                'sos_signal_id' => $id,
                'status' => $request->status,
                'responder_name' => $request->responder_name,
                'response_notes' => $request->response_notes,
                'responded_at' => Carbon::now(),
                'created_at' => Carbon::now()
            ]);
        }

        DB::table('sos_response_logs')->insert([
            'sos_signal_id' => $id,
            'action' => 'status_updated',
            'details' => json_encode([
                'new_status' => $request->status,
                'responder' => $request->responder_name,
                'notes' => $request->response_notes
            ]),
            'created_at' => Carbon::now()
        ]);

        return response()->json(['success' => 'Tanggapan berhasil disimpan']);
    }

    public function getSOSStats()
    {
        $totalSOS = DB::table('mountain_sos_signals')->count();

        $pendingSOS = DB::table('mountain_sos_signals as mss')
            ->leftJoin('sos_responses as sr', 'mss.id', '=', 'sr.sos_signal_id')
            ->whereNull('sr.status')
            ->count();

        $resolvedSOS = DB::table('sos_responses')
            ->where('status', 'resolved')
            ->count();

        $recentSOS = DB::table('mountain_sos_signals as mss')
            ->join('mountain_hiking_histories as mh', 'mss.booking_id', '=', 'mh.booking_id')
            ->join('users as u', 'mh.user_id', '=', 'u.id')
            ->join('mountains as m', 'mss.mountain_id', '=', 'm.id')
            ->leftJoin('sos_responses as sr', 'mss.id', '=', 'sr.sos_signal_id')
            ->select(
                'mss.id',
                'u.name as user_name',
                'm.name as mountain_name',
                'mss.timestamp',
                'sr.status as response_status'
            )
            ->where('mss.timestamp', '>=', Carbon::now()->subHours(24))
            ->orderBy('mss.timestamp', 'desc')
            ->limit(10)
            ->get();

        $avgResponseTime = DB::table('sos_responses as sr')
            ->join('mountain_sos_signals as mss', 'sr.sos_signal_id', '=', 'mss.id')
            ->where('sr.status', 'resolved')
            ->whereNotNull('sr.responded_at')
            ->selectRaw('AVG(EXTRACT(EPOCH FROM (sr.responded_at - mss.timestamp))/60) as avg_minutes')
            ->value('avg_minutes');

        return response()->json([
            'total_sos' => $totalSOS,
            'pending_sos' => $pendingSOS,
            'resolved_sos' => $resolvedSOS,
            'recent_sos' => $recentSOS,
            'avg_response_time' => round($avgResponseTime ?: 0, 1) . ' minutes'
        ]);
    }

    public function createSOSSignal(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:mountain_hiking_histories,booking_id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'message' => 'nullable|string|max:500'
        ]);

        $booking = DB::table('mountain_hiking_histories')
            ->where('booking_id', $request->booking_id)
            ->first();

        if (!$booking) {
            return response()->json(['error' => 'Data pendakian tidak ditemukan'], 404);
        }

        $sosId = DB::table('mountain_sos_signals')->insertGetId([
            'booking_id' => $request->booking_id,
            'mountain_id' => $booking->mountain_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'message' => $request->message,
            'timestamp' => Carbon::now()
        ]);

        $this->triggerEmergencyNotifications($sosId);

        return response()->json([
            'success' => 'Sinyal SOS berhasil dikirim',
            'sos_id' => $sosId
        ]);
    }

    private function calculatePriority($signal)
    {
        $hoursAgo = (time() - strtotime($signal->timestamp)) / 3600;

        if ($hoursAgo > 6) {
            return 'critical';
        } elseif ($hoursAgo > 2) {
            return 'high';
        } elseif ($hoursAgo > 1) {
            return 'medium';
        } else {
            return 'normal';
        }
    }

    private function triggerEmergencyNotifications($sosId)
    {
        DB::table('emergency_notifications')->insert([
            'sos_signal_id' => $sosId,
            'notification_type' => 'emergency_alert',
            'status' => 'sent',
            'created_at' => Carbon::now()
        ]);
    }

    public function getEmergencyContacts($bookingId)
    {
        $contacts = DB::table('mountain_hiking_histories as mh')
            ->join('users as u', 'mh.user_id', '=', 'u.id')
            ->select('u.emergency_contact', 'u.phone')
            ->where('mh.booking_id', $bookingId)
            ->first();

        return response()->json($contacts);
    }
}
