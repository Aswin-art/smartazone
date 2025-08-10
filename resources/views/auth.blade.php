@extends('main-layout')

@section('content')
    <!-- Mobile Container -->
    <div class="max-w-lg mx-auto bg-white min-h-screen shadow-2xl overflow-hidden relative">

        <!-- Hero Image with Overlay Text -->
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

        <!-- Tabs and Forms Section -->
        <div class="p-6">
            <!-- Tab Navigation -->
            <div class="flex bg-gray-100 rounded-full p-1 mb-6">
                <button onclick="switchTab('login')" id="loginTab"
                    class="flex-1 py-3 px-4 rounded-full font-semibold text-sm transition-all duration-200 bg-black text-white">
                    Login
                </button>
                <button onclick="switchTab('signup')" id="signupTab"
                    class="flex-1 py-3 px-4 rounded-full font-semibold text-sm transition-all duration-200 text-gray-600">
                    Sign Up
                </button>
            </div>

            <!-- Login Form -->
            <div id="loginForm" class="space-y-4">
                <!-- Email Input -->
                <div>
                    <input type="email" placeholder="Email"
                        class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <!-- Password Input -->
                <div>
                    <input type="password" placeholder="Password"
                        class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <!-- Login Button -->
                <button
                    class="w-full bg-black text-white py-4 rounded-full font-semibold text-lg hover:bg-gray-800 transition-colors mt-6">
                    Login
                </button>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-gray-500 text-sm">or</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Social Login Options -->
                <div class="space-y-3">
                    <!-- Google -->
                    <button
                        class="w-full flex items-center justify-center py-4 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span class="text-gray-700 font-medium">Continue with Google</span>
                    </button>

                    <!-- Facebook -->
                    <button
                        class="w-full flex items-center justify-center py-4 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="#1877F2" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span class="text-gray-700 font-medium">Continue with Facebook</span>
                    </button>
                </div>
            </div>

            <!-- Sign Up Form -->
            <div id="signupForm" class="space-y-4 hidden">
                <!-- Email Input -->
                <div>
                    <input type="email" placeholder="Email"
                        class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <!-- Phone Input -->
                <div>
                    <input type="tel" placeholder="No. Telepon"
                        class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <!-- Password Input -->
                <div>
                    <input type="password" placeholder="Password"
                        class="w-full px-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <!-- Sign Up Button -->
                <button
                    class="w-full bg-black text-white py-4 rounded-full font-semibold text-lg hover:bg-gray-800 transition-colors mt-6">
                    Sign Up
                </button>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-4 text-gray-500 text-sm">or</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                <!-- Social Login Options -->
                <div class="space-y-3">
                    <!-- Google -->
                    <button
                        class="w-full flex items-center justify-center py-4 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                            <path fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span class="text-gray-700 font-medium">Continue with Google</span>
                    </button>

                    <!-- Facebook -->
                    <button
                        class="w-full flex items-center justify-center py-4 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="#1877F2" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span class="text-gray-700 font-medium">Continue with Facebook</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            const loginTab = document.getElementById('loginTab');
            const signupTab = document.getElementById('signupTab');
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');

            if (tabName === 'login') {
                // Active login tab
                loginTab.classList.add('bg-black', 'text-white');
                loginTab.classList.remove('text-gray-600');
                signupTab.classList.remove('bg-black', 'text-white');
                signupTab.classList.add('text-gray-600');

                // Show login form, hide signup form
                loginForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
            } else {
                // Active signup tab
                signupTab.classList.add('bg-black', 'text-white');
                signupTab.classList.remove('text-gray-600');
                loginTab.classList.remove('bg-black', 'text-white');
                loginTab.classList.add('text-gray-600');

                // Show signup form, hide login form
                signupForm.classList.remove('hidden');
                loginForm.classList.add('hidden');
            }
        }
    </script>
@endsection
