<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check latest verification code
$code = \App\Models\EmailVerificationCode::where('email', 'testuser@mailtrap.io')
    ->where('is_verified', false)
    ->where('expires_at', '>', now())
    ->first();

if ($code) {
    echo "Verification code for testuser@mailtrap.io: " . $code->code . "\n";
    echo "Code ID: " . $code->id . "\n";
    echo "User ID: " . $code->user_id . "\n";
    echo "Expires at: " . $code->expires_at . "\n";
} else {
    echo "No verification code found\n";
}

// Check if user exists
$user = \App\Models\User::where('email', 'testuser@mailtrap.io')->first();
if ($user) {
    echo "\nUser found: ID=" . $user->id . ", name=" . $user->name . "\n";
    echo "Email verified: " . ($user->email_verified_at ? $user->email_verified_at : 'NO') . "\n";
} else {
    echo "\nUser NOT found - correct! (not created yet)\n";
}
