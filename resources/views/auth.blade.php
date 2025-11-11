@extends('main-layout')

@section('content')
    <!-- Auth Container -->
    <div class="bg-white min-h-screen overflow-hidden relative">

        <!-- Hero Section - Swiss Design -->
        <div class="relative h-screen overflow-hidden">
            <!-- Background Image with Blur -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                    alt="Mountain Background" class="w-full h-full object-cover scale-110 blur-sm">
            </div>

            <!-- Gradient Overlay - Navy Theme -->
            <div class="absolute inset-0"
                style="background: linear-gradient(to bottom, rgba(27, 73, 101, 0.4) 0%, rgba(27, 73, 101, 0.7) 50%, rgba(27, 73, 101, 0.9) 100%);">
            </div>

            <!-- Auth Card - Centered -->
            <div class="absolute inset-0 flex items-center justify-center p-6">
                <div class="w-full max-w-md space-y-8 animate-fade-in">
                    <!-- Logo & Title -->
                    <div class="text-center space-y-3">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 mb-2">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-white tracking-tight">SmartAzone</h1>
                        <p class="text-white/80 text-sm font-light">Petualangan dimulai dari sini</p>
                    </div>

                    <!-- Auth Card -->
                    <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 overflow-hidden">
                        <!-- Tab Navigation -->
                        <div class="p-6 pb-4">
                            <div class="flex rounded-2xl p-1" style="background-color: #CAE9FF;">
                                <button onclick="switchTab('login')" id="loginTab"
                                    class="flex-1 py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-300 text-white shadow-lg"
                                    style="background-color: #1B4965;">
                                    Masuk
                                </button>
                                <button onclick="switchTab('signup')" id="signupTab"
                                    class="flex-1 py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-300 hover:bg-white/50"
                                    style="color: #1B4965;">
                                    Daftar
                                </button>
                            </div>
                        </div>

                        <!-- Login Form -->
                        <div id="loginForm" class="px-6 pb-6 space-y-5">
                            <!-- Email Input -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Email</label>
                                <input type="email" placeholder="nama@email.com"
                                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all">
                            </div>

                            <!-- Password Input -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Password</label>
                                <input type="password" placeholder="••••••••"
                                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all">
                            </div>

                            <!-- Forgot Password -->
                            <div class="text-right">
                                <a href="#"
                                    class="text-xs font-semibold text-gray-600 hover:text-gray-900 transition-colors">Lupa
                                    password?</a>
                            </div>

                            <!-- Login Button -->
                            <button
                                class="w-full text-white py-4 rounded-xl font-semibold transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0"
                                style="background-color: #1B4965; hover:background-color: #153a52;">
                                Masuk
                            </button>

                            <!-- Divider -->
                            <div class="relative py-4">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span
                                        class="px-4 text-xs text-gray-500 bg-white font-medium uppercase tracking-wide">Atau</span>
                                </div>
                            </div>

                            <!-- Social Login -->
                            <div class="space-y-3">
                                <button
                                    class="w-full flex items-center justify-center gap-3 py-3.5 border-2 border-gray-200 rounded-xl hover:border-gray-300 hover:bg-gray-50 transition-all group">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill="#4285F4"
                                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                        <path fill="#34A853"
                                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                        <path fill="#FBBC05"
                                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                        <path fill="#EA4335"
                                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                    </svg>
                                    <span
                                        class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">Google</span>
                                </button>
                            </div>
                        </div>

                        <!-- Sign Up Form -->
                        <div id="signupForm" class="px-6 pb-6 space-y-5 hidden">
                            <!-- Name Input -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Nama
                                    Lengkap</label>
                                <input type="text" placeholder="John Doe"
                                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all">
                            </div>

                            <!-- Email Input -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Email</label>
                                <input type="email" placeholder="nama@email.com"
                                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all">
                            </div>

                            <!-- Phone Input -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-700 uppercase tracking-wide">No.
                                    Telepon</label>
                                <input type="tel" placeholder="08123456789"
                                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all">
                            </div>

                            <!-- Password Input -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-gray-700 uppercase tracking-wide">Password</label>
                                <input type="password" placeholder="••••••••"
                                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-gray-900 focus:ring-4 focus:ring-gray-900/10 transition-all">
                            </div>

                            <!-- Sign Up Button -->
                            <button
                                class="w-full text-white py-4 rounded-xl font-semibold transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 mt-2"
                                style="background-color: #1B4965;">
                                Daftar Sekarang
                            </button>

                            <!-- Divider -->
                            <div class="relative py-4">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span
                                        class="px-4 text-xs text-gray-500 bg-white font-medium uppercase tracking-wide">Atau</span>
                                </div>
                            </div>

                            <!-- Social Sign Up -->
                            <div class="space-y-3">
                                <button
                                    class="w-full flex items-center justify-center gap-3 py-3.5 border-2 border-gray-200 rounded-xl hover:border-gray-300 hover:bg-gray-50 transition-all group">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill="#4285F4"
                                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                        <path fill="#34A853"
                                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                        <path fill="#FBBC05"
                                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                        <path fill="#EA4335"
                                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                    </svg>
                                    <span
                                        class="text-sm font-semibold text-gray-700 group-hover:text-gray-900">Google</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            animation: fade-in 0.5s ease-out;
        }

        /* Smooth tab transition */
        #loginForm,
        #signupForm {
            animation: fade-in 0.3s ease-out;
        }
    </style>

    <script>
        function switchTab(tabName) {
            const loginTab = document.getElementById('loginTab');
            const signupTab = document.getElementById('signupTab');
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');

            if (tabName === 'login') {
                // Active login tab
                loginTab.style.backgroundColor = '#1B4965';
                loginTab.style.color = 'white';
                loginTab.classList.add('shadow-lg');
                signupTab.style.backgroundColor = 'transparent';
                signupTab.style.color = '#1B4965';
                signupTab.classList.remove('shadow-lg');

                // Show login form, hide signup form with fade
                setTimeout(() => {
                    loginForm.classList.remove('hidden');
                    signupForm.classList.add('hidden');
                }, 150);
            } else {
                // Active signup tab
                signupTab.style.backgroundColor = '#1B4965';
                signupTab.style.color = 'white';
                signupTab.classList.add('shadow-lg');
                loginTab.style.backgroundColor = 'transparent';
                loginTab.style.color = '#1B4965';
                loginTab.classList.remove('shadow-lg');

                // Show signup form, hide login form with fade
                setTimeout(() => {
                    signupForm.classList.remove('hidden');
                    loginForm.classList.add('hidden');
                }, 150);
            }
        }

        // Add focus glow effect
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('scale-[1.01]');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('scale-[1.01]');
                });
            });
        });
    </script>
@endsection
