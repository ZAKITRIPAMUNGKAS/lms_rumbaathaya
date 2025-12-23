<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get the materials for this subject.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Get the schedules for this subject.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the student reports for this subject.
     */
    public function studentReports(): HasMany
    {
        return $this->hasMany(StudentReport::class);
    }
}
