<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoirMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'voice_part',
        'joined_date',
        'status'
    ];

    protected $casts = [
        'joined_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}