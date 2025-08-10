@extends('dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">
                <!-- SOS Statistics Cards -->
                <div class="col-xl-12">
                    <div class="row gy-6">
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-info me-3 p-2">
                                            <i class="ri-alarm-warning-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="totalSOS">0</h5>
                                            <small class="text-muted">Total SOS Signals</small>
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
                                            <h5 class="mb-0" id="pendingSOS">0</h5>
                                            <small class="text-muted">Pending Response</small>
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
                                            <h5 class="mb-0" id="resolvedSOS">0</h5>
                                            <small class="text-muted">Resolved</small>
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
                                            <i class="ri-time-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="avgResponseTime">0</h5>
                                            <small class="text-muted">Avg Response Time</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent SOS Alerts -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="ri-alert-line text-danger me-2"></i>
                                Recent SOS Signals (Last 24 Hours)
                            </h5>
                            <button class="btn btn-sm btn-outline-primary" onclick="refreshSOSAlerts()">
                                <i class="ri-refresh-line me-1"></i> Refresh
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="recentSOSContainer">
                                <div class="text-center p-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SOS Signals Table -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ri-alarm-warning-line text-danger me-2"></i>
                            SOS Signal Monitor
                        </h5>
                        <div class="card-header-elements d-flex">
                            <select class="form-select me-2" id="statusFilter" style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="responded">Responded</option>
                                <option value="resolved">Resolved</option>
                                <option value="false_alarm">False Alarm</option>
                            </select>
                            <input type="text" id="searchInput" class="form-control" placeholder="Search SOS signals..."
                                style="width: 250px;">
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="sosTable">
                            <thead>
                                <tr>
                                    <th>Priority</th>
                                    <th>Hiker</th>
                                    <th>Mountain</th>
                                    <th>Location</th>
                                    <th>Message</th>
                                    <th>Time</th>
                                    <th>Status</th>
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
                        <p class="text-muted">No SOS signals found.</p>
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

        <!-- SOS Detail Modal -->
        <div class="modal fade" id="sosDetailModal" tabindex="-1" aria-labelledby="sosDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sosDetailModalLabel">
                            <i class="ri-alarm-warning-line text-danger me-2"></i>
                            SOS Signal Details
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="sosDetails">
                            <!-- Details will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="markResolvedBtn">
                            <i class="ri-shield-check-line me-1"></i>Mark as Resolved
                        </button>
                        <button type="button" class="btn btn-warning" id="markRespondedBtn">
                            <i class="ri-chat-check-line me-1"></i>Mark as Responded
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Response Modal -->
        <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel">Respond to SOS Signal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="responseForm">
                        <div class="modal-body">
                            <input type="hidden" id="sosSignalId" name="sos_signal_id">
                            <div class="mb-3">
                                <label for="responseStatus" class="form-label">Status *</label>
                                <select class="form-select" id="responseStatus" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="responded">Responded - Help is on the way</option>
                                    <option value="resolved">Resolved - Situation handled</option>
                                    <option value="false_alarm">False Alarm - No assistance needed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="responderName" class="form-label">Responder Name *</label>
                                <input type="text" class="form-control" id="responderName" name="responder_name" 
                                       placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3">
                                <label for="responseNotes" class="form-label">Response Notes</label>
                                <textarea class="form-control" id="responseNotes" name="response_notes" rows="3"
                                          placeholder="Enter any additional notes or actions taken..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-send-plane-line me-1"></i>Submit Response
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        &#169;
                        <script>document.write(new Date().getFullYear());</script>, Mountain Management System
                    </div>
                </div>
            </div>
        </footer>

        <div class="content-backdrop fade"></div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let currentPage = 1;
        let itemsPerPage = 10;
        let searchTerm = '';
        let statusFilter = '';
        let totalRecords = 0;
        let refreshInterval;
        let currentSOSId = null;
        
        loadSOSData();
        loadSOSStats();
        loadRecentSOSAlerts();
        
        // Auto-refresh every 15 seconds for SOS signals
        refreshInterval = setInterval(function() {
            loadSOSData();
            loadSOSStats();
            loadRecentSOSAlerts();
        }, 15000);

        let searchTimeout;
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTerm = $(this).val();
            searchTimeout = setTimeout(function() {
                currentPage = 1;
                loadSOSData();
            }, 500);
        });

        $('#statusFilter').on('change', function() {
            statusFilter = $(this).val();
            currentPage = 1;
            loadSOSData();
        });

        function loadSOSData() {
            showLoading();
            $.ajax({
                url: '{{ route('sos.getData') }}',
                type: 'GET',
                data: {
                    search: searchTerm,
                    status: statusFilter,
                    start: (currentPage - 1) * itemsPerPage,
                    length: itemsPerPage,
                    order_column: 'mss.timestamp',
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
                        $('#sosTable tbody').empty();
                        $('#pagination').empty();
                        $('#tableInfo').text('Showing 0 to 0 of 0 entries');
                        $('#noDataMessage').show();
                    }
                },
                error: function(xhr, status, error) {
                    hideLoading();
                    console.error('Error loading SOS data:', error);
                    alert('Error loading data. Please try again.');
                }
            });
        }

        function loadSOSStats() {
            $.ajax({
                url: '{{ route('sos.stats') }}',
                type: 'GET',
                success: function(response) {
                    $('#totalSOS').text(response.total_sos);
                    $('#pendingSOS').text(response.pending_sos);
                    $('#resolvedSOS').text(response.resolved_sos);
                    $('#avgResponseTime').text(response.avg_response_time);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading SOS stats:', error);
                }
            });
        }

        function loadRecentSOSAlerts() {
            $.ajax({
                url: '{{ route('sos.stats') }}',
                type: 'GET',
                success: function(response) {
                    renderRecentSOSAlerts(response.recent_sos);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading recent SOS alerts:', error);
                }
            });
        }

        function renderRecentSOSAlerts(recentSOS) {
            let html = '';
            
            if (recentSOS && recentSOS.length > 0) {
                recentSOS.forEach(function(sos) {
                    let priorityClass = getPriorityClass(sos.timestamp);
                    let statusBadge = getSOSStatusBadge(sos.response_status);
                    let timeAgo = getTimeAgo(sos.timestamp);
                    
                    html += `
                        <div class="alert alert-${priorityClass} d-flex align-items-center" role="alert">
                            <i class="ri-alarm-warning-line me-2 ri-22px"></i>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>${sos.user_name}</strong> at <strong>${sos.mountain_name}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="ri-time-line me-1"></i>${timeAgo} ago
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        ${statusBadge}
                                        <br>
                                        <button class="btn btn-sm btn-outline-primary mt-1" onclick="viewSOSDetails(${sos.id})">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = `
                    <div class="alert alert-success text-center" role="alert">
                        <i class="ri-shield-check-line me-2"></i>
                        No recent SOS signals. All hikers are safe.
                    </div>
                `;
            }
            
            $('#recentSOSContainer').html(html);
        }

        function renderTable(data) {
            let html = '';
            data.forEach(function(sos) {
                let priorityBadge = getPriorityBadge(sos.priority);
                let statusBadge = getSOSStatusBadge(sos.status);
                let coordinates = `${parseFloat(sos.latitude).toFixed(6)}, ${parseFloat(sos.longitude).toFixed(6)}`;
                let message = sos.message.length > 30 ? sos.message.substring(0, 30) + '...' : sos.message;
                
                html += `
                    <tr class="${sos.priority === 'critical' ? 'table-danger' : ''}">
                        <td>${priorityBadge}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="icon-base ri ri-user-3-line icon-22px text-danger me-3"></i>
                                <div>
                                    <span class="fw-medium">${sos.user_name}</span><br>
                                    <small class="text-muted">
                                        <i class="ri-phone-line me-1"></i>${sos.phone || 'No phone'}
                                    </small><br>
                                    <small class="text-muted">
                                        <i class="ri-group-line me-1"></i>Team: ${sos.team_size}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="icon-base ri ri-mountain-line icon-22px text-success me-2"></i>
                            ${sos.mountain_name}
                        </td>
                        <td>
                            <div class="location-info">
                                <span class="d-block font-monospace small">${coordinates}</span>
                                <small class="text-muted">
                                    <a href="https://maps.google.com/?q=${sos.latitude},${sos.longitude}" target="_blank" class="text-decoration-none">
                                        <i class="ri-external-link-line me-1"></i>View on Map
                                    </a>
                                </small>
                            </div>
                        </td>
                        <td>
                            <span class="text-wrap" style="max-width: 150px; display: inline-block;" 
                                  title="${sos.message}">${message}</span>
                        </td>
                        <td>
                            <div>
                                <small class="text-muted">${sos.timestamp}</small>
                                ${sos.responded_at ? `
                                    <br><small class="text-success">
                                        <i class="ri-check-line me-1"></i>
                                        Responded: ${sos.responded_at}
                                    </small>
                                ` : ''}
                            </div>
                        </td>
                        <td>${statusBadge}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="viewSOSDetails(${sos.sos_id})">
                                        <i class="icon-base ri ri-eye-line icon-18px me-2"></i>
                                        View Details
                                    </a>
                                    ${sos.status === 'pending' ? `
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="respondToSOS(${sos.sos_id})">
                                        <i class="icon-base ri ri-chat-check-line icon-18px me-2"></i>
                                        Respond
                                    </a>
                                    ` : ''}
                                    <a class="dropdown-item" href="https://maps.google.com/?q=${sos.latitude},${sos.longitude}" target="_blank">
                                        <i class="icon-base ri ri-map-pin-line icon-18px me-2"></i>
                                        Open in Maps
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="getEmergencyContacts(${sos.booking_id})">
                                        <i class="icon-base ri ri-contacts-line icon-18px me-2"></i>
                                        Emergency Contacts
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });
            $('#sosTable tbody').html(html);
        }

        function getPriorityBadge(priority) {
            switch (priority) {
                case 'critical':
                    return '<span class="badge bg-danger">Critical</span>';
                case 'high':
                    return '<span class="badge bg-warning">High</span>';
                case 'medium':
                    return '<span class="badge bg-info">Medium</span>';
                case 'normal':
                    return '<span class="badge bg-success">Normal</span>';
                default:
                    return '<span class="badge bg-secondary">Unknown</span>';
            }
        }

        function getSOSStatusBadge(status) {
            switch (status) {
                case 'pending':
                    return '<span class="badge bg-label-danger">Pending</span>';
                case 'responded':
                    return '<span class="badge bg-label-warning">Responded</span>';
                case 'resolved':
                    return '<span class="badge bg-label-success">Resolved</span>';
                case 'false_alarm':
                    return '<span class="badge bg-label-secondary">False Alarm</span>';
                default:
                    return '<span class="badge bg-label-danger">Pending</span>';
            }
        }

        function getPriorityClass(timestamp) {
            let hoursAgo = (new Date() - new Date(timestamp)) / (1000 * 60 * 60);
            if (hoursAgo > 6) return 'danger';
            if (hoursAgo > 2) return 'warning';
            return 'info';
        }

        function getTimeAgo(timestamp) {
            let now = new Date();
            let past = new Date(timestamp);
            let diffMs = now - past;
            let diffHrs = Math.floor(diffMs / (1000 * 60 * 60));
            let diffMins = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
            
            if (diffHrs > 0) {
                return `${diffHrs}h ${diffMins}m`;
            } else {
                return `${diffMins}m`;
            }
        }

        window.viewSOSDetails = function(sosId) {
            $.ajax({
                url: `/sos/${sosId}`,
                type: 'GET',
                success: function(response) {
                    currentSOSId = sosId;
                    renderSOSDetails(response);
                    $('#sosDetailModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Error loading SOS details. Please try again.');
                }
            });
        };

        window.respondToSOS = function(sosId) {
            currentSOSId = sosId;
            $('#sosSignalId').val(sosId);
            $('#responseModal').modal('show');
        };

        window.getEmergencyContacts = function(bookingId) {
            $.ajax({
                url: `/sos/emergency-contacts/${bookingId}`,
                type: 'GET',
                success: function(response) {
                    let contactsHtml = `
                        <div class="alert alert-info">
                            <h6>Emergency Contacts:</h6>
                            <p><strong>Emergency Contact:</strong> ${response.emergency_contact || 'Not provided'}</p>
                            <p><strong>Hiker Phone:</strong> ${response.phone || 'Not provided'}</p>
                        </div>
                    `;
                    
                    if (response.members) {
                        let members = JSON.parse(response.members);
                        contactsHtml += '<h6>Team Members:</h6><ul>';
                        members.forEach(function(member) {
                            contactsHtml += `<li>${member.name || 'Unknown'} - ${member.phone || 'No phone'}</li>`;
                        });
                        contactsHtml += '</ul>';
                    }
                    
                    alert(contactsHtml);
                },
                error: function(xhr, status, error) {
                    alert('Error loading emergency contacts.');
                }
            });
        };

        window.refreshSOSAlerts = function() {
            loadRecentSOSAlerts();
        };

        // Response form submission
        $('#responseForm').on('submit', function(e) {
            e.preventDefault();
            
            let formData = {
                _token: '{{ csrf_token() }}',
                status: $('#responseStatus').val(),
                responder_name: $('#responderName').val(),
                response_notes: $('#responseNotes').val()
            };
            
            $.ajax({
                url: `/sos/${currentSOSId}/respond`,
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Response recorded successfully');
                    $('#responseModal').modal('hide');
                    $('#responseForm')[0].reset();
                    loadSOSData();
                    loadSOSStats();
                },
                error: function(xhr, status, error) {
                    alert('Error recording response. Please try again.');
                }
            });
        });

        // Quick response buttons
        $('#markResolvedBtn').on('click', function() {
            if (currentSOSId && confirm('Mark this SOS signal as resolved?')) {
                $.ajax({
                    url: `/sos/${currentSOSId}/respond`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: 'resolved',
                        responder_name: 'Admin Dashboard',
                        response_notes: 'Marked as resolved from dashboard'
                    },
                    success: function(response) {
                        alert('SOS signal marked as resolved');
                        $('#sosDetailModal').modal('hide');
                        loadSOSData();
                        loadSOSStats();
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating status. Please try again.');
                    }
                });
            }
        });

        $('#markRespondedBtn').on('click', function() {
            respondToSOS(currentSOSId);
            $('#sosDetailModal').modal('hide');
        });

        function renderSOSDetails(data) {
            let priorityClass = getPriorityClass(data.sos_signal.timestamp);
            let statusBadge = getSOSStatusBadge(data.sos_signal.response_status);
            
            let detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted">SOS Status</h6>
                                <h4 class="text-${priorityClass}">${statusBadge}</h4>
                                <small class="text-muted">
                                    Signal Time: ${new Date(data.sos_signal.timestamp).toLocaleString()}
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted">Location</h6>
                                <p class="font-monospace">
                                    <i class="ri-map-pin-line me-1"></i>
                                    ${parseFloat(data.sos_signal.latitude).toFixed(6)}, ${parseFloat(data.sos_signal.longitude).toFixed(6)}
                                </p>
                                <a href="https://maps.google.com/?q=${data.sos_signal.latitude},${data.sos_signal.longitude}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-external-link-line me-1"></i>View on Map
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Hiker Information</h6>
                        <p><strong>Name:</strong> ${data.sos_signal.user_name}</p>
                        <p><strong>Email:</strong> ${data.sos_signal.email}</p>
                        <p><strong>Phone:</strong> ${data.sos_signal.phone || 'Not provided'}</p>
                        <p><strong>Emergency Contact:</strong> ${data.sos_signal.emergency_contact || 'Not provided'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Hiking Details</h6>
                        <p><strong>Mountain:</strong> ${data.sos_signal.mountain_name}</p>
                        <p><strong>Team Size:</strong> ${data.sos_signal.team_size} people</p>
                        <p><strong>Hike Date:</strong> ${data.sos_signal.hike_date}</p>
                        <p><strong>Return Date:</strong> ${data.sos_signal.return_date}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-muted">Emergency Message</h6>
                        <div class="alert alert-warning">
                            <p class="mb-0">${data.sos_signal.message || 'Emergency assistance needed - No additional message provided'}</p>
                        </div>
                    </div>
                </div>
            `;
            
            if (data.sos_signal.response_status && data.sos_signal.response_status !== 'pending') {
                detailsHtml += `
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-muted">Response Information</h6>
                            <div class="alert alert-success">
                                <p><strong>Status:</strong> ${data.sos_signal.response_status}</p>
                                <p><strong>Responder:</strong> ${data.sos_signal.responder_name}</p>
                                <p><strong>Response Time:</strong> ${new Date(data.sos_signal.responded_at).toLocaleString()}</p>
                                ${data.sos_signal.response_notes ? `<p><strong>Notes:</strong> ${data.sos_signal.response_notes}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            }
            
            $('#sosDetails').html(detailsHtml);
        }

        // Utility functions for pagination, etc. (similar to previous examples)
        function renderPagination() {
            const totalPages = Math.ceil(totalRecords / itemsPerPage);
            let html = '';
            if (totalPages <= 1) {
                $('#pagination').empty();
                return;
            }
            
            html += `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage - 1})">
                        <i class="ri-arrow-left-s-line"></i>
                    </a>
                </li>
            `;
            
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, startPage + 4);
            
            if (startPage > 1) {
                html += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(1)">1</a></li>`;
                if (startPage > 2) {
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
            }
            
            for (let i = startPage; i <= endPage; i++) {
                html += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" onclick="changePage(${i})">${i}</a>
                    </li>
                `;
            }
            
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }
                html += `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
            }
            
            html += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage + 1})">
                        <i class="ri-arrow-right-s-line"></i>
                    </a>
                </li>
            `;
            
            $('#pagination').html(html);
        }

        window.changePage = function(page) {
            if (page < 1 || page > Math.ceil(totalRecords / itemsPerPage)) return;
            currentPage = page;
            loadSOSData();
        };

        function updateTableInfo() {
            const start = (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, totalRecords);
            $('#tableInfo').text(`Showing ${start} to ${end} of ${totalRecords} entries`);
        }

        function showLoading() {
            $('#loadingSpinner').show();
            $('#sosTable tbody').empty();
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