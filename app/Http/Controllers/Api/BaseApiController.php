<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

abstract class BaseApiController extends Controller
{
    /**
     * Check if the authenticated user has the required role
     * 
     * @param string|array $requiredRole Role(s) required to access
     * @return bool
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function checkRole($requiredRole): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(401, 'Unauthenticated');
        }

        $roles = is_array($requiredRole) ? $requiredRole : [$requiredRole];
        
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized: This action requires ' . implode(' or ', $roles) . ' role');
        }

        return true;
    }

    /**
     * Check if user is admin
     */
    protected function requireAdmin(): void
    {
        $this->checkRole('admin');
    }

    /**
     * Check if user is tutor
     */
    protected function requireTutor(): void
    {
        $this->checkRole('tutor');
    }

    /**
     * Check if user is student
     */
    protected function requireStudent(): void
    {
        $this->checkRole('student');
    }

    /**
     * Check if user is admin or tutor
     */
    protected function requireAdminOrTutor(): void
    {
        $this->checkRole(['admin', 'tutor']);
    }

    /**
     * Get authenticated user ID
     */
    protected function getAuthUserId(): int
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthenticated');
        }
        return $user->id;
    }

    /**
     * Get authenticated user
     */
    protected function getAuthUser()
    {
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthenticated');
        }
        return $user;
    }
}
