<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SahabatRAController extends Controller
{
    public function __construct(
        private PostService $postService
    ) {}

    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 12;
        
        // Cache paginated posts for 1 hour
        $cacheKey = "sahabat_ra_posts_page_{$page}";
        
        $posts = Cache::remember($cacheKey, 3600, function () use ($perPage) {
            return $this->postService->getPublished($perPage);
        });

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl . '/sahabat-ra');
    }

    public function show($slug)
    {
        // Get post using service layer (already cached)
        $post = $this->postService->getBySlug($slug);

        if (!$post) {
            abort(404);
        }

        // Cache related posts for 1 hour
        $cacheKey = "related_posts_{$post->id}_{$post->category}";
        
        $relatedPosts = Cache::remember($cacheKey, 3600, function () use ($post) {
            return $this->postService->getPublished(3)
                ->where('id', '!=', $post->id)
                ->where('category', $post->category)
                ->take(3);
        });

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl . '/sahabat-ra/' . $slug);
    }
}

