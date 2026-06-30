<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // STEP 1: Redirect ke Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // STEP 2: Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Login Google gagal, coba lagi.']);
        }


        // Cari atau buat user otomatis
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'      => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'password'  => null,
            ]
        );
       

        // Force update avatar setiap login
        $user->update([
            'avatar' => $googleUser->getAvatar(),
        ]);

        // Tetap kirim OTP meskipun login via Google
        $otp = $user->generateOtp();
        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        session(['otp_user_id' => $user->id]);

        return redirect()->route('otp.form')
            ->with('success', 'OTP dikirim ke ' . $user->email);
    }
}
