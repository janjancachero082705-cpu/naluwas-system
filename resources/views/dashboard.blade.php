@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<style>
    * { box-sizing: border-box; }

    /* ─── Stats Grid ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        margin-bottom: 1.25rem;
    }

    .stat-card {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .si-blue   { background: #E6F1FB; color: #185FA5; }
    .si-purple { background: #EEEDFE; color: #534AB7; }
    .si-teal   { background: #E1F5EE; color: #0F6E56; }
    .si-amber  { background: #FAEEDA; color: #854F0B; }

    .stat-info { flex: 1; min-width: 0; }

    .stat-label {
        font-size: 11px;
        color: var(--text-muted);
        margin-bottom: 3px;
        letter-spacing: 0.3px;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1;
        transition: all 0.3s ease;
    }

    .stat-value.updated {
        animation: statPulse 0.5s ease;
    }

    @keyframes statPulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.08); color: #1D9E75; }
        100% { transform: scale(1); }
    }

    .stat-sub {
        font-size: 11px;
        margin-top: 4px;
        color: var(--text-muted);
    }

    .stat-sub.trend-up { color: #0F6E56; }
    .stat-sub.trend-down { color: #A32D2D; }

    .col-3 .card-pro {
        height: 100%;
    }

    /* ─── Cards ─── */
    .card-pro {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s;
    }

    .card-pro:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .card-pro-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 1rem;
        border-bottom: 0.5px solid var(--border-color);
        background: var(--bg-tertiary);
    }

    .card-pro-header h6 {
        font-size: 12px;
        font-weight: 600;
        margin: 0;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .card-pro-header h6 i { font-size: 14px; }

    .action-link {
        font-size: 11px;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.15s;
    }

    .action-link:hover { color: #0F6E56; }

    .card-pro-body {
        padding: 0.9rem 1rem;
        flex: 1;
        overflow-y: auto;
        max-height: 380px;
    }

    .card-pro-body::-webkit-scrollbar { width: 3px; }
    .card-pro-body::-webkit-scrollbar-track { background: var(--bg-tertiary); border-radius: 10px; }
    .card-pro-body::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

    /* ─── Chart ─── */
    .chart-legend {
        display: flex;
        gap: 16px;
        margin-bottom: 10px;
    }

    .leg-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--text-muted);
    }

    .leg-dot {
        width: 10px;
        height: 10px;
        border-radius: 2px;
    }

    .chart-wrap {
        height: 210px;
        position: relative;
    }

    .chart-wrap canvas {
        width: 100% !important;
        height: 100% !important;
    }

    /* ─── Grids ─── */
    .dashboard-grid {
        display: grid;
        gap: 10px;
        margin-bottom: 10px;
        width: 100%;
    }

    .col-full   { grid-template-columns: minmax(0, 1fr); }
    .col-3      { grid-template-columns: repeat(3, minmax(0, 1fr)); }

    /* ─── Transaction List ─── */
    .tx-list { display: flex; flex-direction: column; }

    .tx-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 0.5px solid var(--border-color);
        transition: all 0.2s ease;
    }

    .tx-item:last-child { border-bottom: none; padding-bottom: 0; }

    .tx-item.new-transaction {
        animation: highlightNew 2s ease;
    }

    @keyframes highlightNew {
        0% { background: rgba(29, 158, 117, 0.15); border-radius: 8px; }
        100% { background: transparent; }
    }

    .tx-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }

    .tx-in  { background: #E1F5EE; color: #0F6E56; }
    .tx-out { background: #FCEBEB; color: #A32D2D; }

    .tx-content { flex: 1; min-width: 0; }

    .tx-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tx-date {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    .tx-right { text-align: right; flex-shrink: 0; }

    .tx-amount {
        font-size: 13px;
        font-weight: 600;
    }

    .tx-amount.pos { color: #0F6E56; }
    .tx-amount.neg { color: #A32D2D; }

    .tx-badge {
        font-size: 10px;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        border: 0.5px solid var(--border-color);
        border-radius: 20px;
        padding: 1px 7px;
        display: inline-block;
        margin-top: 2px;
    }

    /* ─── Birthday List ─── */
    .bd-list { display: flex; flex-direction: column; }

    .bd-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 0.5px solid var(--border-color);
        transition: all 0.2s ease;
    }

    .bd-item:last-child { border-bottom: none; padding-bottom: 0; }

    .bd-item.new-birthday {
        animation: highlightNew 2s ease;
    }

    .bd-date-box {
        min-width: 38px;
        text-align: center;
        background: var(--bg-tertiary);
        border: 0.5px solid var(--border-color);
        border-radius: 8px;
        padding: 4px 5px;
        flex-shrink: 0;
    }

    .bd-day   { font-size: 15px; font-weight: 600; color: var(--text-primary); line-height: 1; }
    .bd-month { font-size: 10px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }

    .bd-info { flex: 1; min-width: 0; }

    .bd-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
    }

    .bd-meta { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

    .bd-badge {
        font-size: 10px;
        border-radius: 20px;
        padding: 1px 8px;
        display: inline-block;
    }

    .bd-badge.amber  { background: #FAEEDA; color: #854F0B; }
    .bd-badge.teal   { background: #E1F5EE; color: #0F6E56; }

    .bd-action {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        background: var(--bg-tertiary);
        border: 0.5px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 12px;
        flex-shrink: 0;
        transition: all 0.15s;
    }

    .bd-action:hover {
        background: #E6F1FB;
        border-color: #B5D4F4;
        color: #185FA5;
    }

    /* ─── Choir Card ─── */
    .choir-center { text-align: center; padding: 0.5rem 0 0.75rem; }

    .choir-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #EEEDFE;
        color: #534AB7;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
    }

    .choir-group-name {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .choir-meta-text {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    .chips {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        justify-content: center;
        margin: 10px 0 12px;
    }

    .chip {
        background: var(--bg-tertiary);
        border: 0.5px solid var(--border-color);
        border-radius: 20px;
        padding: 2px 9px;
        font-size: 11px;
        color: var(--text-muted);
    }

    .btn-view-schedule {
        background: #1D9E75;
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 7px 0;
        width: 100%;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.2s;
        cursor: pointer;
    }

    .btn-view-schedule:hover { background: #0F6E56; color: #fff; }

    /* ─── Coming Sundays ─── */
    .coming-wrap {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 0.5px solid var(--border-color);
    }

    .coming-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .coming-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;
    }

    .coming-item {
        background: var(--bg-tertiary);
        border: 0.5px solid var(--border-color);
        border-radius: 8px;
        padding: 7px 5px;
        text-align: center;
        transition: all 0.2s ease;
    }

    .coming-item.updated {
        animation: highlightNew 2s ease;
    }

    .coming-date  { font-size: 10px; color: var(--text-muted); }
    .coming-name  { font-size: 12px; font-weight: 600; color: #534AB7; }
    .coming-count { font-size: 10px; color: var(--text-muted); margin-top: 1px; }

    /* ─── Empty State ─── */
    .empty-state {
        text-align: center;
        padding: 1.5rem 0;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 26px;
        display: block;
        margin-bottom: 8px;
        opacity: 0.4;
    }

    .empty-state p { font-size: 12px; margin-bottom: 10px; }

    .btn-outline-sm {
        display: inline-block;
        font-size: 11px;
        padding: 4px 14px;
        border-radius: 8px;
        border: 0.5px solid var(--border-color);
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-outline-sm:hover {
        background: #1D9E75;
        border-color: #1D9E75;
        color: #fff;
    }

    /* ─── Alerts ─── */
    .alert-minimal {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.65rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 13px;
        border-left: 3px solid transparent;
        animation: slideDown 0.25s ease;
    }

    .alert-minimal.success {
        background: rgba(29, 158, 117, 0.07);
        border-left-color: #1D9E75;
        color: #0F6E56;
    }

    .alert-minimal.error {
        background: rgba(226, 75, 74, 0.07);
        border-left-color: #E24B4A;
        color: #A32D2D;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ─── Real-time toast inside dashboard ─── */
    .dashboard-toast {
        position: fixed;
        bottom: 80px;
        right: 20px;
        z-index: 9999;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        gap: 12px;
        transform: translateX(120%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 350px;
        border-left: 4px solid #1D9E75;
    }

    .dashboard-toast.show {
        transform: translateX(0);
    }

    .dashboard-toast .toast-icon {
        font-size: 18px;
    }

    .dashboard-toast .toast-content {
        flex: 1;
    }

    .dashboard-toast .toast-title {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .dashboard-toast .toast-message {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* ─── Responsive ─── */
    @media (max-width: 1100px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .col-3      { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .col-3      { grid-template-columns: minmax(0, 1fr); }
        .coming-grid { grid-template-columns: repeat(2, 1fr); }
        .chart-wrap  { height: 180px; }
        .dashboard-toast {
            max-width: calc(100vw - 32px);
            right: 16px;
            bottom: 80px;
        }
    }
</style>

<div class="container-fluid px-0" style="width:100%; overflow:visible;">

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="alert-minimal success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert-minimal error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Dashboard Toast for Real-time Updates ── --}}
    <div class="dashboard-toast" id="dashboardToast">
        <span class="toast-icon">📊</span>
        <div class="toast-content">
            <div class="toast-title" id="toastTitle">Update received</div>
            <div class="toast-message" id="toastMessage">Real-time data updated</div>
        </div>
        <button onclick="this.closest('.dashboard-toast').classList.remove('show')" style="background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:14px;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon si-blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total members</div>
                <div class="stat-value" id="stat-total-members">{{ number_format($totalMembers ?? 0) }}</div>
                <div class="stat-sub trend-up">↑ Active members</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon si-purple">
                <i class="fas fa-music"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Choir members</div>
                <div class="stat-value" id="stat-choir-members">{{ number_format($choirMembers ?? 0) }}</div>
                <div class="stat-sub trend-up">↑ Music ministry</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon si-teal">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Today's attendance</div>
                <div class="stat-value" id="stat-today-attendance">{{ number_format($todayAttendance ?? 0) }}</div>
                @php
                    $rate = ($totalMembers ?? 1) > 0
                        ? (($todayAttendance ?? 0) / ($totalMembers ?? 1)) * 100
                        : 0;
                @endphp
                <div class="stat-sub" id="stat-attendance-rate">{{ number_format($rate, 1) }}% present</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon si-amber">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Monthly balance</div>
                <div class="stat-value" id="stat-monthly-balance" style="color: {{ ($monthlyBalance ?? 0) >= 0 ? '#0F6E56' : '#A32D2D' }};">
                    ₱{{ number_format(abs($monthlyBalance ?? 0), 2) }}
                </div>
                <div class="stat-sub" id="stat-balance-trend" style="color: {{ ($monthlyBalance ?? 0) >= 0 ? '#0F6E56' : '#A32D2D' }};">
                    {{ ($monthlyBalance ?? 0) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
                </div>
            </div>
        </div>

    </div>

    {{-- ── Finance Chart (full width) ── --}}
    <div class="dashboard-grid col-full" style="margin-bottom: 10px;">
        <div class="card-pro">
            <div class="card-pro-header">
                <h6>
                    <i class="fas fa-chart-line" style="color:#1D9E75;"></i>
                    Income vs expenses
                    <span id="chart-update-indicator" style="font-size:10px;color:var(--text-muted);font-weight:400;display:none;">
                        <i class="fas fa-spinner fa-spin"></i> Updating...
                    </span>
                </h6>
                <span class="action-link">Last 6 months</span>
            </div>
            <div class="card-pro-body" style="max-height: 280px;">
                <div class="chart-legend">
                    <span class="leg-item">
                        <span class="leg-dot" style="background:#1D9E75;"></span> Income
                    </span>
                    <span class="leg-item">
                        <span class="leg-dot" style="background:#E24B4A; border: 1px dashed #E24B4A; background: none; width:18px; height:2px; border-radius:0;"></span> Expenses
                    </span>
                </div>
                <div class="chart-wrap">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Three-Column Row ── --}}
    <div class="dashboard-grid col-3">

        {{-- Transactions --}}
        <div class="card-pro">
            <div class="card-pro-header">
                <h6><i class="fas fa-arrows-alt-v"></i> Transactions</h6>
                <a href="{{ route('inventory.index') }}" class="action-link">View all →</a>
            </div>
            <div class="card-pro-body" id="transactions-list">
                @forelse(($recentActivities ?? []) as $item)
                    @php
                        $isIncome = ($item->type ?? 'expense') === 'income';
                    @endphp
                    <div class="tx-item" data-transaction-id="{{ $item->id ?? '' }}">
                        <div class="tx-icon {{ $isIncome ? 'tx-in' : 'tx-out' }}">
                            <i class="fas {{ $isIncome ? 'fa-arrow-down-left' : 'fa-arrow-up-right' }}"></i>
                        </div>
                        <div class="tx-content">
                            <div class="tx-name">{{ $item->description ?? $item->name ?? 'Transaction' }}</div>
                            <div class="tx-date">
                                {{ \Carbon\Carbon::parse($item->date ?? $item->created_at ?? now())->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="tx-right">
                            <div class="tx-amount {{ $isIncome ? 'pos' : 'neg' }}">
                                {{ $isIncome ? '+' : '−' }}₱{{ number_format($item->amount ?? 0, 2) }}
                            </div>
                            <span class="tx-badge">{{ ucfirst($item->type ?? 'expense') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-receipt"></i>
                        <p>No transactions yet</p>
                        <a href="{{ route('inventory.index') }}" class="btn-outline-sm">Add transaction</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Birthdays --}}
        <div class="card-pro">
            <div class="card-pro-header">
                <h6>
                    <i class="fas fa-birthday-cake" style="color:#854F0B;"></i>
                    Birthdays
                </h6>
                <span class="action-link">This month</span>
            </div>
            <div class="card-pro-body" id="birthdays-list">
                @forelse(($upcomingBirthdays ?? []) as $birthday)
                    @php
                        $daysUntil = $birthday->days_until ?? null;
                    @endphp
                    <div class="bd-item" data-member-id="{{ $birthday->id ?? '' }}">
                        <div class="bd-date-box">
                            <div class="bd-day">
                                {{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('d') }}
                            </div>
                            <div class="bd-month">
                                {{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('M') }}
                            </div>
                        </div>
                        <div class="bd-info">
                            <div class="bd-name">
                                {{ $birthday->first_name ?? '' }} {{ $birthday->last_name ?? '' }}
                            </div>
                            <div class="bd-meta">
                                @if($daysUntil === 0)
                                    <span class="bd-badge teal">🎉 Today!</span>
                                @elseif($daysUntil === 1)
                                    <span class="bd-badge amber">🎂 Tomorrow!</span>
                                @elseif($daysUntil !== null)
                                    Turning {{ $birthday->age ?? '?' }} in {{ $daysUntil }} days
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

        {{-- Choir Schedule --}}
        <div class="card-pro">
            <div class="card-pro-header">
                <h6>
                    <i class="fas fa-music" style="color:#534AB7;"></i>
                    Choir schedule
                </h6>
                <span class="action-link">Upcoming</span>
            </div>
            <div class="card-pro-body" id="choir-schedule-container">
                @if(isset($upcomingSunday) && $upcomingSunday)
                    <div class="choir-center">
                        <div class="choir-avatar">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="choir-group-name" style="color: {{ $upcomingSunday['group_color'] ?? '#534AB7' }};">
                            {{ $upcomingSunday['group_name'] ?? 'Choir Group' }}
                        </div>
                        <div class="choir-meta-text" id="choir-meta-text">
                            <i class="fas fa-users"></i>
                            {{ $upcomingSunday['members_count'] ?? 0 }} members ·
                            {{ \Carbon\Carbon::parse($upcomingSunday['date'] ?? now())->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="chips" id="choir-members-chips">
                        @forelse(($upcomingSunday['members'] ?? []) as $member)
                            <span class="chip">
                                {{ $member->first_name ?? '' }} {{ substr($member->last_name ?? '', 0, 1) }}.
                            </span>
                        @empty
                            <span class="chip">No members assigned</span>
                        @endforelse
                    </div>

                    <a href="{{ route('choir-schedules.index', ['date' => $upcomingSunday['date'] ?? '']) }}"
                       class="btn-view-schedule">
                        <i class="fas fa-calendar-alt"></i> View schedule
                    </a>

                    @if(isset($nextWeeks) && count($nextWeeks) > 0)
                        <div class="coming-wrap">
                            <div class="coming-label">
                                <i class="fas fa-calendar-week"></i> Coming Sundays
                            </div>
                            <div class="coming-grid" id="coming-sundays-grid">
                                @foreach($nextWeeks as $week)
                                    <div class="coming-item" data-week-date="{{ $week['date'] ?? '' }}">
                                        <div class="coming-date">
                                            {{ \Carbon\Carbon::parse($week['date'])->format('M d') }}
                                        </div>
                                        <div class="coming-name">{{ $week['group_name'] ?? 'Choir' }}</div>
                                        <div class="coming-count">
                                            <i class="fas fa-users"></i> {{ $week['members_count'] ?? 0 }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @else
                    <div class="empty-state">
                        <i class="fas fa-music"></i>
                        <p>No upcoming schedule</p>
                        <a href="{{ route('choir-schedules.index') }}" class="btn-outline-sm">
                            Create schedule
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>{{-- /.col-3 --}}

</div>{{-- /.container-fluid --}}

{{-- ── Chart.js ── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ============================================
// FINANCE CHART
// ============================================
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('financeChart');
    if (!canvas) return;

    let months      = [];
    let incomeData  = [];
    let expenseData = [];

    try {
        months      = JSON.parse('<?php echo addslashes(json_encode($months      ?? [])); ?>');
        incomeData  = JSON.parse('<?php echo addslashes(json_encode($incomeData  ?? [])); ?>');
        expenseData = JSON.parse('<?php echo addslashes(json_encode($expenseData ?? [])); ?>');
    } catch (e) {
        months      = ['Jan','Feb','Mar','Apr','May','Jun'];
        incomeData  = [0,0,0,0,0,0];
        expenseData = [0,0,0,0,0,0];
    }

    if (!Array.isArray(months)      || months.length === 0)      months      = ['Jan','Feb','Mar','Apr','May','Jun'];
    if (!Array.isArray(incomeData)  || incomeData.length === 0)  incomeData  = new Array(months.length).fill(0);
    if (!Array.isArray(expenseData) || expenseData.length === 0) expenseData = new Array(months.length).fill(0);

    while (incomeData.length  < months.length) incomeData.push(0);
    while (expenseData.length < months.length) expenseData.push(0);

    const isDark    = document.documentElement.getAttribute('data-theme') === 'dark' || 
                      window.matchMedia('(prefers-color-scheme: dark)').matches;
    const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
    const tickColor = isDark ? 'rgba(255,255,255,0.4)'  : '#888';
    const ttBg      = isDark ? '#2a2a2a' : '#ffffff';
    const ttTitle   = isDark ? '#e0e0e0' : '#1e293b';
    const ttBody    = isDark ? '#aaaaaa' : '#475569';
    const ttBorder  = isDark ? 'rgba(255,255,255,0.1)' : '#e2e8f0';
    const ptBorder  = isDark ? '#1e1e1e' : '#ffffff';

    let financeChart = new Chart(canvas, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Income',
                    data: incomeData,
                    borderColor: '#1D9E75',
                    backgroundColor: 'rgba(29,158,117,0.07)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#1D9E75',
                    pointBorderColor: ptBorder,
                    pointBorderWidth: 2,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#1D9E75',
                    pointHoverBorderColor: ptBorder,
                    pointHoverBorderWidth: 2
                },
                {
                    label: 'Expenses',
                    data: expenseData,
                    borderColor: '#E24B4A',
                    backgroundColor: 'rgba(226,75,74,0.05)',
                    borderWidth: 2,
                    borderDash: [5, 3],
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#E24B4A',
                    pointBorderColor: ptBorder,
                    pointBorderWidth: 2,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#E24B4A',
                    pointHoverBorderColor: ptBorder,
                    pointHoverBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: ttBg,
                    titleColor: ttTitle,
                    bodyColor: ttBody,
                    borderColor: ttBorder,
                    borderWidth: 1,
                    cornerRadius: 8,
                    padding: 10,
                    callbacks: {
                        label: ctx => ctx.dataset.label + ': ₱' + ctx.parsed.y.toLocaleString()
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: v => '₱' + v.toLocaleString(),
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

    // ============================================
    // EXPOSE CHART FOR REAL-TIME UPDATES
    // ============================================
    window.financeChart = financeChart;
    window.chartData = {
        months: months,
        income: incomeData,
        expenses: expenseData
    };
});

// ============================================
// REAL-TIME DASHBOARD UPDATES
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    
    // Show dashboard toast notification
    function showDashboardToast(title, message, icon = '📊') {
        const toast = document.getElementById('dashboardToast');
        if (!toast) return;
        
        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastMessage').textContent = message;
        toast.querySelector('.toast-icon').textContent = icon;
        
        toast.classList.add('show');
        clearTimeout(toast._hideTimeout);
        toast._hideTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    // ============================================
    // LISTEN FOR ATTENDANCE UPDATES
    // ============================================
    if (window.Echo) {
        window.Echo.channel('attendance')
            .listen('attendance.updated', (e) => {
                console.log('📊 Dashboard: Attendance updated', e);
                
                // Update stats
                const present = e.present || e.presentCount || 0;
                const total = e.total || e.totalMembers || 0;
                const absent = e.absent || e.absentCount || 0;
                
                const todayEl = document.getElementById('stat-today-attendance');
                if (todayEl) {
                    todayEl.textContent = present;
                    todayEl.classList.add('updated');
                    setTimeout(() => todayEl.classList.remove('updated'), 500);
                }
                
                const rateEl = document.getElementById('stat-attendance-rate');
                if (rateEl) {
                    const rate = total > 0 ? Math.round((present / total) * 100 * 10) / 10 : 0;
                    rateEl.textContent = rate + '% present';
                }
                
                // Show toast
                showDashboardToast(
                    '📊 Attendance Updated',
                    `${present} present, ${absent} absent`,
                    '📊'
                );
            });

        // ============================================
        // LISTEN FOR FINANCIAL UPDATES
        // ============================================
        window.Echo.channel('finances')
            .listen('balance.updated', (e) => {
                console.log('💰 Dashboard: Balance updated', e);
                
                const balance = e.balance || 0;
                const balanceEl = document.getElementById('stat-monthly-balance');
                const trendEl = document.getElementById('stat-balance-trend');
                
                if (balanceEl) {
                    const isPositive = balance >= 0;
                    balanceEl.textContent = '₱' + Math.abs(balance).toLocaleString();
                    balanceEl.style.color = isPositive ? '#0F6E56' : '#A32D2D';
                    balanceEl.classList.add('updated');
                    setTimeout(() => balanceEl.classList.remove('updated'), 500);
                }
                
                if (trendEl) {
                    const isPositive = balance >= 0;
                    trendEl.textContent = isPositive ? '↑ Surplus' : '↓ Deficit';
                    trendEl.style.color = isPositive ? '#0F6E56' : '#A32D2D';
                }
                
                // Update chart if data is provided
                if (e.chart_data && window.financeChart) {
                    const chart = window.financeChart;
                    chart.data.datasets[0].data = e.chart_data.income || window.chartData?.income || [];
                    chart.data.datasets[1].data = e.chart_data.expenses || window.chartData?.expenses || [];
                    chart.update();
                    
                    document.getElementById('chart-update-indicator').style.display = 'inline';
                    setTimeout(() => {
                        document.getElementById('chart-update-indicator').style.display = 'none';
                    }, 2000);
                }
                
                showDashboardToast(
                    '💰 Balance Updated',
                    `${e.eglesia_name || 'Church'}: ₱${Math.abs(balance).toLocaleString()}`,
                    '💰'
                );
            });

        // ============================================
        // LISTEN FOR CHOIR SCHEDULE UPDATES
        // ============================================
        window.Echo.channel('choir')
            .listen('schedule.updated', (e) => {
                console.log('🎵 Dashboard: Choir schedule updated', e);
                
                // Update choir stats if data is provided
                if (e.members_count !== undefined) {
                    const choirEl = document.getElementById('stat-choir-members');
                    if (choirEl) {
                        choirEl.textContent = e.members_count;
                        choirEl.classList.add('updated');
                        setTimeout(() => choirEl.classList.remove('updated'), 500);
                    }
                }
                
                // Update choir schedule display
                const metaText = document.getElementById('choir-meta-text');
                if (metaText && e.event_name) {
                    metaText.innerHTML = `
                        <i class="fas fa-users"></i>
                        ${e.members_count || 0} members ·
                        ${e.date || 'Scheduled'}
                    `;
                }
                
                // Update coming Sundays if data is provided
                if (e.next_weeks && Array.isArray(e.next_weeks)) {
                    const grid = document.getElementById('coming-sundays-grid');
                    if (grid) {
                        grid.innerHTML = e.next_weeks.map(week => `
                            <div class="coming-item updated">
                                <div class="coming-date">${week.date || ''}</div>
                                <div class="coming-name">${week.group_name || 'Choir'}</div>
                                <div class="coming-count">
                                    <i class="fas fa-users"></i> ${week.members_count || 0}
                                </div>
                            </div>
                        `).join('');
                    }
                }
                
                showDashboardToast(
                    '🎵 Choir Schedule',
                    e.message || 'Schedule updated',
                    '🎵'
                );
            });
    }
});

// ============================================
// THEME CHANGE DETECTION FOR CHART
// ============================================
const observer = new MutationObserver(() => {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const chart = window.financeChart;
    if (chart) {
        const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
        const tickColor = isDark ? 'rgba(255,255,255,0.4)' : '#888';
        chart.options.scales.y.grid.color = gridColor;
        chart.options.scales.y.ticks.color = tickColor;
        chart.options.scales.x.ticks.color = tickColor;
        chart.update();
    }
});

observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['data-theme']
});
</script>
@endsection