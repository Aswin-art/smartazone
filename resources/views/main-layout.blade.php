<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartAzone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/rellax@1.12.1/rellax.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>
    <style>
        html.lenis { height: auto; }
        .lenis.lenis-smooth { scroll-behavior: auto; }
        .lenis.lenis-smooth [data-lenis-prevent] { overscroll-behavior: contain; }
        .lenis.lenis-stopped { overflow: hidden; }
    </style>
</head>

<body class="min-h-screen relative overflow-x-hidden bg-white pb-32">
    <!-- Mobile Bottom Navigation - Functional Swiss Style -->
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-t border-neutral-200 px-6 py-3 transition-all duration-300">
        <div class="flex justify-between items-center max-w-sm mx-auto">
            <!-- Home -->
            <a href="/" class="flex flex-col items-center gap-1 group w-16 {{ request()->is('/') ? 'text-[#1B4965]' : 'text-neutral-400 hover:text-[#1B4965]' }}">
                <div class="relative p-1 transition-transform duration-300 group-active:scale-95">
                    <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    @if(request()->is('/'))
                    <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-1 h-1 bg-[#1B4965] rounded-full"></span>
                    @endif
                </div>
                <span class="text-[10px] font-medium tracking-wide {{ request()->is('/') ? 'font-semibold' : '' }}">Home</span>
            </a>
            
            <!-- Explore (Gunung) -->
            <a href="/booking" class="flex flex-col items-center gap-1 group w-16 {{ request()->is('booking*') && !request()->is('booking-history*') ? 'text-[#1B4965]' : 'text-neutral-400 hover:text-[#1B4965]' }}">
                <div class="relative p-1 transition-transform duration-300 group-active:scale-95">
                    <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    @if(request()->is('booking*') && !request()->is('booking-history*'))
                    <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-1 h-1 bg-[#1B4965] rounded-full"></span>
                    @endif
                </div>
                <span class="text-[10px] font-medium tracking-wide {{ request()->is('booking*') && !request()->is('booking-history*') ? 'font-semibold' : '' }}">Explore</span>
            </a>

            <!-- Saved (Trip) -->
            <a href="/booking-history" class="flex flex-col items-center gap-1 group w-16 {{ request()->is('booking-history*') ? 'text-[#1B4965]' : 'text-neutral-400 hover:text-[#1B4965]' }}">
                <div class="relative p-1 transition-transform duration-300 group-active:scale-95">
                    <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    @if(request()->is('booking-history*'))
                    <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-1 h-1 bg-[#1B4965] rounded-full"></span>
                    @endif
                </div>
                <span class="text-[10px] font-medium tracking-wide {{ request()->is('booking-history*') ? 'font-semibold' : '' }}">Saved</span>
            </a>

            <!-- Profile -->
            <a href="/profile" class="flex flex-col items-center gap-1 group w-16 {{ request()->is('profile*') ? 'text-[#1B4965]' : 'text-neutral-400 hover:text-[#1B4965]' }}">
                <div class="relative p-1 transition-transform duration-300 group-active:scale-95">
                    <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    @if(request()->is('profile*'))
                    <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-1 h-1 bg-[#1B4965] rounded-full"></span>
                    @endif
                </div>
                <span class="text-[10px] font-medium tracking-wide {{ request()->is('profile*') ? 'font-semibold' : '' }}">Profile</span>
            </a>
        </div>
    </nav>

    <!-- Content Layer with Container - Linktree Style -->
    <div class="relative z-10 min-h-screen md:flex md:items-start md:justify-center md:p-8 md:py-12">
        <!-- Content Container - Full on Mobile, Rounded Card on Desktop -->
        <div class="w-full md:max-w-lg md:rounded-3xl md:shadow-2xl md:overflow-hidden bg-white">
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>

</html>
