<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Material;
use App\Models\Post;
use App\Models\Student;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends StatsOverviewWidget
{
    // Enable lazy loading for better performance
    protected static bool $isLazy = true;
    
    // Disable auto-refresh untuk performa lebih cepat
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        // Cache stats untuk 10 menit
        return Cache::remember('admin_dashboard_stats', 600, function () {
            $totalStudents = Student::count();
            $totalTutors = User::where('role', 'tutor')->count();
            $totalMaterials = Material::count();
            $totalPosts = Post::where('is_published', true)->count();
            
            // Jurnal bulan ini
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $monthlyJournals = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();
            
            return [
                // Statistik 1: Total Siswa
                Stat::make('Total Sahabat RA', $totalStudents)
                    ->description('Siswa aktif saat ini')
                    ->descriptionIcon('heroicon-m-academic-cap')
                    ->color('gray')
                    ->chart([7, 2, 10, 3, 15, 4, 17]),

                // Statistik 2: Tutor
                Stat::make('Total Tutor', $totalTutors)
                    ->description('Siap mengajar')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('gray'),

                // Statistik 3: Materi
                Stat::make('Bank Materi', $totalMaterials)
                    ->description('Modul & Video tersedia')
                    ->descriptionIcon('heroicon-m-book-open')
                    ->color('gray'),
                
                // Statistik 4: Jurnal Bulan Ini
                Stat::make('Jurnal Bulan Ini', $monthlyJournals)
                    ->description('Jurnal mengajar bulan ini')
                    ->descriptionIcon('heroicon-m-clipboard-document-check')
                    ->color('gray'),
                
                // Statistik 5: Postingan
                Stat::make('Postingan Publik', $totalPosts)
                    ->description('Artikel di Sahabat RA')
                    ->descriptionIcon('heroicon-m-newspaper')
                    ->color('gray'),
            ];
        });
    }
}
