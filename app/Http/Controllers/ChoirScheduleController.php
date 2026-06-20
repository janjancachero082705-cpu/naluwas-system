<?php

namespace App\Http\Controllers;

use App\Models\ChoirGroup;
use App\Models\ChoirSchedule;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChoirScheduleController extends Controller
{
    public function index(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        // Get the month parameter
        $monthParam = $request->get('month', Carbon::now()->format('Y-m'));
        
        if (strpos($monthParam, '-') !== false) {
            $parts = explode('-', $monthParam);
            $selectedYear = (int) $parts[0];
            $selectedMonth = (int) $parts[1];
        } else {
            $selectedYear = (int) $request->get('year', Carbon::now()->year);
            $selectedMonth = (int) $monthParam;
        }
        
        if ($selectedMonth < 1 || $selectedMonth > 12) {
            $selectedMonth = Carbon::now()->month;
        }
        
        $selectedDate = $request->get('date', Carbon::now()->format('Y-m-d'));
        
        // Get all active groups
        $groups = ChoirGroup::where('church_id', $churchId)
            ->where('is_active', true)
            ->orderBy('rotation_order')
            ->get();
        
        // =============================================
        // DELETE: Past months schedules only
        // =============================================
        $this->deletePastSchedules($churchId);
        
        // =============================================
        // GENERATE: All schedules (current + future) if they don't exist
        // =============================================
        $this->generateAllSchedules($churchId, $groups);
        
        // Generate available months for dropdown
        $availableMonths = [];
        $start = Carbon::now()->subMonths(12);
        $end = Carbon::now()->addMonths(12);
        
        for ($date = $start->copy(); $date <= $end; $date->addMonth()) {
            $availableMonths[] = [
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y'),
            ];
        }
        
        $selectedMonthYear = $selectedYear . '-' . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT);
        
        // Get rotation order for display
        $rotationOrder = [];
        foreach ($groups as $group) {
            $rotationOrder[] = [
                'position' => $group->rotation_order,
                'group_name' => $group->name,
                'color' => $group->color
            ];
        }
        
        // Get schedules for the selected month
        $schedules = ChoirSchedule::where('church_id', $churchId)
            ->whereYear('service_date', $selectedYear)
            ->whereMonth('service_date', $selectedMonth)
            ->with(['group', 'members'])
            ->get()
            ->keyBy('service_date');
        
        // Build sundays data
        $sundays = [];
        $currentDate = Carbon::create($selectedYear, $selectedMonth, 1);
        $endDate = $currentDate->copy()->endOfMonth();
        
        while ($currentDate <= $endDate) {
            if ($currentDate->dayOfWeek == Carbon::SUNDAY) {
                $dateStr = $currentDate->format('Y-m-d');
                $schedule = $schedules->get($dateStr);
                
                if ($schedule) {
                    $sundays[] = [
                        'date' => $dateStr,
                        'has_schedule' => true,
                        'group' => $schedule->group,
                        'members' => $schedule->members,
                    ];
                } else {
                    // Try to generate schedule on the fly for this specific Sunday
                    if ($groups->count() > 0) {
                        $firstSundayOfYear = Carbon::create($selectedYear, 1, 1)->next(Carbon::SUNDAY);
                        $currentSunday = Carbon::parse($dateStr);
                        $weeksDiff = $firstSundayOfYear->diffInWeeks($currentSunday);
                        $groupIndex = $weeksDiff % $groups->count();
                        $assignedGroup = $groups[$groupIndex];
                        
                        // Create the schedule
                        $schedule = ChoirSchedule::updateOrCreate(
                            [
                                'church_id' => $churchId,
                                'service_date' => $dateStr
                            ],
                            [
                                'group_id' => $assignedGroup->id
                            ]
                        );
                        
                        // Add members
                        $groupMembers = Member::where('church_id', $churchId)
                            ->where('choir_group_id', $assignedGroup->id)
                            ->where('is_choir', true)
                            ->where('is_deceased', false)
                            ->get();
                        
                        $schedule->members()->sync($groupMembers->pluck('id')->toArray());
                        
                        $sundays[] = [
                            'date' => $dateStr,
                            'has_schedule' => true,
                            'group' => $assignedGroup,
                            'members' => $groupMembers
                        ];
                    } else {
                        $sundays[] = [
                            'date' => $dateStr,
                            'has_schedule' => false,
                            'group' => null,
                            'members' => []
                        ];
                    }
                }
            }
            $currentDate->addDay();
        }
        
        // Stats
        $totalChoirMembers = Member::where('church_id', $churchId)
            ->where('is_choir', true)
            ->where('is_deceased', false)
            ->count();
        
        $totalGroups = ChoirGroup::where('church_id', $churchId)->where('is_active', true)->count();
        
        $thisMonthSchedules = ChoirSchedule::where('church_id', $churchId)
            ->whereYear('service_date', Carbon::now()->year)
            ->whereMonth('service_date', Carbon::now()->month)
            ->count();
        
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = ['value' => $i, 'name' => Carbon::create(null, $i, 1)->format('F')];
        }
        
        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 2);
        
        return view('choir-schedules.index', compact(
            'selectedYear', 
            'selectedMonth', 
            'selectedDate', 
            'sundays', 
            'totalChoirMembers', 
            'totalGroups', 
            'thisMonthSchedules', 
            'months', 
            'years', 
            'rotationOrder', 
            'groups',
            'availableMonths',
            'selectedMonthYear'
        ));
    }
    
    private function deletePastSchedules($churchId)
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        
        ChoirSchedule::where('church_id', $churchId)
            ->where('service_date', '<', $currentMonthStart->format('Y-m-d'))
            ->delete();
    }
    
    private function generateAllSchedules($churchId, $groups)
    {
        if ($groups->isEmpty()) {
            return;
        }
        
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->addMonths(12)->endOfMonth();
        
        $currentDate = $startDate->copy();
        $totalGroups = $groups->count();
        
        $firstSundayOfYear = Carbon::create($startDate->year, 1, 1)->next(Carbon::SUNDAY);
        
        while ($currentDate <= $endDate) {
            if ($currentDate->dayOfWeek == Carbon::SUNDAY) {
                $dateStr = $currentDate->format('Y-m-d');
                
                $existingSchedule = ChoirSchedule::where('church_id', $churchId)
                    ->where('service_date', $dateStr)
                    ->first();
                
                if (!$existingSchedule) {
                    $weeksDiff = $firstSundayOfYear->diffInWeeks($currentDate);
                    $groupIndex = $weeksDiff % $totalGroups;
                    $assignedGroup = $groups[$groupIndex];
                    
                    $schedule = ChoirSchedule::updateOrCreate(
                        [
                            'church_id' => $churchId,
                            'service_date' => $dateStr
                        ],
                        [
                            'group_id' => $assignedGroup->id
                        ]
                    );
                    
                    $groupMembers = Member::where('church_id', $churchId)
                        ->where('choir_group_id', $assignedGroup->id)
                        ->where('is_choir', true)
                        ->where('is_deceased', false)
                        ->get();
                    
                    $schedule->members()->sync($groupMembers->pluck('id')->toArray());
                }
            }
            $currentDate->addDay();
        }
    }
    
    public function getScheduleByDate($date)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $schedule = ChoirSchedule::where('church_id', $churchId)
            ->where('service_date', $date)
            ->with('members')
            ->first();
        
        $scheduledMembers = [];
        if ($schedule) {
            $scheduledMembers = $schedule->members->map(function($member) {
                return [
                    'id' => $member->id,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'choir_role' => $member->choir_role ?? 'Singer',
                    'avatar' => strtoupper(substr($member->first_name, 0, 1)) . strtoupper(substr($member->last_name, 0, 1))
                ];
            });
        }
        
        $scheduledMemberIds = $schedule ? $schedule->members->pluck('id')->toArray() : [];
        
        $availableMembers = Member::where('church_id', $churchId)
            ->where('is_choir', true)
            ->where('is_deceased', false)
            ->whereNotIn('id', $scheduledMemberIds)
            ->orderBy('first_name')
            ->get()
            ->map(function($member) {
                return [
                    'id' => $member->id,
                    'first_name' => $member->first_name,
                    'last_name' => $member->last_name,
                    'choir_role' => $member->choir_role ?? 'Singer',
                    'avatar' => strtoupper(substr($member->first_name, 0, 1)) . strtoupper(substr($member->last_name, 0, 1))
                ];
            });
        
        return response()->json([
            'success' => true,
            'scheduled_members' => $scheduledMembers,
            'available_members' => $availableMembers,
            'has_schedule' => !is_null($schedule)
        ]);
    }
    
    public function addMemberToSchedule(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $request->validate([
            'service_date' => 'required|date',
            'member_id' => 'required|exists:members,id'
        ]);
        
        $serviceDate = $request->service_date;
        $memberId = $request->member_id;
        
        $schedule = ChoirSchedule::where('church_id', $churchId)
            ->where('service_date', $serviceDate)
            ->first();
        
        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Schedule not found.']);
        }
        
        if ($schedule->members()->where('member_id', $memberId)->exists()) {
            return response()->json(['success' => false, 'message' => 'Member already scheduled.']);
        }
        
        $schedule->members()->attach($memberId);
        
        return response()->json(['success' => true, 'message' => 'Member added!']);
    }
    
    public function removeMemberFromSchedule(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $request->validate([
            'service_date' => 'required|date',
            'member_id' => 'required|exists:members,id'
        ]);
        
        $serviceDate = $request->service_date;
        $memberId = $request->member_id;
        
        $schedule = ChoirSchedule::where('church_id', $churchId)
            ->where('service_date', $serviceDate)
            ->first();
        
        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Schedule not found.']);
        }
        
        $schedule->members()->detach($memberId);
        
        return response()->json(['success' => true, 'message' => 'Member removed!']);
    }
    
    // Groups Management
    public function groups()
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $groups = ChoirGroup::where('church_id', $churchId)
            ->with('members')
            ->orderBy('rotation_order')
            ->get();
        
        foreach ($groups as $group) {
            $group->member_count = $group->members->count();
            $group->roles_count = $group->members->whereNotNull('choir_role')->count();
        }
        
        $unassignedMembers = Member::where('church_id', $churchId)
            ->where('is_choir', true)
            ->where('is_deceased', false)
            ->whereNull('choir_group_id')
            ->orderBy('first_name')
            ->get();
        
        return view('choir-schedules.groups', compact('groups', 'unassignedMembers'));
    }
    
    public function storeGroup(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string'
        ]);
        
        $maxOrder = ChoirGroup::where('church_id', $churchId)->max('rotation_order') ?? 0;
        
        $group = ChoirGroup::create([
            'church_id' => $churchId,
            'name' => $request->name,
            'color' => $request->color ?? '#8b5cf6',
            'rotation_order' => $maxOrder + 1,
            'is_active' => true
        ]);
        
        $this->deletePastSchedules($churchId);
        $groups = ChoirGroup::where('church_id', $churchId)->where('is_active', true)->orderBy('rotation_order')->get();
        $this->generateAllSchedules($churchId, $groups);
        
        return redirect()->route('choir-schedules.groups')->with('success', 'Group created! Schedules updated.');
    }
    
    public function updateGroup(Request $request, $id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $group = ChoirGroup::where('id', $id)->where('church_id', $churchId)->firstOrFail();
        
        $group->update([
            'name' => $request->name,
            'color' => $request->color ?? $group->color,
            'is_active' => $request->has('is_active')
        ]);
        
        $this->deletePastSchedules($churchId);
        $groups = ChoirGroup::where('church_id', $churchId)->where('is_active', true)->orderBy('rotation_order')->get();
        $this->generateAllSchedules($churchId, $groups);
        
        return redirect()->route('choir-schedules.groups')->with('success', 'Group updated! Schedules updated.');
    }
    
    public function destroyGroup($id)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $group = ChoirGroup::where('id', $id)->where('church_id', $churchId)->firstOrFail();
        
        Member::where('choir_group_id', $group->id)->update(['choir_group_id' => null]);
        ChoirSchedule::where('group_id', $group->id)->update(['group_id' => null]);
        
        $group->delete();
        
        $this->deletePastSchedules($churchId);
        $groups = ChoirGroup::where('church_id', $churchId)->where('is_active', true)->orderBy('rotation_order')->get();
        $this->generateAllSchedules($churchId, $groups);
        
        return redirect()->route('choir-schedules.groups')->with('success', 'Group deleted! Schedules updated.');
    }
    
    public function assignMemberToGroup(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'group_id' => 'required|exists:choir_groups,id'
        ]);
        
        $member = Member::where('id', $request->member_id)->where('church_id', $churchId)->firstOrFail();
        $group = ChoirGroup::where('id', $request->group_id)->where('church_id', $churchId)->firstOrFail();
        
        $member->update(['choir_group_id' => $group->id, 'is_choir' => true]);
        
        $this->deletePastSchedules($churchId);
        $groups = ChoirGroup::where('church_id', $churchId)->where('is_active', true)->orderBy('rotation_order')->get();
        $this->generateAllSchedules($churchId, $groups);
        
        return response()->json(['success' => true, 'message' => 'Member assigned! Schedules updated.']);
    }
    
    public function removeMemberFromGroup($memberId)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $member = Member::where('id', $memberId)->where('church_id', $churchId)->firstOrFail();
        $member->update(['choir_group_id' => null]);
        
        $this->deletePastSchedules($churchId);
        $groups = ChoirGroup::where('church_id', $churchId)->where('is_active', true)->orderBy('rotation_order')->get();
        $this->generateAllSchedules($churchId, $groups);
        
        return response()->json(['success' => true, 'message' => 'Member removed! Schedules updated.']);
    }
    
    public function updateRotationOrder(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        $request->validate(['order' => 'required|array']);
        
        foreach ($request->order as $index => $groupId) {
            ChoirGroup::where('id', $groupId)->where('church_id', $churchId)
                ->update(['rotation_order' => $index + 1]);
        }
        
        $this->deletePastSchedules($churchId);
        $groups = ChoirGroup::where('church_id', $churchId)->where('is_active', true)->orderBy('rotation_order')->get();
        $this->generateAllSchedules($churchId, $groups);
        
        return response()->json(['success' => true, 'message' => 'Rotation order saved! Schedules updated.']);
    }
}