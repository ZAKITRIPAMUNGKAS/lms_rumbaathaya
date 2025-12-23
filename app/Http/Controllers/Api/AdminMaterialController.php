<?php

namespace App\Http\Controllers\Api;

use App\Models\Material;
use App\Models\Subject;
use App\Models\ClassLevel;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminMaterialController extends BaseApiController
{
    /**
     * Get list of materials with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'subject_id' => 'sometimes|exists:subjects,id',
            'class_level_id' => 'sometimes|exists:class_levels,id',
        ]);

        $query = Material::with(['subject', 'classLevel', 'tutor', 'uploader']);

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
     * Get a single material by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $material = Material::with(['subject', 'classLevel', 'tutor', 'uploader'])->find($id);

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
     * Get options for material form (subjects, class levels, tutors)
     */
    public function options(): JsonResponse
    {
        $this->requireAdmin();
        $subjects = Subject::select('id', 'name')->orderBy('name')->get();
        $classLevels = ClassLevel::select('id', 'name')->orderBy('name')->get();
        $tutors = User::where('role', 'tutor')->select('id', 'name')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'subjects' => $subjects,
                'class_levels' => $classLevels,
                'tutors' => $tutors,
            ],
        ]);
    }

    /**
     * Create a new material
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_level_id' => 'required|exists:class_levels,id',
            'tutor_id' => 'nullable|exists:users,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'video_url' => 'nullable|url|max:255',
        ]);

        try {
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')
                    ->store('materials', 'public');
            }

            $material = Material::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'subject_id' => $validated['subject_id'],
                'class_level_id' => $validated['class_level_id'],
                'tutor_id' => !empty($validated['tutor_id']) ? $validated['tutor_id'] : null,
                'file_path' => $filePath,
                'video_url' => $validated['video_url'] ?? null,
                'uploaded_by' => Auth::id(),
            ]);

            $material->load(['subject', 'classLevel', 'tutor', 'uploader']);

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil ditambahkan',
                'data' => $material,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan materi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a material
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_level_id' => 'required|exists:class_levels,id',
            'tutor_id' => 'nullable|exists:users,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'video_url' => 'nullable|url|max:255',
        ]);

        try {
            $updateData = [
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'subject_id' => $validated['subject_id'],
                'class_level_id' => $validated['class_level_id'],
                'tutor_id' => $validated['tutor_id'] ?? null,
                'video_url' => $validated['video_url'] ?? null,
            ];

            if ($request->hasFile('file')) {
                if ($material->file_path) {
                    Storage::disk('public')->delete($material->file_path);
                }
                $updateData['file_path'] = $request->file('file')
                    ->store('materials', 'public');
            }

            $material->update($updateData);
            $material->load(['subject', 'classLevel', 'tutor', 'uploader']);

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil diperbarui',
                'data' => $material,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui materi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a material
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'success' => false,
                'message' => 'Materi tidak ditemukan',
            ], 404);
        }

        try {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $material->delete();

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus materi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
