<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Attendance;
use App\Traits\ChurchScopeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    use ChurchScopeTrait;

    public function index(Request $request)
    {
        $churchId = $this->getCurrentChurchId();
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        // Get members for this church ONLY
        $members = Member::where('church_id', $churchId)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        // Get attendance for selected date for this church ONLY
        $attendances = Attendance::where('church_id', $churchId)
            ->where('service_date', $selectedDate)
            ->get()
            ->keyBy('member_id');
        
        // Calculate statistics for this church ONLY
        $presentCount = $attendances->where('status', 'Present')->count();
        $lateCount = $attendances->where('status', 'Late')->count();
        $absentCount = $members->count() - $presentCount - $lateCount;
        
        return view('attendance.index', compact(
            'members', 'attendances', 'selectedDate',
            'presentCount', 'lateCount', 'absentCount'
        ));
    }

    public function store(Request $request)
    {
        $churchId = $this->getCurrentChurchId();
        
        $request->validate([
            'service_date' => 'required|date',
            'attendances' => 'array',
        ]);
        
        foreach ($request->attendances as $memberId => $data) {
            Attendance::updateOrCreate(
                [
                    'member_id' => $memberId,
                    'service_date' => $request->service_date,
                ],
                [
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'church_id' => $churchId,
                ]
            );
        }
        
        return redirect()->route('attendance.index', ['date' => $request->service_date])
            ->with('success', 'Attendance saved successfully!');
    }
}