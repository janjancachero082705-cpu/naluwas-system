<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'receiver']);
    }

    public function broadcastOn()
    {
        // Send to both sender and receiver channels
        return [
            new Channel('messages.' . $this->message->receiver_church_id),
            new Channel('messages.' . $this->message->sender_church_id),
        ];
    }

    public function broadcastAs()
    {
        return 'message.new';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->sender_church_id,
            'sender_name' => $this->message->sender->name ?? 'Unknown',
            'receiver_id' => $this->message->receiver_church_id,
            'receiver_name' => $this->message->receiver->name ?? 'Unknown',
            'subject' => $this->message->subject,
            'body' => $this->message->body,
            'is_read' => $this->message->is_read,
            'created_at' => $this->message->created_at->diffForHumans(),
            'timestamp' => $this->message->created_at->toDateTimeString(),
        ];
    }
}