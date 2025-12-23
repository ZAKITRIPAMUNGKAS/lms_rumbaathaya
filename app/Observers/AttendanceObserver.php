<?php

namespace App\Observers;

use App\Models\Attendance;
use Illuminate\Support\Facades\Cache;

class AttendanceObserver
{
    /**
     * Handle the Attendance "created" event.
     */
    public function created(Attendance $attendance): void
    {
        $this->clearStudentStatsCache($attendance->student_id);
    }

    /**
     * Handle the Attendance "updated" event.
     */
    public function updated(Attendance $attendance): void
    {
        $this->clearStudentStatsCache($attendance->student_id);
    }

    /**
     * Handle the Attendance "deleted" event.
     */
    public function deleted(Attendance $attendance): void
    {
        $this->clearStudentStatsCache($attendance->student_id);
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

