<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SundayAttendance extends Model
{
    use HasFactory;

    protected $table = 'sunday_attendances';

    protected $fillable = [
        'church_id',
        'member_id',
        'service_date',
        'service_type',
        'status',
        'visitor_name',
        'is_visitor',
        'notes',
    ];

    protected $casts = [
        'service_date' => 'date',
        'is_visitor' => 'boolean',
    ];

    // Relationship with Church
    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    // Relationship with Member
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}