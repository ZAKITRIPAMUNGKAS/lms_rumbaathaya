<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'nickname',
        'birth_place',
        'birth_date',
        'address',
        'school_name',
        'program',
        'program_other',
        'photo',
        'email',
        'phone',
        'whatsapp_number',
        'password',
        'status',
        'notes',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the program display name
     */
    public function getProgramDisplayAttribute(): string
    {
        if ($this->program === 'Yang lain' && $this->program_other) {
            return $this->program_other;
        }
        return $this->program;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }
}

