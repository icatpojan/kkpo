<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KKPO KONI Tangsel</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-teal: #82a8c7; 
            --primary-dark: #638ab0;
            --bg-light: #f8fafc;
            --text-main: #334155;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            overflow: hidden;
        }
        .login-container {
            height: 100vh;
            display: flex;
        }
        .login-left {
            flex: 1.2;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 40px;
            overflow: hidden;
            background: url('{{ asset("images/hero-medical.png") }}') center center/cover no-repeat;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(99, 138, 176, 0.9), rgba(15, 23, 42, 0.95));
            z-index: 1;
        }
        .login-left-content {
            position: relative;
            z-index: 2;
            max-width: 500px;
            text-align: center;
        }
        .login-logo {
            width: 120px;
            margin-bottom: 30px;
            mix-blend-mode: screen;
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }
        .login-left h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            letter-spacing: -1px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .login-left p {
            font-size: 1.15rem;
            opacity: 0.9;
            line-height: 1.6;
            font-weight: 300;
        }
        
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 40px;
            position: relative;
        }
        .login-right::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background-image: url('{{ asset("images/bg-pattern.png") }}');
            background-size: cover; background-position: center; opacity: 0.05; z-index: 0; pointer-events: none;
        }
        .login-form-wrapper {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }
        .login-form-wrapper h2 {
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 10px;
            font-size: 2.2rem;
            letter-spacing: -0.5px;
        }
        .login-form-wrapper p {
            color: #64748b;
            margin-bottom: 40px;
            font-size: 1.05rem;
        }
        
        .form-group-custom {
            position: relative;
            margin-bottom: 25px;
        }
        .form-group-custom > i {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            transition: 0.3s;
            pointer-events: none;
        }
        .form-control-custom {
            width: 100%;
            border-radius: 12px;
            padding: 16px 20px 16px 55px;
            border: 2px solid #f1f5f9;
            background: #f8fafc;
            font-size: 1rem;
            color: #334155;
            transition: all 0.3s;
            font-weight: 500;
        }
        .form-control-custom:focus {
            border-color: var(--primary-teal);
            background: #ffffff;
            box-shadow: 0 0 0 5px rgba(130, 168, 199, 0.15);
            outline: none;
        }
        .form-control-custom:focus + i, .form-control-custom:not(:placeholder-shown) + i {
            color: var(--primary-dark);
        }
        
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            z-index: 10;
            transition: 0.3s;
            font-size: 1.1rem;
        }
        .password-toggle:hover {
            color: var(--primary-dark);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-teal), var(--primary-dark));
            color: white;
            border-radius: 12px;
            padding: 16px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            border: none;
            transition: 0.3s;
            box-shadow: 0 10px 25px rgba(130, 168, 199, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(130, 168, 199, 0.4);
            color: white;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        .back-link:hover {
            color: var(--primary-dark);
            transform: translateX(-3px);
        }

        @media (max-width: 991px) {
            .login-left { display: none; }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Left Side (Hero Image + Gradient) -->
        <div class="login-left">
            <div class="login-left-content">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="login-logo">
                <h1>KKPO KONI</h1>
                <p>Sistem Informasi Kesehatan & Kesejahteraan Pelaku Olahraga Kota Tangerang Selatan.</p>
            </div>
        </div>

        <!-- Right Side (Form) -->
        <div class="login-right">
            <div class="login-form-wrapper">
                <img src="{{ asset('img/logo.png') }}" alt="Logo KKPO" class="d-block d-lg-none mx-auto mb-4" style="width: 70px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                <h2>Selamat Datang!</h2>
                <p>Silakan masuk ke portal manajemen medis.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group-custom">
                        <input id="email" type="email" class="form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                        <i class="fas fa-envelope"></i>
                        @error('email')
                            <span class="invalid-feedback d-block mt-2 fw-semibold" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group-custom">
                        <input id="password" type="password" class="form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" style="padding-right: 50px;">
                        <i class="fas fa-lock"></i>
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </span>
                        @error('password')
                            <span class="invalid-feedback d-block mt-2 fw-semibold" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-secondary fw-medium" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none fw-bold" style="color: var(--primary-dark);" href="{{ route('password.request') }}">
                                Lupa Sandi?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-login">
                        Login Dashboard <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <div class="text-center mt-5">
                        <a href="{{ url('/') }}" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
