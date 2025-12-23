<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BimbelJournal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TutorJournalController extends BaseApiController
{
    /**
     * Get list of journals for the authenticated tutor
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireTutor();
        $tutorId = $this->getAuthUserId();

        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date',
        ]);

        $query = BimbelJournal::where('tutor_id', $tutorId)->with('tutor');

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('material', 'like', "%{$search}%");
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
     * Get a single journal (only if it belongs to the tutor)
     */
    public function show($id): JsonResponse
    {
        $this->requireTutor();
        $tutorId = $this->getAuthUserId();
        $journal = BimbelJournal::where('tutor_id', $tutorId)
            ->with('tutor')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $journal,
        ]);
    }

    /**
     * Create a new journal (automatically set tutor_id to authenticated user)
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireTutor();
        $tutorId = $this->getAuthUserId();

        $validated = $request->validate([
            'schedule_id' => 'nullable|exists:schedules,id',
            'date' => 'required|date|before_or_equal:today', // CRITICAL: Only past or today
            'time' => 'required|date_format:H:i',
            'material' => 'required|string|max:5000',
            'documentation' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240', // 10MB
        ], [
            'date.before_or_equal' => 'Jurnal hanya dapat dibuat untuk tanggal hari ini atau sebelumnya.',
            'schedule_id.exists' => 'Jadwal tidak ditemukan.',
        ]);

        // CRITICAL: If schedule_id provided, verify it belongs to this tutor and is completed
        if (isset($validated['schedule_id'])) {
            $schedule = \App\Models\Schedule::find($validated['schedule_id']);
            if (!$schedule || $schedule->tutor_id !== $tutorId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal tidak ditemukan atau tidak dimiliki oleh tutor ini.',
                ], 422);
            }
        }

        $data = [
            'tutor_id' => $tutorId, // Automatically set to authenticated tutor
            'schedule_id' => $validated['schedule_id'] ?? null,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'material' => $validated['material'],
        ];

        if ($request->hasFile('documentation')) {
            $file = $request->file('documentation');
            $path = $file->store('journals/documentation', 'public');
            $data['documentation_path'] = $path;
        }

        $journal = BimbelJournal::create($data);
        $journal->load('tutor');

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil ditambahkan',
            'data' => $journal,
        ], 201);
    }

    /**
     * Update a journal (only if it belongs to the tutor)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $this->requireTutor();
        $tutorId = $this->getAuthUserId();
        $journal = BimbelJournal::where('tutor_id', $tutorId)->findOrFail($id);

        $validated = $request->validate([
            'schedule_id' => 'nullable|exists:schedules,id',
            'date' => 'required|date|before_or_equal:today', // CRITICAL: Only past or today
            'time' => 'required|date_format:H:i',
            'material' => 'required|string|max:5000',
            'documentation' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240', // 10MB
        ], [
            'date.before_or_equal' => 'Jurnal hanya dapat dibuat untuk tanggal hari ini atau sebelumnya.',
            'schedule_id.exists' => 'Jadwal tidak ditemukan.',
        ]);

        // CRITICAL: If schedule_id provided, verify it belongs to this tutor
        if (isset($validated['schedule_id'])) {
            $schedule = \App\Models\Schedule::find($validated['schedule_id']);
            if (!$schedule || $schedule->tutor_id !== $tutorId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal tidak ditemukan atau tidak dimiliki oleh tutor ini.',
                ], 422);
            }
        }

        $data = [
            'schedule_id' => $validated['schedule_id'] ?? $journal->schedule_id,
            'date' => $validated['date'],
            'time' => $validated['time'],
            'material' => $validated['material'],
        ];

        if ($request->hasFile('documentation')) {
            // Delete old file if exists
            if ($journal->documentation_path) {
                Storage::disk('public')->delete($journal->documentation_path);
            }
            $file = $request->file('documentation');
            $path = $file->store('journals/documentation', 'public');
            $data['documentation_path'] = $path;
        }

        $journal->update($data);
        $journal->load('tutor');

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil diperbarui',
            'data' => $journal,
        ]);
    }

    /**
     * Delete a journal (only if it belongs to the tutor)
     */
    public function destroy($id): JsonResponse
    {
        $this->requireTutor();
        $tutorId = $this->getAuthUserId();
        $journal = BimbelJournal::where('tutor_id', $tutorId)->findOrFail($id);

        // Delete documentation file if exists
        if ($journal->documentation_path) {
            Storage::disk('public')->delete($journal->documentation_path);
        }

        $journal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil dihapus',
        ]);
    }
}
