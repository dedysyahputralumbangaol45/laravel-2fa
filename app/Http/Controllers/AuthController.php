<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        session([
            'last_activity' => time()
        ]);

        /** @var User $user */
        $user = Auth::user();
        $otp  = $user->generateOtp();

        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        Auth::logout(); // ← logout dulu

        request()->session()->put('otp_user_id', $user->id); // ← simpan session setelah logout

        return redirect()->route('otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        /** @var User $user */
        $user   = User::findOrFail(session('otp_user_id'));
        $result = $user->verifyOtp($request->otp);

        if ($result === 'expired') {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa.']);
        }

        if ($result === 'invalid') {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        Auth::login($user);
        session()->forget('otp_user_id');

        return redirect()->route('dashboard');
    }

    public function resendOtp()
    {
        /** @var User $user */
        $user = User::findOrFail(session('otp_user_id'));
        $otp  = $user->generateOtp();

        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
