<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'schedule_id',
        'tutor_id',
        'student_id',
        'date',
        'topic_taught',
        'student_progress_note',
        'photo_evidence_path',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the schedule for this attendance.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the tutor for this attendance.
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Get the student for this attendance.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
