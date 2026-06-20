<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SundayAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceViewController extends Controller
{
    public function index(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        // Get selected date or default to today
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        // Get all members for this church (active members only)
        $members = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        // Get attendance for selected date
        $attendances = SundayAttendance::where('church_id', $churchId)
            ->where('service_date', $selectedDate)
            ->get()
            ->keyBy('member_id');
        
        // Statistics
        $totalMembers = $members->count();
        $presentCount = $attendances->where('status', 'Present')->count();
        $absentCount = $totalMembers - $presentCount;
        
        return view('attendance-view.index', compact(
            'selectedDate',
            'members',
            'attendances',
            'totalMembers',
            'presentCount',
            'absentCount'
        ));
    }
    
    public function show($date)
    {
        return redirect()->route('attendance-view.index', ['date' => $date]);
    }
}