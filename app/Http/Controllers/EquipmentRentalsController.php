<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EquipmentRentalsController extends Controller
{
    public function index()
    {
        // Get mountains for filter dropdown
        $mountains = DB::table('mountains')
            ->select('id', 'name')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get equipment for filter dropdown
        $equipments = DB::table('mountain_equipments')
            ->select(DB::raw('MIN(id) as id'), 'name')
            ->groupBy('name')
            ->orderBy('name')
            ->get();


        return view('Dashboard.pages.equipment-rentals.index', compact('mountains', 'equipments'));
    }

    public function getData(Request $request)
    {
        $search = $request->get('search', '');
        $start = $request->get('start', 0);
        $length = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mer.created_at');
        $orderDir = $request->get('order_dir', 'desc');

        // Filter parameters
        $mountainId = $request->get('mountain_id', '');
        $equipmentId = $request->get('equipment_id', '');
        $status = $request->get('status', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        $query = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_bookings as mb', 'mer.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mer.mountain_id', '=', 'm.id')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
            ->select(
                'mer.id as rental_id',
                'mer.quantity as rental_quantity',
                'mer.status as rental_status',
                'mer.created_at as rental_date',
                'u.id as user_id',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'm.id as mountain_id',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'me.id as equipment_id',
                'me.name as equipment_name',
                'me.description as equipment_description',
                'me.image_url as equipment_image',
                'me.quantity as equipment_total_quantity',
                'mb.id as booking_id',
                'mb.hike_date',
                'mb.return_date',
                'mb.checkin_time',
                'mb.checkout_time',
                'mb.status as booking_status',
                DB::raw('DATEDIFF(COALESCE(mb.return_date, CURDATE()), mb.hike_date) + 1 as rental_duration_days'),
                DB::raw('CASE 
                    WHEN mer.status = "borrowed" AND mb.return_date < CURDATE() THEN "overdue"
                    WHEN mer.status = "borrowed" AND mb.return_date >= CURDATE() THEN "active"
                    WHEN mer.status = "returned" THEN "completed"
                    ELSE "unknown"
                END as rental_status_category')
            );

        // Apply mountain filter
        if (!empty($mountainId)) {
            $query->where('mer.mountain_id', $mountainId);
        }

        // Apply equipment filter
        if (!empty($equipmentId)) {
            $query->where('mer.equipment_id', $equipmentId);
        }

        // Apply status filter
        if (!empty($status)) {
            $query->where('mer.status', $status);
        }

        // Apply date range filter
        if (!empty($dateFrom)) {
            $query->where('mer.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }
        if (!empty($dateTo)) {
            $query->where('mer.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        // Apply search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('me.name', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('mb.id', 'LIKE', "%{$search}%");
            });
        }

        // Get total count before pagination
        $totalRecords = $query->count();

        // Apply ordering and pagination
        $rentals = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        // Format the data for DataTables
        $data = $rentals->map(function ($rental) {
            // Calculate overdue days
            $overdueDays = 0;
            if ($rental->rental_status === 'borrowed' && $rental->return_date) {
                $returnDate = Carbon::parse($rental->return_date);
                $today = Carbon::today();
                if ($today->gt($returnDate)) {
                    $overdueDays = $today->diffInDays($returnDate);
                }
            }

            return [
                'rental_id' => $rental->rental_id,
                'user_name' => $rental->user_name,
                'user_email' => $rental->user_email,
                'user_phone' => $rental->user_phone,
                'mountain_name' => $rental->mountain_name,
                'mountain_location' => $rental->mountain_location,
                'equipment_name' => $rental->equipment_name,
                'equipment_description' => $rental->equipment_description,
                'equipment_image' => $rental->equipment_image,
                'rental_quantity' => $rental->rental_quantity,
                'equipment_total_quantity' => $rental->equipment_total_quantity,
                'rental_status' => $rental->rental_status,
                'rental_status_category' => $rental->rental_status_category,
                'rental_date' => $rental->rental_date,
                'formatted_rental_date' => Carbon::parse($rental->rental_date)->format('d/m/Y H:i'),
                'hike_date' => $rental->hike_date ? Carbon::parse($rental->hike_date)->format('d/m/Y') : '-',
                'return_date' => $rental->return_date ? Carbon::parse($rental->return_date)->format('d/m/Y') : '-',
                'rental_duration_days' => $rental->rental_duration_days,
                'booking_id' => $rental->booking_id,
                'booking_status' => $rental->booking_status,
                'overdue_days' => $overdueDays,
                'is_overdue' => $overdueDays > 0,
                'checkin_time' => $rental->checkin_time,
                'checkout_time' => $rental->checkout_time,
                'has_image' => !empty($rental->equipment_image)
            ];
        });

        return response()->json([
            'draw' => intval($request->get('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }

    public function show($rentalId)
    {
        $rental = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_bookings as mb', 'mer.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mer.mountain_id', '=', 'm.id')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
            ->select(
                'mer.*',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'u.emergency_contact',
                'm.name as mountain_name',
                'm.location as mountain_location',
                'me.name as equipment_name',
                'me.description as equipment_description',
                'me.image_url as equipment_image',
                'me.quantity as equipment_total_quantity',
                'mb.hike_date',
                'mb.return_date',
                'mb.checkin_time',
                'mb.checkout_time',
                'mb.status as booking_status',
                'mb.team_size',
                'mb.members'
            )
            ->where('mer.id', $rentalId)
            ->first();

        if (!$rental) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }

        // Get other equipment rentals for the same booking
        $otherRentals = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
            ->select('mer.*', 'me.name as equipment_name', 'me.description', 'me.image_url')
            ->where('mer.booking_id', $rental->booking_id)
            ->where('mer.id', '!=', $rentalId)
            ->get();

        // Parse team members
        $members = [];
        if ($rental->members) {
            $members = json_decode($rental->members, true) ?: [];
        }

        // Calculate rental history for this user
        $rentalHistory = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_bookings as mb', 'mer.booking_id', '=', 'mb.id')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
            ->join('mountains as m', 'mer.mountain_id', '=', 'm.id')
            ->select(
                'mer.created_at',
                'mer.status',
                'me.name as equipment_name',
                'm.name as mountain_name',
                'mb.hike_date'
            )
            ->where('mb.user_id', DB::table('mountain_bookings')->where('id', $rental->booking_id)->value('user_id'))
            ->where('mer.id', '!=', $rentalId)
            ->orderBy('mer.created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'rental' => $rental,
            'other_rentals' => $otherRentals,
            'members' => $members,
            'rental_history' => $rentalHistory
        ]);
    }

    public function updateStatus(Request $request, $rentalId)
    {
        $status = $request->get('status');

        if (!in_array($status, ['borrowed', 'returned'])) {
            return response()->json(['error' => 'Status tidak valid'], 400);
        }

        DB::table('mountain_equipment_rentals')
            ->where('id', $rentalId)
            ->update([
                'status' => $status,
                'updated_at' => Carbon::now()
            ]);

        $statusText = $status === 'returned' ? 'dikembalikan' : 'dipinjam';

        return response()->json([
            'success' => true,
            'message' => "Status peminjaman berhasil diubah menjadi {$statusText}"
        ]);
    }

    public function getStatistics(Request $request)
    {
        $mountainId = $request->get('mountain_id', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        $query = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_bookings as mb', 'mer.booking_id', '=', 'mb.id')
            ->join('mountains as m', 'mer.mountain_id', '=', 'm.id')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id');

        // Apply filters
        if (!empty($mountainId)) {
            $query->where('mer.mountain_id', $mountainId);
        }
        if (!empty($dateFrom)) {
            $query->where('mer.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }
        if (!empty($dateTo)) {
            $query->where('mer.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        // Get total rentals
        $totalRentals = $query->count();

        // Get rentals by status
        $borrowedCount = (clone $query)->where('mer.status', 'borrowed')->count();
        $returnedCount = (clone $query)->where('mer.status', 'returned')->count();

        // Get overdue rentals
        $overdueCount = (clone $query)
            ->where('mer.status', 'borrowed')
            ->where('mb.return_date', '<', Carbon::today())
            ->count();

        // Get most rented equipment
        $mostRentedEquipment = (clone $query)
            ->select('me.name as equipment_name', DB::raw('COUNT(*) as rental_count'))
            ->groupBy('me.id', 'me.name')
            ->orderBy('rental_count', 'desc')
            ->limit(5)
            ->get();

        // Get rentals by mountain
        $rentalsByMountain = (clone $query)
            ->select('m.name as mountain_name', DB::raw('COUNT(*) as total'))
            ->groupBy('m.id', 'm.name')
            ->orderBy('total', 'desc')
            ->get();

        // Get total quantity borrowed vs returned
        $totalBorrowedQuantity = (clone $query)
            ->where('mer.status', 'borrowed')
            ->sum('mer.quantity');

        $totalReturnedQuantity = (clone $query)
            ->where('mer.status', 'returned')
            ->sum('mer.quantity');

        return response()->json([
            'total_rentals' => $totalRentals,
            'borrowed_count' => $borrowedCount,
            'returned_count' => $returnedCount,
            'overdue_count' => $overdueCount,
            'most_rented_equipment' => $mostRentedEquipment,
            'rentals_by_mountain' => $rentalsByMountain,
            'total_borrowed_quantity' => $totalBorrowedQuantity,
            'total_returned_quantity' => $totalReturnedQuantity
        ]);
    }

    public function exportRentals(Request $request)
    {
        $mountainId = $request->get('mountain_id', '');
        $equipmentId = $request->get('equipment_id', '');
        $status = $request->get('status', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');

        $query = DB::table('mountain_equipment_rentals as mer')
            ->join('mountain_bookings as mb', 'mer.booking_id', '=', 'mb.id')
            ->join('users as u', 'mb.user_id', '=', 'u.id')
            ->join('mountains as m', 'mer.mountain_id', '=', 'm.id')
            ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
            ->select(
                'mer.id as rental_id',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone as user_phone',
                'm.name as mountain_name',
                'me.name as equipment_name',
                'mer.quantity as rental_quantity',
                'mer.status as rental_status',
                'mb.hike_date',
                'mb.return_date',
                'mer.created_at as rental_date'
            );

        // Apply same filters as getData method
        if (!empty($mountainId)) {
            $query->where('mer.mountain_id', $mountainId);
        }
        if (!empty($equipmentId)) {
            $query->where('mer.equipment_id', $equipmentId);
        }
        if (!empty($status)) {
            $query->where('mer.status', $status);
        }
        if (!empty($dateFrom)) {
            $query->where('mer.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
        }
        if (!empty($dateTo)) {
            $query->where('mer.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
        }

        $rentals = $query->orderBy('mer.created_at', 'desc')->get();

        return response()->json([
            'data' => $rentals,
            'filename' => 'equipment_rentals_' . date('Y-m-d_H-i-s') . '.csv'
        ]);
    }

    public function getEquipmentAvailability(Request $request)
    {
        $mountainId = $request->get('mountain_id');

        if (empty($mountainId)) {
            return response()->json(['error' => 'Mountain ID required'], 400);
        }

        $equipments = DB::table('mountain_equipments as me')
            ->leftJoin('mountain_equipment_rentals as mer', function ($join) {
                $join->on('me.id', '=', 'mer.equipment_id')
                    ->where('mer.status', '=', 'borrowed');
            })
            ->select(
                'me.id',
                'me.name',
                'me.quantity as total_quantity',
                DB::raw('COALESCE(SUM(mer.quantity), 0) as borrowed_quantity'),
                DB::raw('me.quantity - COALESCE(SUM(mer.quantity), 0) as available_quantity')
            )
            ->where('me.mountain_id', $mountainId)
            ->groupBy('me.id', 'me.name', 'me.quantity')
            ->orderBy('me.name')
            ->get();

        return response()->json(['equipments' => $equipments]);
    }
}
