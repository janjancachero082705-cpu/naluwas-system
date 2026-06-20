<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'church_id',
        'day',
        'start_time',
        'end_time',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the church that owns this schedule
     */
    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    /**
     * Get the full day name
     */
    public function getDayNameAttribute()
    {
        $days = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];
        return $days[$this->day] ?? ucfirst($this->day);
    }

    /**
     * Get the activity type name
     */
    public function getTypeNameAttribute()
    {
        $types = [
            'choir' => 'Choir Practice',
            'bible_study' => 'Bible Study',
            'prayer_meeting' => 'Prayer Meeting',
            'youth_fellowship' => 'Youth Fellowship',
            'children_church' => "Children's Church"
        ];
        return $types[$this->type] ?? ucfirst($this->type);
    }

    /**
     * Get the type icon
     */
    public function getTypeIconAttribute()
    {
        $icons = [
            'choir' => '🎵',
            'bible_study' => '📖',
            'prayer_meeting' => '🙏',
            'youth_fellowship' => '👥',
            'children_church' => '🧒'
        ];
        return $icons[$this->type] ?? '📌';
    }
}