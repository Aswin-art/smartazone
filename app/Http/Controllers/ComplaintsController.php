<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComplaintsController extends Controller
{
    public function index()
    {
        // Get mountains for filter dropdown
        $mountains = DB::table('mountains')
            ->select('id', 'name')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('dashboard.pages.complaints.index', compact('mountains'));
    }

    public function getData(Request $request)
    {
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mc.created_at');
        $orderDir = $request->get('order_dir', 'desc');
        
        // Filter parameters
        $mountainId = $request->get('mountain_id', '');
        $status = $request->get('status', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        $query = DB::table('mountain_complaints as mc')
            ->join('mountain_bookings as mb', 'mc.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id')
            ->select(
                'mc.id as complaint_id',
                'mc.message',
                'mc.image_url',
                'mc.created_at as complaint_date',
                'u.id as user_id',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'm.id as mountain_id',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.id as booking_id',
                'mb.hike_date',
                'mb.checkin_time',
                'mb.status as booking_status',
                DB::raw("CASE 
                    WHEN mc.created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 'new'
                    WHEN mc.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 'recent'
                    ELSE 'old'
                END as complaint_status"),
                DB::raw("CASE 
                    WHEN mc.message LIKE '%darurat%' OR mc.message LIKE '%emergency%' OR mc.message LIKE '%urgent%' THEN 'high'
                    WHEN mc.message LIKE '%peralatan%' OR mc.message LIKE '%equipment%' OR mc.message LIKE '%rusak%' THEN 'medium'
                    ELSE 'low'
                END as priority_level")
            );

        // Apply mountain filter
        if (!empty($mountainId)) {
            $query->where('mc.mountain_id', $mountainId);
        }

        // Apply status filter (based on complaint age)
        if (!empty($status)) {
            switch ($status) {
                case 'new':
                    $query->where('mc.created_at', '>=', Carbon::now()->subHours(24));
                    break;
                case 'recent':
                    $query->where('mc.created_at', '>=', Carbon::now()->subDays(7))
                          ->where('mc.created_at', '<', Carbon::now()->subHours(24));
                    break;
                case 'old':
                    $query->where('mc.created_at', '<', Carbon::now()->subDays(7));
                    break;
            }
        }

        // Apply date range filter
        if (!empty($dateFrom)) {
            $query->where('mc.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }
        if (!empty($dateTo)) {
            $query->where('mc.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('m.location', 'LIKE', "%{$search}%")
                    ->orWhere('mc.message', 'LIKE', "%{$search}%");
            });
        }

        // Get total count before pagination
        $totalRecords = $query->count();

        // Apply ordering and pagination
        $complaints = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format the data for DataTables
        $data = $complaints->map(function ($complaint) {
            // Truncate message for table display
            $shortMessage = strlen($complaint->message) > 100 
                ? substr($complaint->message, 0, 100) . '...' 
                : $complaint->message;

            return [
                'complaint_id' => $complaint->complaint_id,
                'user_name' => $complaint->user_name,
                'user_email' => $complaint->user_email,
                'user_phone' => $complaint->user_phone,
                'mountain_name' => $complaint->mountain_name,
                'mountain_location' => $complaint->mountain_location,
                'message' => $complaint->message,
                'short_message' => $shortMessage,
                'image_url' => $complaint->image_url,
                'complaint_date' => $complaint->complaint_date,
                'formatted_date' => Carbon::parse($complaint->complaint_date)->format('d/m/Y H:i'),
                'relative_date' => Carbon::parse($complaint->complaint_date)->diffForHumans(),
                'hike_date' => $complaint->hike_date ? Carbon::parse($complaint->hike_date)->format('d/m/Y') : '-',
                'booking_id' => $complaint->booking_id,
                'booking_status' => $complaint->booking_status,
                'complaint_status' => $complaint->complaint_status,
                'priority_level' => $complaint->priority_level,
                'has_image' => !empty($complaint->image_url)
            ];
        });

        return response()->json([
            'draw' => intval($request->get('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function show($complaintId)
    {
        $complaint = DB::table('mountain_complaints as mc')
            ->join('mountain_bookings as mb', 'mc.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id')
            ->select(
                'mc.*',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'u.emergency_contact',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.hike_date',
                'mb.return_date',
                'mb.checkin_time',
                'mb.checkout_time',
                'mb.status as booking_status',
                'mb.team_size',
                'mb.members'
            )
            ->where('mc.id', $complaintId)
            ->first();

        if (!$complaint) {
            return response()->json(['error' => 'Pengaduan tidak ditemukan'], 404);
        }

        // Parse team members
        $members = [];
        if ($complaint->members) {
            $members = json_decode($complaint->members, true) ?: [];
        }

        // Get related complaints from same user
        $relatedComplaints = DB::table('mountain_complaints as mc')
            ->join('mountain_bookings as mb', 'mc.booking_id', '=', 'mb.id')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id')
            ->select('mc.id', 'mc.message', 'mc.created_at', 'm.name as mountain_name')
            ->where('mb.user_id', DB::table('mountain_bookings')->where('id', $complaint->booking_id)->value('user_id'))
            ->where('mc.id', '!=', $complaintId)
            ->orderBy('mc.created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'complaint' => $complaint,
            'members' => $members,
            'related_complaints' => $relatedComplaints
        ]);
    }

    public function getStatistics(Request $request)
    {
        $mountainId = $request->get('mountain_id', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        $query = DB::table('mountain_complaints as mc')
            ->join('mountain_bookings as mb', 'mc.booking_id', '=', 'mb.id')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id');

        // Apply filters
        if (!empty($mountainId)) {
            $query->where('mc.mountain_id', $mountainId);
        }
        if (!empty($dateFrom)) {
            $query->where('mc.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }
        if (!empty($dateTo)) {
            $query->where('mc.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        // Get total complaints
        $totalComplaints = $query->count();

        // Get complaints by status (age)
        $newComplaints = (clone $query)->where('mc.created_at', '>=', Carbon::now()->subHours(24))->count();
        $recentComplaints = (clone $query)
            ->where('mc.created_at', '>=', Carbon::now()->subDays(7))
            ->where('mc.created_at', '<', Carbon::now()->subHours(24))
            ->count();
        $oldComplaints = (clone $query)->where('mc.created_at', '<', Carbon::now()->subDays(7))->count();

        // Get complaints by mountain
        $complaintsByMountain = (clone $query)
            ->select('m.name as mountain_name', DB::raw('COUNT(*) as total'))
            ->groupBy('m.id', 'm.name')
            ->orderBy('total', 'desc')
            ->get();

        // Get complaints by priority
        $highPriorityCount = (clone $query)
            ->where(function($q) {
                $q->where('mc.message', 'LIKE', '%darurat%')
                  ->orWhere('mc.message', 'LIKE', '%emergency%')
                  ->orWhere('mc.message', 'LIKE', '%urgent%');
            })
            ->count();

        $mediumPriorityCount = (clone $query)
            ->where(function($q) {
                $q->where('mc.message', 'LIKE', '%peralatan%')
                  ->orWhere('mc.message', 'LIKE', '%equipment%')
                  ->orWhere('mc.message', 'LIKE', '%rusak%');
            })
            ->count();

        $lowPriorityCount = $totalComplaints - $highPriorityCount - $mediumPriorityCount;

        return response()->json([
            'total_complaints' => $totalComplaints,
            'new_complaints' => $newComplaints,
            'recent_complaints' => $recentComplaints,
            'old_complaints' => $oldComplaints,
            'complaints_by_mountain' => $complaintsByMountain,
            'high_priority' => $highPriorityCount,
            'medium_priority' => $mediumPriorityCount,
            'low_priority' => $lowPriorityCount
        ]);
    }

    public function markAsRead(Request $request, $complaintId)
    {
        // Note: You might want to add a 'read_at' or 'status' column to mountain_complaints table
        // For now, we'll just return success
        return response()->json(['success' => true, 'message' => 'Pengaduan ditandai sebagai dibaca']);
    }

    public function exportComplaints(Request $request)
    {
        $mountainId = $request->get('mountain_id', '');
        $status = $request->get('status', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        $query = DB::table('mountain_complaints as mc')
            ->join('mountain_bookings as mb', 'mc.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id')
            ->select(
                'mc.id as complaint_id',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.hike_date',
                'mc.message',
                'mc.created_at as complaint_date'
            );

        // Apply same filters as getData method
        if (!empty($mountainId)) {
            $query->where('mc.mountain_id', $mountainId);
        }

        if (!empty($status)) {
            switch ($status) {
                case 'new':
                    $query->where('mc.created_at', '>=', Carbon::now()->subHours(24));
                    break;
                case 'recent':
                    $query->where('mc.created_at', '>=', Carbon::now()->subDays(7))
                          ->where('mc.created_at', '<', Carbon::now()->subHours(24));
                    break;
                case 'old':
                    $query->where('mc.created_at', '<', Carbon::now()->subDays(7));
                    break;
            }
        }

        if (!empty($dateFrom)) {
            $query->where('mc.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }
        if (!empty($dateTo)) {
            $query->where('mc.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        $complaints = $query->orderBy('mc.created_at', 'desc')->get();

        return response()->json([
            'data' => $complaints,
            'filename' => 'complaints_' . date('Y-m-d_H-i-s') . '.csv'
        ]);
    }
}