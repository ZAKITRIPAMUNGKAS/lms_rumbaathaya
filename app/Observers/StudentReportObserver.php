<?php

namespace App\Observers;

use App\Models\StudentReport;
use Illuminate\Support\Facades\Cache;

class StudentReportObserver
{
    /**
     * Handle the StudentReport "created" event.
     */
    public function created(StudentReport $studentReport): void
    {
        $this->clearStudentStatsCache($studentReport->student_id);
    }

    /**
     * Handle the StudentReport "updated" event.
     */
    public function updated(StudentReport $studentReport): void
    {
        $this->clearStudentStatsCache($studentReport->student_id);
    }

    /**
     * Handle the StudentReport "deleted" event.
     */
    public function deleted(StudentReport $studentReport): void
    {
        $this->clearStudentStatsCache($studentReport->student_id);
    }

    protected function clearStudentStatsCache($studentId): void
    {
        // Clear student stats cache - clear current hour cache
        $currentHour = now()->format('Y-m-d-H');
        for ($i = 0; $i < 60; $i++) {
            $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
            Cache::forget("student_stats_{$studentId}_{$currentHour}-{$minute}");
        }
    }
}

