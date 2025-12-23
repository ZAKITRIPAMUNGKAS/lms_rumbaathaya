<?php

namespace App\Http\Controllers\Api;

use App\Models\Material;
use App\Models\Subject;
use App\Models\ClassLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TutorMaterialController extends BaseApiController
{
    /**
     * Get list of materials for the authenticated tutor
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'subject_id' => 'sometimes|exists:subjects,id',
            'class_level_id' => 'sometimes|exists:class_levels,id',
        ]);

        $query = Material::with(['subject', 'classLevel', 'uploader'])
            ->where('tutor_id', $tutor->id); // Strict filter: only tutor's own materials

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('class_level_id') && $request->class_level_id) {
            $query->where('class_level_id', $request->class_level_id);
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
     * Get a single material by ID (only if owned by tutor)
     */
    public function show(int $id): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $material = Material::with(['subject', 'classLevel', 'uploader'])
            ->where('tutor_id', $tutor->id)
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
     * Get options for material form (subjects, class levels)
     */
    public function options(): JsonResponse
    {
        $this->requireTutor();
        $subjects = Subject::select('id', 'name')->orderBy('name')->get();
        $classLevels = ClassLevel::select('id', 'name')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'subjects' => $subjects,
                'class_levels' => $classLevels,
            ],
        ]);
    }

    /**
     * Create a new material (automatically assigns tutor_id)
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_level_id' => 'required|exists:class_levels,id',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt|max:102400', // 100MB
            'tutor_id' => 'nullable|exists:users,id', // Accept but will be overridden for security
        ]);

        // Prepare material data (ignore tutor_id from request for security)
        $materialData = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'subject_id' => $validated['subject_id'],
            'class_level_id' => $validated['class_level_id'],
        ];
        
        // Automatically inject tutor_id and uploaded_by (override any value from frontend for security)
        $materialData['tutor_id'] = $tutor->id;
        // Fix: Use 'uploaded_by' not 'uploader_id' (matches database column name)
        $materialData['uploaded_by'] = $tutor->id;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('materials', 'public');
            $materialData['file_path'] = $path;
        }

        $material = Material::create($materialData);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil dibuat',
            'data' => $material->load(['subject', 'classLevel']),
        ], 201);
    }

    /**
     * Update a material (only if owned by tutor)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $material = Material::where('tutor_id', $tutor->id)->find($id);

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'class_level_id' => 'sometimes|required|exists:class_levels,id',
            'file' => 'sometimes|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt|max:102400', // 100MB
            'tutor_id' => 'nullable|exists:users,id', // Accept but ignore (will not update)
        ]);

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('materials', 'public');
            $validated['file_path'] = $path;
        }

        // Prepare update data (exclude tutor_id to prevent changing ownership)
        $updateData = $validated;
        unset($updateData['tutor_id']); // Never allow tutor_id to be changed
        
        $material->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil diperbarui',
            'data' => $material->load(['subject', 'classLevel']),
        ]);
    }

    /**
     * Delete a material (only if owned by tutor)
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireTutor();
        $tutor = $this->getAuthUser();

        $material = Material::where('tutor_id', $tutor->id)->find($id);

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ditemukan',
            ], 404);
        }

        // Delete file
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return response()->json([
            'success' => true,
            'message' => 'Materi berhasil dihapus',
        ]);
    }
}

