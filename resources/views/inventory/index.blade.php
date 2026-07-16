@extends('layouts.app')

@section('header', 'Financial Management')

@section('content')
<style>
    /* ============================================
       CLEAN UI - SAME STYLE AS MEMBER PAGE
    ============================================ */
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-icon.income { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.expense { background: linear-gradient(135deg, #ef4444, #f87171); }
    .stat-icon.balance { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .stat-icon.church { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    
    .stat-info {
        flex: 1;
    }
    
    .stat-info h4 {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin: 0 0 3px 0;
        font-weight: 600;
    }
    
    .stat-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .stat-trend {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    
    .amount-positive { color: #10b981 !important; }
    .amount-negative { color: #ef4444 !important; }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    
    .action-btn {
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .action-btn.income:hover {
        border-color: #10b981;
    }
    
    .action-btn.income i {
        color: #10b981;
    }
    
    .action-btn.expense:hover {
        border-color: #ef4444;
    }
    
    .action-btn.expense i {
        color: #ef4444;
    }
    
    .action-btn.history:hover {
        border-color: #4F46E5;
    }
    
    .action-btn.history i {
        color: #4F46E5;
    }
    
    /* Summary Banner */
    .summary-banner {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .summary-banner h4 {
        margin: 0 0 2px 0;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        font-weight: 600;
    }
    
    .summary-banner .amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .summary-banner .small {
        font-size: 0.7rem;
        color: var(--text-muted);
    }
    
    /* Category Grid */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .category-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
    }
    
    .category-header {
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .category-header h6 {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .category-header h6 i {
        margin-right: 6px;
    }
    
    .category-header h6 .text-success { color: #10b981 !important; }
    .category-header h6 .text-danger { color: #ef4444 !important; }
    
    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.15s ease;
    }
    
    .category-item:hover {
        background: var(--bg-tertiary);
        transform: translateX(3px);
    }
    
    .category-name {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .category-amount {
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .category-amount.income { color: #10b981; }
    .category-amount.expense { color: #ef4444; }
    
    .summary-row {
        padding: 0.6rem 1.2rem;
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 0.8rem;
        border-top: 2px solid var(--border-color);
        color: var(--text-primary);
    }
    
    /* Table Container */
    .table-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .table-container .card-header-custom {
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .table-container .card-header-custom h6 {
        color: var(--text-primary);
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
    }
    
    .table {
        margin-bottom: 0;
        width: 100%;
        background: var(--card-bg);
        border-collapse: collapse;
    }
    
    .table thead th {
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-muted) !important;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 0.7rem 1rem;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 0.6rem 1rem;
        vertical-align: middle;
        color: var(--text-primary) !important;
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        font-size: 0.8rem;
    }
    
    .table tbody tr {
        transition: all 0.15s ease;
    }
    
    .table tbody tr:hover {
        background: var(--bg-tertiary) !important;
    }
    
    .table tbody tr:hover td {
        background: var(--bg-tertiary) !important;
    }
    
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
    }
    
    .badge-income {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981 !important;
    }
    
    .badge-expense {
        background: rgba(239, 68, 68, 0.12);
        color: #ef4444 !important;
    }
    
    .table tbody td strong {
        color: var(--text-primary);
        font-weight: 600;
    }
    
    /* Modal Styles */
    .modal-content {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
    }
    
    .modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .modal-header .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .modal-header p {
        color: var(--text-muted);
        font-size: 0.75rem;
        margin: 0;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    /* Form Styles */
    .form-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .form-label i {
        font-size: 0.65rem;
    }
    
    .form-control, .form-select, textarea {
        width: 100%;
        padding: 0.5rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus, textarea:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-control::placeholder, textarea::placeholder {
        color: var(--text-muted);
    }
    
    textarea {
        resize: vertical;
        min-height: 60px;
    }
    
    /* Category Pills */
    .category-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }
    
    .category-pill {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        text-align: center;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .category-pill i {
        font-size: 0.6rem;
    }
    
    .category-pill:hover {
        background: var(--hover-bg);
        border-color: #10b981;
    }
    
    .category-pill.selected {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    
    /* Amount Preview */
    .amount-preview {
        background: var(--bg-tertiary);
        border-radius: 10px;
        padding: 0.8rem 1rem;
        margin-top: 1rem;
        border: 1px solid var(--border-color);
    }
    
    .alert-success {
        background: rgba(16, 185, 129, 0.08);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.15);
    }
    
    .alert-info {
        background: rgba(59, 130, 246, 0.08);
        color: var(--text-primary);
        border: 1px solid rgba(59, 130, 246, 0.15);
    }
    
    .alert-danger {
        background: rgba(239, 68, 68, 0.08);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.15);
    }
    
    .input-group-text {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        font-size: 0.8rem;
    }
    
    /* Modal Filters */
    .filter-tabs {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 0.5rem;
    }
    
    .filter-tab {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        background: transparent;
        color: var(--text-secondary);
        font-size: 0.7rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .filter-tab:hover {
        background: var(--hover-bg);
        color: var(--text-primary);
    }
    
    .filter-tab.active {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }
    
    /* Search Bar */
    .search-bar {
        max-width: 300px;
    }
    
    .search-bar .input-group-text {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        border-right: none;
    }
    
    .search-bar .form-control {
        background: var(--input-bg);
        border-left: none;
    }
    
    /* Buttons */
    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
        background: var(--hover-bg);
        transform: translateY(-1px);
    }
    
    .btn-primary {
        background: #10b981;
        color: white;
        border: none;
        padding: 0.4rem 1.2rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    
    .btn-success {
        background: #10b981;
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    
    .btn-danger {
        background: #ef4444;
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    .btn-danger:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .btn-close {
        color: var(--text-muted);
        opacity: 0.5;
        transition: all 0.2s ease;
    }
    
    .btn-close:hover {
        opacity: 1;
    }
    
    /* Transaction Summary */
    .transaction-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
    }
    
    .summary-item {
        background: var(--bg-tertiary);
        border-radius: 10px;
        padding: 0.8rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .summary-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .summary-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }
    
    .summary-icon.income-bg { background: linear-gradient(135deg, #10b981, #34d399); }
    .summary-icon.expense-bg { background: linear-gradient(135deg, #ef4444, #f87171); }
    .summary-icon.balance-bg { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .summary-icon.total-bg { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    
    .summary-info {
        flex: 1;
    }
    
    .summary-label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        display: block;
    }
    
    .summary-value {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .summary-value.amount-positive { color: #10b981; }
    .summary-value.amount-negative { color: #ef4444; }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .stat-value {
            font-size: 1.1rem;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        .action-buttons {
            flex-direction: column;
        }
        .action-btn {
            width: 100%;
            justify-content: center;
        }
        .category-grid {
            grid-template-columns: 1fr;
        }
        .summary-banner {
            flex-direction: column;
            text-align: center;
        }
        .transaction-summary {
            grid-template-columns: repeat(2, 1fr);
        }
        .summary-item {
            padding: 0.6rem;
        }
        .summary-value {
            font-size: 0.85rem;
        }
        .table thead th,
        .table tbody td {
            padding: 0.4rem 0.6rem;
            font-size: 0.65rem;
        }
        .modal-header {
            padding: 0.8rem 1rem;
        }
        .modal-body {
            padding: 1rem;
        }
        .search-bar {
            max-width: 100%;
        }
    }
</style>

<div class="container-fluid px-0">

  

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon income"><i class="fas fa-arrow-down"></i></div>
            <div class="stat-info">
                <h4>Total Income</h4>
                <div class="stat-value amount-positive">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon expense"><i class="fas fa-arrow-up"></i></div>
            <div class="stat-info">
                <h4>Total Expenses</h4>
                <div class="stat-value amount-negative">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon balance"><i class="fas fa-calculator"></i></div>
            <div class="stat-info">
                <h4>Net Balance</h4>
                <div class="stat-value {{ ($balance ?? 0) >= 0 ? 'amount-positive' : 'amount-negative' }}">
                    {{ ($balance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($balance ?? 0), 2) }}
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon church"><i class="fas fa-church"></i></div>
            <div class="stat-info">
                <h4>Church Balance</h4>
                <div class="stat-value {{ ($allTimeBalance ?? 0) >= 0 ? 'amount-positive' : 'amount-negative' }}">
                    {{ ($allTimeBalance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($allTimeBalance ?? 0), 2) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="action-btn income" data-bs-toggle="modal" data-bs-target="#incomeModal">
            <i class="fas fa-plus-circle"></i> Record Income
        </button>
        <button class="action-btn expense" data-bs-toggle="modal" data-bs-target="#expenseModal">
            <i class="fas fa-minus-circle"></i> Record Expense
        </button>
        <button class="action-btn history" data-bs-toggle="modal" data-bs-target="#transactionsModal">
            <i class="fas fa-list"></i> View All Transactions
        </button>
    </div>

    <!-- Summary Banner -->
    <div class="summary-banner">
        <div>
            <h4><i class="fas fa-chart-line me-1" style="color: #10b981;"></i> Financial Summary</h4>
            <div class="amount">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="small">Total Income</div>
        </div>
        <div>
            <div class="small">Expenses: ₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            <div class="small">Net: ₱{{ number_format($balance ?? 0, 2) }}</div>
        </div>
    </div>

    <!-- Category Breakdown -->
    <div class="category-grid">
        <div class="category-card">
            <div class="category-header">
                <h6><i class="fas fa-chart-pie text-success"></i> Income Breakdown</h6>
            </div>
            @forelse(($incomeByCategory ?? []) as $category => $amount)
                <div class="category-item">
                    <span class="category-name">{{ $category }}</span>
                    <span class="category-amount income">₱{{ number_format($amount, 2) }}</span>
                </div>
            @empty
                <div class="category-item">
                    <span class="category-name">No income records yet</span>
                    <span class="category-amount income">₱0.00</span>
                </div>
            @endforelse
            <div class="summary-row">
                <span>Total Income</span>
                <span class="amount-positive">₱{{ number_format($allTimeIncome ?? 0, 2) }}</span>
            </div>
        </div>

        <div class="category-card">
            <div class="category-header">
                <h6><i class="fas fa-chart-pie text-danger"></i> Expense Breakdown</h6>
            </div>
            @forelse(($expenseByCategory ?? []) as $category => $amount)
                <div class="category-item">
                    <span class="category-name">{{ $category }}</span>
                    <span class="category-amount expense">₱{{ number_format($amount, 2) }}</span>
                </div>
            @empty
                <div class="category-item">
                    <span class="category-name">No expense records yet</span>
                    <span class="category-amount expense">₱0.00</span>
                </div>
            @endforelse
            <div class="summary-row">
                <span>Total Expenses</span>
                <span class="amount-negative">₱{{ number_format($allTimeExpense ?? 0, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="table-container">
        <div class="card-header-custom">
            <h6><i class="fas fa-history me-2" style="color: #10b981;"></i>Recent Transactions</h6>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentTransactions ?? collect()) as $transaction)
                    <tr>
                        <td style="color: var(--text-primary);">
                            {{ \Carbon\Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}
                        </td>
                        <td style="color: var(--text-primary);">
                            <strong>{{ $transaction->description }}</strong>
                        </td>
                        <td style="color: var(--text-primary);">
                            {{ $transaction->category ?? '-' }}
                        </td>
                        <td>
                            <span class="type-badge {{ $transaction->type == 'income' ? 'badge-income' : 'badge-expense' }}">
                                <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }} me-1"></i>
                                {{ $transaction->type == 'income' ? 'Income' : 'Expense' }}
                            </span>
                        </td>
                        <td>
                            <strong class="{{ $transaction->type == 'income' ? 'amount-positive' : 'amount-negative' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount, 2) }}
                            </strong>
                        </td>
                        <td style="color: var(--text-muted);">
                            {{ $transaction->remarks ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color: var(--text-muted);">
                            <i class="fas fa-receipt fa-2x text-muted mb-2 d-block" style="color: var(--text-muted);"></i>
                            <p class="text-muted mb-0" style="color: var(--text-muted);">No transactions yet</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- INCOME MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="incomeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-arrow-down me-2" style="color: #10b981;"></i>
                        Record Income
                    </h5>
                    <p>Add money received by the church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="type" value="income">
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-tag"></i> Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" required 
                               placeholder="e.g., Sunday Offering, Tithes, Special Donation">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-folder"></i> Category <span class="text-danger">*</span></label>
                        <div class="category-pills">
                            <div class="category-pill selected" data-category="Sunday Offering" onclick="selectIncomeCategory(this, 'Sunday Offering')">
                                <i class="fas fa-church"></i> Sunday Offering
                            </div>
                            <div class="category-pill" data-category="Tithe" onclick="selectIncomeCategory(this, 'Tithe')">
                                <i class="fas fa-hand-holding-heart"></i> Tithe
                            </div>
                            <div class="category-pill" data-category="Special Donation" onclick="selectIncomeCategory(this, 'Special Donation')">
                                <i class="fas fa-gift"></i> Special Donation
                            </div>
                            <div class="category-pill" data-category="Building Fund" onclick="selectIncomeCategory(this, 'Building Fund')">
                                <i class="fas fa-building"></i> Building Fund
                            </div>
                            <div class="category-pill" data-category="Other Income" onclick="selectIncomeCategory(this, 'Other Income')">
                                <i class="fas fa-ellipsis-h"></i> Other Income
                            </div>
                        </div>
                        <input type="hidden" name="category" id="incomeCategory" value="Sunday Offering">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-money-bill-wave"></i> Amount (₱) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" name="amount" step="0.01" class="form-control" required 
                                       placeholder="0.00" id="incomeAmount" oninput="updateIncomePreview()">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-calendar"></i> Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" 
                                   max="{{ date('Y-m-d') }}" required>
                            <small class="text-muted" style="font-size: 0.6rem; display: block; margin-top: 3px;">
                                <i class="fas fa-info-circle"></i> Only past or today's date allowed
                            </small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Donor Name</label>
                        <input type="text" name="donor_name" class="form-control" placeholder="Optional - Name of the donor">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-pen"></i> Remarks / Notes</label>
                        <textarea name="remarks" class="form-control" rows="2" placeholder="Additional notes about this income..."></textarea>
                    </div>
                    
                    <div class="amount-preview alert-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-calculator me-2"></i> Amount to Record:</span>
                            <strong id="incomePreviewAmount" class="fs-5" style="color: #10b981;">₱0.00</strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn-success">
                        <i class="fas fa-save me-1"></i> Save Income
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- EXPENSE MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-arrow-up me-2" style="color: #ef4444;"></i>
                        Record Expense
                    </h5>
                    <p>Record money spent by the church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="type" value="expense">
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-tag"></i> Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control" required 
                               placeholder="e.g., Outreach Program, Church Supplies">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-folder"></i> Category <span class="text-danger">*</span></label>
                        <div class="category-pills">
                            <div class="category-pill selected" data-category="Church Help" onclick="selectExpenseCategory(this, 'Church Help')">
                                <i class="fas fa-hands-helping"></i> Church Help
                            </div>
                            <div class="category-pill" data-category="Outreach" onclick="selectExpenseCategory(this, 'Outreach')">
                                <i class="fas fa-hand-holding-heart"></i> Outreach
                            </div>
                            <div class="category-pill" data-category="Donation to Others" onclick="selectExpenseCategory(this, 'Donation to Others')">
                                <i class="fas fa-gift"></i> Donation
                            </div>
                            <div class="category-pill" data-category="Maintenance" onclick="selectExpenseCategory(this, 'Maintenance')">
                                <i class="fas fa-tools"></i> Maintenance
                            </div>
                            <div class="category-pill" data-category="Other Expense" onclick="selectExpenseCategory(this, 'Other Expense')">
                                <i class="fas fa-ellipsis-h"></i> Other Expense
                            </div>
                        </div>
                        <input type="hidden" name="category" id="expenseCategory" value="Church Help">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-money-bill-wave"></i> Amount (₱) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" name="amount" step="0.01" class="form-control" required 
                                       placeholder="0.00" id="expenseAmount" oninput="updateExpensePreview()">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-calendar"></i> Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" 
                                   max="{{ date('Y-m-d') }}" required>
                            <small class="text-muted" style="font-size: 0.6rem; display: block; margin-top: 3px;">
                                <i class="fas fa-info-circle"></i> Only past or today's date allowed
                            </small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Recipient / Beneficiary</label>
                        <input type="text" name="recipient" class="form-control" placeholder="Optional - Who received this amount?">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-pen"></i> Remarks / Notes</label>
                        <textarea name="remarks" class="form-control" rows="2" placeholder="Additional notes about this expense..."></textarea>
                    </div>
                    
                    <div class="amount-preview alert-info">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-wallet me-2"></i> Current Balance:</span>
                            <strong id="currentBalance">₱{{ number_format($allTimeBalance ?? 0, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-minus-circle me-2" style="color: #ef4444;"></i> Amount to Deduct:</span>
                            <strong id="expensePreviewAmount" style="color: #ef4444;">₱0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top" style="border-top-color: var(--border-color);">
                            <span><i class="fas fa-calculator me-2"></i> Remaining Balance:</span>
                            <strong id="remainingBalance" class="fs-5" style="color: #10b981;">₱{{ number_format($allTimeBalance ?? 0, 2) }}</strong>
                        </div>
                    </div>
                    
                    @if(($allTimeBalance ?? 0) <= 0)
                        <div class="alert-danger" style="padding: 0.6rem 1rem; border-radius: 8px; margin-top: 0.8rem;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Insufficient balance! Current balance: ₱{{ number_format($allTimeBalance ?? 0, 2) }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn-danger" id="expenseSubmitBtn" {{ ($allTimeBalance ?? 0) <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save me-1"></i> Save Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- ALL TRANSACTIONS MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="transactionsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-list me-2" style="color: #10b981;"></i>
                        All Transactions
                    </h5>
                    <p>Complete financial history of your church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Filter Tabs -->
                <div class="filter-tabs mb-3">
                    <button class="filter-tab active" onclick="filterTransactions('all', event)">All Transactions</button>
                    <button class="filter-tab" onclick="filterTransactions('income', event)"><i class="fas fa-arrow-down me-1" style="color: #10b981;"></i> Income</button>
                    <button class="filter-tab" onclick="filterTransactions('expense', event)"><i class="fas fa-arrow-up me-1" style="color: #ef4444;"></i> Expense</button>
                </div>
                
                <!-- Summary Stats -->
                <div class="transaction-summary mb-3">
                    <div class="summary-item">
                        <div class="summary-icon income-bg"><i class="fas fa-arrow-down"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Total Income</span>
                            <span class="summary-value amount-positive">₱{{ number_format($allTimeIncome ?? 0, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-icon expense-bg"><i class="fas fa-arrow-up"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Total Expenses</span>
                            <span class="summary-value amount-negative">₱{{ number_format($allTimeExpense ?? 0, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-icon balance-bg"><i class="fas fa-calculator"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Net Balance</span>
                            <span class="summary-value {{ ($allTimeBalance ?? 0) >= 0 ? 'amount-positive' : 'amount-negative' }}">
                                {{ ($allTimeBalance ?? 0) >= 0 ? '+' : '-' }} ₱{{ number_format(abs($allTimeBalance ?? 0), 2) }}
                            </span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-icon total-bg"><i class="fas fa-receipt"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Total Transactions</span>
                            <span class="summary-value" id="totalTransactions">{{ count($transactions ?? []) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="search-bar mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="transactionSearch" class="form-control" 
                               placeholder="Search transactions..." 
                               onkeyup="searchTransactions()">
                    </div>
                </div>
                
                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            @forelse(($transactions ?? [])->sortByDesc('date') as $transaction)
                            <tr data-type="{{ $transaction->type }}" data-search="{{ strtolower($transaction->description . ' ' . ($transaction->category ?? '') . ' ' . ($transaction->remarks ?? '')) }}">
                                <td style="color: var(--text-primary);">
                                    {{ \Carbon\Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}
                                </td>
                                <td style="color: var(--text-primary);">
                                    <strong>{{ $transaction->description }}</strong>
                                    @if($transaction->type == 'income' && $transaction->donor_name)
                                        <div class="small text-muted"><i class="fas fa-user me-1"></i> Donor: {{ $transaction->donor_name }}</div>
                                    @elseif($transaction->type == 'expense' && $transaction->recipient)
                                        <div class="small text-muted"><i class="fas fa-user me-1"></i> Recipient: {{ $transaction->recipient }}</div>
                                    @endif
                                </td>
                                <td style="color: var(--text-primary);">
                                    <span class="category-badge" style="background: var(--bg-tertiary); padding: 2px 10px; border-radius: 20px; font-size: 0.65rem;">
                                        {{ $transaction->category ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="type-badge {{ $transaction->type == 'income' ? 'badge-income' : 'badge-expense' }}">
                                        <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }} me-1"></i>
                                        {{ $transaction->type == 'income' ? 'Income' : 'Expense' }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="{{ $transaction->type == 'income' ? 'amount-positive' : 'amount-negative' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount, 2) }}
                                    </strong>
                                </td>
                                <td style="color: var(--text-muted);">{{ $transaction->remarks ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: var(--text-muted);">
                                    <i class="fas fa-receipt fa-2x mb-2 d-block" style="color: var(--text-muted);"></i>
                                    <p class="mb-0" style="color: var(--text-muted);">No transactions found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary btn-sm" onclick="exportToCSV()" style="padding: 0.3rem 0.8rem;">
                    <i class="fas fa-file-excel me-1"></i> Export CSV
                </button>
                <button class="btn-secondary btn-sm" onclick="window.print()" style="padding: 0.3rem 0.8rem;">
                    <i class="fas fa-print me-1"></i> Print
                </button>
                <button type="button" class="btn-primary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Income Category Selection
    function selectIncomeCategory(element, category) {
        document.querySelectorAll('#incomeModal .category-pill').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('incomeCategory').value = category;
    }
    
    // Expense Category Selection
    function selectExpenseCategory(element, category) {
        document.querySelectorAll('#expenseModal .category-pill').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('expenseCategory').value = category;
    }
    
    // Update Income Preview
    function updateIncomePreview() {
        let amount = parseFloat(document.getElementById('incomeAmount')?.value) || 0;
        let preview = document.getElementById('incomePreviewAmount');
        if (preview) {
            preview.textContent = '₱' + amount.toFixed(2);
        }
    }
    
    // Update Expense Preview
    function updateExpensePreview() {
        let amount = parseFloat(document.getElementById('expenseAmount')?.value) || 0;
        let currentBalance = {{ $allTimeBalance ?? 0 }};
        let remainingBalance = currentBalance - amount;
        
        let previewAmount = document.getElementById('expensePreviewAmount');
        let remainingSpan = document.getElementById('remainingBalance');
        let submitBtn = document.getElementById('expenseSubmitBtn');
        
        if (previewAmount) {
            previewAmount.textContent = '₱' + amount.toFixed(2);
        }
        
        if (remainingSpan) {
            remainingSpan.textContent = (remainingBalance >= 0 ? '₱' : '-₱') + Math.abs(remainingBalance).toFixed(2);
            remainingSpan.style.color = remainingBalance >= 0 ? '#10b981' : '#ef4444';
        }
        
        if (submitBtn) {
            if (amount > currentBalance && currentBalance > 0) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
            } else {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            }
        }
    }
    
    // Filter Transactions
    function filterTransactions(type, event) {
        if (event) {
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (type === 'all') {
                row.style.display = '';
                visibleCount++;
            } else if (row.getAttribute('data-type') === type) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        const totalSpan = document.getElementById('totalTransactions');
        if (totalSpan) {
            totalSpan.textContent = visibleCount;
        }
    }
    
    // Search Transactions
    function searchTransactions() {
        const searchTerm = document.getElementById('transactionSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            if (searchData.includes(searchTerm) || searchTerm === '') {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        const totalSpan = document.getElementById('totalTransactions');
        if (totalSpan) {
            totalSpan.textContent = visibleCount;
        }
    }
    
    // Export to CSV
    function exportToCSV() {
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let csvContent = "Date,Description,Category,Type,Amount,Notes\n";
        
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const cells = row.querySelectorAll('td');
                const rowData = [];
                cells.forEach(cell => {
                    let text = cell.innerText.replace(/,/g, ';');
                    rowData.push(text);
                });
                csvContent += rowData.join(',') + "\n";
            }
        });
        
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.download = 'transactions_export.csv';
        link.click();
        URL.revokeObjectURL(url);
    }
    
    // Initialize on modal open
    document.getElementById('incomeModal')?.addEventListener('shown.bs.modal', function() {
        updateIncomePreview();
    });
    
    document.getElementById('expenseModal')?.addEventListener('shown.bs.modal', function() {
        updateExpensePreview();
    });
    
    document.getElementById('transactionsModal')?.addEventListener('shown.bs.modal', function() {
        document.getElementById('transactionSearch').value = '';
        filterTransactions('all');
    });
</script>
@endsection