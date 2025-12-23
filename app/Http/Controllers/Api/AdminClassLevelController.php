<?php

namespace App\Http\Controllers\Api;

use App\Models\ClassLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminClassLevelController extends BaseApiController
{
    /**
     * Get list of class levels with pagination
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
        ]);

        $query = ClassLevel::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $classLevels = $query->orderBy('name')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $classLevels->items(),
            'meta' => [
                'current_page' => $classLevels->currentPage(),
                'per_page' => $classLevels->perPage(),
                'total' => $classLevels->total(),
                'last_page' => $classLevels->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single class level by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $classLevel = ClassLevel::find($id);

        if (!$classLevel) {
            return response()->json([
                'success' => false,
                'message' => 'Jenjang tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $classLevel,
        ]);
    }

    /**
     * Create a new class level
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:class_levels,name',
        ]);

        $classLevel = ClassLevel::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jenjang berhasil ditambahkan',
            'data' => $classLevel,
        ], 201);
    }

    /**
     * Update a class level
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $classLevel = ClassLevel::find($id);

        if (!$classLevel) {
            return response()->json([
                'success' => false,
                'message' => 'Jenjang tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:class_levels,name,' . $id,
        ]);

        $classLevel->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jenjang berhasil diperbarui',
            'data' => $classLevel->fresh(),
        ]);
    }

    /**
     * Delete a class level
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $classLevel = ClassLevel::find($id);

        if (!$classLevel) {
            return response()->json([
                'success' => false,
                'message' => 'Jenjang tidak ditemukan',
            ], 404);
        }

        // Check if class level is being used
        if ($classLevel->students()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jenjang tidak dapat dihapus karena masih digunakan oleh siswa',
            ], 422);
        }

        $classLevel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenjang berhasil dihapus',
        ]);
    }
}
