<?php

namespace App\Repositories;

use App\Contracts\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Get all published posts with pagination.
     */
    public function getPublished(int $perPage = 15): LengthAwarePaginator
    {
        return Post::published()
            ->select('id', 'title', 'slug', 'category', 'content', 'thumbnail', 'published_at')
            ->latest('published_at')
            ->paginate($perPage);
    }

    /**
     * Get latest published posts.
     */
    public function getLatest(int $limit = 10): Collection
    {
        return Post::published()
            ->select('id', 'title', 'slug', 'category', 'content', 'thumbnail', 'published_at')
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Find a post by ID.
     */
    public function findById(int $id): ?Post
    {
        return Post::find($id);
    }

    /**
     * Find a post by slug.
     */
    public function findBySlug(string $slug): ?Post
    {
        return Post::where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }

    /**
     * Create a new post.
     */
    public function create(array $data): Post
    {
        return Post::create($data);
    }

    /**
     * Update a post.
     */
    public function update(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    /**
     * Delete a post.
     */
    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
