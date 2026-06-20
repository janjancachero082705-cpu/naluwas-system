<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Church;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Church fields
            'church_name' => 'required|string|max:255',
            'subdomain' => 'required|string|unique:churches,subdomain',
            'denomination' => 'nullable|string|max:255',
            'church_location' => 'nullable|string|max:255',
            'church_email' => 'nullable|email|max:255',
            'church_phone' => 'nullable|string|max:20',
            
            // Admin user fields
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the church
        $church = Church::create([
            'name' => $request->church_name,
            'subdomain' => $request->subdomain,
            'denomination' => $request->denomination,
            'location' => $request->church_location,
            'email' => $request->church_email,
            'phone' => $request->church_phone,
            'is_active' => true,
        ]);

        // Create the admin user with church_id
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'church_id' => $church->id,  // IMPORTANT: Assign church_id
            'role' => 'church_admin',
        ]);

        event(new Registered($user));

        // Login the user
        Auth::login($user);
        
        // Set session for current church
        session(['current_church_id' => $church->id]);

        return redirect(route('dashboard', absolute: false));
    }
}