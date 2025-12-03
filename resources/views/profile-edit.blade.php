@extends('main-layout')

@section('content')
    <div class="bg-white min-h-screen font-sans text-neutral-900 pb-32">
        <!-- Header - Solid Brand Color -->
        <div class="bg-[#1B4965] px-6 pt-16 pb-12 rounded-b-[2.5rem] shadow-xl shadow-[#1B4965]/10 relative overflow-hidden">
            <!-- Background Pattern -->
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none">
            </div>

            <!-- Back Button -->
            <a href="{{ route('profile') }}"
                class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-md z-20 text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="relative z-10 text-center mt-4 opacity-0 animate-enter">
                <h1 class="text-3xl font-medium tracking-tight text-white mb-2">
                    Edit Profile
                </h1>
                <p class="text-sm text-white/70 font-medium tracking-wide">
                    Update your personal information
                </p>
            </div>
        </div>

        <!-- Form Section -->
        <div class="px-6 -mt-8 relative z-20 opacity-0 animate-enter" style="animation-delay: 0.1s">
            <div class="bg-white rounded-2xl shadow-lg shadow-neutral-100 border border-neutral-100 p-6">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label for="name"
                            class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none placeholder:text-neutral-300"
                            required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="email"
                            class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Email
                            Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none placeholder:text-neutral-300"
                            required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="phone"
                            class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest ml-1">Phone
                            Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3.5 bg-neutral-50 border-0 rounded-xl text-neutral-900 font-medium focus:ring-2 focus:ring-[#1B4965]/20 focus:bg-white transition-all outline-none placeholder:text-neutral-300">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-[#1B4965] text-white font-bold py-4 px-6 rounded-full transition-all hover:bg-[#153a51] hover:shadow-lg flex items-center justify-center gap-3 group">
                            <span class="text-xs uppercase tracking-widest">Save Changes</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                gsap.to(".animate-enter", {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    stagger: 0.1,
                    ease: "power2.out"
                });
            });
        </script>
        <style>
            .animate-enter {
                transform: translateY(20px);
            }
        </style>
    @endpush
@endsection
