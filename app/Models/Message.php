<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_church_id',
        'receiver_church_id',
        'subject',
        'body',
        'is_read',
        'read_at',
        'is_archived',
        'attachments'
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read' => 'boolean',
        'is_archived' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(Church::class, 'sender_church_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Church::class, 'receiver_church_id');
    }

    // Scope for unread messages
    public function scopeUnread($query, $churchId)
    {
        return $query->where('receiver_church_id', $churchId)
                    ->where('is_read', false);
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }
}