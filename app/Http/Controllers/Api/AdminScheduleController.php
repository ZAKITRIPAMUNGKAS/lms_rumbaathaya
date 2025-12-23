<?php

namespace App\Http\Controllers\Api;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminScheduleController extends BaseApiController
{
    /**
     * Get list of schedules with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'tutor_id' => 'sometimes|exists:users,id',
            'student_id' => 'sometimes|exists:students,id',
            'subject_id' => 'sometimes|exists:subjects,id',
            'day_of_week' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $query = Schedule::with(['tutor', 'student', 'subject']);

        if ($request->has('tutor_id') && $request->tutor_id) {
            $query->where('tutor_id', $request->tutor_id);
        }

        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('day_of_week') && $request->day_of_week) {
            $query->where('day_of_week', $request->day_of_week);
        }

        if ($request->has('is_active') && $request->is_active !== null) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('tutor', function($tutorQuery) use ($request) {
                    $tutorQuery->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('student', function($studentQuery) use ($request) {
                    $studentQuery->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('subject', function($subjectQuery) use ($request) {
                    $subjectQuery->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $schedules = $query->orderBy('day_of_week')->orderBy('time_start')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $schedules->items(),
            'meta' => [
                'current_page' => $schedules->currentPage(),
                'per_page' => $schedules->perPage(),
                'total' => $schedules->total(),
                'last_page' => $schedules->lastPage(),
            ],
        ]);
    }

    /**
     * Get options for schedules (tutors, students, subjects)
     */
    public function options(): JsonResponse
    {
        $this->requireAdmin();
        $tutors = User::where('role', 'tutor')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $students = Student::select('id', 'name')
            ->orderBy('name')
            ->get();

        $subjects = Subject::select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'tutors' => $tutors,
                'students' => $students,
                'subjects' => $subjects,
            ],
        ]);
    }

    /**
     * Get a single schedule by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $schedule = Schedule::with(['tutor', 'student', 'subject'])->find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $schedule,
        ]);
    }

    /**
     * Create a new schedule
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'is_active' => 'sometimes|boolean',
        ]);

        // Verify tutor role
        $tutor = User::find($validated['tutor_id']);
        if (!$tutor || $tutor->role !== 'tutor') {
            return response()->json([
                'success' => false,
                'message' => 'User yang dipilih bukan tutor',
            ], 422);
        }

        // CRITICAL: Check for tutor scheduling conflicts using proper overlapping time logic
        // Two time ranges overlap if: start1 < end2 && start2 < end1
        $tutorConflict = Schedule::where('tutor_id', $validated['tutor_id'])
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
            // Get conflicting schedule details for better error message
            $conflictingSchedule = Schedule::where('tutor_id', $validated['tutor_id'])
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
                'message' => "Tutor sudah memiliki jadwal untuk {$subjectName} pada waktu yang sama. Silakan pilih waktu lain.",
            ], 422);
        }

        // CRITICAL: Check for student scheduling conflicts using proper overlapping time logic
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
            // Get conflicting schedule details for better error message
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
     * Update a schedule
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'tutor_id' => 'sometimes|exists:users,id',
            'student_id' => 'sometimes|exists:students,id',
            'subject_id' => 'sometimes|exists:subjects,id',
            'day_of_week' => 'sometimes|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_start' => 'sometimes|date_format:H:i',
            'time_end' => 'sometimes|date_format:H:i',
            'is_active' => 'sometimes|boolean',
        ]);

        // Validate time_end is after time_start if both are provided
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

        // Verify tutor role if tutor_id is being updated
        if (isset($validated['tutor_id'])) {
            $tutor = User::find($validated['tutor_id']);
            if (!$tutor || $tutor->role !== 'tutor') {
                return response()->json([
                    'success' => false,
                    'message' => 'User yang dipilih bukan tutor',
                ], 422);
            }
        }

        // Prepare conflict check data (use existing or new values)
        $checkTutorId = $validated['tutor_id'] ?? $schedule->tutor_id;
        $checkStudentId = $validated['student_id'] ?? $schedule->student_id;
        $checkDay = $validated['day_of_week'] ?? $schedule->day_of_week;
        $checkTimeStart = $validated['time_start'] ?? $schedule->time_start;
        $checkTimeEnd = $validated['time_end'] ?? $schedule->time_end;

        // CRITICAL: Check for tutor scheduling conflicts (exclude current schedule) using proper overlapping time logic
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
            // Get conflicting schedule details for better error message
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
                'message' => "Tutor sudah memiliki jadwal untuk {$subjectName} pada waktu yang sama. Silakan pilih waktu lain.",
            ], 422);
        }

        // CRITICAL: Check for student scheduling conflicts (exclude current schedule) using proper overlapping time logic
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
            // Get conflicting schedule details for better error message
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
            'data' => $schedule->fresh()->load(['tutor', 'student', 'subject']),
        ]);
    }

    /**
     * Delete a schedule
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan',
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus',
        ]);
    }
}
