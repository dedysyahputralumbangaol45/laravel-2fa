<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <title>Dashboard 2FA</title>

    <style>
        body {
            font-family: Segoe UI, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        h1 {
            margin-bottom: 20px;
        }

        .success {
            color: #16a34a;
            font-weight: bold;
        }

        .btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Selamat Datang di Dashboard Sistem 2FA</h1>

        <div class="card">
            <h3>Data Pengguna</h3>

            @if (Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="">
            @endif

            <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        </div>
        

        <div class="card">
            <h3>Status Keamanan</h3>

            <p>
                OTP Verification:
                <span class="success">
                    {{ Auth::user()->otp_verified ? 'Verified' : 'Not Verified' }}
                </span>
            </p>

            <p>
                Login Method:
                {{ Auth::user()->google_id ? 'Google OAuth' : 'Email & Password' }}
            </p>
        </div>

        <div class="card">
            <h3>Informasi Sistem</h3>

            <p>Framework : Laravel</p>
            <p>Authentication : Laravel Auth</p>
            <p>2FA : Email OTP</p>
            <p>Database : MySQL</p>
        </div>

        <form action="{{ route('logout') }}" method="GET">
            <button class="btn">
                Logout
            </button>
        </form>

    </div>
    <script>
        let idleTime = 0;
        const timeout = 10;

        function resetTimer() {
            idleTime = 0;
        }

        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('click', resetTimer);
        document.addEventListener('scroll', resetTimer);

        setInterval(() => {
            idleTime++;

            if (idleTime >= timeout) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Sesi Berakhir',
                    text: 'Anda tidak aktif selama 10 detik.',
                    allowOutsideClick: false,
                    confirmButtonText: 'Login Kembali'
                }).then(() => {
                    window.location.href = "{{ route('logout') }}";
                });

            }
        }, 1000);
    </script>
</body>

</html>
