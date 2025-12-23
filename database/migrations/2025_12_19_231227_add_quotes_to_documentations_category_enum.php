<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan 'Quotes' ke ENUM category pada tabel documentations.
     * Karena ENUM di MySQL tidak bisa diubah langsung dengan Schema builder,
     * kita menggunakan DB::statement untuk menjalankan ALTER TABLE langsung.
     */
    public function up(): void
    {
        // Modifikasi kolom category untuk menambahkan 'Quotes' ke ENUM
        DB::statement("ALTER TABLE documentations MODIFY COLUMN category ENUM('Kegiatan Belajar', 'Event', 'Karya Siswa', 'Testimoni', 'Quotes', 'Lainnya') DEFAULT 'Kegiatan Belajar'");
    }

    /**
     * Reverse the migrations.
     * 
     * Mengembalikan ENUM ke versi sebelumnya tanpa 'Quotes'.
     * Catatan: Jika ada data dengan category 'Quotes', akan diubah menjadi NULL atau default.
     */
    public function down(): void
    {
        // Kembalikan ke ENUM tanpa 'Quotes'
        // Update data yang menggunakan 'Quotes' menjadi 'Lainnya' terlebih dahulu
        DB::statement("UPDATE documentations SET category = 'Lainnya' WHERE category = 'Quotes'");
        
        // Kembalikan ENUM ke versi sebelumnya
        DB::statement("ALTER TABLE documentations MODIFY COLUMN category ENUM('Kegiatan Belajar', 'Event', 'Karya Siswa', 'Testimoni', 'Lainnya') DEFAULT 'Kegiatan Belajar'");
    }
};
