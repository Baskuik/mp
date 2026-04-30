<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = \App\Models\User::orderBy('id', 'desc')->limit(5)->get();

echo "Latest 5 users:\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Verified: " . ($user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'NOT VERIFIED') . "\n";
}

echo "\n\nVerification codes:\n";
$codes = \App\Models\EmailVerificationCode::orderBy('id', 'desc')->limit(5)->get();
foreach ($codes as $code) {
    echo "Email: {$code->email}, Code: {$code->code}, Verified: {$code->is_verified}, Expires: {$code->expires_at}\n";
}
