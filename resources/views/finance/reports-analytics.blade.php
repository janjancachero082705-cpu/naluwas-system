@extends('layouts.sidebar')

@section('header', 'Reports & Analytics')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
:root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --info: #8b5cf6;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
}

.reports-container {
    max-width: 100%;
    margin: 0;
}

/* Print Styles */
@media print {
    .no-print, .filter-section, .action-buttons, .print-modal, .btn, .modal {
        display: none !important;
    }
    .print-section { break-inside: avoid; }
    .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
    .print-footer { display: block !important; text-align: center; margin-top: 20px; font-size: 10px; }
}

.print-header, .print-footer { display: none; }

/* Professional Card Design */
.pro-card {
    background: white;
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.pro-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    background: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.pro-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--gray-800);
    display: flex;
    align-items: center;
    gap: 10px;
}

.pro-card-title i {
    color: var(--primary);
    font-size: 1.2rem;
}

.pro-card-body {
    padding: 1.5rem;
}

/* KPI Cards */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.kpi-card {
    background: white;
    border-radius: 20px;
    padding: 1.25rem;
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary), var(--info));
}

.kpi-card.income::before { background: linear-gradient(90deg, #10b981, #34d399); }
.kpi-card.expense::before { background: linear-gradient(90deg, #ef4444, #f87171); }
.kpi-card.balance::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
.kpi-card.avg::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

.kpi-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1);
}

.kpi-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 0.5rem;
}

.kpi-value {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--gray-800);
    line-height: 1.2;
    margin-bottom: 0.25rem;
}

.kpi-trend {
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.trend-up { color: #10b981; }
.trend-down { color: #ef4444; }

/* Filter Section */
.filter-section {
    background: white;
    border-radius: 20px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--gray-200);
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: flex-end;
}

.filter-group {
    flex: 1;
    min-width: 150px;
}

.filter-group label {
    display: block;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-600);
    margin-bottom: 0.25rem;
}

.filter-group select, .filter-group input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--gray-200);
    border-radius: 10px;
    font-size: 0.85rem;
    background: white;
    transition: all 0.2s;
}

.filter-group select:focus, .filter-group input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Buttons */
.btn-pro {
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-pro-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.btn-pro-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-pro-secondary {
    background: var(--gray-100);
    color: var(--gray-700);
    border: 1px solid var(--gray-200);
}

.btn-pro-secondary:hover {
    background: var(--gray-200);
}

.btn-pro-info {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    color: white;
}

.btn-pro-info:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

/* Tables */
.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    text-align: left;
    padding: 0.75rem 0.5rem;
    background: var(--gray-50);
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-600);
    border-bottom: 1px solid var(--gray-200);
}

.data-table td {
    padding: 0.75rem 0.5rem;
    font-size: 0.8rem;
    border-bottom: 1px solid var(--gray-100);
}

.data-table tbody tr:hover {
    background: var(--gray-50);
}

/* Category Items */
.category-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0;
    border-bottom: 1px solid var(--gray-100);
}

.category-name {
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.category-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.category-dot.income { background: #10b981; }
.category-dot.expense { background: #ef4444; }

.category-amount {
    font-size: 0.85rem;
    font-weight: 700;
}

.income-color { color: #10b981; }
.expense-color { color: #ef4444; }

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    margin-top: 0.5rem;
    border-top: 2px solid var(--gray-200);
    font-weight: 700;
}

/* Chart Container */
.chart-wrapper {
    background: white;
    border-radius: 16px;
    padding: 0.5rem;
}

.chart-box {
    height: 320px;
    position: relative;
}

/* Badges */
.badge-pro {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
}

.badge-income { background: #d1fae5; color: #065f46; }
.badge-expense { background: #fee2e2; color: #991b1b; }

/* Print Modal */
.print-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.print-modal-content {
    background: white;
    width: 480px;
    max-width: 90%;
    border-radius: 20px;
    overflow: hidden;
    animation: modalFadeIn 0.2s ease;
}

.print-modal-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #1e293b, #0f172a);
    color: white;
}

.print-modal-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.print-modal-body {
    padding: 1.5rem;
}

.print-option {
    margin-bottom: 1rem;
    padding: 0.75rem;
    border: 1px solid var(--gray-200);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.print-option:hover {
    background: var(--gray-50);
    border-color: var(--primary);
}

.print-option.selected {
    background: #eff6ff;
    border-color: var(--primary);
}

.print-option-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.print-option-desc {
    font-size: 0.7rem;
    color: var(--gray-600);
}

.print-modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--gray-200);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.format-group {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--gray-200);
}

.format-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: block;
}

.format-options {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.format-option {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    font-size: 0.8rem;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

/* Responsive */
@media (max-width: 768px) {
    .filter-section {
        flex-direction: column;
    }
    .filter-group {
        width: 100%;
    }
    .kpi-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    .kpi-value {
        font-size: 1.25rem;
    }
    .pro-card-header {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="reports-container">

@php
    $selectedMonth = request('month');
    $selectedYear = request('year');
    $selectedType = request('type');
    $churchId = session('current_church_id', auth()->user()->church_id);
    $churchName = auth()->user()->church->name ?? 'My Church';
    
    // Build query
    $query = App\Models\MoneyTransaction::where('church_id', $churchId);
    if ($selectedMonth && $selectedMonth != '') $query->whereMonth('date', $selectedMonth);
    if ($selectedYear && $selectedYear != '') $query->whereYear('date', $selectedYear);
    if ($selectedType && $selectedType != '') $query->where('type', $selectedType);
    
    $transactions = $query->orderBy('date', 'desc')->get();
    
    $totalIncome = $transactions->where('type', 'income')->sum('amount');
    $totalExpense = $transactions->where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;
    
    $allTimeIncome = App\Models\MoneyTransaction::where('church_id', $churchId)->where('type', 'income')->sum('amount');
    $allTimeExpense = App\Models\MoneyTransaction::where('church_id', $churchId)->where('type', 'expense')->sum('amount');
    $allTimeBalance = $allTimeIncome - $allTimeExpense;
    
    // Category breakdowns
    $incomeByCategory = App\Models\MoneyTransaction::where('church_id', $churchId)
        ->where('type', 'income')
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->get();
    
    $expenseByCategory = App\Models\MoneyTransaction::where('church_id', $churchId)
        ->where('type', 'expense')
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->get();
    
    // Top transactions
    $topIncome = App\Models\MoneyTransaction::where('church_id', $churchId)
        ->where('type', 'income')
        ->orderBy('amount', 'desc')
        ->limit(5)
        ->get();
    
    $topExpense = App\Models\MoneyTransaction::where('church_id', $churchId)
        ->where('type', 'expense')
        ->orderBy('amount', 'desc')
        ->limit(5)
        ->get();
    
    // Monthly data for chart (last 12 months)
    $months = [];
    $monthlyIncome = [];
    $monthlyExpense = [];
    for ($i = 11; $i >= 0; $i--) {
        $month = Carbon\Carbon::now()->subMonths($i);
        $months[] = $month->format('M Y');
        $monthlyIncome[] = (float) App\Models\MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'income')
            ->whereYear('date', $month->year)
            ->whereMonth('date', $month->month)
            ->sum('amount');
        $monthlyExpense[] = (float) App\Models\MoneyTransaction::where('church_id', $churchId)
            ->where('type', 'expense')
            ->whereYear('date', $month->year)
            ->whereMonth('date', $month->month)
            ->sum('amount');
    }
    
    $avgMonthlyIncome = $totalIncome / max(1, $transactions->pluck('date')->map(function($d) { return date('Y-m', strtotime($d)); })->unique()->count());
    $avgMonthlyExpense = $totalExpense / max(1, $transactions->pluck('date')->map(function($d) { return date('Y-m', strtotime($d)); })->unique()->count());
    
    $isFiltered = ($selectedMonth && $selectedMonth != '') || ($selectedYear && $selectedYear != '');
    $displayMonth = $selectedMonth ? date('F', mktime(0,0,0,$selectedMonth,1)) : 'All Months';
    $displayYear = $selectedYear ?: 'All Years';
@endphp

{{-- Print Header --}}
<div class="print-header">
    <h2>{{ $churchName }}</h2>
    <p>Financial Report - {{ now()->format('F d, Y') }}</p>
    <p>Period: {{ $displayMonth }} {{ $displayYear }}</p>
    <hr>
</div>

{{-- Filter Section --}}
<div class="filter-section no-print">
    <div class="filter-group">
        <label><i class="fas fa-calendar-alt"></i> Month</label>
        <select id="monthFilter">
            <option value="">All Months</option>
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
            @endforeach
        </select>
    </div>
    <div class="filter-group">
        <label><i class="fas fa-calendar-year"></i> Year</label>
        <select id="yearFilter">
            <option value="">All Years</option>
            @php $currentYear = date('Y'); @endphp
            @for($y = $currentYear; $y >= $currentYear - 5; $y--)
                <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </div>
    <div class="filter-group">
        <label><i class="fas fa-chart-line"></i> Type</label>
        <select id="typeFilter">
            <option value="">All Types</option>
            <option value="income" {{ $selectedType == 'income' ? 'selected' : '' }}>Income Only</option>
            <option value="expense" {{ $selectedType == 'expense' ? 'selected' : '' }}>Expense Only</option>
        </select>
    </div>
    <div class="action-buttons">
        <button class="btn-pro btn-pro-primary" onclick="applyFilters()">
            <i class="fas fa-search"></i> Apply
        </button>
        <button class="btn-pro btn-pro-secondary" onclick="resetFilters()">
            <i class="fas fa-undo"></i> Reset
        </button>
        <button class="btn-pro btn-pro-info" onclick="openPrintModal()">
            <i class="fas fa-print"></i> Export
        </button>
    </div>
</div>

{{-- KPI Cards --}}
<div class="kpi-grid print-section" id="stats-section">
    <div class="kpi-card income">
        <div class="kpi-label">Total Income</div>
        <div class="kpi-value">₱{{ number_format($totalIncome, 2) }}</div>
        <div class="kpi-trend trend-up">
            <i class="fas fa-arrow-up"></i> {{ $isFiltered ? 'Filtered Period' : 'All Time' }}
        </div>
    </div>
    <div class="kpi-card expense">
        <div class="kpi-label">Total Expenses</div>
        <div class="kpi-value">₱{{ number_format($totalExpense, 2) }}</div>
        <div class="kpi-trend trend-down">
            <i class="fas fa-arrow-down"></i> {{ $isFiltered ? 'Filtered Period' : 'All Time' }}
        </div>
    </div>
    <div class="kpi-card balance">
        <div class="kpi-label">Net Balance</div>
        <div class="kpi-value {{ $balance >= 0 ? 'text-success' : 'text-danger' }}">
            {{ $balance >= 0 ? '+' : '-' }}₱{{ number_format(abs($balance), 2) }}
        </div>
        <div class="kpi-trend">
            {{ $balance >= 0 ? 'Surplus' : 'Deficit' }}
        </div>
    </div>
    <div class="kpi-card avg">
        <div class="kpi-label">Church Balance</div>
        <div class="kpi-value">₱{{ number_format($allTimeBalance, 2) }}</div>
        <div class="kpi-trend">Lifetime Balance</div>
    </div>
</div>

{{-- Chart Section --}}
<div class="pro-card print-section" id="chart-section">
    <div class="pro-card-header">
        <div class="pro-card-title">
            <i class="fas fa-chart-line"></i> Income vs Expenses Trend
        </div>
        <div>
            <span class="badge-pro badge-income"><i class="fas fa-chart-line"></i> Last 12 Months</span>
        </div>
    </div>
    <div class="pro-card-body">
        <div class="chart-wrapper">
            <div class="chart-box">
                <canvas id="financialChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Category Breakdowns --}}
<div class="row g-4 mb-4 print-section" id="category-section">
    <div class="col-md-6">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">
                    <i class="fas fa-arrow-down text-success"></i> Income by Category
                </div>
            </div>
            <div class="pro-card-body">
                <div class="category-list">
                    @forelse($incomeByCategory as $category)
                        <div class="category-item">
                            <div class="category-name">
                                <span class="category-dot income"></span>
                                {{ $category->category ?? 'Uncategorized' }}
                            </div>
                            <div class="category-amount income-color">₱{{ number_format($category->total, 2) }}</div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No income records found</div>
                    @endforelse
                    <div class="summary-row">
                        <span>Total Income</span>
                        <span class="income-color">₱{{ number_format($totalIncome, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">
                    <i class="fas fa-arrow-up text-danger"></i> Expense by Category
                </div>
            </div>
            <div class="pro-card-body">
                <div class="category-list">
                    @forelse($expenseByCategory as $category)
                        <div class="category-item">
                            <div class="category-name">
                                <span class="category-dot expense"></span>
                                {{ $category->category ?? 'Uncategorized' }}
                            </div>
                            <div class="category-amount expense-color">₱{{ number_format($category->total, 2) }}</div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No expense records found</div>
                    @endforelse
                    <div class="summary-row">
                        <span>Total Expenses</span>
                        <span class="expense-color">₱{{ number_format($totalExpense, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top Transactions --}}
<div class="row g-4 mb-4 print-section" id="transactions-section">
    <div class="col-md-6">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">
                    <i class="fas fa-trophy text-warning"></i> Top 5 Income
                </div>
            </div>
            <div class="pro-card-body">
                <table class="data-table">
                    <thead>
                        <tr><th>Date</th><th>Description</th><th>Amount</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topIncome as $t)
                        <tr><td>{{ \Carbon\Carbon::parse($t->date)->format('M d, Y') }}</td><td>{{ Str::limit($t->description, 25) }}</td><td class="text-success">+₱{{ number_format($t->amount, 2) }}</td></tr>
                        @empty<tr><td colspan="3" class="text-center text-muted">No records</td></tr>@endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="pro-card">
            <div class="pro-card-header">
                <div class="pro-card-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Top 5 Expenses
                </div>
            </div>
            <div class="pro-card-body">
                <table class="data-table">
                    <thead>
                        <tr><th>Date</th><th>Description</th><th>Amount</th></tr>
                    </thead>
                    <tbody>
                        @forelse($topExpense as $t)
                        <tr><td>{{ \Carbon\Carbon::parse($t->date)->format('M d, Y') }}</td><td>{{ Str::limit($t->description, 25) }}</td><td class="text-danger">-₱{{ number_format($t->amount, 2) }}</td></tr>
                        @empty<tr><td colspan="3" class="text-center text-muted">No records</td></tr>@endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- All Transactions --}}
<div class="pro-card print-section" id="all-transactions-section">
    <div class="pro-card-header">
        <div class="pro-card-title">
            <i class="fas fa-list-ul"></i> All Transactions
        </div>
        <div><span class="badge-pro badge-income">{{ $transactions->count() }} records</span></div>
    </div>
    <div class="pro-card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr><th>Date</th><th>Description</th><th>Category</th><th>Type</th><th>Amount</th></tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->date)->format('M d, Y') }}</td>
                        <td>{{ Str::limit($t->description, 30) }}</td>
                        <td>{{ $t->category ?? '-' }}</td>
                        <td><span class="badge-pro {{ $t->type == 'income' ? 'badge-income' : 'badge-expense' }}">{{ ucfirst($t->type) }}</span></td>
                        <td class="{{ $t->type == 'income' ? 'text-success' : 'text-danger' }}">{{ $t->type == 'income' ? '+' : '-' }} ₱{{ number_format($t->amount, 2) }}</td>
                    </tr>
                    @empty<tr><td colspan="5" class="text-center text-muted py-4">No transactions found</td></tr>@endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Print Footer --}}
<div class="print-footer">
    <p>Generated on {{ now()->format('F d, Y h:i A') }} | {{ $churchName }} Financial Report</p>
    <p>This is a computer-generated document. No signature required.</p>
</div>

</div>

{{-- Print Modal --}}
<div id="printModal" class="print-modal no-print">
    <div class="print-modal-content">
        <div class="print-modal-header">
            <h3><i class="fas fa-print me-2"></i> Export Report</h3>
        </div>
        <div class="print-modal-body">
            <div class="print-option selected" onclick="togglePrintSection('stats')">
                <div class="print-option-title">
                    <input type="checkbox" id="chk-stats" checked class="me-2"> 📊 Key Metrics
                </div>
                <div class="print-option-desc">Income, Expenses, Balance summary cards</div>
            </div>
            <div class="print-option selected" onclick="togglePrintSection('chart')">
                <div class="print-option-title">
                    <input type="checkbox" id="chk-chart" checked class="me-2"> 📈 Trend Chart
                </div>
                <div class="print-option-desc">12-month income vs expense visualization</div>
            </div>
            <div class="print-option selected" onclick="togglePrintSection('category')">
                <div class="print-option-title">
                    <input type="checkbox" id="chk-category" checked class="me-2"> 📂 Category Breakdown
                </div>
                <div class="print-option-desc">Income and expense by category</div>
            </div>
            <div class="print-option selected" onclick="togglePrintSection('transactions')">
                <div class="print-option-title">
                    <input type="checkbox" id="chk-transactions" checked class="me-2"> 🏆 Top Transactions
                </div>
                <div class="print-option-desc">Top 5 income and expense transactions</div>
            </div>
            <div class="print-option selected" onclick="togglePrintSection('all-transactions')">
                <div class="print-option-title">
                    <input type="checkbox" id="chk-all-transactions" checked class="me-2"> 📋 All Transactions
                </div>
                <div class="print-option-desc">Complete transaction history</div>
            </div>
            <div class="format-group">
                <div class="format-label">Export Format:</div>
                <div class="format-options">
                    <label class="format-option"><input type="radio" name="exportFormat" value="print" checked> 🖨️ Print</label>
                    <label class="format-option"><input type="radio" name="exportFormat" value="pdf"> 📄 PDF</label>
                    <label class="format-option"><input type="radio" name="exportFormat" value="excel"> 📊 Excel</label>
                    <label class="format-option"><input type="radio" name="exportFormat" value="csv"> 📎 CSV</label>
                </div>
            </div>
        </div>
        <div class="print-modal-footer">
            <button class="btn-pro btn-pro-secondary" onclick="closePrintModal()">Cancel</button>
            <button class="btn-pro btn-pro-primary" onclick="executeExport()">Export</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
// Financial Chart
new Chart(document.getElementById('financialChart'), {
    type: 'line',
    data: {
        labels: @json($months),
        datasets: [
            { label: 'Income', data: @json($monthlyIncome), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.05)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#10b981', pointBorderColor: '#fff', pointBorderWidth: 2 },
            { label: 'Expenses', data: @json($monthlyExpense), borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,0.05)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#ef4444', pointBorderColor: '#fff', pointBorderWidth: 2 }
        ]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8 } }, tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ₱${ctx.parsed.y.toLocaleString()}` } } }, scales: { y: { beginAtZero: true, ticks: { callback: (v) => '₱' + v.toLocaleString() } } } }
});

let selectedSections = { stats: true, chart: true, category: true, transactions: true, allTransactions: true };
function openPrintModal() { document.getElementById('printModal').style.display = 'flex'; }
function closePrintModal() { document.getElementById('printModal').style.display = 'none'; }
function togglePrintSection(section) { let cb = document.getElementById(`chk-${section}`); cb.checked = !cb.checked; selectedSections[section] = cb.checked; cb.closest('.print-option').classList.toggle('selected', cb.checked); }
function applyFilters() { let url = "{{ route('reports.analytics') }}?"; if (document.getElementById('monthFilter').value) url += 'month=' + document.getElementById('monthFilter').value + '&'; if (document.getElementById('yearFilter').value) url += 'year=' + document.getElementById('yearFilter').value + '&'; if (document.getElementById('typeFilter').value) url += 'type=' + document.getElementById('typeFilter').value + '&'; window.location.href = url; }
function resetFilters() { window.location.href = "{{ route('reports.analytics') }}"; }
function executeExport() {
    let format = document.querySelector('input[name="exportFormat"]:checked').value;
    closePrintModal();
    if (format === 'print') printSelected();
    else if (format === 'pdf') generatePDF();
    else if (format === 'excel') exportToExcel();
    else if (format === 'csv') exportToCSV();
}
function printSelected() {
    let content = '<div class="print-header"><h2>{{ $churchName }}</h2><p>Financial Report - ' + new Date().toLocaleDateString() + '</p><hr></div>';
    if (selectedSections.stats) content += document.getElementById('stats-section').innerHTML;
    if (selectedSections.chart) content += document.getElementById('chart-section').innerHTML;
    if (selectedSections.category) content += document.getElementById('category-section').innerHTML;
    if (selectedSections.transactions) content += document.getElementById('transactions-section').innerHTML;
    if (selectedSections.allTransactions) content += document.getElementById('all-transactions-section').innerHTML;
    content += '<div class="print-footer"><p>Generated on ' + new Date().toLocaleString() + '</p></div>';
    let w = window.open('', '_blank');
    w.document.write(`<!DOCTYPE html><html><head><title>{{ $churchName }} Report</title><style>body{font-family:Arial,sans-serif;margin:20px}.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:15px}.kpi-card{border:1px solid #ddd;border-radius:10px;padding:15px;text-align:center}.kpi-value{font-size:24px;font-weight:bold}.text-success{color:#10b981}.text-danger{color:#ef4444}.data-table{width:100%;border-collapse:collapse}.data-table th,.data-table td{border:1px solid #ddd;padding:8px;text-align:left}.data-table th{background:#f5f5f5}.category-item{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #eee}.summary-row{display:flex;justify-content:space-between;padding:10px 0;border-top:2px solid #ddd;font-weight:bold}.print-header{text-align:center;margin-bottom:20px;border-bottom:2px solid #333}.print-footer{text-align:center;margin-top:20px;border-top:1px solid #ccc;padding-top:10px;font-size:10px}.badge-pro{padding:3px 8px;border-radius:5px;font-size:11px}.badge-income{background:#d1fae5;color:#065f46}.badge-expense{background:#fee2e2;color:#991b1b}</style></head><body>${content}</body></html>`);
    w.document.close(); w.print();
}
function generatePDF() {
    let element = document.createElement('div'); element.style.padding = '20px';
    let content = '<div class="print-header"><h2>{{ $churchName }}</h2><p>Financial Report - ' + new Date().toLocaleDateString() + '</p><hr></div>';
    if (selectedSections.stats) content += document.getElementById('stats-section').innerHTML;
    if (selectedSections.chart) content += document.getElementById('chart-section').innerHTML;
    if (selectedSections.category) content += document.getElementById('category-section').innerHTML;
    if (selectedSections.transactions) content += document.getElementById('transactions-section').innerHTML;
    if (selectedSections.allTransactions) content += document.getElementById('all-transactions-section').innerHTML;
    content += '<div class="print-footer"><p>Generated on ' + new Date().toLocaleString() + '</p></div>';
    element.innerHTML = content;
    html2pdf().set({ margin: [0.5,0.5,0.5,0.5], filename: '{{ preg_replace('/[^a-zA-Z0-9]/', '_', $churchName) }}_Report.pdf', image: { type: 'jpeg', quality: 0.98 }, html2canvas: { scale: 2 }, jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' } }).from(element).save();
}
function exportToExcel() {
    let data = [['Date', 'Description', 'Category', 'Type', 'Amount', 'Remarks']];
    @foreach($transactions as $t) data.push(['{{ $t->date }}', '{{ addslashes($t->description) }}', '{{ $t->category ?? "-" }}', '{{ ucfirst($t->type) }}', {{ $t->amount }}, '{{ addslashes($t->remarks ?? "-") }}']); @endforeach
    let ws = XLSX.utils.aoa_to_sheet(data); let wb = XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb, ws, 'Financial Report'); XLSX.writeFile(wb, `{{ preg_replace('/[^a-zA-Z0-9]/', '_', $churchName) }}_Report_${new Date().toISOString().slice(0,10)}.xlsx`);
}
function exportToCSV() {
    let csv = 'Date,Description,Category,Type,Amount,Remarks\n';
    @foreach($transactions as $t) csv += `"{{ $t->date }}","{{ addslashes($t->description) }}","{{ $t->category ?? "-" }}","{{ ucfirst($t->type) }}",{{ $t->amount }},"{{ addslashes($t->remarks ?? "-") }}"\n`; @endforeach
    let blob = new Blob([csv], { type: 'text/csv' }); let link = document.createElement('a'); link.href = URL.createObjectURL(blob); link.download = `{{ preg_replace('/[^a-zA-Z0-9]/', '_', $churchName) }}_Report_${new Date().toISOString().slice(0,10)}.csv`; link.click(); URL.revokeObjectURL(link.href);
}
</script>

@endsection