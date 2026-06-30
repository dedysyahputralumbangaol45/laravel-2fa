<!-- resources/views/auth/otp.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <title>Verifikasi OTP - Laravel 2FA</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
        }

        .icon {
            text-align: center;
            font-size: 48px;
            margin-bottom: 12px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        /* OTP input 6 kotak */
        .otp-wrapper {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 24px;
        }

        .otp-box {
            width: 48px;
            height: 56px;
            border: 2px solid #d1d5db;
            border-radius: 10px;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            outline: none;
            transition: .2s;
        }

        .otp-box:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        /* hidden input yang dikirim ke server */
        #otp-hidden {
            display: none;
        }

        .btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
            margin-bottom: 12px;
        }

        .btn:hover { background: #1d4ed8; }
        .btn:disabled { background: #93c5fd; cursor: not-allowed; }

        .resend-form {
            text-align: center;
        }

        .btn-resend {
            background: none;
            border: none;
            color: #2563eb;
            font-size: 14px;
            cursor: pointer;
            font-weight: 600;
            padding: 0;
        }

        .btn-resend:hover { text-decoration: underline; }

        .timer {
            font-size: 13px;
            color: #6b7280;
        }

        .alert {
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .alert-danger  { background: #fee2e2; color: #b91c1c; }
        .alert-success { background: #dcfce7; color: #166534; }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
        }

        .back-link:hover { color: #2563eb; }
    </style>
</head>
<body>

<div class="card">

    <div class="icon">📧</div>
    <h2 class="title">Verifikasi OTP</h2>
    <p class="subtitle">
        Masukkan 6 digit kode yang telah dikirim<br>ke email Anda. Kode berlaku selama 1 menit.
    </p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}" id="otp-form">
        @csrf

        {{-- 6 kotak input visual --}}
        <div class="otp-wrapper">
            @for($i = 0; $i < 6; $i++)
                <input
                    type="text"
                    class="otp-box"
                    maxlength="1"
                    inputmode="numeric"
                    pattern="[0-9]"
                    data-index="{{ $i }}"
                    autocomplete="off"
                >
            @endfor
        </div>

        {{-- Input tersembunyi yang dikumpulkan dari 6 kotak --}}
        <input type="hidden" name="otp" id="otp-hidden">

        <button type="submit" class="btn" id="btn-submit" disabled>
            Verifikasi
        </button>
    </form>

    {{-- Tombol kirim ulang --}}
    <form method="POST" action="{{ route('otp.resend') }}" class="resend-form">
        @csrf
        <span class="timer" id="timer-text">Kirim ulang dalam <b id="countdown">60</b> detik</span>
        <button type="submit" class="btn-resend" id="btn-resend" style="display:none;">
            Kirim Ulang Kode
        </button>
    </form>

    <a href="{{ route('login') }}" class="back-link">← Kembali ke Login</a>

</div>

<script>
    // ── Auto-focus & auto-jump antar kotak ──
    const boxes  = document.querySelectorAll('.otp-box');
    const hidden = document.getElementById('otp-hidden');
    const submit = document.getElementById('btn-submit');

    boxes.forEach((box, idx) => {
        box.addEventListener('input', e => {
            // Hanya angka
            box.value = box.value.replace(/\D/g, '').slice(-1);

            if (box.value && idx < 5) boxes[idx + 1].focus();

            syncHidden();
        });

        box.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !box.value && idx > 0) {
                boxes[idx - 1].focus();
            }
        });

        // Support paste seluruh kode sekaligus
        box.addEventListener('paste', e => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData)
                .getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((ch, i) => {
                if (boxes[i]) boxes[i].value = ch;
            });
            if (boxes[pasted.length - 1]) boxes[pasted.length - 1].focus();
            syncHidden();
        });
    });

    function syncHidden() {
        const val = Array.from(boxes).map(b => b.value).join('');
        hidden.value = val;
        submit.disabled = val.length < 6;
    }

    // ── Countdown 60 detik sebelum tombol resend muncul ──
    let seconds = 60;
    const timerText = document.getElementById('timer-text');
    const btnResend = document.getElementById('btn-resend');
    const countdown = document.getElementById('countdown');

    const interval = setInterval(() => {
        seconds--;
        countdown.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(interval);
            timerText.style.display = 'none';
            btnResend.style.display = 'inline';
        }
    }, 1000);
</script>

</body>
</html>