<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistrationFormController extends Controller
{
    /**
     * Show the registration form
     */
    public function index()
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl . '/pendaftaran');
    }

    /**
     * Store registration data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'address' => 'required|string',
            'school_name' => 'required|string|max:255',
            'program' => 'required|in:Calistung (TK-SD Kelas 1),MAPEL SD,MAPEL SMP,MAPEL SMA,Tahfidz,Yang lain',
            'program_other' => 'nullable|required_if:program,Yang lain|string|max:255',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:10240', // 10MB max
            'email' => 'nullable|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'nickname.required' => 'Nama panggilan wajib diisi',
            'birth_place.required' => 'Tempat lahir wajib diisi',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'school_name.required' => 'Asal sekolah wajib diisi',
            'program.required' => 'Program berprestasi wajib dipilih',
            'program_other.required_if' => 'Silakan isi program lainnya',
            'photo.required' => 'Foto Ananda wajib diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'photo.max' => 'Ukuran foto maksimal 10 MB',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain atau login',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = Str::slug($validated['full_name']) . '-' . time() . '.' . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('registrations/photos', $photoName, 'public');
            $validated['photo'] = $photoPath;
        }

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Create registration
        $registration = Registration::create($validated);

        // Create user account for login (if email provided)
        if (!empty($validated['email'])) {
            try {
                $user = User::create([
                    'name' => $validated['full_name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role' => 'student',
                ]);

                // Link registration to user (optional, bisa ditambahkan user_id di registrations table jika diperlukan)
            } catch (\Exception $e) {
                // If user creation fails, continue with registration anyway
                \Log::warning('Failed to create user account for registration: ' . $e->getMessage());
            }
        }

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl . '/pendaftaran/berhasil/' . $registration->id)
            ->with('success', 'Pendaftaran berhasil dikirim! Kami akan menghubungi Anda segera.');
    }

    /**
     * Show success page
     */
    public function success($id)
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
        return redirect($frontendUrl . '/pendaftaran/berhasil/' . $id);
    }
}

