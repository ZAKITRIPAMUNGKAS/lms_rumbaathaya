<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.student')]
class Schedules extends Component
{
    public function render()
    {
        $user = Auth::user();
        $student = $user->student;

        $schedules = $student
            ? Schedule::where('student_id', $student->id)
                ->where('is_active', true)
                ->with(['tutor', 'subject'])
                ->get()
            : collect();

        // Sort: Today first, then by time, then other days
        $today = now()->dayOfWeek; // 0 (Sun) to 6 (Sat)
        // Convert Laravel's dayOfWeek to 1 (Mon) - 7 (Sun) if needed, but Schedule model stores English names usually.
        // Assuming Schedule stores 'Monday', 'Tuesday', etc.

        $dayMap = [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thursday' => 4,
            'Friday' => 5,
            'Saturday' => 6,
            'Sunday' => 7,
        ];

        // Custom sort: Days relative to today
        $sortedSchedules = $schedules->sortBy(function ($schedule) use ($today, $dayMap) {
            $scheduleDay = $dayMap[$schedule->day_of_week] ?? 0;
            // 0=Sun in Carbon, 7=Sun in our map. Let's align Carbon to our map.
            $currentDay = $today == 0 ? 7 : $today;

            $diff = $scheduleDay - $currentDay;
            if ($diff < 0)
                $diff += 7; // Wrap around for next week

            return $diff * 10000 + (int) str_replace(':', '', $schedule->time_start);
        });

        $groupedSchedules = $sortedSchedules->groupBy('day_of_week');

        // Ensure consistent order of days starting from today or Monday
        // For display we might want static Mon-Sun or Relative. 
        // Let's stick to the blade implementation's Mon-Sun grid but cleaner.

        return view('livewire.student.schedules', [
            'schedules' => $schedules,
            'groupedSchedules' => $groupedSchedules,
            'daysOfWeek' => [
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu',
            ]
        ]);
    }
}
