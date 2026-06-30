<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <title>Register - Laravel 2FA</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-image: url('{{ asset('image/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo img {
            width: 80px;
            height: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2563eb;
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

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .form-group {
            margin-bottom: 15px;
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

        .input-group input {
            width: 100%;
            padding: 12px 50px 12px 55px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            box-sizing: border-box;
            transition: .2s;
        }

        .input-group input:focus {
            border-color: #2563eb;
        }

        .toggle-password {
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="logo">
            <img src="{{ asset('image/logo.png') }}" alt="Logo Sistem">
        </div>

        <h2>Register Laravel 2FA</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-left:15px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group input-group">
                <i data-lucide="user"></i>
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
            </div>

            <div class="form-group input-group">
                <i data-lucide="mail"></i>
                <input type="email" name="email" placeholder="Alamat Email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group input-group">
                <i data-lucide="lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-password" data-target="password">
                    <i data-lucide="eye"></i>
                </span>
            </div>

            <div class="form-group input-group">
                <i data-lucide="shield-check"></i>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Konfirmasi Password" required>
                <span class="toggle-password" data-target="password_confirmation">
                    <i data-lucide="eye"></i>
                </span>
            </div>

            <button type="submit" class="btn">
                Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>

    <script>
        lucide.createIcons();

        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const targetId = toggle.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (input.type === 'password') {
                    input.type = 'text';
                    toggle.innerHTML = '<i data-lucide="eye-off"></i>';
                } else {
                    input.type = 'password';
                    toggle.innerHTML = '<i data-lucide="eye"></i>';
                }

                lucide.createIcons();
            });
        });
    </script>
</body>

</html>