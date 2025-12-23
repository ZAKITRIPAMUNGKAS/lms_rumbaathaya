<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Student;

class Settings extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $nickname;
    public $whatsapp_number;
    public $parent_phone;
    public $address;
    public $photo;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $student = $user->student;

        $this->name = $user->name;
        $this->email = $user->email;

        if ($student) {
            $this->nickname = $student->nickname;
            $this->whatsapp_number = $student->whatsapp_number;
            $this->parent_phone = $student->parent_phone;
            $this->address = $student->address;
        }
    }

    public function updateProfile()
    {
        $user = Auth::user();
        $student = $user->student;

        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nickname' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:20',
            'parent_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|max:1024',
        ]);

        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            $user->avatar_url = $path;
        }

        $user->save();

        if ($student) {
            $updateData = [
                'name' => $this->name,
                'nickname' => $this->nickname,
                'whatsapp_number' => $this->whatsapp_number,
                'parent_phone' => $this->parent_phone,
                'address' => $this->address,
            ];

            if ($this->photo) {
                $updateData['profile_photo_path'] = $path;
            }

            $student->update($updateData);
        }

        session()->flash('success', 'Profil berhasil diperbarui.');
        $this->dispatch('profile-updated');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success_password', 'Password berhasil diubah.');
    }

    public function render()
    {
        return view('livewire.student.settings')
            ->layout('layouts.student');
    }
}
