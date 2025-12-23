<?php

namespace App\Livewire\Tutor;

use Livewire\Component;

class Attendance extends Component
{
    public $schedules;
    public $selectedSchedule = null;

    // Form fields
    public $topic_taught = '';
    public $student_progress_note = '';
    public $status = 'present';

    public function mount()
    {
        $this->loadTodaySchedules();
    }

    public function loadTodaySchedules()
    {
        $user = auth()->user();
        $todayDayName = now()->format('l'); // e.g., "Monday"

        // Fetch today's schedules
        $this->schedules = \App\Models\Schedule::where('tutor_id', $user->id)
            ->where('day_of_week', $todayDayName)
            ->with(['student.classLevel', 'subject'])
            ->get();

        // Check attendance status for each schedule
        $this->schedules->transform(function ($schedule) {
            $today = now()->format('Y-m-d');
            $hasAttendance = \App\Models\Attendance::where('schedule_id', $schedule->id)
                ->whereDate('date', '=', $today)
                ->exists();

            $schedule->has_attendance_today = $hasAttendance;
            return $schedule;
        });
    }

    public function selectSchedule($scheduleId)
    {
        $this->selectedSchedule = $scheduleId;
        $this->reset(['topic_taught', 'student_progress_note', 'status']);
        $this->status = 'present';
    }

    public function cancelForm()
    {
        $this->selectedSchedule = null;
        $this->reset(['topic_taught', 'student_progress_note', 'status']);
    }

    protected $rules = [
        'topic_taught' => 'required|string|min:5',
        'student_progress_note' => 'nullable|string',
        'status' => 'required|in:present,absent,permission',
    ];

    public function saveAttendance()
    {
        $this->validate();

        $schedule = \App\Models\Schedule::findOrFail($this->selectedSchedule);

        // Security check
        if ($schedule->tutor_id !== auth()->id()) {
            abort(403);
        }

        // Create Attendance
        \App\Models\Attendance::create([
            'schedule_id' => $schedule->id,
            'tutor_id' => auth()->id(),
            'student_id' => $schedule->student_id,
            'date' => now()->format('Y-m-d'),
            'topic_taught' => $this->topic_taught,
            'student_progress_note' => $this->student_progress_note,
            'status' => $this->status,
        ]);

        // Create Journal if present
        if ($this->status === 'present') {
            \App\Models\BimbelJournal::create([
                'tutor_id' => auth()->id(),
                'schedule_id' => $schedule->id,
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i'),
                'material' => $this->topic_taught,
                'documentation_path' => null,
            ]);
        }

        session()->flash('success', 'Absensi berhasil disimpan!');

        // Reset form and reload schedules
        $this->cancelForm();
        $this->loadTodaySchedules();
    }

    public function render()
    {
        return view('livewire.tutor.attendance')->layout('layouts.tutor');
    }
}
