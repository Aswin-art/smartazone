@extends('dashboard.layouts.app')
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
                                    <i class="icon-base ri ri-tools-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Peminjaman</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="totalRentals">0</h6>
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
                                    <i class="icon-base ri ri-hand-coin-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sedang Dipinjam</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="borrowedCount">0</h6>
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
                                    <i class="icon-base ri ri-check-double-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sudah Dikembalikan</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="returnedCount">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-danger">
                                    <i class="icon-base ri ri-error-warning-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Terlambat</small>
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-1" id="overdueCount">0</h6>
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
                                <h5 class="mb-0">List Peminjaman Alat</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-outline-info" onclick="showEquipmentAvailability()">
                                        <i class="icon-base ri ri-database-2-line me-1"></i>Stok Alat
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
                                        <i class="icon-base ri ri-filter-3-line me-1"></i>Filter
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick="exportRentals()">
                                        <i class="icon-base ri ri-download-line me-1"></i>Export
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Filters -->
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari peminjaman...">
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="quickMountainFilter">
                                    <option value="">Semua Gunung</option>
                                    @foreach($mountains as $mountain)
                                        <option value="{{ $mountain->id }}">{{ $mountain->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="quickEquipmentFilter">
                                    <option value="">Semua Alat</option>
                                    @foreach($equipments as $equipment)
                                        <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-select" id="quickStatusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="borrowed">Dipinjam</option>
                                    <option value="returned">Dikembalikan</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                                    <i class="icon-base ri ri-refresh-line me-1"></i>Reset
                                </button>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="showOverdueOnly">
                                    <label class="form-check-label" for="showOverdueOnly">
                                        Hanya terlambat
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table" id="rentalsTable">
                            <thead>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <th>Nama Pendaki</th>
                                    <th>Gunung</th>
                                    <th>Alat yang Dipinjam</th>
                                    <th>Jumlah</th>
                                    <th>Durasi</th>
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
                        <p class="text-muted">Tidak ada peminjaman ditemukan.</p>
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
                        <h5 class="modal-title" id="filterModalLabel">Filter Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="filterMountain" class="form-label">Gunung</label>
                                    <select class="form-select" id="filterMountain" name="mountain_id">
                                        <option value="">Semua Gunung</option>
                                        @foreach($mountains as $mountain)
                                            <option value="{{ $mountain->id }}">{{ $mountain->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filterEquipment" class="form-label">Alat</label>
                                    <select class="form-select" id="filterEquipment" name="equipment_id">
                                        <option value="">Semua Alat</option>
                                        @foreach($equipments as $equipment)
                                            <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="filterStatus" class="form-label">Status</label>
                                    <select class="form-select" id="filterStatus" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="borrowed">Dipinjam</option>
                                        <option value="returned">Dikembalikan</option>
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
                        <h5 class="modal-title" id="detailModalLabel">Detail Peminjaman Alat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detailContent">
                            <!-- Detail content will be loaded here -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" id="updateStatusBtn" onclick="updateRentalStatus()">
                            <i class="icon-base ri ri-refresh-line me-1"></i>Ubah Status
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Availability Modal -->
        <div class="modal fade" id="availabilityModal" tabindex="-1" aria-labelledby="availabilityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="availabilityModalLabel">Ketersediaan Alat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="availabilityMountain" class="form-label">Pilih Gunung</label>
                            <select class="form-select" id="availabilityMountain">
                                <option value="">Pilih gunung...</option>
                                @foreach($mountains as $mountain)
                                    <option value="{{ $mountain->id }}">{{ $mountain->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="availabilityContent">
                            <p class="text-muted text-center">Pilih gunung untuk melihat ketersediaan alat</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Update Modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Ubah Status Peminjaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="statusForm">
                            <div class="mb-3">
                                <label for="newStatus" class="form-label">Status Baru</label>
                                <select class="form-select" id="newStatus" name="status" required>
                                    <option value="">Pilih status...</option>
                                    <option value="borrowed">Dipinjam</option>
                                    <option value="returned">Dikembalikan</option>
                                </select>
                            </div>
                            <div class="alert alert-info">
                                <i class="icon-base ri ri-information-line me-2"></i>
                                Pastikan status yang dipilih sesuai dengan kondisi aktual alat.
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="confirmStatusUpdate()">Ubah Status</button>
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
            let currentRentalId = null;
            let showOverdueOnly = false;

            // Filter variables
            let filters = {
                mountain_id: '',
                equipment_id: '',
                status: '',
                date_from: '',
                date_to: ''
            };

            // Load initial data
            loadRentals();
            loadStatistics();

            // Search with debounce
            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTerm = $(this).val();
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    loadRentals();
                }, 500);
            });

            // Quick filters
            $('#quickMountainFilter, #quickEquipmentFilter, #quickStatusFilter').on('change', function() {
                updateQuickFilters();
                currentPage = 1;
                loadRentals();
                loadStatistics();
            });

            // Overdue only checkbox
            $('#showOverdueOnly').on('change', function() {
                showOverdueOnly = $(this).is(':checked');
                currentPage = 1;
                loadRentals();
            });

            // Equipment availability mountain selector
            $('#availabilityMountain').on('change', function() {
                loadEquipmentAvailability($(this).val());
            });

            function updateQuickFilters() {
                filters.mountain_id = $('#quickMountainFilter').val();
                filters.equipment_id = $('#quickEquipmentFilter').val();
                filters.status = $('#quickStatusFilter').val();
            }

            function loadRentals() {
                showLoading();
                $.ajax({
                    url: '{{ route('equipment-rentals.data') }}',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        start: (currentPage - 1) * itemsPerPage,
                        length: itemsPerPage,
                        order_column: 'mer.created_at',
                        order_dir: 'desc',
                        show_overdue_only: showOverdueOnly,
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
                            $('#rentalsTable tbody').empty();
                            $('#pagination').empty();
                            $('#tableInfo').text('Menampilkan 0 sampai 0 dari 0 entri');
                            $('#noDataMessage').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('Error loading rentals:', error);
                        alert('Error loading data. Silakan coba lagi.');
                    }
                });
            }

            function loadStatistics() {
                $.ajax({
                    url: '{{ route('equipment-rentals.statistics') }}',
                    type: 'GET',
                    data: filters,
                    success: function(response) {
                        $('#totalRentals').text(response.total_rentals);
                        $('#borrowedCount').text(response.borrowed_count);
                        $('#returnedCount').text(response.returned_count);
                        $('#overdueCount').text(response.overdue_count);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading statistics:', error);
                    }
                });
            }

            function renderTable(data) {
                let html = '';
                data.forEach(function(rental) {
                    let statusBadge = getStatusBadge(rental.rental_status, rental.is_overdue);
                    let overdueBadge = rental.is_overdue ? 
                        `<br><small class="badge bg-danger">Terlambat ${rental.overdue_days} hari</small>` : '';
                    let equipmentImage = rental.has_image ? 
                        `<img src="${rental.equipment_image}" class="rounded me-2" style="width: 32px; height: 32px; object-fit: cover;" alt="${rental.equipment_name}">` : 
                        '<i class="icon-base ri ri-tools-line icon-22px text-primary me-2"></i>';
                    
                    html += `
                <tr ${rental.is_overdue ? 'class="table-warning"' : ''}>
                    <td>
                        <div>
                            <span class="fw-medium">${rental.formatted_rental_date}</span>
                            <br>
                            <small class="text-muted">Booking: ${rental.hike_date}</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="icon-base ri ri-user-3-line icon-22px text-info me-3"></i>
                            <div>
                                <span class="fw-medium">${rental.user_name}</span>
                                <br>
                                <small class="text-muted">${rental.user_email}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="icon-base ri ri-mountain-line icon-22px text-success me-2"></i>
                            <div>
                                <span class="fw-medium">${rental.mountain_name}</span>
                                <br>
                                <small class="text-muted">${rental.mountain_location}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            ${equipmentImage}
                            <div>
                                <span class="fw-medium">${rental.equipment_name}</span>
                                ${rental.equipment_description ? '<br><small class="text-muted">' + rental.equipment_description + '</small>' : ''}
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-info">${rental.rental_quantity} pcs</span>
                    </td>
                    <td>
                        <div>
                            <span class="fw-medium">${rental.rental_duration_days} hari</span>
                            <br>
                            <small class="text-muted">s/d ${rental.return_date}</small>
                        </div>
                    </td>
                    <td>${statusBadge}${overdueBadge}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);" onclick="viewDetail(${rental.rental_id})">
                                    <i class="icon-base ri ri-eye-line icon-18px me-2"></i>
                                    Lihat Detail
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="openStatusModal(${rental.rental_id}, '${rental.rental_status}')">
                                    <i class="icon-base ri ri-refresh-line icon-18px me-2"></i>
                                    Ubah Status
                                </a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="contactUser('${rental.user_phone}')">
                                    <i class="icon-base ri ri-phone-line icon-18px me-2"></i>
                                    Hubungi Pendaki
                                </a>
                                ${rental.is_overdue ? 
                                    '<div class="dropdown-divider"></div>' +
                                    '<a class="dropdown-item text-danger" href="javascript:void(0);" onclick="sendOverdueReminder(' + rental.rental_id + ')">' +
                                    '<i class="icon-base ri ri-alarm-warning-line icon-18px me-2"></i>' +
                                    'Kirim Peringatan' +
                                    '</a>' : ''
                                }
                            </div>
                        </div>
                    </td>
                </tr>
            `;
                });
                $('#rentalsTable tbody').html(html);
            }

            function getStatusBadge(status, isOverdue) {
                let badgeClass = '';
                let statusText = '';
                let icon = '';
                
                if (isOverdue && status === 'borrowed') {
                    badgeClass = 'bg-label-danger';
                    statusText = 'Dipinjam (Terlambat)';
                    icon = 'ri-error-warning-line';
                } else {
                    switch (status) {
                        case 'borrowed':
                            badgeClass = 'bg-label-warning';
                            statusText = 'Dipinjam';
                            icon = 'ri-hand-coin-line';
                            break;
                        case 'returned':
                            badgeClass = 'bg-label-success';
                            statusText = 'Dikembalikan';
                            icon = 'ri-check-double-line';
                            break;
                        default:
                            badgeClass = 'bg-label-secondary';
                            statusText = 'Unknown';
                            icon = 'ri-question-line';
                    }
                }
                
                return `<span class="badge rounded-pill ${badgeClass}">
                    <i class="icon-base ${icon} icon-12px me-1"></i>
                    ${statusText}
                </span>`;
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
                loadRentals();
            };

            function updateTableInfo() {
                const start = (currentPage - 1) * itemsPerPage + 1;
                const end = Math.min(currentPage * itemsPerPage, totalRecords);
                $('#tableInfo').text(`Menampilkan ${start} sampai ${end} dari ${totalRecords} entri`);
            }

            function showLoading() {
                $('#loadingSpinner').show();
                $('#rentalsTable tbody').empty();
                $('#noDataMessage').hide();
            }

            function hideLoading() {
                $('#loadingSpinner').hide();
            }

            // Modal and action functions
            window.viewDetail = function(rentalId) {
                currentRentalId = rentalId;
                $.ajax({
                    url: '{{ route('equipment-rentals.detail', ':rentalId') }}'.replace(':rentalId', rentalId),
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

            window.contactUser = function(phone) {
                if (phone) {
                    const whatsappUrl = `https://wa.me/${phone.replace(/\D/g, '')}?text=Halo,%20kami%20dari%20Mountain%20Management%20System%20mengenai%20peminjaman%20alat%20Anda.`;
                    window.open(whatsappUrl, '_blank');
                } else {
                    alert('Nomor telepon tidak tersedia.');
                }
            };

            window.openStatusModal = function(rentalId, currentStatus) {
                currentRentalId = rentalId;
                $('#newStatus').val(currentStatus);
                $('#statusModal').modal('show');
            };

            window.confirmStatusUpdate = function() {
                const newStatus = $('#newStatus').val();
                if (!newStatus) {
                    alert('Pilih status terlebih dahulu.');
                    return;
                }

                $.ajax({
                    url: '{{ route('equipment-rentals.update-status', ':rentalId') }}'.replace(':rentalId', currentRentalId),
                    type: 'POST',
                    data: {
                        status: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#statusModal').modal('hide');
                        loadRentals();
                        loadStatistics();
                    },
                    error: function(xhr, status, error) {
                        alert('Error updating status. Silakan coba lagi.');
                    }
                });
            };

            window.sendOverdueReminder = function(rentalId) {
                if (confirm('Kirim peringatan keterlambatan ke pendaki?')) {
                    // This would typically integrate with SMS/Email service
                    alert('Peringatan telah dikirim ke pendaki.');
                }
            };

            window.showEquipmentAvailability = function() {
                $('#availabilityModal').modal('show');
            };

            function loadEquipmentAvailability(mountainId) {
                if (!mountainId) {
                    $('#availabilityContent').html('<p class="text-muted text-center">Pilih gunung untuk melihat ketersediaan alat</p>');
                    return;
                }

                $.ajax({
                    url: '{{ route('equipment-rentals.equipment-availability') }}',
                    type: 'GET',
                    data: { mountain_id: mountainId },
                    success: function(response) {
                        renderAvailabilityTable(response.equipments);
                    },
                    error: function(xhr, status, error) {
                        $('#availabilityContent').html('<p class="text-danger text-center">Error loading data</p>');
                    }
                });
            }

            function renderAvailabilityTable(equipments) {
                if (equipments.length === 0) {
                    $('#availabilityContent').html('<p class="text-muted text-center">Tidak ada alat tersedia</p>');
                    return;
                }

                let html = `
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Alat</th>
                            <th>Total Stok</th>
                            <th>Dipinjam</th>
                            <th>Tersedia</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

                equipments.forEach(function(equipment) {
                    const availabilityPercentage = (equipment.available_quantity / equipment.total_quantity) * 100;
                    let statusBadge = '';
                    
                    if (availabilityPercentage > 50) {
                        statusBadge = '<span class="badge bg-success">Tersedia</span>';
                    } else if (availabilityPercentage > 20) {
                        statusBadge = '<span class="badge bg-warning">Terbatas</span>';
                    } else if (availabilityPercentage > 0) {
                        statusBadge = '<span class="badge bg-danger">Hampir Habis</span>';
                    } else {
                        statusBadge = '<span class="badge bg-secondary">Habis</span>';
                    }

                    html += `
                <tr>
                    <td>${equipment.name}</td>
                    <td>${equipment.total_quantity}</td>
                    <td>${equipment.borrowed_quantity}</td>
                    <td><strong>${equipment.available_quantity}</strong></td>
                    <td>${statusBadge}</td>
                </tr>
            `;
                });

                html += `
                    </tbody>
                </table>
            </div>
        `;

                $('#availabilityContent').html(html);
            }

            // Filter functions
            window.applyFilters = function() {
                filters.mountain_id = $('#filterMountain').val();
                filters.equipment_id = $('#filterEquipment').val();
                filters.status = $('#filterStatus').val();
                filters.date_from = $('#dateFrom').val();
                filters.date_to = $('#dateTo').val();
                
                // Update quick filters to match
                $('#quickMountainFilter').val(filters.mountain_id);
                $('#quickEquipmentFilter').val(filters.equipment_id);
                $('#quickStatusFilter').val(filters.status);
                
                currentPage = 1;
                loadRentals();
                loadStatistics();
                $('#filterModal').modal('hide');
            };

            window.clearFilters = function() {
                filters = {
                    mountain_id: '',
                    equipment_id: '',
                    status: '',
                    date_from: '',
                    date_to: ''
                };
                
                // Clear all filter inputs
                $('#searchInput').val('');
                $('#quickMountainFilter').val('');
                $('#quickEquipmentFilter').val('');
                $('#quickStatusFilter').val('');
                $('#showOverdueOnly').prop('checked', false);
                $('#filterMountain').val('');
                $('#filterEquipment').val('');
                $('#filterStatus').val('');
                $('#dateFrom').val('');
                $('#dateTo').val('');
                
                searchTerm = '';
                showOverdueOnly = false;
                currentPage = 1;
                loadRentals();
                loadStatistics();
            };

            window.exportRentals = function() {
                const params = new URLSearchParams({
                    ...filters
                });
                window.open(`{{ route('equipment-rentals.export') }}?${params.toString()}`, '_blank');
            };

            window.updateRentalStatus = function() {
                if (currentRentalId) {
                    $('#statusModal').modal('show');
                }
            };

            function renderDetailModal(data) {
                const rental = data.rental;
                const otherRentals = data.other_rentals || [];
                const members = data.members || [];
                const rentalHistory = data.rental_history || [];

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

                let otherRentalsHtml = '';
                if (otherRentals.length > 0) {
                    otherRentals.forEach(function(other) {
                        const statusBadge = other.status === 'returned' ? 
                            '<span class="badge bg-success">Dikembalikan</span>' : 
                            '<span class="badge bg-warning">Dipinjam</span>';
                        
                        otherRentalsHtml += `
                    <tr>
                        <td>${other.equipment_name}</td>
                        <td>${other.quantity}</td>
                        <td>${statusBadge}</td>
                        <td>${other.description || '-'}</td>
                    </tr>
                `;
                    });
                }

                let historyHtml = '';
                if (rentalHistory.length > 0) {
                    rentalHistory.forEach(function(history) {
                        const historyDate = new Date(history.created_at).toLocaleDateString('id-ID');
                        const statusBadge = history.status === 'returned' ? 
                            '<span class="badge bg-success">Dikembalikan</span>' : 
                            '<span class="badge bg-warning">Dipinjam</span>';
                        
                        historyHtml += `
                    <tr>
                        <td>${historyDate}</td>
                        <td>${history.mountain_name}</td>
                        <td>${history.equipment_name}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `;
                    });
                }

                // Calculate rental duration
                const rentalDate = new Date(rental.created_at);
                const hikeDate = new Date(rental.hike_date);
                const returnDate = rental.return_date ? new Date(rental.return_date) : null;
                const today = new Date();

                let durationText = '';
                let overdueText = '';
                
                if (returnDate) {
                    const diffTime = returnDate - hikeDate;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    durationText = `${diffDays} hari`;
                    
                    if (rental.status === 'borrowed' && today > returnDate) {
                        const overdueDays = Math.ceil((today - returnDate) / (1000 * 60 * 60 * 24));
                        overdueText = `<div class="alert alert-danger mt-2">
                            <i class="icon-base ri ri-error-warning-line me-2"></i>
                            Terlambat ${overdueDays} hari dari tanggal kembali
                        </div>`;
                    }
                }

                const detailHtml = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informasi Pendaki</h6>
                    <table class="table table-borderless">
                        <tr><td class="fw-medium">Nama:</td><td>${rental.user_name}</td></tr>
                        <tr><td class="fw-medium">Email:</td><td>${rental.user_email}</td></tr>
                        <tr><td class="fw-medium">Telepon:</td><td>${rental.user_phone || '-'}</td></tr>
                        <tr><td class="fw-medium">Kontak Darurat:</td><td>${rental.emergency_contact || '-'}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Informasi Pendakian</h6>
                    <table class="table table-borderless">
                        <tr><td class="fw-medium">Gunung:</td><td>${rental.mountain_name}</td></tr>
                        <tr><td class="fw-medium">Lokasi:</td><td>${rental.mountain_location}</td></tr>
                        <tr><td class="fw-medium">Tanggal Pendakian:</td><td>${rental.hike_date || '-'}</td></tr>
                        <tr><td class="fw-medium">Tanggal Kembali:</td><td>${rental.return_date || '-'}</td></tr>
                        <tr><td class="fw-medium">Jumlah Tim:</td><td>${rental.team_size} orang</td></tr>
                    </table>
                </div>
            </div>

            ${overdueText}

            <div class="row mt-4">
                <div class="col-12">
                    <h6>Detail Alat yang Dipinjam</h6>
                    <div class="card bg-label-light">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    ${rental.equipment_image ? 
                                        '<img src="' + rental.equipment_image + '" class="img-fluid rounded" alt="' + rental.equipment_name + '">' : 
                                        '<div class="text-center p-3 bg-label-secondary rounded"><i class="icon-base ri ri-tools-line icon-48px"></i></div>'
                                    }
                                </div>
                                <div class="col-md-10">
                                    <h5 class="mb-2">${rental.equipment_name}</h5>
                                    <p class="mb-2">${rental.equipment_description || 'Tidak ada deskripsi'}</p>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <small class="text-muted">Jumlah Dipinjam</small>
                                            <h6>${rental.quantity} pcs</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted">Total Stok</small>
                                            <h6>${rental.equipment_total_quantity} pcs</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted">Durasi</small>
                                            <h6>${durationText}</h6>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted">Status</small>
                                            <h6>${rental.status === 'returned' ? 
                                                '<span class="badge bg-success">Dikembalikan</span>' : 
                                                '<span class="badge bg-warning">Dipinjam</span>'
                                            }</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-label-info">
                                <div class="card-body text-center">
                                    <i class="icon-base ri ri-calendar-line icon-32px mb-2"></i>
                                    <h6 class="mb-1">Tanggal Pinjam</h6>
                                    <small>${new Date(rental.created_at).toLocaleDateString('id-ID', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric'
                                    })}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-label-success">
                                <div class="card-body text-center">
                                    <i class="icon-base ri ri-login-box-line icon-32px mb-2"></i>
                                    <h6 class="mb-1">Check-in</h6>
                                    <small>${rental.checkin_time || 'Belum check-in'}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-label-primary">
                                <div class="card-body text-center">
                                    <i class="icon-base ri ri-logout-box-line icon-32px mb-2"></i>
                                    <h6 class="mb-1">Check-out</h6>
                                    <small>${rental.checkout_time || 'Belum check-out'}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-label-warning">
                                <div class="card-body text-center">
                                    <i class="icon-base ri ri-bookmark-line icon-32px mb-2"></i>
                                    <h6 class="mb-1">Status Booking</h6>
                                    <small>${rental.booking_status}</small>
                                </div>
                            </div>
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

            ${otherRentalsHtml ? `
            <div class="mt-4">
                <h6>Alat Lain yang Dipinjam dalam Booking yang Sama</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Alat</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${otherRentalsHtml}
                        </tbody>
                    </table>
                </div>
            </div>
            ` : ''}

            ${historyHtml ? `
            <div class="mt-4">
                <h6>Riwayat Peminjaman Pendaki</h6>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Gunung</th>
                                <th>Alat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${historyHtml}
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