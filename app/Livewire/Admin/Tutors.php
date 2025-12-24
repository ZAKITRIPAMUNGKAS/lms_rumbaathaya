<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Tutors extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $bio = '';
    public $avatar;
    public $avatar_url = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function getStatsProperty()
    {
        return [
            'total' => User::where('role', 'tutor')->count(),
            'active' => User::where('role', 'tutor')->count(), // Assuming all are active for now
            'new' => User::where('role', 'tutor')->where('created_at', '>=', now()->subDays(30))->count(),
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
        $tutor = User::where('role', 'tutor')->find($id);

        if (!$tutor) {
            session()->flash('error', 'Tutor tidak ditemukan');
            return;
        }

        $this->editingId = $id;
        $this->name = $tutor->name;
        $this->email = $tutor->email;
        $this->password = '';
        $this->bio = $tutor->bio ?? '';
        $this->avatar_url = $tutor->avatar_url ?? '';
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
            'email' => ['required', 'email', 'max:255'],
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ];

        if ($this->editingId) {
            $rules['email'][] = Rule::unique('users')->ignore($this->editingId);
            if ($this->password) {
                $rules['password'] = 'nullable|string|min:8';
            }
        } else {
            $rules['email'][] = 'unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }

        $validated = $this->validate($rules, [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'avatar.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        try {
            if ($this->editingId) {
                // Update existing tutor
                $tutor = User::where('role', 'tutor')->find($this->editingId);

                $userData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'bio' => $this->bio ?: null,
                ];

                if ($this->password) {
                    $userData['password'] = Hash::make($validated['password']);
                }

                // Handle avatar
                if ($this->avatar) {
                    // Delete old avatar
                    if ($tutor->avatar_url) {
                        // Use getRawOriginal to bypass accessor and get the real path
                        Storage::disk('public')->delete($tutor->getRawOriginal('avatar_url'));
                    }
                    $userData['avatar_url'] = $this->avatar->store('avatars', 'public');
                }

                $tutor->update($userData);
                session()->flash('success', 'Data tutor berhasil diperbarui');
            } else {
                // Create new tutor
                $avatarPath = null;
                if ($this->avatar) {
                    $avatarPath = $this->avatar->store('avatars', 'public');
                }

                User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'tutor',
                    'bio' => $this->bio ?: null,
                    'avatar_url' => $avatarPath,
                ]);

                session()->flash('success', 'Tutor berhasil ditambahkan');
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

        $tutor = User::where('role', 'tutor')->find($this->deleteId);

        if (!$tutor) {
            session()->flash('error', 'Tutor tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        // Check for active schedules
        $activeSchedulesCount = \App\Models\Schedule::where('tutor_id', $this->deleteId)
            ->where('is_active', true)
            ->count();

        if ($activeSchedulesCount > 0) {
            session()->flash('error', "Tidak dapat menghapus tutor karena memiliki {$activeSchedulesCount} jadwal aktif.");
            $this->closeDeleteModal();
            return;
        }

        try {
            // Delete avatar
            if ($tutor->avatar_url) {
                // Use getRawOriginal to bypass accessor and get the real path
                Storage::disk('public')->delete($tutor->getRawOriginal('avatar_url'));
            }

            $tutor->delete();
            session()->flash('success', 'Tutor berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus tutor: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->bio = '';
        $this->avatar = null;
        $this->avatar_url = '';
    }

    public function render()
    {
        $query = User::where('role', 'tutor');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('bio', 'like', '%' . $this->search . '%');
            });
        }

        $tutors = $query->latest()->paginate(25);

        return view('livewire.admin.tutors', [
            'tutors' => $tutors,
        ])->layout('layouts.admin');
    }
}
