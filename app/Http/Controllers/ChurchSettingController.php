<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChurchSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChurchSettingController extends Controller
{
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $settings = ChurchSetting::current();
            
            // Delete old logo if exists
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            
            // Generate unique filename
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = 'church_logo_' . time() . '_' . Str::random(10) . '.' . $extension;
            
            // Store new logo
            $path = $file->storeAs('church-logos', $filename, 'public');
            
            // Update settings
            $settings->update([
                'logo_path' => $path
            ]);
            
            // Generate URL
            $logoUrl = Storage::disk('public')->url($path);
            
            return response()->json([
                'success' => true,
                'message' => 'Logo updated successfully!',
                'logo_url' => $logoUrl
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload logo: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function removeLogo(Request $request)
    {
        try {
            $settings = ChurchSetting::current();
            
            if ($settings->logo_path && Storage::disk('public')->exists($settings->logo_path)) {
                Storage::disk('public')->delete($settings->logo_path);
                $settings->update(['logo_path' => null]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Logo removed successfully!'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No logo found to remove'
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove logo: ' . $e->getMessage()
            ], 500);
        }
    }
}