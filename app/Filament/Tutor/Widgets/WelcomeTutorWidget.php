<?php

namespace App\Filament\Tutor\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeTutorWidget extends Widget
{
    protected static ?int $sort = 1;
    
    protected string $view = 'filament.tutor.widgets.welcome-tutor-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    // Matikan polling untuk performa
    protected static ?string $pollingInterval = null;

    protected function getViewData(): array
    {
        $user = Auth::user();
        
        $quotes = [
            "Mengajar adalah seni tertinggi. - Albert Einstein",
            "Seorang guru yang baik adalah seperti lilin - ia menghabiskan dirinya untuk menerangi jalan bagi orang lain. - Mustafa Kemal Atatürk",
            "Pendidikan bukanlah mengisi ember, tetapi menyalakan api. - William Butler Yeats",
            "Guru yang baik adalah guru yang terus belajar. - John Cotton Dana",
            "Mengajar berarti belajar dua kali. - Joseph Joubert",
            "Investasi terbaik adalah investasi dalam pendidikan. - Benjamin Franklin",
            "Guru yang baik memberikan inspirasi, bukan hanya informasi.",
            "Mengajar adalah profesi yang menciptakan semua profesi lainnya.",
        ];
        
        // Pastikan nama ditampilkan dengan benar
        $tutorName = $user->name ?? 'Tutor';
        $tutorName = ucwords(strtolower(trim($tutorName)));
        
        // Get avatar URL - handle both accessor and raw attribute
        $avatarUrl = null;
        $rawAvatar = $user->getAttribute('avatar_url'); // Get raw value from database
        
        if ($rawAvatar) {
            // Check if it's already a full URL
            if (filter_var($rawAvatar, FILTER_VALIDATE_URL)) {
                $avatarUrl = $rawAvatar;
            } else {
                // It's a storage path, prepend storage/
                $avatarUrl = asset('storage/' . $rawAvatar);
            }
        }
        
        // Debug logging in development
        if (config('app.debug')) {
            \Log::debug('WelcomeTutorWidget - Avatar URL', [
                'user_id' => $user->id,
                'raw_avatar' => $rawAvatar,
                'avatar_url' => $avatarUrl,
            ]);
        }
        
        return [
            'tutorName' => $tutorName,
            'email' => $user->email ?? '',
            'avatar' => $avatarUrl,
            'quote' => $quotes[array_rand($quotes)],
        ];
    }
}
