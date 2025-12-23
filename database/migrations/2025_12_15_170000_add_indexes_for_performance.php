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
        // Add indexes to users table for faster role queries
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('email');
        });

        // Add indexes to posts table for faster published queries
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['is_published', 'published_at']);
            $table->index('slug');
        });

        // Add indexes to students table
        Schema::table('students', function (Blueprint $table) {
            $table->index('class_level_id');
            $table->index('user_id');
        });

        // Add indexes to attendances table
        Schema::table('attendances', function (Blueprint $table) {
            $table->index('date');
            $table->index('tutor_id');
            $table->index('student_id');
            $table->index('status');
        });

        // Add indexes to schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->index('tutor_id');
            $table->index('student_id');
            $table->index('is_active');
        });

        // Add indexes to materials table
        Schema::table('materials', function (Blueprint $table) {
            $table->index('subject_id');
            $table->index('class_level_id');
            $table->index('uploaded_by');
        });

        // Add indexes to testimonials table
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('is_published');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['email']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['is_published', 'published_at']);
            $table->dropIndex(['slug']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['class_level_id']);
            $table->dropIndex(['user_id']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropIndex(['tutor_id']);
            $table->dropIndex(['student_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex(['tutor_id']);
            $table->dropIndex(['student_id']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['class_level_id']);
            $table->dropIndex(['uploaded_by']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['is_published']);
            $table->dropIndex(['sort_order']);
        });
    }
};

