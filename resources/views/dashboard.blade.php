@extends('layouts.app')

@section('header')
    <span data-i18n="Dashboard">{{ __("Dashboard") }}</span>
@endsection

@section('content')
<style>
    /* ==========================================================
       DASHBOARD — 2025 REDESIGN
       Flat · bordered · airy · Inter
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .dash {
        --dash-card: var(--card-bg, #ffffff);
        --dash-border: var(--border-color, #e8eaf0);
        --dash-text: var(--text-primary, #0f172a);
        --dash-muted: var(--text-muted, #7c8494);
        --dash-soft: var(--bg-tertiary, #f5f6fa);

        --dash-primary: #4f46e5;
        --dash-primary-soft: rgba(79, 70, 229, .08);

        --dash-green: #059669;
        --dash-green-soft: rgba(5, 150, 105, .10);
        --dash-rose: #e11d48;
        --dash-rose-soft: rgba(225, 29, 72, .09);
        --dash-amber: #d97706;
        --dash-amber-soft: rgba(217, 119, 6, .10);
        --dash-violet: #7c3aed;
        --dash-violet-soft: rgba(124, 58, 237, .10);

        --dash-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --dash-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --dash-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--dash-text);
        padding-bottom: 2rem;
        max-width: 1600px;
        margin: 0 auto;
    }

    [data-theme="dark"] .dash {
        --dash-primary: #6366f1;
        --dash-primary-soft: rgba(99, 102, 241, .16);
        --dash-green: #34d399;
        --dash-green-soft: rgba(16, 185, 129, .14);
        --dash-rose: #fb7185;
        --dash-rose-soft: rgba(244, 63, 94, .14);
        --dash-amber: #fbbf24;
        --dash-amber-soft: rgba(245, 158, 11, .14);
        --dash-violet: #a78bfa;
        --dash-violet-soft: rgba(139, 92, 246, .16);
        --dash-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --dash-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .dash * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .dash-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--dash-border);
        margin-bottom: 1.5rem;
    }

    .dash-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--dash-muted);
        margin-bottom: .55rem;
    }

    .dash-eyebrow .dash-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--dash-green);
        box-shadow: 0 0 0 3px var(--dash-green-soft);
        animation: dashPulse 2s infinite;
    }

    @keyframes dashPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .5; transform: scale(.75); }
    }

    .dash-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .dash-title i { font-size: 1.2rem; color: var(--dash-primary); }

    .dash-sub {
        margin: .5rem 0 0;
        font-size: .84rem;
        color: var(--dash-muted);
        max-width: 62ch;
        line-height: 1.5;
    }

    .dash-head-right {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hero-stats {
        display: inline-flex;
        align-items: stretch;
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 14px;
        padding: .35rem .35rem;
        box-shadow: var(--dash-shadow-sm);
    }

    .hero-stat {
        padding: .5rem 1rem;
        text-align: center;
        position: relative;
        min-width: 78px;
    }

    .hero-stat + .hero-stat::before {
        content: '';
        position: absolute;
        left: 0; top: 22%; bottom: 22%;
        width: 1px;
        background: var(--dash-border);
    }

    .hero-stat .num {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--dash-text);
        letter-spacing: -.03em;
        line-height: 1;
    }

    .hero-stat .lbl {
        font-size: .58rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--dash-muted);
        margin-top: .3rem;
    }

    /* ---------------- BUTTONS ---------------- */
    .dash-btn {
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

    .dash-btn-primary {
        background: var(--dash-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .dash-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .dash-btn-ghost {
        background: var(--dash-card);
        color: var(--dash-text);
        border-color: var(--dash-border);
    }
    .dash-btn-ghost:hover {
        background: var(--dash-soft);
        color: var(--dash-text);
        transform: translateY(-1px);
    }

    /* ---------------- STATS GRID ---------------- */
    .stats-dash-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-dash-card {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: 1.05rem 1.15rem;
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: var(--dash-radius);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        position: relative;
    }

    .stat-dash-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--dash-shadow-md);
        border-color: transparent;
    }

    .stat-dash-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        display: grid;
        place-items: center;
        font-size: 1rem;
        flex: 0 0 auto;
    }

    .stat-dash-icon.green  { background: var(--dash-green-soft);   color: var(--dash-green); }
    .stat-dash-icon.violet { background: var(--dash-violet-soft);  color: var(--dash-violet); }
    .stat-dash-icon.blue   { background: var(--dash-primary-soft); color: var(--dash-primary); }
    .stat-dash-icon.amber  { background: var(--dash-amber-soft);   color: var(--dash-amber); }

    .stat-dash-body { min-width: 0; flex: 1; }

    .stat-dash-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--dash-muted);
        margin: 0 0 .2rem;
        display: block;
    }

    .stat-dash-value {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -.03em;
        line-height: 1.15;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat-dash-meta {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        margin-top: .3rem;
        padding: .12rem .5rem;
        border-radius: 20px;
        font-size: .64rem;
        font-weight: 600;
        background: var(--dash-soft);
        color: var(--dash-muted);
    }

    .stat-dash-meta.positive { color: var(--dash-green); background: var(--dash-green-soft); }
    .stat-dash-meta.negative { color: var(--dash-rose);  background: var(--dash-rose-soft); }

    /* ---------------- CARD ---------------- */
    .dash-card {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: var(--dash-radius);
        box-shadow: var(--dash-shadow-sm);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: box-shadow .22s ease, border-color .22s ease;
    }

    .dash-card:hover {
        box-shadow: var(--dash-shadow-md);
        border-color: transparent;
    }

    .dash-card:last-child { margin-bottom: 0; }

    .dash-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .9rem 1.15rem;
        border-bottom: 1px solid var(--dash-border);
        background: var(--dash-soft);
    }

    .dash-card-head-left {
        display: flex;
        align-items: center;
        gap: .65rem;
        min-width: 0;
    }

    .dash-card-head-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: .75rem;
        background: var(--dash-primary-soft);
        color: var(--dash-primary);
        flex: 0 0 auto;
    }

    .dash-card-head-icon.rose  { background: var(--dash-rose-soft);   color: var(--dash-rose); }
    .dash-card-head-icon.amber { background: var(--dash-amber-soft);  color: var(--dash-amber); }
    .dash-card-head-icon.violet{ background: var(--dash-violet-soft); color: var(--dash-violet); }

    .dash-card-head-title {
        font-size: .9rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        margin: 0;
    }

    .dash-card-head-sub {
        font-size: .7rem;
        color: var(--dash-muted);
        margin-top: .1rem;
    }

    .dash-card-head-tag {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .22rem .6rem;
        border-radius: 20px;
        border: 1px solid var(--dash-border);
        background: var(--dash-card);
        font-size: .64rem;
        font-weight: 600;
        color: var(--dash-muted);
        white-space: nowrap;
    }

    .dash-card-head-tag i { font-size: .56rem; color: var(--dash-primary); }

    .dash-card-link {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .68rem;
        font-weight: 600;
        color: var(--dash-muted);
        text-decoration: none;
        transition: color .18s ease;
    }

    .dash-card-link:hover { color: var(--dash-primary); text-decoration: none; }

    .dash-card-body { padding: 1.15rem; }

    /* ==========================================================
       CHART — CONSTRAINED WRAPPER
       The wrapper has a fixed height and clips overflow.
       The canvas is absolutely positioned to fill it exactly.
       This prevents the canvas from expanding the page.
    ========================================================== */
    .chart-dash-body {
        position: relative;
        height: 300px;
        width: 100%;
        overflow: hidden;
    }

    .chart-dash-body > canvas {
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        height: 100% !important;
        max-height: 300px !important;
        display: block !important;
    }

    /* ---------------- BOTTOM GRID ---------------- */
    .dash-bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    .dash-bottom-col { display: flex; flex-direction: column; gap: 1.5rem; }

    /* ---------------- TRANSACTIONS ---------------- */
    .tx-item {
        display: flex;
        align-items: center;
        gap: .8rem;
        padding: .75rem 0;
        border-bottom: 1px solid var(--dash-border);
        transition: padding-left .18s ease;
    }

    .tx-item:last-child { border-bottom: none; padding-bottom: 0; }
    .tx-item:hover { padding-left: 4px; }

    .tx-icon {
        width: 38px; height: 38px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        font-size: .78rem;
        flex: 0 0 auto;
    }

    .tx-icon.income  { background: var(--dash-green-soft); color: var(--dash-green); }
    .tx-icon.expense { background: var(--dash-rose-soft);  color: var(--dash-rose); }

    .tx-body { flex: 1; min-width: 0; }

    .tx-name {
        font-size: .82rem;
        font-weight: 600;
        color: var(--dash-text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tx-meta {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-top: .2rem;
        font-size: .66rem;
        color: var(--dash-muted);
    }

    .tx-badge {
        padding: .1rem .5rem;
        border-radius: 20px;
        font-size: .58rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .tx-badge.income  { background: var(--dash-green-soft); color: var(--dash-green); }
    .tx-badge.expense { background: var(--dash-rose-soft);  color: var(--dash-rose); }

    .tx-amount {
        font-size: .84rem;
        font-weight: 700;
        text-align: right;
        flex: 0 0 auto;
        font-variant-numeric: tabular-nums;
        letter-spacing: -.01em;
    }

    .tx-amount.positive { color: var(--dash-green); }
    .tx-amount.negative { color: var(--dash-rose); }

    /* ---------------- BIRTHDAYS ---------------- */
    .bd-item {
        display: flex;
        align-items: center;
        gap: .8rem;
        padding: .65rem 0;
        border-bottom: 1px solid var(--dash-border);
        transition: padding-left .18s ease;
    }

    .bd-item:last-child { border-bottom: none; padding-bottom: 0; }
    .bd-item:hover { padding-left: 4px; }

    .bd-date {
        min-width: 46px;
        text-align: center;
        padding: .35rem .5rem;
        border-radius: 11px;
        background: var(--dash-amber-soft);
        color: var(--dash-amber);
        flex: 0 0 auto;
    }

    .bd-date .day {
        font-size: .95rem;
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1;
    }

    .bd-date .month {
        font-size: .55rem;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-top: .15rem;
        opacity: .85;
    }

    .bd-body { flex: 1; min-width: 0; }

    .bd-name {
        font-size: .82rem;
        font-weight: 600;
        color: var(--dash-text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bd-meta {
        display: flex;
        align-items: center;
        gap: .4rem;
        margin-top: .15rem;
        font-size: .66rem;
        color: var(--dash-muted);
        flex-wrap: wrap;
    }

    .bd-today {
        padding: .1rem .5rem;
        border-radius: 20px;
        font-size: .58rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        background: var(--dash-amber-soft);
        color: var(--dash-amber);
    }

    .bd-arrow {
        display: grid;
        place-items: center;
        width: 26px; height: 26px;
        border-radius: 8px;
        color: var(--dash-muted);
        font-size: .62rem;
        text-decoration: none;
        transition: background .18s ease, color .18s ease;
    }

    .bd-arrow:hover { background: var(--dash-soft); color: var(--dash-primary); }

    /* ---------------- CHOIR ---------------- */
    .choir-panel {
        background: var(--dash-violet-soft);
        border: 1px solid transparent;
        border-radius: 14px;
        padding: 1.25rem 1.15rem;
        text-align: center;
    }

    .choir-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        margin: 0 auto .85rem;
        background: var(--dash-violet);
        color: #fff;
        font-size: 1.35rem;
        box-shadow: 0 8px 22px -8px rgba(124, 58, 237, .55);
    }

    .choir-group {
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1.2;
    }

    .choir-meta {
        font-size: .74rem;
        color: var(--dash-muted);
        margin-top: .35rem;
        font-weight: 500;
    }

    .choir-meta i { color: var(--dash-violet); margin-right: .25rem; }

    .choir-chips {
        display: flex;
        flex-wrap: wrap;
        gap: .35rem;
        justify-content: center;
        margin: 1rem 0;
    }

    .choir-chip {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 20px;
        padding: .22rem .65rem;
        font-size: .66rem;
        font-weight: 600;
        color: var(--dash-muted);
        transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
    }

    .choir-chip:hover {
        background: var(--dash-violet);
        color: #fff;
        border-color: var(--dash-violet);
        transform: translateY(-1px);
    }

    .btn-choir-dash {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
        width: 100%;
        padding: .65rem 1.25rem;
        border-radius: 11px;
        background: var(--dash-violet);
        color: #fff;
        font-size: .78rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
        box-shadow: 0 8px 18px -10px rgba(124, 58, 237, .85);
    }

    .btn-choir-dash:hover {
        background: #6d28d9;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(124, 58, 237, .9);
        text-decoration: none;
    }

    .coming-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(124, 58, 237, .18);
    }

    .coming-item {
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-radius: 11px;
        padding: .55rem .4rem;
        text-align: center;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .coming-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--dash-shadow-sm);
    }

    .coming-date {
        font-size: .58rem;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--dash-muted);
    }

    .coming-name {
        font-size: .72rem;
        font-weight: 700;
        color: var(--dash-violet);
        margin-top: .2rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .coming-count {
        font-size: .6rem;
        color: var(--dash-muted);
        margin-top: .15rem;
    }

    /* ---------------- EMPTY ---------------- */
    .empty-dash {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--dash-muted);
    }

    .empty-dash-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        margin: 0 auto .75rem;
        background: var(--dash-soft);
        color: var(--dash-muted);
        font-size: 1.25rem;
        opacity: .8;
    }

    .empty-dash p {
        font-size: .8rem;
        margin: 0 0 .8rem;
        font-weight: 500;
    }

    .btn-empty-dash {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem .95rem;
        border-radius: 10px;
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        color: var(--dash-text);
        font-size: .72rem;
        font-weight: 700;
        text-decoration: none;
        transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
    }

    .btn-empty-dash:hover {
        background: var(--dash-primary);
        color: #fff;
        border-color: var(--dash-primary);
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ---------------- TOAST ---------------- */
    .dashboard-toast-modern {
        position: fixed;
        bottom: 28px;
        right: 28px;
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .85rem 1.15rem;
        background: var(--dash-card);
        border: 1px solid var(--dash-border);
        border-left: 4px solid var(--dash-primary);
        border-radius: 14px;
        box-shadow: 0 20px 48px -12px rgba(15, 27, 45, .25);
        z-index: 9999;
        transform: translateY(120%);
        opacity: 0;
        transition: all .4s cubic-bezier(.22, 1, .36, 1);
        min-width: 300px;
        max-width: 400px;
    }

    .dashboard-toast-modern.show {
        transform: translateY(0);
        opacity: 1;
    }

    .dashboard-toast-modern .toast-icon { font-size: 1.35rem; flex-shrink: 0; }
    .dashboard-toast-modern .toast-content { flex: 1; min-width: 0; }

    .dashboard-toast-modern .toast-title {
        font-size: .8rem;
        font-weight: 700;
        color: var(--dash-text);
    }

    .dashboard-toast-modern .toast-message {
        font-size: .72rem;
        color: var(--dash-muted);
        margin-top: .1rem;
    }

    .dashboard-toast-modern .toast-close {
        background: none;
        border: none;
        color: var(--dash-muted);
        cursor: pointer;
        padding: 4px;
        font-size: .75rem;
        transition: color .2s ease, transform .2s ease;
    }

    .dashboard-toast-modern .toast-close:hover {
        color: var(--dash-text);
        transform: rotate(90deg);
    }

    /* ---------------- UPDATED PULSE ---------------- */
    .updated { animation: updatedPulse .8s ease; }

    @keyframes updatedPulse {
        0%   { transform: scale(1); }
        40%  { transform: scale(1.1); background: rgba(16, 185, 129, .15); }
        100% { transform: scale(1); }
    }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 1200px) {
        .stats-dash-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 992px) {
        .dash-head { flex-direction: column; align-items: flex-start; }
        .dash-bottom-grid { grid-template-columns: 1fr; }
        .hero-stats { width: 100%; justify-content: space-around; }
        .hero-stat { flex: 1; min-width: 0; }
    }

    @media (max-width: 768px) {
        .dash-title { font-size: 1.3rem; }
        .dash-sub { font-size: .78rem; }

        .stats-dash-grid { grid-template-columns: 1fr 1fr; gap: .8rem; }
        .stat-dash-card { padding: .9rem; }
        .stat-dash-value { font-size: 1.15rem; }
        .stat-dash-icon { width: 38px; height: 38px; font-size: .85rem; }

        .dash-head-right { width: 100%; }
        .dash-head-right .dash-btn { flex: 1; justify-content: center; }

        .chart-dash-body { height: 240px; }
        .chart-dash-body > canvas { max-height: 240px !important; }

        .coming-grid { grid-template-columns: repeat(2, 1fr); }
        .dashboard-toast-modern { right: 16px; left: 16px; bottom: 16px; min-width: auto; }
    }

    @media (max-width: 480px) {
        .stats-dash-grid { grid-template-columns: 1fr; }
        .hero-stats { flex-direction: column; padding: .35rem; }
        .hero-stat + .hero-stat::before { display: none; }
        .hero-stat {
            border-top: 1px solid var(--dash-border);
            padding: .55rem .35rem;
        }
        .hero-stat:first-child { border-top: none; }

        .chart-dash-body { height: 200px; }
        .chart-dash-body > canvas { max-height: 200px !important; }
    }
</style>

<div class="dash container-fluid px-0">

    {{-- ============================================
         HEADER
    ============================================ --}}
    <header class="dash-head">
        <div>
            <div class="dash-eyebrow">
                <span class="dash-dot"></span>
                <span data-i18n="live">Live Dashboard</span>
            </div>
            <h1 class="dash-title">
                <i class="fas fa-church"></i>
                <span data-i18n="Dashboard">{{ __("Dashboard") }}</span>
            </h1>
            <p class="dash-sub" data-i18n="welcome_back">
                {{ __("Welcome back! Here's your church overview") }}
            </p>
        </div>

        <div class="dash-head-right">
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="num">{{ number_format($totalMembers ?? 0) }}</div>
                    <div class="lbl" data-i18n="members">{{ __("Members") }}</div>
                </div>
                <div class="hero-stat">
                    <div class="num">{{ number_format($choirMembers ?? 0) }}</div>
                    <div class="lbl" data-i18n="choir">{{ __("Choir") }}</div>
                </div>
                <div class="hero-stat">
                    <div class="num">{{ number_format($todayAttendance ?? 0) }}</div>
                    <div class="lbl" data-i18n="today">{{ __("Today") }}</div>
                </div>
            </div>

            <a href="{{ route('reports.analytics') }}" class="dash-btn dash-btn-primary">
                <i class="fas fa-chart-line"></i>
                <span data-i18n="analytics">{{ __("Analytics") }}</span>
            </a>
        </div>
    </header>

    {{-- ============================================
         STAT CARDS
    ============================================ --}}
    <section class="stats-dash-grid">

        <div class="stat-dash-card">
            <div class="stat-dash-icon green"><i class="fas fa-users"></i></div>
            <div class="stat-dash-body">
                <span class="stat-dash-label" data-i18n="total_members">{{ __("Total Members") }}</span>
                <div class="stat-dash-value" id="stat-total-members">{{ number_format($totalMembers ?? 0) }}</div>
                <span class="stat-dash-meta positive">
                    <i class="fas fa-arrow-trend-up"></i>
                    <span data-i18n="active_members">{{ __("Active members") }}</span>
                </span>
            </div>
        </div>

        <div class="stat-dash-card">
            <div class="stat-dash-icon violet"><i class="fas fa-music"></i></div>
            <div class="stat-dash-body">
                <span class="stat-dash-label" data-i18n="choir_members">{{ __("Choir Members") }}</span>
                <div class="stat-dash-value" id="stat-choir-members">{{ number_format($choirMembers ?? 0) }}</div>
                <span class="stat-dash-meta positive">
                    <i class="fas fa-arrow-trend-up"></i>
                    <span data-i18n="music_ministry">{{ __("Music ministry") }}</span>
                </span>
            </div>
        </div>

        <div class="stat-dash-card">
            <div class="stat-dash-icon blue"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-dash-body">
                <span class="stat-dash-label" data-i18n="today_attendance">{{ __("Today's Attendance") }}</span>
                <div class="stat-dash-value" id="stat-today-attendance">{{ number_format($todayAttendance ?? 0) }}</div>
                @php
                    $rate = ($totalMembers ?? 1) > 0 ? (($todayAttendance ?? 0) / ($totalMembers ?? 1)) * 100 : 0;
                @endphp
                <span class="stat-dash-meta {{ $rate >= 50 ? 'positive' : 'negative' }}" id="stat-attendance-rate">
                    <i class="fas fa-{{ $rate >= 50 ? 'arrow-up' : 'arrow-down' }}"></i>
                    {{ number_format($rate, 1) }}% <span data-i18n="present">{{ __("present") }}</span>
                </span>
            </div>
        </div>

        <div class="stat-dash-card">
            <div class="stat-dash-icon amber"><i class="fas fa-wallet"></i></div>
            <div class="stat-dash-body">
                <span class="stat-dash-label" data-i18n="monthly_balance">{{ __("Monthly Balance") }}</span>
                <div class="stat-dash-value" id="stat-monthly-balance"
                     style="color: {{ ($monthlyBalance ?? 0) >= 0 ? 'var(--dash-green)' : 'var(--dash-rose)' }};">
                    ₱{{ number_format(abs($monthlyBalance ?? 0), 2) }}
                </div>
                <span class="stat-dash-meta {{ ($monthlyBalance ?? 0) >= 0 ? 'positive' : 'negative' }}" id="stat-balance-trend">
                    <i class="fas fa-{{ ($monthlyBalance ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                    <span data-i18n="{{ ($monthlyBalance ?? 0) >= 0 ? 'surplus' : 'deficit' }}">
                        {{ ($monthlyBalance ?? 0) >= 0 ? __("Surplus") : __("Deficit") }}
                    </span>
                </span>
            </div>
        </div>

    </section>

    {{-- ============================================
         CHART
    ============================================ --}}
    <div class="dash-card">
        <div class="dash-card-head">
            <div class="dash-card-head-left">
                <div class="dash-card-head-icon"><i class="fas fa-chart-line"></i></div>
                <div>
                    <h2 class="dash-card-head-title" data-i18n="income_vs_expenses">
                        {{ __("Income vs Expenses") }}
                    </h2>
                    <div class="dash-card-head-sub" data-i18n="chart_subtitle">
                        {{ __("Monthly financial overview") }}
                    </div>
                </div>
            </div>
            <span class="dash-card-head-tag">
                <i class="fas fa-calendar-alt"></i>
                <span data-i18n="last_6_months">{{ __("Last 6 Months") }}</span>
            </span>
        </div>
        <div class="dash-card-body">
            <div class="chart-dash-body">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ============================================
         BOTTOM GRID
    ============================================ --}}
    <div class="dash-bottom-grid">

        {{-- ---------- Recent Transactions ---------- --}}
        <div class="dash-card">
            <div class="dash-card-head">
                <div class="dash-card-head-left">
                    <div class="dash-card-head-icon rose"><i class="fas fa-receipt"></i></div>
                    <div>
                        <h2 class="dash-card-head-title" data-i18n="recent_transactions">
                            {{ __("Recent Transactions") }}
                        </h2>
                    </div>
                </div>
                <a href="{{ route('finance.index') }}" class="dash-card-link">
                    <span data-i18n="view_all">{{ __("View all") }}</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="dash-card-body" id="transactions-list">
                @forelse(($recentActivities ?? []) as $item)
                    @php $isIncome = ($item->type ?? 'expense') === 'income'; @endphp
                    <div class="tx-item">
                        <div class="tx-icon {{ $isIncome ? 'income' : 'expense' }}">
                            <i class="fas {{ $isIncome ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        </div>
                        <div class="tx-body">
                            <div class="tx-name">{{ $item->description ?? $item->name ?? 'Transaction' }}</div>
                            <div class="tx-meta">
                                <span>{{ \Carbon\Carbon::parse($item->date ?? $item->created_at ?? now())->format('M d, Y') }}</span>
                                <span class="tx-badge {{ $isIncome ? 'income' : 'expense' }}" data-i18n="{{ $isIncome ? 'income' : 'expense' }}">
                                    {{ $isIncome ? __("Income") : __("Expense") }}
                                </span>
                            </div>
                        </div>
                        <div class="tx-amount {{ $isIncome ? 'positive' : 'negative' }}">
                            {{ $isIncome ? '+' : '−' }}₱{{ number_format($item->amount ?? 0, 2) }}
                        </div>
                    </div>
                @empty
                    <div class="empty-dash">
                        <div class="empty-dash-icon"><i class="fas fa-receipt"></i></div>
                        <p data-i18n="no_transactions">{{ __("No transactions yet") }}</p>
                        <a href="{{ route('finance.index') }}" class="btn-empty-dash">
                            <i class="fas fa-plus"></i>
                            <span data-i18n="add_transaction">{{ __("Add transaction") }}</span>
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ---------- Right Column ---------- --}}
        <div class="dash-bottom-col">

            {{-- Birthdays --}}
            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="dash-card-head-left">
                        <div class="dash-card-head-icon amber"><i class="fas fa-birthday-cake"></i></div>
                        <div>
                            <h2 class="dash-card-head-title" data-i18n="upcoming_birthdays">
                                {{ __("Upcoming Birthdays") }}
                            </h2>
                        </div>
                    </div>
                    <span class="dash-card-head-tag" data-i18n="this_month">{{ __("This month") }}</span>
                </div>
                <div class="dash-card-body" id="birthdays-list">
                    @forelse(($upcomingBirthdays ?? []) as $birthday)
                        @php
                            $daysUntil = $birthday->days_until ?? null;
                            $isToday = $daysUntil === 0;
                            $isTomorrow = $daysUntil === 1;
                        @endphp
                        <div class="bd-item">
                            <div class="bd-date">
                                <div class="day">{{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('d') }}</div>
                                <div class="month">{{ \Carbon\Carbon::parse($birthday->birthday ?? now())->format('M') }}</div>
                            </div>
                            <div class="bd-body">
                                <div class="bd-name">{{ $birthday->first_name ?? '' }} {{ $birthday->last_name ?? '' }}</div>
                                <div class="bd-meta">
                                    @if($isToday)
                                        <span class="bd-today">🎉 <span data-i18n="today_label">{{ __("Today!") }}</span></span>
                                    @elseif($isTomorrow)
                                        <span class="bd-today">🎂 <span data-i18n="tomorrow_label">{{ __("Tomorrow!") }}</span></span>
                                    @elseif($daysUntil !== null)
                                        <span data-i18n="turning_in_days">{{ __("Turning") }}</span> {{ $birthday->age ?? '?' }}
                                        <span data-i18n="in">{{ __("in") }}</span> {{ $daysUntil }} <span data-i18n="days">{{ __("days") }}</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('members.show', $birthday->id) }}" class="bd-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="empty-dash">
                            <div class="empty-dash-icon"><i class="fas fa-birthday-cake"></i></div>
                            <p data-i18n="no_upcoming_birthdays">{{ __("No upcoming birthdays") }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Choir Schedule --}}
            <div class="dash-card">
                <div class="dash-card-head">
                    <div class="dash-card-head-left">
                        <div class="dash-card-head-icon violet"><i class="fas fa-music"></i></div>
                        <div>
                            <h2 class="dash-card-head-title" data-i18n="choir_schedule">
                                {{ __("Choir Schedule") }}
                            </h2>
                        </div>
                    </div>
                    <span class="dash-card-head-tag" data-i18n="upcoming_label">{{ __("Upcoming") }}</span>
                </div>
                <div class="dash-card-body" id="choir-schedule-container">
                    @if(isset($upcomingSunday) && $upcomingSunday)
                        <div class="choir-panel">
                            <div class="choir-icon"><i class="fas fa-layer-group"></i></div>
                            <div class="choir-group" style="color: {{ $upcomingSunday['group_color'] ?? '#7C3AED' }};">
                                {{ $upcomingSunday['group_name'] ?? 'Choir Group' }}
                            </div>
                            <div class="choir-meta">
                                <i class="fas fa-users"></i>
                                {{ $upcomingSunday['members_count'] ?? 0 }} <span data-i18n="members">{{ __("Members") }}</span>
                                ·
                                {{ \Carbon\Carbon::parse($upcomingSunday['date'] ?? now())->format('M d, Y') }}
                            </div>

                            <div class="choir-chips" id="choir-members-chips">
                                @forelse(($upcomingSunday['members'] ?? []) as $member)
                                    <span class="choir-chip">
                                        {{ $member->first_name ?? '' }} {{ substr($member->last_name ?? '', 0, 1) }}.
                                    </span>
                                @empty
                                    <span class="choir-chip" data-i18n="no_members_assigned">{{ __("No members assigned") }}</span>
                                @endforelse
                            </div>

                            <a href="{{ route('choir-schedules.index', ['date' => $upcomingSunday['date'] ?? '']) }}" class="btn-choir-dash">
                                <i class="fas fa-calendar-alt"></i>
                                <span data-i18n="view_full_schedule">{{ __("View Full Schedule") }}</span>
                            </a>

                            @if(isset($nextWeeks) && count($nextWeeks) > 0)
                                <div class="coming-grid" id="coming-sundays-grid">
                                    @foreach($nextWeeks as $week)
                                        <div class="coming-item">
                                            <div class="coming-date">{{ \Carbon\Carbon::parse($week['date'])->format('M d') }}</div>
                                            <div class="coming-name">{{ $week['group_name'] ?? 'Choir' }}</div>
                                            <div class="coming-count"><i class="fas fa-users"></i> {{ $week['members_count'] ?? 0 }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-dash">
                            <div class="empty-dash-icon"><i class="fas fa-music"></i></div>
                            <p data-i18n="no_upcoming_schedule">{{ __("No upcoming schedule") }}</p>
                            <a href="{{ route('choir-schedules.index') }}" class="btn-empty-dash">
                                <i class="fas fa-plus"></i>
                                <span data-i18n="create_schedule">{{ __("Create schedule") }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

{{-- ===== SCRIPTS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    /* =============================================
       i18n helper
    ============================================= */
    function t(key, fallback) {
        if (typeof window.t === 'function') return window.t(key, fallback);
        if (typeof window.__t === 'function') return window.__t(key, fallback);
        return fallback || key;
    }

    /* =============================================
       FINANCE CHART
    ============================================= */
    let financeChartInstance = null;

    function buildFinanceChart() {
        const canvas = document.getElementById('financeChart');
        if (!canvas) return;

        // ⭐ Ensure parent has a defined size BEFORE Chart.js reads it
        const parent = canvas.parentElement;
        if (parent) {
            parent.style.position = 'relative';
            parent.style.height = '300px';
            parent.style.width = '100%';
        }

        // ⭐ Force canvas to have explicit pixel size BEFORE Chart.js init
        canvas.width = canvas.parentElement.clientWidth || 800;
        canvas.height = 300;

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

        if (financeChartInstance) {
            financeChartInstance.destroy();
            financeChartInstance = null;
        }

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

        // ⭐ Force resize after mount — fixes empty/0-height charts
        setTimeout(function () {
            if (financeChartInstance) {
                try { financeChartInstance.resize(); } catch (e) {}
            }
        }, 80);
    }

    /* =============================================
       BUILD ON LOAD
    ============================================= */
    document.addEventListener('DOMContentLoaded', function() {

        // ⭐ Wait for layout/paint before building chart
        requestAnimationFrame(function () {
            setTimeout(buildFinanceChart, 60);
        });

        // ⭐ Auto-resize chart on window resize
        window.addEventListener('resize', function () {
            if (financeChartInstance) {
                try { financeChartInstance.resize(); } catch (e) {}
            }
        });

        // ============================================
        // TOAST
        // ============================================
        function showDashboardToast(title, message, icon) {
            icon = icon || '📊';
            let toast = document.getElementById('dashboardToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'dashboardToast';
                toast.className = 'dashboard-toast-modern';
                toast.innerHTML = `
                    <span class="toast-icon">📊</span>
                    <div class="toast-content">
                        <div class="toast-title" id="toastTitle">Update received</div>
                        <div class="toast-message" id="toastMessage">Real-time data updated</div>
                    </div>
                    <button class="toast-close" onclick="this.closest('.dashboard-toast-modern').classList.remove('show')">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                document.body.appendChild(toast);
            }

            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;
            toast.querySelector('.toast-icon').textContent = icon;

            toast.classList.add('show');
            clearTimeout(toast._hideTimeout);
            toast._hideTimeout = setTimeout(function() {
                toast.classList.remove('show');
            }, 4000);
        }

        window.showDashboardToast = showDashboardToast;

        // ============================================
        // REAL-TIME UPDATES (Echo)
        // ============================================
        if (window.Echo) {
            window.Echo.channel('attendance')
                .listen('attendance.updated', function(e) {
                    const present = e.present || 0;
                    const total = e.total || 0;

                    const todayEl = document.getElementById('stat-today-attendance');
                    if (todayEl) {
                        todayEl.textContent = present;
                        todayEl.classList.add('updated');
                        setTimeout(function() { todayEl.classList.remove('updated'); }, 800);
                    }

                    const rateEl = document.getElementById('stat-attendance-rate');
                    if (rateEl) {
                        const rate = total > 0 ? Math.round((present / total) * 100 * 10) / 10 : 0;
                        const presentText = (typeof window.__t === 'function') ? window.__t('present', 'present') : 'present';
                        rateEl.innerHTML = '<i class="fas fa-' + (rate >= 50 ? 'arrow-up' : 'arrow-down') + '"></i> ' + rate + '% ' + presentText;
                        rateEl.className = 'stat-dash-meta ' + (rate >= 50 ? 'positive' : 'negative');
                    }

                    showDashboardToast('📊 Attendance', present + ' present today', '📊');
                });

            window.Echo.channel('finances')
                .listen('balance.updated', function(e) {
                    const balance = e.balance || 0;
                    const balanceEl = document.getElementById('stat-monthly-balance');
                    const trendEl = document.getElementById('stat-balance-trend');

                    if (balanceEl) {
                        balanceEl.textContent = '₱' + Math.abs(balance).toLocaleString();
                        balanceEl.style.color = balance >= 0 ? '#10B981' : '#EF4444';
                    }

                    if (trendEl) {
                        const surplusText = (typeof window.__t === 'function') ? window.__t('surplus', 'Surplus') : 'Surplus';
                        const deficitText = (typeof window.__t === 'function') ? window.__t('deficit', 'Deficit') : 'Deficit';
                        trendEl.innerHTML = '<i class="fas fa-' + (balance >= 0 ? 'arrow-up' : 'arrow-down') + '"></i> ' + (balance >= 0 ? surplusText : deficitText);
                        trendEl.className = 'stat-dash-meta ' + (balance >= 0 ? 'positive' : 'negative');
                    }

                    showDashboardToast('💰 Balance', '₱' + Math.abs(balance).toLocaleString(), '💰');
                });

            window.Echo.channel('choir')
                .listen('schedule.updated', function(e) {
                    const choirEl = document.getElementById('stat-choir-members');
                    if (choirEl && e.members_count !== undefined) {
                        choirEl.textContent = e.members_count;
                    }
                    showDashboardToast('🎵 Choir', e.message || 'Schedule updated', '🎵');
                });
        }
    });

    /* =============================================
       LOCALE CHANGE
    ============================================= */
    window.addEventListener('localeChanged', function(e) {
        if (typeof window.applyTranslations === 'function') {
            window.applyTranslations();
        }
        buildFinanceChart();
        console.log('[Dashboard] Locale changed to:', e.detail.locale);
    });

    /* =============================================
       THEME CHANGE
    ============================================= */
    document.addEventListener('click', function(e) {
        if (e.target.closest('#themeToggleBtn')) {
            setTimeout(buildFinanceChart, 150);
        }
    });
</script>
@endsection