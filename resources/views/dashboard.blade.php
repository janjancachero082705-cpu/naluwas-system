@extends('layouts.app')

@section('title', __('Dashboard'))

{{-- Big greeting, like "Hello Thomas" --}}
@section('header')
    {{ __('Hello') }} {{ \Illuminate\Support\Str::of(Auth::user()->name ?? '')->before(' ') }}
@endsection

@section('subheader', __('This is your dashboard'))

@section('content')
@php
    $monthlyData = $monthlyData ?? [];
    $totalIncome = collect($monthlyData)->sum(function ($m) {
        return (float) (is_array($m) ? ($m['income'] ?? 0) : ($m->income ?? 0));
    });
    $totalExpense = collect($monthlyData)->sum(function ($m) {
        return (float) (is_array($m) ? ($m['expense'] ?? 0) : ($m->expense ?? 0));
    });

    $male        = (int) ($maleCount ?? 0);
    $female      = (int) ($femaleCount ?? 0);
    $totalGender = $male + $female;
    $malePerc    = $totalGender > 0 ? round(($male / $totalGender) * 100) : 0;
    $femalePerc  = $totalGender > 0 ? 100 - $malePerc : 0;

    $balance = $monthlyBalance ?? 0;
@endphp

<style>
    .dash { max-width: 1600px; margin: 0 auto; }

    .dash .stat-card { height: 100%; }
    .dash .stat-link { color: var(--text-light); font-size: 0.9rem; letter-spacing: 2px; }

    /* Income panel: summary on the left, chart on the right */
    .income-summary { display: flex; flex-direction: column; justify-content: space-between; height: 100%; padding: 28px 28px 28px 32px; }
    .income-summary .lead-label { font-size: 0.8rem; font-weight: 700; color: var(--text-main); }
    .income-chart { position: relative; height: 320px; padding: 22px 24px 14px 8px; }
    @media (min-width: 992px) {
        .income-summary { border-right: 1px solid var(--border-color); }
    }
    @media (max-width: 991px) {
        .income-summary { gap: 18px; padding: 24px; }
        .income-chart { padding: 8px 16px 16px; }
    }

    /* Demographics */
    .donut-wrap { position: relative; height: 230px; }
    .donut-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }
    .donut-center .val { font-size: 1.9rem; font-weight: 800; letter-spacing: -1px; line-height: 1; color: var(--text-main); }
    .donut-center .lbl { font-size: 0.75rem; font-weight: 600; color: var(--text-muted); margin-top: 4px; }
    .legend-row { display: flex; align-items: center; gap: 12px; padding: 8px 0; font-size: 0.85rem; font-weight: 600; }
    .legend-row .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .legend-row .pct { margin-left: auto; color: var(--text-muted); font-weight: 600; }

    /* Table pills */
    .pill { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; }
    .pill-in  { background: rgba(34, 197, 94, 0.12); color: #16A34A; }
    .pill-out { background: rgba(239, 68, 68, 0.1);  color: #DC2626; }
    .amount-in  { color: #16A34A; font-weight: 700; }
    .amount-out { color: #DC2626; font-weight: 700; }

    /* Birthdays */
    .bday { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: var(--radius); height: 100%; }
    .bday-avatar { width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: var(--primary-soft); color: var(--primary-btn); font-weight: 800; font-size: 0.9rem; }
    .bday-name { font-size: 0.85rem; font-weight: 700; margin: 0; line-height: 1.3; }
    .bday-date { font-size: 0.75rem; color: var(--text-muted); margin: 0; }

    .empty-note { padding: 28px 0; text-align: center; color: var(--text-muted); font-size: 0.85rem; }
    /* ========== MOBILE ========== */
    @media (max-width: 767px) {
        .dash .stat-card {
            aspect-ratio: 1 / 1;
            height: auto;
            padding: 12px !important;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            overflow: hidden;
        }
        .dash .stat-card .stat-icon { width: 34px; height: 34px; font-size: 0.9rem; flex-shrink: 0; }
        .dash .stat-card .stat-label { font-size: 0.68rem; line-height: 1.2; }
        .dash .stat-card .stat-value { font-size: clamp(1.1rem, 6vw, 1.5rem); line-height: 1.1; word-break: break-all; }
        .dash .stat-card .stat-trend { font-size: 0.65rem; }

        .income-summary { padding: 18px; gap: 14px; }
        .income-chart   { height: 240px; padding: 8px 10px 12px; }
        .income-summary .big-number { font-size: 1.8rem; }

        .panel-head { padding: 14px 16px; font-size: 0.85rem; }
        .panel-body { padding: 16px; }

        .table th, .table td { padding: 10px 8px; font-size: 0.75rem; white-space: nowrap; }
        .pill { padding: 2px 8px; font-size: 0.62rem; }

        .donut-wrap { height: 190px; }
        .donut-center .val { font-size: 1.5rem; }

        .bday { padding: 10px; gap: 8px; }
        .bday-avatar { width: 34px; height: 34px; font-size: 0.8rem; }
        .bday-name { font-size: 0.78rem; }
        .bday-date { font-size: 0.7rem; }
    }
    @media (max-width: 767px) {
        .dash [class*="col-"] { min-width: 0; }
        .income-chart canvas, .donut-wrap canvas { width: 100% !important; }

        .income-summary {
            border-bottom: 1px solid var(--border-color);
            flex-direction: row;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
        }
        .income-summary .lead-label { width: 100%; }

        .donut-wrap { max-width: 220px; margin: 0 auto; }
        .legend-row { padding: 6px 0; font-size: 0.8rem; }

        .table th, .table td { white-space: normal; }
    }
    @media (max-width: 380px) {
        .dash .stat-card .stat-trend { display: none; }
    }
</style>

<div class="dash container-fluid px-0">

    {{-- 1. STAT CARDS --}}
    <div class="row g-2 g-md-4 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div>
                    <div class="stat-label">{{ __('Total Members') }}</div>
                    <div class="stat-value count-up" data-target="{{ $totalMembers ?? 0 }}">0</div>
                    <div class="stat-trend"><span class="trend-up"><i class="fas fa-arrow-up"></i> {{ __('Active') }}</span></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                <div>
                    <div class="stat-label">{{ __('Monthly Balance') }}</div>
                    <div class="stat-value count-up" data-target="{{ abs($balance) }}" data-currency="true" style="color: {{ $balance >= 0 ? 'var(--text-main)' : 'var(--danger)' }};">₱0</div>
                    <div class="stat-trend">
                        <span class="{{ $balance >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas fa-arrow-{{ $balance >= 0 ? 'up' : 'down' }}"></i> {{ $balance >= 0 ? __('Surplus') : __('Deficit') }}
                        </span>
                    </div>
                </div>
            </div>
        </div></div>

    {{-- 1B. MORE STATS --}}
    <style>
        .dx-card { display:flex; align-items:center; gap:14px; padding:16px; border-radius:16px; background:var(--card-bg, #fff); border:1px solid var(--border-color, #E3E8F5); text-decoration:none; color:inherit; transition:transform .18s ease, box-shadow .18s ease; height:100%; }
        .dx-card:hover { transform:translateY(-3px); box-shadow:0 12px 28px rgba(18,28,90,.12); color:inherit; }
        .dx-ico { width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
        .dx-ico.c1 { background:rgba(49,87,213,.12); color:#3157D5; }
        .dx-ico.c2 { background:rgba(239,68,68,.12); color:#EF4444; }
        .dx-ico.c3 { background:rgba(18,196,222,.15); color:#0BA5BD; }
        .dx-ico.c4 { background:rgba(245,158,11,.15); color:#D97706; }
        .dx-ico.c5 { background:rgba(236,72,153,.12); color:#DB2777; }
        .dx-ico.c6 { background:rgba(16,185,129,.14); color:#059669; }
        .dx-num { font-size:1.5rem; font-weight:800; line-height:1.1; }
        .dx-lbl { font-size:.74rem; font-weight:600; opacity:.7; text-transform:uppercase; letter-spacing:.5px; }
        .dx-quick { display:grid; grid-template-columns:repeat(auto-fit, minmax(140px, 1fr)); gap:10px; }
        .dx-quick a { display:flex; flex-direction:column; align-items:center; gap:8px; padding:16px 10px; border-radius:14px; border:1px dashed var(--border-color, #E3E8F5); text-decoration:none; color:inherit; font-weight:600; font-size:.84rem; transition:all .18s ease; }
        .dx-quick a i { font-size:1.2rem; color:#3157D5; }
        .dx-quick a:hover { background:rgba(49,87,213,.08); border-style:solid; transform:translateY(-2px); color:inherit; }
        .dx-bar { height:10px; border-radius:6px; background:rgba(127,140,200,.18); overflow:hidden; }
        .dx-bar > span { display:block; height:100%; border-radius:6px; }
    </style>
    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('members.index') }}" class="dx-card">
                <div class="dx-ico c1"><i class="fas fa-user-plus"></i></div>
                <div><div class="dx-num">{{ $newMembers ?? 0 }}</div><div class="dx-lbl">{{ __('New this month') }}</div></div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('messages.index') }}" class="dx-card">
                <div class="dx-ico c2"><i class="fas fa-envelope"></i></div>
                <div><div class="dx-num">{{ $unreadMessages ?? 0 }}</div><div class="dx-lbl">{{ __('Unread messages') }}</div></div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('inventory.index') }}" class="dx-card">
                <div class="dx-ico c3"><i class="fas fa-boxes-stacked"></i></div>
                <div><div class="dx-num">{{ $inventoryCount ?? 0 }}</div><div class="dx-lbl">{{ __('Inventory items') }}</div></div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('inventory.index') }}" class="dx-card">
                <div class="dx-ico c4"><i class="fas fa-triangle-exclamation"></i></div>
                <div><div class="dx-num">{{ $lowStock ?? 0 }}</div><div class="dx-lbl">{{ __('Low stock') }}</div></div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('members.index') }}" class="dx-card">
                <div class="dx-ico c5"><i class="fas fa-cake-candles"></i></div>
                <div><div class="dx-num">{{ $birthdaysMonth ?? 0 }}</div><div class="dx-lbl">{{ __('Birthdays this month') }}</div></div>
            </a>
        </div>
        <div class="col-6 col-md-4 col-xl-2">
            <a href="{{ route('members.index') }}" class="dx-card">
                <div class="dx-ico c6"><i class="fas fa-shield-halved"></i></div>
                <div><div class="dx-num">{{ $rolesCount ?? 0 }}</div><div class="dx-lbl">{{ __('Ministries / roles') }}</div></div>
            </a>
        </div>
    </div>

    {{-- 1C. QUICK ACTIONS + THIS MONTH --}}
    @php
        $mi = (float) ($monthIncome ?? 0);
        $me = (float) ($monthExpense ?? 0);
        $mt = max($mi + $me, 1);
        $incPct = round($mi / $mt * 100);
        $expPct = 100 - $incPct;
    @endphp
    <div class="row g-3 mb-4">
        <div class="col-lg-7">
            <div class="panel h-100">
                <div class="panel-head"><i class="fas fa-bolt"></i> <span>{{ __('Quick Actions') }}</span></div>
                <div class="panel-body">
                    <div class="dx-quick">
                        <a href="{{ route('members.create') }}"><i class="fas fa-user-plus"></i>{{ __('Add Member') }}</a>
                        <a href="{{ route('finance.index') }}"><i class="fas fa-money-bill-wave"></i>{{ __('Finance') }}</a>
                        <a href="{{ route('inventory.index') }}"><i class="fas fa-boxes-stacked"></i>{{ __('Inventory') }}</a>
                        <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i>{{ __('Messages') }}</a>
                        <a href="{{ route('reports.analytics') }}"><i class="fas fa-chart-line"></i>{{ __('Reports') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="panel h-100">
                <div class="panel-head"><i class="fas fa-calendar-day"></i> <span>{{ __('This Month') }} · {{ now()->format('F') }}</span></div>
                <div class="panel-body">
                    <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;font-weight:600;">
                        <span>{{ __('Income') }}</span><span>₱{{ number_format($mi) }}</span>
                    </div>
                    <div class="dx-bar mb-3"><span style="width:{{ $incPct }}%;background:#10B981;"></span></div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;font-weight:600;">
                        <span>{{ __('Expenses') }}</span><span>₱{{ number_format($me) }}</span>
                    </div>
                    <div class="dx-bar mb-3"><span style="width:{{ $expPct }}%;background:#EF4444;"></span></div>
                    <div class="d-flex justify-content-between pt-2" style="border-top:1px solid var(--border-color,#E3E8F5);font-weight:800;">
                        <span>{{ __('Net') }}</span>
                        <span style="color:{{ ($mi - $me) >= 0 ? '#059669' : '#EF4444' }};">₱{{ number_format($mi - $me) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. INCOME PANEL --}}
    <div class="panel mb-4">
        <div class="row g-0 align-items-stretch">
            <div class="col-lg-3">
                <div class="income-summary">
                    <div class="lead-label">{{ __('Income, last 6 months') }}</div>
                    <div>
                        <div class="big-number"><span class="cur">₱</span>{{ number_format($totalIncome) }}</div>
                        <div class="stat-trend mt-1">{{ __('Expenses') }}: ₱{{ number_format($totalExpense) }}</div>
                    </div>
                    <div>
                        <a href="{{ route('finance.index') }}" class="btn-ghost">{{ __('Open finance') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="income-chart">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. TRANSACTIONS + DEMOGRAPHICS --}}
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-lg-7">
            <div class="panel h-100">
                <div class="panel-head">
                    <i class="fas fa-receipt"></i> {{ __('Recent Transactions') }}
                    <a href="{{ route('finance.index') }}" class="ms-auto" style="font-size: 0.78rem; font-weight: 700;">{{ __('View all') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Description') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Date') }}</th>
                                <th class="d-none d-md-table-cell">{{ __('Type') }}</th>
                                <th class="text-end">{{ __('Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities ?? [] as $item)
                                @php $isIncome = ($item->type ?? 'expense') === 'income'; @endphp
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $item->description ?? 'Transaction' }}
                                        <div class="d-md-none mt-1">
                                            <span class="pill {{ $isIncome ? 'pill-in' : 'pill-out' }}">{{ $isIncome ? __('Income') : __('Expense') }}</span>
                                            <span class="text-muted" style="font-size:.7rem; font-weight:500;">{{ \Carbon\Carbon::parse($item->date ?? $item->created_at)->format('M d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted d-none d-md-table-cell">{{ \Carbon\Carbon::parse($item->date ?? $item->created_at)->format('M d, Y') }}</td>
                                    <td class="d-none d-md-table-cell"><span class="pill {{ $isIncome ? 'pill-in' : 'pill-out' }}">{{ $isIncome ? __('Income') : __('Expense') }}</span></td>
                                    <td class="text-end {{ $isIncome ? 'amount-in' : 'amount-out' }}">
                                        {{ $isIncome ? '+' : '-' }}₱{{ number_format($item->amount ?? 0, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="empty-note">{{ __('No transactions found.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="panel h-100">
                <div class="panel-head"><i class="fas fa-chart-pie"></i> {{ __('Demographics') }}</div>
                <div class="panel-body">
                    <div class="donut-wrap">
                        <canvas id="doughnutChart"></canvas>
                        <div class="donut-center">
                            <div class="val">{{ $totalGender }}</div>
                            <div class="lbl">{{ __('Members') }}</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="legend-row"><span class="dot" style="background: var(--navy-chart, #3157D5);"></span> {{ __('Male') }} <span class="pct">{{ $malePerc }}% · {{ $male }}</span></div>
                        <div class="legend-row"><span class="dot" style="background: var(--primary);"></span> {{ __('Female') }} <span class="pct">{{ $femalePerc }}% · {{ $female }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. BIRTHDAYS --}}
    <div class="panel">
        <div class="panel-head"><i class="fas fa-cake-candles"></i> {{ __('Upcoming Birthdays') }}</div>
        <div class="panel-body">
            @if(!empty($upcomingBirthdays) && count($upcomingBirthdays))
                <div class="row g-2 g-md-3">
                    @foreach($upcomingBirthdays as $bd)
                        <div class="col-6 col-xl-3">
                            <div class="bday">
                                <div class="bday-avatar">{{ strtoupper(substr($bd->first_name ?? 'M', 0, 1)) }}</div>
                                <div>
                                    <p class="bday-name">{{ $bd->first_name }} {{ $bd->last_name }}</p>
                                    <p class="bday-date">{{ \Carbon\Carbon::parse($bd->birthday)->format('F d') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-note">{{ __('No upcoming birthdays.') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1. COUNT-UP
    document.querySelectorAll('.count-up').forEach(function (el) {
        var target = +el.getAttribute('data-target') || 0;
        var isCur  = el.hasAttribute('data-currency');
        var fmt = function (n) { return (isCur ? '₱' : '') + Math.round(n).toLocaleString(); };
        var duration = 900, start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / duration, 1);
            el.innerText = fmt(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });

    if (typeof Chart === 'undefined') return;

    // 2. THEME-AWARE COLORS
    function colors() {
        var dark = document.documentElement.getAttribute('data-theme') === 'dark';
        return {
            line:   dark ? '#7C9BFF' : '#3157D5',
            cyan:   dark ? '#22D3EE' : '#12C4DE',
            grid:   dark ? 'rgba(255,255,255,0.07)' : '#E8ECF5',
            text:   dark ? '#A3ACD3' : '#6B7499',
            tipBg:  dark ? '#070C2E' : '#0C1445'
        };
    }
    var C = colors();
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = C.text;

    // 3. INCOME / EXPENSE LINE CHART
    var monthlyData = @json($monthlyData);
    var labels      = monthlyData.map(function (m) { return m.month; });
    var incomeData  = monthlyData.map(function (m) { return parseFloat(m.income)  || 0; });
    var expenseData = monthlyData.map(function (m) { return parseFloat(m.expense) || 0; });

    var ctx = document.getElementById('mainChart').getContext('2d');
    function fillGradient(hex) {
        var g = ctx.createLinearGradient(0, 0, 0, 300);
        g.addColorStop(0, hex + '33');
        g.addColorStop(1, hex + '00');
        return g;
    }

    var mainChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length ? labels : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Income',
                    data: incomeData.length ? incomeData : [0,0,0,0,0,0],
                    borderColor: C.line,
                    backgroundColor: fillGradient(C.line),
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: C.line,
                    pointHoverBorderWidth: 2
                },
                {
                    label: 'Expense',
                    data: expenseData.length ? expenseData : [0,0,0,0,0,0],
                    borderColor: C.cyan,
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 4],
                    tension: 0.35,
                    fill: false,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: C.cyan,
                    pointHoverBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: 'easeOutQuart' },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: true, position: 'top', align: 'end', labels: { usePointStyle: true, boxWidth: 8, boxHeight: 8, font: { size: 11, weight: 600 } } },
                tooltip: {
                    backgroundColor: C.tipBg,
                    titleColor: '#FFFFFF',
                    bodyColor: '#CFD6F5',
                    padding: 14,
                    cornerRadius: 6,
                    displayColors: true,
                    boxWidth: 8, boxHeight: 8, usePointStyle: true,
                    callbacks: {
                        label: function (c) { return ' ' + c.dataset.label + ': ₱' + c.parsed.y.toLocaleString(); }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11, weight: 600 } } },
                y: { grid: { color: C.grid, borderDash: [4, 4] }, border: { display: false }, ticks: { font: { size: 11, weight: 600 }, callback: function (v) { return '₱' + v.toLocaleString(); } } }
            }
        }
    });

    // 4. DOUGHNUT
    var donut = new Chart(document.getElementById('doughnutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [{{ $male }}, {{ $female }}],
                backgroundColor: [C.line, C.cyan],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            animation: { animateScale: true, animateRotate: true, duration: 1200 },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: C.tipBg, titleColor: '#fff', bodyColor: '#CFD6F5',
                    padding: 10, cornerRadius: 6,
                    callbacks: { label: function (c) { return ' ' + c.label + ': ' + c.parsed; } }
                }
            }
        }
    });

    // 4b. MOBILE ADJUSTMENTS
    var mq = window.matchMedia('(max-width: 767px)');

    function compact(v) {
        if (v >= 1000000) return '₱' + (v / 1000000).toFixed(1).replace('.0', '') + 'M';
        if (v >= 1000)    return '₱' + (v / 1000).toFixed(1).replace('.0', '') + 'k';
        return '₱' + v;
    }

    function applyResponsive() {
        var m = mq.matches;
        var o = mainChart.options;

        o.plugins.legend.align = m ? 'start' : 'end';
        o.plugins.legend.labels.font.size = m ? 10 : 11;
        o.plugins.tooltip.padding = m ? 10 : 14;
        o.plugins.tooltip.titleFont = { size: m ? 11 : 13 };
        o.plugins.tooltip.bodyFont  = { size: m ? 11 : 13 };

        o.scales.x.ticks.font.size     = m ? 10 : 11;
        o.scales.x.ticks.maxRotation   = 0;
        o.scales.x.ticks.autoSkip      = true;
        o.scales.x.ticks.maxTicksLimit = m ? 6 : 12;

        o.scales.y.ticks.font.size     = m ? 10 : 11;
        o.scales.y.ticks.maxTicksLimit = m ? 5 : 8;
        o.scales.y.ticks.callback = function (v) { return m ? compact(v) : '₱' + v.toLocaleString(); };

        o.layout = { padding: m ? { left: 0, right: 4, top: 0, bottom: 0 } : 0 };

        mainChart.data.datasets.forEach(function (d) {
            d.borderWidth = m ? 1.5 : 2;
            d.pointHoverRadius = m ? 4 : 5;
        });
        mainChart.update('none');
        mainChart.resize();

        donut.options.cutout = m ? '68%' : '72%';
        donut.update('none');
        donut.resize();
    }

    applyResponsive();
    if (mq.addEventListener) mq.addEventListener('change', applyResponsive);
    else mq.addListener(applyResponsive);

    window.addEventListener('orientationchange', function () {
        setTimeout(function () { mainChart.resize(); donut.resize(); }, 250);
    });

    // 5. RE-COLOR WHEN THEME TOGGLES
    window.addEventListener('themechanged', function () {
        var N = colors();
        Chart.defaults.color = N.text;

        var inc = mainChart.data.datasets[0], exp = mainChart.data.datasets[1];
        inc.borderColor = N.line; inc.backgroundColor = fillGradient(N.line); inc.pointHoverBorderColor = N.line;
        exp.borderColor = N.cyan; exp.pointHoverBorderColor = N.cyan;
        mainChart.options.scales.y.grid.color = N.grid;
        mainChart.options.plugins.tooltip.backgroundColor = N.tipBg;
        mainChart.options.plugins.legend.labels.color = N.text;
        mainChart.options.scales.x.ticks.color = N.text;
        mainChart.options.scales.y.ticks.color = N.text;
        mainChart.update('none');

        donut.data.datasets[0].backgroundColor = [N.line, N.cyan];
        donut.options.plugins.tooltip.backgroundColor = N.tipBg;
        donut.update('none');

        document.querySelectorAll('.legend-row .dot')[0].style.background = N.line;
    });

    // initial legend dot color
    var dots = document.querySelectorAll('.legend-row .dot');
    if (dots[0]) dots[0].style.background = C.line;
});
</script>
@endpush