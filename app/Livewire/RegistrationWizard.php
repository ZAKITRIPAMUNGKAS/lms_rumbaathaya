<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Student;
use App\Models\Registration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

#[Layout('layouts.guest')]
class RegistrationWizard extends Component
{
    use WithFileUploads;

    // Step 1: Biodata
    public $name = '';
    public $nickname = '';
    public $dateOfBirth = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $whatsapp_number = '';
    public $parent_phone = '';

    // Step 2: Program Selection
    public $selectedProgram = null;

    // Step 3: Photo
    public $photo;
    public $photoPreview = null;

    // Current step
    public $currentStep = 1;

    // State
    public $isSubmitting = false;
    public $isSuccess = false;
    public $submitError = null; // Changed from $errors to avoid conflict with Laravel's ViewErrorBag

    public const PROGRAMS = [
        'calistung-tk' => ['name' => 'Calistung TK', 'icon' => '📚', 'description' => 'Baca Tulis Hitung'],
        'sd-kelas-1-3' => ['name' => 'SD Kelas 1-3', 'icon' => '🎓', 'description' => 'Fondasi Juara'],
        'sd-kelas-4-6' => ['name' => 'SD Kelas 4-6', 'icon' => '🏆', 'description' => 'Persiapan SMP'],
        'smp-kelas-7-9' => ['name' => 'SMP Kelas 7-9', 'icon' => '📖', 'description' => 'Siap SMA Favorit'],
        'kelas-tahfidz' => ['name' => 'Kelas Tahfidz', 'icon' => '📿', 'description' => 'Hafalan & Tahsin'],
    ];

    public const STEPS = [
        ['number' => 1, 'title' => 'Biodata', 'description' => 'Informasi dasar', 'icon' => 'ph-user'],
        ['number' => 2, 'title' => 'Program', 'description' => 'Pilih program', 'icon' => 'ph-graduation-cap'],
        ['number' => 3, 'title' => 'Foto', 'description' => 'Upload foto', 'icon' => 'ph-camera'],
        ['number' => 4, 'title' => 'Review', 'description' => 'Periksa data', 'icon' => 'ph-clipboard-text'],
    ];

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:5120', // 5MB max
        ], [
            'photo.image' => 'File harus berupa gambar',
            'photo.max' => 'Ukuran foto maksimal 5MB',
        ]);

        if ($this->photo) {
            $this->photoPreview = $this->photo->temporaryUrl();
        }
    }

    public function removePhoto()
    {
        $this->photo = null;
        $this->photoPreview = null;
        $this->resetValidation('photo');
    }

    public function validateStep($step)
    {
        $this->resetValidation();

        if ($step === 1) {
            $this->validate([
                'name' => 'required|string|max:255',
                'nickname' => 'required|string|max:255',
                'dateOfBirth' => 'required|date|before:today',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'parent_phone' => 'required|string|max:20',
                'whatsapp_number' => 'nullable|string|max:20',
            ], [
                'name.required' => 'Nama lengkap wajib diisi',
                'nickname.required' => 'Nama panggilan wajib diisi',
                'dateOfBirth.required' => 'Tanggal lahir wajib diisi',
                'dateOfBirth.before' => 'Tanggal lahir harus sebelum hari ini',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 8 karakter',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'parent_phone.required' => 'Nomor orang tua/wali wajib diisi',
            ]);

            return true;
        }

        if ($step === 2) {
            $this->validate([
                'selectedProgram' => 'required|string|in:' . implode(',', array_keys(self::PROGRAMS)),
            ], [
                'selectedProgram.required' => 'Pilih program terlebih dahulu',
            ]);

            return true;
        }

        if ($step === 3) {
            $this->validate([
                'photo' => 'required|image|max:5120',
            ], [
                'photo.required' => 'Upload foto terlebih dahulu',
                'photo.image' => 'File harus berupa gambar',
                'photo.max' => 'Ukuran foto maksimal 5MB',
            ]);

            return true;
        }

        return true;
    }

    public function nextStep()
    {
        if ($this->validateStep($this->currentStep)) {
            if ($this->currentStep < 4) {
                $this->currentStep++;
            }
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->resetValidation();
        }
    }

    public function submit()
    {
        if (!$this->validateStep(4)) {
            return;
        }

        $this->isSubmitting = true;
        $this->resetValidation();

        try {
            // Create user
            $user = User::create([
                'name' => $this->name,
                'email' => strtolower(trim($this->email)),
                'password' => Hash::make($this->password),
                'role' => 'student',
            ]);

            // Handle photo upload
            $photoPath = null;
            if ($this->photo) {
                $photoPath = $this->photo->store('avatars', 'public');
            }

            // Get class_level_id based on program (default to first class level if not found)
            $classLevelId = \App\Models\ClassLevel::first()?->id ?? 1;

            // Create student profile
            $studentData = [
                'user_id' => $user->id,
                'name' => $this->name,
                'nickname' => $this->nickname,
                'date_of_birth' => $this->dateOfBirth,
                'parent_phone' => $this->parent_phone,
                'program_interest' => self::PROGRAMS[$this->selectedProgram]['name'] ?? $this->selectedProgram,
                'class_level_id' => $classLevelId,
            ];

            // Add whatsapp_number if provided (field added via migration)
            if ($this->whatsapp_number) {
                $studentData['whatsapp_number'] = $this->whatsapp_number;
            }

            if ($photoPath) {
                $studentData['profile_photo_path'] = $photoPath;
            }

            $student = Student::create($studentData);

            // Also create a Registration record for tracking
            Registration::create([
                'user_id' => $user->id,
                'full_name' => $this->name,
                'nickname' => $this->nickname,
                'birth_date' => $this->dateOfBirth,
                'email' => $this->email,
                'phone' => $this->parent_phone,
                'whatsapp_number' => $this->whatsapp_number,
                'program' => self::PROGRAMS[$this->selectedProgram]['name'] ?? $this->selectedProgram,
                'photo' => $photoPath,
                'status' => 'approved', // Auto-approved since user is created
            ]);

            // Auto-login
            Auth::login($user);

            // Success
            $this->isSuccess = true;
            $this->isSubmitting = false;

            // Dispatch browser event for confetti (handled in view)
            $this->dispatch('registration-success');

            // Auto-redirect to student dashboard after 3 seconds
            $this->dispatch('redirect-to-dashboard');

        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            $this->submitError = 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';
            $this->isSubmitting = false;
        }
    }

    public function render()
    {
        return view('livewire.registration-wizard');
    }
}
