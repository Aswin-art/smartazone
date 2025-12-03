@extends('main-layout')

@section('content')
    <div class="bg-white min-h-screen font-sans text-neutral-900 pb-32">
        <!-- Header Section - Solid Brand Color -->
        <!-- Header Section - Solid Brand Color -->
        <div class="bg-[#1B4965] px-6 pt-12 pb-16 rounded-b-[3rem] shadow-2xl shadow-[#1B4965]/20 relative overflow-hidden">
            <!-- Background Pattern -->
            <div
                class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2 pointer-events-none">
            </div>

            <!-- Top Bar -->
            <div class="relative z-10 flex justify-between items-center mb-10 opacity-0 animate-enter">
                <h1 class="text-xl font-bold text-white tracking-wide uppercase">Profil</h1>
                @auth
                    <a href="{{ route('profile.edit') }}"
                        class="w-10 h-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white hover:bg-white/20 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>
                @endauth
            </div>

            <!-- User Profile Summary -->
            <div class="relative z-10 flex items-center gap-6 opacity-0 animate-enter" style="animation-delay: 0.1s">
                <!-- Avatar -->
                <div
                    class="w-20 h-20 rounded-[2rem] bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-black/5">
                    @if (Auth::check())
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @else
                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    @endif
                </div>

                <!-- Text Info -->
                <div>
                    <h2 class="text-2xl font-bold text-white leading-tight mb-1">
                        {{ Auth::user()->name ?? 'Tamu' }}
                    </h2>
                    <p class="text-white/70 text-sm font-medium tracking-wide">
                        {{ Auth::user()->email ?? 'Silakan masuk' }}
                    </p>
                    @auth
                        <div class="mt-3 flex gap-2">
                            <span
                                class="px-3 py-1 bg-white/10 rounded-full text-[10px] font-bold text-white uppercase tracking-wider border border-white/10 backdrop-blur-sm">
                                Member
                            </span>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        @auth
            <!-- Info Section -->
            <div class="px-6 mt-12 space-y-8 opacity-0 animate-enter" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#1B4965]">Informasi Pribadi</span>
                    <span class="text-[10px] font-mono text-neutral-300">01</span>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-neutral-50 border border-neutral-100">
                        <div class="w-10 h-10 rounded-full bg-[#1B4965]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#1B4965]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-400 mb-1">Nomor Telepon</label>
                            <div class="text-base font-medium text-neutral-900">
                                {{ $user->phone ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-neutral-50 border border-neutral-100">
                        <div class="w-10 h-10 rounded-full bg-[#1B4965]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#1B4965]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-neutral-400 mb-1">Anggota Sejak</label>
                            <div class="text-base font-medium text-neutral-900">
                                {{ $user?->created_at ? $user->created_at->format('F Y') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Section -->
            <div class="px-6 mt-12 space-y-6 opacity-0 animate-enter" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#1B4965]">Menu</span>
                    <span class="text-[10px] font-mono text-neutral-300">02</span>
                </div>

                <div class="space-y-3">
                    <a href="/booking-history"
                        class="group flex items-center justify-between p-4 rounded-2xl border border-neutral-200 hover:border-[#1B4965] hover:bg-[#1B4965]/5 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-neutral-100 group-hover:bg-white flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 text-neutral-500 group-hover:text-[#1B4965] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span
                                class="text-base font-medium text-neutral-900 group-hover:text-[#1B4965] transition-colors">Riwayat
                                Pemesanan</span>
                        </div>
                        <svg class="w-5 h-5 text-neutral-300 group-hover:text-[#1B4965] group-hover:translate-x-1 transition-all"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="group flex items-center justify-between p-4 rounded-2xl border border-neutral-200 hover:border-[#1B4965] hover:bg-[#1B4965]/5 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-[#1B4965]/5 flex items-center justify-center text-[#1B4965] group-hover:bg-[#1B4965] group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-neutral-700 group-hover:text-[#1B4965]">Pengaturan</span>
                        </div>
                        <svg class="w-5 h-5 text-neutral-400 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M9 18l6-6-6-6" />
                        </svg>
                    </a>

                    <a href="{{ route('help-support') }}"
                        class="group flex items-center justify-between p-4 rounded-2xl border border-neutral-200 hover:border-[#1B4965] hover:bg-[#1B4965]/5 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-neutral-100 group-hover:bg-white flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 text-neutral-500 group-hover:text-[#1B4965] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-base font-medium text-neutral-900 group-hover:text-[#1B4965] transition-colors">Bantuan
                                & Dukungan</span>
                        </div>
                        <svg class="w-5 h-5 text-neutral-300 group-hover:text-[#1B4965] group-hover:translate-x-1 transition-all"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Logout -->
            <div class="px-6 mt-12 opacity-0 animate-enter" style="animation-delay: 0.4s">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-4 bg-red-50 text-red-500 text-xs font-bold uppercase tracking-wider rounded-2xl hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        @endauth

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
                    Silakan masuk atau daftar untuk melihat profil Anda dan mengelola pemesanan.
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
        </script>
        <style>
            .animate-enter {
                transform: translateY(20px);
            }
        </style>
    @endpush
@endsection
