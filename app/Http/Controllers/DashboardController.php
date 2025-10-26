<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $mountainId = Auth::user()->mountain_id;

        $monthlyHikers = $this->getMonthlyHikers($mountainId);
        $totalRevenue = $this->getTotalRevenue($mountainId);
        $checkInOutTrends = $this->getCheckInOutTrends($mountainId);
        $favoriteRoutes = $this->getFavoriteRoutes($mountainId);
        $overallStats = $this->getOverallStats($mountainId);
        $recentBookings = $this->getRecentBookings($mountainId);

        return view('dashboard.pages.index', compact(
            'monthlyHikers',
            'totalRevenue',
            'checkInOutTrends',
            'favoriteRoutes',
            'overallStats',
            'recentBookings'
        ));
    }

    private function getMonthlyHikers($mountainId)
    {
        $currentYear = Carbon::now()->year;

        $monthlyData = DB::table('mountain_bookings')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('MONTHNAME(created_at) as month_name'),
                DB::raw('SUM(team_size) as total_hikers'),
                DB::raw('COUNT(*) as total_bookings')
            )
            ->whereYear('created_at', $currentYear)
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('MONTHNAME(created_at)'))
            ->orderBy('month')
            ->get();

        $monthlyStats = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyData->where('month', $i)->first();
            $monthlyStats[] = [
                'month' => Carbon::create()->month($i)->format('M'),
                'hikers' => $monthData ? $monthData->total_hikers : 0,
                'bookings' => $monthData ? $monthData->total_bookings : 0
            ];
        }

        return $monthlyStats;
    }

    private function getTotalRevenue($mountainId)
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $lastMonth = Carbon::now()->subMonth()->format('Y-m');

        $query = DB::table('mountain_bookings')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId));

        $currentMonthRevenue = (clone $query)
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $currentMonth)
            ->sum(DB::raw('team_size * 50000'));

        $lastMonthRevenue = (clone $query)
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $lastMonth)
            ->sum(DB::raw('team_size * 50000'));

        $totalRevenue = (clone $query)
            ->sum(DB::raw('team_size * 50000'));

        $growthPercentage = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : 0;

        return [
            'total' => $totalRevenue,
            'current_month' => $currentMonthRevenue,
            'last_month' => $lastMonthRevenue,
            'growth_percentage' => round($growthPercentage, 1)
        ];
    }

    private function getCheckInOutTrends($mountainId)
    {
        $last7Days = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $checkIns = DB::table('mountain_bookings')
                ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
                ->whereDate('checkin_time', $date->format('Y-m-d'))
                ->count();

            $checkOuts = DB::table('mountain_bookings')
                ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
                ->whereDate('checkout_time', $date->format('Y-m-d'))
                ->count();

            $last7Days->push([
                'date' => $date->format('M d'),
                'check_ins' => $checkIns,
                'check_outs' => $checkOuts
            ]);
        }

        $totalActiveBookings = DB::table('mountain_bookings')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->where('status', 'active')
            ->whereNotNull('checkin_time')
            ->whereNull('checkout_time')
            ->count();

        return [
            'daily_trends' => $last7Days,
            'active_bookings' => $totalActiveBookings,
        ];
    }

    private function getFavoriteRoutes($mountainId)
    {
        $routes = DB::table('mountain_bookings')
            ->join('mountains', 'mountain_bookings.mountain_id', '=', 'mountains.id')
            ->leftJoin('mountain_feedbacks', 'mountain_bookings.id', '=', 'mountain_feedbacks.booking_id')
            ->select(
                'mountains.name',
                'mountains.location',
                DB::raw('COUNT(mountain_bookings.id) as total_bookings'),
                DB::raw('SUM(team_size) as total_hikers'),
                DB::raw('AVG(COALESCE(mountain_feedbacks.rating, 0)) as avg_rating')
            )
            ->when($mountainId, fn($q) => $q->where('mountains.id', $mountainId))
            ->groupBy('mountains.id', 'mountains.name', 'mountains.location')
            ->orderByDesc('total_bookings')
            ->limit(5)
            ->get();

        return $routes->map(function ($route) {
            return [
                'name' => $route->name,
                'location' => $route->location,
                'bookings' => $route->total_bookings,
                'hikers' => $route->total_hikers,
                'rating' => round($route->avg_rating, 1)
            ];
        });
    }

    private function getOverallStats($mountainId)
    {
        $totalMountains = DB::table('mountains')
            ->where('status', 'active')
            ->when($mountainId, fn($q) => $q->where('id', $mountainId))
            ->count();

        $totalUsers = DB::table('users')
            ->where('user_type', 'pendaki')
            ->count();

        $totalBookings = DB::table('mountain_bookings')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->count();

        $totalEquipmentRentals = DB::table('mountain_equipment_rentals')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->count();

        $sosSignalsToday = DB::table('mountain_sos_signals')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->whereDate('timestamp', Carbon::today())
            ->count();

        $activeBookingsToday = DB::table('mountain_bookings')
            ->when($mountainId, fn($q) => $q->where('mountain_id', $mountainId))
            ->where('status', 'active')
            ->whereDate('hike_date', '<=', Carbon::today())
            ->whereDate('return_date', '>=', Carbon::today())
            ->count();

        return [
            'total_mountains' => $totalMountains,
            'total_users' => $totalUsers,
            'total_bookings' => $totalBookings,
            'equipment_rentals' => $totalEquipmentRentals,
            'sos_today' => $sosSignalsToday,
            'active_today' => $activeBookingsToday,
        ];
    }

    private function getRecentBookings($mountainId)
    {
        return DB::table('mountain_bookings')
            ->join('users', 'mountain_bookings.user_id', '=', 'users.id')
            ->join('mountains', 'mountain_bookings.mountain_id', '=', 'mountains.id')
            ->select(
                'users.name as user_name',
                'users.email',
                'mountains.name as mountain_name',
                'mountain_bookings.team_size',
                'mountain_bookings.status',
                'mountain_bookings.hike_date',
                'mountain_bookings.created_at'
            )
            ->when($mountainId, fn($q) => $q->where('mountain_bookings.mountain_id', $mountainId))
            ->orderByDesc('mountain_bookings.created_at')
            ->limit(8)
            ->get();
    }
}
