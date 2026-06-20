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
        'choir_role',
        'is_choir',
        'address',
        'birthday',
        'notes',
        'choir_group_id',
        'is_deceased',
        'date_deceased',
    ];

    protected $casts = [
        'is_choir' => 'boolean',
        'is_deceased' => 'boolean',
        'birthday' => 'date',
        'date_deceased' => 'date',
    ];

    // Relationship with choir schedules
    public function choirSchedules()
    {
        return $this->hasMany(ChoirSchedule::class);
    }

    // Relationship with choir group
    public function choirGroup()
    {
        return $this->belongsTo(ChoirGroup::class, 'choir_group_id');
    }

    // Relationship with roles (many-to-many)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'member_role', 'member_id', 'role_id');
    }

    // Get full name attribute
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    // Get total services served
    public function getTotalServicesAttribute()
    {
        return $this->choirSchedules()->count();
    }

    // Get last service date
    public function getLastServiceDateAttribute()
    {
        $lastSchedule = $this->choirSchedules()
            ->orderBy('service_date', 'desc')
            ->first();
        
        return $lastSchedule ? $lastSchedule->service_date : null;
    }

    // Get upcoming service date
    public function getUpcomingServiceDateAttribute()
    {
        $upcomingSchedule = $this->choirSchedules()
            ->where('service_date', '>=', now())
            ->orderBy('service_date', 'asc')
            ->first();
        
        return $upcomingSchedule ? $upcomingSchedule->service_date : null;
    }

    // Get assigned group name
    public function getGroupNameAttribute()
    {
        return $this->choirGroup ? $this->choirGroup->name : 'Not Assigned';
    }

    // Get group color
    public function getGroupColorAttribute()
    {
        return $this->choirGroup ? $this->choirGroup->color : '#6c757d';
    }

    // Check if member is in choir
    public function getIsChoirMemberAttribute()
    {
        return $this->is_choir;
    }

    // Get choir role display
    public function getChoirRoleDisplayAttribute()
    {
        return $this->choir_role ?? 'Not Assigned';
    }

    // Scope for active members (not deceased)
    public function scopeActive($query)
    {
        return $query->where('is_deceased', false);
    }

    // Scope for deceased members
    public function scopeDeceased($query)
    {
        return $query->where('is_deceased', true);
    }

    // Scope for choir members only
    public function scopeChoirMembers($query)
    {
        return $query->where('is_choir', true)->where('is_deceased', false);
    }

    // Scope by choir role
    public function scopeByChoirRole($query, $role)
    {
        return $query->where('choir_role', $role);
    }

    // Scope by group
    public function scopeByGroup($query, $groupId)
    {
        return $query->where('choir_group_id', $groupId);
    }

    // Scope for members with upcoming birthdays (active only)
    public function scopeBirthdayThisMonth($query)
    {
        return $query->whereMonth('birthday', now()->month)->where('is_deceased', false);
    }

    // Get birthday formatted
    public function getBirthdayFormattedAttribute()
    {
        return $this->birthday ? $this->birthday->format('F d, Y') : null;
    }

    // Get age
    public function getAgeAttribute()
    {
        return $this->birthday ? $this->birthday->age : null;
    }

    // Get age at death
    public function getAgeAtDeathAttribute()
    {
        if ($this->birthday && $this->date_deceased) {
            return $this->birthday->diffInYears($this->date_deceased);
        }
        return null;
    }

    // REMOVED: getIsDeceasedAttribute() - no longer needed because $casts handles it

    // Get status (for display)
    public function getStatusAttribute()
    {
        if ($this->is_deceased) {
            return 'Deceased';
        }
        return 'Active';
    }

    // Get status badge class
    public function getStatusBadgeAttribute()
    {
        if ($this->is_deceased) {
            return 'secondary';
        }
        return 'success';
    }

    // Get choir role badge class
    public function getChoirRoleBadgeAttribute()
    {
        $badges = [
            'Singer' => 'success',
            'Guitarist' => 'warning',
            'Bassist' => 'info',
            'Drummer' => 'danger',
        ];
        
        return $badges[$this->choir_role] ?? 'secondary';
    }

    // Get choir role icon
    public function getChoirRoleIconAttribute()
    {
        $icons = [
            'Singer' => 'fa-microphone-alt',
            'Guitarist' => 'fa-guitar',
            'Bassist' => 'fa-guitar',
            'Drummer' => 'fa-drum',
        ];
        
        return $icons[$this->choir_role] ?? 'fa-user';
    }

    // Get date deceased formatted
    public function getDateDeceasedFormattedAttribute()
    {
        return $this->date_deceased ? $this->date_deceased->format('F d, Y') : null;
    }
}