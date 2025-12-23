<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Documentation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'video_url',
        'thumbnail',
        'category',
        'event_date',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope untuk dokumentasi yang dipublikasikan
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope untuk foto saja
     */
    public function scopePhotos($query)
    {
        return $query->where('type', 'photo');
    }

    /**
     * Scope untuk video saja
     */
    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }

        return asset('storage/' . $this->file_path);
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->thumbnail) {
            return null;
        }

        if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
            return $this->thumbnail;
        }

        return asset('storage/' . $this->thumbnail);
    }

    /**
     * Get YouTube video ID from URL
     */
    public function getYoutubeIdAttribute(): ?string
    {
        if ($this->type !== 'video' || !$this->video_url) {
            return null;
        }

        // Extract YouTube video ID from various URL formats
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
        
        return $matches[1] ?? null;
    }
}
