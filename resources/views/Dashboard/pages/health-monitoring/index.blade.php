@extends('Dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">
                <!-- Health Statistics Cards -->
                <div class="col-xl-12">
                    <div class="row gy-6">
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                            <i class="ri-heart-pulse-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="totalActiveHikers">0</h5>
                                            <small class="text-muted">Active Hikers</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-success me-3 p-2">
                                            <i class="ri-shield-check-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="normalStatus">0</h5>
                                            <small class="text-muted">Normal Status</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                            <i class="ri-alert-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="criticalHikers">0</h5>
                                            <small class="text-muted">Critical Status</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-warning me-3 p-2">
                                            <i class="ri-notification-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="recentAlerts">0</h5>
                                            <small class="text-muted">Recent Alerts</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Health Alerts -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="ri-alert-line text-danger me-2"></i>
                                Recent Health Alerts
                            </h5>
                            <button class="btn btn-sm btn-outline-primary" onclick="refreshAlerts()">
                                <i class="ri-refresh-line me-1"></i> Refresh
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="healthAlertsContainer">
                                <div class="text-center p-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Health Monitoring Table -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ri-heart-pulse-line text-primary me-2"></i>
                            Health Monitoring Dashboard
                        </h5>
                        <div class="card-header-elements">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search hikers..."
                                style="width: 250px;">
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="healthTable">
                            <thead>
                                <tr>
                                    <th>Hiker</th>
                                    <th>Mountain</th>
                                    <th>Heart Rate</th>
                                    <th>Body Temperature</th>
                                    <th>Status</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Loading spinner -->
                    <div id="loadingSpinner" class="text-center p-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- No data message -->
                    <div id="noDataMessage" class="text-center p-4" style="display: none;">
                        <p class="text-muted">No health data found.</p>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span id="tableInfo" class="text-muted">Showing 0 to 0 of 0 entries</span>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Table pagination">
                                    <ul class="pagination justify-content-end mb-0" id="pagination">
                                        <!-- Pagination will be generated by JavaScript -->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health Detail Modal -->
        <div class="modal fade" id="healthDetailModal" tabindex="-1" aria-labelledby="healthDetailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="healthDetailModalLabel">Health Monitoring Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="healthDetails">
                            <!-- Details will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="sendAlertBtn">
                            <i class="ri-alarm-warning-line me-1"></i>Send Alert
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let itemsPerPage = 10;
            let searchTerm = '';
            let totalRecords = 0;
            let refreshInterval;

            loadHealthData();
            loadStats();
            loadHealthAlerts();

            // Auto-refresh every 30 seconds
            refreshInterval = setInterval(function() {
                loadHealthData();
                loadStats();
                loadHealthAlerts();
            }, 30000);

            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTerm = $(this).val();
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    loadHealthData();
                }, 500);
            });

            function loadHealthData() {
                showLoading();
                $.ajax({
                    url: '{{ route('health.getData') }}',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        start: (currentPage - 1) * itemsPerPage,
                        length: itemsPerPage,
                        order_column: 'mhl.timestamp',
                        order_dir: 'desc'
                    },
                    success: function(response) {
                        hideLoading();
                        totalRecords = response.recordsTotal;
                        if (response.data && response.data.length > 0) {
                            renderTable(response.data);
                            renderPagination();
                            updateTableInfo();
                            $('#noDataMessage').hide();
                        } else {
                            $('#healthTable tbody').empty();
                            $('#pagination').empty();
                            $('#tableInfo').text('Showing 0 to 0 of 0 entries');
                            $('#noDataMessage').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('Error loading health data:', error);
                    }
                });
            }

            function loadStats() {
                $.ajax({
                    url: '{{ route('health.stats') }}',
                    type: 'GET',
                    success: function(response) {
                        $('#totalActiveHikers').text(response.total_active);
                        $('#criticalHikers').text(response.critical_hikers);
                        $('#recentAlerts').text(response.recent_alerts);
                        $('#normalStatus').text(response.total_active - response.critical_hikers);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading stats:', error);
                    }
                });
            }

            function loadHealthAlerts() {
                $.ajax({
                    url: '{{ route('health.stats') }}',
                    type: 'GET',
                    success: function(response) {
                        renderHealthAlerts(response.alert_details);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading alerts:', error);
                    }
                });
            }

            function renderHealthAlerts(alerts) {
                let html = '';

                if (alerts && alerts.length > 0) {
                    alerts.forEach(function(alert) {
                        let alertClass = getAlertClass(alert.heart_rate, alert.body_temperature);
                        let alertIcon = getAlertIcon(alert.heart_rate, alert.body_temperature);

                        html += `
                        <div class="alert ${alertClass} d-flex align-items-center" role="alert">
                            <i class="${alertIcon} me-2"></i>
                            <div class="flex-grow-1">
                                <strong>${alert.user_name}</strong> at <strong>${alert.mountain_name}</strong>
                                <br>
                                <small>
                                    Heart Rate: ${alert.heart_rate} bpm | Temperature: ${alert.body_temperature}°C
                                    | ${new Date(alert.timestamp).toLocaleString()}
                                </small>
                            </div>
                        </div>
                    `;
                    });
                } else {
                    html = `
                    <div class="alert alert-success text-center" role="alert">
                        <i class="ri-shield-check-line me-2"></i>
                        No health alerts at this time. All hikers are in normal condition.
                    </div>
                `;
                }

                $('#healthAlertsContainer').html(html);
            }

            function renderTable(data) {
                let html = '';
                data.forEach(function(health) {
                    let statusBadge = getHealthStatusBadge(health.health_status);
                    let heartRateColor = getVitalColor(health.heart_rate, 'heart_rate');
                    let temperatureColor = getVitalColor(health.body_temperature, 'temperature');

                    html += `
                    <tr>
                        <td>
                            <i class="icon-base ri ri-user-3-line icon-22px text-info me-3"></i>
                            <div>
                                <span class="fw-medium">${health.user_name}</span><br>
                                <small class="text-muted">${health.email}</small>
                            </div>
                        </td>
                        <td>
                            <i class="icon-base ri ri-mountain-line icon-22px text-success me-2"></i>
                            ${health.mountain_name}
                        </td>
                        <td>
                            <span class="badge ${heartRateColor} fw-medium">
                                <i class="ri-heart-pulse-line me-1"></i>
                                ${health.heart_rate} bpm
                            </span>
                        </td>
                        <td>
                            <span class="badge ${temperatureColor} fw-medium">
                                <i class="ri-temp-hot-line me-1"></i>
                                ${health.body_temperature}°C
                            </span>
                        </td>
                        <td>${statusBadge}</td>
                        <td>
                            <small class="text-muted">${health.timestamp}</small>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="viewHealthDetails(${health.booking_id})">
                                        <i class="icon-base ri ri-eye-line icon-18px me-2"></i>
                                        View Details
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="viewHealthChart(${health.booking_id})">
                                        <i class="icon-base ri ri-line-chart-line icon-18px me-2"></i>
                                        View Chart
                                    </a>
                                    ${health.health_status === 'critical' ? `
                                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="sendEmergencyAlert(${health.booking_id})">
                                            <i class="icon-base ri ri-alarm-warning-line icon-18px me-2"></i>
                                            Send Alert
                                        </a>
                                        ` : ''}
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                });
                $('#healthTable tbody').html(html);
            }

            function getHealthStatusBadge(status) {
                switch (status) {
                    case 'critical':
                        return '<span class="badge bg-label-danger">Critical</span>';
                    case 'warning':
                        return '<span class="badge bg-label-warning">Warning</span>';
                    case 'normal':
                        return '<span class="badge bg-label-success">Normal</span>';
                    default:
                        return '<span class="badge bg-label-secondary">Unknown</span>';
                }
            }

            function getVitalColor(value, type) {
                if (type === 'heart_rate') {
                    if (value > 120 || value < 50) return 'bg-label-danger';
                    if (value > 100 || value < 60) return 'bg-label-warning';
                    return 'bg-label-success';
                } else if (type === 'temperature') {
                    if (value > 38.5 || value < 35.0) return 'bg-label-danger';
                    if (value > 37.8 || value < 35.5) return 'bg-label-warning';
                    return 'bg-label-success';
                }
                return 'bg-label-secondary';
            }

            function getAlertClass(heartRate, temperature) {
                if (heartRate > 120 || heartRate < 50 || temperature > 38.5 || temperature < 35.0) {
                    return 'alert-danger';
                }
                return 'alert-warning';
            }

            function getAlertIcon(heartRate, temperature) {
                if (heartRate > 120 || heartRate < 50 || temperature > 38.5 || temperature < 35.0) {
                    return 'ri-alert-line';
                }
                return 'ri-error-warning-line';
            }

            window.viewHealthDetails = function(bookingId) {
                $.ajax({
                    url: `/health/${bookingId}`,
                    type: 'GET',
                    success: function(response) {
                        renderHealthDetails(response);
                        $('#healthDetailModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        alert('Error loading health details. Please try again.');
                    }
                });
            };

            window.viewHealthChart = function(bookingId) {
                // This would open a chart modal showing health trends
                viewHealthDetails(bookingId);
            };

            window.sendEmergencyAlert = function(bookingId) {
                if (confirm('Send emergency health alert for this hiker?')) {
                    $.ajax({
                        url: '{{ route('health.sendAlert') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            booking_id: bookingId,
                            alert_type: 'health_emergency',
                            message: 'Critical health readings detected'
                        },
                        success: function(response) {
                            alert('Emergency alert sent successfully');
                        },
                        error: function(xhr, status, error) {
                            alert('Error sending alert. Please try again.');
                        }
                    });
                }
            };

            window.refreshAlerts = function() {
                loadHealthAlerts();
            };

            function renderHealthDetails(data) {
                let statusClass = data.current_status === 'critical' ? 'danger' :
                    data.current_status === 'warning' ? 'warning' : 'success';

                let detailsHtml = `
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">Current Status</h6>
                                <h3 class="text-${statusClass} text-capitalize">${data.current_status}</h3>
                                <small class="text-muted">Last Update: ${new Date(data.latest_reading.timestamp).toLocaleString()}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">Heart Rate</h6>
                                <h3 class="text-primary">
                                    <i class="ri-heart-pulse-line me-1"></i>
                                    ${data.latest_reading.heart_rate} bpm
                                </h3>
                                <small class="text-muted">Avg: ${data.averages.heart_rate} bpm</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6 class="text-muted">Body Temperature</h6>
                                <h3 class="text-info">
                                    <i class="ri-temp-hot-line me-1"></i>
                                    ${data.latest_reading.body_temperature}°C
                                </h3>
                                <small class="text-muted">Avg: ${data.averages.body_temperature}°C</small>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Hiker Information</h6>
                        <p><strong>Name:</strong> ${data.hiker_info.name}</p>
                        <p><strong>Email:</strong> ${data.hiker_info.email}</p>
                        <p><strong>Mountain:</strong> ${data.hiker_info.mountain}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Recent Readings</h6>
                        <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>HR</th>
                                        <th>Temp</th>
                                    </tr>
                                </thead>
                                <tbody>
            `;

                data.readings.forEach(function(reading) {
                    detailsHtml += `
                    <tr>
                        <td><small>${new Date(reading.timestamp).toLocaleTimeString()}</small></td>
                        <td><small>${reading.heart_rate} bpm</small></td>
                        <td><small>${reading.body_temperature}°C</small></td>
                    </tr>
                `;
                });

                detailsHtml += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;

                $('#healthDetails').html(detailsHtml);
            }

            // Pagination and other utility functions (same as previous examples)
            function renderPagination() {
                const totalPages = Math.ceil(totalRecords / itemsPerPage);
                let html = '';
                if (totalPages <= 1) {
                    $('#pagination').empty();
                    return;
                }
                // ... pagination code similar to previous examples
            }

            window.changePage = function(page) {
                if (page < 1 || page > Math.ceil(totalRecords / itemsPerPage)) return;
                currentPage = page;
                loadHealthData();
            };

            function updateTableInfo() {
                const start = (currentPage - 1) * itemsPerPage + 1;
                const end = Math.min(currentPage * itemsPerPage, totalRecords);
                $('#tableInfo').text(`Showing ${start} to ${end} of ${totalRecords} entries`);
            }

            function showLoading() {
                $('#loadingSpinner').show();
                $('#healthTable tbody').empty();
                $('#noDataMessage').hide();
            }

            function hideLoading() {
                $('#loadingSpinner').hide();
            }

            // Clear interval when page is unloaded
            $(window).on('beforeunload', function() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }
            });
        });
    </script>
@endpush
