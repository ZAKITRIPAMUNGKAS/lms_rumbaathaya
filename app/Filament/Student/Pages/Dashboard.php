<?php

namespace App\Filament\Student\Pages;

use App\Models\Attendance;
use App\Models\StudentReport;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Dashboard extends Page
{
    protected static ?string $title = 'Beranda';
    
    protected string $view = 'filament.student.pages.dashboard';
    
    protected static string|BackedEnum|null $navigationIcon = null;
    
    protected static ?int $navigationSort = 1;
    
    // Matikan polling untuk performa
    protected static ?string $pollingInterval = null;

    public function getActivities()
    {
        $user = Auth::user()->load('student');
        $student = $user->student;

        if (!$student) {
            return collect([]);
        }

        // Cache activities untuk 5 menit
        $cacheKey = "student_activities_{$student->id}_" . now()->format('Y-m-d-H-i');
        
        return Cache::remember($cacheKey, 300, function () use ($student) {
            return Attendance::query()
                ->where('student_id', $student->id)
                ->with([
                    'schedule:id,subject_id,student_id',
                    'schedule.subject:id,name',
                    'tutor:id,name'
                ])
                ->select('id', 'schedule_id', 'tutor_id', 'student_id', 'date', 'topic_taught', 'photo_evidence_path', 'status')
                ->latest('date')
                ->take(5)
                ->get();
        });
    }

    public function getStats(): array
    {
        $user = Auth::user()->load('student');
        $student = $user->student;

        if (!$student) {
            return [
                'attendance' => 0,
                'tasks' => 0,
                'points' => 0,
            ];
        }

        // Cache stats untuk 5 menit
        $cacheKey = "student_stats_{$student->id}_" . now()->format('Y-m');
        
        return Cache::remember($cacheKey, 300, function () use ($student) {
            // Kehadiran bulan ini
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $attendance = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();

            // Tugas (Student Reports)
            $tasks = StudentReport::where('student_id', $student->id)
                ->where('report_date', '>=', $startOfMonth)
                ->count();

            // Rata-rata poin/nilai
            $latestReport = StudentReport::where('student_id', $student->id)
                ->latest('report_date')
                ->first();
            
            $points = $latestReport ? $latestReport->score : 0;

            return [
                'attendance' => $attendance,
                'tasks' => $tasks,
                'points' => $points,
            ];
        });
    }

    public function getStudentName(): string
    {
        $user = Auth::user()->load('student');
        $student = $user->student;
        
        $name = $student ? ($student->name ?? $user->name) : ($user->name ?? 'Siswa');
        
        // Pastikan nama ditampilkan dengan benar dan terformat
        return ucwords(strtolower(trim($name)));
    }
}
