<?php

namespace App\Filament\Tutor\Widgets;

use App\Filament\Tutor\Resources\Attendances\AttendanceResource;
use App\Models\Attendance;
use App\Models\Schedule;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TutorStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    
    // Enable lazy loading for better performance
    protected static bool $isLazy = true;
    
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $tutor = Auth::user();
        
        if (!$tutor || !$tutor->isTutor()) {
            return [];
        }

        $cacheKey = "tutor_stats_{$tutor->id}_" . now()->format('Y-m-d-H');
        
        return Cache::remember($cacheKey, 3600, function () use ($tutor) {
            // Total Siswa yang diajar
            $totalStudents = Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->distinct('student_id')
                ->count('student_id');
            
            // Total Jadwal Aktif
            $activeSchedules = Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->count();
            
            // Jurnal Bulan Ini
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            
            $monthlyJournals = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();
            
            // Jurnal Hari Ini
            $todayJournals = Attendance::where('tutor_id', $tutor->id)
                ->whereDate('date', Carbon::today())
                ->count();
            
            return [
                Stat::make('Total Siswa', $totalStudents)
                    ->description('Siswa yang sedang diajar')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('primary')
                    ->chart([5, 3, 8, 4, 10, 6, 12]),
                
                Stat::make('Jadwal Aktif', $activeSchedules)
                    ->description('Jadwal mengajar aktif')
                    ->descriptionIcon('heroicon-m-calendar-days')
                    ->color('info'),
                
                Stat::make('Jurnal Bulan Ini', $monthlyJournals)
                    ->description($todayJournals > 0 ? "Hari ini: {$todayJournals} jurnal" : 'Belum ada jurnal hari ini')
                    ->descriptionIcon('heroicon-m-clipboard-document-check')
                    ->color('success')
                    ->url(AttendanceResource::getUrl('create'))
                    ->extraAttributes([
                        'class' => 'cursor-pointer',
                    ]),
            ];
        });
    }
}
