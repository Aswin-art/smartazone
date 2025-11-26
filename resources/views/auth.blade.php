@extends('main-layout')

@section('content')
    <div class="bg-white min-h-screen font-sans text-neutral-900 pb-32">
        
        <!-- Header Section - Solid Brand Color -->
        <div class="bg-[#1B4965] px-6 pt-16 pb-12 rounded-b-[2.5rem] shadow-xl shadow-[#1B4965]/10 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 mb-6 shadow-lg shadow-[#1B4965]/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white tracking-tight mb-2">Welcome Back</h1>
                <p class="text-sm text-white/70 font-medium">Start your adventure with SmartAzone</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="px-6 mt-8">
            <!-- Tabs -->
            <div class="flex items-center gap-8 border-b border-neutral-100 mb-8 relative">
                <button onclick="switchTab('login')" id="loginTab" class="pb-4 text-sm font-bold uppercase tracking-widest text-[#1B4965] relative transition-colors w-1/2 text-center">
                    Login
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#1B4965] rounded-t-full transition-all duration-300" id="loginIndicator"></span>
                </button>
                <button onclick="switchTab('signup')" id="signupTab" class="pb-4 text-sm font-bold uppercase tracking-widest text-neutral-400 hover:text-neutral-600 relative transition-colors w-1/2 text-center">
                    Register
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#1B4965] rounded-t-full scale-x-0 transition-all duration-300" id="signupIndicator"></span>
                </button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" method="POST" action="{{ route('auth.login') }}" class="space-y-6 animate-fade-in">
                @csrf
                <div class="space-y-5">
                    <div class="group">
                        <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#1B4965] transition-colors">Email Address</label>
                        <input type="email" name="email" placeholder="name@example.com" class="w-full px-0 py-3 bg-transparent border-b border-neutral-200 text-neutral-900 font-medium placeholder:text-neutral-300 focus:border-[#1B4965] focus:ring-0 transition-all outline-none">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#1B4965] transition-colors">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full px-0 py-3 bg-transparent border-b border-neutral-200 text-neutral-900 font-medium placeholder:text-neutral-300 focus:border-[#1B4965] focus:ring-0 transition-all outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 rounded border-neutral-300 text-[#1B4965] focus:ring-[#1B4965]/20">
                        <span class="text-xs font-medium text-neutral-500">Remember me</span>
                    </label>
                    <a href="#" class="text-xs font-bold text-[#1B4965] hover:text-[#153a51]">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full bg-[#1B4965] text-white font-bold py-4 rounded-full hover:bg-[#153a51] transition-all hover:shadow-lg hover:shadow-[#1B4965]/20 flex items-center justify-center gap-2 group">
                    <span class="text-xs uppercase tracking-widest">Sign In</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>

            <!-- Signup Form -->
            <form id="signupForm" method="POST" action="{{ route('auth.register') }}" class="space-y-6 hidden animate-fade-in">
                @csrf
                <div class="space-y-5">
                    <div class="group">
                        <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#1B4965] transition-colors">Full Name</label>
                        <input type="text" name="name" placeholder="John Doe" class="w-full px-0 py-3 bg-transparent border-b border-neutral-200 text-neutral-900 font-medium placeholder:text-neutral-300 focus:border-[#1B4965] focus:ring-0 transition-all outline-none">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#1B4965] transition-colors">Email Address</label>
                        <input type="email" name="email" placeholder="name@example.com" class="w-full px-0 py-3 bg-transparent border-b border-neutral-200 text-neutral-900 font-medium placeholder:text-neutral-300 focus:border-[#1B4965] focus:ring-0 transition-all outline-none">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#1B4965] transition-colors">Phone Number</label>
                        <input type="tel" name="phone" placeholder="08xxxxxxxxxx" class="w-full px-0 py-3 bg-transparent border-b border-neutral-200 text-neutral-900 font-medium placeholder:text-neutral-300 focus:border-[#1B4965] focus:ring-0 transition-all outline-none">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-bold text-neutral-400 uppercase tracking-widest mb-1.5 group-focus-within:text-[#1B4965] transition-colors">Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full px-0 py-3 bg-transparent border-b border-neutral-200 text-neutral-900 font-medium placeholder:text-neutral-300 focus:border-[#1B4965] focus:ring-0 transition-all outline-none">
                    </div>
                    <input type="hidden" name="user_type" value="pendaki" />
                </div>

                <button type="submit" class="w-full bg-[#1B4965] text-white font-bold py-4 rounded-full hover:bg-[#153a51] transition-all hover:shadow-lg hover:shadow-[#1B4965]/20 flex items-center justify-center gap-2 group">
                    <span class="text-xs uppercase tracking-widest">Create Account</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </button>
            </form>

            <!-- Social Divider -->
            <div class="relative py-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-neutral-100"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-4 text-[10px] font-bold text-neutral-400 bg-white uppercase tracking-widest">Or continue with</span>
                </div>
            </div>

            <!-- Social Buttons -->
            <div class="grid grid-cols-2 gap-4">
                <button class="flex items-center justify-center gap-3 py-3.5 border border-neutral-200 rounded-xl hover:border-[#1B4965] hover:bg-[#1B4965]/5 transition-all group">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    <span class="text-xs font-bold text-neutral-600 group-hover:text-[#1B4965]">Google</span>
                </button>
                <button class="flex items-center justify-center gap-3 py-3.5 border border-neutral-200 rounded-xl hover:border-[#1B4965] hover:bg-[#1B4965]/5 transition-all group">
                    <svg class="w-5 h-5 text-neutral-900" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.285 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                    </svg>
                    <span class="text-xs font-bold text-neutral-600 group-hover:text-[#1B4965]">GitHub</span>
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.4s ease-out forwards;
        }
    </style>

    <script>
        function switchTab(tabName) {
            const loginTab = document.getElementById('loginTab');
            const signupTab = document.getElementById('signupTab');
            const loginIndicator = document.getElementById('loginIndicator');
            const signupIndicator = document.getElementById('signupIndicator');
            const loginForm = document.getElementById('loginForm');
            const signupForm = document.getElementById('signupForm');

            if (tabName === 'login') {
                // Style Tabs
                loginTab.classList.replace('text-neutral-400', 'text-[#1B4965]');
                signupTab.classList.replace('text-[#1B4965]', 'text-neutral-400');
                
                // Animate Indicators
                loginIndicator.classList.remove('scale-x-0');
                signupIndicator.classList.add('scale-x-0');

                // Switch Forms
                loginForm.classList.remove('hidden');
                signupForm.classList.add('hidden');
            } else {
                // Style Tabs
                signupTab.classList.replace('text-neutral-400', 'text-[#1B4965]');
                loginTab.classList.replace('text-[#1B4965]', 'text-neutral-400');

                // Animate Indicators
                signupIndicator.classList.remove('scale-x-0');
                loginIndicator.classList.add('scale-x-0');

                // Switch Forms
                signupForm.classList.remove('hidden');
                loginForm.classList.add('hidden');
            }
        }
    </script>
@endsection
