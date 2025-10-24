<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyHikers = $this->getMonthlyHikers();
        $totalRevenue = $this->getTotalRevenue();
        $checkInOutTrends = $this->getCheckInOutTrends();
        $favoriteRoutes = $this->getFavoriteRoutes();
        $overallStats = $this->getOverallStats();
        $recentBookings = $this->getRecentBookings();

        return view('dashboard.pages.index', compact(
            'monthlyHikers',
            'totalRevenue',
            'checkInOutTrends',
            'favoriteRoutes',
            'overallStats',
            'recentBookings'
        ));
    }

    private function getMonthlyHikers()
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

    private function getTotalRevenue()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $lastMonth = Carbon::now()->subMonth()->format('Y-m');

        $currentMonthRevenue = DB::table('mountain_bookings')
            ->join('mountains', 'mountain_bookings.mountain_id', '=', 'mountains.id')
            ->where(DB::raw("DATE_FORMAT(mountain_bookings.created_at, '%Y-%m')"), $currentMonth)
            ->sum(DB::raw('team_size * 50000'));

        $lastMonthRevenue = DB::table('mountain_bookings')
            ->join('mountains', 'mountain_bookings.mountain_id', '=', 'mountains.id')
            ->where(DB::raw("DATE_FORMAT(mountain_bookings.created_at, '%Y-%m')"), $lastMonth)
            ->sum(DB::raw('team_size * 50000'));

        $totalRevenue = DB::table('mountain_bookings')
            ->sum(DB::raw('team_size * 50000'));

        $growthPercentage = 0;
        if ($lastMonthRevenue > 0) {
            $growthPercentage = (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }

        return [
            'total' => $totalRevenue,
            'current_month' => $currentMonthRevenue,
            'last_month' => $lastMonthRevenue,
            'growth_percentage' => round($growthPercentage, 1)
        ];
    }

    private function getCheckInOutTrends()
    {
        $last7Days = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $checkIns = DB::table('mountain_bookings')
                ->whereDate('checkin_time', $date->format('Y-m-d'))
                ->count();

            $checkOuts = DB::table('mountain_bookings')
                ->whereDate('checkout_time', $date->format('Y-m-d'))
                ->count();

            $last7Days->push([
                'date' => $date->format('M d'),
                'check_ins' => $checkIns,
                'check_outs' => $checkOuts
            ]);
        }

        $totalActiveBookings = DB::table('mountain_bookings')
            ->where('status', 'active')
            ->whereNotNull('checkin_time')
            ->whereNull('checkout_time')
            ->count();

        $averageDuration = DB::table('mountain_bookings')
            ->where('status', 'completed')
            ->whereNotNull('total_duration_minutes')
            ->avg('total_duration_minutes');

        return [
            'daily_trends' => $last7Days,
            'active_bookings' => $totalActiveBookings,
            'avg_duration_hours' => $averageDuration ? round($averageDuration / 60, 1) : 0
        ];
    }

    private function getFavoriteRoutes()
    {
        $routes = DB::table('mountain_bookings')
            ->join('mountains', 'mountain_bookings.mountain_id', '=', 'mountains.id')
            ->select(
                'mountains.name',
                'mountains.location',
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(team_size) as total_hikers'),
                DB::raw('AVG(COALESCE(mountain_feedbacks.rating, 0)) as avg_rating')
            )
            ->leftJoin('mountain_feedbacks', 'mountain_bookings.id', '=', 'mountain_feedbacks.booking_id')
            ->groupBy('mountains.id', 'mountains.name', 'mountains.location')
            ->orderBy('total_bookings', 'desc')
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

    private function getOverallStats()
    {
        $totalMountains = DB::table('mountains')
            ->where('status', 'active')
            ->count();

        $totalUsers = DB::table('users')
            ->where('user_type', 'pendaki')
            ->count();

        $totalBookings = DB::table('mountain_bookings')->count();

        $totalEquipmentRentals = DB::table('mountain_equipment_rentals')->count();

        $sosSignalsToday = DB::table('mountain_sos_signals')
            ->whereDate('timestamp', Carbon::today())
            ->count();

        $activeBookingsToday = DB::table('mountain_bookings')
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
            'active_today' => $activeBookingsToday
        ];
    }

    private function getRecentBookings()
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
            ->orderBy('mountain_bookings.created_at', 'desc')
            ->limit(8)
            ->get();
    }
}
