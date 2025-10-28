@extends('dashboard.layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
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
                                    <i class="icon-base ri ri-hand-coin-line icon-24px"></i>
                                </span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Total Biaya Sewa (Rp)</small>
                                <h6 class="mb-0" id="totalRentalCost">0</h6>
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
                                    <button type="button" class="btn btn-outline-info"
                                        onclick="showEquipmentAvailability()">
                                        <i class="icon-base ri ri-database-2-line me-1"></i>Stok Alat
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                        data-bs-target="#filterModal">
                                        <i class="icon-base ri ri-filter-3-line me-1"></i>Filter
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Filters -->
                        <div class="row mt-3 g-2">
                            <div class="col-12 col-md-4 col-lg-3">
                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="Cari peminjaman...">
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <select class="form-select" id="quickEquipmentFilter">
                                    <option value="">Semua Alat</option>
                                    @foreach ($equipments as $equipment)
                                        <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3">
                                <select class="form-select" id="quickStatusFilter">
                                    <option value="">Semua Status</option>
                                    <option value="borrowed">Dipinjam</option>
                                    <option value="returned">Dikembalikan</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <button type="button" class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                                    <i class="icon-base ri ri-refresh-line me-1"></i>
                                    <span class="d-none d-sm-inline">Reset</span>
                                    <span class="d-inline d-sm-none">Reset Filter</span>
                                </button>
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
                                    <th>Total Biaya</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
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
                                    <label for="filterStatus" class="form-label">Status</label>
                                    <select class="form-select" id="filterStatus" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="borrowed">Dipinjam</option>
                                        <option value="returned">Dikembalikan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="filterEquipment" class="form-label">Alat</label>
                                    <select class="form-select" id="filterEquipment" name="equipment_id">
                                        <option value="">Semua Alat</option>
                                        @foreach ($equipments as $equipment)
                                            <option value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                        @endforeach
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
                        <button type="button" class="btn btn-outline-warning" id="updateStatusBtn"
                            onclick="updateRentalStatus()">
                            <i class="icon-base ri ri-refresh-line me-1"></i>Ubah Status
                        </button>
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
                        <button type="button" class="btn btn-primary" onclick="confirmStatusUpdate()">Ubah
                            Status</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal CRUD & Stok Alat -->
        <div class="modal fade" id="availabilityModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ketersediaan & Manajemen Alat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between mb-3">
                            <input type="text" id="equipmentSearch" class="form-control w-50"
                                placeholder="Cari alat...">
                            <button class="btn btn-primary" onclick="openAddEquipmentModal()"><i
                                    class="ri-add-line me-1"></i>Tambah Alat</button>
                        </div>
                        <div id="availabilityContent"></div>
                    </div>
                    <div class="modal-footer"><button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah/Edit Alat -->
        <div class="modal fade" id="equipmentFormModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="equipmentFormTitle">Tambah Alat</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="equipmentForm">
                            <input type="hidden" id="equipmentId">
                            <div class="mb-3">
                                <label class="form-label">Nama Alat</label>
                                <input type="text" id="equipmentName" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Stok</label>
                                <input type="number" id="equipmentQuantity" class="form-control" min="0"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Biaya Sewa (per unit/hari)</label>
                                <input type="number" id="equipmentPrice" class="form-control" min="0"
                                    step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea id="equipmentDescription" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" id="saveEquipmentBtn" onclick="saveEquipment()">Simpan</button>
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
    @include('dashboard.pages.equipment-rentals.js.script')
@endpush
