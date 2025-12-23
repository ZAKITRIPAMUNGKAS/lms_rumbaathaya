<?php

namespace App\Http\Controllers\Api;

use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDocumentationController extends BaseApiController
{
    /**
     * Get list of documentation with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:photo,video',
            'category' => 'sometimes|string|max:255',
            'is_published' => 'sometimes|boolean',
        ]);

        $query = Documentation::query();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('is_published')) {
            $query->where('is_published', $request->is_published);
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $documentations = $query->orderBy('sort_order')->latest('event_date')->latest()->paginate($perPage);

        // Transform to include URLs
        $transformedDocs = $documentations->getCollection()->map(function ($doc) {
            return [
                'id' => $doc->id,
                'title' => $doc->title,
                'description' => $doc->description,
                'type' => $doc->type,
                'file_path' => $doc->file_url,
                'video_url' => $doc->video_url,
                'thumbnail' => $doc->thumbnail_url,
                'category' => $doc->category,
                'event_date' => $doc->event_date?->toIso8601String(),
                'is_published' => $doc->is_published,
                'sort_order' => $doc->sort_order,
                'created_at' => $doc->created_at->toIso8601String(),
                'updated_at' => $doc->updated_at->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $transformedDocs->values(),
            'meta' => [
                'current_page' => $documentations->currentPage(),
                'per_page' => $documentations->perPage(),
                'total' => $documentations->total(),
                'last_page' => $documentations->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single documentation by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $doc = Documentation::find($id);

        if (!$doc) {
            return response()->json([
                'success' => false,
                'message' => 'Dokumentasi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $doc->id,
                'title' => $doc->title,
                'description' => $doc->description,
                'type' => $doc->type,
                'file_path' => $doc->file_url,
                'video_url' => $doc->video_url,
                'thumbnail' => $doc->thumbnail_url,
                'category' => $doc->category,
                'event_date' => $doc->event_date?->toIso8601String(),
                'is_published' => $doc->is_published,
                'sort_order' => $doc->sort_order,
                'created_at' => $doc->created_at->toIso8601String(),
                'updated_at' => $doc->updated_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * Create a new documentation
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video',
            'file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,mp4,mov|max:102400', // 100MB
            'video_url' => 'nullable|url|max:255|required_if:type,video',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'category' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')
                    ->store('documentations', 'public');
            }

            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')
                    ->store('documentations/thumbnails', 'public');
            }

            $doc = Documentation::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'type' => $validated['type'],
                'file_path' => $filePath,
                'video_url' => $validated['video_url'] ?? null,
                'thumbnail' => $thumbnailPath,
                'category' => $validated['category'] ?? null,
                'event_date' => $validated['event_date'] ?? null,
                'is_published' => $validated['is_published'] ?? false,
                'sort_order' => $validated['sort_order'] ?? 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumentasi berhasil ditambahkan',
                'data' => [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'description' => $doc->description,
                    'type' => $doc->type,
                    'file_path' => $doc->file_url,
                    'video_url' => $doc->video_url,
                    'thumbnail' => $doc->thumbnail_url,
                    'category' => $doc->category,
                    'event_date' => $doc->event_date?->toIso8601String(),
                    'is_published' => $doc->is_published,
                    'sort_order' => $doc->sort_order,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan dokumentasi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a documentation
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $doc = Documentation::find($id);

        if (!$doc) {
            return response()->json([
                'success' => false,
                'message' => 'Dokumentasi tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:photo,video',
            'file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,mp4,mov|max:102400', // 100MB
            'video_url' => 'nullable|url|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'category' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            $updateData = [
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'type' => $validated['type'],
                'video_url' => $validated['video_url'] ?? null,
                'category' => $validated['category'] ?? null,
                'event_date' => $validated['event_date'] ?? null,
                'is_published' => $validated['is_published'] ?? $doc->is_published,
                'sort_order' => $validated['sort_order'] ?? $doc->sort_order,
            ];

            if ($request->hasFile('file')) {
                if ($doc->file_path) {
                    Storage::disk('public')->delete($doc->file_path);
                }
                $updateData['file_path'] = $request->file('file')
                    ->store('documentations', 'public');
            }

            if ($request->hasFile('thumbnail')) {
                if ($doc->thumbnail) {
                    Storage::disk('public')->delete($doc->thumbnail);
                }
                $updateData['thumbnail'] = $request->file('thumbnail')
                    ->store('documentations/thumbnails', 'public');
            }

            $doc->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Dokumentasi berhasil diperbarui',
                'data' => [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'description' => $doc->description,
                    'type' => $doc->type,
                    'file_path' => $doc->file_url,
                    'video_url' => $doc->video_url,
                    'thumbnail' => $doc->thumbnail_url,
                    'category' => $doc->category,
                    'event_date' => $doc->event_date?->toIso8601String(),
                    'is_published' => $doc->is_published,
                    'sort_order' => $doc->sort_order,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui dokumentasi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a documentation
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $doc = Documentation::find($id);

        if (!$doc) {
            return response()->json([
                'success' => false,
                'message' => 'Dokumentasi tidak ditemukan',
            ], 404);
        }

        try {
            if ($doc->file_path) {
                Storage::disk('public')->delete($doc->file_path);
            }
            if ($doc->thumbnail) {
                Storage::disk('public')->delete($doc->thumbnail);
            }

            $doc->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dokumentasi berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus dokumentasi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
