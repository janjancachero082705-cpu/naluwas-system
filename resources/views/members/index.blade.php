@extends('layouts.app')

@section('header')
    <span data-i18n="member_management">{{ __("Member Management") }}</span>
@endsection

@section('content')

<style>
    /* ==========================================================
       MEMBER DIRECTORY — 2025 REDESIGN
       Flat · bordered · airy · Inter
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .mm {
        --mm-card: var(--card-bg, #ffffff);
        --mm-border: var(--border-color, #e8eaf0);
        --mm-text: var(--text-primary, #0f172a);
        --mm-muted: var(--text-muted, #7c8494);
        --mm-soft: var(--bg-tertiary, #f5f6fa);

        --mm-primary: #4f46e5;
        --mm-primary-soft: rgba(79, 70, 229, .08);
        --mm-primary-ring: rgba(79, 70, 229, .18);

        --mm-green: #059669;
        --mm-green-soft: rgba(5, 150, 105, .10);
        --mm-rose: #e11d48;
        --mm-rose-soft: rgba(225, 29, 72, .09);
        --mm-amber: #d97706;
        --mm-amber-soft: rgba(217, 119, 6, .10);
        --mm-violet: #7c3aed;
        --mm-violet-soft: rgba(124, 58, 237, .10);

        --mm-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --mm-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --mm-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--mm-text);
        padding-bottom: 2rem;
    }

    [data-theme="dark"] .mm {
        --mm-primary: #6366f1;
        --mm-primary-soft: rgba(99, 102, 241, .16);
        --mm-primary-ring: rgba(99, 102, 241, .28);
        --mm-green: #34d399;
        --mm-green-soft: rgba(16, 185, 129, .14);
        --mm-rose: #fb7185;
        --mm-rose-soft: rgba(244, 63, 94, .14);
        --mm-amber: #fbbf24;
        --mm-amber-soft: rgba(245, 158, 11, .14);
        --mm-violet: #a78bfa;
        --mm-violet-soft: rgba(139, 92, 246, .16);
        --mm-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --mm-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .mm * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .mm-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--mm-border);
        margin-bottom: 1.5rem;
    }

    .mm-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--mm-muted);
        margin-bottom: .55rem;
    }

    .mm-eyebrow .mm-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--mm-green);
        box-shadow: 0 0 0 3px var(--mm-green-soft);
    }

    .mm-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .mm-title i { font-size: 1.2rem; color: var(--mm-primary); }

    .mm-sub {
        margin: .5rem 0 0;
        font-size: .84rem;
        color: var(--mm-muted);
        max-width: 62ch;
        line-height: 1.5;
    }

    .mm-head-actions {
        display: flex;
        gap: .6rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .mm-btn {
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
        transition: background .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .mm-btn-primary {
        background: var(--mm-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .mm-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .mm-btn-ghost {
        background: var(--mm-card);
        color: var(--mm-text);
        border-color: var(--mm-border);
    }
    .mm-btn-ghost:hover {
        background: var(--mm-soft);
        color: var(--mm-text);
        transform: translateY(-1px);
    }

    /* ---------------- STATS ---------------- */
    .mm-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .mm-stat {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: 1.05rem 1.15rem;
        background: var(--mm-card);
        border: 1px solid var(--mm-border);
        border-radius: var(--mm-radius);
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    }

    .mm-stat:hover {
        transform: translateY(-3px);
        box-shadow: var(--mm-shadow-md);
        border-color: transparent;
    }

    .mm-stat-icon {
        width: 44px; height: 44px;
        border-radius: 13px;
        display: grid;
        place-items: center;
        font-size: 1rem;
        flex: 0 0 auto;
    }

    .mm-stat-icon.green  { background: var(--mm-green-soft);  color: var(--mm-green); }
    .mm-stat-icon.violet { background: var(--mm-violet-soft); color: var(--mm-violet); }
    .mm-stat-icon.amber  { background: var(--mm-amber-soft);  color: var(--mm-amber); }
    .mm-stat-icon.rose   { background: var(--mm-rose-soft);   color: var(--mm-rose); }

    .mm-stat-body { min-width: 0; }

    .mm-stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.1;
    }

    .mm-stat-label {
        font-size: .72rem;
        font-weight: 600;
        color: var(--mm-text);
        margin-top: .18rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mm-stat-cap {
        font-size: .65rem;
        color: var(--mm-muted);
        margin-top: .1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ---------------- PANEL ---------------- */
    .mm-panel {
        background: var(--mm-card);
        border: 1px solid var(--mm-border);
        border-radius: var(--mm-radius);
        overflow: hidden;
    }

    .mm-panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .9rem 1.15rem;
        border-bottom: 1px solid var(--mm-border);
    }

    /* segmented tabs */
    .mm-seg {
        display: inline-flex;
        gap: 2px;
        padding: 4px;
        background: var(--mm-soft);
        border-radius: 12px;
    }

    .mm-seg-item {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .45rem .95rem;
        border-radius: 9px;
        font-size: .77rem;
        font-weight: 600;
        color: var(--mm-muted);
        text-decoration: none;
        transition: background .18s ease, color .18s ease, box-shadow .18s ease;
    }

    .mm-seg-item:hover { color: var(--mm-text); text-decoration: none; }

    .mm-seg-item.active {
        background: var(--mm-card);
        color: var(--mm-text);
        box-shadow: var(--mm-shadow-sm);
    }

    .mm-seg-count {
        font-size: .64rem;
        font-weight: 700;
        padding: .08rem .42rem;
        border-radius: 20px;
        background: rgba(125, 130, 150, .16);
        color: inherit;
    }

    .mm-seg-item.active .mm-seg-count {
        background: var(--mm-primary-soft);
        color: var(--mm-primary);
    }

    /* toolbar */
    .mm-tools {
        display: flex;
        align-items: center;
        gap: .55rem;
        flex-wrap: wrap;
    }

    .mm-search,
    .mm-select { position: relative; display: flex; align-items: center; }

    .mm-search > i,
    .mm-select > .mm-select-icon {
        position: absolute;
        left: .8rem;
        font-size: .72rem;
        color: var(--mm-muted);
        pointer-events: none;
        z-index: 2;
    }

    .mm-search input {
        width: 230px;
        padding: .5rem .9rem .5rem 2.15rem;
        border-radius: 10px;
        border: 1px solid var(--mm-border);
        background: var(--mm-soft);
        color: var(--mm-text);
        font-size: .78rem;
        font-family: inherit;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .mm-search input::placeholder { color: var(--mm-muted); }

    .mm-search input:focus {
        outline: none;
        background: var(--mm-card);
        border-color: var(--mm-primary);
        box-shadow: 0 0 0 3px var(--mm-primary-ring);
    }

    .mm-select select {
        appearance: none;
        -webkit-appearance: none;
        padding: .5rem 2.2rem .5rem 2.05rem;
        border-radius: 10px;
        border: 1px solid var(--mm-border);
        background: var(--mm-soft);
        color: var(--mm-text);
        font-size: .78rem;
        font-family: inherit;
        cursor: pointer;
        max-width: 230px;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .mm-select select:focus {
        outline: none;
        background: var(--mm-card);
        border-color: var(--mm-primary);
        box-shadow: 0 0 0 3px var(--mm-primary-ring);
    }

    .mm-select select option { background: var(--mm-card); color: var(--mm-text); }

    .mm-select .mm-select-caret {
        position: absolute;
        right: .8rem;
        font-size: .6rem;
        color: var(--mm-muted);
        pointer-events: none;
        z-index: 2;
    }

    /* ---------------- TABLE ---------------- */
    .mm-section { display: none; }
    .mm-section.is-active { display: block; }

    .mm-table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    .mm-table {
        width: 100%;
        min-width: 780px;
        border-collapse: separate;
        border-spacing: 0;
    }

    .mm-table thead th {
        text-align: left;
        padding: .8rem 1.15rem;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--mm-muted);
        background: var(--mm-card);
        border-bottom: 1px solid var(--mm-border);
        white-space: nowrap;
    }

    .mm-table tbody td {
        padding: .8rem 1.15rem;
        font-size: .82rem;
        color: var(--mm-text);
        border-bottom: 1px solid var(--mm-border);
        vertical-align: middle;
    }

    .mm-table tbody tr:last-child td { border-bottom: none; }

    .mm-row {
        cursor: pointer;
        transition: background .16s ease;
    }

    .mm-row:hover { background: var(--mm-soft); }

    .mm-row td:first-child { position: relative; }

    .mm-row:hover td:first-child::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: var(--mm-primary);
        border-radius: 0 3px 3px 0;
    }

    .mm-idx {
        font-size: .72rem;
        font-weight: 600;
        color: var(--mm-muted);
        font-variant-numeric: tabular-nums;
    }

    .mm-muted { color: var(--mm-muted); }

    /* person cell */
    .mm-person {
        display: flex;
        align-items: center;
        gap: .75rem;
        min-width: 0;
    }

    .mm-avatar {
        width: 38px; height: 38px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .02em;
        background: var(--mm-primary-soft);
        color: var(--mm-primary);
    }

    .mm-avatar.muted {
        background: var(--mm-rose-soft);
        color: var(--mm-rose);
    }

    .mm-person-name {
        display: flex;
        align-items: center;
        gap: .35rem;
        font-size: .85rem;
        font-weight: 600;
        line-height: 1.25;
    }

    .mm-person-meta {
        display: flex;
        align-items: center;
        gap: .3rem;
        font-size: .68rem;
        color: var(--mm-muted);
        margin-top: .15rem;
    }

    /* pills */
    .mm-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .24rem .6rem;
        border-radius: 8px;
        font-size: .67rem;
        font-weight: 600;
        line-height: 1.4;
        white-space: nowrap;
        background: var(--mm-soft);
        color: var(--mm-muted);
        border: 1px solid var(--mm-border);
    }

    .mm-pill i { font-size: .58rem; opacity: .85; }

    .mm-pill.male {
        background: rgba(59, 130, 246, .10);
        color: #2563eb;
        border-color: rgba(59, 130, 246, .18);
    }

    .mm-pill.female {
        background: rgba(236, 72, 153, .10);
        color: #db2777;
        border-color: rgba(236, 72, 153, .18);
    }

    .mm-pill.choir {
        background: var(--mm-amber-soft);
        color: var(--mm-amber);
        border-color: transparent;
    }

    .mm-pill.deceased {
        background: var(--mm-rose-soft);
        color: var(--mm-rose);
        border-color: transparent;
    }

    [data-theme="dark"] .mm-pill.male {
        background: rgba(59, 130, 246, .16);
        color: #60a5fa;
        border-color: rgba(59, 130, 246, .24);
    }

    [data-theme="dark"] .mm-pill.female {
        background: rgba(236, 72, 153, .16);
        color: #f472b6;
        border-color: rgba(236, 72, 153, .24);
    }

    .mm-pill-group {
        display: flex;
        flex-wrap: wrap;
        gap: .3rem;
    }

    /* actions */
    .mm-actions {
        display: flex;
        gap: .3rem;
        flex-wrap: wrap;
    }

    .mm-icon-btn {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        border: 1px solid transparent;
        background: transparent;
        color: var(--mm-muted);
        font-size: .74rem;
        cursor: pointer;
        text-decoration: none;
        transition: background .16s ease, color .16s ease, transform .16s ease;
    }

    .mm-icon-btn:hover {
        background: var(--mm-soft);
        color: var(--mm-text);
        transform: translateY(-1px);
    }

    .mm-icon-btn.view:hover    { background: var(--mm-primary-soft); color: var(--mm-primary); }
    .mm-icon-btn.restore:hover { background: var(--mm-green-soft);   color: var(--mm-green); }
    .mm-icon-btn.danger:hover  { background: var(--mm-rose-soft);    color: var(--mm-rose); }

    /* ---------------- EMPTY ---------------- */
    .mm-empty {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .mm-empty i {
        font-size: 2.4rem;
        color: var(--mm-muted);
        opacity: .35;
        margin-bottom: .9rem;
        display: block;
    }

    .mm-empty h5 {
        margin: 0 0 .35rem;
        font-size: 1rem;
        font-weight: 700;
        color: var(--mm-text);
        letter-spacing: -.01em;
    }

    .mm-empty p {
        margin: 0 0 1.1rem;
        font-size: .82rem;
        color: var(--mm-muted);
    }

    /* ---------------- FOOTER ---------------- */
    .mm-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        padding: .85rem 1.15rem;
        border-top: 1px solid var(--mm-border);
    }

    .mm-foot-info {
        font-size: .72rem;
        color: var(--mm-muted);
    }

    .mm-foot-info strong {
        color: var(--mm-text);
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }

    .mm-foot .pagination {
        margin: 0;
        gap: .25rem;
        flex-wrap: wrap;
    }

    .mm-foot .page-link {
        border: 1px solid var(--mm-border);
        background: var(--mm-card);
        color: var(--mm-muted);
        font-size: .72rem;
        font-weight: 600;
        padding: .35rem .7rem;
        border-radius: 9px;
        transition: background .16s ease, color .16s ease, border-color .16s ease;
    }

    .mm-foot .page-link:hover {
        background: var(--mm-soft);
        color: var(--mm-text);
        border-color: var(--mm-border);
    }

    .mm-foot .page-item.active .page-link {
        background: var(--mm-primary);
        border-color: var(--mm-primary);
        color: #fff;
    }

    .mm-foot .page-item.disabled .page-link {
        opacity: .45;
        background: var(--mm-card);
    }

    /* ---------------- SPINNER (Swal) ---------------- */
    .loading-spinner {
        width: 38px;
        height: 38px;
        margin: 0 auto;
        border: 4px solid var(--mm-border, #e5e7eb);
        border-top-color: #4f46e5;
        border-radius: 50%;
        animation: mmSpin .8s linear infinite;
    }

    @keyframes mmSpin { to { transform: rotate(360deg); } }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 1100px) {
        .mm-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 900px) {
        .mm-col-optional { display: none; }
        .mm-search input { width: 180px; }
    }

    @media (max-width: 768px) {
        .mm-head { flex-direction: column; align-items: flex-start; }
        .mm-head-actions { width: 100%; }
        .mm-head-actions .mm-btn { flex: 1; justify-content: center; }

        .mm-title { font-size: 1.3rem; }
        .mm-sub { font-size: .78rem; }

        .mm-panel-head { flex-direction: column; align-items: stretch; }

        .mm-seg { width: 100%; }
        .mm-seg-item { flex: 1; justify-content: center; }

        .mm-tools { width: 100%; }
        .mm-search { flex: 1 1 100%; }
        .mm-search input { width: 100%; }
        .mm-select { flex: 1 1 100%; }
        .mm-select select { width: 100%; max-width: none; }

        .mm-foot { flex-direction: column; text-align: center; }
    }

    @media (max-width: 480px) {
        .mm-stats { grid-template-columns: 1fr; }
        .mm-stat { padding: .9rem 1rem; }
    }
</style>

<div class="mm container-fluid px-0">

    {{-- ============================================
         HEADER
    ============================================ --}}
    <header class="mm-head">
        <div>
            <div class="mm-eyebrow">
                <span class="mm-dot"></span>
                <span data-i18n="member_directory">{{ __("Member Directory") }}</span>
            </div>
            <h1 class="mm-title">
                <i class="fas fa-users"></i>
                <span data-i18n="member_management">{{ __("Member Management") }}</span>
            </h1>
            <p class="mm-sub" data-i18n="member_management_desc">
                {{ __("Manage your church members, roles, and choir assignments") }}
            </p>
        </div>

        <div class="mm-head-actions">
            <a href="{{ route('members.create') }}" class="mm-btn mm-btn-primary">
                <i class="fas fa-user-plus"></i>
                <span data-i18n="add_member">{{ __("Add Member") }}</span>
            </a>

            @if($isDeceasedFilter)
                <a href="{{ route('members.index') }}" class="mm-btn mm-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    <span data-i18n="back_to_active">{{ __("Back to Active") }}</span>
                </a>
            @else
                <a href="{{ route('members.index', ['filter' => 'deceased']) }}" class="mm-btn mm-btn-ghost">
                    <i class="fas fa-cross"></i>
                    <span data-i18n="view_deceased">{{ __("View Deceased") }}</span>
                </a>
            @endif
        </div>
    </header>

    {{-- ============================================
         STATS
    ============================================ --}}
    <section class="mm-stats">
        <article class="mm-stat">
            <div class="mm-stat-icon green"><i class="fas fa-users"></i></div>
            <div class="mm-stat-body">
                <div class="mm-stat-value">{{ number_format($totalMembers ?? 0) }}</div>
                <div class="mm-stat-label" data-i18n="active_members_label">{{ __("Active Members") }}</div>
                <div class="mm-stat-cap" data-i18n="active_members">{{ __("Active members") }}</div>
            </div>
        </article>

        <article class="mm-stat">
            <div class="mm-stat-icon violet"><i class="fas fa-music"></i></div>
            <div class="mm-stat-body">
                <div class="mm-stat-value">{{ number_format($choirCount ?? 0) }}</div>
                <div class="mm-stat-label" data-i18n="choir_members_label">{{ __("Choir Members") }}</div>
                <div class="mm-stat-cap" data-i18n="music_ministry">{{ __("Music ministry") }}</div>
            </div>
        </article>

        <article class="mm-stat">
            <div class="mm-stat-icon amber"><i class="fas fa-birthday-cake"></i></div>
            <div class="mm-stat-body">
                <div class="mm-stat-value">{{ number_format($birthdaysThisMonth ?? 0) }}</div>
                <div class="mm-stat-label" data-i18n="birthdays_this_month">{{ __("Birthdays This Month") }}</div>
                <div class="mm-stat-cap" data-i18n="celebrating_soon">{{ __("Celebrating soon") }}</div>
            </div>
        </article>

        <article class="mm-stat">
            <div class="mm-stat-icon rose"><i class="fas fa-cross"></i></div>
            <div class="mm-stat-body">
                <div class="mm-stat-value">{{ number_format($deceasedCount ?? 0) }}</div>
                <div class="mm-stat-label" data-i18n="deceased_label">{{ __("Deceased") }}</div>
                <div class="mm-stat-cap" data-i18n="at_rest">{{ __("At rest") }}</div>
            </div>
        </article>
    </section>

    {{-- ============================================
         PANEL
    ============================================ --}}
    <div class="mm-panel">

        {{-- Toolbar --}}
        <div class="mm-panel-head">
            <nav class="mm-seg">
                <a href="{{ route('members.index') }}"
                   class="mm-seg-item {{ !$isDeceasedFilter ? 'active' : '' }}">
                    <i class="fas fa-user-friends"></i>
                    <span data-i18n="active">{{ __("Active") }}</span>
                    <span class="mm-seg-count">{{ number_format($totalMembers ?? 0) }}</span>
                </a>
                <a href="{{ route('members.index', ['filter' => 'deceased']) }}"
                   class="mm-seg-item {{ $isDeceasedFilter ? 'active' : '' }}">
                    <i class="fas fa-cross"></i>
                    <span data-i18n="deceased">{{ __("Deceased") }}</span>
                    <span class="mm-seg-count">{{ number_format($deceasedCount ?? 0) }}</span>
                </a>
            </nav>

            <div class="mm-tools">
                <label class="mm-search">
                    <i class="fas fa-search"></i>
                    <input type="search" id="mmSearch" autocomplete="off"
                           placeholder="{{ __('Search members...') }}"
                           aria-label="{{ __('Search members') }}">
                </label>

                <div class="mm-select">
                    <i class="fas fa-filter mm-select-icon"></i>
                    <select id="roleFilter" onchange="window.location.href=this.value"
                            aria-label="{{ __('Filter by Ministry') }}">
                        <option value="{{ route('members.index', ['role' => 'all']) }}"
                            {{ ($currentFilter ?? 'all') == 'all' ? 'selected' : '' }}>
                            📋 {{ __("All Members") }}
                        </option>
                        @php
                            $uniqueRoles = collect($allRoles ?? [])->unique('name')->values()->all();
                        @endphp
                        @foreach($uniqueRoles as $role)
                            <option value="{{ route('members.index', ['role' => $role->slug ?? $role]) }}"
                                {{ ($currentFilter ?? '') == ($role->slug ?? $role) ? 'selected' : '' }}>
                                {{ $role->name ?? ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down mm-select-caret"></i>
                </div>
            </div>
        </div>

        {{-- ============================================
             ACTIVE MEMBERS
        ============================================ --}}
        <section id="activeMembersTable"
                 class="mm-section {{ !$isDeceasedFilter ? 'is-active' : '' }}">
            <div class="mm-table-scroll">
                <table class="mm-table">
                    <thead>
                        <tr>
                            <th style="width:56px;">#</th>
                            <th data-i18n="member">{{ __("Member") }}</th>
                            <th style="width:96px;" data-i18n="gender">{{ __("Gender") }}</th>
                            <th data-i18n="roles">{{ __("Roles") }}</th>
                            <th style="width:110px;" class="mm-col-optional" data-i18n="birthday">{{ __("Birthday") }}</th>
                            <th style="width:80px;" class="mm-col-optional" data-i18n="age">{{ __("Age") }}</th>
                            <th style="width:150px;" data-i18n="actions">{{ __("Actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $index => $member)
                            @php
                                $age = $member->birthday ? \Carbon\Carbon::parse($member->birthday)->age : null;
                                $birthdayDate = $member->birthday ? \Carbon\Carbon::parse($member->birthday) : null;
                                $isBirthdayThisWeek = false;
                                if ($birthdayDate) {
                                    $today = \Carbon\Carbon::today();
                                    $birthdayThisYear = \Carbon\Carbon::create($today->year, $birthdayDate->month, $birthdayDate->day);
                                    $daysUntil = $today->diffInDays($birthdayThisYear, false);
                                    $isBirthdayThisWeek = ($daysUntil >= 0 && $daysUntil <= 7);
                                }

                                $memberRoles = $member->roles ?? [];
                                $uniqueRoles = collect($memberRoles)->unique('name')->values()->all();

                                $genderValue = $member->gender ?? null;
                                if ($genderValue === 'male') {
                                    $genderIcon = 'fa-mars'; $genderLabel = 'Male'; $genderClass = 'male';
                                } elseif ($genderValue === 'female') {
                                    $genderIcon = 'fa-venus'; $genderLabel = 'Female'; $genderClass = 'female';
                                } else {
                                    $genderIcon = 'fa-circle'; $genderLabel = '—'; $genderClass = 'unspecified';
                                }
                            @endphp
                            <tr class="member-row mm-row"
                                data-row
                                data-member-id="{{ $member->id }}"
                                data-member-name="{{ addslashes($member->first_name . ' ' . $member->last_name) }}"
                                data-member-birthday="{{ $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('F d, Y') : '' }}"
                                data-member-age="{{ $age ?? '' }}"
                                data-member-address="{{ $member->address ?? '' }}"
                                data-member-phone="{{ $member->phone ?? '' }}"
                                data-member-roles="{{ json_encode($uniqueRoles) }}"
                                data-member-ischoir="{{ $member->is_choir ? 'true' : 'false' }}"
                                data-member-isdeceased="{{ $member->is_deceased ? 'true' : 'false' }}">

                                <td class="mm-idx">{{ $members->firstItem() + $index }}</td>

                                <td>
                                    <div class="mm-person">
                                        <div class="mm-avatar">
                                            {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
                                        </div>
                                        <div style="min-width:0;">
                                            <div class="mm-person-name">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                                @if($isBirthdayThisWeek)
                                                    <span title="{{ __('Birthday this week') }}">🎂</span>
                                                @endif
                                            </div>
                                            @if($member->phone)
                                                <div class="mm-person-meta">
                                                    <i class="fas fa-phone"></i> {{ $member->phone }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="mm-pill {{ $genderClass }}">
                                        <i class="fas {{ $genderIcon }}"></i> {{ $genderLabel }}
                                    </span>
                                </td>

                                <td>
                                    <div class="mm-pill-group">
                                        @forelse($uniqueRoles as $role)
                                            <span class="mm-pill">
                                                <i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}
                                            </span>
                                        @empty
                                            <span class="mm-pill">
                                                <i class="fas fa-user"></i>
                                                <span data-i18n="regular">{{ __("Regular") }}</span>
                                            </span>
                                        @endforelse
                                        @if($member->is_choir)
                                            <span class="mm-pill choir">
                                                <i class="fas fa-music"></i>
                                                <span data-i18n="choir">{{ __("Choir") }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="mm-col-optional">
                                    @if($member->birthday)
                                        {{ \Carbon\Carbon::parse($member->birthday)->format('M d') }}
                                    @else
                                        <span class="mm-muted">—</span>
                                    @endif
                                </td>

                                <td class="mm-col-optional">
                                    @if($age)
                                        {{ $age }}
                                    @else
                                        <span class="mm-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="mm-actions">
                                        <a href="{{ route('members.show', $member->id) }}"
                                           class="mm-icon-btn view" title="{{ __('View Profile') }}"
                                           onclick="event.stopPropagation();">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('members.edit', $member->id) }}"
                                           class="mm-icon-btn" title="{{ __('Edit Member') }}"
                                           onclick="event.stopPropagation();">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @if(!$member->is_deceased)
                                            <button type="button"
                                                    class="mm-icon-btn"
                                                    title="{{ __('Mark as Deceased') }}"
                                                    onclick="event.stopPropagation(); openDeceasedModal({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                                <i class="fas fa-cross"></i>
                                            </button>
                                        @endif
                                        <button type="button"
                                                class="mm-icon-btn danger"
                                                title="{{ __('Delete Member') }}"
                                                onclick="event.stopPropagation(); confirmDelete({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $member->id }}"
                                          action="{{ route('members.destroy', $member->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="mm-empty">
                                        <i class="fas fa-users"></i>
                                        <h5 data-i18n="no_active_members">{{ __("No Active Members Yet") }}</h5>
                                        <p data-i18n="no_active_members_desc">{{ __("Get started by adding your first church member to the system.") }}</p>
                                        <a href="{{ route('members.create') }}" class="mm-btn mm-btn-primary">
                                            <i class="fas fa-plus"></i>
                                            <span data-i18n="add_first_member">{{ __("Add Your First Member") }}</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        <tr class="mm-no-results" hidden>
                            <td colspan="7">
                                <div class="mm-empty" style="padding:2.25rem 1.5rem;">
                                    <i class="fas fa-magnifying-glass"></i>
                                    <h5>{{ __("No matching members") }}</h5>
                                    <p>{{ __("Try a different name or phone number.") }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($members->hasPages())
                <div class="mm-foot">
                    <div class="mm-foot-info">
                        <span data-i18n="showing">{{ __("Showing") }}</span>
                        <strong>{{ $members->firstItem() }}</strong>
                        <span data-i18n="to">{{ __("to") }}</span>
                        <strong>{{ $members->lastItem() }}</strong>
                        <span data-i18n="of">{{ __("of") }}</span>
                        <strong>{{ $members->total() }}</strong>
                        <span data-i18n="active_members">{{ __("active members") }}</span>
                    </div>
                    {{ $members->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </section>

        {{-- ============================================
             DECEASED MEMBERS
        ============================================ --}}
        <section id="deceasedMembersTable"
                 class="mm-section {{ $isDeceasedFilter ? 'is-active' : '' }}">
            <div class="mm-table-scroll">
                <table class="mm-table">
                    <thead>
                        <tr>
                            <th style="width:56px;">#</th>
                            <th data-i18n="member">{{ __("Member") }}</th>
                            <th style="width:96px;" data-i18n="gender">{{ __("Gender") }}</th>
                            <th data-i18n="roles">{{ __("Roles") }}</th>
                            <th style="width:110px;" class="mm-col-optional" data-i18n="birthday">{{ __("Birthday") }}</th>
                            <th style="width:80px;" class="mm-col-optional" data-i18n="age">{{ __("Age") }}</th>
                            <th style="width:120px;" data-i18n="actions">{{ __("Actions") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deceasedMembers as $index => $member)
                            @php
                                $ageAtDeath = null;
                                if ($member->birthday && $member->date_deceased) {
                                    $birthDate = \Carbon\Carbon::parse($member->birthday);
                                    $deathDate = \Carbon\Carbon::parse($member->date_deceased);
                                    $ageAtDeath = $birthDate->diffInYears($deathDate);
                                }

                                $memberRoles = $member->roles ?? [];
                                $uniqueRoles = collect($memberRoles)->unique('name')->values()->all();

                                $genderValue = $member->gender ?? null;
                                if ($genderValue === 'male') {
                                    $genderIcon = 'fa-mars'; $genderLabel = 'Male'; $genderClass = 'male';
                                } elseif ($genderValue === 'female') {
                                    $genderIcon = 'fa-venus'; $genderLabel = 'Female'; $genderClass = 'female';
                                } else {
                                    $genderIcon = 'fa-circle'; $genderLabel = '—'; $genderClass = 'unspecified';
                                }
                            @endphp
                            <tr class="member-row mm-row"
                                data-row
                                data-member-id="{{ $member->id }}"
                                data-member-name="{{ addslashes($member->first_name . ' ' . $member->last_name) }}"
                                data-member-birthday="{{ $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('F d, Y') : '' }}"
                                data-member-age="{{ $ageAtDeath ?? '' }}"
                                data-member-address="{{ $member->address ?? '' }}"
                                data-member-phone="{{ $member->phone ?? '' }}"
                                data-member-roles="{{ json_encode($uniqueRoles) }}"
                                data-member-ischoir="{{ $member->is_choir ? 'true' : 'false' }}"
                                data-member-isdeceased="true">

                                <td class="mm-idx">{{ $deceasedMembers->firstItem() + $index }}</td>

                                <td>
                                    <div class="mm-person">
                                        <div class="mm-avatar muted">
                                            <i class="fas fa-cross"></i>
                                        </div>
                                        <div style="min-width:0;">
                                            <div class="mm-person-name">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </div>
                                            <div class="mm-person-meta">
                                                <i class="fas fa-cross"></i>
                                                {{ \Carbon\Carbon::parse($member->date_deceased)->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="mm-pill {{ $genderClass }}">
                                        <i class="fas {{ $genderIcon }}"></i> {{ $genderLabel }}
                                    </span>
                                </td>

                                <td>
                                    <div class="mm-pill-group">
                                        @forelse($uniqueRoles as $role)
                                            <span class="mm-pill">
                                                <i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}
                                            </span>
                                        @empty
                                            <span class="mm-pill">
                                                <i class="fas fa-user"></i>
                                                <span data-i18n="regular">{{ __("Regular") }}</span>
                                            </span>
                                        @endforelse
                                        @if($member->is_choir)
                                            <span class="mm-pill choir">
                                                <i class="fas fa-music"></i>
                                                <span data-i18n="choir">{{ __("Choir") }}</span>
                                            </span>
                                        @endif
                                        <span class="mm-pill deceased">
                                            <i class="fas fa-cross"></i>
                                            <span data-i18n="deceased">{{ __("Deceased") }}</span>
                                        </span>
                                    </div>
                                </td>

                                <td class="mm-col-optional">
                                    @if($member->birthday)
                                        {{ \Carbon\Carbon::parse($member->birthday)->format('M d') }}
                                    @else
                                        <span class="mm-muted">—</span>
                                    @endif
                                </td>

                                <td class="mm-col-optional">
                                    @if($ageAtDeath)
                                        {{ $ageAtDeath }}
                                    @else
                                        <span class="mm-muted">—</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="mm-actions">
                                        <button type="button"
                                                class="mm-icon-btn restore"
                                                title="{{ __('Restore to Active') }}"
                                                onclick="event.stopPropagation(); confirmRestore({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-rotate-left"></i>
                                        </button>
                                        <button type="button"
                                                class="mm-icon-btn danger"
                                                title="{{ __('Delete Permanently') }}"
                                                onclick="event.stopPropagation(); confirmDeletePermanent({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <form id="restore-form-{{ $member->id }}"
                                          action="{{ route('members.restore', $member->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf @method('PUT')
                                    </form>
                                    <form id="delete-deceased-form-{{ $member->id }}"
                                          action="{{ route('members.destroy', $member->id) }}"
                                          method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="mm-empty">
                                        <i class="fas fa-cross"></i>
                                        <h5 data-i18n="no_deceased_members">{{ __("No Deceased Members") }}</h5>
                                        <p data-i18n="no_deceased_members_desc">{{ __("Click the cross button on any active member to move them here.") }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        <tr class="mm-no-results" hidden>
                            <td colspan="7">
                                <div class="mm-empty" style="padding:2.25rem 1.5rem;">
                                    <i class="fas fa-magnifying-glass"></i>
                                    <h5>{{ __("No matching members") }}</h5>
                                    <p>{{ __("Try a different name or phone number.") }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($deceasedMembers->hasPages())
                <div class="mm-foot">
                    <div class="mm-foot-info">
                        <span data-i18n="showing">{{ __("Showing") }}</span>
                        <strong>{{ $deceasedMembers->firstItem() }}</strong>
                        <span data-i18n="to">{{ __("to") }}</span>
                        <strong>{{ $deceasedMembers->lastItem() }}</strong>
                        <span data-i18n="of">{{ __("of") }}</span>
                        <strong>{{ $deceasedMembers->total() }}</strong>
                        <span data-i18n="deceased_members">{{ __("deceased members") }}</span>
                    </div>
                    {{ $deceasedMembers->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /* =============================================
       i18n helper
    ============================================= */
    function t(key, fallback) {
        if (typeof window.__t === 'function') {
            return window.__t(key, fallback);
        }
        return fallback || key;
    }

    /* =============================================
       CLIENT-SIDE SEARCH (filters visible section)
    ============================================= */
    (function () {
        const input = document.getElementById('mmSearch');
        if (!input) return;

        function applyFilter() {
            const q = input.value.trim().toLowerCase();
            const section = document.querySelector('.mm-section.is-active');
            if (!section) return;

            const rows = section.querySelectorAll('tbody tr[data-row]');
            let visible = 0;

            rows.forEach(function (tr) {
                const name = (tr.dataset.memberName || '').toLowerCase();
                const phone = (tr.dataset.memberPhone || '').toLowerCase();
                const match = !q || name.includes(q) || phone.includes(q);
                tr.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            const noResults = section.querySelector('.mm-no-results');
            if (noResults) noResults.hidden = visible > 0 || rows.length === 0;
        }

        input.addEventListener('input', applyFilter);

        // Escape clears the search
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                input.value = '';
                applyFilter();
            }
        });
    })();

    /* =============================================
       DELETE ACTIVE MEMBER
    ============================================= */
    function confirmDelete(memberId, memberName) {
        Swal.fire({
            title: t('delete_member', 'Delete Member?'),
            html: t('delete_member_confirm', 'Are you sure you want to permanently delete <strong>{memberName}</strong>?<br><small>This action cannot be undone.</small>').replace('{memberName}', memberName),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: t('yes_delete', 'Yes, delete!'),
            cancelButtonText: t('cancel', 'Cancel'),
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: t('deleting', 'Deleting...'),
                    html: '<div class="loading-spinner"></div><p class="mt-2">' + t('please_wait', 'Please wait') + '</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: 'var(--card-bg)'
                });
                document.getElementById(`delete-form-${memberId}`).submit();
            }
        });
    }

    /* =============================================
       DELETE DECEASED MEMBER (PERMANENT)
    ============================================= */
    function confirmDeletePermanent(memberId, memberName) {
        Swal.fire({
            title: t('permanently_delete', 'Permanently Delete?'),
            html: t('permanently_delete_confirm', 'Are you sure you want to permanently delete <strong>{memberName}</strong>?<br><small>All records will be lost forever.</small>').replace('{memberName}', memberName),
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: t('yes_delete', 'Yes, delete!'),
            cancelButtonText: t('cancel', 'Cancel'),
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: t('deleting', 'Deleting...'),
                    html: '<div class="loading-spinner"></div><p class="mt-2">' + t('please_wait', 'Please wait') + '</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: 'var(--card-bg)'
                });
                document.getElementById(`delete-deceased-form-${memberId}`).submit();
            }
        });
    }

    /* =============================================
       RESTORE DECEASED MEMBER
    ============================================= */
    function confirmRestore(memberId, memberName) {
        Swal.fire({
            title: t('restore_member', 'Restore Member?'),
            html: t('restore_member_confirm', 'Are you sure you want to restore <strong>{memberName}</strong> to active members?').replace('{memberName}', memberName),
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: t('yes_restore', 'Yes, restore!'),
            cancelButtonText: t('cancel', 'Cancel'),
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: t('restoring', 'Restoring...'),
                    html: '<div class="loading-spinner"></div><p class="mt-2">' + t('please_wait', 'Please wait') + '</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: 'var(--card-bg)'
                });

                fetch(`/members/${memberId}/restore`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: t('restored', 'Restored!'),
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false,
                            background: 'var(--card-bg)',
                            color: 'var(--text-primary)'
                        }).then(() => window.location.reload());
                    } else {
                        throw new Error(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: t('error', 'Error!'),
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                });
            }
        });
    }

    /* =============================================
       MARK AS DECEASED
    ============================================= */
    function openDeceasedModal(memberId, memberName) {
        Swal.fire({
            title: t('mark_as_deceased', 'Mark as Deceased'),
            html: `
                <div style="text-align:left;">
                    <p>${t('mark_deceased_confirm', 'Mark <strong>{memberName}</strong> as deceased?').replace('{memberName}', memberName)}</p>
                    <div class="mb-3">
                        <label class="form-label" style="display:block;text-align:left;margin-bottom:5px;">
                            ${t('date_of_death', 'Date of Death:')}
                        </label>
                        <input type="date" id="date_deceased_input" class="swal2-input"
                               style="width:100%;padding:8px;border-radius:8px;border:1px solid #d1d5db;"
                               max="${new Date().toISOString().split('T')[0]}" required>
                    </div>
                    <small style="color:#6b7280;">${t('deceased_move_note', 'This member will be moved to the Deceased Members section.')}</small>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#6b7280',
            cancelButtonColor: '#6c757d',
            confirmButtonText: t('mark_deceased', 'Mark as Deceased'),
            cancelButtonText: t('cancel', 'Cancel'),
            background: 'var(--card-bg)',
            color: 'var(--text-primary)',
            preConfirm: () => {
                const dateDeceased = document.getElementById('date_deceased_input').value;
                if (!dateDeceased) {
                    Swal.showValidationMessage(t('select_death_date', 'Please select the date of death'));
                    return false;
                }
                return { date_deceased: dateDeceased };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const dateDeceased = result.value.date_deceased;
                Swal.fire({
                    title: t('processing', 'Processing...'),
                    html: '<div class="loading-spinner"></div><p class="mt-2">' + t('please_wait', 'Please wait') + '</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: 'var(--card-bg)'
                });

                fetch(`/members/${memberId}/deceased`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ date_deceased: dateDeceased })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: t('marked_deceased', 'Marked as Deceased'),
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false,
                            background: 'var(--card-bg)',
                            color: 'var(--text-primary)'
                        }).then(() => window.location.reload());
                    } else {
                        throw new Error(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: t('error', 'Error!'),
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                });
            }
        });
    }

    /* =============================================
       LANGUAGE CHANGE
    ============================================= */
    window.addEventListener('localeChanged', function (e) {
        if (typeof window.applyTranslations === 'function') {
            window.applyTranslations();
        }
        console.log('[Members] Locale changed to:', e.detail.locale);
    });
</script>
@endsection