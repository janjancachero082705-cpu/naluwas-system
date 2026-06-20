<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\ChoirSchedule;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();
        $churchId = $user->church_id;
        
        $notifications = [];
        
        // 1. Check for upcoming birthdays (next 7 days)
        $today = Carbon::today();
        $next7Days = Carbon::today()->addDays(7);
        
        $birthdays = Member::where('church_id', $churchId)
            ->whereRaw("DATE_FORMAT(birth_date, '%m-%d') BETWEEN ? AND ?", [
                $today->format('m-d'),
                $next7Days->format('m-d')
            ])
            ->orWhereRaw("DATE_FORMAT(birth_date, '%m-%d') >= ?", [$today->format('m-d')])
            ->orderByRaw("DATE_FORMAT(birth_date, '%m-%d')")
            ->limit(5)
            ->get();
        
        foreach ($birthdays as $member) {
            $birthDate = Carbon::parse($member->birth_date);
            $daysUntil = $today->diffInDays(Carbon::createFromDate($today->year, $birthDate->month, $birthDate->day));
            
            if ($daysUntil == 0) {
                $message = "🎂 Today is {$member->first_name} {$member->last_name}'s birthday!";
            } elseif ($daysUntil == 1) {
                $message = "🎂 {$member->first_name} {$member->last_name}'s birthday is tomorrow!";
            } else {
                $message = "🎂 {$member->first_name} {$member->last_name}'s birthday is in {$daysUntil} days";
            }
            
            $notifications[] = [
                'id' => 'birthday_' . $member->id,
                'title' => 'Upcoming Birthday',
                'message' => $message,
                'type' => 'birthday',
                'link' => route('members.show', $member->id),
                'time' => $daysUntil == 0 ? 'Today' : ($daysUntil == 1 ? 'Tomorrow' : "In {$daysUntil} days"),
                'created_at' => now()->toISOString()
            ];
        }
        
        // 2. Check for upcoming choir schedules (next 7 days)
        $upcomingSchedules = ChoirSchedule::where('church_id', $churchId)
            ->where('schedule_date', '>=', $today)
            ->where('schedule_date', '<=', $next7Days)
            ->with('choirMembers')
            ->orderBy('schedule_date', 'asc')
            ->limit(5)
            ->get();
        
        foreach ($upcomingSchedules as $schedule) {
            $scheduleDate = Carbon::parse($schedule->schedule_date);
            $daysUntil = $today->diffInDays($scheduleDate);
            
            $notifications[] = [
                'id' => 'schedule_' . $schedule->id,
                'title' => 'Choir Schedule',
                'message' => "🎵 {$schedule->title} on " . $scheduleDate->format('D, M d, Y'),
                'type' => 'schedule',
                'link' => route('choir-schedules.index'),
                'time' => $daysUntil == 0 ? 'Today' : ($daysUntil == 1 ? 'Tomorrow' : "In {$daysUntil} days"),
                'created_at' => $schedule->created_at
            ];
        }
        
        // 3. Check for recent attendance (if no attendance recorded for today)
        $todayAttendance = Attendance::where('church_id', $churchId)
            ->whereDate('service_date', $today)
            ->count();
        
        if ($todayAttendance == 0) {
            $notifications[] = [
                'id' => 'attendance_reminder',
                'title' => 'Attendance Reminder',
                'message' => "📋 No attendance recorded for today. Don't forget to mark attendance!",
                'type' => 'reminder',
                'link' => route('sunday-attendance.index'),
                'time' => 'Today',
                'created_at' => now()->toISOString()
            ];
        }
        
        // Sort notifications by time (most urgent first)
        usort($notifications, function($a, $b) {
            $priority = ['Today' => 0, 'Tomorrow' => 1, 'In' => 2];
            $aPriority = isset($priority[explode(' ', $a['time'])[0]]) ? $priority[explode(' ', $a['time'])[0]] : 3;
            $bPriority = isset($priority[explode(' ', $b['time'])[0]]) ? $priority[explode(' ', $b['time'])[0]] : 3;
            return $aPriority - $bPriority;
        });
        
        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'count' => count($notifications)
        ]);
    }
    
    public function markAsRead($id)
    {
        // Store read notifications in session or database
        $readNotifications = session()->get('read_notifications', []);
        if (!in_array($id, $readNotifications)) {
            $readNotifications[] = $id;
            session()->put('read_notifications', $readNotifications);
        }
        
        return response()->json(['success' => true]);
    }
}