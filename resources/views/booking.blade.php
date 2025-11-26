@extends('main-layout')

@section('content')
    <!-- Main Container - Functional Swiss Design -->
    <div class="bg-white min-h-screen font-sans text-neutral-900 pb-32" data-mountain-id="1">
        
        <!-- Header - Solid Brand Color -->
        <div class="bg-[#1B4965] px-6 pt-16 pb-12 rounded-b-[2.5rem] shadow-xl shadow-[#1B4965]/10 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

            <!-- Back Button -->
            <button onclick="window.history.back()" class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-md z-20 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div class="relative z-10 text-center mt-4 opacity-0 animate-enter">
                <h1 class="text-3xl font-medium tracking-tight text-white mb-2">
                    Booking
                </h1>
                <p class="text-sm text-white/70 font-medium tracking-wide">
                    Gunung Bromo · 2,329 MDPL
                </p>
            </div>
        </div>

        @guest
            <!-- Guest Prompt -->
            <div class="px-6 py-12 text-center opacity-0 animate-enter" style="animation-delay: 0.1s">
                <div class="w-20 h-20 bg-neutral-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-neutral-900 mb-3">Access Required</h2>
                <p class="text-sm text-neutral-500 mb-8 max-w-xs mx-auto">Please login to continue your booking process securely.</p>
                <div class="flex flex-col gap-3">
                    <a href="/auth" class="w-full py-3.5 bg-[#1B4965] text-white text-xs font-bold uppercase tracking-wider rounded-full hover:bg-[#153a51] transition-colors">
                        Login
                    </a>
                    <a href="/auth" class="w-full py-3.5 border border-neutral-200 text-neutral-600 text-xs font-bold uppercase tracking-wider rounded-full hover:bg-neutral-50 transition-colors">
                        Register
                    </a>
                </div>
            </div>
        @endguest

        @auth
            <div class="px-6 -mt-8 relative z-20">
                <!-- Progress Steps -->
                <div class="bg-white rounded-2xl shadow-lg shadow-neutral-100 border border-neutral-100 p-4 mb-8 flex items-center justify-between max-w-sm mx-auto opacity-0 animate-enter" style="animation-delay: 0.1s">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-[#1B4965]"></div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#1B4965]">Schedule</span>
                    </div>
                    <div class="w-8 h-px bg-neutral-100"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-neutral-200"></div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-400">Data</span>
                    </div>
                    <div class="w-8 h-px bg-neutral-100"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-neutral-200"></div>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-neutral-400">Pay</span>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="space-y-8 opacity-0 animate-enter" style="animation-delay: 0.2s">
                    <!-- Schedule Section -->
                    <section class="bg-white rounded-3xl border border-neutral-200 p-6 space-y-6">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-6 h-6 rounded-full bg-[#1B4965]/10 text-[#1B4965] text-xs font-bold flex items-center justify-center">1</span>
                            <h2 class="text-sm font-bold uppercase tracking-wide text-neutral-900">Select Schedule</h2>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Departure</label>
                                <input type="date" id="departureDate" class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Return</label>
                                <input type="date" id="returnDate" class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Climbers</label>
                                <div class="relative">
                                    <input type="number" id="climberCount" min="1" max="10" value="1" class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-neutral-400">Persons</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Data Section (Hidden initially) -->
                    <div id="formContainer" class="space-y-8 hidden">
                        <section class="bg-white rounded-3xl border border-neutral-200 p-6 space-y-6">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="w-6 h-6 rounded-full bg-[#1B4965]/10 text-[#1B4965] text-xs font-bold flex items-center justify-center">2</span>
                                <h2 class="text-sm font-bold uppercase tracking-wide text-neutral-900">Leader Data</h2>
                            </div>

                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Full Name</label>
                                    <input type="text" id="leaderName" placeholder="As per ID Card" class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none placeholder:text-neutral-300">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Email</label>
                                    <input type="email" id="leaderEmail" placeholder="example@email.com" class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none placeholder:text-neutral-300">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Phone</label>
                                    <input type="tel" id="leaderPhone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none placeholder:text-neutral-300">
                                </div>
                            </div>
                        </section>

                        <!-- Member Button -->
                        <div id="memberDataBtn" class="hidden">
                            <button onclick="openMemberModal()" class="w-full group bg-white border border-neutral-200 rounded-2xl p-5 flex items-center justify-between hover:border-[#1B4965] transition-all duration-300 shadow-sm hover:shadow-md">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-[#1B4965]/5 flex items-center justify-center text-[#1B4965] group-hover:bg-[#1B4965] group-hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p id="memberBtnText" class="font-bold text-neutral-900 text-xs uppercase tracking-wide">Member Data</p>
                                        <p class="text-[10px] text-neutral-400 mt-0.5">Required for insurance</p>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-neutral-300 group-hover:text-[#1B4965] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <!-- Equipment Button -->
                        <button id="equipmentBtn" disabled class="w-full group bg-white border border-neutral-200 rounded-2xl p-5 flex items-center justify-between hover:border-[#1B4965] transition-all duration-300 shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:border-neutral-200 disabled:hover:shadow-none">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-[#1B4965]/5 flex items-center justify-center text-[#1B4965] group-hover:bg-[#1B4965] group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-bold text-neutral-900 text-xs uppercase tracking-wide">Rent Equipment</p>
                                    <p class="text-[10px] text-neutral-400 mt-0.5">Optional · Tents, Jackets, etc.</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-neutral-300 group-hover:text-[#1B4965] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Price Summary -->
                        <div class="bg-neutral-50 rounded-3xl p-6 border border-neutral-100">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-1 h-4 bg-[#1B4965] rounded-full"></div>
                                <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-900">Cost Summary</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-neutral-500">Entrance Ticket</span>
                                    <span id="entranceFee" class="font-semibold text-neutral-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-neutral-500">Climber Fee (<span id="climberDisplay">1</span>x)</span>
                                    <span id="climberFee" class="font-semibold text-neutral-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-neutral-500">Equipment</span>
                                    <span id="equipmentFee" class="font-semibold text-neutral-900">Rp 0</span>
                                </div>
                                
                                <div class="pt-4 border-t border-neutral-200 mt-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-xs uppercase tracking-widest text-neutral-900">Total</span>
                                        <span id="totalPrice" class="font-bold text-xl text-[#1B4965]">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Submit Button -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-neutral-100 p-4 z-30 pb-8">
                <div class="max-w-3xl mx-auto">
                    <button id="submitBtn" disabled class="w-full bg-[#1B4965] text-white font-bold py-4 px-6 rounded-full transition-all hover:bg-[#153a51] hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:shadow-none flex items-center justify-center gap-3 group">
                        <span class="text-xs uppercase tracking-widest">Proceed to Payment</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Hidden Form -->
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

    <!-- Equipment Modal -->
    <div id="equipmentModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[85vh] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-neutral-100 flex items-center justify-between bg-white">
                <div>
                    <h2 class="text-sm font-bold text-neutral-900 uppercase tracking-wide">Equipment</h2>
                    <p class="text-[10px] text-neutral-500 mt-1">Optional add-ons</p>
                </div>
                <button id="closeModal" class="p-2 hover:bg-neutral-50 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-1">
                <div class="space-y-3" id="equipmentList"></div>
            </div>
            <div class="border-t border-neutral-100 p-6 bg-neutral-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Total</span>
                    <span id="modalTotal" class="text-lg font-bold text-[#1B4965]">Rp 0</span>
                </div>
                <button id="confirmEquipment" class="w-full bg-[#1B4965] text-white font-bold py-3.5 rounded-full transition-all hover:bg-[#153a51] uppercase tracking-widest text-xs">
                    Save Selection
                </button>
            </div>
        </div>
    </div>

    <!-- Member Modal -->
    <div id="memberModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-hidden flex flex-col">
            <div class="p-6 border-b border-neutral-100 flex items-center justify-between bg-white">
                <div>
                    <h2 class="text-sm font-bold text-neutral-900 uppercase tracking-wide">Member Data</h2>
                    <p class="text-[10px] text-neutral-500 mt-1">Complete all climber details</p>
                </div>
                <button id="closeMemberModal" class="p-2 hover:bg-neutral-50 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 bg-neutral-50">
                <div id="memberList" class="space-y-4"></div>
            </div>
            <div class="border-t border-neutral-100 p-6 bg-white">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">
                        Filled: <span id="completedMembers" class="text-[#1B4965]">0</span>/<span id="totalMembers">0</span>
                    </span>
                </div>
                <button id="confirmMembers" class="w-full bg-[#1B4965] text-white font-bold py-3.5 rounded-full transition-all hover:bg-[#153a51] uppercase tracking-widest text-xs">
                    Save Data
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // GSAP Animations
            gsap.to(".animate-enter", {
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.1,
                ease: "power2.out"
            });

            // Logic (Kept mostly same, updated styling references)
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
            const equipmentData = [
                { name: 'Tent 2-3 Person', price: 75000, id: 'tent' },
                { name: 'Sleeping Bag', price: 35000, id: 'sleeping_bag' },
                { name: 'Carrier 60L', price: 50000, id: 'carrier' },
                { name: 'Sleeping Pad', price: 25000, id: 'matras' },
                { name: 'Headlamp + Battery', price: 30000, id: 'headlamp' },
                { name: 'Stove + Gas', price: 45000, id: 'stove' },
                { name: 'Cooking Set', price: 40000, id: 'nesting' },
                { name: 'Jacket', price: 60000, id: 'jacket' },
                { name: 'Hiking Boots', price: 80000, id: 'boots' },
                { name: 'Trekking Pole', price: 35000, id: 'pole' }
            ];

            let selectedEquipment = {};
            let memberData = [];
            let currentPrices = { entrance: 0, climber: 0, equipment: 0 };

            // Date change handlers
            function checkDatesAndShowForm() {
                if (departureDate.value && returnDate.value) {
                    const departure = new Date(departureDate.value);
                    const returnD = new Date(returnDate.value);

                    if (returnD <= departure) {
                        alert('Return date must be after departure date');
                        returnDate.value = '';
                        return;
                    }

                    formContainer.classList.remove('hidden');
                    equipmentBtn.disabled = false;
                    submitBtn.disabled = false;

                    const days = Math.ceil((returnD - departure) / (1000 * 60 * 60 * 24));
                    currentPrices.entrance = days * 25000;
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
                currentPrices.climber = count * 150000;
                updateMemberDataButton(count);
                initializeMemberData(count);
                updatePricing();
            });

            function updateMemberDataButton(count) {
                const memberBtnText = document.getElementById('memberBtnText');
                if (count > 1) {
                    memberDataBtn.classList.remove('hidden');
                    const remainingMembers = count - 1;
                    memberBtnText.textContent = `Member Data (${remainingMembers} persons)`;
                } else {
                    memberDataBtn.classList.add('hidden');
                }
            }

            function initializeMemberData(count) {
                memberData = [];
                for (let i = 1; i < count; i++) {
                    memberData.push({ name: '', email: '', phone: '', nik: '' });
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
                    memberList.appendChild(createMemberForm(member, index));
                });
                updateMemberProgress();
            }

            function createMemberForm(member, index) {
                const div = document.createElement('div');
                div.className = 'p-5 rounded-2xl border border-neutral-200 bg-white shadow-sm';
                div.innerHTML = `
                    <h4 class="font-bold mb-4 text-[10px] uppercase tracking-widest text-[#1B4965]">Member ${index + 1}</h4>
                    <div class="space-y-3">
                        <input type="text" placeholder="Full Name" value="${member.name}" onchange="updateMemberData(${index}, 'name', this.value)" class="w-full px-4 py-3 bg-neutral-50 border-0 rounded-xl text-sm focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none">
                        <input type="number" placeholder="NIK (KTP)" value="${member.nik || ''}" onchange="updateMemberData(${index}, 'nik', this.value)" class="w-full px-4 py-3 bg-neutral-50 border-0 rounded-xl text-sm focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none">
                        <input type="email" placeholder="Email" value="${member.email}" onchange="updateMemberData(${index}, 'email', this.value)" class="w-full px-4 py-3 bg-neutral-50 border-0 rounded-xl text-sm focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none">
                        <input type="tel" placeholder="Phone" value="${member.phone}" onchange="updateMemberData(${index}, 'phone', this.value)" class="w-full px-4 py-3 bg-neutral-50 border-0 rounded-xl text-sm focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none">
                    </div>
                `;
                return div;
            }

            window.updateMemberData = function(index, field, value) {
                memberData[index][field] = value;
                updateMemberProgress();
            }

            function updateMemberProgress() {
                const completedMembers = memberData.filter(member => member.name.trim() !== '' && member.email.trim() !== '' && member.phone.trim() !== '' && member.nik.trim() !== '').length;
                document.getElementById('completedMembers').textContent = completedMembers;
                const memberBtnText = document.getElementById('memberBtnText');
                if (completedMembers === memberData.length && memberData.length > 0) {
                    memberBtnText.textContent = `Member Data Complete ✓`;
                    memberBtnText.classList.add('text-green-600');
                } else {
                    memberBtnText.textContent = `Member Data (${memberData.length} persons)`;
                    memberBtnText.classList.remove('text-green-600');
                }
            }

            // Equipment modal
            equipmentBtn.addEventListener('click', function() {
                if (!equipmentBtn.disabled) showEquipmentModal();
            });

            closeModal.addEventListener('click', () => {
                equipmentModal.classList.add('hidden');
                equipmentModal.classList.remove('flex');
            });

            closeMemberModal.addEventListener('click', closeMemberModalFunc);
            confirmMembers.addEventListener('click', closeMemberModalFunc);
            window.openMemberModal = openMemberModal;

            function showEquipmentModal() {
                const equipmentList = document.getElementById('equipmentList');
                equipmentList.innerHTML = '';
                equipmentData.forEach(item => {
                    const quantity = selectedEquipment[item.id] || 0;
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'border border-neutral-200 rounded-2xl p-4 bg-white hover:border-[#1B4965]/50 transition-all';
                    itemDiv.innerHTML = `
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-sm text-neutral-900">${item.name}</p>
                                <p class="text-[10px] text-neutral-500 mt-0.5">Rp ${item.price.toLocaleString('id-ID')}/day</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">Qty</span>
                            <div class="flex items-center gap-3">
                                <button class="decrease-btn w-8 h-8 rounded-lg bg-neutral-100 hover:bg-neutral-200 text-neutral-600 font-bold transition-colors flex items-center justify-center text-lg leading-none" data-id="${item.id}">−</button>
                                <span class="quantity w-8 text-center font-bold text-sm text-neutral-900" data-id="${item.id}">${quantity}</span>
                                <button class="increase-btn w-8 h-8 rounded-lg bg-[#1B4965] text-white font-bold transition-colors flex items-center justify-center text-lg leading-none shadow-md shadow-[#1B4965]/20" data-id="${item.id}">+</button>
                            </div>
                        </div>
                    `;
                    equipmentList.appendChild(itemDiv);
                });

                document.querySelectorAll('.decrease-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        if (selectedEquipment[id] && selectedEquipment[id] > 0) {
                            selectedEquipment[id]--;
                            if (selectedEquipment[id] === 0) delete selectedEquipment[id];
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
                if (quantitySpan) quantitySpan.textContent = selectedEquipment[id] || 0;
            }

            function updateModalTotal() {
                let total = 0;
                Object.keys(selectedEquipment).forEach(id => {
                    const item = equipmentData.find(e => e.id === id);
                    if (item) total += item.price * selectedEquipment[id];
                });
                document.getElementById('modalTotal').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            }

            confirmEquipment.addEventListener('click', function() {
                currentPrices.equipment = 0;
                Object.keys(selectedEquipment).forEach(id => {
                    const item = equipmentData.find(e => e.id === id);
                    if (item) currentPrices.equipment += item.price * selectedEquipment[id];
                });
                updatePricing();
                equipmentModal.classList.add('hidden');
                equipmentModal.classList.remove('flex');
                const itemCount = Object.values(selectedEquipment).reduce((sum, qty) => sum + qty, 0);
                const btnText = equipmentBtn.querySelector('.text-left p:first-child');
                btnText.textContent = itemCount > 0 ? `Equipment Selected (${itemCount} items)` : 'Rent Equipment';
                if(itemCount > 0) btnText.classList.add('text-[#1B4965]');
                else btnText.classList.remove('text-[#1B4965]');
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

            updatePricing();

            submitBtn.addEventListener('click', function() {
                if (!submitBtn.disabled) {
                    const leaderName = document.getElementById('leaderName').value.trim();
                    const leaderEmail = document.getElementById('leaderEmail').value.trim();
                    const leaderPhone = document.getElementById('leaderPhone').value.trim();

                    if (!leaderName || !leaderEmail || !leaderPhone) {
                        alert('Please complete all leader details');
                        return;
                    }

                    if (memberData.length > 0) {
                        const incompletemembers = memberData.filter(m => !m.name.trim() || !m.email.trim() || !m.phone.trim() || !m.nik.trim());
                        if (incompletemembers.length > 0) {
                            alert('Please complete all member details');
                            return;
                        }
                    }

                    formHikeDate.value = departureDate.value;
                    formReturnDate.value = returnDate.value;
                    formTeamSize.value = parseInt(climberCount.value) || 1;
                    formMembers.value = JSON.stringify(memberData);
                    formMountainId.value = mountainId;
                    bookingForm.submit();
                }
            });
        });
    </script>
    <style>
        .animate-enter { transform: translateY(20px); }
    </style>