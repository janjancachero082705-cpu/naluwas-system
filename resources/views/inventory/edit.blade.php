@extends('layouts.app')

@section('header', 'Edit Transaction')

@section('content')

<style>
    /* ==========================================================
       EDIT TRANSACTION — 2025 REDESIGN
       Flat · bordered · airy · Inter
       (functionality unchanged — design only)
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .et {
        --et-card: var(--card-bg, #ffffff);
        --et-border: var(--border-color, #e8eaf0);
        --et-text: var(--text-primary, #0f172a);
        --et-muted: var(--text-muted, #7c8494);
        --et-soft: var(--bg-tertiary, #f5f6fa);

        --et-primary: #4f46e5;
        --et-primary-soft: rgba(79, 70, 229, .08);
        --et-primary-ring: rgba(79, 70, 229, .18);

        --et-green: #059669;
        --et-green-soft: rgba(5, 150, 105, .10);
        --et-rose: #e11d48;
        --et-rose-soft: rgba(225, 29, 72, .09);
        --et-amber: #d97706;
        --et-amber-soft: rgba(217, 119, 6, .10);
        --et-violet: #7c3aed;
        --et-violet-soft: rgba(124, 58, 237, .10);

        --et-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --et-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --et-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--et-text);
        padding-bottom: 2rem;
        max-width: 980px;
        margin: 0 auto;
    }

    [data-theme="dark"] .et {
        --et-primary: #6366f1;
        --et-primary-soft: rgba(99, 102, 241, .16);
        --et-primary-ring: rgba(99, 102, 241, .28);
        --et-green: #34d399;
        --et-green-soft: rgba(16, 185, 129, .14);
        --et-rose: #fb7185;
        --et-rose-soft: rgba(244, 63, 94, .14);
        --et-amber: #fbbf24;
        --et-amber-soft: rgba(245, 158, 11, .14);
        --et-violet: #a78bfa;
        --et-violet-soft: rgba(139, 92, 246, .16);
        --et-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --et-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .et * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .et-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--et-border);
        margin-bottom: 1.5rem;
    }

    .et-head-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
    }

    .et-avatar {
        width: 60px; height: 60px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        font-size: 1.25rem;
        flex: 0 0 auto;
    }

    .et-avatar.income {
        background: var(--et-green-soft);
        color: var(--et-green);
    }

    .et-avatar.expense {
        background: var(--et-rose-soft);
        color: var(--et-rose);
    }

    .et-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--et-muted);
        margin-bottom: .4rem;
    }

    .et-eyebrow .et-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--et-violet);
        box-shadow: 0 0 0 3px var(--et-violet-soft);
    }

    .et-title {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0;
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .et-title i { font-size: 1.05rem; color: var(--et-primary); }

    .et-sub {
        margin: .45rem 0 0;
        font-size: .8rem;
        color: var(--et-muted);
        line-height: 1.5;
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .et-sub .sep { opacity: .4; }
    .et-sub i { font-size: .68rem; }

    .et-type-pill {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .15rem .55rem;
        border-radius: 20px;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .03em;
    }

    .et-type-pill.income {
        background: var(--et-green-soft);
        color: var(--et-green);
    }

    .et-type-pill.expense {
        background: var(--et-rose-soft);
        color: var(--et-rose);
    }

    .et-type-pill i { font-size: .55rem; }

    .et-amount-pill {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .15rem .6rem;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 700;
        background: var(--et-soft);
        color: var(--et-text);
        font-variant-numeric: tabular-nums;
    }

    .et-head-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .et-btn {
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

    .et-btn-primary {
        background: var(--et-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .et-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .et-btn-rose {
        background: var(--et-rose);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(225, 29, 72, .9);
    }
    .et-btn-rose:hover {
        background: #be123c;
        color: #fff;
        transform: translateY(-1px);
    }

    .et-btn-ghost {
        background: var(--et-card);
        color: var(--et-text);
        border-color: var(--et-border);
    }
    .et-btn-ghost:hover {
        background: var(--et-soft);
        color: var(--et-text);
        transform: translateY(-1px);
    }

    /* ---------------- CARD ---------------- */
    .et-card {
        background: var(--et-card);
        border: 1px solid var(--et-border);
        border-radius: var(--et-radius);
        overflow: hidden;
        box-shadow: var(--et-shadow-sm);
    }

    .et-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1rem 1.35rem;
        border-bottom: 1px solid var(--et-border);
        background: var(--et-soft);
    }

    .et-card-head-left {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .et-card-head-icon {
        width: 36px; height: 36px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        font-size: .85rem;
        background: var(--et-primary-soft);
        color: var(--et-primary);
        flex: 0 0 auto;
    }

    .et-card-head-title {
        font-size: .92rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
    }

    .et-card-head-sub {
        font-size: .7rem;
        color: var(--et-muted);
        margin-top: .15rem;
    }

    .et-card-head-tag {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .28rem .7rem;
        border-radius: 20px;
        border: 1px solid var(--et-border);
        background: var(--et-card);
        font-size: .68rem;
        font-weight: 600;
        color: var(--et-muted);
        white-space: nowrap;
    }

    .et-card-head-tag i { font-size: .6rem; }

    .et-card-body {
        padding: 1.5rem 1.35rem;
    }

    /* ---------------- SECTION ---------------- */
    .et-section + .et-section {
        margin-top: 2rem;
        padding-top: 1.75rem;
        border-top: 1px solid var(--et-border);
    }

    .et-section-head {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin-bottom: 1.15rem;
    }

    .et-section-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: .78rem;
        background: var(--et-primary-soft);
        color: var(--et-primary);
        flex: 0 0 auto;
    }

    .et-section-title {
        font-size: .95rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        margin: 0;
    }

    .et-section-sub {
        font-size: .7rem;
        color: var(--et-muted);
        margin-top: .1rem;
    }

    /* ---------------- FORM ---------------- */
    .et-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.15rem 1.25rem;
    }

    .et-field { min-width: 0; }
    .et-field.is-full { grid-column: 1 / -1; }

    .et-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--et-muted);
        margin-bottom: .45rem;
    }

    .et-label i {
        font-size: .62rem;
        color: var(--et-primary);
        width: 14px;
        text-align: center;
    }

    .et-label .et-req { color: var(--et-rose); font-size: .8rem; line-height: 1; }

    .et-input-wrap { position: relative; }

    .et-input-wrap > .et-input-icon {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .72rem;
        color: var(--et-muted);
        pointer-events: none;
        z-index: 2;
        transition: color .18s ease;
    }

    .et-input,
    .et-select,
    .et-textarea {
        width: 100%;
        padding: .68rem .9rem .68rem 2.35rem;
        border-radius: 11px;
        border: 1px solid var(--et-border);
        background: var(--et-soft);
        color: var(--et-text);
        font-size: .84rem;
        font-family: inherit;
        line-height: 1.35;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .et-textarea {
        padding-left: .9rem;
        min-height: 80px;
        resize: vertical;
        line-height: 1.55;
    }

    .et-input::placeholder,
    .et-textarea::placeholder { color: var(--et-muted); opacity: .8; }

    .et-input:focus,
    .et-select:focus,
    .et-textarea:focus {
        outline: none;
        background: var(--et-card);
        border-color: var(--et-primary);
        box-shadow: 0 0 0 3px var(--et-primary-ring);
    }

    .et-input-wrap:focus-within > .et-input-icon { color: var(--et-primary); }

    .et-input.is-invalid,
    .et-select.is-invalid,
    .et-textarea.is-invalid {
        border-color: var(--et-rose);
    }

    .et-input.is-invalid:focus,
    .et-select.is-invalid:focus,
    .et-textarea.is-invalid:focus {
        box-shadow: 0 0 0 3px var(--et-rose-soft);
    }

    .et-select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 2.4rem;
        cursor: pointer;
    }

    .et-select option { background: var(--et-card); color: var(--et-text); }

    .et-select-caret {
        position: absolute;
        right: .95rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .58rem;
        color: var(--et-muted);
        pointer-events: none;
        z-index: 2;
    }

    /* Amount input */
    .et-amount-wrap {
        display: flex;
        align-items: stretch;
        border-radius: 11px;
        border: 1px solid var(--et-border);
        background: var(--et-soft);
        overflow: hidden;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .et-amount-wrap:focus-within {
        background: var(--et-card);
        border-color: var(--et-primary);
        box-shadow: 0 0 0 3px var(--et-primary-ring);
    }

    .et-amount-wrap.is-invalid { border-color: var(--et-rose); }

    .et-amount-symbol {
        display: grid;
        place-items: center;
        padding: 0 1rem;
        font-size: .85rem;
        font-weight: 700;
        color: var(--et-muted);
        background: transparent;
        border-right: 1px solid var(--et-border);
    }

    .et-amount-input {
        flex: 1;
        width: 100%;
        border: none;
        background: transparent;
        padding: .68rem .9rem;
        font-size: .9rem;
        font-weight: 600;
        color: var(--et-text);
        font-family: inherit;
        outline: none;
        font-variant-numeric: tabular-nums;
    }

    .et-amount-input::-webkit-outer-spin-button,
    .et-amount-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .et-amount-input[type="number"] { -moz-appearance: textfield; }

    /* Type select with live badge */
    .et-type-row {
        display: flex;
        align-items: stretch;
        gap: .55rem;
    }

    .et-type-row .et-input-wrap { flex: 1; }

    .et-type-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: 0 .9rem;
        border-radius: 11px;
        font-size: .72rem;
        font-weight: 700;
        white-space: nowrap;
        flex: 0 0 auto;
        transition: background .18s ease, color .18s ease;
    }

    .et-type-badge.income {
        background: var(--et-green-soft);
        color: var(--et-green);
    }

    .et-type-badge.expense {
        background: var(--et-rose-soft);
        color: var(--et-rose);
    }

    .et-type-badge i { font-size: .6rem; }

    /* Errors */
    .et-error {
        display: flex;
        align-items: center;
        gap: .35rem;
        margin-top: .35rem;
        font-size: .7rem;
        color: var(--et-rose);
        font-weight: 500;
    }

    .et-error i { font-size: .6rem; }

    /* ---------------- FINANCIAL IMPACT BOX ---------------- */
    .et-impact {
        background: var(--et-primary-soft);
        border: 1px solid transparent;
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
    }

    .et-impact-head {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .78rem;
        font-weight: 700;
        color: var(--et-primary);
        margin-bottom: .9rem;
    }

    .et-impact-head i { font-size: .82rem; }

    .et-impact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .9rem;
    }

    .et-impact-item {
        background: var(--et-card);
        border: 1px solid var(--et-border);
        border-radius: 11px;
        padding: .85rem .95rem;
    }

    .et-impact-label {
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--et-muted);
        margin: 0 0 .35rem;
    }

    .et-impact-value {
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: -.02em;
        font-variant-numeric: tabular-nums;
        line-height: 1.2;
    }

    .et-impact-value.is-green { color: var(--et-green); }
    .et-impact-value.is-rose  { color: var(--et-rose); }
    .et-impact-value.is-primary { color: var(--et-primary); }
    .et-impact-value.is-default { color: var(--et-text); }

    .et-impact-hint {
        display: flex;
        align-items: center;
        gap: .45rem;
        margin-top: .9rem;
        padding-top: .9rem;
        border-top: 1px solid var(--et-border);
        font-size: .72rem;
        color: var(--et-muted);
        line-height: 1.5;
    }

    .et-impact-hint i { color: var(--et-amber); flex: 0 0 auto; }

    /* ---------------- FOOTER ---------------- */
    .et-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .7rem;
        flex-wrap: wrap;
        padding: 1.1rem 1.35rem;
        border-top: 1px solid var(--et-border);
        background: var(--et-soft);
    }

    .et-foot-right {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 768px) {
        .et-head { flex-direction: column; align-items: flex-start; }
        .et-head-left { width: 100%; }
        .et-head-actions { width: 100%; }
        .et-head-actions .et-btn { flex: 1; justify-content: center; }

        .et-avatar { width: 50px; height: 50px; border-radius: 15px; font-size: 1.05rem; }
        .et-title { font-size: 1.2rem; }

        .et-grid { grid-template-columns: 1fr; }
        .et-card-body { padding: 1.15rem 1rem; }
        .et-card-head { padding: .9rem 1rem; }

        .et-impact-grid { grid-template-columns: 1fr; }

        .et-type-row { flex-direction: column; }
        .et-type-badge { padding: .55rem .9rem; justify-content: center; }

        .et-foot { flex-direction: column-reverse; align-items: stretch; padding: 1rem; }
        .et-foot-right { width: 100%; }
        .et-foot .et-btn { width: 100%; flex: 1; justify-content: center; }
    }

    @media (max-width: 480px) {
        .et-card-body { padding: 1rem .85rem; }
        .et-impact { padding: 1rem .9rem; }
    }
</style>

<div class="et container-fluid px-0">

    {{-- ============================================
         HEADER
    ============================================ --}}
    <header class="et-head">
        <div class="et-head-left">
            <div class="et-avatar {{ $transaction->type == 'income' ? 'income' : 'expense' }}">
                <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
            </div>
            <div style="min-width:0;">
                <div class="et-eyebrow">
                    <span class="et-dot"></span>
                    <span>{{ __('Inventory Management') }}</span>
                </div>
                <h1 class="et-title">
                    <i class="fas fa-pen-to-square"></i>
                    <span>{{ __('Edit Transaction') }}</span>
                </h1>
                <p class="et-sub">
                    <span>{{ $transaction->description ?? 'Untitled' }}</span>
                    <span class="sep">·</span>
                    <span class="et-type-pill {{ $transaction->type }}">
                        <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        {{ ucfirst($transaction->type) }}
                    </span>
                    <span class="et-amount-pill">₱{{ number_format($transaction->amount ?? 0, 2) }}</span>
                </p>
            </div>
        </div>
        <div class="et-head-actions">
            <a href="{{ route('inventory.index') }}" class="et-btn et-btn-ghost" id="backBtn">
                <i class="fas fa-arrow-left"></i>
                <span>{{ __('Back to Inventory') }}</span>
            </a>
        </div>
    </header>

    {{-- ============================================
         CARD
    ============================================ --}}
    <div class="et-card">

        <div class="et-card-head">
            <div class="et-card-head-left">
                <div class="et-card-head-icon"><i class="fas fa-receipt"></i></div>
                <div>
                    <div class="et-card-head-title">{{ __('Edit Transaction Details') }}</div>
                    <div class="et-card-head-sub">{{ __('Update the fields below and save your changes') }}</div>
                </div>
            </div>
            <span class="et-card-head-tag">
                <i class="fas fa-hashtag"></i>
                {{ str_pad($transaction->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                <span style="opacity:.4;">·</span>
                <i class="fas fa-clock"></i>
                {{ $transaction->updated_at ? \Carbon\Carbon::parse($transaction->updated_at)->diffForHumans() : __('Never') }}
            </span>
        </div>

        <form action="{{ route('inventory.update', $transaction->id) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')

            {{-- Hidden fields to track old values for balance recalculation --}}
            <input type="hidden" name="old_type" value="{{ $transaction->type }}">
            <input type="hidden" name="old_amount" value="{{ $transaction->amount }}">

            <div class="et-card-body">

                {{-- ============================================
                     TRANSACTION DETAILS
                ============================================ --}}
                <section class="et-section">
                    <div class="et-section-head">
                        <div class="et-section-icon"><i class="fas fa-info-circle"></i></div>
                        <div>
                            <h2 class="et-section-title">{{ __('Transaction Details') }}</h2>
                            <div class="et-section-sub">{{ __('Description, category, amount and date') }}</div>
                        </div>
                    </div>

                    <div class="et-grid">

                        {{-- DESCRIPTION --}}
                        <div class="et-field is-full">
                            <label class="et-label" for="description">
                                <i class="fas fa-tag"></i>
                                <span>{{ __('Description') }}</span>
                                <span class="et-req">*</span>
                            </label>
                            <div class="et-input-wrap">
                                <input type="text"
                                       id="description"
                                       name="description"
                                       class="et-input @error('description') is-invalid @enderror"
                                       value="{{ old('description', $transaction->description) }}"
                                       placeholder="{{ __('Enter transaction description') }}"
                                       required>
                                <i class="fas fa-tag et-input-icon"></i>
                            </div>
                            @error('description')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CATEGORY --}}
                        <div class="et-field">
                            <label class="et-label" for="category">
                                <i class="fas fa-folder"></i>
                                <span>{{ __('Category') }}</span>
                                <span class="et-req">*</span>
                            </label>
                            <div class="et-input-wrap">
                                <select id="category"
                                        name="category"
                                        class="et-select @error('category') is-invalid @enderror"
                                        required>
                                    @php
                                        $incomeCategories = [
                                            'Sunday Offering', 'Tithes', 'Special Donation',
                                            'Building Fund', 'Missions', 'Benevolence',
                                            'Thanksgiving', 'Rental Income', 'Other Income'
                                        ];
                                        $expenseCategories = [
                                            'Church Help', 'Outreach', 'Donation to Others',
                                            'Maintenance', 'Utilities', 'Staff Salary',
                                            'Equipment', 'Events', 'Other Expense'
                                        ];
                                        $allCategories = array_merge($incomeCategories, $expenseCategories);
                                        sort($allCategories);
                                    @endphp
                                    <option value="">— {{ __('Select Category') }} —</option>
                                    @foreach($allCategories as $cat)
                                        <option value="{{ $cat }}"
                                            {{ old('category', $transaction->category) == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-folder et-input-icon"></i>
                                <i class="fas fa-chevron-down et-select-caret"></i>
                            </div>
                            @error('category')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- AMOUNT --}}
                        <div class="et-field">
                            <label class="et-label" for="amount">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>{{ __('Amount') }} (₱)</span>
                                <span class="et-req">*</span>
                            </label>
                            <div class="et-amount-wrap @error('amount') is-invalid @enderror">
                                <span class="et-amount-symbol">₱</span>
                                <input type="number"
                                       id="amount"
                                       name="amount"
                                       step="0.01"
                                       class="et-amount-input"
                                       value="{{ old('amount', $transaction->amount) }}"
                                       placeholder="0.00"
                                       required>
                            </div>
                            @error('amount')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DATE --}}
                        <div class="et-field">
                            <label class="et-label" for="date">
                                <i class="fas fa-calendar"></i>
                                <span>{{ __('Date') }}</span>
                                <span class="et-req">*</span>
                            </label>
                            <div class="et-input-wrap">
                                <input type="date"
                                       id="date"
                                       name="date"
                                       class="et-input @error('date') is-invalid @enderror"
                                       value="{{ old('date', $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') : '') }}"
                                       required>
                                <i class="fas fa-calendar et-input-icon"></i>
                            </div>
                            @error('date')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TYPE --}}
                        <div class="et-field">
                            <label class="et-label" for="type">
                                <i class="fas fa-exchange-alt"></i>
                                <span>{{ __('Type') }}</span>
                                <span class="et-req">*</span>
                            </label>
                            <div class="et-type-row">
                                <div class="et-input-wrap">
                                    <select id="type"
                                            name="type"
                                            class="et-select @error('type') is-invalid @enderror"
                                            required>
                                        <option value="income"  {{ old('type', $transaction->type) == 'income'  ? 'selected' : '' }}>{{ __('Income') }}</option>
                                        <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>{{ __('Expense') }}</option>
                                    </select>
                                    <i class="fas fa-exchange-alt et-input-icon"></i>
                                    <i class="fas fa-chevron-down et-select-caret"></i>
                                </div>
                                <span id="typeDisplay" class="et-type-badge {{ $transaction->type }}">
                                    <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </div>
                            @error('type')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DONOR NAME (Income) --}}
                        <div id="donorGroup"
                             class="et-field"
                             style="{{ old('type', $transaction->type) == 'income' ? 'display:block;' : 'display:none;' }}">
                            <label class="et-label" for="donor_name">
                                <i class="fas fa-user"></i>
                                <span>{{ __('Donor Name') }}</span>
                            </label>
                            <div class="et-input-wrap">
                                <input type="text"
                                       id="donor_name"
                                       name="donor_name"
                                       class="et-input @error('donor_name') is-invalid @enderror"
                                       value="{{ old('donor_name', $transaction->donor_name) }}"
                                       placeholder="{{ __('Enter donor name') }}">
                                <i class="fas fa-user et-input-icon"></i>
                            </div>
                            @error('donor_name')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- RECIPIENT (Expense) --}}
                        <div id="recipientGroup"
                             class="et-field"
                             style="{{ old('type', $transaction->type) == 'expense' ? 'display:block;' : 'display:none;' }}">
                            <label class="et-label" for="recipient">
                                <i class="fas fa-user"></i>
                                <span>{{ __('Recipient / Beneficiary') }}</span>
                            </label>
                            <div class="et-input-wrap">
                                <input type="text"
                                       id="recipient"
                                       name="recipient"
                                       class="et-input @error('recipient') is-invalid @enderror"
                                       value="{{ old('recipient', $transaction->recipient) }}"
                                       placeholder="{{ __('Enter recipient name') }}">
                                <i class="fas fa-user et-input-icon"></i>
                            </div>
                            @error('recipient')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- REMARKS --}}
                        <div class="et-field is-full">
                            <label class="et-label" for="remarks">
                                <i class="fas fa-pen"></i>
                                <span>{{ __('Remarks / Notes') }}</span>
                            </label>
                            <div class="et-input-wrap">
                                <textarea id="remarks"
                                          name="remarks"
                                          class="et-textarea @error('remarks') is-invalid @enderror"
                                          rows="3"
                                          placeholder="{{ __('Enter additional notes...') }}">{{ old('remarks', $transaction->remarks) }}</textarea>
                            </div>
                            @error('remarks')
                                <div class="et-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </section>

                {{-- ============================================
                     FINANCIAL IMPACT
                ============================================ --}}
                <section class="et-section">
                    <div class="et-section-head">
                        <div class="et-section-icon"><i class="fas fa-wallet"></i></div>
                        <div>
                            <h2 class="et-section-title">{{ __('Financial Impact') }}</h2>
                            <div class="et-section-sub">{{ __('Summary of how this transaction affects the balance') }}</div>
                        </div>
                    </div>

                    <div class="et-impact">
                        <div class="et-impact-head">
                            <i class="fas fa-calculator"></i>
                            <span>{{ __('Balance Overview') }}</span>
                        </div>
                        <div class="et-impact-grid">
                            <div class="et-impact-item">
                                <p class="et-impact-label">{{ __('Current Transaction') }}</p>
                                <div class="et-impact-value {{ $transaction->type == 'income' ? 'is-green' : 'is-rose' }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="et-impact-item">
                                <p class="et-impact-label">{{ __('Balance Without This') }}</p>
                                <div class="et-impact-value is-primary">
                                    ₱{{ number_format($balance ?? 0, 2) }}
                                </div>
                            </div>
                            <div class="et-impact-item">
                                <p class="et-impact-label">{{ __('Total Transactions') }}</p>
                                <div class="et-impact-value is-default">
                                    {{ \App\Models\MoneyTransaction::where('church_id', $transaction->church_id)->count() }}
                                </div>
                            </div>
                        </div>
                        <div class="et-impact-hint">
                            <i class="fas fa-lightbulb"></i>
                            <span>{{ __('Changing the amount or type will automatically recalculate the church balance.') }}</span>
                        </div>
                    </div>
                </section>

            </div>

            {{-- ============================================
                 ACTIONS
            ============================================ --}}
            <div class="et-foot">
                {{-- ⭐ Cancel button now uses custom confirmation --}}
                <button type="button" class="et-btn et-btn-ghost" id="cancelBtn">
                    <i class="fas fa-times"></i>
                    <span>{{ __('Cancel') }}</span>
                </button>
                <div class="et-foot-right">
                    <button type="button" class="et-btn et-btn-rose" onclick="confirmDelete({{ $transaction->id }})">
                        <i class="fas fa-trash-alt"></i>
                        <span>{{ __('Delete') }}</span>
                    </button>
                    <button type="submit" class="et-btn et-btn-primary" id="updateBtn">
                        <i class="fas fa-check"></i>
                        <span>{{ __('Update Transaction') }}</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ============================================
        // FORM CHANGED TRACKING
        // ============================================
        let formChanged = false;
        let allowNavigation = false; // flag to bypass beforeunload

        const form = document.getElementById('editForm');
        const cancelBtn = document.getElementById('cancelBtn');
        const backBtn = document.getElementById('backBtn');
        const updateBtn = document.getElementById('updateBtn');

        const inventoryUrl = '{{ route("inventory.index") }}';

        if (form) {
            const inputs = form.querySelectorAll('input, select, textarea');

            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    formChanged = true;
                });
                if (input.type === 'text' || input.type === 'number' || input.tagName === 'TEXTAREA') {
                    input.addEventListener('input', function() {
                        formChanged = true;
                    });
                }
            });

            // ⭐ Only trigger browser warning when leaving the page via
            //    browser back/refresh/close, NOT via our own buttons
            window.addEventListener('beforeunload', function(e) {
                if (formChanged && !allowNavigation) {
                    e.preventDefault();
                    e.returnValue = '';
                    return '';
                }
            });

            form.addEventListener('submit', function() {
                formChanged = false;
                allowNavigation = true;
            });
        }

        // ============================================
        // ⭐ CUSTOM CANCEL CONFIRMATION
        // ============================================
        function navigateAway(url) {
            allowNavigation = true;              // bypass beforeunload
            window.location.href = url;
        }

        function showLeaveConfirm(onConfirm) {
            Swal.fire({
                title: 'Discard changes?',
                html: `
                    <div style="text-align:left; font-size:.86rem; line-height:1.55;">
                        <p style="margin:0 0 .6rem;">You have <strong>unsaved changes</strong> in this transaction.</p>
                        <p style="margin:0; color:#6b7280; font-size:.78rem;">
                            If you leave now, your edits will be lost.
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Save & Leave',
                denyButtonText: '<i class="fas fa-times"></i> Discard',
                cancelButtonText: 'Stay',
                confirmButtonColor: '#4f46e5',
                denyButtonColor: '#e11d48',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
                background: 'var(--card-bg)',
                color: 'var(--text-primary)',
                customClass: {
                    popup: 'swal-et-popup',
                    title: 'swal-et-title',
                    confirmButton: 'swal-et-confirm',
                    denyButton: 'swal-et-deny',
                    cancelButton: 'swal-et-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Save & Leave → submit the form
                    allowNavigation = true;
                    formChanged = false;
                    form.submit();
                } else if (result.isDenied) {
                    // Discard → leave without saving
                    onConfirm();
                }
                // Cancel → do nothing (stay)
            });
        }

        // Cancel button (footer)
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function() {
                if (formChanged) {
                    showLeaveConfirm(() => navigateAway(inventoryUrl));
                } else {
                    navigateAway(inventoryUrl);
                }
            });
        }

        // Back to Inventory button (header) — same behavior
        if (backBtn) {
            backBtn.addEventListener('click', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    showLeaveConfirm(() => navigateAway(inventoryUrl));
                }
            });
        }

        // ============================================
        // TYPE CHANGE HANDLER
        // ============================================
        const typeSelect = document.getElementById('type');
        const typeDisplay = document.getElementById('typeDisplay');
        const donorGroup = document.getElementById('donorGroup');
        const recipientGroup = document.getElementById('recipientGroup');
        const donorName = document.getElementById('donor_name');
        const recipient = document.getElementById('recipient');

        if (typeSelect) {
            typeSelect.addEventListener('change', function() {
                if (this.value === 'income') {
                    typeDisplay.className = 'et-type-badge income';
                    typeDisplay.innerHTML = '<i class="fas fa-arrow-down"></i> Income';
                    donorGroup.style.display = 'block';
                    recipientGroup.style.display = 'none';
                    if (recipient) recipient.value = '';
                } else {
                    typeDisplay.className = 'et-type-badge expense';
                    typeDisplay.innerHTML = '<i class="fas fa-arrow-up"></i> Expense';
                    donorGroup.style.display = 'none';
                    recipientGroup.style.display = 'block';
                    if (donorName) donorName.value = '';
                }
            });
        }

        // ============================================
        // DELETE CONFIRMATION
        // ============================================
        window.confirmDelete = function(id) {
            Swal.fire({
                title: 'Delete Transaction?',
                text: 'This action cannot be undone. All financial records will be updated.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    fetch(`/inventory/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            allowNavigation = true;
                            formChanged = false;
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message || 'Transaction deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false,
                                toast: true,
                                position: 'top-end'
                            });
                            setTimeout(() => {
                                window.location.href = inventoryUrl;
                            }, 500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to delete transaction.',
                                confirmButtonColor: '#EF4444',
                                background: 'var(--card-bg)',
                                color: 'var(--text-primary)'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        console.error('Delete error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonColor: '#EF4444',
                            background: 'var(--card-bg)',
                            color: 'var(--text-primary)'
                        });
                    });
                }
            });
        };

        // ============================================
        // INVALID FIELDS FOCUS
        // ============================================
        const invalidFields = document.querySelectorAll('.is-invalid');
        if (invalidFields.length > 0) {
            invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            invalidFields[0].focus();
        }

        // ============================================
        // CARD ENTRANCE ANIMATION
        // ============================================
        const card = document.querySelector('.et-card');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(14px)';
            requestAnimationFrame(() => {
                card.style.transition = 'opacity .5s cubic-bezier(0.4, 0, 0.2, 1), transform .5s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            });
        }
    });
</script>

<style>
    /* ⭐ SweetAlert custom styling for the leave confirmation */
    .swal-et-popup {
        border-radius: 16px !important;
        padding: 1.75rem 1.5rem !important;
        border: 1px solid var(--border-color, #e8eaf0) !important;
        box-shadow: 0 24px 60px -20px rgba(15, 23, 42, .4) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
    }

    .swal-et-popup .swal2-title {
        font-size: 1.15rem !important;
        font-weight: 800 !important;
        letter-spacing: -.02em !important;
        color: var(--text-primary, #0f172a) !important;
    }

    .swal-et-popup .swal2-icon {
        margin-top: 0 !important;
        margin-bottom: 1rem !important;
    }

    .swal-et-popup .swal2-html-container {
        margin: 0 0 1.15rem !important;
        color: var(--text-primary, #0f172a) !important;
    }

    .swal-et-popup .swal2-actions {
        gap: .5rem !important;
        width: 100% !important;
        justify-content: center !important;
        margin-top: .5rem !important;
    }

    .swal-et-popup .swal2-confirm,
    .swal-et-popup .swal2-deny,
    .swal-et-popup .swal2-cancel {
        border-radius: 11px !important;
        font-weight: 700 !important;
        font-size: .8rem !important;
        font-family: inherit !important;
        padding: .65rem 1.2rem !important;
        min-width: 130px !important;
        border: none !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: .4rem !important;
        transition: background .18s ease, transform .18s ease, box-shadow .18s ease !important;
    }

    .swal-et-popup .swal2-confirm:hover { transform: translateY(-1px) !important; }
    .swal-et-popup .swal2-deny:hover    { transform: translateY(-1px) !important; }
    .swal-et-popup .swal2-cancel:hover  { transform: translateY(-1px) !important; }

    .swal-et-popup .swal2-cancel {
        background: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #e2e8f0 !important;
    }

    [data-theme="dark"] .swal-et-popup .swal2-cancel {
        background: #2a2a3d !important;
        color: #f1f5f9 !important;
        border-color: #3a3a4d !important;
    }
</style>

@endsection