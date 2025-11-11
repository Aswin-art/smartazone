@extends('main-layout')

@section('content')
    <!-- Booking History Container -->
    <div class="bg-white min-h-screen overflow-hidden">
        <!-- Header - Navy Background -->
        <div class="relative px-8 py-12" style="background-color: #1B4965;">
            <!-- Back Button -->
            <button onclick="window.location.href='/profile'"
                class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Header Title -->
            <div class="text-center space-y-3">
                <div
                    class="inline-flex items-center justify-center w-14 h-14 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm mb-2">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-white">
                    RIWAYAT BOOKING
                </h1>
                <p class="text-white/70 text-sm font-light tracking-wide">
                    Semua pendakian Anda
                </p>
            </div>
        </div>

        <!-- Filter & Stats Section -->
        <div class="px-8 py-6" style="background-color: #CAE9FF;">
            <div class="flex items-center justify-between gap-4">
                <!-- Stats -->
                <div class="flex gap-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold" style="color: #1B4965;">12</p>
                        <p class="text-xs text-gray-600 uppercase tracking-wider">Total</p>
                    </div>
                    <div class="w-px bg-gray-300"></div>
                    <div class="text-center">
                        <p class="text-2xl font-bold" style="color: #1B4965;">8</p>
                        <p class="text-xs text-gray-600 uppercase tracking-wider">Selesai</p>
                    </div>
                    <div class="w-px bg-gray-300"></div>
                    <div class="text-center">
                        <p class="text-2xl font-bold" style="color: #FFD166;">2</p>
                        <p class="text-xs text-gray-600 uppercase tracking-wider">Aktif</p>
                    </div>
                </div>

                <!-- Filter Button -->
                <button onclick="toggleFilter()"
                    class="w-10 h-10 rounded-xl flex items-center justify-center border-2 transition-all hover:shadow-lg"
                    style="border-color: #1B4965; background-color: white;">
                    <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Filter Panel (Hidden by default) -->
        <div id="filterPanel" class="hidden px-8 py-4 border-b border-gray-200">
            <div class="space-y-3">
                <div class="flex gap-2 flex-wrap">
                    <button class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border-2"
                        style="background-color: #1B4965; color: white; border-color: #1B4965;">
                        Semua
                    </button>
                    <button
                        class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border-2 hover:shadow-lg"
                        style="color: #1B4965; border-color: #1B4965; background-color: white;">
                        Aktif
                    </button>
                    <button
                        class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border-2 hover:shadow-lg"
                        style="color: #1B4965; border-color: #1B4965; background-color: white;">
                        Selesai
                    </button>
                    <button
                        class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-all border-2 hover:shadow-lg"
                        style="color: #1B4965; border-color: #1B4965; background-color: white;">
                        Dibatalkan
                    </button>
                </div>
            </div>
        </div>

        <!-- Booking List -->
        <div class="p-8 space-y-4">
            <!-- Booking Card 1 - Active -->
            <div class="border-2 rounded-2xl overflow-hidden transition-all hover:shadow-xl animate-fade-in"
                style="border-color: #FFD166;">
                <!-- Card Header -->
                <div class="p-5" style="background-color: #FFD166;">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-sm uppercase tracking-wider" style="color: #1B4965;">Gunung Bromo</h3>
                            <p class="text-xs mt-1" style="color: #1B4965;">BRG-2024-001</p>
                        </div>
                        <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-white"
                            style="color: #1B4965;">
                            Aktif
                        </span>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 space-y-4 bg-white">
                    <!-- Date Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</p>
                            <p class="text-sm font-bold text-gray-900">15 - 17 Nov 2024</p>
                        </div>
                    </div>

                    <!-- Participants Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pendaki</p>
                            <p class="text-sm font-bold text-gray-900">4 Orang</p>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Biaya</p>
                            <p class="text-sm font-bold text-gray-900">Rp 2.400.000</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="w-full h-px bg-gray-200"></div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button
                            class="flex-1 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:shadow-lg border-2"
                            style="color: #1B4965; border-color: #1B4965; background-color: white;">
                            Detail
                        </button>
                        <button
                            class="flex-1 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:shadow-xl text-white"
                            style="background-color: #1B4965;">
                            Tracking
                        </button>
                    </div>
                </div>
            </div>

            <!-- Booking Card 2 - Completed -->
            <div
                class="border-2 border-gray-200 rounded-2xl overflow-hidden transition-all hover:shadow-xl animate-fade-in">
                <!-- Card Header -->
                <div class="p-5 bg-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-sm uppercase tracking-wider" style="color: #1B4965;">Gunung Semeru
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">SMR-2024-002</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-green-100 text-green-700">
                            Selesai
                        </span>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 space-y-4 bg-white">
                    <!-- Date Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</p>
                            <p class="text-sm font-bold text-gray-900">1 - 4 Okt 2024</p>
                        </div>
                    </div>

                    <!-- Participants Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pendaki</p>
                            <p class="text-sm font-bold text-gray-900">2 Orang</p>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Biaya</p>
                            <p class="text-sm font-bold text-gray-900">Rp 1.800.000</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="w-full h-px bg-gray-200"></div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button
                            class="flex-1 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:shadow-lg border-2"
                            style="color: #1B4965; border-color: #1B4965; background-color: white;">
                            Detail
                        </button>
                        <button
                            class="flex-1 py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:shadow-lg border-2"
                            style="color: #1B4965; border-color: #1B4965; background-color: white;">
                            Berikan Rating
                        </button>
                    </div>
                </div>
            </div>

            <!-- Booking Card 3 - Completed -->
            <div
                class="border-2 border-gray-200 rounded-2xl overflow-hidden transition-all hover:shadow-xl animate-fade-in">
                <!-- Card Header -->
                <div class="p-5 bg-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-sm uppercase tracking-wider" style="color: #1B4965;">Gunung Rinjani
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">RNJ-2024-003</p>
                        </div>
                        <span
                            class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-green-100 text-green-700">
                            Selesai
                        </span>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 space-y-4 bg-white">
                    <!-- Date Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</p>
                            <p class="text-sm font-bold text-gray-900">20 - 23 Sep 2024</p>
                        </div>
                    </div>

                    <!-- Participants Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pendaki</p>
                            <p class="text-sm font-bold text-gray-900">3 Orang</p>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                            style="background-color: #CAE9FF;">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Biaya</p>
                            <p class="text-sm font-bold text-gray-900">Rp 3.200.000</p>
                        </div>
                    </div>

                    <!-- Rating Display -->
                    <div class="p-3 rounded-xl" style="background-color: #CAE9FF;">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1">
                                <svg class="w-4 h-4" style="color: #FFD166;" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" style="color: #FFD166;" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" style="color: #FFD166;" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" style="color: #FFD166;" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg class="w-4 h-4" style="color: #FFD166;" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold" style="color: #1B4965;">5.0 · Pengalaman Luar Biasa!</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="w-full h-px bg-gray-200"></div>

                    <!-- Action Button -->
                    <button
                        class="w-full py-3 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:shadow-lg border-2"
                        style="color: #1B4965; border-color: #1B4965; background-color: white;">
                        Detail
                    </button>
                </div>
            </div>

            <!-- Empty State (Hidden when there's data) -->
            <div class="hidden py-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-4"
                    style="background-color: #CAE9FF;">
                    <svg class="w-10 h-10" style="color: #1B4965;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Riwayat</h3>
                <p class="text-sm text-gray-500 mb-6">Mulai petualangan pertama Anda sekarang!</p>
                <button onclick="window.location.href='/booking'"
                    class="px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-white transition-all hover:shadow-xl"
                    style="background-color: #1B4965;">
                    Booking Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- CSS Animations -->
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }

        /* Staggered animation for cards */
        .animate-fade-in:nth-child(1) {
            animation-delay: 0.1s;
        }

        .animate-fade-in:nth-child(2) {
            animation-delay: 0.2s;
        }

        .animate-fade-in:nth-child(3) {
            animation-delay: 0.3s;
        }
    </style>

    <!-- JavaScript -->
    <script>
        function toggleFilter() {
            const filterPanel = document.getElementById('filterPanel');
            filterPanel.classList.toggle('hidden');
        }

        // Initialize page with fade-in animation
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.animate-fade-in');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.opacity = '1';
                }, index * 100);
            });
        });
    </script>
@endsection
