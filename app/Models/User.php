<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'otp_code',
        'otp_expired_at',  // ← samakan nama dengan migration
        'otp_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'otp_expired_at'    => 'datetime', // ← tambahkan ini
        ];
    }

    // ===== METHOD OTP =====

    public function generateOtp()
    {
        $otp = rand(100000, 999999);

        $this->update([
            'otp_code'       => bcrypt($otp),
            'otp_expired_at' => now()->addMinutes(5),
            'otp_verified'   => false,
        ]);

        return $otp;
    }

    public function verifyOtp(string $otp):string
    {
        if (now()->gt($this->otp_expired_at)) {
            return 'expired';
        }

        if (!Hash::check($otp, $this->otp_code)) {
            return 'invalid';
        }

        $this->update([
            'otp_code'       => null,
            'otp_expired_at' => null,
            'otp_verified'   => true,
        ]);

        return 'valid';
    }
    
}