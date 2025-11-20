<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mountain System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #696CFF;
            --primary-light: #8A92FF;
            --primary-dark: #5A60E8;
            --success: #71DD37;
            --danger: #FF3E1E;
            --warning: #FFAB00;
            --info: #03C3EC;
            --dark: #161A1F;
            --light: #F5F5F5;
            --text-primary: #1A202C;
            --text-secondary: #6C757D;
            --border-color: #E5E7EB;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .bg-animation {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            opacity: 0.1;
            filter: blur(80px);
            animation: float 6s ease-in-out infinite;
        }

        .blob:nth-child(1) {
            width: 400px;
            height: 400px;
            background: white;
            top: -100px;
            right: -50px;
            animation-delay: 0s;
        }

        .blob:nth-child(2) {
            width: 300px;
            height: 300px;
            background: white;
            bottom: -100px;
            left: -50px;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0px, 0px); }
            33% { transform: translate(30px, -30px); }
            66% { transform: translate(-20px, 20px); }
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            width: 100%;
            max-width: 1200px;
            height: auto;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .login-illustration {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .login-illustration::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-illustration::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .illustration-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
        }

        .mountain-icon {
            font-size: 80px;
            margin-bottom: 1.5rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .login-illustration h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .login-illustration p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .feature-list {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            opacity: 0.95;
        }

        .feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .login-form {
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 2.5rem;
        }

        .form-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 20px;
            z-index: 1;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 20px;
            cursor: pointer;
            z-index: 2;
            transition: all 0.3s ease;
            padding: 0;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        .form-control {
            padding-left: 48px;
            padding-right: 16px;
            height: 48px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: var(--light);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .form-control:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.1);
            outline: none;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-top: 0;
            margin-right: 0.75rem;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.1);
        }

        .form-check-label {
            margin: 0;
            color: var(--text-primary);
            font-weight: 500;
            cursor: pointer;
        }

        .btn-login {
            height: 48px;
            background: var(--primary);
            border: none;
            color: white;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(105, 108, 255, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            border: none;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: rgba(255, 62, 30, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert-success {
            background: rgba(113, 221, 55, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .btn-close {
            opacity: 0.5;
            transition: opacity 0.3s ease;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .role-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--border-color);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            gap: 0.4rem;
        }

        .badge-superadmin {
            background: rgba(255, 62, 30, 0.1);
            color: var(--danger);
        }

        .badge-admin {
            background: rgba(255, 171, 0, 0.1);
            color: var(--warning);
        }

        .badge-pendaki {
            background: rgba(113, 221, 55, 0.1);
            color: var(--success);
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-illustration {
                padding: 2rem;
                min-height: 300px;
            }

            .login-illustration h1 {
                font-size: 1.5rem;
            }

            .feature-list {
                display: none;
            }

            .login-form {
                padding: 2rem;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="blob"></div>
        <div class="blob"></div>
    </div>

    <div class="login-container">
        <div class="login-illustration">
            <div class="illustration-content">
                <div class="mountain-icon">
                    <i class="mdi mdi-mountain"></i>
                </div>
                <h1>Mountain System</h1>
                <p>Kelola pendakian Anda dengan mudah dan aman</p>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="mdi mdi-shield-check"></i>
                        </div>
                        <span>Sistem keamanan terpercaya</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="mdi mdi-chart-line"></i>
                        </div>
                        <span>Analitik mendalam dan laporan</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="mdi mdi-sync"></i>
                        </div>
                        <span>Sinkronisasi real-time</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-form">
            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle"></i>
                    <span>{{ $errors->first() }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-circle"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="mdi mdi-email-outline"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@example.com">
                    </div>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="mdi mdi-lock-outline"></i></span>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="••••••••">
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="mdi mdi-login"></i> Login
                </button>

                {{-- <div class="role-badges">
                    <div class="role-badge badge-superadmin">
                        <i class="mdi mdi-shield-crown"></i> Superadmin
                    </div>
                    <div class="role-badge badge-admin">
                        <i class="mdi mdi-account-tie"></i> Admin
                    </div>
                    <div class="role-badge badge-pendaki">
                        <i class="mdi mdi-hiking"></i> Pendaki
                    </div>
                </div> --}}
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword) {
            togglePassword.addEventListener('click', function(e) {
                e.preventDefault();
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('mdi-eye-outline');
                    icon.classList.add('mdi-eye-off-outline');
                } else {
                    icon.classList.remove('mdi-eye-off-outline');
                    icon.classList.add('mdi-eye-outline');
                }
            });
        }

        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    </script>
</body>
</html>