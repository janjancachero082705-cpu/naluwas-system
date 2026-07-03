<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class ChoirScheduleUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $scheduleId;
    public $eventName;
    public $date;
    public $time;
    public $location;
    public $assignedMembers;
    public $action;

    public function __construct($scheduleId, $eventName, $date, $time, $location, $assignedMembers = [], $action = 'created')
    {
        $this->scheduleId = $scheduleId;
        $this->eventName = $eventName;
        $this->date = $date;
        $this->time = $time;
        $this->location = $location;
        $this->assignedMembers = $assignedMembers;
        $this->action = $action;
    }

    public function broadcastOn()
    {
        return new Channel('choir');
    }

    public function broadcastAs()
    {
        return 'schedule.updated';
    }

    public function broadcastWith()
    {
        return [
            'schedule_id' => $this->scheduleId,
            'event_name' => $this->eventName,
            'date' => $this->date,
            'time' => $this->time,
            'location' => $this->location,
            'assigned_members' => $this->assignedMembers,
            'action' => $this->action,
            'message' => $this->action === 'created' 
                ? "New choir event: {$this->eventName}" 
                : "Choir schedule updated: {$this->eventName}",
            'timestamp' => now()->toDateTimeString()
        ];
    }
}