<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EquipmentRentalsController extends Controller
{
    public function index()
    {
        $mountainId = Auth::user()->mountain_id;

        $mountains = DB::table('mountains')
            ->select('id', 'name')
            ->where('status', 'active')
            ->when($mountainId, fn($q) => $q->where('id', $mountainId))
            ->orderBy('name')
            ->get();

        $equipments = DB::table('mountain_equipments')
            ->select(DB::raw('MIN(id) as id'), 'name')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->groupBy('name')
            ->orderBy('name')
            ->get();

        return view('dashboard.pages.equipment-rentals.index', compact('mountains', 'equipments'));
    }

    public function getData(Request $request)
    {
        $mountainId  = Auth::user()->mountain_id;
        $search      = $request->get('search', '');
        $start       = $request->get('start', 0);
        $length      = $request->get('length', 10);
        $orderColumn = $request->get('order_column', 'mer.created_at');
        $orderDir    = $request->get('order_dir', 'desc');
        $status      = $request->get('status', '');
        $equipmentId = $request->get('equipment_id', '');
        $dateFrom    = $request->get('date_from', '');
        $dateTo      = $request->get('date_to', '');

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
                'm.name as mountain_name',
                'm.location as mountain_location',
                'me.name as equipment_name',
                'me.description as equipment_description',
                'me.image_url as equipment_image',
                'me.quantity as equipment_total_quantity',
                'mb.hike_date',
                'mb.return_date',
                'mb.status as booking_status',
                DB::raw("CASE
                    WHEN mer.status = 'borrowed' AND mb.return_date < NOW() THEN 'overdue'
                    WHEN mer.status = 'borrowed' THEN 'active'
                    WHEN mer.status = 'returned' THEN 'completed'
                    ELSE 'unknown'
                END as rental_status_category")
            )
            ->when($mountainId, fn($q) => $q->where('mer.mountain_id', $mountainId));

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
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('u.name', 'LIKE', "%{$search}%")
                    ->orWhere('u.email', 'LIKE', "%{$search}%")
                    ->orWhere('me.name', 'LIKE', "%{$search}%")
                    ->orWhere('m.name', 'LIKE', "%{$search}%")
                    ->orWhere('mer.id', 'LIKE', "%{$search}%");
            });
        }

        $totalRecords = $query->count();

        $rentals = $query->orderBy($orderColumn, $orderDir)
            ->skip($start)
            ->take($length)
            ->get();

        $data = $rentals->map(function ($rental) {
            $overdueDays = 0;
            if ($rental->rental_status === 'borrowed' && $rental->return_date) {
                $returnDate = Carbon::parse($rental->return_date);
                $today = Carbon::today();
                if ($today->gt($returnDate)) {
                    $overdueDays = $today->diffInDays($returnDate);
                }
            }

            return [
                'rental_id'                => $rental->rental_id,
                'user_name'                => $rental->user_name,
                'user_email'               => $rental->user_email,
                'user_phone'               => $rental->user_phone,
                'mountain_name'            => $rental->mountain_name,
                'mountain_location'        => $rental->mountain_location,
                'equipment_name'           => $rental->equipment_name,
                'equipment_description'    => $rental->equipment_description,
                'equipment_image'          => $rental->equipment_image,
                'rental_quantity'          => $rental->rental_quantity,
                'equipment_total_quantity' => $rental->equipment_total_quantity,
                'rental_status'            => ucfirst($rental->rental_status),
                'rental_status_category'   => ucfirst($rental->rental_status_category),
                'rental_date'              => Carbon::parse($rental->rental_date)->format('d/m/Y H:i'),
                'hike_date'                => $rental->hike_date ? Carbon::parse($rental->hike_date)->format('d/m/Y') : '-',
                'return_date'              => $rental->return_date ? Carbon::parse($rental->return_date)->format('d/m/Y') : '-',
                'booking_status'           => ucfirst($rental->booking_status),
                'overdue_days'             => $overdueDays,
                'is_overdue'               => $overdueDays > 0,
                'has_image'                => !empty($rental->equipment_image)
            ];
        });

        return response()->json([
            'draw'            => intval($request->get('draw', 1)),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $data
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
                'status'     => $status,
                'updated_at' => Carbon::now()
            ]);

        $statusText = $status === 'returned' ? 'dikembalikan' : 'dipinjam';

        return response()->json([
            'success' => true,
            'message' => "Status peminjaman berhasil diubah menjadi {$statusText}"
        ]);
    }

    public function getEquipmentAvailability(Request $request)
    {
        $mountainId = Auth::user()->mountain_id;

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
            ->when($mountainId, fn($q) => $q->where('me.mountain_id', $mountainId))
            ->groupBy('me.id', 'me.name', 'me.quantity')
            ->orderBy('me.name')
            ->get();

        return response()->json(['equipments' => $equipments]);
    }
    public function getStatistics(Request $request)
{
    $mountainId = Auth::user()->mountain_id;
    $dateFrom   = $request->get('date_from', '');
    $dateTo     = $request->get('date_to', '');

    $query = DB::table('mountain_equipment_rentals as mer')
        ->join('mountain_bookings as mb', 'mer.booking_id', '=', 'mb.id')
        ->join('mountains as m', 'mer.mountain_id', '=', 'm.id')
        ->join('mountain_equipments as me', 'mer.equipment_id', '=', 'me.id')
        ->when($mountainId, fn($q) => $q->where('mer.mountain_id', $mountainId));

    if (!empty($dateFrom)) {
        $query->where('mer.created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
    }
    if (!empty($dateTo)) {
        $query->where('mer.created_at', '<=', Carbon::parse($dateTo)->endOfDay());
    }

    $totalRentals  = $query->count();
    $borrowedCount = (clone $query)->where('mer.status', 'borrowed')->count();
    $returnedCount = (clone $query)->where('mer.status', 'returned')->count();
    $overdueCount  = (clone $query)
        ->where('mer.status', 'borrowed')
        ->where('mb.return_date', '<', Carbon::now())
        ->count();

    $mostRentedEquipment = (clone $query)
        ->select('me.name as equipment_name', DB::raw('COUNT(*) as rental_count'))
        ->groupBy('me.id', 'me.name')
        ->orderBy('rental_count', 'desc')
        ->limit(5)
        ->get();

    $rentalsByMountain = (clone $query)
        ->select('m.name as mountain_name', DB::raw('COUNT(*) as total'))
        ->groupBy('m.id', 'm.name')
        ->orderBy('total', 'desc')
        ->get();

    return response()->json([
        'total_rentals'         => $totalRentals,
        'borrowed_count'        => $borrowedCount,
        'returned_count'        => $returnedCount,
        'overdue_count'         => $overdueCount,
        'most_rented_equipment' => $mostRentedEquipment,
        'rentals_by_mountain'   => $rentalsByMountain,
    ]);
}

}
