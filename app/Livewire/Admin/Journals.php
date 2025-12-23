<?php

namespace App\Livewire\Admin;

use App\Models\BimbelJournal;
use App\Models\Schedule;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Journals extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $tutorFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $tutor_id = '';
    public $schedule_id = '';
    public $date = '';
    public $time = '';
    public $material = '';
    public $documentation;
    public $documentation_path = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTutorFilter()
    {
        $this->resetPage();
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
        $journal = BimbelJournal::with(['tutor', 'schedule'])->find($id);
        if (!$journal) {
            session()->flash('error', 'Jurnal tidak ditemukan');
            return;
        }
        $this->editingId = $id;
        $this->tutor_id = $journal->tutor_id;
        $this->schedule_id = $journal->schedule_id ?? '';
        $this->date = $journal->date->format('Y-m-d');
        $this->time = $journal->time ?? '';
        $this->material = $journal->material ?? '';
        $this->documentation_path = $journal->documentation_path ?? '';
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
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'material' => 'required|string',
            'documentation' => 'nullable|file|mimes:jpeg,jpg,png,webp,pdf|max:10240',
        ], [
            'tutor_id.required' => 'Tutor wajib dipilih',
            'date.required' => 'Tanggal wajib diisi',
            'time.required' => 'Waktu wajib diisi',
            'material.required' => 'Materi wajib diisi',
        ]);

        try {
            if ($this->editingId) {
                $journal = BimbelJournal::find($this->editingId);
                $updateData = [
                    'tutor_id' => $this->tutor_id,
                    'schedule_id' => $this->schedule_id ?: null,
                    'date' => $this->date,
                    'time' => $this->time,
                    'material' => $this->material,
                ];

                if ($this->documentation) {
                    if ($journal->documentation_path) {
                        Storage::disk('public')->delete($journal->documentation_path);
                    }
                    $updateData['documentation_path'] = $this->documentation->store('journal-docs', 'public');
                }

                $journal->update($updateData);
                session()->flash('success', 'Jurnal berhasil diperbarui');
            } else {
                $docPath = null;
                if ($this->documentation) {
                    $docPath = $this->documentation->store('journal-docs', 'public');
                }

                BimbelJournal::create([
                    'tutor_id' => $this->tutor_id,
                    'schedule_id' => $this->schedule_id ?: null,
                    'date' => $this->date,
                    'time' => $this->time,
                    'material' => $this->material,
                    'documentation_path' => $docPath,
                ]);
                session()->flash('success', 'Jurnal berhasil ditambahkan');
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

        $journal = BimbelJournal::find($this->deleteId);
        if (!$journal) {
            session()->flash('error', 'Jurnal tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        try {
            if ($journal->documentation_path) {
                Storage::disk('public')->delete($journal->documentation_path);
            }
            $journal->delete();
            session()->flash('success', 'Jurnal berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->tutor_id = '';
        $this->schedule_id = '';
        $this->date = '';
        $this->time = '';
        $this->material = '';
        $this->documentation = null;
        $this->documentation_path = '';
    }

    public function render()
    {
        $query = BimbelJournal::with(['tutor', 'schedule']);

        if ($this->tutorFilter) {
            $query->where('tutor_id', $this->tutorFilter);
        }
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('material', 'like', '%' . $this->search . '%')
                    ->orWhereHas('tutor', function ($tutorQuery) {
                        $tutorQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $journals = $query->latest('date')->paginate(25);
        $tutors = User::where('role', 'tutor')->orderBy('name')->get();
        $schedules = Schedule::with(['student', 'tutor', 'subject'])->where('is_active', true)->get();

        return view('livewire.admin.journals', compact('journals', 'tutors', 'schedules'))
            ->layout('layouts.admin');
    }
}
