<?php

namespace App\Livewire\Tutor;

use App\Models\BimbelJournal;
use App\Models\Schedule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Journals extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $schedule_id = '';
    public $date = '';
    public $time = '';
    public $material = '';
    public $documentation;
    public $documentation_path = '';

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'schedule_id' => 'nullable|exists:schedules,id',
            'date' => 'required|date',
            'time' => 'required|string',
            'material' => 'required|string|min:5',
            'documentation' => 'nullable|image|max:2048', // Max 2MB image
        ];
    }

    protected $messages = [
        'date.required' => 'Tanggal mengajar wajib diisi.',
        'time.required' => 'Waktu mengajar wajib diisi.',
        'material.required' => 'Materi pelajaran wajib diisi.',
        'material.min' => 'Materi pelajaran minimal 5 karakter.',
        'documentation.image' => 'File dokumentasi harus berupa gambar.',
        'documentation.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->date = now()->format('Y-m-d');
        $this->time = now()->format('H:i');
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $journal = BimbelJournal::where('tutor_id', auth()->id())->find($id);
        if (!$journal) {
            session()->flash('error', 'Jurnal tidak ditemukan atau Anda tidak berwenang.');
            return;
        }

        $this->resetValidation();
        $this->editingId = $id;
        $this->schedule_id = $journal->schedule_id ?? '';
        $this->date = $journal->date ? $journal->date->format('Y-m-d') : '';
        $this->time = $journal->time ?? '';
        $this->material = $journal->material ?? '';
        $this->documentation_path = $journal->documentation_path ?? '';
        $this->documentation = null;
        
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $journal = BimbelJournal::where('tutor_id', auth()->id())->find($id);
        if (!$journal) {
            session()->flash('error', 'Jurnal tidak ditemukan atau Anda tidak berwenang.');
            return;
        }
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $journal = BimbelJournal::where('tutor_id', auth()->id())->find($this->deleteId);
        if ($journal) {
            // Delete old documentation file if exists
            if ($journal->documentation_path) {
                Storage::disk('public')->delete($journal->documentation_path);
            }
            $journal->delete();
            session()->flash('success', 'Jurnal berhasil dihapus.');
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'tutor_id' => auth()->id(),
            'schedule_id' => $this->schedule_id ?: null,
            'date' => $this->date,
            'time' => $this->time,
            'material' => $this->material,
        ];

        // Handle File Upload
        if ($this->documentation) {
            // Delete old one if editing
            if ($this->editingId && $this->documentation_path) {
                Storage::disk('public')->delete($this->documentation_path);
            }
            $fileName = time() . '_' . $this->documentation->getClientOriginalName();
            $path = $this->documentation->storeAs('documentations', $fileName, 'public');
            $data['documentation_path'] = $path;
        }

        if ($this->editingId) {
            BimbelJournal::where('tutor_id', auth()->id())->find($this->editingId)->update($data);
            session()->flash('success', 'Jurnal berhasil diperbarui.');
        } else {
            BimbelJournal::create($data);
            session()->flash('success', 'Jurnal mengajar baru berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->schedule_id = '';
        $this->date = '';
        $this->time = '';
        $this->material = '';
        $this->documentation = null;
        $this->documentation_path = '';
        $this->resetValidation();
    }

    public function render()
    {
        $tutorId = auth()->id();
        
        $journals = BimbelJournal::where('tutor_id', $tutorId)
            ->with(['schedule.student', 'schedule.subject'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(12);

        // Get schedules assigned to this tutor for dropdown selection
        $schedules = Schedule::where('tutor_id', $tutorId)
            ->with(['student', 'subject'])
            ->orderBy('day_of_week', 'asc')
            ->orderBy('time_start', 'asc')
            ->get();

        return view('livewire.tutor.journals', [
            'journals' => $journals,
            'schedules' => $schedules
        ]);
    }
}
