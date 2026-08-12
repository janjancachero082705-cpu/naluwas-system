@extends('layouts.app')

@section('header')
    <span data-i18n="Dashboard">Dashboard</span>
@endsection

@section('content')
<style>
    /* Dashboard Styles - same as before */
    :root {
        --dash-primary: #4F46E5;
        --dash-success: #10B981;
        --dash-danger: #EF4444;
        --dash-warning: #F59E0B;
        --dash-purple: #8B5CF6;
        --shadow-glow: 0 8px 32px rgba(79, 70, 229, 0.3);
        --shadow-card: 0 1px 2px rgba(16,24,39,0.04), 0 1px 3px rgba(16,24,39,0.05);
        --shadow-card-hover: 0 16px 32px -12px rgba(16,24,39,0.14);
    }

    .dash-hero {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        border-radius: 20px;
        padding: 1.8rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-glow);
    }
    .dash-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: heroPulse 6s ease-in-out infinite;
    }
    @keyframes heroPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 1; }
    }
    .dash-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .dash-hero .hero-left { display: flex; flex-direction: column; gap: 0.25rem; }
    .dash-hero h1 { font-size: 1.6rem; font-weight: 800; color: white; margin: 0; font-family: 'Inter', sans-serif; }
    .dash-hero h1 i { margin-right: 12px; opacity: 0.8; }
    .dash-hero .hero-sub { color: rgba(255,255,255,0.8); font-size: 0.85rem; margin: 0; }
    .dash-hero .hero-stats {
        display: flex;
        gap: 2rem;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        padding: 0.6rem 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.15);
    }
    .dash-hero .hero-stat-item { text-align: center; }
    .dash-hero .hero-stat-item .num { font-size: 1.1rem; font-weight: 700; color: white; display: block; }
    .dash-hero .hero-stat-item .label { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.8px; color: rgba(255,255,255,0.6); }
    .btn-hero {
        padding: 0.5rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    .btn-hero-white { background: white; color: #4F46E5; }
    .btn-hero-white:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.2); color: #4F46E5; text-decoration: none; }

    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    .stat-card-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-card);
    }
    .stat-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
    }
    .stat-card-premium:hover { transform: translateY(-4px); box-shadow: var(--shadow-card-hover); border-color: transparent; }
    .stat-card-premium .stat-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem; }
    .stat-card-premium .stat-label { font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-muted); font-weight: 700; margin: 0; }
    .stat-card-premium .stat-icon-wrap { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: white; flex-shrink: 0; }
    .stat-card-premium .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--text-primary); font-family: 'Inter', sans-serif; letter-spacing: -0.5px; line-height: 1.2; }
    .stat-card-premium .stat-change { font-size: 0.65rem; color: var(--text-muted); display: inline-flex; align-items: center; gap: 4px; margin-top: 2px; padding: 2px 8px; border-radius: 20px; background: var(--bg-tertiary); }
    .stat-card-premium .stat-change.positive { color: #10B981; }
    .stat-card-premium .stat-change.negative { color: #EF4444; }
    .stat-card-premium.green::before { background: linear-gradient(135deg, #10B981, #34D399); }
    .stat-card-premium.blue::before { background: linear-gradient(135deg, #4F46E5, #7C3AED); }
    .stat-card-premium.purple::before { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    .stat-card-premium.orange::before { background: linear-gradient(135deg, #F59E0B, #FBBF24); }
    .stat-card-premium.green .stat-icon-wrap { background: linear-gradient(135deg, #10B981, #34D399); }
    .stat-card-premium.blue .stat-icon-wrap { background: linear-gradient(135deg, #4F46E5, #7C3AED); }
    .stat-card-premium.purple .stat-icon-wrap { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    .stat-card-premium.orange .stat-icon-wrap { background: linear-gradient(135deg, #F59E0B, #FBBF24); }

    .chart-modern-dash {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card);
    }
    .chart-modern-dash .chart-header-dash {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .chart-modern-dash .chart-header-dash h5 {
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    .chart-modern-dash .chart-header-dash h5 i { color: #4F46E5; margin-right: 8px; }
    .chart-modern-dash .chart-body-dash { height: 240px; position: relative; }

    .dash-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .card-modern-dash {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
    }
    .card-modern-dash:hover { box-shadow: var(--shadow-card-hover); }
    .card-modern-dash .card-header-dash {
        padding: 0.8rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .card-modern-dash .card-header-dash h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    .card-modern-dash .card-header-dash h6 i { margin-right: 8px; color: #4F46E5; }
    .card-modern-dash .card-body-dash { padding: 1.2rem 1.5rem; }

    .tx-item-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.7rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    .tx-item-modern:last-child { border-bottom: none; padding-bottom: 0; }
    .tx-item-modern:hover { padding-left: 4px; }
    .tx-icon-modern {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .tx-icon-modern.income { background: rgba(16, 185, 129, 0.12); color: #10B981; }
    .tx-icon-modern.expense { background: rgba(239, 68, 68, 0.12); color: #EF4444; }
    .tx-content-modern { flex: 1; min-width: 0; }
    .tx-content-modern .tx-name { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
    .tx-content-modern .tx-meta { font-size: 0.65rem; color: var(--text-muted); display: flex; align-items: center; gap: 8px; margin-top: 1px; }
    .tx-content-modern .tx-meta .tx-badge { font-size: 0.55rem; padding: 1px 8px; border-radius: 20px; font-weight: 600; }
    .tx-content-modern .tx-meta .tx-badge.income { background: rgba(16, 185, 129, 0.1); color: #10B981; }
    .tx-content-modern .tx-meta .tx-badge.expense { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
    .tx-amount-modern { font-size: 0.85rem; font-weight: 700; text-align: right; flex-shrink: 0; }
    .tx-amount-modern.positive { color: #10B981; }
    .tx-amount-modern.negative { color: #EF4444; }

    .bd-item-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    .bd-item-modern:last-child { border-bottom: none; padding-bottom: 0; }
    .bd-date-modern {
        min-width: 40px;
        text-align: center;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 4px 6px;
        flex-shrink: 0;
    }
    .bd-date-modern .day { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); line-height: 1; }
    .bd-date-modern .month { font-size: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); }
    .bd-info-modern { flex: 1; min-width: 0; }
    .bd-info-modern .name { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
    .bd-info-modern .meta { font-size: 0.65rem; color: var(--text-muted); }
    .bd-info-modern .meta .today-badge { font-size: 0.55rem; padding: 1px 8px; border-radius: 20px; background: rgba(245, 158, 11, 0.15); color: #F59E0B; font-weight: 600; }

    .choir-card-modern {
        background: var(--bg-tertiary);
        border-radius: 12px;
        padding: 1.2rem;
        border: 1px solid var(--border-color);
        text-align: center;
    }
    .choir-card-modern .choir-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, #8B5CF6, #A78BFA);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.8rem;
        color: white;
        font-size: 1.4rem;
        box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3);
    }
    .choir-card-modern .choir-group { font-size: 1rem; font-weight: 700; color: var(--text-primary); }
    .choir-card-modern .choir-meta { font-size: 0.7rem; color: var(--text-muted); margin-top: 4px; }
    .choir-card-modern .choir-chips { display: flex; flex-wrap: wrap; gap: 4px; justify-content: center; margin: 0.8rem 0; }
    .choir-card-modern .choir-chips .chip { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 20px; padding: 2px 10px; font-size: 0.65rem; color: var(--text-secondary); }
    .btn-choir {
        background: linear-gradient(135deg, #8B5CF6, #A78BFA);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
        width: 100%;
        justify-content: center;
    }
    .btn-choir:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3); color: white; text-decoration: none; }

    .coming-grid-modern {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;
        margin-top: 0.8rem;
        padding-top: 0.8rem;
        border-top: 1px solid var(--border-color);
    }
    .coming-item-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.6rem 0.4rem;
        text-align: center;
        transition: all 0.2s ease;
    }
    .coming-item-modern:hover { transform: translateY(-2px); box-shadow: var(--shadow-card); }
    .coming-item-modern .date { font-size: 0.55rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.3px; }
    .coming-item-modern .name { font-size: 0.7rem; font-weight: 700; color: #8B5CF6; margin-top: 2px; }
    .coming-item-modern .count { font-size: 0.55rem; color: var(--text-muted); }

    .empty-state-modern { text-align: center; padding: 1.5rem 0; color: var(--text-muted); }
    .empty-state-modern i { font-size: 2rem; display: block; margin-bottom: 0.5rem; opacity: 0.3; }
    .empty-state-modern p { font-size: 0.75rem; margin-bottom: 0.5rem; }
    .btn-ghost-sm { font-size: 0.65rem; padding: 4px 14px; border-radius: 8px; border: 1px solid var(--border-color); color: var(--text-muted); text-decoration: none; transition: all 0.15s; display: inline-block; }
    .btn-ghost-sm:hover { background: linear-gradient(135deg, #4F46E5, #7C3AED); border-color: #4F46E5; color: white; text-decoration: none; }

    .badge-modern { font-size: 0.6rem; font-weight: 600; padding: 0.2rem 0.8rem; border-radius: 20px; background: var(--bg-tertiary); color: var(--text-muted); border: 1px solid var(--border-color); }

    @media (max-width: 1200px) { .stats-grid-premium { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 992px) { .dash-grid-2 { grid-template-columns: 1fr; } .dash-hero .hero-content { flex-direction: column; text-align: center; } .dash-hero .hero-left { align-items: center; } .dash-hero .hero-stats { justify-content: center; width: 100%; } .dash-hero .hero-actions { width: 100%; justify-content: center; } }
    @media (max-width: 768px) { .dash-hero { padding: 1.2rem 1.5rem; } .dash-hero h1 { font-size: 1.2rem; } .dash-hero .hero-stats { gap: 1rem; padding: 0.5rem 1rem; } .dash-hero .hero-stat-item .num { font-size: 0.9rem; } .stats-grid-premium { grid-template-columns: 1fr 1fr; gap: 0.8rem; } .stat-card-premium { padding: 1rem; } .stat-card-premium .stat-value { font-size: 1.3rem; } .stat-card-premium .stat-icon-wrap { width: 36px; height: 36px; font-size: 0.9rem; } .coming-grid-modern { grid-template-columns: repeat(2, 1fr); } .card-modern-dash .card-body-dash { padding: 1rem; } .chart-modern-dash .chart-body-dash { height: 180px; } }
    @media (max-width: 480px) { .stats-grid-premium { grid-template-columns: 1fr; } }
</style>

<div class="container-fluid px-0">

    <!-- ===== HERO SECTION ===== -->
    <div class="dash-hero">
        <div class="hero-content">
            <div class="hero-left">
                <h1><i class="fas fa-church"></i> <span data-i18n="Dashboard">Dashboard</span></h1>
                <p class="hero-sub">
                    <i class="fas fa-circle" style="color: #34D399; font-size: 0.4rem; vertical-align: middle;"></i>
                    <span data-i18n="welcome_back">Welcome back! Here's your church overview</span>
                </p>
            </div>
            <div class="hero-stats">
                <div class="hero-stat-item">
                    <span class="num">{{ number_format($totalMembers ?? 0) }}</span>
                    <span class="label" data-i18n="members">Members</span>
                </div>
                <div class="hero-stat-item">
                    <span class="num">{{ number_format($choirMembers ?? 0) }}</span>
                    <span class="label" data-i18n="choir">Choir</span>
                </div>
                <div class="hero-stat-item">
                    <span class="num">{{ number_format($todayAttendance ?? 0) }}</span>
                    <span class="label" data-i18n="today">Today</span>
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('reports.analytics') }}" class="btn-hero btn-hero-white">
                    <i class="fas fa-chart-line"></i> <span data-i18n="analytics">Analytics</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== STAT CARDS ===== -->
    <div class="stats-grid-premium">
        <div class="stat-card-premium green">
            <div class="stat-top">
                <span class="stat-label" data-i18n="total_members">Total Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value" id="stat-total-members">{{ number_format($totalMembers ?? 0) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> <span data-i18n="active_members">Active members</span></div>
        </div>
        
        <div class="stat-card-premium purple">
            <div class="stat-top">
                <span class="stat-label" data-i18n="choir_members">Choir Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-music"></i></div>
            </div>
            <div class="stat-value" id="stat-choir-members">{{ number_format($choirMembers ?? 0) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> <span data-i18n="music_ministry">Music ministry</span></div>
        </div>
        
        <div class="stat-card-premium blue">
            <div class="stat-top">
                <span class="stat-label" data-i18n="today_attendance">Today's Attendance</span>
                <div class="stat-icon-wrap"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="stat-value" id="stat-today-attendance">{{ number_format($todayAttendance ?? 0) }}</div>
            @php
                $rate = ($totalMembers ?? 1) > 0 ? (($todayAttendance ?? 0) / ($totalMembers ?? 1)) * 100 : 0;
            @endphp
            <div class="stat-change {{ $rate >= 50 ? 'positive' : 'negative' }}" id="stat-attendance-rate">
                <i class="fas fa-{{ $rate >= 50 ? 'arrow-up' : 'arrow-down' }}"></i>
                {{ number_format($rate, 1) }}% <span data-i18n="present">present</span>
            </div>
        </div>
        
        <div class="stat-card-premium orange">
            <div class="stat-top">
                <span class="stat-label" data-i18n="monthly_balance">Monthly Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-wallet"></i></div>
            </div>
            <div class="stat-value" id="stat-monthly-balance" style="color: {{ ($monthlyBalance ?? 0) >= 0 ? '#10B981' : '#EF4444' }};">
                ₱{{ number_format(abs($monthlyBalance ?? 0), 2) }}
            </div>
            <div class="stat-change {{ ($monthlyBalance ?? 0) >= 0 ? 'positive' : 'negative' }}" id="stat-balance-trend">
                <i class="fas fa-{{ ($monthlyBalance ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                <span data-i18n="{{ ($monthlyBalance ?? 0) >= 0 ? 'surplus' : 'deficit' }}">
                    {{ ($monthlyBalance ?? 0) >= 0 ? 'Surplus' : 'Deficit' }}
                </span>
            </div>
        </div>
    </div>

    <!-- ===== CHART ===== -->
    <div class="chart-modern-dash">
        <div class="chart-header-dash">
            <h5><i class="fas fa-chart-line"></i> <span data-i18n="income_vs_expenses">Income vs Expenses</span></h5>
            <span class="badge-modern"><i class="fas fa-calendar-alt"></i> <span data-i18n="last_6_months">Last 6 Months</span></span>
        </div>
        <div class="chart-body-dash">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    <!-- ===== TWO COLUMN GRID ===== -->
    <div class="dash-grid-2">

        <!-- Transactions -->
        <div class="card-modern-dash">
            <div class="card-header-dash">
                <h6><i class="fas fa-arrows-alt-v"></i> <span data-i18n="recent_transactions">Recent Transactions</span></h6>
                <a href="{{ route('finance.index') }}" style="font-size: 0.65rem; color: var(--text-muted); text-decoration: none;">
                    <span data-i18n="view_all">View all</span> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body-dash" id="transactions-list">
                @forelse(($recentActivities ?? []) as $item)
                    @php $isIncome = ($item->type ?? 'expense') === 'income'; @endphp
                    <div class="tx-item-modern">
                        <div class="tx-icon-modern {{ $isIncome ? 'income' : 'expense' }}">
                            <i class="fas {{ $isIncome ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        </div>
                        <div class="tx-content-modern">
                            <div class="tx-name">{{ $item->description ?? $item->name ?? 'Transaction' }}</div>
                            <div class="tx-meta">
                                <span>{{ \Carbon\Carbon::parse($item->date ?? $item->created_at ?? now())->format('M d, Y') }}</span>
                                <span class="tx-badge {{ $isIncome ? 'income' : 'expense' }}">{{ ucfirst($item->type ?? 'expense') }}</span>
                            </div>
                        </div>
                        <div class="tx-amount-modern {{ $isIncome ? 'positive' : 'negative' }}">
                            {{ $isIncome ? '+' : '−' }}₱{{ number_format($item->amount ?? 0, 2) }}
                        </div>
                    </div>
                @empty
                    <div class="empty-state-modern">
                        <i class="fas fa-receipt"></i>
                        <p data-i18n="no_transactions">No transactions yet</p>
                        <a href="{{ route('finance.index') }}" class="btn-ghost-sm" data-i18n="add_transaction">Add transaction</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <!-- Birthdays -->
            <div class="card-modern-dash">
                <div class="card-header-dash">
                    <h6><i class="fas fa-birthday-cake" style="color: #F59E0B;"></i> <span data-i18n="upcoming_birthdays">Upcoming Birthdays</span></h6>
                    <span class="badge-modern" data-i18n="this_month">This month</span>
                </div>
                <div class="card-body-dash" id="birthdays-list">
                    @forelse(($upcomingBirthdays ?? []) as $birthday)
                        @php
                            $daysUntil = $birthday->days_until ?? null;
                            $isToday = $daysUntil === 0;
                            $isTomorrow = $daysUntil === 1;
                        @endphp
                        <div class="bd-item-modern">
                            <div class="bd-date-modern">
                                <div class="day">{{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('d') }}</div>
                                <div class="month">{{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('M') }}</div>
                            </div>
                            <div class="bd-info-modern">
                                <div class="name">{{ $birthday->first_name ?? '' }} {{ $birthday->last_name ?? '' }}</div>
                                <div class="meta">
                                    @if($isToday)
                                        <span class="today-badge">🎉 <span data-i18n="today_label">Today!</span></span>
                                    @elseif($isTomorrow)
                                        <span class="today-badge" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">🎂 <span data-i18n="tomorrow_label">Tomorrow!</span></span>
                                    @elseif($daysUntil !== null)
                                        <span data-i18n="turning_in_days">Turning</span> {{ $birthday->age ?? '?' }} <span data-i18n="in">in</span> {{ $daysUntil }} <span data-i18n="days">days</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('members.show', $birthday->id) }}" style="color: var(--text-muted); font-size: 0.8rem; text-decoration: none; padding: 4px 8px; border-radius: 6px; transition: all 0.2s;">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="empty-state-modern">
                            <i class="fas fa-birthday-cake"></i>
                            <p data-i18n="no_upcoming_birthdays">No upcoming birthdays</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Choir Schedule -->
            <div class="card-modern-dash" style="margin-bottom: 0;">
                <div class="card-header-dash">
                    <h6><i class="fas fa-music" style="color: #8B5CF6;"></i> <span data-i18n="choir_schedule">Choir Schedule</span></h6>
                    <span class="badge-modern" data-i18n="upcoming_label">Upcoming</span>
                </div>
                <div class="card-body-dash" id="choir-schedule-container">
                    @if(isset($upcomingSunday) && $upcomingSunday)
                        <div class="choir-card-modern">
                            <div class="choir-icon"><i class="fas fa-layer-group"></i></div>
                            <div class="choir-group" style="color: {{ $upcomingSunday['group_color'] ?? '#8B5CF6' }};">
                                {{ $upcomingSunday['group_name'] ?? 'Choir Group' }}
                            </div>
                            <div class="choir-meta">
                                <i class="fas fa-users"></i>
                                {{ $upcomingSunday['members_count'] ?? 0 }} <span data-i18n="members">members</span> ·
                                {{ \Carbon\Carbon::parse($upcomingSunday['date'] ?? now())->format('M d, Y') }}
                            </div>
                            <div class="choir-chips" id="choir-members-chips">
                                @forelse(($upcomingSunday['members'] ?? []) as $member)
                                    <span class="chip">
                                        {{ $member->first_name ?? '' }} {{ substr($member->last_name ?? '', 0, 1) }}.
                                    </span>
                                @empty
                                    <span class="chip" data-i18n="no_members_assigned">No members assigned</span>
                                @endforelse
                            </div>
                            <a href="{{ route('choir-schedules.index', ['date' => $upcomingSunday['date'] ?? '']) }}" class="btn-choir">
                                <i class="fas fa-calendar-alt"></i> <span data-i18n="view_full_schedule">View Full Schedule</span>
                            </a>

                            @if(isset($nextWeeks) && count($nextWeeks) > 0)
                                <div class="coming-grid-modern" id="coming-sundays-grid">
                                    @foreach($nextWeeks as $week)
                                        <div class="coming-item-modern">
                                            <div class="date">{{ \Carbon\Carbon::parse($week['date'])->format('M d') }}</div>
                                            <div class="name">{{ $week['group_name'] ?? 'Choir' }}</div>
                                            <div class="count"><i class="fas fa-users"></i> {{ $week['members_count'] ?? 0 }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-state-modern">
                            <i class="fas fa-music"></i>
                            <p data-i18n="no_upcoming_schedule">No upcoming schedule</p>
                            <a href="{{ route('choir-schedules.index') }}" class="btn-ghost-sm" data-i18n="create_schedule">Create schedule</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ============================================ -->
<!-- SCRIPTS -->
<!-- ============================================ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== FINANCE CHART =====
    const canvas = document.getElementById('financeChart');
    if (canvas) {
        const monthsData = @json($months ?? []);
        const incomeData = @json($incomeData ?? []);
        const expenseData = @json($expenseData ?? []);

        let months = Array.isArray(monthsData) && monthsData.length > 0 ? monthsData : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        let income = Array.isArray(incomeData) && incomeData.length > 0 ? incomeData : [0, 0, 0, 0, 0, 0];
        let expense = Array.isArray(expenseData) && expenseData.length > 0 ? expenseData : [0, 0, 0, 0, 0, 0];

        while (income.length < months.length) income.push(0);
        while (expense.length < months.length) expense.push(0);

        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
        const tickColor = isDark ? 'rgba(255,255,255,0.4)' : '#888';

        // Get translated labels
        const incomeLabel = window.t ? window.t('income') : 'Income';
        const expensesLabel = window.t ? window.t('expenses') : 'Expenses';

        const chart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: incomeLabel,
                        data: income,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.05)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: isDark ? '#1e1e1e' : '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
                    },
                    {
                        label: expensesLabel,
                        data: expense,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderWidth: 2,
                        borderDash: [5, 3],
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#EF4444',
                        pointBorderColor: isDark ? '#1e1e1e' : '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
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
                            font: { size: 11, weight: '600' },
                            color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary').trim(),
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: isDark ? '#2a2a2a' : '#fff',
                        titleColor: isDark ? '#e0e0e0' : '#1e293b',
                        bodyColor: isDark ? '#aaa' : '#475569',
                        borderColor: isDark ? 'rgba(255,255,255,0.1)' : '#e2e8f0',
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 10,
                        callbacks: {
                            label: function(ctx) {
                                return ctx.dataset.label + ': ₱' + ctx.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            },
                            font: { size: 11 },
                            color: tickColor
                        },
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11 },
                            color: tickColor
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        window.financeChart = chart;
    }

    // ===== TOAST FUNCTION =====
    function showDashboardToast(title, message, icon) {
        icon = icon || '📊';
        let toast = document.getElementById('dashboardToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'dashboardToast';
            toast.className = 'dashboard-toast-modern';
            toast.innerHTML = `
                <span class="toast-icon">📊</span>
                <div class="toast-content">
                    <div class="toast-title" id="toastTitle">Update received</div>
                    <div class="toast-message" id="toastMessage">Real-time data updated</div>
                </div>
                <button class="toast-close" onclick="this.closest('.dashboard-toast-modern').classList.remove('show')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            document.body.appendChild(toast);
        }
        
        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastMessage').textContent = message;
        toast.querySelector('.toast-icon').textContent = icon;
        
        toast.classList.add('show');
        clearTimeout(toast._hideTimeout);
        toast._hideTimeout = setTimeout(function() {
            toast.classList.remove('show');
        }, 4000);
    }

    window.showDashboardToast = showDashboardToast;

    // ===== REAL-TIME UPDATES =====
    if (window.Echo) {
        window.Echo.channel('attendance')
            .listen('attendance.updated', function(e) {
                const present = e.present || 0;
                const total = e.total || 0;
                
                const todayEl = document.getElementById('stat-today-attendance');
                if (todayEl) {
                    todayEl.textContent = present;
                    todayEl.classList.add('updated');
                    setTimeout(function() {
                        todayEl.classList.remove('updated');
                    }, 500);
                }
                
                const rateEl = document.getElementById('stat-attendance-rate');
                if (rateEl) {
                    const rate = total > 0 ? Math.round((present / total) * 100 * 10) / 10 : 0;
                    const presentText = window.t ? window.t('present') : 'present';
                    rateEl.innerHTML = rate + '% ' + presentText;
                }
                
                showDashboardToast('📊 Attendance', present + ' present today', '📊');
            });

        window.Echo.channel('finances')
            .listen('balance.updated', function(e) {
                const balance = e.balance || 0;
                const balanceEl = document.getElementById('stat-monthly-balance');
                const trendEl = document.getElementById('stat-balance-trend');
                
                if (balanceEl) {
                    balanceEl.textContent = '₱' + Math.abs(balance).toLocaleString();
                    balanceEl.style.color = balance >= 0 ? '#10B981' : '#EF4444';
                }
                
                if (trendEl) {
                    const surplusText = window.t ? window.t('surplus') : 'Surplus';
                    const deficitText = window.t ? window.t('deficit') : 'Deficit';
                    trendEl.innerHTML = `<i class="fas fa-${balance >= 0 ? 'arrow-up' : 'arrow-down'}"></i> ${balance >= 0 ? surplusText : deficitText}`;
                    trendEl.className = 'stat-change ' + (balance >= 0 ? 'positive' : 'negative');
                }
                
                showDashboardToast('💰 Balance', '₱' + Math.abs(balance).toLocaleString(), '💰');
            });

        window.Echo.channel('choir')
            .listen('schedule.updated', function(e) {
                const choirEl = document.getElementById('stat-choir-members');
                if (choirEl && e.members_count !== undefined) {
                    choirEl.textContent = e.members_count;
                }
                
                showDashboardToast('🎵 Choir', e.message || 'Schedule updated', '🎵');
            });
    }
});
</script>
@endsection