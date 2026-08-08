<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        
        // Update last activity
        $user->updateLastActivity();

        // Check if session has expired
        if ($user->session_timeout > 0 && $user->isSessionExpired()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Your session has expired due to inactivity.');
        }

        return $next($request);
    }
}