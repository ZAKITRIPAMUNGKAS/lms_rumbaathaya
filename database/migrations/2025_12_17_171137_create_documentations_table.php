<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['photo', 'video']); // photo atau video
            $table->string('file_path')->nullable(); // untuk foto atau video file
            $table->string('video_url')->nullable(); // untuk YouTube atau video URL
            $table->string('thumbnail')->nullable(); // thumbnail untuk video
            $table->enum('category', ['Kegiatan Belajar', 'Event', 'Karya Siswa', 'Testimoni', 'Lainnya'])->default('Kegiatan Belajar');
            $table->date('event_date')->nullable(); // tanggal kegiatan
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0); // untuk urutan tampilan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentations');
    }
};
