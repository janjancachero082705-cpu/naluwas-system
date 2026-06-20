@extends('layouts.app')

@section('header', 'Reports & Analytics')

@php
use Carbon\Carbon;
@endphp

@section('content')
<style>
    /* ============================================
       CLEAN UI - SAME STYLE AS OTHER PAGES
    ============================================ */
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-radius: 0 4px 4px 0;
    }
    
    .stat-card.income::before { background: #10b981; }
    .stat-card.expense::before { background: #ef4444; }
    .stat-card.balance::before { background: #4F46E5; }
    .stat-card.members::before { background: #8b5cf6; }
    .stat-card.choir::before { background: #f59e0b; }
    
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
    
    .stat-icon.green { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.red { background: linear-gradient(135deg, #ef4444, #f87171); }
    .stat-icon.blue { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .stat-icon.yellow { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    
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
    
    /* Hero Section - Green */
    .reports-hero {
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 12px;
        padding: 1.2rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    
    .reports-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .reports-hero h1 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: white;
        position: relative;
        z-index: 1;
    }
    
    .reports-hero h1 i {
        margin-right: 8px;
    }
    
    .reports-hero p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 0.75rem;
        position: relative;
        z-index: 1;
    }
    
    .hero-left {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .hero-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    
    .btn-export {
        background: white;
        color: #059669;
        border-radius: 8px;
        padding: 0.4rem 1.2rem;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
    }
    
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        color: #059669;
        text-decoration: none;
    }
    
    .btn-back-system {
        background: rgba(255,255,255,0.2);
        color: white;
        border-radius: 8px;
        padding: 0.4rem 1.2rem;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid rgba(255,255,255,0.2);
        cursor: pointer;
    }
    
    .btn-back-system:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
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
    
    .table-container .card-header-custom h6 i {
        color: #10b981;
        margin-right: 6px;
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
        padding: 0.6rem 1rem;
        white-space: nowrap;
    }
    
    .table thead th i {
        margin-right: 4px;
        font-size: 0.6rem;
    }
    
    .table tbody td {
        padding: 0.5rem 1rem;
        vertical-align: middle;
        color: var(--text-primary) !important;
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        font-size: 0.75rem;
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
    
    /* Badges */
    .badge-income {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
    }
    
    .badge-expense {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
        background: rgba(239, 68, 68, 0.12);
        color: #ef4444;
    }
    
    /* Member Items */
    .member-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .member-item:last-child {
        border-bottom: none;
    }
    
    .member-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--bg-tertiary);
        border: 1.5px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        color: var(--text-muted);
        flex-shrink: 0;
    }
    
    .member-avatar i {
        font-size: 0.65rem;
    }
    
    .member-item .fw-semibold {
        color: var(--text-primary);
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .member-item .text-muted {
        color: var(--text-muted);
        font-size: 0.6rem;
    }
    
    /* Chart Container */
    .chart-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
    }
    
    .chart-container h6 {
        color: var(--text-primary);
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
    }
    
    .chart-container h6 i {
        color: #10b981;
        margin-right: 6px;
    }
    
    .chart-box {
        height: 250px;
        position: relative;
    }
    
    /* Upcoming Schedule Card */
    .schedule-card {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
    }
    
    .schedule-card .group-badge {
        display: inline-block;
        padding: 0.3rem 1.2rem;
        border-radius: 20px;
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .schedule-card .schedule-detail {
        margin-top: 0.5rem;
        font-size: 0.7rem;
        color: var(--text-muted);
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
    
    .modal-header .modal-title i {
        color: #10b981;
        margin-right: 6px;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .btn-close-modal {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0.2rem 0.4rem;
    }
    
    .btn-close-modal:hover {
        color: var(--text-primary);
        transform: rotate(90deg);
    }
    
    .btn-secondary {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        padding: 0.4rem 1.2rem;
        border-radius: 8px;
        color: var(--text-secondary);
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-secondary:hover {
        background: var(--hover-bg);
        transform: translateY(-1px);
    }
    
    .btn-primary-modal {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 0.4rem 1.5rem;
        border-radius: 8px;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-primary-modal:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    
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
    
    .form-control, .form-select {
        width: 100%;
        padding: 0.4rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    /* Format Selector */
    .format-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .format-card {
        background: var(--bg-tertiary);
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 0.8rem 0.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--text-primary);
    }
    
    .format-card:hover {
        border-color: #10b981;
    }
    
    .format-card.selected {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.08);
    }
    
    .format-card i {
        font-size: 1.3rem;
        display: block;
        margin-bottom: 4px;
    }
    
    .format-card span {
        font-size: 0.6rem;
        font-weight: 600;
    }
    
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
        .reports-hero {
            text-align: center;
            padding: 1rem 1.2rem;
            flex-direction: column;
        }
        .reports-hero h1 {
            font-size: 1rem;
        }
        .hero-left {
            align-items: center;
        }
        .hero-right {
            width: 100%;
            justify-content: center;
            flex-direction: column;
        }
        .btn-export, .btn-back-system {
            width: 100%;
            justify-content: center;
        }
        .table thead th,
        .table tbody td {
            padding: 0.3rem 0.5rem;
            font-size: 0.6rem;
        }
        .member-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.55rem;
        }
        .format-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .chart-box {
            height: 180px;
        }
    }
    
    @media print {
        .no-print { display: none !important; }
        body { background: white; }
        .stat-card { border: 1px solid #ddd; }
        .table-container { border: 1px solid #ddd; }
        @page { margin: 0.5cm; }
    }
</style>

<div class="container-fluid px-0">
    <!-- Hero Section - Green -->
    <div class="reports-hero no-print">
        <div class="hero-left">
            <h1><i class="fas fa-chart-line"></i> Reports & Analytics</h1>
            <p>Complete church financial and ministry analytics dashboard</p>
        </div>
        <div class="hero-right">
            <a href="{{ route('dashboard') }}" class="btn-back-system">
                <i class="fas fa-arrow-left"></i> Back to System
            </a>
            <button class="btn-export" onclick="openExportModal()">
                <i class="fas fa-download"></i> Export / Print
            </button>
        </div>
    </div>

    <!-- Statistics Cards - Removed Today's Attendance -->
    <div class="stats-grid">
        <div class="stat-card income">
            <div class="stat-icon green"><i class="fas fa-arrow-down"></i></div>
            <div class="stat-info">
                <h4>Total Income</h4>
                <div class="stat-value amount-positive">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
                <div class="stat-trend">Money received</div>
            </div>
        </div>
        <div class="stat-card expense">
            <div class="stat-icon red"><i class="fas fa-arrow-up"></i></div>
            <div class="stat-info">
                <h4>Total Expenses</h4>
                <div class="stat-value amount-negative">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
                <div class="stat-trend">Money spent</div>
            </div>
        </div>
        <div class="stat-card balance">
            <div class="stat-icon blue"><i class="fas fa-scale-balanced"></i></div>
            <div class="stat-info">
                <h4>Net Balance</h4>
                <div class="stat-value {{ ($balance ?? 0) >= 0 ? 'amount-positive' : 'amount-negative' }}">
                    {{ ($balance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($balance ?? 0), 2) }}
                </div>
                <div class="stat-trend">{{ ($balance ?? 0) >= 0 ? 'Surplus' : 'Deficit' }}</div>
            </div>
        </div>
        <div class="stat-card members">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4>Total Members</h4>
                <div class="stat-value">{{ number_format($totalMembers ?? 0) }}</div>
                <div class="stat-trend">Church family</div>
            </div>
        </div>
        <div class="stat-card choir">
            <div class="stat-icon yellow"><i class="fas fa-music"></i></div>
            <div class="stat-info">
                <h4>Choir Members</h4>
                <div class="stat-value">{{ number_format($choirMembers ?? 0) }}</div>
                <div class="stat-trend">Voices of praise</div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="table-container">
        <div class="card-header-custom">
            <h6><i class="fas fa-history"></i> Recent Transactions</h6>
        </div>
        <div class="table-responsive">
            <table class="table" id="transactionsTable">
                <thead>
                    <tr>
                        <th><i class="fas fa-calendar"></i> Date</th>
                        <th><i class="fas fa-tag"></i> Description</th>
                        <th><i class="fas fa-folder"></i> Category</th>
                        <th><i class="fas fa-exchange-alt"></i> Type</th>
                        <th class="text-end"><i class="fas fa-money-bill-wave"></i> Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentTransactions ?? []) as $transaction)
                    <tr>
                        <td>{{ Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}</td>
                        <td>{{ $transaction->description ?? 'N/A' }}</td>
                        <td>{{ $transaction->category ?? 'General' }}</td>
                        <td><span class="{{ $transaction->type == 'income' ? 'badge-income' : 'badge-expense' }}">{{ ucfirst($transaction->type ?? 'expense') }}</span></td>
                        <td class="text-end fw-bold {{ $transaction->type == 'income' ? 'amount-positive' : 'amount-negative' }}">
                            {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount ?? 0, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4" style="color: var(--text-muted);">
                            <i class="fas fa-receipt text-muted mb-2 d-block" style="font-size: 1.5rem; opacity: 0.3;"></i>
                            No transactions found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Members and Birthdays -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="table-container">
                <div class="card-header-custom">
                    <h6><i class="fas fa-users"></i> Recent Members</h6>
                </div>
                <div class="p-3" id="membersList">
                    @forelse(($recentMembers ?? []) as $member)
                    <div class="member-item">
                        <div class="member-avatar"><i class="fas fa-user"></i></div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                            <small class="text-muted">Joined {{ Carbon::parse($member->created_at)->diffForHumans() }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4" style="color: var(--text-muted);">
                        <i class="fas fa-users text-muted mb-2 d-block" style="font-size: 1.5rem; opacity: 0.3;"></i>
                        No members found
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-container">
                <div class="card-header-custom">
                    <h6><i class="fas fa-birthday-cake"></i> Upcoming Birthdays</h6>
                </div>
                <div class="p-3" id="birthdaysList">
                    @forelse(($upcomingBirthdays ?? []) as $birthday)
                    <div class="member-item">
                        <div class="member-avatar" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; border: none;">🎂</div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $birthday->first_name ?? '' }} {{ $birthday->last_name ?? '' }}</div>
                            <small class="text-muted">{{ Carbon::parse($birthday->birthday)->format('F d') }}</small>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4" style="color: var(--text-muted);">
                        <i class="fas fa-birthday-cake text-muted mb-2 d-block" style="font-size: 1.5rem; opacity: 0.3;"></i>
                        No upcoming birthdays
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Choir Schedule -->
    <div class="table-container">
        <div class="card-header-custom">
            <h6><i class="fas fa-music"></i> Upcoming Choir Schedule</h6>
        </div>
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="schedule-card">
                        <span class="group-badge" style="background: {{ $choirGroupColor ?? '#10b981' }};">
                            <i class="fas fa-layer-group me-1"></i> {{ $choirGroupName ?? 'No schedule yet' }}
                        </span>
                        <div class="schedule-detail">
                            <i class="fas fa-users me-1"></i> {{ $choirMembersCount ?? 0 }} members scheduled
                        </div>
                        <div class="schedule-detail">
                            <i class="fas fa-calendar-alt me-1"></i> 
                            @php $nextSun = Carbon::now(); if ($nextSun->dayOfWeek != Carbon::SUNDAY) $nextSun = $nextSun->next(Carbon::SUNDAY); @endphp
                            {{ $nextSun->format('F d, Y') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('choir-schedules.index') }}" class="btn-primary-modal">
                        <i class="fas fa-arrow-right me-1"></i> View Schedule
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Chart -->
    <div class="chart-container">
        <h6><i class="fas fa-chart-line"></i> Income vs Expenses (Last 6 Months)</h6>
        <div class="chart-box">
            <canvas id="financeChart"></canvas>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div id="exportModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-magic"></i> Customize Your Report</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Format Selection -->
                <div class="format-grid">
                    <div class="format-card selected" data-format="pdf" onclick="selectFormat(this)">
                        <i class="fas fa-file-pdf" style="color: #ef4444;"></i>
                        <span>PDF</span>
                    </div>
                    <div class="format-card" data-format="excel" onclick="selectFormat(this)">
                        <i class="fas fa-file-excel" style="color: #10b981;"></i>
                        <span>Excel</span>
                    </div>
                    <div class="format-card" data-format="csv" onclick="selectFormat(this)">
                        <i class="fas fa-file-csv" style="color: #3b82f6;"></i>
                        <span>CSV</span>
                    </div>
                    <div class="format-card" data-format="print" onclick="selectFormat(this)">
                        <i class="fas fa-print" style="color: #8b5cf6;"></i>
                        <span>Print</span>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAllCheckbox" checked onchange="toggleSelectAll()">
                        <label class="form-check-label" for="selectAllCheckbox" style="font-size: 0.8rem; font-weight: 600; color: var(--text-primary);">
                            ✓ Select All Sections
                        </label>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="income" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">💰 Income</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="expenses" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">💸 Expenses</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="balance" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">⚖️ Balance</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="transactions" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">📋 Transactions</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="members" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">👥 Members</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="birthdays" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">🎂 Birthdays</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="choir" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">🎵 Choir</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input section-cb" value="chart" checked>
                            <label class="form-check-label" style="font-size: 0.75rem;">📈 Chart</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-modal" onclick="generateReport()">
                    <i class="fas fa-file-export me-1"></i> Generate Report
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let selectedFormat = 'pdf';
    let currentReportHTML = '';
    let churchLogoUrl = '{{ $churchLogo ?? "" }}';
    let churchNameText = '{{ $churchName ?? "TINC Church" }}';

    function getSystemLogo() {
        if (churchLogoUrl && churchLogoUrl !== '') {
            return churchLogoUrl;
        }
        let logoImg = document.getElementById('logoImg');
        if (logoImg && logoImg.tagName === 'IMG' && logoImg.src) {
            return logoImg.src;
        }
        let anyLogo = document.querySelector('.logo-section img, .logo-img');
        if (anyLogo && anyLogo.src) {
            return anyLogo.src;
        }
        return '{{ asset("images/default-church-logo.png") }}';
    }

    function getChurchNameText() {
        if (churchNameText && churchNameText !== '') {
            return churchNameText;
        }
        let nameEl = document.querySelector('.logo-text h2');
        return nameEl ? nameEl.innerText : 'TINC Church';
    }

    function openExportModal() {
        const modal = new bootstrap.Modal(document.getElementById('exportModal'));
        modal.show();
    }

    function selectFormat(element) {
        document.querySelectorAll('.format-card').forEach(c => c.classList.remove('selected'));
        element.classList.add('selected');
        selectedFormat = element.dataset.format;
    }

    function toggleSelectAll() {
        let isChecked = document.getElementById('selectAllCheckbox').checked;
        document.querySelectorAll('.section-cb').forEach(cb => cb.checked = isChecked);
    }

    function getSelectedSections() {
        let selected = [];
        document.querySelectorAll('.section-cb:checked').forEach(cb => selected.push(cb.value));
        return selected;
    }

    function getPageData() {
        return {
            totalIncome: document.querySelector('.stat-card.income .stat-value')?.innerText || '₱0',
            totalExpense: document.querySelector('.stat-card.expense .stat-value')?.innerText || '₱0',
            balance: document.querySelector('.stat-card.balance .stat-value')?.innerText || '₱0',
            totalMembers: document.querySelector('.stat-card.members .stat-value')?.innerText || '0',
            choirMembers: document.querySelector('.stat-card.choir .stat-value')?.innerText || '0',
            choirGroup: document.querySelector('.group-badge')?.innerText || 'No schedule',
            choirMembersCount: document.querySelector('.schedule-detail:first-child')?.innerText?.replace(' members scheduled', '') || '0'
        };
    }

    function generateReport() {
        let sections = getSelectedSections();
        if (sections.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one section.',
                confirmButtonColor: '#10b981',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
            return;
        }

        Swal.fire({
            title: 'Generating Report...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); },
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        });

        setTimeout(() => {
            let data = getPageData();
            let logoUrl = getSystemLogo();
            let churchName = getChurchNameText();
            let transactions = [];
            let members = [];
            let birthdays = [];

            document.querySelectorAll('#transactionsTable tbody tr').forEach(row => {
                if (row.querySelector('td') && !row.innerText.includes('No transactions')) {
                    let cells = row.querySelectorAll('td');
                    transactions.push({
                        date: cells[0]?.innerText || '',
                        desc: cells[1]?.innerText || '',
                        category: cells[2]?.innerText || '',
                        type: cells[3]?.innerText || '',
                        amount: cells[4]?.innerText || ''
                    });
                }
            });

            document.querySelectorAll('#membersList .member-item').forEach(item => {
                let name = item.querySelector('.fw-semibold')?.innerText || '';
                let joined = item.querySelector('small')?.innerText || '';
                members.push({ name: name, joined: joined });
            });

            document.querySelectorAll('#birthdaysList .member-item').forEach(item => {
                let name = item.querySelector('.fw-semibold')?.innerText || '';
                let date = item.querySelector('small')?.innerText || '';
                birthdays.push({ name: name, date: date });
            });

            let html = `
                <div style="font-family: 'Segoe UI', Arial, sans-serif; padding: 20px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="${logoUrl}" style="max-width: 70px; max-height: 70px; object-fit: contain; margin-bottom: 10px; border-radius: 10px;" onerror="this.src='{{ asset("images/default-church-logo.png") }}'">
                        <h1 style="color: #10b981; margin: 10px 0 5px; font-size: 1.5rem;">${churchName}</h1>
                        <h2 style="font-size: 1rem; color: #666; margin: 0;">Comprehensive Church Report</h2>
                        <p style="color: #999; margin-top: 10px; font-size: 0.7rem;">Generated: ${new Date().toLocaleString()}</p>
                        <hr style="margin: 15px 0;">
                    </div>
            `;

            if (sections.includes('income')) html += `<div style="margin-bottom: 8px;"><strong>💰 Total Income:</strong> ${data.totalIncome}</div>`;
            if (sections.includes('expenses')) html += `<div style="margin-bottom: 8px;"><strong>💸 Total Expenses:</strong> ${data.totalExpense}</div>`;
            if (sections.includes('balance')) html += `<div style="margin-bottom: 8px;"><strong>⚖️ Net Balance:</strong> ${data.balance}</div>`;

            if (sections.includes('transactions') && transactions.length > 0) {
                html += `<h3 style="margin: 20px 0 10px; font-size: 1rem;">📋 Recent Transactions</h3>
                         <table style="width:100%; border-collapse: collapse; font-size: 0.7rem;">
                            <thead><tr style="background:#f5f5f5;"><th style="border:1px solid #ddd;padding:6px;">Date</th><th style="border:1px solid #ddd;padding:6px;">Description</th><th style="border:1px solid #ddd;padding:6px;">Category</th><th style="border:1px solid #ddd;padding:6px;">Type</th><th style="border:1px solid #ddd;padding:6px;">Amount</th></tr></thead>
                            <tbody>`;
                transactions.forEach(t => {
                    let badgeColor = t.type.includes('Income') ? '#10b981' : '#ef4444';
                    html += `<tr><td style="border:1px solid #ddd;padding:5px;">${t.date}</td>
                            <td style="border:1px solid #ddd;padding:5px;">${t.desc}</td>
                            <td style="border:1px solid #ddd;padding:5px;">${t.category}</td>
                            <td style="border:1px solid #ddd;padding:5px;"><span style="background:${badgeColor};color:white;padding:2px 8px;border-radius:10px;font-size:0.6rem;">${t.type}</span></td>
                            <td style="border:1px solid #ddd;padding:5px;">${t.amount}</td></tr>`;
                });
                html += `</tbody></table>`;
            }

            if (sections.includes('members') && members.length > 0) {
                html += `<h3 style="margin: 20px 0 10px; font-size: 1rem;">👥 Recent Members</h3>
                         <table style="width:100%; border-collapse: collapse; font-size: 0.7rem;">
                            <thead><tr style="background:#f5f5f5;"><th style="border:1px solid #ddd;padding:6px;">Name</th><th style="border:1px solid #ddd;padding:6px;">Joined</th></tr></thead>
                            <tbody>`;
                members.forEach(m => html += `<tr><td style="border:1px solid #ddd;padding:5px;">${m.name}</td><td style="border:1px solid #ddd;padding:5px;">${m.joined}</td></tr>`);
                html += `</tbody></table>`;
            }

            if (sections.includes('birthdays') && birthdays.length > 0) {
                html += `<h3 style="margin: 20px 0 10px; font-size: 1rem;">🎂 Upcoming Birthdays</h3>
                         <table style="width:100%; border-collapse: collapse; font-size: 0.7rem;">
                            <thead><tr style="background:#f5f5f5;"><th style="border:1px solid #ddd;padding:6px;">Name</th><th style="border:1px solid #ddd;padding:6px;">Birthday</th></tr></thead>
                            <tbody>`;
                birthdays.forEach(b => html += `<tr><td style="border:1px solid #ddd;padding:5px;">${b.name}</td><td style="border:1px solid #ddd;padding:5px;">${b.date}</td></tr>`);
                html += `</tbody></table>`;
            }

            if (sections.includes('choir')) {
                html += `<div style="margin-top: 20px;"><strong>🎵 Upcoming Choir Schedule:</strong> ${data.choirGroup} (${data.choirMembersCount} members)</div>`;
            }

            if (sections.includes('members')) {
                html += `<div style="margin-top: 10px;"><strong>👥 Total Members:</strong> ${data.totalMembers}</div>`;
                html += `<div><strong>🎵 Choir Members:</strong> ${data.choirMembers}</div>`;
            }

            html += `<div style="text-align: center; margin-top: 30px; padding-top: 10px; border-top: 1px solid #eee; font-size: 0.6rem; color: #999;">© ${churchName} • ${new Date().getFullYear()}</div></div>`;

            currentReportHTML = html;

            if (selectedFormat === 'pdf' || selectedFormat === 'print') {
                let printWindow = window.open('', '_blank');
                printWindow.document.write(`<html><head><title>${churchName} Report</title>
                    <style>
                        body{font-family:'Segoe UI',Arial;padding:20px;}
                        table{border-collapse:collapse;width:100%;}
                        th,td{border:1px solid #ddd;padding:6px;text-align:left;}
                        th{background:#f5f5f5;}
                        @media print{body{padding:0;}}
                    </style>
                </head><body>${html}</body></html>`);
                printWindow.document.close();
                printWindow.print();
                Swal.close();
                const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
                if (modal) modal.hide();
            } else {
                let plainText = html.replace(/<[^>]*>/g, '\n').replace(/&nbsp;/g, ' ').replace(/\n\s*\n/g, '\n\n');
                let blob = new Blob(["\uFEFF" + plainText], { type: "text/csv;charset=utf-8;" });
                let link = document.createElement("a");
                let url = URL.createObjectURL(blob);
                link.href = url;
                link.setAttribute("download", `church_report_${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.${selectedFormat === 'excel' ? 'xls' : 'csv'}`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
                Swal.close();
                const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
                if (modal) modal.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Exported!',
                    text: 'Report downloaded successfully.',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            }
        }, 500);
    }

    // Chart
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('financeChart');
        if (canvas) {
            const months = @json($months ?? []);
            const incomeData = @json($incomeData ?? []);
            const expenseData = @json($expenseData ?? []);
            if (months.length > 0) {
                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Income',
                                data: incomeData,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16,185,129,0.05)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3,
                                pointBackgroundColor: '#10b981'
                            },
                            {
                                label: 'Expenses',
                                data: expenseData,
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239,68,68,0.05)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3,
                                pointBackgroundColor: '#ef4444'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: { size: 10 },
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary').trim()
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `${ctx.dataset.label}: ₱${ctx.parsed.y.toLocaleString()}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: v => '₱' + v.toLocaleString(),
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--text-muted').trim()
                                },
                                grid: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--border-color').trim()
                                }
                            },
                            x: {
                                grid: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--border-color').trim()
                                },
                                ticks: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--text-muted').trim()
                                }
                            }
                        }
                    }
                });
            }
        }
    });
</script>
@endsection