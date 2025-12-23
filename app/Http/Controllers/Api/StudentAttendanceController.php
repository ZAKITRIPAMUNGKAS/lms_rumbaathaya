<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentAttendanceController extends BaseApiController
{
    /**
     * Get attendance history for authenticated student
     * GET /api/v1/student/attendances
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireStudent();
        $user = $this->getAuthUser();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Profil siswa tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:present,absent,permission,sick',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date|after_or_equal:date_from',
        ]);

        $query = Attendance::where('student_id', $student->id)
            ->with([
                'schedule:id,subject_id',
                'schedule.subject:id,name',
                'tutor:id,name',
            ]);

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $validated['status']);
        }

        if ($request->has('date_from')) {
            $query->whereDate('date', '>=', $validated['date_from']);
        }

        if ($request->has('date_to')) {
            $query->whereDate('date', '<=', $validated['date_to']);
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $attendances = $query->latest('date')->paginate($perPage);

        // Transform data to include proof_file_url
        $attendances->getCollection()->transform(function ($attendance) {
            $attendance->proof_file_url = $attendance->photo_evidence_path
                ? Storage::url($attendance->photo_evidence_path)
                : null;
            return $attendance;
        });

        return response()->json([
            'success' => true,
            'data' => $attendances->items(),
            'meta' => [
                'current_page' => $attendances->currentPage(),
                'per_page' => $attendances->perPage(),
                'total' => $attendances->total(),
                'last_page' => $attendances->lastPage(),
            ],
        ]);
    }

    /**
     * Get single attendance details (Student)
     * GET /api/v1/student/attendances/{id}
     */
    public function show(int $id): JsonResponse
    {
        $this->requireStudent();
        $user = $this->getAuthUser();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Profil siswa tidak ditemukan',
            ], 404);
        }

        $attendance = Attendance::where('student_id', $student->id)
            ->with([
                'schedule:id,subject_id',
                'schedule.subject:id,name',
                'tutor:id,name',
            ])
            ->find($id);

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi tidak ditemukan',
            ], 404);
        }

        // Add proof_file_url
        $attendance->proof_file_url = $attendance->photo_evidence_path
            ? Storage::url($attendance->photo_evidence_path)
            : null;

        return response()->json([
            'success' => true,
            'data' => $attendance,
        ]);
    }
}

