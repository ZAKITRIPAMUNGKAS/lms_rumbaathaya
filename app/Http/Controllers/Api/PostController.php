<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService
    ) {}

    /**
     * Get paginated list of published posts.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Validate and sanitize input
            $validated = $request->validate([
                'per_page' => 'sometimes|integer|min:1|max:50',
                'page' => 'sometimes|integer|min:1',
            ]);

            $perPage = min((int) ($validated['per_page'] ?? 15), 50);
            $page = max((int) ($validated['page'] ?? 1), 1);
            
            // Temporarily set page in request for service layer
            $request->merge(['page' => $page]);
            
            $posts = $this->postService->getPublished($perPage);

            // Transform posts to include thumbnail_url
            // Build full URL manually to avoid accessor issues with select()
            // Note: items() returns array, so we need to convert to collection first
            $transformedPosts = collect($posts->items())->map(function ($post) {
                try {
                    $thumbnail = null;
                    if ($post->thumbnail) {
                        // Build full URL manually
                        if (filter_var($post->thumbnail, FILTER_VALIDATE_URL)) {
                            $thumbnail = $post->thumbnail;
                        } else {
                            $thumbnail = asset('storage/' . $post->thumbnail);
                            // Normalize URL: replace 127.0.0.1 with localhost for consistency
                            $thumbnail = str_replace('http://127.0.0.1:', 'http://localhost:', $thumbnail);
                            
                            // Debug logging in development
                            if (config('app.debug')) {
                                \Log::debug('PostController - Thumbnail URL generated', [
                                    'post_id' => $post->id,
                                    'post_title' => $post->title ?? 'N/A',
                                    'raw_thumbnail' => $post->thumbnail,
                                    'generated_url' => $thumbnail,
                                ]);
                            }
                        }
                    }
                    
                    $publishedAt = null;
                    if ($post->published_at) {
                        try {
                            // Try toIso8601String first (Laravel 10+)
                            if (method_exists($post->published_at, 'toIso8601String')) {
                                $publishedAt = $post->published_at->toIso8601String();
                            } else {
                                // Fallback to toDateTimeString or format
                                $publishedAt = $post->published_at->toDateTimeString();
                            }
                        } catch (\Exception $e) {
                            \Log::warning('Error formatting published_at: ' . $e->getMessage());
                            $publishedAt = $post->published_at->toDateTimeString();
                        }
                    }
                    
                    return [
                        'id' => $post->id,
                        'title' => $post->title ?? '',
                        'slug' => $post->slug ?? '',
                        'category' => $post->category ?? '',
                        'content' => $post->content ?? '',
                        'thumbnail' => $thumbnail,
                        'published_at' => $publishedAt,
                    ];
                } catch (\Exception $e) {
                    \Log::error('Error transforming post: ' . $e->getMessage(), [
                        'post_id' => $post->id ?? null,
                    ]);
                    return null;
                }
            })->filter()->values(); // Remove null values and reindex

            return response()->json([
                'data' => $transformedPosts,
                'meta' => [
                    'current_page' => $posts->currentPage(),
                    'per_page' => $posts->perPage(),
                    'total' => $posts->total(),
                    'last_page' => $posts->lastPage(),
                ],
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('API PostController index database error: ' . $e->getMessage(), [
                'sql' => $e->getSql() ?? null,
                'bindings' => $e->getBindings() ?? null,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return response()->json([
                'message' => 'Database error while fetching posts',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        } catch (\Exception $e) {
            \Log::error('API PostController index error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => get_class($e),
            ]);
            return response()->json([
                'message' => 'Failed to fetch posts',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                'type' => config('app.debug') ? get_class($e) : null,
            ], 500);
        }
    }

    /**
     * Get a single post by slug.
     */
    public function show(string $slug): JsonResponse
    {
        try {
            // Validate slug format
            if (empty($slug) || strlen($slug) > 255) {
                return response()->json([
                    'message' => 'Invalid slug format',
                ], 400);
            }

            $post = $this->postService->getBySlug($slug);

            if (!$post) {
                return response()->json([
                    'message' => 'Post not found',
                ], 404);
            }

            // Build thumbnail URL manually
            $thumbnail = null;
            if ($post->thumbnail) {
                if (filter_var($post->thumbnail, FILTER_VALIDATE_URL)) {
                    $thumbnail = $post->thumbnail;
                } else {
                    $thumbnail = asset('storage/' . $post->thumbnail);
                    // Normalize URL: replace 127.0.0.1 with localhost for consistency
                    $thumbnail = str_replace('http://127.0.0.1:', 'http://localhost:', $thumbnail);
                }
            }

            $publishedAt = null;
            if ($post->published_at) {
                try {
                    // Try toIso8601String first (Laravel 10+)
                    if (method_exists($post->published_at, 'toIso8601String')) {
                        $publishedAt = $post->published_at->toIso8601String();
                    } else {
                        // Fallback to toDateTimeString or format
                        $publishedAt = $post->published_at->toDateTimeString();
                    }
                } catch (\Exception $e) {
                    \Log::warning('Error formatting published_at: ' . $e->getMessage());
                    $publishedAt = $post->published_at->toDateTimeString();
                }
            }

            return response()->json([
                'data' => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'category' => $post->category,
                    'content' => $post->content,
                    'thumbnail' => $thumbnail,
                    'published_at' => $publishedAt,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('API PostController show error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to fetch post',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error',
            ], 500);
        }
    }
}
