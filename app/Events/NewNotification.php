<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class NewNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $userId;
    public $type;
    public $title;
    public $message;
    public $link;

    public function __construct($userId, $type, $title, $message, $link = null)
    {
        $this->userId = $userId;
        $this->type = $type;
        $this->title = $title;
        $this->message = $message;
        $this->link = $link;
    }

    public function broadcastOn()
    {
        return new Channel('notifications.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'notification.new';
    }

    public function broadcastWith()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'link' => $this->link,
            'timestamp' => now()->toDateTimeString()
        ];
    }
}