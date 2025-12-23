<?php

namespace App\Livewire\Admin;

use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Subjects extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;
    public $name = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
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
        $subject = Subject::find($id);
        if (!$subject) {
            session()->flash('error', 'Mata pelajaran tidak ditemukan');
            return;
        }
        $this->editingId = $id;
        $this->name = $subject->name;
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($this->editingId) {
            $rules['name'][] = Rule::unique('subjects', 'name')->ignore($this->editingId);
        } else {
            $rules['name'][] = 'unique:subjects,name';
        }

        $this->validate($rules, [
            'name.required' => 'Nama mata pelajaran wajib diisi',
            'name.unique' => 'Nama mata pelajaran sudah ada',
        ]);

        try {
            if ($this->editingId) {
                Subject::find($this->editingId)->update(['name' => $this->name]);
                session()->flash('success', 'Mata pelajaran berhasil diperbarui');
            } else {
                Subject::create(['name' => $this->name]);
                session()->flash('success', 'Mata pelajaran berhasil ditambahkan');
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

        $subject = Subject::find($this->deleteId);
        if (!$subject) {
            session()->flash('error', 'Mata pelajaran tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        // Check if used by materials or schedules
        if ($subject->materials()->count() > 0 || $subject->schedules()->count() > 0) {
            session()->flash('error', 'Tidak dapat menghapus mata pelajaran yang masih digunakan');
            $this->closeDeleteModal();
            return;
        }

        try {
            $subject->delete();
            session()->flash('success', 'Mata pelajaran berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
    }

    public function render()
    {
        $query = Subject::query();
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $subjects = $query->orderBy('name')->paginate(25);
        return view('livewire.admin.subjects', compact('subjects'))
            ->layout('layouts.admin');
    }
}
