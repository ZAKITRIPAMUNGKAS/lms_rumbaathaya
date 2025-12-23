<?php

namespace App\Services;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PostService
{
    public function __construct(
        private PostRepositoryInterface $repository
    ) {}

    /**
     * Get all published posts with caching.
     */
    public function getPublished(int $perPage = 15): LengthAwarePaginator
    {
        $page = (int) request()->get('page', 1);
        $cacheKey = "posts_published_page_{$page}_per_page_{$perPage}";
        
        try {
            return Cache::remember($cacheKey, 3600, function () use ($perPage) {
                return $this->repository->getPublished($perPage);
            });
        } catch (\Exception $e) {
            // If cache fails, return directly from repository
            \Log::warning('Cache failed for posts, using direct query: ' . $e->getMessage());
            return $this->repository->getPublished($perPage);
        }
    }

    /**
     * Get latest published posts with caching.
     */
    public function getLatest(int $limit = 10): Collection
    {
        $cacheKey = "posts_latest_{$limit}";
        
        try {
            return Cache::remember($cacheKey, 3600, function () use ($limit) {
                return $this->repository->getLatest($limit);
            });
        } catch (\Exception $e) {
            // If cache fails, return directly from repository
            \Log::warning('Cache failed for latest posts, using direct query: ' . $e->getMessage());
            return $this->repository->getLatest($limit);
        }
    }

    /**
     * Get a post by slug with caching.
     */
    public function getBySlug(string $slug): ?Post
    {
        $cacheKey = "post_slug_{$slug}";
        
        try {
            return Cache::remember($cacheKey, 3600, function () use ($slug) {
                return $this->repository->findBySlug($slug);
            });
        } catch (\Exception $e) {
            // If cache fails, return directly from repository
            \Log::warning('Cache failed for post by slug, using direct query: ' . $e->getMessage());
            return $this->repository->findBySlug($slug);
        }
    }

    /**
     * Get a post by ID.
     */
    public function getById(int $id): ?Post
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new post and invalidate cache.
     */
    public function create(array $data): Post
    {
        $post = $this->repository->create($data);
        $this->invalidateCache();
        
        return $post;
    }

    /**
     * Update a post and invalidate cache.
     */
    public function update(Post $post, array $data): bool
    {
        $result = $this->repository->update($post, $data);
        $this->invalidateCache();
        $this->invalidatePostCache($post);
        
        return $result;
    }

    /**
     * Delete a post and invalidate cache.
     */
    public function delete(Post $post): bool
    {
        $slug = $post->slug;
        $result = $this->repository->delete($post);
        $this->invalidateCache();
        Cache::forget("post_slug_{$slug}");
        
        return $result;
    }

    /**
     * Invalidate all post-related cache.
     */
    protected function invalidateCache(): void
    {
        // Invalidate home posts cache (handled by observer, but also clear here for safety)
        Cache::forget('home_posts');
        
        // Clear paginated cache (we'll clear first few pages)
        for ($page = 1; $page <= 5; $page++) {
            Cache::forget("posts_published_page_{$page}_per_page_15");
        }
        
        // Clear latest posts cache
        Cache::forget('posts_latest_10');
        Cache::forget('posts_latest_3');
    }

    /**
     * Invalidate cache for a specific post.
     */
    protected function invalidatePostCache(Post $post): void
    {
        if ($post->slug) {
            Cache::forget("post_slug_{$post->slug}");
        }
    }
}
