<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.feedback.index');
    }

    public function getData(Request $request)
    {
        $mountainId = Auth::user()->mountain_id;
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mf.created_at');
        $orderDir = $request->get('order_dir', 'desc');

        $query = DB::table('mountain_feedbacks as mf')
            ->join('mountain_bookings as mb', 'mf.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mf.mountain_id', '=', 'm.id')
            ->select(
                'mf.id as feedback_id',
                'u.name as user_name',
                'u.email',
                'm.name as mountain_name',
                'mf.rating',
                'mf.comment',
                'mf.image_url',
                'mf.created_at',
                'mb.hike_date',
                'mb.return_date',
                'mb.status as booking_status',
                'mf.booking_id'
            )
            ->when($mountainId, fn($q) => $q->where('mf.mountain_id', $mountainId));

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('mf.comment', 'LIKE', "%{$search}%")
                    ->orWhere('mf.rating', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = $query->count();

        $feedbacks = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $data = $feedbacks->map(function ($f) {
            return [
                'feedback_id' => $f->feedback_id,
                'user_name' => $f->user_name,
                'email' => $f->email,
                'mountain_name' => $f->mountain_name,
                'rating' => $f->rating,
                'comment' => $f->comment ?: '-',
                'hike_date' => $f->hike_date ? Carbon::parse($f->hike_date)->format('d/m/Y') : '-',
                'return_date' => $f->return_date ? Carbon::parse($f->return_date)->format('d/m/Y') : '-',
                'booking_status' => ucfirst($f->booking_status),
                'image_url' => $f->image_url,
                'created_at' => Carbon::parse($f->created_at)->format('d/m/Y H:i'),
                'booking_id' => $f->booking_id
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
        $feedback = DB::table('mountain_feedbacks as mf')
            ->join('mountain_bookings as mb', 'mf.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mf.mountain_id', '=', 'm.id')
            ->select(
                'mf.*',
                'u.name as user_name',
                'u.email',
                'u.phone',
                'u.emergency_contact',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.hike_date',
                'mb.return_date',
                'mb.status as booking_status'
            )
            ->where('mf.id', $id)
            ->first();

        if (!$feedback) {
            return response()->json(['error' => 'Feedback tidak ditemukan'], 404);
        }

        return response()->json($feedback);
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::table('mountain_feedbacks')->where('id', $id)->delete();

            if ($deleted) {
                return response()->json(['success' => 'Feedback berhasil dihapus']);
            } else {
                return response()->json(['error' => 'Feedback tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus feedback'], 500);
        }
    }

    public function getStats()
    {
        $mountainId = Auth::user()->mountain_id;

        $stats = DB::table('mountain_feedbacks as mf')
            ->join('mountains as m', 'mf.mountain_id', '=', 'm.id')
            ->when($mountainId, fn($q) => $q->where('mf.mountain_id', $mountainId))
            ->select(
                'm.name as mountain_name',
                DB::raw('COUNT(*) as total_reviews'),
                DB::raw('ROUND(AVG(mf.rating), 1) as avg_rating'),
                DB::raw('MAX(mf.rating) as max_rating'),
                DB::raw('MIN(mf.rating) as min_rating')
            )
            ->groupBy('m.id', 'm.name')
            ->orderBy('avg_rating', 'desc')
            ->get();

        $totalFeedbacks = DB::table('mountain_feedbacks')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->count();

        $avgOverallRating = DB::table('mountain_feedbacks')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->avg('rating');

        $latestFeedbacks = DB::table('mountain_feedbacks as mf')
            ->join('mountain_bookings as mb', 'mf.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mf.mountain_id', '=', 'm.id')
            ->when($mountainId, fn($q) => $q->where('mf.mountain_id', $mountainId))
            ->select('mf.comment', 'mf.rating', 'u.name as user_name', 'm.name as mountain_name', 'mf.created_at')
            ->orderBy('mf.created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'stats_by_mountain' => $stats,
            'total_feedbacks' => $totalFeedbacks,
            'avg_overall_rating' => round($avgOverallRating, 1),
            'latest_feedbacks' => $latestFeedbacks
        ]);
    }
}
