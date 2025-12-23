<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form
     * Note: Middleware 'guest' will handle redirecting authenticated users
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Create the user with role 'student'
        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        // Create the student profile linked to the user
        Student::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'nickname' => $validated['nickname'] ?? null,
        ]);

        // Fire the registered event (optional, for email verification if needed)
        event(new Registered($user));

        // Auto-login the user
        Auth::login($user);

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect to student dashboard
        return redirect()->route('student.dashboard');
    }
}

