<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'thumbnail',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the thumbnail URL attribute.
     * This ensures thumbnail URLs are always properly formatted.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        // Get the raw thumbnail value from attributes
        $thumbnail = $this->getAttribute('thumbnail');

        if (!$thumbnail) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($thumbnail, FILTER_VALIDATE_URL)) {
            return $thumbnail;
        }

        // Filament stores path as 'posts/thumbnails/filename.png'
        // We need to prepend 'uploads/' to make it accessible via public/uploads
        return asset('uploads/' . $thumbnail);
    }
}
