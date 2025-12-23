<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        
        $users = $query->latest()->paginate(25);
        
        // Redirect to Filament admin panel
        return redirect('/admin/users');
    }
    
    public function create()
    {
        // Redirect to Filament admin panel
        return redirect('/admin/users/create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,tutor,student',
            'avatar_url' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'bio' => 'nullable|string|max:500',
        ]);
        
        if ($request->hasFile('avatar_url')) {
            $validated['avatar_url'] = $request->file('avatar_url')
                ->store('user-avatars', 'public');
        }
        
        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan');
    }
    
    public function show(User $user)
    {
        // Redirect to Filament admin panel
        return redirect('/admin/users/' . $user->id);
    }
    
    public function edit(User $user)
    {
        // Redirect to Filament admin panel
        return redirect('/admin/users/' . $user->id . '/edit');
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,tutor,student',
            'avatar_url' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'bio' => 'nullable|string|max:500',
        ]);
        
        if ($request->hasFile('avatar_url')) {
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            $validated['avatar_url'] = $request->file('avatar_url')
                ->store('user-avatars', 'public');
        }
        
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui');
    }
    
    public function destroy(User $user)
    {
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus');
    }
}

