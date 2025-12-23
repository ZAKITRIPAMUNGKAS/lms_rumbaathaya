<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Selamat, Rumba Athaya Raih Penghargaan Bimbel Terbaik!',
                'content' => 'Rumba Athaya kembali menorehkan prestasi dengan meraih penghargaan sebagai Bimbingan Belajar Terbaik di Kota Semarang. Penghargaan ini diberikan atas dedikasi kami dalam memberikan layanan pendidikan berkualitas bagi siswa-siswi SD hingga SMA. Terima kasih atas kepercayaan Sahabat Rumba dan Orang Tua!',
                'category' => 'Kabar Rumba',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Tips Sukses Menghadapi Ujian Nasional',
                'content' => 'Ujian Nasional semakin dekat! Jangan panik, Sahabat Rumba. Yuk simak tips jitu dari Tutor Rumba Athaya agar kamu bisa menghadapi ujian dengan tenang dan mendapatkan nilai maksimal. Mulai dari manajemen waktu, cara meringkas materi, hingga menjaga kesehatan.',
                'category' => 'Info',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Karya Siswa: Puisi "Guruku Pahlawanku"',
                'content' => 'Simak puisi indah karya Aninda, siswa kelas 5 SD Rumba Athaya, yang dipersembahkan untuk para guru di Hari Guru Nasional. Bakat sastra Sahabat Rumba memang luar biasa! Terus berkarya ya, Aninda.',
                'category' => 'Karya Siswa',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Pendaftaran Program Intensif Persiapan masuk SMP Favorit Dibuka!',
                'content' => 'Bagi Sahabat Rumba kelas 6 SD yang ingin masuk SMP Favorit, segera daftarkan dirimu di Program Intensif Rumba Athaya. Kuota terbatas! Dapatkan materi eksklusif, drill soal, dan try out berkala.',
                'category' => 'Info',
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($posts as $post) {
            Post::firstOrCreate(
                ['title' => $post['title']],
                array_merge($post, ['slug' => Str::slug($post['title'])])
            );
        }
    }
}
