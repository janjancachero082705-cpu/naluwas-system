<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoneyTransaction extends Model
{
    use HasFactory;

    protected $table = 'money_transactions';

    protected $fillable = [
        'description',
        'type',
        'category',
        'amount',
        'recipient',
        'donor_name',
        'remarks',
        'date',
        'church_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    // Scope for current church
    public function scopeForChurch($query, $churchId)
    {
        return $query->where('church_id', $churchId);
    }

    // Scope for income only
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    // Scope for expense only
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }
}