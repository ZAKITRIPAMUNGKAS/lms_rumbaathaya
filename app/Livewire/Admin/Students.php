<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class Students extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $classLevelFilter = '';
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingId = null;
    public $deleteId = null;

    // Form fields
    public $name = '';
    public $nickname = '';
    public $email = '';
    public $password = '';
    public $place_of_birth = '';
    public $date_of_birth = '';
    public $address = '';
    public $school_origin = '';
    public $class_level_id = '';
    public $program_interest = '';
    public $parent_phone = '';
    public $profile_photo;
    public $profile_photo_path = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetForm();
    }

    public function getStatsProperty()
    {
        return [
            'total' => Student::count(),
            'active' => Student::whereHas('schedules', function ($q) {
                $q->where('is_active', true);
            })->count(),
            'new' => Student::where('created_at', '>=', now()->subDays(30))->count(),
        ];
    }

    public function updatingSearch()
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
        $student = Student::with(['user', 'classLevel'])->find($id);

        if (!$student) {
            session()->flash('error', 'Siswa tidak ditemukan');
            return;
        }

        $this->editingId = $id;
        $this->name = $student->name;
        $this->nickname = $student->nickname ?? '';
        $this->email = $student->user->email ?? '';
        $this->password = '';
        $this->place_of_birth = $student->place_of_birth ?? '';
        $this->date_of_birth = $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '';
        $this->address = $student->address ?? '';
        $this->school_origin = $student->school_origin;
        $this->class_level_id = $student->class_level_id;
        $this->program_interest = $student->program_interest ?? '';
        $this->parent_phone = $student->parent_phone ?? '';
        $this->profile_photo_path = $student->profile_photo_path ?? '';
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
            'school_origin' => 'required|string|max:255',
            'class_level_id' => 'required|exists:class_levels,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ];

        if ($this->editingId) {
            $student = Student::find($this->editingId);
            $rules['email'][] = Rule::unique('users')->ignore($student->user_id);
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
            'school_origin.required' => 'Sekolah asal wajib diisi',
            'class_level_id.required' => 'Jenjang kelas wajib dipilih',
            'class_level_id.exists' => 'Jenjang kelas tidak valid',
            'profile_photo.image' => 'File harus berupa gambar',
            'profile_photo.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'profile_photo.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        try {
            DB::beginTransaction();

            if ($this->editingId) {
                // Update existing student
                $student = Student::find($this->editingId);

                // Update user
                $userData = [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ];

                if ($this->password) {
                    $userData['password'] = Hash::make($validated['password']);
                }

                $student->user->update($userData);

                // Handle profile photo
                if ($this->profile_photo) {
                    // Delete old photo
                    if ($student->profile_photo_path) {
                        Storage::disk('public')->delete($student->profile_photo_path);
                    }
                    $this->profile_photo_path = $this->profile_photo->store('student-photos', 'public');
                }

                // Update student
                $student->update([
                    'name' => $validated['name'],
                    'nickname' => $this->nickname ?: null,
                    'place_of_birth' => $this->place_of_birth ?: null,
                    'date_of_birth' => $this->date_of_birth ?: null,
                    'address' => $this->address ?: null,
                    'school_origin' => $validated['school_origin'],
                    'class_level_id' => $validated['class_level_id'],
                    'program_interest' => $this->program_interest ?: null,
                    'parent_phone' => $this->parent_phone ?: null,
                    'profile_photo_path' => $this->profile_photo_path ?: $student->profile_photo_path,
                ]);

                session()->flash('success', 'Data siswa berhasil diperbarui');
            } else {
                // Create new student
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'student',
                ]);

                // Handle profile photo
                if ($this->profile_photo) {
                    $this->profile_photo_path = $this->profile_photo->store('student-photos', 'public');
                }

                Student::create([
                    'user_id' => $user->id,
                    'name' => $validated['name'],
                    'nickname' => $this->nickname ?: null,
                    'place_of_birth' => $this->place_of_birth ?: null,
                    'date_of_birth' => $this->date_of_birth ?: null,
                    'address' => $this->address ?: null,
                    'school_origin' => $validated['school_origin'],
                    'class_level_id' => $validated['class_level_id'],
                    'program_interest' => $this->program_interest ?: null,
                    'parent_phone' => $this->parent_phone ?: null,
                    'profile_photo_path' => $this->profile_photo_path,
                ]);

                session()->flash('success', 'Siswa berhasil ditambahkan');
            }

            DB::commit();
            $this->closeModal();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if (!$this->deleteId) {
            return;
        }

        $student = Student::find($this->deleteId);

        if (!$student) {
            session()->flash('error', 'Siswa tidak ditemukan');
            $this->closeDeleteModal();
            return;
        }

        // Check for active schedules
        $activeSchedulesCount = \App\Models\Schedule::where('student_id', $this->deleteId)
            ->where('is_active', true)
            ->count();

        if ($activeSchedulesCount > 0) {
            session()->flash('error', "Tidak dapat menghapus siswa karena memiliki {$activeSchedulesCount} jadwal aktif.");
            $this->closeDeleteModal();
            return;
        }

        // Check for attendances
        $attendancesCount = \App\Models\Attendance::where('student_id', $this->deleteId)->count();
        if ($attendancesCount > 0) {
            session()->flash('error', "Tidak dapat menghapus siswa karena memiliki {$attendancesCount} data kehadiran.");
            $this->closeDeleteModal();
            return;
        }

        try {
            // Delete profile photo
            if ($student->profile_photo_path) {
                Storage::disk('public')->delete($student->profile_photo_path);
            }

            $userId = $student->user_id;
            $student->delete();

            // Delete user account
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    if ($user->avatar_url) {
                        Storage::disk('public')->delete($user->avatar_url);
                    }
                    $user->delete();
                }
            }

            session()->flash('success', 'Siswa berhasil dihapus');
            $this->closeDeleteModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->nickname = '';
        $this->email = '';
        $this->password = '';
        $this->place_of_birth = '';
        $this->date_of_birth = '';
        $this->address = '';
        $this->school_origin = '';
        $this->class_level_id = '';
        $this->program_interest = '';
        $this->parent_phone = '';
        $this->profile_photo = null;
        $this->profile_photo_path = '';
    }

    public function render()
    {
        $query = Student::with(['user', 'classLevel']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('nickname', 'like', '%' . $this->search . '%')
                    ->orWhere('school_origin', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('email', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->classLevelFilter) {
            $query->where('class_level_id', $this->classLevelFilter);
        }

        $students = $query->latest()->paginate(25);
        $classLevels = ClassLevel::orderBy('name')->get();

        return view('livewire.admin.students', [
            'students' => $students,
            'classLevels' => $classLevels,
        ])->layout('layouts.admin');
    }
}
