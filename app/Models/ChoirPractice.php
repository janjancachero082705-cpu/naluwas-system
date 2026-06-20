<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class ChoirPractice extends Model
{
    use HasFactory;

    protected $fillable = [
        'church_id',
        'date',
        'start_time',
        'end_time',
        'location',
        'notes',
        'is_mandatory',
    ];

    protected $casts = [
        'date' => 'date',
        'is_mandatory' => 'boolean',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('F d, Y');
    }

    public function getFormattedStartTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('g:i A');
    }

    public function getFormattedEndTimeAttribute()
    {
        return Carbon::parse($this->end_time)->format('g:i A');
    }
}