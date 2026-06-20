<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoirSchedule extends Model
{
    use HasFactory;

    protected $table = 'choir_schedules';

    protected $fillable = [
        'church_id',
        'service_date',
        'group_id'
    ];

    protected $casts = [
        'service_date' => 'date'
    ];

    public function group()
    {
        return $this->belongsTo(ChoirGroup::class, 'group_id');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'choir_schedule_member', 'choir_schedule_id', 'member_id');
    }
}