<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ChoirMemberController;
use App\Http\Controllers\ChoirScheduleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SundayAttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AttendanceViewController;
use App\Models\Church;
use App\Models\User;
use App\Models\ChurchSetting;
use App\Http\Controllers\ChurchSettingController;
use App\Http\Controllers\ChoirPracticeController;
use App\Http\Controllers\WeeklyScheduleController;
use App\Http\Controllers\FinanceController;

/*
|--------------------------------------------------------------------------
| Public Route - Redirect to Login (No more "Get Started" landing page)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // If user is already logged in, go to dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // Otherwise, go to login page
    return redirect()->route('login');
})->name('home');

/*
|--------------------------------------------------------------------------
| MANUAL PASSWORD RESET
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password-manual', function () {
    return view('auth.reset-password-manual');
})->name('manual.password.request');

Route::post('/reset-password-manual', function (Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();
    $user->password = bcrypt($request->password);
    $user->save();

    return redirect()->route('login')->with('success', 'Password changed successfully!');
})->name('manual.password.update');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| CHURCH MANAGEMENT SYSTEM ROUTES (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::delete('/inventory/destroy/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    
    // Members
    Route::resource('members', MemberController::class);
    
    // DECEASED MEMBER ROUTES
    Route::put('/members/{member}/deceased', [MemberController::class, 'markAsDeceased'])->name('members.deceased');
    Route::put('/members/{member}/restore', [MemberController::class, 'restoreFromDeceased'])->name('members.restore');
    
    // Attendance
    Route::resource('attendance', AttendanceController::class);
    
    // Choir Members
    Route::resource('choir-members', ChoirMemberController::class);
    
    // ==============================================
    // CHOIR SCHEDULES & GROUPS
    // ==============================================
    
    // Choir Groups Management Routes
    Route::get('/choir-schedules/groups', [ChoirScheduleController::class, 'groups'])->name('choir-schedules.groups');
    Route::post('/choir-schedules/groups', [ChoirScheduleController::class, 'storeGroup'])->name('choir-schedules.groups.store');
    Route::put('/choir-schedules/groups/{id}', [ChoirScheduleController::class, 'updateGroup'])->name('choir-schedules.groups.update');
    Route::delete('/choir-schedules/groups/{id}', [ChoirScheduleController::class, 'destroyGroup'])->name('choir-schedules.groups.destroy');
    Route::post('/choir-schedules/assign-member', [ChoirScheduleController::class, 'assignMemberToGroup'])->name('choir-schedules.assign-member');
    Route::delete('/choir-schedules/remove-member/{memberId}', [ChoirScheduleController::class, 'removeMemberFromGroup'])->name('choir-schedules.remove-member');
    Route::post('/choir-schedules/auto-rotate', [ChoirScheduleController::class, 'autoRotate'])->name('choir-schedules.auto-rotate');
    Route::post('/choir-schedules/update-rotation', [ChoirScheduleController::class, 'updateRotationOrder'])->name('choir-schedules.update-rotation');
    
    // Choir Schedules Resource Route
    Route::resource('choir-schedules', ChoirScheduleController::class);
    
    // Additional schedule routes
    Route::post('/choir-schedules/auto-schedule', [ChoirScheduleController::class, 'autoSchedule'])->name('choir-schedules.auto-schedule');
    Route::post('/choir-schedules/generate-alternating', [ChoirScheduleController::class, 'generateAlternatingScheduleForAll'])->name('choir-schedules.generate-alternating');
    
    // ==============================================
    // MODAL POPUP ROUTES
    // ==============================================
    Route::get('/choir-schedules/get-schedule/{date}', [ChoirScheduleController::class, 'getScheduleByDate'])->name('choir-schedules.get-schedule');
    Route::post('/choir-schedules/add-member', [ChoirScheduleController::class, 'addMemberToSchedule'])->name('choir-schedules.add-member');
    Route::delete('/choir-schedules/remove-member', [ChoirScheduleController::class, 'removeMemberFromSchedule'])->name('choir-schedules.remove-member');
    Route::post('/choir-schedules/store-direct', [ChoirScheduleController::class, 'storeDirect'])->name('choir-schedules.store-direct');
    
    // ==============================================
    // SUNDAY ATTENDANCE ROUTES
    // ==============================================
    Route::get('/sunday-attendance', [SundayAttendanceController::class, 'index'])->name('sunday-attendance.index');
    Route::get('/sunday-attendance/entry/{date}', [SundayAttendanceController::class, 'create'])->name('sunday-attendance.entry');
    Route::post('/sunday-attendance', [SundayAttendanceController::class, 'store'])->name('sunday-attendance.store');
    Route::get('/sunday-attendance/get-attendance', [SundayAttendanceController::class, 'getAttendance'])->name('sunday-attendance.get-attendance');
    Route::get('/sunday-attendance/report', [SundayAttendanceController::class, 'report'])->name('sunday-attendance.report');
    Route::get('/sunday-attendance/records', [SundayAttendanceController::class, 'records'])->name('sunday-attendance.records');
    
    // Church Settings Routes
    Route::post('/settings/profile', [ChurchSettingController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/logo', [ChurchSettingController::class, 'updateLogo'])->name('settings.logo.update');
    Route::delete('/settings/logo', [ChurchSettingController::class, 'removeLogo'])->name('settings.logo.remove');
    
    // Choir Practices Routes
    Route::get('/choir-practices/get', [ChoirPracticeController::class, 'getPractices'])->name('choir.practices.get');
    Route::post('/choir-practices/store', [ChoirPracticeController::class, 'store'])->name('choir.practices.store');
    Route::delete('/choir-practices/{id}', [ChoirPracticeController::class, 'destroy'])->name('choir.practices.delete');
    
    // Weekly Schedules Routes
    Route::get('/weekly-schedules/get', [WeeklyScheduleController::class, 'getSchedules'])->name('weekly.schedules.get');
    Route::post('/weekly-schedules/store', [WeeklyScheduleController::class, 'store'])->name('weekly.schedules.store');
    Route::delete('/weekly-schedules/{id}', [WeeklyScheduleController::class, 'destroy'])->name('weekly.schedules.delete');
    
    // Finance Routes
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('/finance/store', [FinanceController::class, 'store'])->name('finance.store');
    Route::delete('/finance/{id}', [FinanceController::class, 'destroy'])->name('finance.destroy');
    
    // Reports & Analytics Route
    Route::get('/reports/analytics', [FinanceController::class, 'reportsAnalytics'])->name('reports.analytics');
    
    // NOTIFICATION ROUTES
    Route::get('/notifications', [DashboardController::class, 'getNotifications'])->name('notifications.get');
    Route::post('/notifications/mark-read', [DashboardController::class, 'markNotificationsAsRead'])->name('notifications.mark-read');
    
    // Profile Picture Routes
    Route::post('/profile/picture/upload', [ProfilePictureController::class, 'upload'])->name('profile.picture.upload');
    Route::delete('/profile/picture/remove', [ProfilePictureController::class, 'remove'])->name('profile.picture.remove');
    // ==============================================
    // MESSAGING ROUTES FOR CHURCH COMMUNICATION
    // ==============================================
    
    // Send a message
    Route::post('/messages/store', function (Request $request) {
        $user = Auth::user();
        if (!$user || !$user->church_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        
        $request->validate([
            'receiver_church_id' => 'required|exists:churches,id',
            'message' => 'required|string|max:1000',
        ]);
        
        $message = \App\Models\Message::create([
            'church_id' => $request->sender_church_id ?? $user->church_id,
            'sender_id' => $user->id,
            'receiver_church_id' => $request->receiver_church_id,
            'message' => $request->message,
            'is_read' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'sender_name' => $user->church->name ?? 'You',
                'sender_church_id' => $user->church_id,
                'message' => $message->message,
                'is_read' => false,
                'created_at' => 'Just now',
                'is_own' => true,
            ]
        ]);
    })->name('messages.store');
    
    // Mark message as read
    Route::post('/messages/mark-read', function (Request $request) {
        $request->validate([
            'message_id' => 'required|exists:messages,id',
        ]);
        
        $message = \App\Models\Message::find($request->message_id);
        if ($message && ($message->receiver_church_id == auth()->user()->church_id)) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Message not found or unauthorized']);
    })->name('messages.mark-read');
    
    // Delete a message
    Route::delete('/messages/delete', function (Request $request) {
        $request->validate([
            'message_id' => 'required|exists:messages,id',
        ]);
        
        $message = \App\Models\Message::find($request->message_id);
        if ($message && ($message->church_id == auth()->user()->church_id || $message->receiver_church_id == auth()->user()->church_id)) {
            $message->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Message not found or unauthorized']);
    })->name('messages.delete');
    
    // Get unread message count for notification badge
    Route::get('/messages/unread-count', function () {
        $user = Auth::user();
        if (!$user || !$user->church_id) {
            return response()->json(['unread_count' => 0]);
        }
        
        try {
            if (class_exists('App\Models\Message')) {
                $count = \App\Models\Message::where('receiver_church_id', $user->church_id)
                    ->where('is_read', false)
                    ->count();
                return response()->json(['unread_count' => $count]);
            }
        } catch (\Exception $e) {
            // Silently fail if table doesn't exist
        }
        
        return response()->json(['unread_count' => 0]);
    })->name('messages.unread-count');
});

/*
|--------------------------------------------------------------------------
| LOGIN & REGISTER ROUTES (Guest)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->church_id) {
                session(['current_church_id' => $user->church_id]);
                // Get church name and store in session
                $church = Church::find($user->church_id);
                if ($church) {
                    session(['current_church_name' => $church->name]);
                }
            }
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ])->onlyInput('email');
    });

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    // COMPLETE REGISTRATION ROUTE WITH CHURCH SETTINGS (NO EMAIL FIELD)
    Route::post('/register', function (Request $request) {
        $request->validate([
            'church_name' => 'required|string|max:255',
            'subdomain' => 'required|string|unique:churches,subdomain',
            'denomination' => 'nullable|string|max:255',
            'church_location' => 'nullable|string|max:255',
            'church_email' => 'nullable|email|max:255',
            'church_phone' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 1. CREATE CHURCH
        $church = Church::create([
            'name' => $request->church_name,
            'subdomain' => $request->subdomain,
            'denomination' => $request->denomination,
            'location' => $request->church_location,
            'email' => $request->church_email,
            'phone' => $request->church_phone,
            'is_active' => true,
        ]);

        // 2. CREATE CHURCH SETTINGS (NO EMAIL FIELD)
        ChurchSetting::create([
            'church_id' => $church->id,
            'church_name' => $request->church_name,
            'tagline' => 'Church Management System',
            'address' => $request->church_location,
            'phone' => $request->church_phone,
        ]);

        // 3. CREATE USER
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'church_id' => $church->id,
            'role' => 'church_admin',
        ]);

        // 4. LOGIN USER
        Auth::login($user);
        
        // 5. SET SESSION VARIABLES
        session([
            'current_church_id' => $church->id,
            'current_church_name' => $request->church_name,
        ]);

        // 6. REDIRECT TO DASHBOARD
        return redirect('/dashboard')->with('success', 'Welcome to ' . $request->church_name . '! Your church has been successfully registered.');
    });
});

/*
|--------------------------------------------------------------------------
| DEBUG ROUTES (Remove after testing)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/debug-church', function () {
        $user = auth()->user();
        $sessionChurchId = session('current_church_id');
        $usedChurchId = $sessionChurchId ?: $user->church_id;
        
        $income = App\Models\MoneyTransaction::where('church_id', $usedChurchId)->where('type', 'income')->sum('amount');
        $expense = App\Models\MoneyTransaction::where('church_id', $usedChurchId)->where('type', 'expense')->sum('amount');
        
        $churches = App\Models\Church::all();
        $churchBalances = [];
        foreach ($churches as $church) {
            $churchIncome = App\Models\MoneyTransaction::where('church_id', $church->id)->where('type', 'income')->sum('amount');
            $churchExpense = App\Models\MoneyTransaction::where('church_id', $church->id)->where('type', 'expense')->sum('amount');
            $churchBalances[] = [
                'church_id' => $church->id,
                'church_name' => $church->name,
                'income' => number_format($churchIncome, 2),
                'expense' => number_format($churchExpense, 2),
                'balance' => number_format($churchIncome - $churchExpense, 2),
            ];
        }
        
        $users = App\Models\User::select('id', 'name', 'email', 'church_id', 'role')->get();
        
        return response()->json([
            'logged_in_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'church_id' => $user->church_id,
                'role' => $user->role,
            ],
            'session' => [
                'current_church_id' => $sessionChurchId,
            ],
            'used_church_id' => $usedChurchId,
            'current_church_balance' => [
                'income' => number_format($income, 2),
                'expense' => number_format($expense, 2),
                'balance' => number_format($income - $expense, 2),
            ],
            'all_churches_balances' => $churchBalances,
            'all_users' => $users,
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| EMERGENCY RESET (Remove in production)
|--------------------------------------------------------------------------
*/

Route::get('/quick-reset/{email}/{newpassword}', function ($email, $newpassword) {
    $user = User::where('email', $email)->first();
    if ($user) {
        $user->password = bcrypt($newpassword);
        $user->save();
        return "Password for {$email} has been reset to: {$newpassword}";
    }
    return "User not found!";
});

Route::get('/test-member-controller', function() {
    try {
        $members = App\Models\Member::paginate(5);
        
        return [
            'success' => true,
            'members_count' => $members->count(),
            'total_members' => App\Models\Member::count()
        ];
    } catch (Exception $e) {
        return [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ];
    }
});

Route::get('/simple-members', function() {
    return "Simple test working!";
});