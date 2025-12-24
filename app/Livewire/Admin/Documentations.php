<?php

namespace App\Livewire\Admin;

use App\Models\Documentation;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Documentations extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $typeFilter = '';
    public $categoryFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $title = '';
    public $type = 'photo';
    public $category = '';
    public $description = '';
    public $event_date = '';
    public $file;
    public $file_path = '';
    public $video_url = '';
    public $thumbnail;
    public $thumbnail_path = '';
    public $is_published = true;
    public $sort_order = 0;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function getStatsProperty()
    {
        return [
            'total' => Documentation::count(),
            'photos' => Documentation::where('type', 'photo')->count(),
            'videos' => Documentation::where('type', 'video')->count(),
            'quotes' => Documentation::where('type', 'quotes')->count(),
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
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
        $doc = Documentation::find($id);

        if (!$doc) {
            session()->flash('error', 'Dokumentasi tidak ditemukan');
            return;
        }

        $this->editingId = $id;
        $this->title = $doc->title;
        $this->type = $doc->type;
        $this->category = $doc->category ?? '';
        $this->description = $doc->description ?? '';
        $this->event_date = $doc->event_date ? $doc->event_date->format('Y-m-d') : '';
        $this->file_path = $doc->file_path ?? '';
        $this->video_url = $doc->video_url ?? '';
        $this->thumbnail_path = $doc->thumbnail_path ?? '';
        $this->is_published = $doc->is_published;
        $this->sort_order = $doc->sort_order;
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
            'type' => 'required|in:photo,video,quotes',
            'category' => 'nullable|string',
            'description' => 'nullable|string|max:500',
            'event_date' => 'nullable|date',
        ];

        if ($this->type === 'video') {
            $rules['video_url'] = 'required|url';
        } else {
            $rules['file'] = 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120';
        }

        $validated = $this->validate($rules, [
            'title.required' => 'Judul wajib diisi',
            'type.required' => 'Tipe wajib dipilih',
            'video_url.required' => 'URL video wajib diisi',
            'video_url.url' => 'Format URL tidak valid',
            'file.image' => 'File harus berupa gambar',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            if ($this->editingId) {
                $doc = Documentation::find($this->editingId);

                // Handle file upload
                if ($this->file) {
                    if ($doc->file_path) {
                        Storage::disk('public')->delete($doc->file_path);
                    }
                    $this->file_path = $this->file->store('documentations', 'public');
                }

                // Handle thumbnail
                if ($this->thumbnail) {
                    if ($doc->thumbnail_path) {
                        Storage::disk('public')->delete($doc->thumbnail_path);
                    }
                    $this->thumbnail_path = $this->thumbnail->store('documentations/thumbnails', 'public');
                }

                $doc->update([
                    'title' => $validated['title'],
                    'type' => $validated['type'],
                    'category' => $this->category ?: null,
                    'description' => $this->description ?: null,
                    'event_date' => $this->event_date ?: null,
                    'file_path' => $this->file_path ?: $doc->file_path,
                    'video_url' => $this->video_url ?: null,
                    'thumbnail_path' => $this->thumbnail_path ?: $doc->thumbnail_path,
                    'is_published' => $this->is_published,
                    'sort_order' => $this->sort_order,
                ]);

                session()->flash('success', 'Dokumentasi berhasil diperbarui');
            } else {
                // Create new
                if ($this->file) {
                    $this->file_path = $this->file->store('documentations', 'public');
                }

                if ($this->thumbnail) {
                    $this->thumbnail_path = $this->thumbnail->store('documentations/thumbnails', 'public');
                }

                Documentation::create([
                    'title' => $validated['title'],
                    'type' => $validated['type'],
                    'category' => $this->category ?: null,
                    'description' => $this->description ?: null,
                    'event_date' => $this->event_date ?: null,
                    'file_path' => $this->file_path,
                    'video_url' => $this->video_url ?: null,
                    'thumbnail_path' => $this->thumbnail_path,
                    'is_published' => $this->is_published,
                    'sort_order' => $this->sort_order,
                ]);

                session()->flash('success', 'Dokumentasi berhasil ditambahkan');
            }

            $this->closeModal();
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if (!$this->deleteId) {
            return;
        }

        $doc = Documentation::find($this->deleteId);

        if (!$doc) {
            session()->flash('error', 'Dokumentasi tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        try {
            if ($doc->file_path) {
                Storage::disk('public')->delete($doc->file_path);
            }
            if ($doc->thumbnail_path) {
                Storage::disk('public')->delete($doc->thumbnail_path);
            }

            $doc->delete();

            session()->flash('success', 'Dokumentasi berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus dokumentasi: ' . $e->getMessage());
        }
    }

    public function togglePublish($id)
    {
        $doc = Documentation::find($id);
        if ($doc) {
            $doc->update(['is_published' => !$doc->is_published]);
            session()->flash('success', 'Status publikasi berhasil diubah');
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->type = 'photo';
        $this->category = '';
        $this->description = '';
        $this->event_date = '';
        $this->file = null;
        $this->file_path = '';
        $this->video_url = '';
        $this->thumbnail = null;
        $this->thumbnail_path = '';
        $this->is_published = true;
        $this->sort_order = 0;
    }

    public function render()
    {
        $query = Documentation::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }

        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        $documentations = $query->orderBy('sort_order')->latest()->paginate(25);

        return view('livewire.admin.documentations', [
            'documentations' => $documentations,
        ])->layout('layouts.admin');
    }
}
