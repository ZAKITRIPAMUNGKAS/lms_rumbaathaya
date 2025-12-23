<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            'Matematika',
            'Bahasa Indonesia',
            'IPA (Ilmu Pengetahuan Alam)',
            'IPS (Ilmu Pengetahuan Sosial)',
            'Bahasa Inggris',
            'Pendidikan Agama Islam',
            'PKn (Pendidikan Kewarganegaraan)',
            'SBdP (Seni Budaya dan Prakarya)',
            'PJOK (Pendidikan Jasmani, Olahraga, dan Kesehatan)',
            'Tahfidz',
            'Tahsin',
            'Calistung',
        ];

        foreach ($subjects as $subjectName) {
            Subject::updateOrCreate(
                ['slug' => Str::slug($subjectName)],
                ['name' => $subjectName]
            );
        }
    }
}
