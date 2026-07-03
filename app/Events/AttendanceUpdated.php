<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class AttendanceUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $serviceDate;
    public $presentCount;
    public $lateCount;
    public $absentCount;
    public $totalMembers;
    public $churchName;

    public function __construct($serviceDate, $presentCount, $lateCount, $absentCount, $totalMembers, $churchName)
    {
        $this->serviceDate = $serviceDate;
        $this->presentCount = $presentCount;
        $this->lateCount = $lateCount;
        $this->absentCount = $absentCount;
        $this->totalMembers = $totalMembers;
        $this->churchName = $churchName;
    }

    public function broadcastOn()
    {
        return new Channel('attendance');
    }

    public function broadcastAs()
    {
        return 'attendance.updated';
    }

    // Optional: Customize the broadcast data
    public function broadcastWith()
    {
        return [
            'service_date' => $this->serviceDate,
            'present' => $this->presentCount,
            'late' => $this->lateCount,
            'absent' => $this->absentCount,
            'total' => $this->totalMembers,
            'church' => $this->churchName,
            'message' => "Attendance updated for {$this->churchName}",
            'timestamp' => now()->toDateTimeString()
        ];
    }
}