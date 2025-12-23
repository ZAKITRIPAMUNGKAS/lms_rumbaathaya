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
        Schema::table('student_reports', function (Blueprint $table) {
            // Add indexes for better query performance
            $table->index('student_id');
            $table->index('report_date');
            $table->index(['student_id', 'report_date']); // Composite index for latest query
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_reports', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['report_date']);
            $table->dropIndex(['student_id', 'report_date']);
        });
    }
};
