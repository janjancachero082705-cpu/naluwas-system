@extends('layouts.app')

@section('header')
    <span data-i18n="add_choir_member_title">Add Choir Member</span>
@endsection

@section('content')

{{-- SAFE FALLBACK — fetch available members directly from DB --}}
@php
    $availableMembers = $availableMembers ?? \App\Models\Member::query()
        ->where(function ($q) {
            $q->where('is_deceased', false)->orWhereNull('is_deceased');
        })
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get(['id', 'first_name', 'last_name', 'email', 'phone', 'is_choir']);
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ═══════════════════════════════════════════════
       ADD CHOIR MEMBER — matches app dark palette
    ═══════════════════════════════════════════════ */
    .choir-form-app {
        font-family: var(--font-body, 'Inter', sans-serif);
        color: var(--text-primary);
        max-width: 920px;
        margin: 0 auto;
    }

    .choir-form-app * { box-sizing: border-box; }

    /* ─── Animations ─── */
    @keyframes aFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes aFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes aCardIn {
        0%   { opacity: 0; transform: translateY(8px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ═══════════════════════════════════════════════
       HERO — dark navy with brass accent
    ═══════════════════════════════════════════════ */
    .form-hero {
        position: relative;
        padding: 1.25rem 1.5rem;
        border-radius: 16px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        margin-bottom: 1.25rem;
        overflow: hidden;
        animation: aFadeUp 0.5s ease both;
    }
    .form-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #D3A24C 0%, #B9862F 60%, transparent 100%);
    }

    .form-hero-inner {
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }

    .form-hero-orb {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        color: #0B1A2E;
        font-size: 1.15rem;
        box-shadow: 0 6px 20px -4px rgba(200, 155, 60, 0.45);
    }

    .form-hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        min-width: 0;
        flex: 1;
    }

    .form-hero-title {
        margin: 0;
        font-family: var(--font-display, 'Fraunces', serif);
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.02em;
        line-height: 1.15;
    }

    .form-hero-sub {
        margin: 0;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .form-hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-top: 0.35rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        background: rgba(200, 155, 60, 0.12);
        border: 1px solid rgba(200, 155, 60, 0.25);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        width: fit-content;
        color: #D3A24C;
    }
    .form-hero-tag .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #D3A24C;
        box-shadow: 0 0 8px rgba(211, 162, 76, 0.7);
    }

    /* ═══════════════════════════════════════════════
       FORM CARD
    ═══════════════════════════════════════════════ */
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        animation: aFadeUp 0.55s ease 0.08s both;
    }

    .card-header-custom {
        padding: 1.15rem 1.5rem;
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-custom .header-icon {
        width: 38px;
        height: 38px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        color: #0B1A2E;
        font-size: 0.9rem;
        flex-shrink: 0;
        box-shadow: 0 6px 16px -6px rgba(200, 155, 60, 0.45);
    }

    .card-header-custom .header-copy {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        min-width: 0;
    }

    .card-header-custom h4 {
        margin: 0;
        font-family: var(--font-display, 'Fraunces', serif);
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.01em;
    }

    .card-header-custom p {
        margin: 0;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .card-body-custom {
        padding: 1.5rem;
    }

    /* ═══════════════════════════════════════════════
       MODE TOGGLE
    ═══════════════════════════════════════════════ */
    .mode-toggle {
        display: inline-flex;
        gap: 4px;
        padding: 4px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        margin-bottom: 1.25rem;
        width: 100%;
    }

    .mode-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: inherit;
        color: var(--text-muted);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.22s ease;
        white-space: nowrap;
    }

    .mode-btn i { font-size: 0.8rem; }
    .mode-btn:hover { color: var(--text-primary); }

    .mode-btn.active {
        background: var(--card-bg);
        color: #D3A24C;
        box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.35);
    }

    /* ═══════════════════════════════════════════════
       MODE PANELS
    ═══════════════════════════════════════════════ */
    .mode-panel {
        display: none;
        animation: aFadeIn 0.3s ease;
    }

    .mode-panel.active { display: block; }

    .panel-intro {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1rem;
        background: rgba(74, 122, 181, 0.10);
        border: 1px solid rgba(74, 122, 181, 0.20);
        border-radius: 12px;
        margin-bottom: 1rem;
        font-size: 0.78rem;
        color: #A5C0DE;
        font-weight: 500;
        line-height: 1.5;
    }

    .panel-intro i {
        font-size: 0.9rem;
        flex-shrink: 0;
        color: #4A7AB5;
    }

    /* ═══════════════════════════════════════════════
       EXISTING MEMBER PICKER
    ═══════════════════════════════════════════════ */
    .member-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .member-search-wrap i {
        position: absolute;
        left: 15px;
        color: var(--text-muted);
        font-size: 0.78rem;
        opacity: 0.7;
        pointer-events: none;
    }

    .member-search-wrap input {
        width: 100%;
        padding: 0.7rem 1rem 0.7rem 2.6rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        color: var(--text-primary);
        font-size: 0.83rem;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
    }

    .member-search-wrap input::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }

    .member-search-wrap input:focus {
        background: var(--card-bg);
        border-color: #D3A24C;
        box-shadow: 0 0 0 4px rgba(200, 155, 60, 0.12);
    }

    .member-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 0.7rem;
        max-height: 420px;
        overflow-y: auto;
        padding: 0.25rem;
        margin: 0 -0.25rem;
    }

    .member-grid::-webkit-scrollbar { width: 6px; }
    .member-grid::-webkit-scrollbar-track { background: transparent; }
    .member-grid::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 6px;
    }

    .member-card {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0.9rem;
        border-radius: 12px;
        background: var(--bg-tertiary);
        border: 1.5px solid var(--border-color);
        cursor: pointer;
        transition: all 0.2s ease;
        animation: aCardIn 0.3s ease both;
        overflow: hidden;
    }

    .member-card:hover {
        transform: translateY(-2px);
        border-color: rgba(200, 155, 60, 0.5);
        background: rgba(200, 155, 60, 0.06);
    }

    .member-card.selected {
        border-color: #D3A24C;
        background: rgba(200, 155, 60, 0.10);
    }

    .member-card.selected::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #D3A24C, #B9862F);
        border-radius: 0 3px 3px 0;
    }

    .member-card-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 0.78rem;
        font-weight: 700;
        color: #0B1A2E;
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        flex-shrink: 0;
    }

    .member-card-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.1rem;
    }

    .member-card-name {
        font-size: 0.83rem;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .member-card-meta {
        font-size: 0.68rem;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .member-card-check {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: rgba(200, 155, 60, 0.15);
        color: #D3A24C;
        font-size: 0.7rem;
        flex-shrink: 0;
        opacity: 0;
        transform: scale(0.5);
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .member-card.selected .member-card-check {
        opacity: 1;
        transform: scale(1);
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        color: #0B1A2E;
    }

    /* In-choir badge */
    .member-card.in-choir {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .member-card.in-choir:hover {
        transform: none;
        border-color: var(--border-color);
        background: var(--bg-tertiary);
    }

    .member-card-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 0.12rem 0.5rem;
        border-radius: 20px;
        background: rgba(42, 161, 152, 0.14);
        color: #4DBF8A;
        letter-spacing: 0.02em;
        margin-top: 0.15rem;
        width: fit-content;
    }

    .member-card-tag i { font-size: 0.52rem; }

    .no-members {
        grid-column: 1 / -1;
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--text-muted);
    }

    .no-members i {
        display: block;
        font-size: 2.4rem;
        opacity: 0.3;
        margin-bottom: 0.75rem;
        color: #D3A24C;
    }

    .no-members p {
        margin: 0 0 0.35rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .no-members small {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .selected-chip {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        padding: 0.7rem 1rem;
        background: rgba(200, 155, 60, 0.08);
        border: 1px solid rgba(200, 155, 60, 0.22);
        border-radius: 12px;
        font-size: 0.8rem;
        color: var(--text-primary);
        animation: aFadeUp 0.3s ease;
    }

    .selected-chip i { color: #4DBF8A; }

    .selected-chip strong {
        color: #D3A24C;
        font-weight: 700;
    }

    .selected-chip button {
        margin-left: auto;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        border: none;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 0.7rem;
        transition: all 0.2s ease;
    }

    .selected-chip button:hover {
        background: rgba(208, 85, 78, 0.15);
        color: #F1A29D;
    }

    /* ═══════════════════════════════════════════════
       FORM GRID / INPUTS
    ═══════════════════════════════════════════════ */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .form-group-full { grid-column: span 2; }

    .form-label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        font-weight: 700;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .form-label i {
        font-size: 0.62rem;
        color: #D3A24C;
    }

    .required {
        color: #F1A29D;
        margin-left: 2px;
    }

    .form-control,
    .form-select,
    textarea {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: var(--bg-tertiary);
        color: var(--text-primary);
        font-size: 0.85rem;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .form-control::placeholder,
    textarea::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }

    .form-control:focus,
    .form-select:focus,
    textarea:focus {
        outline: none;
        background: var(--card-bg);
        border-color: #D3A24C;
        box-shadow: 0 0 0 4px rgba(200, 155, 60, 0.12);
    }

    input[type="date"] { color-scheme: dark; }

    textarea {
        resize: vertical;
        min-height: 80px;
    }

    /* ═══════════════════════════════════════════════
       CHOIR DETAILS SECTION
    ═══════════════════════════════════════════════ */
    .choir-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px dashed var(--border-color);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .section-title i {
        display: grid;
        place-items: center;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: rgba(200, 155, 60, 0.12);
        color: #D3A24C;
        font-size: 0.7rem;
        letter-spacing: 0;
    }

    .voice-selector {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.6rem;
    }

    .voice-option {
        padding: 0.85rem 0.5rem;
        border-radius: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: var(--bg-tertiary);
        border: 1.5px solid var(--border-color);
        color: var(--text-muted);
        font-size: 0.78rem;
        font-weight: 600;
        user-select: none;
        position: relative;
        overflow: hidden;
    }

    .voice-option i {
        display: block;
        font-size: 1.05rem;
        margin-bottom: 0.35rem;
        color: #D3A24C;
        transition: all 0.25s ease;
        opacity: 0.7;
    }

    .voice-option:hover {
        border-color: rgba(200, 155, 60, 0.5);
        background: rgba(200, 155, 60, 0.08);
        color: #D3A24C;
        transform: translateY(-2px);
    }

    .voice-option:hover i {
        opacity: 1;
        transform: scale(1.1);
    }

    .voice-option.selected {
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        border-color: transparent;
        color: #0B1A2E;
        box-shadow: 0 10px 24px -10px rgba(200, 155, 60, 0.7);
        transform: translateY(-2px);
    }

    .voice-option.selected i {
        color: #0B1A2E;
        opacity: 1;
        transform: scale(1.15);
    }

    /* ═══════════════════════════════════════════════
       ACTIONS
    ═══════════════════════════════════════════════ */
    .button-group {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        flex: 1;
        padding: 0.75rem 1.4rem;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: inherit;
        color: #0B1A2E;
        background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        letter-spacing: -0.005em;
    }

    .btn-submit:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px -8px rgba(200, 155, 60, 0.55);
    }

    .btn-submit:active { transform: translateY(0) scale(0.99); }
    .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        flex: 1;
        padding: 0.75rem 1.4rem;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        font-family: inherit;
        color: var(--text-primary);
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: var(--bg-secondary);
        color: #A5B4FC;
        border-color: #4A7AB5;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════ */
    @media (max-width: 640px) {
        .form-hero { padding: 1rem 1.15rem; }
        .form-hero-orb { width: 42px; height: 42px; font-size: 1rem; }
        .form-hero-title { font-size: 1.05rem; }

        .card-header-custom { padding: 1rem 1.15rem; }
        .card-header-custom .header-icon { width: 34px; height: 34px; font-size: 0.85rem; }
        .card-header-custom h4 { font-size: 0.92rem; }
        .card-body-custom { padding: 1.15rem; }

        .mode-btn { font-size: 0.74rem; padding: 0.55rem 0.6rem; }

        .form-grid { grid-template-columns: 1fr; gap: 1rem; }
        .form-group-full { grid-column: span 1; }

        .voice-selector { grid-template-columns: repeat(2, 1fr); }

        .button-group { flex-direction: column-reverse; }
        .btn-submit, .btn-cancel { width: 100%; }

        .member-grid { grid-template-columns: 1fr; max-height: 360px; }
    }
</style>

<div class="choir-form-app">

    {{-- HERO --}}
    <div class="form-hero">
        <div class="form-hero-inner">
            <div class="form-hero-orb">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="form-hero-copy">
                <h1 class="form-hero-title" data-i18n="add_choir_member_title">Add New Choir Member</h1>
                <p class="form-hero-sub" data-i18n="add_choir_member_desc">Add a new voice to praise the Lord</p>
                <span class="form-hero-tag">
                    <span class="dot"></span>
                    <span data-i18n="choir_ministry_title">Choir Ministry</span>
                </span>
            </div>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="form-card">

        <div class="card-header-custom">
            <div class="header-icon">
                <i class="fas fa-music"></i>
            </div>
            <div class="header-copy">
                <h4 data-i18n="member_details_label">Member Details</h4>
                <p data-i18n="fill_member_info">Pick an existing member or create a new one</p>
            </div>
        </div>

        <div class="card-body-custom">
            <form action="{{ route('choir-members.store') }}" method="POST" id="choirMemberForm">
                @csrf

                {{-- MODE TOGGLE --}}
                <div class="mode-toggle" role="tablist">
                    <button type="button"
                            class="mode-btn active"
                            data-mode="existing"
                            onclick="setMode('existing')">
                        <i class="fas fa-user-check"></i>
                        <span data-i18n="pick_from_members">Pick from Members</span>
                    </button>
                    <button type="button"
                            class="mode-btn"
                            data-mode="new"
                            onclick="setMode('new')">
                        <i class="fas fa-user-plus"></i>
                        <span data-i18n="create_new_member">Create New Member</span>
                    </button>
                </div>

                {{-- MODE: EXISTING MEMBER --}}
                <div class="mode-panel active" data-panel="existing">
                    <div class="panel-intro">
                        <i class="fas fa-info-circle"></i>
                        <span data-i18n="pick_existing_note">Pick an existing member to add them to the choir. Their member details stay unchanged.</span>
                    </div>

                    <div class="member-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text"
                               id="memberSearch"
                               placeholder="{{ __('Search by name or email...') }}"
                               autocomplete="off">
                    </div>

                    <div class="member-grid" id="memberGrid">
                        @forelse($availableMembers as $m)
                            @php
                                $initials = strtoupper(substr($m->first_name ?? 'M', 0, 1)) . strtoupper(substr($m->last_name ?? '', 0, 1));
                                $searchKey = strtolower(($m->first_name ?? '') . ' ' . ($m->last_name ?? '') . ' ' . ($m->email ?? '') . ' ' . ($m->phone ?? ''));
                                $alreadyInChoir = !empty($m->is_choir);
                            @endphp
                            <div class="member-card {{ $alreadyInChoir ? 'in-choir' : '' }}"
                                 data-member-id="{{ $m->id }}"
                                 data-search="{{ $searchKey }}"
                                 @if(!$alreadyInChoir)
                                    onclick="selectMember(this, {{ $m->id }})"
                                 @endif>
                                <div class="member-card-avatar">
                                    {{ $initials }}
                                </div>
                                <div class="member-card-info">
                                    <div class="member-card-name">{{ $m->first_name }} {{ $m->last_name }}</div>
                                    @if($m->email)
                                        <div class="member-card-meta">{{ $m->email }}</div>
                                    @elseif($m->phone)
                                        <div class="member-card-meta">{{ $m->phone }}</div>
                                    @endif
                                    @if($alreadyInChoir)
                                        <span class="member-card-tag">
                                            <i class="fas fa-check"></i>
                                            <span data-i18n="already_in_choir">Already in choir</span>
                                        </span>
                                    @endif
                                </div>
                                <div class="member-card-check">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                        @empty
                            <div class="no-members">
                                <i class="fas fa-users-slash"></i>
                                <p data-i18n="no_available_members">No members available to add</p>
                                <small data-i18n="no_available_members_hint">Switch to "Create New Member" to add a brand new member.</small>
                            </div>
                        @endforelse

                        <div class="no-members" id="noSearchResults" style="display:none;">
                            <i class="fas fa-magnifying-glass"></i>
                            <p data-i18n="no_search_results">No matching members</p>
                            <small data-i18n="no_search_results_hint">Try a different name, email, or phone number.</small>
                        </div>
                    </div>

                    <input type="hidden" name="member_id" id="selectedMemberId" value="">

                    <div class="selected-chip" id="selectedChip" style="display:none;">
                        <i class="fas fa-check-circle"></i>
                        <span data-i18n="selected_label">Selected:</span>
                        <strong id="selectedName"></strong>
                        <button type="button" onclick="clearSelection()" title="{{ __('Clear selection') }}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- MODE: NEW MEMBER --}}
                <div class="mode-panel" data-panel="new">
                    <div class="panel-intro">
                        <i class="fas fa-info-circle"></i>
                        <span data-i18n="create_new_note">Create a brand new member and add them directly to the choir.</span>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                <span data-i18n="first_name">First Name</span>
                                <span class="required">*</span>
                            </label>
                            <input type="text"
                                   name="first_name"
                                   class="form-control"
                                   placeholder="{{ __('Enter first name') }}"
                                   data-required="new">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i>
                                <span data-i18n="last_name">Last Name</span>
                                <span class="required">*</span>
                            </label>
                            <input type="text"
                                   name="last_name"
                                   class="form-control"
                                   placeholder="{{ __('Enter last name') }}"
                                   data-required="new">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-birthday-cake"></i>
                                <span data-i18n="birthday">Birthday</span>
                            </label>
                            <input type="date" name="birthday" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone"></i>
                                <span data-i18n="phone">Phone</span>
                            </label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   placeholder="{{ __('Optional contact number') }}">
                        </div>

                        <div class="form-group-full">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                <span data-i18n="address">Address</span>
                            </label>
                            <textarea name="address"
                                      rows="2"
                                      class="form-control"
                                      placeholder="{{ __('Complete address of the member') }}"></textarea>
                        </div>
                    </div>
                </div>

                {{-- SHARED: CHOIR DETAILS --}}
                <div class="choir-section">
                    <div class="section-title">
                        <i class="fas fa-sliders-h"></i>
                        <span data-i18n="choir_details">Choir Details</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-microphone-alt"></i>
                            <span data-i18n="voice_part">Voice Part</span>
                            <span class="required">*</span>
                        </label>
                        <div class="voice-selector">
                            <div class="voice-option" data-voice="Soprano" onclick="selectVoice(this, 'Soprano')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="soprano">Soprano</span>
                            </div>
                            <div class="voice-option" data-voice="Alto" onclick="selectVoice(this, 'Alto')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="alto">Alto</span>
                            </div>
                            <div class="voice-option" data-voice="Tenor" onclick="selectVoice(this, 'Tenor')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="tenor">Tenor</span>
                            </div>
                            <div class="voice-option" data-voice="Bass" onclick="selectVoice(this, 'Bass')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="bass">Bass</span>
                            </div>
                        </div>
                        <input type="hidden" name="voice_part" id="voicePart" value="">
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="button-group">
                    <a href="{{ route('choir-members.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        <span data-i18n="cancel">Cancel</span>
                    </a>
                    <button type="submit" class="btn-submit" id="saveBtn">
                        <i class="fas fa-save"></i>
                        <span data-i18n="save_choir_member">Save Choir Member</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    /* =============================================
       STATE
    ============================================= */
    let currentMode = 'existing';
    let selectedMemberId = null;
    let selectedVoice = null;

    /* =============================================
       MODE SWITCHING
    ============================================= */
    function setMode(mode) {
        currentMode = mode;

        document.querySelectorAll('.mode-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.mode === mode);
        });

        document.querySelectorAll('.mode-panel').forEach(panel => {
            panel.classList.toggle('active', panel.dataset.panel === mode);
        });

        document.querySelectorAll('[data-required="new"]').forEach(field => {
            if (mode === 'new') {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });

        updateSaveButton();
    }

    /* =============================================
       SELECT EXISTING MEMBER
    ============================================= */
    function selectMember(el, memberId) {
        if (el.classList.contains('in-choir')) return;

        document.querySelectorAll('.member-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        selectedMemberId = memberId;
        document.getElementById('selectedMemberId').value = memberId;

        const name = el.querySelector('.member-card-name').textContent.trim();
        document.getElementById('selectedName').textContent = name;
        document.getElementById('selectedChip').style.display = 'flex';

        updateSaveButton();
    }

    function clearSelection() {
        document.querySelectorAll('.member-card').forEach(c => c.classList.remove('selected'));
        selectedMemberId = null;
        document.getElementById('selectedMemberId').value = '';
        document.getElementById('selectedChip').style.display = 'none';
        updateSaveButton();
    }

    /* =============================================
       SELECT VOICE
    ============================================= */
    function selectVoice(el, voice) {
        document.querySelectorAll('.voice-option').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        selectedVoice = voice;
        document.getElementById('voicePart').value = voice;
        updateSaveButton();
    }

    /* =============================================
       ENABLE / DISABLE SAVE
    ============================================= */
    function updateSaveButton() {
        const saveBtn = document.getElementById('saveBtn');
        if (!saveBtn) return;

        let ready = false;

        if (currentMode === 'existing') {
            ready = !!selectedMemberId;
        } else {
            const firstName = document.querySelector('[name="first_name"]').value.trim();
            const lastName = document.querySelector('[name="last_name"]').value.trim();
            ready = !!firstName && !!lastName;
        }

        if (!selectedVoice) ready = false;

        saveBtn.disabled = !ready;
    }

    /* =============================================
       SEARCH
    ============================================= */
    document.getElementById('memberSearch')?.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let visible = 0;

        document.querySelectorAll('.member-card').forEach(card => {
            const haystack = (card.dataset.search || '').toLowerCase();
            const match = !q || haystack.includes(q);
            card.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        const noResults = document.getElementById('noSearchResults');
        if (noResults) {
            const hasAnyCards = document.querySelectorAll('.member-card').length > 0;
            noResults.style.display = (hasAnyCards && visible === 0 && q) ? 'block' : 'none';
        }
    });

    /* =============================================
       FORM SUBMIT VALIDATION
    ============================================= */
    document.getElementById('choirMemberForm')?.addEventListener('submit', function (e) {
        if (!selectedVoice) {
            e.preventDefault();
            alert('Please select a voice part.');
            return;
        }

        if (currentMode === 'existing' && !selectedMemberId) {
            e.preventDefault();
            alert('Please select a member from the list.');
            return;
        }

        if (currentMode === 'new') {
            const firstName = document.querySelector('[name="first_name"]').value.trim();
            const lastName = document.querySelector('[name="last_name"]').value.trim();
            if (!firstName || !lastName) {
                e.preventDefault();
                alert('Please enter first and last name.');
                return;
            }
        }
    });

    /* =============================================
       WATCH INPUTS
    ============================================= */
    document.querySelectorAll('[name="first_name"], [name="last_name"]').forEach(input => {
        input.addEventListener('input', updateSaveButton);
    });

    /* =============================================
       INIT
    ============================================= */
    document.addEventListener('DOMContentLoaded', function () {
        setMode('existing');
        updateSaveButton();
    });
</script>
@endsection