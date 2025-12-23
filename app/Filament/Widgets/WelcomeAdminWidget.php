<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeAdminWidget extends Widget
{
    protected static ?int $sort = 0;
    
    protected string $view = 'filament.widgets.welcome-admin-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    // Matikan polling untuk performa
    protected static ?string $pollingInterval = null;

    protected function getViewData(): array
    {
        $user = Auth::user();
        
        $quotes = [
            "Kepemimpinan adalah seni untuk membuat orang lain melakukan apa yang Anda inginkan karena mereka ingin melakukannya. - Dwight D. Eisenhower",
            "Manajemen yang baik adalah seni membuat masalah menjadi begitu menarik sehingga semua orang ingin melihat dan menyelesaikannya. - Paul Hawken",
            "Kepemimpinan sejati adalah melayani orang lain, bukan dilayani. - John C. Maxwell",
            "Administrasi yang baik adalah fondasi dari organisasi yang sukses.",
            "Efisiensi adalah melakukan sesuatu dengan benar. Efektivitas adalah melakukan hal yang benar. - Peter Drucker",
        ];
        
        // Pastikan nama ditampilkan dengan benar
        $adminName = $user->name ?? 'Admin';
        $adminName = ucwords(strtolower(trim($adminName)));
        
        return [
            'adminName' => $adminName,
            'email' => $user->email ?? '',
            'avatar' => $user->avatar_url ? asset('storage/' . $user->avatar_url) : null,
            'quote' => $quotes[array_rand($quotes)],
        ];
    }
}
