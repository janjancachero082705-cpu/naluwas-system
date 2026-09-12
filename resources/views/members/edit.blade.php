@extends('layouts.app')

@section('header')
    <span data-i18n="edit_member">{{ __("Edit Member") }}</span>
@endsection

@section('content')
<style>
    /* ==========================================================
       EDIT MEMBER — 2025 REDESIGN
       Flat · bordered · airy · Inter
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .em {
        --em-card: var(--card-bg, #ffffff);
        --em-border: var(--border-color, #e8eaf0);
        --em-text: var(--text-primary, #0f172a);
        --em-muted: var(--text-muted, #7c8494);
        --em-soft: var(--bg-tertiary, #f5f6fa);

        --em-primary: #4f46e5;
        --em-primary-soft: rgba(79, 70, 229, .08);
        --em-primary-ring: rgba(79, 70, 229, .18);

        --em-green: #059669;
        --em-green-soft: rgba(5, 150, 105, .10);
        --em-rose: #e11d48;
        --em-rose-soft: rgba(225, 29, 72, .09);
        --em-amber: #d97706;
        --em-amber-soft: rgba(217, 119, 6, .10);
        --em-violet: #7c3aed;
        --em-violet-soft: rgba(124, 58, 237, .10);

        --em-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --em-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --em-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--em-text);
        padding-bottom: 2rem;
        max-width: 980px;
        margin: 0 auto;
    }

    [data-theme="dark"] .em {
        --em-primary: #6366f1;
        --em-primary-soft: rgba(99, 102, 241, .16);
        --em-primary-ring: rgba(99, 102, 241, .28);
        --em-green: #34d399;
        --em-green-soft: rgba(16, 185, 129, .14);
        --em-rose: #fb7185;
        --em-rose-soft: rgba(244, 63, 94, .14);
        --em-amber: #fbbf24;
        --em-amber-soft: rgba(245, 158, 11, .14);
        --em-violet: #a78bfa;
        --em-violet-soft: rgba(139, 92, 246, .16);
        --em-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --em-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .em * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .em-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--em-border);
        margin-bottom: 1.5rem;
    }

    .em-head-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
    }

    .em-avatar {
        width: 60px; height: 60px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: .02em;
        background: var(--em-primary-soft);
        color: var(--em-primary);
        flex: 0 0 auto;
    }

    .em-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--em-muted);
        margin-bottom: .4rem;
    }

    .em-eyebrow .em-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--em-violet);
        box-shadow: 0 0 0 3px var(--em-violet-soft);
    }

    .em-title {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0;
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .em-title i { font-size: 1.05rem; color: var(--em-primary); }

    .em-sub {
        margin: .45rem 0 0;
        font-size: .8rem;
        color: var(--em-muted);
        line-height: 1.5;
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .em-sub .em-sep { opacity: .4; }

    .em-head-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .em-btn {
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

    .em-btn-primary {
        background: var(--em-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .em-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }
    .em-btn-primary:active { transform: translateY(0); }

    .em-btn-ghost {
        background: var(--em-card);
        color: var(--em-text);
        border-color: var(--em-border);
    }
    .em-btn-ghost:hover {
        background: var(--em-soft);
        color: var(--em-text);
        transform: translateY(-1px);
    }

    /* ---------------- CARD ---------------- */
    .em-card {
        background: var(--em-card);
        border: 1px solid var(--em-border);
        border-radius: var(--em-radius);
        overflow: hidden;
        box-shadow: var(--em-shadow-sm);
    }

    .em-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1rem 1.35rem;
        border-bottom: 1px solid var(--em-border);
        background: var(--em-soft);
    }

    .em-card-head-left {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .em-card-head-icon {
        width: 36px; height: 36px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        font-size: .85rem;
        background: var(--em-primary-soft);
        color: var(--em-primary);
        flex: 0 0 auto;
    }

    .em-card-head-title {
        font-size: .92rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
    }

    .em-card-head-sub {
        font-size: .7rem;
        color: var(--em-muted);
        margin-top: .15rem;
    }

    .em-updated {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .28rem .7rem;
        border-radius: 20px;
        border: 1px solid var(--em-border);
        background: var(--em-card);
        font-size: .68rem;
        font-weight: 600;
        color: var(--em-muted);
        white-space: nowrap;
    }

    .em-updated i { font-size: .6rem; }

    .em-card-body {
        padding: 1.5rem 1.35rem;
    }

    /* ---------------- SECTION ---------------- */
    .em-section + .em-section {
        margin-top: 2rem;
        padding-top: 1.75rem;
        border-top: 1px solid var(--em-border);
    }

    .em-section-head {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin-bottom: 1.15rem;
    }

    .em-section-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: .78rem;
        flex: 0 0 auto;
    }

    .em-section-icon.primary { background: var(--em-primary-soft); color: var(--em-primary); }
    .em-section-icon.violet  { background: var(--em-violet-soft);  color: var(--em-violet); }

    .em-section-title {
        font-size: .95rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        margin: 0;
    }

    .em-section-sub {
        font-size: .7rem;
        color: var(--em-muted);
        margin-top: .1rem;
    }

    /* ---------------- FORM ---------------- */
    .em-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.15rem 1.25rem;
    }

    .em-field { min-width: 0; }
    .em-field.is-full { grid-column: 1 / -1; }

    .em-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--em-muted);
        margin-bottom: .45rem;
    }

    .em-label i {
        font-size: .62rem;
        color: var(--em-primary);
        width: 14px;
        text-align: center;
    }

    .em-label .em-req { color: var(--em-rose); font-size: .8rem; line-height: 1; }

    .em-input-wrap { position: relative; }

    .em-input-wrap > .em-input-icon {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .72rem;
        color: var(--em-muted);
        pointer-events: none;
        z-index: 2;
        transition: color .18s ease;
    }

    .em-input,
    .em-select {
        width: 100%;
        padding: .68rem .9rem .68rem 2.35rem;
        border-radius: 11px;
        border: 1px solid var(--em-border);
        background: var(--em-soft);
        color: var(--em-text);
        font-size: .84rem;
        font-family: inherit;
        line-height: 1.35;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .em-input::placeholder { color: var(--em-muted); opacity: .8; }

    .em-input:focus,
    .em-select:focus {
        outline: none;
        background: var(--em-card);
        border-color: var(--em-primary);
        box-shadow: 0 0 0 3px var(--em-primary-ring);
    }

    .em-input-wrap:focus-within > .em-input-icon { color: var(--em-primary); }

    .em-input.is-invalid,
    .em-select.is-invalid { border-color: var(--em-rose); }

    .em-input.is-invalid:focus,
    .em-select.is-invalid:focus {
        box-shadow: 0 0 0 3px var(--em-rose-soft);
    }

    .em-select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 2.4rem;
        cursor: pointer;
    }

    .em-select option { background: var(--em-card); color: var(--em-text); }

    .em-select-caret {
        position: absolute;
        right: .95rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .58rem;
        color: var(--em-muted);
        pointer-events: none;
        z-index: 2;
    }

    /* current value chip */
    .em-current {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        margin-top: .45rem;
        padding: .25rem .6rem;
        border-radius: 20px;
        font-size: .66rem;
        font-weight: 600;
        background: var(--em-soft);
        color: var(--em-muted);
        border: 1px solid var(--em-border);
    }

    .em-current i { font-size: .55rem; }

    .em-current strong { color: var(--em-text); font-weight: 700; }

    /* Error */
    .em-error {
        display: flex;
        align-items: center;
        gap: .35rem;
        margin-top: .35rem;
        font-size: .7rem;
        color: var(--em-rose);
        font-weight: 500;
    }

    .em-error i { font-size: .6rem; }

    /* ---------------- MULTI-SELECT ---------------- */
    .em-multi {
        width: 100%;
        min-height: 130px;
        padding: .55rem;
        border-radius: 11px;
        border: 1px solid var(--em-border);
        background: var(--em-soft);
        color: var(--em-text);
        font-size: .82rem;
        font-family: inherit;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .em-multi:focus {
        outline: none;
        background: var(--em-card);
        border-color: var(--em-primary);
        box-shadow: 0 0 0 3px var(--em-primary-ring);
    }

    .em-multi.is-invalid { border-color: var(--em-rose); }

    .em-multi option {
        padding: .38rem .6rem;
        border-radius: 7px;
        margin-bottom: 2px;
        cursor: pointer;
    }

    .em-multi option:checked {
        background: var(--em-primary) linear-gradient(0deg, var(--em-primary) 0%, var(--em-primary) 100%);
        color: #fff;
    }

    .em-hint {
        display: flex;
        align-items: center;
        gap: .35rem;
        margin-top: .45rem;
        font-size: .7rem;
        color: var(--em-muted);
    }

    .em-hint i { font-size: .6rem; color: var(--em-primary); }

    .em-hint kbd {
        display: inline-block;
        padding: .05rem .35rem;
        border-radius: 5px;
        border: 1px solid var(--em-border);
        background: var(--em-card);
        font-family: inherit;
        font-size: .65rem;
        font-weight: 600;
        color: var(--em-text);
    }

    /* ---------------- CHOIR BLOCK ---------------- */
    .em-choir {
        background: var(--em-violet-soft);
        border: 1px solid transparent;
        border-radius: 14px;
        padding: 1.15rem 1.15rem .4rem;
    }

    .em-choir .em-label i { color: var(--em-violet); }

    .em-choir .em-input,
    .em-choir .em-select {
        background: var(--em-card);
    }

    .em-choir .em-input:focus,
    .em-choir .em-select:focus {
        box-shadow: 0 0 0 3px rgba(124, 58, 237, .18);
        border-color: var(--em-violet);
    }

    .em-choir .em-input-wrap:focus-within > .em-input-icon { color: var(--em-violet); }

    /* ---------------- FOOTER ---------------- */
    .em-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .7rem;
        flex-wrap: wrap;
        padding: 1.1rem 1.35rem;
        border-top: 1px solid var(--em-border);
        background: var(--em-soft);
    }

    .em-foot-right {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 768px) {
        .em-head { flex-direction: column; align-items: flex-start; }
        .em-head-left { width: 100%; }
        .em-head-actions { width: 100%; }
        .em-head-actions .em-btn { flex: 1; justify-content: center; }

        .em-avatar { width: 50px; height: 50px; border-radius: 15px; font-size: 1.05rem; }
        .em-title { font-size: 1.2rem; }

        .em-grid { grid-template-columns: 1fr; }
        .em-card-body { padding: 1.15rem 1rem; }
        .em-card-head { padding: .9rem 1rem; }

        .em-foot { flex-direction: column-reverse; align-items: stretch; padding: 1rem; }
        .em-foot-right { width: 100%; }
        .em-foot .em-btn { width: 100%; flex: 1; justify-content: center; }
    }

    @media (max-width: 480px) {
        .em-card-body { padding: 1rem .85rem; }
        .em-choir { padding: 1rem .85rem .3rem; }
    }
</style>

<div class="em container-fluid px-0">

    {{-- ============================================
         HEADER
    ============================================ --}}
    <header class="em-head">
        <div class="em-head-left">
            <div class="em-avatar">
                {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <div class="em-eyebrow">
                    <span class="em-dot"></span>
                    <span data-i18n="member_directory">{{ __("Member Directory") }}</span>
                </div>
                <h1 class="em-title">
                    <i class="fas fa-pen-to-square"></i>
                    <span data-i18n="edit_member">{{ __("Edit Member") }}</span>
                </h1>
                <p class="em-sub">
                    <span>{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</span>
                    <span class="em-sep">·</span>
                    <span><i class="fas fa-hashtag" style="font-size:.65rem;"></i> {{ str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT) }}</span>
                </p>
            </div>
        </div>

        <div class="em-head-actions">
            <a href="{{ route('members.show', $member->id) }}" class="em-btn em-btn-ghost">
                <i class="fas fa-eye"></i>
                <span data-i18n="view_profile">{{ __("View Profile") }}</span>
            </a>
            <a href="{{ route('members.index') }}" class="em-btn em-btn-ghost">
                <i class="fas fa-arrow-left"></i>
                <span data-i18n="back">{{ __("Back") }}</span>
            </a>
        </div>
    </header>

    {{-- ============================================
         CARD
    ============================================ --}}
    <div class="em-card">

        <div class="em-card-head">
            <div class="em-card-head-left">
                <div class="em-card-head-icon"><i class="fas fa-id-card"></i></div>
                <div>
                    <div class="em-card-head-title" data-i18n="edit_member_information">
                        {{ __("Edit Member Information") }}
                    </div>
                    <div class="em-card-head-sub" data-i18n="fields_marked_required">
                        {{ __("Fields marked with * are required") }}
                    </div>
                </div>
            </div>

            <span class="em-updated">
                <i class="fas fa-clock"></i>
                <span data-i18n="last_updated">{{ __("Last updated:") }}</span>
                {{ $member->updated_at ? \Carbon\Carbon::parse($member->updated_at)->diffForHumans() : __("Never") }}
            </span>
        </div>

        <form action="{{ route('members.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="em-card-body">

                {{-- ============================================
                     PERSONAL INFORMATION
                ============================================ --}}
                <section class="em-section">
                    <div class="em-section-head">
                        <div class="em-section-icon primary"><i class="fas fa-user-circle"></i></div>
                        <div>
                            <h2 class="em-section-title" data-i18n="personal_information">
                                {{ __("Personal Information") }}
                            </h2>
                            <div class="em-section-sub" data-i18n="personal_information_desc">
                                {{ __("Basic details about this member") }}
                            </div>
                        </div>
                    </div>

                    <div class="em-grid">

                        {{-- First Name --}}
                        <div class="em-field">
                            <label class="em-label" for="first_name">
                                <i class="fas fa-user"></i>
                                <span data-i18n="first_name">{{ __("First Name") }}</span>
                                <span class="em-req">*</span>
                            </label>
                            <div class="em-input-wrap">
                                <input type="text"
                                       id="first_name" name="first_name"
                                       class="em-input @error('first_name') is-invalid @enderror"
                                       value="{{ old('first_name', $member->first_name) }}"
                                       placeholder="{{ __('Enter first name') }}" required
                                       data-i18n-placeholder="Enter first name">
                                <i class="fas fa-user em-input-icon"></i>
                            </div>
                            @error('first_name')
                                <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Last Name --}}
                        <div class="em-field">
                            <label class="em-label" for="last_name">
                                <i class="fas fa-user"></i>
                                <span data-i18n="last_name">{{ __("Last Name") }}</span>
                                <span class="em-req">*</span>
                            </label>
                            <div class="em-input-wrap">
                                <input type="text"
                                       id="last_name" name="last_name"
                                       class="em-input @error('last_name') is-invalid @enderror"
                                       value="{{ old('last_name', $member->last_name) }}"
                                       placeholder="{{ __('Enter last name') }}" required
                                       data-i18n-placeholder="Enter last name">
                                <i class="fas fa-user em-input-icon"></i>
                            </div>
                            @error('last_name')
                                <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Birthday --}}
                        <div class="em-field">
                            <label class="em-label" for="birthday">
                                <i class="fas fa-birthday-cake"></i>
                                <span data-i18n="birthday">{{ __("Birthday") }}</span>
                            </label>
                            <div class="em-input-wrap">
                                <input type="date"
                                       id="birthday" name="birthday"
                                       class="em-input @error('birthday') is-invalid @enderror"
                                       value="{{ old('birthday', $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('Y-m-d') : '') }}">
                                <i class="fas fa-calendar-alt em-input-icon"></i>
                            </div>
                            @error('birthday')
                                <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div class="em-field">
                            <label class="em-label" for="gender">
                                <i class="fas fa-venus-mars"></i>
                                <span data-i18n="gender">{{ __("Gender") }}</span>
                            </label>
                            <div class="em-input-wrap">
                                <select id="gender" name="gender"
                                        class="em-select @error('gender') is-invalid @enderror">
                                    <option value="">— {{ __("Select Gender") }} —</option>
                                    <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>
                                        {{ __("Male") }}
                                    </option>
                                    <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>
                                        {{ __("Female") }}
                                    </option>
                                </select>
                                <i class="fas fa-venus-mars em-input-icon"></i>
                                <i class="fas fa-chevron-down em-select-caret"></i>
                            </div>
                            @error('gender')
                                <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                            <div class="em-current">
                                <i class="fas fa-database"></i>
                                <span data-i18n="current_db_value">{{ __("Current:") }}</span>
                                <strong>{{ $member->gender ?? '—' }}</strong>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="em-field">
                            <label class="em-label" for="phone">
                                <i class="fas fa-phone"></i>
                                <span data-i18n="phone_number">{{ __("Phone Number") }}</span>
                            </label>
                            <div class="em-input-wrap">
                                <input type="text"
                                       id="phone" name="phone"
                                       class="em-input @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $member->phone) }}"
                                       placeholder="{{ __('Enter phone number') }}"
                                       data-i18n-placeholder="Enter phone number">
                                <i class="fas fa-phone em-input-icon"></i>
                            </div>
                            @error('phone')
                                <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="em-field">
                            <label class="em-label" for="email">
                                <i class="fas fa-envelope"></i>
                                <span data-i18n="email_address">{{ __("Email Address") }}</span>
                            </label>
                            <div class="em-input-wrap">
                                <input type="email"
                                       id="email" name="email"
                                       class="em-input @error('email') is-invalid @enderror"
                                       value="{{ old('email', $member->email) }}"
                                       placeholder="{{ __('Enter email address') }}"
                                       data-i18n-placeholder="Enter email address">
                                <i class="fas fa-envelope em-input-icon"></i>
                            </div>
                            @error('email')
                                <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="em-field is-full">
                            <label class="em-label" for="address">
                                <i class="fas fa-map-marker-alt"></i>
                                <span data-i18n="address">{{ __("Address") }}</span>
                            </label>
                            <div class="em-input-wrap">
                                <input type="text"
                                       id="address" name="address"
                                       class="em-input @error('address') is-invalid @enderror"
                                       value="{{ old('address', $member->address) }}"
                                       placeholder="{{ __('Enter address') }}"
                                       data-i18n-placeholder="Enter address">
                                <i class="fas fa-home em-input-icon"></i>
                            </div>
                            @error('address')
                                <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </section>

                {{-- ============================================
                     ROLES
                ============================================ --}}
                <section class="em-section">
                    <div class="em-section-head">
                        <div class="em-section-icon primary"><i class="fas fa-tags"></i></div>
                        <div>
                            <h2 class="em-section-title" data-i18n="roles_responsibilities">
                                {{ __("Roles & Responsibilities") }}
                            </h2>
                            <div class="em-section-sub" data-i18n="roles_responsibilities_desc">
                                {{ __("Assign ministries this member belongs to") }}
                            </div>
                        </div>
                    </div>

                    <div class="em-field">
                        <label class="em-label" for="roles">
                            <i class="fas fa-shield-alt"></i>
                            <span data-i18n="assign_roles">{{ __("Assign Roles") }}</span>
                        </label>
                        <select id="roles" name="roles[]"
                                class="em-multi @error('roles') is-invalid @enderror" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, old('roles', $memberRoles ?? [])) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="em-hint">
                            <i class="fas fa-circle-info"></i>
                            <span data-i18n="select_multiple_hint">{{ __("Hold") }}</span>
                            <kbd>Ctrl</kbd>
                            <span data-i18n="windows_hint">{{ __("(Windows) or") }}</span>
                            <kbd>⌘ Cmd</kbd>
                            <span data-i18n="mac_hint">{{ __("(Mac) to select multiple roles") }}</span>
                        </div>
                        @error('roles')
                            <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </section>

                {{-- ============================================
                     CHOIR
                ============================================ --}}
                <section class="em-section">
                    <div class="em-section-head">
                        <div class="em-section-icon violet"><i class="fas fa-music"></i></div>
                        <div>
                            <h2 class="em-section-title" data-i18n="choir_information">
                                {{ __("Choir Information") }}
                            </h2>
                            <div class="em-section-sub" data-i18n="choir_information_desc">
                                {{ __("Optional — assign a choir group and role") }}
                            </div>
                        </div>
                    </div>

                    <div class="em-choir">
                        <div class="em-grid">

                            {{-- Choir Group --}}
                            <div class="em-field">
                                <label class="em-label" for="choir_group_id">
                                    <i class="fas fa-layer-group"></i>
                                    <span data-i18n="choir_group">{{ __("Choir Group") }}</span>
                                </label>
                                <div class="em-input-wrap">
                                    <select id="choir_group_id" name="choir_group_id"
                                            class="em-select @error('choir_group_id') is-invalid @enderror">
                                        <option value="">— {{ __("No Choir Group") }} —</option>
                                        @foreach($choirGroups ?? [] as $group)
                                            <option value="{{ $group->id }}"
                                                {{ old('choir_group_id', $member->choir_group_id) == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fas fa-layer-group em-input-icon"></i>
                                    <i class="fas fa-chevron-down em-select-caret"></i>
                                </div>
                                @error('choir_group_id')
                                    <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Choir Role --}}
                            <div class="em-field">
                                <label class="em-label" for="choir_role">
                                    <i class="fas fa-microphone-alt"></i>
                                    <span data-i18n="choir_role">{{ __("Choir Role") }}</span>
                                </label>
                                <div class="em-input-wrap">
                                    <select id="choir_role" name="choir_role"
                                            class="em-select @error('choir_role') is-invalid @enderror">
                                        <option value="">— {{ __("No Choir Role") }} —</option>
                                        <option value="Singer"    {{ old('choir_role', $member->choir_role) == 'Singer'    ? 'selected' : '' }}>{{ __("Singer") }}</option>
                                        <option value="Guitarist" {{ old('choir_role', $member->choir_role) == 'Guitarist' ? 'selected' : '' }}>{{ __("Guitarist") }}</option>
                                        <option value="Bassist"   {{ old('choir_role', $member->choir_role) == 'Bassist'   ? 'selected' : '' }}>{{ __("Bassist") }}</option>
                                        <option value="Drummer"   {{ old('choir_role', $member->choir_role) == 'Drummer'   ? 'selected' : '' }}>{{ __("Drummer") }}</option>
                                    </select>
                                    <i class="fas fa-microphone-alt em-input-icon"></i>
                                    <i class="fas fa-chevron-down em-select-caret"></i>
                                </div>
                                @error('choir_role')
                                    <div class="em-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </section>

            </div>

            {{-- Actions --}}
            <div class="em-foot">
                <a href="{{ route('members.index') }}" class="em-btn em-btn-ghost">
                    <i class="fas fa-times"></i>
                    <span data-i18n="cancel">{{ __("Cancel") }}</span>
                </a>
                <div class="em-foot-right">
                    <a href="{{ route('members.show', $member->id) }}" class="em-btn em-btn-ghost">
                        <i class="fas fa-eye"></i>
                        <span data-i18n="view_profile">{{ __("View Profile") }}</span>
                    </a>
                    <button type="submit" class="em-btn em-btn-primary">
                        <i class="fas fa-check"></i>
                        <span data-i18n="update_member">{{ __("Update Member") }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    /* ============================================
       UNSAVED-CHANGES GUARD + SCROLL TO FIRST ERROR
    ============================================ */
    document.addEventListener('DOMContentLoaded', function () {
        // Scroll to first invalid field
        const invalidFields = document.querySelectorAll('.is-invalid');
        if (invalidFields.length > 0) {
            invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            invalidFields[0].focus();
        }

        // Unsaved-changes guard
        let formChanged = false;
        const form = document.querySelector('.em form');
        if (!form) return;

        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', function () { formChanged = true; });
        });

        window.addEventListener('beforeunload', function (e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = window.t
                    ? window.t('unsaved_changes', 'You have unsaved changes. Are you sure you want to leave?')
                    : 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });

        form.addEventListener('submit', function () { formChanged = false; });

        // Gentle card entrance
        const card = document.querySelector('.em-card');
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

    /* ============================================
       LANGUAGE CHANGE
    ============================================ */
    window.addEventListener('localeChanged', function (e) {
        if (typeof window.applyTranslations === 'function') {
            window.applyTranslations();
        }
        console.log('[Members Edit] Locale changed to:', e.detail.locale);
    });
</script>
@endsection