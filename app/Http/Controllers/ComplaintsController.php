<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComplaintsController extends Controller
{
    public function index()
    {
        $mountains = DB::table('mountains')
            ->select('id', 'name')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('dashboard.pages.complaints.index', compact('mountains'));
    }

    public function getData(Request $request)
    {
        $search      = $request->get('search', '');
        $start       = $request->get('start', 0);
        $length      = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mc.created_at');
        $orderDir    = $request->get('order_dir', 'desc');
        $mountainId  = $request->get('mountain_id', '');
        $status      = $request->get('status', '');
        $dateFrom    = $request->get('date_from', '');
        $dateTo      = $request->get('date_to', '');

        $query = DB::table('mountain_complaints as mc')
            ->join('mountain_bookings as mb', 'mc.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id')
            ->select(
                'mc.id as complaint_id',
                'mc.subject',
                'mc.category',
                'mc.description',
                'mc.evidence_url',
                'mc.status as complaint_status',
                'mc.response',
                'mc.created_at as complaint_date',
                'u.id as user_id',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'm.id as mountain_id',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.status as booking_status'
            );

        if (!empty($mountainId)) {
            $query->where('mc.mountain_id', $mountainId);
        }

        if (!empty($status)) {
            $query->where('mc.status', $status);
        }

        if (!empty($dateFrom)) {
            $query->where('mc.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }

        if (!empty($dateTo)) {
            $query->where('mc.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('u.phone', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('m.location', 'LIKE', "%{$search}%")
                    ->orWhere('mc.subject', 'LIKE', "%{$search}%")
                    ->orWhere('mc.description', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = $query->count();

        $complaints = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $data = $complaints->map(function ($c) {
            return [
                'complaint_id'      => $c->complaint_id,
                'user_name'         => $c->user_name,
                'user_email'        => $c->user_email,
                'user_phone'        => $c->user_phone,
                'mountain_name'     => $c->mountain_name,
                'mountain_location' => $c->mountain_location,
                'subject'           => $c->subject,
                'category'          => $c->category,
                'description'       => $c->description,
                'evidence_url'      => $c->evidence_url,
                'complaint_status'  => ucfirst($c->complaint_status),
                'response'          => $c->response ?? '-',
                'complaint_date'    => Carbon::parse($c->complaint_date)->format('d/m/Y H:i'),
                'relative_date'     => Carbon::parse($c->complaint_date)->diffForHumans(),
                'booking_status'    => ucfirst($c->booking_status),
            ];
        });

        return response()->json([
            'draw'             => intval($request->get('draw', 1)),
            'recordsTotal'     => $totalRecords,
            'recordsFiltered'  => $totalRecords,
            'data'             => $data
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
                'mb.status as booking_status'
            )
            ->where('mc.id', $complaintId)
            ->first();

        if (!$complaint) {
            return response()->json(['error' => 'Pengaduan tidak ditemukan'], 404);
        }

        $relatedComplaints = DB::table('mountain_complaints as mc')
            ->join('mountain_bookings as mb', 'mc.booking_id', '=', 'mb.id')
            ->where('mb.user_id', $complaint->user_id)
            ->where('mc.id', '!=', $complaintId)
            ->select('mc.id', 'mc.subject', 'mc.category', 'mc.status', 'mc.created_at')
            ->orderBy('mc.created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'complaint'          => $complaint,
            'related_complaints' => $relatedComplaints
        ]);
    }

    public function getStatistics(Request $request)
    {
        $mountainId = $request->get('mountain_id', '');
        $dateFrom   = $request->get('date_from', '');
        $dateTo     = $request->get('date_to', '');

        $query = DB::table('mountain_complaints as mc')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id');

        if (!empty($mountainId)) {
            $query->where('mc.mountain_id', $mountainId);
        }

        if (!empty($dateFrom)) {
            $query->where('mc.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }

        if (!empty($dateTo)) {
            $query->where('mc.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        $total     = $query->count();
        $pending   = (clone $query)->where('mc.status', 'pending')->count();
        $inReview  = (clone $query)->where('mc.status', 'in_review')->count();
        $resolved  = (clone $query)->where('mc.status', 'resolved')->count();
        $rejected  = (clone $query)->where('mc.status', 'rejected')->count();

        $byMountain = (clone $query)
            ->select('m.name as mountain_name', DB::raw('COUNT(*) as total'))
            ->groupBy('m.id', 'm.name')
            ->orderBy('total', 'desc')
            ->get();

        $byCategory = (clone $query)
            ->select('mc.category', DB::raw('COUNT(*) as total'))
            ->groupBy('mc.category')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json([
            'total_complaints'       => $total,
            'pending'                => $pending,
            'in_review'              => $inReview,
            'resolved'               => $resolved,
            'rejected'               => $rejected,
            'complaints_by_mountain' => $byMountain,
            'complaints_by_category' => $byCategory
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        DB::table('mountain_complaints')->where('id', $id)->update([
            'status'     => $request->status,
            'response'   => $request->response,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Status pengaduan diperbarui']);
    }

    public function exportComplaints(Request $request)
    {
        $mountainId = $request->get('mountain_id', '');
        $status     = $request->get('status', '');
        $dateFrom   = $request->get('date_from', '');
        $dateTo     = $request->get('date_to', '');

        $query = DB::table('mountain_complaints as mc')
            ->join('users as u', 'mc.user_id', '=', 'u.id')
            ->join('mountains as m', 'mc.mountain_id', '=', 'm.id')
            ->select(
                'mc.id as complaint_id',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mc.category',
                'mc.subject',
                'mc.description',
                'mc.status',
                'mc.created_at'
            );

        if (!empty($mountainId)) {
            $query->where('mc.mountain_id', $mountainId);
        }

        if (!empty($status)) {
            $query->where('mc.status', $status);
        }

        if (!empty($dateFrom)) {
            $query->where('mc.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }

        if (!empty($dateTo)) {
            $query->where('mc.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        $complaints = $query->orderBy('mc.created_at', 'desc')->get();

        return response()->json([
            'data'     => $complaints,
            'filename' => 'complaints_' . date('Y-m-d_H-i-s') . '.csv',
        ]);
    }
}
