<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.feedback.index');
    }

    public function getData(Request $request)
    {
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
                'mb.hike_date',
                'mb.return_date',
                'mf.created_at',
                'mb.id as booking_id'
            );

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('mf.comment', 'LIKE', "%{$search}%")
                    ->orWhere('mf.rating', 'LIKE', "%{$search}%");
            });
        }

        // Get total count before pagination
        $totalRecords = $query->count();

        // Apply ordering and pagination
        $feedbacks = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format the data for DataTables
        $data = $feedbacks->map(function ($feedback) {
            return [
                'user_name' => $feedback->user_name,
                'email' => $feedback->email,
                'mountain_name' => $feedback->mountain_name,
                'rating' => $feedback->rating,
                'comment' => $feedback->comment ?: '-',
                'hike_date' => $feedback->hike_date ? date('Y-m-d', strtotime($feedback->hike_date)) : '-',
                'return_date' => $feedback->return_date ? date('Y-m-d', strtotime($feedback->return_date)) : '-',
                'created_at' => date('Y-m-d H:i', strtotime($feedback->created_at)),
                'feedback_id' => $feedback->feedback_id,
                'booking_id' => $feedback->booking_id
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
                'm.name as mountain_name',
                'm.location as mountain_location',
                'mb.hike_date',
                'mb.return_date',
                'mb.team_size',
                'mb.checkin_time',
                'mb.checkout_time'
            )
            ->where('mf.id', $id)
            ->first();

        if (!$feedback) {
            return response()->json(['error' => 'Feedback not found'], 404);
        }

        return response()->json($feedback);
    }

    public function destroy($id)
    {
        try {
            $deleted = DB::table('mountain_feedbacks')->where('id', $id)->delete();
            
            if ($deleted) {
                return response()->json(['success' => 'Feedback deleted successfully']);
            } else {
                return response()->json(['error' => 'Feedback not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting feedback'], 500);
        }
    }

    public function getStats()
    {
        $stats = DB::table('mountain_feedbacks as mf')
            ->join('mountains as m', 'mf.mountain_id', '=', 'm.id')
            ->select(
                'm.name as mountain_name',
                DB::raw('COUNT(*) as total_reviews'),
                DB::raw('AVG(mf.rating) as avg_rating'),
                DB::raw('MAX(mf.rating) as max_rating'),
                DB::raw('MIN(mf.rating) as min_rating')
            )
            ->groupBy('m.id', 'm.name')
            ->orderBy('avg_rating', 'desc')
            ->get();

        return response()->json($stats);
    }
}