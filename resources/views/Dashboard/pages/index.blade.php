@extends('Dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">

                <div class="col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-body text-nowrap">
                            <h5 class="card-title mb-0 flex-wrap text-nowrap">Welcome Admin! 🎉</h5>
                            <p class="mb-2">Mountain Management System</p>
                            <h4 class="text-primary mb-0">Rp {{ number_format($totalRevenue['current_month'], 0, ',', '.') }}
                            </h4>
                            <p class="mb-2">
                                {{ $totalRevenue['growth_percentage'] > 0 ? '+' : '' }}{{ $totalRevenue['growth_percentage'] }}%
                                this month 🚀</p>
                            <a href="javascript:;" class="btn btn-sm btn-primary">View Details</a>
                        </div>
                        <img src="../assets/img/illustrations/trophy.png" class="position-absolute bottom-0 end-0 me-5 mb-5"
                            width="83" alt="view sales" />
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title m-0 me-2">Overview Statistics</h5>
                                <div class="dropdown">
                                    <button class="btn text-body-secondary p-0" type="button" id="overviewID"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-base ri ri-more-2-line icon-24px"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="overviewID">
                                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Export</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-lg-10">
                            <div class="row g-6">
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-primary rounded shadow-xs">
                                                <i class="icon-base ri ri-mountain-line icon-24px"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-0">Mountains</p>
                                            <h5 class="mb-0">{{ $overallStats['total_mountains'] }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-success rounded shadow-xs">
                                                <i class="icon-base ri ri-group-line icon-24px"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-0">Hikers</p>
                                            <h5 class="mb-0">{{ number_format($overallStats['total_users']) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-warning rounded shadow-xs">
                                                <i class="icon-base ri ri-calendar-check-line icon-24px"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-0">Bookings</p>
                                            <h5 class="mb-0">{{ number_format($overallStats['total_bookings']) }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-initial bg-info rounded shadow-xs">
                                                <i class="icon-base ri ri-money-dollar-circle-line icon-24px"></i>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-0">Revenue</p>
                                            <h5 class="mb-0">Rp {{ number_format($totalRevenue['total'], 0, ',', '.') }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-1">Monthly Hikers</h5>
                                <div class="dropdown">
                                    <button class="btn text-body-secondary p-0" type="button" id="monthlyHikersDropdown"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-base ri ri-more-2-line icon-24px"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="monthlyHikersDropdown">
                                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Export</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-lg-2">
                            <div id="monthlyHikersChart"></div>
                            <div class="mt-1 mt-md-3">
                                <div class="d-flex align-items-center gap-4">
                                    @php
                                        $totalHikers = collect($monthlyHikers)->sum('hikers');
                                        $avgHikers = $totalHikers > 0 ? round($totalHikers / 12, 0) : 0;
                                    @endphp
                                    <h4 class="mb-0">{{ number_format($totalHikers) }}</h4>
                                    <p class="mb-0">Total hikers this year with avg {{ $avgHikers }}/month 📊</p>
                                </div>
                                <div class="d-grid mt-3 mt-md-4">
                                    <button class="btn btn-primary" type="button">View Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Check-in/Check-out Trends</h5>
                            <div class="dropdown">
                                <button class="btn text-body-secondary p-0" type="button" id="trendsDropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base ri ri-more-2-line icon-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="trendsDropdown">
                                    <a class="dropdown-item" href="javascript:void(0);">Last 7 Days</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-lg-8">
                            <div class="mb-5 mb-lg-12">
                                <div class="d-flex align-items-center">
                                    <h3 class="mb-0">{{ $checkInOutTrends['active_bookings'] }}</h3>
                                    <span class="text-success ms-2">
                                        <i class="icon-base ri ri-arrow-up-s-line icon-sm"></i>
                                        <span>Active</span>
                                    </span>
                                </div>
                                <p class="mb-0">Currently hiking ({{ $checkInOutTrends['avg_duration_hours'] }}h avg
                                    duration)</p>
                            </div>
                            <ul class="p-0 m-0">
                                @foreach ($checkInOutTrends['daily_trends']->take(5) as $trend)
                                    <li class="d-flex mb-6">
                                        <div class="avatar flex-shrink-0 bg-lightest rounded me-3">
                                            <i class="ri-calendar-line"></i>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $trend['date'] }}</h6>
                                                <p class="mb-0">Check-ins: {{ $trend['check_ins'] }} | Check-outs:
                                                    {{ $trend['check_outs'] }}</p>
                                            </div>
                                            <div>
                                                <div class="progress bg-label-primary" style="height: 4px; width: 60px;">
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ min(($trend['check_ins'] + $trend['check_outs']) * 10, 100) }}%"
                                                        role="progressbar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Popular Routes</h5>
                            <div class="dropdown">
                                <button class="btn text-body-secondary p-0" type="button" id="routesDropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base ri ri-more-2-line icon-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="routesDropdown">
                                    <a class="dropdown-item" href="javascript:void(0);">View All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Export</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($favoriteRoutes as $index => $route)
                                <div class="d-flex justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-4">
                                            <div
                                                class="avatar-initial {{ ['bg-label-success', 'bg-label-primary', 'bg-label-warning', 'bg-label-info', 'bg-label-danger'][$index] }} rounded-circle">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                <h6 class="mb-0">{{ $route['name'] }}</h6>
                                                <div class="ms-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="ri-star{{ $i <= $route['rating'] ? '-fill' : '-line' }} text-warning"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="mb-0">{{ $route['location'] }}</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="mb-1">{{ $route['bookings'] }}</h6>
                                        <small class="text-body-secondary">{{ $route['hikers'] }} hikers</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
                    <div class="card-group">
                        <div class="card mb-0">
                            <div class="card-body card-separator">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                    <h5 class="m-0 me-2">Safety Alerts</h5>
                                    <a class="fw-medium" href="javascript:void(0);">View all</a>
                                </div>
                                <div class="deposit-content pt-2">
                                    <ul class="p-0 m-0">
                                        <li class="d-flex mb-4 align-items-center pb-2">
                                            <div class="flex-shrink-0 me-4">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-initial bg-danger rounded">
                                                        <i class="ri-alarm-warning-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0">SOS Signals Today</h6>
                                                    <p class="mb-0">Emergency alerts received</p>
                                                </div>
                                                <h6 class="text-danger mb-0">{{ $overallStats['sos_today'] }}</h6>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center pb-2">
                                            <div class="flex-shrink-0 me-4">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-initial bg-success rounded">
                                                        <i class="ri-user-location-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0">Active Hikers</h6>
                                                    <p class="mb-0">Currently on mountains</p>
                                                </div>
                                                <h6 class="text-success mb-0">{{ $overallStats['active_today'] }}</h6>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center pb-2">
                                            <div class="flex-shrink-0 me-4">
                                                <div class="avatar avatar-sm">
                                                    <div class="avatar-initial bg-info rounded">
                                                        <i class="ri-tools-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0">Equipment Rentals</h6>
                                                    <p class="mb-0">Active equipment loans</p>
                                                </div>
                                                <h6 class="text-info mb-0">{{ $overallStats['equipment_rentals'] }}</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                    <h5 class="m-0 me-2">Recent Activity</h5>
                                    <a class="fw-medium" href="javascript:void(0);">View all</a>
                                </div>
                                <div class="withdraw-content pt-2">
                                    <ul class="p-0 m-0">
                                        @php $statusColors = ['active' => 'success', 'cancelled' => 'danger', 'completed' => 'primary']; @endphp
                                        @foreach ($recentBookings->take(5) as $booking)
                                            <li class="d-flex mb-4 align-items-center pb-2">
                                                <div class="flex-shrink-0 me-4">
                                                    <div class="avatar avatar-sm">
                                                        <div
                                                            class="avatar-initial bg-{{ $statusColors[$booking->status] ?? 'secondary' }} rounded">
                                                            {{ strtoupper(substr($booking->user_name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0">{{ $booking->user_name }}</h6>
                                                        <p class="mb-0">{{ $booking->mountain_name }}
                                                            ({{ $booking->team_size }} hikers)</p>
                                                    </div>
                                                    <span
                                                        class="badge bg-label-{{ $statusColors[$booking->status] ?? 'secondary' }} rounded-pill">{{ ucfirst($booking->status) }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card overflow-hidden">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent Bookings</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-truncate">Hiker</th>
                                        <th class="text-truncate">Mountain</th>
                                        <th class="text-truncate">Team Size</th>
                                        <th class="text-truncate">Hike Date</th>
                                        <th class="text-truncate">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentBookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-4">
                                                        <div
                                                            class="avatar-initial bg-{{ $statusColors[$booking->status] ?? 'secondary' }} rounded-circle">
                                                            {{ strtoupper(substr($booking->user_name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-truncate">{{ $booking->user_name }}</h6>
                                                        <small class="text-truncate">{{ $booking->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-truncate">{{ $booking->mountain_name }}</td>
                                            <td class="text-truncate">
                                                <div class="d-flex align-items-center">
                                                    <i class="icon-base ri ri-group-line icon-22px text-primary me-2"></i>
                                                    <span>{{ $booking->team_size }} hikers</span>
                                                </div>
                                            </td>
                                            <td class="text-truncate">
                                                {{ \Carbon\Carbon::parse($booking->hike_date)->format('M d, Y') }}</td>
                                            <td><span
                                                    class="badge bg-label-{{ $statusColors[$booking->status] ?? 'secondary' }} rounded-pill">{{ ucfirst($booking->status) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div
                    class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        &#169;
                        <script>
                            document.write(new Date().getFullYear());
                        </script>, Mountain Management System
                    </div>
                </div>
            </div>
        </footer>

        <div class="content-backdrop fade"></div>
    </div>
@endsection
