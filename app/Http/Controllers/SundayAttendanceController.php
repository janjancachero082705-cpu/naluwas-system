<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SundayAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SundayAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        // Get date parameters
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        
        // Get all members for this church
        $members = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        // Get existing attendance for selected date
        $attendances = SundayAttendance::where('church_id', $churchId)
            ->where('service_date', $selectedDate)
            ->get()
            ->keyBy('member_id');
        
        // Statistics
        $totalMembers = $members->count();
        $presentCount = $attendances->where('status', 'Present')->count();
        $absentCount = $totalMembers - $presentCount;
        
        // Check if date is Sunday
        $isSunday = Carbon::parse($selectedDate)->isSunday();
        
        return view('sunday-attendance.index', compact(
            'selectedDate',
            'members',
            'attendances',
            'totalMembers',
            'presentCount',
            'absentCount',
            'year',
            'month',
            'isSunday'
        ));
    }

    public function store(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        $serviceDate = $request->service_date;
        
        // Validate
        $request->validate([
            'service_date' => 'required|date',
            'attendances' => 'nullable|array',
        ]);
        
        // Delete existing attendance for this date
        SundayAttendance::where('church_id', $churchId)
            ->where('service_date', $serviceDate)
            ->delete();
        
        // Save member attendance
        if ($request->has('attendances')) {
            foreach ($request->attendances as $memberId => $data) {
                if (isset($data['status'])) {
                    SundayAttendance::create([
                        'church_id' => $churchId,
                        'member_id' => $memberId,
                        'service_date' => $serviceDate,
                        'service_type' => 'Sunday Service',
                        'status' => $data['status'],
                        'notes' => $data['notes'] ?? null,
                    ]);
                }
            }
        }
        
        // For AJAX requests (auto-save)
        if ($request->ajax()) {
            // Get updated statistics
            $members = Member::where('church_id', $churchId)
                ->where('is_deceased', false)
                ->get();
            
            $attendances = SundayAttendance::where('church_id', $churchId)
                ->where('service_date', $serviceDate)
                ->get()
                ->keyBy('member_id');
            
            $totalMembers = $members->count();
            $presentCount = $attendances->where('status', 'Present')->count();
            $absentCount = $totalMembers - $presentCount;
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance saved successfully!',
                'stats' => [
                    'total' => $totalMembers,
                    'present' => $presentCount,
                    'absent' => $absentCount,
                ]
            ]);
        }
        
        // Redirect to attendance records with the date
        return redirect()->route('attendance-view.index', ['date' => $serviceDate])
            ->with('success', 'Attendance saved successfully for ' . Carbon::parse($serviceDate)->format('F d, Y') . '!');
    }

    /**
     * Display attendance records page
     */
    public function records(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        // Get date parameter
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        // Get all members for this church
        $members = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        // Get existing attendance for selected date
        $attendances = SundayAttendance::where('church_id', $churchId)
            ->where('service_date', $selectedDate)
            ->get()
            ->keyBy('member_id');
        
        // Statistics
        $totalMembers = $members->count();
        $presentCount = $attendances->where('status', 'Present')->count();
        $absentCount = $totalMembers - $presentCount;
        
        return view('sunday-attendance.records', compact(
            'members',
            'attendances',
            'totalMembers',
            'presentCount',
            'absentCount',
            'selectedDate'
        ));
    }
}