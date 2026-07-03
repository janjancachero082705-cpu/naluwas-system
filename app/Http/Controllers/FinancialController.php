<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Eglesia;
use App\Events\BalanceUpdated;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function store(Request $request)
    {
        $transaction = Transaction::create($request->all());
        
        // Update eglesia balance
        $eglesia = Eglesia::find($request->eglesia_id);
        $eglesia->balance += $request->amount;
        $eglesia->save();
        
        // Get all eglesias for multi-view
        $allBalances = Eglesia::all()->map(function($e) {
            return [
                'id' => $e->id,
                'name' => $e->name,
                'amount' => number_format($e->balance, 2)
            ];
        });
        
        // Broadcast the update
        event(new BalanceUpdated(
            $eglesia->id,
            $eglesia->name,
            $eglesia->balance,
            $eglesia->income,
            $eglesia->expenses,
            $request->type,
            $allBalances
        ));
        
        return redirect()->back()->with('success', 'Transaction recorded!');
    }
}