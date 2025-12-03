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
                class="absolute left-6 top-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 transition-all border border-white/20 backdrop-blur-md z-20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <div class="relative z-10 text-center mt-4 opacity-0 animate-enter">
                <h1 class="text-3xl font-medium tracking-tight text-white mb-2">
                    Bantuan & Dukungan
                </h1>
                <p class="text-sm text-white/70 font-medium tracking-wide">
                    Apa yang bisa kami bantu hari ini?
                </p>
            </div>
        </div>

        <!-- Content Container -->
        <div class="px-6 -mt-8 relative z-20 space-y-8">

            <!-- Contact Cards -->
            <div class="grid grid-cols-2 gap-4 opacity-0 animate-enter" style="animation-delay: 0.1s">
                <a href="mailto:support@smartazone.com"
                    class="bg-white p-6 rounded-2xl shadow-lg shadow-neutral-100 border border-neutral-100 text-center group hover:border-[#1B4965] transition-colors">
                    <div
                        class="w-12 h-12 bg-[#1B4965]/5 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-[#1B4965] transition-colors">
                        <svg class="w-6 h-6 text-[#1B4965] group-hover:text-white transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-neutral-900 mb-1">Email Kami</h3>
                    <p class="text-[10px] text-neutral-400 font-medium">Dibalas dalam 24 jam</p>
                </a>
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="bg-white p-6 rounded-2xl shadow-lg shadow-neutral-100 border border-neutral-100 text-center group hover:border-[#25D366] transition-colors">
                    <div
                        class="w-12 h-12 bg-[#25D366]/5 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-[#25D366] transition-colors">
                        <svg class="w-6 h-6 text-[#25D366] group-hover:text-white transition-colors" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-neutral-900 mb-1">WhatsApp</h3>
                    <p class="text-[10px] text-neutral-400 font-medium">Chat dengan kami</p>
                </a>
            </div>

            <!-- FAQ Section -->
            <div class="opacity-0 animate-enter" style="animation-delay: 0.2s">
                <h2 class="text-lg font-bold text-neutral-900 mb-4 px-2">Pertanyaan Umum</h2>
                <div class="space-y-3">
                    <!-- FAQ Item 1 -->
                    <details
                        class="group bg-white rounded-2xl border border-neutral-100 overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center justify-between p-5 cursor-pointer">
                            <h3 class="text-sm font-semibold text-neutral-900">Bagaimana cara melakukan pemesanan?</h3>
                            <svg class="w-5 h-5 text-neutral-400 group-open:rotate-180 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="px-5 pb-5 text-xs text-neutral-500 leading-relaxed">
                            Untuk memesan, cukup buka halaman beranda, pilih tujuan gunung yang diinginkan, pilih tanggal,
                            dan lanjutkan ke pembayaran. Anda akan menerima tiket konfirmasi setelah berhasil.
                        </div>
                    </details>

                    <!-- FAQ Item 2 -->
                    <details
                        class="group bg-white rounded-2xl border border-neutral-100 overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center justify-between p-5 cursor-pointer">
                            <h3 class="text-sm font-semibold text-neutral-900">Bisakah saya membatalkan pesanan?</h3>
                            <svg class="w-5 h-5 text-neutral-400 group-open:rotate-180 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="px-5 pb-5 text-xs text-neutral-500 leading-relaxed">
                            Ya, pembatalan diperbolehkan hingga 48 jam sebelum tanggal pendakian Anda. Silakan hubungi tim
                            dukungan kami melalui email atau WhatsApp untuk memproses pembatalan.
                        </div>
                    </details>

                    <!-- FAQ Item 3 -->
                    <details
                        class="group bg-white rounded-2xl border border-neutral-100 overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center justify-between p-5 cursor-pointer">
                            <h3 class="text-sm font-semibold text-neutral-900">Metode pembayaran apa yang diterima?</h3>
                            <svg class="w-5 h-5 text-neutral-400 group-open:rotate-180 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="px-5 pb-5 text-xs text-neutral-500 leading-relaxed">
                            Kami menerima berbagai metode pembayaran termasuk kartu kredit/debit, transfer bank, dan
                            e-wallet. Semua transaksi aman dan terenkripsi.
                        </div>
                    </details>

                    <!-- FAQ Item 4 -->
                    <details
                        class="group bg-white rounded-2xl border border-neutral-100 overflow-hidden [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center justify-between p-5 cursor-pointer">
                            <h3 class="text-sm font-semibold text-neutral-900">Apakah saya perlu membawa peralatan sendiri?
                            </h3>
                            <svg class="w-5 h-5 text-neutral-400 group-open:rotate-180 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="px-5 pb-5 text-xs text-neutral-500 leading-relaxed">
                            Peralatan keselamatan dasar disarankan. Namun, kami juga menawarkan layanan penyewaan tenda,
                            kantong tidur, dan perlengkapan mendaki lainnya. Cek bagian penyewaan peralatan untuk detail
                            lebih lanjut.
                        </div>
                    </details>
                </div>
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
