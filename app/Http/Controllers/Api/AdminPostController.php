<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPostController extends BaseApiController
{
    /**
     * Get list of posts with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'is_published' => 'sometimes|boolean',
        ]);

        $query = Post::query();

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('is_published')) {
            $query->where('is_published', $request->is_published);
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $posts = $query->latest('published_at')->latest()->paginate($perPage);

        // Transform posts to include thumbnail URL
        $transformedPosts = $posts->getCollection()->map(function ($post) {
            $thumbnail = null;
            if ($post->thumbnail) {
                if (filter_var($post->thumbnail, FILTER_VALIDATE_URL)) {
                    $thumbnail = $post->thumbnail;
                } else {
                    $thumbnail = asset('storage/' . $post->thumbnail);
                }
            }

            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'category' => $post->category,
                'content' => $post->content,
                'thumbnail' => $thumbnail,
                'is_published' => $post->is_published,
                'published_at' => $post->published_at?->toIso8601String(),
                'created_at' => $post->created_at->toIso8601String(),
                'updated_at' => $post->updated_at->toIso8601String(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $transformedPosts->values(),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'last_page' => $posts->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single post by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $thumbnail = null;
        if ($post->thumbnail) {
            if (filter_var($post->thumbnail, FILTER_VALIDATE_URL)) {
                $thumbnail = $post->thumbnail;
            } else {
                $thumbnail = asset('storage/' . $post->thumbnail);
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'category' => $post->category,
                'content' => $post->content,
                'thumbnail' => $thumbnail,
                'is_published' => $post->is_published,
                'published_at' => $post->published_at?->toIso8601String(),
                'created_at' => $post->created_at->toIso8601String(),
                'updated_at' => $post->updated_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * Create a new post
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:20480',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        try {
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')
                    ->store('posts/thumbnails', 'public');
            }

            $post = Post::create([
                'title' => $validated['title'],
                'slug' => $validated['slug'] ?? Str::slug($validated['title']),
                'category' => $validated['category'],
                'content' => $validated['content'],
                'thumbnail' => $thumbnailPath,
                'is_published' => $validated['is_published'] ?? false,
                'published_at' => $validated['published_at'] ?? ($validated['is_published'] ? now() : null),
            ]);

            $thumbnail = null;
            if ($post->thumbnail) {
                $thumbnail = asset('storage/' . $post->thumbnail);
            }

            return response()->json([
                'success' => true,
                'message' => 'Post berhasil ditambahkan',
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'category' => $post->category,
                    'content' => $post->content,
                    'thumbnail' => $thumbnail,
                    'is_published' => $post->is_published,
                    'published_at' => $post->published_at?->toIso8601String(),
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan post: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a post
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', \Illuminate\Validation\Rule::unique('posts')->ignore($id)],
            'category' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:20480',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        try {
            $updateData = [
                'title' => $validated['title'],
                'category' => $validated['category'],
                'content' => $validated['content'],
                'is_published' => $validated['is_published'] ?? $post->is_published,
                'published_at' => $validated['published_at'] ?? $post->published_at,
            ];

            if ($request->filled('slug')) {
                $updateData['slug'] = $validated['slug'];
            } elseif ($request->filled('title') && $post->title !== $validated['title']) {
                $updateData['slug'] = Str::slug($validated['title']);
            }

            if ($request->hasFile('thumbnail')) {
                if ($post->thumbnail) {
                    Storage::disk('public')->delete($post->thumbnail);
                }
                $updateData['thumbnail'] = $request->file('thumbnail')
                    ->store('posts/thumbnails', 'public');
            }

            $post->update($updateData);

            $thumbnail = null;
            if ($post->thumbnail) {
                $thumbnail = asset('storage/' . $post->thumbnail);
            }

            return response()->json([
                'success' => true,
                'message' => 'Post berhasil diperbarui',
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'category' => $post->category,
                    'content' => $post->content,
                    'thumbnail' => $thumbnail,
                    'is_published' => $post->is_published,
                    'published_at' => $post->published_at?->toIso8601String(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui post: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a post
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        try {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }

            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus post: ' . $e->getMessage(),
            ], 500);
        }
    }
}
