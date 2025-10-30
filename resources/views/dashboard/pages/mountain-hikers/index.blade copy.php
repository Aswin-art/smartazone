@extends('dashboard.layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pendaki Aktif</h5>
                <button class="btn btn-sm btn-primary" id="refreshList"><i class="ri-refresh-line me-1"></i> Refresh</button>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="hikerTable">
                    <thead>
                        <tr>
                            <th>Nama Pendaki</th>
                            <th>Telepon</th>
                            <th>Periode Pendakian</th>
                            <th>Jumlah Tim</th>
                            <th>Koordinat Terakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mapModalLabel">Lokasi Pendaki</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="mapContainer" style="width:100%;height:500px;overflow:hidden;border-radius:10px;">
                            <div id="hikerMap" style="width:100%;height:100%;"></div>
                        </div>
                        <div class="p-3" id="logDetails"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
#mapModal .modal-body {
    padding: 0 !important;
}
.leaflet-container {
    width: 100% !important;
    height: 100% !important;
}
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
$(document).ready(function() {
    let logsCache = {}
    let activeBookingId = null
    let mapInstance = null

    function loadHikers() {
        $('#hikerTable tbody').html('<tr><td colspan="6" class="text-center text-muted p-3">Loading...</td></tr>')
        $.ajax({
            url: '{{ route('mountain_hikers.list') }}',
            method: 'GET',
            success: function(res) {
                const hikers = res.data || []
                if (hikers.length === 0) {
                    $('#hikerTable tbody').html('<tr><td colspan="6" class="text-center text-muted p-3">Tidak ada pendaki aktif.</td></tr>')
                    return
                }
                let html = ''
                $.each(hikers, function(_, h) {
                    html += `
                    <tr>
                        <td><i class="ri-user-line text-primary me-2"></i>${h.user_name}</td>
                        <td>${h.phone ?? '-'}</td>
                        <td><small>${h.hike_date} - ${h.return_date}</small></td>
                        <td>${h.team_size}</td>
                        <td>${h.latitude ? parseFloat(h.latitude).toFixed(4)+', '+parseFloat(h.longitude).toFixed(4) : '-'}</td>
                        <td>
                            <button class="btn btn-sm btn-info view-map" data-id="${h.booking_id}">
                                <i class="ri-map-pin-line me-1"></i>Lihat
                            </button>
                        </td>
                    </tr>`
                })
                $('#hikerTable tbody').html(html)
            }
        })
    }

    $(document).on('click', '.view-map', function() {
        activeBookingId = $(this).data('id')
        $('#logDetails').html('<p class="text-muted m-3">Memuat data lokasi...</p>')
        $('#mapModal').modal('show')
    })

    $('#mapModal').on('shown.bs.modal', function() {
        if (!activeBookingId) return
        if (logsCache[activeBookingId]) {
            renderMap(logsCache[activeBookingId])
        } else {
            $.ajax({
                url: '{{ route('mountain_hikers.logs') }}',
                method: 'GET',
                data: { id: activeBookingId },
                success: function(res) {
                    const logs = res.logs || []
                    logsCache[activeBookingId] = logs
                    renderMap(logs)
                },
                error: function() {
                    $('#logDetails').html('<div class="alert alert-danger m-3">Gagal memuat data.</div>')
                }
            })
        }
    })

    function renderMap(logs) {
        if (mapInstance) {
            mapInstance.remove()
            mapInstance = null
        }
        if (logs.length === 0) {
            $('#logDetails').html('<div class="alert alert-warning m-3">Tidak ada data lokasi ditemukan.</div>')
            return
        }
        const first = logs[0]
        mapInstance = L.map('hikerMap', {
            zoomControl: true,
            attributionControl: true
        }).setView([first.latitude, first.longitude], 13)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(mapInstance)
        const markers = []
        logs.forEach(log => {
            const marker = L.marker([log.latitude, log.longitude]).bindPopup(
                `<b>Waktu:</b> ${log.timestamp}<br>
                 ❤️ BPM: ${log.heart_rate ?? '-'}<br>
                 🩸 SpO₂: ${log.spo2 ?? '-'}<br>
                 😌 Stres: ${log.stress_level ?? '-'}`
            )
            markers.push(marker)
            marker.addTo(mapInstance)
        })
        const group = new L.featureGroup(markers)
        mapInstance.fitBounds(group.getBounds(), { padding: [30, 30] })
        setTimeout(() => mapInstance.invalidateSize(), 400)
        $('#logDetails').html(`<strong>Total titik:</strong> ${logs.length}`)
    }

    $('#refreshList').click(loadHikers)
    loadHikers()
})
</script>
@endpush
