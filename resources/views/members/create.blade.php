@extends('layouts.app')

@section('header')
    <span data-i18n="add_new_member">{{ __("Add New Member") }}</span>
@endsection

@section('content')
<style>
    /* ==========================================================
       ADD MEMBER — 2025 REDESIGN
       Flat · bordered · airy · Inter
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .am {
        --am-card: var(--card-bg, #ffffff);
        --am-border: var(--border-color, #e8eaf0);
        --am-text: var(--text-primary, #0f172a);
        --am-muted: var(--text-muted, #7c8494);
        --am-soft: var(--bg-tertiary, #f5f6fa);

        --am-primary: #4f46e5;
        --am-primary-soft: rgba(79, 70, 229, .08);
        --am-primary-ring: rgba(79, 70, 229, .18);

        --am-green: #059669;
        --am-green-soft: rgba(5, 150, 105, .10);
        --am-rose: #e11d48;
        --am-rose-soft: rgba(225, 29, 72, .09);
        --am-amber: #d97706;
        --am-amber-soft: rgba(217, 119, 6, .10);

        --am-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --am-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --am-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--am-text);
        padding-bottom: 2rem;
        max-width: 900px;
        margin: 0 auto;
    }

    [data-theme="dark"] .am {
        --am-primary: #6366f1;
        --am-primary-soft: rgba(99, 102, 241, .16);
        --am-primary-ring: rgba(99, 102, 241, .28);
        --am-green: #34d399;
        --am-green-soft: rgba(16, 185, 129, .14);
        --am-rose: #fb7185;
        --am-rose-soft: rgba(244, 63, 94, .14);
        --am-amber: #fbbf24;
        --am-amber-soft: rgba(245, 158, 11, .14);
        --am-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --am-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .am * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .am-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--am-border);
        margin-bottom: 1.5rem;
    }

    .am-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--am-muted);
        margin-bottom: .55rem;
    }

    .am-eyebrow .am-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--am-green);
        box-shadow: 0 0 0 3px var(--am-green-soft);
    }

    .am-title {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin: 0;
        font-size: 1.6rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .am-title i { font-size: 1.2rem; color: var(--am-primary); }

    .am-sub {
        margin: .5rem 0 0;
        font-size: .84rem;
        color: var(--am-muted);
        max-width: 62ch;
        line-height: 1.5;
    }

    /* ---------------- CARD ---------------- */
    .am-card {
        background: var(--am-card);
        border: 1px solid var(--am-border);
        border-radius: var(--am-radius);
        overflow: hidden;
        box-shadow: var(--am-shadow-sm);
    }

    .am-card-head {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.35rem;
        border-bottom: 1px solid var(--am-border);
        background: var(--am-soft);
    }

    .am-card-head-icon {
        width: 36px; height: 36px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        font-size: .85rem;
        background: var(--am-primary-soft);
        color: var(--am-primary);
        flex: 0 0 auto;
    }

    .am-card-head-title {
        font-size: .92rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
    }

    .am-card-head-sub {
        font-size: .72rem;
        color: var(--am-muted);
        margin-top: .15rem;
    }

    .am-card-body {
        padding: 1.5rem 1.35rem;
    }

    /* ---------------- FORM ---------------- */
    .am-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.15rem 1.25rem;
    }

    .am-field { min-width: 0; }
    .am-field.is-full { grid-column: 1 / -1; }

    .am-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--am-muted);
        margin-bottom: .45rem;
    }

    .am-label i {
        font-size: .62rem;
        color: var(--am-primary);
        width: 14px;
        text-align: center;
    }

    .am-label .am-req {
        color: var(--am-rose);
        font-size: .8rem;
        line-height: 1;
    }

    .am-label .am-opt {
        font-size: .6rem;
        font-weight: 500;
        letter-spacing: .04em;
        text-transform: none;
        color: var(--am-muted);
        opacity: .8;
    }

    .am-input-wrap { position: relative; }

    .am-input-wrap > .am-input-icon {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .72rem;
        color: var(--am-muted);
        pointer-events: none;
        z-index: 2;
        transition: color .18s ease;
    }

    .am-input,
    .am-select {
        width: 100%;
        padding: .68rem .9rem .68rem 2.35rem;
        border-radius: 11px;
        border: 1px solid var(--am-border);
        background: var(--am-soft);
        color: var(--am-text);
        font-size: .84rem;
        font-family: inherit;
        line-height: 1.35;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .am-input::placeholder { color: var(--am-muted); opacity: .8; }

    .am-input:focus,
    .am-select:focus {
        outline: none;
        background: var(--am-card);
        border-color: var(--am-primary);
        box-shadow: 0 0 0 3px var(--am-primary-ring);
    }

    .am-input-wrap:focus-within > .am-input-icon { color: var(--am-primary); }

    .am-input.is-invalid,
    .am-select.is-invalid {
        border-color: var(--am-rose);
    }

    .am-input.is-invalid:focus,
    .am-select.is-invalid:focus {
        box-shadow: 0 0 0 3px var(--am-rose-soft);
    }

    .am-select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 2.4rem;
        cursor: pointer;
    }

    .am-select option { background: var(--am-card); color: var(--am-text); }

    .am-select-caret {
        position: absolute;
        right: .95rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .58rem;
        color: var(--am-muted);
        pointer-events: none;
        z-index: 2;
    }

    /* Gender live preview chip */
    .am-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        margin-top: .45rem;
        padding: .25rem .6rem;
        border-radius: 20px;
        font-size: .66rem;
        font-weight: 600;
        background: var(--am-green-soft);
        color: var(--am-green);
        border: 1px solid transparent;
        transition: background .2s ease, color .2s ease;
    }

    .am-chip i { font-size: .55rem; }

    /* ---------------- ROLES ---------------- */
    .am-roles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: .55rem;
        margin-top: .35rem;
    }

    .am-role {
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .6rem .8rem;
        border-radius: 11px;
        border: 1px solid var(--am-border);
        background: var(--am-soft);
        cursor: pointer;
        transition: background .18s ease, border-color .18s ease, transform .18s ease;
        position: relative;
        user-select: none;
    }

    .am-role:hover {
        border-color: var(--am-primary);
        background: var(--am-primary-soft);
        transform: translateY(-1px);
    }

    .am-role input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .am-role-box {
        width: 18px; height: 18px;
        border-radius: 5px;
        border: 1.5px solid var(--am-border);
        background: var(--am-card);
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        transition: background .18s ease, border-color .18s ease;
    }

    .am-role-box i {
        font-size: .55rem;
        color: #fff;
        opacity: 0;
        transform: scale(.6);
        transition: opacity .18s ease, transform .18s ease;
    }

    .am-role-text {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .78rem;
        font-weight: 500;
        color: var(--am-text);
        min-width: 0;
    }

    .am-role-text i {
        font-size: .68rem;
        color: var(--am-muted);
        width: 16px;
        text-align: center;
        transition: color .18s ease;
        flex: 0 0 auto;
    }

    .am-role-text span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Checked state */
    .am-role:has(input:checked) {
        border-color: var(--am-primary);
        background: var(--am-primary-soft);
    }

    .am-role:has(input:checked) .am-role-box {
        background: var(--am-primary);
        border-color: var(--am-primary);
    }

    .am-role:has(input:checked) .am-role-box i {
        opacity: 1;
        transform: scale(1);
    }

    .am-role:has(input:checked) .am-role-text i {
        color: var(--am-primary);
    }

    /* Choir info note */
    .am-note {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        margin-top: .9rem;
        padding: .75rem .95rem;
        border-radius: 11px;
        background: var(--am-amber-soft);
        font-size: .75rem;
        color: var(--am-amber);
        line-height: 1.5;
    }

    .am-note i {
        font-size: .85rem;
        flex: 0 0 auto;
        margin-top: 1px;
    }

    .am-note strong { font-weight: 700; }

    /* Errors */
    .am-error {
        display: flex;
        align-items: center;
        gap: .35rem;
        margin-top: .35rem;
        font-size: .7rem;
        color: var(--am-rose);
        font-weight: 500;
    }

    .am-error i { font-size: .6rem; }

    /* ---------------- FOOTER ---------------- */
    .am-foot {
        display: flex;
        gap: .7rem;
        padding: 1.1rem 1.35rem;
        border-top: 1px solid var(--am-border);
        background: var(--am-soft);
    }

    .am-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .7rem 1.3rem;
        border-radius: 11px;
        font-size: .82rem;
        font-weight: 600;
        font-family: inherit;
        line-height: 1.2;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: background .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease;
    }

    .am-btn-ghost {
        background: var(--am-card);
        color: var(--am-text);
        border-color: var(--am-border);
        flex: 1;
    }

    .am-btn-ghost:hover {
        background: var(--am-soft);
        color: var(--am-text);
        transform: translateY(-1px);
    }

    .am-btn-primary {
        background: var(--am-primary);
        color: #fff;
        flex: 2;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }

    .am-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .am-btn-primary:active { transform: translateY(0); }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 768px) {
        .am-grid { grid-template-columns: 1fr; }
        .am-title { font-size: 1.3rem; }
        .am-sub { font-size: .78rem; }
        .am-card-body { padding: 1.15rem 1rem; }
        .am-card-head { padding: .9rem 1rem; }
        .am-foot { flex-direction: column-reverse; padding: 1rem; }
        .am-btn { width: 100%; flex: 1; }
        .am-roles-grid { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 480px) {
        .am-head { flex-direction: column; align-items: flex-start; }
        .am-roles-grid { grid-template-columns: 1fr; }
        .am-card-body { padding: 1rem .85rem; }
    }
</style>

<div class="am container-fluid px-0">

    {{-- ============================================
         HEADER
    ============================================ --}}
    <header class="am-head">
        <div>
            <div class="am-eyebrow">
                <span class="am-dot"></span>
                <span data-i18n="member_directory">{{ __("Member Directory") }}</span>
            </div>
            <h1 class="am-title">
                <i class="fas fa-user-plus"></i>
                <span data-i18n="add_new_member">{{ __("Add New Member") }}</span>
            </h1>
            <p class="am-sub" data-i18n="add_member_desc">
                {{ __("Add a new member to your church family") }}
            </p>
        </div>
    </header>

    {{-- ============================================
         FORM CARD
    ============================================ --}}
    <div class="am-card">
        <div class="am-card-head">
            <div class="am-card-head-icon"><i class="fas fa-id-card"></i></div>
            <div>
                <div class="am-card-head-title" data-i18n="personal_information">
                    {{ __("Personal Information") }}
                </div>
                <div class="am-card-head-sub" data-i18n="fill_required_fields">
                    {{ __("Fields marked with * are required") }}
                </div>
            </div>
        </div>

        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            <div class="am-card-body">
                <div class="am-grid">

                    {{-- First Name --}}
                    <div class="am-field">
                        <label for="first_name" class="am-label">
                            <i class="fas fa-user"></i>
                            <span data-i18n="first_name">{{ __("First Name") }}</span>
                            <span class="am-req">*</span>
                        </label>
                        <div class="am-input-wrap">
                            <input type="text"
                                   class="am-input @error('first_name') is-invalid @enderror"
                                   id="first_name" name="first_name"
                                   placeholder="{{ __('Enter first name') }}"
                                   value="{{ old('first_name') }}" required
                                   data-i18n-placeholder="Enter first name">
                            <i class="fas fa-user am-input-icon"></i>
                        </div>
                        @error('first_name')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="am-field">
                        <label for="last_name" class="am-label">
                            <i class="fas fa-user"></i>
                            <span data-i18n="last_name">{{ __("Last Name") }}</span>
                            <span class="am-req">*</span>
                        </label>
                        <div class="am-input-wrap">
                            <input type="text"
                                   class="am-input @error('last_name') is-invalid @enderror"
                                   id="last_name" name="last_name"
                                   placeholder="{{ __('Enter last name') }}"
                                   value="{{ old('last_name') }}" required
                                   data-i18n-placeholder="Enter last name">
                            <i class="fas fa-user am-input-icon"></i>
                        </div>
                        @error('last_name')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div class="am-field">
                        <label for="gender" class="am-label">
                            <i class="fas fa-venus-mars"></i>
                            <span data-i18n="gender">{{ __("Gender") }}</span>
                        </label>
                        <div class="am-input-wrap">
                            <select class="am-select @error('gender') is-invalid @enderror"
                                    id="gender" name="gender">
                                <option value="">— {{ __("Select Gender") }} —</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                    {{ __("Male") }}
                                </option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                    {{ __("Female") }}
                                </option>
                            </select>
                            <i class="fas fa-venus-mars am-input-icon"></i>
                            <i class="fas fa-chevron-down am-select-caret"></i>
                        </div>
                        @error('gender')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                        <div class="am-chip" id="genderChip">
                            <i class="fas fa-circle-info"></i>
                            <span data-i18n="selected_label">{{ __("Selected:") }}</span>
                            <strong id="genderDisplay">{{ __("Not selected") }}</strong>
                        </div>
                    </div>

                    {{-- Birthday --}}
                    <div class="am-field">
                        <label for="birthday" class="am-label">
                            <i class="fas fa-birthday-cake"></i>
                            <span data-i18n="birthday">{{ __("Birthday") }}</span>
                        </label>
                        <div class="am-input-wrap">
                            <input type="date"
                                   class="am-input @error('birthday') is-invalid @enderror"
                                   id="birthday" name="birthday"
                                   value="{{ old('birthday') }}">
                            <i class="fas fa-calendar-alt am-input-icon"></i>
                        </div>
                        @error('birthday')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="am-field">
                        <label for="phone" class="am-label">
                            <i class="fas fa-phone"></i>
                            <span data-i18n="phone">{{ __("Phone") }}</span>
                            <span class="am-opt">(<span data-i18n="optional">{{ __("Optional") }}</span>)</span>
                        </label>
                        <div class="am-input-wrap">
                            <input type="text"
                                   class="am-input @error('phone') is-invalid @enderror"
                                   id="phone" name="phone"
                                   placeholder="{{ __('Enter phone number') }}"
                                   value="{{ old('phone') }}"
                                   data-i18n-placeholder="Enter phone number (optional)">
                            <i class="fas fa-phone am-input-icon"></i>
                        </div>
                        @error('phone')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="am-field">
                        <label for="email" class="am-label">
                            <i class="fas fa-envelope"></i>
                            <span data-i18n="email">{{ __("Email") }}</span>
                            <span class="am-opt">(<span data-i18n="optional">{{ __("Optional") }}</span>)</span>
                        </label>
                        <div class="am-input-wrap">
                            <input type="email"
                                   class="am-input @error('email') is-invalid @enderror"
                                   id="email" name="email"
                                   placeholder="{{ __('Enter email address') }}"
                                   value="{{ old('email') }}"
                                   data-i18n-placeholder="Enter email address (optional)">
                            <i class="fas fa-envelope am-input-icon"></i>
                        </div>
                        @error('email')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="am-field is-full">
                        <label for="address" class="am-label">
                            <i class="fas fa-map-marker-alt"></i>
                            <span data-i18n="address">{{ __("Address") }}</span>
                        </label>
                        <div class="am-input-wrap">
                            <input type="text"
                                   class="am-input @error('address') is-invalid @enderror"
                                   id="address" name="address"
                                   placeholder="{{ __('Complete address of the member') }}"
                                   value="{{ old('address') }}"
                                   data-i18n-placeholder="Complete address of the member">
                            <i class="fas fa-home am-input-icon"></i>
                        </div>
                        @error('address')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Roles --}}
                    <div class="am-field is-full">
                        <label class="am-label">
                            <i class="fas fa-tags"></i>
                            <span data-i18n="roles_ministries">{{ __("Roles / Ministries") }}</span>
                        </label>
                        <p style="font-size:.72rem; color:var(--am-muted); margin:.15rem 0 .55rem;">
                            <span data-i18n="select_roles_hint">{{ __("Select one or more roles for this member") }}</span>
                        </p>

                        <div class="am-roles-grid">
                            @if(isset($roles) && $roles->count() > 0)
                                @foreach($roles as $role)
                                    <label class="am-role">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                               {{ is_array(old('roles')) && in_array($role->id, old('roles')) ? 'checked' : '' }}>
                                        <span class="am-role-box"><i class="fas fa-check"></i></span>
                                        <span class="am-role-text">
                                            <i class="fas {{ $role->icon ?? 'fa-tag' }}"></i>
                                            <span>{{ $role->name }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            @else
                                <div style="grid-column:1/-1; text-align:center; padding:1rem; color:var(--am-muted); font-size:.8rem;">
                                    <i class="fas fa-circle-info" style="color:var(--am-primary);"></i>
                                    <span data-i18n="no_roles_available">{{ __("No roles available. Please contact administrator.") }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="am-note">
                            <i class="fas fa-circle-info"></i>
                            <div>
                                <span data-i18n="choir_note_text">
                                    {{ __("Note: Members with Training Pastor, Palagkanta, Instruments, Singer, Musician, Guitarist, Pianist, Drummer, Bassist, or Choir roles will automatically be added to the Choir Ministry.") }}
                                </span>
                            </div>
                        </div>

                        @error('roles')
                            <div class="am-error"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Actions --}}
            <div class="am-foot">
                <a href="{{ route('members.index') }}" class="am-btn am-btn-ghost">
                    <i class="fas fa-arrow-left"></i>
                    <span data-i18n="cancel">{{ __("Cancel") }}</span>
                </a>
                <button type="submit" class="am-btn am-btn-primary">
                    <i class="fas fa-check"></i>
                    <span data-i18n="save_member">{{ __("Save Member") }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    /* ============================================
       GENDER LIVE PREVIEW
    ============================================ */
    function updateGenderDisplay() {
        const select = document.getElementById('gender');
        const display = document.getElementById('genderDisplay');
        const chip = document.getElementById('genderChip');
        if (!select || !display || !chip) return;

        const value = select.value;

        if (value === 'male') {
            display.textContent = window.t ? window.t('male', 'Male') : 'Male';
            chip.style.background = 'rgba(59, 130, 246, .10)';
            chip.style.color = '#2563eb';
        } else if (value === 'female') {
            display.textContent = window.t ? window.t('female', 'Female') : 'Female';
            chip.style.background = 'rgba(236, 72, 153, .10)';
            chip.style.color = '#db2777';
        } else {
            display.textContent = window.t ? window.t('not_selected', 'Not selected') : 'Not selected';
            chip.style.background = '';
            chip.style.color = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('gender');
        if (select) {
            updateGenderDisplay();
            select.addEventListener('change', updateGenderDisplay);
        }
    });

    /* ============================================
       LANGUAGE CHANGE
    ============================================ */
    window.addEventListener('localeChanged', function (e) {
        if (typeof window.applyTranslations === 'function') {
            window.applyTranslations();
        }
        updateGenderDisplay();
        console.log('[Members Create] Locale changed to:', e.detail.locale);
    });
</script>
@endsection