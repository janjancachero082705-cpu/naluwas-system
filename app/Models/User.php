<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'church_id',
        'role',
        'profile_picture',
        'avatar_color',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the church that owns the user
     */
    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    /**
     * Get church settings through church
     */
    public function churchSettings()
    {
        return $this->hasOneThrough(ChurchSetting::class, Church::class, 'id', 'church_id', 'church_id');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'church_admin';
    }

    /**
     * Get profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/profile_pictures/' . $this->profile_picture);
        }
        return null;
    }

    /**
     * Get user initials
     */
    public function getInitialsAttribute()
    {
        $name = $this->name;
        $words = explode(' ', trim($name));
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }
        
        return substr($initials, 0, 2);
    }

    /**
     * Get avatar color (generates random color if not set)
     */
    public function getAvatarColorAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        $colors = [
            '#4F46E5', '#10B981', '#EF4444', '#F59E0B', 
            '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6',
            '#F97316', '#6366F1', '#06B6D4', '#D946EF'
        ];
        
        $randomColor = $colors[array_rand($colors)];
        $this->avatar_color = $randomColor;
        $this->save();
        
        return $randomColor;
    }

    /**
     * Check if user has profile picture
     */
    public function hasProfilePicture()
    {
        return !is_null($this->profile_picture);
    }

    /**
     * Delete profile picture
     */
    public function deleteProfilePicture()
    {
        if ($this->profile_picture) {
            Storage::disk('public')->delete('profile_pictures/' . $this->profile_picture);
            $this->profile_picture = null;
            $this->save();
            return true;
        }
        return false;
    }
}