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

        // Filter by month/year (if selected)
        $selectedMonth = $request->month;
        $selectedYear = $request->year;

        $filtered = $transactions;

        if ($selectedMonth) {
            $filtered = $filtered->filter(function ($t) use ($selectedMonth) {
                return date('m', strtotime($t->date)) == $selectedMonth;
            });
        }

        if ($selectedYear) {
            $filtered = $filtered->filter(function ($t) use ($selectedYear) {
                return date('Y', strtotime($t->date)) == $selectedYear;
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

        return view('inventory.index', compact(
            'transactions', 'allTimeIncome', 'allTimeExpense', 'allTimeBalance',
            'totalIncome', 'totalExpense', 'balance', 'incomeByCategory', 
            'expenseByCategory', 'church', 'selectedMonth', 'selectedYear'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'category' => 'nullable|string|max:100',
            'amount' => 'required|numeric|min:0.01',
            'recipient' => 'nullable|string|max:255',
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

    public function destroy($id)
    {
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

        return redirect()->route('inventory.index')->with('warning',
            "🗑️ Deleted: {$description} (₱" . number_format($amount, 2) . ") - New Balance: ₱" . number_format($balance, 2)
        );
    }
    
    // Optional: Get balance for current church
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