<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Ticket - #BRO-2025-{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 1.6cm;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-white text-neutral-900 font-sans antialiased">
    <!-- Print Controls -->
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <button onclick="window.print()"
            class="px-4 py-2 bg-[#1B4965] text-white rounded-lg font-bold shadow-lg hover:bg-[#153a51] transition-colors">
            Print Ticket
        </button>
        <button onclick="window.close()"
            class="px-4 py-2 bg-white border border-neutral-200 text-neutral-600 rounded-lg font-bold shadow-lg hover:bg-neutral-50 transition-colors">
            Close
        </button>
    </div>

    <!-- Ticket Container -->
    <div class="max-w-2xl mx-auto border-2 border-neutral-900 rounded-3xl overflow-hidden relative">
        <!-- Header -->
        <div class="bg-[#1B4965] text-white p-8 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold tracking-tight mb-1">SMARTAZONE</h1>
                <p class="text-white/70 text-sm font-medium tracking-wide">MOUNTAIN ADVENTURES</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-bold uppercase tracking-widest opacity-70 mb-1">Booking ID</p>
                <p class="text-xl font-mono font-bold">#BRO-2025-{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Mountain Info -->
            <div class="mb-8">
                <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mb-2">Destination</p>
                <h2 class="text-4xl font-bold text-[#1B4965]">{{ $booking->mountain_name }}</h2>
            </div>

            <!-- Grid Info -->
            <div class="grid grid-cols-2 gap-8 mb-8 border-y-2 border-neutral-100 py-8">
                <div>
                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mb-1">Check-in</p>
                    <p class="text-lg font-bold">{{ \Carbon\Carbon::parse($booking->hike_date)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mb-1">Check-out</p>
                    <p class="text-lg font-bold">{{ \Carbon\Carbon::parse($booking->return_date)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mb-1">Team Size</p>
                    <p class="text-lg font-bold">{{ $booking->team_size }} Climbers</p>
                </div>
                <div>
                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mb-1">Status</p>
                    <span
                        class="inline-block px-3 py-1 bg-neutral-100 text-neutral-600 text-xs font-bold uppercase tracking-wider rounded-full">
                        {{ $booking->status }}
                    </span>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="flex items-center justify-between gap-8">
                <div class="flex-1">
                    <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mb-2">Scan for Check-in
                    </p>
                    <p class="text-xs text-neutral-500 leading-relaxed">
                        Please present this ticket at the base camp registration desk.
                        Ensure the QR code is clearly visible for scanning.
                    </p>
                </div>
                <div
                    class="w-48 h-48 bg-neutral-900 p-4 rounded-xl flex items-center justify-center shrink-0 print:bg-white print:border-2 print:border-neutral-900">
                    <!-- Placeholder QR -->
                    <svg class="w-full h-full text-white print:text-neutral-900" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M3 3h6v6H3V3zm2 2v2h2V5H5zm8-2h6v6h-6V3zm2 2v2h2V5h-2zM3 13h6v6H3v-6zm2 2v2h2v-2H5zm13-2h3v2h-3v-2zm-3 2h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 0h-3v3h2v-1h1v-2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-neutral-50 p-6 text-center border-t border-neutral-100">
            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest">
                Generated on {{ now()->format('d M Y H:i') }}
            </p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>

</html>
