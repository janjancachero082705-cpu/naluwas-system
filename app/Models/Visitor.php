<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';
    
    protected $fillable = [
        'church_id',
        'visitor_name',
        'service_date',
        'notes',
    ];
    
    protected $casts = [
        'service_date' => 'date',
    ];
    
    public function church()
    {
        return $this->belongsTo(Church::class);
    }
}