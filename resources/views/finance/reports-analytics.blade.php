@extends('layouts.app')

@section('header', 'Reports & Analytics')
@section('subheader', __('Income, expenses and trends for your church'))

@push('styles')
    @include('finance._styles')
@endpush

@section('content')
@php
    $peso       = "\u{20B1}";
    $month      = request('month');
    $year       = request('year');
    $type       = request('type');
    $churchId   = session('current_church_id', auth()->user()->church_id);
    $churchName = auth()->user()->church->name ?? 'My Church';

    $base = \App\Models\MoneyTransaction::where('church_id', $churchId);

    // ---- filtered transactions (everything below uses these) ----
    $transactions = (clone $base)
        ->when($month, fn ($q) => $q->whereMonth('date', $month))
        ->when($year,  fn ($q) => $q->whereYear('date', $year))
        ->when($type,  fn ($q) => $q->where('type', $type))
        ->orderBy('date', 'desc')
        ->get();

    $incomeRows   = $transactions->where('type', 'income');
    $expenseRows  = $transactions->where('type', 'expense');
    $totalIncome  = $incomeRows->sum('amount');
    $totalExpense = $expenseRows->sum('amount');
    $balance      = $totalIncome - $totalExpense;

    $allTimeBalance = (clone $base)->where('type', 'income')->sum('amount')
                    - (clone $base)->where('type', 'expense')->sum('amount');

    $incomeByCategory  = $incomeRows->groupBy('category')->map->sum('amount')->sortDesc();
    $expenseByCategory = $expenseRows->groupBy('category')->map->sum('amount')->sortDesc();
    $topIncome         = $incomeRows->sortByDesc('amount')->take(5);
    $topExpense        = $expenseRows->sortByDesc('amount')->take(5);

    // ---- last 12 months chart (one query) ----
    $start   = now()->startOfMonth()->subMonths(11);
    $monthly = (clone $base)
        ->where('date', '>=', $start)
        ->selectRaw('YEAR(date) as y, MONTH(date) as m, type, SUM(amount) as total')
        ->groupBy('y', 'm', 'type')
        ->get();

    $months = $monthlyIncome = $monthlyExpense = [];
    for ($i = 0; $i < 12; $i++) {
        $d    = $start->copy()->addMonths($i);
        $rows = $monthly->where('y', $d->year)->where('m', $d->month);
        $months[]         = $d->format('M Y');
        $monthlyIncome[]  = (float) $rows->where('type', 'income')->sum('total');
        $monthlyExpense[] = (float) $rows->where('type', 'expense')->sum('total');
    }

    // ---- export rows ----
    $exportRows = $transactions->map(fn ($t) => [
        \Carbon\Carbon::parse($t->date)->toDateString(),
        $t->description,
        $t->category ?? '-',
        ucfirst($t->type),
        (float) $t->amount,
        $t->remarks ?? '-',
    ])->values();

    $isFiltered = $month || $year;
    $periodText = ($month ? date('F', mktime(0, 0, 0, $month, 1)) : __('All Months')) . ' ' . ($year ?: __('All Years'));

    $kpis = [
        ['fa-arrow-down',     'green', __('Total Income'),   $peso . number_format($totalIncome, 2),  $isFiltered ? __('Filtered Period') : __('All Time'), ''],
        ['fa-arrow-up',       'red',   __('Total Expenses'), $peso . number_format($totalExpense, 2), $isFiltered ? __('Filtered Period') : __('All Time'), ''],
        ['fa-scale-balanced', '',      __('Net Balance'),    ($balance >= 0 ? '+' : '-') . $peso . number_format(abs($balance), 2), $balance >= 0 ? __('Surplus') : __('Deficit'), $balance >= 0 ? 'trend-up' : 'trend-down'],
        ['fa-wallet',         '',      __('Church Balance'), $peso . number_format($allTimeBalance, 2), __('Lifetime Balance'), ''],
    ];
@endphp

{{-- ============ FILTERS ============ --}}
<form method="GET" action="{{ route('reports.analytics') }}" class="panel mb-4 no-print">
    <div class="panel-body d-flex flex-wrap align-items-end gap-3">
        <div style="flex:1 1 150px;">
            <label for="month" class="form-label" data-i18n="month">{{ __("Month") }}</label>
            <select id="month" name="month" class="form-select">
                <option value="">{{ __("All Months") }}</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                @endforeach
            </select>
        </div>
        <div style="flex:1 1 150px;">
            <label for="year" class="form-label" data-i18n="year">{{ __("Year") }}</label>
            <select id="year" name="year" class="form-select">
                <option value="">{{ __("All Years") }}</option>
                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div style="flex:1 1 150px;">
            <label for="type" class="form-label" data-i18n="type">{{ __("Type") }}</label>
            <select id="type" name="type" class="form-select">
                <option value="">{{ __("All Types") }}</option>
                <option value="income"  {{ $type == 'income'  ? 'selected' : '' }}>{{ __("Income Only") }}</option>
                <option value="expense" {{ $type == 'expense' ? 'selected' : '' }}>{{ __("Expense Only") }}</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn-cyan"><i class="fas fa-search"></i> {{ __("Apply") }}</button>
            <a href="{{ route('reports.analytics') }}" class="btn-ghost"><i class="fas fa-undo"></i> {{ __("Reset") }}</a>
            <button type="button" class="btn-ghost" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="fas fa-download"></i> {{ __("Export") }}
            </button>
        </div>
    </div>
</form>

{{-- ============ KPI CARDS ============ --}}
<div class="row g-3 mb-4" id="stats-section">
    @foreach($kpis as [$icon, $color, $label, $value, $sub, $subClass])
        <div class="col-6 col-xl-3">
            <div class="stat-card f-stat h-100">
                <div class="stat-icon {{ $color }}"><i class="fas {{ $icon }}"></i></div>
                <div style="min-width:0;">
                    <div class="stat-label">{{ $label }}</div>
                    <div class="stat-value">{{ $value }}</div>
                    <div class="stat-trend {{ $subClass }}">{{ $sub }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ============ TREND CHART ============ --}}
<div class="panel mb-4" id="chart-section">
    <div class="panel-head flex-wrap">
        <i class="fas fa-chart-line"></i>
        <span data-i18n="income_vs_expenses_trend">{{ __("Income vs Expenses Trend") }}</span>
        <span class="f-pill ms-auto"><i class="fas fa-clock"></i> {{ __("Last 12 Months") }}</span>
    </div>
    <div class="panel-body">
        <div class="f-legend">
            <span><i class="income"></i> {{ __("Income") }}</span>
            <span><i class="expense"></i> {{ __("Expenses") }}</span>
        </div>
        <div class="f-chart"><canvas id="financialChart"></canvas></div>
    </div>
</div>

{{-- ============ CATEGORY BREAKDOWN ============ --}}
<div class="row g-3 mb-4" id="category-section">
    @foreach([
        ['income',  __('Income by Category'),  'fa-arrow-down', $incomeByCategory,  $totalIncome,  __('No income records found')],
        ['expense', __('Expense by Category'), 'fa-arrow-up',   $expenseByCategory, $totalExpense, __('No expense records found')],
    ] as [$kind, $title, $icon, $list, $total, $emptyText])
        <div class="col-md-6">
            <div class="panel h-100">
                <div class="panel-head"><i class="fas {{ $icon }}"></i> {{ $title }}</div>
                <div class="panel-body">
                    @forelse($list as $cat => $sum)
                        <div class="f-list-item">
                            <span><i class="f-dot {{ $kind }}"></i> {{ $cat ?: __("Uncategorized") }}</span>
                            <strong class="f-{{ $kind }}">{{ $peso }}{{ number_format($sum, 2) }}</strong>
                        </div>
                    @empty
                        <div class="f-empty py-4"><p>{{ $emptyText }}</p></div>
                    @endforelse
                    <div class="f-list-total">
                        <span>{{ $kind == 'income' ? __("Total Income") : __("Total Expenses") }}</span>
                        <span class="f-{{ $kind }}">{{ $peso }}{{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ============ TOP 5 ============ --}}
<div class="row g-3 mb-4" id="transactions-section">
    @foreach([
        ['income',  __('Top 5 Income'),   'fa-trophy',               $topIncome,  '+'],
        ['expense', __('Top 5 Expenses'), 'fa-exclamation-triangle', $topExpense, '-'],
    ] as [$kind, $title, $icon, $list, $sign])
        <div class="col-md-6">
            <div class="panel h-100">
                <div class="panel-head"><i class="fas {{ $icon }}"></i> {{ $title }}</div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>{{ __("Date") }}</th>
                                <th>{{ __("Description") }}</th>
                                <th class="text-end">{{ __("Amount") }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($list as $t)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($t->date)->format('M d, Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($t->description, 25) }}</td>
                                    <td class="text-end fw-semibold f-{{ $kind }}">{{ $sign }}{{ $peso }}{{ number_format($t->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted">{{ __("No records") }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ============ ALL TRANSACTIONS ============ --}}
<div class="panel" id="all-transactions-section">
    <div class="panel-head">
        <i class="fas fa-list-ul"></i>
        <span data-i18n="all_transactions">{{ __("All Transactions") }}</span>
        <span class="f-pill ms-auto">{{ $transactions->count() }} <span data-i18n="records">{{ __("records") }}</span></span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>{{ __("Date") }}</th>
                    <th>{{ __("Description") }}</th>
                    <th>{{ __("Category") }}</th>
                    <th>{{ __("Type") }}</th>
                    <th class="text-end">{{ __("Amount") }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    @php $isIncome = $t->type == 'income'; @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($t->date)->format('M d, Y') }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($t->description, 30) }}</td>
                        <td>{{ $t->category ?? '-' }}</td>
                        <td><span class="f-pill {{ $isIncome ? 'income' : 'expense' }}">{{ $isIncome ? __("Income") : __("Expense") }}</span></td>
                        <td class="text-end fw-semibold {{ $isIncome ? 'f-income' : 'f-expense' }}">
                            {{ $isIncome ? '+' : '-' }}{{ $peso }}{{ number_format($t->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="f-empty"><i class="fas fa-receipt"></i><h5>{{ __("No transactions found") }}</h5></div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ============ EXPORT MODAL ============ --}}
<div class="modal fade no-print" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel" style="font-size:1rem;font-weight:700;">
                    <i class="fas fa-download me-2" style="color:var(--primary);"></i>{{ __("Export Report") }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="f-subtitle">{{ __("Include") }}</div>
                @foreach([
                    ['stats-section',            __('Key Metrics')],
                    ['chart-section',            __('Trend Chart')],
                    ['category-section',         __('Category Breakdown')],
                    ['transactions-section',     __('Top Transactions')],
                    ['all-transactions-section', __('All Transactions')],
                ] as [$sectionId, $sectionLabel])
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="chk-{{ $sectionId }}" data-section="{{ $sectionId }}" checked>
                        <label class="form-check-label" for="chk-{{ $sectionId }}">{{ $sectionLabel }}</label>
                    </div>
                @endforeach

                <div class="f-subtitle mt-4">{{ __("Export Format") }}</div>
                <div class="d-flex flex-wrap gap-3">
                    @foreach(['print' => 'Print', 'pdf' => 'PDF', 'excel' => 'Excel', 'csv' => 'CSV'] as $val => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exportFormat" id="fmt-{{ $val }}" value="{{ $val }}" {{ $val == 'print' ? 'checked' : '' }}>
                            <label class="form-check-label" for="fmt-{{ $val }}">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
                <p class="text-muted mt-3 mb-0" style="font-size:.75rem;">
                    {{ __("Excel and CSV export the transaction list. Sections apply to Print and PDF.") }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">{{ __("Cancel") }}</button>
                <button type="button" class="btn-cyan" id="exportBtn"><i class="fas fa-download"></i> {{ __("Export") }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
(function () {
    'use strict';

    var CHURCH  = @json($churchName);
    var PERIOD  = @json($periodText);
    var ROWS    = @json($exportRows);
    var LABELS  = @json($months);
    var INCOME  = @json($monthlyIncome);
    var EXPENSE = @json($monthlyExpense);
    var HEAD    = ['Date', 'Description', 'Category', 'Type', 'Amount', 'Remarks'];
    var PESO    = '\u20B1';
    var chart   = null;

    function css(name) { return getComputedStyle(document.documentElement).getPropertyValue(name).trim(); }
    function esc(s) { var d = document.createElement('div'); d.textContent = s == null ? '' : s; return d.innerHTML; }
    function fileBase() { return CHURCH.replace(/[^a-zA-Z0-9]/g, '_') + '_Report_' + new Date().toISOString().slice(0, 10); }


    /* ---------------- CHART ---------------- */
    function buildChart() {
        var canvas = document.getElementById('financialChart');
        if (!canvas || !window.Chart) return;
        if (chart) chart.destroy();

        var grid = css('--border-color'), tick = css('--text-muted');

        function line(label, data, color, dashed) {
            return {
                label: label, data: data, borderColor: color, backgroundColor: color + '14',
                borderWidth: 2.5, borderDash: dashed ? [5, 4] : [], fill: true, tension: 0.4,
                pointRadius: 3, pointBackgroundColor: color,
                pointBorderColor: css('--bg-card'), pointBorderWidth: 2, pointHoverRadius: 5
            };
        }

        chart = new Chart(canvas, {
            type: 'line',
            data: { labels: LABELS, datasets: [line('Income', INCOME, '#22C55E', false), line('Expenses', EXPENSE, '#EF4444', true)] },
            options: {
                responsive: true, maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: css('--bg-card'), titleColor: css('--text-main'), bodyColor: tick,
                        borderColor: grid, borderWidth: 1, cornerRadius: 8, padding: 10,
                        callbacks: { label: function (c) { return c.dataset.label + ': ' + PESO + c.parsed.y.toLocaleString(); } }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: grid }, ticks: { color: tick, font: { size: 10 }, callback: function (v) { return PESO + v.toLocaleString(); } } },
                    x: { grid: { display: false }, ticks: { color: tick, font: { size: 10 } } }
                }
            }
        });
    }

    buildChart();
    window.addEventListener('themechanged', buildChart);   // fired by app-shell.js


    /* ---------------- EXPORT ---------------- */
    function selectedHtml() {
        var html = '';
        document.querySelectorAll('#exportModal [data-section]:checked').forEach(function (cb) {
            var el = document.getElementById(cb.dataset.section);
            if (!el) return;
            var clone = el.cloneNode(true);
            clone.querySelectorAll('canvas').forEach(function (c) {
                if (chart) {
                    var img = new Image();
                    img.src = chart.toBase64Image();
                    img.style.maxWidth = '100%';
                    c.replaceWith(img);
                } else { c.remove(); }
            });
            html += clone.outerHTML;
        });
        return html;
    }

    function reportHtml() {
        return '<div style="text-align:center;border-bottom:2px solid #333;margin-bottom:16px;padding-bottom:8px;">' +
                   '<h2>' + esc(CHURCH) + '</h2>' +
                   '<p>Financial Report - ' + new Date().toLocaleDateString() + '</p>' +
                   '<p>' + esc(PERIOD) + '</p>' +
               '</div>' + selectedHtml() +
               '<p style="text-align:center;font-size:10px;margin-top:16px;border-top:1px solid #ccc;padding-top:8px;">Generated on ' +
               new Date().toLocaleString() + ' | ' + esc(CHURCH) + '</p>';
    }

    var PRINT_CSS =
        'body{font-family:Arial,sans-serif;margin:24px;color:#111}' +
        '.row{display:grid;grid-template-columns:1fr 1fr;gap:14px}.col-6,.col-xl-3{display:block}' +
        '#stats-section{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}' +
        '.stat-card{border:1px solid #ddd;border-radius:8px;padding:12px}.stat-icon{display:none}' +
        '.stat-label{font-size:10px;text-transform:uppercase;color:#666}.stat-value{font-size:20px;font-weight:700}' +
        '.panel{border:1px solid #ddd;border-radius:8px;margin:14px 0;break-inside:avoid}' +
        '.panel-head{padding:10px 14px;font-weight:700;border-bottom:1px solid #ddd}.panel-body{padding:14px}' +
        'table{width:100%;border-collapse:collapse}th,td{border-bottom:1px solid #eee;padding:6px;text-align:left;font-size:12px}' +
        '.text-end{text-align:right!important}.f-income{color:#16a34a}.f-expense{color:#dc2626}' +
        '.f-list-item,.f-list-total{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #eee}' +
        '.f-legend,.f-dot,.f-pill i{display:none}.f-pill{font-size:11px}';

    function doPrint() {
        var w = window.open('', '_blank');
        w.document.write('<!DOCTYPE html><html><head><title>' + esc(CHURCH) + ' Report</title><style>' + PRINT_CSS + '</style></head><body>' + reportHtml() + '</body></html>');
        w.document.close();
        w.focus();
        w.print();
    }

    function doPdf() {
        var el = document.createElement('div');
        el.style.padding = '20px';
        el.innerHTML = reportHtml();
        html2pdf().set({
            margin: 0.5, filename: fileBase() + '.pdf',
            image: { type: 'jpeg', quality: 0.98 }, html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        }).from(el).save();
    }

    function doExcel() {
        var ws = XLSX.utils.aoa_to_sheet([HEAD].concat(ROWS));
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Financial Report');
        XLSX.writeFile(wb, fileBase() + '.xlsx');
    }

    function doCsv() {
        var cell = function (v) { return '"' + String(v == null ? '' : v).replace(/"/g, '""') + '"'; };
        var lines = [HEAD].concat(ROWS).map(function (r) { return r.map(cell).join(','); });
        var blob = new Blob([lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = fileBase() + '.csv';
        a.click();
        URL.revokeObjectURL(a.href);
    }

    document.getElementById('exportBtn').addEventListener('click', function () {
        var format = document.querySelector('input[name="exportFormat"]:checked').value;
        var modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
        if (modal) modal.hide();
        ({ print: doPrint, pdf: doPdf, excel: doExcel, csv: doCsv })[format]();
    });

    window.addEventListener('localeChanged', function () {
        if (typeof window.applyTranslations === 'function') window.applyTranslations();
    });
})();
</script>
@endpush