<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'username' => 'admin',
            'password' => Hash::make('ditiseentest'),
            'bio' => 'Administrator van het platform',
            'is_admin' => true,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Test users
        User::create([
            'name' => 'Jan de Vries',
            'email' => 'jan@test.com',
            'username' => 'jandevries',
            'password' => Hash::make('ditiseentest'),
            'bio' => 'Verkoper van vintage artikelen',
            'is_admin' => false,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Maria Jansen',
            'email' => 'maria@test.com',
            'username' => 'mariajansen',
            'password' => Hash::make('ditiseentest'),
            'bio' => 'Koper en verzamelaar',
            'is_admin' => false,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Piet Bakker',
            'email' => 'piet@test.com',
            'username' => 'pietbakker',
            'password' => Hash::make('ditiseentest'),
            'bio' => 'Antiek handelaar',
            'is_admin' => false,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Lisa Hermans',
            'email' => 'lisa@test.com',
            'username' => 'lisahermans',
            'password' => Hash::make('ditiseentest'),
            'bio' => 'Vintage fashion expert',
            'is_admin' => false,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
