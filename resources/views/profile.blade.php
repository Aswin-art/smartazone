@extends('main-layout')


@section('content')
    <!-- Profile Container -->
    <div class="bg-white min-h-screen overflow-hidden">
        <!-- Header - Navy Background -->
        <div class="relative px-8 py-12" style="background-color: #1B4965;">
            <!-- Back Button -->
            <button onclick="window.history.back()"
                class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Profile Header -->
            <div class="text-center space-y-4">
                <!-- Avatar -->
                <div
                    class="inline-flex items-center justify-center w-24 h-24 rounded-full border-4 border-white/20 bg-white/10 backdrop-blur-sm">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">{{ $user->name ?? 'Pengguna' }}</h1>
                    <p class="text-white/70 text-sm font-light mt-1">{{ $user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="p-8 space-y-6">
            <!-- Personal Info Section -->
            <div class="space-y-4">
                <div class="space-y-1">
                    <h2 class="text-base font-bold text-gray-900 uppercase tracking-wider" style="color: #1B4965;">Informasi
                        Pribadi</h2>
                    <div class="w-16 h-0.5" style="background-color: #FFD166;"></div>
                </div>

                <div class="space-y-3">
                    <!-- Name -->
                    <div class="p-4 rounded-2xl border-2 border-gray-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->name ?? '-' }}</p>
                    </div>

                    <!-- Email -->
                    <div class="p-4 rounded-2xl border-2 border-gray-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</label>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->email ?? '-' }}</p>
                    </div>

                    <!-- Phone -->
                    <div class="p-4 rounded-2xl border-2 border-gray-200">
                        <label class="text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Telepon</label>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $user->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="w-full h-px bg-gray-200"></div>

            <!-- Menu Items -->
            <div class="space-y-3">
                <!-- Booking History -->
                <button onclick="window.location.href='/booking-history'"
                    class="w-full border-2 border-gray-200 rounded-2xl py-5 px-6 flex items-center justify-between transition-all hover:shadow-lg group bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-6 h-6" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-sm text-gray-900 uppercase tracking-wide">Riwayat Booking</p>
                            <p class="text-xs text-gray-500 mt-0.5">Lihat semua booking Anda</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Settings -->
                <button
                    class="w-full border-2 border-gray-200 rounded-2xl py-5 px-6 flex items-center justify-between transition-all hover:shadow-lg group bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-6 h-6" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-sm text-gray-900 uppercase tracking-wide">Pengaturan</p>
                            <p class="text-xs text-gray-500 mt-0.5">Ubah preferensi akun</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Help -->
                <button
                    class="w-full border-2 border-gray-200 rounded-2xl py-5 px-6 flex items-center justify-between transition-all hover:shadow-lg group bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-6 h-6" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-sm text-gray-900 uppercase tracking-wide">Bantuan</p>
                            <p class="text-xs text-gray-500 mt-0.5">FAQ & Dukungan</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Divider -->
            <div class="w-full h-px bg-gray-200"></div>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full text-white font-bold py-4 px-6 rounded-2xl transition-all hover:shadow-xl flex items-center justify-center gap-3 group"
                    style="background-color: #dc2626;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-sm uppercase tracking-wider">Keluar</span>
                </button>
        </div>
    </div>
@endsection
