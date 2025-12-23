<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProgramController as BaseProgramController;
use Illuminate\Http\JsonResponse;

class ProgramController extends Controller
{
    /**
     * Get all programs
     */
    public function index(): JsonResponse
    {
        $programs = BaseProgramController::getAllPrograms();
        
        return response()->json([
            'success' => true,
            'data' => array_values($programs),
        ]);
    }

    /**
     * Get a specific program by slug
     */
    public function show(string $slug): JsonResponse
    {
        $programs = BaseProgramController::getAllPrograms();
        
        if (!isset($programs[$slug])) {
            return response()->json([
                'success' => false,
                'message' => 'Program tidak ditemukan',
            ], 404);
        }

        $program = $programs[$slug];
        
        // Get all programs for "Program Lainnya" sidebar
        $allPrograms = array_values($programs);
        
        return response()->json([
            'success' => true,
            'data' => $program,
            'allPrograms' => $allPrograms,
        ]);
    }
}
