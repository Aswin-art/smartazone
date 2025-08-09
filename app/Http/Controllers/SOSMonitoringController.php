<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $status = $request->get('status', ''); // all, pending, responded, resolved

        $query = DB::table('mountain_sos_signals as mss')
            ->join('mountain_bookings as mb', 'mss.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
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
                'mb.id as booking_id',
                'mb.team_size',
                'sr.status as response_status',
                'sr.responded_at',
                'sr.responder_name'
            );

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('mss.message', 'LIKE', "%{$search}%");
            });
        }

        // Apply status filter
        if (!empty($status) && $status !== 'all') {
            if ($status === 'pending') {
                $query->whereNull('sr.status');
            } else {
                $query->where('sr.status', $status);
            }
        }

        // Get total count before pagination
        $totalRecords = $query->count();

        // Apply ordering and pagination
        $sosSignals = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format the data for DataTables
        $data = $sosSignals->map(function ($signal) {
            return [
                'user_name' => $signal->user_name,
                'email' => $signal->email,
                'phone' => $signal->phone,
                'mountain_name' => $signal->mountain_name,
                'latitude' => $signal->latitude,
                'longitude' => $signal->longitude,
                'message' => $signal->message ?: 'Emergency assistance needed',
                'timestamp' => date('Y-m-d H:i:s', strtotime($signal->timestamp)),
                'team_size' => $signal->team_size,
                'status' => $signal->response_status ?: 'pending',
                'responded_at' => $signal->responded_at ? date('Y-m-d H:i:s', strtotime($signal->responded_at)) : null,
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
            ->join('mountain_bookings as mb', 'mss.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
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
                'mb.hike_date',
                'mb.return_date',
                'mb.team_size',
                'mb.members',
                'mb.checkin_time',
                'sr.status as response_status',
                'sr.responded_at',
                'sr.responder_name',
                'sr.response_notes'
            )
            ->where('mss.id', $id)
            ->first();

        if (!$sosSignal) {
            return response()->json(['error' => 'SOS signal not found'], 404);
        }

        // Get latest location if different from SOS location
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

        // Check if response already exists
        $existingResponse = DB::table('sos_responses')->where('sos_signal_id', $id)->first();

        if ($existingResponse) {
            // Update existing response
            DB::table('sos_responses')
                ->where('sos_signal_id', $id)
                ->update([
                    'status' => $request->status,
                    'responder_name' => $request->responder_name,
                    'response_notes' => $request->response_notes,
                    'responded_at' => now(),
                    'updated_at' => now()
                ]);
        } else {
            // Create new response
            DB::table('sos_responses')->insert([
                'sos_signal_id' => $id,
                'status' => $request->status,
                'responder_name' => $request->responder_name,
                'response_notes' => $request->response_notes,
                'responded_at' => now(),
                'created_at' => now()
            ]);
        }

        // Log the response action
        DB::table('sos_response_logs')->insert([
            'sos_signal_id' => $id,
            'action' => 'status_updated',
            'details' => json_encode([
                'new_status' => $request->status,
                'responder' => $request->responder_name,
                'notes' => $request->response_notes
            ]),
            'created_at' => now()
        ]);

        return response()->json(['success' => 'Response recorded successfully']);
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
            ->join('mountain_bookings as mb', 'mss.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mss.mountain_id', '=', 'm.id')
            ->leftJoin('sos_responses as sr', 'mss.id', '=', 'sr.sos_signal_id')
            ->select(
                'mss.id',
                'u.name as user_name',
                'm.name as mountain_name',
                'mss.timestamp',
                'sr.status as response_status'
            )
            ->where('mss.timestamp', '>=', now()->subHours(24))
            ->orderBy('mss.timestamp', 'desc')
            ->limit(10)
            ->get();

        // Average response time
        $avgResponseTime = DB::table('sos_responses as sr')
            ->join('mountain_sos_signals as mss', 'sr.sos_signal_id', '=', 'mss.id')
            ->where('sr.status', 'resolved')
            ->whereNotNull('sr.responded_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, mss.timestamp, sr.responded_at)) as avg_minutes')
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
            'booking_id' => 'required|exists:mountain_bookings,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'message' => 'nullable|string|max:500'
        ]);

        // Get mountain_id from booking
        $booking = DB::table('mountain_bookings')
            ->where('id', $request->booking_id)
            ->first();

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $sosId = DB::table('mountain_sos_signals')->insertGetId([
            'booking_id' => $request->booking_id,
            'mountain_id' => $booking->mountain_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'message' => $request->message,
            'timestamp' => now()
        ]);

        // Trigger emergency notifications (this would be handled by a queue/event)
        $this->triggerEmergencyNotifications($sosId);

        return response()->json([
            'success' => 'SOS signal sent successfully',
            'sos_id' => $sosId
        ]);
    }

    private function calculatePriority($signal)
    {
        $hoursAgo = (strtotime('now') - strtotime($signal->timestamp)) / 3600;
        
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
        // This would trigger:
        // 1. SMS to emergency contacts
        // 2. Email to rescue teams
        // 3. Push notifications to admin dashboard
        // 4. Integration with emergency services API
        
        // For now, just log the notification
        DB::table('emergency_notifications')->insert([
            'sos_signal_id' => $sosId,
            'notification_type' => 'emergency_alert',
            'status' => 'sent',
            'created_at' => now()
        ]);
    }

    public function getEmergencyContacts($bookingId)
    {
        $contacts = DB::table('mountain_bookings as mb')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->select('u.emergency_contact', 'u.phone', 'mb.members')
            ->where('mb.id', $bookingId)
            ->first();

        return response()->json($contacts);
    }
}