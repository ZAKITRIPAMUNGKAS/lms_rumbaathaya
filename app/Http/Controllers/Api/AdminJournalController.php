<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BimbelJournal;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminJournalController extends BaseApiController
{
    /**
     * Get list of journals with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'tutor_id' => 'sometimes|exists:users,id',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date',
        ]);

        $query = BimbelJournal::with('tutor');

        if ($request->has('tutor_id') && $request->tutor_id) {
            $query->where('tutor_id', $request->tutor_id);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('material', 'like', "%{$search}%")
                    ->orWhereHas('tutor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $perPage = $request->get('per_page', 25);
        $journals = $query->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $journals->items(),
            'meta' => [
                'current_page' => $journals->currentPage(),
                'last_page' => $journals->lastPage(),
                'per_page' => $journals->perPage(),
                'total' => $journals->total(),
            ],
        ]);
    }

    /**
     * Get options for dropdowns
     */
    public function options(): JsonResponse
    {
        $this->requireAdmin();
        $tutors = User::where('role', 'tutor')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'tutors' => $tutors,
            ],
        ]);
    }

    /**
     * Get a single journal
     */
    public function show($id): JsonResponse
    {
        $this->requireAdmin();
        $journal = BimbelJournal::with('tutor')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $journal,
        ]);
    }

    // Admin can only view journals, not create/update/delete
    // Tutors manage their own journals through TutorJournalController
}
