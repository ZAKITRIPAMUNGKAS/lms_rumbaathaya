<?php

namespace App\Http\Controllers\Api;

use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentMaterialController extends BaseApiController
{
    /**
     * Get list of materials available for the authenticated student
     * Only shows materials matching student's class_level_id
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
            'search' => 'sometimes|string|max:255',
            'subject_id' => 'sometimes|exists:subjects,id',
        ]);

        $query = Material::with(['subject', 'classLevel', 'tutor'])
            ->where('class_level_id', $student->class_level_id); // Strict filter: only student's class level

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $materials = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $materials->items(),
            'meta' => [
                'current_page' => $materials->currentPage(),
                'per_page' => $materials->perPage(),
                'total' => $materials->total(),
                'last_page' => $materials->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single material by ID (only if available for student's class level)
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

        $material = Material::with(['subject', 'classLevel', 'tutor'])
            ->where('class_level_id', $student->class_level_id)
            ->find($id);

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $material,
        ]);
    }

    /**
     * Download material file
     */
    public function download(int $id): JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
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

        $material = Material::where('class_level_id', $student->class_level_id)->find($id);

        if (!$material || !$material->file_path) {
            return response()->json([
                'success' => false,
                'message' => 'File materi tidak ditemukan',
            ], 404);
        }

        $filePath = storage_path('app/public/' . $material->file_path);

        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan di server',
            ], 404);
        }

        return response()->download($filePath, $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION));
    }
}

