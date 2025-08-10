@extends('main-layout')

@section('content')
    <div class="max-w-lg mx-auto bg-white min-h-screen shadow-2xl overflow-hidden relative">
        <!-- Header dengan Image Unggulan -->
        <div class="relative overflow-hidden">
            <!-- Gambar -->
            <div class="h-96">
                <img src="https://images.unsplash.com/photo-1548013146-72479768bada?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                    alt="Hero" class="w-full h-full object-cover rounded-b-3xl" />
            </div>

            <!-- Overlay gelap -->
            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-b-3xl"></div>

            <!-- Teks di atas gambar -->
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <h1 class="text-3xl font-bold leading-tight mb-2">Experience the wonders of the world</h1>
                <p class="text-lg opacity-90">And conquer with us</p>
            </div>
        </div>
        <div class="w-full max-w-lg">
            <!-- Main Card -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 p-8 relative overflow-hidden"
                style="background-color: rgba(247, 247, 247, 0.8);">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 rounded-full blur-3xl opacity-15 -translate-y-16 translate-x-16"
                    style="background: linear-gradient(135deg, #1B4965 0%, #CAE9FF 100%);"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 rounded-full blur-2xl opacity-15 translate-y-12 -translate-x-12"
                    style="background: linear-gradient(135deg, #FFD166 0%, #1B4965 100%);"></div>

                <!-- Input Tanggal Pergi dan Pulang -->
                <div class="mb-8">
                    <h3 class="font-semibold text-lg mb-4 flex items-center space-x-2" style="color: #1A1A1A;">
                        <div class="w-2 h-2 rounded-full" style="background-color: #1B4965;"></div>
                        <span>Tanggal Pendakian</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <label class="block text-sm font-medium mb-2" style="color: #1B4965;">Tanggal Berangkat</label>
                            <input type="date" id="departureDate"
                                class="w-full p-4 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 hover:shadow-md font-medium"
                                style="background-color: rgba(255, 255, 255, 0.7); border-color: #CAE9FF; color: #1A1A1A; focus:ring-color: #1B4965; focus:border-color: transparent;">
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-medium mb-2" style="color: #1B4965;">Tanggal Kembali</label>
                            <input type="date" id="returnDate"
                                class="w-full p-4 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 hover:shadow-md font-medium"
                                style="background-color: rgba(255, 255, 255, 0.7); border-color: #CAE9FF; color: #1A1A1A; focus:ring-color: #1B4965; focus:border-color: transparent;">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium mb-2" style="color: #1B4965;">Jumlah Pendaki</label>
                        <input type="number" id="climberCount" min="1" max="10" value="1"
                            class="w-full p-4 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 hover:shadow-md font-medium"
                            style="background-color: rgba(255, 255, 255, 0.7); border-color: #CAE9FF; color: #1A1A1A; focus:ring-color: #1B4965; focus:border-color: transparent;">
                    </div>
                </div>

                <!-- Form Pengisian Data Diri (Hidden initially) -->
                <div id="formContainer" class="mb-8 relative hidden">
                    <div class="backdrop-blur-sm rounded-2xl p-6 border"
                        style="background: linear-gradient(135deg, rgba(247, 247, 247, 0.5) 0%, rgba(255, 255, 255, 0.5) 100%); border-color: rgba(202, 233, 255, 0.5);">
                        <h3 class="font-semibold text-lg mb-6 flex items-center space-x-2" style="color: #1A1A1A;">
                            <div class="w-2 h-2 rounded-full" style="background-color: #FFD166;"></div>
                            <span>Data Pendaki Utama</span>
                        </h3>

                        <div class="space-y-4">
                            <div class="relative">
                                <input type="text" placeholder="Nama Lengkap"
                                    class="w-full p-4 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 hover:shadow-md font-medium"
                                    style="background-color: rgba(255, 255, 255, 0.7); border-color: #CAE9FF; color: #1A1A1A; focus:ring-color: #1B4965; focus:border-color: transparent;">
                            </div>
                            <div class="relative">
                                <input type="email" placeholder="Email Address"
                                    class="w-full p-4 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 hover:shadow-md font-medium"
                                    style="background-color: rgba(255, 255, 255, 0.7); border-color: #CAE9FF; color: #1A1A1A; focus:ring-color: #1B4965; focus:border-color: transparent;">
                            </div>
                            <div class="relative">
                                <input type="tel" placeholder="Nomor Telepon"
                                    class="w-full p-4 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 hover:shadow-md font-medium"
                                    style="background-color: rgba(255, 255, 255, 0.7); border-color: #CAE9FF; color: #1A1A1A; focus:ring-color: #1B4965; focus:border-color: transparent;">
                            </div>
                            <div class="relative">
                                <textarea placeholder="Pengalaman Mendaki & Catatan Khusus" rows="3"
                                    class="w-full p-4 backdrop-blur-sm border rounded-xl focus:outline-none focus:ring-2 transition-all duration-300 hover:shadow-md resize-none font-medium"
                                    style="background-color: rgba(255, 255, 255, 0.7); border-color: #CAE9FF; color: #1A1A1A; focus:ring-color: #1B4965; focus:border-color: transparent;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Sewa Peralatan -->
                <div class="mb-8">
                    <button id="equipmentBtn"
                        class="group w-full font-medium py-4 px-6 rounded-2xl border transition-all duration-300 hover:shadow-lg hover:-translate-y-1 relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed"
                        style="background: linear-gradient(135deg, #F7F7F7 0%, #CAE9FF 50%); border-color: #CAE9FF; color: #1A1A1A;">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-all duration-500"
                            style="background: linear-gradient(135deg, #1B4965 0%, #FFD166 100%);"></div>
                        <div class="relative flex items-center justify-center space-x-3">
                            <svg class="w-5 h-5 transition-colors" style="color: #1B4965;" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Sewa Peralatan Gunung</span>
                        </div>
                    </button>
                </div>

                <!-- Total Harga -->
                <div class="mb-8">
                    <div class="rounded-2xl p-6 border shadow-inner"
                        style="background: linear-gradient(135deg, #CAE9FF 0%, #E8F4FF 100%); border-color: rgba(27, 73, 101, 0.2);">
                        <h3 class="font-semibold text-lg mb-4 flex items-center space-x-2" style="color: #1A1A1A;">
                            <div class="w-2 h-2 rounded-full" style="background-color: #FFD166;"></div>
                            <span>Rincian Biaya</span>
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b"
                                style="border-color: rgba(27, 73, 101, 0.15);">
                                <span style="color: #1B4965;">Tiket Masuk Gunung</span>
                                <span id="entranceFee" class="font-semibold" style="color: #1A1A1A;">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b"
                                style="border-color: rgba(27, 73, 101, 0.15);">
                                <span style="color: #1B4965;">Jumlah Pendaki (<span id="climberDisplay">0</span>
                                    orang)</span>
                                <span id="climberFee" class="font-semibold" style="color: #1A1A1A;">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b"
                                style="border-color: rgba(27, 73, 101, 0.15);">
                                <span style="color: #1B4965;">Peralatan yang Disewa</span>
                                <span id="equipmentFee" class="font-semibold" style="color: #1A1A1A;">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center pt-3 border-t-2"
                                style="border-color: rgba(27, 73, 101, 0.3);">
                                <span class="text-lg font-bold" style="color: #1A1A1A;">Total Biaya</span>
                                <span id="totalPrice" class="text-2xl font-bold" style="color: #1B4965;">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button id="submitBtn"
                    class="group w-full text-white font-semibold py-4 px-6 rounded-2xl transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden disabled:opacity-50 disabled:cursor-not-allowed"
                    style="background: linear-gradient(135deg, #1B4965 0%, #2A5A7A 100%);">
                    <div class="absolute inset-0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"
                        style="background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);">
                    </div>
                    <div class="relative flex items-center justify-center space-x-3">
                        <span class="text-lg">Konfirmasi Booking</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Peralatan -->
    <div id="equipmentModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[80vh] overflow-hidden">
            <div class="p-6 text-white" style="background: linear-gradient(135deg, #1B4965 0%, #2A5A7A 100%);">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">Peralatan Gunung</h2>
                    <button id="closeModal" class="p-2 hover:bg-white/20 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6 max-h-96 overflow-y-auto">
                <div class="space-y-4" id="equipmentList">
                    <!-- Equipment items will be populated here -->
                </div>
            </div>

            <div class="border-t p-6" style="background-color: #F7F7F7;">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold" style="color: #1A1A1A;">Total Peralatan:</span>
                    <span id="modalTotal" class="text-xl font-bold" style="color: #1B4965;">Rp 0</span>
                </div>
                <button id="confirmEquipment" class="w-full text-white font-semibold py-3 rounded-xl transition-all"
                    style="background: linear-gradient(135deg, #1B4965 0%, #2A5A7A 100%);">
                    Konfirmasi Pilihan
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departureDate = document.getElementById('departureDate');
            const returnDate = document.getElementById('returnDate');
            const climberCount = document.getElementById('climberCount');
            const formContainer = document.getElementById('formContainer');
            const equipmentBtn = document.getElementById('equipmentBtn');
            const equipmentModal = document.getElementById('equipmentModal');
            const closeModal = document.getElementById('closeModal');
            const confirmEquipment = document.getElementById('confirmEquipment');
            const submitBtn = document.getElementById('submitBtn');

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
                        alert('Tanggal kembali harus setelah tanggal berangkat!');
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
                updatePricing();
            });

            // Equipment modal
            equipmentBtn.addEventListener('click', function() {
                if (!equipmentBtn.disabled) {
                    showEquipmentModal();
                }
            });

            closeModal.addEventListener('click', function() {
                equipmentModal.classList.add('hidden');
            });

            function showEquipmentModal() {
                const equipmentList = document.getElementById('equipmentList');
                equipmentList.innerHTML = '';

                equipmentData.forEach(item => {
                    const quantity = selectedEquipment[item.id] || 0;
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'border rounded-xl p-4';
                    itemDiv.style =
                        'background: linear-gradient(135deg, #F7F7F7 0%, #CAE9FF 30%); border-color: #CAE9FF;';
                    itemDiv.innerHTML = `
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium" style="color: #1A1A1A;">${item.name}</span>
                            <span class="font-semibold" style="color: #1B4965;">Rp ${item.price.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button class="decrease-btn w-8 h-8 rounded-lg transition-colors" data-id="${item.id}" style="background-color: rgba(220, 38, 38, 0.1); color: #DC2626;">-</button>
                            <span class="quantity w-8 text-center font-semibold" data-id="${item.id}" style="color: #1A1A1A;">${quantity}</span>
                            <button class="increase-btn w-8 h-8 rounded-lg transition-colors" data-id="${item.id}" style="background-color: rgba(27, 73, 101, 0.1); color: #1B4965;">+</button>
                        </div>
                    `;
                    equipmentList.appendChild(itemDiv);
                });

                // Add event listeners for quantity buttons
                document.querySelectorAll('.decrease-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.dataset.id;
                        if (selectedEquipment[id] > 0) {
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
                        const id = this.dataset.id;
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
                    const item = equipmentData.find(eq => eq.id === id);
                    if (item) {
                        total += item.price * selectedEquipment[id];
                    }
                });
                document.getElementById('modalTotal').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            confirmEquipment.addEventListener('click', function() {
                currentPrices.equipment = 0;
                Object.keys(selectedEquipment).forEach(id => {
                    const item = equipmentData.find(eq => eq.id === id);
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
                    equipmentBtn.innerHTML = `
                        <div class="absolute inset-0 opacity-20" style="background: linear-gradient(135deg, #1B4965 0%, #FFD166 100%);"></div>
                        <div class="relative flex items-center justify-center space-x-3">
                            <svg class="w-5 h-5" style="color: #1B4965;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-semibold" style="color: #1A1A1A;">${itemCount} Peralatan Dipilih</span>
                        </div>
                    `;
                    equipmentBtn.style =
                        'background: linear-gradient(135deg, #CAE9FF 0%, #E8F4FF 100%); border-color: #FFD166; color: #1A1A1A;';
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
                    this.innerHTML = `
                        <div class="relative flex items-center justify-center space-x-3">
                            <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>Processing...</span>
                        </div>
                    `;

                    setTimeout(() => {
                        this.innerHTML = `
                            <div class="relative flex items-center justify-center space-x-3">
                                <svg class="w-5 h-5" style="color: #CAE9FF;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Booking Berhasil!</span>
                            </div>
                        `;
                    }, 2000);
                }
            });
        });
    </script>
@endsection
