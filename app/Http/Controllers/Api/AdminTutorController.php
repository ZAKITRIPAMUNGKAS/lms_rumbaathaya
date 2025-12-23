<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminTutorController extends BaseApiController
{
    /**
     * Get list of tutors with pagination and filters
     */
    public function index(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'per_page' => 'sometimes|integer|min:1|max:100',
            'page' => 'sometimes|integer|min:1',
            'search' => 'sometimes|string|max:255',
        ]);

        $query = User::where('role', 'tutor');

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('bio', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = min((int) ($validated['per_page'] ?? 25), 100);
        $tutors = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $tutors->items(),
            'meta' => [
                'current_page' => $tutors->currentPage(),
                'per_page' => $tutors->perPage(),
                'total' => $tutors->total(),
                'last_page' => $tutors->lastPage(),
            ],
        ]);
    }

    /**
     * Get a single tutor by ID
     */
    public function show(int $id): JsonResponse
    {
        $this->requireAdmin();
        $tutor = User::where('role', 'tutor')->find($id);

        if (!$tutor) {
            return response()->json([
                'success' => false,
                'message' => 'Tutor tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tutor,
        ]);
    }

    /**
     * Create a new tutor
     */
    public function store(Request $request): JsonResponse
    {
        $this->requireAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ]);

        try {
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')
                    ->store('avatars', 'public');
            }

            $tutor = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'tutor',
                'bio' => $validated['bio'] ?? null,
                'avatar_url' => $avatarPath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tutor berhasil ditambahkan',
                'data' => $tutor,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan tutor: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a tutor
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->requireAdmin();
        $tutor = User::where('role', 'tutor')->find($id);

        if (!$tutor) {
            return response()->json([
                'success' => false,
                'message' => 'Tutor tidak ditemukan',
            ], 404);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ];

        // Only validate password if provided
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8';
        }

        // Only validate bio if provided
        if ($request->has('bio')) {
            $rules['bio'] = 'nullable|string|max:1000';
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi jika ingin mengubah',
            'password.min' => 'Password minimal 8 karakter',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.mimes' => 'Format gambar harus JPG, PNG, atau WEBP',
            'avatar.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        try {
            $updateData = [
                'name' => trim($validated['name']),
                'email' => trim($validated['email']),
            ];

            // Only update bio if provided
            if ($request->has('bio')) {
                $updateData['bio'] = $validated['bio'] ? trim($validated['bio']) : null;
            }

            // Only update password if provided
            if ($request->filled('password') && !empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($tutor->avatar_url) {
                    Storage::disk('public')->delete($tutor->avatar_url);
                }
                $updateData['avatar_url'] = $request->file('avatar')
                    ->store('avatars', 'public');
            }

            $tutor->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Data tutor berhasil diperbarui',
                'data' => $tutor->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui tutor: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a tutor
     */
    public function destroy(int $id): JsonResponse
    {
        $this->requireAdmin();
        $tutor = User::where('role', 'tutor')->find($id);

        if (!$tutor) {
            return response()->json([
                'success' => false,
                'message' => 'Tutor tidak ditemukan',
            ], 404);
        }

        // CRITICAL: Check for active schedules before deletion
        $activeSchedulesCount = \App\Models\Schedule::where('tutor_id', $id)
            ->where('is_active', true)
            ->count();

        if ($activeSchedulesCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus tutor karena memiliki {$activeSchedulesCount} jadwal aktif. Silakan nonaktifkan atau hapus jadwal terlebih dahulu.",
            ], 409);
        }

        // Check for journals
        $journalsCount = \App\Models\BimbelJournal::where('tutor_id', $id)->count();
        if ($journalsCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus tutor karena memiliki {$journalsCount} jurnal. Silakan hapus jurnal terlebih dahulu atau hubungi administrator.",
            ], 409);
        }

        try {
            // Delete avatar if exists
            if ($tutor->avatar_url) {
                Storage::disk('public')->delete($tutor->avatar_url);
            }

            $tutor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tutor berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus tutor: ' . $e->getMessage(),
            ], 500);
        }
    }
}
