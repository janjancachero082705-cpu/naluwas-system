<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MoneyTransaction;
use App\Models\InventoryItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $churchId = $user->church_id ?? 1;

        // 1. MEMBERS STATS
        $totalMembers = Member::where('church_id', $churchId)->where('is_deceased', false)->count();
        
        // Gender Demographics
        $maleCount = Member::where('church_id', $churchId)->where('is_deceased', false)->where('gender', 'male')->count();
        $femaleCount = Member::where('church_id', $churchId)->where('is_deceased', false)->where('gender', 'female')->count();

        // 3. FINANCE STATS
        $totalIncome = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
        $totalExpense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
        $monthlyBalance = $totalIncome - $totalExpense;

        // 4. RECENT TRANSACTIONS
        $txDateColumn = Schema::hasColumn('money_transactions', 'date') ? 'date' : 'created_at';
        $recentActivities = MoneyTransaction::where('church_id', $churchId)->latest($txDateColumn)->take(5)->get();

        // 5. CHART DATA (Last 6 Months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $inc = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->whereMonth($txDateColumn, $date->month)->whereYear($txDateColumn, $date->year)->sum('amount');
            $exp = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->whereMonth($txDateColumn, $date->month)->whereYear($txDateColumn, $date->year)->sum('amount');

            $monthlyData[] = [
                'month'   => $date->format('M'),
                'income'  => (float) $inc,
                'expense' => (float) $exp,
            ];
        }

        // 6. MINISTRY FUNDS
        $fundBalances = InventoryItem::where('church_id', $churchId)->orderBy('quantity', 'desc')->take(4)->get();
        $inventoryValue = InventoryItem::where('church_id', $churchId)->sum('quantity');

        // 7. UPCOMING BIRTHDAYS
        $upcomingBirthdays = Member::where('church_id', $churchId)
            ->where('is_deceased', false)->whereNotNull('birthday')
            ->whereRaw("DATE_FORMAT(birthday, '%m-%d') >= DATE_FORMAT(NOW(), '%m-%d')")
            ->orderByRaw("DATE_FORMAT(birthday, '%m-%d')")->limit(4)->get();

        // 8. EXTRA DASHBOARD STATS
        $newMembers = Member::where('church_id', $churchId)->where('is_deceased', false)
            ->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $birthdaysMonth = Member::where('church_id', $churchId)->where('is_deceased', false)
            ->whereMonth('birthday', now()->month)->count();
        $rolesCount = \App\Models\Role::count();
        $inventoryCount = InventoryItem::where('church_id', $churchId)->count();
        $lowStock = InventoryItem::where('church_id', $churchId)->where('quantity', '<=', 5)->count();
        try {
            $unreadMessages = \App\Models\Message::where('receiver_church_id', $churchId)->where('is_read', false)->count();
        } catch (\Throwable $e) {
            $unreadMessages = 0;
        }
        $monthIncome = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')
            ->whereMonth($txDateColumn, now()->month)->whereYear($txDateColumn, now()->year)->sum('amount');
        $monthExpense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')
            ->whereMonth($txDateColumn, now()->month)->whereYear($txDateColumn, now()->year)->sum('amount');
        return view('dashboard', compact(
            'totalIncome', 'totalExpense', 'monthlyBalance', 'totalMembers', 
            'recentActivities', 'monthlyData', 
            'maleCount', 'femaleCount', 'fundBalances', 'upcomingBirthdays', 'inventoryValue',
            'newMembers', 'birthdaysMonth', 'rolesCount', 'inventoryCount', 'lowStock', 'unreadMessages', 'monthIncome', 'monthExpense'
        ));
    }
}