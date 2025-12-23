<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Posts extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $categoryFilter = '';
    public $statusFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $title = '';
    public $slug = '';
    public $category = '';
    public $content = '';
    public $thumbnail;
    public $thumbnail_path = '';
    public $is_published = false;
    public $published_at = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedTitle()
    {
        if (!$this->editingId) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->published_at = now()->format('Y-m-d\TH:i');
        $this->showModal = true;

        // Dispatch event to initialize Summernote editor
        $this->dispatch('modalOpened');
    }

    public function openEditModal($id)
    {
        $post = Post::find($id);
        if (!$post) {
            session()->flash('error', 'Artikel tidak ditemukan');
            return;
        }
        $this->editingId = $id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->category = $post->category ?? '';
        $this->content = $post->content ?? '';
        $this->thumbnail_path = $post->thumbnail ?? '';
        $this->is_published = $post->is_published;
        $this->published_at = $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '';
        $this->showModal = true;

        // Dispatch event to populate Summernote editor
        $this->dispatch('modalOpened');
        $this->dispatch('contentUpdated', content: $this->content);
    }

    public function openDeleteModal($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function closeModal()
    {
        // Dispatch event to destroy Summernote editor
        $this->dispatch('modalClosed');

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
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ], [
            'title.required' => 'Judul wajib diisi',
            'slug.required' => 'Slug wajib diisi',
            'thumbnail.image' => 'File harus berupa gambar',
            'thumbnail.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'thumbnail.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Ensure slug is unique
        if ($this->editingId) {
            $existingPost = Post::where('slug', $this->slug)->where('id', '!=', $this->editingId)->first();
        } else {
            $existingPost = Post::where('slug', $this->slug)->first();
        }

        if ($existingPost) {
            $this->addError('slug', 'Slug sudah digunakan');
            return;
        }

        try {
            if ($this->editingId) {
                $post = Post::find($this->editingId);
                $updateData = [
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'category' => $this->category ?: null,
                    'content' => $this->content ?: null,
                    'is_published' => $this->is_published,
                    'published_at' => $this->published_at ? now()->parse($this->published_at) : null,
                ];

                if ($this->thumbnail) {
                    if ($post->thumbnail) {
                        Storage::disk('public')->delete($post->thumbnail);
                    }
                    $updateData['thumbnail'] = $this->thumbnail->store('posts/thumbnails', 'public');
                }

                $post->update($updateData);
                session()->flash('success', 'Artikel berhasil diperbarui');
            } else {
                $thumbnailPath = null;
                if ($this->thumbnail) {
                    $thumbnailPath = $this->thumbnail->store('posts/thumbnails', 'public');
                }

                Post::create([
                    'title' => $this->title,
                    'slug' => $this->slug,
                    'category' => $this->category ?: null,
                    'content' => $this->content ?: null,
                    'thumbnail' => $thumbnailPath,
                    'is_published' => $this->is_published,
                    'published_at' => $this->published_at ? now()->parse($this->published_at) : null,
                ]);
                session()->flash('success', 'Artikel berhasil ditambahkan');
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

        $post = Post::find($this->deleteId);
        if (!$post) {
            session()->flash('error', 'Artikel tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        try {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $post->delete();
            session()->flash('success', 'Artikel berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->slug = '';
        $this->category = '';
        $this->content = '';
        $this->thumbnail = null;
        $this->thumbnail_path = '';
        $this->is_published = false;
        $this->published_at = '';
    }

    public function render()
    {
        $query = Post::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }
        if ($this->statusFilter !== '') {
            $query->where('is_published', $this->statusFilter === '1');
        }

        $posts = $query->latest('published_at')->paginate(25);
        $categories = Post::distinct()->whereNotNull('category')->pluck('category');

        return view('livewire.admin.posts', compact('posts', 'categories'))
            ->layout('layouts.admin');
    }
}
