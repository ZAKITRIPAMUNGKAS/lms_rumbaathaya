<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class TestimonialController extends Controller
{
    /**
     * Get all published testimonials
     */
    public function index(): JsonResponse
    {
        $cacheKey = 'api_testimonials_published';
        
        $data = Cache::remember($cacheKey, 3600, function () {
            return Testimonial::published()
                ->orderBy('sort_order')
                ->latest()
                ->get()
                ->map(function ($testimonial) {
                    return [
                        'id' => $testimonial->id,
                        'name' => $testimonial->name,
                        'role' => $testimonial->role,
                        'content' => $testimonial->content,
                        'rating' => $testimonial->rating,
                        'photo' => $testimonial->photo_url,
                    ];
                });
        });

        return response()->json([
            'success' => true,
            'data' => $data->values(),
        ]);
    }
}

