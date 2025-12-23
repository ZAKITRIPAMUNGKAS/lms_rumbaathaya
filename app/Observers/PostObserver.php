<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->invalidateCache($post);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->invalidateCache($post);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        $this->invalidateCache($post);
    }

    /**
     * Invalidate all post-related cache.
     */
    protected function invalidateCache(Post $post): void
    {
        // Invalidate home posts cache
        Cache::forget('home_posts');
        
        // Invalidate latest posts cache
        Cache::forget('posts_latest_10');
        Cache::forget('posts_latest_3');
        
        // Invalidate specific post cache
        if ($post->slug) {
            Cache::forget("post_slug_{$post->slug}");
        }
        
        // Invalidate paginated API cache (first 5 pages)
        for ($page = 1; $page <= 5; $page++) {
            Cache::forget("posts_published_page_{$page}_per_page_15");
            Cache::forget("posts_published_page_{$page}_per_page_50");
        }
    }
}

