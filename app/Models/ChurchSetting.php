<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ChurchSetting extends Model
{
    protected $table = 'church_settings';

    protected $fillable = [
        'church_id',
        'church_name',
        'tagline',
        'logo_path',
        'address',
        'phone',
        'website',
    ];

    public static function current(): ?self
    {
        $churchId = session('current_church_id', auth()->user()->church_id ?? null);
        
        if (!$churchId) {
            return null;
        }
        
        $cacheKey = 'church_settings_' . $churchId;
        
        return Cache::remember($cacheKey, 3600, function () use ($churchId) {
            $setting = self::where('church_id', $churchId)->first();
            
            if (!$setting) {
                $church = Church::find($churchId);
                $churchName = $church ? $church->name : 'Church Management';
                
                $setting = self::create([
                    'church_id' => $churchId,
                    'church_name' => $churchName,
                    'tagline' => 'Church Management System',
                ]);
            }
            
            return $setting;
        });
    }

    public function logoUrl(): ?string
    {
        if (!$this->logo_path) {
            return null;
        }

        if (Storage::disk('public')->exists($this->logo_path)) {
            return asset('storage/' . $this->logo_path);
        }

        return null;
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget('church_settings_' . $setting->church_id);
        });

        static::deleted(function ($setting) {
            Cache::forget('church_settings_' . $setting->church_id);
        });
    }
}