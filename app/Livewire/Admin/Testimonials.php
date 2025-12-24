<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Testimonials extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $name = '';
    public $role = '';
    public $content = '';
    public $rating = 5;
    public $photo;
    public $photo_path = '';
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
            'total' => Testimonial::count(),
            'published' => Testimonial::where('is_published', true)->count(),
            'unpublished' => Testimonial::where('is_published', false)->count(),
        ];
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
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            session()->flash('error', 'Testimoni tidak ditemukan');
            return;
        }

        $this->editingId = $id;
        $this->name = $testimonial->name;
        $this->role = $testimonial->role ?? '';
        $this->content = $testimonial->content;
        $this->rating = $testimonial->rating;
        $this->photo_path = $testimonial->photo_path ?? '';
        $this->is_published = $testimonial->is_published;
        $this->sort_order = $testimonial->sort_order;
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
            'name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ];

        $validated = $this->validate($rules, [
            'name.required' => 'Nama wajib diisi',
            'content.required' => 'Isi testimoni wajib diisi',
            'content.max' => 'Isi testimoni maksimal 1000 karakter',
            'rating.required' => 'Rating wajib dipilih',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            if ($this->editingId) {
                // Update existing testimonial
                $testimonial = Testimonial::find($this->editingId);

                // Handle photo
                if ($this->photo) {
                    // Delete old photo
                    if ($testimonial->photo_path) {
                        Storage::disk('public')->delete($testimonial->photo_path);
                    }
                    $this->photo_path = $this->photo->store('testimonials/photos', 'public');
                }

                $testimonial->update([
                    'name' => $validated['name'],
                    'role' => $this->role ?: null,
                    'content' => $validated['content'],
                    'rating' => $validated['rating'],
                    'photo_path' => $this->photo_path ?: $testimonial->photo_path,
                    'is_published' => $this->is_published,
                    'sort_order' => $this->sort_order,
                ]);

                session()->flash('success', 'Testimoni berhasil diperbarui');
            } else {
                // Create new testimonial
                if ($this->photo) {
                    $this->photo_path = $this->photo->store('testimonials/photos', 'public');
                }

                Testimonial::create([
                    'name' => $validated['name'],
                    'role' => $this->role ?: null,
                    'content' => $validated['content'],
                    'rating' => $validated['rating'],
                    'photo_path' => $this->photo_path,
                    'is_published' => $this->is_published,
                    'sort_order' => $this->sort_order,
                ]);

                session()->flash('success', 'Testimoni berhasil ditambahkan');
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

        $testimonial = Testimonial::find($this->deleteId);

        if (!$testimonial) {
            session()->flash('error', 'Testimoni tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        try {
            // Delete photo
            if ($testimonial->photo_path) {
                Storage::disk('public')->delete($testimonial->photo_path);
            }

            $testimonial->delete();

            session()->flash('success', 'Testimoni berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus testimoni: ' . $e->getMessage());
        }
    }

    public function togglePublish($id)
    {
        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $testimonial->update(['is_published' => !$testimonial->is_published]);
            session()->flash('success', 'Status publikasi berhasil diubah');
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->role = '';
        $this->content = '';
        $this->rating = 5;
        $this->photo = null;
        $this->photo_path = '';
        $this->is_published = true;
        $this->sort_order = 0;
    }

    public function render()
    {
        $query = Testimonial::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('role', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        $testimonials = $query->orderBy('sort_order')->latest()->paginate(25);

        return view('livewire.admin.testimonials', [
            'testimonials' => $testimonials,
        ])->layout('layouts.admin');
    }
}
