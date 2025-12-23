<?php

namespace App\Livewire\Tutor;

use Livewire\Component;

class AttendanceForm extends Component
{
    public $schedule_id;
    public $schedule;

    // Form fields
    public $topic_taught;
    public $student_progress_note;
    public $status = 'present';
    public $photo_evidence; // For file upload if needed later (leaving basic for now)

    // Journal fields (auto-created)
    public $material_journal;

    public function mount($schedule_id)
    {
        $this->schedule_id = $schedule_id;
        $this->schedule = \App\Models\Schedule::with(['student', 'subject', 'classLevel'])->findOrFail($schedule_id);

        // Security check: ensure this schedule belongs to logged in tutor
        if ($this->schedule->tutor_id !== auth()->id()) {
            abort(403);
        }
    }

    protected $rules = [
        'topic_taught' => 'required|string|min:5',
        'student_progress_note' => 'nullable|string',
        'status' => 'required|in:present,absent,permission',
    ];

    public function save()
    {
        $this->validate();

        // 1. Create Attendance
        $attendance = \App\Models\Attendance::create([
            'schedule_id' => $this->schedule->id,
            'tutor_id' => auth()->id(),
            'student_id' => $this->schedule->student_id,
            'date' => now()->format('Y-m-d'),
            'topic_taught' => $this->topic_taught,
            'student_progress_note' => $this->student_progress_note,
            'status' => $this->status,
            // Photo evidence can be added here if we implement file upload
        ]);

        // 2. Create Journal automatically if present
        if ($this->status === 'present') {
            \App\Models\BimbelJournal::create([
                'tutor_id' => auth()->id(),
                'schedule_id' => $this->schedule->id,
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i'),
                'material' => $this->topic_taught, // Use topic as material
                'documentation_path' => null,
            ]);
        }

        session()->flash('success', 'Absensi berhasil disimpan!');

        return redirect()->route('tutor.schedules.index');
    }

    public function render()
    {
        return view('livewire.tutor.attendance-form')->layout('layouts.tutor');
    }
}
