<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminStudentController extends BaseApiController
{
    /**
     * Get list of students with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
            'class_level_id' => 'sometimes|exists:class_levels,id',
        ]);

        $query = Student::with(['user', 'classLevel']);

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nickname', 'like', '%' . $request->search . '%')
                  ->orWhere('school_origin', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->has('class_level_id') && $request->class_level_id) {
            $query->where('class_level_id', $request->class_level_id);
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $students = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $students->items(),
            'meta' => [
                'current_page' => $students->currentPage(),
                'per_page' => $students->perPage(),
                'total' => $students->total(),
                'last_page' => $students->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single student by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $student = Student::with(['user', 'classLevel'])->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $student,
        ]);
    }

    /**
     * Get options for student form (class levels, etc)
     */
    public function options(): JsonResponse
    {
        $classLevels = ClassLevel::select('id', 'name')->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => [
                'class_levels' => $classLevels,
            ],
        ]);
    }

    /**
     * Create a new student
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'school_origin' => 'required|string|max:255',
            'class_level_id' => 'required|exists:class_levels,id',
            'program_interest' => 'nullable|in:Calistung,Mapel SD,Mapel SMP,Mapel SMA,Tahfidz',
            'parent_phone' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'school_origin.required' => 'Sekolah asal wajib diisi',
            'school_origin.max' => 'Sekolah asal maksimal 255 karakter',
            'class_level_id.required' => 'Jenjang kelas wajib dipilih',
            'class_level_id.exists' => 'Jenjang kelas tidak valid',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid',
            'program_interest.in' => 'Program minat tidak valid',
            'parent_phone.max' => 'Nomor telepon maksimal 20 karakter',
            'profile_photo.image' => 'File harus berupa gambar',
            'profile_photo.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'profile_photo.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        try {
            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
            ]);

            // Handle profile photo upload
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')
                    ->store('student-photos', 'public');
            }

            // Create student profile
            $student = Student::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'nickname' => $validated['nickname'] ?? null,
                'place_of_birth' => $validated['place_of_birth'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'address' => $validated['address'] ?? null,
                'school_origin' => $validated['school_origin'],
                'class_level_id' => $validated['class_level_id'],
                'program_interest' => $validated['program_interest'] ?? null,
                'parent_phone' => $validated['parent_phone'] ?? null,
                'profile_photo_path' => $profilePhotoPath,
            ]);

            $student->load(['user', 'classLevel']);

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil ditambahkan',
                'data' => $student,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan siswa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a student
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($student->user_id)],
            'school_origin' => 'required|string|max:255',
            'class_level_id' => 'required|exists:class_levels,id',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ];

        // Only validate optional fields if they are provided
        if ($request->has('nickname')) {
            $rules['nickname'] = 'nullable|string|max:255';
        }
        if ($request->has('password')) {
            $rules['password'] = 'nullable|string|min:8';
        }
        if ($request->has('place_of_birth')) {
            $rules['place_of_birth'] = 'nullable|string|max:255';
        }
        if ($request->has('date_of_birth')) {
            $rules['date_of_birth'] = 'nullable|date';
        }
        if ($request->has('address')) {
            $rules['address'] = 'nullable|string';
        }
        if ($request->has('program_interest')) {
            $rules['program_interest'] = 'nullable|in:Calistung,Mapel SD,Mapel SMP,Mapel SMA,Tahfidz';
        }
        if ($request->has('parent_phone')) {
            $rules['parent_phone'] = 'nullable|string|max:20';
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'school_origin.required' => 'Sekolah asal wajib diisi',
            'school_origin.max' => 'Sekolah asal maksimal 255 karakter',
            'class_level_id.required' => 'Jenjang kelas wajib dipilih',
            'class_level_id.exists' => 'Jenjang kelas tidak valid',
            'password.min' => 'Password minimal 8 karakter',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid',
            'program_interest.in' => 'Program minat tidak valid',
            'parent_phone.max' => 'Nomor telepon maksimal 20 karakter',
            'profile_photo.image' => 'File harus berupa gambar',
            'profile_photo.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'profile_photo.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        try {
            // Update user account
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            if (!$student->user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User account tidak ditemukan untuk siswa ini',
                ], 404);
            }

            $student->user->update($userData);

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                if ($student->profile_photo_path) {
                    Storage::disk('public')->delete($student->profile_photo_path);
                }
                $validated['profile_photo_path'] = $request->file('profile_photo')
                    ->store('student-photos', 'public');
            }

            // Update student profile - only update fields that are provided
            $updateData = [
                'name' => trim($validated['name']),
                'school_origin' => trim($validated['school_origin']),
                'class_level_id' => $validated['class_level_id'],
            ];

            // Only update optional fields if they are provided
            if ($request->has('nickname')) {
                $updateData['nickname'] = $validated['nickname'] ? trim($validated['nickname']) : null;
            }
            if ($request->has('place_of_birth')) {
                $updateData['place_of_birth'] = $validated['place_of_birth'] ? trim($validated['place_of_birth']) : null;
            }
            if ($request->has('date_of_birth')) {
                $updateData['date_of_birth'] = $validated['date_of_birth'] ?? null;
            }
            if ($request->has('address')) {
                $updateData['address'] = $validated['address'] ? trim($validated['address']) : null;
            }
            if ($request->has('program_interest')) {
                $updateData['program_interest'] = $validated['program_interest'] ?? null;
            }
            if ($request->has('parent_phone')) {
                $updateData['parent_phone'] = $validated['parent_phone'] ? trim($validated['parent_phone']) : null;
            }

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old avatar if exists
                if ($student->profile_photo_path) {
                    Storage::disk('public')->delete($student->profile_photo_path);
                }
                $updateData['profile_photo_path'] = $request->file('profile_photo')
                    ->store('student-photos', 'public');
            }

            $student->update($updateData);

            $student->load(['user', 'classLevel']);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diperbarui',
                'data' => $student,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui siswa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a student
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        // CRITICAL: Check for active schedules before deletion
        $activeSchedulesCount = \App\Models\Schedule::where('student_id', $id)
            ->where('is_active', true)
            ->count();

        if ($activeSchedulesCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus siswa karena memiliki {$activeSchedulesCount} jadwal aktif. Silakan nonaktifkan atau hapus jadwal terlebih dahulu.",
            ], 409);
        }

        // Check for attendances
        $attendancesCount = \App\Models\Attendance::where('student_id', $id)->count();
        if ($attendancesCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus siswa karena memiliki {$attendancesCount} data kehadiran. Silakan hapus data kehadiran terlebih dahulu atau hubungi administrator.",
            ], 409);
        }

        try {
            // Delete profile photo if exists
            if ($student->profile_photo_path) {
                Storage::disk('public')->delete($student->profile_photo_path);
            }

            $userId = $student->user_id;
            $student->delete();

            // Delete user account if exists
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    // Delete avatar if exists
                    if ($user->avatar_url) {
                        Storage::disk('public')->delete($user->avatar_url);
                    }
                    $user->delete();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus siswa: ' . $e->getMessage(),
            ], 500);
        }
    }
}
