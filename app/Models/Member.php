<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'church_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'address',
        'birthday',
        'notes',
        'is_deceased',
        'date_deceased',
    ];

    protected $casts = [
        'is_deceased' => 'boolean',
        'birthday' => 'date',
        'date_deceased' => 'date',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'member_role', 'member_id', 'role_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeActive($query)
    {
        return $query->where('is_deceased', false);
    }

    public function scopeDeceased($query)
    {
        return $query->where('is_deceased', true);
    }

    public function scopeBirthdayThisMonth($query)
    {
        return $query->whereMonth('birthday', now()->month)->where('is_deceased', false);
    }

    public function getBirthdayFormattedAttribute()
    {
        return $this->birthday ? $this->birthday->format('F d, Y') : null;
    }

    public function getAgeAttribute()
    {
        return $this->birthday ? $this->birthday->age : null;
    }

    public function getAgeAtDeathAttribute()
    {
        if ($this->birthday && $this->date_deceased) {
            return $this->birthday->diffInYears($this->date_deceased);
        }
        return null;
    }

    public function getStatusAttribute()
    {
        return $this->is_deceased ? 'Deceased' : 'Active';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->is_deceased ? 'secondary' : 'success';
    }

    public function getDateDeceasedFormattedAttribute()
    {
        return $this->date_deceased ? $this->date_deceased->format('F d, Y') : null;
    }
}