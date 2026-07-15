<?php

namespace App\Livewire\Tutor;

use App\Models\Material;
use App\Models\Subject;
use App\Models\ClassLevel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

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
    public $file;
    public $file_path = '';
    public $video_url = '';

    protected $paginationTheme = 'tailwind';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255|min:5',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'class_level_id' => 'required|exists:class_levels,id',
            'file' => $this->editingId ? 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,jpg,png|max:10240' : 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,jpg,png|max:10240', // Max 10MB
            'video_url' => 'nullable|url',
        ];
    }

    protected $messages = [
        'title.required' => 'Judul materi wajib diisi.',
        'title.min' => 'Judul materi minimal 5 karakter.',
        'subject_id.required' => 'Pilih mata pelajaran.',
        'class_level_id.required' => 'Pilih tingkatan kelas.',
        'file.required' => 'File modul materi wajib diunggah.',
        'file.mimes' => 'Format file harus berupa PDF, Word, PowerPoint, ZIP, atau Gambar.',
        'file.max' => 'Ukuran file maksimal adalah 10MB.',
        'video_url.url' => 'Format link video pembelajaran tidak valid.',
    ];

    public function mount()
    {
        $this->resetForm();
    }

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
        $material = Material::where('uploaded_by', auth()->id())->find($id);
        if (!$material) {
            session()->flash('error', 'Materi tidak ditemukan atau Anda tidak berwenang.');
            return;
        }

        $this->resetValidation();
        $this->editingId = $id;
        $this->title = $material->title;
        $this->description = $material->description ?? '';
        $this->subject_id = $material->subject_id;
        $this->class_level_id = $material->class_level_id;
        $this->file_path = $material->file_path;
        $this->video_url = $material->video_url ?? '';
        $this->file = null;
        
        $this->showModal = true;
    }

    public function confirmDelete($id)
    {
        $material = Material::where('uploaded_by', auth()->id())->find($id);
        if (!$material) {
            session()->flash('error', 'Materi tidak ditemukan atau Anda tidak berwenang.');
            return;
        }
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $material = Material::where('uploaded_by', auth()->id())->find($this->deleteId);
        if ($material) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $material->delete();
            session()->flash('success', 'Materi berhasil dihapus.');
        }

        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description ?: null,
            'subject_id' => $this->subject_id,
            'class_level_id' => $this->class_level_id,
            'uploaded_by' => auth()->id(),
            'video_url' => $this->video_url ?: null,
        ];

        // Handle File Upload
        if ($this->file) {
            if ($this->editingId && $this->file_path) {
                Storage::disk('public')->delete($this->file_path);
            }
            $fileName = time() . '_' . $this->file->getClientOriginalName();
            $path = $this->file->storeAs('materials', $fileName, 'public');
            $data['file_path'] = $path;
        }

        if ($this->editingId) {
            Material::where('uploaded_by', auth()->id())->find($this->editingId)->update($data);
            session()->flash('success', 'Materi berhasil diperbarui.');
        } else {
            Material::create($data);
            session()->flash('success', 'Materi pembelajaran baru berhasil diunggah.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->description = '';
        $this->subject_id = '';
        $this->class_level_id = '';
        $this->file = null;
        $this->file_path = '';
        $this->video_url = '';
        $this->resetValidation();
    }

    public function render()
    {
        $tutorId = auth()->id();

        $materials = Material::where('uploaded_by', $tutorId)
            ->with(['subject', 'classLevel'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->subjectFilter, function ($query) {
                $query->where('subject_id', $this->subjectFilter);
            })
            ->when($this->classLevelFilter, function ($query) {
                $query->where('class_level_id', $this->classLevelFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $subjects = Subject::orderBy('name', 'asc')->get();
        $classLevels = ClassLevel::orderBy('name', 'asc')->get();

        return view('livewire.tutor.materials', [
            'materials' => $materials,
            'subjects' => $subjects,
            'classLevels' => $classLevels
        ]);
    }
}
