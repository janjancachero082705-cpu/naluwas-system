<?php
// app/Models/InventoryItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'church_id',
        'name',
        'category',
        'quantity',
        'unit_price',
        'reorder_level',
        'description',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'reorder_level' => 'integer',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}