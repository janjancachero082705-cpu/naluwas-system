<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoirGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'church_id',
        'name',
        'color',
        'description',
        'rotation_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'choir_group_id');
    }

    public function schedules()
    {
        return $this->hasMany(ChoirSchedule::class, 'group_id');
    }
}