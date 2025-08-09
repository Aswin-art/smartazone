@extends('dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">
                <!-- Location Statistics Cards -->
                <div class="col-xl-12">
                    <div class="row gy-6">
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                            <i class="ri-map-pin-user-line ri-22px"></i>
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
                                            <i class="ri-wifi-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="onlineHikers">0</h5>
                                            <small class="text-muted">Online</small>
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
                                            <i class="ri-wifi-off-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="offlineHikers">0</h5>
                                            <small class="text-muted">Offline</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="badge rounded-pill bg-label-info me-3 p-2">
                                            <i class="ri-mountain-line ri-22px"></i>
                                        </div>
                                        <div class="card-info">
                                            <h5 class="mb-0" id="activeMountains">0</h5>
                                            <small class="text-muted">Active Mountains</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interactive Map -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="ri-map-2-line text-primary me-2"></i>
                                Real-time Hiker Locations
                            </h5>
                            <div class="card-header-elements">
                                <button class="btn btn-sm btn-outline-primary me-2" onclick="refreshMap()">
                                    <i class="ri-refresh-line me-1"></i> Refresh
                                </button>
                                <button class="btn btn-sm btn-primary" onclick="centerMap()">
                                    <i class="ri-focus-3-line me-1"></i> Center Map
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="hikersMap" style="height: 500px; width: 100%;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary mb-3" role="status">
                                            <span class="visually-hidden">Loading map...</span>
                                        </div>
                                        <p class="text-muted">Loading interactive map...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hikers List -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="ri-group-line text-info me-2"></i>
                                Active Hikers
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div id="hikersList" style="max-height: 500px; overflow-y: auto;">
                                <!-- Hikers list will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location History Table -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ri-route-line text-success me-2"></i>
                            Location Tracking History
                        </h5>
                        <div class="card-header-elements">
                            <select class="form-select" id="mountainFilter" style="width: 200px;">
                                <option value="">All Mountains</option>
                                <!-- Options will be loaded dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="locationTable">
                            <thead>
                                <tr>
                                    <th>Hiker</th>
                                    <th>Mountain</th>
                                    <th>Location</th>
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

                    <!-- No data message -->
                    <div id="noLocationData" class="text-center p-4" style="display: none;">
                        <p class="text-muted">No location data found.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hiker Detail Modal -->
        <div class="modal fade" id="hikerDetailModal" tabindex="-1" aria-labelledby="hikerDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hikerDetailModalLabel">Hiker Location Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="hikerDetails">
                            <!-- Details will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="exportTrackBtn">
                            <i class="ri-download-line me-1"></i>Export Track
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
    $(document).ready(function() {
        let map;
        let hikerMarkers = {};
        let refreshInterval;
        let currentHikerData = null;
        
        initializeMap();
        loadLocationStats();
        loadActiveHikers();
        loadHikersList();
        
        // Auto-refresh every 30 seconds
        refreshInterval = setInterval(function() {
            loadLocationStats();
            loadActiveHikers();
            loadHikersList();
        }, 30000);

        function initializeMap() {
            // Initialize Leaflet map centered on Indonesia
            map = L.map('hikersMap').setView([-7.797068, 110.370529], 7);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Custom marker icons
            window.hikerIcon = L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background: #28a745; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.4);"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });

            window.offlineHikerIcon = L.divIcon({
                className: 'custom-div-icon',
                html: '<div style="background: #dc3545; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 1px 3px rgba(0,0,0,0.4);"></div>',
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
        }

        function loadLocationStats() {
            $.ajax({
                url: '{{ route('location.stats') }}',
                type: 'GET',
                success: function(response) {
                    $('#totalActiveHikers').text(response.total_active);
                    $('#onlineHikers').text(response.online_hikers);
                    $('#offlineHikers').text(response.offline_hikers);
                    $('#activeMountains').text(response.hikers_by_mountain.length);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading location stats:', error);
                }
            });
        }

        function loadActiveHikers() {
            $.ajax({
                url: '{{ route('location.activeHikers') }}',
                type: 'GET',
                success: function(response) {
                    updateMapMarkers(response);
                    renderLocationTable(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading active hikers:', error);
                }
            });
        }

        function loadHikersList() {
            $.ajax({
                url: '{{ route('location.activeHikers') }}',
                type: 'GET',
                success: function(response) {
                    renderHikersList(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading hikers list:', error);
                }
            });
        }

        function updateMapMarkers(hikers) {
            // Clear existing markers
            Object.keys(hikerMarkers).forEach(function(bookingId) {
                map.removeLayer(hikerMarkers[bookingId]);
            });
            hikerMarkers = {};

            // Add new markers
            hikers.forEach(function(hiker) {
                if (hiker.latitude && hiker.longitude) {
                    let isOnline = hiker.last_location_update && 
                        new Date(hiker.last_location_update) > new Date(Date.now() - 30 * 60 * 1000);
                    
                    let marker = L.marker([hiker.latitude, hiker.longitude], {
                        icon: isOnline ? hikerIcon : offlineHikerIcon
                    }).addTo(map);

                    let popupContent = `
                        <div class="p-2">
                            <h6 class="mb-2"><strong>${hiker.user_name}</strong></h6>
                            <p class="mb-1"><i class="ri-mountain-line me-1"></i>${hiker.mountain_name}</p>
                            <p class="mb-1"><i class="ri-group-line me-1"></i>Team: ${hiker.team_size} people</p>
                            <p class="mb-1"><i class="ri-phone-line me-1"></i>${hiker.phone || 'N/A'}</p>
                            <small class="text-muted">
                                <i class="ri-time-line me-1"></i>
                                Last update: ${hiker.last_location_update ? 
                                    new Date(hiker.last_location_update).toLocaleString() : 'No recent data'}
                            </small>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-primary" onclick="viewHikerDetails(${hiker.booking_id})">
                                    View Details
                                </button>
                            </div>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    hikerMarkers[hiker.booking_id] = marker;
                }
            });
        }

        function renderLocationTable(hikers) {
            let html = '';
            
            if (hikers && hikers.length > 0) {
                hikers.forEach(function(hiker) {
                    let statusBadge = getLocationStatusBadge(hiker.last_location_update);
                    let coordinates = hiker.latitude && hiker.longitude ? 
                        `${parseFloat(hiker.latitude).toFixed(6)}, ${parseFloat(hiker.longitude).toFixed(6)}` : 
                        'No location data';
                    
                    html += `
                        <tr>
                            <td>
                                <i class="icon-base ri ri-user-3-line icon-22px text-info me-3"></i>
                                <div>
                                    <span class="fw-medium">${hiker.user_name}</span><br>
                                    <small class="text-muted">${hiker.email}</small>
                                </div>
                            </td>
                            <td>
                                <i class="icon-base ri ri-mountain-line icon-22px text-success me-2"></i>
                                ${hiker.mountain_name}
                            </td>
                            <td>
                                <div class="location-info">
                                    <span class="d-block">${coordinates}</span>
                                    ${hiker.latitude && hiker.longitude ? `
                                        <small class="text-muted">
                                            <a href="https://maps.google.com/?q=${hiker.latitude},${hiker.longitude}" target="_blank" class="text-decoration-none">
                                                <i class="ri-external-link-line me-1"></i>View on Map
                                            </a>
                                        </small>
                                    ` : ''}
                                </div>
                            </td>
                            <td>${statusBadge}</td>
                            <td>
                                <small class="text-muted">
                                    ${hiker.last_location_update ? 
                                        new Date(hiker.last_location_update).toLocaleString() : 
                                        'No recent data'}
                                </small>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                        <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="viewHikerDetails(${hiker.booking_id})">
                                            <i class="icon-base ri ri-eye-line icon-18px me-2"></i>
                                            View Details
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="showOnMap(${hiker.booking_id})">
                                            <i class="icon-base ri ri-map-pin-line icon-18px me-2"></i>
                                            Show on Map
                                        </a>
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="exportTrack(${hiker.booking_id})">
                                            <i class="icon-base ri ri-download-line icon-18px me-2"></i>
                                            Export Track
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                $('#noLocationData').hide();
            } else {
                $('#noLocationData').show();
            }
            
            $('#locationTable tbody').html(html);
        }

        function renderHikersList(hikers) {
            let html = '';
            
            if (hikers && hikers.length > 0) {
                hikers.forEach(function(hiker) {
                    let isOnline = hiker.last_location_update && 
                        new Date(hiker.last_location_update) > new Date(Date.now() - 30 * 60 * 1000);
                    let statusClass = isOnline ? 'success' : 'danger';
                    let statusIcon = isOnline ? 'ri-wifi-line' : 'ri-wifi-off-line';
                    let statusText = isOnline ? 'Online' : 'Offline';
                    
                    html += `
                        <div class="d-flex align-items-center p-3 border-bottom cursor-pointer hiker-item" 
                             onclick="focusHiker(${hiker.booking_id})" data-booking-id="${hiker.booking_id}">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="ri-user-3-line"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">${hiker.user_name}</h6>
                                <small class="text-muted">
                                    <i class="ri-mountain-line me-1"></i>${hiker.mountain_name}
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="ri-group-line me-1"></i>Team: ${hiker.team_size}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-label-${statusClass} mb-1">
                                    <i class="${statusIcon} me-1"></i>${statusText}
                                </span>
                                <br>
                                <small class="text-muted">
                                    ${hiker.last_location_update ? 
                                        new Date(hiker.last_location_update).toLocaleTimeString() : 
                                        'No data'}
                                </small>
                            </div>
                        </div>
                    `;
                });
            } else {
                html = `
                    <div class="text-center p-4">
                        <i class="ri-map-pin-line ri-48px text-muted mb-3"></i>
                        <p class="text-muted">No active hikers found</p>
                    </div>
                `;
            }
            
            $('#hikersList').html(html);
        }

        function getLocationStatusBadge(lastUpdate) {
            if (!lastUpdate) {
                return '<span class="badge bg-label-secondary">No Data</span>';
            }
            
            let now = new Date();
            let updateTime = new Date(lastUpdate);
            let diffMinutes = (now - updateTime) / (1000 * 60);
            
            if (diffMinutes <= 30) {
                return '<span class="badge bg-label-success">Online</span>';
            } else if (diffMinutes <= 60) {
                return '<span class="badge bg-label-warning">Recently Active</span>';
            } else {
                return '<span class="badge bg-label-danger">Offline</span>';
            }
        }

        window.viewHikerDetails = function(bookingId) {
            $.ajax({
                url: `/location/${bookingId}/history`,
                type: 'GET',
                success: function(response) {
                    currentHikerData = response;
                    renderHikerDetails(response);
                    $('#hikerDetailModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert('Error loading hiker details. Please try again.');
                }
            });
        };

        window.showOnMap = function(bookingId) {
            if (hikerMarkers[bookingId]) {
                let marker = hikerMarkers[bookingId];
                map.setView(marker.getLatLng(), 15);
                marker.openPopup();
            }
        };

        window.focusHiker = function(bookingId) {
            showOnMap(bookingId);
            
            // Highlight the hiker in the list
            $('.hiker-item').removeClass('bg-light');
            $(`.hiker-item[data-booking-id="${bookingId}"]`).addClass('bg-light');
        };

        window.exportTrack = function(bookingId) {
            window.open(`/location/${bookingId}/export`, '_blank');
        };

        window.refreshMap = function() {
            loadActiveHikers();
            loadHikersList();
        };

        window.centerMap = function() {
            if (Object.keys(hikerMarkers).length > 0) {
                let group = new L.featureGroup(Object.values(hikerMarkers));
                map.fitBounds(group.getBounds().pad(0.1));
            } else {
                map.setView([-7.797068, 110.370529], 7);
            }
        };

        function renderHikerDetails(data) {
            let detailsHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Hiker Information</h6>
                        <p><strong>Name:</strong> ${data.hiker_info.name}</p>
                        <p><strong>Mountain:</strong> ${data.hiker_info.mountain}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Location Statistics</h6>
                        <p><strong>Total Points:</strong> ${data.locations.length}</p>
                        <p><strong>Latest Update:</strong> ${data.locations.length > 0 ? 
                            new Date(data.locations[0].timestamp).toLocaleString() : 'No data'}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-muted">Recent Location History</h6>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
            `;
            
            data.locations.slice(0, 20).forEach(function(location) {
                detailsHtml += `
                    <tr>
                        <td><small>${new Date(location.timestamp).toLocaleString()}</small></td>
                        <td><small>${parseFloat(location.latitude).toFixed(6)}</small></td>
                        <td><small>${parseFloat(location.longitude).toFixed(6)}</small></td>
                        <td>
                            <a href="https://maps.google.com/?q=${location.latitude},${location.longitude}" 
                               target="_blank" class="btn btn-xs btn-outline-primary">
                                <i class="ri-external-link-line"></i>
                            </a>
                        </td>
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
            
            $('#hikerDetails').html(detailsHtml);
        }

        $('#exportTrackBtn').on('click', function() {
            if (currentHikerData && currentHikerData.locations.length > 0) {
                // This would trigger the export functionality
                let bookingId = currentHikerData.locations[0].booking_id;
                exportTrack(bookingId);
            }
        });

        // Add custom CSS for markers
        $('<style>')
            .prop('type', 'text/css')
            .html(`
                .hiker-item:hover {
                    background-color: #f8f9fa !important;
                }
                .cursor-pointer {
                    cursor: pointer;
                }
            `)
            .appendTo('head');

        // Clear interval when page is unloaded
        $(window).on('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    });
</script>
@endpush