@extends('layouts.app')

@section('header')
    <span data-i18n="finance_dashboard">{{ __("Finance Dashboard") }}</span>
@endsection

@section('content')

<style>
    /* ==========================================================
       FINANCE DASHBOARD — 2025 REDESIGN
       Flat · bordered · airy · Inter
       (functionality unchanged — design only)
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .fd {
        --fd-card: var(--card-bg, #ffffff);
        --fd-border: var(--border-color, #e8eaf0);
        --fd-text: var(--text-primary, #0f172a);
        --fd-muted: var(--text-muted, #7c8494);
        --fd-soft: var(--bg-tertiary, #f5f6fa);

        --fd-primary: #4f46e5;
        --fd-primary-soft: rgba(79, 70, 229, .08);
        --fd-primary-ring: rgba(79, 70, 229, .18);

        --fd-green: #059669;
        --fd-green-soft: rgba(5, 150, 105, .10);
        --fd-rose: #e11d48;
        --fd-rose-soft: rgba(225, 29, 72, .09);
        --fd-amber: #d97706;
        --fd-amber-soft: rgba(217, 119, 6, .10);
        --fd-violet: #7c3aed;
        --fd-violet-soft: rgba(124, 58, 237, .10);
        --fd-blue: #2563eb;
        --fd-blue-soft: rgba(37, 99, 235, .10);

        --fd-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --fd-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --fd-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--fd-text);
        padding-bottom: 2rem;
    }

    [data-theme="dark"] .fd {
        --fd-primary: #6366f1;
        --fd-primary-soft: rgba(99, 102, 241, .16);
        --fd-primary-ring: rgba(99, 102, 241, .28);
        --fd-green: #34d399;
        --fd-green-soft: rgba(16, 185, 129, .14);
        --fd-rose: #fb7185;
        --fd-rose-soft: rgba(244, 63, 94, .14);
        --fd-amber: #fbbf24;
        --fd-amber-soft: rgba(245, 158, 11, .14);
        --fd-violet: #a78bfa;
        --fd-violet-soft: rgba(139, 92, 246, .16);
        --fd-blue: #60a5fa;
        --fd-blue-soft: rgba(59, 130, 246, .16);
        --fd-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --fd-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .fd * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .fd-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--fd-border);
        margin-bottom: 1.5rem;
    }

    .fd-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--fd-muted);
        margin-bottom: .55rem;
    }

    .fd-eyebrow .fd-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--fd-green);
        box-shadow: 0 0 0 3px var(--fd-green-soft);
    }

    .fd-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .fd-title i { font-size: 1.2rem; color: var(--fd-primary); }

    .fd-sub {
        margin: .5rem 0 0;
        font-size: .84rem;
        color: var(--fd-muted);
        max-width: 62ch;
        line-height: 1.5;
    }

    .fd-head-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .fd-btn {
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

    .fd-btn-primary {
        background: var(--fd-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .fd-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .fd-btn-ghost {
        background: var(--fd-card);
        color: var(--fd-text);
        border-color: var(--fd-border);
    }
    .fd-btn-ghost:hover {
        background: var(--fd-soft);
        color: var(--fd-text);
        transform: translateY(-1px);
    }

    /* ---------------- STATS ---------------- */
    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card-premium {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: 1.05rem 1.15rem;
        background: var(--fd-card);
        border: 1px solid var(--fd-border);
        border-radius: var(--fd-radius);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        position: relative;
    }

    .stat-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--fd-shadow-md);
        border-color: transparent;
    }

    .stat-card-premium .stat-icon-wrap {
        width: 44px; height: 44px;
        border-radius: 13px;
        display: grid;
        place-items: center;
        font-size: 1rem;
        flex: 0 0 auto;
    }

    .stat-card-premium.green  .stat-icon-wrap { background: var(--fd-green-soft);   color: var(--fd-green); }
    .stat-card-premium.red    .stat-icon-wrap { background: var(--fd-rose-soft);    color: var(--fd-rose); }
    .stat-card-premium.blue   .stat-icon-wrap { background: var(--fd-primary-soft); color: var(--fd-primary); }
    .stat-card-premium.purple .stat-icon-wrap { background: var(--fd-violet-soft);  color: var(--fd-violet); }

    .stat-card-premium .stat-body { min-width: 0; }

    .stat-card-premium .stat-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--fd-muted);
        margin: 0 0 .2rem;
    }

    .stat-card-premium .stat-value {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1.15;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-card-premium .stat-change {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        margin-top: .25rem;
        padding: .12rem .5rem;
        border-radius: 20px;
        font-size: .64rem;
        font-weight: 600;
        background: var(--fd-soft);
        color: var(--fd-muted);
    }

    .stat-card-premium .stat-change.positive { color: var(--fd-green); background: var(--fd-green-soft); }
    .stat-card-premium .stat-change.negative { color: var(--fd-rose);  background: var(--fd-rose-soft); }

    /* ---------------- CARD / PANEL ---------------- */
    .fd-card {
        background: var(--fd-card);
        border: 1px solid var(--fd-border);
        border-radius: var(--fd-radius);
        box-shadow: var(--fd-shadow-sm);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: box-shadow .22s ease, border-color .22s ease;
    }

    .fd-card:hover {
        box-shadow: var(--fd-shadow-md);
        border-color: transparent;
    }

    .fd-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .9rem 1.15rem;
        border-bottom: 1px solid var(--fd-border);
        background: var(--fd-soft);
    }

    .fd-card-head-left {
        display: flex;
        align-items: center;
        gap: .65rem;
        min-width: 0;
    }

    .fd-card-head-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: .75rem;
        background: var(--fd-primary-soft);
        color: var(--fd-primary);
        flex: 0 0 auto;
    }

    .fd-card-head-title {
        font-size: .9rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        margin: 0;
    }

    .fd-card-head-sub {
        font-size: .7rem;
        color: var(--fd-muted);
        margin-top: .1rem;
    }

    .fd-card-head-tag {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .22rem .6rem;
        border-radius: 20px;
        border: 1px solid var(--fd-border);
        background: var(--fd-card);
        font-size: .64rem;
        font-weight: 600;
        color: var(--fd-muted);
        white-space: nowrap;
    }

    .fd-card-head-tag i { font-size: .56rem; }

    .fd-card-body { padding: 1.15rem 1.15rem; }

    /* ---------------- FILTER BAR ---------------- */
    .filter-card-modern {
        background: var(--fd-card);
        border: 1px solid var(--fd-border);
        border-radius: var(--fd-radius);
        padding: 1rem 1.15rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--fd-shadow-sm);
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        transition: box-shadow .22s ease;
    }

    .filter-card-modern:hover { box-shadow: var(--fd-shadow-md); }

    .filter-field { min-width: 0; flex: 1 1 260px; }

    .filter-label-modern {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--fd-muted);
        margin-bottom: .4rem;
    }

    .filter-label-modern i { font-size: .62rem; color: var(--fd-primary); }

    .filter-select-modern {
        width: 100%;
        padding: .6rem 2.4rem .6rem .9rem;
        border-radius: 11px;
        border: 1px solid var(--fd-border);
        background: var(--fd-soft);
        color: var(--fd-text);
        font-size: .82rem;
        font-family: inherit;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237c8494' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right .85rem center;
        background-size: 13px;
    }

    .filter-select-modern:focus {
        outline: none;
        background-color: var(--fd-card);
        border-color: var(--fd-primary);
        box-shadow: 0 0 0 3px var(--fd-primary-ring);
    }

    .filter-select-modern option { background: var(--fd-card); color: var(--fd-text); }

    .total-badge-modern {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .45rem .9rem;
        border-radius: 30px;
        background: var(--fd-soft);
        color: var(--fd-muted);
        border: 1px solid var(--fd-border);
        font-size: .74rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .total-badge-modern i { font-size: .68rem; color: var(--fd-primary); }

    .total-badge-modern strong { color: var(--fd-text); font-weight: 700; }

    /* ---------------- CHURCH DETAIL ---------------- */
    .church-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .9rem;
    }

    .church-detail-item {
        background: var(--fd-soft);
        border: 1px solid var(--fd-border);
        border-radius: 12px;
        padding: .95rem 1rem;
        text-align: center;
        transition: transform .2s ease, border-color .2s ease;
    }

    .church-detail-item:hover {
        transform: translateY(-2px);
        border-color: var(--fd-primary);
    }

    .church-detail-item .label {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .62rem;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: var(--fd-muted);
        font-weight: 700;
        margin-bottom: .35rem;
    }

    .church-detail-item .label i { font-size: .62rem; }

    .church-detail-item .value {
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1.2;
    }

    .church-detail-item .value.income  { color: var(--fd-green); }
    .church-detail-item .value.expense { color: var(--fd-rose); }
    .church-detail-item .value.balance { color: var(--fd-primary); }
    .church-detail-item .value.balance.positive { color: var(--fd-green); }
    .church-detail-item .value.balance.negative { color: var(--fd-rose); }

    .church-detail-item .sub-text {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        margin-top: .35rem;
        font-size: .64rem;
        font-weight: 600;
        color: var(--fd-muted);
    }

    .category-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        padding-top: 1.15rem;
        margin-top: 1.15rem;
        border-top: 1px solid var(--fd-border);
    }

    .category-section .cat-label {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .62rem;
        text-transform: uppercase;
        letter-spacing: .09em;
        color: var(--fd-muted);
        font-weight: 700;
        margin-bottom: .55rem;
    }

    .category-section .cat-label i { font-size: .62rem; }

    .category-tags {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
    }

    .category-tag {
        padding: .28rem .65rem;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 600;
        border: 1px solid var(--fd-border);
        background: var(--fd-soft);
        color: var(--fd-muted);
        transition: transform .18s ease, border-color .18s ease;
    }

    .category-tag:hover { transform: translateY(-1px); }

    .category-tag.income-tag {
        background: var(--fd-green-soft);
        color: var(--fd-green);
        border-color: transparent;
    }

    .category-tag.expense-tag {
        background: var(--fd-rose-soft);
        color: var(--fd-rose);
        border-color: transparent;
    }

    /* ---------------- CHART ---------------- */
    .chart-header h6 {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin: 0;
        font-size: .9rem;
        font-weight: 700;
        letter-spacing: -.005em;
        color: var(--fd-text);
    }

    .chart-header h6 i {
        display: grid;
        place-items: center;
        width: 30px; height: 30px;
        border-radius: 9px;
        font-size: .7rem;
        background: var(--fd-green-soft);
        color: var(--fd-green);
    }

    .chart-legend-premium {
        display: flex;
        gap: 1.25rem;
        margin: .35rem 0 1rem;
        flex-wrap: wrap;
    }

    .leg-item {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .72rem;
        color: var(--fd-muted);
        font-weight: 500;
    }

    .leg-dot {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }

    .leg-dot.dashed {
        background: none;
        border-top: 2px dashed var(--fd-rose);
        height: 2px;
        width: 20px;
        border-radius: 0;
    }

    .chart-box {
        height: 300px;
        position: relative;
    }

    .chart-box canvas { width: 100% !important; height: 100% !important; }

    /* ---------------- INFO MESSAGE ---------------- */
    .info-message-modern {
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: .85rem 1.15rem;
        border-radius: 12px;
        background: var(--fd-primary-soft);
        color: var(--fd-primary);
        border: 1px solid transparent;
        font-size: .82rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }

    .info-message-modern i { font-size: .95rem; flex: 0 0 auto; }

    /* ---------------- ALL CHURCHES GRID ---------------- */
    .all-churches-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .church-mini-card-premium {
        position: relative;
        background: var(--fd-card);
        border: 1px solid var(--fd-border);
        border-radius: var(--fd-radius);
        padding: 1.15rem 1.15rem 1rem;
        box-shadow: var(--fd-shadow-sm);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    }

    .church-mini-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--fd-shadow-md);
        border-color: transparent;
    }

    .church-mini-card-premium .status-dot {
        position: absolute;
        top: 14px; right: 14px;
        width: 9px; height: 9px;
        border-radius: 50%;
    }

    .church-mini-card-premium .status-dot.surplus {
        background: var(--fd-green);
        box-shadow: 0 0 0 4px var(--fd-green-soft);
    }

    .church-mini-card-premium .status-dot.deficit {
        background: var(--fd-rose);
        box-shadow: 0 0 0 4px var(--fd-rose-soft);
    }

    .church-mini-card-premium .church-name {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .88rem;
        font-weight: 700;
        color: var(--fd-text);
        letter-spacing: -.005em;
        margin-bottom: .5rem;
        padding-right: 1.5rem;
    }

    .church-mini-card-premium .church-name i {
        display: grid;
        place-items: center;
        width: 26px; height: 26px;
        border-radius: 8px;
        font-size: .65rem;
        background: var(--fd-primary-soft);
        color: var(--fd-primary);
        flex: 0 0 auto;
    }

    .church-mini-card-premium .mini-balance {
        font-size: 1.3rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1.15;
        margin-bottom: .5rem;
    }

    .church-mini-card-premium .mini-balance.positive { color: var(--fd-green); }
    .church-mini-card-premium .mini-balance.negative { color: var(--fd-rose); }

    .church-mini-card-premium .mini-details {
        display: flex;
        gap: .4rem;
        flex-wrap: wrap;
        margin-bottom: .65rem;
    }

    .church-mini-card-premium .mini-details span {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .22rem .55rem;
        border-radius: 20px;
        background: var(--fd-soft);
        border: 1px solid var(--fd-border);
        color: var(--fd-muted);
        font-size: .66rem;
        font-weight: 600;
    }

    .church-mini-card-premium .mini-details span i { font-size: .55rem; }

    .btn-view-church-premium {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .42rem .85rem;
        border-radius: 9px;
        font-size: .72rem;
        font-weight: 600;
        background: var(--fd-primary-soft);
        color: var(--fd-primary);
        border: 1px solid transparent;
        text-decoration: none;
        transition: background .18s ease, color .18s ease, transform .18s ease;
    }

    .btn-view-church-premium:hover {
        background: var(--fd-primary);
        color: #fff;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ---------------- EMPTY ---------------- */
    .empty-state-modern {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--fd-muted);
    }

    .empty-state-modern i {
        font-size: 2.4rem;
        opacity: .35;
        display: block;
        margin-bottom: .9rem;
    }

    .empty-state-modern h5 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--fd-text);
        letter-spacing: -.01em;
        margin: 0 0 .35rem;
    }

    .empty-state-modern p { font-size: .82rem; margin: 0; }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 1200px) {
        .stats-grid-premium { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 992px) {
        .fd-head { flex-direction: column; align-items: flex-start; }
        .category-section { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .fd-title { font-size: 1.3rem; }
        .fd-sub { font-size: .78rem; }

        .stats-grid-premium { grid-template-columns: 1fr 1fr; gap: .8rem; }
        .stat-card-premium { padding: .9rem; }
        .stat-card-premium .stat-value { font-size: 1.15rem; }
        .stat-card-premium .stat-icon-wrap { width: 38px; height: 38px; font-size: .85rem; }

        .fd-head-actions { width: 100%; }
        .fd-head-actions .fd-btn { flex: 1; justify-content: center; }

        .filter-card-modern { flex-direction: column; align-items: stretch; }
        .filter-field { flex: 1 1 auto; }

        .church-detail-grid { grid-template-columns: 1fr 1fr; }
        .all-churches-grid-premium { grid-template-columns: 1fr 1fr; }
        .chart-box { height: 220px; }
    }

    @media (max-width: 480px) {
        .stats-grid-premium { grid-template-columns: 1fr; }
        .church-detail-grid { grid-template-columns: 1fr; }
        .all-churches-grid-premium { grid-template-columns: 1fr; }
        .filter-select-modern { width: 100%; }
        .total-badge-modern { justify-content: center; width: 100%; }
        .chart-box { height: 200px; }
    }
</style>

<div class="fd container-fluid px-0">

    {{-- ============================================
         HERO
    ============================================ --}}
    <header class="fd-head">
        <div>
            <div class="fd-eyebrow">
                <span class="fd-dot"></span>
                <span data-i18n="finance_overview">{{ __("Finance Overview") }}</span>
            </div>
            <h1 class="fd-title">
                <i class="fas fa-coins"></i>
                <span data-i18n="finance_dashboard">{{ __("Finance Dashboard") }}</span>
            </h1>
            <p class="fd-sub" data-i18n="finance_dashboard_desc">
                {{ __("Track income, expenses, and financial health across all churches") }}
            </p>
        </div>
        <div class="fd-head-actions">
            <a href="{{ route('finance.index') }}?church=all" class="fd-btn fd-btn-primary">
                <i class="fas fa-chart-simple"></i>
                <span data-i18n="view_all">{{ __("View All") }}</span>
            </a>
            <a href="{{ route('finance.index') }}" class="fd-btn fd-btn-ghost">
                <i class="fas fa-sync-alt"></i>
                <span data-i18n="refresh">{{ __("Refresh") }}</span>
            </a>
        </div>
    </header>

    {{-- ============================================
         STATS
    ============================================ --}}
    <section class="stats-grid-premium">
        <div class="stat-card-premium green">
            <div class="stat-icon-wrap"><i class="fas fa-arrow-down"></i></div>
            <div class="stat-body">
                <p class="stat-label"><span data-i18n="total_income">{{ __("Total Income") }}</span></p>
                <div class="stat-value">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span data-i18n="all_churches">{{ __("All churches") }}</span>
                </span>
            </div>
        </div>

        <div class="stat-card-premium red">
            <div class="stat-icon-wrap"><i class="fas fa-arrow-up"></i></div>
            <div class="stat-body">
                <p class="stat-label"><span data-i18n="total_expenses">{{ __("Total Expenses") }}</span></p>
                <div class="stat-value">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
                <span class="stat-change negative">
                    <i class="fas fa-arrow-down"></i>
                    <span data-i18n="all_churches">{{ __("All churches") }}</span>
                </span>
            </div>
        </div>

        <div class="stat-card-premium blue">
            <div class="stat-icon-wrap"><i class="fas fa-scale-balanced"></i></div>
            <div class="stat-body">
                <p class="stat-label"><span data-i18n="overall_balance">{{ __("Overall Balance") }}</span></p>
                <div class="stat-value" style="color: {{ ($overallBalance ?? 0) >= 0 ? 'var(--fd-green)' : 'var(--fd-rose)' }}">
                    ₱{{ number_format(abs($overallBalance ?? 0), 2) }}
                </div>
                <span class="stat-change {{ ($overallBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    {{ ($overallBalance ?? 0) >= 0 ? '↑ ' : '↓ ' }}
                    <span data-i18n="{{ ($overallBalance ?? 0) >= 0 ? 'surplus' : 'deficit' }}">
                        {{ ($overallBalance ?? 0) >= 0 ? __("Surplus") : __("Deficit") }}
                    </span>
                </span>
            </div>
        </div>

        <div class="stat-card-premium purple">
            <div class="stat-icon-wrap"><i class="fas fa-church"></i></div>
            <div class="stat-body">
                <p class="stat-label"><span data-i18n="churches">{{ __("Churches") }}</span></p>
                <div class="stat-value">{{ $churches->count() ?? 0 }}</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span data-i18n="connected_churches">{{ __("Connected churches") }}</span>
                </span>
            </div>
        </div>
    </section>

    {{-- ============================================
         FILTER
    ============================================ --}}
    <div class="filter-card-modern">
        <div class="filter-field">
            <span class="filter-label-modern">
                <i class="fas fa-church"></i>
                <span data-i18n="select_church">{{ __("Select Church") }}</span>
            </span>
            <select id="churchSelect" class="filter-select-modern"
                    onchange="window.location.href='{{ route('finance.index') }}?church=' + this.value">
                <option value="">— {{ __("Choose a Church") }} —</option>
                @foreach($churches as $church)
                    <option value="{{ $church->id }}" {{ ($selectedChurchId ?? '') == $church->id ? 'selected' : '' }}>
                        {{ $church->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <span class="total-badge-modern">
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
        {{-- ============================================
             CHURCH DETAIL
        ============================================ --}}
        <div class="fd-card">
            <div class="fd-card-head">
                <div class="fd-card-head-left">
                    <div class="fd-card-head-icon"><i class="fas fa-church"></i></div>
                    <div>
                        <h2 class="fd-card-head-title">{{ $selectedChurch->name }}</h2>
                        <div class="fd-card-head-sub" data-i18n="church_financial_summary">
                            {{ __("Financial summary for the selected church") }}
                        </div>
                    </div>
                </div>
                <span class="fd-card-head-tag">
                    <i class="fas fa-calendar-alt"></i>
                    {{ now()->format('F d, Y') }}
                </span>
            </div>

            <div class="fd-card-body">
                <div class="church-detail-grid">
                    <div class="church-detail-item">
                        <div class="label">
                            <i class="fas fa-arrow-down" style="color: var(--fd-green);"></i>
                            <span data-i18n="total_income">{{ __("Total Income") }}</span>
                        </div>
                        <div class="value income">₱{{ number_format($churchIncome ?? 0, 2) }}</div>
                    </div>
                    <div class="church-detail-item">
                        <div class="label">
                            <i class="fas fa-arrow-up" style="color: var(--fd-rose);"></i>
                            <span data-i18n="total_expenses">{{ __("Total Expenses") }}</span>
                        </div>
                        <div class="value expense">₱{{ number_format($churchExpenses ?? 0, 2) }}</div>
                    </div>
                    <div class="church-detail-item">
                        <div class="label">
                            <i class="fas fa-scale-balanced" style="color: var(--fd-primary);"></i>
                            <span data-i18n="balance">{{ __("Balance") }}</span>
                        </div>
                        <div class="value balance {{ ($churchBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                            ₱{{ number_format(abs($churchBalance ?? 0), 2) }}
                        </div>
                        <div class="sub-text">
                            {{ ($churchBalance ?? 0) >= 0 ? '↑ ' : '↓ ' }}
                            <span data-i18n="{{ ($churchBalance ?? 0) >= 0 ? 'surplus' : 'deficit' }}">
                                {{ ($churchBalance ?? 0) >= 0 ? __("Surplus") : __("Deficit") }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="category-section">
                    <div>
                        <span class="cat-label">
                            <i class="fas fa-tags" style="color: var(--fd-green);"></i>
                            <span data-i18n="income_categories">{{ __("Income Categories") }}</span>
                        </span>
                        <div class="category-tags">
                            @forelse($incomeTypes ?? [] as $type)
                                <span class="category-tag income-tag">
                                    {{ $type->category ?? __("Uncategorized") }}: ₱{{ number_format($type->total, 2) }}
                                </span>
                            @empty
                                <span style="font-size:.72rem; color: var(--fd-muted);">
                                    <span data-i18n="no_income_categories">{{ __("No income categories") }}</span>
                                </span>
                            @endforelse
                        </div>
                    </div>
                    <div>
                        <span class="cat-label">
                            <i class="fas fa-tags" style="color: var(--fd-rose);"></i>
                            <span data-i18n="expense_categories">{{ __("Expense Categories") }}</span>
                        </span>
                        <div class="category-tags">
                            @forelse($expenseTypes ?? [] as $type)
                                <span class="category-tag expense-tag">
                                    {{ $type->category ?? __("Uncategorized") }}: ₱{{ number_format($type->total, 2) }}
                                </span>
                            @empty
                                <span style="font-size:.72rem; color: var(--fd-muted);">
                                    <span data-i18n="no_expense_categories">{{ __("No expense categories") }}</span>
                                </span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================
             CHART
        ============================================ --}}
        <div class="fd-card">
            <div class="fd-card-head">
                <div class="chart-header">
                    <h6>
                        <i class="fas fa-chart-line"></i>
                        <span data-i18n="monthly_income_expenses">{{ __("Monthly Income vs Expenses") }}</span>
                        — {{ $selectedChurch->name }}
                    </h6>
                </div>
                <span class="fd-card-head-tag">
                    <i class="fas fa-clock"></i>
                    <span data-i18n="last_6_months">{{ __("Last 6 months") }}</span>
                </span>
            </div>

            <div class="fd-card-body">
                <div class="chart-legend-premium">
                    <span class="leg-item">
                        <span class="leg-dot" style="background: var(--fd-green);"></span>
                        <span data-i18n="income">{{ __("Income") }}</span>
                    </span>
                    <span class="leg-item">
                        <span class="leg-dot dashed"></span>
                        <span data-i18n="expenses">{{ __("Expenses") }}</span>
                    </span>
                </div>
                <div class="chart-box">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>
    @else
        {{-- ============================================
             ALL CHURCHES OVERVIEW
        ============================================ --}}
        <div class="info-message-modern">
            <i class="fas fa-info-circle"></i>
            <span data-i18n="select_church_hint">
                {{ __("Select a church above to view its detailed financial information.") }}
            </span>
        </div>

        <div class="all-churches-grid-premium">
            @foreach($churchBalances ?? [] as $data)
                <div class="church-mini-card-premium">
                    <div class="status-dot {{ $data['status'] }}"></div>
                    <div class="church-name">
                        <i class="fas fa-church"></i>
                        <span>{{ $data['church']->name }}</span>
                    </div>
                    <div class="mini-balance {{ $data['status'] == 'surplus' ? 'positive' : 'negative' }}">
                        ₱{{ number_format(abs($data['balance']), 2) }}
                        {{ $data['balance'] >= 0 ? '↑' : '↓' }}
                    </div>
                    <div class="mini-details">
                        <span>
                            <i class="fas fa-arrow-down" style="color: var(--fd-green);"></i>
                            ₱{{ number_format($data['income'], 2) }}
                        </span>
                        <span>
                            <i class="fas fa-arrow-up" style="color: var(--fd-rose);"></i>
                            ₱{{ number_format($data['expense'], 2) }}
                        </span>
                    </div>
                    <a href="{{ route('finance.index') }}?church={{ $data['church']->id }}" class="btn-view-church-premium">
                        <i class="fas fa-eye"></i>
                        <span data-i18n="view_details">{{ __("View Details") }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ⭐ Helper
    function t(key, fallback) {
        if (typeof window.t === 'function') return window.t(key, fallback);
        if (typeof window.__t === 'function') return window.__t(key, fallback);
        return fallback || key;
    }

    let financeChartInstance = null;

    function buildFinanceChart() {
        const canvas = document.getElementById('financeChart');
        if (!canvas) return;

        let monthlyData = @json($monthlyData ?? []);
        let months = monthlyData.map(item => item.month);
        let incomeData = monthlyData.map(item => item.income);
        let expenseData = monthlyData.map(item => item.expense);

        if (!Array.isArray(months) || months.length === 0) {
            months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            incomeData = [0, 0, 0, 0, 0, 0];
            expenseData = [0, 0, 0, 0, 0, 0];
        }

        while (incomeData.length < months.length) incomeData.push(0);
        while (expenseData.length < months.length) expenseData.push(0);

        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
        const tickColor = isDark ? 'rgba(255,255,255,0.4)' : '#888';
        const ttBg = isDark ? '#2a2a2a' : '#ffffff';
        const ttTitle = isDark ? '#e0e0e0' : '#1e293b';
        const ttBody = isDark ? '#aaaaaa' : '#475569';
        const ttBorder = isDark ? 'rgba(255,255,255,0.1)' : '#e2e8f0';
        const ptBorder = isDark ? '#1e1e1e' : '#ffffff';

        const incomeLabel = t('income', 'Income');
        const expensesLabel = t('expenses', 'Expenses');

        if (financeChartInstance) financeChartInstance.destroy();

        financeChartInstance = new Chart(canvas, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: incomeLabel,
                        data: incomeData,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.07)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: ptBorder,
                        pointBorderWidth: 2,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#10B981',
                        pointHoverBorderColor: ptBorder,
                        pointHoverBorderWidth: 2
                    },
                    {
                        label: expensesLabel,
                        data: expenseData,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.05)',
                        borderWidth: 2,
                        borderDash: [5, 3],
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointBackgroundColor: '#EF4444',
                        pointBorderColor: ptBorder,
                        pointBorderWidth: 2,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#EF4444',
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
                            font: { size: 10 },
                            color: tickColor
                        },
                        grid: { color: gridColor, drawBorder: false }
                    },
                    x: {
                        ticks: { font: { size: 10 }, color: tickColor },
                        grid: { display: false, drawBorder: false }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', buildFinanceChart);

    // ⭐ LISTEN FOR LANGUAGE CHANGES — rebuild chart with new labels
    window.addEventListener('localeChanged', function(e) {
        if (typeof window.applyTranslations === 'function') {
            window.applyTranslations();
        }
        buildFinanceChart();
        console.log('[Finance] Locale changed to:', e.detail.locale);
    });

    // ⭐ Rebuild chart on theme change
    document.addEventListener('click', function(e) {
        if (e.target.closest('#themeToggleBtn')) {
            setTimeout(buildFinanceChart, 150);
        }
    });
</script>
@endsection