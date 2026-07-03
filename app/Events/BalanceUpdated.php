<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class BalanceUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $eglesiaId;
    public $eglesiaName;
    public $balance;
    public $income;
    public $expenses;
    public $transactionType;
    public $allBalances; // For multi-eglesia view

    public function __construct($eglesiaId, $eglesiaName, $balance, $income, $expenses, $transactionType, $allBalances = null)
    {
        $this->eglesiaId = $eglesiaId;
        $this->eglesiaName = $eglesiaName;
        $this->balance = $balance;
        $this->income = $income;
        $this->expenses = $expenses;
        $this->transactionType = $transactionType;
        $this->allBalances = $allBalances;
    }

    public function broadcastOn()
    {
        return new Channel('finances');
    }

    public function broadcastAs()
    {
        return 'balance.updated';
    }

    public function broadcastWith()
    {
        return [
            'eglesia_id' => $this->eglesiaId,
            'eglesia_name' => $this->eglesiaName,
            'balance' => number_format($this->balance, 2),
            'income' => number_format($this->income, 2),
            'expenses' => number_format($this->expenses, 2),
            'transaction_type' => $this->transactionType,
            'all_balances' => $this->allBalances,
            'timestamp' => now()->toDateTimeString()
        ];
    }
}