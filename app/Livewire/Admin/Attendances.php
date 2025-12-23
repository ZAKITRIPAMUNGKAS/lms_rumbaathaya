<?php

namespace App\Livewire\Admin;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Attendances extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $studentFilter = '';
    public $tutorFilter = '';
    public $statusFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $schedule_id = '';
    public $tutor_id = '';
    public $student_id = '';
    public $date = '';
    public $topic_taught = '';
    public $student_progress_note = '';
    public $photo_evidence;
    public $photo_evidence_path = '';
    public $status = 'present';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStudentFilter()
    {
        $this->resetPage();
    }

    public function updatingTutorFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->date = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $attendance = Attendance::with(['student', 'tutor', 'schedule'])->find($id);
        if (!$attendance) {
            session()->flash('error', 'Absensi tidak ditemukan');
            return;
        }
        $this->editingId = $id;
        $this->schedule_id = $attendance->schedule_id ?? '';
        $this->tutor_id = $attendance->tutor_id;
        $this->student_id = $attendance->student_id;
        $this->date = $attendance->date->format('Y-m-d');
        $this->topic_taught = $attendance->topic_taught ?? '';
        $this->student_progress_note = $attendance->student_progress_note ?? '';
        $this->photo_evidence_path = $attendance->photo_evidence_path ?? '';
        $this->status = $attendance->status ?? 'present';
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
            'date' => 'required|date',
            'status' => 'required|in:present,absent,permission,sick',
            'photo_evidence' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ], [
            'tutor_id.required' => 'Tutor wajib dipilih',
            'student_id.required' => 'Siswa wajib dipilih',
            'date.required' => 'Tanggal wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ]);

        try {
            if ($this->editingId) {
                $attendance = Attendance::find($this->editingId);
                $updateData = [
                    'tutor_id' => $this->tutor_id,
                    'student_id' => $this->student_id,
                    'schedule_id' => $this->schedule_id ?: null,
                    'date' => $this->date,
                    'topic_taught' => $this->topic_taught ?: null,
                    'student_progress_note' => $this->student_progress_note ?: null,
                    'status' => $this->status,
                ];

                if ($this->photo_evidence) {
                    if ($attendance->photo_evidence_path) {
                        Storage::disk('public')->delete($attendance->photo_evidence_path);
                    }
                    $updateData['photo_evidence_path'] = $this->photo_evidence->store('attendance-photos', 'public');
                }

                $attendance->update($updateData);
                session()->flash('success', 'Absensi berhasil diperbarui');
            } else {
                $photoPath = null;
                if ($this->photo_evidence) {
                    $photoPath = $this->photo_evidence->store('attendance-photos', 'public');
                }

                Attendance::create([
                    'tutor_id' => $this->tutor_id,
                    'student_id' => $this->student_id,
                    'schedule_id' => $this->schedule_id ?: null,
                    'date' => $this->date,
                    'topic_taught' => $this->topic_taught ?: null,
                    'student_progress_note' => $this->student_progress_note ?: null,
                    'photo_evidence_path' => $photoPath,
                    'status' => $this->status,
                ]);
                session()->flash('success', 'Absensi berhasil ditambahkan');
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

        $attendance = Attendance::find($this->deleteId);
        if (!$attendance) {
            session()->flash('error', 'Absensi tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        try {
            if ($attendance->photo_evidence_path) {
                Storage::disk('public')->delete($attendance->photo_evidence_path);
            }
            $attendance->delete();
            session()->flash('success', 'Absensi berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->schedule_id = '';
        $this->tutor_id = '';
        $this->student_id = '';
        $this->date = '';
        $this->topic_taught = '';
        $this->student_progress_note = '';
        $this->photo_evidence = null;
        $this->photo_evidence_path = '';
        $this->status = 'present';
    }

    public function render()
    {
        $query = Attendance::with(['student', 'tutor', 'schedule']);

        if ($this->studentFilter) {
            $query->where('student_id', $this->studentFilter);
        }
        if ($this->tutorFilter) {
            $query->where('tutor_id', $this->tutorFilter);
        }
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('student', function ($studentQuery) {
                    $studentQuery->where('name', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('tutor', function ($tutorQuery) {
                        $tutorQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('topic_taught', 'like', '%' . $this->search . '%');
            });
        }

        $attendances = $query->latest('date')->paginate(25);
        $students = Student::orderBy('name')->get();
        $tutors = User::where('role', 'tutor')->orderBy('name')->get();
        $schedules = Schedule::with(['student', 'tutor', 'subject'])->where('is_active', true)->get();

        return view('livewire.admin.attendances', compact('attendances', 'students', 'tutors', 'schedules'))
            ->layout('layouts.admin');
    }
}
