<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\ChoirSchedule;
use App\Models\Attendance;
use App\Models\MoneyTransaction;
use App\Models\InventoryItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        // Get current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Financial stats
        $totalIncome = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
        $totalExpense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
        
        $monthlyIncome = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'income')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');
        
        $monthlyExpense = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'expense')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');
        
        $balance = $totalIncome - $totalExpense;
        $monthlyBalance = $monthlyIncome - $monthlyExpense;
        
        // Member stats
        $totalMembers = Member::where('church_id', $churchId)->where('is_deceased', false)->count();
        $choirMembers = Member::where('church_id', $churchId)->where('is_choir', true)->where('is_deceased', false)->count();
        $newMembersThisMonth = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        
        // Today's attendance
        $todayAttendance = Attendance::where('church_id', $churchId)
            ->whereDate('service_date', Carbon::today())
            ->count();
        
        // Recent members
        $recentMembers = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Upcoming birthdays
        $upcomingBirthdays = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->whereNotNull('birthday')
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') >= DATE_FORMAT(NOW(), '%m-%d')")
            ->orderByRaw("DATE_FORMAT(birthday, '%m-%d')")
            ->limit(10)
            ->get();
        
        foreach ($upcomingBirthdays as $birthday) {
            $birthdayDate = Carbon::parse($birthday->birthday);
            $today = Carbon::today();
            $nextBirthday = Carbon::create($today->year, $birthdayDate->month, $birthdayDate->day);
            if ($nextBirthday->lt($today)) {
                $nextBirthday->addYear();
            }
            $birthday->days_until = $today->diffInDays($nextBirthday);
            $birthday->age = $nextBirthday->year - $birthdayDate->year;
        }
        
        // Get upcoming Sunday schedules
        $upcomingSunday = $this->getUpcomingSundaySchedule(0);
        $nextSunday = $this->getUpcomingSundaySchedule(7);
        $followingSunday = $this->getUpcomingSundaySchedule(14);
        
        // Next 4 weeks
        $nextWeeks = [];
        for ($i = 7; $i <= 28; $i += 7) {
            $nextWeeks[] = $this->getUpcomingSundaySchedule($i);
        }
        
        // Recent transactions
        $recentTransactions = MoneyTransaction::where('church_id', $churchId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Recent activities (for compatibility with dashboard view)
        $recentActivities = $recentTransactions;
        
        // Chart data
        $months = [];
        $incomeData = [];
        $expenseData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');
            
            $income = MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'income')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');
            
            $expense = MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'expense')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');
            
            $incomeData[] = $income;
            $expenseData[] = $expense;
        }
        
        return view('dashboard', compact(
            'totalMembers', 'choirMembers', 'newMembersThisMonth', 'todayAttendance',
            'monthlyBalance', 'totalIncome', 'totalExpense', 'balance',
            'monthlyIncome', 'monthlyExpense',
            'recentMembers', 'upcomingBirthdays',
            'upcomingSunday', 'nextSunday', 'followingSunday', 'nextWeeks',
            'recentTransactions', 'recentActivities', 'months', 'incomeData', 'expenseData'
        ));
    }
    
    /**
     * Get the schedule for an upcoming Sunday
     */
    private function getUpcomingSundaySchedule($daysFromNow = 0)
    {
        $churchId = session('current_church_id', auth()->user()->church_id);
        
        // Calculate the target Sunday
        $targetDate = Carbon::now()->addDays($daysFromNow);
        while ($targetDate->dayOfWeek != Carbon::SUNDAY) {
            $targetDate->addDay();
        }
        $dateStr = $targetDate->format('Y-m-d');
        
        // Get the schedule for this date
        $schedule = ChoirSchedule::where('church_id', $churchId)
            ->where('service_date', $dateStr)
            ->with('group')
            ->first();
        
        if (!$schedule || !$schedule->group_id) {
            return [
                'date' => $dateStr,
                'group_name' => 'Not Scheduled',
                'group_color' => '#6b7280',
                'members_count' => 0,
                'members' => collect()
            ];
        }
        
        // Get members directly from the schedule's members relationship
        $members = $schedule->members;
        
        return [
            'date' => $dateStr,
            'group_name' => $schedule->group->name,
            'group_color' => $schedule->group->color,
            'members_count' => $members->count(),
            'members' => $members->take(5)
        ];
    }
    
    /**
     * Get notifications for the authenticated user
     */
    public function getNotifications()
    {
        $user = Auth::user();
        $churchId = session('current_church_id', $user->church_id);
        $today = Carbon::today();
        $next7Days = Carbon::today()->addDays(7);
        
        $notifications = [];
        
        // 1. Check for upcoming birthdays (next 7 days)
        $birthdays = Member::where('church_id', $churchId)
            ->where('is_deceased', false)
            ->whereNotNull('birthday')
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN ? AND ?", [
                $today->format('m-d'),
                $next7Days->format('m-d')
            ])
            ->orderByRaw("DATE_FORMAT(birthday, '%m-%d')")
            ->limit(5)
            ->get();
        
        foreach ($birthdays as $member) {
            $birthDate = Carbon::parse($member->birthday);
            $birthDateThisYear = Carbon::createFromDate($today->year, $birthDate->month, $birthDate->day);
            
            if ($birthDateThisYear->isPast()) {
                $birthDateThisYear->addYear();
            }
            
            $daysUntil = $today->diffInDays($birthDateThisYear);
            
            if ($daysUntil == 0) {
                $message = "🎂 Today is {$member->first_name} {$member->last_name}'s birthday!";
                $timeLabel = "Today";
            } elseif ($daysUntil == 1) {
                $message = "🎂 {$member->first_name} {$member->last_name}'s birthday is tomorrow!";
                $timeLabel = "Tomorrow";
            } else {
                $message = "🎂 {$member->first_name} {$member->last_name}'s birthday is in {$daysUntil} days";
                $timeLabel = "In {$daysUntil} days";
            }
            
            $notifications[] = [
                'id' => 'birthday_' . $member->id,
                'title' => 'Upcoming Birthday 🎂',
                'message' => $message,
                'type' => 'birthday',
                'link' => route('members.show', $member->id),
                'time' => $timeLabel,
                'created_at' => now()->toISOString()
            ];
        }
        
        // 2. Check for upcoming choir schedules (next 7 days)
        $upcomingSchedules = ChoirSchedule::where('church_id', $churchId)
            ->where('service_date', '>=', $today)
            ->where('service_date', '<=', $next7Days)
            ->orderBy('service_date', 'asc')
            ->limit(5)
            ->get();
        
        foreach ($upcomingSchedules as $schedule) {
            $scheduleDate = Carbon::parse($schedule->service_date);
            $daysUntil = $today->diffInDays($scheduleDate);
            
            if ($daysUntil == 0) {
                $timeLabel = "Today";
            } elseif ($daysUntil == 1) {
                $timeLabel = "Tomorrow";
            } else {
                $timeLabel = "In {$daysUntil} days";
            }
            
            $groupName = $schedule->group ? $schedule->group->name : 'Choir';
            
            $notifications[] = [
                'id' => 'schedule_' . $schedule->id,
                'title' => 'Choir Schedule 🎵',
                'message' => "{$groupName} is scheduled for " . $scheduleDate->format('D, M d, Y'),
                'type' => 'schedule',
                'link' => route('choir-schedules.index'),
                'time' => $timeLabel,
                'created_at' => $schedule->created_at
            ];
        }
        
        // 3. Check for attendance reminder (if no attendance recorded for today if it's Sunday)
        if ($today->isSunday()) {
            $todayAttendance = Attendance::where('church_id', $churchId)
                ->whereDate('service_date', $today)
                ->count();
            
            if ($todayAttendance == 0) {
                $notifications[] = [
                    'id' => 'attendance_reminder',
                    'title' => 'Attendance Reminder 📋',
                    'message' => "No attendance recorded for today's Sunday service. Don't forget to mark attendance!",
                    'type' => 'reminder',
                    'link' => route('sunday-attendance.index'),
                    'time' => 'Today',
                    'created_at' => now()->toISOString()
                ];
            }
        }
        
        // 4. Check for low inventory items (if InventoryItem model exists)
        if (class_exists(InventoryItem::class)) {
            $lowInventory = InventoryItem::where('church_id', $churchId)
                ->whereColumn('quantity', '<=', 'reorder_level')
                ->where('reorder_level', '>', 0)
                ->limit(3)
                ->get();
            
            foreach ($lowInventory as $item) {
                $notifications[] = [
                    'id' => 'inventory_' . $item->id,
                    'title' => 'Low Inventory ⚠️',
                    'message' => "{$item->name} is running low! Only {$item->quantity} left.",
                    'type' => 'inventory',
                    'link' => route('inventory.index'),
                    'time' => 'Urgent',
                    'created_at' => now()->toISOString()
                ];
            }
        }
        
        // Sort notifications by urgency
        usort($notifications, function($a, $b) {
            $priority = ['Today' => 0, 'Urgent' => 0, 'Tomorrow' => 1, 'In' => 2];
            $aKey = explode(' ', $a['time'])[0];
            $bKey = explode(' ', $b['time'])[0];
            $aPriority = $priority[$aKey] ?? 3;
            $bPriority = $priority[$bKey] ?? 3;
            return $aPriority - $bPriority;
        });
        
        // Limit to 10 notifications
        $notifications = array_slice($notifications, 0, 10);
        
        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'count' => count($notifications)
        ]);
    }
}