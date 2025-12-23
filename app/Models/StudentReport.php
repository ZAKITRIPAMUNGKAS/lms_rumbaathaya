<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentReport extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'score',
        'attendance_count',
        'notes',
        'period',
        'report_date',
    ];

    protected $casts = [
        'report_date' => 'date',
        'score' => 'integer',
        'attendance_count' => 'integer',
    ];

    /**
     * Get the student that owns the report.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject that owns the report.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the score badge color.
     */
    public function getScoreColorAttribute(): string
    {
        if ($this->score >= 75) {
            return 'success';
        } elseif ($this->score >= 50) {
            return 'warning';
        }
        return 'danger';
    }
}
