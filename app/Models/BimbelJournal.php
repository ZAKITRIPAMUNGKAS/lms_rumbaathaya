<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BimbelJournal extends Model
{
    protected $fillable = [
        'tutor_id',
        'schedule_id',
        'date',
        'time',
        'material',
        'documentation_path',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'string', // Time is stored as string in format H:i
    ];

    /**
     * Get the tutor for this journal.
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Get the schedule for this journal.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
