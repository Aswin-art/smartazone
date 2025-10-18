@extends('Dashboard.layouts.app')

@section('content')
    <!-- ✅ Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Hero Section -->
            <div class="position-relative mb-4 rounded-3 overflow-hidden" style="height: 350px;">
                <img src="{{ $mountain->banner_image_url }}" alt="Banner"
                    style="width: 100%; height: 100%; object-fit: cover;">
                <div
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgba(0,0,0,0.4) 0%, transparent 60%);">
                </div>

                <div style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 2rem; color: white;">
                    <h2 style="font-size: 2.5rem; font-weight: 700;">{{ $mountain->name }}</h2>
                    <p style="font-size: 1.1rem;"><i class="bi bi-geo-alt-fill"></i> {{ $mountain->location }}</p>
                </div>

                <div style="position: absolute; top: 1.5rem; right: 1.5rem; display: flex; gap: 0.75rem;">
                    <a href="{{ route('superadmin.mountains.index') }}" class="btn btn-light"
                        style="border-radius: 12px; font-weight: 600;">
                        {{-- <i class="bi bi-arrow-left-circle"></i>  --}}
                        Kembali
                    </a>
                    <a href="{{ route('superadmin.mountains.edit', $mountain->id) }}" class="btn btn-primary"
                        style="border-radius: 12px; font-weight: 600; background: #696CFF; border: none;">
                        <i class="bi bi-pencil-square"></i>
                        <span class="ms-2">Edit Gunung</span>
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mb-4 g-3">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3"
                                style="width: 56px; height: 56px; margin: 0 auto; 
                        background: linear-gradient(135deg, #696CFF 0%, #8A92FF 100%);
                        border-radius: 12px; color: #fff; font-size: 28px;">
                                <i class="bi bi-tools"></i>
                            </div>
                            <h6 class="text-muted mb-2">Peminjaman Alat</h6>
                            <h3 class="fw-bold text-primary">{{ $stats['total_rentals'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3"
                                style="width: 56px; height: 56px; background: linear-gradient(135deg, #71DD37 0%, #84E647 100%);
                        border-radius: 12px; color: #fff; font-size: 28px;">
                                <i class="bi bi-signpost-split"></i>
                            </div>
                            <h6 class="text-muted mb-2">Total Pendakian</h6>
                            <h3 class="fw-bold" style="color: #71DD37;">{{ $stats['total_bookings'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3"
                                style="width: 56px; height: 56px; background: linear-gradient(135deg, #03C3EC 0%, #37EFFF 100%);
                        border-radius: 12px; color: #fff; font-size: 28px;">
                                <i class="bi bi-chat-square-quote"></i>
                            </div>
                            <h6 class="text-muted mb-2">Feedback</h6>
                            <h3 class="fw-bold" style="color: #03C3EC;">{{ $stats['total_feedback'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="card-body text-center p-4">
                            <div class="d-flex align-items-center justify-content-center mb-3"
                                style="width: 56px; height: 56px; background: linear-gradient(135deg, #FF3E1E 0%, #FF6B4A 100%);
                        border-radius: 12px; color: #fff; font-size: 28px;">
                                <i class="bi bi-exclamation-octagon"></i>
                            </div>
                            <h6 class="text-muted mb-2">Komplain</h6>
                            <h3 class="fw-bold" style="color: #FF3E1E;">{{ $stats['total_complaints'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-square bg-primary bg-gradient text-white me-3 rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-file-earmark-text fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Deskripsi</h5>
                    </div>
                    <p class="text-muted mb-0">{{ $mountain->description }}</p>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-square bg-primary bg-gradient text-white me-3 rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-info-circle fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Informasi Tambahan</h5>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-light p-3 rounded-3">
                                <p class="text-muted mb-1">ELEVASI</p>
                                <p class="fw-bold">{{ $mountain->meta['elevation'] ?? '-' }} m</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-light p-3 rounded-3">
                                <p class="text-muted mb-1">KESULITAN</p>
                                <p class="fw-bold">{{ ucfirst($mountain->meta['difficulty'] ?? '-') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-light p-3 rounded-3">
                                <p class="text-muted mb-1">DURASI ESTIMASI</p>
                                <p class="fw-bold">{{ $mountain->meta['estimated_duration'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="bg-light p-3 rounded-3">
                                <p class="text-muted mb-1">STATUS</p>
                                <span class="badge text-white"
                                    style="background: {{ $mountain->status === 'active' ? '#71DD37' : ($mountain->status === 'inactive' ? '#CCCCCC' : '#FFAB00') }};">
                                    {{ ucfirst($mountain->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Galeri -->
            @if (!empty($mountain->gallery))
                <div class="card border-0 shadow-sm mb-4 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-square bg-primary bg-gradient text-white me-3 rounded-3 d-flex align-items-center justify-content-center"
                                style="width: 48px; height: 48px; min-width: 48px;">
                                <i class="bi bi-images fs-5"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Galeri Gunung</h5>
                        </div>
                        <div class="d-grid gap-3" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));">
                            @foreach ($mountain->gallery as $img)
                                <div class="rounded-3 overflow-hidden shadow-sm" style="transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='scale(1.05)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                    <img src="{{ $img }}"
                                        style="width: 100%; height: 150px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Daftar Peralatan -->
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-square bg-primary bg-gradient text-white me-3 rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-hammer fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Daftar Peralatan</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th class="text-end">Harga (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($equipments as $eq)
                                    <tr>
                                        <td>{{ $eq->name }}</td>
                                        <td class="text-muted">{{ $eq->description }}</td>
                                        <td><span class="badge bg-light text-dark">{{ $eq->quantity }}</span></td>
                                        <td class="text-end fw-semibold">Rp {{ number_format($eq->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada peralatan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Feedback -->
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-square bg-info text-white rounded-3 me-3 rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-chat-heart fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Umpan Balik Pendaki</h5>
                    </div>

                    @forelse($feedbacks as $fb)
                        <div class="bg-light p-3 rounded-3 mb-3 border-start border-info border-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-info fw-semibold"><i class="bi bi-star-fill text-warning"></i>
                                    {{ $fb->rating }}/5</span>
                                <span
                                    class="text-muted small">{{ \Carbon\Carbon::parse($fb->created_at)->diffForHumans() }}</span>
                            </div>
                            <p class="text-muted mb-0">{{ $fb->comment }}</p>
                        </div>
                    @empty
                        <p class="text-center text-muted py-3">Belum ada feedback.</p>
                    @endforelse
                </div>
            </div>

            <!-- Komplain -->
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-square bg-danger text-white me-3 rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-exclamation-triangle fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Komplain / Insiden</h5>
                    </div>

                    @forelse($complaints as $c)
                        <div class="bg-light p-3 rounded-3 mb-3 border-start border-danger border-3">
                            <p class="fw-semibold mb-2">{{ $c->message }}</p>
                            @if ($c->image_url)
                                <img src="{{ $c->image_url }}" class="rounded mb-2" style="max-height: 150px;">
                            @endif
                            <span
                                class="text-muted small">{{ \Carbon\Carbon::parse($c->created_at)->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-center text-muted py-3">Tidak ada komplain tercatat.</p>
                    @endforelse
                </div>
            </div>

            <!-- Log Pendaki -->
            <div class="card border-0 shadow-sm mb-5 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-square bg-success text-white  me-3 rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 48px; height: 48px; min-width: 48px;">
                            <i class="bi bi-heart-pulse fs-5"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Log Pendaki (Aktivitas)</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Heart Rate</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hikerLogs as $log)
                                    <tr>
                                        <td>{{ $log->timestamp }}</td>
                                        <td><span class="badge bg-success">{{ $log->heart_rate }} bpm</span></td>
                                        <td>{{ $log->latitude }}</td>
                                        <td>{{ $log->longitude }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">Belum ada log aktivitas
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
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
    </div>
@endsection
