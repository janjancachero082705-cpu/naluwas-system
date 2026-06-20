<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Church;

class SetChurchContext
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // If user has no church_id, create or assign one
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
            
            // Set session
            session(['current_church_id' => $user->church_id]);
        }
        
        return $next($request);
    }
}