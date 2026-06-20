<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subdomain',
        'denomination',
        'location',
        'email',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function settings()
    {
        return $this->hasOne(ChurchSetting::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getFullNameAttribute()
    {
        if ($this->denomination) {
            return $this->denomination . ' - ' . $this->name;
        }
        return $this->name;
    }
}