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
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // CHURCH CONTEXT
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $churchId = session('current_church_id', auth()->user()->church_id ?? 0);

        $churches = Church::where('is_active', true)->get();

        // Handle "all" as a special value â€” walang specific church na naka-select
        $requestedChurch  = $request->get('church', $churchId);
        $selectedChurchId = ($requestedChurch === 'all' || $requestedChurch === '') ? null : $requestedChurch;

        $selectedChurch = null;
        if ($selectedChurchId) {
            $selectedChurch = Church::find($selectedChurchId);
        }

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // 1. CALCULATE BALANCES FOR ALL CHURCHES
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $churchBalances = [];
        $totalIncome    = 0;
        $totalExpense   = 0;

        foreach ($churches as $church) {
            $income = MoneyTransaction::where('church_id', $church->id)
                ->where('type', 'income')
                ->sum('amount') ?? 0;

            $expense = MoneyTransaction::where('church_id', $church->id)
                ->where('type', 'expense')
                ->sum('amount') ?? 0;

            $balance = $income - $expense;

            $churchBalances[] = [
                'church'  => $church,
                'income'  => $income,
                'expense' => $expense,
                'balance' => $balance,
                'status'  => $balance >= 0 ? 'surplus' : 'deficit',
            ];

            $totalIncome  += $income;
            $totalExpense += $expense;
        }

        $overallBalance = $totalIncome - $totalExpense;

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // 2. SELECTED CHURCH DATA (Filtered by Church)
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $churchIncome        = 0;
        $churchExpenses      = 0;
        $churchBalance       = 0;
        $incomeTypes         = collect();
        $expenseTypes        = collect();
        $recentTransactions  = collect();
        $unreadMessages      = 0;

        if ($selectedChurch) {
            $churchIncome = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'income')
                ->sum('amount') ?? 0;

            $churchExpenses = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'expense')
                ->sum('amount') ?? 0;

            $churchBalance = $churchIncome - $churchExpenses;

            $incomeTypes = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'income')
                ->select('category', DB::raw('SUM(amount) as total'))
                ->groupBy('category')
                ->get();

            $expenseTypes = MoneyTransaction::where('church_id', $selectedChurch->id)
                ->where('type', 'expense')
                ->select('category', DB::raw('SUM(amount) as total'))
                ->groupBy('category')
                ->get();

            $recentTransactions = MoneyTransaction::with('church')
                ->where('church_id', $selectedChurch->id)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(15)
                ->get();

            $unreadMessages = \App\Models\Message::where('receiver_church_id', $selectedChurch->id)
                ->where('is_read', false)
                ->count();
        }

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // 3. MONTHLY CHART DATA â€” â­ ALWAYS POPULATED
        //    Kung walang selected church â†’ aggregate ALL churches
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $monthlyData = $this->getMonthlySummary($selectedChurch ? $selectedChurch->id : null);

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
            'monthlyData',    // â­ Now always has data
            'recentTransactions',
            'unreadMessages'
        ));
    }

    /**
     * Get monthly summary
     * If $churchId is null â†’ aggregate across ALL churches
     */
    private function getMonthlySummary($churchId = null)
    {
        $months = [];
        $now    = now();

        for ($i = 5; $i >= 0; $i--) {
            $month      = $now->copy()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd   = $month->copy()->endOfMonth();

            $incomeQuery = MoneyTransaction::where('type', 'income')
                ->whereBetween('date', [$monthStart, $monthEnd]);

            $expenseQuery = MoneyTransaction::where('type', 'expense')
                ->whereBetween('date', [$monthStart, $monthEnd]);

            // Filter by church only kapag may specific na church
            if ($churchId) {
                $incomeQuery->where('church_id', $churchId);
                $expenseQuery->where('church_id', $churchId);
            }

            $income  = (float) ($incomeQuery->sum('amount') ?? 0);
            $expense = (float) ($expenseQuery->sum('amount') ?? 0);

            $months[] = [
                'month'   => $month->format('M Y'),
                'income'  => $income,
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
            'church_id'   => 'required|exists:churches,id',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:0.01',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'date'        => 'nullable|date',
        ]);

        MoneyTransaction::create([
            'church_id'   => $request->church_id,
            'type'        => $request->type,
            'amount'      => $request->amount,
            'category'    => $request->category,
            'description' => $request->description,
            'date'        => $request->date ?? now(),
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

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // FINANCIAL DATA
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // MEMBER DATA
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $totalMembers = DB::table('members')->where('church_id', $churchId)->count();
        $choirMembers = DB::table('members')->where('church_id', $churchId)->where('is_choir', 1)->count();

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

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // ATTENDANCE DATA
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $todaysAttendance = 0; // Gi-remove kay wala nay attendance module

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // INVENTORY DATA
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $totalInventoryItems = DB::table('inventories')
            ->where('church_id', $churchId)
            ->count();

        try {
            $columns     = DB::select("SHOW COLUMNS FROM inventories");
            $columnNames = array_column($columns, 'Field');

            if (in_array('quantity', $columnNames) && in_array('unit_price', $columnNames)) {
                $totalInventoryValue = DB::table('inventories')
                    ->where('church_id', $churchId)
                    ->sum(DB::raw('quantity * unit_price'));
            } elseif (in_array('stock', $columnNames) && in_array('price', $columnNames)) {
                $totalInventoryValue = DB::table('inventories')
                    ->where('church_id', $churchId)
                    ->sum(DB::raw('stock * price'));
            } else {
                $totalInventoryValue = DB::table('inventories')
                    ->where('church_id', $churchId)
                    ->sum('quantity') ?? 0;
            }
        } catch (\Exception $e) {
            $totalInventoryValue = 0;
        }

        try {
            $columns     = DB::select("SHOW COLUMNS FROM inventories");
            $columnNames = array_column($columns, 'Field');

            if (in_array('reorder_level', $columnNames)) {
                $lowStockItems = DB::table('inventories')
                    ->where('church_id', $churchId)
                    ->whereColumn('quantity', '<=', 'reorder_level')
                    ->count();
            } else {
                $lowStockItems = 0;
            }
        } catch (\Exception $e) {
            $lowStockItems = 0;
        }

        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        // CHART DATA (Last 6 Months)
        // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $months      = [];
        $incomeData  = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month   = Carbon::now()->subMonths($i);
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
