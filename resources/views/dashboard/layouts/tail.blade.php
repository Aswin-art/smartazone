    <audio id="alert-sound" src="{{ asset('assets/sound/alert.mp3') }}" preload="auto"></audio>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

    <script>
        $(document).ready(function () {
            const audio = document.getElementById('alert-sound');
            $(document).one('click', function () {
                audio.play().then(() => {
                    audio.pause();
                    audio.currentTime = 0;
                }).catch(() => {});
                console.log('🔊 Audio unlocked by user interaction');
            });

            Pusher.logToConsole = false;
            const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
                forceTLS: true
            });

            const mountainId = "{{ auth()->user()->mountain_id }}";
            const channel = pusher.subscribe(`mountain-sos.${mountainId}`);

            channel.bind('sos.created', function (data) {
                console.log('📡 SOS event received:', data);
                audio.play().catch(err => console.warn('Audio play blocked:', err));
                alert(`🚨 SOS DARI PENDAKI!\nPesan: ${data.sosData.message}\nKoordinat: ${data.sosData.latitude}, ${data.sosData.longitude}`);
            });
        });
    </script>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async="async" defer="defer" src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
