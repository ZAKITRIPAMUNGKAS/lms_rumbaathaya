<?php

namespace App\Livewire\Tutor;

use Livewire\Component;

class Schedules extends Component
{
    public function render()
    {
        $user = auth()->user();

        // Fetch schedules for the logged-in tutor
        $schedules = \App\Models\Schedule::where('tutor_id', $user->id)
            ->with(['student.classLevel', 'subject'])
            ->get();

        // Helper to check if attendance exists for today for a given schedule
        $schedules->transform(function ($schedule) {
            $today = now()->format('Y-m-d');
            $hasAttendance = \App\Models\Attendance::where('schedule_id', $schedule->id)
                // Use 3-argument syntax to ensure strict comparison and avoid linter confusion if possible
                ->whereDate('date', '=', $today)
                ->exists();

            $schedule->has_attendance_today = $hasAttendance;
            return $schedule;
        });

        // Group by day for easier display
        $groupedSchedules = $schedules->groupBy('day_of_week');

        // Order days logic (Monday to Sunday)
        $daysOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $sortedSchedules = collect($daysOrder)->mapWithKeys(function ($day) use ($groupedSchedules) {
            return [$day => $groupedSchedules->get($day)];
        })->filter();

        // Indonesian day names mapping
        $dayNamesIndo = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        return view('livewire.tutor.schedules', [
            'schedules' => $sortedSchedules,
            'dayNamesIndo' => $dayNamesIndo
        ])->layout('layouts.tutor');
    }
}
