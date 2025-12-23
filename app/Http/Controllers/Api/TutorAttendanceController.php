<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TutorAttendanceController extends BaseApiController
{
    /**
     * Create a new attendance record
     * 
     * POST /api/v1/tutor/attendances
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        // Validate request
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'topic_taught' => 'required|string|max:1000',
            'student_progress_note' => 'nullable|string|max:2000',
            'status' => ['required', Rule::in(['present', 'absent', 'permission', 'sick'])],
            'photo_evidence' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Security: Verify that the schedule belongs to the authenticated tutor
        $schedule = Schedule::find($validated['schedule_id']);
        if (!$schedule || $schedule->tutor_id !== $tutor->id) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan atau tidak memiliki akses',
            ], 403);
        }

        // Verify that the student_id matches the schedule's student
        if ($schedule->student_id != $validated['student_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak sesuai dengan jadwal yang dipilih',
            ], 422);
        }

        // Handle file upload if provided
        $photoEvidencePath = null;
        if ($request->hasFile('photo_evidence')) {
            $file = $request->file('photo_evidence');
            $photoEvidencePath = $file->store('attendances', 'public');
        }

        // Create attendance record
        $attendance = Attendance::create([
            'schedule_id' => $validated['schedule_id'],
            'tutor_id' => $tutor->id, // Auto-inject from authenticated user
            'student_id' => $validated['student_id'],
            'date' => $validated['date'],
            'topic_taught' => $validated['topic_taught'],
            'student_progress_note' => $validated['student_progress_note'] ?? null,
            'photo_evidence_path' => $photoEvidencePath,
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat',
            'data' => $attendance->load(['schedule', 'student']),
        ], 201);
    }
}

