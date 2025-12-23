<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Store registration data
     */
    public function store(Request $request): JsonResponse
    {
        // Map program names from frontend to database enum values
        $programMapping = [
            'Calistung TK' => 'Calistung (TK-SD Kelas 1)',
            'SD Kelas 1-3' => 'MAPEL SD',
            'SD Kelas 4-6' => 'MAPEL SD',
            'SMP Kelas 7-9' => 'MAPEL SMP',
            'Kelas Tahfidz' => 'Tahfidz',
        ];

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'program' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:10240', // 10MB max
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'whatsapp_number' => 'nullable|string|max:20',
            'parent_phone' => 'required|string|max:20',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi',
            'nickname.required' => 'Nama panggilan wajib diisi',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'program.required' => 'Program wajib dipilih',
            'photo.required' => 'Foto wajib diupload',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'photo.max' => 'Ukuran foto maksimal 10 MB',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain atau login',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'parent_phone.required' => 'Nomor orang tua/wali wajib diisi',
        ]);

        try {
            DB::beginTransaction();

            // Map program to database enum value
            $programValue = $programMapping[$validated['program']] ?? $validated['program'];
            
            // Validate program is in allowed enum values
            $allowedPrograms = [
                'Calistung (TK-SD Kelas 1)',
                'MAPEL SD',
                'MAPEL SMP',
                'MAPEL SMA',
                'Tahfidz',
                'Yang lain'
            ];
            
            if (!in_array($programValue, $allowedPrograms)) {
                // If not in enum, use 'Yang lain' and store original in program_other
                $programOther = $validated['program'];
                $programValue = 'Yang lain';
            } else {
                $programOther = null;
            }

            // Handle photo upload
            $photoPath = null;
            if ($request->hasFile('photo')) {
                try {
                    $photo = $request->file('photo');
                    $photoName = Str::slug($validated['full_name']) . '-' . time() . '.' . $photo->getClientOriginalExtension();
                    
                    // Ensure directory exists
                    $directory = 'registrations/photos';
                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory);
                    }
                    
                    $photoPath = $photo->storeAs($directory, $photoName, 'public');
                    
                    if (!$photoPath) {
                        throw new \Exception('Failed to upload photo');
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::error('Photo upload error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal mengupload foto: ' . $e->getMessage(),
                    ], 500);
                }
            }

            // Hash password
            $hashedPassword = Hash::make($validated['password']);

            // Create user account first
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $hashedPassword,
                'role' => 'student',
            ]);

            // Create registration record
            // Note: birth_place, address, school_name are required in migration but not in form
            // Setting them to empty string or null based on migration
            $registration = Registration::create([
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'nickname' => $validated['nickname'],
                'birth_place' => '', // Not in form, set empty
                'birth_date' => $validated['birth_date'],
                'address' => '', // Not in form, set empty
                'school_name' => '', // Not in form, set empty
                'program' => $programValue,
                'program_other' => $programOther,
                'photo' => $photoPath,
                'email' => $validated['email'],
                'password' => $hashedPassword,
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'phone' => $validated['parent_phone'],
            ]);

            // Get default class level (first available or create a default one)
            $defaultClassLevel = ClassLevel::first();
            if (!$defaultClassLevel) {
                // Create a default class level if none exists
                try {
                    $defaultClassLevel = ClassLevel::create([
                        'name' => 'SD Kelas 1',
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to create default class level: ' . $e->getMessage());
                    throw new \Exception('Database error: Unable to create default class level. Please contact administrator.');
                }
            }

            // Create student profile
            try {
                $student = Student::create([
                    'user_id' => $user->id,
                    'name' => $validated['full_name'],
                    'nickname' => $validated['nickname'],
                'date_of_birth' => $validated['birth_date'],
                'program_interest' => $programValue === 'Yang lain' && $programOther ? $programOther : $programValue,
                'profile_photo_path' => $photoPath,
                    'parent_phone' => $validated['parent_phone'],
                    'class_level_id' => $defaultClassLevel->id,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                \Log::error('Failed to create student: ' . $e->getMessage(), [
                    'sql' => $e->getSql(),
                    'bindings' => $e->getBindings(),
                ]);
                throw new \Exception('Database error: Unable to create student profile. ' . (config('app.debug') ? $e->getMessage() : 'Please contact administrator.'));
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil! Akun Anda telah dibuat.',
                'data' => [
                    'registration_id' => $registration->id,
                    'user_id' => $user->id,
                ],
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal. Periksa kembali data yang Anda masukkan.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            
            \Log::error('Registration database error: ' . $e->getMessage(), [
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            $errorMessage = config('app.debug') 
                ? 'Database error: ' . $e->getMessage()
                : 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'error' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'sql' => $e->getSql(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ] : null,
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Registration error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->except(['password', 'password_confirmation']),
            ]);

            $errorMessage = config('app.debug') 
                ? 'Error: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine()
                : 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'error' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => explode("\n", $e->getTraceAsString()),
                ] : null,
            ], 500);
        }
    }
}
