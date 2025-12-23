<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User (update if exists, create if not)
        User::updateOrCreate(
            ['email' => 'admin@rumbaathaya.com'],
            [
                'name' => 'Admin Rumba Athaya',
                'role' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create Test Tutor (update if exists, create if not)
        User::updateOrCreate(
            ['email' => 'tutor@rumbaathaya.com'],
            [
                'name' => 'Tutor Test',
                'role' => 'tutor',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
