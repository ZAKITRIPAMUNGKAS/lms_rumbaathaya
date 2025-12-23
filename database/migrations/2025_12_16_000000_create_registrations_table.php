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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('nickname');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->text('address');
            $table->string('school_name');
            $table->enum('program', [
                'Calistung (TK-SD Kelas 1)',
                'MAPEL SD',
                'MAPEL SMP',
                'MAPEL SMA',
                'Tahfidz',
                'Yang lain'
            ]);
            $table->string('program_other')->nullable();
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};

