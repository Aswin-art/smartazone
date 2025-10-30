@extends('dashboard.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row gy-6">

            {{-- Welcome Card --}}
            <div class="col-md-12 col-lg-4">
                <div class="card position-relative overflow-hidden">
                    <div class="card-body text-nowrap">
                        <h5 class="card-title mb-0">Welcome, {{ Auth::user()->name }}! 🎉</h5>
                        <p class="mb-2">Mountain Management System</p>
                        <h4 class="text-primary mb-0">
                            Rp {{ number_format($totalRevenue['current_month'], 0, ',', '.') }}
                        </h4>
                        <p class="mb-2">
                            {{ $totalRevenue['growth_percentage'] > 0 ? '+' : '' }}{{ $totalRevenue['growth_percentage'] }}%
                            growth this month 🚀
                        </p>
                        <a href="javascript:;" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                    <img src="{{ asset('assets/img/illustrations/trophy.png') }}" class="position-absolute bottom-0 end-0 me-4 mb-4" width="83" alt="view sales" />
                </div>
            </div>

            {{-- Overview Statistics --}}
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Overview Statistics</h5>
                            <button class="btn text-body-secondary p-0" data-bs-toggle="dropdown">
                                <i class="ri-more-2-line ri-24px"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body pt-lg-10">
                        <div class="row g-6">
                            {{-- <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-primary rounded shadow-xs">
                                            <i class="ri-mountain-line ri-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0">Mountains</p>
                                        <h5 class="mb-0">{{ $overallStats['total_mountains'] }}</h5>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-success rounded shadow-xs">
                                            <i class="ri-group-line ri-24px"></i>
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
                                            <i class="ri-calendar-check-line ri-24px"></i>
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
                                            <i class="ri-money-dollar-circle-line ri-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <p class="mb-0">Revenue</p>
                                        <h5 class="mb-0">Rp {{ number_format($totalRevenue['total'], 0, ',', '.') }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Monthly Hikers --}}
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-1">Monthly Hikers</h5>
                    </div>
                    <div class="card-body pt-lg-2">
                        <div id="monthlyHikersChart"></div>
                        <div class="mt-3">
                            @php
                                $totalHikers = collect($monthlyHikers)->sum('hikers');
                                $avgHikers = $totalHikers > 0 ? round($totalHikers / 12, 0) : 0;
                            @endphp
                            <h4 class="mb-0">{{ number_format($totalHikers) }}</h4>
                            <p class="mb-0">Total hikers this year (avg {{ $avgHikers }}/month)</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Check-in/Check-out Trends --}}
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Check-in / Check-out</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="mb-1">{{ $checkInOutTrends['active_bookings'] }}</h3>
                        <p class="text-muted mb-3">Currently active bookings</p>
                        <ul class="list-unstyled">
                            @foreach ($checkInOutTrends['daily_trends'] as $trend)
                                <li class="d-flex justify-content-between align-items-center mb-2">
                                    <span>{{ $trend['date'] }}</span>
                                    <span class="text-muted">In: {{ $trend['check_ins'] }} | Out: {{ $trend['check_outs'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Popular Routes --}}
            <div class="col-xl-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title m-0">Popular Routes</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($favoriteRoutes as $index => $route)
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h6 class="mb-0">{{ $route->name }}</h6>
                                    <small>{{ $route->location }}</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">{{ $route->total_bookings }}</h6>
                                    <small>{{ $route->total_hikers }} hikers</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Safety Alerts & Recent Activity --}}
            <div class="col-xl-8">
                <div class="card-group">
                    <div class="card mb-0">
                        <div class="card-body">
                            <h5 class="mb-3">Safety Alerts</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3 d-flex justify-content-between align-items-center">
                                    <span><i class="ri-alarm-warning-line text-danger me-2"></i> SOS Signals Today</span>
                                    <strong class="text-danger">{{ $overallStats['sos_today'] }}</strong>
                                </li>
                                <li class="mb-3 d-flex justify-content-between align-items-center">
                                    <span><i class="ri-user-location-line text-success me-2"></i> Active Hikers</span>
                                    <strong class="text-success">{{ $overallStats['active_today'] }}</strong>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <span><i class="ri-tools-line text-info me-2"></i> Equipment Rentals</span>
                                    <strong class="text-info">{{ $overallStats['equipment_rentals'] }}</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-body">
                            <h5 class="mb-3">Recent Activity</h5>
                            @php $statusColors = ['active' => 'success', 'cancelled' => 'danger', 'completed' => 'primary']; @endphp
                            <ul class="list-unstyled">
                                @foreach ($recentBookings->take(5) as $booking)
                                    <li class="mb-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $booking->user_name }}</strong>
                                            <p class="mb-0 text-muted small">{{ $booking->mountain_name }}</p>
                                        </div>
                                        <span class="badge bg-label-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Bookings Table --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Recent Bookings</h5></div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Hiker</th>
                                    <th>Mountain</th>
                                    <th>Team</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentBookings as $booking)
                                    <tr>
                                        <td>
                                            <strong>{{ $booking->user_name }}</strong><br>
                                            <small class="text-muted">{{ $booking->email }}</small>
                                        </td>
                                        <td>{{ $booking->mountain_name }}</td>
                                        <td>{{ $booking->team_size }} hikers</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->hike_date)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-label-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
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
        <div class="container-xxl py-3 text-center">
            © <script>document.write(new Date().getFullYear());</script> Mountain Management System
        </div>
    </footer>
</div>
@endsection
