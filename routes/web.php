<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//web routes
Route::get('/', function () {
    return view('welcome');
});

// Route::get('/favorieten', function () {
//     return view('favorieten');
// });

// Route::get('/contact', function () {
//     return view('contact');
// });

// Route::get('/profiel', function () {
//     return view('profiel');
// });

// Route::get('/instellingen', function () {
//     return view('instellingen');
// });

//auth routes')
Route::get('/register', [AuthController::class, 'showRegisterStep1'])->name('register.step1');
Route::post('/register/step1', [AuthController::class, 'registerStep1'])->name('register.step1.post');
Route::get('/register/step2', [AuthController::class, 'showRegisterStep2'])->name('register.step2');
Route::post('/register/step2', [AuthController::class, 'registerStep2'])->name('register.step2.post');
Route::get('/register/step3', [AuthController::class, 'showRegisterStep3'])->name('register.step3');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::get('/password/request', [AuthController::class, 'showPasswordRequest'])->name('password.request');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Email verification routes (accessible during registration - NOT protected by auth)
Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('/verify-email-code', [AuthController::class, 'verifyEmailCode'])->name('verify-email-code');
    Route::get('/verify-email-code', function () {
        return redirect()->route('register.step3');
    });
    Route::post('/resend-verification-email', [AuthController::class, 'resendVerificationEmail'])->name('resend-verification-email');
});

// Language switcher
Route::post('/set-language/{lang}', function ($lang) {
    if (in_array($lang, ['nl', 'de', 'en', 'be'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('set-language');