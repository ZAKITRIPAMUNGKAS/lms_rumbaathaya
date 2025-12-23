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
        Schema::table('attendances', function (Blueprint $table) {
            // Composite index untuk query monthly attendance yang lebih cepat
            $table->index(['student_id', 'status', 'date'], 'attendances_student_status_date_idx');
        });

        Schema::table('schedules', function (Blueprint $table) {
            // Composite index untuk query active schedules
            $table->index(['student_id', 'is_active'], 'schedules_student_active_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex('attendances_student_status_date_idx');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex('schedules_student_active_idx');
        });
    }
};
