<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'nickname',
        'place_of_birth',
        'date_of_birth',
        'address',
        'program_interest',
        'profile_photo_path',
        'parent_phone',
        'whatsapp_number',
        'school_origin',
        'class_level_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user account associated with the student.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the class level of the student.
     */
    public function classLevel(): BelongsTo
    {
        return $this->belongsTo(ClassLevel::class);
    }

    /**
     * Get the schedules for this student.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the attendances for this student.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the student reports for this student.
     */
    public function studentReports(): HasMany
    {
        return $this->hasMany(StudentReport::class);
    }

    /**
     * Get the student's display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->user ? $this->user->name : $this->name;
    }

    /**
     * Get the profile photo URL attribute.
     */
    public function getProfilePhotoPathAttribute($value)
    {
        if (!$value) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Return asset URL pointing to uploads directory
        return asset('uploads/' . $value);
    }
}
