<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Material;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class TutorDashboardController extends BaseApiController
{
    /**
     * Get tutor dashboard statistics
     */
    public function stats(): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $cacheKey = "tutor_dashboard_stats_{$tutor->id}_" . now()->format('Y-m-d-H');
        
        $stats = Cache::remember($cacheKey, 300, function () use ($tutor) {
            // Total active students
            $activeStudents = Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->distinct('student_id')
                ->count('student_id');

            // Active classes
            $activeClasses = Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->count();

            // Materials uploaded
            $materialsUploaded = $tutor->uploadedMaterials()->count();

            // Today's attendance
            $todayAttendance = Attendance::where('tutor_id', $tutor->id)
                ->whereDate('date', Carbon::today())
                ->where('status', 'present')
                ->count();

            // Monthly attendance
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $monthlyAttendance = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->where('status', 'present')
                ->count();

            return [
                'active_students' => $activeStudents,
                'active_classes' => $activeClasses,
                'materials_uploaded' => $materialsUploaded,
                'today_attendance' => $todayAttendance,
                'monthly_attendance' => $monthlyAttendance,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get upcoming schedules/classes for the authenticated tutor
     */
    public function schedules(): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $cacheKey = "tutor_schedules_{$tutor->id}_" . now()->format('Y-m-d-H');
        
        $schedules = Cache::remember($cacheKey, 300, function () use ($tutor) {
            return Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->with(['subject:id,name', 'student:id,name'])
                ->orderBy('day_of_week')
                ->orderBy('time_start')
                ->get()
                ->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'subject' => $schedule->subject->name ?? 'N/A',
                        'subject_id' => $schedule->subject_id,
                        'student' => $schedule->student->name ?? 'N/A',
                        'student_id' => $schedule->student_id,
                        'day_of_week' => $schedule->day_of_week,
                        'time_start' => $schedule->time_start,
                        'time_end' => $schedule->time_end,
                        'type' => $schedule->type ?? 'offline',
                        'created_at' => $schedule->created_at?->toISOString(),
                    ];
                });
        });

        return response()->json([
            'success' => true,
            'data' => $schedules,
        ]);
    }

    /**
     * Get upcoming classes (alias for schedules for backward compatibility)
     */
    public function upcomingClasses(): JsonResponse
    {
        return $this->schedules();
    }

    /**
     * Get weekly activity data (last 7 days) for chart
     * Returns student attendance/activity data for the authenticated tutor
     */
    public function activity(): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $cacheKey = "tutor_weekly_activity_{$tutor->id}_" . now()->format('Y-m-d-H');
        
        $activityData = Cache::remember($cacheKey, 300, function () use ($tutor) {
            // Get day names in Indonesian
            $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            
            // Helper function to get day name
            $getDayName = function($date) use ($dayNames) {
                // Carbon dayOfWeek: 0=Sunday, 1=Monday, ..., 6=Saturday
                // Our array: 0=Monday, 1=Tuesday, ..., 6=Sunday
                $dayOfWeek = $date->dayOfWeek;
                if ($dayOfWeek === 0) {
                    return $dayNames[6]; // Sunday
                }
                return $dayNames[$dayOfWeek - 1]; // Monday-Saturday
            };
            
            // Weekly student attendance (last 7 days)
            $weeklyActivity = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $count = Attendance::where('tutor_id', $tutor->id)
                    ->whereDate('date', $date->format('Y-m-d'))
                    ->where('status', 'present')
                    ->count();
                $weeklyActivity[] = [
                    'day' => $getDayName($date),
                    'aktivitas' => $count,
                    'date' => $date->format('Y-m-d'),
                ];
            }
            
            return $weeklyActivity;
        });

        return response()->json([
            'success' => true,
            'data' => $activityData,
        ]);
    }

    /**
     * Get weekly activity (alias for activity for backward compatibility)
     */
    public function weeklyActivity(): JsonResponse
    {
        return $this->activity();
    }

    /**
     * Get students for a specific schedule
     * Since a schedule has a single student, this returns an array with that student
     */
    public function scheduleStudents(int $id): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $schedule = Schedule::where('tutor_id', $tutor->id)
            ->with('student:id,name')
            ->find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
            ], 404);
        }

        // Return array with the single student (for consistency with frontend expectations)
        $students = [];
        if ($schedule->student) {
            $students[] = [
                'id' => $schedule->student->id,
                'name' => $schedule->student->name,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $students,
        ]);
    }

    /**
     * Get comprehensive reports for the authenticated tutor
     * GET /api/v1/tutor/reports
     */
    public function reports(Request $request): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $cacheKey = "tutor_reports_{$tutor->id}_" . now()->format('Y-m-d-H');
        
        $reports = Cache::remember($cacheKey, 300, function () use ($tutor) {
            // 1. Attendance Summary
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            
            $totalAttendances = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();
            
            $presentCount = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->where('status', 'present')
                ->count();
            
            $absentCount = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->where('status', 'absent')
                ->count();
            
            $permissionCount = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->where('status', 'permission')
                ->count();
            
            $sickCount = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->where('status', 'sick')
                ->count();
            
            $attendanceRate = $totalAttendances > 0 
                ? round(($presentCount / $totalAttendances) * 100, 2) 
                : 0;
            
            $attendanceSummary = [
                'total_classes' => $totalAttendances,
                'present_count' => $presentCount,
                'absent_count' => $absentCount,
                'permission_count' => $permissionCount,
                'sick_count' => $sickCount,
                'attendance_rate' => $attendanceRate,
            ];

            // 2. Material Stats
            $totalMaterials = Material::where('tutor_id', $tutor->id)->count();
            
            // Get materials by subject
            $materialsBySubject = Material::where('tutor_id', $tutor->id)
                ->with('subject:id,name')
                ->get()
                ->groupBy('subject_id')
                ->map(function ($materials, $subjectId) {
                    $subject = $materials->first()->subject;
                    return [
                        'subject' => $subject ? $subject->name : 'Lainnya',
                        'count' => $materials->count(),
                        'downloads' => 0, // Material model doesn't have downloads field yet
                    ];
                })
                ->values()
                ->toArray();
            
            $materialStats = [
                'total_materials' => $totalMaterials,
                'total_downloads' => 0, // Material model doesn't have downloads field yet
                'materials_by_subject' => $materialsBySubject,
            ];

            // 3. Student Progress (students with attendance rate < 70%)
            $studentIds = Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->distinct()
                ->pluck('student_id');
            
            $studentProgress = [];
            
            foreach ($studentIds as $studentId) {
                $student = Student::find($studentId);
                if (!$student) continue;
                
                // Get all attendances for this student with this tutor
                $studentAttendances = Attendance::where('tutor_id', $tutor->id)
                    ->where('student_id', $studentId)
                    ->whereBetween('date', [$startOfMonth, $endOfMonth])
                    ->get();
                
                $totalClasses = $studentAttendances->count();
                $presentCount = $studentAttendances->where('status', 'present')->count();
                
                $studentAttendanceRate = $totalClasses > 0 
                    ? round(($presentCount / $totalClasses) * 100, 2) 
                    : 0;
                
                $lastAttendance = $studentAttendances->sortByDesc('date')->first();
                
                $studentProgress[] = [
                    'student_id' => $studentId,
                    'student_name' => $student->name,
                    'attendance_rate' => $studentAttendanceRate,
                    'total_classes' => $totalClasses,
                    'present_count' => $presentCount,
                    'last_attendance' => $lastAttendance ? $lastAttendance->date->format('Y-m-d') : null,
                ];
            }
            
            // Filter students with attendance rate < 70% and sort by attendance rate
            $lowAttendanceStudents = collect($studentProgress)
                ->filter(function ($student) {
                    return $student['attendance_rate'] < 70;
                })
                ->sortBy('attendance_rate')
                ->values()
                ->toArray();

            return [
                'attendance_summary' => $attendanceSummary,
                'material_stats' => $materialStats,
                'student_progress' => $lowAttendanceStudents,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $reports,
        ]);
    }

    /**
     * Get options for schedule form (students, subjects)
     * GET /api/v1/tutor/schedules/options
     */
    public function scheduleOptions(): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        // Get students that are assigned to this tutor's schedules
        $studentIds = Schedule::where('tutor_id', $tutor->id)
            ->where('is_active', true)
            ->distinct()
            ->pluck('student_id')
            ->filter();

        // Get all students (tutor can create schedules for any student)
        // Or only students from their existing schedules
        $students = Student::select('id', 'name')
            ->orderBy('name')
            ->get();

        // Get all subjects
        $subjects = Subject::select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'students' => $students,
                'subjects' => $subjects,
            ],
        ]);
    }

    /**
     * Create a new schedule (tutor can only create for themselves)
     * POST /api/v1/tutor/schedules
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'is_active' => 'sometimes|boolean',
        ]);

        // Auto-inject tutor_id (tutor can only create schedules for themselves)
        $validated['tutor_id'] = $tutor->id;

        // Check for tutor scheduling conflicts
        $tutorConflict = Schedule::where('tutor_id', $tutor->id)
            ->where('day_of_week', $validated['day_of_week'])
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->whereRaw('time_start < ? AND time_end > ?', [
                    $validated['time_end'],
                    $validated['time_start']
                ]);
            })
            ->exists();

        if ($tutorConflict) {
            $conflictingSchedule = Schedule::where('tutor_id', $tutor->id)
                ->where('day_of_week', $validated['day_of_week'])
                ->where('is_active', true)
                ->where(function($query) use ($validated) {
                    $query->whereRaw('time_start < ? AND time_end > ?', [
                        $validated['time_end'],
                        $validated['time_start']
                    ]);
                })
                ->with('subject')
                ->first();

            $subjectName = $conflictingSchedule && $conflictingSchedule->subject 
                ? $conflictingSchedule->subject->name 
                : 'kelas lain';
            
            return response()->json([
                'success' => false,
                'message' => "Anda sudah memiliki jadwal untuk {$subjectName} pada waktu yang sama. Silakan pilih waktu lain.",
            ], 422);
        }

        // Check for student scheduling conflicts
        $studentConflict = Schedule::where('student_id', $validated['student_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->where('is_active', true)
            ->where(function($query) use ($validated) {
                $query->whereRaw('time_start < ? AND time_end > ?', [
                    $validated['time_end'],
                    $validated['time_start']
                ]);
            })
            ->exists();

        if ($studentConflict) {
            $conflictingSchedule = Schedule::where('student_id', $validated['student_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('is_active', true)
                ->where(function($query) use ($validated) {
                    $query->whereRaw('time_start < ? AND time_end > ?', [
                        $validated['time_end'],
                        $validated['time_start']
                    ]);
                })
                ->with('subject')
                ->first();

            $subjectName = $conflictingSchedule && $conflictingSchedule->subject 
                ? $conflictingSchedule->subject->name 
                : 'mata pelajaran lain';
            
            return response()->json([
                'success' => false,
                'message' => "Siswa sudah memiliki jadwal untuk {$subjectName} pada waktu yang sama. Silakan pilih waktu lain.",
            ], 422);
        }

        $schedule = Schedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil ditambahkan',
            'data' => $schedule->load(['tutor', 'student', 'subject']),
        ], 201);
    }

    /**
     * Update a schedule (tutor can only update their own schedules)
     * PUT /api/v1/tutor/schedules/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $schedule = Schedule::where('id', $id)
            ->where('tutor_id', $tutor->id)
            ->first();

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan atau Anda tidak memiliki akses',
            ], 404);
        }

        $validated = $request->validate([
            'student_id' => 'sometimes|exists:students,id',
            'subject_id' => 'sometimes|exists:subjects,id',
            'day_of_week' => 'sometimes|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_start' => 'sometimes|date_format:H:i',
            'time_end' => 'sometimes|date_format:H:i',
            'is_active' => 'sometimes|boolean',
        ]);

        // Validate time_end is after time_start
        if (isset($validated['time_start']) && isset($validated['time_end'])) {
            if ($validated['time_end'] <= $validated['time_start']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Waktu selesai harus setelah waktu mulai',
                ], 422);
            }
        } elseif (isset($validated['time_end']) && $validated['time_end'] <= $schedule->time_start) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu selesai harus setelah waktu mulai',
            ], 422);
        } elseif (isset($validated['time_start']) && $validated['time_start'] >= $schedule->time_end) {
            return response()->json([
                'success' => false,
                'message' => 'Waktu mulai harus sebelum waktu selesai',
            ], 422);
        }

        // Prepare conflict check data
        $checkTutorId = $tutor->id; // Tutor cannot change tutor_id
        $checkStudentId = $validated['student_id'] ?? $schedule->student_id;
        $checkDay = $validated['day_of_week'] ?? $schedule->day_of_week;
        $checkTimeStart = $validated['time_start'] ?? $schedule->time_start;
        $checkTimeEnd = $validated['time_end'] ?? $schedule->time_end;

        // Check for tutor scheduling conflicts (exclude current schedule)
        $tutorConflict = Schedule::where('tutor_id', $checkTutorId)
            ->where('day_of_week', $checkDay)
            ->where('is_active', true)
            ->where('id', '!=', $schedule->id)
            ->where(function($query) use ($checkTimeStart, $checkTimeEnd) {
                $query->whereRaw('time_start < ? AND time_end > ?', [
                    $checkTimeEnd,
                    $checkTimeStart
                ]);
            })
            ->exists();

        if ($tutorConflict) {
            $conflictingSchedule = Schedule::where('tutor_id', $checkTutorId)
                ->where('day_of_week', $checkDay)
                ->where('is_active', true)
                ->where('id', '!=', $schedule->id)
                ->where(function($query) use ($checkTimeStart, $checkTimeEnd) {
                    $query->whereRaw('time_start < ? AND time_end > ?', [
                        $checkTimeEnd,
                        $checkTimeStart
                    ]);
                })
                ->with('subject')
                ->first();

            $subjectName = $conflictingSchedule && $conflictingSchedule->subject 
                ? $conflictingSchedule->subject->name 
                : 'kelas lain';
            
            return response()->json([
                'success' => false,
                'message' => "Anda sudah memiliki jadwal untuk {$subjectName} pada waktu yang sama. Silakan pilih waktu lain.",
            ], 422);
        }

        // Check for student scheduling conflicts (exclude current schedule)
        $studentConflict = Schedule::where('student_id', $checkStudentId)
            ->where('day_of_week', $checkDay)
            ->where('is_active', true)
            ->where('id', '!=', $schedule->id)
            ->where(function($query) use ($checkTimeStart, $checkTimeEnd) {
                $query->whereRaw('time_start < ? AND time_end > ?', [
                    $checkTimeEnd,
                    $checkTimeStart
                ]);
            })
            ->exists();

        if ($studentConflict) {
            $conflictingSchedule = Schedule::where('student_id', $checkStudentId)
                ->where('day_of_week', $checkDay)
                ->where('is_active', true)
                ->where('id', '!=', $schedule->id)
                ->where(function($query) use ($checkTimeStart, $checkTimeEnd) {
                    $query->whereRaw('time_start < ? AND time_end > ?', [
                        $checkTimeEnd,
                        $checkTimeStart
                    ]);
                })
                ->with('subject')
                ->first();

            $subjectName = $conflictingSchedule && $conflictingSchedule->subject 
                ? $conflictingSchedule->subject->name 
                : 'mata pelajaran lain';
            
            return response()->json([
                'success' => false,
                'message' => "Siswa sudah memiliki jadwal untuk {$subjectName} pada waktu yang sama. Silakan pilih waktu lain.",
            ], 422);
        }

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui',
            'data' => $schedule->load(['tutor', 'student', 'subject']),
        ]);
    }

    /**
     * Delete a schedule (tutor can only delete their own schedules)
     * DELETE /api/v1/tutor/schedules/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $schedule = Schedule::where('id', $id)
            ->where('tutor_id', $tutor->id)
            ->first();

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan atau Anda tidak memiliki akses',
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus',
        ]);
    }
}
