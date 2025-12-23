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
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@rumbaathaya.com'],
            [
                'name' => 'Admin Rumba Athaya',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Tutor Users
        $tutors = [
            [
                'name' => 'Budi Santoso, S.Pd.',
                'email' => 'budi@rumbaathaya.com',
                'role' => 'tutor',
                'bio' => 'Tutor Matematika berpengalaman 10 tahun, lulusan UGM',
            ],
            [
                'name' => 'Siti Nurhaliza, M.Pd.',
                'email' => 'siti@rumbaathaya.com',
                'role' => 'tutor',
                'bio' => 'Tutor Bahasa Indonesia dan Calistung, lulusan UNY',
            ],
            [
                'name' => 'Ahmad Fauzi, S.Pd.',
                'email' => 'ahmad@rumbaathaya.com',
                'role' => 'tutor',
                'bio' => 'Tutor IPA dan Tahfidz, lulusan UIN',
            ],
            [
                'name' => 'Dewi Kartika, S.Pd.',
                'email' => 'dewi@rumbaathaya.com',
                'role' => 'tutor',
                'bio' => 'Tutor Bahasa Inggris, lulusan UNS',
            ],
            [
                'name' => 'Rudi Hartono, M.Pd.',
                'email' => 'rudi@rumbaathaya.com',
                'role' => 'tutor',
                'bio' => 'Tutor IPS, lulusan UGM',
            ],
        ];

        foreach ($tutors as $tutor) {
            User::updateOrCreate(
                ['email' => $tutor['email']],
                [
                    'name' => $tutor['name'],
                    'role' => $tutor['role'],
                    'bio' => $tutor['bio'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Test Student User
        User::updateOrCreate(
            ['email' => 'student@rumbaathaya.com'],
            [
                'name' => 'Student Test',
                'role' => 'student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
