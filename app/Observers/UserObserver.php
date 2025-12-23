<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if ($user->role === 'tutor') {
            $this->invalidateTutorCache($user);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->isDirty('role') || $user->role === 'tutor') {
            $this->invalidateTutorCache($user);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        if ($user->role === 'tutor') {
            $this->invalidateTutorCache($user);
        }
    }

    /**
     * Invalidate all tutor-related cache.
     */
    protected function invalidateTutorCache(User $user): void
    {
        // Invalidate home tutors cache
        Cache::forget('home_tutors');
        
        // Invalidate API tutor cache
        Cache::forget("api_tutor_{$user->id}");
        
        // Invalidate paginated API cache (first 5 pages)
        for ($page = 1; $page <= 5; $page++) {
            Cache::forget("api_tutors_page_{$page}_per_page_15");
            Cache::forget("api_tutors_page_{$page}_per_page_50");
        }
    }
}

