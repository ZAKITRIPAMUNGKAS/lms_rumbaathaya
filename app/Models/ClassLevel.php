<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassLevel extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the students for this class level.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the materials for this class level.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
