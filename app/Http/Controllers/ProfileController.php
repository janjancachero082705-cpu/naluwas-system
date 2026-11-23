<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Partial Validation: I-validate ra kung naa ang field
        $rules = [];
        if ($request->filled('name')) $rules['name'] = 'required|string|max:255';
        if ($request->filled('email')) $rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
        if ($request->hasFile('profile_picture')) $rules['profile_picture'] = 'nullable|image|max:2048';
        if ($request->filled('church_name')) $rules['church_name'] = 'nullable|string|max:255';

        $request->validate($rules);

        $data = [];
        if ($request->filled('name')) $data['name'] = $request->name;
        if ($request->filled('email')) $data['email'] = $request->email;

        if ($request->filled('church_name') && $user->church) {
            $user->church->update(['name' => $request->church_name]);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $data['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        if (!empty($data)) {
            $user->update($data);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully!');
    }
}