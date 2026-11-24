<style>
    /* ============================================================
       MEMBERS - shared styles
       Uses only the tokens + components from layouts/app.blade.php
       (--primary, --bg-card, --border-color, .panel, .stat-card, .btn-cyan ...)
       so light/dark mode works automatically.
    ============================================================ */

    .m-narrow { max-width: 900px; }

    /* ---- buttons: keep link-buttons readable in dark mode ---- */
    .btn-ghost { color: var(--text-main) !important; }

    /* ---- avatar ---- */
    .m-avatar {
        width: 38px; height: 38px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
        background: var(--primary-soft); color: var(--primary-hover);
        font-size: .74rem; font-weight: 700; letter-spacing: .3px;
    }
    [data-theme="dark"] .m-avatar { color: var(--primary); }
    .m-avatar.lg { width: 84px; height: 84px; font-size: 1.7rem; }
    .m-avatar.danger { background: rgba(239, 68, 68, .12); color: var(--danger); }

    /* ---- pills ---- */
    .m-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 3px 10px; border-radius: 999px;
        font-size: .7rem; font-weight: 600; white-space: nowrap;
        background: var(--bg-hover); color: var(--text-muted);
        border: 1px solid var(--border-color);
    }
    .m-pill i { font-size: .6rem; }
    .m-pill.male     { background: rgba(59, 130, 246, .1);  color: #3B82F6; border-color: transparent; }
    .m-pill.female   { background: rgba(236, 72, 153, .1);  color: #EC4899; border-color: transparent; }
    .m-pill.success  { background: rgba(34, 197, 94, .12);  color: var(--success); border-color: transparent; }
    .m-pill.danger   { background: rgba(239, 68, 68, .12);  color: var(--danger);  border-color: transparent; }

    /* ---- tabs + search (panel toolbar) ---- */
    .m-tabs { display: flex; gap: 4px; }
    .m-tab {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border: none; border-radius: 999px;
        font-size: .82rem; font-weight: 600;
        color: var(--text-muted); background: transparent;
    }
    .m-tab:hover { color: var(--text-main); background: var(--bg-hover); }
    .m-tab.active { color: var(--primary-hover); background: var(--primary-soft); }
    [data-theme="dark"] .m-tab.active { color: var(--primary); }
    .m-count {
        padding: 1px 8px; border-radius: 999px;
        font-size: .68rem; font-weight: 700;
        background: var(--bg-hover);
    }
    .m-tab.active .m-count { background: var(--bg-card); }

    .m-search { position: relative; }
    .m-search i {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        font-size: .75rem; color: var(--text-muted); pointer-events: none;
    }
    .m-search .form-control { padding-left: 34px; min-width: 230px; }

    /* ---- row actions ---- */
    .m-actions { display: flex; gap: 2px; }
    .m-act {
        width: 32px; height: 32px; padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; border-radius: 50%;
        background: transparent; color: var(--text-muted); font-size: .78rem;
    }
    .m-act:hover         { background: var(--primary-soft); color: var(--primary-btn); }
    .m-act.success:hover { background: rgba(34, 197, 94, .12); color: var(--success); }
    .m-act.danger:hover  { background: rgba(239, 68, 68, .12); color: var(--danger); }

    /* ---- empty state ---- */
    .m-empty { text-align: center; padding: 48px 20px; color: var(--text-muted); }
    .m-empty i { display: block; margin-bottom: 12px; font-size: 2rem; color: var(--text-light); }
    .m-empty h5 { margin-bottom: 4px; font-size: 1rem; font-weight: 700; color: var(--text-main); }
    .m-empty p { margin-bottom: 16px; font-size: .85rem; }

    /* ---- forms ---- */
    .form-label { margin-bottom: 6px; font-size: .75rem; font-weight: 600; color: var(--text-muted); }
    .form-label .req { color: var(--danger); }
    .form-check-input:checked { background-color: var(--primary-btn); border-color: var(--primary-btn); }
    .form-check-input:focus { border-color: var(--primary); box-shadow: 0 0 0 .2rem var(--primary-soft); }

    .m-section + .m-section { margin-top: 28px; padding-top: 24px; border-top: 1px solid var(--border-color); }
    .m-section-title {
        display: flex; align-items: center; gap: 8px; margin: 0 0 14px;
        font-size: .8rem; font-weight: 700; color: var(--text-main);
    }
    .m-section-title i { color: var(--primary); }

    .m-role {
        display: flex; align-items: center; gap: 10px;
        height: 100%; padding: 9px 12px; margin: 0;
        border: 1px solid var(--border-color); border-radius: var(--radius);
        background: var(--bg-card); cursor: pointer; user-select: none;
        font-size: .82rem; font-weight: 500;
        transition: border-color .15s ease, background .15s ease;
    }
    .m-role:hover { border-color: var(--primary); }
    .m-role:has(input:checked) { border-color: var(--primary); background: var(--primary-soft); }
    .m-role > i { width: 16px; text-align: center; font-size: .75rem; color: var(--text-muted); }
    .m-role:has(input:checked) > i { color: var(--primary); }
    .m-role input { margin: 0; flex-shrink: 0; }

    .m-note {
        display: flex; gap: 10px; align-items: flex-start;
        margin-top: 14px; padding: 12px 14px;
        border-radius: var(--radius); background: var(--primary-soft);
        font-size: .78rem; color: var(--text-main);
    }
    .m-note i { margin-top: 2px; color: var(--primary); }

    .m-foot {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border-color);
    }

    /* ---- profile info rows ---- */
    .m-info { display: flex; gap: 14px; padding: 14px 0; border-bottom: 1px solid var(--border-color); }
    .m-info:first-child { padding-top: 0; }
    .m-info:last-child { padding-bottom: 0; border-bottom: none; }
    .m-info-icon {
        width: 36px; height: 36px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; background: var(--primary-soft); color: var(--primary-hover);
        font-size: .8rem;
    }
    [data-theme="dark"] .m-info-icon { color: var(--primary); }
    .m-info-label { margin: 0 0 2px; font-size: .66rem; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; color: var(--text-muted); }
    .m-info-value { margin: 0; font-size: .88rem; font-weight: 500; word-break: break-word; }

    /* ---- SweetAlert spinner ---- */
    .loading-spinner {
        width: 38px; height: 38px; margin: 0 auto;
        border: 4px solid var(--border-color); border-top-color: var(--primary-btn);
        border-radius: 50%; animation: mSpin .8s linear infinite;
    }
    @keyframes mSpin { to { transform: rotate(360deg); } }

    @media (max-width: 575px) {
        .m-search .form-control { min-width: 0; width: 100%; }
        .m-search { width: 100%; }
        .m-foot { flex-direction: column-reverse; }
        .m-foot > * { justify-content: center; }
    }
</style>

<style>
    /* ===== MEMBERS ACTION MENU (v9) ===== */
    .mk-btn { display: none; }

    @media (max-width: 767.98px) {
        /* Itago ang daan nga buttons/kebab (v6) */
        .m-kebab { display: none !important; }
        .m-section .table tr[data-row] .m-actions { display: none !important; }

        /* Bag-ong kebab button */
        .mk-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; padding: 0;
            border: 1px solid var(--border-color); border-radius: 12px;
            background: var(--bg-hover); color: var(--text-main); font-size: 1rem;
            cursor: pointer; -webkit-tap-highlight-color: transparent; touch-action: manipulation;
        }
        .mk-btn:active, .mk-btn[aria-expanded="true"] { background: var(--primary-soft); color: var(--primary-hover); }
    }

    /* Menu (gi-append sa body, mao nga husto ang posisyon) */
    .mk-menu {
        position: fixed; z-index: 5000;
        min-width: 210px; max-width: calc(100vw - 20px);
        max-height: calc(100vh - 16px); overflow-y: auto;
        padding: 6px; display: flex; flex-direction: column; gap: 2px;
        background: var(--bg-card, #fff); color: var(--text-main, #0C1445);
        border: 1px solid var(--border-color, #E3E8F5); border-radius: 14px;
        box-shadow: 0 18px 40px rgba(12, 20, 69, .28);
    }
    .mk-item {
        display: flex; align-items: center; gap: 12px;
        width: 100%; height: 44px; padding: 0 12px; margin: 0;
        border: 0; border-radius: 10px; background: transparent; color: inherit;
        font: inherit; font-size: .9rem; font-weight: 600; text-align: left;
        cursor: pointer; -webkit-tap-highlight-color: transparent; touch-action: manipulation;
    }
    .mk-item i { width: 18px; text-align: center; font-size: .9rem; }
    .mk-item:hover, .mk-item:active { background: var(--primary-soft, rgba(18,196,222,.12)); }
    .mk-item.danger, .mk-item.danger i { color: var(--danger, #EF4444); }
    .mk-item.success, .mk-item.success i { color: var(--success, #16A34A); }
</style>
