<?php

namespace Database\Seeders;

use App\Models\ClassLevel;
use App\Models\Material;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get tutors
        $tutors = User::where('role', 'tutor')->get();
        if ($tutors->isEmpty()) {
            $this->command->warn('No tutors found. Please run UserSeeder first.');
            return;
        }

        // Get subjects
        $matematika = Subject::where('name', 'like', '%Matematika%')->first();
        $bahasaIndonesia = Subject::where('name', 'like', '%Bahasa Indonesia%')->first();
        $ipa = Subject::where('name', 'like', '%IPA%')->first();
        $bahasaInggris = Subject::where('name', 'like', '%Bahasa Inggris%')->first();
        $tahfidz = Subject::where('name', 'Tahfidz')->first();
        $calistung = Subject::where('name', 'Calistung')->first();

        // Get class levels
        $tk = ClassLevel::where('name', 'TK')->first();
        $sd1 = ClassLevel::where('name', 'SD Kelas 1')->first();
        $sd4 = ClassLevel::where('name', 'SD Kelas 4')->first();
        $smp7 = ClassLevel::where('name', 'SMP Kelas 7')->first();

        $materials = [
            [
                'title' => 'Pengenalan Angka 1-10',
                'description' => 'Materi pembelajaran pengenalan angka untuk anak TK',
                'subject_id' => $calistung?->id,
                'class_level_id' => $tk?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Membaca Huruf A-Z',
                'description' => 'Materi pembelajaran membaca huruf alfabet',
                'subject_id' => $calistung?->id,
                'class_level_id' => $tk?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Penjumlahan Dasar',
                'description' => 'Belajar penjumlahan bilangan 1-20 untuk SD Kelas 1',
                'subject_id' => $matematika?->id,
                'class_level_id' => $sd1?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Membaca Cerita Pendek',
                'description' => 'Latihan membaca dan memahami cerita pendek',
                'subject_id' => $bahasaIndonesia?->id,
                'class_level_id' => $sd1?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Perkalian dan Pembagian',
                'description' => 'Materi perkalian dan pembagian untuk SD Kelas 4',
                'subject_id' => $matematika?->id,
                'class_level_id' => $sd4?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Sistem Pencernaan Manusia',
                'description' => 'Belajar tentang sistem pencernaan pada manusia',
                'subject_id' => $ipa?->id,
                'class_level_id' => $sd4?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Aljabar Dasar',
                'description' => 'Pengenalan aljabar untuk SMP Kelas 7',
                'subject_id' => $matematika?->id,
                'class_level_id' => $smp7?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Simple Present Tense',
                'description' => 'Belajar tenses dalam bahasa Inggris',
                'subject_id' => $bahasaInggris?->id,
                'class_level_id' => $smp7?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Hafalan Surat Al-Fatihah',
                'description' => 'Materi tahfidz surat Al-Fatihah',
                'subject_id' => $tahfidz?->id,
                'class_level_id' => $tk?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
            [
                'title' => 'Hafalan Surat Al-Ikhlas',
                'description' => 'Materi tahfidz surat Al-Ikhlas',
                'subject_id' => $tahfidz?->id,
                'class_level_id' => $sd1?->id,
                'uploaded_by' => $tutors->first()->id,
            ],
        ];

        foreach ($materials as $index => $material) {
            Material::updateOrCreate(
                [
                    'title' => $material['title'],
                    'subject_id' => $material['subject_id'],
                    'class_level_id' => $material['class_level_id'],
                ],
                $material
            );
        }
    }
}
