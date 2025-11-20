@extends('main-layout')

@section('content')
    <!-- Main Card Container - Swiss Design -->
    <div id="bookingPageRoot" class="bg-white min-h-screen overflow-hidden animate-fade-in" data-mountain-id="1">
        <!-- Header - Navy Background -->
        <div class="relative px-8 py-12" style="background-color: #1B4965;">
            <!-- Back Button -->
            <button onclick="window.history.back()"
                class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-xl bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Title - Swiss Typography -->
            <div class="text-center space-y-3">
                <div
                    class="inline-flex items-center justify-center w-14 h-14 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm mb-2">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold tracking-tight text-white">
                    BOOKING
                </h1>
                <p class="text-white/70 text-sm font-light tracking-wide">
                    Gunung Bromo · 2.329 MDPL
                </p>
            </div>
        </div>

        @guest
            <!-- Guest Prompt - Ask to Login (Full Width Section) -->
            <div class="px-8 py-20 min-h-screen" style="background-color: #CAE9FF;">
                <div class="max-w-xl mx-auto text-center space-y-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl mb-4"
                        style="background-color: #1B4965;">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight uppercase" style="color: #1B4965;">Masuk untuk Melanjutkan</h2>
                    <p class="text-base text-gray-700 font-light leading-relaxed max-w-md mx-auto">Silakan login terlebih dahulu
                        untuk mengisi formulir booking pendakian dan menikmati pengalaman penuh.</p>
                    <div class="flex items-center justify-center gap-4 pt-4">
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 text-white font-bold text-sm uppercase tracking-wider rounded-2xl hover:opacity-90 transition"
                            style="background-color: #1B4965;">Masuk</a>
                        <a href="/auth#signup"
                            class="px-8 py-4 font-bold text-sm uppercase tracking-wider rounded-2xl border-2 transition hover:bg-white"
                            style="border-color:#1B4965; color:#1B4965;">Daftar</a>
                    </div>
                </div>
            </div>
        @endguest

        @auth
            <!-- Progress Steps - Minimal Swiss -->
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-100">
                <div class="flex items-center justify-center gap-3">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm"
                            style="background-color: #1B4965; color: white;">
                            01
                        </div>
                        <span class="text-xs font-medium text-gray-900 hidden sm:inline uppercase tracking-wider">Jadwal</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-sm text-gray-400">
                            02
                        </div>
                        <span class="text-xs font-medium text-gray-400 hidden sm:inline uppercase tracking-wider">Data</span>
                    </div>
                    <div class="w-16 h-0.5 bg-gray-200"></div>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-sm text-gray-400">
                            03
                        </div>
                        <span class="text-xs font-medium text-gray-400 hidden sm:inline uppercase tracking-wider">Bayar</span>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8 space-y-8">
                <!-- Pilih Tanggal Section -->
                <div class="space-y-5">
                    <div class="space-y-1">
                        <h2 class="text-base font-bold text-gray-900 uppercase tracking-wider" style="color: #1B4965;">01 ·
                            Pilih Tanggal</h2>
                        <div class="w-16 h-0.5" style="background-color: #FFD166;"></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="departureDate"
                                class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                Tanggal Berangkat
                            </label>
                            <input type="date" id="departureDate"
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:border-transparent transition-all text-sm bg-white"
                                style="focus:ring-color: #1B4965;" required>
                        </div>

                        <div>
                            <label for="returnDate"
                                class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                Tanggal Kembali
                            </label>
                            <input type="date" id="returnDate"
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:border-transparent transition-all text-sm bg-white"
                                style="focus:ring-color: #1B4965;" required>
                        </div>

                        <div>
                            <label for="climberCount"
                                class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                Jumlah Pendaki
                            </label>
                            <input type="number" id="climberCount" min="1" max="10" value="1"
                                class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:border-transparent transition-all text-sm bg-white"
                                style="focus:ring-color: #1B4965;" required>
                        </div>
                    </div>
                </div>

                <!-- Divider Line -->
                <div class="w-full h-px bg-gray-200"></div>

                <!-- Form Pengisian Data Diri (Hidden initially) -->
                <div id="formContainer" class="space-y-8 hidden">
                    <div class="space-y-5">
                        <div class="space-y-1">
                            <h2 class="text-base font-bold text-gray-900 uppercase tracking-wider" style="color: #1B4965;">02 ·
                                Data Ketua Rombongan</h2>
                            <div class="w-16 h-0.5" style="background-color: #FFD166;"></div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="leaderName"
                                    class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                    Nama Lengkap
                                </label>
                                <input type="text" id="leaderName"
                                    class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:border-transparent transition-all text-sm bg-white"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div>
                                <label for="leaderEmail"
                                    class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                    Email
                                </label>
                                <input type="email" id="leaderEmail"
                                    class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:border-transparent transition-all text-sm bg-white"
                                    placeholder="example@email.com" required>
                            </div>
                            <div>
                                <label for="leaderPhone"
                                    class="block text-xs font-semibold text-gray-600 mb-2 uppercase tracking-wider">
                                    No. Telepon
                                </label>
                                <input type="tel" id="leaderPhone"
                                    class="w-full px-4 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:border-transparent transition-all text-sm bg-white"
                                    placeholder="08xxxxxxxxxx" required>
                            </div>
                        </div>
                    </div>

                    <!-- Button Data Anggota (Muncul jika pendaki > 1) -->
                    <div id="memberDataBtn" class="hidden">
                        <button onclick="openMemberModal()"
                            class="w-full border-2 border-gray-200 rounded-2xl py-5 px-6 flex items-center justify-between transition-all hover:shadow-lg group bg-white">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors"
                                    style="background-color: #CAE9FF;">
                                    <svg class="w-6 h-6" style="color: #1B4965;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p id="memberBtnText" class="font-bold text-sm text-gray-900 uppercase tracking-wide">
                                        Input Data Anggota</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Tambahkan informasi anggota lainnya</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Divider Line -->
                    <div class="w-full h-px bg-gray-200"></div>

                    <!-- Button Sewa Peralatan -->
                    <div>
                        <button id="equipmentBtn" disabled
                            class="w-full border-2 border-gray-200 rounded-2xl py-5 px-6 flex items-center justify-between transition-all hover:shadow-lg disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:shadow-none group bg-white">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center transition-colors"
                                    style="background-color: #CAE9FF;">
                                    <svg class="w-6 h-6" style="color: #1B4965;" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-sm text-gray-900 uppercase tracking-wide">Sewa Peralatan</p>
                                    <p class="text-xs text-gray-500 mt-0.5">Opsional · Pilih perlengkapan Anda</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Divider Line -->
                    <div class="w-full h-px bg-gray-200"></div>

                    <!-- Total Harga -->
                    <div>
                        <div class="rounded-2xl p-6 space-y-4" style="background-color: #CAE9FF;">
                            <h3 class="text-xs font-bold uppercase tracking-wider mb-4" style="color: #1B4965;">Rincian Biaya
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Biaya Masuk</span>
                                    <span id="entranceFee" class="font-bold" style="color: #1B4965;">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">
                                        Biaya Pendaki (<span id="climberDisplay">1</span> orang)
                                    </span>
                                    <span id="climberFee" class="font-bold" style="color: #1B4965;">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Sewa Peralatan</span>
                                    <span id="equipmentFee" class="font-bold" style="color: #1B4965;">Rp 0</span>
                                </div>
                            </div>
                            <div class="pt-4 mt-4 border-t-2" style="border-color: #1B4965;">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-sm uppercase tracking-wider"
                                        style="color: #1B4965;">Total</span>
                                    <span id="totalPrice" class="font-bold text-3xl" style="color: #1B4965;">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="p-8 border-t border-gray-100 bg-gray-50">
                <button id="submitBtn" disabled
                    class="w-full text-white font-bold py-4 px-6 rounded-2xl transition-all hover:shadow-xl disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:shadow-none flex items-center justify-center gap-3 group"
                    style="background-color: #1B4965;">
                    <span class="text-sm uppercase tracking-wider">Lanjutkan ke Pembayaran</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </div>

            <!-- Hidden Booking Form (auto-submitted by JS) -->
            <form id="bookingForm" method="POST" action="{{ route('booking.store') }}" class="hidden">
                @csrf
                <input type="hidden" name="hike_date" id="formHikeDate">
                <input type="hidden" name="return_date" id="formReturnDate">
                <input type="hidden" name="team_size" id="formTeamSize">
                <input type="hidden" name="members" id="formMembers">
                <input type="hidden" name="mountain_id" id="formMountainId" value="1">
            </form>
        @endauth
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

        /* Custom focus ring colors */
        input:focus {
            ring-color: #1B4965 !important;
        }
    </style>

    <!-- Modal Peralatan -->
    <div id="equipmentModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[85vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="p-6 text-white" style="background-color: #1B4965;">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold uppercase tracking-wide">Peralatan Gunung</h2>
                        <p class="text-xs text-white/70 mt-1">Pilih perlengkapan yang Anda butuhkan</p>
                    </div>
                    <button id="closeModal" class="p-2 hover:bg-white/10 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6 max-h-96 overflow-y-auto">
                <div class="space-y-3" id="equipmentList">
                    <!-- Equipment items will be populated here -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-100 p-6" style="background-color: #CAE9FF;">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider" style="color: #1B4965;">Total
                        Peralatan</span>
                    <span id="modalTotal" class="text-2xl font-bold" style="color: #1B4965;">Rp 0</span>
                </div>
                <button id="confirmEquipment"
                    class="w-full text-white font-bold py-4 rounded-2xl transition-all hover:shadow-lg uppercase tracking-wider text-sm"
                    style="background-color: #1B4965;">
                    Konfirmasi Pilihan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Data Anggota -->
    <div id="memberModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="p-6 text-white" style="background-color: #1B4965;">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold uppercase tracking-wide">Data Anggota Pendaki</h2>
                        <p class="text-xs text-white/70 mt-1">Masukkan informasi setiap anggota</p>
                    </div>
                    <button id="closeMemberModal" class="p-2 hover:bg-white/10 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6 max-h-96 overflow-y-auto">
                <div id="memberList">
                    <!-- Member forms will be populated here -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-100 p-6" style="background-color: #CAE9FF;">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider" style="color: #1B4965;">
                        Data Lengkap: <span id="completedMembers">0</span>/<span id="totalMembers">0</span>
                    </span>
                </div>
                <button id="confirmMembers"
                    class="w-full text-white font-bold py-4 rounded-2xl transition-all hover:shadow-lg uppercase tracking-wider text-sm"
                    style="background-color: #1B4965;">
                    Simpan Data Anggota
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const root = document.getElementById('bookingPageRoot');
            const mountainId = (root && root.dataset && root.dataset.mountainId) ? root.dataset.mountainId : '1';
            const departureDate = document.getElementById('departureDate');
            const returnDate = document.getElementById('returnDate');
            const climberCount = document.getElementById('climberCount');
            const formContainer = document.getElementById('formContainer');
            const memberDataBtn = document.getElementById('memberDataBtn');
            const equipmentBtn = document.getElementById('equipmentBtn');
            const equipmentModal = document.getElementById('equipmentModal');
            const memberModal = document.getElementById('memberModal');
            const closeModal = document.getElementById('closeModal');
            const closeMemberModal = document.getElementById('closeMemberModal');
            const confirmEquipment = document.getElementById('confirmEquipment');
            const confirmMembers = document.getElementById('confirmMembers');
            const submitBtn = document.getElementById('submitBtn');

            // Hidden form elements
            const bookingForm = document.getElementById('bookingForm');
            const formHikeDate = document.getElementById('formHikeDate');
            const formReturnDate = document.getElementById('formReturnDate');
            const formTeamSize = document.getElementById('formTeamSize');
            const formMembers = document.getElementById('formMembers');
            const formMountainId = document.getElementById('formMountainId');

            // Price elements
            const entranceFee = document.getElementById('entranceFee');
            const climberDisplay = document.getElementById('climberDisplay');
            const climberFee = document.getElementById('climberFee');
            const equipmentFee = document.getElementById('equipmentFee');
            const totalPrice = document.getElementById('totalPrice');

            // Equipment data
            const equipmentData = [{
                    name: 'Tenda 2-3 Orang',
                    price: 75000,
                    id: 'tent'
                },
                {
                    name: 'Sleeping Bag',
                    price: 35000,
                    id: 'sleeping_bag'
                },
                {
                    name: 'Carrier/Ransel 60L',
                    price: 50000,
                    id: 'carrier'
                },
                {
                    name: 'Matras/Sleeping Pad',
                    price: 25000,
                    id: 'matras'
                },
                {
                    name: 'Headlamp + Baterai',
                    price: 30000,
                    id: 'headlamp'
                },
                {
                    name: 'Kompor + Gas',
                    price: 45000,
                    id: 'stove'
                },
                {
                    name: 'Nesting (Set Masak)',
                    price: 40000,
                    id: 'nesting'
                },
                {
                    name: 'Jaket Gunung',
                    price: 60000,
                    id: 'jacket'
                },
                {
                    name: 'Sepatu Gunung',
                    price: 80000,
                    id: 'boots'
                },
                {
                    name: 'Trekking Pole',
                    price: 35000,
                    id: 'pole'
                }
            ];

            let selectedEquipment = {};
            let memberData = [];
            let currentPrices = {
                entrance: 0,
                climber: 0,
                equipment: 0
            };

            // Initially disable buttons
            equipmentBtn.disabled = true;
            submitBtn.disabled = true;

            // Date change handlers
            function checkDatesAndShowForm() {
                if (departureDate.value && returnDate.value) {
                    // Validate dates
                    const departure = new Date(departureDate.value);
                    const returnD = new Date(returnDate.value);

                    if (returnD <= departure) {
                        alert('Tanggal kembali harus setelah tanggal berangkat');
                        returnDate.value = '';
                        return;
                    }

                    // Show form and enable buttons
                    formContainer.classList.remove('hidden');
                    formContainer.classList.add('animate-fade-in');
                    equipmentBtn.disabled = false;
                    submitBtn.disabled = false;

                    // Calculate entrance fee (per day)
                    const days = Math.ceil((returnD - departure) / (1000 * 60 * 60 * 24));
                    currentPrices.entrance = days * 25000; // 25k per day entrance

                    updatePricing();
                } else {
                    formContainer.classList.add('hidden');
                    equipmentBtn.disabled = true;
                    submitBtn.disabled = true;
                    currentPrices.entrance = 0;
                    updatePricing();
                }
            }

            departureDate.addEventListener('change', checkDatesAndShowForm);
            returnDate.addEventListener('change', checkDatesAndShowForm);

            // Climber count change
            climberCount.addEventListener('change', function() {
                const count = parseInt(this.value) || 1;
                currentPrices.climber = count * 150000; // 150k per person
                updateMemberDataButton(count);
                initializeMemberData(count);
                updatePricing();
            });

            function updateMemberDataButton(count) {
                const memberBtnText = document.getElementById('memberBtnText');

                if (count > 1) {
                    memberDataBtn.classList.remove('hidden');
                    const remainingMembers = count - 1; // Exclude leader
                    memberBtnText.textContent = `Input Data Anggota Pendaki (${remainingMembers} orang)`;
                } else {
                    memberDataBtn.classList.add('hidden');
                }
            }

            function initializeMemberData(count) {
                // Initialize member data array (excluding leader)
                memberData = [];
                for (let i = 1; i < count; i++) {
                    memberData.push({
                        name: '',
                        email: '',
                        phone: ''
                    });
                }
            }

            // Member Modal Functions
            function openMemberModal() {
                populateMemberList();
                memberModal.classList.remove('hidden');
                memberModal.classList.add('flex');
            }

            function closeMemberModalFunc() {
                memberModal.classList.add('hidden');
                memberModal.classList.remove('flex');
                updateMemberProgress();
            }

            function populateMemberList() {
                const memberList = document.getElementById('memberList');
                const totalMembers = document.getElementById('totalMembers');

                memberList.innerHTML = '';
                totalMembers.textContent = memberData.length;

                memberData.forEach((member, index) => {
                    const memberForm = createMemberForm(member, index);
                    memberList.appendChild(memberForm);
                });

                updateMemberProgress();
            }

            function createMemberForm(member, index) {
                const div = document.createElement('div');
                div.className = 'mb-4 p-5 rounded-2xl border-2 border-gray-200 bg-white';

                div.innerHTML = `
                    <h4 class="font-bold mb-4 text-sm uppercase tracking-wider" style="color: #1B4965;">
                        Anggota ${index + 1}
                    </h4>
                    <div class="space-y-3">
                        <input type="text" placeholder="Nama Lengkap" value="${member.name}"
                            onchange="updateMemberData(${index}, 'name', this.value)"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all bg-white"
                            style="focus:ring-color: #1B4965;">
                        <input type="email" placeholder="Email" value="${member.email}"
                            onchange="updateMemberData(${index}, 'email', this.value)"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all bg-white"
                            style="focus:ring-color: #1B4965;">
                        <input type="tel" placeholder="No. Telepon" value="${member.phone}"
                            onchange="updateMemberData(${index}, 'phone', this.value)"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all bg-white"
                            style="focus:ring-color: #1B4965;">
                    </div>
                `;

                return div;
            }

            window.updateMemberData = function(index, field, value) {
                memberData[index][field] = value;
                updateMemberProgress();
            }

            function updateMemberProgress() {
                const completedMembers = memberData.filter(member =>
                    member.name.trim() !== '' && member.email.trim() !== '' && member.phone.trim() !== ''
                ).length;

                document.getElementById('completedMembers').textContent = completedMembers;

                // Update button text
                const memberBtnText = document.getElementById('memberBtnText');
                if (completedMembers === memberData.length && memberData.length > 0) {
                    memberBtnText.textContent = `Data Anggota Lengkap ✓`;
                } else {
                    memberBtnText.textContent = `Input Data Anggota Pendaki (${memberData.length} orang)`;
                }
            }

            // Equipment modal
            equipmentBtn.addEventListener('click', function() {
                if (!equipmentBtn.disabled) {
                    showEquipmentModal();
                }
            });

            closeModal.addEventListener('click', function() {
                equipmentModal.classList.add('hidden');
            });

            closeMemberModal.addEventListener('click', closeMemberModalFunc);
            confirmMembers.addEventListener('click', closeMemberModalFunc);

            // Make openMemberModal global
            window.openMemberModal = openMemberModal;

            function showEquipmentModal() {
                const equipmentList = document.getElementById('equipmentList');
                equipmentList.innerHTML = '';

                equipmentData.forEach(item => {
                    const quantity = selectedEquipment[item.id] || 0;
                    const itemDiv = document.createElement('div');
                    itemDiv.className =
                        'border-2 border-gray-200 rounded-2xl p-4 bg-white hover:border-gray-300 transition-colors';
                    itemDiv.innerHTML = `
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-sm text-gray-900">${item.name}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Rp ${item.price.toLocaleString('id-ID')}/hari</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</span>
                            <div class="flex items-center gap-2">
                                <button class="decrease-btn w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors flex items-center justify-center text-sm" data-id="${item.id}">−</button>
                                <span class="quantity w-10 text-center font-bold text-sm text-gray-900" data-id="${item.id}">${quantity}</span>
                                <button class="increase-btn w-10 h-10 rounded-xl text-white font-bold transition-colors flex items-center justify-center text-sm" data-id="${item.id}" style="background-color: #1B4965;">+</button>
                            </div>
                        </div>
                    `;
                    equipmentList.appendChild(itemDiv);
                });

                // Add event listeners for quantity buttons
                document.querySelectorAll('.decrease-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        if (selectedEquipment[id] && selectedEquipment[id] > 0) {
                            selectedEquipment[id]--;
                            if (selectedEquipment[id] === 0) {
                                delete selectedEquipment[id];
                            }
                            updateModalQuantity(id);
                            updateModalTotal();
                        }
                    });
                });

                document.querySelectorAll('.increase-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        selectedEquipment[id] = (selectedEquipment[id] || 0) + 1;
                        updateModalQuantity(id);
                        updateModalTotal();
                    });
                });

                updateModalTotal();
                equipmentModal.classList.remove('hidden');
                equipmentModal.classList.add('flex');
            }

            function updateModalQuantity(id) {
                const quantitySpan = document.querySelector(`.quantity[data-id="${id}"]`);
                if (quantitySpan) {
                    quantitySpan.textContent = selectedEquipment[id] || 0;
                }
            }

            function updateModalTotal() {
                let total = 0;
                Object.keys(selectedEquipment).forEach(id => {
                    const item = equipmentData.find(e => e.id === id);
                    if (item) {
                        total += item.price * selectedEquipment[id];
                    }
                });
                document.getElementById('modalTotal').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            confirmEquipment.addEventListener('click', function() {
                currentPrices.equipment = 0;
                Object.keys(selectedEquipment).forEach(id => {
                    const item = equipmentData.find(e => e.id === id);
                    if (item) {
                        currentPrices.equipment += item.price * selectedEquipment[id];
                    }
                });

                updatePricing();
                equipmentModal.classList.add('hidden');
                equipmentModal.classList.remove('flex');

                // Update equipment button text
                const itemCount = Object.values(selectedEquipment).reduce((sum, qty) => sum + qty, 0);
                if (itemCount > 0) {
                    equipmentBtn.querySelector('.text-left p:first-child').textContent =
                        `Peralatan Dipilih (${itemCount} item)`;
                } else {
                    equipmentBtn.querySelector('.text-left p:first-child').textContent = 'Sewa Peralatan';
                }
            });

            function updatePricing() {
                const climbers = parseInt(climberCount.value) || 1;

                entranceFee.textContent = `Rp ${currentPrices.entrance.toLocaleString('id-ID')}`;
                climberDisplay.textContent = climbers;
                climberFee.textContent = `Rp ${currentPrices.climber.toLocaleString('id-ID')}`;
                equipmentFee.textContent = `Rp ${currentPrices.equipment.toLocaleString('id-ID')}`;

                const total = currentPrices.entrance + currentPrices.climber + currentPrices.equipment;
                totalPrice.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            // Initialize pricing
            updatePricing();

            // Submit handler
            submitBtn.addEventListener('click', function() {
                if (!submitBtn.disabled) {
                    // Validate form
                    const leaderName = document.getElementById('leaderName').value.trim();
                    const leaderEmail = document.getElementById('leaderEmail').value.trim();
                    const leaderPhone = document.getElementById('leaderPhone').value.trim();

                    if (!leaderName || !leaderEmail || !leaderPhone) {
                        alert('Mohon lengkapi semua data ketua rombongan');
                        return;
                    }

                    // Check if all member data is complete for multi-climber bookings
                    if (memberData.length > 0) {
                        const incompletemembers = memberData.filter(m =>
                            !m.name.trim() || !m.email.trim() || !m.phone.trim()
                        );
                        if (incompletemembers.length > 0) {
                            alert('Mohon lengkapi data semua anggota pendaki');
                            return;
                        }
                    }

                    // Populate hidden form fields
                    formHikeDate.value = departureDate.value;
                    formReturnDate.value = returnDate.value;
                    formTeamSize.value = parseInt(climberCount.value) || 1;
                    // Only companions (excludes leader) are included in members
                    formMembers.value = JSON.stringify(memberData);
                    formMountainId.value = mountainId;

                    // Submit the form to the server
                    bookingForm.submit();
                }
            });
        });
    </script>
@endsection
