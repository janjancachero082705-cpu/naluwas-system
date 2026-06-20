<?php

namespace App\Http\Controllers;

use App\Models\WeeklySchedule;
use Illuminate\Http\Request;
use App\Traits\ChurchScopeTrait;

class WeeklyScheduleController extends Controller
{
    use ChurchScopeTrait;

    /**
     * Get all weekly schedules for the current church
     */
    public function getSchedules()
    {
        $churchId = $this->getCurrentChurchId();
        
        $schedules = WeeklySchedule::where('church_id', $churchId)
            ->where('is_active', true)
            ->orderByRaw("FIELD(day, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')")
            ->orderBy('start_time', 'asc')
            ->get();
        
        return response()->json([
            'success' => true,
            'schedules' => $schedules
        ]);
    }

    /**
     * Store a new weekly schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required',
            'end_time' => 'required',
            'type' => 'required|in:choir,bible_study,prayer_meeting,youth_fellowship,children_church',
        ]);

        $churchId = $this->getCurrentChurchId();

        // Check if schedule already exists for this day and type
        $exists = WeeklySchedule::where('church_id', $churchId)
            ->where('day', $request->day)
            ->where('type', $request->type)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'A schedule already exists for ' . ucfirst($request->day) . ' for this activity.'
            ], 422);
        }

        $schedule = WeeklySchedule::create([
            'church_id' => $churchId,
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'type' => $request->type,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Schedule added successfully!',
            'schedule' => $schedule
        ]);
    }

    /**
     * Delete a weekly schedule
     */
    public function destroy($id)
    {
        $churchId = $this->getCurrentChurchId();
        
        $schedule = WeeklySchedule::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule removed successfully!'
        ]);
    }
}