<?php

namespace App\Services;

use App\Models\Material;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class MaterialService
{
    /**
     * Get paginated materials with caching.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        $page = request()->get('page', 1);
        $cacheKey = "materials_page_{$page}_per_page_{$perPage}";
        
        return Cache::remember($cacheKey, 3600, function () use ($perPage) {
            return Material::with(['subject:id,name', 'classLevel:id,name'])
                ->select('id', 'title', 'description', 'file_path', 'subject_id', 'class_level_id', 'created_at')
                ->latest()
                ->paginate($perPage);
        });
    }

    /**
     * Get latest materials with caching.
     */
    public function getLatest(int $limit = 10): Collection
    {
        $cacheKey = "materials_latest_{$limit}";
        
        return Cache::remember($cacheKey, 3600, function () use ($limit) {
            return Material::with(['subject:id,name', 'classLevel:id,name'])
                ->select('id', 'title', 'description', 'file_path', 'subject_id', 'class_level_id', 'created_at')
                ->latest()
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get a material by ID.
     */
    public function getById(int $id): ?Material
    {
        $cacheKey = "material_{$id}";
        
        return Cache::remember($cacheKey, 3600, function () use ($id) {
            return Material::with(['subject:id,name', 'classLevel:id,name'])
                ->where('id', $id)
                ->first();
        });
    }

    /**
     * Invalidate all material-related cache.
     */
    public function invalidateCache(): void
    {
        // Clear paginated cache (first 5 pages)
        for ($page = 1; $page <= 5; $page++) {
            Cache::forget("materials_page_{$page}_per_page_15");
            Cache::forget("materials_page_{$page}_per_page_50");
        }
        
        // Clear latest materials cache
        Cache::forget('materials_latest_10');
    }

    /**
     * Invalidate cache for a specific material.
     */
    public function invalidateMaterialCache(int $materialId): void
    {
        Cache::forget("material_{$materialId}");
        $this->invalidateCache();
    }
}
