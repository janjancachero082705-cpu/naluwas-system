@extends('layouts.app')

@section('header')
    <span data-i18n="sunday_attendance">{{ __("Sunday Service Attendance") }}</span>
@endsection

@section('content')

<style>
    /* ==========================================================
       SUNDAY ATTENDANCE — 2025 REDESIGN
       Flat · bordered · airy · Inter
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .sa {
        --sa-card: var(--card-bg, #ffffff);
        --sa-border: var(--border-color, #e8eaf0);
        --sa-text: var(--text-primary, #0f172a);
        --sa-muted: var(--text-muted, #7c8494);
        --sa-soft: var(--bg-tertiary, #f5f6fa);

        --sa-primary: #4f46e5;
        --sa-primary-soft: rgba(79, 70, 229, .08);
        --sa-primary-ring: rgba(79, 70, 229, .18);

        --sa-green: #059669;
        --sa-green-soft: rgba(5, 150, 105, .10);
        --sa-rose: #e11d48;
        --sa-rose-soft: rgba(225, 29, 72, .09);
        --sa-amber: #d97706;
        --sa-amber-soft: rgba(217, 119, 6, .10);
        --sa-violet: #7c3aed;
        --sa-violet-soft: rgba(124, 58, 237, .10);
        --sa-blue: #2563eb;
        --sa-blue-soft: rgba(37, 99, 235, .10);

        --sa-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --sa-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --sa-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--sa-text);
        padding-bottom: 2rem;
    }

    [data-theme="dark"] .sa {
        --sa-primary: #6366f1;
        --sa-primary-soft: rgba(99, 102, 241, .16);
        --sa-primary-ring: rgba(99, 102, 241, .28);
        --sa-green: #34d399;
        --sa-green-soft: rgba(16, 185, 129, .14);
        --sa-rose: #fb7185;
        --sa-rose-soft: rgba(244, 63, 94, .14);
        --sa-amber: #fbbf24;
        --sa-amber-soft: rgba(245, 158, 11, .14);
        --sa-violet: #a78bfa;
        --sa-violet-soft: rgba(139, 92, 246, .16);
        --sa-blue: #60a5fa;
        --sa-blue-soft: rgba(59, 130, 246, .16);
        --sa-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --sa-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .sa * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .sa-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--sa-border);
        margin-bottom: 1.5rem;
    }

    .sa-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--sa-muted);
        margin-bottom: .55rem;
    }

    .sa-eyebrow .sa-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--sa-green);
        box-shadow: 0 0 0 3px var(--sa-green-soft);
    }

    .sa-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .sa-title i { font-size: 1.2rem; color: var(--sa-primary); }

    .sa-sub {
        margin: .5rem 0 0;
        font-size: .84rem;
        color: var(--sa-muted);
        max-width: 62ch;
        line-height: 1.5;
    }

    .sa-head-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .sa-btn {
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
        transition: background .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease, border-color .18s ease, opacity .18s ease;
    }

    .sa-btn-primary {
        background: var(--sa-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .sa-btn-primary:hover:not(:disabled) {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    /* ⭐ DISABLED state for Save Now */
    .sa-btn-primary:disabled,
    .sa-btn-primary[disabled] {
        opacity: .45;
        cursor: not-allowed;
        pointer-events: none;
        box-shadow: none;
        background: var(--sa-primary);
        color: #fff;
        transform: none;
    }

    .sa-btn-ghost {
        background: var(--sa-card);
        color: var(--sa-text);
        border-color: var(--sa-border);
    }
    .sa-btn-ghost:hover {
        background: var(--sa-soft);
        color: var(--sa-text);
        transform: translateY(-1px);
    }

    .sa-pill {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1rem;
        border-radius: 11px;
        border: 1px solid var(--sa-border);
        background: var(--sa-card);
        color: var(--sa-muted);
        font-size: .74rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .sa-pill i { font-size: .68rem; color: var(--sa-primary); }

    /* ---------------- STATS ---------------- */
    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card-premium {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: 1.05rem 1.15rem;
        background: var(--sa-card);
        border: 1px solid var(--sa-border);
        border-radius: var(--sa-radius);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        position: relative;
    }

    .stat-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--sa-shadow-md);
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

    .stat-card-premium.blue  .stat-icon-wrap { background: var(--sa-primary-soft); color: var(--sa-primary); }
    .stat-card-premium.green .stat-icon-wrap { background: var(--sa-green-soft);   color: var(--sa-green); }
    .stat-card-premium.red   .stat-icon-wrap { background: var(--sa-rose-soft);    color: var(--sa-rose); }

    .stat-card-premium .stat-body { min-width: 0; }

    .stat-card-premium .stat-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--sa-muted);
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

    .stat-card-premium .stat-value.amount-positive-premium { color: var(--sa-green); }
    .stat-card-premium .stat-value.amount-negative-premium { color: var(--sa-rose); }

    .stat-card-premium .stat-change {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        margin-top: .3rem;
        padding: .12rem .5rem;
        border-radius: 20px;
        font-size: .64rem;
        font-weight: 600;
        background: var(--sa-soft);
        color: var(--sa-muted);
    }

    .stat-card-premium .stat-change.positive { color: var(--sa-green); background: var(--sa-green-soft); }
    .stat-card-premium .stat-change.negative { color: var(--sa-rose);  background: var(--sa-rose-soft); }

    /* ---------------- CARD ---------------- */
    .sa-card {
        background: var(--sa-card);
        border: 1px solid var(--sa-border);
        border-radius: var(--sa-radius);
        box-shadow: var(--sa-shadow-sm);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: box-shadow .22s ease, border-color .22s ease;
    }

    .sa-card:hover {
        box-shadow: var(--sa-shadow-md);
        border-color: transparent;
    }

    .sa-card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .9rem 1.15rem;
        border-bottom: 1px solid var(--sa-border);
        background: var(--sa-soft);
    }

    .sa-card-head-left {
        display: flex;
        align-items: center;
        gap: .65rem;
        min-width: 0;
    }

    .sa-card-head-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: .75rem;
        background: var(--sa-primary-soft);
        color: var(--sa-primary);
        flex: 0 0 auto;
    }

    .sa-card-head-title {
        font-size: .9rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        margin: 0;
    }

    .sa-card-head-sub {
        font-size: .7rem;
        color: var(--sa-muted);
        margin-top: .1rem;
    }

    /* ---------------- DATE SELECTOR ---------------- */
    .date-selector-premium {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1rem 1.15rem;
    }

    .selector-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .selector-item { min-width: 0; }

    .selector-item label {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--sa-muted);
        margin-bottom: .4rem;
    }

    .selector-item label i { font-size: .62rem; color: var(--sa-primary); }

    .selector-item input {
        width: 220px;
        padding: .6rem .9rem;
        border-radius: 11px;
        border: 1px solid var(--sa-border);
        background: var(--sa-soft);
        color: var(--sa-text);
        font-size: .82rem;
        font-family: inherit;
        cursor: pointer;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .selector-item input:focus {
        outline: none;
        background: var(--sa-card);
        border-color: var(--sa-primary);
        box-shadow: 0 0 0 3px var(--sa-primary-ring);
    }

    .week-nav {
        display: flex;
        gap: .5rem;
    }

    .btn-week-premium {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .6rem 1rem;
        border-radius: 11px;
        font-size: .76rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        border: 1px solid var(--sa-border);
        background: var(--sa-card);
        color: var(--sa-text);
        transition: background .18s ease, color .18s ease, border-color .18s ease, transform .18s ease;
    }

    .btn-week-premium:hover {
        background: var(--sa-soft);
        border-color: var(--sa-primary);
        color: var(--sa-primary);
        transform: translateY(-1px);
    }

    .btn-week-premium i { font-size: .68rem; transition: transform .18s ease; }
    .btn-week-prev:hover i { transform: translateX(-3px); }
    .btn-week-next:hover i { transform: translateX(3px); }

    .auto-save-status {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .4rem .85rem;
        border-radius: 20px;
        border: 1px solid var(--sa-border);
        background: var(--sa-card);
        font-size: .68rem;
        font-weight: 600;
        color: var(--sa-muted);
        white-space: nowrap;
    }

    .auto-save-status .fa-check-circle { color: var(--sa-green); }
    .auto-save-status .fa-exclamation-circle { color: var(--sa-rose); }

    /* ---------------- TABLE ---------------- */
    .table-container-premium {
        background: var(--sa-card);
        border: 1px solid var(--sa-border);
        border-radius: var(--sa-radius);
        box-shadow: var(--sa-shadow-sm);
        overflow: hidden;
        margin-bottom: 1.5rem;
        transition: box-shadow .22s ease, border-color .22s ease;
    }

    .table-container-premium:hover {
        box-shadow: var(--sa-shadow-md);
        border-color: transparent;
    }

    .table-header-premium {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .9rem 1.15rem;
        border-bottom: 1px solid var(--sa-border);
        background: var(--sa-soft);
    }

    .table-header-premium h6 {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0;
        font-size: .88rem;
        font-weight: 700;
        letter-spacing: -.005em;
        color: var(--sa-text);
    }

    .table-header-premium h6 i {
        display: grid;
        place-items: center;
        width: 30px; height: 30px;
        border-radius: 9px;
        font-size: .7rem;
        background: var(--sa-primary-soft);
        color: var(--sa-primary);
    }

    .badge-count-premium {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        padding: .18rem .6rem;
        margin-left: .35rem;
        border-radius: 20px;
        font-size: .64rem;
        font-weight: 700;
        background: var(--sa-green-soft);
        color: var(--sa-green);
    }

    .table-premium {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--sa-card);
    }

    .table-premium thead th {
        text-align: left;
        padding: .8rem 1.15rem;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--sa-muted) !important;
        background: var(--sa-card);
        border-bottom: 1px solid var(--sa-border);
        white-space: nowrap;
    }

    .table-premium tbody td {
        padding: .7rem 1.15rem;
        vertical-align: middle;
        color: var(--sa-text) !important;
        background: var(--sa-card);
        border-bottom: 1px solid var(--sa-border);
        font-size: .82rem;
        transition: background .16s ease;
    }

    .table-premium tbody tr:last-child td { border-bottom: none; }
    .table-premium tbody tr { transition: background .16s ease; }
    .table-premium tbody tr:hover td { background: var(--sa-soft) !important; }

    .table-premium .text-muted { color: var(--sa-muted) !important; }
    .table-premium .text-center { text-align: center; }

    .member-info-premium {
        display: flex;
        align-items: center;
        gap: .75rem;
        min-width: 0;
    }

    .member-avatar-premium {
        width: 38px; height: 38px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .02em;
        background: var(--sa-primary-soft);
        color: var(--sa-primary);
    }

    .member-name-premium {
        font-size: .85rem;
        font-weight: 600;
        color: var(--sa-text);
        line-height: 1.25;
    }

    .member-role-premium {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        margin-top: .15rem;
        font-size: .66rem;
        color: var(--sa-muted);
    }

    .member-role-premium i { color: var(--sa-violet); font-size: .58rem; }

    .status-select-premium {
        width: 130px;
        padding: .42rem .8rem;
        border-radius: 10px;
        border: 1px solid var(--sa-border);
        background: var(--sa-soft);
        color: var(--sa-text);
        font-size: .78rem;
        font-family: inherit;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%237c8494' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right .7rem center;
        background-size: 12px;
        transition: border-color .18s ease, background-color .18s ease, box-shadow .18s ease;
    }

    .status-select-premium:focus {
        outline: none;
        background-color: var(--sa-card);
        border-color: var(--sa-primary);
        box-shadow: 0 0 0 3px var(--sa-primary-ring);
    }

    .status-select-premium option { background: var(--sa-card); color: var(--sa-text); }

    .status-select-premium.changed {
        border-color: var(--sa-amber);
        background-color: var(--sa-amber-soft);
    }

    .status-select-premium.saved {
        border-color: var(--sa-green);
        background-color: var(--sa-green-soft);
    }

    .notes-input-premium {
        width: 100%;
        padding: .42rem .8rem;
        border-radius: 10px;
        border: 1px solid var(--sa-border);
        background: var(--sa-soft);
        color: var(--sa-text);
        font-size: .78rem;
        font-family: inherit;
        transition: border-color .18s ease, background-color .18s ease, box-shadow .18s ease;
    }

    .notes-input-premium::placeholder { color: var(--sa-muted); opacity: .8; }

    .notes-input-premium:focus {
        outline: none;
        background: var(--sa-card);
        border-color: var(--sa-primary);
        box-shadow: 0 0 0 3px var(--sa-primary-ring);
    }

    .notes-input-premium.changed {
        border-color: var(--sa-amber);
        background-color: var(--sa-amber-soft);
    }

    .notes-input-premium.saved {
        border-color: var(--sa-green);
        background-color: var(--sa-green-soft);
    }

    .alert-box-premium {
        display: flex;
        align-items: center;
        gap: .7rem;
        padding: .85rem 1.15rem;
        border-radius: 12px;
        margin-bottom: 1.25rem;
        font-size: .82rem;
        font-weight: 500;
        background: var(--sa-green-soft);
        color: var(--sa-green);
        border: 1px solid transparent;
    }

    .alert-box-premium.error {
        background: var(--sa-rose-soft);
        color: var(--sa-rose);
    }

    .alert-box-premium i { font-size: .95rem; flex: 0 0 auto; }

    .empty-state-premium {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--sa-muted);
    }

    .empty-state-premium i {
        font-size: 2.4rem;
        color: var(--sa-muted);
        opacity: .35;
        display: block;
        margin-bottom: .9rem;
    }

    .empty-state-premium p {
        font-size: .85rem;
        margin: 0;
        font-weight: 500;
    }

    .auto-save-toast {
        position: fixed;
        bottom: 28px;
        right: 28px;
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .8rem 1.1rem;
        background: var(--sa-card);
        border: 1px solid var(--sa-border);
        border-left: 4px solid var(--sa-green);
        border-radius: 14px;
        box-shadow: 0 20px 48px -12px rgba(15, 27, 45, .25);
        font-size: .8rem;
        font-weight: 600;
        color: var(--sa-text);
        z-index: 9999;
        transform: translateY(120%);
        opacity: 0;
        transition: all .4s cubic-bezier(.22, 1, .36, 1);
        min-width: 260px;
        max-width: 380px;
    }

    .auto-save-toast.show { transform: translateY(0); opacity: 1; }
    .auto-save-toast.success { border-left-color: var(--sa-green); }
    .auto-save-toast.success i { color: var(--sa-green); }
    .auto-save-toast.error { border-left-color: var(--sa-rose); }
    .auto-save-toast.error i { color: var(--sa-rose); }

    .custom-alert-overlay {
        --sa-card: var(--card-bg, #ffffff);
        --sa-border: var(--border-color, #e8eaf0);
        --sa-text: var(--text-primary, #0f172a);
        --sa-muted: var(--text-muted, #7c8494);
        --sa-soft: var(--bg-tertiary, #f5f6fa);
        --sa-primary: #4f46e5;
        --sa-primary-soft: rgba(79, 70, 229, .08);
        --sa-amber: #d97706;
        --sa-amber-soft: rgba(217, 119, 6, .10);
        --sa-green: #059669;
        --sa-rose: #e11d48;

        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .55);
        backdrop-filter: blur(3px);
        -webkit-backdrop-filter: blur(3px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        animation: saFadeIn .22s ease;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    [data-theme="dark"] .custom-alert-overlay {
        --sa-card: var(--card-bg, #1e1e2d);
        --sa-border: var(--border-color, #2a2a3d);
        --sa-text: var(--text-primary, #f1f5f9);
        --sa-muted: var(--text-muted, #94a3b8);
        --sa-soft: var(--bg-tertiary, #262636);
        --sa-primary: #6366f1;
        --sa-primary-soft: rgba(99, 102, 241, .16);
        --sa-amber: #fbbf24;
        --sa-amber-soft: rgba(245, 158, 11, .18);
        --sa-green: #34d399;
        --sa-rose: #fb7185;
        background: rgba(0, 0, 0, .7);
    }

    .custom-alert-overlay.active { display: flex; }

    .custom-alert {
        background: var(--sa-card);
        border-radius: 16px;
        padding: 2rem 1.75rem 1.75rem;
        max-width: 420px;
        width: 90%;
        box-shadow:
            0 24px 60px -20px rgba(15, 23, 42, .4),
            0 8px 24px -12px rgba(15, 23, 42, .25);
        animation: saSlideUp .3s cubic-bezier(.22, 1, .36, 1);
        text-align: center;
        border: 1px solid var(--sa-border);
        position: relative;
    }

    .custom-alert-icon {
        width: 68px; height: 68px;
        border-radius: 20px;
        background: var(--sa-amber-soft);
        color: var(--sa-amber);
        display: grid;
        place-items: center;
        margin: 0 auto 1rem;
        font-size: 1.7rem;
        box-shadow: 0 8px 20px -8px rgba(217, 119, 6, .35);
    }

    .custom-alert h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--sa-text);
        margin: 0 0 .4rem;
        letter-spacing: -.02em;
    }

    .custom-alert p {
        font-size: .84rem;
        color: var(--sa-muted);
        margin: 0 0 1.1rem;
        line-height: 1.55;
    }

    .custom-alert .alert-date {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .5rem 1rem;
        border-radius: 10px;
        background: var(--sa-soft);
        border: 1px solid var(--sa-border);
        font-size: .78rem;
        font-weight: 600;
        color: var(--sa-text);
        margin-bottom: 1.25rem;
        white-space: nowrap;
    }

    .custom-alert .alert-date i { color: var(--sa-amber); font-size: .72rem; }

    .btn-alert-close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .45rem;
        padding: .7rem 1.8rem;
        background: var(--sa-primary);
        color: #fff;
        border: none;
        border-radius: 11px;
        font-size: .82rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: background .18s ease, transform .18s ease, box-shadow .18s ease;
        box-shadow: 0 10px 22px -10px rgba(79, 70, 229, .9);
        min-width: 180px;
    }

    .btn-alert-close:hover {
        background: #4338ca;
        transform: translateY(-1px);
        box-shadow: 0 14px 26px -10px rgba(79, 70, 229, .95);
    }

    @keyframes saFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes saSlideUp {
        from { opacity: 0; transform: translateY(16px) scale(.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    @media (max-width: 992px) {
        .sa-head { flex-direction: column; align-items: flex-start; }
        .sa-head-actions { width: 100%; }
        .sa-head-actions .sa-btn { flex: 1; justify-content: center; }
    }

    @media (max-width: 768px) {
        .sa-title { font-size: 1.3rem; }
        .sa-sub { font-size: .78rem; }

        .stats-grid-premium { grid-template-columns: 1fr; gap: .8rem; }
        .stat-card-premium { padding: .9rem; }
        .stat-card-premium .stat-value { font-size: 1.15rem; }
        .stat-card-premium .stat-icon-wrap { width: 38px; height: 38px; font-size: .85rem; }

        .date-selector-premium { flex-direction: column; align-items: stretch; }
        .selector-group { flex-direction: column; align-items: stretch; }
        .selector-item input { width: 100%; }
        .week-nav { width: 100%; }
        .btn-week-premium { flex: 1; justify-content: center; }

        .auto-save-status { align-self: flex-start; }

        .table-header-premium { flex-direction: column; align-items: flex-start; }

        .table-premium thead th,
        .table-premium tbody td { padding: .55rem .75rem; font-size: .7rem; }

        .member-avatar-premium { width: 32px; height: 32px; border-radius: 10px; font-size: .65rem; }
        .member-name-premium { font-size: .78rem; }
        .status-select-premium { width: 100%; }

        .auto-save-toast { right: 16px; left: 16px; bottom: 16px; min-width: auto; }

        .custom-alert { padding: 1.6rem 1.25rem 1.35rem; }
        .custom-alert-icon { width: 58px; height: 58px; font-size: 1.45rem; border-radius: 16px; }
        .custom-alert h3 { font-size: 1.02rem; }
    }

    @media (max-width: 480px) {
        .sa-head-actions { flex-direction: column; }
        .sa-head-actions .sa-btn,
        .sa-head-actions .sa-pill { width: 100%; justify-content: center; }

        .btn-alert-close { width: 100%; min-width: 0; }
        .custom-alert .alert-date { white-space: normal; }
    }
</style>

<div class="sa container-fluid px-0">

    {{-- ============================================
         HEADER
    ============================================ --}}
    <header class="sa-head">
        <div>
            <div class="sa-eyebrow">
                <span class="sa-dot"></span>
                <span data-i18n="sunday_service_label">{{ __("Sunday Service") }}</span>
            </div>
            <h1 class="sa-title">
                <i class="fas fa-church"></i>
                <span data-i18n="sunday_attendance">{{ __("Sunday Service Attendance") }}</span>
            </h1>
            <p class="sa-sub" data-i18n="sunday_attendance_desc">
                {{ __("Record and manage attendance for Sunday worship services") }}
            </p>
        </div>
        <div class="sa-head-actions">
            <a href="{{ route('sunday-attendance.records', ['date' => $selectedDate]) }}" class="sa-btn sa-btn-ghost">
                <i class="fas fa-list-alt"></i>
                <span data-i18n="view_records">{{ __("View Records") }}</span>
            </a>

            {{-- ⭐ Save Now: disabled by default, enabled only when there are changes --}}
            <button type="button"
                    class="sa-btn sa-btn-primary"
                    id="saveNowBtn"
                    onclick="saveAttendance(true)"
                    disabled
                    title="{{ __('No changes yet') }}">
                <i class="fas fa-save"></i>
                <span data-i18n="save_now">{{ __("Save Now") }}</span>
            </button>

            <span class="sa-pill">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::parse($selectedDate)->format('l, F d, Y') }}
            </span>
        </div>
    </header>

    @if(session('success'))
        <div class="alert-box-premium">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-box-premium error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <section class="stats-grid-premium">
        <div class="stat-card-premium blue">
            <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            <div class="stat-body">
                <p class="stat-label"><span data-i18n="total_members">{{ __("Total Members") }}</span></p>
                <div class="stat-value">{{ number_format($totalMembers ?? 0) }}</div>
                <span class="stat-change positive">
                    <i class="fas fa-users"></i>
                    <span data-i18n="church_family">{{ __("Church family") }}</span>
                </span>
            </div>
        </div>

        <div class="stat-card-premium green">
            <div class="stat-icon-wrap"><i class="fas fa-check-circle"></i></div>
            <div class="stat-body">
                <p class="stat-label"><span data-i18n="present_label">{{ __("Present") }}</span></p>
                <div class="stat-value amount-positive-premium" id="presentCountValue">{{ number_format($presentCount ?? 0) }}</div>
                <span class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span data-i18n="attended_today">{{ __("Attended today") }}</span>
                </span>
            </div>
        </div>

        <div class="stat-card-premium red">
            <div class="stat-icon-wrap"><i class="fas fa-times-circle"></i></div>
            <div class="stat-body">
                <p class="stat-label"><span data-i18n="absent_label">{{ __("Absent") }}</span></p>
                <div class="stat-value amount-negative-premium" id="absentCountValue">{{ number_format($absentCount ?? 0) }}</div>
                <span class="stat-change negative">
                    <i class="fas fa-arrow-down"></i>
                    <span data-i18n="not_attended">{{ __("Not attended") }}</span>
                </span>
            </div>
        </div>
    </section>

    <div class="sa-card">
        <div class="sa-card-head">
            <div class="sa-card-head-left">
                <div class="sa-card-head-icon"><i class="fas fa-calendar-week"></i></div>
                <div>
                    <h2 class="sa-card-head-title" data-i18n="select_date">{{ __("Select Date") }}</h2>
                    <div class="sa-card-head-sub">
                        <i class="fas fa-info-circle" style="font-size:.62rem;"></i>
                        <span data-i18n="only_sundays">{{ __("Only Sundays are selectable") }}</span>
                    </div>
                </div>
            </div>
            <span class="auto-save-status">
                <i class="fas fa-sync-alt fa-fw" id="autoSaveSpinner"></i>
                <span id="autoSaveLabel" data-i18n="auto_save_enabled">{{ __("Auto-save enabled") }}</span>
            </span>
        </div>
        <div class="date-selector-premium">
            <div class="selector-group">
                <div class="selector-item">
                    <label>
                        <i class="fas fa-calendar-day"></i>
                        <span data-i18n="date_label">{{ __("DATE") }}</span>
                    </label>
                    <input type="date" id="datePicker" value="{{ $selectedDate }}"
                           min="{{ \Carbon\Carbon::now()->subYears(5)->format('Y-m-d') }}"
                           max="{{ \Carbon\Carbon::now()->addYears(1)->format('Y-m-d') }}">
                </div>
                <div class="week-nav">
                    <button type="button" class="btn-week-premium btn-week-prev" onclick="goToPrevWeek()">
                        <i class="fas fa-chevron-left"></i>
                        <span data-i18n="prev_week">{{ __("Prev Week") }}</span>
                    </button>
                    <button type="button" class="btn-week-premium btn-week-next" onclick="goToNextWeek()">
                        <span data-i18n="next_week">{{ __("Next Week") }}</span>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <form id="attendanceForm" action="{{ route('sunday-attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="service_date" id="serviceDate" value="{{ $selectedDate }}">

        <div class="table-container-premium">
            <div class="table-header-premium">
                <h6>
                    <i class="fas fa-users"></i>
                    <span data-i18n="member_attendance">{{ __("Member Attendance") }}</span>
                    <span class="badge-count-premium" id="badgeCount">
                        {{ $presentCount ?? 0 }} / {{ $totalMembers ?? 0 }}
                        <span data-i18n="recorded">{{ __("Recorded") }}</span>
                    </span>
                </h6>
                <span style="font-size: .68rem; color: var(--sa-muted); display: inline-flex; align-items: center; gap: .35rem;">
                    <i class="fas fa-edit"></i>
                    <span data-i18n="changes_auto_save">{{ __("Changes auto-save") }}</span>
                </span>
            </div>
            <div class="table-responsive">
                <table class="table-premium table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th data-i18n="member_info">{{ __("Member Information") }}</th>
                            <th style="width: 150px;" data-i18n="status_label">{{ __("Status") }}</th>
                            <th data-i18n="notes_label">{{ __("Notes") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members ?? [] as $index => $member)
                        @php
                            $attendance = ($attendances ?? collect())->get($member->id);
                            $status = $attendance ? $attendance->status : 'Absent';
                            $notes = $attendance ? $attendance->notes : '';
                        @endphp
                        <tr>
                            <td class="text-muted text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="member-info-premium">
                                    <div class="member-avatar-premium">
                                        {{ strtoupper(substr($member->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? '', 0, 1)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <div class="member-name-premium">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </div>
                                        @if(($member->is_choir ?? false))
                                            <div class="member-role-premium">
                                                <i class="fas fa-music"></i>
                                                <span data-i18n="choir_member">{{ __("Choir Member") }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <select name="attendances[{{ $member->id }}][status]"
                                        class="status-select-premium"
                                        data-member="{{ $member->id }}"
                                        onchange="autoSave(this)">
                                    <option value="Present" {{ $status == 'Present' ? 'selected' : '' }}>✅ {{ __("Present") }}</option>
                                    <option value="Absent"  {{ $status == 'Absent'  ? 'selected' : '' }}>❌ {{ __("Absent") }}</option>
                                </select>
                            </td>
                            <td>
                                <input type="text"
                                       name="attendances[{{ $member->id }}][notes]"
                                       class="notes-input-premium"
                                       placeholder="{{ __('Add notes...') }}"
                                       value="{{ $notes }}"
                                       data-member="{{ $member->id }}"
                                       data-i18n-placeholder="Add notes..."
                                       onchange="autoSave(this)"
                                       onkeyup="autoSaveDebounce(this)">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state-premium">
                                    <i class="fas fa-users"></i>
                                    <p data-i18n="no_members_found">{{ __("No members found. Please add members first.") }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="btn-save-hidden" id="hiddenSubmitBtn" style="display:none;"></button>
    </form>

    <div class="custom-alert-overlay" id="customAlert">
        <div class="custom-alert">
            <div class="custom-alert-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h3 data-i18n="only_sundays_allowed">{{ __("Only Sundays Allowed") }}</h3>
            <p data-i18n="only_sundays_desc">{{ __("Attendance can only be recorded on Sundays. Please select a Sunday date.") }}</p>
            <div class="alert-date">
                <i class="fas fa-calendar-day"></i>
                <span id="alertSelectedDate">
                    <span data-i18n="select_date_label">{{ __("Select a date") }}</span>
                </span>
            </div>
            <br>
            <button class="btn-alert-close" onclick="closeCustomAlert()">
                <i class="fas fa-check"></i>
                <span data-i18n="ok_understand">{{ __("OK, I Understand") }}</span>
            </button>
        </div>
    </div>

</div>

<div class="auto-save-toast" id="autoSaveToast">
    <i class="fas fa-check-circle"></i>
    <span id="autoSaveMessage" data-i18n="changes_saved">{{ __("Changes saved automatically") }}</span>
</div>

<script>
    // ⭐ Translation helper
    function t(key, fallback) {
        if (typeof window.t === 'function') return window.t(key, fallback);
        if (typeof window.__t === 'function') return window.__t(key, fallback);
        return fallback || key;
    }

    // =============================================
    // SUNDAY CHECK HELPER — force local time
    // =============================================
    function isSunday(dateStr) {
        if (!dateStr) return false;
        const d = new Date(dateStr + 'T00:00:00');
        return !isNaN(d.getTime()) && d.getDay() === 0;
    }

    // =============================================
    // SAVE NOW BUTTON — enable/disable based on changes
    // =============================================
    function setSaveNowEnabled(enabled) {
        const btn = document.getElementById('saveNowBtn');
        if (!btn) return;
        if (enabled) {
            btn.disabled = false;
            btn.removeAttribute('disabled');
            btn.title = t('click_to_save', 'Click to save now');
        } else {
            btn.disabled = true;
            btn.setAttribute('disabled', 'disabled');
            btn.title = t('no_changes_yet', 'No changes yet');
        }
    }

    // =============================================
    // CUSTOM ALERT
    // =============================================
    function showCustomAlert(date) {
        const overlay = document.getElementById('customAlert');
        const dateSpan = document.getElementById('alertSelectedDate');

        if (date) {
            const d = new Date(date + 'T00:00:00');
            const localeMap = { 'en': 'en-US', 'ceb': 'en-PH', 'tl': 'en-PH' };
            const locale = window.__currentLocale || 'en';
            dateSpan.textContent = d.toLocaleDateString(localeMap[locale] || 'en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        } else {
            dateSpan.textContent = t('invalid_date', 'Invalid date selected');
        }

        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeCustomAlert() {
        const overlay = document.getElementById('customAlert');
        overlay.classList.remove('active');
        document.body.style.overflow = '';

        const datePicker = document.getElementById('datePicker');
        const currentDate = document.getElementById('serviceDate').value;
        if (datePicker && currentDate) datePicker.value = currentDate;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('customAlert');
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeCustomAlert();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.classList.contains('active')) closeCustomAlert();
        });

        // ⭐ Ensure Save Now is disabled on initial load
        setSaveNowEnabled(false);
    });

    // =============================================
    // AUTO-SAVE
    // =============================================
    let saveTimeout = null;
    let isSaving = false;
    const toast = document.getElementById('autoSaveToast');
    const toastMessage = document.getElementById('autoSaveMessage');
    const spinner = document.getElementById('autoSaveSpinner');
    const autoSaveLabel = document.getElementById('autoSaveLabel');

    function showToast(message, type = 'success') {
        toast.className = 'auto-save-toast ' + type;
        toastMessage.textContent = message;
        toast.classList.add('show');
        clearTimeout(toast._hideTimeout);
        toast._hideTimeout = setTimeout(() => toast.classList.remove('show'), 3000);
    }

    function autoSave(element) {
        // ⭐ SUNDAY-ONLY GUARD
        const serviceDate = document.getElementById('serviceDate').value;
        if (!isSunday(serviceDate)) {
            if (element) element.classList.remove('changed');
            showCustomAlert(serviceDate);
            return;
        }

        // ⭐ Enable Save Now since a change happened
        setSaveNowEnabled(true);

        clearTimeout(saveTimeout);
        if (element) element.classList.add('changed');
        spinner.className = 'fas fa-spinner fa-spin fa-fw';
        autoSaveLabel.textContent = t('saving', 'Saving...');
        saveTimeout = setTimeout(() => saveAttendance(false), 500);
    }

    function autoSaveDebounce(element) {
        // ⭐ SUNDAY-ONLY GUARD
        const serviceDate = document.getElementById('serviceDate').value;
        if (!isSunday(serviceDate)) {
            if (element) element.classList.remove('changed');
            showCustomAlert(serviceDate);
            return;
        }

        // ⭐ Enable Save Now since a change happened
        setSaveNowEnabled(true);

        clearTimeout(saveTimeout);
        if (element) element.classList.add('changed');
        spinner.className = 'fas fa-spinner fa-spin fa-fw';
        autoSaveLabel.textContent = t('saving', 'Saving...');
        saveTimeout = setTimeout(() => saveAttendance(false), 800);
    }

    /**
     * Save attendance.
     * @param {boolean} manual  true = user clicked "Save Now", false = auto-save
     */
    function saveAttendance(manual) {
        if (isSaving) return;

        const serviceDate = document.getElementById('serviceDate').value;

        // ⭐ SUNDAY-ONLY GUARD
        if (!isSunday(serviceDate)) {
            isSaving = false;
            spinner.className = 'fas fa-exclamation-circle fa-fw';
            autoSaveLabel.textContent = t('save_blocked', 'Save blocked');
            showCustomAlert(serviceDate);
            document.querySelectorAll('.status-select-premium.changed, .notes-input-premium.changed')
                .forEach(el => el.classList.remove('changed'));
            setTimeout(() => {
                spinner.className = 'fas fa-sync-alt fa-fw';
                autoSaveLabel.textContent = t('auto_save_enabled', 'Auto-save enabled');
            }, 3000);
            return;
        }

        // ⭐ If manual click but nothing changed, do nothing
        if (manual) {
            const hasChanges = document.querySelectorAll('.status-select-premium.changed, .notes-input-premium.changed').length > 0;
            const btn = document.getElementById('saveNowBtn');
            if (!hasChanges && btn && btn.disabled) return;
        }

        isSaving = true;

        const form = document.getElementById('attendanceForm');
        const statusSelects = form.querySelectorAll('.status-select-premium');
        const notesInputs = form.querySelectorAll('.notes-input-premium');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        const attendances = {};

        statusSelects.forEach(select => {
            const memberId = select.dataset.member;
            if (!attendances[memberId]) attendances[memberId] = {};
            attendances[memberId]['status'] = select.value;
        });

        notesInputs.forEach(input => {
            const memberId = input.dataset.member;
            if (!attendances[memberId]) attendances[memberId] = {};
            attendances[memberId]['notes'] = input.value;
        });

        const submitData = new FormData();
        submitData.append('service_date', serviceDate);
        submitData.append('_token', csrfToken);

        Object.keys(attendances).forEach(memberId => {
            submitData.append(`attendances[${memberId}][status]`, attendances[memberId]['status'] || 'Absent');
            submitData.append(`attendances[${memberId}][notes]`, attendances[memberId]['notes'] || '');
        });

        fetch('{{ route("sunday-attendance.store") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: submitData,
            credentials: 'same-origin'
        })
        .then(async response => {
            const contentType = response.headers.get('content-type') || '';
            if (!response.ok) {
                const text = await response.text();
                console.error('[Auto-save] HTTP', response.status, text);
                throw new Error('Server returned ' + response.status);
            }
            if (!contentType.includes('application/json')) {
                const text = await response.text();
                console.error('[Auto-save] Non-JSON response:', text.substring(0, 300));
                throw new Error('Server did not return JSON.');
            }
            return response.json();
        })
        .then(data => {
            isSaving = false;

            if (data.success) {
                document.querySelectorAll('.status-select-premium.changed, .notes-input-premium.changed').forEach(el => {
                    el.classList.remove('changed');
                    el.classList.add('saved');
                    setTimeout(() => el.classList.remove('saved'), 1000);
                });

                spinner.className = 'fas fa-check-circle fa-fw';
                autoSaveLabel.textContent = t('auto_saved', 'Auto-saved');

                // ⭐ Disable Save Now again after successful save
                setSaveNowEnabled(false);

                if (data.stats) {
                    const presentEl = document.getElementById('presentCountValue');
                    const absentEl  = document.getElementById('absentCountValue');
                    const badgeEl   = document.getElementById('badgeCount');

                    if (presentEl) presentEl.textContent = data.stats.present;
                    if (absentEl)  absentEl.textContent  = data.stats.absent;
                    if (badgeEl)   badgeEl.innerHTML = data.stats.present + ' / ' + data.stats.total + ' ' + t('recorded', 'Recorded');
                }

                showToast(data.message || t('changes_saved', 'Changes saved automatically'), 'success');

                // ⭐ Manual save → redirect to records
                if (manual) {
                    setTimeout(() => {
                        window.location.href = "{{ route('sunday-attendance.records') }}?date=" + serviceDate;
                    }, 600);
                }
            } else {
                showToast(data.message || t('save_error', 'Error saving changes'), 'error');
                spinner.className = 'fas fa-exclamation-circle fa-fw';
                autoSaveLabel.textContent = t('save_failed', 'Auto-save failed');
            }

            setTimeout(() => {
                spinner.className = 'fas fa-sync-alt fa-fw';
                autoSaveLabel.textContent = t('auto_save_enabled', 'Auto-save enabled');
            }, 3000);
        })
        .catch(error => {
            isSaving = false;
            console.error('[Auto-save] Error:', error);
            showToast(t('network_error', 'Save failed. Check console for details.'), 'error');
            spinner.className = 'fas fa-exclamation-circle fa-fw';
            autoSaveLabel.textContent = t('save_failed', 'Auto-save failed');
            setTimeout(() => {
                spinner.className = 'fas fa-sync-alt fa-fw';
                autoSaveLabel.textContent = t('auto_save_enabled', 'Auto-save enabled');
            }, 3000);
        });
    }

    // =============================================
    // DATE PICKER — ONLY SUNDAYS
    // =============================================
    const datePicker = document.getElementById('datePicker');

    function getNearestSunday(date) {
        let d = new Date(date + 'T00:00:00');
        d.setDate(d.getDate() + (7 - d.getDay()) % 7);
        return d;
    }

    function toLocalDateStr(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return y + '-' + m + '-' + d;
    }

    if (datePicker) {
        const currentDate = datePicker.value;
        if (currentDate && !isSunday(currentDate)) {
            const nearestSunday = getNearestSunday(currentDate);
            window.location.href = "{{ route('sunday-attendance.index') }}?date=" + toLocalDateStr(nearestSunday);
        }

        datePicker.addEventListener('input', function() {
            if (!isSunday(this.value)) {
                showCustomAlert(this.value);
                this.value = document.getElementById('serviceDate').value;
            } else if (this.value) {
                window.location.href = "{{ route('sunday-attendance.index') }}?date=" + this.value;
            }
        });
    }

    function goToPrevWeek() {
        let date = new Date(document.getElementById('datePicker').value + 'T00:00:00');
        date.setDate(date.getDate() - 7);
        window.location.href = "{{ route('sunday-attendance.index') }}?date=" + toLocalDateStr(date);
    }

    function goToNextWeek() {
        let date = new Date(document.getElementById('datePicker').value + 'T00:00:00');
        date.setDate(date.getDate() + 7);
        window.location.href = "{{ route('sunday-attendance.index') }}?date=" + toLocalDateStr(date);
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const badge = document.getElementById('badgeCount');
            if (badge) {
                const text = badge.textContent;
                if (text && !text.includes('0 /')) {
                    spinner.className = 'fas fa-check-circle fa-fw';
                    autoSaveLabel.textContent = t('auto_saved', 'Auto-saved');
                    setTimeout(() => {
                        spinner.className = 'fas fa-sync-alt fa-fw';
                        autoSaveLabel.textContent = t('auto_save_enabled', 'Auto-save enabled');
                    }, 2000);
                }
            }
        }, 1000);
    });

    window.addEventListener('localeChanged', function(e) {
        if (typeof window.applyTranslations === 'function') {
            window.applyTranslations();
        }
        if (autoSaveLabel && spinner.classList.contains('fa-sync-alt')) {
            autoSaveLabel.textContent = t('auto_save_enabled', 'Auto-save enabled');
        }
        // Refresh Save Now button title
        const btn = document.getElementById('saveNowBtn');
        if (btn) {
            btn.title = btn.disabled ? t('no_changes_yet', 'No changes yet') : t('click_to_save', 'Click to save now');
        }
        console.log('[Attendance] Locale changed to:', e.detail.locate);
    });
</script>
@endsection