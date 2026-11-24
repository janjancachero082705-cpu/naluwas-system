<?php



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChurchSettingController;
use App\Http\Controllers\WeeklyScheduleController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SettingsController;
use App\Models\Church;
use App\Models\User;
use App\Models\ChurchSetting;

// TINC welcome page (gibutang sa taas aron mao ang unang mo-match)
Route::get('/', function () {
    if (auth()->check() && Route::has('dashboard')) {
        return redirect()->route('dashboard');
    }
    return view('tinc-welcome');
})->name('tinc.welcome');

/*
|--------------------------------------------------------------------------
| Public Route - Redirect to Login
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
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
| AUTHENTICATED USER ROUTES (Profile & Account)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Profile page


    // Profile update (AJAX ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã‚Â¡ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â used by the profile page)



    // ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¦ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã¢â‚¬Å“ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¦ NEW: Language update from profile page


    // Password update (from security modal)
    Route::post('/password/update', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Account deletion


    // Profile picture (both aliases for compatibility)

  // alias


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

    // ============================================
    // SETTINGS - Language & Security
    // ============================================
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::post('/language', [SettingsController::class, 'updateLanguage'])->name('language');
        Route::post('/two-factor', [SettingsController::class, 'toggleTwoFactor'])->name('two-factor');
        Route::post('/session-timeout', [SettingsController::class, 'updateSessionTimeout'])->name('session-timeout');
        Route::post('/password', [SettingsController::class, 'updatePassword'])->name('password');
        Route::post('/logout-all', [SettingsController::class, 'logoutAllSessions'])->name('logout-all');
    });

    // ============================================
    // INVENTORY / FINANCE ROUTES - COMPLETE CRUD
    // ============================================
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');

    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::delete('/inventory/destroy/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy.alt');

    Route::get('/inventory/transaction/{id}', [InventoryController::class, 'getTransaction'])->name('inventory.transaction.get');
    Route::put('/inventory/transaction/{id}', [InventoryController::class, 'updateTransaction'])->name('inventory.transaction.update');
    Route::delete('/inventory/transaction/{id}', [InventoryController::class, 'destroyTransaction'])->name('inventory.transaction.destroy');

    Route::get('/inventory/balance', [InventoryController::class, 'getBalance'])->name('inventory.balance');
    Route::get('/inventory/transactions', [InventoryController::class, 'getTransactions'])->name('inventory.transactions');
    Route::get('/inventory/export-data', [InventoryController::class, 'exportData'])->name('inventory.export-data');

    // ============================================
    // MEMBERS
    // ============================================
    Route::resource('members', MemberController::class);
    Route::put('/members/{member}/deceased', [MemberController::class, 'markAsDeceased'])->name('members.deceased');
    Route::put('/members/{member}/restore', [MemberController::class, 'restoreFromDeceased'])->name('members.restore');

    // ============================================
    // ============================================

    // ============================================
    // ============================================



    // ============================================
    // ============================================

    // ============================================
    // CHURCH SETTINGS
    // ============================================

    Route::post('/settings/logo', [ChurchSettingController::class, 'updateLogo'])->name('settings.logo.update');
    Route::delete('/settings/logo', [ChurchSettingController::class, 'removeLogo'])->name('settings.logo.remove');

    // ============================================
    // ============================================

    // ============================================
    // WEEKLY SCHEDULES
    // ============================================
    Route::get('/weekly-schedules/get', [WeeklyScheduleController::class, 'getSchedules'])->name('weekly.schedules.get');
    Route::post('/weekly-schedules/store', [WeeklyScheduleController::class, 'store'])->name('weekly.schedules.store');
    Route::delete('/weekly-schedules/{id}', [WeeklyScheduleController::class, 'destroy'])->name('weekly.schedules.delete');

    // ============================================
    // FINANCE
    // ============================================
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');

    Route::get('/reports/analytics', [FinanceController::class, 'reportsAnalytics'])->name('reports.analytics');

    // ============================================
    // NOTIFICATIONS
    // ============================================
    Route::get('/notifications', [DashboardController::class, 'getNotifications'])->name('notifications.get');
    Route::post('/notifications/mark-read', [DashboardController::class, 'markNotificationsAsRead'])->name('notifications.mark-read');

    // ============================================
    // MESSAGING SYSTEM
    // ============================================
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/unread-count', [MessageController::class, 'unreadCount'])->name('unread-count');
        Route::post('/mark-all-read', [MessageController::class, 'markAllRead'])->name('mark-all-read');
        Route::get('/create', [MessageController::class, 'create'])->name('create');
        Route::post('/', [MessageController::class, 'store'])->name('store');
        Route::get('/{id}', [MessageController::class, 'show'])->name('show');
        Route::get('/conversation/{churchId}', [MessageController::class, 'conversation'])->name('conversation');
        Route::post('/{id}/read', [MessageController::class, 'markRead'])->name('mark-read');
        Route::post('/{id}/archive', [MessageController::class, 'archive'])->name('archive');
        Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
    });
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

            // ÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã†â€™ÃƒÂ¢Ã¢â€šÂ¬Ã‚Â¦ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â‚¬Å¡Ã‚Â¬Ãƒâ€¦Ã¢â‚¬Å“ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¢ÃƒÆ’Ã‚Â¢ÃƒÂ¢Ã¢â€šÂ¬Ã…Â¡Ãƒâ€šÃ‚Â¬ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¦ Track last login
            $user->last_login_at = now();
            $user->last_activity = now();
            $user->save();

            if ($user->church_id) {
                session(['current_church_id' => $user->church_id]);
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

        $church = Church::create([
            'name' => $request->church_name,
            'subdomain' => $request->subdomain,
            'denomination' => $request->denomination,
            'location' => $request->church_location,
            'email' => $request->church_email,
            'phone' => $request->church_phone,
            'is_active' => true,
        ]);

        ChurchSetting::create([
            'church_id' => $church->id,
            'church_name' => $request->church_name,
            'tagline' => 'Church Management System',
            'address' => $request->church_location,
            'phone' => $request->church_phone,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'church_id' => $church->id,
            'role' => 'church_admin',
        ]);

        Auth::login($user);

        session([
            'current_church_id' => $church->id,
            'current_church_name' => $request->church_name,
        ]);

        return redirect('/dashboard')->with('success', 'Welcome to ' . $request->church_name . '! Your church has been successfully registered.');
    });
});
// ==========================================
// PROFILE ROUTES (Gi-dugang para mo-gana)
// ==========================================
Route::middleware(['auth'])->group(function () {



});
// ==========================================
// PROFILE ROUTES (LIMPYO UG SAKTONG METHOD)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::match(['put', 'patch'], '/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});
Route::post('/ai-chat', [\App\Http\Controllers\AiChatController::class, 'send'])->middleware('auth');

Route::get('/ai', fn () => view('ai-chat'))->middleware('auth');

// ===== Inventory (funds) =====
Route::middleware(['auth'])->prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/', [\App\Http\Controllers\InventoryController::class, 'index'])->name('index');
    Route::get('/export', [\App\Http\Controllers\InventoryController::class, 'export'])->name('export');

    Route::middleware('throttle:30,1')->group(function () {
        Route::post('/collections', [\App\Http\Controllers\InventoryController::class, 'storeCollection'])->name('collections.store');
        Route::post('/deductions',  [\App\Http\Controllers\InventoryController::class, 'storeDeduction'])->name('deductions.store');
        Route::post('/donations', [\App\Http\Controllers\InventoryController::class, 'storeDonation'])->name('donations.store');
        Route::get('/{transaction}/edit', [\App\Http\Controllers\InventoryController::class, 'edit'])->whereNumber('transaction')->name('edit');
        Route::put('/{transaction}',      [\App\Http\Controllers\InventoryController::class, 'update'])->whereNumber('transaction')->name('update');
        Route::delete('/{transaction}',   [\App\Http\Controllers\InventoryController::class, 'destroy'])->whereNumber('transaction')->name('destroy');
    });
});


