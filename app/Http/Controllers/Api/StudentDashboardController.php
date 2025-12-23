<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\StudentReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StudentDashboardController extends BaseApiController
{
    /**
     * Get student dashboard statistics
     */
    public function stats(): JsonResponse
    {
        $this->requireStudent();
        $user = $this->getAuthUser();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student profile not found',
            ], 404);
        }

        $cacheKey = "student_dashboard_stats_{$student->id}_" . now()->format('Y-m-d-H');
        
        $stats = Cache::remember($cacheKey, 300, function () use ($student) {
            // Active classes count
            $activeClasses = Schedule::where('student_id', $student->id)
                ->where('is_active', true)
                ->distinct('subject_id')
                ->count('subject_id');

            // Completed materials (using attendance as proxy)
            $completedMaterials = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->count();

            // Completed tasks (student reports)
            $completedTasks = StudentReport::where('student_id', $student->id)
                ->count();

            // Average score
            $averageScore = StudentReport::where('student_id', $student->id)
                ->avg('score') ?? 0;

            // Monthly attendance
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $monthlyAttendance = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();

            return [
                'active_classes' => $activeClasses,
                'completed_materials' => $completedMaterials,
                'completed_tasks' => $completedTasks,
                'average_score' => round($averageScore, 0),
                'monthly_attendance' => $monthlyAttendance,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get student schedules/classes
     */
    public function schedules(): JsonResponse
    {
        $this->requireStudent();
        $user = $this->getAuthUser();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student profile not found',
            ], 404);
        }

        $schedules = Schedule::where('student_id', $student->id)
            ->where('is_active', true)
            ->with(['subject:id,name', 'tutor:id,name'])
            ->orderBy('day_of_week')
            ->orderBy('time_start')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'subject' => $schedule->subject->name ?? 'N/A',
                    'tutor' => $schedule->tutor->name ?? 'N/A',
                    'day_of_week' => $schedule->day_of_week,
                    'time_start' => $schedule->time_start,
                    'time_end' => $schedule->time_end,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $schedules,
        ]);
    }

    /**
     * Get recent activities
     */
    public function activities(): JsonResponse
    {
        $this->requireStudent();
        $user = $this->getAuthUser();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student profile not found',
            ], 404);
        }

        $activities = Attendance::where('student_id', $student->id)
            ->with(['schedule.subject:id,name', 'tutor:id,name'])
            ->latest('date')
            ->take(5)
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'date' => $attendance->date->format('Y-m-d'),
                    'subject' => $attendance->schedule->subject->name ?? 'N/A',
                    'tutor' => $attendance->tutor->name ?? 'N/A',
                    'topic' => $attendance->topic_taught,
                    'status' => $attendance->status,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $activities,
        ]);
    }
}
