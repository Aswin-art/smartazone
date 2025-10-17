@extends('Dashboard.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <h5 class="mb-0">Manajemen Gunung</h5>
                        <div class="card-header-elements d-flex gap-2 flex-wrap">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Cari nama, lokasi, atau subdomain..." style="width: 300px;">
                            <select id="statusFilter" class="form-select" style="width: 150px;">
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>
                                <option value="pending">Pending</option>
                            </select>
                            <input type="date" id="dateFromFilter" class="form-control" style="width: 150px;">
                            <input type="date" id="dateToFilter" class="form-control" style="width: 150px;">
                            <button class="btn btn-secondary" id="resetFilters">Reset</button>
                        </div>
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table" id="mountainsTable">
                            <thead>
                                <tr>
                                    <th>Nama Gunung</th>
                                    <th>Lokasi</th>
                                    <th>Subdomain</th>
                                    <th>Status</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            </tbody>
                        </table>
                    </div>

                    <div id="loadingSpinner" class="text-center p-4" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <div id="noDataMessage" class="text-center p-4" style="display: none;">
                        <p class="text-muted">Tidak ada data gunung ditemukan.</p>
                    </div>

                    <div class="card-footer">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span id="tableInfo" class="text-muted">Menampilkan 0 hingga 0 dari 0 entri</span>
                            </div>
                            <div class="col-md-6">
                                <nav aria-label="Table pagination">
                                    <ul class="pagination justify-content-end mb-0" id="pagination"></ul>
                                </nav>
                            </div>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let itemsPerPage = 10;
            let searchTerm = '';
            let statusFilter = '';
            let dateFromFilter = '';
            let dateToFilter = '';
            let totalRecords = 0;

            loadMountains();

            let searchTimeout;
            $('#searchInput').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTerm = $(this).val();
                searchTimeout = setTimeout(function() {
                    currentPage = 1;
                    loadMountains();
                }, 500);
            });

            $('#statusFilter').on('change', function() {
                statusFilter = $(this).val();
                currentPage = 1;
                loadMountains();
            });

            $('#dateFromFilter').on('change', function() {
                dateFromFilter = $(this).val();
                currentPage = 1;
                loadMountains();
            });

            $('#dateToFilter').on('change', function() {
                dateToFilter = $(this).val();
                currentPage = 1;
                loadMountains();
            });

            $('#resetFilters').on('click', function() {
                $('#searchInput').val('');
                $('#statusFilter').val('');
                $('#dateFromFilter').val('');
                $('#dateToFilter').val('');
                searchTerm = '';
                statusFilter = '';
                dateFromFilter = '';
                dateToFilter = '';
                currentPage = 1;
                loadMountains();
            });

            function loadMountains() {
                showLoading();
                $.ajax({
                    url: '{{ route('superadmin.mountains.getData') }}',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        status: statusFilter,
                        dateFrom: dateFromFilter,
                        dateTo: dateToFilter,
                        start: (currentPage - 1) * itemsPerPage,
                        length: itemsPerPage,
                        order_column: 'created_at',
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
                            $('#mountainsTable tbody').empty();
                            $('#pagination').empty();
                            $('#tableInfo').text('Menampilkan 0 hingga 0 dari 0 entri');
                            $('#noDataMessage').show();
                        }
                    },
                    error: function() {
                        hideLoading();
                        alert('Error memuat data. Silakan coba lagi.');
                    }
                });
            }

            function renderTable(data) {
                let html = '';
                data.forEach(function(mountain) {
                    let statusBadge = getStatusBadge(mountain.status);
                    let joinDate = new Date(mountain.created_at).toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });

                    let showUrl = '{{ route('superadmin.mountains.show', ':id') }}'.replace(':id', mountain
                        .id);
                    let editUrl = '{{ route('superadmin.mountains.edit', ':id') }}'.replace(':id', mountain
                        .id);

                    html += `
                <tr>
                    <td>
                        <i class="bi bi-signpost-split text-success me-2"></i>
                        <span class="fw-semibold">${mountain.name}</span>
                    </td>
                    <td>${mountain.location}</td>
                    <td><span class="text-muted">${mountain.subdomains ?? '-'}</span></td>
                    <td>${statusBadge}</td>
                    <td>${joinDate}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="${showUrl}">
                                    <i class="bi bi-eye me-2 text-primary"></i>Lihat Detail
                                </a>
                                <a class="dropdown-item" href="${editUrl}">
                                    <i class="bi bi-pencil-square me-2 text-success"></i>Edit Data
                                </a>
                                ${mountain.status !== 'inactive' ? `
                                    <a class="dropdown-item text-warning" href="javascript:void(0);" onclick="deactivateMountain(${mountain.id})">
                                        <i class="bi bi-pause-circle me-2"></i>Nonaktifkan
                                    </a>` : ''}
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteMountain(${mountain.id})">
                                    <i class="bi bi-trash3 me-2"></i>Hapus
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                `;
                });
                $('#mountainsTable tbody').html(html);
            }

            function getStatusBadge(status) {
                let badgeClass = '',
                    badgeText = '';
                switch (status.toLowerCase()) {
                    case 'active':
                        badgeClass = 'bg-label-success';
                        badgeText = 'Aktif';
                        break;
                    case 'inactive':
                        badgeClass = 'bg-label-danger';
                        badgeText = 'Nonaktif';
                        break;
                    case 'pending':
                        badgeClass = 'bg-label-warning';
                        badgeText = 'Pending';
                        break;
                    default:
                        badgeClass = 'bg-label-secondary';
                        badgeText = status;
                }
                return `<span class="badge rounded-pill ${badgeClass}">${badgeText}</span>`;
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
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
            `;

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, startPage + 4);

                if (startPage > 1) {
                    html +=
                        `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(1)">1</a></li>`;
                    if (startPage > 2) html +=
                        `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                }

                for (let i = startPage; i <= endPage; i++) {
                    html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                            <a class="page-link" href="javascript:void(0);" onclick="changePage(${i})">${i}</a>
                        </li>`;
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) html +=
                        `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    html +=
                        `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="changePage(${totalPages})">${totalPages}</a></li>`;
                }

                html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="changePage(${currentPage + 1})">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>`;

                $('#pagination').html(html);
            }

            window.changePage = function(page) {
                if (page < 1 || page > Math.ceil(totalRecords / itemsPerPage)) return;
                currentPage = page;
                loadMountains();
            };

            function updateTableInfo() {
                const start = (currentPage - 1) * itemsPerPage + 1;
                const end = Math.min(currentPage * itemsPerPage, totalRecords);
                $('#tableInfo').text(`Menampilkan ${start} hingga ${end} dari ${totalRecords} entri`);
            }

            function showLoading() {
                $('#loadingSpinner').show();
                $('#mountainsTable tbody').empty();
                $('#noDataMessage').hide();
            }

            function hideLoading() {
                $('#loadingSpinner').hide();
            }

            window.deactivateMountain = function(mountainId) {
                if (confirm('Nonaktifkan gunung ini? Booking baru akan diblokir.')) {
                    let deactivateUrl = '{{ route('superadmin.mountains.deactivate', ':id') }}'.replace(':id',
                        mountainId);
                    $.ajax({
                        url: deactivateUrl,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            alert('Gunung berhasil dinonaktifkan');
                            loadMountains();
                        },
                        error: function() {
                            alert('Gagal menonaktifkan gunung.');
                        }
                    });
                }
            };

            window.deleteMountain = function(mountainId) {
                if (confirm('Apakah Anda yakin ingin menghapus gunung ini?')) {
                    let destroyUrl = '{{ route('superadmin.mountains.destroy', ':id') }}'.replace(':id',
                        mountainId);
                    $.ajax({
                        url: destroyUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            alert('Gunung berhasil dihapus');
                            loadMountains();
                        },
                        error: function() {
                            alert('Gagal menghapus gunung.');
                        }
                    });
                }
            };
        });
    </script>
@endpush
