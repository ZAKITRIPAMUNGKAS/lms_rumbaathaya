<?php

namespace App\Filament\Student\Widgets;

use App\Models\Post;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class SahabatRaNewsWidget extends Widget
{
    protected static ?int $sort = 4;
    
    protected string $view = 'filament.student.widgets.sahabat-ra-news-widget';
    
    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];
    
    // Enable lazy loading for better performance
    protected static bool $isLazy = true;
    
    // Matikan polling untuk performa
    protected static ?string $pollingInterval = null;

    protected function getViewData(): array
    {
        // Cache posts for 15 minutes untuk performa lebih baik
        $posts = Cache::remember('student_dashboard_posts', 900, function () {
            return Post::where('is_published', true)
                ->whereNotNull('published_at')
                ->latest('published_at')
                ->limit(3)
                ->select('id', 'title', 'thumbnail', 'slug', 'category')
                ->get();
        });

        return [
            'posts' => $posts,
        ];
    }
}

