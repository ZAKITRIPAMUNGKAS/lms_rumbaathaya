<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar_url',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the student profile associated with the user.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get the schedules where this user is a tutor.
     */
    public function tutorSchedules()
    {
        return $this->hasMany(Schedule::class, 'tutor_id');
    }

    /**
     * Get the attendances where this user is a tutor.
     */
    public function tutorAttendances()
    {
        return $this->hasMany(Attendance::class, 'tutor_id');
    }

    /**
     * Get the materials uploaded by this user.
     */
    public function uploadedMaterials()
    {
        return $this->hasMany(Material::class, 'uploaded_by');
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is tutor.
     */
    public function isTutor(): bool
    {
        return $this->role === 'tutor';
    }

    /**
     * Check if user is student.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Determine if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Admin can only access admin panel
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }
        
        // Tutor can only access tutor panel
        if ($panel->getId() === 'tutor') {
            return $this->role === 'tutor';
        }
        
        // Student can only access student panel
        if ($panel->getId() === 'student') {
            return $this->role === 'student';
        }
        
        return false;
    }

    /**
     * Get the avatar URL attribute (accessor for Filament AccountWidget).
     * This ensures avatar URLs are always properly formatted.
     */
    public function getAvatarUrlAttribute($value): ?string
    {
        // Get original value from database (not modified)
        $originalValue = $this->attributes['avatar_url'] ?? $value;
        
        if (!$originalValue) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($originalValue, FILTER_VALIDATE_URL)) {
            return $originalValue;
        }

        // Filament stores path as 'avatars/filename.png'
        // We need to prepend 'storage/' to make it accessible via public/storage symlink
        return asset('storage/' . $originalValue);
    }

    /**
     * Get the full avatar URL (helper method).
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }
}
