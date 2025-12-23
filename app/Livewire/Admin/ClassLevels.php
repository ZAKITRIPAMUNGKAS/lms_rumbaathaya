<?php

namespace App\Livewire\Admin;

use App\Models\ClassLevel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ClassLevels extends Component
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
        $classLevel = ClassLevel::find($id);
        if (!$classLevel) {
            session()->flash('error', 'Jenjang tidak ditemukan');
            return;
        }
        $this->editingId = $id;
        $this->name = $classLevel->name;
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
            $rules['name'][] = Rule::unique('class_levels', 'name')->ignore($this->editingId);
        } else {
            $rules['name'][] = 'unique:class_levels,name';
        }

        $this->validate($rules, [
            'name.required' => 'Nama jenjang wajib diisi',
            'name.unique' => 'Nama jenjang sudah ada',
        ]);

        try {
            if ($this->editingId) {
                ClassLevel::find($this->editingId)->update(['name' => $this->name]);
                session()->flash('success', 'Jenjang berhasil diperbarui');
            } else {
                ClassLevel::create(['name' => $this->name]);
                session()->flash('success', 'Jenjang berhasil ditambahkan');
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

        $classLevel = ClassLevel::find($this->deleteId);
        if (!$classLevel) {
            session()->flash('error', 'Jenjang tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        // Check if used by students
        if ($classLevel->students()->count() > 0) {
            session()->flash('error', 'Tidak dapat menghapus jenjang yang masih digunakan oleh siswa');
            $this->closeDeleteModal();
            return;
        }

        try {
            $classLevel->delete();
            session()->flash('success', 'Jenjang berhasil dihapus');
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
        $query = ClassLevel::query();
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $classLevels = $query->orderBy('name')->paginate(25);
        return view('livewire.admin.class-levels', compact('classLevels'))
            ->layout('layouts.admin');
    }
}
