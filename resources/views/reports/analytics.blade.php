@extends('layouts.app')

@section('header', 'Reports & Analytics')
@section('subheader', __('Complete church financial and membership analytics'))

@push('styles')
    @include('finance._styles')
@endpush

@section('content')
@php
    $peso      = "\u{20B1}";
    $balance   = $balance ?? 0;
    $isSurplus = $balance >= 0;

    $recentTransactions = $recentTransactions ?? [];
    $recentMembers      = $recentMembers ?? [];
    $upcomingBirthdays  = $upcomingBirthdays ?? [];

    // [icon, icon colour, i18n key, label, value, trend text, trend class]
    $stats = [
        ['fa-arrow-down',     'green', 'total_income',   __('Total Income'),   $peso . number_format($totalIncome ?? 0, 2),  __('Money received'), ''],
        ['fa-arrow-up',       'red',   'total_expenses', __('Total Expenses'), $peso . number_format($totalExpense ?? 0, 2), __('Money spent'),    ''],
        ['fa-scale-balanced', '',      'net_balance',    __('Net Balance'),    ($isSurplus ? '' : '-') . $peso . number_format(abs($balance), 2), $isSurplus ? __('Surplus') : __('Deficit'), $isSurplus ? 'trend-up' : 'trend-down'],
        ['fa-users',          '',      'total_members',  __('Total Members'),  number_format($totalMembers ?? 0),            __('Church family'),  ''],
    ];

    // Data for the PDF export (plain text - the PDF standard fonts have no peso sign, so "PHP" is used)
    $pdfData = [
        'labels' => [
            'title'        => __('Reports & Analytics'),
            'generated'    => __('Generated'),
            'chart'        => __('Income vs Expenses (Last 6 Months)'),
            'transactions' => __('Recent Transactions'),
            'members'      => __('Recent Members'),
            'birthdays'    => __('Upcoming Birthdays'),
            'date'         => __('Date'),
            'description'  => __('Description'),
            'type'         => __('Type'),
            'amount'       => __('Amount'),
            'name'         => __('Name'),
            'joined'       => __('Joined'),
            'birthday'     => __('Birthday'),
            'none'         => __('No records'),
            'page'         => __('Page'),
        ],
        'stats' => [
            ['label' => __('Total Income'),   'value' => 'PHP ' . number_format($totalIncome ?? 0, 2),  'sub' => __('Money received'), 'tone' => 'green'],
            ['label' => __('Total Expenses'), 'value' => 'PHP ' . number_format($totalExpense ?? 0, 2), 'sub' => __('Money spent'),    'tone' => 'red'],
            ['label' => __('Net Balance'),    'value' => ($isSurplus ? '' : '-') . 'PHP ' . number_format(abs($balance), 2), 'sub' => $isSurplus ? __('Surplus') : __('Deficit'), 'tone' => $isSurplus ? 'green' : 'red'],
            ['label' => __('Total Members'),  'value' => number_format($totalMembers ?? 0), 'sub' => __('Church family'), 'tone' => 'brand'],
        ],
        'transactions' => collect($recentTransactions)->take(10)->map(fn ($t) => [
            \Carbon\Carbon::parse($t->date ?? $t->created_at)->format('M d, Y'),
            \Illuminate\Support\Str::limit($t->description ?? 'N/A', 45),
            ($t->type ?? 'expense') == 'income' ? __('Income') : __('Expense'),
            (($t->type ?? 'expense') == 'income' ? '+' : '-') . 'PHP ' . number_format($t->amount ?? 0, 2),
        ])->values(),
        'members' => collect($recentMembers)->take(6)->map(fn ($m) => [
            trim(($m->first_name ?? '') . ' ' . ($m->last_name ?? '')),
            \Carbon\Carbon::parse($m->created_at)->format('M d, Y'),
        ])->values(),
        'birthdays' => collect($upcomingBirthdays)->take(6)->map(fn ($b) => [
            trim(($b->first_name ?? '') . ' ' . ($b->last_name ?? '')),
            \Carbon\Carbon::parse($b->birthday)->format('F d'),
        ])->values(),
    ];
@endphp

{{-- ACTIONS --}}
<div class="d-flex flex-wrap justify-content-end gap-2 mb-3 no-print">
    <a href="{{ route('dashboard') }}" class="btn-ghost">
        <i class="fas fa-arrow-left"></i> <span data-i18n="Dashboard">{{ __("Dashboard") }}</span>
    </a>
    <button type="button" class="btn-cyan" data-bs-toggle="modal" data-bs-target="#exportModal">
        <i class="fas fa-download"></i> <span data-i18n="export_report">{{ __("Export Report") }}</span>
    </button>
</div>

{{-- STATS --}}
<div class="row g-3 mb-4" id="stats-section">
    @foreach($stats as [$icon, $color, $key, $label, $value, $tText, $tClass])
        <div class="col-6 col-xl-3">
            <div class="stat-card f-stat h-100">
                <div class="stat-icon {{ $color }}"><i class="fas {{ $icon }}"></i></div>
                <div style="min-width:0;">
                    <div class="stat-label" data-i18n="{{ $key }}">{{ $label }}</div>
                    <div class="stat-value">{{ $value }}</div>
                    <div class="stat-trend {{ $tClass }}">{{ $tText }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- CHART --}}
<div class="panel mb-4" id="chart-section">
    <div class="panel-head flex-wrap">
        <i class="fas fa-chart-line"></i>
        <span data-i18n="income_vs_expenses_chart">{{ __("Income vs Expenses") }}</span>
        <span class="f-pill ms-auto"><i class="fas fa-clock"></i> {{ __("Last 6 Months") }}</span>
    </div>
    <div class="panel-body">
        <div class="f-legend">
            <span><i class="income"></i> {{ __("Income") }}</span>
            <span><i class="expense"></i> {{ __("Expenses") }}</span>
        </div>
        <div class="f-chart"><canvas id="financeChart"></canvas></div>
    </div>
</div>

<div class="row g-3 mb-4">

    {{-- RECENT TRANSACTIONS --}}
    <div class="col-lg-7">
        <div class="panel h-100" id="transactions-section">
            <div class="panel-head">
                <i class="fas fa-history"></i>
                <span data-i18n="recent_transactions">{{ __("Recent Transactions") }}</span>
                <span class="f-pill ms-auto">{{ count($recentTransactions) }} <span data-i18n="entries">{{ __("entries") }}</span></span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>{{ __("Date") }}</th>
                            <th>{{ __("Description") }}</th>
                            <th>{{ __("Type") }}</th>
                            <th class="text-end">{{ __("Amount") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $t)
                            @php $isIncome = ($t->type ?? 'expense') == 'income'; @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($t->date ?? $t->created_at)->format('M d, Y') }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($t->description ?? 'N/A', 30) }}</td>
                                <td><span class="f-pill {{ $isIncome ? 'income' : 'expense' }}">{{ $isIncome ? __("Income") : __("Expense") }}</span></td>
                                <td class="text-end fw-semibold {{ $isIncome ? 'f-income' : 'f-expense' }}">
                                    {{ $isIncome ? '+' : '-' }}{{ $peso }}{{ number_format($t->amount ?? 0, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="f-empty"><i class="fas fa-receipt"></i><h5>{{ __("No transactions found") }}</h5></div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MEMBERS + BIRTHDAYS --}}
    <div class="col-lg-5">
        <div class="panel mb-3" id="members-section">
            <div class="panel-head">
                <i class="fas fa-users"></i>
                <span data-i18n="recent_members">{{ __("Recent Members") }}</span>
                <span class="f-pill ms-auto">{{ count($recentMembers) }} <span data-i18n="new">{{ __("new") }}</span></span>
            </div>
            <div class="panel-body">
                @forelse($recentMembers as $member)
                    <div class="f-list-item">
                        <span><i class="fas fa-user text-muted me-2"></i>{{ trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? '')) }}</span>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($member->created_at)->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="f-empty py-4"><p>{{ __("No members found") }}</p></div>
                @endforelse
            </div>
        </div>

        <div class="panel" id="birthdays-section">
            <div class="panel-head">
                <i class="fas fa-cake-candles"></i>
                <span data-i18n="upcoming_birthdays">{{ __("Upcoming Birthdays") }}</span>
                <span class="f-pill ms-auto">{{ count($upcomingBirthdays) }} <span data-i18n="celebrating">{{ __("celebrating") }}</span></span>
            </div>
            <div class="panel-body">
                @forelse($upcomingBirthdays as $b)
                    <div class="f-list-item">
                        <span><i class="fas fa-cake-candles text-muted me-2"></i>{{ trim(($b->first_name ?? '') . ' ' . ($b->last_name ?? '')) }}</span>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($b->birthday)->format('F d') }}</small>
                    </div>
                @empty
                    <div class="f-empty py-4"><p>{{ __("No upcoming birthdays") }}</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- EXPORT MODAL --}}
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
                    ['stats-section',        __('Key Metrics')],
                    ['chart-section',        __('Chart')],
                    ['transactions-section', __('Recent Transactions')],
                    ['members-section',      __('Recent Members')],
                    ['birthdays-section',    __('Upcoming Birthdays')],
                ] as [$sectionId, $sectionLabel])
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="chk-{{ $sectionId }}" data-section="{{ $sectionId }}" checked>
                        <label class="form-check-label" for="chk-{{ $sectionId }}">{{ $sectionLabel }}</label>
                    </div>
                @endforeach
                <p class="text-muted mt-3 mb-0" style="font-size:.75rem;">
                    {{ __("The report is exported as a one-page A4 PDF. Print opens the same PDF in a new tab.") }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">{{ __("Cancel") }}</button>
                <button type="button" class="btn-ghost" id="exportPrint"><i class="fas fa-print"></i> {{ __("Print") }}</button>
                <button type="button" class="btn-cyan" id="exportPdf"><i class="fas fa-file-pdf"></i> {{ __("Download PDF") }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
(function () {
    'use strict';

    var CHURCH  = @json(auth()->user()->church->name ?? 'My Church');
    var PDF     = @json($pdfData);
    var MONTHS  = @json($months ?? []);
    var INCOME  = @json($incomeData ?? []);
    var EXPENSE = @json($expenseData ?? []);
    var PESO    = '\u20B1';
    var chart   = null;

    function css(name) { return getComputedStyle(document.documentElement).getPropertyValue(name).trim(); }
    function fileBase() { return CHURCH.replace(/[^a-zA-Z0-9]/g, '_') + '_Report_' + new Date().toISOString().slice(0, 10); }


    /* ---------------- PAGE CHART ---------------- */
    function buildChart() {
        var canvas = document.getElementById('financeChart');
        if (!canvas || !window.Chart) return;
        if (!MONTHS.length) {
            canvas.parentNode.innerHTML = '<div class="f-empty"><p>No chart data available</p></div>';
            return;
        }
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
            data: { labels: MONTHS, datasets: [line('Income', INCOME, '#22C55E', false), line('Expenses', EXPENSE, '#EF4444', true)] },
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


    /* ---------------- PDF ---------------- */
    var CHART_W = 1100, CHART_H = 330;

    // Light-theme copy of the chart, drawn off-screen so the PDF never depends on the page theme
    function chartImage() {
        if (!MONTHS.length || !window.Chart) return null;
        var cv = document.createElement('canvas');
        cv.width = CHART_W;
        cv.height = CHART_H;

        function ds(label, data, color, dashed) {
            return { label: label, data: data, borderColor: color, backgroundColor: color + '18', fill: true, tension: 0.35,
                     borderWidth: 4, borderDash: dashed ? [10, 8] : [], pointRadius: 5, pointBackgroundColor: color };
        }

        var c = new Chart(cv, {
            type: 'line',
            data: { labels: MONTHS, datasets: [ds('Income', INCOME, '#16a34a', false), ds('Expenses', EXPENSE, '#dc2626', true)] },
            options: {
                responsive: false, animation: false, devicePixelRatio: 1,
                plugins: { legend: { position: 'top', labels: { font: { size: 22 }, color: '#334155', usePointStyle: true } } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#e5e7eb' }, ticks: { color: '#64748b', font: { size: 20 }, callback: function (v) { return PESO + v.toLocaleString(); } } },
                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 20 } } }
                }
            }
        });
        var url = cv.toDataURL('image/png');
        c.destroy();
        return url;
    }

    function rgb(value, fallback) {
        var m = /^#?([0-9a-f]{6})$/i.exec((value || '').trim());
        if (!m) return fallback;
        var n = parseInt(m[1], 16);
        return [(n >> 16) & 255, (n >> 8) & 255, n & 255];
    }

    function buildPdf(sections) {
        var doc = new window.jspdf.jsPDF({ unit: 'mm', format: 'a4' });
        var W = 210, M = 15, CW = W - 2 * M;
        var L     = PDF.labels;
        var brand = rgb(css('--primary'), [8, 145, 178]);
        var ink = [15, 23, 42], muted = [100, 116, 139], line = [226, 232, 240];
        var tones = { green: [22, 163, 74], red: [220, 38, 38], brand: brand };
        var has = function (id) { return sections.indexOf(id) !== -1; };
        var y;

        /* header band */
        doc.setFillColor(...ink);   doc.rect(0, 0, W, 26, 'F');
        doc.setFillColor(...brand); doc.rect(0, 26, W, 1.6, 'F');
        doc.setFont('helvetica', 'bold');   doc.setFontSize(16); doc.setTextColor(255, 255, 255);
        doc.text(String(CHURCH), M, 12);
        doc.setFont('helvetica', 'normal'); doc.setFontSize(9);  doc.setTextColor(203, 213, 225);
        doc.text(String(L.title), M, 19);
        doc.text(L.generated + ': ' + new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }), W - M, 19, { align: 'right' });
        y = 37;

        function title(text, x) {
            doc.setFillColor(...brand); doc.rect(x, y - 3.8, 1.4, 5, 'F');
            doc.setFont('helvetica', 'bold'); doc.setFontSize(10.5); doc.setTextColor(...ink);
            doc.text(String(text), x + 3.5, y);
            y += 4;
        }

        function table(head, body, x, width, cols, parse) {
            doc.autoTable({
                startY: y,
                head: [head],
                body: body.length ? body : [[{ content: L.none, colSpan: head.length, styles: { halign: 'center', textColor: muted } }]],
                margin: { left: x, right: W - x - width, bottom: 16 },
                tableWidth: width,
                theme: 'plain',
                styles: { font: 'helvetica', fontSize: 8.3, textColor: ink, overflow: 'ellipsize',
                          cellPadding: { top: 1.9, bottom: 1.9, left: 2.5, right: 2.5 } },
                headStyles: { fillColor: [241, 245, 249], textColor: muted, fontStyle: 'bold', fontSize: 7 },
                alternateRowStyles: { fillColor: [250, 251, 253] },
                columnStyles: cols,
                didParseCell: parse,
                didDrawCell: function (d) {
                    if (d.section !== 'body') return;
                    doc.setDrawColor(...line); doc.setLineWidth(0.2);
                    doc.line(d.cell.x, d.cell.y + d.cell.height, d.cell.x + d.cell.width, d.cell.y + d.cell.height);
                }
            });
            return doc.lastAutoTable.finalY;
        }

        /* key metrics */
        if (has('stats-section')) {
            var gap = 4, cw = (CW - gap * 3) / 4, ch = 25;
            PDF.stats.forEach(function (s, i) {
                var x = M + i * (cw + gap), c = tones[s.tone] || brand, size = 13;
                doc.setDrawColor(...line); doc.setFillColor(248, 250, 252);
                doc.roundedRect(x, y, cw, ch, 2, 2, 'FD');
                doc.setFillColor(...c); doc.rect(x, y + 3, 1.2, ch - 6, 'F');

                doc.setFont('helvetica', 'bold'); doc.setFontSize(6.8); doc.setTextColor(...muted);
                doc.text(String(s.label).toUpperCase(), x + 5, y + 6.5);

                doc.setFontSize(size);
                while (size > 7 && doc.getTextWidth(String(s.value)) > cw - 8) { size -= 0.5; doc.setFontSize(size); }
                doc.setTextColor(...ink);
                doc.text(String(s.value), x + 5, y + 14.5);

                doc.setFont('helvetica', 'normal'); doc.setFontSize(7.2); doc.setTextColor(...c);
                doc.text(String(s.sub), x + 5, y + 20.5);
            });
            y += ch + 9;
        }

        /* chart */
        if (has('chart-section')) {
            title(L.chart, M);
            var img = chartImage();
            var ih  = (CW - 4) * CHART_H / CHART_W;
            doc.setDrawColor(...line);
            doc.roundedRect(M, y, CW, ih + 4, 2, 2, 'S');
            if (img) {
                doc.addImage(img, 'PNG', M + 2, y + 2, CW - 4, ih);
            } else {
                doc.setFont('helvetica', 'normal'); doc.setFontSize(9); doc.setTextColor(...muted);
                doc.text(String(L.none), M + CW / 2, y + (ih + 4) / 2, { align: 'center' });
            }
            y += ih + 4 + 9;
        }

        /* recent transactions */
        if (has('transactions-section')) {
            title(L.transactions, M);
            y = table(
                [L.date, L.description, L.type, L.amount],
                PDF.transactions, M, CW,
                { 0: { cellWidth: 28 }, 2: { cellWidth: 24 }, 3: { cellWidth: 38, halign: 'right', fontStyle: 'bold' } },
                function (d) {
                    if (d.section !== 'body' || typeof d.cell.raw !== 'string') return;
                    if (d.column.index === 3) d.cell.styles.textColor = d.cell.raw.charAt(0) === '+' ? tones.green : tones.red;
                    if (d.column.index === 2) d.cell.styles.textColor = PDF.transactions[d.row.index][3].charAt(0) === '+' ? tones.green : tones.red;
                }
            ) + 9;
        }

        /* members + birthdays side by side */
        var blocks = [];
        if (has('members-section'))   blocks.push([L.members,   [L.name, L.joined],   PDF.members]);
        if (has('birthdays-section')) blocks.push([L.birthdays, [L.name, L.birthday], PDF.birthdays]);
        if (blocks.length) {
            var w = blocks.length === 2 ? (CW - 6) / 2 : CW, top = y, bottoms = [];
            blocks.forEach(function (b, i) {
                y = top;
                var x = M + i * (w + 6);
                title(b[0], x);
                bottoms.push(table(b[1], b[2], x, w, { 1: { halign: 'right', textColor: muted } }));
            });
            y = Math.max.apply(null, bottoms) + 9;
        }

        /* footer on every page */
        var pages = doc.getNumberOfPages();
        for (var p = 1; p <= pages; p++) {
            doc.setPage(p);
            doc.setDrawColor(...line); doc.setLineWidth(0.2); doc.line(M, 284, W - M, 284);
            doc.setFont('helvetica', 'normal'); doc.setFontSize(7.5); doc.setTextColor(...muted);
            doc.text('Generated by TINC Church Management System', M, 289);
            doc.text(L.page + ' ' + p + ' / ' + pages, W - M, 289, { align: 'right' });
        }
        return doc;
    }


    /* ---------------- EXPORT BUTTONS ---------------- */
    var btnPrint = document.getElementById('exportPrint');
    var btnPdf   = document.getElementById('exportPdf');

    function selected() {
        return Array.prototype.map.call(document.querySelectorAll('#exportModal [data-section]:checked'), function (cb) { return cb.dataset.section; });
    }

    function syncButtons() {
        var none = selected().length === 0;
        btnPrint.disabled = none;
        btnPdf.disabled   = none;
    }
    document.querySelectorAll('#exportModal [data-section]').forEach(function (cb) { cb.addEventListener('change', syncButtons); });

    function run(action) {
        if (!window.jspdf || !window.jspdf.jsPDF) { alert('The PDF library could not be loaded. Please check your internet connection and reload the page.'); return; }
        var modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
        if (modal) modal.hide();
        try { action(buildPdf(selected())); }
        catch (e) { console.error(e); alert('Could not create the PDF: ' + e.message); }
    }

    btnPdf.addEventListener('click',   function () { run(function (doc) { doc.save(fileBase() + '.pdf'); }); });
    btnPrint.addEventListener('click', function () { run(function (doc) { window.open(doc.output('bloburl'), '_blank'); }); });

    window.addEventListener('localeChanged', function () {
        if (typeof window.applyTranslations === 'function') window.applyTranslations();
    });
})();
</script>
@endpush