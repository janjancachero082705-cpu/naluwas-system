@extends('layouts.app')

@section('header')
    <span data-i18n="inventory_management">Inventory Management</span>
@endsection

@section('content')

<style>
    /* ==========================================================
       INVENTORY MANAGEMENT — 2025 REDESIGN
       Flat · bordered · airy · Inter
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .inv {
        --inv-card: var(--card-bg, #ffffff);
        --inv-border: var(--border-color, #e8eaf0);
        --inv-text: var(--text-primary, #0f172a);
        --inv-muted: var(--text-muted, #7c8494);
        --inv-soft: var(--bg-tertiary, #f5f6fa);

        --inv-primary: #4f46e5;
        --inv-primary-soft: rgba(79, 70, 229, .08);
        --inv-primary-ring: rgba(79, 70, 229, .18);

        --inv-green: #059669;
        --inv-green-soft: rgba(5, 150, 105, .10);
        --inv-rose: #e11d48;
        --inv-rose-soft: rgba(225, 29, 72, .09);
        --inv-amber: #d97706;
        --inv-amber-soft: rgba(217, 119, 6, .10);
        --inv-violet: #7c3aed;
        --inv-violet-soft: rgba(124, 58, 237, .10);

        --inv-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --inv-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --inv-shadow-lg: 0 20px 60px -24px rgba(15, 23, 42, .35);
        --inv-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--inv-text);
        padding-bottom: 2rem;
    }

    [data-theme="dark"] .inv {
        --inv-primary: #6366f1;
        --inv-primary-soft: rgba(99, 102, 241, .16);
        --inv-primary-ring: rgba(99, 102, 241, .28);
        --inv-green: #34d399;
        --inv-green-soft: rgba(16, 185, 129, .14);
        --inv-rose: #fb7185;
        --inv-rose-soft: rgba(244, 63, 94, .14);
        --inv-amber: #fbbf24;
        --inv-amber-soft: rgba(245, 158, 11, .14);
        --inv-violet: #a78bfa;
        --inv-violet-soft: rgba(139, 92, 246, .16);
        --inv-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --inv-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
        --inv-shadow-lg: 0 24px 60px -20px rgba(0, 0, 0, .85);
    }

    .inv * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .inv-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--inv-border);
        margin-bottom: 1.5rem;
    }

    .inv-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--inv-muted);
        margin-bottom: .55rem;
    }

    .inv-eyebrow .inv-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--inv-green);
        box-shadow: 0 0 0 3px var(--inv-green-soft);
    }

    .inv-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .inv-title i { font-size: 1.2rem; color: var(--inv-primary); }

    .inv-sub {
        margin: .5rem 0 0;
        font-size: .84rem;
        color: var(--inv-muted);
        max-width: 62ch;
        line-height: 1.5;
    }

    .inv-head-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .inv-btn {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem 1.1rem;
        border-radius: 11px;
        font-size: .79rem;
        font-weight: 600;
        font-family: inherit;
        line-height: 1.2;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        white-space: nowrap;
        transition: background .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }

    .inv-btn-primary {
        background: var(--inv-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .inv-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .inv-btn-green {
        background: var(--inv-green);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(5, 150, 105, .9);
    }
    .inv-btn-green:hover {
        background: #047857;
        color: #fff;
        transform: translateY(-1px);
    }

    .inv-btn-rose {
        background: var(--inv-rose);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(225, 29, 72, .9);
    }
    .inv-btn-rose:hover {
        background: #be123c;
        color: #fff;
        transform: translateY(-1px);
    }

    .inv-btn-ghost {
        background: var(--inv-card);
        color: var(--inv-text);
        border-color: var(--inv-border);
    }
    .inv-btn-ghost:hover {
        background: var(--inv-soft);
        color: var(--inv-text);
        transform: translateY(-1px);
    }

    /* ---------------- STATS ---------------- */
    .inv-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .inv-stat {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: 1.05rem 1.15rem;
        background: var(--inv-card);
        border: 1px solid var(--inv-border);
        border-radius: var(--inv-radius);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        position: relative;
    }

    .inv-stat:hover {
        transform: translateY(-3px);
        box-shadow: var(--inv-shadow-md);
        border-color: transparent;
    }

    .inv-stat .inv-stat-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        display: grid;
        place-items: center;
        font-size: 1rem;
        flex: 0 0 auto;
    }

    .inv-stat.green  .inv-stat-icon { background: var(--inv-green-soft);   color: var(--inv-green); }
    .inv-stat.rose   .inv-stat-icon { background: var(--inv-rose-soft);    color: var(--inv-rose); }
    .inv-stat.primary .inv-stat-icon { background: var(--inv-primary-soft); color: var(--inv-primary); }
    .inv-stat.violet .inv-stat-icon { background: var(--inv-violet-soft);  color: var(--inv-violet); }

    .inv-stat .inv-stat-body { min-width: 0; flex: 1; }

    .inv-stat .inv-stat-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--inv-muted);
        margin: 0 0 .2rem;
    }

    .inv-stat .inv-stat-value {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1.15;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .inv-stat .inv-stat-value.is-positive { color: var(--inv-green); }
    .inv-stat .inv-stat-value.is-negative { color: var(--inv-rose); }

    .inv-stat .inv-stat-meta {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        margin-top: .3rem;
        padding: .12rem .5rem;
        border-radius: 20px;
        font-size: .64rem;
        font-weight: 600;
        background: var(--inv-soft);
        color: var(--inv-muted);
    }

    .inv-stat .inv-stat-meta.positive { color: var(--inv-green); background: var(--inv-green-soft); }
    .inv-stat .inv-stat-meta.negative { color: var(--inv-rose);  background: var(--inv-rose-soft); }

    /* ---------------- SUMMARY BANNER ---------------- */
    .inv-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
        padding: 1.15rem 1.35rem;
        background: var(--inv-card);
        border: 1px solid var(--inv-border);
        border-radius: var(--inv-radius);
        box-shadow: var(--inv-shadow-sm);
        margin-bottom: 1.5rem;
        transition: box-shadow .22s ease;
    }

    .inv-summary:hover { box-shadow: var(--inv-shadow-md); }

    .inv-summary-left h4 {
        display: flex;
        align-items: center;
        gap: .45rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--inv-muted);
        margin: 0 0 .4rem;
    }

    .inv-summary-left h4 i { color: var(--inv-green); font-size: .7rem; }

    .inv-summary-amount {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -.04em;
        color: var(--inv-text);
        line-height: 1.1;
    }

    .inv-summary-left .small {
        font-size: .7rem;
        color: var(--inv-muted);
        margin-top: .15rem;
    }

    .inv-summary-right {
        display: flex;
        flex-direction: column;
        gap: .35rem;
        text-align: right;
    }

    .inv-summary-right .small {
        font-size: .74rem;
        color: var(--inv-muted);
        font-weight: 500;
    }

    .inv-summary-right .small strong { color: var(--inv-text); font-weight: 700; }
    .inv-summary-right .small.net-pos strong { color: var(--inv-green); }
    .inv-summary-right .small.net-neg strong { color: var(--inv-rose); }

    /* ---------------- CATEGORY GRID ---------------- */
    .inv-category-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .inv-card {
        background: var(--inv-card);
        border: 1px solid var(--inv-border);
        border-radius: var(--inv-radius);
        box-shadow: var(--inv-shadow-sm);
        overflow: hidden;
        transition: box-shadow .22s ease, border-color .22s ease;
    }

    .inv-card:hover {
        box-shadow: var(--inv-shadow-md);
        border-color: transparent;
    }

    .inv-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .9rem 1.15rem;
        border-bottom: 1px solid var(--inv-border);
        background: var(--inv-soft);
    }

    .inv-card-head-left {
        display: flex;
        align-items: center;
        gap: .65rem;
        min-width: 0;
    }

    .inv-card-head-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: .75rem;
        flex: 0 0 auto;
    }

    .inv-card-head-icon.green  { background: var(--inv-green-soft);   color: var(--inv-green); }
    .inv-card-head-icon.rose   { background: var(--inv-rose-soft);    color: var(--inv-rose); }
    .inv-card-head-icon.primary { background: var(--inv-primary-soft); color: var(--inv-primary); }

    .inv-card-head-title {
        font-size: .9rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        margin: 0;
    }

    .inv-card-head-sub {
        font-size: .7rem;
        color: var(--inv-muted);
        margin-top: .1rem;
    }

    .inv-card-head-tag {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .22rem .6rem;
        border-radius: 20px;
        border: 1px solid var(--inv-border);
        background: var(--inv-card);
        font-size: .64rem;
        font-weight: 600;
        color: var(--inv-muted);
        white-space: nowrap;
    }

    .inv-card-head-tag i { font-size: .56rem; color: var(--inv-primary); }

    .inv-cat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: .7rem 1.15rem;
        border-bottom: 1px solid var(--inv-border);
        transition: background .16s ease;
    }

    .inv-cat-item:last-of-type { border-bottom: none; }
    .inv-cat-item:hover { background: var(--inv-soft); }

    .inv-cat-item .name {
        font-size: .82rem;
        font-weight: 500;
        color: var(--inv-text);
    }

    .inv-cat-item .amt {
        font-size: .85rem;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
        letter-spacing: -.01em;
    }

    .inv-cat-item .amt.income  { color: var(--inv-green); }
    .inv-cat-item .amt.expense { color: var(--inv-rose); }

    .inv-cat-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .8rem 1.15rem;
        background: var(--inv-soft);
        border-top: 1px solid var(--inv-border);
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: -.005em;
        color: var(--inv-text);
    }

    .inv-cat-summary .amt { font-variant-numeric: tabular-nums; }
    .inv-cat-summary .amt.income  { color: var(--inv-green); }
    .inv-cat-summary .amt.expense { color: var(--inv-rose); }

    /* ---------------- TABLE ---------------- */
    .inv-table-container {
        background: var(--inv-card);
        border: 1px solid var(--inv-border);
        border-radius: var(--inv-radius);
        box-shadow: var(--inv-shadow-sm);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: box-shadow .22s ease, border-color .22s ease;
    }

    .inv-table-container:hover {
        box-shadow: var(--inv-shadow-md);
        border-color: transparent;
    }

    .inv-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .9rem 1.15rem;
        border-bottom: 1px solid var(--inv-border);
        background: var(--inv-soft);
    }

    .inv-table-header h6 {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0;
        font-size: .88rem;
        font-weight: 700;
        letter-spacing: -.005em;
        color: var(--inv-text);
    }

    .inv-table-header h6 i {
        display: grid;
        place-items: center;
        width: 30px; height: 30px;
        border-radius: 9px;
        font-size: .7rem;
        background: var(--inv-primary-soft);
        color: var(--inv-primary);
    }

    .inv-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--inv-card);
    }

    .inv-table thead th {
        text-align: left;
        padding: .8rem 1.15rem;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--inv-muted) !important;
        background: var(--inv-card);
        border-bottom: 1px solid var(--inv-border);
        white-space: nowrap;
    }

    .inv-table tbody td {
        padding: .7rem 1.15rem;
        vertical-align: middle;
        color: var(--inv-text) !important;
        background: var(--inv-card);
        border-bottom: 1px solid var(--inv-border);
        font-size: .82rem;
        transition: background .16s ease;
    }

    .inv-table tbody tr:last-child td { border-bottom: none; }
    .inv-table tbody tr { transition: background .16s ease; }
    .inv-table tbody tr:hover td { background: var(--inv-soft) !important; }

    .inv-table .text-muted { color: var(--inv-muted) !important; }

    .inv-type-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .24rem .65rem;
        border-radius: 20px;
        font-size: .66rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .inv-type-badge.income {
        background: var(--inv-green-soft);
        color: var(--inv-green);
    }

    .inv-type-badge.expense {
        background: var(--inv-rose-soft);
        color: var(--inv-rose);
    }

    .inv-type-badge i { font-size: .58rem; }

    .inv-cat-badge {
        display: inline-block;
        padding: .2rem .65rem;
        border-radius: 20px;
        font-size: .66rem;
        font-weight: 500;
        background: var(--inv-soft);
        border: 1px solid var(--inv-border);
        color: var(--inv-muted);
    }

    .inv-amount-pos { color: var(--inv-green) !important; font-weight: 700; font-variant-numeric: tabular-nums; }
    .inv-amount-neg { color: var(--inv-rose) !important; font-weight: 700; font-variant-numeric: tabular-nums; }

    .inv-action-btns {
        display: flex;
        gap: 4px;
        justify-content: center;
    }

    .inv-icon-btn {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: inline-grid;
        place-items: center;
        border: 1px solid var(--inv-border);
        background: transparent;
        color: var(--inv-muted);
        cursor: pointer;
        font-size: .72rem;
        text-decoration: none;
        transition: background .16s ease, color .16s ease, border-color .16s ease;
    }

    .inv-icon-btn:hover { transform: translateY(-1px); }
    .inv-icon-btn.edit:hover   { background: var(--inv-primary-soft); color: var(--inv-primary); border-color: transparent; }
    .inv-icon-btn.delete:hover { background: var(--inv-rose-soft);    color: var(--inv-rose);    border-color: transparent; }

    /* ---------------- EMPTY ---------------- */
    .inv-empty {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--inv-muted);
    }

    .inv-empty i {
        font-size: 2.4rem;
        color: var(--inv-muted);
        opacity: .35;
        display: block;
        margin-bottom: .9rem;
    }

    .inv-empty p { font-size: .85rem; margin: 0 0 .35rem; font-weight: 600; color: var(--inv-text); }
    .inv-empty small { font-size: .75rem; color: var(--inv-muted); }

    /* ==========================================================
       MODALS — FIXED
    ========================================================== */
    .modal-content-premium {
        --inv-card: var(--card-bg, #ffffff);
        --inv-border: var(--border-color, #e8eaf0);
        --inv-text: var(--text-primary, #0f172a);
        --inv-muted: var(--text-muted, #7c8494);
        --inv-soft: var(--bg-tertiary, #f5f6fa);
        --inv-primary: #4f46e5;
        --inv-primary-soft: rgba(79, 70, 229, .08);
        --inv-primary-ring: rgba(79, 70, 229, .18);
        --inv-green: #059669;
        --inv-green-soft: rgba(5, 150, 105, .10);
        --inv-rose: #e11d48;
        --inv-rose-soft: rgba(225, 29, 72, .09);
        --inv-amber: #d97706;
        --inv-amber-soft: rgba(217, 119, 6, .10);
        --inv-violet: #7c3aed;
        --inv-violet-soft: rgba(124, 58, 237, .10);
        --inv-shadow-lg: 0 20px 60px -24px rgba(15, 23, 42, .35);

        background: var(--inv-card) !important;
        border: 1px solid var(--inv-border) !important;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--inv-shadow-lg);
        color: var(--inv-text);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    [data-theme="dark"] .modal-content-premium {
        --inv-card: var(--card-bg, #1e1e2d);
        --inv-border: var(--border-color, #2a2a3d);
        --inv-text: var(--text-primary, #f1f5f9);
        --inv-muted: var(--text-muted, #94a3b8);
        --inv-soft: var(--bg-tertiary, #262636);
        --inv-primary: #6366f1;
        --inv-primary-soft: rgba(99, 102, 241, .16);
        --inv-primary-ring: rgba(99, 102, 241, .28);
        --inv-green: #34d399;
        --inv-green-soft: rgba(16, 185, 129, .14);
        --inv-rose: #fb7185;
        --inv-rose-soft: rgba(244, 63, 94, .14);
        --inv-amber: #fbbf24;
        --inv-amber-soft: rgba(245, 158, 11, .14);
        --inv-violet: #a78bfa;
        --inv-violet-soft: rgba(139, 92, 246, .16);
        --inv-shadow-lg: 0 24px 60px -20px rgba(0, 0, 0, .85);
    }

    .modal-backdrop {
        background: rgba(15, 23, 42, .55) !important;
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
    }

    .modal-backdrop.show { opacity: 1 !important; }

    [data-theme="dark"] .modal-backdrop {
        background: rgba(0, 0, 0, .7) !important;
    }

    .modal-dialog { z-index: 1056; }

    .modal-header-premium {
        padding: 1rem 1.35rem;
        border-bottom: 1px solid var(--inv-border);
        background: var(--inv-soft);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }

    .modal-header-premium .modal-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .95rem;
        font-weight: 700;
        color: var(--inv-text);
        letter-spacing: -.005em;
        margin: 0;
    }

    .modal-header-premium .modal-title i { font-size: .95rem; }

    .modal-header-premium p {
        color: var(--inv-muted);
        font-size: .72rem;
        margin: .25rem 0 0;
    }

    .modal-body { padding: 1.35rem; }

    .modal-footer {
        padding: 1rem 1.35rem;
        border-top: 1px solid var(--inv-border);
        background: var(--inv-soft);
        display: flex;
        justify-content: flex-end;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* Category Pills */
    .category-pills-premium {
        display: flex;
        flex-wrap: wrap;
        gap: .45rem;
    }

    .category-pill-premium {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem .85rem;
        border-radius: 10px;
        font-size: .72rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .16s ease, color .16s ease, border-color .16s ease, transform .16s ease;
        background: var(--inv-card);
        border: 1px solid var(--inv-border);
        color: var(--inv-muted);
        user-select: none;
    }

    .category-pill-premium i { font-size: .68rem; }

    .category-pill-premium:hover {
        border-color: var(--inv-primary);
        color: var(--inv-primary);
        transform: translateY(-1px);
    }

    .category-pill-premium.selected {
        background: var(--inv-primary);
        border-color: var(--inv-primary);
        color: #fff;
        box-shadow: 0 6px 16px -8px rgba(79, 70, 229, .9);
    }

    /* Form */
    .form-label-premium {
        display: flex;
        align-items: center;
        gap: .35rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--inv-muted);
        margin-bottom: .4rem;
    }

    .form-label-premium i { font-size: .62rem; color: var(--inv-primary); }

    .form-control-premium {
        width: 100%;
        padding: .6rem .9rem;
        border-radius: 11px;
        border: 1px solid var(--inv-border);
        background: var(--inv-soft);
        color: var(--inv-text);
        font-size: .82rem;
        font-family: inherit;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .form-control-premium::placeholder { color: var(--inv-muted); opacity: .8; }

    .form-control-premium:focus {
        outline: none;
        background: var(--inv-card);
        border-color: var(--inv-primary);
        box-shadow: 0 0 0 3px var(--inv-primary-ring);
    }

    .input-group-text-premium {
        background: var(--inv-soft);
        border: 1px solid var(--inv-border);
        border-right: none;
        color: var(--inv-muted);
        font-size: .82rem;
        font-weight: 600;
        border-radius: 11px 0 0 11px;
        padding: .6rem .85rem;
    }

    .amount-preview-premium {
        padding: .9rem 1.15rem;
        border-radius: 12px;
        border: 1px solid transparent;
        margin-top: 1rem;
        font-size: .82rem;
    }

    .alert-success-premium {
        background: var(--inv-green-soft);
        color: var(--inv-green);
        border-color: transparent;
    }

    .alert-info-premium {
        background: var(--inv-primary-soft);
        color: var(--inv-primary);
        border-color: transparent;
    }

    .alert-danger-premium {
        background: var(--inv-rose-soft);
        color: var(--inv-rose);
        border-color: transparent;
        padding: .7rem 1rem;
        border-radius: 10px;
        font-size: .78rem;
        margin-top: .8rem;
    }

    /* Buttons */
    .btn-secondary-premium {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--inv-card);
        color: var(--inv-text);
        border: 1px solid var(--inv-border);
        padding: .55rem 1.2rem;
        border-radius: 11px;
        font-size: .78rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .16s ease, transform .16s ease;
    }

    .btn-secondary-premium:hover {
        background: var(--inv-soft);
        transform: translateY(-1px);
    }

    .btn-success-premium {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--inv-green);
        color: #fff;
        border: none;
        padding: .55rem 1.4rem;
        border-radius: 11px;
        font-size: .78rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 8px 18px -10px rgba(5, 150, 105, .9);
        transition: background .16s ease, transform .16s ease, box-shadow .16s ease;
    }

    .btn-success-premium:hover {
        background: #047857;
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-danger-premium {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--inv-rose);
        color: #fff;
        border: none;
        padding: .55rem 1.4rem;
        border-radius: 11px;
        font-size: .78rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 8px 18px -10px rgba(225, 29, 72, .9);
        transition: background .16s ease, transform .16s ease, box-shadow .16s ease;
    }

    .btn-danger-premium:hover:not(:disabled) {
        background: #be123c;
        transform: translateY(-1px);
        color: #fff;
    }

    .btn-danger-premium:disabled {
        opacity: .45;
        cursor: not-allowed;
        box-shadow: none;
    }

    .btn-primary-premium {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--inv-primary);
        color: #fff;
        border: none;
        padding: .55rem 1.4rem;
        border-radius: 11px;
        font-size: .78rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
        transition: background .16s ease, transform .16s ease, box-shadow .16s ease;
    }

    .btn-primary-premium:hover {
        background: #4338ca;
        transform: translateY(-1px);
        color: #fff;
    }

    /* Filter tabs */
    .filter-tabs-premium {
        display: flex;
        gap: .4rem;
        flex-wrap: wrap;
        padding-bottom: .75rem;
        border-bottom: 1px solid var(--inv-border);
    }

    .filter-tab-premium {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .4rem 1rem;
        border-radius: 10px;
        border: 1px solid var(--inv-border);
        background: var(--inv-card);
        color: var(--inv-muted);
        font-size: .74rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: background .16s ease, color .16s ease, border-color .16s ease, transform .16s ease;
    }

    .filter-tab-premium:hover {
        background: var(--inv-soft);
        color: var(--inv-text);
        transform: translateY(-1px);
    }

    .filter-tab-premium.active {
        background: var(--inv-primary);
        border-color: var(--inv-primary);
        color: #fff;
    }

    .filter-tab-premium i { font-size: .65rem; }

    /* Modal filter container */
    .modal-filter-container {
        display: flex;
        flex-wrap: wrap;
        gap: .65rem;
        align-items: center;
        margin-bottom: 1rem;
        padding: .85rem 1.15rem;
        background: var(--inv-soft);
        border-radius: 12px;
        border: 1px solid var(--inv-border);
    }

    .modal-filter-container label {
        display: flex;
        align-items: center;
        gap: .3rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--inv-muted);
        margin: 0;
    }

    .modal-filter-container select,
    .modal-filter-container input {
        padding: .42rem .75rem;
        border: 1px solid var(--inv-border);
        border-radius: 9px;
        background: var(--inv-card);
        color: var(--inv-text);
        font-size: .78rem;
        font-family: inherit;
        cursor: pointer;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .modal-filter-container select:focus,
    .modal-filter-container input:focus {
        outline: none;
        border-color: var(--inv-primary);
        box-shadow: 0 0 0 3px var(--inv-primary-ring);
    }

    .modal-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .42rem 1rem;
        background: var(--inv-primary);
        color: #fff;
        border: none;
        border-radius: 9px;
        font-size: .75rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: background .16s ease, transform .16s ease;
    }

    .modal-filter-btn:hover {
        background: #4338ca;
        transform: translateY(-1px);
    }

    .modal-filter-btn:disabled {
        opacity: .5;
        cursor: not-allowed;
        transform: none;
    }

    /* Transaction summary */
    .transaction-summary-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: .75rem;
    }

    .summary-item-premium {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .8rem 1rem;
        background: var(--inv-soft);
        border: 1px solid var(--inv-border);
        border-radius: 12px;
        transition: transform .2s ease, border-color .2s ease;
    }

    .summary-item-premium:hover {
        transform: translateY(-2px);
        border-color: transparent;
    }

    .summary-icon-premium {
        width: 38px; height: 38px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        font-size: .85rem;
        flex: 0 0 auto;
    }

    .summary-icon-premium.income-bg  { background: var(--inv-green-soft);   color: var(--inv-green); }
    .summary-icon-premium.expense-bg { background: var(--inv-rose-soft);    color: var(--inv-rose); }
    .summary-icon-premium.balance-bg { background: var(--inv-primary-soft); color: var(--inv-primary); }
    .summary-icon-premium.total-bg   { background: var(--inv-violet-soft);  color: var(--inv-violet); }

    .summary-info { min-width: 0; }

    .summary-label {
        display: block;
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--inv-muted);
        margin-bottom: .1rem;
    }

    .summary-value {
        display: block;
        font-size: .9rem;
        font-weight: 700;
        color: var(--inv-text);
        font-variant-numeric: tabular-nums;
        letter-spacing: -.01em;
    }

    /* Search */
    .search-bar-premium { max-width: 320px; }
    .search-bar-premium .input-group { display: flex; }
    .search-bar-premium .input-group-text {
        display: grid;
        place-items: center;
        padding: 0 .8rem;
        background: var(--inv-soft);
        border: 1px solid var(--inv-border);
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: var(--inv-muted);
        font-size: .75rem;
    }

    .search-bar-premium .form-control-premium {
        border-left: none;
        border-radius: 0 10px 10px 0;
    }

    /* ---------------- EXPORT MODAL ---------------- */
    .export-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .55);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        animation: invFadeIn .22s ease;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .export-modal-overlay.active { display: flex; }

    .export-modal-content {
        --inv-card: var(--card-bg, #ffffff);
        --inv-border: var(--border-color, #e8eaf0);
        --inv-text: var(--text-primary, #0f172a);
        --inv-muted: var(--text-muted, #7c8494);
        --inv-soft: var(--bg-tertiary, #f5f6fa);
        --inv-primary: #4f46e5;
        --inv-primary-soft: rgba(79, 70, 229, .08);
        --inv-primary-ring: rgba(79, 70, 229, .18);
        --inv-green: #059669;
        --inv-green-soft: rgba(5, 150, 105, .10);
        --inv-rose: #e11d48;

        background: var(--inv-card);
        border: 1px solid var(--inv-border);
        border-radius: 18px;
        padding: 1.75rem;
        max-width: 640px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 24px 60px -20px rgba(15, 23, 42, .4);
        color: var(--inv-text);
    }

    [data-theme="dark"] .export-modal-content {
        --inv-card: var(--card-bg, #1e1e2d);
        --inv-border: var(--border-color, #2a2a3d);
        --inv-text: var(--text-primary, #f1f5f9);
        --inv-muted: var(--text-muted, #94a3b8);
        --inv-soft: var(--bg-tertiary, #262636);
        --inv-primary: #6366f1;
        --inv-primary-soft: rgba(99, 102, 241, .16);
        --inv-green: #34d399;
        --inv-green-soft: rgba(16, 185, 129, .14);
        --inv-rose: #fb7185;
    }

    .export-modal-content .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--inv-border);
    }

    .export-modal-content .modal-header-custom h3 {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: 1rem;
        font-weight: 700;
        color: var(--inv-text);
        margin: 0;
        letter-spacing: -.01em;
    }

    .export-modal-content .modal-header-custom h3 i { color: var(--inv-primary); }

    .export-modal-content .modal-header-custom .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        line-height: 1;
        color: var(--inv-muted);
        cursor: pointer;
        padding: 0 .35rem;
        transition: color .2s ease, transform .2s ease;
    }

    .export-modal-content .modal-header-custom .close-btn:hover {
        color: var(--inv-text);
        transform: rotate(90deg);
    }

    .export-section-group { margin-bottom: 1.25rem; }

    .export-section-group .checkbox-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .5rem;
    }

    .export-section-group .checkbox-item {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .55rem .8rem;
        border-radius: 11px;
        background: var(--inv-soft);
        border: 1px solid var(--inv-border);
        transition: border-color .18s ease, background .18s ease;
        cursor: pointer;
    }

    .export-section-group .checkbox-item:hover {
        border-color: var(--inv-primary);
        background: var(--inv-primary-soft);
    }

    .export-section-group .checkbox-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--inv-primary);
        cursor: pointer;
        flex-shrink: 0;
    }

    .export-section-group .checkbox-item label {
        font-size: .76rem;
        font-weight: 600;
        color: var(--inv-text);
        margin: 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
    }

    .export-section-group .checkbox-item label i { font-size: .72rem; color: var(--inv-primary); }

    .select-all-row {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .55rem .8rem;
        border-radius: 11px;
        background: var(--inv-primary-soft);
        border: 1px solid transparent;
        margin-bottom: .85rem;
        cursor: pointer;
    }

    .select-all-row input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--inv-primary);
        cursor: pointer;
    }

    .select-all-row label {
        font-size: .8rem;
        font-weight: 700;
        color: var(--inv-text);
        margin: 0;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
    }

    .export-actions {
        display: flex;
        gap: .6rem;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--inv-border);
        flex-wrap: wrap;
    }

    .export-actions .btn-export {
        flex: 1;
        min-width: 120px;
        padding: .7rem 1.2rem;
        border-radius: 11px;
        font-weight: 700;
        font-size: .8rem;
        font-family: inherit;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .btn-export-pdf {
        background: var(--inv-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .btn-export-pdf:hover { background: #4338ca; transform: translateY(-1px); }

    .btn-export-print {
        background: var(--inv-green);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(5, 150, 105, .9);
    }
    .btn-export-print:hover { background: #047857; transform: translateY(-1px); }

    .btn-export-cancel {
        background: var(--inv-card);
        color: var(--inv-text);
        border: 1px solid var(--inv-border);
    }
    .btn-export-cancel:hover { background: var(--inv-soft); transform: translateY(-1px); }

    /* ---------------- PDF EXPORT WRAPPER (print) ---------------- */
    .pdf-export-wrapper {
        display: none;
        background: white;
        padding: 30px;
        max-width: 1100px;
        margin: 0 auto;
        font-family: 'Inter', Arial, sans-serif;
        color: #1a1a2e;
    }

    .pdf-export-wrapper .pdf-header {
        text-align: center;
        padding-bottom: 20px;
        margin-bottom: 25px;
        border-bottom: 2px solid #4F46E5;
    }

    .pdf-export-wrapper .pdf-header h1 {
        font-size: 24px;
        font-weight: 800;
        color: #4F46E5;
        margin: 0 0 5px 0;
    }

    .pdf-export-wrapper .pdf-header p {
        color: #666;
        margin: 0;
        font-size: 14px;
    }

    .pdf-export-wrapper .pdf-header .pdf-date {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }

    .pdf-export-wrapper .pdf-section {
        margin-bottom: 25px;
        page-break-inside: avoid;
    }

    .pdf-export-wrapper .pdf-section .pdf-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #4F46E5;
        padding-bottom: 8px;
        margin-bottom: 12px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pdf-export-wrapper .pdf-section .pdf-section-title i { color: #4F46E5; }

    .pdf-export-wrapper .pdf-section .pdf-section-title .pdf-date-badge {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        background: #f9fafb;
        padding: 2px 12px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
    }

    .pdf-export-wrapper .pdf-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .pdf-export-wrapper .pdf-stat-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 15px 20px;
        text-align: center;
    }

    .pdf-export-wrapper .pdf-stat-card .pdf-stat-value {
        font-size: 22px;
        font-weight: 800;
        color: #1a1a2e;
    }

    .pdf-export-wrapper .pdf-stat-card .pdf-stat-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .pdf-export-wrapper .pdf-stat-card .pdf-stat-change {
        font-size: 11px;
        font-weight: 600;
        margin-top: 4px;
    }

    .pdf-export-wrapper .pdf-stat-card .pdf-stat-change.positive { color: #10B981; }
    .pdf-export-wrapper .pdf-stat-card .pdf-stat-change.negative { color: #EF4444; }

    .pdf-export-wrapper .pdf-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .pdf-export-wrapper .pdf-table thead th {
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
        padding: 8px 12px;
        text-align: left;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.5px;
    }

    .pdf-export-wrapper .pdf-table tbody td {
        padding: 8px 12px;
        border-bottom: 1px solid #f0f0f0;
        color: #1a1a2e;
    }

    .pdf-export-wrapper .pdf-table tbody tr:last-child td { border-bottom: none; }

    .pdf-export-wrapper .pdf-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .pdf-export-wrapper .pdf-badge.income { background: #d1fae5; color: #065f46; }
    .pdf-export-wrapper .pdf-badge.expense { background: #fee2e2; color: #991b1b; }

    .pdf-export-wrapper .pdf-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
        font-size: 12px;
        color: #999;
    }

    .pdf-export-wrapper .pdf-footer strong { color: #4F46E5; }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 1200px) {
        .inv-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 992px) {
        .inv-head { flex-direction: column; align-items: flex-start; }
        .inv-head-actions { width: 100%; }
        .inv-head-actions .inv-btn { flex: 1; justify-content: center; }
        .inv-category-grid { grid-template-columns: 1fr; }
        .export-section-group .checkbox-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .inv-title { font-size: 1.3rem; }
        .inv-sub { font-size: .78rem; }

        .inv-stats { grid-template-columns: 1fr; gap: .8rem; }
        .inv-stat { padding: .9rem; }
        .inv-stat .inv-stat-value { font-size: 1.15rem; }
        .inv-stat .inv-stat-icon { width: 38px; height: 38px; font-size: .85rem; }

        .inv-summary { flex-direction: column; align-items: flex-start; }
        .inv-summary-right { text-align: left; }

        .inv-table-header { flex-direction: column; align-items: flex-start; }

        .inv-table thead th,
        .inv-table tbody td { padding: .55rem .75rem; font-size: .7rem; }

        .modal-body { padding: 1rem; }
        .modal-header-premium { padding: .9rem 1rem; }
        .modal-footer { padding: .85rem 1rem; }

        .modal-filter-container { flex-direction: column; align-items: stretch; }
        .modal-filter-container label { justify-content: flex-start; }
        .modal-filter-container select,
        .modal-filter-container input { width: 100%; }

        .search-bar-premium { max-width: 100%; }

        .export-modal-content { padding: 1.25rem; }
        .export-actions { flex-direction: column; }
        .export-actions .btn-export { width: 100%; }
    }

    @media (max-width: 480px) {
        .inv-head-actions { flex-direction: column; }
        .inv-head-actions .inv-btn { width: 100%; justify-content: center; }
        .transaction-summary-premium { grid-template-columns: 1fr; }
    }

    @keyframes invFadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>

{{-- ============================================= --}}
{{-- MAIN CONTENT --}}
{{-- ============================================= --}}
<div class="inv container-fluid px-0" id="reportContent">

    {{-- HEADER --}}
    <header class="inv-head">
        <div>
            <div class="inv-eyebrow">
                <span class="inv-dot"></span>
                <span data-i18n="inventory_management">Inventory Management</span>
            </div>
            <h1 class="inv-title">
                <i class="fas fa-boxes"></i>
                <span data-i18n="inventory_management">Inventory Management</span>
            </h1>
            <p class="inv-sub" data-i18n="inventory_desc">
                Track church finances, income, expenses, and donations
            </p>
        </div>
        <div class="inv-head-actions">
            <button type="button" class="inv-btn inv-btn-green" data-bs-toggle="modal" data-bs-target="#incomeModal">
                <i class="fas fa-plus-circle"></i>
                <span data-i18n="income_label">Income</span>
            </button>
            <button type="button" class="inv-btn inv-btn-rose" data-bs-toggle="modal" data-bs-target="#expenseModal">
                <i class="fas fa-minus-circle"></i>
                <span data-i18n="expense_label">Expense</span>
            </button>
            <button type="button" class="inv-btn inv-btn-ghost" data-bs-toggle="modal" data-bs-target="#transactionsModal">
                <i class="fas fa-list"></i>
                <span data-i18n="all_transactions">All Transactions</span>
            </button>
            <button type="button" class="inv-btn inv-btn-primary" onclick="openExportModal()">
                <i class="fas fa-file-pdf"></i>
                <span data-i18n="export_pdf">Export PDF</span>
            </button>
        </div>
    </header>

    {{-- STATS CARDS --}}
    <section class="inv-stats" id="statsSection">
        <div class="inv-stat green">
            <div class="inv-stat-icon"><i class="fas fa-arrow-down"></i></div>
            <div class="inv-stat-body">
                <p class="inv-stat-label" data-i18n="total_income">Total Income</p>
                <div class="inv-stat-value is-positive" id="totalIncome">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
                <span class="inv-stat-meta positive">
                    <i class="fas fa-arrow-up"></i>
                    <span data-i18n="all_time">All time</span>
                </span>
            </div>
        </div>

        <div class="inv-stat rose">
            <div class="inv-stat-icon"><i class="fas fa-arrow-up"></i></div>
            <div class="inv-stat-body">
                <p class="inv-stat-label" data-i18n="total_expenses">Total Expenses</p>
                <div class="inv-stat-value is-negative" id="totalExpense">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
                <span class="inv-stat-meta negative">
                    <i class="fas fa-arrow-down"></i>
                    <span data-i18n="all_time">All time</span>
                </span>
            </div>
        </div>

        <div class="inv-stat primary">
            <div class="inv-stat-icon"><i class="fas fa-calculator"></i></div>
            <div class="inv-stat-body">
                <p class="inv-stat-label" data-i18n="net_balance">Net Balance</p>
                <div class="inv-stat-value {{ ($balance ?? 0) >= 0 ? 'is-positive' : 'is-negative' }}" id="netBalance">
                    {{ ($balance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($balance ?? 0), 2) }}
                </div>
                <span class="inv-stat-meta {{ ($balance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($balance ?? 0) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
                </span>
            </div>
        </div>

        <div class="inv-stat violet">
            <div class="inv-stat-icon"><i class="fas fa-church"></i></div>
            <div class="inv-stat-body">
                <p class="inv-stat-label" data-i18n="church_balance">Church Balance</p>
                <div class="inv-stat-value {{ ($allTimeBalance ?? 0) >= 0 ? 'is-positive' : 'is-negative' }}" id="churchBalance">
                    {{ ($allTimeBalance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($allTimeBalance ?? 0), 2) }}
                </div>
                <span class="inv-stat-meta {{ ($allTimeBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($allTimeBalance ?? 0) >= 0 ? '↑ Available' : '↓ Shortfall' }}
                </span>
            </div>
        </div>
    </section>

    {{-- SUMMARY BANNER --}}
    <div class="inv-summary" id="summarySection">
        <div class="inv-summary-left">
            <h4>
                <i class="fas fa-chart-line"></i>
                <span data-i18n="financial_summary">Financial Summary</span>
            </h4>
            <div class="inv-summary-amount">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="small" data-i18n="total_income">Total Income</div>
        </div>
        <div class="inv-summary-right">
            <div class="small">
                <span data-i18n="expenses">Expenses:</span>
                <strong>₱{{ number_format($totalExpense ?? 0, 2) }}</strong>
            </div>
            <div class="small {{ ($balance ?? 0) >= 0 ? 'net-pos' : 'net-neg' }}">
                <span data-i18n="net">Net:</span>
                <strong>{{ ($balance ?? 0) >= 0 ? '+' : '' }}₱{{ number_format($balance ?? 0, 2) }}</strong>
            </div>
        </div>
    </div>

    {{-- CATEGORY GRID --}}
    <div class="inv-category-grid" id="categorySection">

        {{-- INCOME BREAKDOWN --}}
        <div class="inv-card" id="incomeCategoryCard">
            <div class="inv-card-head">
                <div class="inv-card-head-left">
                    <div class="inv-card-head-icon green"><i class="fas fa-arrow-down"></i></div>
                    <div>
                        <h2 class="inv-card-head-title" data-i18n="income_breakdown">Income Breakdown</h2>
                        <div class="inv-card-head-sub" data-i18n="income_by_category">Income grouped by category</div>
                    </div>
                </div>
                <span class="inv-card-head-tag">
                    <i class="fas fa-calendar-alt"></i>
                    @php
                        $incomeDates = [];
                        if(isset($incomeByCategory) && !empty($incomeByCategory)) {
                            if(isset($recentTransactions)) {
                                foreach($recentTransactions as $t) {
                                    if($t->type == 'income' && $t->date) {
                                        $incomeDates[] = $t->date;
                                    }
                                }
                            }
                        }
                        if(!empty($incomeDates)) {
                            sort($incomeDates);
                            $firstIncome = $incomeDates[0];
                            $lastIncome = end($incomeDates);
                            echo \Carbon\Carbon::parse($firstIncome)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($lastIncome)->format('M d, Y');
                        } else {
                            echo __('No records yet');
                        }
                    @endphp
                </span>
            </div>
            @forelse(($incomeByCategory ?? []) as $category => $amount)
                <div class="inv-cat-item">
                    <span class="name">{{ $category }}</span>
                    <span class="amt income">₱{{ number_format($amount, 2) }}</span>
                </div>
            @empty
                <div class="inv-cat-item">
                    <span class="name" data-i18n="no_income_records">No income records yet</span>
                    <span class="amt income">₱0.00</span>
                </div>
            @endforelse
            <div class="inv-cat-summary">
                <span data-i18n="total_income">Total Income</span>
                <span class="amt income">₱{{ number_format($allTimeIncome ?? 0, 2) }}</span>
            </div>
        </div>

        {{-- EXPENSE BREAKDOWN --}}
        <div class="inv-card" id="expenseCategoryCard">
            <div class="inv-card-head">
                <div class="inv-card-head-left">
                    <div class="inv-card-head-icon rose"><i class="fas fa-arrow-up"></i></div>
                    <div>
                        <h2 class="inv-card-head-title" data-i18n="expense_breakdown">Expense Breakdown</h2>
                        <div class="inv-card-head-sub" data-i18n="expense_by_category">Expenses grouped by category</div>
                    </div>
                </div>
                <span class="inv-card-head-tag">
                    <i class="fas fa-calendar-alt"></i>
                    @php
                        $expenseDates = [];
                        if(isset($expenseByCategory) && !empty($expenseByCategory)) {
                            if(isset($recentTransactions)) {
                                foreach($recentTransactions as $t) {
                                    if($t->type == 'expense' && $t->date) {
                                        $expenseDates[] = $t->date;
                                    }
                                }
                            }
                        }
                        if(!empty($expenseDates)) {
                            sort($expenseDates);
                            $firstExpense = $expenseDates[0];
                            $lastExpense = end($expenseDates);
                            echo \Carbon\Carbon::parse($firstExpense)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($lastExpense)->format('M d, Y');
                        } else {
                            echo __('No records yet');
                        }
                    @endphp
                </span>
            </div>
            @forelse(($expenseByCategory ?? []) as $category => $amount)
                <div class="inv-cat-item">
                    <span class="name">{{ $category }}</span>
                    <span class="amt expense">₱{{ number_format($amount, 2) }}</span>
                </div>
            @empty
                <div class="inv-cat-item">
                    <span class="name" data-i18n="no_expense_records">No expense records yet</span>
                    <span class="amt expense">₱0.00</span>
                </div>
            @endforelse
            <div class="inv-cat-summary">
                <span data-i18n="total_expenses">Total Expenses</span>
                <span class="amt expense">₱{{ number_format($allTimeExpense ?? 0, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- RECENT TRANSACTIONS --}}
    <div class="inv-table-container" id="transactionsSection">
        <div class="inv-table-header">
            <h6>
                <i class="fas fa-history"></i>
                <span data-i18n="recent_transactions">Recent Transactions</span>
            </h6>
            <span style="font-size: .68rem; color: var(--inv-muted);">
                <span data-i18n="showing_latest">Showing latest</span>
                <strong style="color: var(--inv-text);">{{ count($recentTransactions ?? []) }}</strong>
                <span data-i18n="entries">entries</span>
            </span>
        </div>
        <div class="table-responsive">
            <table class="inv-table" id="recentTransactionsTable">
                <thead>
                    <tr>
                        <th data-i18n="date">Date</th>
                        <th data-i18n="description">Description</th>
                        <th data-i18n="category">Category</th>
                        <th data-i18n="type">Type</th>
                        <th data-i18n="amount">Amount</th>
                        <th data-i18n="notes">Notes</th>
                        <th style="width: 100px; text-align: center;" data-i18n="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentTransactions ?? collect()) as $transaction)
                    <tr>
                        <td style="color: var(--inv-text);">
                            {{ \Carbon\Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}
                        </td>
                        <td style="color: var(--inv-text);">
                            <strong>{{ $transaction->description }}</strong>
                            @if($transaction->type == 'income' && $transaction->donor_name)
                                <div style="font-size:.68rem; color: var(--inv-muted); margin-top:.15rem;">
                                    <i class="fas fa-user" style="font-size:.58rem;"></i>
                                    <span data-i18n="donor">Donor</span>: {{ $transaction->donor_name }}
                                </div>
                            @elseif($transaction->type == 'expense' && $transaction->recipient)
                                <div style="font-size:.68rem; color: var(--inv-muted); margin-top:.15rem;">
                                    <i class="fas fa-user" style="font-size:.58rem;"></i>
                                    <span data-i18n="recipient">Recipient</span>: {{ $transaction->recipient }}
                                </div>
                            @endif
                        </td>
                        <td style="color: var(--inv-text);">
                            <span class="inv-cat-badge">{{ $transaction->category ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="inv-type-badge {{ $transaction->type == 'income' ? 'income' : 'expense' }}">
                                <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                <span data-i18n="{{ $transaction->type == 'income' ? 'income' : 'expense' }}">
                                    {{ $transaction->type == 'income' ? 'Income' : 'Expense' }}
                                </span>
                            </span>
                        </td>
                        <td>
                            <span class="{{ $transaction->type == 'income' ? 'inv-amount-pos' : 'inv-amount-neg' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount, 2) }}
                            </span>
                        </td>
                        <td style="color: var(--inv-muted);">
                            {{ $transaction->remarks ?? '—' }}
                        </td>
                        <td style="text-align: center;">
                            <div class="inv-action-btns">
                                <a href="{{ route('inventory.edit', $transaction->id) }}" class="inv-icon-btn edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="inv-icon-btn delete" onclick="confirmDelete({{ $transaction->id }})" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="inv-empty">
                                <i class="fas fa-receipt"></i>
                                <p data-i18n="no_transactions">No transactions yet</p>
                                <small data-i18n="click_to_start">Click "Income" or "Expense" to get started</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- EXPORT MODAL --}}
{{-- ============================================ --}}
<div class="export-modal-overlay" id="exportModal">
    <div class="export-modal-content">
        <div class="modal-header-custom">
            <h3>
                <i class="fas fa-file-export"></i>
                <span data-i18n="export_inventory_report">Export Inventory Report</span>
            </h3>
            <button type="button" class="close-btn" onclick="closeExportModal()">&times;</button>
        </div>

        <div style="margin-bottom: 1.25rem;">
            <p style="color: var(--inv-muted); font-size: .84rem; margin: 0; line-height: 1.5;" data-i18n="export_desc">
                Select the date range and sections you want to include in your inventory report.
            </p>
        </div>

        <div class="modal-filter-container">
            <div style="flex: 1; min-width: 200px;">
                <label style="display:block; margin-bottom:.35rem;" data-i18n="select_months">Select Months (Hold Ctrl for multiple)</label>
                <select id="exportFilterMonths" multiple style="width: 100%; min-height: 80px;">
                    <option value="" data-i18n="all_months">All Months</option>
                    @foreach(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'] as $num)
                        <option value="{{ $num }}">{{ \Carbon\Carbon::create()->month((int)$num)->format('F') }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block; margin-bottom:.35rem;" data-i18n="year_label">Year</label>
                <select id="exportFilterYear">
                    <option value="" data-i18n="all_years">All Years</option>
                    @php
                        $currentYear = date('Y');
                        for($y = $currentYear - 5; $y <= $currentYear; $y++) {
                            echo "<option value=\"$y\">$y</option>";
                        }
                    @endphp
                </select>
            </div>

            <div>
                <label style="display:block; margin-bottom:.35rem;" data-i18n="week_label">Week</label>
                <input type="week" id="exportFilterWeek">
            </div>

            <div>
                <button type="button" class="modal-filter-btn" onclick="loadExportData()">
                    <i class="fas fa-sync-alt"></i>
                    <span data-i18n="load_data">Load Data</span>
                </button>
            </div>
        </div>

        <div class="export-section-group">
            <div class="select-all-row" onclick="toggleAllSections()">
                <input type="checkbox" id="selectAll" checked>
                <label for="selectAll">
                    <i class="fas fa-check-circle"></i>
                    <span data-i18n="select_all_sections">Select All Sections</span>
                </label>
            </div>

            <div class="checkbox-grid">
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="stats" checked>
                    <label><i class="fas fa-chart-pie"></i> <span data-i18n="stats_cards">Stats Cards</span></label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="summary" checked>
                    <label><i class="fas fa-chart-line"></i> <span data-i18n="summary_label">Summary</span></label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="categories" checked>
                    <label><i class="fas fa-tags"></i> <span data-i18n="categories_label">Categories</span></label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="transactions" checked>
                    <label><i class="fas fa-list"></i> <span data-i18n="transactions_label">Transactions</span></label>
                </div>
            </div>
        </div>

        <div style="padding: .75rem 1rem; background: var(--inv-primary-soft); border-radius: 10px; margin-bottom: 1.25rem;">
            <p style="font-size: .76rem; color: var(--inv-primary); margin: 0; font-weight: 500;" data-i18n="export_info">
                <i class="fas fa-info-circle"></i>
                Only the sections you select will appear in the exported PDF/Print.
            </p>
        </div>

        <div class="export-actions">
            <button type="button" class="btn-export btn-export-cancel" onclick="closeExportModal()">
                <i class="fas fa-times"></i>
                <span data-i18n="cancel">Cancel</span>
            </button>
            <button type="button" class="btn-export btn-export-print" onclick="exportPrint()">
                <i class="fas fa-print"></i>
                <span data-i18n="print">Print</span>
            </button>
            <button type="button" class="btn-export btn-export-pdf" onclick="exportPDF()">
                <i class="fas fa-file-pdf"></i>
                <span data-i18n="export_pdf">Export PDF</span>
            </button>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- INCOME MODAL --}}
{{-- ============================================ --}}
<div class="modal fade" id="incomeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-premium">
            <div class="modal-header modal-header-premium">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-arrow-down" style="color: var(--inv-green);"></i>
                        <span data-i18n="record_income">Record Income</span>
                    </h5>
                    <p data-i18n="record_income_desc">Add money received by the church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="type" value="income">

                    <div class="mb-3" style="margin-bottom: 1rem;">
                        <label class="form-label-premium">
                            <i class="fas fa-tag"></i>
                            <span data-i18n="description_label">Description</span>
                            <span style="color: var(--inv-rose);">*</span>
                        </label>
                        <input type="text" name="description" class="form-control-premium" required
                               placeholder="{{ __('e.g., Sunday Offering, Tithes, Special Donation') }}">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label-premium">
                            <i class="fas fa-folder"></i>
                            <span data-i18n="category_label">Category</span>
                            <span style="color: var(--inv-rose);">*</span>
                        </label>
                        <div class="category-pills-premium">
                            <div class="category-pill-premium selected" data-category="Sunday Offering" onclick="selectIncomeCategory(this, 'Sunday Offering')">
                                <i class="fas fa-church"></i> <span data-i18n="sunday_offering">Sunday Offering</span>
                            </div>
                            <div class="category-pill-premium" data-category="Tithes" onclick="selectIncomeCategory(this, 'Tithes')">
                                <i class="fas fa-hand-holding-heart"></i> <span data-i18n="tithes">Tithes</span>
                            </div>
                            <div class="category-pill-premium" data-category="Special Donation" onclick="selectIncomeCategory(this, 'Special Donation')">
                                <i class="fas fa-gift"></i> <span data-i18n="special_donation">Special Donation</span>
                            </div>
                            <div class="category-pill-premium" data-category="Building Fund" onclick="selectIncomeCategory(this, 'Building Fund')">
                                <i class="fas fa-building"></i> <span data-i18n="building_fund">Building Fund</span>
                            </div>
                            <div class="category-pill-premium" data-category="Missions" onclick="selectIncomeCategory(this, 'Missions')">
                                <i class="fas fa-globe"></i> <span data-i18n="missions">Missions</span>
                            </div>
                            <div class="category-pill-premium" data-category="Benevolence" onclick="selectIncomeCategory(this, 'Benevolence')">
                                <i class="fas fa-hands-helping"></i> <span data-i18n="benevolence">Benevolence</span>
                            </div>
                            <div class="category-pill-premium" data-category="Thanksgiving" onclick="selectIncomeCategory(this, 'Thanksgiving')">
                                <i class="fas fa-hands-praying"></i> <span data-i18n="thanksgiving">Thanksgiving</span>
                            </div>
                            <div class="category-pill-premium" data-category="Rental Income" onclick="selectIncomeCategory(this, 'Rental Income')">
                                <i class="fas fa-home"></i> <span data-i18n="rental_income">Rental Income</span>
                            </div>
                            <div class="category-pill-premium" data-category="Other Income" onclick="selectIncomeCategory(this, 'Other Income')">
                                <i class="fas fa-ellipsis-h"></i> <span data-i18n="other_income">Other Income</span>
                            </div>
                        </div>
                        <input type="hidden" name="category" id="incomeCategory" value="Sunday Offering">
                    </div>

                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 1rem;">
                            <label class="form-label-premium">
                                <i class="fas fa-money-bill-wave"></i>
                                <span data-i18n="amount_label">Amount</span> (₱)
                                <span style="color: var(--inv-rose);">*</span>
                            </label>
                            <div class="input-group" style="display:flex;">
                                <span class="input-group-text-premium">₱</span>
                                <input type="number" name="amount" step="0.01" class="form-control-premium" required
                                       placeholder="0.00" id="incomeAmount" oninput="updateIncomePreview()"
                                       style="border-radius: 0 11px 11px 0;">
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 1rem;">
                            <label class="form-label-premium">
                                <i class="fas fa-calendar"></i>
                                <span data-i18n="date_label">Date</span>
                                <span style="color: var(--inv-rose);">*</span>
                            </label>
                            <input type="date" name="date" class="form-control-premium" value="{{ date('Y-m-d') }}"
                                   max="{{ date('Y-m-d') }}" required>
                            <small style="font-size: .64rem; color: var(--inv-muted); display: block; margin-top: .25rem;">
                                <i class="fas fa-info-circle"></i>
                                <span data-i18n="past_date_only">Only past or today's date allowed</span>
                            </small>
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label-premium">
                            <i class="fas fa-user"></i>
                            <span data-i18n="donor_name">Donor Name</span>
                        </label>
                        <input type="text" name="donor_name" class="form-control-premium" placeholder="{{ __('Optional - Name of the donor') }}">
                    </div>

                    <div>
                        <label class="form-label-premium">
                            <i class="fas fa-pen"></i>
                            <span data-i18n="remarks_notes">Remarks / Notes</span>
                        </label>
                        <textarea name="remarks" class="form-control-premium" rows="2" placeholder="{{ __('Additional notes about this income...') }}" style="min-height: 50px;"></textarea>
                    </div>

                    <div class="amount-preview-premium alert-success-premium">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>
                                <i class="fas fa-calculator"></i>
                                <span data-i18n="amount_to_record">Amount to Record</span>:
                            </span>
                            <strong id="incomePreviewAmount" style="font-size: 1rem; color: var(--inv-green);">₱0.00</strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-premium" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        <span data-i18n="cancel">Cancel</span>
                    </button>
                    <button type="submit" class="btn-success-premium">
                        <i class="fas fa-save"></i>
                        <span data-i18n="save_income">Save Income</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- EXPENSE MODAL --}}
{{-- ============================================ --}}
<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-premium">
            <div class="modal-header modal-header-premium">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-arrow-up" style="color: var(--inv-rose);"></i>
                        <span data-i18n="record_expense">Record Expense</span>
                    </h5>
                    <p data-i18n="record_expense_desc">Record money spent by the church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="type" value="expense">

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label-premium">
                            <i class="fas fa-tag"></i>
                            <span data-i18n="description_label">Description</span>
                            <span style="color: var(--inv-rose);">*</span>
                        </label>
                        <input type="text" name="description" class="form-control-premium" required
                               placeholder="{{ __('e.g., Outreach Program, Church Supplies') }}">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label-premium">
                            <i class="fas fa-folder"></i>
                            <span data-i18n="category_label">Category</span>
                            <span style="color: var(--inv-rose);">*</span>
                        </label>
                        <div class="category-pills-premium">
                            <div class="category-pill-premium selected" data-category="Church Help" onclick="selectExpenseCategory(this, 'Church Help')">
                                <i class="fas fa-hands-helping"></i> <span data-i18n="church_help">Church Help</span>
                            </div>
                            <div class="category-pill-premium" data-category="Outreach" onclick="selectExpenseCategory(this, 'Outreach')">
                                <i class="fas fa-hand-holding-heart"></i> <span data-i18n="outreach">Outreach</span>
                            </div>
                            <div class="category-pill-premium" data-category="Donation to Others" onclick="selectExpenseCategory(this, 'Donation to Others')">
                                <i class="fas fa-gift"></i> <span data-i18n="donation">Donation</span>
                            </div>
                            <div class="category-pill-premium" data-category="Maintenance" onclick="selectExpenseCategory(this, 'Maintenance')">
                                <i class="fas fa-tools"></i> <span data-i18n="maintenance">Maintenance</span>
                            </div>
                            <div class="category-pill-premium" data-category="Utilities" onclick="selectExpenseCategory(this, 'Utilities')">
                                <i class="fas fa-bolt"></i> <span data-i18n="utilities">Utilities</span>
                            </div>
                            <div class="category-pill-premium" data-category="Staff Salary" onclick="selectExpenseCategory(this, 'Staff Salary')">
                                <i class="fas fa-user-tie"></i> <span data-i18n="staff_salary">Staff Salary</span>
                            </div>
                            <div class="category-pill-premium" data-category="Equipment" onclick="selectExpenseCategory(this, 'Equipment')">
                                <i class="fas fa-microphone"></i> <span data-i18n="equipment">Equipment</span>
                            </div>
                            <div class="category-pill-premium" data-category="Events" onclick="selectExpenseCategory(this, 'Events')">
                                <i class="fas fa-calendar-check"></i> <span data-i18n="events">Events</span>
                            </div>
                            <div class="category-pill-premium" data-category="Other Expense" onclick="selectExpenseCategory(this, 'Other Expense')">
                                <i class="fas fa-ellipsis-h"></i> <span data-i18n="other_expense">Other Expense</span>
                            </div>
                        </div>
                        <input type="hidden" name="category" id="expenseCategory" value="Church Help">
                    </div>

                    <div class="row">
                        <div class="col-md-6" style="margin-bottom: 1rem;">
                            <label class="form-label-premium">
                                <i class="fas fa-money-bill-wave"></i>
                                <span data-i18n="amount_label">Amount</span> (₱)
                                <span style="color: var(--inv-rose);">*</span>
                            </label>
                            <div class="input-group" style="display:flex;">
                                <span class="input-group-text-premium">₱</span>
                                <input type="number" name="amount" step="0.01" class="form-control-premium" required
                                       placeholder="0.00" id="expenseAmount" oninput="updateExpensePreview()"
                                       style="border-radius: 0 11px 11px 0;">
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-bottom: 1rem;">
                            <label class="form-label-premium">
                                <i class="fas fa-calendar"></i>
                                <span data-i18n="date_label">Date</span>
                                <span style="color: var(--inv-rose);">*</span>
                            </label>
                            <input type="date" name="date" class="form-control-premium" value="{{ date('Y-m-d') }}"
                                   max="{{ date('Y-m-d') }}" required>
                            <small style="font-size: .64rem; color: var(--inv-muted); display: block; margin-top: .25rem;">
                                <i class="fas fa-info-circle"></i>
                                <span data-i18n="past_date_only">Only past or today's date allowed</span>
                            </small>
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label class="form-label-premium">
                            <i class="fas fa-user"></i>
                            <span data-i18n="recipient_label">Recipient / Beneficiary</span>
                        </label>
                        <input type="text" name="recipient" class="form-control-premium" placeholder="{{ __('Optional - Who received this amount?') }}">
                    </div>

                    <div>
                        <label class="form-label-premium">
                            <i class="fas fa-pen"></i>
                            <span data-i18n="remarks_notes">Remarks / Notes</span>
                        </label>
                        <textarea name="remarks" class="form-control-premium" rows="2" placeholder="{{ __('Additional notes about this expense...') }}" style="min-height: 50px;"></textarea>
                    </div>

                    <div class="amount-preview-premium alert-info-premium">
                        <div style="display: flex; justify-content: space-between; margin-bottom: .35rem;">
                            <span><i class="fas fa-wallet"></i> <span data-i18n="current_balance">Current Balance</span>:</span>
                            <strong id="currentBalance" style="font-variant-numeric: tabular-nums;">₱{{ number_format($allTimeBalance ?? 0, 2) }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: .35rem;">
                            <span><i class="fas fa-minus-circle" style="color: var(--inv-rose);"></i> <span data-i18n="amount_to_deduct">Amount to Deduct</span>:</span>
                            <strong id="expensePreviewAmount" style="color: var(--inv-rose); font-variant-numeric: tabular-nums;">₱0.00</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: .5rem; border-top: 1px solid var(--inv-border);">
                            <span><i class="fas fa-calculator"></i> <span data-i18n="remaining_balance">Remaining Balance</span>:</span>
                            <strong id="remainingBalance" style="color: var(--inv-green); font-size: .95rem; font-variant-numeric: tabular-nums;">₱{{ number_format($allTimeBalance ?? 0, 2) }}</strong>
                        </div>
                    </div>

                    @if(($allTimeBalance ?? 0) <= 0)
                        <div class="alert-danger-premium">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span data-i18n="insufficient_balance">Insufficient balance!</span>
                            <span data-i18n="current_balance">Current balance</span>: ₱{{ number_format($allTimeBalance ?? 0, 2) }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-premium" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        <span data-i18n="cancel">Cancel</span>
                    </button>
                    <button type="submit" class="btn-danger-premium" id="expenseSubmitBtn" {{ ($allTimeBalance ?? 0) <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save"></i>
                        <span data-i18n="save_expense">Save Expense</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- ALL TRANSACTIONS MODAL --}}
{{-- ============================================ --}}
<div class="modal fade" id="transactionsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-premium">
            <div class="modal-header modal-header-premium">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-list" style="color: var(--inv-primary);"></i>
                        <span data-i18n="all_transactions">All Transactions</span>
                    </h5>
                    <p data-i18n="complete_history">Complete financial history of your church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div class="modal-filter-container">
                    <label>
                        <i class="fas fa-calendar-alt"></i>
                        <span data-i18n="month_label">Month</span>
                    </label>
                    <select id="modalFilterMonth" onchange="applyModalFilters()">
                        <option value="" data-i18n="all_months">All Months</option>
                        @foreach(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'] as $num)
                            <option value="{{ $num }}">{{ \Carbon\Carbon::create()->month((int)$num)->format('F') }}</option>
                        @endforeach
                    </select>

                    <label>
                        <i class="fas fa-calendar"></i>
                        <span data-i18n="year_label">Year</span>
                    </label>
                    <select id="modalFilterYear" onchange="applyModalFilters()">
                        <option value="" data-i18n="all_years">All Years</option>
                        @php
                            $currentYear = date('Y');
                            for($y = $currentYear - 5; $y <= $currentYear; $y++) {
                                echo "<option value=\"$y\">$y</option>";
                            }
                        @endphp
                    </select>

                    <label>
                        <i class="fas fa-calendar-week"></i>
                        <span data-i18n="week_label">Week</span>
                    </label>
                    <input type="week" id="modalFilterWeek" onchange="applyModalFilters()">

                    <button type="button" class="modal-filter-btn" onclick="resetModalFilters()">
                        <i class="fas fa-undo"></i>
                        <span data-i18n="reset">Reset</span>
                    </button>
                </div>

                <div class="filter-tabs-premium" style="margin-bottom: 1rem;">
                    <button type="button" class="filter-tab-premium active" onclick="filterTransactions('all', event)">
                        <span data-i18n="all_transactions">All Transactions</span>
                    </button>
                    <button type="button" class="filter-tab-premium" onclick="filterTransactions('income', event)">
                        <i class="fas fa-arrow-down" style="color: var(--inv-green);"></i>
                        <span data-i18n="income">Income</span>
                    </button>
                    <button type="button" class="filter-tab-premium" onclick="filterTransactions('expense', event)">
                        <i class="fas fa-arrow-up" style="color: var(--inv-rose);"></i>
                        <span data-i18n="expense">Expense</span>
                    </button>
                </div>

                <div class="transaction-summary-premium" id="modalSummaryStats" style="margin-bottom: 1rem;">
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium income-bg"><i class="fas fa-arrow-down"></i></div>
                        <div class="summary-info">
                            <span class="summary-label" data-i18n="total_income">Total Income</span>
                            <span class="summary-value" id="modalTotalIncome" style="color: var(--inv-green);">₱0.00</span>
                        </div>
                    </div>
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium expense-bg"><i class="fas fa-arrow-up"></i></div>
                        <div class="summary-info">
                            <span class="summary-label" data-i18n="total_expenses">Total Expenses</span>
                            <span class="summary-value" id="modalTotalExpense" style="color: var(--inv-rose);">₱0.00</span>
                        </div>
                    </div>
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium balance-bg"><i class="fas fa-calculator"></i></div>
                        <div class="summary-info">
                            <span class="summary-label" data-i18n="net_balance">Net Balance</span>
                            <span class="summary-value" id="modalNetBalance">₱0.00</span>
                        </div>
                    </div>
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium total-bg"><i class="fas fa-receipt"></i></div>
                        <div class="summary-info">
                            <span class="summary-label" data-i18n="total_transactions">Total Transactions</span>
                            <span class="summary-value" id="modalTotalTransactions">0</span>
                        </div>
                    </div>
                </div>

                <div class="search-bar-premium" style="margin-bottom: 1rem;">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="transactionSearch" class="form-control-premium"
                               placeholder="{{ __('Search transactions...') }}"
                               onkeyup="searchTransactions()">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="inv-table" id="transactionsTable">
                        <thead>
                            <tr>
                                <th data-i18n="date">Date</th>
                                <th data-i18n="description">Description</th>
                                <th data-i18n="category">Category</th>
                                <th data-i18n="type">Type</th>
                                <th data-i18n="amount">Amount</th>
                                <th data-i18n="notes">Notes</th>
                                <th style="width: 100px; text-align: center;" data-i18n="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            <tr>
                                <td colspan="7">
                                    <div class="inv-empty" style="padding: 2rem;">
                                        <i class="fas fa-receipt"></i>
                                        <p style="font-weight: 500; color: var(--inv-muted);" data-i18n="select_filter">Select a filter to view transactions</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: .65rem; font-size: .68rem; color: var(--inv-muted); text-align: center;">
                    <i class="fas fa-mouse-pointer"></i>
                    <span data-i18n="click_row_edit">Click on any row to edit the transaction</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary-premium" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    <span data-i18n="close">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- PDF EXPORT CONTAINER --}}
{{-- ============================================= --}}
<div class="pdf-export-wrapper" id="pdfExportContainer">
    <div class="pdf-header">
        <h1><span data-i18n="inventory_management">Inventory Management Report</span></h1>
        <p><span data-i18n="church_financial_overview">Church financial overview - Income, Expenses, and Transactions</span></p>
        <div class="pdf-date"><span data-i18n="generated">Generated</span>: {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</div>
    </div>

    <div id="pdfContent">
        <div class="pdf-section" id="pdf-stats">
            <div class="pdf-section-title"><i class="fas fa-chart-pie"></i> <span data-i18n="financial_overview">Financial Overview</span></div>
            <div class="pdf-stats-grid" id="pdfStatsGrid"></div>
        </div>

        <div class="pdf-section" id="pdf-summary" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-chart-line"></i> <span data-i18n="summary_label">Summary</span></div>
            <div id="pdfSummaryContent"></div>
        </div>

        <div class="pdf-section" id="pdf-categories" style="display:none;">
            <div class="pdf-section-title">
                <i class="fas fa-tags"></i> <span data-i18n="category_breakdown">Category Breakdown</span>
                <span class="pdf-date-badge" id="pdfCategoryDateRange">
                    @php
                        $allDates = [];
                        if(isset($recentTransactions)) {
                            foreach($recentTransactions as $t) {
                                if($t->date) {
                                    $allDates[] = $t->date;
                                }
                            }
                        }
                        if(!empty($allDates)) {
                            sort($allDates);
                            echo \Carbon\Carbon::parse($allDates[0])->format('M d, Y') . ' - ' . \Carbon\Carbon::parse(end($allDates))->format('M d, Y');
                        } else {
                            echo __('No records yet');
                        }
                    @endphp
                </span>
            </div>
            <div id="pdfCategoriesContent"></div>
        </div>

        <div class="pdf-section" id="pdf-transactions" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-list"></i> <span data-i18n="recent_transactions">Recent Transactions</span></div>
            <table class="pdf-table" id="pdfTransactionsTable">
                <thead>
                    <tr>
                        <th data-i18n="date">Date</th>
                        <th data-i18n="description">Description</th>
                        <th data-i18n="category">Category</th>
                        <th data-i18n="type">Type</th>
                        <th style="text-align:right;" data-i18n="amount">Amount</th>
                        <th data-i18n="notes">Notes</th>
                    </tr>
                </thead>
                <tbody id="pdfTransactionsBody"></tbody>
            </table>
        </div>
    </div>

    <div class="pdf-footer">
        <span data-i18n="generated_by">Generated by</span> <strong>TINC Church Management System</strong> • {{ \Carbon\Carbon::now()->format('Y') }}
    </div>
</div>

{{-- ============================================= --}}
{{-- SCRIPTS --}}
{{-- ============================================= --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ============================================
    // ⭐ SAFE DATE FORMATTER — prevents timezone off-by-one
    // ============================================
    function formatDateSafe(dateStr) {
        if (!dateStr) return '—';

        // Case 1: Plain date string "YYYY-MM-DD" → parse as LOCAL date
        if (typeof dateStr === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(dateStr)) {
            const [y, m, d] = dateStr.split('-').map(Number);
            return new Date(y, m - 1, d).toLocaleDateString('en-US', {
                month: 'short', day: 'numeric', year: 'numeric'
            });
        }

        // Case 2: Full ISO datetime "YYYY-MM-DDTHH:MM:SS..." → use only the date part
        if (typeof dateStr === 'string' && /^\d{4}-\d{2}-\d{2}T/.test(dateStr)) {
            const [y, m, d] = dateStr.substring(0, 10).split('-').map(Number);
            return new Date(y, m - 1, d).toLocaleDateString('en-US', {
                month: 'short', day: 'numeric', year: 'numeric'
            });
        }

        // Case 3: Fallback — parse normally
        const dt = new Date(dateStr);
        if (isNaN(dt.getTime())) return '—';
        return dt.toLocaleDateString('en-US', {
            month: 'short', day: 'numeric', year: 'numeric'
        });
    }

    // ============================================
    // CATEGORY SELECTION
    // ============================================
    function selectIncomeCategory(element, category) {
        document.querySelectorAll('#incomeModal .category-pill-premium').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('incomeCategory').value = category;
    }

    function selectExpenseCategory(element, category) {
        document.querySelectorAll('#expenseModal .category-pill-premium').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('expenseCategory').value = category;
    }

    // ============================================
    // UPDATE PREVIEWS
    // ============================================
    function updateIncomePreview() {
        let amount = parseFloat(document.getElementById('incomeAmount')?.value) || 0;
        let preview = document.getElementById('incomePreviewAmount');
        if (preview) {
            preview.textContent = '₱' + amount.toFixed(2);
        }
    }

    function updateExpensePreview() {
        let amount = parseFloat(document.getElementById('expenseAmount')?.value) || 0;
        let currentBalance = {{ $allTimeBalance ?? 0 }};
        let remainingBalance = currentBalance - amount;

        let previewAmount = document.getElementById('expensePreviewAmount');
        let remainingSpan = document.getElementById('remainingBalance');
        let submitBtn = document.getElementById('expenseSubmitBtn');

        if (previewAmount) {
            previewAmount.textContent = '₱' + amount.toFixed(2);
        }

        if (remainingSpan) {
            remainingSpan.textContent = (remainingBalance >= 0 ? '₱' : '-₱') + Math.abs(remainingBalance).toFixed(2);
            remainingSpan.style.color = remainingBalance >= 0 ? '#10B981' : '#EF4444';
        }

        if (submitBtn) {
            if (amount > currentBalance && currentBalance > 0) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
            } else {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            }
        }
    }

    // ============================================
    // EXPORT MODAL
    // ============================================
    function openExportModal() {
        document.getElementById('exportModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeExportModal() {
        document.getElementById('exportModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    function toggleAllSections() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.section-checkbox');
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    }

    document.querySelectorAll('.section-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = document.querySelectorAll('.section-checkbox:checked').length === document.querySelectorAll('.section-checkbox').length;
            document.getElementById('selectAll').checked = allChecked;
        });
    });

    function getSelectedSections() {
        const selected = [];
        document.querySelectorAll('.section-checkbox:checked').forEach(cb => {
            selected.push(cb.value);
        });
        return selected;
    }

    // ============================================
    // EXPORT DATA LOADING
    // ============================================
    let exportDataCache = null;

    function loadExportData() {
        const months = Array.from(document.getElementById('exportFilterMonths').selectedOptions).map(opt => opt.value);
        const year = document.getElementById('exportFilterYear').value;
        const week = document.getElementById('exportFilterWeek').value;

        let url = `{{ route('inventory.export-data') }}`;
        let params = [];

        if (months.length > 0) {
            params.push(`months[]=${months.join(',')}`);
        }
        if (year) {
            params.push(`year=${year}`);
        }
        if (week) {
            params.push(`week=${week}`);
        }

        if (params.length > 0) {
            url += '?' + params.join('&');
        }

        const loadingText = window.t ? window.t('loading') : 'Loading...';
        const fetchText = window.t ? window.t('fetching_data') : 'Fetching data for export...';

        Swal.fire({
            title: loadingText,
            text: fetchText,
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        fetch(url)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    exportDataCache = data;
                    const foundText = window.t ? window.t('found_transactions') : 'Found';
                    const transactionsText = window.t ? window.t('transactions') : 'transactions';
                    const periodText = window.t ? window.t('for_period') : 'for the selected period.';
                    Swal.fire({
                        icon: 'success',
                        title: window.t ? window.t('data_loaded') : 'Data Loaded!',
                        text: `${foundText} ${data.totals.count} ${transactionsText} ${periodText}`,
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: window.t ? window.t('error') : 'Error',
                        text: window.t ? window.t('failed_to_load') : 'Failed to load data.',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: window.t ? window.t('error') : 'Error',
                    text: window.t ? window.t('something_wrong') : 'Something went wrong. Please try again.',
                    confirmButtonColor: '#EF4444'
                });
            });
    }

    // ============================================
    // BUILD PDF CONTENT
    // ============================================
    function buildPDFContent(sections) {
        if (!exportDataCache) {
            const noDataText = window.t ? window.t('no_data') : 'No Data';
            const loadFirstText = window.t ? window.t('load_data_first') : 'Please load the data first by clicking "Load Data".';
            Swal.fire({
                icon: 'warning',
                title: noDataText,
                text: loadFirstText,
                confirmButtonColor: '#4F46E5'
            });
            return false;
        }

        const data = exportDataCache;
        const months = Array.from(document.getElementById('exportFilterMonths').selectedOptions).map(opt => opt.text);
        const year = document.getElementById('exportFilterYear').value;
        const week = document.getElementById('exportFilterWeek').value;

        let filterDisplay = '';
        const forText = window.t ? window.t('for') : 'for';
        if (months.length > 0 && year) {
            filterDisplay = ` ${forText} ${months.join(', ')} ${year}`;
        } else if (months.length > 0) {
            filterDisplay = ` ${forText} ${months.join(', ')}`;
        } else if (year) {
            filterDisplay = ` ${forText} ${year}`;
        } else if (week) {
            filterDisplay = ` ${forText} Week ${week}`;
        }

        const reportTitle = window.t ? window.t('inventory_management') : 'Inventory Management Report';
        const generatedText = window.t ? window.t('generated') : 'Generated';
        document.querySelector('#pdfExportContainer .pdf-header h1').textContent = reportTitle + filterDisplay;
        document.querySelector('#pdfExportContainer .pdf-header .pdf-date').textContent = generatedText + ': ' + new Date().toLocaleString();

        // Stats
        if (sections.includes('stats')) {
            document.getElementById('pdf-stats').style.display = 'block';
            const grid = document.getElementById('pdfStatsGrid');
            const incomeLabel = window.t ? window.t('total_income') : 'Total Income';
            const expensesLabel = window.t ? window.t('total_expenses') : 'Total Expenses';
            const netLabel = window.t ? window.t('net_balance') : 'Net Balance';
            const totalLabel = window.t ? window.t('total_transactions') : 'Total Transactions';

            const stats = [
                { label: incomeLabel, value: '₱' + data.totals.income, change: 'Money received', positive: true },
                { label: expensesLabel, value: '₱' + data.totals.expense, change: 'Money spent', positive: false },
                { label: netLabel, value: (parseFloat(data.totals.balance) >= 0 ? '+' : '-') + ' ₱' + Math.abs(parseFloat(data.totals.balance)).toFixed(2), change: 'Surplus', positive: true },
                { label: totalLabel, value: data.totals.count, change: 'Records', positive: true }
            ];
            grid.innerHTML = stats.map(s => `
                <div class="pdf-stat-card">
                    <div class="pdf-stat-label">${s.label}</div>
                    <div class="pdf-stat-value">${s.value}</div>
                    <div class="pdf-stat-change ${s.positive ? 'positive' : 'negative'}">${s.change}</div>
                </div>
            `).join('');
        } else {
            document.getElementById('pdf-stats').style.display = 'none';
        }

        // Summary
        if (sections.includes('summary')) {
            document.getElementById('pdf-summary').style.display = 'block';
            const summary = document.getElementById('pdfSummaryContent');
            const incomeLabel = window.t ? window.t('total_income') : 'Total Income';
            const expensesLabel = window.t ? window.t('total_expenses') : 'Total Expenses';
            const netLabel = window.t ? window.t('net_balance') : 'Net Balance';
            summary.innerHTML = `
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;">
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px 20px;text-align:center;">
                        <div style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">${incomeLabel}</div>
                        <div style="font-size:22px;font-weight:800;color:#10B981;">₱${data.totals.income}</div>
                    </div>
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px 20px;text-align:center;">
                        <div style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">${expensesLabel}</div>
                        <div style="font-size:22px;font-weight:800;color:#EF4444;">₱${data.totals.expense}</div>
                    </div>
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px 20px;text-align:center;">
                        <div style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">${netLabel}</div>
                        <div style="font-size:22px;font-weight:800;color:#4F46E5;">${parseFloat(data.totals.balance) >= 0 ? '+' : '-'} ₱${Math.abs(parseFloat(data.totals.balance)).toFixed(2)}</div>
                    </div>
                </div>
            `;
        } else {
            document.getElementById('pdf-summary').style.display = 'none';
        }

        // Categories
        if (sections.includes('categories')) {
            document.getElementById('pdf-categories').style.display = 'block';
            const content = document.getElementById('pdfCategoriesContent');

            const incomeCategories = {};
            const expenseCategories = {};
            let totalIncome = 0;
            let totalExpense = 0;

            data.transactions.forEach(t => {
                if (t.type === 'income') {
                    incomeCategories[t.category] = (incomeCategories[t.category] || 0) + parseFloat(t.amount);
                    totalIncome += parseFloat(t.amount);
                } else {
                    expenseCategories[t.category] = (expenseCategories[t.category] || 0) + parseFloat(t.amount);
                    totalExpense += parseFloat(t.amount);
                }
            });

            const incomeLabel = window.t ? window.t('income_categories') : 'Income Categories';
            const expensesLabel = window.t ? window.t('expense_categories') : 'Expense Categories';
            const totalIncomeLabel = window.t ? window.t('total_income') : 'Total Income';
            const totalExpensesLabel = window.t ? window.t('total_expenses') : 'Total Expenses';

            let incomeHtml = `<div style="margin-bottom:15px;"><h4 style="font-size:14px;color:#10B981;margin:0 0 10px 0;">${incomeLabel}</h4>`;
            if (Object.keys(incomeCategories).length > 0) {
                incomeHtml += '<table class="pdf-table"><thead><tr><th>Category</th><th style="text-align:right;">Amount</th></tr></thead><tbody>';
                Object.entries(incomeCategories).forEach(([category, amount]) => {
                    incomeHtml += `<tr><td>${category}</td><td style="text-align:right;color:#10B981;">₱${amount.toFixed(2)}</td></tr>`;
                });
                incomeHtml += `<tr style="font-weight:700;border-top:2px solid #e5e7eb;"><td>${totalIncomeLabel}</td><td style="text-align:right;color:#10B981;">₱${totalIncome.toFixed(2)}</td></tr>`;
                incomeHtml += '</tbody></table>';
            } else {
                const noRecords = window.t ? window.t('no_income_records') : 'No income records yet';
                incomeHtml += `<p style="color:#999;">${noRecords}</p>`;
            }
            incomeHtml += '</div>';

            let expenseHtml = `<div><h4 style="font-size:14px;color:#EF4444;margin:0 0 10px 0;">${expensesLabel}</h4>`;
            if (Object.keys(expenseCategories).length > 0) {
                expenseHtml += '<table class="pdf-table"><thead><tr><th>Category</th><th style="text-align:right;">Amount</th></tr></thead><tbody>';
                Object.entries(expenseCategories).forEach(([category, amount]) => {
                    expenseHtml += `<tr><td>${category}</td><td style="text-align:right;color:#EF4444;">₱${amount.toFixed(2)}</td></tr>`;
                });
                expenseHtml += `<tr style="font-weight:700;border-top:2px solid #e5e7eb;"><td>${totalExpensesLabel}</td><td style="text-align:right;color:#EF4444;">₱${totalExpense.toFixed(2)}</td></tr>`;
                expenseHtml += '</tbody></table>';
            } else {
                const noRecords = window.t ? window.t('no_expense_records') : 'No expense records yet';
                expenseHtml += `<p style="color:#999;">${noRecords}</p>`;
            }
            expenseHtml += '</div>';

            content.innerHTML = incomeHtml + expenseHtml;
        } else {
            document.getElementById('pdf-categories').style.display = 'none';
        }

        // Transactions
        if (sections.includes('transactions')) {
            document.getElementById('pdf-transactions').style.display = 'block';
            const body = document.getElementById('pdfTransactionsBody');

            let html = '';
            const noTransactions = window.t ? window.t('no_transactions_period') : 'No transactions found for the selected period';
            if (data.transactions.length === 0) {
                html = `<tr><td colspan="6" style="text-align:center; color:#999; padding:20px;">${noTransactions}</td></tr>`;
            } else {
                const incomeLabel = window.t ? window.t('income') : 'Income';
                const expensesLabel = window.t ? window.t('expense') : 'Expense';
                data.transactions.forEach(t => {
                    // ⭐ FIX: Use formatDateSafe instead of `new Date(...)` to prevent timezone shift
                    const formattedDate = formatDateSafe(t.date || t.created_at);
                    const isIncome = t.type === 'income';
                    html += `
                        <tr>
                            <td>${formattedDate}</td>
                            <td>${t.description}</td>
                            <td>${t.category || 'Uncategorized'}</td>
                            <td><span class="pdf-badge ${isIncome ? 'income' : 'expense'}">${isIncome ? incomeLabel : expensesLabel}</span></td>
                            <td style="text-align:right; font-weight:700; color:${isIncome ? '#10B981' : '#EF4444'};">${isIncome ? '+' : '-'} ₱${parseFloat(t.amount).toFixed(2)}</td>
                            <td>${t.remarks || '—'}</td>
                        </tr>
                    `;
                });
            }
            body.innerHTML = html;
        } else {
            document.getElementById('pdf-transactions').style.display = 'none';
        }

        return true;
    }

    // ============================================
    // EXPORT FUNCTIONS
    // ============================================
    function exportPrint() {
        const sections = getSelectedSections();
        if (sections.length === 0) {
            const noSelection = window.t ? window.t('no_selection') : 'No Selection';
            const selectSection = window.t ? window.t('select_section') : 'Please select at least one section to export.';
            Swal.fire({
                icon: 'warning',
                title: noSelection,
                text: selectSection,
                confirmButtonColor: '#4F46E5'
            });
            return;
        }

        loadExportData();

        setTimeout(() => {
            if (!exportDataCache) {
                const notLoaded = window.t ? window.t('data_not_loaded') : 'Data Not Loaded';
                const waitText = window.t ? window.t('wait_load_data') : 'Please wait for data to load or click "Load Data" again.';
                Swal.fire({
                    icon: 'error',
                    title: notLoaded,
                    text: waitText,
                    confirmButtonColor: '#EF4444'
                });
                return;
            }

            closeExportModal();

            const success = buildPDFContent(sections);
            if (!success) return;

            const container = document.getElementById('pdfExportContainer');
            container.style.display = 'block';

            const preparing = window.t ? window.t('preparing_print') : 'Preparing Print...';
            const waitText = window.t ? window.t('please_wait') : 'Please wait...';
            Swal.fire({
                title: preparing,
                text: waitText,
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            setTimeout(() => {
                Swal.close();
                window.print();
                setTimeout(() => {
                    container.style.display = 'none';
                }, 1000);
            }, 500);
        }, 1000);
    }

    function exportPDF() {
        const sections = getSelectedSections();
        if (sections.length === 0) {
            const noSelection = window.t ? window.t('no_selection') : 'No Selection';
            const selectSection = window.t ? window.t('select_section') : 'Please select at least one section to export.';
            Swal.fire({
                icon: 'warning',
                title: noSelection,
                text: selectSection,
                confirmButtonColor: '#4F46E5'
            });
            return;
        }

        loadExportData();

        setTimeout(() => {
            if (!exportDataCache) {
                const notLoaded = window.t ? window.t('data_not_loaded') : 'Data Not Loaded';
                const waitText = window.t ? window.t('wait_load_data') : 'Please wait for data to load or click "Load Data" again.';
                Swal.fire({
                    icon: 'error',
                    title: notLoaded,
                    text: waitText,
                    confirmButtonColor: '#EF4444'
                });
                return;
            }

            closeExportModal();

            const success = buildPDFContent(sections);
            if (!success) return;

            const container = document.getElementById('pdfExportContainer');
            container.style.display = 'block';

            const generating = window.t ? window.t('generating_pdf') : 'Generating PDF...';
            const waitText = window.t ? window.t('please_wait') : 'Please wait...';
            Swal.fire({
                title: generating,
                text: waitText,
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            const opt = {
                margin: [10, 10, 10, 10],
                filename: 'Inventory_Report_' + new Date().toISOString().slice(0,10) + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, letterRendering: true, logging: false, backgroundColor: '#ffffff' },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(container).save().then(function() {
                container.style.display = 'none';
                Swal.close();
                const exported = window.t ? window.t('pdf_exported') : 'PDF Exported!';
                const successMsg = window.t ? window.t('pdf_success') : 'Your inventory report has been downloaded successfully.';
                Swal.fire({
                    icon: 'success',
                    title: exported,
                    text: successMsg,
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }).catch(function(err) {
                container.style.display = 'none';
                Swal.close();
                const failed = window.t ? window.t('export_failed') : 'Export Failed';
                const tryAgain = window.t ? window.t('try_again') : 'Something went wrong. Please try again.';
                Swal.fire({
                    icon: 'error',
                    title: failed,
                    text: err.message || tryAgain,
                    confirmButtonColor: '#EF4444'
                });
            });
        }, 1000);
    }

    // ============================================
    // DELETE TRANSACTION
    // ============================================
    function confirmDelete(id) {
        const deleteTitle = window.t ? window.t('delete_transaction') : 'Delete Transaction?';
        const deleteMsg = window.t ? window.t('delete_confirm') : 'This action cannot be undone. Are you sure?';
        const confirmText = window.t ? window.t('yes_delete') : 'Yes, delete it!';
        const cancelText = window.t ? window.t('cancel') : 'Cancel';
        const deleting = window.t ? window.t('deleting') : 'Deleting...';
        const waitText = window.t ? window.t('please_wait') : 'Please wait...';
        const deletedTitle = window.t ? window.t('deleted') : 'Deleted!';
        const successMsg = window.t ? window.t('delete_success') : 'Transaction deleted successfully.';
        const errorTitle = window.t ? window.t('error') : 'Error';

        Swal.fire({
            title: deleteTitle,
            text: deleteMsg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: deleting,
                    text: waitText,
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                fetch(`/inventory/destroy/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: deletedTitle,
                            text: data.message || successMsg,
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: errorTitle,
                            text: data.message || 'Failed to delete transaction.',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: errorTitle,
                        text: window.t ? window.t('something_wrong') : 'Something went wrong. Please try again.',
                        confirmButtonColor: '#EF4444'
                    });
                });
            }
        });
    }

    // ============================================
    // FILTER TRANSACTIONS (Type)
    // ============================================
    function filterTransactions(type, event) {
        if (event) {
            document.querySelectorAll('.filter-tab-premium').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.closest('.filter-tab-premium').classList.add('active');
        }

        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            if (type === 'all') {
                row.style.display = '';
                visibleCount++;
            } else if (row.getAttribute('data-type') === type) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const totalSpan = document.getElementById('modalTotalTransactions');
        if (totalSpan) {
            totalSpan.textContent = visibleCount;
        }
    }

    // ============================================
    // SEARCH TRANSACTIONS
    // ============================================
    function searchTransactions() {
        const searchTerm = document.getElementById('transactionSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            if (searchData.includes(searchTerm) || searchTerm === '') {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const totalSpan = document.getElementById('modalTotalTransactions');
        if (totalSpan) {
            totalSpan.textContent = visibleCount;
        }
    }

    // ============================================
    // MODAL FILTER FUNCTIONS
    // ============================================
    function applyModalFilters() {
        const month = document.getElementById('modalFilterMonth').value;
        const year = document.getElementById('modalFilterYear').value;
        const week = document.getElementById('modalFilterWeek').value;

        let url = `{{ route('inventory.transactions') }}`;
        let params = [];
        if (month) params.push(`month=${month}`);
        if (year) params.push(`year=${year}`);
        if (week) params.push(`week=${week}`);

        if (params.length > 0) {
            url += '?' + params.join('&');
        } else {
            const selectFilter = window.t ? window.t('select_filter') : 'Select a filter to view transactions';
            document.getElementById('transactionsTableBody').innerHTML = `
                <tr>
                    <td colspan="7">
                        <div class="inv-empty" style="padding: 2rem;">
                            <i class="fas fa-receipt"></i>
                            <p style="font-weight: 500; color: var(--inv-muted);">${selectFilter}</p>
                        </div>
                    </td>
                </tr>
            `;
            document.getElementById('modalTotalIncome').textContent = '₱0.00';
            document.getElementById('modalTotalExpense').textContent = '₱0.00';
            document.getElementById('modalNetBalance').textContent = '₱0.00';
            document.getElementById('modalTotalTransactions').textContent = '0';
            return;
        }

        const tbody = document.getElementById('transactionsTableBody');
        const loading = window.t ? window.t('loading_transactions') : 'Loading transactions...';
        tbody.innerHTML = `
            <tr>
                <td colspan="7">
                    <div class="inv-empty" style="padding: 2rem;">
                        <i class="fas fa-spinner fa-spin" style="opacity: 1; color: var(--inv-primary);"></i>
                        <p style="font-weight: 500; color: var(--inv-muted);">${loading}</p>
                    </div>
                </td>
            </tr>
        `;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateTransactionsTable(data.transactions, data.totals);
                } else {
                    const errorTitle = window.t ? window.t('error') : 'Error';
                    const failed = window.t ? window.t('failed_load_transactions') : 'Failed to load transactions.';
                    Swal.fire({
                        icon: 'error',
                        title: errorTitle,
                        text: failed,
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(error => {
                const errorTitle = window.t ? window.t('error') : 'Error';
                const tryAgain = window.t ? window.t('something_wrong') : 'Something went wrong. Please try again.';
                Swal.fire({
                    icon: 'error',
                    title: errorTitle,
                    text: tryAgain,
                    confirmButtonColor: '#EF4444'
                });
            });
    }

    function resetModalFilters() {
        document.getElementById('modalFilterMonth').value = '';
        document.getElementById('modalFilterYear').value = '';
        document.getElementById('modalFilterWeek').value = '';
        applyModalFilters();
    }

    function updateTransactionsTable(transactions, totals) {
        const tbody = document.getElementById('transactionsTableBody');
        const totalIncomeSpan = document.getElementById('modalTotalIncome');
        const totalExpenseSpan = document.getElementById('modalTotalExpense');
        const netBalanceSpan = document.getElementById('modalNetBalance');
        const totalCountSpan = document.getElementById('modalTotalTransactions');

        if (totalIncomeSpan) totalIncomeSpan.textContent = '₱' + totals.income;
        if (totalExpenseSpan) totalExpenseSpan.textContent = '₱' + totals.expense;
        if (netBalanceSpan) {
            const bal = parseFloat(totals.balance.replace(/,/g, ''));
            netBalanceSpan.textContent = (bal >= 0 ? '+' : '-') + ' ₱' + Math.abs(bal).toFixed(2);
            netBalanceSpan.style.color = bal >= 0 ? 'var(--inv-green)' : 'var(--inv-rose)';
        }
        if (totalCountSpan) totalCountSpan.textContent = totals.count;

        let html = '';
        const noTransactions = window.t ? window.t('no_transactions_filter') : 'No transactions found for this filter';
        if (transactions.length === 0) {
            html = `
                <tr>
                    <td colspan="7">
                        <div class="inv-empty" style="padding: 2rem;">
                            <i class="fas fa-receipt"></i>
                            <p style="font-weight: 500; color: var(--inv-muted);">${noTransactions}</p>
                        </div>
                    </td>
                </tr>
            `;
        } else {
            const incomeLabel = window.t ? window.t('income') : 'Income';
            const expensesLabel = window.t ? window.t('expense') : 'Expense';
            const donorLabel = window.t ? window.t('donor') : 'Donor';
            const recipientLabel = window.t ? window.t('recipient') : 'Recipient';

            transactions.forEach(t => {
                // ⭐ FIX: Use formatDateSafe instead of `new Date(...)` to prevent timezone shift
                const formattedDate = formatDateSafe(t.date || t.created_at);

                const isIncome = t.type === 'income';
                const donorHtml = (isIncome && t.donor_name) ? `<div style="font-size:.68rem;color:var(--inv-muted);margin-top:.15rem;"><i class="fas fa-user" style="font-size:.58rem;"></i> ${donorLabel}: ${t.donor_name}</div>` : '';
                const recipientHtml = (!isIncome && t.recipient) ? `<div style="font-size:.68rem;color:var(--inv-muted);margin-top:.15rem;"><i class="fas fa-user" style="font-size:.58rem;"></i> ${recipientLabel}: ${t.recipient}</div>` : '';

                html += `
                    <tr data-type="${t.type}" data-search="${(t.description + ' ' + (t.category || '') + ' ' + (t.remarks || '')).toLowerCase()}" data-id="${t.id}" class="clickable-row" style="cursor:pointer;">
                        <td style="color: var(--inv-text);">${formattedDate}</td>
                        <td style="color: var(--inv-text);">
                            <strong>${t.description}</strong>
                            ${donorHtml}${recipientHtml}
                        </td>
                        <td style="color: var(--inv-text);">
                            <span class="inv-cat-badge">${t.category || 'Uncategorized'}</span>
                        </td>
                        <td>
                            <span class="inv-type-badge ${isIncome ? 'income' : 'expense'}">
                                <i class="fas ${isIncome ? 'fa-arrow-down' : 'fa-arrow-up'}"></i>
                                ${isIncome ? incomeLabel : expensesLabel}
                            </span>
                        </td>
                        <td>
                            <span class="${isIncome ? 'inv-amount-pos' : 'inv-amount-neg'}">
                                ${isIncome ? '+' : '-'} ₱${parseFloat(t.amount).toFixed(2)}
                            </span>
                        </td>
                        <td style="color: var(--inv-muted);">${t.remarks || '—'}</td>
                        <td style="text-align: center;">
                            <div class="inv-action-btns">
                                <a href="/inventory/${t.id}/edit" class="inv-icon-btn edit" title="Edit" onclick="event.stopPropagation();">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="inv-icon-btn delete" title="Delete" onclick="event.stopPropagation(); confirmDelete(${t.id})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
        tbody.innerHTML = html;

        tbody.querySelectorAll('.clickable-row').forEach(row => {
            row.addEventListener('click', function(e) {
                if (e.target.closest('.inv-action-btns') || e.target.closest('.inv-icon-btn')) {
                    return;
                }
                const id = this.getAttribute('data-id');
                if (id) {
                    window.location.href = `/inventory/${id}/edit`;
                }
            });
        });

        document.querySelectorAll('.filter-tab-premium').forEach(tab => tab.classList.remove('active'));
        document.querySelector('.filter-tab-premium[onclick*="all"]')?.classList.add('active');

        const searchVal = document.getElementById('transactionSearch').value;
        if (searchVal) {
            searchTransactions();
        }
    }

    // ============================================
    // INITIALIZE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('transactionsTableBody').innerHTML = `
            <tr>
                <td colspan="7">
                    <div class="inv-empty" style="padding: 2rem;">
                        <i class="fas fa-receipt"></i>
                        <p style="font-weight: 500; color: var(--inv-muted);">${window.t ? window.t('select_filter') : 'Select a filter to view transactions'}</p>
                    </div>
                </td>
            </tr>
        `;
    });

    document.getElementById('incomeModal')?.addEventListener('shown.bs.modal', function() {
        updateIncomePreview();
    });

    document.getElementById('expenseModal')?.addEventListener('shown.bs.modal', function() {
        updateExpensePreview();
    });
</script>
@endsection