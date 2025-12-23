<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MaterialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct(
        private MaterialService $materialService
    ) {}

    /**
     * Get list of materials.
     */
    public function index(Request $request): JsonResponse
    {
        // Validate and sanitize input
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:50',
            'page' => 'sometimes|integer|min:1',
        ]);

        $perPage = min((int) ($validated['per_page'] ?? 15), 50);
        $materials = $this->materialService->getPaginated($perPage);

        return response()->json([
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
     * Get a single material by ID.
     */
    public function show(int $id): JsonResponse
    {
        // Validate ID
        if ($id <= 0) {
            return response()->json([
                'message' => 'Invalid material ID',
            ], 400);
        }

        $material = $this->materialService->getById($id);

        if (!$material) {
            return response()->json([
                'message' => 'Material not found',
            ], 404);
        }

        return response()->json([
            'data' => $material,
        ]);
    }
}
