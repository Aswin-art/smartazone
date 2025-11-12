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

                <!-- Booking Item - Full Width Swiss Design -->
                <div class="hover:bg-gray-50 transition-all animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
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
    </div> <!-- CSS Animations - Swiss Design -->
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
    </script>
@endsection
