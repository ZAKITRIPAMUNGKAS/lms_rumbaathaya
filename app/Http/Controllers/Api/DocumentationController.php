<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class DocumentationController extends Controller
{
    /**
     * Get all published documentation (photos and videos)
     */
    public function index(): JsonResponse
    {
        $cacheKey = 'api_documentation_all';
        
        $data = Cache::remember($cacheKey, 3600, function () {
            $photos = Documentation::published()
                ->photos()
                ->orderBy('sort_order')
                ->orderBy('event_date', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'type' => $item->type,
                        'file_path' => $item->file_url,
                        'thumbnail' => $item->thumbnail_url,
                        'category' => $item->category,
                        'event_date' => $item->event_date?->toIso8601String(),
                    ];
                });

            $videos = Documentation::published()
                ->videos()
                ->orderBy('sort_order')
                ->orderBy('event_date', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'type' => $item->type,
                        'video_url' => $item->video_url,
                        'thumbnail' => $item->thumbnail_url,
                        'category' => $item->category,
                        'event_date' => $item->event_date?->toIso8601String(),
                    ];
                });

            return [
                'photos' => $photos,
                'videos' => $videos,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
