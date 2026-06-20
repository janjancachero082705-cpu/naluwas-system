@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<style>
    /* ============================================
       ENHANCED DASHBOARD UI - CLEAN & MODERN
    ============================================ */
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 1.2rem 1.2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
    }
    
    .stat-card:nth-child(1)::after { background: linear-gradient(90deg, #4F46E5, #818CF8); }
    .stat-card:nth-child(2)::after { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
    .stat-card:nth-child(3)::after { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card:nth-child(4)::after { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    }
    
    .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-muted);
        font-weight: 600;
    }
    
    .stat-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-card:nth-child(1) .stat-icon-wrap { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .stat-card:nth-child(2) .stat-icon-wrap { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .stat-card:nth-child(3) .stat-icon-wrap { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-card:nth-child(4) .stat-icon-wrap { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    
    .stat-number {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .stat-trend {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .stat-trend .up { color: #10b981; }
    .stat-trend .down { color: #ef4444; }
    
    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
    }
    
    .dashboard-grid.three {
        grid-template-columns: 1fr 1fr 1fr;
    }
    
    /* Cards */
    .card-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .card-modern:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
    
    .card-modern-header {
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--bg-tertiary);
    }
    
    .card-modern-header h6 {
        font-size: 0.7rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .card-modern-header h6 i {
        font-size: 0.8rem;
    }
    
    .card-modern-header .action-link {
        font-size: 0.55rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s;
        font-weight: 500;
    }
    
    .card-modern-header .action-link:hover {
        color: #10b981;
    }
    
    .card-modern-body {
        padding: 0.9rem 1.2rem;
        flex: 1;
        max-height: 340px;
        overflow-y: auto;
    }
    
    .card-modern-body::-webkit-scrollbar {
        width: 3px;
    }
    
    .card-modern-body::-webkit-scrollbar-track {
        background: var(--bg-tertiary);
        border-radius: 10px;
    }
    
    .card-modern-body::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }
    
    /* Chart */
    .chart-wrap {
        height: 240px;
        position: relative;
        padding: 0.5rem 0;
    }
    
    .chart-wrap canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* List Items */
    .list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .list-item:last-child {
        border-bottom: none;
    }
    
    .list-item:hover {
        padding-left: 4px;
    }
    
    .list-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
    
    .list-icon.income { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .list-icon.expense { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .list-icon.birthday { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .list-icon.music { background: rgba(79, 70, 229, 0.1); color: #4F46E5; }
    .list-icon.user { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
    
    .list-content {
        flex: 1;
        min-width: 0;
    }
    
    .list-title {
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .list-sub {
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .list-right {
        text-align: right;
        flex-shrink: 0;
    }
    
    .list-amount {
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .list-amount.positive { color: #10b981; }
    .list-amount.negative { color: #ef4444; }
    
    .list-badge {
        font-size: 0.45rem;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        padding: 1px 8px;
        border-radius: 10px;
        font-weight: 600;
        border: 1px solid var(--border-color);
    }
    
    /* Birthday Items */
    .bd-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.4rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .bd-item:last-child {
        border-bottom: none;
    }
    
    .bd-item:hover {
        padding-left: 4px;
    }
    
    .bd-date {
        min-width: 40px;
        text-align: center;
        background: var(--bg-tertiary);
        border-radius: 8px;
        padding: 3px 6px;
        border: 1px solid var(--border-color);
    }
    
    .bd-day {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }
    
    .bd-month {
        font-size: 0.35rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
    }
    
    .bd-info {
        flex: 1;
    }
    
    .bd-name {
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .bd-name i {
        color: #f59e0b;
        margin-right: 4px;
    }
    
    .bd-text {
        font-size: 0.55rem;
        color: var(--text-muted);
    }
    
    .bd-tag {
        font-size: 0.5rem;
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
        padding: 1px 8px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-block;
    }
    
    .bd-action {
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: var(--bg-tertiary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        transition: all 0.2s;
        text-decoration: none;
        border: 1px solid var(--border-color);
    }
    
    .bd-action:hover {
        background: #4F46E5;
        color: white;
        border-color: #4F46E5;
        transform: scale(1.05);
    }
    
    /* Choir Schedule */
    .choir-center {
        text-align: center;
        padding: 0.3rem 0;
    }
    
    .choir-icon-wrap {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        background: rgba(79, 70, 229, 0.1);
        color: #4F46E5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin: 0 auto 0.5rem;
        border: 1px solid rgba(79, 70, 229, 0.1);
    }
    
    .choir-group-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .choir-meta {
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .choir-members-chip {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        justify-content: center;
        margin: 0.5rem 0;
    }
    
    .chip {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.55rem;
        color: var(--text-muted);
        transition: all 0.2s ease;
    }
    
    .chip:hover {
        background: var(--hover-bg);
        border-color: #4F46E5;
    }
    
    .btn-primary-sm {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        width: 100%;
        justify-content: center;
    }
    
    .btn-primary-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-primary-sm i {
        font-size: 0.6rem;
    }
    
    /* Coming Sundays */
    .coming-wrap {
        margin-top: 0.8rem;
        padding-top: 0.8rem;
        border-top: 1px solid var(--border-color);
    }
    
    .coming-label {
        font-size: 0.55rem;
        font-weight: 600;
        color: var(--text-muted);
        text-align: left;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .coming-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }
    
    .coming-item {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.3rem;
        text-align: center;
        transition: all 0.2s ease;
    }
    
    .coming-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #4F46E5;
    }
    
    .coming-date {
        font-size: 0.5rem;
        color: var(--text-muted);
    }
    
    .coming-name {
        font-size: 0.6rem;
        font-weight: 600;
        color: #4F46E5;
    }
    
    .coming-count {
        font-size: 0.45rem;
        color: var(--text-muted);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 1.5rem 0.5rem;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
        opacity: 0.3;
        display: block;
    }
    
    .empty-state p {
        font-size: 0.7rem;
        margin-bottom: 0.5rem;
    }
    
    .btn-outline-sm {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 3px 14px;
        border-radius: 6px;
        font-size: 0.6rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
    }
    
    .btn-outline-sm:hover {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    
    /* Alerts */
    .alert-minimal {
        padding: 0.7rem 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.78rem;
        border-left: 3px solid transparent;
        animation: slideDown 0.3s ease;
    }
    
    .alert-minimal.success {
        background: rgba(16, 185, 129, 0.06);
        border-left-color: #10b981;
        color: #10b981;
    }
    
    .alert-minimal.error {
        background: rgba(239, 68, 68, 0.06);
        border-left-color: #ef4444;
        color: #ef4444;
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        border-radius: 14px;
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
    
    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .welcome-section h2 {
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        margin: 0;
        position: relative;
        z-index: 1;
    }
    
    .welcome-section p {
        color: rgba(255,255,255,0.8);
        margin: 0;
        font-size: 0.8rem;
        position: relative;
        z-index: 1;
    }
    
    .welcome-date {
        color: rgba(255,255,255,0.9);
        font-size: 0.8rem;
        font-weight: 500;
        position: relative;
        z-index: 1;
        background: rgba(255,255,255,0.15);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.8rem; }
        .dashboard-grid { grid-template-columns: 1fr; }
        .dashboard-grid.three { grid-template-columns: 1fr 1fr; }
        .coming-grid { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .dashboard-grid.three { grid-template-columns: 1fr; }
        .stat-number { font-size: 1.3rem; }
        .coming-grid { grid-template-columns: 1fr; }
        .chart-wrap { height: 180px; }
        .welcome-section {
            flex-direction: column;
            text-align: center;
            padding: 1rem;
        }
        .welcome-date {
            font-size: 0.7rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div>
            <h2><i class="fas fa-church me-2"></i>Welcome back, {{ Auth::user()->name ?? 'Administrator' }}!</h2>
            <p>Here's what's happening in your church today</p>
        </div>
        <div class="welcome-date">
            <i class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::now()->format('l, F d, Y') }}
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert-minimal success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-minimal error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Total Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-number">{{ number_format($totalMembers ?? 0) }}</div>
            <div class="stat-trend"><span class="up">↑</span> Active members</div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Choir Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-music"></i></div>
            </div>
            <div class="stat-number">{{ number_format($choirMembers ?? 0) }}</div>
            <div class="stat-trend"><span class="up">↑</span> Music ministry</div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Today's Attendance</span>
                <div class="stat-icon-wrap"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="stat-number">{{ number_format($todayAttendance ?? 0) }}</div>
            <div class="stat-trend">
                @php $rate = ($totalMembers ?? 1) > 0 ? (($todayAttendance ?? 0) / ($totalMembers ?? 1)) * 100 : 0; @endphp
                <span>{{ number_format($rate, 1) }}% present</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <span class="stat-label">Monthly Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-wallet"></i></div>
            </div>
            <div class="stat-number" style="color: {{ ($monthlyBalance ?? 0) >= 0 ? '#10b981' : '#ef4444' }}">
                ₱{{ number_format(abs($monthlyBalance ?? 0), 2) }}
            </div>
            <div class="stat-trend">
                <span class="{{ ($monthlyBalance ?? 0) >= 0 ? 'up' : 'down' }}">
                    {{ ($monthlyBalance ?? 0) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Row 1: Chart (Full Width) -->
    <div class="card-modern" style="margin-bottom: 1.2rem;">
        <div class="card-modern-header">
            <h6><i class="fas fa-chart-line" style="color:#10b981;"></i> Income vs Expenses</h6>
            <span class="action-link">Last 6 months</span>
        </div>
        <div class="card-modern-body" style="max-height: 280px;">
            <div class="chart-wrap">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Row 2: 3-Column Grid -->
    <div class="dashboard-grid three">
        
        <!-- Recent Transactions -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h6><i class="fas fa-history" style="color:#10b981;"></i> Transactions</h6>
                <a href="{{ route('finance.index') }}" class="action-link">View All →</a>
            </div>
            <div class="card-modern-body">
                @forelse(($recentActivities ?? []) as $item)
                    <div class="list-item">
                        <div class="list-icon {{ ($item->type ?? 'expense') == 'income' ? 'income' : 'expense' }}">
                            <i class="fas {{ ($item->type ?? 'expense') == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        </div>
                        <div class="list-content">
                            <div class="list-title">{{ $item->description ?? $item->name ?? 'Transaction' }}</div>
                            <div class="list-sub">{{ \Carbon\Carbon::parse($item->date ?? $item->created_at ?? now())->format('M d, Y') }}</div>
                        </div>
                        <div class="list-right">
                            <div class="list-amount {{ ($item->type ?? 'expense') == 'income' ? 'positive' : 'negative' }}">
                                {{ ($item->type ?? 'expense') == 'income' ? '+' : '-' }} ₱{{ number_format($item->amount ?? 0, 2) }}
                            </div>
                            <span class="list-badge">{{ ucfirst($item->type ?? 'expense') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-receipt"></i>
                        <p>No transactions yet</p>
                        <a href="{{ route('finance.index') }}" class="btn-outline-sm">Add Transaction</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Birthdays -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h6><i class="fas fa-birthday-cake" style="color:#f59e0b;"></i> Birthdays</h6>
                <span class="action-link">This month</span>
            </div>
            <div class="card-modern-body">
                @forelse(($upcomingBirthdays ?? []) as $birthday)
                    <div class="bd-item">
                        <div class="bd-date">
                            <div class="bd-day">{{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('d') }}</div>
                            <div class="bd-month">{{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('M') }}</div>
                        </div>
                        <div class="bd-info">
                            <div class="bd-name">
                                <i class="fas fa-birthday-cake"></i>
                                {{ $birthday->first_name ?? '' }} {{ $birthday->last_name ?? '' }}
                            </div>
                            <div class="bd-text">
                                @if(isset($birthday->days_until))
                                    @if($birthday->days_until == 0)
                                        <span class="bd-tag">🎉 Today!</span>
                                    @elseif($birthday->days_until == 1)
                                        <span class="bd-tag">🎂 Tomorrow!</span>
                                    @else
                                        Turning {{ $birthday->age ?? '?' }} in {{ $birthday->days_until }} days
                                    @endif
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('members.show', $birthday->id) }}" class="bd-action">
                            <i class="fas fa-user"></i>
                        </a>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-birthday-cake"></i>
                        <p>No upcoming birthdays</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Choir Schedule + Coming Sundays -->
        <div class="card-modern">
            <div class="card-modern-header">
                <h6><i class="fas fa-music" style="color:#4F46E5;"></i> Choir Schedule</h6>
                <span class="action-link">Upcoming</span>
            </div>
            <div class="card-modern-body">
                @if(isset($upcomingSunday) && $upcomingSunday)
                    <div class="choir-center">
                        <div class="choir-icon-wrap">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="choir-group-name" style="color: {{ $upcomingSunday['group_color'] ?? '#4F46E5' }};">
                            {{ $upcomingSunday['group_name'] ?? 'Choir Group' }}
                        </div>
                        <div class="choir-meta">
                            <i class="fas fa-users"></i> {{ $upcomingSunday['members_count'] ?? 0 }} members · 
                            {{ \Carbon\Carbon::parse($upcomingSunday['date'] ?? now())->format('M d, Y') }}
                        </div>
                    </div>
                    
                    <div class="choir-members-chip">
                        @forelse(($upcomingSunday['members'] ?? []) as $member)
                            <span class="chip">{{ $member->first_name ?? '' }} {{ substr($member->last_name ?? '', 0, 1) }}.</span>
                        @empty
                            <span class="chip">No members assigned</span>
                        @endforelse
                    </div>
                    
                    <a href="{{ route('choir-schedules.index', ['date' => $upcomingSunday['date'] ?? '']) }}" class="btn-primary-sm">
                        <i class="fas fa-calendar-alt"></i> View Schedule
                    </a>

                    @if(isset($nextWeeks) && count($nextWeeks) > 0)
                    <div class="coming-wrap">
                        <div class="coming-label"><i class="fas fa-calendar-week"></i> Coming Sundays</div>
                        <div class="coming-grid">
                            @foreach($nextWeeks as $week)
                            <div class="coming-item">
                                <div class="coming-date">{{ \Carbon\Carbon::parse($week['date'])->format('M d') }}</div>
                                <div class="coming-name">{{ $week['group_name'] ?? 'Choir' }}</div>
                                <div class="coming-count"><i class="fas fa-users"></i> {{ $week['members_count'] ?? 0 }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-music"></i>
                        <p>No upcoming schedule</p>
                        <a href="{{ route('choir-schedules.index') }}" class="btn-outline-sm">Create Schedule</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const financeCanvas = document.getElementById('financeChart');
        if (financeCanvas) {
            let months = [];
            let incomeData = [];
            let expenseData = [];
            
            try {
                months = JSON.parse('<?php echo addslashes(json_encode($months ?? [])); ?>');
                incomeData = JSON.parse('<?php echo addslashes(json_encode($incomeData ?? [])); ?>');
                expenseData = JSON.parse('<?php echo addslashes(json_encode($expenseData ?? [])); ?>');
            } catch (e) {
                months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                incomeData = [0, 0, 0, 0, 0, 0];
                expenseData = [0, 0, 0, 0, 0, 0];
            }
            
            if (!Array.isArray(months) || months.length === 0) months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            if (!Array.isArray(incomeData) || incomeData.length === 0) incomeData = new Array(months.length).fill(0);
            if (!Array.isArray(expenseData) || expenseData.length === 0) expenseData = new Array(months.length).fill(0);
            
            while (incomeData.length < months.length) incomeData.push(0);
            while (expenseData.length < months.length) expenseData.push(0);
            
            new Chart(financeCanvas, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Income',
                            data: incomeData,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.08)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#10B981',
                            pointBorderColor: '#FFFFFF',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#10B981',
                            pointHoverBorderColor: '#FFFFFF',
                            pointHoverBorderWidth: 2
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.06)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#EF4444',
                            pointBorderColor: '#FFFFFF',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#EF4444',
                            pointHoverBorderColor: '#FFFFFF',
                            pointHoverBorderWidth: 2
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
                                font: { size: 10, weight: '500' },
                                usePointStyle: true,
                                boxWidth: 8,
                                padding: 12,
                                color: '#94A3B8'
                            } 
                        },
                        tooltip: { 
                            backgroundColor: '#FFFFFF',
                            titleColor: '#1E293B',
                            bodyColor: '#475569',
                            borderColor: '#E2E8F0',
                            borderWidth: 1,
                            cornerRadius: 10,
                            padding: 12,
                            callbacks: { 
                                label: (ctx) => ctx.dataset.label + ': ₱' + ctx.parsed.y.toLocaleString() 
                            } 
                        }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            ticks: { 
                                callback: (v) => '₱' + v.toLocaleString(),
                                font: { size: 9 },
                                color: '#94A3B8'
                            },
                            grid: { 
                                color: 'rgba(148, 163, 184, 0.08)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: { 
                                font: { size: 9 },
                                color: '#94A3B8'
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
        }
    });
</script>
@endsection