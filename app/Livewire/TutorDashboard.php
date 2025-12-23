<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Material;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

#[Layout('layouts.tutor')]
class TutorDashboard extends Component
{
    public $stats = [];
    public $schedules = [];
    public $loading = true;

    public function mount()
    {
        $this->loadStats();
        $this->loadSchedules();
        $this->loading = false;
    }

    public function loadStats()
    {
        $tutor = auth()->user();
        $cacheKey = "tutor_dashboard_stats_{$tutor->id}_" . now()->format('Y-m-d-H');

        $this->stats = Cache::remember($cacheKey, 300, function () use ($tutor) {
            $activeStudents = Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->distinct('student_id')
                ->count('student_id');

            $activeClasses = Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->count();

            $materialsUploaded = $tutor->uploadedMaterials()->count();

            $todayAttendance = Attendance::where('tutor_id', $tutor->id)
                ->whereDate('date', Carbon::today())
                ->where('status', 'present')
                ->count();

            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $monthlyAttendance = Attendance::where('tutor_id', $tutor->id)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->where('status', 'present')
                ->count();

            return [
                'active_students' => $activeStudents,
                'active_classes' => $activeClasses,
                'materials_uploaded' => $materialsUploaded,
                'today_attendance' => $todayAttendance,
                'monthly_attendance' => $monthlyAttendance,
            ];
        });
    }

    public function loadSchedules()
    {
        $tutor = auth()->user();
        $cacheKey = "tutor_schedules_{$tutor->id}_" . now()->format('Y-m-d-H');

        $this->schedules = Cache::remember($cacheKey, 300, function () use ($tutor) {
            return Schedule::where('tutor_id', $tutor->id)
                ->where('is_active', true)
                ->with(['subject', 'student'])
                ->orderBy('day_of_week')
                ->orderBy('time_start')
                ->take(10)
                ->get();
        });
    }

    public function render()
    {
        return view('livewire.tutor-dashboard');
    }
}
