<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Static array containing all program data
     */
    private static function getPrograms(): array
    {
        return [
            'calistung-tk' => [
                'slug' => 'calistung-tk',
                'title' => 'Calistung TK',
                'badge' => 'Khusus TK',
                'badge_color' => 'pink',
                'description' => 'Program khusus untuk Sahabat Rumba Athaya yang masih duduk di Taman Kanak-kanak agar bisa lebih cepat membaca, menulis, serta menghitung.',
                'benefits' => [
                    'Metode Belajar Sambil Bermain',
                    'Persiapan Masuk SD',
                    'Tutor Sabar & Telaten',
                ],
                'image' => asset('heaedr produk.png'),
                'color' => 'pink',
            ],
            'sd-kelas-1-3' => [
                'slug' => 'sd-kelas-1-3',
                'title' => 'SD Kelas 1–3',
                'badge' => 'Fondasi Juara',
                'badge_color' => 'orange',
                'description' => 'Sahabat Rumba yang masih duduk di sekolah dasar pasti mau kan jadi juara di sekolah? Rumba Athaya membantu agar nilai rapormu meningkat. Kamu akan BELAJAR dengan tutor yang akrab dan berkualitas.',
                'benefits' => [
                    'Bantuan PR Harian',
                    'Persiapan Ujian Sekolah',
                    'Penguatan Calistung Lanjutan',
                ],
                'image' => asset('heaedr produk.png'),
                'color' => 'orange',
            ],
            'sd-kelas-4-6' => [
                'slug' => 'sd-kelas-4-6',
                'title' => 'SD Kelas 4–6',
                'badge' => 'Persiapan SMP',
                'badge_color' => 'red',
                'description' => 'Persiapan masuk SMP Favorit! Kami membiasakan siswa BERLATIH mengerjakan berbagai variasi soal yang mirip dengan ujian sekolah agar BERPRESTASI baik akademik maupun non-akademik.',
                'benefits' => [
                    'Drilling Soal Ujian',
                    'Strategi Masuk SMP Favorit',
                    'Konsultasi Akademik',
                ],
                'image' => asset('heaedr produk.png'),
                'color' => 'red',
            ],
            'smp-kelas-7-9' => [
                'slug' => 'smp-kelas-7-9',
                'title' => 'SMP Kelas 7–9',
                'badge' => 'Siap SMA Favorit',
                'badge_color' => 'blue',
                'description' => 'Persiapan masuk SMA Favorit. Di sini kamu akan BELAJAR bareng pengajar berkualitas, BERLATIH soal variatif, dan BERTANDING melalui Try Out berbasis aplikasi.',
                'benefits' => [
                    'Try Out Berbasis Aplikasi',
                    'Bedah Kisi-kisi Ujian',
                    'Persiapan Masuk SMA Unggulan',
                ],
                'image' => asset('heaedr produk.png'),
                'color' => 'blue',
            ],
            'kelas-tahfidz' => [
                'slug' => 'kelas-tahfidz',
                'title' => 'Kelas Tahfidz',
                'badge' => 'Hafalan & Tahsin',
                'badge_color' => 'green',
                'description' => 'Program khusus untuk mendalami ilmu agama terutama hafalan Al-Qur\'an serta perbaikan bacaan (Tahsin).',
                'benefits' => [
                    'Setoran Hafalan',
                    'Perbaikan Tajwid (Tahsin)',
                    'Suasana Religius',
                ],
                'image' => asset('heaedr produk.png'),
                'color' => 'green',
                'featured' => true,
            ],
        ];
    }

    /**
     * Display the specified program detail page.
     */
    public function show(string $slug)
    {
        $programs = self::getPrograms();
        
        if (!isset($programs[$slug])) {
            abort(404, 'Program tidak ditemukan');
        }

        $program = $programs[$slug];
        return view('pages.program-show', compact('program'));
    }

    /**
     * Get all programs (for API or other uses)
     */
    public static function getAllPrograms(): array
    {
        return self::getPrograms();
    }
}
