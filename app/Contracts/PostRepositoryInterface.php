<?php

namespace App\Contracts;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    /**
     * Get all published posts with pagination.
     */
    public function getPublished(int $perPage = 15): LengthAwarePaginator;

    /**
     * Get latest published posts.
     */
    public function getLatest(int $limit = 10): Collection;

    /**
     * Find a post by ID.
     */
    public function findById(int $id): ?Post;

    /**
     * Find a post by slug.
     */
    public function findBySlug(string $slug): ?Post;

    /**
     * Create a new post.
     */
    public function create(array $data): Post;

    /**
     * Update a post.
     */
    public function update(Post $post, array $data): bool;

    /**
     * Delete a post.
     */
    public function delete(Post $post): bool;
}
