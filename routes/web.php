<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthControllerManual;
use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

//Route OTP — di LUAR group guest
Route::get('/otp', [AuthController::class, 'showOtpForm'])
    ->name('otp.form');
Route::post('/otp/verify', [AuthController::class, 'verifyOtp'])
    ->name('otp.verify');
Route::post('/otp/resend', [AuthController::class, 'resendOtp'])
    ->name('otp.resend');

Route::middleware('guest')->group(function () {

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Google Login
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])
        ->name('google.login');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])
        ->name('google.callback');
});

Route::prefix('manual')->name('manual.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/register', [AuthControllerManual::class, 'showRegister'])
            ->name('register');
        Route::post('/register', [AuthControllerManual::class, 'register']);

        Route::get('/login', [AuthControllerManual::class, 'showLogin'])
            ->name('login');
        Route::post('/login', [AuthControllerManual::class, 'login']);
    });

        Route::get('/logout', [AuthControllerManual::class, 'logout'])
            ->name('logout');
    });


Route::middleware(['auth' ,'idle'])->group(function () {

    Route::get('/dashboard', function () {
        return view ('dashboard');
    })->name('dashboard');

    Route::get('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});
