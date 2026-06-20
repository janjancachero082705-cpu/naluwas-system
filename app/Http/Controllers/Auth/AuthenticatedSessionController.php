<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Set church context after login
        $user = Auth::user();
        
        // Check if user has a church
        if (!$user->church_id && $user->role !== 'super_admin') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is not associated with any church. Please contact administrator.',
            ]);
        }

        // Set the current church ID in session
        if ($user->church_id) {
            session(['current_church_id' => $user->church_id]);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}