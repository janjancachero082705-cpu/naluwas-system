@extends('layouts.app')

@section('header', 'Add Inventory Item')

@section('content')

<style>
    /* ==========================================================
       ADD INVENTORY ITEM — 2025 REDESIGN
       Flat · bordered · airy · Inter
       (functionality unchanged — design only)
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .ai {
        --ai-card: var(--card-bg, #ffffff);
        --ai-border: var(--border-color, #e8eaf0);
        --ai-text: var(--text-primary, #0f172a);
        --ai-muted: var(--text-muted, #7c8494);
        --ai-soft: var(--bg-tertiary, #f5f6fa);

        --ai-primary: #4f46e5;
        --ai-primary-soft: rgba(79, 70, 229, .08);
        --ai-primary-ring: rgba(79, 70, 229, .18);

        --ai-green: #059669;
        --ai-green-soft: rgba(5, 150, 105, .10);
        --ai-rose: #e11d48;
        --ai-rose-soft: rgba(225, 29, 72, .09);
        --ai-amber: #d97706;
        --ai-amber-soft: rgba(217, 119, 6, .10);
        --ai-violet: #7c3aed;
        --ai-violet-soft: rgba(124, 58, 237, .10);

        --ai-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --ai-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --ai-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--ai-text);
        padding-bottom: 2rem;
        max-width: 980px;
        margin: 0 auto;
    }

    [data-theme="dark"] .ai {
        --ai-primary: #6366f1;
        --ai-primary-soft: rgba(99, 102, 241, .16);
        --ai-primary-ring: rgba(99, 102, 241, .28);
        --ai-green: #34d399;
        --ai-green-soft: rgba(16, 185, 129, .14);
        --ai-rose: #fb7185;
        --ai-rose-soft: rgba(244, 63, 94, .14);
        --ai-amber: #fbbf24;
        --ai-amber-soft: rgba(245, 158, 11, .14);
        --ai-violet: #a78bfa;
        --ai-violet-soft: rgba(139, 92, 246, .16);
        --ai-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --ai-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .ai * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .ai-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--ai-border);
        margin-bottom: 1.5rem;
    }

    .ai-head-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
    }

    .ai-avatar {
        width: 60px; height: 60px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        font-size: 1.25rem;
        flex: 0 0 auto;
        background: var(--ai-violet-soft);
        color: var(--ai-violet);
    }

    .ai-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--ai-muted);
        margin-bottom: .4rem;
    }

    .ai-eyebrow .ai-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--ai-violet);
        box-shadow: 0 0 0 3px var(--ai-violet-soft);
    }

    .ai-title {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0;
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .ai-title i { font-size: 1.05rem; color: var(--ai-primary); }

    .ai-sub {
        margin: .45rem 0 0;
        font-size: .8rem;
        color: var(--ai-muted);
        line-height: 1.5;
    }

    .ai-head-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .ai-btn {
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

    .ai-btn-primary {
        background: var(--ai-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .ai-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .ai-btn-green {
        background: var(--ai-green);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(5, 150, 105, .9);
    }
    .ai-btn-green:hover {
        background: #047857;
        color: #fff;
        transform: translateY(-1px);
    }

    .ai-btn-ghost {
        background: var(--ai-card);
        color: var(--ai-text);
        border-color: var(--ai-border);
    }
    .ai-btn-ghost:hover {
        background: var(--ai-soft);
        color: var(--ai-text);
        transform: translateY(-1px);
    }

    /* ---------------- CARD ---------------- */
    .ai-card {
        background: var(--ai-card);
        border: 1px solid var(--ai-border);
        border-radius: var(--ai-radius);
        overflow: hidden;
        box-shadow: var(--ai-shadow-sm);
    }

    .ai-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        padding: 1rem 1.35rem;
        border-bottom: 1px solid var(--ai-border);
        background: var(--ai-soft);
    }

    .ai-card-head-left {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .ai-card-head-icon {
        width: 36px; height: 36px;
        border-radius: 11px;
        display: grid;
        place-items: center;
        font-size: .85rem;
        background: var(--ai-violet-soft);
        color: var(--ai-violet);
        flex: 0 0 auto;
    }

    .ai-card-head-title {
        font-size: .92rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
    }

    .ai-card-head-sub {
        font-size: .7rem;
        color: var(--ai-muted);
        margin-top: .15rem;
    }

    .ai-card-head-tag {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .28rem .7rem;
        border-radius: 20px;
        border: 1px solid var(--ai-border);
        background: var(--ai-card);
        font-size: .68rem;
        font-weight: 600;
        color: var(--ai-muted);
        white-space: nowrap;
    }

    .ai-card-head-tag i { font-size: .6rem; color: var(--ai-primary); }

    .ai-card-body {
        padding: 1.5rem 1.35rem;
    }

    /* ---------------- SECTION ---------------- */
    .ai-section + .ai-section {
        margin-top: 2rem;
        padding-top: 1.75rem;
        border-top: 1px solid var(--ai-border);
    }

    .ai-section-head {
        display: flex;
        align-items: center;
        gap: .65rem;
        margin-bottom: 1.15rem;
    }

    .ai-section-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        font-size: .78rem;
        background: var(--ai-primary-soft);
        color: var(--ai-primary);
        flex: 0 0 auto;
    }

    .ai-section-title {
        font-size: .95rem;
        font-weight: 700;
        letter-spacing: -.01em;
        line-height: 1.2;
        margin: 0;
    }

    .ai-section-sub {
        font-size: .7rem;
        color: var(--ai-muted);
        margin-top: .1rem;
    }

    /* ---------------- FORM ---------------- */
    .ai-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.15rem 1.25rem;
    }

    .ai-field { min-width: 0; }
    .ai-field.is-full { grid-column: 1 / -1; }

    .ai-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--ai-muted);
        margin-bottom: .45rem;
    }

    .ai-label i {
        font-size: .62rem;
        color: var(--ai-primary);
        width: 14px;
        text-align: center;
    }

    .ai-label .ai-req { color: var(--ai-rose); font-size: .8rem; line-height: 1; }

    .ai-label .ai-opt {
        font-size: .6rem;
        font-weight: 500;
        letter-spacing: .04em;
        text-transform: none;
        color: var(--ai-muted);
        opacity: .8;
    }

    .ai-input-wrap { position: relative; }

    .ai-input-wrap > .ai-input-icon {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .72rem;
        color: var(--ai-muted);
        pointer-events: none;
        z-index: 2;
        transition: color .18s ease;
    }

    .ai-input,
    .ai-select,
    .ai-textarea {
        width: 100%;
        padding: .68rem .9rem .68rem 2.35rem;
        border-radius: 11px;
        border: 1px solid var(--ai-border);
        background: var(--ai-soft);
        color: var(--ai-text);
        font-size: .84rem;
        font-family: inherit;
        line-height: 1.35;
        transition: background .18s ease, border-color .18s ease, box-shadow .18s ease;
    }

    .ai-textarea {
        padding-left: .9rem;
        min-height: 90px;
        resize: vertical;
        line-height: 1.55;
    }

    .ai-input::placeholder,
    .ai-textarea::placeholder { color: var(--ai-muted); opacity: .8; }

    .ai-input:focus,
    .ai-select:focus,
    .ai-textarea:focus {
        outline: none;
        background: var(--ai-card);
        border-color: var(--ai-primary);
        box-shadow: 0 0 0 3px var(--ai-primary-ring);
    }

    .ai-input-wrap:focus-within > .ai-input-icon { color: var(--ai-primary); }

    .ai-select {
        appearance: none;
        -webkit-appearance: none;
        padding-right: 2.4rem;
        cursor: pointer;
    }

    .ai-select option { background: var(--ai-card); color: var(--ai-text); }

    .ai-select-caret {
        position: absolute;
        right: .95rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: .58rem;
        color: var(--ai-muted);
        pointer-events: none;
        z-index: 2;
    }

    /* Helper text */
    .ai-hint {
        display: flex;
        align-items: center;
        gap: .35rem;
        margin-top: .35rem;
        font-size: .68rem;
        color: var(--ai-muted);
    }

    .ai-hint i { font-size: .6rem; color: var(--ai-primary); }

    /* ---------------- STATUS OPTIONS ---------------- */
    .ai-status-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .6rem;
    }

    .ai-status-opt {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .65rem .9rem;
        border-radius: 11px;
        border: 1px solid var(--ai-border);
        background: var(--ai-soft);
        color: var(--ai-muted);
        font-size: .78rem;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        user-select: none;
        transition: background .16s ease, border-color .16s ease, color .16s ease, transform .16s ease;
    }

    .ai-status-opt i { font-size: .72rem; }

    .ai-status-opt:hover {
        border-color: var(--ai-primary);
        color: var(--ai-primary);
        transform: translateY(-1px);
    }

    .ai-status-opt.active {
        border-color: var(--ai-green);
        background: var(--ai-green-soft);
        color: var(--ai-green);
    }

    .ai-status-opt[data-status="damaged"].active {
        border-color: var(--ai-amber);
        background: var(--ai-amber-soft);
        color: var(--ai-amber);
    }

    .ai-status-opt[data-status="lost"].active {
        border-color: var(--ai-rose);
        background: var(--ai-rose-soft);
        color: var(--ai-rose);
    }

    /* ---------------- FOOTER ---------------- */
    .ai-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: .7rem;
        flex-wrap: wrap;
        padding: 1.1rem 1.35rem;
        border-top: 1px solid var(--ai-border);
        background: var(--ai-soft);
    }

    .ai-foot-right {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 768px) {
        .ai-head { flex-direction: column; align-items: flex-start; }
        .ai-head-left { width: 100%; }
        .ai-head-actions { width: 100%; }
        .ai-head-actions .ai-btn { flex: 1; justify-content: center; }

        .ai-avatar { width: 50px; height: 50px; border-radius: 15px; font-size: 1.05rem; }
        .ai-title { font-size: 1.2rem; }

        .ai-grid { grid-template-columns: 1fr; }
        .ai-card-body { padding: 1.15rem 1rem; }
        .ai-card-head { padding: .9rem 1rem; }

        .ai-status-row { grid-template-columns: 1fr; }

        .ai-foot { flex-direction: column-reverse; align-items: stretch; padding: 1rem; }
        .ai-foot-right { width: 100%; }
        .ai-foot .ai-btn { width: 100%; flex: 1; justify-content: center; }
    }

    @media (max-width: 480px) {
        .ai-card-body { padding: 1rem .85rem; }
    }
</style>

<div class="ai container-fluid px-0">

    {{-- ============================================
         HEADER
    ============================================ --}}
    <header class="ai-head">
        <div class="ai-head-left">
            <div class="ai-avatar">
                <i class="fas fa-box-open"></i>
            </div>
            <div style="min-width:0;">
                <div class="ai-eyebrow">
                    <span class="ai-dot"></span>
                    <span>{{ __('Inventory Management') }}</span>
                </div>
                <h1 class="ai-title">
                    <i class="fas fa-plus-circle"></i>
                    <span>{{ __('Add New Inventory Item') }}</span>
                </h1>
                <p class="ai-sub">{{ __('Register a new item to your church inventory') }}</p>
            </div>
        </div>
        <div class="ai-head-actions">
            <a href="{{ route('inventory.index') }}" class="ai-btn ai-btn-ghost">
                <i class="fas fa-arrow-left"></i>
                <span>{{ __('Back to Inventory') }}</span>
            </a>
        </div>
    </header>

    {{-- ============================================
         CARD
    ============================================ --}}
    <div class="ai-card">

        <div class="ai-card-head">
            <div class="ai-card-head-left">
                <div class="ai-card-head-icon"><i class="fas fa-boxes"></i></div>
                <div>
                    <div class="ai-card-head-title">{{ __('Item Details') }}</div>
                    <div class="ai-card-head-sub">{{ __('Fields marked with * are required') }}</div>
                </div>
            </div>
            <span class="ai-card-head-tag">
                <i class="fas fa-info-circle"></i>
                {{ __('New Item') }}
            </span>
        </div>

        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf

            <div class="ai-card-body">

                {{-- ============================================
                     BASIC INFORMATION
                ============================================ --}}
                <section class="ai-section">
                    <div class="ai-section-head">
                        <div class="ai-section-icon"><i class="fas fa-info-circle"></i></div>
                        <div>
                            <h2 class="ai-section-title">{{ __('Basic Information') }}</h2>
                            <div class="ai-section-sub">{{ __('Item name, category and description') }}</div>
                        </div>
                    </div>

                    <div class="ai-grid">

                        {{-- Item Name --}}
                        <div class="ai-field is-full">
                            <label class="ai-label" for="item_name">
                                <i class="fas fa-tag"></i>
                                <span>{{ __('Item Name') }}</span>
                                <span class="ai-req">*</span>
                            </label>
                            <div class="ai-input-wrap">
                                <input type="text"
                                       id="item_name"
                                       name="item_name"
                                       class="ai-input @error('item_name') is-invalid @enderror"
                                       value="{{ old('item_name') }}"
                                       placeholder="{{ __('Enter item name e.g., Sound System, Chairs, Books') }}"
                                       required>
                                <i class="fas fa-tag ai-input-icon"></i>
                            </div>
                            @error('item_name')
                                <div class="ai-hint" style="color: var(--ai-rose);">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div class="ai-field">
                            <label class="ai-label" for="category">
                                <i class="fas fa-folder"></i>
                                <span>{{ __('Category') }}</span>
                            </label>
                            <div class="ai-input-wrap">
                                <select id="category" name="category" class="ai-select @error('category') is-invalid @enderror">
                                    <option value="">— {{ __('Select Category') }} —</option>
                                    <option value="Equipment" {{ old('category') == 'Equipment' ? 'selected' : '' }}>🎛️ {{ __('Equipment') }}</option>
                                    <option value="Furniture" {{ old('category') == 'Furniture' ? 'selected' : '' }}>🪑 {{ __('Furniture') }}</option>
                                    <option value="Books" {{ old('category') == 'Books' ? 'selected' : '' }}>📚 {{ __('Books') }}</option>
                                    <option value="Office Supplies" {{ old('category') == 'Office Supplies' ? 'selected' : '' }}>📎 {{ __('Office Supplies') }}</option>
                                    <option value="Music Instruments" {{ old('category') == 'Music Instruments' ? 'selected' : '' }}>🎸 {{ __('Music Instruments') }}</option>
                                    <option value="Sound System" {{ old('category') == 'Sound System' ? 'selected' : '' }}>🔊 {{ __('Sound System') }}</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>📦 {{ __('Other') }}</option>
                                </select>
                                <i class="fas fa-folder ai-input-icon"></i>
                                <i class="fas fa-chevron-down ai-select-caret"></i>
                            </div>
                            @error('category')
                                <div class="ai-hint" style="color: var(--ai-rose);">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="ai-field">
                            <label class="ai-label" for="description">
                                <i class="fas fa-align-left"></i>
                                <span>{{ __('Description') }}</span>
                                <span class="ai-opt">({{ __('Optional') }})</span>
                            </label>
                            <div class="ai-input-wrap">
                                <textarea id="description"
                                          name="description"
                                          class="ai-textarea @error('description') is-invalid @enderror"
                                          placeholder="{{ __('Enter item description, condition, location, or additional notes...') }}">{{ old('description') }}</textarea>
                            </div>
                            <div class="ai-hint">
                                <i class="fas fa-pen"></i>
                                {{ __('Include details like brand, color, location, etc.') }}
                            </div>
                            @error('description')
                                <div class="ai-hint" style="color: var(--ai-rose);">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </section>

                {{-- ============================================
                     QUANTITY & PRICE
                ============================================ --}}
                <section class="ai-section">
                    <div class="ai-section-head">
                        <div class="ai-section-icon"><i class="fas fa-cubes"></i></div>
                        <div>
                            <h2 class="ai-section-title">{{ __('Quantity & Price') }}</h2>
                            <div class="ai-section-sub">{{ __('Stock count and item value') }}</div>
                        </div>
                    </div>

                    <div class="ai-grid">

                        {{-- Quantity --}}
                        <div class="ai-field">
                            <label class="ai-label" for="quantity">
                                <i class="fas fa-hashtag"></i>
                                <span>{{ __('Quantity') }}</span>
                                <span class="ai-req">*</span>
                            </label>
                            <div class="ai-input-wrap">
                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       class="ai-input @error('quantity') is-invalid @enderror"
                                       value="{{ old('quantity', 1) }}"
                                       placeholder="0"
                                       min="0"
                                       required>
                                <i class="fas fa-hashtag ai-input-icon"></i>
                            </div>
                            @error('quantity')
                                <div class="ai-hint" style="color: var(--ai-rose);">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Price --}}
                        <div class="ai-field">
                            <label class="ai-label" for="price">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>{{ __('Price') }} (₱)</span>
                                <span class="ai-opt">({{ __('Optional') }})</span>
                            </label>
                            <div class="ai-input-wrap">
                                <input type="number"
                                       id="price"
                                       name="price"
                                       step="0.01"
                                       class="ai-input @error('price') is-invalid @enderror"
                                       value="{{ old('price') }}"
                                       placeholder="0.00"
                                       min="0">
                                <i class="fas fa-money-bill-wave ai-input-icon"></i>
                            </div>
                            <div class="ai-hint">
                                <i class="fas fa-info-circle"></i>
                                {{ __('Leave empty if not applicable') }}
                            </div>
                            @error('price')
                                <div class="ai-hint" style="color: var(--ai-rose);">
                                    <i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </section>

                {{-- ============================================
                     STATUS
                ============================================ --}}
                <section class="ai-section">
                    <div class="ai-section-head">
                        <div class="ai-section-icon"><i class="fas fa-circle-check"></i></div>
                        <div>
                            <h2 class="ai-section-title">{{ __('Item Status') }}</h2>
                            <div class="ai-section-sub">{{ __('Current condition of the item') }}</div>
                        </div>
                    </div>

                    <div class="ai-field is-full">
                        <div class="ai-status-row">
                            <button type="button"
                                    class="ai-status-opt active"
                                    data-status="available"
                                    onclick="selectStatus('available')">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ __('Available') }}</span>
                            </button>
                            <button type="button"
                                    class="ai-status-opt"
                                    data-status="damaged"
                                    onclick="selectStatus('damaged')">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ __('Damaged') }}</span>
                            </button>
                            <button type="button"
                                    class="ai-status-opt"
                                    data-status="lost"
                                    onclick="selectStatus('lost')">
                                <i class="fas fa-times-circle"></i>
                                <span>{{ __('Lost') }}</span>
                            </button>
                        </div>
                        <input type="hidden" name="status" id="statusInput" value="{{ old('status', 'available') }}">
                    </div>
                </section>

            </div>

            {{-- ============================================
                 ACTIONS
            ============================================ --}}
            <div class="ai-foot">
                <a href="{{ route('inventory.index') }}" class="ai-btn ai-btn-ghost">
                    <i class="fas fa-times"></i>
                    <span>{{ __('Cancel') }}</span>
                </a>
                <div class="ai-foot-right">
                    <button type="submit" class="ai-btn ai-btn-primary">
                        <i class="fas fa-check"></i>
                        <span>{{ __('Save Item') }}</span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    // ============================================
    // STATUS SELECTION
    // ============================================
    function selectStatus(status) {
        // Update hidden input
        document.getElementById('statusInput').value = status;

        // Update UI
        document.querySelectorAll('.ai-status-opt').forEach(option => {
            option.classList.remove('active');
            if (option.getAttribute('data-status') === status) {
                option.classList.add('active');
            }
        });
    }

    // ============================================
    // INITIALIZE FROM OLD VALUE
    // ============================================
    document.addEventListener('DOMContentLoaded', function () {
        const hidden = document.getElementById('statusInput');
        if (hidden && hidden.value) {
            selectStatus(hidden.value);
        }

        // Card entrance animation
        const card = document.querySelector('.ai-card');
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

@endsection