@extends('layouts.app')

@section('header', 'Reports & Analytics')

@php
use Carbon\Carbon;
@endphp

@section('content')
<style>
    /* ============================================
       MODERN ANALYTICS DESIGN - V2
    ============================================ */
    
    /* Import Google Fonts for better typography */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    
    :root {
        --analytics-primary: #4F46E5;
        --analytics-primary-light: #818CF8;
        --analytics-success: #10B981;
        --analytics-danger: #EF4444;
        --analytics-warning: #F59E0B;
        --analytics-info: #3B82F6;
        --analytics-purple: #8B5CF6;
        --analytics-pink: #EC4899;
        --analytics-orange: #F97316;
        --analytics-teal: #14B8A6;
        --gradient-blue: linear-gradient(135deg, #4F46E5, #7C3AED);
        --gradient-green: linear-gradient(135deg, #10B981, #34D399);
        --gradient-red: linear-gradient(135deg, #EF4444, #F87171);
        --gradient-purple: linear-gradient(135deg, #8B5CF6, #A78BFA);
        --gradient-orange: linear-gradient(135deg, #F59E0B, #FBBF24);
        --gradient-pink: linear-gradient(135deg, #EC4899, #F472B6);
        --shadow-card-lg: 0 20px 60px rgba(0,0,0,0.08);
        --shadow-card-hover: 0 24px 80px rgba(0,0,0,0.12);
        --glass-bg: rgba(255,255,255,0.7);
        --glass-border: rgba(255,255,255,0.2);
        --backdrop-blur: blur(20px);
    }
    
    [data-theme="dark"] {
        --glass-bg: rgba(22,32,50,0.7);
        --glass-border: rgba(255,255,255,0.05);
    }
    
    /* Hero Section - Modern Gradient */
    .analytics-hero {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(79, 70, 229, 0.3);
    }
    
    .analytics-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 80%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
        animation: pulseGlow 8s ease-in-out infinite;
    }
    
    .analytics-hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        pointer-events: none;
        animation: pulseGlow 10s ease-in-out infinite reverse;
    }
    
    @keyframes pulseGlow {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }
    
    .analytics-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .analytics-hero .hero-left {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    
    .analytics-hero h1 {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin: 0;
        letter-spacing: -0.5px;
        font-family: 'Inter', sans-serif;
    }
    
    .analytics-hero h1 i {
        margin-right: 12px;
        opacity: 0.8;
    }
    
    .analytics-hero p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 0.9rem;
        font-weight: 400;
    }
    
    .analytics-hero .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: var(--backdrop-blur);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .analytics-hero .hero-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    
    .btn-hero-primary {
        background: white;
        color: #4F46E5;
        border: none;
        padding: 0.6rem 1.8rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-hero-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        color: #4F46E5;
        text-decoration: none;
    }
    
    .btn-hero-secondary {
        background: rgba(255,255,255,0.15);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 0.6rem 1.8rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
        backdrop-filter: var(--backdrop-blur);
    }
    
    .btn-hero-secondary:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    /* Stats Grid - Modern Cards */
    .analytics-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    
    .stat-card-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-card);
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gradient-blue);
    }
    
    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .stat-card-modern .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    
    .stat-card-modern .stat-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        font-weight: 700;
        margin: 0;
    }
    
    .stat-card-modern .stat-icon-wrap {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-card-modern .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    
    .stat-card-modern .stat-change {
        font-size: 0.65rem;
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }
    
    .stat-card-modern .stat-change.positive { color: var(--analytics-success); }
    .stat-card-modern .stat-change.negative { color: var(--analytics-danger); }
    
    /* Gradient variants for stat cards */
    .stat-card-modern.green::before { background: var(--gradient-green); }
    .stat-card-modern.red::before { background: var(--gradient-red); }
    .stat-card-modern.blue::before { background: var(--gradient-blue); }
    .stat-card-modern.purple::before { background: var(--gradient-purple); }
    .stat-card-modern.orange::before { background: var(--gradient-orange); }
    
    .stat-card-modern.green .stat-icon-wrap { background: var(--gradient-green); }
    .stat-card-modern.red .stat-icon-wrap { background: var(--gradient-red); }
    .stat-card-modern.blue .stat-icon-wrap { background: var(--gradient-blue); }
    .stat-card-modern.purple .stat-icon-wrap { background: var(--gradient-purple); }
    .stat-card-modern.orange .stat-icon-wrap { background: var(--gradient-orange); }
    
    /* Section Headers */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.2rem;
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    
    .section-header h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Inter', sans-serif;
    }
    
    .section-header h3 i {
        color: var(--analytics-primary);
        font-size: 1rem;
    }
    
    .section-header .section-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    /* Card Containers */
    .card-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
    }
    
    .card-modern:hover {
        box-shadow: var(--shadow-card-hover);
    }
    
    .card-modern .card-header-custom {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-modern .card-header-custom h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .card-modern .card-header-custom h6 i {
        margin-right: 8px;
        color: var(--analytics-primary);
    }
    
    .card-modern .card-body {
        padding: 1.5rem;
    }
    
    /* Table - Modern Style */
    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        padding: 0.75rem 1rem;
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: var(--text-muted);
        border-bottom: 2px solid var(--border-color);
        text-align: left;
    }
    
    .table-modern tbody td {
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }
    
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-modern tbody tr:hover {
        background: var(--bg-tertiary);
    }
    
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Badges */
    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.25rem 0.8rem;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 700;
    }
    
    .badge-modern.income {
        background: rgba(16, 185, 129, 0.12);
        color: #10B981;
    }
    
    .badge-modern.expense {
        background: rgba(239, 68, 68, 0.12);
        color: #EF4444;
    }
    
    .badge-modern.choir {
        background: rgba(245, 158, 11, 0.12);
        color: #F59E0B;
    }
    
    .badge-modern.member {
        background: rgba(79, 70, 229, 0.12);
        color: #4F46E5;
    }
    
    /* Member List Items */
    .member-item-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.7rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .member-item-modern:last-child {
        border-bottom: none;
    }
    
    .member-item-modern .member-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--gradient-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.7rem;
        flex-shrink: 0;
        font-weight: 700;
    }
    
    .member-item-modern .member-info {
        flex: 1;
    }
    
    .member-item-modern .member-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-primary);
    }
    
    .member-item-modern .member-meta {
        font-size: 0.65rem;
        color: var(--text-muted);
    }
    
    /* Schedule Card */
    .schedule-card-modern {
        background: var(--bg-tertiary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .schedule-card-modern .schedule-info {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .schedule-card-modern .schedule-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.5rem 1.2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
        background: var(--gradient-purple);
    }
    
    .schedule-card-modern .schedule-detail {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .schedule-card-modern .schedule-detail i {
        color: var(--analytics-primary);
        width: 16px;
    }
    
    /* Chart Container */
    .chart-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card);
    }
    
    .chart-modern .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.2rem;
    }
    
    .chart-modern .chart-header h5 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .chart-modern .chart-header h5 i {
        color: var(--analytics-primary);
        margin-right: 8px;
    }
    
    .chart-modern .chart-body {
        height: 280px;
        position: relative;
    }
    
    /* Two Column Grid */
    .analytics-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .analytics-stats {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .analytics-grid-2 {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .analytics-hero {
            padding: 1.5rem;
            border-radius: 16px;
        }
        
        .analytics-hero h1 {
            font-size: 1.4rem;
        }
        
        .analytics-hero .hero-content {
            flex-direction: column;
            text-align: center;
        }
        
        .analytics-hero .hero-left {
            align-items: center;
        }
        
        .analytics-hero .hero-actions {
            width: 100%;
            justify-content: center;
        }
        
        .analytics-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }
        
        .stat-card-modern {
            padding: 1rem;
        }
        
        .stat-card-modern .stat-value {
            font-size: 1.3rem;
        }
        
        .schedule-card-modern {
            flex-direction: column;
            text-align: center;
        }
        
        .schedule-card-modern .schedule-info {
            flex-direction: column;
            align-items: center;
        }
        
        .btn-hero-primary,
        .btn-hero-secondary {
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 480px) {
        .analytics-stats {
            grid-template-columns: 1fr 1fr;
            gap: 0.6rem;
        }
        
        .stat-card-modern .stat-value {
            font-size: 1.1rem;
        }
        
        .stat-card-modern .stat-icon-wrap {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
    }
    
    /* Print Styles */
    @media print {
        .no-print { display: none !important; }
        .analytics-hero { background: #4F46E5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .stat-card-modern { border: 1px solid #ddd !important; }
        .stat-card-modern .stat-icon-wrap { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .badge-modern { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .schedule-badge { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="analytics-hero no-print">
        <div class="hero-content">
            <div class="hero-left">
                <h1><i class="fas fa-chart-line"></i> Reports & Analytics</h1>
                <p>Complete church financial and ministry analytics dashboard</p>
                <div class="hero-badge">
                    <i class="fas fa-circle" style="color: #34D399; font-size: 0.5rem;"></i>
                    Live Data • Updated in Real-Time
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('dashboard') }}" class="btn-hero-secondary">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <button class="btn-hero-primary" onclick="openExportModal()">
                    <i class="fas fa-download"></i> Export Report
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="analytics-stats">
        <div class="stat-card-modern green">
            <div class="stat-top">
                <span class="stat-label">Total Income</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-down"></i></div>
            </div>
            <div class="stat-value">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Money received
            </div>
        </div>
        
        <div class="stat-card-modern red">
            <div class="stat-top">
                <span class="stat-label">Total Expenses</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-up"></i></div>
            </div>
            <div class="stat-value">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            <div class="stat-change negative">
                <i class="fas fa-arrow-down"></i> Money spent
            </div>
        </div>
        
        <div class="stat-card-modern blue">
            <div class="stat-top">
                <span class="stat-label">Net Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-scale-balanced"></i></div>
            </div>
            <div class="stat-value {{ ($balance ?? 0) >= 0 ? '' : 'text-danger' }}">
                {{ ($balance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($balance ?? 0), 2) }}
            </div>
            <div class="stat-change {{ ($balance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-{{ ($balance ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                {{ ($balance ?? 0) >= 0 ? 'Surplus' : 'Deficit' }}
            </div>
        </div>
        
        <div class="stat-card-modern purple">
            <div class="stat-top">
                <span class="stat-label">Total Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value">{{ number_format($totalMembers ?? 0) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-users"></i> Church family
            </div>
        </div>
        
        <div class="stat-card-modern orange">
            <div class="stat-top">
                <span class="stat-label">Choir Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-music"></i></div>
            </div>
            <div class="stat-value">{{ number_format($choirMembers ?? 0) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-microphone"></i> Voices of praise
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-modern">
        <div class="chart-header">
            <h5><i class="fas fa-chart-line"></i> Income vs Expenses (Last 6 Months)</h5>
            <span class="badge-modern member"><i class="fas fa-calendar"></i> 6 Months</span>
        </div>
        <div class="chart-body">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    <!-- Two Column Grid -->
    <div class="analytics-grid-2">
        <!-- Recent Transactions -->
        <div class="card-modern">
            <div class="card-header-custom">
                <h6><i class="fas fa-history"></i> Recent Transactions</h6>
                <span class="badge-modern member">{{ count($recentTransactions ?? []) }} entries</span>
            </div>
            <div class="card-body" style="padding: 0;">
                <div style="max-height: 350px; overflow-y: auto;">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($recentTransactions ?? []) as $transaction)
                            <tr>
                                <td>{{ Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d') }}</td>
                                <td>{{ $transaction->description ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge-modern {{ $transaction->type == 'income' ? 'income' : 'expense' }}">
                                        {{ ucfirst($transaction->type ?? 'expense') }}
                                    </span>
                                </td>
                                <td style="text-align: right; font-weight: 700; color: {{ $transaction->type == 'income' ? '#10B981' : '#EF4444' }};">
                                    {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount ?? 0, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                    <i class="fas fa-receipt" style="font-size: 1.5rem; display: block; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                                    No transactions found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Members & Birthdays -->
        <div>
            <div class="card-modern">
                <div class="card-header-custom">
                    <h6><i class="fas fa-users"></i> Recent Members</h6>
                    <span class="badge-modern member">{{ count($recentMembers ?? []) }} new</span>
                </div>
                <div class="card-body">
                    @forelse(($recentMembers ?? []) as $member)
                    <div class="member-item-modern">
                        <div class="member-avatar">
                            {{ strtoupper(substr($member->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="member-info">
                            <div class="member-name">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                            <div class="member-meta">Joined {{ Carbon::parse($member->created_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 1.5rem; color: var(--text-muted);">
                        <i class="fas fa-users" style="font-size: 1.5rem; display: block; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                        No members found
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="card-modern" style="margin-bottom: 0;">
                <div class="card-header-custom">
                    <h6><i class="fas fa-birthday-cake"></i> Upcoming Birthdays</h6>
                    <span class="badge-modern choir">{{ count($upcomingBirthdays ?? []) }} celebrating</span>
                </div>
                <div class="card-body">
                    @forelse(($upcomingBirthdays ?? []) as $birthday)
                    <div class="member-item-modern">
                        <div class="member-avatar" style="background: var(--gradient-orange);">
                            <i class="fas fa-cake-candles"></i>
                        </div>
                        <div class="member-info">
                            <div class="member-name">{{ $birthday->first_name ?? '' }} {{ $birthday->last_name ?? '' }}</div>
                            <div class="member-meta">{{ Carbon::parse($birthday->birthday)->format('F d') }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 1.5rem; color: var(--text-muted);">
                        <i class="fas fa-birthday-cake" style="font-size: 1.5rem; display: block; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                        No upcoming birthdays
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Choir Schedule -->
    <div class="card-modern">
        <div class="card-header-custom">
            <h6><i class="fas fa-music"></i> Upcoming Choir Schedule</h6>
            <span class="badge-modern choir"><i class="fas fa-clock"></i> This Week</span>
        </div>
        <div class="card-body">
            <div class="schedule-card-modern">
                <div class="schedule-info">
                    <div class="schedule-badge" style="background: var(--gradient-purple);">
                        <i class="fas fa-layer-group"></i> {{ $choirGroupName ?? 'Worship Team' }}
                    </div>
                    <div class="schedule-detail">
                        <i class="fas fa-users"></i> {{ $choirMembersCount ?? 0 }} members
                    </div>
                    <div class="schedule-detail">
                        <i class="fas fa-calendar-alt"></i> 
                        @php 
                            $nextSun = Carbon::now(); 
                            if ($nextSun->dayOfWeek != Carbon::SUNDAY) $nextSun = $nextSun->next(Carbon::SUNDAY); 
                        @endphp
                        {{ $nextSun->format('F d, Y') }}
                    </div>
                </div>
                <a href="{{ route('choir-schedules.index') }}" class="btn-hero-primary" style="background: var(--gradient-purple); color: white; padding: 0.5rem 1.5rem;">
                    <i class="fas fa-arrow-right"></i> View Schedule
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div id="exportModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header" style="background: var(--gradient-blue); border: none; padding: 1.5rem;">
                <h5 class="modal-title" style="color: white; font-weight: 700;">
                    <i class="fas fa-magic" style="margin-right: 8px;"></i> Customize Your Report
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" style="color: white; opacity: 0.8; background: none; border: none; font-size: 1.5rem;">&times;</button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">
                    Select the sections you want to include in your report.
                </p>
                
                <!-- Format Selection -->
                <label style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem; display: block;">
                    <i class="fas fa-file"></i> Choose Format
                </label>
                <div class="format-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.5rem; margin-bottom: 1.5rem;">
                    <div class="format-card selected" data-format="pdf" onclick="selectFormat(this)" style="background: var(--bg-tertiary); border: 2px solid var(--border-color); border-radius: 12px; padding: 0.8rem; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                        <i class="fas fa-file-pdf" style="color: #EF4444; font-size: 1.3rem; display: block; margin-bottom: 4px;"></i>
                        <span style="font-size: 0.6rem; font-weight: 600;">PDF</span>
                    </div>
                    <div class="format-card" data-format="excel" onclick="selectFormat(this)" style="background: var(--bg-tertiary); border: 2px solid var(--border-color); border-radius: 12px; padding: 0.8rem; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                        <i class="fas fa-file-excel" style="color: #10B981; font-size: 1.3rem; display: block; margin-bottom: 4px;"></i>
                        <span style="font-size: 0.6rem; font-weight: 600;">Excel</span>
                    </div>
                    <div class="format-card" data-format="csv" onclick="selectFormat(this)" style="background: var(--bg-tertiary); border: 2px solid var(--border-color); border-radius: 12px; padding: 0.8rem; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                        <i class="fas fa-file-csv" style="color: #3B82F6; font-size: 1.3rem; display: block; margin-bottom: 4px;"></i>
                        <span style="font-size: 0.6rem; font-weight: 600;">CSV</span>
                    </div>
                    <div class="format-card" data-format="print" onclick="selectFormat(this)" style="background: var(--bg-tertiary); border: 2px solid var(--border-color); border-radius: 12px; padding: 0.8rem; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                        <i class="fas fa-print" style="color: #8B5CF6; font-size: 1.3rem; display: block; margin-bottom: 4px;"></i>
                        <span style="font-size: 0.6rem; font-weight: 600;">Print</span>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="selectAllCheckbox" checked onchange="toggleSelectAll()" style="width: 18px; height: 18px; cursor: pointer;">
                        <label class="form-check-label" for="selectAllCheckbox" style="font-size: 0.85rem; font-weight: 700; color: var(--text-primary); cursor: pointer;">
                            ✓ Select All Sections
                        </label>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.5rem;">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="income" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">💰 Income</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="expenses" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">💸 Expenses</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="balance" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">⚖️ Balance</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="transactions" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">📋 Transactions</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="members" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">👥 Members</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="birthdays" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">🎂 Birthdays</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="choir" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">🎵 Choir</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input section-cb" value="chart" checked style="width: 16px; height: 16px; cursor: pointer;">
                        <label class="form-check-label" style="font-size: 0.8rem; color: var(--text-secondary); cursor: pointer;">📈 Chart</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-color); padding: 1rem 1.5rem; background: var(--bg-tertiary);">
                <button type="button" class="btn-secondary" data-bs-dismiss="modal" style="padding: 0.5rem 1.5rem; border-radius: 12px; font-weight: 600;">Cancel</button>
                <button type="button" class="btn-primary-modal" onclick="generateReport()" style="background: var(--gradient-blue); border: none; padding: 0.5rem 2rem; border-radius: 12px; color: white; font-weight: 700; transition: all 0.3s ease; cursor: pointer;">
                    <i class="fas fa-file-export me-2"></i> Generate Report
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Format card selection
    function selectFormat(element) {
        document.querySelectorAll('.format-card').forEach(c => c.classList.remove('selected'));
        element.classList.add('selected');
        selectedFormat = element.dataset.format;
    }

    function toggleSelectAll() {
        let isChecked = document.getElementById('selectAllCheckbox').checked;
        document.querySelectorAll('.section-cb').forEach(cb => cb.checked = isChecked);
    }

    function openExportModal() {
        const modal = new bootstrap.Modal(document.getElementById('exportModal'));
        modal.show();
    }

    function getSelectedSections() {
        let selected = [];
        document.querySelectorAll('.section-cb:checked').forEach(cb => selected.push(cb.value));
        return selected;
    }

    function generateReport() {
        let sections = getSelectedSections();
        if (sections.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one section.',
                confirmButtonColor: '#4F46E5',
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
            // Get data
            let data = {
                totalIncome: document.querySelector('.stat-card-modern.green .stat-value')?.innerText || '₱0',
                totalExpense: document.querySelector('.stat-card-modern.red .stat-value')?.innerText || '₱0',
                balance: document.querySelector('.stat-card-modern.blue .stat-value')?.innerText || '₱0',
                totalMembers: document.querySelector('.stat-card-modern.purple .stat-value')?.innerText || '0',
                choirMembers: document.querySelector('.stat-card-modern.orange .stat-value')?.innerText || '0'
            };

            let churchName = document.querySelector('.logo-text h2')?.innerText || 'TINC Church';
            let html = generateReportHTML(data, sections, churchName);

            if (selectedFormat === 'pdf' || selectedFormat === 'print') {
                let printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>${churchName} - Report</title>
                            <style>
                                body { font-family: 'Inter', 'Segoe UI', Arial, sans-serif; padding: 30px; max-width: 1200px; margin: 0 auto; }
                                .report-header { text-align: center; margin-bottom: 30px; }
                                .report-header h1 { color: #4F46E5; font-size: 24px; }
                                .report-header p { color: #666; }
                                .report-section { margin-bottom: 25px; }
                                .report-section h3 { color: #4F46E5; font-size: 16px; margin-bottom: 10px; }
                                table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
                                th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; font-size: 13px; }
                                th { background: #f5f5f5; font-weight: 600; }
                                .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
                                .badge.income { background: #d1fae5; color: #065f46; }
                                .badge.expense { background: #fee2e2; color: #991b1b; }
                                .text-right { text-align: right; }
                                .amount-positive { color: #10b981; }
                                .amount-negative { color: #ef4444; }
                                .report-footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #999; }
                                @media print { body { padding: 0; } }
                            </style>
                        </head>
                        <body>${html}</body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.print();
                Swal.close();
                const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
                if (modal) modal.hide();
            } else {
                // CSV/Excel download
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

    function generateReportHTML(data, sections, churchName) {
        let html = `
            <div class="report-header">
                <h1>${churchName}</h1>
                <h2 style="font-size: 18px; color: #666; margin: 5px 0;">Comprehensive Church Report</h2>
                <p>Generated: ${new Date().toLocaleString()}</p>
                <hr>
            </div>
        `;

        if (sections.includes('income')) {
            html += `<div class="report-section">
                <h3>💰 Total Income</h3>
                <p style="font-size: 20px; font-weight: 700; color: #10b981;">${data.totalIncome}</p>
            </div>`;
        }

        if (sections.includes('expenses')) {
            html += `<div class="report-section">
                <h3>💸 Total Expenses</h3>
                <p style="font-size: 20px; font-weight: 700; color: #ef4444;">${data.totalExpense}</p>
            </div>`;
        }

        if (sections.includes('balance')) {
            html += `<div class="report-section">
                <h3>⚖️ Net Balance</h3>
                <p style="font-size: 20px; font-weight: 700; color: #4F46E5;">${data.balance}</p>
            </div>`;
        }

        // Get transactions
        if (sections.includes('transactions')) {
            let transactions = [];
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

            if (transactions.length > 0) {
                html += `<div class="report-section">
                    <h3>📋 Recent Transactions</h3>
                    <table>
                        <thead><tr><th>Date</th><th>Description</th><th>Category</th><th>Type</th><th class="text-right">Amount</th></tr></thead>
                        <tbody>`;
                transactions.forEach(t => {
                    let badgeClass = t.type.includes('Income') ? 'income' : 'expense';
                    html += `<tr>
                        <td>${t.date}</td>
                        <td>${t.desc}</td>
                        <td>${t.category}</td>
                        <td><span class="badge ${badgeClass}">${t.type}</span></td>
                        <td class="text-right ${t.type.includes('Income') ? 'amount-positive' : 'amount-negative'}">${t.amount}</td>
                    </tr>`;
                });
                html += `</tbody></table></div>`;
            }
        }

        // Get members
        if (sections.includes('members')) {
            let members = [];
            document.querySelectorAll('#membersList .member-item-modern').forEach(item => {
                let name = item.querySelector('.member-name')?.innerText || '';
                let joined = item.querySelector('.member-meta')?.innerText || '';
                members.push({ name: name, joined: joined });
            });

            if (members.length > 0) {
                html += `<div class="report-section">
                    <h3>👥 Recent Members</h3>
                    <table>
                        <thead><tr><th>Name</th><th>Joined</th></tr></thead>
                        <tbody>`;
                members.forEach(m => html += `<tr><td>${m.name}</td><td>${m.joined}</td></tr>`);
                html += `</tbody></table></div>`;
            }
            html += `<div class="report-section"><p><strong>Total Members:</strong> ${data.totalMembers}</p></div>`;
        }

        // Get birthdays
        if (sections.includes('birthdays')) {
            let birthdays = [];
            document.querySelectorAll('#birthdaysList .member-item-modern').forEach(item => {
                let name = item.querySelector('.member-name')?.innerText || '';
                let date = item.querySelector('.member-meta')?.innerText || '';
                birthdays.push({ name: name, date: date });
            });

            if (birthdays.length > 0) {
                html += `<div class="report-section">
                    <h3>🎂 Upcoming Birthdays</h3>
                    <table>
                        <thead><tr><th>Name</th><th>Birthday</th></tr></thead>
                        <tbody>`;
                birthdays.forEach(b => html += `<tr><td>${b.name}</td><td>${b.date}</td></tr>`);
                html += `</tbody></table></div>`;
            }
        }

        // Choir
        if (sections.includes('choir')) {
            html += `<div class="report-section">
                <h3>🎵 Choir Members</h3>
                <p><strong>Total Choir Members:</strong> ${data.choirMembers}</p>
                <p><strong>Upcoming Schedule:</strong> ${document.querySelector('.schedule-badge')?.innerText?.trim() || 'Worship Team'}</p>
            </div>`;
        }

        html += `<div class="report-footer">© ${churchName} • ${new Date().getFullYear()}</div>`;
        return html;
    }

    let selectedFormat = 'pdf';

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
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#10B981',
                                pointBorderColor: 'white',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Expenses',
                                data: expenseData,
                                borderColor: '#EF4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#EF4444',
                                pointBorderColor: 'white',
                                pointBorderWidth: 2
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
                                    font: { 
                                        size: 11,
                                        weight: '600'
                                    },
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary').trim(),
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                padding: 12,
                                cornerRadius: 8,
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
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }
        }
    });
</script>
@endsection