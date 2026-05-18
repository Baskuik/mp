<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = \App\Models\User::where('email', 'admin@example.com')->first();
if (!$user) {
    $user = \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password'),
        'email_verified_at' => now(),
        'is_admin' => true,
        'is_active' => true
    ]);
}
echo 'User ready: ' . $user->email . "\n";
