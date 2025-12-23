<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocumentationController extends Controller
{
    public function index()
    {
        // Cache documentation for 1 hour
        $cacheKey = 'documentation_all';
        
        $data = Cache::remember($cacheKey, 3600, function () {
            // Ambil dokumentasi yang dipublikasikan, diurutkan berdasarkan sort_order
            $photos = Documentation::published()
                ->photos()
                ->orderBy('sort_order')
                ->orderBy('event_date', 'desc')
                ->get();

            $videos = Documentation::published()
                ->videos()
                ->orderBy('sort_order')
                ->orderBy('event_date', 'desc')
                ->get();

            return compact('photos', 'videos');
        });

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl . '/dokumentasi');
    }
}

