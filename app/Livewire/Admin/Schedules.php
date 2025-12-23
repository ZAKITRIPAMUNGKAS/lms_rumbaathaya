<?php

namespace App\Livewire\Admin;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Schedules extends Component
{
    use WithPagination;

    public $search = '';
    public $tutorFilter = '';
    public $studentFilter = '';
    public $subjectFilter = '';
    public $dayFilter = '';
    public $isActiveFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $tutor_id = '';
    public $student_id = '';
    public $subject_id = '';
    public $day_of_week = '';
    public $time_start = '';
    public $time_end = '';
    public $is_active = true;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function getStatsProperty()
    {
        return [
            'total' => Schedule::count(),
            'active' => Schedule::where('is_active', true)->count(),
            'today' => Schedule::where('day_of_week', now()->format('l'))->where('is_active', true)->count(),
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTutorFilter()
    {
        $this->resetPage();
    }

    public function updatingStudentFilter()
    {
        $this->resetPage();
    }

    public function updatingSubjectFilter()
    {
        $this->resetPage();
    }

    public function updatingDayFilter()
    {
        $this->resetPage();
    }

    public function updatingIsActiveFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $schedule = Schedule::with(['tutor', 'student', 'subject'])->find($id);
        if (!$schedule) {
            session()->flash('error', 'Jadwal tidak ditemukan');
            return;
        }
        $this->editingId = $id;
        $this->tutor_id = $schedule->tutor_id;
        $this->student_id = $schedule->student_id;
        $this->subject_id = $schedule->subject_id;
        $this->day_of_week = $schedule->day_of_week;
        $this->time_start = $schedule->time_start;
        $this->time_end = $schedule->time_end;
        $this->is_active = $schedule->is_active;
        $this->showModal = true;
    }

    public function openDeleteModal($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function save()
    {
        $this->validate([
            'tutor_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'is_active' => 'boolean',
        ], [
            'tutor_id.required' => 'Tutor wajib dipilih',
            'student_id.required' => 'Siswa wajib dipilih',
            'subject_id.required' => 'Mata pelajaran wajib dipilih',
            'day_of_week.required' => 'Hari wajib dipilih',
            'time_start.required' => 'Waktu mulai wajib diisi',
            'time_end.required' => 'Waktu selesai wajib diisi',
            'time_end.after' => 'Waktu selesai harus setelah waktu mulai',
        ]);

        // Verify tutor role
        $tutor = User::find($this->tutor_id);
        if (!$tutor || $tutor->role !== 'tutor') {
            session()->flash('error', 'User yang dipilih bukan tutor');
            return;
        }

        try {
            if ($this->editingId) {
                Schedule::find($this->editingId)->update([
                    'tutor_id' => $this->tutor_id,
                    'student_id' => $this->student_id,
                    'subject_id' => $this->subject_id,
                    'day_of_week' => $this->day_of_week,
                    'time_start' => $this->time_start,
                    'time_end' => $this->time_end,
                    'is_active' => $this->is_active,
                ]);
                session()->flash('success', 'Jadwal berhasil diperbarui');
            } else {
                Schedule::create([
                    'tutor_id' => $this->tutor_id,
                    'student_id' => $this->student_id,
                    'subject_id' => $this->subject_id,
                    'day_of_week' => $this->day_of_week,
                    'time_start' => $this->time_start,
                    'time_end' => $this->time_end,
                    'is_active' => $this->is_active ?? true,
                ]);
                session()->flash('success', 'Jadwal berhasil ditambahkan');
            }
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if (!$this->deleteId)
            return;

        $schedule = Schedule::find($this->deleteId);
        if (!$schedule) {
            session()->flash('error', 'Jadwal tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        // Check for dependencies
        $attendancesCount = \App\Models\Attendance::where('schedule_id', $this->deleteId)->count();
        $journalsCount = \App\Models\BimbelJournal::where('schedule_id', $this->deleteId)->count();

        if ($attendancesCount > 0 || $journalsCount > 0) {
            $total = $attendancesCount + $journalsCount;
            session()->flash('error', "Tidak dapat menghapus jadwal karena memiliki {$total} data terkait (absensi/jurnal).");
            $this->closeDeleteModal();
            return;
        }

        try {
            $schedule->delete();
            session()->flash('success', 'Jadwal berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->tutor_id = '';
        $this->student_id = '';
        $this->subject_id = '';
        $this->day_of_week = '';
        $this->time_start = '';
        $this->time_end = '';
        $this->is_active = true;
    }

    public function render()
    {
        $query = Schedule::with(['tutor', 'student', 'subject']);

        if ($this->tutorFilter) {
            $query->where('tutor_id', $this->tutorFilter);
        }
        if ($this->studentFilter) {
            $query->where('student_id', $this->studentFilter);
        }
        if ($this->subjectFilter) {
            $query->where('subject_id', $this->subjectFilter);
        }
        if ($this->dayFilter) {
            $query->where('day_of_week', $this->dayFilter);
        }
        if ($this->isActiveFilter !== '') {
            $query->where('is_active', $this->isActiveFilter === '1');
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('tutor', function ($tutorQuery) {
                    $tutorQuery->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('student', function ($studentQuery) {
                        $studentQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('subject', function ($subjectQuery) {
                        $subjectQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $schedules = $query->orderBy('day_of_week')->orderBy('time_start')->paginate(25);
        $tutors = User::where('role', 'tutor')->orderBy('name')->get();
        $students = Student::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $days = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];

        return view('livewire.admin.schedules', compact('schedules', 'tutors', 'students', 'subjects', 'days'))
            ->layout('layouts.admin');
    }
}
