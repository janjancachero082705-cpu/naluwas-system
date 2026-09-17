@extends('layouts.app')

@section('header')
    <span data-i18n="edit_choir_member_title">Edit Choir Member</span>
@endsection

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ═══════════════════════════════════════════════
       EDIT CHOIR MEMBER — matches app dark palette
    ═══════════════════════════════════════════════ */
    .choir-form-app {
        font-family: var(--font-body, 'Inter', sans-serif);
        color: var(--text-primary);
        max-width: 820px;
        margin: 0 auto;
    }

    .choir-form-app * { box-sizing: border-box; }

    /* ─── Animations ─── */
    @keyframes aFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
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
       CHECKBOX
    ═══════════════════════════════════════════════ */
    .checkbox-wrapper {
        background: rgba(200, 155, 60, 0.06);
        border-radius: 14px;
        padding: 1rem 1.15rem;
        border: 1px solid rgba(200, 155, 60, 0.20);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .checkbox-wrapper .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .checkbox-wrapper .form-check-input {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #D3A24C;
        flex-shrink: 0;
    }

    .checkbox-wrapper .form-check-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        cursor: pointer;
        letter-spacing: -0.005em;
    }

    .checkbox-wrapper .form-check-label i {
        display: grid;
        place-items: center;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: rgba(200, 155, 60, 0.14);
        color: #D3A24C;
        font-size: 0.7rem;
    }

    .checkbox-wrapper .checkbox-hint {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .checkbox-wrapper .checkbox-hint i {
        font-size: 0.62rem;
        opacity: 0.75;
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

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px -8px rgba(200, 155, 60, 0.55);
    }

    .btn-submit:active { transform: translateY(0) scale(0.99); }

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

        .form-grid { grid-template-columns: 1fr; gap: 1rem; }
        .form-group-full { grid-column: span 1; }

        .voice-selector { grid-template-columns: repeat(2, 1fr); }

        .button-group { flex-direction: column-reverse; }
        .btn-submit, .btn-cancel { width: 100%; }

        .checkbox-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="choir-form-app">

    {{-- HERO --}}
    <div class="form-hero">
        <div class="form-hero-inner">
            <div class="form-hero-orb">
                <i class="fas fa-pen-to-square"></i>
            </div>
            <div class="form-hero-copy">
                <h1 class="form-hero-title" data-i18n="edit_choir_member_title">Edit Choir Member</h1>
                <p class="form-hero-sub" data-i18n="edit_choir_member_desc">Update choir member information</p>
                <span class="form-hero-tag">
                    <span class="dot"></span>
                    <span>{{ $choir_member->first_name }} {{ $choir_member->last_name }}</span>
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
                <p data-i18n="edit_member_info">Update the fields below and save your changes</p>
            </div>
        </div>

        <div class="card-body-custom">
            <form action="{{ route('choir-members.update', $choir_member->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    {{-- First Name --}}
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            <span data-i18n="first_name">First Name</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text"
                               name="first_name"
                               class="form-control"
                               required
                               value="{{ old('first_name', $choir_member->first_name) }}"
                               placeholder="{{ __('Enter first name') }}">
                    </div>

                    {{-- Last Name --}}
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i>
                            <span data-i18n="last_name">Last Name</span>
                            <span class="required">*</span>
                        </label>
                        <input type="text"
                               name="last_name"
                               class="form-control"
                               required
                               value="{{ old('last_name', $choir_member->last_name) }}"
                               placeholder="{{ __('Enter last name') }}">
                    </div>

                    {{-- Birthday --}}
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-birthday-cake"></i>
                            <span data-i18n="birthday">Birthday</span>
                        </label>
                        <input type="date"
                               name="birthday"
                               class="form-control"
                               value="{{ old('birthday', $choir_member->birthday) }}">
                    </div>

                    {{-- Phone --}}
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-phone"></i>
                            <span data-i18n="phone">Phone</span>
                        </label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $choir_member->phone ?? '') }}"
                               placeholder="{{ __('Optional contact number') }}">
                    </div>

                    {{-- Address --}}
                    <div class="form-group-full">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i>
                            <span data-i18n="address">Address</span>
                        </label>
                        <textarea name="address"
                                  rows="2"
                                  class="form-control"
                                  placeholder="{{ __('Complete address of the member') }}">{{ old('address', $choir_member->address) }}</textarea>
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
                        </label>
                        <div class="voice-selector">
                            <div class="voice-option {{ $choir_member->voice_part == 'Soprano' ? 'selected' : '' }}"
                                 data-voice="Soprano"
                                 onclick="selectVoice(this, 'Soprano')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="soprano">Soprano</span>
                            </div>
                            <div class="voice-option {{ $choir_member->voice_part == 'Alto' ? 'selected' : '' }}"
                                 data-voice="Alto"
                                 onclick="selectVoice(this, 'Alto')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="alto">Alto</span>
                            </div>
                            <div class="voice-option {{ $choir_member->voice_part == 'Tenor' ? 'selected' : '' }}"
                                 data-voice="Tenor"
                                 onclick="selectVoice(this, 'Tenor')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="tenor">Tenor</span>
                            </div>
                            <div class="voice-option {{ $choir_member->voice_part == 'Bass' ? 'selected' : '' }}"
                                 data-voice="Bass"
                                 onclick="selectVoice(this, 'Bass')">
                                <i class="fas fa-microphone-alt"></i>
                                <span data-i18n="bass">Bass</span>
                            </div>
                        </div>
                        <input type="hidden"
                               name="voice_part"
                               id="voicePart"
                               value="{{ old('voice_part', $choir_member->voice_part) }}">
                    </div>

                    {{-- Choir Status --}}
                    <div class="form-group-full" style="margin-top: 1.25rem;">
                        <div class="checkbox-wrapper">
                            <div class="form-check">
                                <input type="checkbox"
                                       name="is_choir"
                                       id="isChoir"
                                       class="form-check-input"
                                       value="1"
                                       {{ $choir_member->is_choir ? 'checked' : '' }}>
                                <label class="form-check-label" for="isChoir">
                                    <i class="fas fa-music"></i>
                                    <span data-i18n="choir_member_label">Choir Member</span>
                                </label>
                            </div>
                            <span class="checkbox-hint">
                                <i class="fas fa-info-circle"></i>
                                <span data-i18n="choir_member_edit_hint">Uncheck to remove from the choir list</span>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="button-group">
                    <a href="{{ route('choir-members.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        <span data-i18n="cancel">Cancel</span>
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        <span data-i18n="update_choir_member">Update Choir Member</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Voice Selection
    function selectVoice(element, voice) {
        document.querySelectorAll('.voice-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('voicePart').value = voice;
    }
</script>
@endsection