@extends('layouts.app')

@section('header', 'Finance')
@section('subheader', __('Track income, expenses, and financial health across all churches'))

@push('styles')
    @include('finance._styles')
@endpush

@section('content')
@php
    $peso    = "\u{20B1}";
    $overall = $overallBalance ?? 0;
    $isSurplus = $overall >= 0;

    // [icon, icon colour, i18n key, label, value, trend icon, trend text, trend class]
    $stats = [
        ['fa-arrow-down',    'green', 'total_income',    __('Total Income'),    $peso . number_format($totalIncome ?? 0, 2),  'fa-building', __('All churches'), ''],
        ['fa-arrow-up',      'red',   'total_expenses',  __('Total Expenses'),  $peso . number_format($totalExpense ?? 0, 2), 'fa-building', __('All churches'), ''],
        ['fa-scale-balanced', '',     'overall_balance', __('Overall Balance'), $peso . number_format(abs($overall), 2),      $isSurplus ? 'fa-arrow-up' : 'fa-arrow-down', $isSurplus ? __('Surplus') : __('Deficit'), $isSurplus ? 'trend-up' : 'trend-down'],
        ['fa-church',        '',      'churches',        __('Churches'),        $churches->count(),                           'fa-link', __('Connected churches'), ''],
    ];
@endphp

{{-- ACTIONS --}}
@if(Route::has('finance.create'))
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('finance.create') }}" class="btn-cyan">
            <i class="fas fa-plus"></i>
            <span data-i18n="add_record">{{ __("Add Record") }}</span>
        </a>
    </div>
@endif

{{-- STATS --}}
<div class="row g-3 mb-4">
    @foreach($stats as [$icon, $color, $key, $label, $value, $tIcon, $tText, $tClass])
        <div class="col-6 col-xl-3">
            <div class="stat-card f-stat h-100">
                <div class="stat-icon {{ $color }}"><i class="fas {{ $icon }}"></i></div>
                <div style="min-width:0;">
                    <div class="stat-label" data-i18n="{{ $key }}">{{ $label }}</div>
                    <div class="stat-value">{{ $value }}</div>
                    <div class="stat-trend {{ $tClass }}"><i class="fas {{ $tIcon }}"></i> {{ $tText }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- CHURCH FILTER --}}
<div class="panel mb-4">
    <div class="panel-body d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div style="flex:1 1 260px;">
            <label for="churchSelect" class="form-label" data-i18n="select_church">{{ __("Select Church") }}</label>
            <select id="churchSelect" class="form-select" onchange="window.location.href=this.value">
                <option value="{{ route('finance.index', ['church' => 'all']) }}">{{ __("All Churches") }}</option>
                @foreach($churches as $church)
                    <option value="{{ route('finance.index', ['church' => $church->id]) }}"
                        {{ ($selectedChurchId ?? '') == $church->id ? 'selected' : '' }}>
                        {{ $church->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <span class="f-pill">
            <i class="fas fa-building"></i>
            @if($selectedChurch)
                <span data-i18n="viewing">{{ __("Viewing:") }}</span> <strong>{{ $selectedChurch->name }}</strong>
            @else
                <span data-i18n="all_churches_label">{{ __("All Churches") }}</span>
            @endif
        </span>
    </div>
</div>

@if($selectedChurch)
    {{-- SELECTED CHURCH --}}
    @php $churchBal = $churchBalance ?? 0; @endphp
    <div class="panel mb-4">
        <div class="panel-head flex-wrap">
            <i class="fas fa-church"></i>
            {{ $selectedChurch->name }}
            <span class="f-pill ms-auto"><i class="fas fa-calendar-alt"></i> {{ now()->format('F d, Y') }}</span>
        </div>
        <div class="panel-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="f-mini">
                        <div class="f-mini-label">{{ __("Total Income") }}</div>
                        <div class="f-mini-value f-income">{{ $peso }}{{ number_format($churchIncome ?? 0, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="f-mini">
                        <div class="f-mini-label">{{ __("Total Expenses") }}</div>
                        <div class="f-mini-value f-expense">{{ $peso }}{{ number_format($churchExpenses ?? 0, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="f-mini">
                        <div class="f-mini-label">{{ __("Balance") }}</div>
                        <div class="f-mini-value {{ $churchBal >= 0 ? 'f-income' : 'f-expense' }}">{{ $peso }}{{ number_format(abs($churchBal), 2) }}</div>
                        <div class="stat-trend {{ $churchBal >= 0 ? 'trend-up' : 'trend-down' }}">
                            <i class="fas {{ $churchBal >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ $churchBal >= 0 ? __("Surplus") : __("Deficit") }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-1 pt-3" style="border-top:1px solid var(--border-color);">
                <div class="col-md-6">
                    <div class="f-subtitle">{{ __("Income Categories") }}</div>
                    <div class="f-tags">
                        @forelse($incomeTypes ?? [] as $type)
                            <span class="f-pill income">{{ $type->category ?? __("Uncategorized") }}: {{ $peso }}{{ number_format($type->total, 2) }}</span>
                        @empty
                            <span class="text-muted" style="font-size:.8rem;">{{ __("No income categories") }}</span>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="f-subtitle">{{ __("Expense Categories") }}</div>
                    <div class="f-tags">
                        @forelse($expenseTypes ?? [] as $type)
                            <span class="f-pill expense">{{ $type->category ?? __("Uncategorized") }}: {{ $peso }}{{ number_format($type->total, 2) }}</span>
                        @empty
                            <span class="text-muted" style="font-size:.8rem;">{{ __("No expense categories") }}</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- ALL CHURCHES --}}
    <div class="row g-3 mb-4">
        @forelse($churchBalances ?? [] as $data)
            @php $isUp = $data['status'] == 'surplus'; @endphp
            <div class="col-md-6 col-xl-4">
                <div class="panel h-100">
                    <div class="panel-body">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div class="f-church-name"><i class="fas fa-church"></i> {{ $data['church']->name }}</div>
                            <span class="f-pill {{ $isUp ? 'income' : 'expense' }}">{{ $isUp ? __("Surplus") : __("Deficit") }}</span>
                        </div>

                        <div class="f-church-balance {{ $isUp ? 'f-income' : 'f-expense' }}">
                            {{ $peso }}{{ number_format(abs($data['balance']), 2) }}
                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="f-pill"><i class="fas fa-arrow-down f-income"></i> {{ $peso }}{{ number_format($data['income'], 2) }}</span>
                            <span class="f-pill"><i class="fas fa-arrow-up f-expense"></i> {{ $peso }}{{ number_format($data['expense'], 2) }}</span>
                        </div>

                        <a href="{{ route('finance.index', ['church' => $data['church']->id]) }}" class="btn-ghost">
                            <i class="fas fa-eye"></i> {{ __("View Details") }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="panel">
                    <div class="f-empty">
                        <i class="fas fa-church"></i>
                        <h5>{{ __("No churches found") }}</h5>
                        <p>{{ __("Add churches to start tracking finances.") }}</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endif

{{-- CHART --}}
<div class="panel">
    <div class="panel-head flex-wrap">
        <i class="fas fa-chart-line"></i>
        {{ __("Monthly Income vs Expenses") }}
        <span class="text-muted fw-normal">&middot; {{ $selectedChurch->name ?? __("All Churches") }}</span>
        <span class="f-pill ms-auto"><i class="fas fa-clock"></i> {{ __("Last 6 months") }}</span>
    </div>
    <div class="panel-body">
        <div class="f-legend">
            <span><i class="income"></i> {{ __("Income") }}</span>
            <span><i class="expense"></i> {{ __("Expenses") }}</span>
        </div>
        <div class="f-chart"><canvas id="financeChart"></canvas></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function () {
    'use strict';

    var RAW = @json($monthlyData ?? []);
    var chart = null;

    function css(name) {
        return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
    }

    function fallbackMonths() {
        var out = [], d = new Date();
        for (var i = 5; i >= 0; i--) {
            var m = new Date(d.getFullYear(), d.getMonth() - i, 1);
            out.push({ month: m.toLocaleString('en', { month: 'short' }), income: 0, expense: 0 });
        }
        return out;
    }

    function build() {
        var canvas = document.getElementById('financeChart');
        if (!canvas || !window.Chart) return;

        var rows = Array.isArray(RAW) && RAW.length ? RAW : fallbackMonths();
        var peso = '\u20B1';
        var grid = css('--border-color'), tick = css('--text-muted');

        if (chart) chart.destroy();

        function line(label, key, color, dashed) {
            return {
                label: label,
                data: rows.map(function (r) { return parseFloat(r[key]) || 0; }),
                borderColor: color,
                backgroundColor: color + '14',
                borderWidth: 2.5,
                borderDash: dashed ? [5, 4] : [],
                fill: true,
                tension: 0.4,
                pointRadius: 3,
                pointBackgroundColor: color,
                pointBorderColor: css('--bg-card'),
                pointBorderWidth: 2,
                pointHoverRadius: 5
            };
        }

        chart = new Chart(canvas, {
            type: 'line',
            data: {
                labels: rows.map(function (r) { return r.month; }),
                datasets: [
                    line('Income', 'income', '#22C55E', false),
                    line('Expenses', 'expense', '#EF4444', true)
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: css('--bg-card'),
                        titleColor: css('--text-main'),
                        bodyColor: tick,
                        borderColor: grid,
                        borderWidth: 1,
                        cornerRadius: 8,
                        padding: 10,
                        callbacks: {
                            label: function (ctx) { return ctx.dataset.label + ': ' + peso + ctx.parsed.y.toLocaleString(); }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: grid },
                        ticks: { color: tick, font: { size: 10 }, callback: function (v) { return peso + v.toLocaleString(); } }
                    },
                    x: { grid: { display: false }, ticks: { color: tick, font: { size: 10 } } }
                }
            }
        });
    }

    build();
    window.addEventListener('themechanged', build);   // fired by app-shell.js
})();
</script>
@endpush