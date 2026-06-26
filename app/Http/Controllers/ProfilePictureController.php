<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilePictureController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        
        // Delete old profile picture
        $user->deleteProfilePicture();

        // Store new profile picture
        $imageName = time() . '_' . $user->id . '.' . $request->profile_picture->extension();
        $request->profile_picture->storeAs('profile_pictures', $imageName, 'public');
        
        $user->profile_picture = $imageName;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile picture updated successfully!',
            'profile_picture_url' => $user->profile_picture_url,
        ]);
    }

    public function remove(Request $request)
    {
        $user = Auth::user();
        $user->deleteProfilePicture();

        return response()->json([
            'success' => true,
            'message' => 'Profile picture removed successfully!',
        ]);
    }
}