<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subdomain',
        'denomination',
        'location',
        'email',
        'phone',
        'is_active',
        'color', // Add color field for avatars
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ============================================
    // EXISTING RELATIONSHIPS
    // ============================================
    
    public function settings()
    {
        return $this->hasOne(ChurchSetting::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // ============================================
    // MESSAGING RELATIONSHIPS
    // ============================================
    
    /**
     * Messages sent by this church
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_church_id');
    }

    /**
     * Messages received by this church
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_church_id');
    }

    /**
     * Get unread messages for this church
     */
    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'receiver_church_id')
                    ->where('is_read', false);
    }

    /**
     * Get unread messages count for this church
     */
    public function getUnreadCountAttribute()
    {
        return $this->unreadMessages()->count();
    }

    // ============================================
    // FINANCE RELATIONSHIPS
    // ============================================
    
    /**
     * Money transactions for this church
     */
    public function moneyTransactions()
    {
        return $this->hasMany(MoneyTransaction::class);
    }

    /**
     * Get total income for this church
     */
    public function getTotalIncomeAttribute()
    {
        return $this->moneyTransactions()->where('type', 'income')->sum('amount');
    }

    /**
     * Get total expenses for this church
     */
    public function getTotalExpensesAttribute()
    {
        return $this->moneyTransactions()->where('type', 'expense')->sum('amount');
    }

    /**
     * Get current balance for this church
     */
    public function getBalanceAttribute()
    {
        return $this->total_income - $this->total_expenses;
    }

    // ============================================
    // ATTENDANCE RELATIONSHIPS
    // ============================================
    
    /**
     * Attendances for this church
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Sunday attendances for this church
     */
    public function sundayAttendances()
    {
        return $this->hasMany(SundayAttendance::class);
    }

    // ============================================
    // CHOIR RELATIONSHIPS
    // ============================================
    
    /**
     * Choir members for this church
     */
    public function choirMembers()
    {
        return $this->hasMany(ChoirMember::class);
    }

    /**
     * Choir schedules for this church
     */
    public function choirSchedules()
    {
        return $this->hasMany(ChoirSchedule::class);
    }

    /**
     * Choir groups for this church
     */
    public function choirGroups()
    {
        return $this->hasMany(ChoirGroup::class);
    }

    // ============================================
    // INVENTORY RELATIONSHIPS
    // ============================================
    
    /**
     * Inventory items for this church
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    // ============================================
    // HELPER ATTRIBUTES
    // ============================================
    
    /**
     * Get the full name with denomination
     */
    public function getFullNameAttribute()
    {
        if ($this->denomination) {
            return $this->denomination . ' - ' . $this->name;
        }
        return $this->name;
    }

    /**
     * Get the initials for avatar
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        return substr($initials, 0, 2);
    }

    /**
     * Get a color for avatar
     */
    public function getAvatarColorAttribute()
    {
        if ($this->color) {
            return $this->color;
        }
        
        $colors = [
            '#4F46E5', '#7C3AED', '#2563EB', '#0891B2', 
            '#059669', '#D97706', '#DC2626', '#7C3AED',
            '#4338CA', '#0D9488', '#6D28D9', '#B45309'
        ];
        
        $index = abs(crc32($this->name)) % count($colors);
        return $colors[$index];
    }

    // ============================================
    // SCOPES
    // ============================================
    
    /**
     * Scope a query to only include active churches.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to search churches by name.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
                     ->orWhere('denomination', 'LIKE', "%{$search}%")
                     ->orWhere('location', 'LIKE', "%{$search}%");
    }
}