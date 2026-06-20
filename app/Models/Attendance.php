<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'church_id',
        'member_id',
        'service_date',
        'status',
        'notes',
    ];
    
    protected $casts = [
        'service_date' => 'date',
    ];
}