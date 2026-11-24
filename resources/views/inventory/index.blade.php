@extends('layouts.app')

@section('title', __('Inventory'))
@section('header', __('Inventory'))
@section('subheader', __('Sunday collections and fund spending'))

@section('content')
@php
    $peso  = fn ($n) => '₱' . number_format((float) $n, 2);
    $icons = ['fellowship' => 'fa-people-group', 'missions' => 'fa-earth-asia', 'offering' => 'fa-hand-holding-heart'];

    $hasRange   = !empty($filters['from']) || !empty($filters['to']);
    $fundFilter = $filters['fund'] ?? null;
    $typeFilter = $filters['type'] ?? null;
    $hasFilter  = collect($filters)->except(['sort', 'per_page'])->filter()->isNotEmpty();
    $collectionBag = $errors->getBag('collection');
    $deductionBag  = $errors->getBag('deduction');

    // URL helpers keep every other filter while changing / removing some
    $without = fn (array $keys) => route('inventory.index', collect($filters)->except(array_merge($keys, ['page']))->all());
    $with    = fn (array $add)  => route('inventory.index', array_merge(collect($filters)->except(['page'])->all(), $add));

    $dateText = ($hasRange)
        ? (!empty($filters['from']) ? \Carbon\Carbon::parse($filters['from'])->format('M d, Y') : __('Start'))
          . ' – ' .
          (!empty($filters['to']) ? \Carbon\Carbon::parse($filters['to'])->format('M d, Y') : __('Today'))
        : null;

    $chips = [];
    if ($hasRange)   $chips[] = ['icon' => 'fa-calendar',  'text' => $dateText,                                   'url' => $without(['from', 'to'])];
    if ($fundFilter) $chips[] = ['icon' => 'fa-layer-group','text' => __($funds[$fundFilter]['label'] ?? $fundFilter), 'url' => $without(['fund'])];
    if ($typeFilter) $chips[] = ['icon' => 'fa-arrow-right-arrow-left', 'text' => $typeFilter === 'income' ? __('Collections only') : __('Deductions only'), 'url' => $without(['type'])];
    if (!empty($filters['q'])) $chips[] = ['icon' => 'fa-magnifying-glass', 'text' => '"' . $filters['q'] . '"', 'url' => $without(['q'])];

    $sort    = $filters['sort'] ?? 'newest';
    $perPage = (int) ($filters['per_page'] ?? 15);
@endphp

<style>
    .inv { max-width: 1600px; margin: 0 auto; }

    .fund-fellowship { --fc: #0BA5C0; }
    .fund-missions   { --fc: #3157D5; }
    .fund-offering   { --fc: #7C5CF0; }
    [data-theme="dark"] .fund-fellowship { --fc: #22D3EE; }
    [data-theme="dark"] .fund-missions   { --fc: #7C9BFF; }
    [data-theme="dark"] .fund-offering   { --fc: #A78BFA; }

    .fund-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 10px; border-radius: 999px;
        font-size: .72rem; font-weight: 700; white-space: nowrap;
        color: var(--fc);
        background: color-mix(in srgb, var(--fc) 14%, transparent);
    }
    .fund-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--fc); }

    /* clickable fund cards */
    .fund-link, .fund-link:hover { display: block; height: 100%; color: inherit; text-decoration: none; }
    .fund-link .stat-card { height: 100%; transition: border-color .15s ease, box-shadow .15s ease; }
    .fund-link:hover .stat-card { border-color: var(--fc, var(--primary)); }
    .fund-link.active .stat-card { border-color: var(--fc); box-shadow: 0 0 0 3px color-mix(in srgb, var(--fc) 22%, transparent); }
    .fund-link:focus-visible { outline: 2px solid var(--primary); outline-offset: 3px; border-radius: var(--radius); }

    .fund-card { display: flex; gap: 16px; align-items: flex-start; }
    .fund-card .stat-icon { background: var(--fc); box-shadow: 0 0 0 6px color-mix(in srgb, var(--fc) 14%, transparent); }
    .fund-card .stat-icon.total { background: var(--navy); }
    [data-theme="dark"] .fund-card .stat-icon.total { background: var(--primary); color: var(--navy-deep); }
    .fund-meta { display: flex; gap: 14px; flex-wrap: wrap; margin-top: 8px; font-size: .72rem; font-weight: 600; color: var(--text-muted); }
    .fund-meta b { color: var(--text-main); font-weight: 700; }
    .fund-meta .in b  { color: #16A34A; }
    .fund-meta .out b { color: #DC2626; }

    /* filters */
    .filter-bar { display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; }
    .filter-bar .fg { display: flex; flex-direction: column; gap: 4px; min-width: 140px; }
    .filter-bar .fg.grow { flex: 1; min-width: 200px; }
    .filter-bar .fg.sm { min-width: 110px; }
    .filter-bar label { font-size: .68rem; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; color: var(--text-muted); }
    .preset-row { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border-color); align-items: center; }
    .preset-row .lbl { font-size: .75rem; color: var(--text-muted); font-weight: 600; margin-right: 2px; }
    .preset { font-size: .75rem; font-weight: 600; padding: 4px 12px; border-radius: 999px; border: 1px solid var(--border-color); color: var(--text-muted) !important; text-decoration: none; transition: border-color .15s, color .15s, background .15s; }
    .preset:hover { border-color: var(--primary); color: var(--text-main) !important; }
    .preset.active { background: var(--primary-btn); border-color: var(--primary-btn); color: #fff !important; }
    .chip-row { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-top: 14px; }
    .chip { display: inline-flex; align-items: center; gap: 8px; padding: 4px 6px 4px 12px; border-radius: 999px; background: var(--primary-soft); color: var(--text-main) !important; font-size: .75rem; font-weight: 600; text-decoration: none; }
    .chip i.lead { color: var(--primary-btn); font-size: .72rem; }
    .chip .x { display: grid; place-items: center; width: 20px; height: 20px; border-radius: 50%; background: rgba(0,0,0,.08); font-size: .6rem; }
    .chip:hover .x { background: #DC2626; color: #fff; }
    .clear-all { font-size: .75rem; font-weight: 700; color: #DC2626 !important; text-decoration: none; margin-left: 4px; }

    .amt-in  { color: #16A34A; font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
    .amt-out { color: #DC2626; font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
    .num { font-variant-numeric: tabular-nums; text-align: right; white-space: nowrap; }
    .cell-sub { font-size: .75rem; color: var(--text-muted); margin-top: 2px; }
    .type-tag { font-size: .7rem; font-weight: 700; padding: 3px 9px; border-radius: 4px; }
    .type-tag.in  { background: rgba(34,197,94,.12); color: #16A34A; }
    .type-tag.out { background: rgba(239,68,68,.10); color: #DC2626; }
    .row-actions { display: flex; gap: 6px; justify-content: flex-end; }
    .row-actions .icon-btn { width: 32px; height: 32px; font-size: .78rem; border: 1px solid var(--border-color); }
    .row-actions .icon-btn.del:hover { color: #DC2626; background: rgba(239,68,68,.1); }
    .tfoot-total td { font-weight: 800; background: var(--bg-hover); }
    .empty-note { padding: 36px 0; text-align: center; color: var(--text-muted); font-size: .88rem; }
    .empty-note i { display: block; font-size: 1.8rem; margin-bottom: 10px; opacity: .4; }
    .results-line { font-size: .78rem; color: var(--text-muted); font-weight: 600; }

    .money-input { display: flex; align-items: stretch; }
    .money-input span { display: grid; place-items: center; padding: 0 14px; border: 1px solid var(--border-color); border-right: 0; border-radius: var(--radius) 0 0 var(--radius); background: var(--bg-hover); font-weight: 700; color: var(--text-muted); }
    .money-input .form-control { border-radius: 0 var(--radius) var(--radius) 0; }
    .modal-title { font-weight: 800; letter-spacing: -.3px; }
    .form-label { font-size: .72rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--text-muted); }
    .preview-box { padding: 12px 16px; border-radius: var(--radius); background: var(--primary-soft); font-size: .85rem; }
    .preview-box .row-line { display: flex; justify-content: space-between; gap: 12px; padding: 2px 0; }
    .preview-box .bad { color: #DC2626; }
    .fund-field { display: flex; align-items: center; gap: 12px; }
    .fund-field .fund-pill { min-width: 108px; justify-content: flex-start; padding: 8px 12px; }
    .fund-field .money-input { flex: 1; }

    .print-only { display: none; }
    @media print {
        .sidebar-container, .top-header, .page-intro, .mbar, .scrim, .no-print, .modal { display: none !important; }
        .print-only { display: block; margin-bottom: 14px; font-size: .9rem; }
        .shell { margin-left: 0 !important; }
        .content-area { padding: 0 !important; }
        .panel, .stat-card { box-shadow: none !important; break-inside: avoid; }
        body { background: #fff !important; color: #000 !important; }
    }
    @media (max-width: 575px) { .fund-field { flex-direction: column; align-items: stretch; } }
</style>

<style>
    /* ===== INVENTORY BOTTOM DOCK (i3) ===== */
    .inv-dock { display: none; }

    @@media (max-width: 767.98px) {
        /* Itago ang taas nga buttons sa mobile */
        .inv > .d-flex.flex-wrap.no-print { display: none !important; }

        /* Luna sa ubos para dili matabonan ang content */
        .inv { padding-bottom: 92px; }

        .inv-dock {
            display: flex; align-items: center; gap: 8px;
            position: fixed; z-index: 1030;
            left: 12px; right: 12px;
            bottom: calc(12px + env(safe-area-inset-bottom, 0px));
            padding: 8px;
            background: var(--bg-card, #fff);
            border: 1px solid var(--border-color, #E3E8F5);
            border-radius: 18px;
            box-shadow: 0 12px 32px rgba(12, 20, 69, .22);
        }
        .inv-dock .dk {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            height: 46px; padding: 0 14px; margin: 0;
            border: 0; border-radius: 12px;
            font: inherit; font-size: .92rem; font-weight: 700;
            text-decoration: none; cursor: pointer;
            -webkit-tap-highlight-color: transparent; touch-action: manipulation;
        }
        .inv-dock .dk i { font-size: .85rem; }
        .inv-dock .dk-main { flex: 1 1 0; min-width: 0; }
        .inv-dock .dk-rec { background: var(--primary-btn, #0BA5C0); color: #fff !important; }
        .inv-dock .dk-ded { background: rgba(239, 68, 68, .12); color: #DC2626 !important; }
        .inv-dock .dk-ico {
            flex: 0 0 46px; padding: 0;
            background: var(--bg-hover, #F1F4FB);
            color: var(--text-main, #0C1445) !important;
            border: 1px solid var(--border-color, #E3E8F5);
        }
        .inv-dock .dk:active { transform: scale(.97); }
        .inv-dock .dk-sep { width: 1px; height: 26px; background: var(--border-color, #E3E8F5); flex: 0 0 auto; }
    }
</style>

<style>
    /* ===== INVENTORY MOBILE (i1) ===== */
    @@media (max-width: 767.98px) {

        .inv, .edit-wrap { max-width: 100% !important; }
        .inv .row { --bs-gutter-x: .5rem; --bs-gutter-y: .5rem; }
        .inv .mb-4 { margin-bottom: .6rem !important; }
        .inv .alert { padding: .6rem .75rem; font-size: .82rem; }
        .inv .panel { border-radius: 14px; }
        .inv .panel-head { flex-wrap: wrap; padding: 12px !important; gap: 6px; font-size: .9rem; }
        .inv .panel-head .results-line, .inv .panel-head .cell-sub { width: 100%; margin-left: 0 !important; }
        .inv .panel-body { padding: 12px !important; }

        /* Action buttons */
        .inv > .d-flex.no-print { display: grid !important; grid-template-columns: 1fr 1fr; gap: 8px !important; }
        .inv > .d-flex.no-print > * { justify-content: center; width: 100%; margin: 0 !important; }
        .inv > .d-flex.no-print > :nth-child(-n+2) { grid-column: 1 / -1; }

        /* Fund cards 2x2 */
        .inv .row > [class*="col-md-6"] { flex: 0 0 auto; width: 50%; }
        .inv .fund-card { flex-direction: column; align-items: flex-start; gap: 8px; padding: 12px !important; }
        .inv .fund-card > div:last-child { width: 100%; min-width: 0; }
        .inv .fund-card .stat-icon { width: 38px; height: 38px; font-size: .95rem; box-shadow: 0 0 0 4px color-mix(in srgb, var(--fc, var(--primary)) 14%, transparent); }
        .inv .fund-card .stat-label { font-size: .68rem; }
        .inv .fund-card .stat-value { font-size: clamp(1.05rem, 5vw, 1.35rem) !important; line-height: 1.15; overflow-wrap: anywhere; }
        .inv .fund-meta { gap: 2px 10px; margin-top: 4px; font-size: .66rem; }
        .inv .fund-meta span { display: block; width: 100%; }

        /* Filters: 2 ka column */
        .filter-bar { gap: 8px; }
        .filter-bar .fg, .filter-bar .fg.sm { flex: 1 1 calc(50% - 4px); min-width: 0; }
        .filter-bar .fg.grow { flex: 1 1 100%; min-width: 0; }
        .filter-bar .form-control, .filter-bar .form-select { width: 100%; min-width: 0; }
        .preset-row { gap: 6px; margin-top: 10px; padding-top: 10px; }
        .preset-row .lbl { width: 100%; }
        .chip-row { margin-top: 10px; gap: 6px; }
        .form-control, .form-select { font-size: 16px !important; min-height: 44px; }


        /* Transactions -> cards */
        #inv-tx .table-responsive { overflow: visible !important; }
        #inv-tx .table, #inv-tx .table tbody, #inv-tx .table tfoot { display: block; width: 100% !important; }
        #inv-tx .table thead { display: none !important; }

        #inv-tx .table tbody tr {
            display: grid; grid-template-columns: auto auto 1fr auto;
            align-items: center; gap: 6px 8px;
            padding: 12px; border-bottom: 1px solid var(--border-color);
        }
        #inv-tx .table tbody td {
            display: block; padding: 0 !important; border: 0 !important;
            width: auto !important; min-width: 0; white-space: normal !important;
            overflow-wrap: anywhere;
        }
        #inv-tx .table tbody td:nth-child(4) { grid-column: 1 / 4; grid-row: 1; font-size: .86rem; }
        #inv-tx .table tbody td:nth-child(5) { grid-column: 4;     grid-row: 1; text-align: right; font-size: .9rem; }
        #inv-tx .table tbody td:nth-child(2) { grid-column: 1;     grid-row: 2; }
        #inv-tx .table tbody td:nth-child(3) { grid-column: 2;     grid-row: 2; }
        #inv-tx .table tbody td:nth-child(1) { grid-column: 3;     grid-row: 2; font-size: .72rem; color: var(--text-muted); white-space: nowrap !important; }
        #inv-tx .table tbody td:nth-child(6) { grid-column: 4;     grid-row: 2; }
        #inv-tx .table tbody td[colspan] { grid-column: 1 / -1 !important; grid-row: auto !important; }
        #inv-tx .row-actions { gap: 4px; }
        #inv-tx .row-actions .icon-btn { width: 32px; height: 32px; }

        /* Totals */
        #inv-tx .table tfoot tr { display: flex; justify-content: space-between; align-items: center; gap: 8px; padding: 12px; }
        #inv-tx .table tfoot td { display: block; padding: 0 !important; border: 0 !important; width: auto !important; }
        #inv-tx .table tfoot td[colspan] { flex: 1; text-align: left !important; }
        #inv-tx .table tfoot td.no-print { display: none !important; }

        /* Pagination */
        .inv .pagination { flex-wrap: wrap; justify-content: center; margin: 0; }
        .inv .panel-body.no-print { display: flex; justify-content: center; }
    }

    /* Modals (nasa gawas sa .inv) */
    @@media (max-width: 767.98px) {
        .modal-dialog { margin: .75rem; }
        .modal-body { padding: 14px; }
        .modal-footer { flex-wrap: nowrap; gap: 8px; }
        .modal-footer > * { flex: 1; margin: 0; justify-content: center; }
        .modal .form-control, .modal .form-select { font-size: 16px !important; min-height: 44px; }
        .modal textarea.form-control { min-height: 90px; }
        .fund-field .fund-pill { min-width: 0; }
    }
</style>

<style>
    /* ===== INVENTORY MOBILE v4 (i4) ===== */
    .fb-toggle { display: none; }
    .tk-btn { display: none; }

    .tk-menu {
        position: fixed; z-index: 5000;
        min-width: 190px; max-width: calc(100vw - 20px);
        padding: 6px; display: flex; flex-direction: column; gap: 2px;
        background: var(--bg-card, #fff); color: var(--text-main, #0C1445);
        border: 1px solid var(--border-color, #E3E8F5); border-radius: 14px;
        box-shadow: 0 18px 40px rgba(12, 20, 69, .28);
    }
    .tk-item {
        display: flex; align-items: center; gap: 12px;
        width: 100%; height: 44px; padding: 0 12px; margin: 0;
        border: 0; border-radius: 10px; background: transparent; color: inherit;
        font: inherit; font-size: .9rem; font-weight: 600; text-align: left;
        cursor: pointer; -webkit-tap-highlight-color: transparent; touch-action: manipulation;
    }
    .tk-item i { width: 18px; text-align: center; font-size: .9rem; }
    .tk-item:hover, .tk-item:active { background: var(--primary-soft, rgba(18,196,222,.12)); }
    .tk-item.danger, .tk-item.danger i { color: #DC2626; }

    @@media (max-width: 767.98px) {

        /* ---------- FILTERS ---------- */
        .inv .preset-row { display: none !important; }
        .inv .filter-bar { display: grid !important; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
        .inv .filter-bar .fg, .inv .filter-bar .fg.sm { min-width: 0; width: 100%; }
        .inv .filter-bar .fg.grow { grid-column: 1 / -1; order: 1; }
        .inv .filter-bar .fg.grow label { display: none; }
        .inv .filter-bar .fb-toggle { grid-column: 1 / -1; order: 2; }
        .inv .filter-bar .fg:not(.grow) { order: 3; }
        .inv .filter-bar:not(.fb-open) .fg:not(.grow) { display: none; }

        .inv .fb-toggle {
            display: flex; align-items: center; gap: 8px;
            width: 100%; height: 44px; padding: 0 14px; margin: 0;
            border: 1px solid var(--border-color); border-radius: 12px;
            background: var(--bg-hover); color: var(--text-main);
            font: inherit; font-size: .88rem; font-weight: 700;
            -webkit-tap-highlight-color: transparent; touch-action: manipulation;
        }
        .inv .fb-toggle > span:first-child { display: inline-flex; align-items: center; gap: 8px; }
        .inv .fb-toggle .fb-count {
            min-width: 22px; height: 22px; padding: 0 7px; border-radius: 11px;
            background: var(--primary-btn, #0BA5C0); color: #fff;
            font-size: .72rem; font-weight: 800; line-height: 22px; text-align: center;
        }
        .inv .fb-toggle .fb-chev { margin-left: auto; font-size: .75rem; transition: transform .15s ease; }
        .inv .filter-bar.fb-open .fb-toggle .fb-chev { transform: rotate(180deg); }

        /* ---------- SUNDAY COLLECTIONS: date sa taas, amounts sa ubos (grid) ---------- */
        .inv #inv-weekly .table-responsive { overflow: visible !important; }
        .inv #inv-weekly .table thead { display: none !important; }
        .inv #inv-weekly .table,
        .inv #inv-weekly .table tbody { display: block !important; width: 100% !important; table-layout: auto; }

        .inv #inv-weekly .table tbody tr {
            display: grid !important;
            grid-template-columns: repeat(var(--cols, 4), minmax(0, 1fr));
            column-gap: 8px; row-gap: 8px;
            padding: 12px !important;
            border-bottom: 1px solid var(--border-color);
        }
        .inv #inv-weekly .table tbody td {
            display: block !important;
            padding: 0 !important; border: 0 !important;
            width: auto !important; min-width: 0;
            background: transparent !important; box-shadow: none !important;
            text-align: left !important;
        }
        .inv #inv-weekly .table tbody td.wk-date {
            grid-column: 1 / -1;
            font-size: .9rem !important; font-weight: 700;
            white-space: nowrap !important;
        }
        .inv #inv-weekly .table tbody td.num {
            font-size: .8rem !important; font-weight: 600;
            white-space: nowrap !important;
            overflow-wrap: normal !important;
        }
        .inv #inv-weekly .table tbody td.num::before {
            content: attr(data-label);
            display: block; margin-bottom: 2px;
            font-size: .6rem; font-weight: 700; letter-spacing: .4px;
            text-transform: uppercase; color: var(--text-muted);
        }
        .inv #inv-weekly .table tbody td.num:last-child {
            padding-left: 8px !important;
            border-left: 1px solid var(--border-color) !important;
            font-weight: 800;
        }
        .inv #inv-weekly .table tbody td[colspan] { grid-column: 1 / -1; }

        /* ---------- TRANSACTIONS: card + kebab (actions makita ra inig click) ---------- */
        .inv #inv-tx .table tbody tr {
            display: grid !important;
            grid-template-columns: auto auto 1fr 44px;
            align-items: center; gap: 6px 8px;
            position: static; padding: 12px !important;
        }
        .inv #inv-tx .table tbody td:nth-child(4) { grid-column: 1 / 4; grid-row: 1; font-size: .88rem; padding-right: 0 !important; }
        .inv #inv-tx .table tbody td:nth-child(2) { grid-column: 1;     grid-row: 2; }
        .inv #inv-tx .table tbody td:nth-child(3) { grid-column: 2;     grid-row: 2; }
        .inv #inv-tx .table tbody td:nth-child(5) { grid-column: 3;     grid-row: 2; text-align: right !important; font-size: .95rem; }
        .inv #inv-tx .table tbody td:nth-child(1) { grid-column: 1 / 4; grid-row: 3; font-size: .72rem; color: var(--text-muted); }
        .inv #inv-tx .table tbody td:nth-child(6) {
            position: static !important;
            grid-column: 4; grid-row: 1 / span 2;
            align-self: center; justify-self: end;
        }
        .inv #inv-tx .row-actions { display: none !important; }
        .inv #inv-tx .tk-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; padding: 0;
            border: 1px solid var(--border-color); border-radius: 12px;
            background: var(--bg-hover); color: var(--text-main); font-size: 1rem;
            cursor: pointer; -webkit-tap-highlight-color: transparent; touch-action: manipulation;
        }
        .inv #inv-tx .tk-btn[aria-expanded="true"], .inv #inv-tx .tk-btn:active { background: var(--primary-soft); color: var(--primary-hover); }
        .inv #inv-tx .table tbody td[colspan] { grid-column: 1 / -1 !important; grid-row: auto !important; }
    }
</style>
<script>
/* Inventory: usa ka kebab button sa matag transaction (i4) */
(function () {
    var menu = null, openBtn = null;

    function close() {
        if (menu) { menu.remove(); menu = null; }
        if (openBtn) { openBtn.setAttribute('aria-expanded', 'false'); openBtn = null; }
    }

    function open(btn, acts) {
        close();
        menu = document.createElement('div');
        menu.className = 'tk-menu';
        menu.setAttribute('role', 'menu');

        acts.querySelectorAll('.icon-btn').forEach(function (src) {
            var it = document.createElement('button');
            it.type = 'button';
            it.className = 'tk-item' + (src.classList.contains('del') ? ' danger' : '');
            var ic = src.querySelector('i');
            var i = document.createElement('i');
            i.className = ic ? ic.className : 'fas fa-circle';
            var sp = document.createElement('span');
            sp.textContent = src.getAttribute('title') || src.getAttribute('aria-label') || '';
            it.appendChild(i); it.appendChild(sp);
            it.addEventListener('click', function (ev) {
                ev.stopPropagation();
                close();
                src.click();   // tinuod nga Edit link / Delete modal trigger
            });
            menu.appendChild(it);
        });

        document.body.appendChild(menu);
        openBtn = btn;
        btn.setAttribute('aria-expanded', 'true');

        var r  = btn.getBoundingClientRect();
        var vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
        var h  = menu.offsetHeight;
        var top = r.bottom + 6;
        if (top + h > vh - 8) top = r.top - h - 6;
        if (top < 8) top = 8;
        menu.style.top   = top + 'px';
        menu.style.left  = 'auto';
        menu.style.right = Math.max(10, document.documentElement.clientWidth - r.right) + 'px';
    }

    function build() {
        document.querySelectorAll('#inv-tx tbody tr').forEach(function (tr) {
            var td = tr.querySelector('td:last-child');
            var acts = td && td.querySelector('.row-actions');
            if (!acts || td.querySelector('.tk-btn')) return;
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'tk-btn';
            b.setAttribute('aria-label', 'Actions');
            b.setAttribute('aria-haspopup', 'true');
            b.setAttribute('aria-expanded', 'false');
            b.innerHTML = '<i class="fas fa-ellipsis-vertical"></i>';
            b.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (openBtn === b) close(); else open(b, acts);
            });
            td.insertBefore(b, td.firstChild);
        });
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', build);
    else build();

    document.addEventListener('click', function (e) { if (menu && !menu.contains(e.target)) close(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
    window.addEventListener('scroll', close, { passive: true });
    window.addEventListener('resize', close);
})();
</script>
<style>
    /* ===== INVENTORY DESKTOP (i5) ===== */
    @@keyframes invFadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @@keyframes invFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @@keyframes invShimmer { from { background-position: -200% 0; } to { background-position: 200% 0; } }

    @@media (min-width: 768px) {

        /* ---------- PAGE GRID ---------- */
        .inv { display: grid; grid-template-columns: repeat(12, minmax(0, 1fr)); gap: 24px; align-items: start; }
        .inv > * { grid-column: 1 / -1; margin: 0 !important; min-width: 0; }
        .inv > .row { align-items: stretch; }

        /* ---------- ENTRANCE ---------- */
        .inv > .d-flex.no-print { animation: invFadeIn .4s ease both; }
        .inv > .row > [class*="col-"] { animation: invFadeUp .5s cubic-bezier(.2,.7,.2,1) both; }
        .inv > .row > [class*="col-"]:nth-child(1) { animation-delay: .04s; }
        .inv > .row > [class*="col-"]:nth-child(2) { animation-delay: .10s; }
        .inv > .row > [class*="col-"]:nth-child(3) { animation-delay: .16s; }
        .inv > .row > [class*="col-"]:nth-child(4) { animation-delay: .22s; }
        .inv > .panel { animation: invFadeUp .55s cubic-bezier(.2,.7,.2,1) both; }
        .inv > .panel.no-print { animation-delay: .26s; }
        .inv #inv-weekly { animation-delay: .32s; }
        .inv #inv-tx     { animation-delay: .38s; }
        .inv #inv-tx tbody tr { animation: invFadeUp .4s ease both; }
        .inv #inv-tx tbody tr:nth-child(1) { animation-delay: .45s; }
        .inv #inv-tx tbody tr:nth-child(2) { animation-delay: .50s; }
        .inv #inv-tx tbody tr:nth-child(3) { animation-delay: .55s; }
        .inv #inv-tx tbody tr:nth-child(4) { animation-delay: .60s; }
        .inv #inv-tx tbody tr:nth-child(5) { animation-delay: .65s; }
        .inv #inv-tx tbody tr:nth-child(n+6) { animation-delay: .70s; }
        .inv #inv-weekly tbody tr { animation: invFadeUp .4s ease both; animation-delay: .42s; }

        /* ---------- ACTION BAR ---------- */
        .inv > .d-flex.no-print { gap: 10px !important; }
        .inv > .d-flex.no-print .btn-cyan,
        .inv > .d-flex.no-print .btn-ghost { transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
        .inv > .d-flex.no-print .btn-cyan:hover,
        .inv > .d-flex.no-print .btn-ghost:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(12, 20, 69, .12); }
        .inv > .d-flex.no-print .btn-cyan:active,
        .inv > .d-flex.no-print .btn-ghost:active { transform: translateY(0) scale(.98); }
        .inv > .d-flex.no-print i { transition: transform .25s ease; }
        .inv > .d-flex.no-print button:hover i.fa-plus  { transform: rotate(90deg); }
        .inv > .d-flex.no-print a:hover i.fa-file-csv   { transform: translateY(2px); }

        /* ---------- FUND CARDS ---------- */
        .inv .fund-link .stat-card {
            position: relative; overflow: hidden;
            transition: transform .22s ease, box-shadow .22s ease, border-color .2s ease;
        }
        .inv .fund-link .stat-card::after {
            content: ""; position: absolute; left: 0; right: 0; bottom: 0; height: 3px;
            background: var(--fc, var(--primary));
            transform: scaleX(0); transform-origin: left; transition: transform .35s ease;
        }
        .inv .fund-link:hover .stat-card { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(12, 20, 69, .14); }
        .inv .fund-link:hover .stat-card::after,
        .inv .fund-link.active .stat-card::after { transform: scaleX(1); }
        .inv .fund-link .stat-icon { transition: transform .3s cubic-bezier(.3,1.6,.5,1); }
        .inv .fund-link:hover .stat-icon { transform: scale(1.1) rotate(-6deg); }
        .inv .fund-card .stat-value { letter-spacing: -.5px; }

        /* ---------- FILTERS ---------- */
        .inv .filter-bar {
            display: grid; gap: 14px 16px; align-items: end;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
        .inv .filter-bar .fg, .inv .filter-bar .fg.sm { min-width: 0; width: 100%; }
        .inv .filter-bar .fg.grow { grid-column: span 2; }
        .inv .filter-bar .form-control,
        .inv .filter-bar .form-select { transition: border-color .18s ease, box-shadow .18s ease; }
        .inv .filter-bar .form-control:focus,
        .inv .filter-bar .form-select:focus { box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary, #0BA5C0) 18%, transparent); }
        .inv .chip-row { margin-top: 16px; padding-top: 14px; border-top: 1px dashed var(--border-color); }
        .inv .chip { transition: transform .15s ease, background .15s ease; animation: invFadeIn .3s ease both; }
        .inv .chip:hover { transform: translateY(-1px); }
        .inv .chip .x { transition: background .15s ease, color .15s ease, transform .2s ease; }
        .inv .chip:hover .x { transform: rotate(90deg); }

        /* ---------- PANELS ---------- */
        .inv .panel { overflow: hidden; transition: box-shadow .25s ease; }
        .inv .panel:hover { box-shadow: 0 10px 28px rgba(12, 20, 69, .07); }
        .inv .panel-head { padding: 16px 22px; display: flex; align-items: center; gap: 10px; }
        .inv .panel-head > i { opacity: .85; }

        /* ---------- TABLES ---------- */
        .inv .table thead th {
            font-size: .68rem; font-weight: 700; letter-spacing: .6px; text-transform: uppercase;
            color: var(--text-muted); padding: 12px 22px; white-space: nowrap;
        }
        .inv .table tbody td { padding: 14px 22px; vertical-align: middle; }
        .inv .table tbody tr { transition: background .15s ease, box-shadow .15s ease; }
        .inv #inv-tx tbody tr:hover { box-shadow: inset 3px 0 0 var(--primary-btn, #0BA5C0); }
        .inv #inv-weekly tbody tr:hover { box-shadow: inset 3px 0 0 var(--primary-btn, #0BA5C0); }
        .inv #inv-weekly .wk-date { white-space: nowrap; }
        .inv .tfoot-total td { padding: 16px 22px; }

        /* Edit/Delete: hinay-hinay mo-fade in inig hover sa row */
        @@media (hover: hover) {
            .inv #inv-tx .row-actions { opacity: .3; transform: translateX(6px); transition: opacity .18s ease, transform .18s ease; }
            .inv #inv-tx tbody tr:hover .row-actions,
            .inv #inv-tx .row-actions:focus-within { opacity: 1; transform: none; }
        }
        .inv .row-actions .icon-btn { transition: transform .15s ease, background .15s ease, color .15s ease; }
        .inv .row-actions .icon-btn:hover { transform: translateY(-2px); }

        .inv .empty-note i { animation: invFadeUp .6s ease both; }
        .inv .pagination { margin: 0; }
    }

    /* ---------- DAKONG SCREEN: Sunday collections (wala) + Transactions (tuo) ---------- */
    @@media (min-width: 1200px) {
        .inv #inv-weekly { grid-column: span 5; }
        .inv #inv-tx     { grid-column: span 7; }
        .inv #inv-weekly .table tbody td { padding: 14px 16px; }
        .inv #inv-weekly .table thead th { padding: 12px 16px; }
    }

    @@media print {
        .inv { display: block !important; }
        .inv * { animation: none !important; opacity: 1 !important; transform: none !important; }
    }
    @@media (prefers-reduced-motion: reduce) {
        .inv, .inv * { animation: none !important; transition: none !important; }
    }
</style>
<script>
/* Inventory desktop (i5): count-up sa balances */
document.addEventListener('DOMContentLoaded', function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    document.querySelectorAll('.inv .stat-value').forEach(function (el) {
        var txt = el.textContent.trim();
        var m = txt.match(/^([^\d\-]*)(-?[\d,]+(?:\.\d+)?)(.*)$/);
        if (!m) return;
        var target = parseFloat(m[2].replace(/,/g, ''));
        if (!isFinite(target) || target === 0) return;
        var dur = 800, t0 = null;
        function step(ts) {
            if (t0 === null) t0 = ts;
            var p = Math.min((ts - t0) / dur, 1);
            var e = 1 - Math.pow(1 - p, 3);
            el.textContent = m[1] + (target * e).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + m[3];
            if (p < 1) requestAnimationFrame(step); else el.textContent = txt;
        }
        requestAnimationFrame(step);
    });
});
</script>
<style>
    /* ===== INVENTORY DESKTOP FIX (i6) ===== */
    @@media (min-width: 768px) {

        /* ---------- PANELS: tibuok gilapdon (dili na magkatabi) ---------- */
        .inv #inv-weekly,
        .inv #inv-tx { grid-column: 1 / -1 !important; }
        .inv #inv-weekly .table tbody td,
        .inv #inv-weekly .table thead th { padding-left: 22px; padding-right: 22px; }

        /* ---------- FUND CARDS: dili na mo-overflow ang numbers ---------- */
        .inv .fund-link { container-type: inline-size; }
        .inv .fund-card { gap: 14px; padding: 18px !important; align-items: center; }
        .inv .fund-card .stat-icon { flex: 0 0 auto; width: 46px; height: 46px; font-size: 1.05rem; }
        .inv .fund-card > div:last-child { flex: 1 1 auto; min-width: 0; }
        .inv .fund-card .stat-label { font-size: .68rem; letter-spacing: .5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .inv .fund-card .stat-value {
            font-size: clamp(1.05rem, 1.7vw, 1.7rem);
            font-size: clamp(1.05rem, 8.5cqw, 1.75rem);
            line-height: 1.15; white-space: nowrap; letter-spacing: -.4px;
        }
        .inv .fund-meta { display: flex; flex-direction: column; gap: 2px; margin-top: 6px; font-size: .72rem; }
        .inv .fund-meta span { white-space: nowrap; }

        /* ---------- FILTERS: 2 ka hapsay nga row ---------- */
        .inv .filter-bar {
            display: grid !important;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 14px 16px; align-items: end;
        }
        .inv .filter-bar .fb-toggle { display: none !important; }
        .inv .filter-bar .fg,
        .inv .filter-bar .fg.sm,
        .inv .filter-bar .fg.grow { grid-column: span 3 !important; order: 0 !important; min-width: 0; width: 100%; display: flex !important; }
        .inv .filter-bar .fg.grow { grid-column: span 6 !important; }
        .inv .filter-bar .fg.grow label { display: block !important; }
        .inv .filter-bar .form-control,
        .inv .filter-bar .form-select { width: 100%; min-width: 0; text-overflow: ellipsis; }
        .inv .filter-bar label { white-space: nowrap; }

        /* ---------- TABLES ---------- */
        .inv #inv-tx .table { min-width: 720px; }
        .inv #inv-tx td.amt-in, .inv #inv-tx td.amt-out,
        .inv #inv-tx .table thead th.text-end { text-align: right; white-space: nowrap; }
        .inv #inv-tx .table tbody td:nth-child(4) { min-width: 220px; }
        .inv #inv-tx .table tbody td:nth-child(2),
        .inv #inv-tx .table tbody td:nth-child(3) { white-space: nowrap; }
        .inv #inv-tx .table tbody td:last-child,
        .inv #inv-tx .table thead th:last-child { width: 96px; }
        .inv #inv-weekly .table .num { white-space: nowrap; }
    }

    /* Medyo gamay nga desktop/laptop: 4 ka fund cards -> 2x2 */
    @@media (min-width: 768px) and (max-width: 1199.98px) {
        .inv .filter-bar .fg:not(.grow) { grid-column: span 4 !important; }
        .inv .filter-bar .fg.grow { grid-column: span 12 !important; }
    }
</style>
<div class="inv container-fluid px-0">

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 no-print" role="alert">
            <i class="fas fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->has('general'))
        <div class="alert alert-danger d-flex align-items-center gap-2 no-print" role="alert">
            <i class="fas fa-triangle-exclamation"></i> {{ $errors->first('general') }}
        </div>
    @endif
    @if($filterErrors->any())
        <div class="alert alert-warning d-flex align-items-center gap-2 no-print" role="alert">
            <i class="fas fa-triangle-exclamation"></i> {{ $filterErrors->first() }} {{ __('Showing everything until the filter is fixed.') }}
        </div>
    @endif

    {{-- Print-only report line --}}
    <div class="print-only">
        <strong>{{ __('Fund report') }}</strong>
        · {{ $hasRange ? $dateText : __('All dates') }}
        · {{ $fundFilter ? __($funds[$fundFilter]['label']) : __('All funds') }}
        · {{ $typeFilter ? ($typeFilter === 'income' ? __('Collections only') : __('Deductions only')) : __('Collections & deductions') }}
        @if(!empty($filters['q'])) · "{{ $filters['q'] }}" @endif
    </div>

    {{-- ACTIONS --}}
    <div class="d-flex flex-wrap gap-2 mb-4 no-print">
        <button type="button" class="btn-cyan" data-bs-toggle="modal" data-bs-target="#collectionModal">
            <i class="fas fa-plus"></i> {{ __('Record Sunday collection') }}
        </button>
        <button type="button" class="btn-ghost" data-bs-toggle="modal" data-bs-target="#deductionModal">
            <i class="fas fa-minus"></i> {{ __('Deduct from a fund') }}
        </button>
        <a href="{{ route('inventory.export', $filters) }}" class="btn-ghost ms-lg-auto">
            <i class="fas fa-file-csv"></i> {{ __('Export CSV') }}
        </a>
        <button type="button" class="btn-ghost" onclick="window.print()">
            <i class="fas fa-print"></i> {{ __('Print') }}
        </button>
    </div>

    {{-- FUND CARDS (click a fund to filter) --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <a href="{{ $without(['fund']) }}" class="fund-link {{ !$fundFilter ? '' : '' }}" title="{{ __('Show all funds') }}">
                <div class="stat-card fund-card">
                    <div class="stat-icon total"><i class="fas fa-wallet"></i></div>
                    <div>
                        <div class="stat-label">{{ __('Total balance') }}</div>
                        <div class="stat-value">{{ $peso($totalBalance) }}</div>
                        <div class="fund-meta"><span>{{ __('All three funds') }}</span></div>
                    </div>
                </div>
            </a>
        </div>

        @foreach($funds as $key => $fund)
            <div class="col-md-6 col-xl-3">
                <a href="{{ $fundFilter === $key ? $without(['fund']) : $with(['fund' => $key]) }}"
                   class="fund-link fund-{{ $key }} {{ $fundFilter === $key ? 'active' : '' }}"
                   title="{{ $fundFilter === $key ? __('Click to clear filter') : __('Click to filter by this fund') }}"
                   aria-pressed="{{ $fundFilter === $key ? 'true' : 'false' }}">
                    <div class="stat-card fund-card">
                        <div class="stat-icon"><i class="fas {{ $icons[$key] }}"></i></div>
                        <div>
                            <div class="stat-label">{{ __($fund['label']) }} {{ __('fund') }}</div>
                            <div class="stat-value">{{ $peso($fund['balance']) }}</div>
                            <div class="fund-meta">
                                <span class="in">{{ $hasRange ? __('In range') : __('Collected') }} <b>{{ $peso($hasRange ? $fund['range_collected'] : $fund['collected']) }}</b></span>
                                <span class="out">{{ __('Spent') }} <b>{{ $peso($hasRange ? $fund['range_spent'] : $fund['spent']) }}</b></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- FILTERS --}}
    <div class="panel mb-4 no-print">
        <div class="panel-body">
            <form method="GET" action="{{ route('inventory.index') }}" class="filter-bar {{ ($hasRange || $fundFilter || $typeFilter) ? 'fb-open' : '' }}" id="filterForm">
                <button type="button" class="fb-toggle" onclick="this.form.classList.toggle('fb-open')">
                    <span><i class="fas fa-sliders"></i> {{ __('Filters') }}</span>
                    @php $fbCount = collect([$hasRange, (bool) $fundFilter, (bool) $typeFilter])->filter()->count(); @endphp
                    @if($fbCount)<span class="fb-count">{{ $fbCount }}</span>@endif
                    <i class="fas fa-chevron-down fb-chev"></i>
                </button>
                <div class="fg">
                    <label for="f_from">{{ __('From') }}</label>
                    <input type="date" id="f_from" name="from" class="form-control" value="{{ $filters['from'] ?? '' }}">
                </div>
                <div class="fg">
                    <label for="f_to">{{ __('To') }}</label>
                    <input type="date" id="f_to" name="to" class="form-control" value="{{ $filters['to'] ?? '' }}">
                </div>
                <div class="fg">
                    <label for="f_fund">{{ __('Fund') }}</label>
                    <select id="f_fund" name="fund" class="form-select">
                        <option value="">{{ __('All funds') }}</option>
                        @foreach($funds as $key => $fund)
                            <option value="{{ $key }}" @selected($fundFilter === $key)>{{ __($fund['label']) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="fg">
                    <label for="f_type">{{ __('Type') }}</label>
                    <select id="f_type" name="type" class="form-select">
                        <option value="">{{ __('Collections & deductions') }}</option>
                        <option value="income"  @selected($typeFilter === 'income')>{{ __('Collections only') }}</option>
                        <option value="expense" @selected($typeFilter === 'expense')>{{ __('Deductions only') }}</option>
                    </select>
                </div>
                <div class="fg grow">
                    <label for="f_q">{{ __('Search') }}</label>
                    <input type="search" id="f_q" name="q" maxlength="100" class="form-control" placeholder="{{ __('Name or purpose') }}" value="{{ $filters['q'] ?? '' }}" autocomplete="off">
                </div>
                <div class="fg">
                    <label for="f_sort">{{ __('Sort by') }}</label>
                    <select id="f_sort" name="sort" class="form-select">
                        <option value="newest" @selected($sort === 'newest')>{{ __('Newest first') }}</option>
                        <option value="oldest" @selected($sort === 'oldest')>{{ __('Oldest first') }}</option>
                        <option value="high"   @selected($sort === 'high')>{{ __('Highest amount') }}</option>
                        <option value="low"    @selected($sort === 'low')>{{ __('Lowest amount') }}</option>
                    </select>
                </div>
                <div class="fg sm">
                    <label for="f_pp">{{ __('Per page') }}</label>
                    <select id="f_pp" name="per_page" class="form-select">
                        @foreach([15, 30, 50] as $n)
                            <option value="{{ $n }}" @selected($perPage === $n)>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
                <noscript><button type="submit" class="btn-cyan">{{ __('Apply') }}</button></noscript>
            </form>

            @if(count($chips))
                <div class="chip-row">
                    <span class="results-line">{{ __('Active filters') }}:</span>
                    @foreach($chips as $c)
                        <a href="{{ $c['url'] }}" class="chip" title="{{ __('Remove this filter') }}">
                            <i class="fas {{ $c['icon'] }} lead"></i>{{ $c['text'] }}
                            <span class="x"><i class="fas fa-xmark"></i></span>
                        </a>
                    @endforeach
                    <a href="{{ route('inventory.index') }}" class="clear-all">{{ __('Clear all') }}</a>
                </div>
            @endif
        </div>
    </div>

    {{-- SUNDAY COLLECTIONS --}}
    <div class="panel mb-4" id="inv-weekly">
        <div class="panel-head">
            <i class="fas fa-church"></i> {{ __('Sunday collections') }}
            <span class="cell-sub ms-auto" style="margin:0;">
                {{ $hasRange ? $dateText : __('Latest 12 Sundays') }}
                @if($fundFilter) · {{ __($funds[$fundFilter]['label']) }} @endif
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        @foreach($funds as $key => $fund)
                            @if(!$fundFilter || $fundFilter === $key)
                                <th class="text-end">{{ __($fund['label']) }}</th>
                            @endif
                        @endforeach
                        <th class="text-end">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php $colCount = ($fundFilter ? 1 : count($funds)) + 2; @endphp
                    @forelse($weekly as $date => $rows)
                        @php $byFund = $rows->pluck('total', 'fund'); @endphp
                        <tr style="--cols: {{ $colCount - 1 }}">
                            <td class="fw-semibold wk-date">{{ \Carbon\Carbon::parse($date)->format('D, M d, Y') }}</td>
                            @foreach($funds as $key => $fund)
                                @if(!$fundFilter || $fundFilter === $key)
                                    <td class="num" data-label="{{ __($fund["label"]) }}">{{ isset($byFund[$key]) ? $peso($byFund[$key]) : '—' }}</td>
                                @endif
                            @endforeach
                            <td class="num fw-bold" data-label="{{ __("Total") }}">{{ $peso($byFund->sum()) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ $colCount }}"><div class="empty-note"><i class="fas fa-church"></i>{{ __('No collections recorded for this period yet.') }}</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TRANSACTIONS --}}
    <div class="panel" id="inv-tx">
        <div class="panel-head">
            <i class="fas fa-receipt"></i> {{ __('Transactions') }}
            <span class="results-line ms-auto">
                @if($transactions->total() > 0)
                    {{ __('Showing') }} {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} {{ __('of') }} {{ $transactions->total() }}
                @else
                    {{ __('0 results') }}
                @endif
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Fund') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th class="text-end">{{ __('Amount') }}</th>
                        <th class="no-print" style="width:90px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                        @php $isIn = $t->isCollection(); @endphp
                        <tr>
                            <td class="text-nowrap">{{ $t->date->format('M d, Y') }}</td>
                            <td><span class="fund-pill fund-{{ $t->fund }}"><span class="fund-dot"></span>{{ $t->fundLabel() }}</span></td>
                            <td><span class="type-tag {{ $isIn ? 'in' : 'out' }}">{{ $isIn ? __('Collection') : __('Deduction') }}</span></td>
                            <td>
                                @if($isIn)
                                    <div class="fw-semibold">{{ $t->description }}</div>
                                    @if($t->donor_name)<div class="cell-sub">{{ __('From') }}: {{ $t->donor_name }}</div>@endif
                                @else
                                    <div class="fw-semibold">{{ __('Taken by') }}: {{ $t->recipient ?: '—' }}</div>
                                    <div class="cell-sub">{{ $t->purpose ?: $t->description }}</div>
                                @endif
                            </td>
                            <td class="text-end {{ $isIn ? 'amt-in' : 'amt-out' }}">{{ $isIn ? '+' : '−' }}{{ $peso($t->amount) }}</td>
                            <td class="no-print">
                                <div class="row-actions">
                                    <a href="{{ route('inventory.edit', $t) }}" class="icon-btn" title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}"><i class="fas fa-pen"></i></a>
                                    <button type="button" class="icon-btn del" title="{{ __('Delete') }}" aria-label="{{ __('Delete') }}"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-action="{{ route('inventory.destroy', $t) }}"
                                            data-label="{{ $t->fundLabel() }} · {{ $peso($t->amount) }} · {{ $t->date->format('M d, Y') }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty-note"><i class="fas fa-receipt"></i>{{ $hasFilter ? __('No transactions match these filters.') : __('No transactions yet. Record your first Sunday collection.') }}</div></td></tr>
                    @endforelse
                </tbody>
                @if($transactions->total() > 0)
                    <tfoot class="tfoot-total">
                        <tr>
                            <td colspan="4" class="text-end">{{ $hasFilter ? __('Totals for this filter') : __('Totals') }}</td>
                            <td class="text-end">
                                <div class="amt-in">+{{ $peso($totals->collected) }}</div>
                                <div class="amt-out">−{{ $peso($totals->spent) }}</div>
                            </td>
                            <td class="no-print"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="panel-body no-print">{{ $transactions->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
</div>

{{-- ============ MOBILE BOTTOM DOCK ============ --}}
<div class="inv-dock no-print" id="invDock" role="toolbar" aria-label="{{ __('Quick actions') }}">
    <button type="button" class="dk dk-main dk-rec" data-bs-toggle="modal" data-bs-target="#collectionModal">
        <i class="fas fa-plus"></i> {{ __('Record') }}
    </button>
    <button type="button" class="dk dk-main dk-ded" data-bs-toggle="modal" data-bs-target="#deductionModal">
        <i class="fas fa-minus"></i> {{ __('Deduct') }}
    </button>
    <span class="dk-sep"></span>
    <a href="{{ route('inventory.export', $filters) }}" class="dk dk-ico" title="{{ __('Export CSV') }}" aria-label="{{ __('Export CSV') }}">
        <i class="fas fa-file-csv"></i>
    </a>
    <button type="button" class="dk dk-ico" onclick="window.print()" title="{{ __('Print') }}" aria-label="{{ __('Print') }}">
        <i class="fas fa-print"></i>
    </button>
</div>
<script>
    /* Ibalhin sa <body> para husto ang pagka-fixed bisag naay animation sa page */
    (function () {
        var d = document.getElementById('invDock');
        if (d && d.parentNode !== document.body) document.body.appendChild(d);
    })();
</script>
{{-- ============ COLLECTION MODAL ============ --}}
<div class="modal fade" id="collectionModal" tabindex="-1" aria-labelledby="collectionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('inventory.collections.store') }}" class="modal-content" autocomplete="off">
            @csrf
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="collectionTitle">{{ __('Record Sunday collection') }}</h5>
                    <div class="cell-sub">{{ __('Leave a fund empty if nothing was collected for it.') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($collectionBag->any())
                    <div class="alert alert-danger py-2" style="font-size:.82rem;">
                        @foreach($collectionBag->all() as $msg)<div>{{ $msg }}</div>@endforeach
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label" for="c_date">{{ __('Sunday date') }}</label>
                    <input type="date" id="c_date" name="date" class="form-control" required max="{{ $today }}"
                           value="{{ old('date', $lastSunday) }}">
                </div>

                <div class="d-grid gap-2 mb-3">
                    @foreach($funds as $key => $fund)
                        <div class="fund-field">
                            <span class="fund-pill fund-{{ $key }}"><i class="fas {{ $icons[$key] }}"></i> {{ __($fund['label']) }}</span>
                            <div class="money-input">
                                <span>₱</span>
                                <input type="number" name="amounts[{{ $key }}]" class="form-control collect-amt" step="0.01" min="0" max="99999999.99"
                                       inputmode="decimal" placeholder="0.00" aria-label="{{ $fund['label'] }} amount"
                                       value="{{ old('amounts.' . $key) }}">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="form-label" for="c_note">{{ __('Note') }} <span class="text-muted fw-normal text-lowercase">({{ __('optional') }})</span></label>
                    <input type="text" id="c_note" name="note" class="form-control" maxlength="200" placeholder="{{ __('e.g. Anniversary Sunday') }}" value="{{ old('note') }}">
                </div>

                <div class="preview-box">
                    <div class="row-line"><span>{{ __('Total for this Sunday') }}</span><strong id="collectTotal">₱0.00</strong></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn-cyan"><i class="fas fa-check"></i> {{ __('Save collection') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ============ DEDUCTION MODAL ============ --}}
<div class="modal fade" id="deductionModal" tabindex="-1" aria-labelledby="deductionTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('inventory.deductions.store') }}" class="modal-content" id="deductionForm" autocomplete="off">
            @csrf
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="deductionTitle">{{ __('Deduct from a fund') }}</h5>
                    <div class="cell-sub">{{ __('Say who took the money and what it is for.') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($deductionBag->any())
                    <div class="alert alert-danger py-2" style="font-size:.82rem;">
                        @foreach($deductionBag->all() as $msg)<div>{{ $msg }}</div>@endforeach
                    </div>
                @endif

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label" for="d_fund">{{ __('Fund') }}</label>
                        <select id="d_fund" name="fund" class="form-select" required>
                            @foreach($funds as $key => $fund)
                                <option value="{{ $key }}" data-balance="{{ $fund['balance'] }}" @selected(old('fund', $fundFilter) === $key)>
                                    {{ __($fund['label']) }} — {{ $peso($fund['balance']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="d_date">{{ __('Date') }}</label>
                        <input type="date" id="d_date" name="date" class="form-control" required max="{{ $today }}" value="{{ old('date', $today) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="d_amount">{{ __('Amount') }}</label>
                        <div class="money-input">
                            <span>₱</span>
                            <input type="number" id="d_amount" name="amount" class="form-control" step="0.01" min="0.01" max="99999999.99"
                                   inputmode="decimal" placeholder="0.00" required value="{{ old('amount') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="d_recipient">{{ __('Taken by') }}</label>
                        <input type="text" id="d_recipient" name="recipient" class="form-control" maxlength="120" required
                               placeholder="{{ __('Full name of the person who took the money') }}" value="{{ old('recipient') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="d_purpose">{{ __('Purpose') }}</label>
                        <textarea id="d_purpose" name="purpose" class="form-control" rows="3" minlength="3" maxlength="500" required
                                  placeholder="{{ __('What is the money for?') }}">{{ old('purpose') }}</textarea>
                    </div>
                    <div class="col-12">
                        <div class="preview-box">
                            <div class="row-line"><span>{{ __('Available') }}</span><strong id="dAvailable">₱0.00</strong></div>
                            <div class="row-line"><span>{{ __('Deducting') }}</span><strong id="dDeduct">₱0.00</strong></div>
                            <div class="row-line" style="border-top:1px solid var(--border-color); margin-top:4px; padding-top:6px;">
                                <span>{{ __('Remaining') }}</span><strong id="dRemain">₱0.00</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn-cyan" id="deductSubmit"><i class="fas fa-check"></i> {{ __('Save deduction') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ============ DELETE MODAL ============ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form method="POST" action="#" class="modal-content" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTitle">{{ __('Delete transaction?') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1" style="font-size:.88rem;">{{ __('This cannot be undone.') }}</p>
                <p class="mb-0 cell-sub" id="deleteLabel"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var peso = function (n) {
        return '₱' + Number(n || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    /* ---------- FILTERS: auto-apply ---------- */
    var form = document.getElementById('filterForm');
    var from = document.getElementById('f_from');
    var to   = document.getElementById('f_to');
    var q    = document.getElementById('f_q');

    function syncDateLimits() {
        to.min   = from.value || '';
        from.max = to.value || '';
    }
    syncDateLimits();

    // strip empty fields so the URL stays clean (?fund=missions instead of ?from=&to=&fund=missions...)
    form.addEventListener('submit', function () {
        form.querySelectorAll('input, select').forEach(function (el) {
            if (!el.value) el.disabled = true;
        });
    });
    window.addEventListener('pageshow', function () {
        form.querySelectorAll('[disabled]').forEach(function (el) { el.disabled = false; });
    });

    form.querySelectorAll('select, input[type="date"]').forEach(function (el) {
        el.addEventListener('change', function () {
            if (from.value && to.value && to.value < from.value) {
                if (el === from) to.value = from.value; else from.value = to.value;
            }
            syncDateLimits();
            form.requestSubmit();
        });
    });

    var timer;
    q.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            try { sessionStorage.setItem('invFocusSearch', '1'); } catch (e) {}
            form.requestSubmit();
        }, 500);
    });
    q.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); clearTimeout(timer); try { sessionStorage.setItem('invFocusSearch', '1'); } catch (er) {} form.requestSubmit(); }
    });
    try {
        if (sessionStorage.getItem('invFocusSearch')) {
            sessionStorage.removeItem('invFocusSearch');
            q.focus();
            var len = q.value.length;
            q.setSelectionRange(len, len);
        }
    } catch (e) {}

    /* ---------- Collection total ---------- */
    var collectInputs = document.querySelectorAll('.collect-amt');
    var collectTotal  = document.getElementById('collectTotal');
    function updateCollect() {
        var sum = 0;
        collectInputs.forEach(function (i) { sum += parseFloat(i.value) || 0; });
        collectTotal.textContent = peso(sum);
    }
    collectInputs.forEach(function (i) { i.addEventListener('input', updateCollect); });
    updateCollect();

    /* ---------- Deduction preview (server still enforces) ---------- */
    var fundSel = document.getElementById('d_fund');
    var amtIn   = document.getElementById('d_amount');
    var submit  = document.getElementById('deductSubmit');
    function updateDeduct() {
        var bal = parseFloat(fundSel.selectedOptions[0].dataset.balance) || 0;
        var amt = parseFloat(amtIn.value) || 0;
        var rem = bal - amt;
        document.getElementById('dAvailable').textContent = peso(bal);
        document.getElementById('dDeduct').textContent    = peso(amt);
        var remEl = document.getElementById('dRemain');
        remEl.textContent = peso(rem);
        remEl.classList.toggle('bad', rem < 0);
        submit.disabled = rem < -0.004;
    }
    fundSel.addEventListener('change', updateDeduct);
    amtIn.addEventListener('input', updateDeduct);
    updateDeduct();

    /* ---------- Delete modal ---------- */
    document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
        var btn = e.relatedTarget;
        if (!btn) return;
        document.getElementById('deleteForm').action = btn.getAttribute('data-action');
        document.getElementById('deleteLabel').textContent = btn.getAttribute('data-label') || '';
    });

    @if($collectionBag->any())
        bootstrap.Modal.getOrCreateInstance(document.getElementById('collectionModal')).show();
    @elseif($deductionBag->any())
        bootstrap.Modal.getOrCreateInstance(document.getElementById('deductionModal')).show();
    @endif
});
</script>
@endpush