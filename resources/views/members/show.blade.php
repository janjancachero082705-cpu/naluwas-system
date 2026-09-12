@extends('layouts.app')

@section('header')
    <span data-i18n="member_profile">{{ __("Member Profile") }}</span>
@endsection

@section('content')
<style>
    /* ==========================================================
       MEMBER PROFILE — 2025 REDESIGN
       Flat · bordered · airy · Inter
       (functionality unchanged — design only)
    ========================================================== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .mp {
        --mp-card: var(--card-bg, #ffffff);
        --mp-border: var(--border-color, #e8eaf0);
        --mp-text: var(--text-primary, #0f172a);
        --mp-muted: var(--text-muted, #7c8494);
        --mp-soft: var(--bg-tertiary, #f5f6fa);

        --mp-primary: #4f46e5;
        --mp-primary-soft: rgba(79, 70, 229, .08);
        --mp-primary-ring: rgba(79, 70, 229, .18);

        --mp-green: #059669;
        --mp-green-soft: rgba(5, 150, 105, .10);
        --mp-rose: #e11d48;
        --mp-rose-soft: rgba(225, 29, 72, .09);
        --mp-amber: #d97706;
        --mp-amber-soft: rgba(217, 119, 6, .10);
        --mp-violet: #7c3aed;
        --mp-violet-soft: rgba(124, 58, 237, .10);
        --mp-pink: #db2777;
        --mp-pink-soft: rgba(219, 39, 119, .10);
        --mp-teal: #0d9488;
        --mp-teal-soft: rgba(13, 148, 136, .10);
        --mp-blue: #2563eb;
        --mp-blue-soft: rgba(37, 99, 235, .10);

        --mp-shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
        --mp-shadow-md: 0 10px 28px -14px rgba(15, 23, 42, .22);
        --mp-radius: 16px;

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--mp-text);
        padding-bottom: 2rem;
    }

    [data-theme="dark"] .mp {
        --mp-primary: #6366f1;
        --mp-primary-soft: rgba(99, 102, 241, .16);
        --mp-primary-ring: rgba(99, 102, 241, .28);
        --mp-green: #34d399;
        --mp-green-soft: rgba(16, 185, 129, .14);
        --mp-rose: #fb7185;
        --mp-rose-soft: rgba(244, 63, 94, .14);
        --mp-amber: #fbbf24;
        --mp-amber-soft: rgba(245, 158, 11, .14);
        --mp-violet: #a78bfa;
        --mp-violet-soft: rgba(139, 92, 246, .16);
        --mp-pink: #f472b6;
        --mp-pink-soft: rgba(236, 72, 153, .14);
        --mp-teal: #2dd4bf;
        --mp-teal-soft: rgba(20, 184, 166, .14);
        --mp-blue: #60a5fa;
        --mp-blue-soft: rgba(59, 130, 246, .16);
        --mp-shadow-sm: 0 1px 2px rgba(0, 0, 0, .35);
        --mp-shadow-md: 0 14px 30px -16px rgba(0, 0, 0, .75);
    }

    .mp * { box-sizing: border-box; }

    /* ---------------- HEADER ---------------- */
    .mp-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1.25rem;
        flex-wrap: wrap;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--mp-border);
        margin-bottom: 1.25rem;
    }

    .mp-head-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
    }

    .mp-head-avatar {
        width: 62px; height: 62px;
        border-radius: 20px;
        display: grid;
        place-items: center;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: .02em;
        background: var(--mp-primary-soft);
        color: var(--mp-primary);
        flex: 0 0 auto;
    }

    .mp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--mp-muted);
        margin-bottom: .4rem;
    }

    .mp-eyebrow .mp-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--mp-violet);
        box-shadow: 0 0 0 3px var(--mp-violet-soft);
    }

    .mp-title {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -.035em;
        line-height: 1.15;
    }

    .mp-title i { font-size: 1.1rem; color: var(--mp-primary); }

    .mp-sub {
        display: flex;
        align-items: center;
        gap: .55rem;
        flex-wrap: wrap;
        margin: .45rem 0 0;
        font-size: .8rem;
        color: var(--mp-muted);
        line-height: 1.4;
    }

    .mp-sub .mp-sep { opacity: .4; }

    .mp-sub i { font-size: .68rem; }

    /* Status pill */
    .mp-status {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .22rem .65rem;
        border-radius: 20px;
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .mp-status.active {
        background: var(--mp-green-soft);
        color: var(--mp-green);
    }

    .mp-status.active::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--mp-green);
        animation: mpPulse 2s infinite;
    }

    .mp-status.deceased {
        background: var(--mp-rose-soft);
        color: var(--mp-rose);
    }

    .mp-status.deceased i { font-size: .58rem; }

    @keyframes mpPulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: .5; transform: scale(.75); }
    }

    .mp-head-actions {
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
    }

    /* ---------------- BUTTONS ---------------- */
    .mp-btn {
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

    .mp-btn-primary {
        background: var(--mp-primary);
        color: #fff;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, .9);
    }
    .mp-btn-primary:hover {
        background: #4338ca;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px -10px rgba(79, 70, 229, .9);
    }

    .mp-btn-ghost {
        background: var(--mp-card);
        color: var(--mp-text);
        border-color: var(--mp-border);
    }
    .mp-btn-ghost:hover {
        background: var(--mp-soft);
        color: var(--mp-text);
        transform: translateY(-1px);
    }

    /* ---------------- QUICK ACTIONS (horizontal) ---------------- */
    .quick-actions-horizontal {
        display: flex;
        gap: .7rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }

    .quick-action-btn {
        flex: 1;
        min-width: 150px;
        padding: .8rem 1rem;
        border-radius: 12px;
        border: 1px solid var(--mp-border);
        background: var(--mp-card);
        text-align: center;
        text-decoration: none;
        color: var(--mp-muted);
        font-size: .78rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        cursor: pointer;
        font-family: inherit;
        transition: background .18s ease, color .18s ease, transform .18s ease, border-color .18s ease;
    }

    .quick-action-btn i { font-size: .85rem; }

    .quick-action-btn:hover {
        transform: translateY(-2px);
    }

    .quick-action-btn.attendance {
        border-color: var(--mp-border);
        color: var(--mp-green);
    }
    .quick-action-btn.attendance:hover {
        border-color: var(--mp-green);
        background: var(--mp-green-soft);
    }

    .quick-action-btn.deceased {
        border-color: var(--mp-border);
        color: var(--mp-rose);
    }
    .quick-action-btn.deceased:hover {
        border-color: var(--mp-rose);
        background: var(--mp-rose-soft);
    }

    .quick-action-btn.edit {
        border-color: var(--mp-border);
        color: var(--mp-violet);
    }
    .quick-action-btn.edit:hover {
        border-color: var(--mp-violet);
        background: var(--mp-violet-soft);
    }

    .quick-action-btn.restore {
        border-color: var(--mp-border);
        color: var(--mp-green);
    }
    .quick-action-btn.restore:hover {
        border-color: var(--mp-green);
        background: var(--mp-green-soft);
    }

    /* ---------------- MAIN LAYOUT ---------------- */
    .profile-main-layout {
        display: flex;
        gap: 1.25rem;
        align-items: stretch;
    }

    .profile-left {
        flex: 0 0 300px;
        min-width: 260px;
    }

    .profile-right {
        flex: 1;
        min-width: 0;
    }

    /* ---------------- NAME CARD (LEFT) ---------------- */
    .name-card {
        background: var(--mp-card);
        border: 1px solid var(--mp-border);
        border-radius: var(--mp-radius);
        box-shadow: var(--mp-shadow-sm);
        padding: 1.6rem 1.15rem 1.4rem;
        text-align: center;
        height: 100%;
        transition: box-shadow .25s ease, border-color .25s ease;
    }

    .name-card:hover {
        box-shadow: var(--mp-shadow-md);
        border-color: transparent;
    }

    .name-card .avatar-large {
        width: 88px; height: 88px;
        border-radius: 24px;
        display: grid;
        place-items: center;
        margin: 0 auto .9rem;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: .02em;
        background: var(--mp-primary-soft);
        color: var(--mp-primary);
    }

    .name-card .member-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--mp-text);
        margin: 0;
        letter-spacing: -.02em;
        line-height: 1.25;
    }

    .name-card .member-id {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        margin: .4rem 0 .9rem;
        font-size: .72rem;
        color: var(--mp-muted);
        font-weight: 500;
    }

    .name-card .member-id i { font-size: .62rem; }

    .name-divider {
        height: 1px;
        background: var(--mp-border);
        margin: 0 auto 1rem;
        width: 100%;
    }

    .name-card .status-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .28rem .75rem;
        border-radius: 20px;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .name-card .status-badge.active {
        background: var(--mp-green-soft);
        color: var(--mp-green);
    }
    .name-card .status-badge.active::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--mp-green);
        animation: mpPulse 2s infinite;
    }

    .name-card .status-badge.deceased {
        background: var(--mp-rose-soft);
        color: var(--mp-rose);
    }

    .name-card .gender-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .28rem .75rem;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
        margin-top: .55rem;
        background: var(--mp-soft);
        color: var(--mp-muted);
        border: 1px solid var(--mp-border);
    }

    .name-card .gender-badge i { font-size: .68rem; }

    .name-card .gender-badge.male {
        background: var(--mp-blue-soft);
        color: var(--mp-blue);
        border-color: transparent;
    }
    .name-card .gender-badge.female {
        background: var(--mp-pink-soft);
        color: var(--mp-pink);
        border-color: transparent;
    }

    /* ---------------- INFO CARD (RIGHT) ---------------- */
    .info-card {
        background: var(--mp-card);
        border: 1px solid var(--mp-border);
        border-radius: var(--mp-radius);
        box-shadow: var(--mp-shadow-sm);
        height: 100%;
        overflow: hidden;
        transition: box-shadow .25s ease, border-color .25s ease;
    }

    .info-card:hover {
        box-shadow: var(--mp-shadow-md);
        border-color: transparent;
    }

    .info-card .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: .85rem 1.2rem;
        border-bottom: 1px solid var(--mp-border);
        background: var(--mp-soft);
    }

    .info-card .card-header h6 {
        display: flex;
        align-items: center;
        gap: .55rem;
        margin: 0;
        font-weight: 700;
        font-size: .84rem;
        color: var(--mp-text);
        letter-spacing: -.005em;
    }

    .info-card .card-header h6 i {
        display: grid;
        place-items: center;
        width: 28px; height: 28px;
        border-radius: 8px;
        font-size: .68rem;
        background: var(--mp-primary-soft);
        color: var(--mp-primary);
    }

    .info-card .card-header .member-since {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .64rem;
        font-weight: 600;
        color: var(--mp-muted);
        background: var(--mp-card);
        padding: .22rem .55rem;
        border-radius: 20px;
        border: 1px solid var(--mp-border);
        white-space: nowrap;
    }

    .info-card .card-header .member-since i { font-size: .56rem; }

    .info-card .card-body {
        padding: .35rem 1.2rem 1.15rem;
    }

    /* Info items */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: .8rem;
        padding: .85rem 0;
        border-bottom: 1px solid var(--mp-border);
    }

    .info-item:last-child { border-bottom: none; padding-bottom: 0; }

    .info-item .info-icon {
        width: 34px; height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        font-size: .75rem;
        flex: 0 0 auto;
    }

    .info-item .info-icon.purple { background: var(--mp-violet-soft); color: var(--mp-violet); }
    .info-item .info-icon.green  { background: var(--mp-green-soft);  color: var(--mp-green); }
    .info-item .info-icon.orange { background: var(--mp-amber-soft);  color: var(--mp-amber); }
    .info-item .info-icon.pink   { background: var(--mp-pink-soft);   color: var(--mp-pink); }
    .info-item .info-icon.blue   { background: var(--mp-blue-soft);   color: var(--mp-blue); }
    .info-item .info-icon.teal   { background: var(--mp-teal-soft);   color: var(--mp-teal); }
    .info-item .info-icon.roles  { background: var(--mp-violet-soft); color: var(--mp-violet); }

    .info-item .info-content { flex: 1; min-width: 0; }

    .info-item .info-label {
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--mp-muted);
        margin: 0 0 .2rem;
    }

    .info-item .info-value {
        font-size: .84rem;
        font-weight: 500;
        color: var(--mp-text);
        margin: 0;
        line-height: 1.45;
        word-break: break-word;
    }

    /* Role tags */
    .role-tag {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .28rem .65rem;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 600;
        background: var(--mp-soft);
        color: var(--mp-muted);
        border: 1px solid var(--mp-border);
        margin: 2px 3px 2px 0;
        transition: transform .18s ease, border-color .18s ease, color .18s ease;
    }

    .role-tag i { font-size: .58rem; opacity: .85; }

    .role-tag:hover {
        transform: translateY(-1px);
        border-color: var(--mp-primary);
        color: var(--mp-primary);
    }

    .role-tag.choir {
        background: var(--mp-amber-soft);
        color: var(--mp-amber);
        border-color: transparent;
    }

    .role-tag.choir:hover {
        color: var(--mp-amber);
        border-color: var(--mp-amber);
    }

    .no-roles {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .78rem;
        color: var(--mp-muted);
        font-style: italic;
    }

    .no-roles a {
        font-style: normal;
        font-weight: 600;
        color: var(--mp-primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .25rem;
    }

    .no-roles a:hover { text-decoration: underline; }
    .no-roles a i { font-size: .6rem; }

    /* ---------------- SWEETALERT CUSTOM (kept identical) ---------------- */
    .swal2-custom-delete {
        border-radius: 20px !important;
        padding: 2rem 1.5rem !important;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15) !important;
    }

    .swal2-custom-delete .swal2-icon {
        border: none !important;
        background: linear-gradient(135deg, #fef2f2, #fee2e2) !important;
        padding: 20px !important;
        border-radius: 50% !important;
        width: 80px !important;
        height: 80px !important;
        margin: 0 auto 1.2rem !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        animation: deletePulse 2s infinite !important;
    }

    @keyframes deletePulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.2); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 15px rgba(239, 68, 68, 0); }
    }

    .swal2-custom-delete .swal2-icon .swal2-x-mark { display: none !important; }

    .swal2-custom-delete .swal2-icon .swal2-icon-content {
        font-size: 2.5rem !important;
        color: #EF4444 !important;
        font-weight: 300 !important;
    }

    .swal2-custom-delete .swal2-title {
        font-size: 1.4rem !important;
        font-weight: 800 !important;
        color: #1e293b !important;
        font-family: 'Inter', sans-serif !important;
        margin-bottom: 0.3rem !important;
    }

    [data-theme="dark"] .swal2-custom-delete .swal2-title { color: #f1f5f9 !important; }

    .swal2-custom-delete .swal2-html-container {
        font-size: 0.9rem !important;
        color: #64748b !important;
        margin-bottom: 1.2rem !important;
        font-family: 'Inter', sans-serif !important;
        line-height: 1.6 !important;
    }

    [data-theme="dark"] .swal2-custom-delete .swal2-html-container { color: #94a3b8 !important; }

    .swal2-custom-delete .swal2-html-container .member-name-highlight {
        color: #EF4444 !important;
        font-weight: 700 !important;
        background: #fef2f2 !important;
        padding: 2px 12px !important;
        border-radius: 6px !important;
        display: inline-block !important;
    }

    [data-theme="dark"] .swal2-custom-delete .swal2-html-container .member-name-highlight {
        background: #7f1d1d !important;
        color: #fca5a5 !important;
    }

    .swal2-custom-delete .swal2-html-container .warning-box {
        background: #fef3c7 !important;
        border: 1px solid #fcd34d !important;
        border-radius: 10px !important;
        padding: 0.8rem 1rem !important;
        margin-top: 0.8rem !important;
        font-size: 0.8rem !important;
        color: #92400e !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    [data-theme="dark"] .swal2-custom-delete .swal2-html-container .warning-box {
        background: #78350f !important;
        border-color: #92400e !important;
        color: #fde68a !important;
    }

    .swal2-custom-delete .swal2-html-container .warning-box i {
        font-size: 1rem !important;
        color: #f59e0b !important;
    }

    .swal2-custom-delete .swal2-actions { gap: 0.8rem !important; margin-top: 0.5rem !important; }

    .swal2-custom-delete .swal2-confirm {
        background: linear-gradient(135deg, #EF4444, #DC2626) !important;
        padding: 0.7rem 2.5rem !important;
        border-radius: 12px !important;
        font-weight: 700 !important;
        font-size: 0.85rem !important;
        font-family: 'Inter', sans-serif !important;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3) !important;
        transition: all 0.3s ease !important;
        border: none !important;
        letter-spacing: 0.3px !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
    }

    .swal2-custom-delete .swal2-confirm:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4) !important;
    }

    .swal2-custom-delete .swal2-confirm:active { transform: scale(0.97) !important; }

    .swal2-custom-delete .swal2-cancel {
        background: var(--bg-tertiary) !important;
        color: var(--text-secondary) !important;
        padding: 0.7rem 2rem !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        font-size: 0.85rem !important;
        font-family: 'Inter', sans-serif !important;
        border: 1px solid var(--border-color) !important;
        transition: all 0.3s ease !important;
    }

    .swal2-custom-delete .swal2-cancel:hover {
        background: var(--bg-tertiary) !important;
        transform: translateY(-2px) !important;
    }

    .swal2-custom-delete .swal2-timer-progress-bar {
        background: linear-gradient(90deg, #EF4444, #F87171) !important;
        height: 3px !important;
    }

    /* ---------------- RESPONSIVE ---------------- */
    @media (max-width: 992px) {
        .profile-main-layout { flex-direction: column; }
        .profile-left { flex: 1; min-width: 0; }
    }

    @media (max-width: 768px) {
        .mp-head { flex-direction: column; align-items: flex-start; }
        .mp-head-left { width: 100%; }
        .mp-head-actions { width: 100%; }
        .mp-head-actions .mp-btn { flex: 1; justify-content: center; }

        .mp-head-avatar { width: 52px; height: 52px; border-radius: 16px; font-size: 1.1rem; }
        .mp-title { font-size: 1.25rem; }

        .quick-actions-horizontal { flex-direction: column; }
        .quick-action-btn { min-width: 0; width: 100%; }

        .name-card .avatar-large { width: 72px; height: 72px; font-size: 1.6rem; }
        .name-card .member-name { font-size: 1.05rem; }

        .info-card .card-header { padding: .7rem 1rem; }
        .info-card .card-body { padding: .25rem 1rem 1rem; }

        .swal2-custom-delete { padding: 1.5rem 1rem !important; margin: 0 0.5rem !important; }
        .swal2-custom-delete .swal2-icon { width: 60px !important; height: 60px !important; padding: 15px !important; }
        .swal2-custom-delete .swal2-icon .swal2-icon-content { font-size: 2rem !important; }
        .swal2-custom-delete .swal2-title { font-size: 1.2rem !important; }
        .swal2-custom-delete .swal2-actions { flex-direction: column !important; width: 100% !important; }
        .swal2-custom-delete .swal2-confirm,
        .swal2-custom-delete .swal2-cancel { width: 100% !important; justify-content: center !important; }
    }

    @media (max-width: 480px) {
        .name-card { padding: 1.2rem 1rem; }
        .name-card .avatar-large { width: 62px; height: 62px; border-radius: 18px; font-size: 1.4rem; }
    }
</style>

<div class="mp container-fluid px-0">

    {{-- ============================================
         HERO SECTION
    ============================================ --}}
    <header class="mp-head">
        <div class="mp-head-left">
            <div class="mp-head-avatar">
                <i class="fas fa-user-circle" style="font-size: 1.8rem;"></i>
            </div>
            <div style="min-width:0;">
                <div class="mp-eyebrow">
                    <span class="mp-dot"></span>
                    <span data-i18n="member_directory">{{ __("Member Directory") }}</span>
                </div>
                <h1 class="mp-title">
                    <i class="fas fa-id-card"></i>
                    <span data-i18n="member_profile">{{ __("Member Profile") }}</span>
                </h1>
                <p class="mp-sub">
                    <span>
                        <i class="fas fa-id-card"></i>
                        <span data-i18n="id_label">{{ __("ID:") }}</span>
                        {{ str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="mp-sep">·</span>
                    <span class="mp-status {{ $member->is_deceased ? 'deceased' : 'active' }}">
                        @if($member->is_deceased)
                            <i class="fas fa-cross"></i>
                        @endif
                        <span data-i18n="{{ $member->is_deceased ? 'deceased' : 'active' }}">
                            {{ $member->is_deceased ? __("Deceased") : __("Active") }}
                        </span>
                    </span>
                </p>
            </div>
        </div>
        <div class="mp-head-actions">
            <a href="{{ route('members.edit', $member->id) }}" class="mp-btn mp-btn-primary">
                <i class="fas fa-edit"></i>
                <span data-i18n="edit_profile">{{ __("Edit Profile") }}</span>
            </a>
            <a href="{{ route('members.index') }}" class="mp-btn mp-btn-ghost">
                <i class="fas fa-arrow-left"></i>
                <span data-i18n="back_to_members">{{ __("Back to Members") }}</span>
            </a>
        </div>
    </header>

    {{-- ============================================
         QUICK ACTIONS (horizontal — unchanged structure)
    ============================================ --}}
    <div class="quick-actions-horizontal">
        @if($member->is_deceased)
            <a href="#" class="quick-action-btn restore" onclick="confirmRestore({{ $member->id }}); return false;">
                <i class="fas fa-undo-alt"></i>
                <span data-i18n="restore_to_active">{{ __("Restore to Active") }}</span>
            </a>
        @endif
    </div>

    {{-- ============================================
         MAIN LAYOUT
    ============================================ --}}
    <div class="profile-main-layout">

        {{-- ---------- LEFT: NAME CARD ---------- --}}
        <div class="profile-left">
            <div class="name-card">
                <div class="avatar-large">
                    {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
                </div>
                <h2 class="member-name">
                    {{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}
                </h2>
                <p class="member-id">
                    <i class="fas fa-id-card"></i>
                    <span data-i18n="id_label">{{ __("ID:") }}</span>
                    {{ str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                </p>

                <div class="name-divider"></div>

                <div>
                    <span class="status-badge {{ $member->is_deceased ? 'deceased' : 'active' }}">
                        @if($member->is_deceased)
                            <i class="fas fa-cross" style="font-size:.58rem;"></i>
                        @endif
                        <span data-i18n="{{ $member->is_deceased ? 'deceased' : 'active' }}">
                            {{ $member->is_deceased ? __("Deceased") : __("Active") }}
                        </span>
                    </span>
                </div>

                <div>
                    @php
                        $genderValue = $member->gender ?? null;
                        if ($genderValue === 'male') {
                            $genderIcon = 'fa-mars';
                            $genderKey = 'male';
                            $genderClass = 'male';
                        } elseif ($genderValue === 'female') {
                            $genderIcon = 'fa-venus';
                            $genderKey = 'female';
                            $genderClass = 'female';
                        } else {
                            $genderIcon = 'fa-circle';
                            $genderKey = 'not_specified';
                            $genderClass = 'unspecified';
                        }
                    @endphp
                    <span class="gender-badge {{ $genderClass }}">
                        <i class="fas {{ $genderIcon }}"></i>
                        <span data-i18n="{{ $genderKey }}">
                            {{ __(ucfirst(str_replace('_', ' ', $genderKey))) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        {{-- ---------- RIGHT: PERSONAL INFORMATION ---------- --}}
        <div class="profile-right">
            <div class="info-card">
                <div class="card-header">
                    <h6>
                        <i class="fas fa-user-circle"></i>
                        <span data-i18n="personal_information">{{ __("Personal Information") }}</span>
                    </h6>
                    <span class="member-since">
                        <i class="fas fa-clock"></i>
                        {{ \Carbon\Carbon::parse($member->created_at ?? now())->format('M d, Y') }}
                    </span>
                </div>
                <div class="card-body">

                    {{-- Birthday --}}
                    <div class="info-item">
                        <div class="info-icon pink"><i class="fas fa-birthday-cake"></i></div>
                        <div class="info-content">
                            <p class="info-label">
                                <span data-i18n="birthday_label">{{ __("Birthday") }}</span>
                            </p>
                            <p class="info-value">
                                @if($member->birthday)
                                    {{ \Carbon\Carbon::parse($member->birthday)->format('F d, Y') }}
                                    <span style="font-size: .7rem; font-weight: 400; color: var(--mp-muted);">
                                        ({{ \Carbon\Carbon::parse($member->birthday)->age }} {{ __("years old") }})
                                    </span>
                                @else
                                    <span style="color:var(--mp-muted); font-style:italic; font-weight:400;">N/A</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="info-item">
                        <div class="info-icon green"><i class="fas fa-phone"></i></div>
                        <div class="info-content">
                            <p class="info-label">
                                <span data-i18n="phone_label">{{ __("Phone Number") }}</span>
                            </p>
                            <p class="info-value">
                                {{ $member->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="info-item">
                        <div class="info-icon orange"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <p class="info-label">
                                <span data-i18n="email_label">{{ __("Email Address") }}</span>
                            </p>
                            <p class="info-value">
                                {{ $member->email ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="info-item">
                        <div class="info-icon teal"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <p class="info-label">
                                <span data-i18n="address_label">{{ __("Address") }}</span>
                            </p>
                            <p class="info-value">
                                {{ $member->address ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    {{-- Roles --}}
                    <div class="info-item">
                        <div class="info-icon roles"><i class="fas fa-tags"></i></div>
                        <div class="info-content">
                            <p class="info-label">
                                <span data-i18n="roles_label">{{ __("Roles & Responsibilities") }}</span>
                            </p>
                            <div class="info-value">
                                @if($member->roles->count() > 0)
                                    <div class="d-flex flex-wrap" style="margin-top: 2px;">
                                        @foreach($member->roles as $role)
                                            <span class="role-tag">
                                                <i class="fas fa-shield-alt"></i>
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                        @if($member->is_choir)
                                            <span class="role-tag choir">
                                                <i class="fas fa-music"></i>
                                                <span data-i18n="choir_label">{{ __("Choir") }}</span>
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="no-roles">
                                        <span data-i18n="no_roles_assigned">{{ __("No roles assigned") }}</span>
                                        <a href="{{ route('members.edit', $member->id) }}">
                                            <i class="fas fa-plus"></i>
                                            <span data-i18n="add_label">{{ __("Add") }}</span>
                                        </a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ⭐ Helper function for translations
function t(key, fallback) {
    if (typeof window.t === 'function') {
        return window.t(key, fallback);
    }
    if (typeof window.__t === 'function') {
        return window.__t(key, fallback);
    }
    return fallback || key;
}

// ============================================
// MARK AS DECEASED
// ============================================
function confirmDeceased(memberId) {
    Swal.fire({
        title: t('mark_as_deceased', '⚠️ Mark as Deceased?'),
        html: `
            <div style="text-align: left;">
                <p>${t('mark_deceased_profile_confirm', 'Are you sure you want to mark this member as DECEASED?')}</p>
                <div class="mb-3">
                    <label class="form-label" style="display: block; text-align: left; margin-bottom: 5px;">${t('date_of_death', 'Date of Death:')}</label>
                    <input type="date" id="date_deceased_input" class="swal2-input" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #d1d5db;" max="${new Date().toISOString().split('T')[0]}" required>
                </div>
                <small style="color: #6b7280;">${t('action_cannot_be_undone', 'This action cannot be undone.')}</small>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: t('yes_mark_deceased', 'Yes, Mark Deceased'),
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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ date_deceased: dateDeceased })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: t('marked_deceased', '✅ Marked as Deceased'),
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
                    title: t('error', '❌ Error!'),
                    text: error.message,
                    confirmButtonColor: '#ef4444',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            });
        }
    });
}

// ============================================
// RESTORE MEMBER
// ============================================
function confirmRestore(memberId) {
    Swal.fire({
        title: t('restore_member', '🔄 Restore Member?'),
        text: t('restore_active_confirm', 'Are you sure you want to restore this member to ACTIVE status?'),
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6c757d',
        confirmButtonText: t('yes_restore', 'Yes, Restore!'),
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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: t('restored', '✅ Restored!'),
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
                    title: t('error', '❌ Error!'),
                    text: error.message,
                    confirmButtonColor: '#ef4444',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            });
        }
    });
}

// ============================================
// DELETE MEMBER - ENHANCED
// ============================================
function confirmDelete(memberId, memberName) {
    const memberDisplay = memberName || 'this member';

    Swal.fire({
        title: t('delete_member', 'Delete Member'),
        html: `
            <div style="text-align: left;">
                <p style="margin-bottom: 0.5rem;">
                    ${t('delete_confirm_text', 'Are you sure you want to permanently delete')}
                    <span class="member-name-highlight" style="color: #EF4444; font-weight: 700; background: #fef2f2; padding: 2px 12px; border-radius: 6px; display: inline-block;">
                        ${memberDisplay}
                    </span>
                    ?
                </p>
                <div class="warning-box" style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 10px; padding: 0.8rem 1rem; margin-top: 0.8rem; font-size: 0.8rem; color: #92400e; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 1rem; color: #f59e0b;"></i>
                    <span>${t('delete_warning', 'This action cannot be undone. All data associated with this member will be permanently removed.')}</span>
                </div>
            </div>
        `,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> ' + t('yes_delete', 'Delete Member'),
        cancelButtonText: '<i class="fas fa-times"></i> ' + t('cancel', 'Cancel'),
        customClass: {
            popup: 'swal2-custom-delete',
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel',
            icon: 'swal2-icon',
            title: 'swal2-title',
            htmlContainer: 'swal2-html-container',
            actions: 'swal2-actions'
        },
        timerProgressBar: true,
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: t('deleting', 'Deleting Member...'),
                html: `
                    <div style="text-align: center; padding: 1rem 0;">
                        <div style="width: 48px; height: 48px; border: 4px solid #e5e7eb; border-top-color: #EF4444; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 1rem;"></div>
                        <p style="color: #64748b; font-size: 0.9rem;">${t('please_wait', 'Please wait while we remove the member')}</p>
                    </div>
                    <style>
                        @keyframes spin {
                            to { transform: rotate(360deg); }
                        }
                    </style>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                background: 'var(--card-bg)',
                color: 'var(--text-primary)',
                customClass: {
                    popup: 'swal2-custom-delete'
                }
            });

            document.getElementById(`delete-form-${memberId}`).submit();
        }
    });
}

// ============================================
// ANIMATIONS
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.name-card, .info-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });
});

// ⭐ LISTEN FOR LANGUAGE CHANGES
window.addEventListener('localeChanged', function(e) {
    if (typeof window.applyTranslations === 'function') {
        window.applyTranslations();
    }
    console.log('[Member Show] Locale changed to:', e.detail.locale);
});
</script>
@endsection