<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Handles mobile device registration for Push Notifications (FCM).
 * Stores FCM token associated to the authenticated user.
 */
class DeviceController extends Controller
{
    /**
     * Register or update the FCM token for the authenticated user's device.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fcm_token'   => ['required', 'string', 'max:512'],
            'platform'    => ['required', 'string', 'in:android,ios,web'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Store FCM token on user model if column exists, otherwise just log
        // To activate: add fcm_token column to users table via migration
        if (in_array('fcm_token', $user->getFillable())) {
            $user->update(['fcm_token' => $validated['fcm_token']]);
        }

        \Log::info('FCM token registered', [
            'user_id'  => $user->id,
            'platform' => $validated['platform'],
            'token'    => substr($validated['fcm_token'], 0, 20) . '...',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device registered successfully.',
            'user_id' => $user->id,
        ]);
    }
}
