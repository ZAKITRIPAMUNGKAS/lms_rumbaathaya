<?php

namespace App\Livewire\Tutor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.tutor')]
class Settings extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone_number;
    public $photo;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:1024',
        ]);

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;

        if ($this->photo) {
            $path = $this->photo->store('avatars', 'public');
            $user->avatar_url = $path;
        }

        $user->save();

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
        return view('livewire.tutor.settings');
    }
}
