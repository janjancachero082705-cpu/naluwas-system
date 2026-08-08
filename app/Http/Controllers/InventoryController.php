<?php

namespace App\Http\Controllers;

use App\Models\MoneyTransaction;
use App\Traits\ChurchScopeTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InventoryController extends Controller
{
    use ChurchScopeTrait;

    public function index(Request $request)
    {
        $churchId = $this->getCurrentChurchId();
        
        // Get current church's church object
        $church = auth()->user()->church;
        
        // Get transactions for THIS CHURCH ONLY
        $transactions = MoneyTransaction::where('church_id', $churchId)
            ->orderBy('date', 'desc')
            ->get();

        // All-time totals for THIS CHURCH ONLY
        $allTimeIncome = $transactions->where('type', 'income')->sum('amount');
        $allTimeExpense = $transactions->where('type', 'expense')->sum('amount');
        $allTimeBalance = $allTimeIncome - $allTimeExpense;

        // Recent Transactions (latest 10 for the table)
        $recentTransactions = MoneyTransaction::where('church_id', $churchId)
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Filter by Month, Year, or Week
        $selectedMonth = $request->month;
        $selectedYear = $request->year;
        $selectedWeek = $request->week;

        $filtered = $transactions;

        if ($selectedMonth && $selectedYear) {
            // Filter by specific Month & Year
            $filtered = $filtered->filter(function ($t) use ($selectedMonth, $selectedYear) {
                return date('m', strtotime($t->date)) == $selectedMonth 
                    && date('Y', strtotime($t->date)) == $selectedYear;
            });
        } elseif ($selectedYear) {
            // Filter by specific Year only
            $filtered = $filtered->filter(function ($t) use ($selectedYear) {
                return date('Y', strtotime($t->date)) == $selectedYear;
            });
        }

        if ($selectedWeek) {
            // Filter by specific Week (e.g., "2026-W32")
            $filtered = $filtered->filter(function ($t) use ($selectedWeek) {
                return \Carbon\Carbon::parse($t->date)->isoWeekYear() . '-W' . \Carbon\Carbon::parse($t->date)->isoWeek() == $selectedWeek;
            });
        }

        $totalIncome = $filtered->where('type', 'income')->sum('amount');
        $totalExpense = $filtered->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Category breakdown for THIS CHURCH ONLY
        $incomeByCategory = $transactions
            ->where('type', 'income')
            ->groupBy('category')
            ->map(fn ($items) => $items->sum('amount'))
            ->toArray();

        $expenseByCategory = $transactions
            ->where('type', 'expense')
            ->groupBy('category')
            ->map(fn ($items) => $items->sum('amount'))
            ->toArray();

        // Generate list of available months and years for dropdowns
        $availableYears = $transactions->map(fn($t) => date('Y', strtotime($t->date)))->unique()->sort()->values();
        $availableMonths = [];
        if ($selectedYear) {
            $availableMonths = $transactions->filter(fn($t) => date('Y', strtotime($t->date)) == $selectedYear)
                ->map(fn($t) => date('m', strtotime($t->date)))->unique()->sort()->values();
        }

        return view('inventory.index', compact(
            'transactions', 'allTimeIncome', 'allTimeExpense', 'allTimeBalance',
            'totalIncome', 'totalExpense', 'balance', 'incomeByCategory', 
            'expenseByCategory', 'church', 'selectedMonth', 'selectedYear', 'selectedWeek',
            'recentTransactions', 'availableYears', 'availableMonths'
        ));
    }

    /**
     * AJAX: Get filtered transactions for the modal (Month, Year, Week)
     */
    public function getTransactions(Request $request)
    {
        $churchId = $this->getCurrentChurchId();
        
        $query = MoneyTransaction::where('church_id', $churchId);
        
        // --- FILTER BY MONTH & YEAR ---
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('date', $request->month)->whereYear('date', $request->year);
        } elseif ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
        
        // --- FILTER BY WEEK ---
        if ($request->filled('week')) {
            $query->whereRaw('YEAR(date) = ? AND WEEK(date, 1) = ?', [
                substr($request->week, 0, 4),
                substr($request->week, 6, 2)
            ]);
        }
        
        $transactions = $query->orderBy('date', 'desc')->get();
        
        // Calculate totals for the filtered data
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;
        $totalCount = $transactions->count();
        
        return response()->json([
            'success' => true,
            'transactions' => $transactions,
            'totals' => [
                'income' => number_format($totalIncome, 2),
                'expense' => number_format($totalExpense, 2),
                'balance' => number_format($netBalance, 2),
                'count' => $totalCount,
            ]
        ]);
    }

       /**
     * AJAX: Get filtered transactions for Export (Multiple Months, Year, Week)
     * If no filters are selected, returns ALL data.
     */
    public function exportData(Request $request)
    {
        $churchId = $this->getCurrentChurchId();
        
        $query = MoneyTransaction::where('church_id', $churchId);
        
        // --- FILTER BY MULTIPLE MONTHS (e.g., 1,2,3 for Jan, Feb, Mar) ---
        if ($request->filled('months') && is_array($request->months)) {
            // Flatten the array if it comes as a comma-separated string
            $months = $request->months;
            if (count($months) === 1 && strpos($months[0], ',') !== false) {
                $months = explode(',', $months[0]);
            }
            $query->whereIn(\DB::raw('MONTH(date)'), $months);
        }
        
        // --- FILTER BY YEAR ---
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
        
        // --- FILTER BY WEEK ---
        if ($request->filled('week')) {
            $query->whereRaw('YEAR(date) = ? AND WEEK(date, 1) = ?', [
                substr($request->week, 0, 4),
                substr($request->week, 6, 2)
            ]);
        }
        
        // --- IF NO FILTERS ARE SELECTED, RETURN ALL DATA ---
        // (The query will already have no filters applied, so it returns everything)
        
        $transactions = $query->orderBy('date', 'desc')->get();
        
        // Calculate totals
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;
        $totalCount = $transactions->count();
        
        return response()->json([
            'success' => true,
            'transactions' => $transactions,
            'totals' => [
                'income' => number_format($totalIncome, 2),
                'expense' => number_format($totalExpense, 2),
                'balance' => number_format($netBalance, 2),
                'count' => $totalCount,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'recipient' => 'nullable|string|max:255',
            'donor_name' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'date' => 'required|date'
        ]);

        $churchId = $this->getCurrentChurchId();

        // Check balance for THIS CHURCH ONLY before expense
        if ($validated['type'] === 'expense') {
            $income = MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'income')
                ->sum('amount');
            $expense = MoneyTransaction::where('church_id', $churchId)
                ->where('type', 'expense')
                ->sum('amount');
            $balance = $income - $expense;

            if ($balance < $validated['amount']) {
                return redirect()->back()->with('error',
                    '⚠️ INSUFFICIENT FUNDS! Available balance: ₱' . number_format($balance, 2)
                )->withInput();
            }
        }

        // Create transaction for THIS CHURCH ONLY
        MoneyTransaction::create([
            ...$validated,
            'church_id' => $churchId,
        ]);

        // Get updated balance
        $income = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
        $expense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
        $newBalance = $income - $expense;

        $message = $validated['type'] === 'income'
            ? "✅ Money IN added! Current Balance: ₱" . number_format($newBalance, 2)
            : "✅ Money OUT recorded! Current Balance: ₱" . number_format($newBalance, 2);

        return redirect()->route('inventory.index')->with('success', $message);
    }

    /**
     * Show the form for editing a transaction
     */
    public function edit($id)
    {
        $churchId = $this->getCurrentChurchId();
        
        $transaction = MoneyTransaction::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        // Get current balance for this church (excluding this transaction)
        $income = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'income')
            ->where('id', '!=', $id)
            ->sum('amount');
        $expense = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'expense')
            ->where('id', '!=', $id)
            ->sum('amount');
        $balance = $income - $expense;
        
        return view('inventory.edit', compact('transaction', 'balance'));
    }

    /**
     * Update a transaction - PROPERLY RECALCULATES BALANCE
     */
    public function update(Request $request, $id)
    {
        $churchId = $this->getCurrentChurchId();
        
        $transaction = MoneyTransaction::where('id', $id)
            ->where('church_id', $churchId)
            ->firstOrFail();
        
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'donor_name' => 'nullable|string|max:255',
            'recipient' => 'nullable|string|max:255',
            'remarks' => 'nullable|string'
        ]);
        
        // --- BALANCE RECALCULATION LOGIC ---
        // Step 1: Remove the old transaction from the balance
        $income = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'income')
            ->where('id', '!=', $id)
            ->sum('amount');
        $expense = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'expense')
            ->where('id', '!=', $id)
            ->sum('amount');
        $currentBalanceWithoutTransaction = $income - $expense;
        
        // Step 2: Check if the new transaction type is expense and validate balance
        if ($validated['type'] === 'expense') {
            // Check if there's enough balance for this expense
            if ($currentBalanceWithoutTransaction < $validated['amount']) {
                return redirect()->back()
                    ->with('error', '⚠️ INSUFFICIENT FUNDS! Available balance: ₱' . number_format($currentBalanceWithoutTransaction, 2))
                    ->withInput();
            }
        }
        
        // Step 3: Update the transaction
        $transaction->description = $validated['description'];
        $transaction->category = $validated['category'];
        $transaction->amount = $validated['amount'];
        $transaction->date = $validated['date'];
        $transaction->type = $validated['type'];
        $transaction->remarks = $validated['remarks'] ?? null;
        
        // Update donor/recipient based on type
        if ($validated['type'] === 'income') {
            $transaction->donor_name = $validated['donor_name'] ?? null;
            $transaction->recipient = null;
        } else {
            $transaction->recipient = $validated['recipient'] ?? null;
            $transaction->donor_name = null;
        }
        
        $transaction->save();
        
        // Step 4: Get updated balance with the new transaction
        $income = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
        $expense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
        $newBalance = $income - $expense;
        
        // Step 5: Create a detailed message
        $oldType = $request->input('old_type');
        $oldAmount = $request->input('old_amount');
        
        $message = "✅ Transaction updated successfully! ";
        $message .= "New Balance: ₱" . number_format($newBalance, 2);
        
        // Add details about the change
        if ($validated['type'] != $oldType) {
            $message .= " | Type changed from " . ucfirst($oldType) . " to " . ucfirst($validated['type']);
        }
        if ($validated['amount'] != $oldAmount) {
            $message .= " | Amount changed from ₱" . number_format($oldAmount, 2) . " to ₱" . number_format($validated['amount'], 2);
        }
        
        return redirect()->route('inventory.index')
            ->with('success', $message);
    }

    /**
     * DELETE transaction - FIXED with $request parameter
     */
    public function destroy(Request $request, $id)
    {
        try {
            $churchId = $this->getCurrentChurchId();
            
            $transaction = MoneyTransaction::where('id', $id)
                ->where('church_id', $churchId)
                ->firstOrFail();

            $description = $transaction->description;
            $amount = $transaction->amount;
            $type = $transaction->type;

            $transaction->delete();

            // Get updated balance for THIS CHURCH ONLY
            $income = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
            $expense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
            $balance = $income - $expense;

            // Check if request expects JSON response (AJAX)
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaction deleted successfully!',
                    'balance' => $balance,
                    'transaction' => [
                        'description' => $description,
                        'amount' => $amount,
                        'type' => $type
                    ]
                ]);
            }

            return redirect()->route('inventory.index')->with('warning',
                "🗑️ Deleted: {$description} (₱" . number_format($amount, 2) . ") - New Balance: ₱" . number_format($balance, 2)
            );
            
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete transaction: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('inventory.index')
                ->with('error', 'Failed to delete transaction: ' . $e->getMessage());
        }
    }

    /**
     * Get single transaction for editing (API)
     */
    public function getTransaction($id)
    {
        $churchId = $this->getCurrentChurchId();
        
        $transaction = MoneyTransaction::where('id', $id)
            ->where('church_id', $churchId)
            ->first();
            
        if (!$transaction) {
            return response()->json([
                'success' => false, 
                'message' => 'Transaction not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true, 
            'transaction' => $transaction
        ]);
    }

    /**
     * Update transaction (API)
     */
    public function updateTransaction(Request $request, $id)
    {
        $churchId = $this->getCurrentChurchId();
        
        $transaction = MoneyTransaction::where('id', $id)
            ->where('church_id', $churchId)
            ->first();
            
        if (!$transaction) {
            return response()->json([
                'success' => false, 
                'message' => 'Transaction not found'
            ], 404);
        }
        
        // Store old values for balance recalculation
        $oldAmount = $transaction->amount;
        $oldType = $transaction->type;
        
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'donor_name' => 'nullable|string|max:255',
            'recipient' => 'nullable|string|max:255',
            'remarks' => 'nullable|string'
        ]);
        
        // --- BALANCE RECALCULATION LOGIC ---
        // Step 1: Remove the old transaction from the balance
        $income = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'income')
            ->where('id', '!=', $id)
            ->sum('amount');
        $expense = MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'expense')
            ->where('id', '!=', $id)
            ->sum('amount');
        $currentBalanceWithoutTransaction = $income - $expense;
        
        // Step 2: Check if the new transaction type is expense and validate balance
        if ($validated['type'] === 'expense') {
            if ($currentBalanceWithoutTransaction < $validated['amount']) {
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ INSUFFICIENT FUNDS! Available balance: ₱' . number_format($currentBalanceWithoutTransaction, 2)
                ], 400);
            }
        }
        
        // Step 3: Update the transaction
        $transaction->description = $validated['description'];
        $transaction->category = $validated['category'];
        $transaction->amount = $validated['amount'];
        $transaction->date = $validated['date'];
        $transaction->type = $validated['type'];
        $transaction->remarks = $validated['remarks'] ?? null;
        
        // Update donor/recipient based on type
        if ($transaction->type === 'income') {
            $transaction->donor_name = $validated['donor_name'] ?? null;
            $transaction->recipient = null;
        } else {
            $transaction->recipient = $validated['recipient'] ?? null;
            $transaction->donor_name = null;
        }
        
        $transaction->save();
        
        // Step 4: Get updated balance
        $income = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
        $expense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;
        
        return response()->json([
            'success' => true,
            'message' => 'Transaction updated successfully. Balance: ₱' . number_format($balance, 2),
            'balance' => $balance,
            'old_amount' => $oldAmount,
            'old_type' => $oldType,
            'new_amount' => $validated['amount'],
            'new_type' => $transaction->type
        ]);
    }

    /**
     * Delete transaction (API)
     */
    public function destroyTransaction(Request $request, $id)
    {
        try {
            $churchId = $this->getCurrentChurchId();
            
            $transaction = MoneyTransaction::where('id', $id)
                ->where('church_id', $churchId)
                ->first();
                
            if (!$transaction) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Transaction not found'
                ], 404);
            }
            
            $transaction->delete();
            
            // Get updated balance
            $income = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
            $expense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
            $balance = $income - $expense;
            
            return response()->json([
                'success' => true,
                'message' => 'Transaction deleted successfully',
                'balance' => $balance
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete transaction: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get balance for current church
     */
    public function getBalance()
    {
        $churchId = $this->getCurrentChurchId();
        
        $income = MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
        $expense = MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;
        
        return response()->json([
            'balance' => $balance,
            'income' => $income,
            'expense' => $expense,
            'church_name' => auth()->user()->church->name ?? 'N/A'
        ]);
    }
}