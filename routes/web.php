<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ListingController;

// View routes
Route::get('/', [ListingController::class, 'home'])->name('home');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

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

Route::middleware('auth')->group(function () {
    Route::get('/profiel', [ListingController::class, 'profile'])->name('profile');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::post('/listings/{listing}/bids', [BidController::class, 'store'])->name('bids.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
    Route::delete('/listings/{listing}/images/{image}', [ListingController::class, 'destroyImage'])
        ->name('listings.images.destroy');
});

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
Route::post('/set-language/{lang}', function ($lang) {
    if (in_array($lang, ['nl', 'de', 'en', 'be'])) {
        session(['locale' => $lang]);
    }
    return back();
})->name('set-language');