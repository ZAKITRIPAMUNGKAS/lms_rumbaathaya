<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Schedule Model
 * 
 * Available Relationships:
 * - tutor(): BelongsTo (User)
 * - student(): BelongsTo (Student)
 * - subject(): BelongsTo (Subject)
 * - attendances(): HasMany (Attendance)
 * 
 * NOTE: Schedule does NOT have a classLevel relationship.
 * If you need class level info, access it via: $schedule->student->classLevel
 */
class Schedule extends Model
{
    protected $fillable = [
        'tutor_id',
        'student_id',
        'subject_id',
        'day_of_week',
        'time_start',
        'time_end',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        // time_start and time_end are time type from database, no special casting needed
    ];

    /**
     * Get the tutor for this schedule.
     */
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    /**
     * Get the student for this schedule.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject for this schedule.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the attendances for this schedule.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
