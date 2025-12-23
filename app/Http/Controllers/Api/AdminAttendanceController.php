<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAttendanceController extends BaseApiController
{
    /**
     * Get list of all attendances (Admin)
     * GET /api/v1/admin/attendances
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'student_id' => 'sometimes|exists:students,id',
            'tutor_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|in:present,absent,permission,sick',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date|after_or_equal:date_from',
            'class_level_id' => 'sometimes|exists:class_levels,id',
        ]);

        $query = Attendance::with([
            'student:id,name,class_level_id',
            'student.classLevel:id,name',
            'schedule:id,subject_id',
            'schedule.subject:id,name',
            'tutor:id,name',
        ]);

        // Apply filters
        if ($request->has('search') && $request->search) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('student_id')) {
            $query->where('student_id', $validated['student_id']);
        }

        if ($request->has('tutor_id')) {
            $query->where('tutor_id', $validated['tutor_id']);
        }

        if ($request->has('status')) {
            $query->where('status', $validated['status']);
        }

        if ($request->has('date_from')) {
            $query->whereDate('date', '>=', $validated['date_from']);
        }

        if ($request->has('date_to')) {
            $query->whereDate('date', '<=', $validated['date_to']);
        }

        if ($request->has('class_level_id')) {
            $query->whereHas('student', function ($q) use ($validated) {
                $q->where('class_level_id', $validated['class_level_id']);
            });
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
     * Get single attendance details (Admin)
     * GET /api/v1/admin/attendances/{id}
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();

        $attendance = Attendance::with([
            'student:id,name,class_level_id',
            'student.classLevel:id,name',
            'schedule:id,subject_id',
            'schedule.subject:id,name',
            'tutor:id,name',
        ])->find($id);

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

