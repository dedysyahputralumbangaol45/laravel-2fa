<!-- resources/views/emails/otp.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Anda</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f9; font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 16px;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0"
                   style="max-width:480px; background:#ffffff; border-radius:16px;
                          box-shadow:0 4px 24px rgba(0,0,0,.07); overflow:hidden;">

                {{-- Header --}}
                <tr>
                    <td style="background:#2563eb; padding:28px 32px; text-align:center;">
                        <p style="margin:0; font-size:28px;">🔐</p>
                        <h1 style="margin:8px 0 0; color:#ffffff; font-size:20px; font-weight:700;
                                   letter-spacing:.5px;">
                            Verifikasi Login
                        </h1>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:32px;">

                        <p style="margin:0 0 8px; color:#374151; font-size:15px;">
                            Halo, <strong>{{ $userName }}</strong>
                        </p>

                        <p style="margin:0 0 24px; color:#6b7280; font-size:14px; line-height:1.7;">
                            Gunakan kode OTP berikut untuk menyelesaikan proses login.
                            Kode hanya berlaku selama <strong>5 menit</strong> dan
                            tidak boleh dibagikan kepada siapa pun.
                        </p>

                        {{-- Kotak OTP --}}
                        <div style="background:#eff6ff; border:2px dashed #93c5fd;
                                    border-radius:12px; padding:24px; text-align:center;
                                    margin-bottom:24px;">
                            <p style="margin:0 0 6px; font-size:12px; color:#6b7280;
                                      letter-spacing:.08em; text-transform:uppercase;">
                                Kode OTP Anda
                            </p>
                            <p style="margin:0; font-size:40px; font-weight:800;
                                      letter-spacing:10px; color:#1d4ed8;">
                                {{ $otp }}
                            </p>
                        </div>

                        <p style="margin:0 0 24px; color:#6b7280; font-size:13px; line-height:1.7;">
                            Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.
                            Akun Anda tetap aman.
                        </p>

                        <hr style="border:none; border-top:1px solid #e5e7eb; margin:0 0 20px;">

                        <p style="margin:0; font-size:12px; color:#9ca3af; text-align:center;">
                            Email ini dikirim otomatis oleh
                            <strong style="color:#6b7280;">{{ config('app.name') }}</strong>.
                            Jangan balas email ini.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>