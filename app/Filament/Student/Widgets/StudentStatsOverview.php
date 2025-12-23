<?php

namespace App\Filament\Student\Widgets;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\StudentReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StudentStatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    
    // Enable lazy loading for better performance
    protected static bool $isLazy = true;
    
    // Disable auto-refresh untuk performa
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $user = Auth::user()->load('student');
        $student = $user->student;

        if (!$student) {
            return [];
        }

        // Method individual sudah handle cache sendiri, jadi langsung panggil saja
        // Metric 1: Next Class
        $nextClass = $this->getNextClass($student);
        
        // Metric 2: Monthly Attendance
        $monthlyAttendance = $this->getMonthlyAttendance($student);
        
        // Metric 3: Latest Performance
        $latestPerformance = $this->getLatestPerformance($student);

        return [
            Stat::make('Kelas Selanjutnya', $nextClass['subject'] ?? 'Tidak ada jadwal')
                ->description($nextClass['time'] ?? 'Belum ada jadwal')
                ->icon('heroicon-m-calendar')
                ->color('warning'),
            
            Stat::make('Kehadiran Bulan Ini', $monthlyAttendance['count'] . ' Sesi')
                ->description($monthlyAttendance['message'])
                ->icon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Rata-rata Nilai', $latestPerformance['score'] ?? 'Belum ada')
                ->description($latestPerformance['subject'] ?? '')
                ->icon('heroicon-m-star')
                ->color('primary')
                ->chart($latestPerformance['chart'] ?? [85, 90, 88, 92, 87]),
        ];
    }

    protected function getNextClass($student): array
    {
        // Cache next class calculation untuk 1 jam
        $cacheKey = "next_class_{$student->id}_" . now()->format('Y-m-d-H');
        
        return Cache::remember($cacheKey, 3600, function () use ($student) {
            $today = Carbon::now();
            $dayOfWeek = $today->format('l'); // Monday, Tuesday, etc.
            
            // Get active schedules for this student (optimized query - limit untuk performa)
            $schedules = Schedule::where('student_id', $student->id)
                ->where('is_active', true)
                ->with(['subject:id,name']) // Only load necessary columns
                ->select('id', 'student_id', 'subject_id', 'day_of_week', 'time_start', 'is_active')
                ->limit(10) // Limit untuk performa lebih baik
                ->get();

            if ($schedules->isEmpty()) {
                return [];
            }

            $nextClass = null;
            $minDaysUntil = 999;

            foreach ($schedules as $schedule) {
                $scheduleDay = $schedule->day_of_week;
                $scheduleTime = Carbon::parse($schedule->time_start);
                
                // Calculate days until next occurrence
                $daysUntil = $this->daysUntilNext($dayOfWeek, $scheduleDay, $scheduleTime);
                
                if ($daysUntil < $minDaysUntil) {
                    $minDaysUntil = $daysUntil;
                    $nextClass = $schedule;
                }
            }

            if ($nextClass) {
                $nextDate = Carbon::now()->addDays($minDaysUntil);
                $dayName = $this->getDayName($nextClass->day_of_week);
                $time = $nextClass->time_start->format('H:i');
                
                return [
                    'subject' => $nextClass->subject->name ?? 'Mata Pelajaran',
                    'time' => $dayName . ', ' . $nextDate->format('d M Y') . ' pukul ' . $time,
                ];
            }

            return [];
        });
    }

    protected function daysUntilNext(string $currentDay, string $scheduleDay, Carbon $scheduleTime): int
    {
        $dayMap = [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
            'Sunday' => 7,
        ];

        $currentDayNum = $dayMap[$currentDay] ?? 1;
        $scheduleDayNum = $dayMap[$scheduleDay] ?? 1;
        
        $now = Carbon::now();
        $todayTime = $now->format('H:i');
        $scheduleTimeStr = $scheduleTime->format('H:i');

        // If schedule is later today
        if ($scheduleDayNum == $currentDayNum && $scheduleTimeStr > $todayTime) {
            return 0;
        }
        
        // If schedule is later this week
        if ($scheduleDayNum > $currentDayNum) {
            return $scheduleDayNum - $currentDayNum;
        }
        
        // If schedule is next week
        return 7 - $currentDayNum + $scheduleDayNum;
    }

    protected function getDayName(string $dayOfWeek): string
    {
        $dayNames = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $dayNames[$dayOfWeek] ?? $dayOfWeek;
    }

    protected function getMonthlyAttendance($student): array
    {
        // Cache monthly attendance untuk 1 jam
        $cacheKey = "monthly_attendance_{$student->id}_" . now()->format('Y-m');
        
        return Cache::remember($cacheKey, 3600, function () use ($student) {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            // Use select count for better performance
            $count = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();

            $message = $count > 0 ? 'Keep it up! 🎉' : 'Ayo mulai belajar!';

            return [
                'count' => $count,
                'message' => $message,
            ];
        });
    }

    protected function getLatestPerformance($student): array
    {
        // Cache latest performance untuk 1 jam
        $cacheKey = "latest_performance_{$student->id}_" . now()->format('Y-m-d-H');
        
        return Cache::remember($cacheKey, 3600, function () use ($student) {
            // Optimize query - get latest report with subject and last 5 scores in one query
            $reports = StudentReport::where('student_id', $student->id)
                ->latest('report_date')
                ->with(['subject:id,name']) // Only load necessary columns
                ->select('id', 'student_id', 'subject_id', 'score', 'report_date')
                ->limit(5)
                ->get();

            if ($reports->isEmpty()) {
                return [];
            }

            $latestReport = $reports->first();
            $chartScores = $reports->pluck('score')->reverse()->values()->toArray();

            return [
                'score' => $latestReport->score,
                'subject' => $latestReport->subject->name ?? 'Mata Pelajaran',
                'chart' => $chartScores,
            ];
        });
    }
}

