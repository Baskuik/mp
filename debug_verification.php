<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get the latest verification code
$code = \App\Models\EmailVerificationCode::orderBy('id', 'desc')->first();

echo "=== LATEST VERIFICATION CODE ===\n";
echo "ID: {$code->id}\n";
echo "Email: {$code->email}\n";
echo "Code: {$code->code}\n";
echo "User ID: {$code->user_id}\n";
echo "Is Verified: {$code->is_verified}\n";
echo "Expires At: {$code->expires_at}\n";
echo "Now: " . now()->format('Y-m-d H:i:s') . "\n";
echo "Is Expired: " . ($code->expires_at < now() ? 'YES' : 'NO') . "\n";

echo "\n=== TESTING QUERY ===\n";

$email = $code->email;
$inputCode = $code->code;

echo "Testing with email: $email\n";
echo "Testing with code: $inputCode\n";

$found = \App\Models\EmailVerificationCode::where('email', $email)
    ->where('code', $inputCode)
    ->where('is_verified', false)
    ->where('expires_at', '>', now())
    ->first();

if ($found) {
    echo "✓ Code FOUND in database!\n";
    echo "Code ID: {$found->id}\n";
} else {
    echo "✗ Code NOT FOUND!\n";

    // Try to find why
    echo "\nDEBUGGING:\n";

    $allCodes = \App\Models\EmailVerificationCode::where('email', $email)->get();
    echo "Total codes for this email: " . count($allCodes) . "\n";

    foreach ($allCodes as $c) {
        echo "  - Code: {$c->code}, is_verified: {$c->is_verified}, expires_at: {$c->expires_at}\n";
        echo "    Matches email? " . ($c->email === $email ? 'YES' : 'NO') . "\n";
        echo "    Matches code? " . ($c->code === $inputCode ? 'YES' : 'NO') . "\n";
        echo "    Is verified? " . ($c->is_verified ? 'YES' : 'NO') . "\n";
        echo "    Is not expired? " . ($c->expires_at > now() ? 'YES' : 'NO') . "\n";
    }
}

echo "\n=== USER CHECK ===\n";
$user = \App\Models\User::where('email', $email)->first();
if ($user) {
    echo "User exists: ID={$user->id}, Name={$user->name}\n";
} else {
    echo "User does NOT exist yet\n";
}
