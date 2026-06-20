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
        $churchId = session('current_church_id', auth()->user()->church_id ?? 0);
        
        // Get all active churches
        $churches = Church::where('is_active', true)->get();
        
        // Get selected church for detailed view
        $selectedChurchId = $request->get('church', $churchId);
        $selectedChurch = Church::find($selectedChurchId);
        
        // Calculate balances for ALL churches
        $churchBalances = [];
        $totalIncome = 0;
        $totalExpense = 0;
        $overallBalance = 0;
        
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
        
        // Get recent transactions (all churches or selected)
        $recentTransactions = MoneyTransaction::with('church')
            ->when($selectedChurchId, function($query) use ($selectedChurchId) {
                return $query->where('church_id', $selectedChurchId);
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(15)
            ->get();
        
        // Get monthly summary for selected church
        $monthlyData = $this->getMonthlySummary($selectedChurchId);
        
        // Get income/expense by category for selected church
        $incomeTypes = MoneyTransaction::where('church_id', $selectedChurchId)
            ->where('type', 'income')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
        
        $expenseTypes = MoneyTransaction::where('church_id', $selectedChurchId)
            ->where('type', 'expense')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();
        
        return view('finance.index', compact(
            'churches',
            'churchBalances',
            'selectedChurch',
            'selectedChurchId',
            'totalIncome',
            'totalExpense',
            'overallBalance',
            'recentTransactions',
            'monthlyData',
            'incomeTypes',
            'expenseTypes'
        ));
    }
    
    /**
     * Get monthly summary for a church
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
        
        // FINANCIAL DATA
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
        
        // MEMBER DATA
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
        
        // ATTENDANCE DATA
        $todaysAttendance = DB::table('attendances')
            ->where('church_id', $churchId)
            ->whereDate('service_date', Carbon::today())
            ->count();
        
        // INVENTORY DATA
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
        
        // CHART DATA (Last 6 Months)
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