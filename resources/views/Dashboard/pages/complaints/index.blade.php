@extends('Dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Statistics Cards -->
            <div class="row mb-4" id="statisticsCards">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="icon-base ri ri-file-list-3-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Pengaduan</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="totalComplaints">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="icon-base ri ri-notification-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Pengaduan Baru</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="newComplaints">0</h6>
                                    <small class="text-muted">(24 jam)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class="icon-base ri ri-error-warning-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Prioritas Tinggi</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="highPriority">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class="icon-base ri ri-time-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Pengaduan Lama</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="recentComplaints">0</h6>
                                    <small class="text-muted">(7 hari)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gy-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0">List Pengaduan</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#filterModal">
                                        <i class="icon-base ri ri-filter-3-line me-1"></i>Filter
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="exportComplaints()">
                                        <i class="icon-base ri ri-download-line me-1"></i>Export
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Filters -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari pengaduan...">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="quickMountainFilter">
                                    <option value="">Semua Gunung</option>
                                    @foreach ($mountains as $mountain)
                                        <option value="{{ $mountain->id }}">{{ $mountain->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="quickStatusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="new">Baru (24 jam)</option>
                                    <option value="recent">Terkini (7 hari)</option>
                                    <option value="old">Lama (>7 hari)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="quickPriorityFilter">
                                    <option value="">Semua Prioritas</option>
                                    <option value="high">Tinggi</option>
                                    <option value="medium">Sedang</option>
                                    <option value="low">Rendah</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                                    <i class="icon-base ri ri-refresh-line me-1"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table" id="complaintsTable">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Pendaki</th>
                                    <th>Gunung</th>
                                    <th>Pengaduan</th>
                                    <th>Prioritas</th>
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
                        <p class="text-muted">Tidak ada pengaduan ditemukan.</p>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span id="tableInfo" class="text-muted">Menampilkan 0 sampai 0 dari 0 entri</span>
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

        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="filterMountain" class="form-label">Gunung</label>
                                    <select class="form-select" id="filterMountain" name="mountain_id">
                                        <option value="">Semua Gunung</option>
                                        @foreach ($mountains as $mountain)
                                            <option value="{{ $mountain->id }}">{{ $mountain->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filterStatus" class="form-label">Status Berdasarkan Waktu</label>
                                    <select class="form-select" id="filterStatus" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="new">Baru (< 24 jam)</option>
                                        <option value="recent">Terkini (< 7 hari)</option>
                                        <option value="old">Lama (> 7 hari)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="dateFrom" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="dateFrom" name="date_from">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dateTo" class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="dateTo" name="date_to">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="applyFilters()">Terapkan Filter</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detailContent">
                            <!-- Detail content will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" onclick="markAsRead()">
                            <i class="icon-base ri ri-check-line me-1"></i>Tandai Dibaca
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Gambar Pengaduan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid" alt="Complaint Image">
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
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let itemsPerPage = 10;
            let searchTerm = '';
            let totalRecords = 0;
            let currentComplaintId = null;

            // Filter variables
            let filters = {
                mountain_id: '',
                status: '',
                date_from: '',
                date_to: '',
                priority: ''
            };

            // Load initial data
            loadComplaints();
            loadStatistics();

            // Search with debounce
            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTerm = $(this).val();
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    loadComplaints();
                }, 500);
            });

            // Quick filters
            $('#quickMountainFilter, #quickStatusFilter, #quickPriorityFilter').on('change', function() {
                updateQuickFilters();
                currentPage = 1;
                loadComplaints();
                loadStatistics();
            });

            function updateQuickFilters() {
                filters.mountain_id = $('#quickMountainFilter').val();
                filters.status = $('#quickStatusFilter').val();
                filters.priority = $('#quickPriorityFilter').val();
            }

            function loadComplaints() {
                showLoading();
                $.ajax({
                    url: '{{ route('complaints.data') }}',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        start: (currentPage - 1) * itemsPerPage,
                        length: itemsPerPage,
                        order_column: 'mc.created_at',
                        order_dir: 'desc',
                        ...filters
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
                            $('#complaintsTable tbody').empty();
                            $('#pagination').empty();
                            $('#tableInfo').text('Menampilkan 0 sampai 0 dari 0 entri');
                            $('#noDataMessage').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('Error loading complaints:', error);
                        alert('Error loading data. Silakan coba lagi.');
                    }
                });
            }

            function loadStatistics() {
                $.ajax({
                    url: '{{ route('complaints.statistics') }}',
                    type: 'GET',
                    data: filters,
                    success: function(response) {
                        $('#totalComplaints').text(response.total_complaints);
                        $('#newComplaints').text(response.new_complaints);
                        $('#recentComplaints').text(response.recent_complaints);
                        $('#highPriority').text(response.high_priority);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading statistics:', error);
                    }
                });
            }

            function renderTable(data) {
                let html = '';
                data.forEach(function(complaint) {
                    let priorityBadge = getPriorityBadge(complaint.priority_level);
                    let statusBadge = getStatusBadge(complaint.complaint_status);
                    let imageBadge = complaint.has_image ?
                        '<i class="icon-base ri ri-image-line text-info ms-2" title="Ada gambar"></i>' : '';

                    html += `
                <tr>
                    <td>
                        <div>
                            <span class="fw-medium">${complaint.formatted_date}</span>
                            <br>
                            <small class="text-muted">${complaint.relative_date}</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="icon-base ri ri-user-3-line icon-22px text-info me-3"></i>
                            <div>
                                <span class="fw-medium">${complaint.user_name}</span>
                                <br>
                                <small class="text-muted">${complaint.user_email}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="icon-base ri ri-mountain-line icon-22px text-success me-2"></i>
                            <div>
                                <span class="fw-medium">${complaint.mountain_name}</span>
                                <br>
                                <small class="text-muted">${complaint.mountain_location}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="complaint-message">
                            <p class="mb-1">${complaint.short_message}</p>
                            ${imageBadge}
                            <br>
                            <small class="text-muted">Booking: ${complaint.hike_date}</small>
                        </div>
                    </td>
                    <td>${priorityBadge}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="viewDetail(${complaint.complaint_id})">
                                    <i class="icon-base ri ri-eye-line icon-18px me-2"></i>
                                    Lihat Detail
                                </a>
                                ${complaint.has_image ? 
                                    '<a class="dropdown-item" href="javascript:void(0);" onclick="viewImage(\'' + complaint.image_url + '\')">' +
                                    '<i class="icon-base ri ri-image-line icon-18px me-2"></i>' +
                                    'Lihat Gambar' +
                                    '</a>' : ''
                                }
                                <a class="dropdown-item" href="javascript:void(0);" onclick="contactUser('${complaint.user_phone}')">
                                    <i class="icon-base ri ri-phone-line icon-18px me-2"></i>
                                    Hubungi Pendaki
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="markComplaintAsRead(${complaint.complaint_id})">
                                    <i class="icon-base ri ri-check-line icon-18px me-2"></i>
                                    Tandai Dibaca
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
                });
                $('#complaintsTable tbody').html(html);
            }

            function getPriorityBadge(priority) {
                let badgeClass = '';
                let priorityText = '';
                let icon = '';

                switch (priority) {
                    case 'high':
                        badgeClass = 'bg-label-danger';
                        priorityText = 'Tinggi';
                        icon = 'ri-error-warning-line';
                        break;
                    case 'medium':
                        badgeClass = 'bg-label-warning';
                        priorityText = 'Sedang';
                        icon = 'ri-alert-line';
                        break;
                    case 'low':
                        badgeClass = 'bg-label-info';
                        priorityText = 'Rendah';
                        icon = 'ri-information-line';
                        break;
                    default:
                        badgeClass = 'bg-label-secondary';
                        priorityText = 'Normal';
                        icon = 'ri-file-text-line';
                }

                return `<span class="badge rounded-pill ${badgeClass}">
                    <i class="icon-base ${icon} icon-12px me-1"></i>
                    ${priorityText}
                </span>`;
            }

            function getStatusBadge(status) {
                let badgeClass = '';
                let statusText = '';

                switch (status) {
                    case 'new':
                        badgeClass = 'bg-label-success';
                        statusText = 'Baru';
                        break;
                    case 'recent':
                        badgeClass = 'bg-label-warning';
                        statusText = 'Terkini';
                        break;
                    case 'old':
                        badgeClass = 'bg-label-secondary';
                        statusText = 'Lama';
                        break;
                    default:
                        badgeClass = 'bg-label-secondary';
                        statusText = 'Unknown';
                }

                return `<span class="badge rounded-pill ${badgeClass}">${statusText}</span>`;
            }

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
                    html +=
                        `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(1)">1</a></li>`;
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
                    html +=
                        `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
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
                loadComplaints();
            };

            function updateTableInfo() {
                const start = (currentPage - 1) * itemsPerPage + 1;
                const end = Math.min(currentPage * itemsPerPage, totalRecords);
                $('#tableInfo').text(`Menampilkan ${start} sampai ${end} dari ${totalRecords} entri`);
            }

            function showLoading() {
                $('#loadingSpinner').show();
                $('#complaintsTable tbody').empty();
                $('#noDataMessage').hide();
            }

            function hideLoading() {
                $('#loadingSpinner').hide();
            }

            // Modal and action functions
            window.viewDetail = function(complaintId) {
                currentComplaintId = complaintId;
                $.ajax({
                    url: '{{ route('complaints.detail', ':complaintId') }}'.replace(':complaintId',
                        complaintId),
                    type: 'GET',
                    success: function(response) {
                        renderDetailModal(response);
                        $('#detailModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        alert('Error loading detail. Silakan coba lagi.');
                    }
                });
            };

            window.viewImage = function(imageUrl) {
                $('#modalImage').attr('src', imageUrl);
                $('#imageModal').modal('show');
            };

            window.contactUser = function(phone) {
                if (phone) {
                    const whatsappUrl =
                        `https://wa.me/${phone.replace(/\D/g, '')}?text=Halo,%20kami%20dari%20Mountain%20Management%20System%20ingin%20merespon%20pengaduan%20Anda.`;
                    window.open(whatsappUrl, '_blank');
                } else {
                    alert('Nomor telepon tidak tersedia.');
                }
            };

            window.markComplaintAsRead = function(complaintId) {
                $.ajax({
                    url: '{{ route('complaints.mark-read', ':complaintId') }}'.replace(':complaintId',
                        complaintId),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Pengaduan ditandai sebagai dibaca.');
                        loadComplaints();
                        loadStatistics();
                    },
                    error: function(xhr, status, error) {
                        alert('Error marking as read. Silakan coba lagi.');
                    }
                });
            };

            window.markAsRead = function() {
                if (currentComplaintId) {
                    markComplaintAsRead(currentComplaintId);
                    $('#detailModal').modal('hide');
                }
            };

            // Filter functions
            window.applyFilters = function() {
                filters.mountain_id = $('#filterMountain').val();
                filters.status = $('#filterStatus').val();
                filters.date_from = $('#dateFrom').val();
                filters.date_to = $('#dateTo').val();

                // Update quick filters to match
                $('#quickMountainFilter').val(filters.mountain_id);
                $('#quickStatusFilter').val(filters.status);

                currentPage = 1;
                loadComplaints();
                loadStatistics();
                $('#filterModal').modal('hide');
            };

            window.clearFilters = function() {
                filters = {
                    mountain_id: '',
                    status: '',
                    date_from: '',
                    date_to: '',
                    priority: ''
                };

                // Clear all filter inputs
                $('#searchInput').val('');
                $('#quickMountainFilter').val('');
                $('#quickStatusFilter').val('');
                $('#quickPriorityFilter').val('');
                $('#filterMountain').val('');
                $('#filterStatus').val('');
                $('#dateFrom').val('');
                $('#dateTo').val('');

                searchTerm = '';
                currentPage = 1;
                loadComplaints();
                loadStatistics();
            };

            window.exportComplaints = function() {
                const params = new URLSearchParams({
                    ...filters
                });
                window.open(`{{ route('complaints.export') }}?${params.toString()}`, '_blank');
            };

            function renderDetailModal(data) {
                const complaint = data.complaint;
                const members = data.members || [];
                const relatedComplaints = data.related_complaints || [];

                let membersHtml = '';
                if (members.length > 0) {
                    members.forEach(function(member, index) {
                        membersHtml += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${member.name || '-'}</td>
                        <td>${member.nik || '-'}</td>
                        <td>${member.phone || '-'}</td>
                    </tr>
                `;
                    });
                }

                let relatedHtml = '';
                if (relatedComplaints.length > 0) {
                    relatedComplaints.forEach(function(related) {
                        const relatedDate = new Date(related.created_at).toLocaleDateString('id-ID');
                        const shortMessage = related.message.length > 50 ?
                            related.message.substring(0, 50) + '...' : related.message;
                        relatedHtml += `
                    <tr>
                        <td>${relatedDate}</td>
                        <td>${related.mountain_name}</td>
                        <td>${shortMessage}</td>
                    </tr>
                `;
                    });
                }

                const detailHtml = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informasi Pendaki</h6>
                    <table class="table table-borderless">
                        <tr><td class="fw-medium">Nama:</td><td>${complaint.user_name}</td></tr>
                        <tr><td class="fw-medium">Email:</td><td>${complaint.user_email}</td></tr>
                        <tr><td class="fw-medium">Telepon:</td><td>${complaint.user_phone || '-'}</td></tr>
                        <tr><td class="fw-medium">Kontak Darurat:</td><td>${complaint.emergency_contact || '-'}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Informasi Pendakian</h6>
                    <table class="table table-borderless">
                        <tr><td class="fw-medium">Gunung:</td><td>${complaint.mountain_name}</td></tr>
                        <tr><td class="fw-medium">Lokasi:</td><td>${complaint.mountain_location}</td></tr>
                        <tr><td class="fw-medium">Tanggal Pendakian:</td><td>${complaint.hike_date || '-'}</td></tr>
                        <tr><td class="fw-medium">Status Booking:</td><td><span class="badge bg-label-info">${complaint.booking_status}</span></td></tr>
                        <tr><td class="fw-medium">Jumlah Tim:</td><td>${complaint.team_size} orang</td></tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h6>Detail Pengaduan</h6>
                    <div class="card bg-label-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-label-primary">${new Date(complaint.created_at).toLocaleDateString('id-ID', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}</span>
                                </div>
                            </div>
                            <p class="mb-0">${complaint.message}</p>
                            ${complaint.image_url ? 
                                '<div class="mt-3">' +
                                '<img src="' + complaint.image_url + '" class="img-fluid rounded" alt="Complaint Image" style="max-height: 300px;" onclick="viewImage(\'' + complaint.image_url + '\')">' +
                                '</div>' : ''
                            }
                        </div>
                    </div>
                </div>
            </div>

            ${membersHtml ? `
                    <div class="mt-4">
                        <h6>Anggota Tim</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Telepon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${membersHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    ` : ''}

            ${relatedHtml ? `
                    <div class="mt-4">
                        <h6>Pengaduan Terkait dari Pendaki yang Sama</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Gunung</th>
                                        <th>Pengaduan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${relatedHtml}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    ` : ''}
        `;

                $('#detailContent').html(detailHtml);
            }
        });
    </script>
@endpush
