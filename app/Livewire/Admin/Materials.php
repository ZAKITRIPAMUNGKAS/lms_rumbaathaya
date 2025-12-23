<?php

namespace App\Livewire\Admin;

use App\Models\Material;
use App\Models\Subject;
use App\Models\ClassLevel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Materials extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $subjectFilter = '';
    public $classLevelFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $title = '';
    public $description = '';
    public $subject_id = '';
    public $class_level_id = '';
    public $tutor_id = '';
    public $file;
    public $file_path = '';
    public $video_url = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSubjectFilter()
    {
        $this->resetPage();
    }

    public function updatingClassLevelFilter()
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
        $material = Material::with(['subject', 'classLevel', 'tutor'])->find($id);
        if (!$material) {
            session()->flash('error', 'Materi tidak ditemukan');
            return;
        }
        $this->editingId = $id;
        $this->title = $material->title;
        $this->description = $material->description ?? '';
        $this->subject_id = $material->subject_id;
        $this->class_level_id = $material->class_level_id;
        $this->tutor_id = $material->tutor_id ?? '';
        $this->file_path = $material->file_path ?? '';
        $this->video_url = $material->video_url ?? '';
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_level_id' => 'required|exists:class_levels,id',
            'tutor_id' => 'nullable|exists:users,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'video_url' => 'nullable|url|max:255',
        ];

        $this->validate($rules, [
            'title.required' => 'Judul wajib diisi',
            'subject_id.required' => 'Mata pelajaran wajib dipilih',
            'class_level_id.required' => 'Jenjang wajib dipilih',
            'file.mimes' => 'File harus PDF, DOC, atau DOCX',
            'file.max' => 'Ukuran file maksimal 10MB',
            'video_url.url' => 'Format URL tidak valid',
        ]);

        try {
            DB::beginTransaction();

            if ($this->editingId) {
                $material = Material::find($this->editingId);
                $updateData = [
                    'title' => $this->title,
                    'description' => $this->description ?: null,
                    'subject_id' => $this->subject_id,
                    'class_level_id' => $this->class_level_id,
                    'tutor_id' => $this->tutor_id ?: null,
                    'video_url' => $this->video_url ?: null,
                ];

                if ($this->file) {
                    if ($material->file_path) {
                        Storage::disk('public')->delete($material->file_path);
                    }
                    $updateData['file_path'] = $this->file->store('materials', 'public');
                }

                $material->update($updateData);
                session()->flash('success', 'Materi berhasil diperbarui');
            } else {
                $filePath = null;
                if ($this->file) {
                    $filePath = $this->file->store('materials', 'public');
                }

                Material::create([
                    'title' => $this->title,
                    'description' => $this->description ?: null,
                    'subject_id' => $this->subject_id,
                    'class_level_id' => $this->class_level_id,
                    'tutor_id' => $this->tutor_id ?: null,
                    'file_path' => $filePath,
                    'video_url' => $this->video_url ?: null,
                    'uploaded_by' => Auth::id(),
                ]);
                session()->flash('success', 'Materi berhasil ditambahkan');
            }

            DB::commit();
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if (!$this->deleteId)
            return;

        $material = Material::find($this->deleteId);
        if (!$material) {
            session()->flash('error', 'Materi tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        // Check for dependencies (schedules or attendances using this material)
        $schedulesCount = \App\Models\Schedule::where('material_id', $this->deleteId)->count();
        if ($schedulesCount > 0) {
            session()->flash('error', "Tidak dapat menghapus materi karena digunakan oleh {$schedulesCount} jadwal.");
            $this->closeDeleteModal();
            return;
        }

        try {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $material->delete();
            session()->flash('success', 'Materi berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->description = '';
        $this->subject_id = '';
        $this->class_level_id = '';
        $this->tutor_id = '';
        $this->file = null;
        $this->file_path = '';
        $this->video_url = '';
    }

    public function render()
    {
        $query = Material::with(['subject', 'classLevel', 'tutor', 'uploader']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->subjectFilter) {
            $query->where('subject_id', $this->subjectFilter);
        }
        if ($this->classLevelFilter) {
            $query->where('class_level_id', $this->classLevelFilter);
        }

        $materials = $query->latest()->paginate(25);
        $subjects = Subject::orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('name')->get();
        $tutors = User::where('role', 'tutor')->orderBy('name')->get();

        return view('livewire.admin.materials', compact('materials', 'subjects', 'classLevels', 'tutors'))
            ->layout('layouts.admin');
    }
}
