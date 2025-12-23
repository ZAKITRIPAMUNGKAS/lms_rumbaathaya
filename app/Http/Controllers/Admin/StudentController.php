<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'classLevel']);
        
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nickname', 'like', '%' . $request->search . '%')
                  ->orWhere('school_origin', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->has('class_level_id') && $request->class_level_id) {
            $query->where('class_level_id', $request->class_level_id);
        }
        
        $students = $query->latest()->paginate(25);
        $classLevels = ClassLevel::all();
        
        // Redirect to Filament admin panel
        return redirect('/admin/students');
    }
    
    public function create()
    {
        $classLevels = ClassLevel::all();
        $users = User::where('role', 'student')->whereDoesntHave('student')->get();
        
        // Redirect to Filament admin panel
        return redirect('/admin/students/create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'school_origin' => 'required|string|max:255',
            'class_level_id' => 'required|exists:class_levels,id',
            'program_interest' => 'nullable|in:Calistung,Mapel SD,Mapel SMP,Mapel SMA,Tahfidz',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'parent_phone' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
        ]);
        
        if ($request->hasFile('profile_photo_path')) {
            $validated['profile_photo_path'] = $request->file('profile_photo_path')
                ->store('student-photos', 'public');
        }
        
        Student::create($validated);
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }
    
    public function show(Student $student)
    {
        $student->load(['user', 'classLevel']);
        // Redirect to Filament admin panel
        return redirect('/admin/students/' . $student->id);
    }
    
    public function edit(Student $student)
    {
        $classLevels = ClassLevel::all();
        $users = User::where('role', 'student')->get();
        
        // Redirect to Filament admin panel
        return redirect('/admin/students/' . $student->id . '/edit');
    }
    
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'school_origin' => 'required|string|max:255',
            'class_level_id' => 'required|exists:class_levels,id',
            'program_interest' => 'nullable|in:Calistung,Mapel SD,Mapel SMP,Mapel SMA,Tahfidz',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'parent_phone' => 'nullable|string|max:20',
            'user_id' => 'nullable|exists:users,id',
        ]);
        
        if ($request->hasFile('profile_photo_path')) {
            if ($student->profile_photo_path) {
                Storage::disk('public')->delete($student->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('profile_photo_path')
                ->store('student-photos', 'public');
        }
        
        $student->update($validated);
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }
    
    public function destroy(Student $student)
    {
        if ($student->profile_photo_path) {
            Storage::disk('public')->delete($student->profile_photo_path);
        }
        
        $student->delete();
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Siswa berhasil dihapus');
    }
}

