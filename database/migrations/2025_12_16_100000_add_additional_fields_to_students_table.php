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
        Schema::table('students', function (Blueprint $table) {
            $table->string('nickname')->nullable()->after('name');
            $table->string('place_of_birth')->nullable()->after('nickname');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->text('address')->nullable()->after('date_of_birth');
            $table->enum('program_interest', ['Calistung', 'Mapel SD', 'Mapel SMP', 'Mapel SMA', 'Tahfidz'])->nullable()->after('address');
            $table->string('profile_photo_path')->nullable()->after('program_interest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'nickname',
                'place_of_birth',
                'date_of_birth',
                'address',
                'program_interest',
                'profile_photo_path',
            ]);
        });
    }
};

