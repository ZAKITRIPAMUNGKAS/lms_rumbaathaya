<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Check if index exists
     */
    private function hasIndex(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $databaseName = $connection->getDatabaseName();
        
        try {
            $result = DB::select(
                "SELECT COUNT(*) as count FROM information_schema.statistics 
                 WHERE table_schema = ? AND table_name = ? AND index_name = ?",
                [$databaseName, $table, $indexName]
            );
            
            return $result[0]->count > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Indexes for students table
        Schema::table('students', function (Blueprint $table) {
            if (!$this->hasIndex('students', 'students_name_index')) {
                $table->index('name');
            }
            if (!$this->hasIndex('students', 'students_nickname_index')) {
                $table->index('nickname');
            }
            if (!$this->hasIndex('students', 'students_user_id_index')) {
                $table->index('user_id');
            }
            if (!$this->hasIndex('students', 'students_class_level_id_index')) {
                $table->index('class_level_id');
            }
            if (!$this->hasIndex('students', 'students_program_interest_index')) {
                $table->index('program_interest');
            }
            if (!$this->hasIndex('students', 'students_parent_phone_index')) {
                $table->index('parent_phone');
            }
            if (!$this->hasIndex('students', 'students_school_origin_index')) {
                $table->index('school_origin');
            }
        });

        // Indexes for users table
        Schema::table('users', function (Blueprint $table) {
            if (!$this->hasIndex('users', 'users_name_index')) {
                $table->index('name');
            }
            if (!$this->hasIndex('users', 'users_email_index')) {
                $table->index('email');
            }
            if (!$this->hasIndex('users', 'users_role_index')) {
                $table->index('role');
            }
        });

        // Indexes for schedules table
        Schema::table('schedules', function (Blueprint $table) {
            if (!$this->hasIndex('schedules', 'schedules_tutor_id_index')) {
                $table->index('tutor_id');
            }
            if (!$this->hasIndex('schedules', 'schedules_student_id_index')) {
                $table->index('student_id');
            }
            if (!$this->hasIndex('schedules', 'schedules_subject_id_index')) {
                $table->index('subject_id');
            }
            if (!$this->hasIndex('schedules', 'schedules_day_of_week_index')) {
                $table->index('day_of_week');
            }
            if (!$this->hasIndex('schedules', 'schedules_is_active_index')) {
                $table->index('is_active');
            }
            if (!$this->hasIndex('schedules', 'schedules_day_of_week_is_active_index')) {
                $table->index(['day_of_week', 'is_active']); // Composite index
            }
        });

        // Indexes for materials table
        Schema::table('materials', function (Blueprint $table) {
            if (!$this->hasIndex('materials', 'materials_title_index')) {
                $table->index('title');
            }
            if (!$this->hasIndex('materials', 'materials_subject_id_index')) {
                $table->index('subject_id');
            }
            if (!$this->hasIndex('materials', 'materials_class_level_id_index')) {
                $table->index('class_level_id');
            }
            if (!$this->hasIndex('materials', 'materials_uploaded_by_index')) {
                $table->index('uploaded_by');
            }
        });

        // Indexes for posts table
        Schema::table('posts', function (Blueprint $table) {
            if (!$this->hasIndex('posts', 'posts_title_index')) {
                $table->index('title');
            }
            if (!$this->hasIndex('posts', 'posts_slug_index')) {
                $table->index('slug');
            }
            if (!$this->hasIndex('posts', 'posts_category_index')) {
                $table->index('category');
            }
            if (!$this->hasIndex('posts', 'posts_is_published_index')) {
                $table->index('is_published');
            }
            if (!$this->hasIndex('posts', 'posts_published_at_index')) {
                $table->index('published_at');
            }
        });

        // Indexes for attendances table
        Schema::table('attendances', function (Blueprint $table) {
            if (!$this->hasIndex('attendances', 'attendances_student_id_index')) {
                $table->index('student_id');
            }
            if (!$this->hasIndex('attendances', 'attendances_tutor_id_index')) {
                $table->index('tutor_id');
            }
            if (!$this->hasIndex('attendances', 'attendances_date_index')) {
                $table->index('date');
            }
            if (!$this->hasIndex('attendances', 'attendances_status_index')) {
                $table->index('status');
            }
            if (!$this->hasIndex('attendances', 'attendances_student_id_date_index')) {
                $table->index(['student_id', 'date']); // Composite index
            }
            if (!$this->hasIndex('attendances', 'attendances_tutor_id_date_index')) {
                $table->index(['tutor_id', 'date']); // Composite index
            }
        });

        // Indexes for student_reports table
        Schema::table('student_reports', function (Blueprint $table) {
            if (!$this->hasIndex('student_reports', 'student_reports_student_id_index')) {
                $table->index('student_id');
            }
            if (!$this->hasIndex('student_reports', 'student_reports_subject_id_index')) {
                $table->index('subject_id');
            }
            if (!$this->hasIndex('student_reports', 'student_reports_period_index')) {
                $table->index('period');
            }
            if (!$this->hasIndex('student_reports', 'student_reports_report_date_index')) {
                $table->index('report_date');
            }
            if (!$this->hasIndex('student_reports', 'student_reports_student_id_subject_id_index')) {
                $table->index(['student_id', 'subject_id']); // Composite index
            }
        });

        // Indexes for registrations table
        Schema::table('registrations', function (Blueprint $table) {
            if (!$this->hasIndex('registrations', 'registrations_full_name_index')) {
                $table->index('full_name');
            }
            if (!$this->hasIndex('registrations', 'registrations_nickname_index')) {
                $table->index('nickname');
            }
            if (!$this->hasIndex('registrations', 'registrations_program_index')) {
                $table->index('program');
            }
            if (!$this->hasIndex('registrations', 'registrations_status_index')) {
                $table->index('status');
            }
            if (!$this->hasIndex('registrations', 'registrations_created_at_index')) {
                $table->index('created_at');
            }
        });

        // Indexes for documentations table (only if table exists)
        if (Schema::hasTable('documentations')) {
            Schema::table('documentations', function (Blueprint $table) {
                if (!$this->hasIndex('documentations', 'documentations_title_index')) {
                    $table->index('title');
                }
                if (!$this->hasIndex('documentations', 'documentations_type_index')) {
                    $table->index('type');
                }
                if (!$this->hasIndex('documentations', 'documentations_category_index')) {
                    $table->index('category');
                }
                if (!$this->hasIndex('documentations', 'documentations_is_published_index')) {
                    $table->index('is_published');
                }
                if (!$this->hasIndex('documentations', 'documentations_sort_order_index')) {
                    $table->index('sort_order');
                }
                if (!$this->hasIndex('documentations', 'documentations_event_date_index')) {
                    $table->index('event_date');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes for students table
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['nickname']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['class_level_id']);
            $table->dropIndex(['program_interest']);
            $table->dropIndex(['parent_phone']);
            $table->dropIndex(['school_origin']);
        });

        // Drop indexes for users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['email']);
            $table->dropIndex(['role']);
        });

        // Drop indexes for schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex(['tutor_id']);
            $table->dropIndex(['student_id']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['day_of_week']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['day_of_week', 'is_active']);
        });

        // Drop indexes for materials table
        Schema::table('materials', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['class_level_id']);
            $table->dropIndex(['uploaded_by']);
        });

        // Drop indexes for posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['slug']);
            $table->dropIndex(['category']);
            $table->dropIndex(['is_published']);
            $table->dropIndex(['published_at']);
        });

        // Drop indexes for attendances table
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['tutor_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['status']);
            $table->dropIndex(['student_id', 'date']);
            $table->dropIndex(['tutor_id', 'date']);
        });

        // Drop indexes for student_reports table
        Schema::table('student_reports', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['subject_id']);
            $table->dropIndex(['period']);
            $table->dropIndex(['report_date']);
            $table->dropIndex(['student_id', 'subject_id']);
        });

        // Drop indexes for registrations table
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropIndex(['full_name']);
            $table->dropIndex(['nickname']);
            $table->dropIndex(['program']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });

        // Drop indexes for documentations table
        Schema::table('documentations', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['type']);
            $table->dropIndex(['category']);
            $table->dropIndex(['is_published']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['event_date']);
        });
    }
};
