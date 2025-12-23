<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AttendancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin can view all, Tutor can view all (filtered by scope), Student can view own
        return $user->isAdmin() || $user->isTutor() || $user->isStudent();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attendance $attendance): bool
    {
        // Admin can view all
        if ($user->isAdmin()) {
            return true;
        }
        
        // Tutor can view their own attendances
        if ($user->isTutor()) {
            return $attendance->tutor_id === $user->id;
        }
        
        // Student can view their own attendances
        if ($user->isStudent() && $user->student) {
            return $attendance->student_id === $user->student->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin and Tutor can create attendances
        return $user->isAdmin() || $user->isTutor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        // Admin can update all
        if ($user->isAdmin()) {
            return true;
        }
        
        // Tutor can only update their own attendances
        if ($user->isTutor()) {
            return $attendance->tutor_id === $user->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        // Admin can delete all
        if ($user->isAdmin()) {
            return true;
        }
        
        // Tutor can only delete their own attendances
        if ($user->isTutor()) {
            return $attendance->tutor_id === $user->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attendance $attendance): bool
    {
        // Only Admin can restore
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendance $attendance): bool
    {
        // Only Admin can force delete
        return $user->isAdmin();
    }
}
