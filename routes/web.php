<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PremiumController;

// View routes
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

// Auth routes
Route::get('/register', [AuthController::class, 'showRegisterStep1'])->name('register.step1');
Route::post('/register/step1', [AuthController::class, 'registerStep1'])->name('register.step1.post');
Route::get('/register/step2', [AuthController::class, 'showRegisterStep2'])->name('register.step2');
Route::post('/register/step2', [AuthController::class, 'registerStep2'])->name('register.step2.post');
Route::get('/register/step3', [AuthController::class, 'showRegisterStep3'])->name('register.step3');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Wachtwoord vergeten / resetten
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])
    ->name('password.request')
    ->middleware('guest');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.send')
    ->middleware(['guest', 'throttle:5,1']);
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPassword'])
    ->name('password.reset')
    ->middleware('guest');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update')
    ->middleware('guest', 'throttle:5,1');

// Email verificatie routes
Route::middleware(['throttle:5,1'])->group(function () {
    Route::post('/verify-email-code', [AuthController::class, 'verifyEmailCode'])->name('verify-email-code');
    Route::get('/verify-email-code', function () {
        return redirect()->route('register.step3');
    });
    Route::post('/resend-verification-email', [AuthController::class, 'resendVerificationEmail'])->name('resend-verification-email');
});

// Language switcher
Route::get('/set-language/{lang}', function ($lang) {
    if (in_array($lang, ['nl', 'de', 'en'])) {
        session(['locale' => $lang]);

        // If user is logged in, also update their database preference
        if (auth()->check()) {
            auth()->user()->update(['language' => $lang]);
        }
    }

    $redirect = request('redirect');
    if ($redirect && str_starts_with($redirect, config('app.url'))) {
        return redirect($redirect);
    }

    return back();
})->name('set-language');

Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profiel', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profiel', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profiel/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profiel/email/send', [ProfileController::class, 'sendEmailVerificationCode'])->name('profile.email.send');
    Route::post('/profiel/email/verify', [ProfileController::class, 'verifyEmailCode'])->name('profile.email.verify');
    // Phone verification
    Route::post('/profile/phone/send', [PhoneVerificationController::class, 'send'])->name('phone.send');
    Route::post('/profile/phone/verify', [PhoneVerificationController::class, 'verify'])->name('phone.verify');

    // Settings routes (Story 399, 400, 402, 403)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/language', [SettingsController::class, 'updateLanguage'])->name('settings.language');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/phone', [SettingsController::class, 'updatePhone'])->name('settings.phone');
    Route::post('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.email');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/premium',          [PremiumController::class, 'index'])->name('premium.index');
    Route::get('/premium/checkout', [PremiumController::class, 'checkout'])->name('premium.checkout');
    Route::post('/premium/intent',  [PremiumController::class, 'intent'])->name('premium.intent');
    Route::get('/premium/success',  [PremiumController::class, 'success'])->name('premium.success');
});