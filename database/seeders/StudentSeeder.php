<?php

namespace Database\Seeders;

use App\Models\ClassLevel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get class levels
        $tk = ClassLevel::where('name', 'TK')->first();
        $sd1 = ClassLevel::where('name', 'SD Kelas 1')->first();
        $sd4 = ClassLevel::where('name', 'SD Kelas 4')->first();
        $smp7 = ClassLevel::where('name', 'SMP Kelas 7')->first();
        $tahfidz = ClassLevel::where('name', 'Tahfidz')->first();

        // Get student user if exists
        $studentUser = User::where('email', 'student@rumbaathaya.com')->first();

        $students = [
            [
                'name' => 'Ahmad Rizki',
                'nickname' => 'Rizki',
                'user_id' => $studentUser?->id,
                'place_of_birth' => 'Yogyakarta',
                'date_of_birth' => '2018-05-15',
                'address' => 'Jl. Malioboro No. 123, Yogyakarta',
                'parent_phone' => '081234567890',
                'school_origin' => 'TK Permata Hati',
                'class_level_id' => $tk?->id,
                'program_interest' => 'Calistung',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'nickname' => 'Siti',
                'place_of_birth' => 'Surakarta',
                'date_of_birth' => '2017-08-20',
                'address' => 'Jl. Sudirman No. 45, Surakarta',
                'parent_phone' => '081234567891',
                'school_origin' => 'SD Negeri 1 Surakarta',
                'class_level_id' => $sd1?->id,
                'program_interest' => 'Mapel SD',
            ],
            [
                'name' => 'Budi Pratama',
                'nickname' => 'Budi',
                'place_of_birth' => 'Jakarta',
                'date_of_birth' => '2014-03-10',
                'address' => 'Jl. Gatot Subroto No. 78, Jakarta',
                'parent_phone' => '081234567892',
                'school_origin' => 'SD Islam Terpadu',
                'class_level_id' => $sd4?->id,
                'program_interest' => 'Mapel SD',
            ],
            [
                'name' => 'Dewi Lestari',
                'nickname' => 'Dewi',
                'place_of_birth' => 'Bandung',
                'date_of_birth' => '2011-11-25',
                'address' => 'Jl. Dago No. 12, Bandung',
                'parent_phone' => '081234567893',
                'school_origin' => 'SMP Negeri 5 Bandung',
                'class_level_id' => $smp7?->id,
                'program_interest' => 'Mapel SMP',
            ],
            [
                'name' => 'Muhammad Fahri',
                'nickname' => 'Fahri',
                'place_of_birth' => 'Yogyakarta',
                'date_of_birth' => '2018-01-05',
                'address' => 'Jl. Kaliurang KM 5, Yogyakarta',
                'parent_phone' => '081234567894',
                'school_origin' => 'TK Al-Quran',
                'class_level_id' => $tahfidz?->id,
                'program_interest' => 'Tahfidz',
            ],
            [
                'name' => 'Kartika Sari',
                'nickname' => 'Kartika',
                'place_of_birth' => 'Surabaya',
                'date_of_birth' => '2016-09-30',
                'address' => 'Jl. Diponegoro No. 56, Surabaya',
                'parent_phone' => '081234567895',
                'school_origin' => 'SD Plus Al-Kautsar',
                'class_level_id' => $sd1?->id,
                'program_interest' => 'Tahfidz',
            ],
        ];

        foreach ($students as $studentData) {
            Student::updateOrCreate(
                [
                    'name' => $studentData['name'],
                    'parent_phone' => $studentData['parent_phone'],
                ],
                $studentData
            );
        }
    }
}
