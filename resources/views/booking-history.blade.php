@extends('main-layout')

@section('content')
    <div class="bg-white min-h-screen font-sans text-neutral-900 pb-32">
        <!-- Header - Solid Brand Color -->
        <div class="bg-[#1B4965] px-6 pt-16 pb-12 rounded-b-[2.5rem] shadow-xl shadow-[#1B4965]/10 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

            <!-- Back Button -->
            <a href="/profile" class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-md z-20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="relative z-10 text-center mt-4 opacity-0 animate-enter">
                <h1 class="text-3xl font-medium tracking-tight text-white mb-2">
                    Booking History
                </h1>
                <p class="text-sm text-white/70 font-medium tracking-wide">
                    Your mountain adventures
                </p>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="px-6 -mt-8 relative z-20 opacity-0 animate-enter" style="animation-delay: 0.1s">
            <div class="bg-white rounded-2xl shadow-lg shadow-neutral-100 border border-neutral-100 p-6 flex justify-between items-center">
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
                    <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mt-1">Done</p>
                </div>
                <div class="w-px h-8 bg-neutral-100"></div>
                <div class="text-center flex-1">
                    <p class="text-2xl font-semibold text-[#FFD166]">{{ $activeBookings }}</p>
                    <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mt-1">Active</p>
                </div>
            </div>
        </div>

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

                <div class="group bg-white rounded-2xl border border-neutral-200 p-5 hover:border-[#1B4965] transition-all duration-300 opacity-0 animate-enter cursor-pointer shadow-sm hover:shadow-md"
                     style="animation-delay: {{ ($index * 0.1) + 0.2 }}s;"
                     onclick="openBookingDetail({{ $booking->id }}, '{{ $booking->mountain_name }}', '{{ $startDate }}', '{{ $endDate }}', '{{ $booking->status }}', {{ $booking->total_duration_minutes ?? 0 }}, {{ $booking->avg_rating ?? 0 }})">
                    
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-neutral-900 group-hover:text-[#1B4965] transition-colors">
                                {{ $booking->mountain_name }}
                            </h3>
                            <p class="text-xs text-neutral-500 font-medium mt-1">
                                {{ $startDate }} — {{ $endDate }}
                            </p>
                        </div>
                        @if ($isActive)
                            <span class="px-3 py-1 bg-[#FFD166]/10 text-[#FFD166] text-[10px] font-bold uppercase tracking-wider rounded-full border border-[#FFD166]/20">
                                Active
                            </span>
                        @elseif ($isCompleted)
                            <span class="px-3 py-1 bg-[#1B4965]/10 text-[#1B4965] text-[10px] font-bold uppercase tracking-wider rounded-full border border-[#1B4965]/20">
                                Completed
                            </span>
                        @elseif ($isCancelled)
                            <span class="px-3 py-1 bg-neutral-100 text-neutral-500 text-[10px] font-bold uppercase tracking-wider rounded-full border border-neutral-200">
                                Cancelled
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-6 mb-5">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-neutral-700">
                                {{ $booking->total_duration_minutes ? round($booking->total_duration_minutes / 60, 1) . 'h' : '-' }}
                            </span>
                        </div>
                        @if ($isCompleted && $booking->avg_rating > 0)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#FFD166]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-sm font-medium text-neutral-700">{{ number_format($booking->avg_rating, 1) }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex gap-3">
                        <button class="flex-1 py-2.5 bg-[#1B4965] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#153a51] transition-colors">
                            Details
                        </button>
                        @if ($isActive)
                            <button class="flex-1 py-2.5 border border-[#1B4965] text-[#1B4965] text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#1B4965]/5 transition-colors">
                                Tracking
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-20 text-center opacity-0 animate-enter" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-neutral-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-neutral-900 mb-1">No Bookings Yet</h3>
                    <p class="text-sm text-neutral-500 mb-6">Start your first adventure today.</p>
                    <a href="/booking" class="inline-block px-8 py-3 bg-[#1B4965] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#153a51] transition-colors">
                        Book Now
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Booking Detail Modal -->
    <div id="bookingDetailModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="relative bg-[#1B4965] p-8 pb-12 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2"></div>
                
                <button onclick="closeBookingDetail()" class="absolute right-4 top-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="text-center relative z-10">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                    <h2 id="modalMountainName" class="text-2xl font-medium text-white mb-1"></h2>
                    <p id="modalDateRange" class="text-sm text-white/70 font-medium"></p>
                    <div id="modalStatusBadge" class="mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full"></div>
                </div>
            </div>

            <div class="px-6 -mt-6 relative z-10 pb-8 space-y-6">
                <!-- Info Cards -->
                <div class="bg-white rounded-2xl shadow-lg shadow-neutral-100 border border-neutral-100 p-6 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-1">Duration</p>
                        <p id="modalDuration" class="text-lg font-semibold text-[#1B4965]"></p>
                    </div>
                    <div id="modalRatingSection">
                        <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-1">Rating</p>
                        <div class="flex items-center gap-2">
                            <div id="modalStars" class="flex gap-0.5"></div>
                            <span id="modalRatingValue" class="text-sm font-bold text-neutral-900"></span>
                        </div>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="text-center">
                    <p class="text-[10px] text-neutral-400 uppercase tracking-widest font-bold mb-3">Booking QR Code</p>
                    <div class="bg-neutral-50 p-4 rounded-2xl inline-block border border-neutral-100">
                        <div class="w-40 h-40 bg-white rounded-xl flex items-center justify-center border border-neutral-100">
                            <!-- Placeholder QR -->
                            <svg class="w-32 h-32 text-neutral-900" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-2zm-3 2h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 0h-3v3h2v-1h1v-2z"/>
                            </svg>
                        </div>
                        <p class="text-[10px] text-neutral-400 font-mono mt-2" id="modalBookingId"></p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4">
                    <button class="flex-1 py-3 bg-[#1B4965] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#153a51] transition-colors">
                        Download Ticket
                    </button>
                    <button onclick="closeBookingDetail()" class="flex-1 py-3 border border-neutral-200 text-neutral-500 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-neutral-50 transition-colors">
                        Close
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

        function openBookingDetail(id, name, start, end, status, duration, rating) {
            const modal = document.getElementById('bookingDetailModal');
            document.getElementById('modalMountainName').textContent = name;
            document.getElementById('modalDateRange').textContent = `${start} — ${end}`;
            document.getElementById('modalBookingId').textContent = `#BRO-2025-${String(id).padStart(3, '0')}`;
            
            const hours = (duration / 60).toFixed(1);
            document.getElementById('modalDuration').textContent = `${hours}h`;

            const badge = document.getElementById('modalStatusBadge');
            if (status === 'active') {
                badge.textContent = 'Active';
                badge.className = 'mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-[#FFD166] text-[#1B4965]';
            } else if (status === 'completed') {
                badge.textContent = 'Completed';
                badge.className = 'mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-white text-[#1B4965]';
            } else {
                badge.textContent = 'Cancelled';
                badge.className = 'mt-4 inline-block px-4 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-white/20 text-white';
            }

            const ratingSection = document.getElementById('modalRatingSection');
            if (rating > 0) {
                ratingSection.classList.remove('hidden');
                const stars = document.getElementById('modalStars');
                stars.innerHTML = '';
                for(let i=1; i<=5; i++) {
                    stars.innerHTML += `<svg class="w-3 h-3 ${i <= rating ? 'text-[#FFD166]' : 'text-neutral-200'}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>`;
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
