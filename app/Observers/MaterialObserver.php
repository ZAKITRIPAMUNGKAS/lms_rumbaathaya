<?php

namespace App\Observers;

use App\Models\Material;
use App\Services\MaterialService;
use Illuminate\Support\Facades\App;

class MaterialObserver
{
    /**
     * Handle the Material "created" event.
     */
    public function created(Material $material): void
    {
        $this->invalidateCache($material);
    }

    /**
     * Handle the Material "updated" event.
     */
    public function updated(Material $material): void
    {
        $this->invalidateCache($material);
    }

    /**
     * Handle the Material "deleted" event.
     */
    public function deleted(Material $material): void
    {
        $this->invalidateCache($material);
    }

    /**
     * Invalidate all material-related cache.
     */
    protected function invalidateCache(Material $material): void
    {
        $service = App::make(\App\Services\MaterialService::class);
        $service->invalidateMaterialCache($material->id);
        
        // Also invalidate API cache
        \Illuminate\Support\Facades\Cache::forget("api_material_{$material->id}");
    }
}
