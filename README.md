# Implementasi Two-Factor Authentication (2FA) Berbasis OTP Email

Sistem login aplikasi web dengan autentikasi dua faktor (2FA) menggunakan OTP Email dan Google OAuth, dibangun menggunakan framework **Laravel**.

## 📋 Deskripsi

Proyek ini merupakan implementasi sistem keamanan login berlapis yang menggabungkan **something you know** (password) dan **something you have** (kode OTP via email). Dengan pendekatan ini, sistem tetap aman meskipun kredensial pengguna (username dan password) bocor, karena penyerang tetap memerlukan akses ke email pemilik akun untuk menyelesaikan proses login.

## ✨ Fitur

- Registrasi akun manual (nama, email, password)
- Login manual dengan verifikasi `Auth::attempt()`
- Login via **Google OAuth** (otomatis membuat akun baru jika belum terdaftar)
- Generate dan kirim kode OTP acak ke email pengguna
- Verifikasi OTP (validasi kode dan masa berlaku)
- Kirim ulang OTP jika kedaluwarsa
- Deteksi idle session dan auto-logout otomatis
- Logout manual

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi |
|---|---|
| Framework | Laravel |
| Autentikasi | Laravel Auth, Google OAuth |
| Pengiriman OTP | SMTP (Mailtrap) |
| Database | MySQL |
| Frontend | Blade, JavaScript (deteksi idle) |

## 🗄️ Struktur Database (Tabel `users`)

| Kolom | Keterangan |
|---|---|
| `id`, `name`, `email`, `password` | Kolom standar autentikasi |
| `google_id`, `avatar` | Dukungan login Google OAuth |
| `otp_code`, `otp_expired_at` | Penyimpanan kode OTP dan masa berlaku |
| `otp_verified` | Status verifikasi OTP (0/1) |

## 🔄 Alur Login

**Jalur Manual:**
1. Input email + password
2. Validasi `Auth::attempt()`
3. Jika valid → generate OTP, simpan ke database, kirim ke email
4. Pengguna input kode OTP
5. Verifikasi kesesuaian kode dan masa berlaku
6. Berhasil → masuk dashboard

**Jalur Google OAuth:**
1. Redirect ke Google OAuth
2. Ambil data akun Google
3. Cek `google_id` → buat akun baru jika belum ada
4. Lanjut ke proses generate dan verifikasi OTP seperti jalur manual

## ⚙️ Instalasi

1. Clone repository ini
   ```bash
   git clone https://github.com/dedysyahputralumbangaol45/2fa-app.git
   cd 2fa-app
   ```

2. Install dependency
   ```bash
   composer install
   npm install
   ```

3. Salin file environment dan generate APP_KEY
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Sesuaikan konfigurasi di file `.env`:
   - Koneksi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)
   - Kredensial SMTP untuk OTP Email (`MAIL_USERNAME`, `MAIL_PASSWORD`) — gunakan akun [Mailtrap](https://mailtrap.io) sendiri
   - Kredensial Google OAuth (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`) — buat di [Google Cloud Console](https://console.cloud.google.com)

5. Jalankan migrasi database
   ```bash
   php artisan migrate
   ```

6. Jalankan server lokal
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses di `http://localhost:8000`

## ✅ Hasil Pengujian

Seluruh 8 skenario pengujian fungsional (registrasi, login manual, login Google OAuth, validasi OTP benar/salah/kedaluwarsa, deteksi idle, logout) telah **lulus** sesuai rancangan sistem.

Pengujian keamanan menunjukkan bahwa sistem tanpa 2FA rentan terhadap pencurian kredensial (akses langsung berhasil), sedangkan sistem dengan 2FA berhasil menahan upaya login di tahap verifikasi OTP karena penyerang tidak memiliki akses ke email korban.

## 📌 Saran Pengembangan

- Tambahan channel WhatsApp sebagai alternatif pengiriman OTP
- Penetration testing (brute force OTP, session hijacking)
- Rate limiting pada pengiriman dan percobaan verifikasi OTP
- Edukasi pengguna terkait keamanan akun email
- Integrasi biometrik atau hardware token

## 👥 Anggota Kelompok

**Kelompok 1 — Keamanan Perangkat Lunak**
Program Studi Teknik Informatika — Universitas Sains dan Teknologi Indonesia

- Dedy Syahputra L.G.
- Jeremy Nicholas D.
- Joedhy Chandra M.
- M. Arya Duta

---
*"Keamanan bukan fitur tambahan — itu fondasi sistem."*
