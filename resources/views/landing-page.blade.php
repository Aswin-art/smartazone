@extends('main-layout')

@section('content')
    <div class="max-w-lg mx-auto bg-white min-h-screen shadow-2xl overflow-hidden relative">
        <div class="relative">
            <div class="rounded-b-3xl absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/60 z-10">
            </div>
            <div class="h-96">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Mountain Vista" class="w-full h-full object-cover rounded-b-3xl">
            </div>
            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full px-4 py-2 z-20">
                <span class="text-white text-sm font-medium">⛰️ 1.500 Mdpl</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                <h1 class="text-white text-3xl font-bold mb-2 drop-shadow-lg">Gunung Bromo</h1>
                <div class="flex items-center gap-4 text-white/90">
                    <span class="flex items-center gap-1 text-sm">
                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                        Buka Sekarang
                    </span>
                    <span class="text-sm">☀️ Cuaca Cerah</span>
                </div>
            </div>
        </div>

        <div class="px-6 py-6 space-y-8 pb-32">
            <div class="space-y-3">
                <h2 class="text-xl font-semibold text-gray-900">Tentang Destinasi</h2>
                <p class="text-gray-600 leading-relaxed text-sm">
                    Nikmati keindahan matahari terbit di salah satu gunung berapi paling ikonik di Indonesia.
                    Pemandangan spektakuler dan pengalaman tak terlupakan menanti Anda di ketinggian 2.329 meter.
                </p>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                    <div class="text-2xl mb-1">🌅</div>
                    <div class="text-xs text-gray-600 font-medium">Sunrise</div>
                    <div class="text-sm font-semibold text-gray-900">05:30</div>
                </div>
                <div
                    class="text-center p-4 bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl border border-emerald-100">
                    <div class="text-2xl mb-1">🌡️</div>
                    <div class="text-xs text-gray-600 font-medium">Suhu</div>
                    <div class="text-sm font-semibold text-gray-900">15-20°C</div>
                </div>
                <div
                    class="text-center p-4 bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-100">
                    <div class="text-2xl mb-1">⭐</div>
                    <div class="text-xs text-gray-600 font-medium">Rating</div>
                    <div class="text-sm font-semibold text-gray-900">4.8/5</div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Galeri Foto</h3>
                    <button class="text-sm text-blue-600 font-medium hover:text-blue-800 transition-colors">Lihat
                        Semua</button>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="h-28 rounded-2xl overflow-hidden border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 cursor-pointer"
                            onclick="openImageModal('https://gelorajatim.com/wp-content/uploads/2024/08/IMG-20240828-WA0020-scaled.jpg')">
                            <img src="https://gelorajatim.com/wp-content/uploads/2024/08/IMG-20240828-WA0020-scaled.jpg"
                                alt="Gallery {{ $i }}" class="w-full h-full object-cover">
                        </div>
                    @endfor
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Flora & Fauna</h3>
                    <button class="text-sm text-blue-600 font-medium hover:text-blue-800 transition-colors">Lihat
                        Semua</button>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="cursor-pointer group" onclick="openFloraModal('edelweiss')">
                        <div
                            class="h-32 bg-gradient-to-br from-emerald-50 to-green-100 rounded-2xl border border-emerald-200 overflow-hidden hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <img src="https://images.unsplash.com/photo-1594736797933-d0501ba2fe65?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                alt="Edelweiss" class="w-full h-full object-cover">
                        </div>
                        <div class="text-center mt-2">
                            <div class="text-sm font-medium text-gray-900 group-hover:text-emerald-600 transition-colors">
                                Edelweiss</div>
                            <div class="text-xs text-gray-600">Bunga abadi</div>
                        </div>
                    </div>
                    <div class="cursor-pointer group" onclick="openFloraModal('elang')">
                        <div
                            class="h-32 bg-gradient-to-br from-amber-50 to-yellow-100 rounded-2xl border border-amber-200 overflow-hidden hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                            <img src="https://images.unsplash.com/photo-1611273426858-450d8e3c9fce?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                                alt="Elang Jawa" class="w-full h-full object-cover">
                        </div>
                        <div class="text-center mt-2">
                            <div class="text-sm font-medium text-gray-900 group-hover:text-amber-600 transition-colors">
                                Elang Jawa</div>
                            <div class="text-xs text-gray-600">Burung langka</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Kontak</h3>
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-lg">📧</span>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Email</div>
                            <div class="text-sm text-gray-600">info@gunungbromo.id</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 text-lg">📞</span>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">WhatsApp</div>
                            <div class="text-sm text-gray-600">+62 812 3456 7890</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                            <span class="text-pink-600 text-lg">📷</span>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">Instagram</div>
                            <div class="text-sm text-gray-600">@gunungbromo_official</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-1/2 transform -translate-x-1/2 w-full max-w-lg px-4 pb-4 z-50">
            <div class="bg-white/80 backdrop-blur-md rounded-t-3xl p-4 shadow-2xl border-t border-gray-200">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <div class="text-lg font-bold text-gray-900">Mulai dari</div>
                        <div class="text-2xl font-bold text-blue-600">Rp 250.000</div>
                        <div class="text-xs text-gray-500">per orang</div>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center gap-1 text-sm text-amber-500 font-medium">
                            <span>⭐</span>
                            <span>4.8</span>
                        </div>
                        <div class="text-xs text-gray-500">1.234 ulasan</div>
                    </div>
                </div>
                <button
                    class="w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white font-semibold py-4 rounded-2xl shadow-lg hover:shadow-xl hover:from-blue-600 hover:via-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                    <span>🎟️</span>
                    <span>Booking Sekarang</span>
                </button>
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <img id="modalImage" src="" alt="Full size image"
                class="max-w-full max-h-full object-contain rounded-2xl">
            <button onclick="closeImageModal()"
                class="absolute top-4 right-4 bg-white bg-opacity-20 backdrop-blur-md rounded-full p-2 text-white hover:bg-opacity-30 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Enhanced Flora Modal -->
    <div id="floraModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header with Image Carousel -->
            <div class="relative h-64">
                <div id="imageCarousel" class="w-full h-full relative overflow-hidden rounded-t-3xl">
                    <!-- Images will be dynamically added here -->
                </div>

                <!-- Carousel Navigation -->
                <button id="prevBtn" onclick="changeImage(-1)"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-md rounded-full p-2 text-white hover:bg-white/30 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>

                <button id="nextBtn" onclick="changeImage(1)"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 backdrop-blur-md rounded-full p-2 text-white hover:bg-white/30 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </button>

                <!-- Image Counter -->
                <div id="imageCounter"
                    class="absolute bottom-4 left-4 bg-black/50 backdrop-blur-md rounded-full px-3 py-1">
                    <span class="text-white text-sm font-medium">1 / 4</span>
                </div>

                <!-- Close Button -->
                <button onclick="closeFloraModal()"
                    class="absolute top-4 right-4 bg-white/20 backdrop-blur-md rounded-full p-2 text-white hover:bg-white/30 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="p-6 space-y-6">
                    <!-- Title Section -->
                    <div class="text-center space-y-2">
                        <h3 id="floraTitle" class="text-3xl font-bold text-gray-900"></h3>
                        <p id="floraSubtitle" class="text-lg text-gray-600 italic"></p>
                        <div id="conservationStatus"
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium"></div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-4">
                        <div id="floraDescription" class="text-gray-700 leading-relaxed space-y-3"></div>
                    </div>

                    <!-- Characteristics Grid -->
                    <div id="characteristicsGrid" class="grid grid-cols-2 gap-4">
                        <!-- Dynamic characteristics will be added here -->
                    </div>

                    <!-- Habitat Info -->
                    <div id="habitatInfo"
                        class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                            <span>🏔️</span>
                            <span>Habitat & Persebaran</span>
                        </h4>
                        <div id="habitatContent" class="text-sm text-gray-700 space-y-2"></div>
                    </div>

                    <!-- Conservation Note -->
                    <div id="conservationNote"
                        class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                            <span>⚠️</span>
                            <span>Status Konservasi</span>
                        </h4>
                        <div id="conservationContent" class="text-sm text-gray-700"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentImageIndex = 0;
        let currentImages = [];

        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function changeImage(direction) {
            currentImageIndex += direction;
            if (currentImageIndex < 0) currentImageIndex = currentImages.length - 1;
            if (currentImageIndex >= currentImages.length) currentImageIndex = 0;

            updateCarouselImage();
        }

        function updateCarouselImage() {
            const carousel = document.getElementById('imageCarousel');
            const counter = document.getElementById('imageCounter');

            carousel.innerHTML = `
                <img src="${currentImages[currentImageIndex]}"
                     alt="Flora/Fauna Image"
                     class="w-full h-full object-cover transition-opacity duration-300">
            `;

            counter.innerHTML =
                `<span class="text-white text-sm font-medium">${currentImageIndex + 1} / ${currentImages.length}</span>`;
        }

        function openFloraModal(type) {
            const floraData = {
                edelweiss: {
                    title: 'Edelweiss',
                    subtitle: 'Leontopodium alpinum',
                    status: {
                        text: 'Dilindungi',
                        class: 'bg-yellow-100 text-yellow-800'
                    },
                    images: [
                        'https://images.unsplash.com/photo-1594736797933-d0501ba2fe65?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ],
                    description: `
                        <p>Edelweiss adalah bunga yang tumbuh di daerah pegunungan tinggi dan dikenal sebagai "bunga abadi" karena keindahannya yang tahan lama. Bunga ini menjadi simbol keabadian, cinta sejati, dan keberanian karena tumbuh di tempat-tempat yang sulit dijangkau.</p>
                        <p>Di Indonesia, edelweiss ditemukan di berbagai gunung tinggi termasuk Gunung Bromo, Semeru, Gede-Pangrango, dan gunung-gunung tinggi lainnya. Bunga ini memiliki adaptasi khusus untuk bertahan hidup di kondisi ekstrem pegunungan.</p>
                    `,
                    characteristics: [{
                            icon: '📏',
                            label: 'Tinggi',
                            value: '20-60 cm'
                        },
                        {
                            icon: '🌸',
                            label: 'Warna',
                            value: 'Putih keperakan'
                        },
                        {
                            icon: '🏔️',
                            label: 'Ketinggian',
                            value: '1.500-3.000 mdpl'
                        },
                        {
                            icon: '🌡️',
                            label: 'Suhu',
                            value: '5-15°C'
                        }
                    ],
                    habitat: `
                        <p>• Tumbuh di padang rumput alpine dan lereng gunung yang terbuka</p>
                        <p>• Membutuhkan drainase yang baik dan sinar matahari penuh</p>
                        <p>• Tersebar di Jawa, Sumatra, dan Sulawesi</p>
                        <p>• Habitat utama: Gunung Gede-Pangrango, Bromo-Tengger-Semeru, Kerinci</p>
                    `,
                    conservation: `Edelweiss termasuk tanaman yang dilindungi karena populasinya yang terus menurun akibat pengambilan liar untuk dijual sebagai bunga kering. Pengambilan edelweiss dari habitat aslinya dapat merusak ekosistem pegunungan dan mengurangi biodiversitas.`
                },
                elang: {
                    title: 'Elang Jawa',
                    subtitle: 'Nisaetus bartelsi',
                    status: {
                        text: 'Terancam Punah',
                        class: 'bg-red-100 text-red-800'
                    },
                    images: [
                        'https://images.unsplash.com/photo-1611273426858-450d8e3c9fce?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1551522435-a13afa10f66a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1574263867128-c8c2b27f3a0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
                    ],
                    description: `
                        <p>Elang Jawa adalah burung endemik Indonesia yang menjadi lambang negara dan merupakan salah satu raptor paling langka di dunia. Dengan populasi kurang dari 1.000 ekor di alam liar, burung ini menghadapi ancaman serius kepunahan.</p>
                        <p>Sebagai predator puncak di ekosistem hutan Jawa, Elang Jawa memainkan peran penting dalam menjaga keseimbangan rantai makanan. Keberadaannya menjadi indikator kesehatan ekosistem hutan.</p>
                    `,
                    characteristics: [{
                            icon: '📐',
                            label: 'Panjang',
                            value: '60-70 cm'
                        },
                        {
                            icon: '🦅',
                            label: 'Rentang Sayap',
                            value: '110-130 cm'
                        },
                        {
                            icon: '⚖️',
                            label: 'Berat',
                            value: '1.2-1.8 kg'
                        },
                        {
                            icon: '🥚',
                            label: 'Telur',
                            value: '1-2 butir'
                        }
                    ],
                    habitat: `
                        <p>• Hutan primer dan sekunder di ketinggian 500-3.000 mdpl</p>
                        <p>• Tersebar di Jawa dan Bali (populasi sangat kecil)</p>
                        <p>• Habitat utama: Taman Nasional Gunung Halimun-Salak, Bromo-Tengger-Semeru</p>
                        <p>• Membutuhkan wilayah jelajah yang luas (1.000-2.000 hektar per pasang)</p>
                    `,
                    conservation: `Elang Jawa menghadapi ancaman serius dari deforestasi, perburuan ilegal, dan perdagangan satwa liar. Populasinya menurun drastis dengan perkiraan hanya tersisa 600-800 ekor dewasa di alam liar. Program konservasi intensif sedang dilakukan melalui perlindungan habitat, penangkaran, dan edukasi masyarakat.`
                }
            };

            const data = floraData[type];
            currentImages = data.images;
            currentImageIndex = 0;

            // Update modal content
            document.getElementById('floraTitle').textContent = data.title;
            document.getElementById('floraSubtitle').textContent = data.subtitle;
            document.getElementById('conservationStatus').innerHTML =
                `<span class="px-3 py-1 rounded-full text-sm font-medium ${data.status.class}">${data.status.text}</span>`;
            document.getElementById('floraDescription').innerHTML = data.description;
            document.getElementById('habitatContent').innerHTML = data.habitat;
            document.getElementById('conservationContent').innerHTML = data.conservation;

            // Update characteristics grid
            const characteristicsGrid = document.getElementById('characteristicsGrid');
            characteristicsGrid.innerHTML = data.characteristics.map(char => `
                <div class="bg-gray-50 rounded-xl p-3 text-center">
                    <div class="text-2xl mb-1">${char.icon}</div>
                    <div class="text-xs text-gray-600 font-medium">${char.label}</div>
                    <div class="text-sm font-semibold text-gray-900">${char.value}</div>
                </div>
            `).join('');

            // Initialize carousel
            updateCarouselImage();

            // Show modal
            document.getElementById('floraModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeFloraModal() {
            document.getElementById('floraModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        document.getElementById('floraModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFloraModal();
            }
        });

        // Keyboard navigation for image carousel
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('floraModal').classList.contains('hidden')) return;

            if (e.key === 'ArrowLeft') changeImage(-1);
            if (e.key === 'ArrowRight') changeImage(1);
            if (e.key === 'Escape') closeFloraModal();
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.getElementById('imageCarousel').addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.getElementById('imageCarousel').addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    changeImage(1); // Swipe left, next image
                } else {
                    changeImage(-1); // Swipe right, previous image
                }
            }
        }

        // Auto-hide floating button on scroll (optional enhancement)
        let lastScrollTop = 0;
        const floatingButton = document.querySelector('.fixed.bottom-0');

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                floatingButton.style.transform = 'translateX(-50%) translateY(100%)';
            } else {
                // Scrolling up
                floatingButton.style.transform = 'translateX(-50%) translateY(0)';
            }

            lastScrollTop = scrollTop;
        }, false);
    </script>
@endsection
