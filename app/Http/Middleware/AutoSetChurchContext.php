<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Church;
use Illuminate\Support\Facades\Schema;

class AutoSetChurchContext
{
    public function handle(Request $request, Closure $next)
    {
        // Check if auth is checked and user is logged in
        if (Auth::check()) {
            try {
                $user = Auth::user();
                
                // Check if users table exists
                if (!Schema::hasTable('users')) {
                    return $next($request);
                }
                
                // Check if churches table exists
                if (!Schema::hasTable('churches')) {
                    return $next($request);
                }
                
                // If user has NO church_id, auto-create or assign one
                if (!$user->church_id) {
                    $church = Church::first();
                    if (!$church) {
                        $church = Church::create([
                            'name' => $user->name . "'s Church",
                            'subdomain' => strtolower(str_replace(' ', '-', $user->name)),
                            'is_active' => true,
                        ]);
                    }
                    
                    $user->church_id = $church->id;
                    $user->save();
                }
                
                session(['current_church_id' => $user->church_id]);
            } catch (\Exception $e) {
                // If there's an error, just continue
                // This prevents the page from breaking
            }
        }
        
        return $next($request);
    }
}