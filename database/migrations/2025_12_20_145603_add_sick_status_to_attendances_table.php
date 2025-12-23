<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify enum to include 'sick' status
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('present', 'absent', 'permission', 'sick') DEFAULT 'present'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum without 'sick'
        DB::statement("ALTER TABLE attendances MODIFY COLUMN status ENUM('present', 'absent', 'permission') DEFAULT 'present'");
    }
};
