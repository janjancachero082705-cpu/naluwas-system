<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'church_id',
        'role',
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
}