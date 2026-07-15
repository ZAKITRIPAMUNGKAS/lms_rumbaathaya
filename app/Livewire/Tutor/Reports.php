<?php

namespace App\Livewire\Tutor;

use App\Models\StudentReport;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class Reports extends Component
{
    use WithPagination;

    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $student_id = '';
    public $subject_id = '';
    public $score = '';
    public $attendance_count = '';
    public $notes = '';
    public $period = '';
    public $report_date = '';

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|integer|min:0|max:100',
            'attendance_count' => 'required|integer|min:0',
            'notes' => 'required|string|min:5',
            'period' => 'required|string|max:255',
            'report_date' => 'required|date',
        ];
    }

    protected $messages = [
        'student_id.required' => 'Pilih siswa.',
        'subject_id.required' => 'Pilih mata pelajaran.',
        'score.required' => 'Nilai akhir wajib diisi.',
        'score.integer' => 'Nilai akhir harus berupa angka.',
        'score.min' => 'Nilai minimal adalah 0.',
        'score.max' => 'Nilai maksimal adalah 100.',
        'attendance_count.required' => 'Jumlah kehadiran wajib diisi.',
        'attendance_count.integer' => 'Jumlah kehadiran harus berupa angka.',
        'notes.required' => 'Catatan perkembangan wajib diisi.',
        'notes.min' => 'Catatan minimal 5 karakter.',
        'period.required' => 'Periode belajar wajib diisi (contoh: Juli 2026).',
        'report_date.required' => 'Tanggal laporan wajib diisi.',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->report_date = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        // Find report where tutor has a schedule with the student
        $report = StudentReport::find($id);
        if (!$report) {
            session()->flash('error', 'Laporan tidak ditemukan.');
            return;
        }

        $this->resetValidation();
        $this->editingId = $id;
        $this->student_id = $report->student_id;
        $this->subject_id = $report->subject_id;
        $this->score = $report->score;
        $this->attendance_count = $report->attendance_count;
        $this->notes = $report->notes ?? '';
        $this->period = $report->period ?? '';
        $this->report_date = $report->report_date ? $report->report_date->format('Y-m-d') : '';
        
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $report = StudentReport::find($id);
        if (!$report) {
            session()->flash('error', 'Laporan tidak ditemukan.');
            return;
        }
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $report = StudentReport::find($this->deleteId);
        if ($report) {
            $report->delete();
            session()->flash('success', 'Laporan berhasil dihapus.');
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'student_id' => $this->student_id,
            'subject_id' => $this->subject_id,
            'score' => $this->score,
            'attendance_count' => $this->attendance_count,
            'notes' => $this->notes,
            'period' => $this->period,
            'report_date' => $this->report_date,
        ];

        if ($this->editingId) {
            StudentReport::find($this->editingId)->update($data);
            session()->flash('success', 'Laporan berhasil diperbarui.');
        } else {
            StudentReport::create($data);
            session()->flash('success', 'Laporan perkembangan belajar baru berhasil dibuat.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->student_id = '';
        $this->subject_id = '';
        $this->score = '';
        $this->attendance_count = '';
        $this->notes = '';
        $this->period = '';
        $this->report_date = '';
        $this->resetValidation();
    }

    public function render()
    {
        $tutorId = auth()->id();
        
        // Get tutor's active schedules to identify which students they teach
        $schedules = Schedule::where('tutor_id', $tutorId)
            ->where('is_active', true)
            ->with(['student', 'subject'])
            ->get();

        $studentIds = $schedules->pluck('student_id')->unique()->toArray();
        $subjectIds = $schedules->pluck('subject_id')->unique()->toArray();

        // Paginate reports for these students
        $reports = StudentReport::whereIn('student_id', $studentIds)
            ->with(['student', 'subject'])
            ->orderBy('report_date', 'desc')
            ->paginate(12);

        // Dropdowns data
        $students = Student::whereIn('id', $studentIds)->orderBy('name', 'asc')->get();
        $subjects = Subject::whereIn('id', $subjectIds)->orderBy('name', 'asc')->get();

        return view('livewire.tutor.reports', [
            'reports' => $reports,
            'schedules' => $schedules,
            'students' => $students,
            'subjects' => $subjects
        ]);
    }
}
