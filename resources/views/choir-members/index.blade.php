@extends('layouts.app')

@section('header')
    <span data-i18n="choir_ministry_title">Choir Ministry</span>
@endsection

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ═══════════════════════════════════════════════
       CHOIR MINISTRY — matches app dark palette
    ═══════════════════════════════════════════════ */
    .choir-app {
        font-family: var(--font-body, 'Inter', sans-serif);
        color: var(--text-primary);
    }

    .choir-app * { box-sizing: border-box; }

    @keyframes aFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ═══════════════════════════════════════════════
       HERO — deep navy with brass accent
    ═══════════════════════════════════════════════ */
    .choir-hero {
        position: relative;
        padding: 1.25rem 1.5rem;
        border-radius: 16px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        margin-bottom: 1.25rem;
        overflow: hidden;
        animation: aFadeUp 0.5s ease both;
    }
    .choir-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #D3A24C 0%, #B9862F 60%, transparent 100%);
    }
    .choir-hero-inner {
        display: flex; align-items: center; justify-content: space-between;
        gap: 1.15rem; flex-wrap: wrap;
    }
    .choir-hero-left { display: flex; align-items: center; gap: 1rem; min-width: 0; flex: 1; }

    .choir-hero-orb {
        width: 48px; height: 48px; flex-shrink: 0;
        display: grid; place-items: center;
        border-radius: 13px;
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        color: #0B1A2E;
        font-size: 1.15rem;
        box-shadow: 0 6px 20px -4px rgba(200, 155, 60, 0.45);
    }

    .choir-hero-copy { display: flex; flex-direction: column; gap: 0.2rem; min-width: 0; }

    .choir-hero-title {
        margin: 0;
        font-family: var(--font-display, 'Fraunces', serif);
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.02em;
        line-height: 1.15;
    }
    .choir-hero-sub {
        margin: 0;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    .choir-hero-tag {
        display: inline-flex; align-items: center; gap: 0.45rem;
        margin-top: 0.35rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        background: rgba(200, 155, 60, 0.12);
        border: 1px solid rgba(200, 155, 60, 0.25);
        font-size: 0.68rem; font-weight: 700;
        color: #D3A24C;
        letter-spacing: 0.02em;
        width: fit-content;
    }
    .choir-hero-tag .dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #D3A24C;
        box-shadow: 0 0 8px rgba(211, 162, 76, 0.7);
    }

    .choir-hero-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        font-size: 0.78rem; font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid rgba(200, 155, 60, 0.35);
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        color: #0B1A2E;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .choir-hero-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px -6px rgba(200, 155, 60, 0.55);
        color: #0B1A2E;
        text-decoration: none;
    }

    /* ═══════════════════════════════════════════════
       STATS
    ═══════════════════════════════════════════════ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .stat-card {
        display: flex; align-items: center; gap: 1rem;
        padding: 1rem 1.15rem;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        transition: transform 0.2s ease, border-color 0.2s ease;
        animation: aFadeUp 0.45s ease both;
    }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.10s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: rgba(200, 155, 60, 0.35);
    }

    .stat-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: grid; place-items: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }
    /* Brass / navy / emerald accents — matching app palette */
    .stat-icon.purple { background: rgba(200, 155, 60, 0.14); color: #D3A24C; }
    .stat-icon.green  { background: rgba(74, 122, 181, 0.14); color: #4A7AB5; }
    .stat-icon.blue   { background: rgba(42, 161, 152, 0.14); color: #2AA198; }

    .stat-info { flex: 1; min-width: 0; }
    .stat-info h4 {
        font-size: 0.66rem;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: var(--text-muted);
        margin: 0 0 0.25rem 0;
        font-weight: 700;
    }
    .stat-value {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.15;
        letter-spacing: -0.02em;
    }
    .stat-trend {
        font-size: 0.68rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }

    /* ═══════════════════════════════════════════════
       FILTER BAR
    ═══════════════════════════════════════════════ */
    .voice-filter-bar {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 0.85rem 1.15rem;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 0.85rem;
        animation: aFadeUp 0.5s ease 0.2s both;
    }
    .filter-left {
        display: flex; align-items: center; gap: 0.75rem;
        flex-wrap: wrap; min-width: 0; flex: 1;
    }
    .filter-label {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-size: 0.7rem; font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.09em;
        white-space: nowrap;
    }
    .filter-label i { color: #D3A24C; font-size: 0.72rem; }

    .voice-filters { display: flex; gap: 0.4rem; flex-wrap: wrap; }
    .voice-filter-btn {
        display: inline-flex; align-items: center; gap: 0.35rem;
        padding: 0.4rem 0.9rem;
        border-radius: 50px;
        font-size: 0.72rem; font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        white-space: nowrap;
    }
    .voice-filter-btn i { font-size: 0.6rem; opacity: 0.7; }
    .voice-filter-btn:hover {
        background: rgba(200, 155, 60, 0.10);
        border-color: rgba(200, 155, 60, 0.35);
        color: #D3A24C;
    }
    .voice-filter-btn.active {
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        border-color: transparent;
        color: #0B1A2E;
        font-weight: 700;
    }
    .voice-filter-btn.active i { opacity: 1; }

    .members-count {
        display: inline-flex; align-items: center; gap: 0.45rem;
        padding: 0.35rem 0.85rem;
        border-radius: 50px;
        background: rgba(200, 155, 60, 0.10);
        color: #D3A24C;
        font-size: 0.72rem; font-weight: 700;
        border: 1px solid rgba(200, 155, 60, 0.20);
        white-space: nowrap;
    }
    .members-count i { font-size: 0.7rem; }

    /* ═══════════════════════════════════════════════
       TABLE
    ═══════════════════════════════════════════════ */
    .table-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        animation: aFadeUp 0.55s ease 0.25s both;
    }
    .card-header-custom {
        display: flex; align-items: center; justify-content: space-between;
        gap: 0.75rem;
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        flex-wrap: wrap;
    }
    .card-header-custom h6 {
        display: flex; align-items: center; gap: 0.5rem;
        color: var(--text-primary);
        margin: 0;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: -0.01em;
    }
    .card-header-custom h6 i {
        display: grid; place-items: center;
        width: 26px; height: 26px;
        border-radius: 8px;
        background: rgba(200, 155, 60, 0.12);
        color: #D3A24C;
        font-size: 0.7rem;
    }
    .card-header-custom .header-count {
        font-weight: 500;
        font-size: 0.7rem;
        color: var(--text-muted);
        background: var(--bg-secondary);
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
    }

    .table {
        margin-bottom: 0;
        width: 100%;
        background: var(--card-bg);
        border-collapse: separate;
        border-spacing: 0;
    }
    .table thead th {
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-muted) !important;
        font-size: 0.64rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        padding: 0.75rem 1rem;
        white-space: nowrap;
        text-align: left;
    }
    .table thead th i {
        margin-right: 5px;
        font-size: 0.62rem;
        color: #D3A24C;
        opacity: 0.75;
    }
    .table tbody td {
        padding: 0.7rem 1rem;
        vertical-align: middle;
        color: var(--text-primary) !important;
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-light);
        font-size: 0.8rem;
        transition: background 0.15s ease;
    }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover td { background: var(--bg-tertiary) !important; }

    /* Member cell */
    .member-name-cell { display: flex; align-items: center; gap: 0.75rem; min-width: 0; }
    .member-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        display: grid; place-items: center;
        font-size: 0.75rem;
        font-weight: 700;
        color: #0B1A2E;
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        flex-shrink: 0;
    }
    .member-avatar i { font-size: 0.75rem; }
    .member-name-text {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.83rem;
        margin-bottom: 1px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .member-sub-text {
        font-size: 0.68rem;
        color: var(--text-muted);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    /* Voice badge */
    .voice-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 0.25rem 0.7rem;
        border-radius: 50px;
        font-size: 0.68rem;
        font-weight: 700;
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        white-space: nowrap;
    }
    .voice-badge i { font-size: 0.55rem; opacity: 0.85; }

    .voice-badge.soprano { background: rgba(200, 155, 60, 0.12); color: #D3A24C; border-color: transparent; }
    .voice-badge.alto    { background: rgba(74, 122, 181, 0.14); color: #4A7AB5; border-color: transparent; }
    .voice-badge.tenor   { background: rgba(42, 161, 152, 0.14); color: #2AA198; border-color: transparent; }
    .voice-badge.bass    { background: rgba(124, 92, 184, 0.14); color: #A78BFA; border-color: transparent; }

    .row-number {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 26px; height: 26px;
        padding: 0 7px;
        border-radius: 8px;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        font-size: 0.7rem;
        font-weight: 700;
        border: 1px solid var(--border-color);
    }

    /* Action buttons */
    .action-buttons { display: flex; gap: 5px; flex-wrap: wrap; justify-content: center; }
    .btn-icon-action {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: inline-flex; align-items: center; justify-content: center;
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.72rem;
    }
    .btn-icon-action:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }
    .btn-icon-action.edit:hover {
        background: rgba(200, 155, 60, 0.12);
        color: #D3A24C;
        border-color: rgba(200, 155, 60, 0.35);
    }
    .btn-icon-action.delete:hover {
        background: rgba(208, 85, 78, 0.12);
        color: #F1A29D;
        border-color: rgba(208, 85, 78, 0.35);
    }

    /* ═══════════════════════════════════════════════
       EMPTY STATE
    ═══════════════════════════════════════════════ */
    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--text-muted);
    }
    .empty-state .empty-orb {
        width: 70px; height: 70px;
        margin: 0 auto 1rem;
        display: grid; place-items: center;
        border-radius: 50%;
        background: rgba(200, 155, 60, 0.10);
        color: #D3A24C;
        font-size: 1.6rem;
        border: 1px solid rgba(200, 155, 60, 0.20);
    }
    .empty-state h5 {
        color: var(--text-primary);
        margin: 0 0 0.35rem;
        font-weight: 700;
        font-size: 1rem;
    }
    .empty-state p {
        font-size: 0.82rem;
        margin: 0 auto 1rem;
        max-width: 320px;
        line-height: 1.6;
    }
    .btn-add-in-table {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.6rem 1.3rem;
        border-radius: 10px;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: inherit;
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        color: #0B1A2E;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-add-in-table:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px -6px rgba(200, 155, 60, 0.5);
        color: #0B1A2E;
        text-decoration: none;
    }

    /* ═══════════════════════════════════════════════
       PAGINATION
    ═══════════════════════════════════════════════ */
    .pagination-container {
        padding: 0.85rem 1.25rem;
        border-top: 1px solid var(--border-color);
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 0.75rem;
        background: var(--card-bg);
    }
    .pagination-info { font-size: 0.72rem; color: var(--text-muted); }
    .pagination-info strong { color: var(--text-primary); font-weight: 700; }
    .page-link {
        border-radius: 9px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-secondary);
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.35rem 0.7rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .page-link:hover {
        background: rgba(200, 155, 60, 0.10);
        border-color: rgba(200, 155, 60, 0.30);
        color: #D3A24C;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        border-color: transparent;
        color: #0B1A2E;
    }

    /* ═══════════════════════════════════════════════
       MODAL — matches app dark palette
    ═══════════════════════════════════════════════ */
    @keyframes modalFade {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes modalPop {
        0%   { opacity: 0; transform: scale(0.94) translateY(12px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes modalSpin {
        to { transform: rotate(360deg); }
    }

    .choir-modal-overlay {
        position: fixed; inset: 0;
        z-index: 99999;
        display: none;
        align-items: center; justify-content: center;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.65);
        animation: modalFade 0.2s ease;
        font-family: var(--font-body, 'Inter', sans-serif);
    }
    .choir-modal-overlay.is-open { display: flex; }

    .choir-modal {
        width: 100%; max-width: 420px;
        background: var(--card-bg, #131C2C);
        border: 1px solid var(--border-color, #22304A);
        border-radius: 16px;
        padding: 1.75rem 1.5rem 1.5rem;
        text-align: center;
        box-shadow: 0 24px 56px -16px rgba(0, 0, 0, 0.7);
        animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .choir-modal-icon {
        width: 60px; height: 60px;
        margin: 0 auto 1rem;
        display: grid; place-items: center;
        border-radius: 50%;
        background: rgba(208, 85, 78, 0.14);
        color: #F1A29D;
        font-size: 1.4rem;
    }
    .choir-modal-icon.is-loading {
        background: rgba(200, 155, 60, 0.14);
        color: #D3A24C;
    }

    .choir-modal-title {
        margin: 0 0 0.5rem;
        font-family: var(--font-display, 'Fraunces', serif);
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary, #E8EEF8);
        letter-spacing: -0.01em;
    }
    .choir-modal-text {
        margin: 0 0 1rem;
        font-size: 0.83rem;
        line-height: 1.55;
        color: var(--text-secondary, #9BABC4);
    }
    .choir-modal-name {
        display: inline-block;
        padding: 0.45rem 1rem;
        border-radius: 8px;
        background: rgba(200, 155, 60, 0.10);
        color: #D3A24C;
        font-size: 0.85rem;
        font-weight: 700;
        border: 1px solid rgba(200, 155, 60, 0.20);
        margin-bottom: 1.25rem;
    }

    .choir-modal-actions {
        display: flex;
        gap: 0.6rem;
    }
    .choir-modal-btn {
        flex: 1;
        padding: 0.7rem 1rem;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
    .choir-modal-btn:active { transform: scale(0.98); }
    .choir-modal-btn:disabled { opacity: 0.5; cursor: not-allowed; }

    .choir-modal-btn.cancel {
        background: var(--bg-tertiary, #14233A);
        color: var(--text-primary, #E8EEF8);
        border-color: var(--border-color, #22304A);
    }
    .choir-modal-btn.cancel:hover:not(:disabled) {
        background: var(--bg-secondary, #0F1B2E);
        border-color: #4A7AB5;
        color: #A5B4FC;
    }

    .choir-modal-btn.confirm {
        background: linear-gradient(135deg, #D0554E 0%, #B03B34 100%);
        color: #FFFFFF;
    }
    .choir-modal-btn.confirm:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px -8px rgba(208, 85, 78, 0.6);
    }

    .choir-spinner {
        width: 14px; height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.35);
        border-top-color: #FFFFFF;
        border-radius: 50%;
        animation: modalSpin 0.7s linear infinite;
    }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
        .stat-value { font-size: 1.15rem; }
        .stat-icon { width: 40px; height: 40px; font-size: 0.95rem; }

        .choir-hero { padding: 1rem 1.15rem; }
        .choir-hero-orb { width: 42px; height: 42px; font-size: 1rem; }
        .choir-hero-title { font-size: 1.05rem; }
        .choir-hero-btn { width: 100%; justify-content: center; }

        .voice-filter-bar { flex-direction: column; align-items: stretch; }
        .voice-filters { overflow-x: auto; padding-bottom: 0.25rem; }

        .table thead th, .table tbody td { padding: 0.55rem 0.75rem; font-size: 0.72rem; }
        .member-avatar { width: 32px; height: 32px; font-size: 0.68rem; }
        .member-name-text { font-size: 0.78rem; }
        .member-sub-text { font-size: 0.64rem; }

        .pagination-container { flex-direction: column; text-align: center; }
        .btn-icon-action { width: 28px; height: 28px; font-size: 0.68rem; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="choir-app container-fluid px-0">

    {{-- HERO --}}
    <div class="choir-hero">
        <div class="choir-hero-inner">
            <div class="choir-hero-left">
                <div class="choir-hero-orb">
                    <i class="fas fa-music"></i>
                </div>
                <div class="choir-hero-copy">
                    <h1 class="choir-hero-title">
                        <span data-i18n="choir_ministry_title">Choir Ministry</span>
                    </h1>
                    <p class="choir-hero-sub" data-i18n="choir_ministry_desc">Manage and organize your church choir members</p>
                    <span class="choir-hero-tag">
                        <span class="dot"></span>
                        <span data-i18n="lifting_voices">Lifting voices in praise</span>
                    </span>
                </div>
            </div>
            <a href="{{ route('choir-members.create') }}" class="choir-hero-btn">
                <i class="fas fa-user-plus"></i>
                <span data-i18n="add_choir_member">Add Choir Member</span>
            </a>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4 data-i18n="total_members_label">Total Members</h4>
                <div class="stat-value">{{ $totalChoirMembers ?? $choir_members->total() ?? $choir_members->count() ?? 0 }}</div>
                <div class="stat-trend" data-i18n="lifting_voices">Lifting voices in praise</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <h4 data-i18n="active_members_label">Active Members</h4>
                <div class="stat-value">{{ $activeCount ?? $choir_members->count() ?? 0 }}</div>
                <div class="stat-trend" data-i18n="regular_attendees">Regular attendees</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-church"></i></div>
            <div class="stat-info">
                <h4 data-i18n="voice_parts_label">Voice Parts</h4>
                <div class="stat-value">{{ $voicePartsCount ?? 4 }}</div>
                <div class="stat-trend" data-i18n="satb_arrangement">SATB arrangement</div>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="voice-filter-bar">
        <div class="filter-left">
            <div class="filter-label">
                <i class="fas fa-filter"></i>
                <span data-i18n="filter_by_voice">Filter by Voice:</span>
            </div>
            <div class="voice-filters" id="voiceFilters">
                <button type="button" class="voice-filter-btn active" data-voice="all">
                    <i class="fas fa-layer-group"></i>
                    <span data-i18n="all_voices">All Voices</span>
                </button>
                <button type="button" class="voice-filter-btn" data-voice="soprano">
                    <i class="fas fa-microphone-alt"></i>
                    <span data-i18n="soprano">Soprano</span>
                </button>
                <button type="button" class="voice-filter-btn" data-voice="alto">
                    <i class="fas fa-microphone-alt"></i>
                    <span data-i18n="alto">Alto</span>
                </button>
                <button type="button" class="voice-filter-btn" data-voice="tenor">
                    <i class="fas fa-microphone-alt"></i>
                    <span data-i18n="tenor">Tenor</span>
                </button>
                <button type="button" class="voice-filter-btn" data-voice="bass">
                    <i class="fas fa-microphone-alt"></i>
                    <span data-i18n="bass">Bass</span>
                </button>
            </div>
        </div>
        <div class="members-count">
            <i class="fas fa-users"></i>
            <span id="visibleCount">0</span>
            <span data-i18n="members_count_label">members</span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-container">
        <div class="card-header-custom">
            <h6>
                <i class="fas fa-users"></i>
                <span data-i18n="choir_members_list">Choir Members List</span>
            </h6>
            <span class="header-count">
                {{ $choir_members->count() ?? 0 }} <span data-i18n="members">members</span>
            </span>
        </div>
        <div class="table-responsive">
            <table class="table" id="choirMembersTable">
                <thead>
                    <tr>
                        <th style="width: 60px;"><i class="fas fa-hashtag"></i> <span data-i18n="no_label">No.</span></th>
                        <th><i class="fas fa-user"></i> <span data-i18n="member_label">Member</span></th>
                        <th><i class="fas fa-microphone-alt"></i> <span data-i18n="voice_part_label">Voice Part</span></th>
                        <th><i class="fas fa-birthday-cake"></i> <span data-i18n="birthday_label">Birthday</span></th>
                        <th><i class="fas fa-calendar-alt"></i> <span data-i18n="age_label">Age</span></th>
                        <th style="width: 110px; text-align: center;"><i class="fas fa-cog"></i> <span data-i18n="actions_label">Actions</span></th>
                    </tr>
                </thead>
                <tbody id="choirMembersBody">
                    @forelse($choir_members as $index => $member)
                    @php
                        $age = $member->birthday ? \Carbon\Carbon::parse($member->birthday)->age : null;
                        $voicePart = strtolower($member->voice_part ?? '');
                        $voiceClass = $voicePart ?: 'default';
                    @endphp
                    <tr data-voice="{{ $voicePart }}">
                        <td>
                            <span class="row-number">{{ $choir_members->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div class="member-name-cell">
                                <div class="member-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div style="min-width: 0;">
                                    <div class="member-name-text">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                                    @if($member->email)
                                        <div class="member-sub-text">{{ $member->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="voice-badge {{ $voiceClass }}">
                                <i class="fas fa-microphone-alt"></i>
                                {{ ucfirst($member->voice_part ?? 'Choir Member') }}
                            </span>
                        </td>
                        <td style="font-size: 0.78rem;">
                            @if($member->birthday)
                                {{ \Carbon\Carbon::parse($member->birthday)->format('M d, Y') }}
                            @else
                                <span style="color: var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td style="font-size: 0.78rem;">
                            @if($age)
                                <strong>{{ $age }}</strong> <span style="color: var(--text-muted);" data-i18n="years">years</span>
                            @else
                                <span style="color: var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('choir-members.edit', $member->id) }}" class="btn-icon-action edit" title="{{ __('Edit Member') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="btn-icon-action delete"
                                        title="{{ __('Remove Member') }}"
                                        data-member-id="{{ $member->id }}"
                                        data-member-name="{{ $member->first_name }} {{ $member->last_name }}"
                                        onclick="openRemoveModal(this)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form id="remove-choir-{{ $member->id }}"
                                      action="{{ route('choir-members.destroy', $member->id) }}"
                                      method="POST"
                                      style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-orb">
                                    <i class="fas fa-music"></i>
                                </div>
                                <h5 data-i18n="no_choir_members">No Choir Members Yet</h5>
                                <p data-i18n="no_choir_members_desc">Start building your choir ministry by adding members</p>
                                <a href="{{ route('choir-members.create') }}" class="btn-add-in-table">
                                    <i class="fas fa-user-plus"></i>
                                    <span data-i18n="add_first_choir_member">Add First Choir Member</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($choir_members) && $choir_members->count() > 0 && method_exists($choir_members, 'hasPages') && $choir_members->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                <span data-i18n="showing">Showing</span> <strong>{{ $choir_members->firstItem() }}</strong> <span data-i18n="to">to</span> <strong>{{ $choir_members->lastItem() }}</strong> <span data-i18n="of">of</span> <strong>{{ $choir_members->total() }}</strong> <span data-i18n="members">members</span>
            </div>
            {{ $choir_members->links() }}
        </div>
        @elseif(isset($choir_members) && $choir_members->count() > 0)
        <div class="pagination-container">
            <div class="pagination-info">
                <span data-i18n="showing">Showing</span> <strong>{{ $choir_members->count() }}</strong> <span data-i18n="choir_members_count">choir members</span>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- MODAL --}}
<div class="choir-modal-overlay" id="removeMemberModal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="choir-modal">
        <div class="choir-modal-icon" id="removeModalIcon">
            <i class="fas fa-trash-alt" id="removeModalIconInner"></i>
        </div>
        <h2 class="choir-modal-title" id="removeModalTitle">Remove from Choir?</h2>
        <p class="choir-modal-text" id="removeModalText">
            This member will be removed from the choir list. Their member record will stay intact.
        </p>
        <div class="choir-modal-name" id="removeModalName">—</div>
        <div class="choir-modal-actions">
            <button type="button" class="choir-modal-btn cancel" id="removeModalCancel">
                <i class="fas fa-times"></i>
                Cancel
            </button>
            <button type="button" class="choir-modal-btn confirm" id="removeModalConfirm">
                <span id="removeModalConfirmContent">
                    <i class="fas fa-trash-alt"></i>
                    Yes, Remove
                </span>
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    let pendingMemberId = null;
    let isSubmitting = false;

    const modal = document.getElementById('removeMemberModal');
    const nameEl = document.getElementById('removeModalName');
    const cancelBtn = document.getElementById('removeModalCancel');
    const confirmBtn = document.getElementById('removeModalConfirm');
    const confirmContent = document.getElementById('removeModalConfirmContent');
    const modalIcon = document.getElementById('removeModalIcon');
    const modalIconInner = document.getElementById('removeModalIconInner');
    const modalTitle = document.getElementById('removeModalTitle');
    const modalText = document.getElementById('removeModalText');

    /* OPEN */
    window.openRemoveModal = function (el) {
        const id = el.getAttribute('data-member-id');
        const name = el.getAttribute('data-member-name');
        if (!id) return;

        pendingMemberId = id;
        isSubmitting = false;
        nameEl.textContent = name || '—';

        // Reset to default state
        modalIcon.classList.remove('is-loading');
        modalIconInner.className = 'fas fa-trash-alt';
        modalIconInner.style.animation = '';
        modalTitle.textContent = 'Remove from Choir?';
        modalText.textContent = 'This member will be removed from the choir list. Their member record will stay intact.';
        confirmBtn.disabled = false;
        cancelBtn.disabled = false;
        confirmContent.innerHTML = '<i class="fas fa-trash-alt"></i> Yes, Remove';

        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    };

    /* CLOSE */
    function closeModal() {
        if (isSubmitting) return;
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
        pendingMemberId = null;
    }

    /* CANCEL */
    cancelBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        closeModal();
    });

    /* CONFIRM */
    confirmBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!pendingMemberId || isSubmitting) return;

        const form = document.getElementById('remove-choir-' + pendingMemberId);
        if (!form) return;

        isSubmitting = true;

        // Show loading state
        modalIcon.classList.add('is-loading');
        modalIconInner.className = 'fas fa-spinner';
        modalIconInner.style.animation = 'modalSpin 0.7s linear infinite';
        modalTitle.textContent = 'Removing...';
        modalText.textContent = 'Please wait while we update the choir list.';

        confirmBtn.disabled = true;
        cancelBtn.disabled = true;
        confirmContent.innerHTML = '<span class="choir-spinner"></span> Removing...';

        setTimeout(function () { form.submit(); }, 150);
    });

    /* BACKDROP */
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    /* ESCAPE */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }
    });

    /* VOICE FILTER */
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('#choirMembersBody tr[data-voice]');
        const countSpan = document.getElementById('visibleCount');

        function updateCount() {
            const visible = document.querySelectorAll('#choirMembersBody tr[data-voice]:not([style*="display: none"])').length;
            if (countSpan) countSpan.textContent = visible;
        }

        function applyFilter() {
            const active = document.querySelector('.voice-filter-btn.active');
            const voice = active ? active.getAttribute('data-voice') : 'all';
            rows.forEach(function (row) {
                const v = row.getAttribute('data-voice') || '';
                row.style.display = (voice === 'all' || v === voice) ? '' : 'none';
            });
            updateCount();
        }

        document.querySelectorAll('.voice-filter-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.voice-filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                applyFilter();
            });
        });

        updateCount();
    });
})();
</script>
@endsection