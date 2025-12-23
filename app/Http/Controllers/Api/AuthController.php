<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Authenticate user and return token.
     */
    public function login(Request $request): JsonResponse
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        // Normalize email to lowercase for case-insensitive lookup
        $email = strtolower(trim($validated['email']));
        $password = $validated['password'];

        // Find user by email (case-insensitive)
        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Log the user in (for session-based auth if needed)
        // This creates a session for Filament panel access
        // Use web guard to ensure session is created for Filament panels
        Auth::guard('web')->login($user, $request->filled('remember'));
        
        // Regenerate session to prevent session fixation attacks
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }
        
        // Create new token (optimized - only create token, don't revoke old ones for better performance)
        $token = $user->createToken('api-token', ['*'], now()->addDays(30))->plainTextToken;

        return response()->json([
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token,
            ],
        ]);
    }

    /**
     * Sync session for Filament panel access after API login.
     * This endpoint should be called after successful API login to ensure session is created.
     */
    public function syncSession(Request $request): JsonResponse
    {
        // Get user from Sanctum token
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Create session for web guard (Filament panel)
        // This ensures user can access Filament panels without re-login
        Auth::guard('web')->login($user);
        
        // Regenerate session to prevent session fixation attacks
        if ($request->hasSession()) {
            $request->session()->regenerate();
        }

        return response()->json([
            'message' => 'Session synced successfully',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ],
        ]);
    }

    /**
     * Get authenticated user.
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'avatar_url' => $user->avatar_url,
            ],
        ]);
    }

    /**
     * Logout user and revoke token.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        // Revoke current token
        $user->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
