@extends('main-layout')

@section('content')
    <!-- Booking History Container -->
    <div class="bg-white min-h-screen">
        <!-- Header - Navy Background (Serasi dengan Profile & Landing) -->
        <div class="relative px-6 py-16" style="background-color: #1B4965;">
            <!-- Back Button -->
            <button onclick="window.location.href='/profile'"
                class="absolute left-4 top-4 w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Header Title -->
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-white mb-2">
                    RIWAYAT BOOKING
                </h1>
                <p class="text-sm text-white/70 font-light tracking-wide">
                    Semua pendakian Anda
                </p>
            </div>
        </div>

        <!-- Stats Bar - Sky Blue Accent (Serasi dengan Design System) -->
        <div class="py-8" style="background-color: #CAE9FF;">
            <div class="flex items-center justify-around">
                @php
                    $totalBookings = $bookings->count();
                    $completedBookings = $bookings->where('status', 'completed')->count();
                    $activeBookings = $bookings->where('status', 'active')->count();
                @endphp
                <div class="text-center">
                    <p class="text-3xl font-bold" style="color: #1B4965;">{{ $totalBookings }}</p>
                    <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-1">Total</p>
                </div>
                <div class="w-px h-12 bg-white"></div>
                <div class="text-center">
                    <p class="text-3xl font-bold" style="color: #1B4965;">{{ $completedBookings }}</p>
                    <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-1">Selesai</p>
                </div>
                <div class="w-px h-12 bg-white"></div>
                <div class="text-center">
                    <p class="text-3xl font-bold" style="color: #FFD166;">{{ $activeBookings }}</p>
                    <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-1">Aktif</p>
                </div>
            </div>
        </div>

        <!-- Booking List - Full Width Cards -->
        <div class="divide-y divide-gray-200">
            @forelse ($bookings as $index => $booking)
                @php
                    $isActive = $booking->status === 'active';
                    $isCompleted = $booking->status === 'completed';
                    $isCancelled = $booking->status === 'cancelled';

                    // Format tanggal
                    $startDate = \Carbon\Carbon::parse($booking->start_time)->format('d M Y');
                    $endDate = \Carbon\Carbon::parse($booking->end_time)->format('d M Y');
                @endphp

                <!-- Booking Item - Full Width Swiss Design (Clickable) -->
                <div class="hover:bg-gray-50 transition-all animate-fade-in cursor-pointer"
                    style="animation-delay: {{ $index * 0.1 }}s;"
                    onclick="openBookingDetail({{ $booking->id }}, '{{ $booking->mountain_name }}', '{{ $startDate }}', '{{ $endDate }}', '{{ $booking->status }}', {{ $booking->total_duration_minutes ?? 0 }}, {{ $booking->avg_rating ?? 0 }})">
                    <div class="px-6 py-8">
                        <!-- Header Row -->
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold tracking-tight uppercase mb-1" style="color: #1B4965;">
                                    {{ $booking->mountain_name }}
                                </h3>
                                <p class="text-sm text-gray-500 font-medium tracking-wide">
                                    {{ $startDate }} — {{ $endDate }}
                                </p>
                            </div>
                            <div>
                                @if ($isActive)
                                    <span
                                        class="inline-block px-4 py-1.5 text-white text-xs font-bold uppercase tracking-wider rounded-lg"
                                        style="background-color: #FFD166;">
                                        Aktif
                                    </span>
                                @elseif ($isCompleted)
                                    <span
                                        class="inline-block px-4 py-1.5 text-xs font-bold uppercase tracking-wider rounded-lg"
                                        style="border: 2px solid #1B4965; color: #1B4965;">
                                        Selesai
                                    </span>
                                @elseif ($isCancelled)
                                    <span
                                        class="inline-block px-4 py-1.5 bg-gray-200 text-gray-600 text-xs font-bold uppercase tracking-wider rounded-lg">
                                        Batal
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Info Grid - Minimalist -->
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Durasi</p>
                                <p class="text-base font-bold" style="color: #1B4965;">
                                    {{ $booking->total_duration_minutes ? round($booking->total_duration_minutes / 60, 1) . ' Jam' : '-' }}
                                </p>
                            </div>

                            @if ($isCompleted && $booking->avg_rating > 0)
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Rating</p>
                                    <div class="flex items-center gap-2">
                                        <div class="flex gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($booking->avg_rating))
                                                    <svg class="w-4 h-4" style="color: #FFD166;" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm font-bold"
                                            style="color: #1B4965;">{{ number_format($booking->avg_rating, 1) }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons - Navy Theme (Serasi) -->
                        <div class="flex gap-3">
                            @if ($isActive)
                                <button
                                    class="flex-1 py-3 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:opacity-90 transition-all"
                                    style="background-color: #1B4965;">
                                    Detail
                                </button>
                                <button
                                    class="flex-1 py-3 text-xs font-bold uppercase tracking-wider rounded-xl transition-all hover:text-white"
                                    style="border: 2px solid #1B4965; color: #1B4965; background-color: white;"
                                    onmouseover="this.style.backgroundColor='#1B4965'"
                                    onmouseout="this.style.backgroundColor='white'">
                                    Tracking
                                </button>
                            @elseif ($isCompleted)
                                <button
                                    class="flex-1 py-3 text-xs font-bold uppercase tracking-wider rounded-xl transition-all hover:text-white"
                                    style="border: 2px solid #1B4965; color: #1B4965; background-color: white;"
                                    onmouseover="this.style.backgroundColor='#1B4965'"
                                    onmouseout="this.style.backgroundColor='white'">
                                    Detail
                                </button>
                                @if (!$booking->avg_rating || $booking->avg_rating == 0)
                                    <button
                                        class="flex-1 py-3 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:opacity-90 transition-all"
                                        style="background-color: #1B4965;">
                                        Rating
                                    </button>
                                @endif
                            @else
                                <button
                                    class="flex-1 py-3 border-2 border-gray-300 text-gray-500 text-xs font-bold uppercase tracking-wider rounded-xl">
                                    Detail
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State - Serasi dengan Design System -->
                <div class="py-24 text-center">
                    <div class="mb-6 inline-flex items-center justify-center w-20 h-20 rounded-full"
                        style="background-color: #CAE9FF;">
                        <svg class="w-10 h-10" style="color: #1B4965;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold uppercase tracking-tight mb-2" style="color: #1B4965;">Belum Ada Riwayat
                    </h3>
                    <p class="text-sm text-gray-500 mb-8 font-light">Mulai petualangan pertama Anda</p>
                    <button onclick="window.location.href='/booking'"
                        class="px-8 py-3 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:opacity-90 transition-all"
                        style="background-color: #1B4965;">
                        Booking Sekarang
                    </button>
                </div>
            @endforelse

        </div>
    </div>

    <!-- Booking Detail Modal -->
    <div id="bookingDetailModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full my-8">
            <!-- Modal Header -->
            <div class="relative px-8 py-8" style="background-color: #1B4965;">
                <button onclick="closeBookingDetail()"
                    class="absolute right-6 top-6 w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-white/10 rounded-2xl border border-white/20 mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                    <h2 id="modalMountainName" class="text-3xl font-bold tracking-tight text-white uppercase mb-2">GUNUNG
                        BROMO</h2>
                    <p id="modalDateRange" class="text-white/70 text-sm font-light tracking-wide">12 Nov 2025 — 14 Nov
                        2025</p>
                    <div id="modalStatusBadge"
                        class="mt-4 inline-block px-5 py-2 text-white text-xs font-bold uppercase tracking-wider rounded-lg"
                        style="background-color: #FFD166;">
                        Aktif
                    </div>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-8 space-y-8">
                <!-- QR Code Section -->
                <div class="text-center">
                    <h3 class="text-sm font-bold uppercase tracking-wider mb-4" style="color: #1B4965;">QR Code Booking
                    </h3>
                    <div class="inline-block p-6 rounded-3xl" style="background-color: #CAE9FF;">
                        <!-- Dummy QR Code (using placeholder) -->
                        <div class="bg-white p-4 rounded-2xl">
                            <svg class="w-48 h-48 mx-auto" viewBox="0 0 200 200" fill="none">
                                <!-- Simplified QR-like pattern for dummy -->
                                <rect width="200" height="200" fill="white" />
                                <rect x="10" y="10" width="50" height="50" fill="#1B4965" />
                                <rect x="140" y="10" width="50" height="50" fill="#1B4965" />
                                <rect x="10" y="140" width="50" height="50" fill="#1B4965" />
                                <rect x="20" y="20" width="30" height="30" fill="white" />
                                <rect x="150" y="20" width="30" height="30" fill="white" />
                                <rect x="20" y="150" width="30" height="30" fill="white" />
                                <rect x="80" y="30" width="10" height="10" fill="#1B4965" />
                                <rect x="100" y="30" width="10" height="10" fill="#1B4965" />
                                <rect x="120" y="30" width="10" height="10" fill="#1B4965" />
                                <rect x="70" y="50" width="10" height="10" fill="#1B4965" />
                                <rect x="110" y="50" width="10" height="10" fill="#1B4965" />
                                <rect x="80" y="70" width="10" height="10" fill="#1B4965" />
                                <rect x="100" y="70" width="10" height="10" fill="#1B4965" />
                                <rect x="120" y="70" width="10" height="10" fill="#1B4965" />
                                <rect x="70" y="90" width="10" height="10" fill="#1B4965" />
                                <rect x="90" y="90" width="10" height="10" fill="#1B4965" />
                                <rect x="110" y="90" width="10" height="10" fill="#1B4965" />
                                <rect x="130" y="90" width="10" height="10" fill="#1B4965" />
                                <rect x="80" y="110" width="10" height="10" fill="#1B4965" />
                                <rect x="100" y="110" width="10" height="10" fill="#1B4965" />
                                <rect x="120" y="110" width="10" height="10" fill="#1B4965" />
                                <rect x="70" y="130" width="10" height="10" fill="#1B4965" />
                                <rect x="110" y="130" width="10" height="10" fill="#1B4965" />
                                <rect x="80" y="150" width="10" height="10" fill="#1B4965" />
                                <rect x="100" y="150" width="10" height="10" fill="#1B4965" />
                                <rect x="120" y="150" width="10" height="10" fill="#1B4965" />
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 mt-4 font-semibold uppercase tracking-wider">Booking ID: <span
                                id="modalBookingId">#BRO-2025-001</span></p>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="rounded-2xl p-6 space-y-4" style="background-color: #CAE9FF;">
                    <h3 class="text-sm font-bold uppercase tracking-wider mb-4" style="color: #1B4965;">Detail Booking
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-1">Durasi</p>
                            <p id="modalDuration" class="text-lg font-bold" style="color: #1B4965;">48.5 Jam</p>
                        </div>
                        <div id="modalRatingSection">
                            <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-1">Rating</p>
                            <div class="flex items-center gap-2">
                                <div id="modalStars" class="flex gap-0.5"></div>
                                <span id="modalRatingValue" class="text-sm font-bold" style="color: #1B4965;">4.5</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hiking Track History (Only for completed bookings) -->
                <div id="trackHistorySection" class="hidden">
                    <div class="rounded-2xl border-2 p-6 space-y-5" style="border-color: #1B4965;">
                        <h3 class="text-sm font-bold uppercase tracking-wider" style="color: #1B4965;">Riwayat Perjalanan
                        </h3>

                        <!-- Track Timeline -->
                        <div class="space-y-4">
                            <!-- Checkpoint 1 -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                        style="background-color: #1B4965;">
                                        1
                                    </div>
                                    <div class="w-0.5 h-full mt-2" style="background-color: #CAE9FF;"></div>
                                </div>
                                <div class="flex-1 pb-6">
                                    <p class="font-bold text-sm mb-1" style="color: #1B4965;">Basecamp</p>
                                    <p class="text-xs text-gray-600 mb-2">12 Nov 2025, 06:00 WIB</p>
                                    <p class="text-xs text-gray-500">Ketinggian: 1,200 MDPL</p>
                                </div>
                            </div>

                            <!-- Checkpoint 2 -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                        style="background-color: #1B4965;">
                                        2
                                    </div>
                                    <div class="w-0.5 h-full mt-2" style="background-color: #CAE9FF;"></div>
                                </div>
                                <div class="flex-1 pb-6">
                                    <p class="font-bold text-sm mb-1" style="color: #1B4965;">Pos 1 - Cemoro Lawang</p>
                                    <p class="text-xs text-gray-600 mb-2">12 Nov 2025, 09:30 WIB · <span
                                            style="color: #FFD166;" class="font-semibold">3.5 jam dari start</span></p>
                                    <p class="text-xs text-gray-500">Ketinggian: 1,800 MDPL</p>
                                </div>
                            </div>

                            <!-- Checkpoint 3 -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                        style="background-color: #1B4965;">
                                        3
                                    </div>
                                    <div class="w-0.5 h-full mt-2" style="background-color: #CAE9FF;"></div>
                                </div>
                                <div class="flex-1 pb-6">
                                    <p class="font-bold text-sm mb-1" style="color: #1B4965;">Pos 2 - Savana</p>
                                    <p class="text-xs text-gray-600 mb-2">12 Nov 2025, 13:00 WIB · <span
                                            style="color: #FFD166;" class="font-semibold">7 jam dari start</span></p>
                                    <p class="text-xs text-gray-500">Ketinggian: 2,100 MDPL</p>
                                </div>
                            </div>

                            <!-- Summit -->
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                                        style="background-color: #FFD166;">
                                        ★
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-sm mb-1" style="color: #1B4965;">Puncak Bromo</p>
                                    <p class="text-xs text-gray-600 mb-2">13 Nov 2025, 05:00 WIB · <span
                                            style="color: #FFD166;" class="font-semibold">23 jam dari start</span></p>
                                    <p class="text-xs text-gray-500">Ketinggian: 2,329 MDPL</p>
                                    <div class="mt-3 px-3 py-2 rounded-lg inline-block"
                                        style="background-color: #CAE9FF;">
                                        <p class="text-xs font-bold uppercase tracking-wider" style="color: #1B4965;">
                                            Summit Achieved! 🎉</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Summary -->
                        <div class="grid grid-cols-3 gap-3 pt-4 border-t-2" style="border-color: #CAE9FF;">
                            <div class="text-center">
                                <p class="text-2xl font-bold" style="color: #1B4965;">23.5</p>
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-1">Jam</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold" style="color: #1B4965;">8.2</p>
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-1">KM</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold" style="color: #FFD166;">2,329</p>
                                <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mt-1">MDPL</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button onclick="window.print()"
                        class="flex-1 py-4 text-white text-sm font-bold uppercase tracking-wider rounded-2xl hover:opacity-90 transition-all"
                        style="background-color: #1B4965;">
                        Download
                    </button>
                    <button onclick="closeBookingDetail()"
                        class="flex-1 py-4 text-sm font-bold uppercase tracking-wider rounded-2xl border-2 transition-all"
                        style="border-color: #1B4965; color: #1B4965;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Animations - Swiss Design -->
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out forwards;
            opacity: 0;
        }
    </style>

    <!-- JavaScript -->
    <script>
        // Initialize staggered fade-in
        document.addEventListener('DOMContentLoaded', function() {
            const items = document.querySelectorAll('.animate-fade-in');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                }, index * 100);
            });
        });

        // Open booking detail modal
        function openBookingDetail(bookingId, mountainName, startDate, endDate, status, duration, rating) {
            const modal = document.getElementById('bookingDetailModal');
            const trackSection = document.getElementById('trackHistorySection');
            const ratingSection = document.getElementById('modalRatingSection');

            // Set basic info
            document.getElementById('modalMountainName').textContent = mountainName.toUpperCase();
            document.getElementById('modalDateRange').textContent = `${startDate} — ${endDate}`;
            document.getElementById('modalBookingId').textContent = `#BRO-2025-${String(bookingId).padStart(3, '0')}`;

            // Set duration
            const hours = (duration / 60).toFixed(1);
            document.getElementById('modalDuration').textContent = `${hours} Jam`;

            // Set status badge
            const statusBadge = document.getElementById('modalStatusBadge');
            if (status === 'active') {
                statusBadge.textContent = 'Aktif';
                statusBadge.style.backgroundColor = '#FFD166';
                statusBadge.style.color = 'white';
                statusBadge.style.border = 'none';
                trackSection.classList.add('hidden');
            } else if (status === 'completed') {
                statusBadge.textContent = 'Selesai';
                statusBadge.style.backgroundColor = 'transparent';
                statusBadge.style.color = '#1B4965';
                statusBadge.style.border = '2px solid #1B4965';
                trackSection.classList.remove('hidden'); // Show track history for completed bookings
            } else {
                statusBadge.textContent = 'Batal';
                statusBadge.style.backgroundColor = '#e5e7eb';
                statusBadge.style.color = '#6b7280';
                statusBadge.style.border = 'none';
                trackSection.classList.add('hidden');
            }

            // Set rating
            if (rating > 0) {
                ratingSection.classList.remove('hidden');
                const starsContainer = document.getElementById('modalStars');
                starsContainer.innerHTML = '';
                for (let i = 1; i <= 5; i++) {
                    const star = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    star.setAttribute('class', 'w-4 h-4');
                    star.setAttribute('fill', 'currentColor');
                    star.setAttribute('viewBox', '0 0 20 20');
                    star.style.color = i <= Math.floor(rating) ? '#FFD166' : '#d1d5db';
                    star.innerHTML =
                        '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />';
                    starsContainer.appendChild(star);
                }
                document.getElementById('modalRatingValue').textContent = rating.toFixed(1);
            } else {
                ratingSection.classList.add('hidden');
            }

            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        // Close booking detail modal
        function closeBookingDetail() {
            const modal = document.getElementById('bookingDetailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modal on background click
        document.getElementById('bookingDetailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingDetail();
            }
        });
    </script>
@endsection
