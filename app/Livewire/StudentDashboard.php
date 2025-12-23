<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\StudentReport;
use App\Models\Material;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

#[Layout('layouts.student')]
class StudentDashboard extends Component
{
    use \Livewire\WithFileUploads;

    public $stats = [];
    public $schedules = [];
    public $recentMaterials = [];
    public $loading = true;
    public $photo;

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);

        $user = auth()->user();
        $student = $user->student;

        $path = $this->photo->store('profile-photos', 'public');
        $user->avatar_url = $path;
        $user->save();

        if ($student) {
            $student->update(['profile_photo_path' => $path]);
        }

        $this->dispatch('profile-updated');
        $this->dispatch('notify', 'Foto profil berhasil diperbarui! 📸');
    }

    public function mount()
    {
        $this->loadStats();
        $this->loadSchedules();
        $this->loadRecentMaterials();
        $this->loading = false;
    }

    public function loadStats()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            $this->stats = [
                'completed_materials' => 0,
                'total_materials' => 0,
                'attendance' => 0,
            ];
            return;
        }

        $cacheKey = "student_dashboard_stats_{$student->id}_" . now()->format('Y-m-d-H');

        $this->stats = Cache::remember($cacheKey, 300, function () use ($student) {
            // Get total materials available for student's class level
            $totalMaterials = Material::where('class_level_id', $student->class_level_id)
                ->count();

            // Get completed materials (attended classes with materials)
            $completedMaterials = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->count();

            // Monthly attendance percentage
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $monthlyAttendance = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();

            return [
                'completed_materials' => $completedMaterials,
                'total_materials' => max($totalMaterials, 10), // Minimum 10 for display
                'attendance' => $monthlyAttendance,
                'monthly_attendance' => $monthlyAttendance, // Alias for view compatibility
            ];
        });
    }

    public function loadSchedules()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            $this->schedules = collect([]);
            return;
        }

        $cacheKey = "student_schedules_{$student->id}_" . now()->format('Y-m-d-H');

        $this->schedules = Cache::remember($cacheKey, 300, function () use ($student) {
            return Schedule::where('student_id', $student->id)
                ->where('is_active', true)
                ->with(['subject', 'tutor'])
                ->orderByRaw("FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')")
                ->orderBy('time_start')
                ->get();
        });
    }

    public function loadRecentMaterials()
    {
        $user = auth()->user();
        $student = $user->student;

        if (!$student) {
            $this->recentMaterials = collect([]);
            return;
        }

        $cacheKey = "student_recent_materials_{$student->id}_" . now()->format('Y-m-d-H');

        $this->recentMaterials = Cache::remember($cacheKey, 300, function () use ($student) {
            return Material::where('class_level_id', $student->class_level_id)
                ->with(['subject', 'tutor'])
                ->latest()
                ->take(3)
                ->get();
        });
    }

    public function getNextSchedule()
    {
        if ($this->schedules->isEmpty()) {
            return null;
        }

        $now = Carbon::now();
        $currentDay = $now->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
        $currentTime = $now->hour * 60 + $now->minute;

        $dayMap = [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
            'Sunday' => 0,
        ];

        // Sort schedules by day and time
        $sortedSchedules = $this->schedules->sortBy(function ($schedule) use ($dayMap) {
            $day = $dayMap[$schedule->day_of_week] ?? 0;
            $time = explode(':', $schedule->time_start ?? '00:00');
            $minutes = (int) $time[0] * 60 + (int) ($time[1] ?? 0);
            return $day * 1440 + $minutes; // Convert to total minutes
        });

        // Find next schedule
        foreach ($sortedSchedules as $schedule) {
            $scheduleDay = $dayMap[$schedule->day_of_week] ?? 0;
            $time = explode(':', $schedule->time_start ?? '00:00');
            $scheduleMinutes = (int) $time[0] * 60 + (int) ($time[1] ?? 0);

            $daysUntil = ($scheduleDay - $currentDay + 7) % 7;
            if ($daysUntil === 0 && $scheduleMinutes > $currentTime) {
                return $schedule;
            } elseif ($daysUntil > 0) {
                return $schedule;
            }
        }

        return $sortedSchedules->first();
    }

    public function render()
    {
        return view('livewire.student-dashboard', [
            'nextSchedule' => $this->getNextSchedule(),
        ]);
    }
}
