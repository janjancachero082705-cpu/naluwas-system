<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChoirGroup extends Model
{
    protected $table = 'choir_groups';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}