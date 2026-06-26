<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\MoneyTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinanceController extends Controller
{
    /**
     * Finance Dashboard - View all churches' balances
     */
    public function index(Request $request)
    {
        // Get church ID from session or request
        $churchId = session('current_church_id', auth()->user()->church_id ?? 0);
        
        // Get all active churches
        $churches = Church::where('is_active', true)->get();
        
        // Get selected church for detailed view
        $selectedChurchId = $request->get('church', $churchId);
        $selectedChurch = null;
        if ($selectedChurchId) {
            $selectedChurch = Church::find($selectedChurchId);
        }
        
        // ============================================
        // 1. CALCULATE BALANCES FOR ALL CHURCHES
        // ============================================
        $churchBalances = [];
        $totalIncome = 0;
        $totalExpense = 0;
        
        foreach ($churches as $church) {
            $income = MoneyTransaction::where('church_id', $church->id)
                ->where('type', 'income')
                ->sum('amount') ?? 0;
            
            $expense = MoneyTransaction::where('church_id', $church->id)
                ->where('type', 'expense')
                ->sum('amount') ?? 0;
            
            $balance = $income - $expense;
            
            $churchBalances[] = [
                'church' => $church,
                'income' => $income,
                'expense' => $expense,
                'balance' => $balance,
                'status' => $balance >= 0 ? 'surplus' : 'deficit',
            ];
            
            $totalIncome += $income;
            $totalExpense += $expense;
        }
        $overallBalance = $totalIncome - $totalExpense;
        
        // ============================================
        // 2. SELECTED CHURCH DATA (Filtered by Church)
        // ============================================
        $churchIncome = 0;
        $churchExpenses = 0;
        $churchBalance = 0;
        $incomeTypes = collect();
        $expenseTypes = collect();
        $monthlyData = [];
        $recentTransactions = collect();
        $unreadMessages = 0;
        
        if ($selectedChurch) {
            // Get church income and expenses
            $churchIncome = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'income')
                ->sum('amount') ?? 0;
            
            $churchExpenses = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'expense')
                ->sum('amount') ?? 0;
            
            $churchBalance = $churchIncome - $churchExpenses;
            
            // Get income by category for selected church
            $incomeTypes = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'income')
                ->select('category', DB::raw('SUM(amount) as total'))
                ->groupBy('category')
                ->get();
            
            // Get expense by category for selected church
            $expenseTypes = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'expense')
                ->select('category', DB::raw('SUM(amount) as total'))
                ->groupBy('category')
                ->get();
            
            // Get monthly summary for selected church
            $monthlyData = $this->getMonthlySummary($selectedChurch->id);
            
            // Get recent transactions for selected church
            $recentTransactions = MoneyTransaction::with('church')
                ->where('church_id', $selectedChurch->id)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(15)
                ->get();
                
            // Get unread messages count for selected church
            $unreadMessages = \App\Models\Message::where('receiver_church_id', $selectedChurch->id)
                ->where('is_read', false)
                ->count();
        }
        
        return view('finance.index', compact(
            'churches',
            'churchBalances',
            'selectedChurch',
            'selectedChurchId',
            'totalIncome',
            'totalExpense',
            'overallBalance',
            'churchIncome',
            'churchExpenses',
            'churchBalance',
            'incomeTypes',
            'expenseTypes',
            'monthlyData',
            'recentTransactions',
            'unreadMessages'
        ));
    }
    
    /**
     * Get monthly summary for a specific church
     */
    private function getMonthlySummary($churchId)
    {
        $months = [];
        $now = now();
        
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $income = MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'income')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('amount') ?? 0;
            
            $expense = MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'expense')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('amount') ?? 0;
            
            $months[] = [
                'month' => $month->format('M Y'),
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense,
            ];
        }
        
        return $months;
    }
    
    /**
     * Store a new transaction
     */
    public function store(Request $request)
    {
        $request->validate([
            'church_id' => 'required|exists:churches,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'date' => 'nullable|date',
        ]);
        
        $transaction = MoneyTransaction::create([
            'church_id' => $request->church_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'date' => $request->date ?? now(),
        ]);
        
        return redirect()->route('finance.index')
            ->with('success', 'Transaction added successfully!');
    }
    
    /**
     * Delete a transaction
     */
    public function destroy($id)
    {
        $transaction = MoneyTransaction::findOrFail($id);
        $transaction->delete();
        
        return redirect()->route('finance.index')
            ->with('success', 'Transaction deleted successfully!');
    }
    
    /**
     * Reports & Analytics Page
     */
    public function reportsAnalytics()
    {
        $churchId = session('current_church_id', auth()->user()->church_id ?? 1);
        
        // ============================================
        // FINANCIAL DATA (Filtered by Church)
        // ============================================
        $totalIncome = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'income')
            ->sum('amount') ?? 0;
            
        $totalExpense = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'expense')
            ->sum('amount') ?? 0;
            
        $balance = $totalIncome - $totalExpense;
        
        $recentTransactions = MoneyTransaction::where('church_id', $churchId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // ============================================
        // MEMBER DATA (Filtered by Church)
        // ============================================
        $totalMembers = DB::table('members')
            ->where('church_id', $churchId)
            ->count();
            
        $choirMembers = DB::table('members')
            ->where('church_id', $churchId)
            ->where('is_choir', 1)
            ->count();
            
        $recentMembers = DB::table('members')
            ->where('church_id', $churchId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $upcomingBirthdays = DB::table('members')
            ->where('church_id', $churchId)
            ->whereNotNull('birthday')
            ->whereRaw('DATE_FORMAT(birthday, "%m-%d") >= DATE_FORMAT(NOW(), "%m-%d")')
            ->orderByRaw('DATE_FORMAT(birthday, "%m-%d")')
            ->limit(10)
            ->get();
        
        // ============================================
        // ATTENDANCE DATA (Filtered by Church)
        // ============================================
        $todaysAttendance = DB::table('attendances')
            ->where('church_id', $churchId)
            ->whereDate('service_date', Carbon::today())
            ->count();
        
        // ============================================
        // INVENTORY DATA (Filtered by Church)
        // ============================================
        $totalInventoryItems = DB::table('inventories')
            ->where('church_id', $churchId)
            ->count();
        
        $totalInventoryValue = DB::table('inventories')
            ->where('church_id', $churchId)
            ->sum(DB::raw('quantity * unit_price'));
        
        $lowStockItems = DB::table('inventories')
            ->where('church_id', $churchId)
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->count();
        
        // ============================================
        // CHART DATA (Last 6 Months - Filtered by Church)
        // ============================================
        $months = [];
        $incomeData = [];
        $expenseData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M Y');
            
            $incomeData[] = (float) MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'income')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');
                
            $expenseData[] = (float) MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'expense')
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('amount');
        }
        
        return view('reports.analytics', compact(
            'totalIncome', 'totalExpense', 'balance', 'recentTransactions',
            'totalMembers', 'choirMembers', 'recentMembers', 'todaysAttendance',
            'totalInventoryItems', 'totalInventoryValue', 'lowStockItems',
            'upcomingBirthdays', 'months', 'incomeData', 'expenseData'
        ));
    }
}