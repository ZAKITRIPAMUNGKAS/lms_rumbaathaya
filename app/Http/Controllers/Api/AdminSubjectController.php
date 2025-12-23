<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSubjectController extends BaseApiController
{
    /**
     * Get list of subjects with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
        ]);

        $query = Subject::query();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $subjects = $query->orderBy('name')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $subjects->items(),
            'meta' => [
                'current_page' => $subjects->currentPage(),
                'per_page' => $subjects->perPage(),
                'total' => $subjects->total(),
                'last_page' => $subjects->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single subject by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subject,
        ]);
    }

    /**
     * Create a new subject
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:subjects,slug',
        ]);

        // Auto-generate slug if not provided
        if (!isset($validated['slug']) || empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Subject::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $subject = Subject::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil ditambahkan',
            'data' => $subject,
        ], 201);
    }

    /**
     * Update a subject
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:subjects,slug,' . $id,
        ]);

        // Auto-generate slug if name changed but slug not provided
        if (isset($validated['name']) && !isset($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Subject::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $subject->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil diperbarui',
            'data' => $subject->fresh(),
        ]);
    }

    /**
     * Delete a subject
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $subject = Subject::find($id);

        if (!$subject) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak ditemukan',
            ], 404);
        }

        // Check if subject is being used
        if ($subject->materials()->count() > 0 || $subject->schedules()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak dapat dihapus karena masih digunakan',
            ], 422);
        }

        $subject->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dihapus',
        ]);
    }
}
