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
    $totalIncome = collect($monthlyData)->sum(fn ($m) => (float) (is_array($m) ? ($m['income'] ?? 0) : ($m->income ?? 0)));
    $totalExpense = collect($monthlyData)->sum(fn ($m) => (float) (is_array($m) ? ($m['expense'] ?? 0) : ($m->expense ?? 0)));

    $male        = (int) ($maleCount ?? 0);
    $female      = (int) ($femaleCount ?? 0);
    $totalGender = $male + $female;
    $malePerc    = $totalGender > 0 ? round(($male / $totalGender) * 100) : 0;
    $femalePerc  = $totalGender > 0 ? 100 - $malePerc : 0;

    $balance = (float) ($monthlyBalance ?? 0);
    $mi = (float) ($monthIncome ?? 0);
    $me = (float) ($monthExpense ?? 0);
    $mt = max($mi + $me, 1);
    $incPct = round($mi / $mt * 100);
    $expPct = 100 - $incPct;

    $kpis = [
        ['fa-users',            'k1', __('Total Members'),        $totalMembers ?? 0,   route('members.index'),   false],
        ['fa-wallet',           'k2', $balance >= 0 ? __('Balance · Surplus') : __('Balance · Deficit'), abs($balance), route('finance.index'), true],
        ['fa-user-plus',        'k3', __('New this month'),       $newMembers ?? 0,     route('members.index'),   false],
        ['fa-envelope',         'k4', __('Unread messages'),      $unreadMessages ?? 0, route('messages.index'),  false],
        ['fa-boxes-stacked',    'k5', __('Inventory items'),      $inventoryCount ?? 0, route('inventory.index'), false],
        ['fa-triangle-exclamation','k6', __('Low stock'),         $lowStock ?? 0,       route('inventory.index'), false],
        ['fa-cake-candles',     'k7', __('Birthdays this month'), $birthdaysMonth ?? 0, route('members.index'),   false],
        ['fa-shield-halved',    'k8', __('Ministries / roles'),   $rolesCount ?? 0,     route('members.index'),   false],
    ];
@endphp

<style>
    .dz { max-width: 1600px; margin: 0 auto; display: flex; flex-direction: column; gap: 18px; }
    .dz *, .dz *::before, .dz *::after { box-sizing: border-box; }

    /* HERO */
    .dz-hero { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; padding: 22px 26px; border-radius: 20px; color: #fff; background: linear-gradient(120deg, #121C5A 0%, #3157D5 70%, #12C4DE 140%); box-shadow: 0 14px 34px rgba(18,28,90,.22); }
    .dz-hero h3 { margin: 0; font-size: 1.25rem; font-weight: 800; }
    .dz-hero p { margin: 4px 0 0; font-size: .82rem; opacity: .8; }
    .dz-hero-actions { display: flex; flex-wrap: wrap; gap: 8px; }
    .dz-hero-actions a { display: inline-flex; align-items: center; gap: 8px; padding: 9px 14px; border-radius: 999px; font-size: .8rem; font-weight: 700; color: #fff; text-decoration: none; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.22); transition: background .15s ease, transform .15s ease; }
    .dz-hero-actions a:hover { background: rgba(255,255,255,.26); transform: translateY(-2px); color: #fff; }

    /* KPI */
    .dz-kpis { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
    .dz-kpi { display: flex; align-items: center; gap: 14px; padding: 18px; border-radius: 18px; text-decoration: none; color: inherit; background: var(--card-bg, #fff); border: 1px solid var(--border-color, #E3E8F5); transition: transform .18s ease, box-shadow .18s ease; min-width: 0; }
    .dz-kpi:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(18,28,90,.12); color: inherit; }
    .dz-ico { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .k1 { background: rgba(49,87,213,.12); color: #3157D5; }
    .k2 { background: rgba(16,185,129,.14); color: #059669; }
    .k3 { background: rgba(14,165,233,.14); color: #0284C7; }
    .k4 { background: rgba(239,68,68,.12); color: #EF4444; }
    .k5 { background: rgba(18,196,222,.15); color: #0BA5BD; }
    .k6 { background: rgba(245,158,11,.15); color: #D97706; }
    .k7 { background: rgba(236,72,153,.12); color: #DB2777; }
    .k8 { background: rgba(124,58,237,.12); color: #7C3AED; }
    .dz-num { font-size: 1.55rem; font-weight: 800; line-height: 1.1; white-space: nowrap; }
    .dz-lbl { font-size: .7rem; font-weight: 700; opacity: .65; text-transform: uppercase; letter-spacing: .5px; margin-top: 2px; }

    /* GRID */
    .dz-grid { display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 16px; align-items: stretch; }
    .dz-card { display: flex; flex-direction: column; border-radius: 18px; background: var(--card-bg, #fff); border: 1px solid var(--border-color, #E3E8F5); overflow: hidden; min-width: 0; }
    .dz-head { display: flex; align-items: center; gap: 10px; padding: 16px 20px; font-size: .9rem; font-weight: 800; border-bottom: 1px solid var(--border-color, #E3E8F5); }
    .dz-head i { color: #3157D5; }
    .dz-head a { margin-left: auto; font-size: .75rem; font-weight: 700; text-decoration: none; }
    .dz-body { padding: 18px 20px; flex: 1; }
    .dz-stack { display: flex; flex-direction: column; gap: 16px; min-width: 0; }

    .dz-chart { position: relative; height: 300px; }
    .dz-chart-meta { display: flex; flex-wrap: wrap; gap: 24px; margin-bottom: 8px; }
    .dz-chart-meta b { display: block; font-size: 1.3rem; font-weight: 800; }
    .dz-chart-meta span { font-size: .72rem; font-weight: 700; opacity: .6; text-transform: uppercase; letter-spacing: .5px; }

    .donut-wrap { position: relative; height: 210px; }
    .donut-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; pointer-events: none; }
    .donut-center .val { font-size: 1.8rem; font-weight: 800; line-height: 1; }
    .donut-center .lbl { font-size: .72rem; font-weight: 600; opacity: .6; margin-top: 4px; }
    .legend-row { display: flex; align-items: center; gap: 10px; padding: 7px 0; font-size: .84rem; font-weight: 600; }
    .legend-row .dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
    .legend-row .pct { margin-left: auto; opacity: .6; }

    .dz-bar { height: 9px; border-radius: 6px; background: rgba(127,140,200,.18); overflow: hidden; }
    .dz-bar > span { display: block; height: 100%; border-radius: 6px; }
    .dz-row { display: flex; justify-content: space-between; margin-bottom: 6px; font-size: .84rem; font-weight: 700; }

    .pill { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: .68rem; font-weight: 700; }
    .pill-in { background: rgba(34,197,94,.12); color: #16A34A; }
    .pill-out { background: rgba(239,68,68,.1); color: #DC2626; }
    .amount-in { color: #16A34A; font-weight: 700; }
    .amount-out { color: #DC2626; font-weight: 700; }

    .bday { display: flex; align-items: center; gap: 12px; padding: 10px 0; }
    .bday + .bday { border-top: 1px dashed var(--border-color, #E3E8F5); }
    .bday-avatar { width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(49,87,213,.12); color: #3157D5; font-weight: 800; font-size: .85rem; }
    .bday-name { margin: 0; font-size: .84rem; font-weight: 700; line-height: 1.3; }
    .bday-date { margin: 0; font-size: .74rem; opacity: .6; }
    .empty-note { padding: 26px 0; text-align: center; opacity: .6; font-size: .85rem; }

    @media (max-width: 991px) {
        .dz-kpis { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dz-grid { grid-template-columns: minmax(0, 1fr); }
    }
    @media (max-width: 575px) {
        .dz { gap: 14px; }
        .dz-hero { padding: 18px; border-radius: 16px; }
        .dz-hero-actions a span { display: none; }
        .dz-hero-actions a { padding: 10px 13px; }
        .dz-kpis { gap: 10px; }
        .dz-kpi { padding: 12px; gap: 10px; border-radius: 14px; }
        .dz-ico { width: 38px; height: 38px; font-size: .95rem; border-radius: 11px; }
        .dz-num { font-size: 1.2rem; }
        .dz-lbl { font-size: .6rem; }
        .dz-chart { height: 240px; }
        .dz-body { padding: 14px; }
        .dz-head { padding: 14px; }
    }
</style>

<div class="dz">

    {{-- HERO + QUICK ACTIONS --}}
    <div class="dz-hero">
        <div>
            <h3>{{ __('Welcome back') }}, {{ \Illuminate\Support\Str::of(Auth::user()->name ?? '')->before(' ') }}</h3>
            <p><i class="fas fa-calendar-day me-1"></i> {{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="dz-hero-actions">
            <a href="{{ route('members.create') }}"><i class="fas fa-user-plus"></i><span>{{ __('Add Member') }}</span></a>
            <a href="{{ route('finance.index') }}"><i class="fas fa-money-bill-wave"></i><span>{{ __('Finance') }}</span></a>
            <a href="{{ route('inventory.index') }}"><i class="fas fa-boxes-stacked"></i><span>{{ __('Inventory') }}</span></a>
            <a href="{{ route('messages.index') }}"><i class="fas fa-envelope"></i><span>{{ __('Messages') }}</span></a>
            <a href="{{ route('reports.analytics') }}"><i class="fas fa-chart-line"></i><span>{{ __('Reports') }}</span></a>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="dz-kpis">
        @foreach($kpis as [$icon, $cls, $label, $value, $url, $cur])
            <a href="{{ $url }}" class="dz-kpi">
                <div class="dz-ico {{ $cls }}"><i class="fas {{ $icon }}"></i></div>
                <div style="min-width:0;">
                    <div class="dz-num count-up" data-target="{{ $value }}" @if($cur) data-currency="true" @endif @if($cur && $balance < 0) style="color:#EF4444;" @endif>{{ $cur ? '₱0' : '0' }}</div>
                    <div class="dz-lbl">{{ $label }}</div>
                </div>
            </a>
        @endforeach
    </div>

    {{-- INCOME CHART + DEMOGRAPHICS --}}
    <div class="dz-grid">
        <div class="dz-card">
            <div class="dz-head"><i class="fas fa-chart-area"></i> {{ __('Income, last 6 months') }}
                <a href="{{ route('finance.index') }}">{{ __('Open finance') }}</a>
            </div>
            <div class="dz-body">
                <div class="dz-chart-meta">
                    <div><b>₱{{ number_format($totalIncome) }}</b><span>{{ __('Income') }}</span></div>
                    <div><b>₱{{ number_format($totalExpense) }}</b><span>{{ __('Expenses') }}</span></div>
                </div>
                <div class="dz-chart"><canvas id="mainChart"></canvas></div>
            </div>
        </div>

        <div class="dz-card">
            <div class="dz-head"><i class="fas fa-chart-pie"></i> {{ __('Demographics') }}</div>
            <div class="dz-body">
                <div class="donut-wrap">
                    <canvas id="doughnutChart"></canvas>
                    <div class="donut-center">
                        <div class="val">{{ $totalGender }}</div>
                        <div class="lbl">{{ __('Members') }}</div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="legend-row"><span class="dot" style="background:#3157D5;"></span> {{ __('Male') }} <span class="pct">{{ $malePerc }}% · {{ $male }}</span></div>
                    <div class="legend-row"><span class="dot" style="background:#12C4DE;"></span> {{ __('Female') }} <span class="pct">{{ $femalePerc }}% · {{ $female }}</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- TRANSACTIONS + THIS MONTH / BIRTHDAYS --}}
    <div class="dz-grid">
        <div class="dz-card">
            <div class="dz-head"><i class="fas fa-receipt"></i> {{ __('Recent Transactions') }}
                <a href="{{ route('finance.index') }}">{{ __('View all') }}</a>
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
                                        <span style="font-size:.7rem;opacity:.6;">{{ \Carbon\Carbon::parse($item->date ?? $item->created_at)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell" style="opacity:.7;">{{ \Carbon\Carbon::parse($item->date ?? $item->created_at)->format('M d, Y') }}</td>
                                <td class="d-none d-md-table-cell"><span class="pill {{ $isIncome ? 'pill-in' : 'pill-out' }}">{{ $isIncome ? __('Income') : __('Expense') }}</span></td>
                                <td class="text-end {{ $isIncome ? 'amount-in' : 'amount-out' }}">{{ $isIncome ? '+' : '-' }}₱{{ number_format($item->amount ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-note">{{ __('No transactions found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dz-stack">
            <div class="dz-card">
                <div class="dz-head"><i class="fas fa-calendar-day"></i> {{ __('This Month') }} · {{ now()->format('F') }}</div>
                <div class="dz-body">
                    <div class="dz-row"><span>{{ __('Income') }}</span><span>₱{{ number_format($mi) }}</span></div>
                    <div class="dz-bar mb-3"><span style="width:{{ $incPct }}%;background:#10B981;"></span></div>
                    <div class="dz-row"><span>{{ __('Expenses') }}</span><span>₱{{ number_format($me) }}</span></div>
                    <div class="dz-bar mb-3"><span style="width:{{ $expPct }}%;background:#EF4444;"></span></div>
                    <div class="dz-row pt-2" style="border-top:1px solid var(--border-color,#E3E8F5);font-weight:800;margin:0;">
                        <span>{{ __('Net') }}</span>
                        <span style="color:{{ ($mi - $me) >= 0 ? '#059669' : '#EF4444' }};">₱{{ number_format($mi - $me) }}</span>
                    </div>
                </div>
            </div>

            <div class="dz-card" style="flex:1;">
                <div class="dz-head"><i class="fas fa-cake-candles"></i> {{ __('Upcoming Birthdays') }}</div>
                <div class="dz-body">
                    @forelse($upcomingBirthdays ?? [] as $bd)
                        <div class="bday">
                            <div class="bday-avatar">{{ strtoupper(substr($bd->first_name ?? 'M', 0, 1)) }}</div>
                            <div>
                                <p class="bday-name">{{ $bd->first_name }} {{ $bd->last_name }}</p>
                                <p class="bday-date">{{ \Carbon\Carbon::parse($bd->birthday)->format('F d') }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="empty-note">{{ __('No upcoming birthdays.') }}</div>
                    @endforelse
                </div>
            </div>
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