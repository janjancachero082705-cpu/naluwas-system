@extends('layouts.sidebar')

@section('header', 'Choir Member Details')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ═══════════════════════════════════════════════
       CHOIR MEMBER DETAILS — Aurora Theme
    ═══════════════════════════════════════════════ */
    .choir-detail-app {
        --a-primary: #6366F1;
        --a-primary-2: #8B5CF6;
        --a-primary-3: #EC4899;
        --a-primary-hover: #4F46E5;
        --a-primary-soft: rgba(99, 102, 241, 0.10);
        --a-primary-soft-2: rgba(99, 102, 241, 0.18);

        --a-green: #10B981;
        --a-green-soft: rgba(16, 185, 129, 0.12);
        --a-amber: #F59E0B;
        --a-amber-soft: rgba(245, 158, 11, 0.12);
        --a-rose: #F43F5E;
        --a-rose-soft: rgba(244, 63, 94, 0.10);
        --a-blue: #3B82F6;
        --a-blue-soft: rgba(59, 130, 246, 0.12);

        --a-bg: var(--bg-primary, #f8f9fc);
        --a-card: var(--card-bg, #ffffff);
        --a-soft: var(--bg-tertiary, #f5f6fa);
        --a-border: var(--border-color, #e8eaf0);
        --a-text: var(--text-primary, #0f172a);
        --a-muted: var(--text-muted, #7c8494);

        --a-aurora: linear-gradient(135deg, #6366F1 0%, #8B5CF6 50%, #EC4899 100%);
        --a-aurora-soft: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, rgba(139,92,246,0.06) 50%, rgba(236,72,153,0.05) 100%);

        --a-r-sm: 10px;
        --a-r-md: 14px;
        --a-r-lg: 20px;
        --a-r-xl: 28px;

        --a-sh-sm: 0 1px 2px rgba(15, 23, 42, 0.05);
        --a-sh-md: 0 12px 32px -14px rgba(15, 23, 42, 0.18);
        --a-sh-lg: 0 30px 70px -28px rgba(99, 102, 241, 0.42);

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--a-text);
    }

    [data-theme="dark"] .choir-detail-app {
        --a-primary: #818CF8;
        --a-primary-2: #A78BFA;
        --a-primary-hover: #A5B4FC;
        --a-primary-soft: rgba(129, 140, 248, 0.14);
        --a-primary-soft-2: rgba(129, 140, 248, 0.26);

        --a-green: #34D399;
        --a-amber: #FBBF24;
        --a-rose: #FB7185;
        --a-blue: #60A5FA;

        --a-bg: var(--bg-primary, #0f0f1a);
        --a-card: var(--card-bg, #1a1a2b);
        --a-soft: var(--bg-tertiary, #22223a);
        --a-border: var(--border-color, #2a2a45);
        --a-text: var(--text-primary, #f1f5f9);
        --a-muted: var(--text-muted, #94a3b8);

        --a-aurora-soft: linear-gradient(135deg, rgba(129,140,248,0.14) 0%, rgba(167,139,250,0.10) 50%, rgba(244,114,182,0.08) 100%);

        --a-sh-md: 0 12px 32px -14px rgba(0, 0, 0, 0.7);
        --a-sh-lg: 0 30px 70px -28px rgba(0, 0, 0, 0.9);
    }

    .choir-detail-app * { box-sizing: border-box; }

    /* ─── Animations ─── */
    @keyframes aFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes aFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes aRing {
        0%   { transform: scale(0.9); opacity: 0.9; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    @keyframes aAuroraShift {
        0%, 100% { background-position: 0% 50%; }
        50%      { background-position: 100% 50%; }
    }
    @keyframes aPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.15); opacity: 0.75; }
    }

    /* ═══════════════════════════════════════════════
       HERO
    ═══════════════════════════════════════════════ */
    .detail-hero {
        position: relative;
        padding: 1.25rem 1.5rem;
        border-radius: var(--a-r-xl);
        background: var(--a-aurora);
        background-size: 200% 200%;
        animation: aAuroraShift 12s ease infinite, aFadeUp 0.5s ease both;
        color: #fff;
        margin-bottom: 1.25rem;
        box-shadow: var(--a-sh-lg);
        overflow: hidden;
        isolation: isolate;
    }

    .detail-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 5%; right: 5%; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
        opacity: 0.7;
    }

    .detail-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 15% 10%, rgba(255,255,255,0.22), transparent 40%),
            radial-gradient(circle at 85% 90%, rgba(255,255,255,0.12), transparent 45%);
        pointer-events: none;
        z-index: -1;
    }

    .detail-hero-inner {
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    .detail-hero-orb {
        position: relative;
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        border: 1.5px solid rgba(255, 255, 255, 0.28);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        font-size: 1.15rem;
        color: #fff;
    }
    .detail-hero-orb::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        animation: aRing 2.8s ease-out infinite;
    }

    .detail-hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        min-width: 0;
        flex: 1;
    }

    .detail-hero-title {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.15;
    }

    .detail-hero-sub {
        margin: 0;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.88);
        font-weight: 400;
    }

    .detail-hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.35rem;
        padding: 0.22rem 0.7rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.26);
        font-size: 0.66rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        width: fit-content;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .detail-hero-tag .dot {
        position: relative;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #FEF3C7;
        box-shadow: 0 0 8px rgba(254, 243, 199, 0.9);
    }
    .detail-hero-tag .dot::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        border: 1.5px solid rgba(254, 243, 199, 0.5);
        animation: aRing 2.2s ease-out infinite;
    }

    .detail-hero-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .detail-hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.15rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        white-space: nowrap;
        letter-spacing: -0.005em;
    }

    .detail-hero-btn.primary {
        background: #fff;
        color: var(--a-primary-hover);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.14);
    }
    .detail-hero-btn.primary:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.22);
        color: var(--a-primary-hover);
        text-decoration: none;
    }

    .detail-hero-btn.ghost {
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.26);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .detail-hero-btn.ghost:hover {
        background: rgba(255, 255, 255, 0.26);
        color: #fff;
        transform: translateY(-2px);
        text-decoration: none;
    }

    /* ═══════════════════════════════════════════════
       LAYOUT GRID
    ═══════════════════════════════════════════════ */
    .detail-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 1.25rem;
        align-items: start;
    }

    @media (max-width: 992px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    /* ═══════════════════════════════════════════════
       CARDS
    ═══════════════════════════════════════════════ */
    .detail-card {
        position: relative;
        background: var(--a-card);
        border: 1px solid var(--a-border);
        border-radius: var(--a-r-lg);
        overflow: hidden;
        box-shadow: var(--a-sh-md);
        animation: aFadeUp 0.55s ease both;
    }

    .detail-card::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: inherit;
        padding: 1px;
        background: var(--a-aurora-soft);
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
                mask-composite: exclude;
        pointer-events: none;
        opacity: 0.9;
        z-index: 1;
    }

    .detail-card-head {
        padding: 1rem 1.25rem;
        background: var(--a-aurora-soft);
        border-bottom: 1px solid var(--a-border);
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .detail-card-head .head-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background: var(--a-aurora);
        color: #fff;
        font-size: 0.82rem;
        flex-shrink: 0;
        box-shadow: 0 8px 20px -10px rgba(99, 102, 241, 0.8);
    }

    .detail-card-head h4 {
        margin: 0;
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--a-text);
        letter-spacing: -0.015em;
    }

    .detail-card-body { padding: 1.25rem; }

    /* ═══════════════════════════════════════════════
       PROFILE CARD (LEFT COLUMN)
    ═══════════════════════════════════════════════ */
    .profile-card .detail-card-body {
        padding: 1.5rem 1.25rem;
        text-align: center;
    }

    .profile-avatar {
        position: relative;
        width: 96px;
        height: 96px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        margin: 0 auto 1rem;
        background: var(--a-aurora);
        color: #fff;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        box-shadow: 0 12px 32px -14px rgba(99, 102, 241, 0.8);
        animation: aPulse 4s ease-in-out infinite;
    }

    .profile-avatar .online-dot {
        position: absolute;
        bottom: 6px;
        right: 6px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--a-green);
        border: 3px solid var(--a-card);
        box-shadow: 0 0 0 2px var(--a-green-soft);
    }

    .profile-name {
        margin: 0 0 0.35rem;
        font-size: 1.15rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        color: var(--a-text);
    }

    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        background: var(--a-primary-soft);
        color: var(--a-primary);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        margin-bottom: 1.25rem;
    }

    .profile-role i { font-size: 0.62rem; }

    /* Mini stats inside profile */
    .profile-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.65rem;
        margin-bottom: 1.25rem;
    }

    .profile-stat {
        padding: 0.75rem 0.6rem;
        border-radius: 12px;
        background: var(--a-soft);
        border: 1px solid var(--a-border);
        text-align: center;
        transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .profile-stat:hover {
        transform: translateY(-2px);
        border-color: transparent;
        box-shadow: 0 8px 20px -12px rgba(99, 102, 241, 0.5);
    }

    .profile-stat .stat-cap {
        display: block;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--a-muted);
        margin-bottom: 0.3rem;
    }

    .profile-stat .stat-main {
        display: block;
        font-size: 0.9rem;
        font-weight: 800;
        color: var(--a-text);
        letter-spacing: -0.015em;
    }

    /* Attendance ring / big number */
    .attendance-ring-wrap {
        padding: 0.9rem 1rem;
        border-radius: 14px;
        background: var(--a-aurora-soft);
        border: 1px solid var(--a-border);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-align: left;
    }

    .attendance-number {
        flex-shrink: 0;
        width: 62px;
        height: 62px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: var(--a-aurora);
        color: #fff;
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        box-shadow: 0 8px 22px -10px rgba(99, 102, 241, 0.9);
    }

    .attendance-info {
        flex: 1;
        min-width: 0;
    }

    .attendance-info .cap {
        display: block;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--a-muted);
        margin-bottom: 0.15rem;
    }

    .attendance-info .val {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--a-text);
        line-height: 1.4;
    }

    .attendance-info .val strong { color: var(--a-primary); }

    /* Profile actions */
    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .profile-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.65rem 1.2rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        letter-spacing: -0.005em;
    }

    .profile-btn.primary {
        background: var(--a-aurora);
        background-size: 150% 150%;
        color: #fff;
        box-shadow: 0 10px 24px -10px rgba(99, 102, 241, 0.9);
    }
    .profile-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 36px -10px rgba(99, 102, 241, 0.9);
        color: #fff;
        text-decoration: none;
    }

    .profile-btn.ghost {
        background: var(--a-soft);
        color: var(--a-text);
        border-color: var(--a-border);
    }
    .profile-btn.ghost:hover {
        background: var(--a-card);
        color: var(--a-primary);
        border-color: var(--a-primary);
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ═══════════════════════════════════════════════
       STATUS BADGES
    ═══════════════════════════════════════════════ */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.22rem 0.7rem;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        border: 1px solid transparent;
    }

    .status-pill i { font-size: 0.55rem; }

    .status-pill.active {
        background: var(--a-green-soft);
        color: var(--a-green);
    }

    .status-pill.inactive {
        background: var(--a-rose-soft);
        color: var(--a-rose);
    }

    .status-pill.on-leave {
        background: var(--a-amber-soft);
        color: var(--a-amber);
    }

    /* ═══════════════════════════════════════════════
       PERSONAL INFO (RIGHT COLUMN)
    ═══════════════════════════════════════════════ */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.85rem;
    }

    @media (max-width: 640px) {
        .info-grid { grid-template-columns: 1fr; }
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.8rem 1rem;
        border-radius: 12px;
        background: var(--a-soft);
        border: 1px solid var(--a-border);
        transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .info-item:hover {
        transform: translateY(-2px);
        border-color: transparent;
        box-shadow: 0 8px 20px -12px rgba(99, 102, 241, 0.5);
    }

    .info-item.full-width { grid-column: 1 / -1; }

    .info-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background: var(--a-primary-soft);
        color: var(--a-primary);
        font-size: 0.78rem;
        flex-shrink: 0;
    }

    .info-item-copy {
        min-width: 0;
        flex: 1;
    }

    .info-item-cap {
        display: block;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--a-muted);
        margin-bottom: 0.15rem;
    }

    .info-item-val {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--a-text);
        line-height: 1.4;
        word-break: break-word;
    }

    .info-item-val.muted {
        color: var(--a-muted);
        font-weight: 500;
    }

    /* ═══════════════════════════════════════════════
       ATTENDANCE TABLE
    ═══════════════════════════════════════════════ */
    .attendance-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .attendance-table {
        width: 100%;
        min-width: 640px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .attendance-table thead th {
        text-align: left;
        padding: 0.75rem 1.15rem;
        font-size: 0.64rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--a-muted);
        background: var(--a-soft);
        border-bottom: 1px solid var(--a-border);
        white-space: nowrap;
    }

    .attendance-table thead th i {
        margin-right: 5px;
        color: var(--a-primary);
        opacity: 0.75;
        font-size: 0.6rem;
    }

    .attendance-table tbody td {
        padding: 0.75rem 1.15rem;
        font-size: 0.8rem;
        color: var(--a-text);
        border-bottom: 1px solid var(--a-border);
        vertical-align: middle;
        transition: background 0.18s ease;
    }

    .attendance-table tbody tr:last-child td { border-bottom: none; }
    .attendance-table tbody tr:hover td { background: var(--a-soft); }

    .attendance-table .date-cell {
        font-weight: 600;
        white-space: nowrap;
    }

    .attendance-table .time-cell {
        color: var(--a-muted);
        font-size: 0.78rem;
        white-space: nowrap;
    }

    .attendance-table .notes-cell {
        color: var(--a-muted);
        font-size: 0.78rem;
        max-width: 220px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Attendance status badges */
    .att-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.01em;
        white-space: nowrap;
    }

    .att-badge i { font-size: 0.55rem; }

    .att-badge.present {
        background: var(--a-green-soft);
        color: var(--a-green);
    }

    .att-badge.absent {
        background: var(--a-rose-soft);
        color: var(--a-rose);
    }

    .att-badge.late {
        background: var(--a-amber-soft);
        color: var(--a-amber);
    }

    .att-badge.excused {
        background: var(--a-blue-soft);
        color: var(--a-blue);
    }

    /* ═══════════════════════════════════════════════
       EMPTY STATE
    ═══════════════════════════════════════════════ */
    .attendance-empty {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--a-muted);
    }

    .attendance-empty .empty-orb {
        width: 68px;
        height: 68px;
        margin: 0 auto 1rem;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: var(--a-primary-soft);
        color: var(--a-primary);
        font-size: 1.5rem;
        border: 1px solid var(--a-border);
    }

    .attendance-empty h5 {
        margin: 0 0 0.35rem;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--a-text);
    }

    .attendance-empty p {
        margin: 0;
        font-size: 0.82rem;
        max-width: 340px;
        margin-inline: auto;
        line-height: 1.6;
    }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════ */
    @media (max-width: 640px) {
        .detail-hero { padding: 1rem 1.15rem; border-radius: 22px; }
        .detail-hero-orb { width: 42px; height: 42px; font-size: 0.95rem; }
        .detail-hero-title { font-size: 1.05rem; }
        .detail-hero-actions { width: 100%; }
        .detail-hero-btn { flex: 1; justify-content: center; }

        .detail-card { border-radius: var(--a-r-md); }
        .detail-card-body { padding: 1rem; }
        .profile-card .detail-card-body { padding: 1.15rem 1rem; }

        .profile-avatar { width: 80px; height: 80px; font-size: 1.7rem; }

        .attendance-table thead th,
        .attendance-table tbody td { padding: 0.55rem 0.75rem; font-size: 0.72rem; }
    }
</style>

<div class="choir-detail-app container-fluid px-0">
    @php
        $initials = strtoupper(substr($member->first_name ?? 'M', 0, 1)) . strtoupper(substr($member->last_name ?? '', 0, 1));
        $status = $member->choir_status ?? 'Active';
        $statusClass = match (strtolower($status)) {
            'active' => 'active',
            'inactive' => 'inactive',
            'on leave', 'on-leave' => 'on-leave',
            default => 'active',
        };
        $statusIcon = match ($statusClass) {
            'active' => 'fa-circle',
            'inactive' => 'fa-circle',
            'on-leave' => 'fa-clock',
            default => 'fa-circle',
        };
    @endphp

    {{-- HERO --}}
    <div class="detail-hero">
        <div class="detail-hero-inner">
            <div class="detail-hero-orb">
                <i class="fas fa-microphone-alt"></i>
            </div>
            <div class="detail-hero-copy">
                <h1 class="detail-hero-title">{{ $member->first_name }} {{ $member->last_name }}</h1>
                <p class="detail-hero-sub" data-i18n="choir_member_details_desc">Choir member profile and practice attendance</p>
                <span class="detail-hero-tag">
                    <span class="dot"></span>
                    <span data-i18n="choir_ministry_title">Choir Ministry</span>
                </span>
            </div>
            <div class="detail-hero-actions">
                <a href="{{ route('choir-members.edit', $member->id) }}" class="detail-hero-btn primary">
                    <i class="fas fa-pen-to-square"></i>
                    <span data-i18n="edit_details">Edit Details</span>
                </a>
                @if($member->email)
                    <a href="mailto:{{ $member->email }}" class="detail-hero-btn ghost">
                        <i class="fas fa-envelope"></i>
                        <span data-i18n="contact">Contact</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- GRID --}}
    <div class="detail-grid">

        {{-- ═══════════════════════════════
             LEFT — PROFILE CARD
        ═══════════════════════════════ --}}
        <div class="detail-card profile-card" style="animation-delay: 0.05s;">
            <div class="detail-card-body">

                {{-- Avatar --}}
                <div class="profile-avatar">
                    {{ $initials }}
                    <span class="online-dot"></span>
                </div>

                {{-- Name --}}
                <h2 class="profile-name">{{ $member->first_name }} {{ $member->last_name }}</h2>

                {{-- Role chip --}}
                <span class="profile-role">
                    <i class="fas fa-music"></i>
                    {{ $member->choir_role ?? 'Choir Member' }}
                </span>

                {{-- Mini stats --}}
                <div class="profile-stats">
                    <div class="profile-stat">
                        <span class="stat-cap" data-i18n="voice_part_label">Voice Part</span>
                        <span class="stat-main">{{ $member->voice_part ?? '—' }}</span>
                    </div>
                    <div class="profile-stat">
                        <span class="stat-cap" data-i18n="status_label">Status</span>
                        <span class="stat-main">
                            <span class="status-pill {{ $statusClass }}">
                                <i class="fas {{ $statusIcon }}"></i>
                                {{ $status }}
                            </span>
                        </span>
                    </div>
                </div>

                {{-- Attendance --}}
                <div class="attendance-ring-wrap">
                    <div class="attendance-number">{{ round($attendanceRate) }}%</div>
                    <div class="attendance-info">
                        <span class="cap" data-i18n="attendance_rate">Attendance Rate</span>
                        <span class="val">
                            <strong>{{ $presentPractices }}</strong> / {{ $totalPractices }}
                            <span data-i18n="practices_attended">practices attended</span>
                        </span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="profile-actions">
                    <a href="{{ route('choir-members.edit', $member->id) }}" class="profile-btn primary">
                        <i class="fas fa-pen-to-square"></i>
                        <span data-i18n="edit_details">Edit Details</span>
                    </a>
                    @if($member->email)
                        <a href="mailto:{{ $member->email }}" class="profile-btn ghost">
                            <i class="fas fa-envelope"></i>
                            <span data-i18n="contact_member">Contact Member</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════
             RIGHT — INFO + ATTENDANCE
        ═══════════════════════════════ --}}
        <div style="display: flex; flex-direction: column; gap: 1.25rem; min-width: 0;">

            {{-- PERSONAL INFO --}}
            <div class="detail-card" style="animation-delay: 0.1s;">
                <div class="detail-card-head">
                    <div class="head-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4 data-i18n="personal_information">Personal Information</h4>
                </div>
                <div class="detail-card-body">
                    <div class="info-grid">

                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-envelope"></i></div>
                            <div class="info-item-copy">
                                <span class="info-item-cap" data-i18n="email_label">Email</span>
                                <span class="info-item-val {{ !$member->email ? 'muted' : '' }}">
                                    {{ $member->email ?? '—' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-phone"></i></div>
                            <div class="info-item-copy">
                                <span class="info-item-cap" data-i18n="phone_label">Phone</span>
                                <span class="info-item-val {{ !$member->phone ? 'muted' : '' }}">
                                    {{ $member->phone ?? '—' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-calendar-plus"></i></div>
                            <div class="info-item-copy">
                                <span class="info-item-cap" data-i18n="joined_choir">Joined Choir</span>
                                <span class="info-item-val {{ !$member->choir_join_date ? 'muted' : '' }}">
                                    {{ $member->choir_join_date ? \Carbon\Carbon::parse($member->choir_join_date)->format('M d, Y') : '—' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-item-icon"><i class="fas fa-birthday-cake"></i></div>
                            <div class="info-item-copy">
                                <span class="info-item-cap" data-i18n="birthday_label">Birthday</span>
                                <span class="info-item-val {{ !$member->birthdate ? 'muted' : '' }}">
                                    {{ $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('M d, Y') : '—' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item full-width">
                            <div class="info-item-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info-item-copy">
                                <span class="info-item-cap" data-i18n="address_label">Address</span>
                                <span class="info-item-val {{ !$member->address ? 'muted' : '' }}">
                                    {{ $member->address ?? '—' }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ATTENDANCE --}}
            <div class="detail-card" style="animation-delay: 0.15s;">
                <div class="detail-card-head">
                    <div class="head-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h4 data-i18n="practice_attendance_history">Practice Attendance History</h4>
                </div>

                @if($practiceAttendances && $practiceAttendances->count() > 0)
                    <div class="attendance-scroll">
                        <table class="attendance-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-calendar"></i><span data-i18n="practice_date">Practice Date</span></th>
                                    <th><i class="fas fa-clock"></i><span data-i18n="time">Time</span></th>
                                    <th><i class="fas fa-map-marker-alt"></i><span data-i18n="location">Location</span></th>
                                    <th><i class="fas fa-check"></i><span data-i18n="status">Status</span></th>
                                    <th><i class="fas fa-sticky-note"></i><span data-i18n="notes">Notes</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($practiceAttendances as $attendance)
                                    @php
                                        $statusRaw = strtolower($attendance->status ?? '');
                                        $badgeClass = match ($statusRaw) {
                                            'present' => 'present',
                                            'absent'  => 'absent',
                                            'late'    => 'late',
                                            'excused' => 'excused',
                                            default   => 'present',
                                        };
                                        $badgeIcon = match ($badgeClass) {
                                            'present' => 'fa-check',
                                            'absent'  => 'fa-xmark',
                                            'late'    => 'fa-clock',
                                            'excused' => 'fa-note-sticky',
                                            default   => 'fa-check',
                                        };
                                    @endphp
                                    <tr>
                                        <td class="date-cell">
                                            {{ \Carbon\Carbon::parse($attendance->choirPractice->practice_date)->format('M d, Y') }}
                                        </td>
                                        <td class="time-cell">
                                            {{ $attendance->choirPractice->start_time }} – {{ $attendance->choirPractice->end_time }}
                                        </td>
                                        <td>
                                            {{ $attendance->choirPractice->location ?? '—' }}
                                        </td>
                                        <td>
                                            <span class="att-badge {{ $badgeClass }}">
                                                <i class="fas {{ $badgeIcon }}"></i>
                                                {{ $attendance->status }}
                                            </span>
                                        </td>
                                        <td class="notes-cell" title="{{ $attendance->notes ?? '' }}">
                                            {{ $attendance->notes ?? '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="detail-card-body">
                        <div class="attendance-empty">
                            <div class="empty-orb">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <h5 data-i18n="no_attendance_yet">No attendance records yet</h5>
                            <p data-i18n="no_attendance_yet_desc">Attendance will appear here once this member attends their first choir practice.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection