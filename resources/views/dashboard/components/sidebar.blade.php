<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ Auth::user()->user_type == 'superadmin' ? route('superadmin.mountains.index') : route('dashboard.index') }}"
            class="app-brand-link">
            <span class="app-brand-logo demo me-1">
                <span class="text-primary">
                    <svg width="30" height="24" viewBox="0 0 250 196" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z"
                            fill="currentColor" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z" fill="black" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z" fill="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z"
                            fill="currentColor" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z" fill="black" />
                        <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                            d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z" fill="black" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                            fill="white" fill-opacity="0.15" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                            fill="white" fill-opacity="0.3" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">SmartAzone</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @if (Auth::user() && Auth::user()->user_type === 'admin')
            <li class="menu-item">
                <a href="{{ route('dashboard.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-bar-chart-box-line"></i>
                    <div data-i18n="Data Analitik">Data Analitik</div>
                    <div class="badge rounded-pill bg-label-success fs-tiny ms-auto">📈</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('hikers.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-group-line"></i>
                    <div data-i18n="List Pendaki">Pendaki</div>
                    <div class="badge rounded-pill bg-label-info fs-tiny ms-auto">🧍‍♂️</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('health.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-heart-pulse-line"></i>
                    <div data-i18n="Monitor Kesehatan">Monitor Kesehatan</div>
                    <div class="badge rounded-pill bg-label-warning fs-tiny ms-auto">🔬</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('hiker-history.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-history-line"></i>
                    <div data-i18n="Riwayat Pendakian">Riwayat Pendakian</div>
                    <div class="badge rounded-pill bg-label-secondary fs-tiny ms-auto">📜</div>
                </a>
            </li>

            {{-- <li class="menu-item">
                <a href="{{ route('complaints.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-feedback-line"></i>
                    <div data-i18n="List Pengaduan">Pengaduan</div>
                    <div class="badge rounded-pill bg-label-danger fs-tiny ms-auto">📄</div>
                </a>
            </li> --}}

            <li class="menu-item">
                <a href="{{ route('equipment-rentals.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-tools-line"></i>
                    <div data-i18n="List Peminjaman Alat">Peminjaman Alat</div>
                    <div class="badge rounded-pill bg-label-warning fs-tiny ms-auto">🧰</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('feedback.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-star-line"></i>
                    <div data-i18n="List Feedback & Rating">Feedback & Rating</div>
                    <div class="badge rounded-pill bg-label-success fs-tiny ms-auto">🌟</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('mountain_hikers.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-map-pin-line"></i>
                    <div data-i18n="Pendaki Aktif">Pendaki Aktif</div>
                    <div class="badge rounded-pill bg-label-info fs-tiny ms-auto">🗺️</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('hiker.link') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-smartphone-line"></i>
                    <div data-i18n="Hiker Devices">Hiker Devices</div>
                    <div class="badge rounded-pill bg-label-primary fs-tiny ms-auto">📱</div>
                </a>
            </li>
<li class="menu-item">
    <a href="{{ route('sos.index') }}" class="menu-link">
        <i class="menu-icon icon-base ri ri-alarm-warning-line"></i>
        <div data-i18n="SOS Monitoring">SOS Monitoring</div>
        <div class="badge rounded-pill bg-label-danger fs-tiny ms-auto">‼️</div>
    </a>
</li>

        @elseif(Auth::user() && Auth::user()->user_type === 'superadmin')
            <li class="menu-item">
                <a href="{{ route('superadmin.mountains.index') }}" class="menu-link">
                    <i class="menu-icon icon-base bi bi-bezier2"></i>
                    <div data-i18n="Manajemen Gunung (Superadmin)">Manajemen Gunung</div>
                    <div class="badge rounded-pill bg-label-dark fs-tiny ms-auto">🗻</div>
                </a>
            </li>
        @endif
    </ul>

</aside>
