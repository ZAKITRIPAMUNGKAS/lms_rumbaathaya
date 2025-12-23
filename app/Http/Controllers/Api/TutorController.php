<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TutorController extends Controller
{
    /**
     * Get list of tutors.
     */
    public function index(Request $request): JsonResponse
    {
        // Validate and sanitize input
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:50',
            'page' => 'sometimes|integer|min:1',
        ]);

        $perPage = min((int) ($validated['per_page'] ?? 15), 50);
        $page = max((int) ($validated['page'] ?? 1), 1);
        
        $cacheKey = "api_tutors_page_{$page}_per_page_{$perPage}";
        
        $tutors = Cache::remember($cacheKey, 3600, function () use ($perPage) {
            return User::where('role', 'tutor')
                ->select('id', 'name', 'email', 'avatar_url', 'bio')
                ->paginate($perPage);
        });

        return response()->json([
            'data' => $tutors->items(),
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
                'last_page' => $tutors->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single tutor by ID.
     */
    public function show(int $id): JsonResponse
    {
        // Validate ID
        if ($id <= 0) {
            return response()->json([
                'message' => 'Invalid tutor ID',
            ], 400);
        }

        $cacheKey = "api_tutor_{$id}";
        
        $tutor = Cache::remember($cacheKey, 3600, function () use ($id) {
            return User::where('role', 'tutor')
                ->where('id', $id)
                ->select('id', 'name', 'email', 'avatar_url', 'bio')
                ->first();
        });

        if (!$tutor) {
            return response()->json([
                'message' => 'Tutor not found',
            ], 404);
        }

        return response()->json([
            'data' => $tutor,
        ]);
    }
}
