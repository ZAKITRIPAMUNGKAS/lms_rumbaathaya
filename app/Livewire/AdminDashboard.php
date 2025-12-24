<?php

namespace App\Livewire;

use App\Models\Student;
use App\Models\User;
use App\Models\Material;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\BimbelJournal;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;

#[Layout('layouts.admin')]
class AdminDashboard extends Component
{
    public $stats = [];
    public $activities = [];
    public $charts = [];
    public $loading = true;

    public function mount()
    {
        $this->loadStats();
        $this->loadActivities();
        $this->loadCharts();
        $this->loading = false;
    }

    public function loadStats()
    {
        $cacheKey = 'admin_dashboard_stats_' . now()->format('Y-m-d-H');

        $this->stats = Cache::remember($cacheKey, 300, function () {
            $totalStudents = Student::count();
            $totalTutors = User::where('role', 'tutor')->count();
            $totalMaterials = Material::count();
            $totalUsers = User::count();
            $newStudentsThisMonth = Student::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $newTutorsThisMonth = User::where('role', 'tutor')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            return [
                'total_students' => $totalStudents,
                'total_tutors' => $totalTutors,
                'total_materials' => $totalMaterials,
                'total_users' => $totalUsers,
                'new_students_this_month' => $newStudentsThisMonth,
                'new_tutors_this_month' => $newTutorsThisMonth,
            ];
        });
    }

    public function loadActivities()
    {
        $cacheKey = 'admin_dashboard_activities_' . now()->format('Y-m-d-H-i');

        $this->activities = Cache::remember($cacheKey, 60, function () {
            $activities = collect();

            // Recent students (last 5)
            $recentStudents = Student::with('user:id,name,email')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($student) {
                    return [
                        'type' => 'student_registered',
                        'title' => 'Siswa baru terdaftar',
                        'description' => ($student->name ?? 'Siswa') . ' mendaftar',
                        'time' => $this->getTimeAgo($student->created_at),
                        'timestamp' => $student->created_at ? $student->created_at->timestamp : 0,
                        'icon' => 'users',
                        'color' => 'text-blue-600',
                        'bg' => 'bg-white border-blue-100',
                    ];
                });

            // Recent materials (last 5)
            $recentMaterials = Material::with(['uploader:id,name', 'subject:id,name'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($material) {
                    $subjectName = $material->subject->name ?? 'Tidak diketahui';
                    return [
                        'type' => 'material_uploaded',
                        'title' => 'Materi diupload',
                        'description' => ($material->title ?? 'Materi') . ' - ' . $subjectName,
                        'time' => $this->getTimeAgo($material->created_at),
                        'timestamp' => $material->created_at ? $material->created_at->timestamp : 0,
                        'icon' => 'book-open',
                        'color' => 'text-emerald-600',
                        'bg' => 'bg-white border-emerald-100',
                    ];
                });

            // Recent posts (last 3)
            $recentPosts = Post::where('is_published', true)
                ->latest('published_at')
                ->take(3)
                ->get()
                ->map(function ($post) {
                    $timestamp = ($post->published_at ?? $post->created_at);
                    return [
                        'type' => 'post_published',
                        'title' => 'Artikel dipublikasikan',
                        'description' => $post->title ?? 'Artikel',
                        'time' => $this->getTimeAgo($timestamp),
                        'timestamp' => $timestamp ? $timestamp->timestamp : 0,
                        'icon' => 'file-text',
                        'color' => 'text-violet-600',
                        'bg' => 'bg-white border-violet-100',
                    ];
                });

            // Recent schedules (last 3)
            $recentSchedules = Schedule::with(['subject:id,name', 'tutor:id,name'])
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($schedule) {
                    $subjectName = $schedule->subject->name ?? 'Tidak diketahui';
                    $tutorName = $schedule->tutor->name ?? 'Tidak diketahui';
                    return [
                        'type' => 'schedule_added',
                        'title' => 'Jadwal baru ditambahkan',
                        'description' => $subjectName . ' - ' . $tutorName,
                        'time' => $this->getTimeAgo($schedule->created_at),
                        'timestamp' => $schedule->created_at ? $schedule->created_at->timestamp : 0,
                        'icon' => 'calendar',
                        'color' => 'text-purple-600',
                        'bg' => 'bg-white border-purple-100',
                    ];
                });

            // Recent attendances (last 3)
            $recentAttendances = Attendance::with(['student:id,name', 'tutor:id,name'])
                ->latest('date')
                ->take(3)
                ->get()
                ->map(function ($attendance) {
                    $studentName = $attendance->student->name ?? 'Tidak diketahui';
                    $tutorName = $attendance->tutor->name ?? 'Tidak diketahui';
                    return [
                        'type' => 'attendance_recorded',
                        'title' => 'Jurnal baru dicatat',
                        'description' => 'Jurnal untuk ' . $studentName . ' oleh ' . $tutorName,
                        'time' => $this->getTimeAgo($attendance->created_at),
                        'timestamp' => $attendance->created_at ? $attendance->created_at->timestamp : 0,
                        'icon' => 'check-circle',
                        'color' => 'text-indigo-600',
                        'bg' => 'bg-white border-indigo-100',
                    ];
                });

            // Combine all activities and sort by timestamp
            return $recentStudents
                ->concat($recentMaterials)
                ->concat($recentPosts)
                ->concat($recentSchedules)
                ->concat($recentAttendances)
                ->sortByDesc('timestamp')
                ->take(10)
                ->values()
                ->toArray();
        });
    }

    public function loadCharts()
    {
        $cacheKey = 'admin_dashboard_charts_' . now()->format('Y-m-d-H');

        $this->charts = Cache::remember($cacheKey, 300, function () {
            $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

            $getDayName = function ($date) use ($dayNames) {
                $dayOfWeek = $date->dayOfWeek;
                if ($dayOfWeek === 0) {
                    return $dayNames[6];
                }
                return $dayNames[$dayOfWeek - 1];
            };

            // Weekly data (last 7 days)
            $weeklyRegistrations = [];
            $weeklyMaterials = [];
            $weeklySchedules = [];
            $weeklyPosts = [];
            $weeklyAttendances = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $dateStr = $date->format('Y-m-d');

                $weeklyRegistrations[] = [
                    'label' => $getDayName($date),
                    'value' => Student::whereDate('created_at', $dateStr)->count(),
                ];

                $weeklyMaterials[] = [
                    'label' => $getDayName($date),
                    'value' => Material::whereDate('created_at', $dateStr)->count(),
                ];

                $weeklySchedules[] = [
                    'label' => $getDayName($date),
                    'value' => Schedule::whereDate('created_at', $dateStr)->count(),
                ];

                $weeklyPosts[] = [
                    'label' => $getDayName($date),
                    'value' => Post::where('is_published', true)
                        ->whereDate('published_at', $dateStr)
                        ->count(),
                ];

                $weeklyAttendances[] = [
                    'label' => $getDayName($date),
                    'value' => BimbelJournal::whereDate('date', $dateStr)->count(),
                ];
            }

            return [
                'registrations' => $weeklyRegistrations,
                'materials' => $weeklyMaterials,
                'schedules' => $weeklySchedules,
                'posts' => $weeklyPosts,
                'attendances' => $weeklyAttendances,
            ];
        });
    }

    private function getTimeAgo($datetime): string
    {
        if (!$datetime) {
            return 'Baru saja';
        }

        $now = now();
        $diff = $now->diffInMinutes($datetime);

        if ($diff < 1) {
            return 'Baru saja';
        } elseif ($diff < 60) {
            return $diff . 'm lalu';
        } elseif ($diff < 1440) {
            return round($diff / 60) . 'j lalu';
        } elseif ($diff < 10080) {
            return round($diff / 1440) . 'h lalu';
        } else {
            return $datetime->format('d M Y');
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
