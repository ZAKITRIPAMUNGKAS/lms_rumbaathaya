<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name',
        'role',
        'content',
        'rating',
        'photo_path',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope untuk testimoni yang dipublikasikan
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the photo URL
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_path) {
            return null;
        }

        if (filter_var($this->photo_path, FILTER_VALIDATE_URL)) {
            return $this->photo_path;
        }

        return asset('storage/' . $this->photo_path);
    }
}
