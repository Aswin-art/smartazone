@extends('main-layout')

@section('content')
    <div class="bg-white min-h-screen font-sans text-neutral-900 pb-32">
        <!-- Header - Solid Brand Color -->
        <div class="bg-[#1B4965] px-6 pt-16 pb-12 rounded-b-[2.5rem] shadow-xl shadow-[#1B4965]/10 relative overflow-hidden">
            <!-- Background Pattern -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none">
            </div>

            <!-- Back Button -->
            <a href="/profile"
                class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-md z-20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="relative z-10 text-center mt-4 opacity-0 animate-enter">
                <h1 class="text-3xl font-medium tracking-tight text-white mb-2">
                    Pesanan Saya
                </h1>
                <p class="text-sm text-white/70 font-medium tracking-wide">
                    Riwayat petualangan Anda
                </p>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="px-6 -mt-8 relative z-20 opacity-0 animate-enter" style="animation-delay: 0.1s">
            <div
                class="bg-white rounded-2xl shadow-lg shadow-neutral-100 border border-neutral-100 p-6 flex justify-between items-center">
                @php
                    $totalBookings = $bookings->count();
                    $completedBookings = $bookings->where('status', 'completed')->count();
                    $activeBookings = $bookings->where('status', 'active')->count();
                @endphp
                <div class="text-center flex-1">
                    <p class="text-2xl font-semibold text-[#1B4965]">{{ $totalBookings }}</p>
                    <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mt-1">Total</p>
                </div>
                <div class="w-px h-8 bg-neutral-100"></div>
                <div class="text-center flex-1">
                    <p class="text-2xl font-semibold text-[#1B4965]">{{ $completedBookings }}</p>
                    <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mt-1">Selesai</p>
                </div>
                <div class="w-px h-8 bg-neutral-100"></div>
                <div class="text-center flex-1">
                    <p class="text-2xl font-semibold text-[#FFD166]">{{ $activeBookings }}</p>
                    <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mt-1">Aktif</p>
                </div>
            </div>
        </div>

        @guest
            <!-- Guest Prompt -->
            <div class="flex flex-col items-center justify-center min-h-[60vh] px-6 text-center">
                <div class="w-20 h-20 bg-neutral-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-neutral-900 mb-2">Akses Diperlukan</h2>
                <p class="text-sm text-neutral-500 mb-8 max-w-xs mx-auto leading-relaxed">
                    Silakan masuk atau daftar untuk melihat riwayat pemesanan Anda.
                </p>
                <div class="flex flex-col gap-3 w-full max-w-xs">
                    <a href="{{ route('login') }}"
                        class="w-full py-3.5 bg-[#1B4965] text-white text-sm font-bold uppercase tracking-wider rounded-full hover:bg-[#153a51] transition-colors shadow-lg shadow-[#1B4965]/20">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full py-3.5 bg-white text-[#1B4965] border border-[#1B4965]/20 text-sm font-bold uppercase tracking-wider rounded-full hover:bg-neutral-50 transition-colors">
                        Daftar
                    </a>
                </div>
            </div>
        @endguest

        @auth
            <!-- Booking List -->
            <div class="px-6 mt-8 space-y-6">
                @forelse ($bookings as $index => $booking)
                    @php
                        $isActive = $booking->status === 'active';
                        $isCompleted = $booking->status === 'completed';
                        $isCancelled = $booking->status === 'cancelled';
                        $startDate = \Carbon\Carbon::parse($booking->start_time)->format('d M Y');
                        $endDate = \Carbon\Carbon::parse($booking->end_time)->format('d M Y');
                    @endphp

                    <div class="group bg-white rounded-2xl border border-neutral-200 p-6 hover:border-[#1B4965] transition-all duration-100 opacity-0 animate-enter cursor-pointer shadow-sm hover:shadow-md"
                        style="animation-delay: {{ $index * 0.1 + 0.2 }}s;"
                        onclick="openBookingDetail({{ $booking->id }}, '{{ $booking->mountain_name }}', '{{ $startDate }}', '{{ $endDate }}', '{{ $booking->status }}', {{ $booking->total_duration_minutes ?? 0 }}, {{ $booking->avg_rating ?? 0 }}, {{ $booking->team_size }})">

                        <!-- Header: Name & Status -->
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-neutral-900 group-hover:text-[#1B4965] transition-colors">
                                    {{ $booking->mountain_name }}
                                </h3>
                                <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mt-1">
                                    Booking ID: #BRO-2025-{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>
                            @if ($isActive)
                                <span
                                    class="px-3 py-1 bg-[#FFD166]/10 text-[#FFD166] text-[10px] font-bold uppercase tracking-wider rounded-full border border-[#FFD166]/20">
                                    Aktif
                                </span>
                            @elseif ($isCompleted)
                                <span
                                    class="px-3 py-1 bg-[#1B4965]/10 text-[#1B4965] text-[10px] font-bold uppercase tracking-wider rounded-full border border-[#1B4965]/20">
                                    Selesai
                                </span>
                            @elseif ($isCancelled)
                                <span
                                    class="px-3 py-1 bg-neutral-100 text-neutral-500 text-[10px] font-bold uppercase tracking-wider rounded-full border border-neutral-200">
                                    Dibatalkan
                                </span>
                            @endif
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-3 gap-4 mb-6 border-y border-neutral-100 py-4">
                            <!-- Date -->
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Tanggal</p>
                                <p class="text-xs font-semibold text-neutral-900">{{ $startDate }}</p>
                            </div>

                            <!-- Duration -->
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Durasi</p>
                                <p class="text-xs font-semibold text-neutral-900">
                                    @php
                                        $start = \Carbon\Carbon::parse($booking->start_time);
                                        $end = \Carbon\Carbon::parse($booking->end_time);
                                        $days = $start->diffInDays($end);
                                    @endphp
                                    {{ $days }} Hari
                                </p>
                            </div>

                            <!-- Team -->
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-wider">Tim</p>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-[#1B4965]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-xs font-semibold text-neutral-900">{{ $booking->team_size }} Pendaki</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 pt-4 border-t border-neutral-100">
                            <button
                                class="flex-1 py-2.5 bg-neutral-50 text-neutral-600 text-[10px] font-bold uppercase tracking-wider rounded-xl hover:bg-neutral-100 transition-colors"
                                onclick="event.stopPropagation(); openBookingDetail({{ $booking->id }}, '{{ $booking->mountain_name }}', '{{ $startDate }}', '{{ $endDate }}', '{{ $booking->status }}', {{ $booking->total_duration_minutes ?? 0 }}, {{ $booking->avg_rating ?? 0 }}, {{ $booking->team_size }})">
                                Lihat Detail
                            </button>
                            <a href="{{ route('hiker-history.tracking-route', $booking->id) }}"
                                onclick="event.stopPropagation()"
                                class="flex-1 py-2.5 bg-[#1B4965] text-white text-[10px] font-bold uppercase tracking-wider rounded-xl hover:bg-[#153a51] transition-colors text-center">
                                Pelacakan Langsung
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-20 text-center opacity-0 animate-enter" style="animation-delay: 0.2s">
                        <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-neutral-900 mb-1">Belum Ada Pesanan</h3>
                        <p class="text-sm text-neutral-500 mb-6">Mulai petualangan pertama Anda hari ini.</p>
                        <a href="/booking"
                            class="inline-block px-8 py-3 bg-[#1B4965] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#153a51] transition-colors">
                            Pesan Sekarang
                        </a>
                    </div>
                @endforelse
            </div>
        @endauth
    </div>

    <!-- Booking Detail Modal -->
    <div id="bookingDetailModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="relative bg-[#1B4965] p-8 pb-12 overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2">
                </div>

                <button onclick="closeBookingDetail()"
                    class="absolute right-4 top-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="text-center relative z-10">
                    <div
                        class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                    <h2 id="modalMountainName" class="text-2xl font-medium text-white mb-1"></h2>
                    <p id="modalDateRange" class="text-sm text-white/70 font-medium"></p>
                    <div id="modalStatusBadge"
                        class="mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full">
                    </div>
                </div>
            </div>

            <div class="px-6 -mt-6 relative z-10 pb-8 space-y-6">
                <!-- Info Cards -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-neutral-50 p-3 rounded-xl">
                        <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-1">Check-in</p>
                        <p id="modalCheckIn" class="text-sm font-bold text-neutral-900">-</p>
                    </div>
                    <div class="bg-neutral-50 p-3 rounded-xl">
                        <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-1">Check-out</p>
                        <p id="modalCheckOut" class="text-sm font-bold text-neutral-900">-</p>
                    </div>
                    <div class="bg-neutral-50 p-3 rounded-xl">
                        <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-1">Durasi</p>
                        <p id="modalDuration" class="text-sm font-bold text-neutral-900">-</p>
                    </div>
                    <div class="bg-neutral-50 p-3 rounded-xl">
                        <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-1">Ukuran Tim</p>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#1B4965]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p id="modalTeamSize" class="text-sm font-bold text-neutral-900">-</p>
                        </div>
                    </div>
                </div>

                <div id="modalRatingSection" class="pt-6 border-t border-neutral-100">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold">Rating</p>
                        <div class="flex items-center gap-2">
                            <div id="modalStars" class="flex gap-0.5"></div>
                            <span id="modalRatingValue" class="text-sm font-bold text-neutral-900"></span>
                        </div>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="text-center mb-6">
                    <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-3">Kode QR Pemesanan</p>
                    <div class="bg-neutral-50 p-4 rounded-2xl inline-block border border-neutral-100">
                        <div
                            class="w-52 h-52 bg-white rounded-xl flex items-center justify-center border border-neutral-100">
                            <!-- Placeholder QR -->
                            <svg class="w-36 h-36 text-neutral-900" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-2zm-3 2h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 0h-3v3h2v-1h1v-2z" />
                            </svg>
                        </div>
                        <p class="text-[10px] text-neutral-400 font-mono mt-2" id="modalBookingId"></p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button id="downloadTicketBtn"
                        class="flex-1 py-3 bg-[#1B4965] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#153a51] transition-colors">
                        Unduh Tiket
                    </button>
                    <button onclick="closeBookingDetail()"
                        class="flex-1 py-3 bg-white border border-neutral-200 text-neutral-600 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-neutral-50 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                gsap.to(".animate-enter", {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: "power2.out"
                });
            });

            function openBookingDetail(id, name, start, end, status, duration, rating, teamSize) {
                const modal = document.getElementById('bookingDetailModal');
                document.getElementById('modalMountainName').textContent = name;
                document.getElementById('modalDateRange').textContent = `${start} — ${end}`;
                document.getElementById('modalCheckIn').textContent = start;
                document.getElementById('modalCheckOut').textContent = end;
                document.getElementById('modalBookingId').textContent = `#ARJ-2025-${String(id).padStart(3, '0')}`;
                document.getElementById('modalTeamSize').textContent = `${teamSize} Pendaki`;

                // Update Download Button Link
                const downloadBtn = document.getElementById('downloadTicketBtn');
                downloadBtn.onclick = function() {
                    window.open(`/booking/${id}/ticket`, '_blank');
                };

                // Calculate days from duration (assuming duration is in minutes)
                // Or better, calculate from dates if available, but here we use the passed duration for simplicity if it represents total time
                // However, the duration passed is total_duration_minutes.
                // Let's approximate days based on 24h or use the dates if parsed.
                // Since we have start and end strings, let's use the duration minutes to show hours or days.
                // The previous code showed hours. Let's show Days if > 24h.

                const hours = duration / 60;
                if (hours > 24) {
                    const days = Math.ceil(hours / 24);
                    document.getElementById('modalDuration').textContent = `${days} Hari`;
                } else {
                    document.getElementById('modalDuration').textContent = `${Math.round(hours)} Jam`;
                }

                const badge = document.getElementById('modalStatusBadge');
                if (status === 'active') {
                    badge.textContent = 'Active';
                    badge.className =
                        'mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#FFD166] text-[#1B4965]';
                } else if (status === 'completed') {
                    badge.textContent = 'Completed';
                    badge.className =
                        'mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-white text-[#1B4965]';
                } else {
                    badge.textContent = 'Cancelled';
                    badge.className =
                        'mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-white/20 text-white';
                }

                const ratingSection = document.getElementById('modalRatingSection');
                if (rating > 0) {
                    ratingSection.classList.remove('hidden');
                    const stars = document.getElementById('modalStars');
                    stars.innerHTML = '';
                    for (let i = 1; i <= 5; i++) {
                        stars.innerHTML +=
                            `<svg class="w-3 h-3 ${i <= rating ? 'text-[#FFD166]' : 'text-neutral-200'}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>`;
                    }
                    document.getElementById('modalRatingValue').textContent = rating.toFixed(1);
                } else {
                    ratingSection.classList.add('hidden');
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeBookingDetail() {
                const modal = document.getElementById('bookingDetailModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }

            document.getElementById('bookingDetailModal').addEventListener('click', function(e) {
                if (e.target === this) closeBookingDetail();
            });
        </script>
        <style>
            .animate-enter {
                transform: translateY(20px);
            }
        </style>
    @endpush
@endsection
