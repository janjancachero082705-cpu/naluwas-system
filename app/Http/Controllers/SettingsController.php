<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    /**
     * Update user's language preference
     */
    public function updateLanguage(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|in:en,ceb,tl'
        ]);

        $user = Auth::user();
        if ($user) {
            $user->preferred_language = $request->locale;
            $user->save();
        }

        session(['app_locale' => $request->locale]);
        
        return response()->json([
            'success' => true,
            'message' => 'Language updated successfully',
            'locale' => $request->locale
        ]);
    }

    /**
     * Toggle two-factor authentication
     */
    public function toggleTwoFactor(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->two_factor_enabled = $request->enabled;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => $request->enabled ? 'Two-factor authentication enabled' : 'Two-factor authentication disabled',
            'enabled' => $request->enabled
        ]);
    }

    /**
     * Update session timeout setting
     */
    public function updateSessionTimeout(Request $request)
    {
        $request->validate([
            'timeout' => 'required|integer|min:0|max:120'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->session_timeout = $request->timeout;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Session timeout updated successfully',
            'timeout' => $request->timeout
        ]);
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    }

    /**
     * Logout all other sessions
     */
    public function logoutAllSessions(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $user->forceLogoutOtherSessions();

        return response()->json([
            'success' => true,
            'message' => 'All other sessions have been logged out'
        ]);
    }
}