<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <title>Login - Laravel 2FA</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('{{ asset('image/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: white;
            width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            color: #666;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 12px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: .2s;
            box-sizing: border-box;
        }

        .google-btn:hover {
            background: #f5f5f5;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .alert-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
            border-radius: 50%;
            object-fit: cover;
        }

        .input-group {
            position: relative;
        }

        .input-group svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #2543c9;
        }

        .input-group {
            position: relative;
        }

        .left-icon svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #64748b;
        }

        .input-group input {
            padding-left: 42px;
            padding-right: 42px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
        }

        .input-group {
            position: relative;
        }

        .left-icon svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #64748b;
        }

        .input-group input {
            padding-left: 42px;
            padding-right: 42px;
        }

        .toggle-password {
            position: absolute;
            right: 45px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
        }

        .input-group input {
            padding-left: 40px;
        }

        .input-group::after {
            content: "";
            position: absolute;
            left: 42px;
            top: 50%;
            transform: translateY(-50%);
            width: 1px;
            height: 22px;
            background: #6e7a83;
        }

        /* Jarak text setelah garis */
        .input-group input {
            width: 100%;
            padding: 12px 50px 12px 55px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2563eb;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="logo">
            <img src="{{ asset('image/logo.png') }}" alt="Logo Sistem">
        </div>
        <h2>Login Laravel 2FA </h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Sesi Berakhir',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                });
            </script>
        @endif

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group input-group">
                <i data-lucide="mail"></i>
                <input type="email" name="email" placeholder="Masukkan Email" value="{{ old('email') }}" required>
            </div>

            

            <div class="form-group input-group">
                <i data-lucide="lock"></i>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                <span class="toggle-password">
                    <i data-lucide="eye" id="eye-icon"></i>
                </span>
            </div>

            <button type="submit" class="btn-login">
                Login
            </button>
        </form>

        <div class="divider">
            ── atau login dengan ──
        </div>

        <a href="{{ route('google.login') }}" class="google-btn">
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" width="20">
            Login dengan Google
        </a>
    </div>
    <script>
        lucide.createIcons();
    </script>
    <script>
        lucide.createIcons();

        const password = document.getElementById('password');
        const toggle = document.querySelector('.toggle-password');

        if (password && toggle) {

            toggle.addEventListener('click', () => {

                if (password.type === 'password') {

                    password.type = 'text';

                    toggle.innerHTML =
                        '<i data-lucide="eye-off"></i>';

                } else {

                    password.type = 'password';

                    toggle.innerHTML =
                        '<i data-lucide="eye"></i>';
                }

                lucide.createIcons();
            });

        }
    </script>
</body>

</html>
