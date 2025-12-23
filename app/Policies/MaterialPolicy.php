<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MaterialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Admin, Tutor, and Student can view materials
        return $user->isAdmin() || $user->isTutor() || $user->isStudent();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Material $material): bool
    {
        // All authenticated users can view materials
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only Admin and Tutor can create materials
        return $user->isAdmin() || $user->isTutor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Material $material): bool
    {
        // Admin can update all
        if ($user->isAdmin()) {
            return true;
        }
        
        // Tutor can only update their own materials
        if ($user->isTutor()) {
            return $material->uploaded_by === $user->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Material $material): bool
    {
        // Admin can delete all
        if ($user->isAdmin()) {
            return true;
        }
        
        // Tutor can only delete their own materials
        if ($user->isTutor()) {
            return $material->uploaded_by === $user->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Material $material): bool
    {
        // Only Admin can restore
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Material $material): bool
    {
        // Only Admin can force delete
        return $user->isAdmin();
    }
}
