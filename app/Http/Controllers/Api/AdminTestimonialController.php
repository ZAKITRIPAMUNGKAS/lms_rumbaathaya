<?php

namespace App\Http\Controllers\Api;

use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTestimonialController extends BaseApiController
{
    /**
     * Get list of testimonials with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'is_published' => 'sometimes|boolean',
        ]);

        $query = Testimonial::query();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('role', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('is_published')) {
            $query->where('is_published', $request->is_published);
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $testimonials = $query->orderBy('sort_order')->latest()->paginate($perPage);

        // Transform to include photo URL
        $transformedTestimonials = $testimonials->getCollection()->map(function ($testimonial) {
            return [
                'id' => $testimonial->id,
                'name' => $testimonial->name,
                'role' => $testimonial->role,
                'content' => $testimonial->content,
                'rating' => $testimonial->rating,
                'photo' => $testimonial->photo_url,
                'is_published' => $testimonial->is_published,
                'sort_order' => $testimonial->sort_order,
                'created_at' => $testimonial->created_at->toIso8601String(),
                'updated_at' => $testimonial->updated_at->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $transformedTestimonials->values(),
            'meta' => [
                'current_page' => $testimonials->currentPage(),
                'per_page' => $testimonials->perPage(),
                'total' => $testimonials->total(),
                'last_page' => $testimonials->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single testimonial by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $testimonial->id,
                'name' => $testimonial->name,
                'role' => $testimonial->role,
                'content' => $testimonial->content,
                'rating' => $testimonial->rating,
                'photo' => $testimonial->photo_url,
                'is_published' => $testimonial->is_published,
                'sort_order' => $testimonial->sort_order,
                'created_at' => $testimonial->created_at->toIso8601String(),
                'updated_at' => $testimonial->updated_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * Create a new testimonial
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')
                    ->store('testimonials', 'public');
            }

            $testimonial = Testimonial::create([
                'name' => $validated['name'],
                'role' => $validated['role'],
                'content' => $validated['content'],
                'rating' => $validated['rating'] ?? 5,
                'photo_path' => $photoPath,
                'is_published' => $validated['is_published'] ?? false,
                'sort_order' => $validated['sort_order'] ?? 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Testimoni berhasil ditambahkan',
                'data' => [
                    'id' => $testimonial->id,
                    'name' => $testimonial->name,
                    'role' => $testimonial->role,
                    'content' => $testimonial->content,
                    'rating' => $testimonial->rating,
                    'photo' => $testimonial->photo_url,
                    'is_published' => $testimonial->is_published,
                    'sort_order' => $testimonial->sort_order,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan testimoni: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a testimonial
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        try {
            $updateData = [
                'name' => $validated['name'],
                'role' => $validated['role'],
                'content' => $validated['content'],
                'rating' => $validated['rating'] ?? $testimonial->rating,
                'is_published' => $validated['is_published'] ?? $testimonial->is_published,
                'sort_order' => $validated['sort_order'] ?? $testimonial->sort_order,
            ];

            if ($request->hasFile('photo')) {
                if ($testimonial->photo_path) {
                    Storage::disk('public')->delete($testimonial->photo_path);
                }
                $updateData['photo_path'] = $request->file('photo')
                    ->store('testimonials', 'public');
            }

            $testimonial->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Testimoni berhasil diperbarui',
                'data' => [
                    'id' => $testimonial->id,
                    'name' => $testimonial->name,
                    'role' => $testimonial->role,
                    'content' => $testimonial->content,
                    'rating' => $testimonial->rating,
                    'photo' => $testimonial->photo_url,
                    'is_published' => $testimonial->is_published,
                    'sort_order' => $testimonial->sort_order,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui testimoni: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a testimonial
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'success' => false,
                'message' => 'Testimoni tidak ditemukan',
            ], 404);
        }

        try {
            if ($testimonial->photo_path) {
                Storage::disk('public')->delete($testimonial->photo_path);
            }

            $testimonial->delete();

            return response()->json([
                'success' => true,
                'message' => 'Testimoni berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus testimoni: ' . $e->getMessage(),
            ], 500);
        }
    }
}
