@extends('layouts.app')

@section('header')
    <span data-i18n="messages_title">Messages</span>
@endsection

@section('content')

{{-- ============================================= --}}
{{-- STYLES --}}
{{-- ============================================= --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

    /* ═══════════════════════════════════════════════
       AURORA — Messenger Redesign
    ═══════════════════════════════════════════════ */
    .msg-app {
        --a-primary: #6366F1;
        --a-primary-2: #8B5CF6;
        --a-primary-3: #EC4899;
        --a-primary-hover: #4F46E5;
        --a-primary-soft: rgba(99, 102, 241, 0.10);
        --a-primary-soft-2: rgba(99, 102, 241, 0.18);

        --a-green: #10B981;
        --a-green-glow: rgba(16, 185, 129, 0.35);
        --a-rose: #F43F5E;

        --a-bg: var(--bg-primary, #f8f9fc);
        --a-card: var(--card-bg, #ffffff);
        --a-soft: var(--bg-tertiary, #f5f6fa);
        --a-border: var(--border-color, #e8eaf0);
        --a-text: var(--text-primary, #0f172a);
        --a-muted: var(--text-muted, #7c8494);

        --a-aurora: linear-gradient(135deg, #6366F1 0%, #8B5CF6 50%, #EC4899 100%);
        --a-aurora-soft: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, rgba(139,92,246,0.06) 50%, rgba(236,72,153,0.05) 100%);

        --a-r-sm: 10px;
        --a-r-md: 14px;
        --a-r-lg: 20px;
        --a-r-xl: 28px;

        --a-sh-sm: 0 1px 2px rgba(15, 23, 42, 0.05);
        --a-sh-md: 0 12px 32px -14px rgba(15, 23, 42, 0.18);
        --a-sh-lg: 0 30px 70px -28px rgba(99, 102, 241, 0.42);

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--a-text);
    }

    [data-theme="dark"] .msg-app {
        --a-primary: #818CF8;
        --a-primary-2: #A78BFA;
        --a-primary-hover: #A5B4FC;
        --a-primary-soft: rgba(129, 140, 248, 0.14);
        --a-primary-soft-2: rgba(129, 140, 248, 0.26);

        --a-green: #34D399;
        --a-rose: #FB7185;

        --a-bg: var(--bg-primary, #0f0f1a);
        --a-card: var(--card-bg, #1a1a2b);
        --a-soft: var(--bg-tertiary, #22223a);
        --a-border: var(--border-color, #2a2a45);
        --a-text: var(--text-primary, #f1f5f9);
        --a-muted: var(--text-muted, #94a3b8);

        --a-aurora-soft: linear-gradient(135deg, rgba(129,140,248,0.14) 0%, rgba(167,139,250,0.10) 50%, rgba(244,114,182,0.08) 100%);

        --a-sh-md: 0 12px 32px -14px rgba(0, 0, 0, 0.7);
        --a-sh-lg: 0 30px 70px -28px rgba(0, 0, 0, 0.9);
    }

    .msg-app * { box-sizing: border-box; }

    /* ─── Animations ─── */
    @keyframes aFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes aFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes aSlideIn {
        from { opacity: 0; transform: translateX(-8px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes aBubbleIn {
        0%   { opacity: 0; transform: translateY(8px) scale(0.97); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes aPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.15); opacity: 0.75; }
    }
    @keyframes aRing {
        0%   { transform: scale(0.9); opacity: 0.9; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    @keyframes aSpin { to { transform: rotate(360deg); } }
    @keyframes aShake {
        0%, 100% { transform: translateX(0); }
        25%      { transform: translateX(-6px); }
        75%      { transform: translateX(6px); }
    }
    @keyframes aHighlight {
        0%, 100% { background: transparent; }
        35%      { background: var(--a-primary-soft-2); }
    }
    @keyframes aToastTimer {
        from { transform: scaleX(1); }
        to   { transform: scaleX(0); }
    }
    @keyframes aAuroraShift {
        0%, 100% { background-position: 0% 50%; }
        50%      { background-position: 100% 50%; }
    }

    /* ═══════════════════════════════════════════════
       HERO
    ═══════════════════════════════════════════════ */
    .msg-hero {
        position: relative;
        padding: 1.15rem 1.4rem;
        border-radius: var(--a-r-xl);
        background: var(--a-aurora);
        background-size: 200% 200%;
        animation: aAuroraShift 12s ease infinite, aFadeUp 0.5s ease both;
        color: #fff;
        margin-bottom: 1.25rem;
        box-shadow: var(--a-sh-lg);
        overflow: hidden;
        isolation: isolate;
    }

    .msg-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 5%;
        right: 5%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
        opacity: 0.7;
    }

    .msg-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 15% 10%, rgba(255,255,255,0.22), transparent 40%),
            radial-gradient(circle at 85% 90%, rgba(255,255,255,0.12), transparent 45%);
        pointer-events: none;
        z-index: -1;
    }

    .msg-hero-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.1rem;
        flex-wrap: wrap;
    }

    .msg-hero-left {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
        flex: 1;
    }

    .msg-hero-orb {
        position: relative;
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.18);
        border: 1.5px solid rgba(255, 255, 255, 0.28);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        font-size: 1.1rem;
        color: #fff;
    }
    .msg-hero-orb::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        animation: aRing 2.8s ease-out infinite;
    }

    .msg-hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
        min-width: 0;
    }

    .msg-hero-title {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }

    .msg-hero-sub {
        margin: 0;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.82);
        font-weight: 400;
        line-height: 1.4;
    }

    .msg-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        margin-top: 0.15rem;
        font-size: 0.71rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
    }
    .msg-hero-badge .dot {
        position: relative;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #6EE7B7;
        box-shadow: 0 0 0 2px rgba(110, 231, 183, 0.25), 0 0 12px rgba(110, 231, 183, 0.8);
    }
    .msg-hero-badge .dot::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        border: 1.5px solid rgba(110, 231, 183, 0.5);
        animation: aRing 2.4s ease-out infinite;
    }

    .msg-hero-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .msg-hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.15rem;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        white-space: nowrap;
        letter-spacing: -0.005em;
    }

    .msg-hero-btn.primary {
        background: #fff;
        color: var(--a-primary-hover);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.14);
    }
    .msg-hero-btn.primary:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.22);
        color: var(--a-primary-hover);
    }

    .msg-hero-btn.ghost {
        background: rgba(255, 255, 255, 0.14);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.26);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    .msg-hero-btn.ghost:hover {
        background: rgba(255, 255, 255, 0.26);
        color: #fff;
        transform: translateY(-2px);
    }

    /* ═══════════════════════════════════════════════
       MESSENGER SHELL
    ═══════════════════════════════════════════════ */
    .messenger-container {
        position: relative;
        display: flex;
        height: calc(100vh - 235px);
        min-height: 560px;
        max-height: 820px;
        background: var(--a-card);
        border: 1px solid var(--a-border);
        border-radius: var(--a-r-xl);
        overflow: hidden;
        box-shadow: var(--a-sh-md);
        animation: aFadeUp 0.6s ease 0.08s both;
    }

    .messenger-container::before {
        content: '';
        position: absolute;
        inset: -1px;
        border-radius: inherit;
        padding: 1px;
        background: var(--a-aurora-soft);
        -webkit-mask:
            linear-gradient(#fff 0 0) content-box,
            linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
                mask-composite: exclude;
        pointer-events: none;
        opacity: 0.9;
    }

    /* ═══════════════════════════════════════════════
       SIDEBAR
    ═══════════════════════════════════════════════ */
    .msg-sidebar {
        width: 320px;
        min-width: 280px;
        flex-shrink: 0;
        background: var(--a-card);
        border-right: 1px solid var(--a-border);
        display: flex;
        flex-direction: column;
        min-height: 0;
        position: relative;
        z-index: 1;
    }

    .msg-sidebar-header {
        padding: 1rem 1.1rem 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        border-bottom: 1px solid var(--a-border);
    }

    .msg-sidebar-title {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        margin: 0;
        font-size: 0.92rem;
        font-weight: 700;
        color: var(--a-text);
        letter-spacing: -0.02em;
    }

    .msg-sidebar-title i {
        display: grid;
        place-items: center;
        width: 26px;
        height: 26px;
        border-radius: 8px;
        background: var(--a-aurora-soft);
        color: var(--a-primary);
        font-size: 0.72rem;
        border: 1px solid var(--a-border);
    }

    .msg-badge-total {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 22px;
        height: 22px;
        padding: 0 8px;
        border-radius: 11px;
        background: var(--a-aurora);
        color: #fff;
        font-size: 0.66rem;
        font-weight: 700;
        margin-left: 0.1rem;
        box-shadow: 0 4px 12px -4px rgba(99, 102, 241, 0.6);
    }

    .msg-icon-btn {
        width: 32px;
        height: 32px;
        display: grid;
        place-items: center;
        border-radius: 9px;
        border: 1px solid var(--a-border);
        background: transparent;
        color: var(--a-muted);
        cursor: pointer;
        font-size: 0.8rem;
        transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .msg-icon-btn:hover {
        background: var(--a-primary-soft);
        color: var(--a-primary);
        border-color: transparent;
        transform: translateY(-1px) scale(1.05);
    }

    .msg-sidebar-search {
        padding: 0.7rem 1rem 0.85rem;
    }

    .msg-search-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .msg-search-wrap i {
        position: absolute;
        left: 15px;
        color: var(--a-muted);
        font-size: 0.76rem;
        opacity: 0.65;
        pointer-events: none;
    }

    .msg-search-wrap input {
        width: 100%;
        padding: 0.6rem 1rem 0.6rem 2.5rem;
        border-radius: 50px;
        border: 1px solid var(--a-border);
        background: var(--a-soft);
        color: var(--a-text);
        font-size: 0.79rem;
        font-family: inherit;
        outline: none;
        transition: all 0.22s ease;
    }
    .msg-search-wrap input:focus {
        border-color: var(--a-primary);
        background: var(--a-card);
        box-shadow: 0 0 0 4px var(--a-primary-soft);
    }
    .msg-search-wrap input::placeholder {
        color: var(--a-muted);
        opacity: 0.7;
    }

    .msg-church-list {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 0.35rem 0.5rem 0.85rem;
    }

    .msg-church-list::-webkit-scrollbar { width: 5px; }
    .msg-church-list::-webkit-scrollbar-track { background: transparent; }
    .msg-church-list::-webkit-scrollbar-thumb {
        background: var(--a-border);
        border-radius: 5px;
    }
    .msg-church-list::-webkit-scrollbar-thumb:hover { background: var(--a-muted); }

    .msg-church-item {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.7rem 1rem 0.7rem 0.85rem;
        margin: 0.15rem 0;
        border-radius: var(--a-r-md);
        cursor: pointer;
        transition: background 0.22s ease;
        animation: aSlideIn 0.35s ease both;
    }

    .msg-church-item:hover {
        background: var(--a-soft);
    }

    .msg-church-item.active {
        background: var(--a-primary-soft);
    }

    .msg-church-item::after {
        content: '';
        position: absolute;
        right: 0;
        top: 30%;
        bottom: 30%;
        width: 3px;
        border-radius: 3px;
        background: var(--a-aurora);
        opacity: 0;
        transform: scaleY(0.4);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .msg-church-item.active::after {
        opacity: 1;
        transform: scaleY(1);
    }

    .msg-church-item.flash {
        animation: aHighlight 1.3s ease;
    }

    .msg-avatar {
        position: relative;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 0.92rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        background: var(--a-aurora);
        box-shadow: 0 6px 16px -8px rgba(99, 102, 241, 0.5);
        transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .msg-church-item:hover .msg-avatar {
        transform: scale(1.06) rotate(-3deg);
    }

    .msg-avatar .online-dot {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--a-green);
        border: 2.5px solid var(--a-card);
        box-shadow: 0 0 0 2px var(--a-green-glow);
    }

    .msg-church-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .msg-church-name {
        font-size: 0.84rem;
        font-weight: 600;
        color: var(--a-text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        letter-spacing: -0.005em;
    }

    .msg-church-last {
        font-size: 0.73rem;
        color: var(--a-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4;
    }

    .msg-church-last.has-unread {
        color: var(--a-text);
        font-weight: 500;
    }

    .msg-church-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.28rem;
        flex-shrink: 0;
        padding-right: 0.5rem;
    }

    .msg-church-time {
        font-size: 0.66rem;
        color: var(--a-muted);
        font-weight: 500;
        letter-spacing: 0.01em;
    }

    .msg-church-unread {
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        background: var(--a-aurora);
        color: #fff;
        font-size: 0.64rem;
        font-weight: 700;
        box-shadow: 0 4px 12px -4px rgba(99, 102, 241, 0.7);
        animation: aBubbleIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .msg-sidebar-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--a-muted);
    }
    .msg-sidebar-empty i {
        font-size: 2.2rem;
        opacity: 0.22;
        margin-bottom: 0.85rem;
        color: var(--a-primary);
    }
    .msg-sidebar-empty p {
        font-size: 0.8rem;
        margin: 0;
    }

    /* ═══════════════════════════════════════════════
       MAIN CHAT
    ═══════════════════════════════════════════════ */
    .msg-main {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        background: var(--a-bg);
        position: relative;
    }

    .msg-main::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--a-aurora-soft);
        opacity: 0.5;
        pointer-events: none;
        z-index: 0;
    }

    .msg-main-header {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.15rem;
        background: var(--a-card);
        border-bottom: 1px solid var(--a-border);
        min-height: 64px;
        flex-shrink: 0;
    }

    .msg-main-header .msg-avatar {
        width: 38px;
        height: 38px;
        font-size: 0.82rem;
    }

    .msg-chat-info {
        flex: 1;
        min-width: 0;
    }

    .msg-chat-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--a-text);
        letter-spacing: -0.015em;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .msg-chat-status {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.7rem;
        color: var(--a-muted);
        margin-top: 0.12rem;
        font-weight: 500;
    }

    .msg-chat-status .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--a-muted);
        flex-shrink: 0;
    }

    .msg-chat-status.online {
        color: var(--a-green);
    }

    .msg-chat-status.online .status-dot {
        background: var(--a-green);
        box-shadow: 0 0 0 3px var(--a-green-glow);
        animation: aPulse 2s ease-in-out infinite;
    }

    .msg-messages {
        position: relative;
        z-index: 1;
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 1.2rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.28rem;
    }

    .msg-messages::-webkit-scrollbar { width: 6px; }
    .msg-messages::-webkit-scrollbar-track { background: transparent; }
    .msg-messages::-webkit-scrollbar-thumb {
        background: var(--a-border);
        border-radius: 6px;
    }
    .msg-messages::-webkit-scrollbar-thumb:hover { background: var(--a-muted); }

    .msg-date-divider {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0.9rem 0 0.6rem;
        animation: aFadeIn 0.35s ease;
    }

    .msg-date-divider span {
        display: inline-block;
        padding: 0.3rem 0.9rem;
        border-radius: 20px;
        background: var(--a-card);
        border: 1px solid var(--a-border);
        color: var(--a-muted);
        font-size: 0.66rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        box-shadow: var(--a-sh-sm);
        white-space: nowrap;
    }

    /* ─── Bubbles ─── */
    .msg-bubble {
        position: relative;
        max-width: 68%;
        padding: 0.65rem 1rem 0.55rem;
        border-radius: 18px;
        font-size: 0.85rem;
        line-height: 1.55;
        word-wrap: break-word;
        overflow-wrap: anywhere;
    }

    .msg-bubble.sent {
        align-self: flex-end;
        background: var(--a-aurora);
        background-size: 150% 150%;
        color: #fff;
        border-bottom-right-radius: 6px;
        box-shadow: 0 8px 22px -12px rgba(99, 102, 241, 0.9);
        animation: aBubbleIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }

    .msg-bubble.sent::after {
        content: '';
        position: absolute;
        right: -8px;
        bottom: 0;
        width: 14px;
        height: 14px;
        background: #EC4899;
        border-bottom-left-radius: 14px;
        z-index: -1;
        mask: radial-gradient(circle at 0 100%, transparent 70%, #000 72%);
        -webkit-mask: radial-gradient(circle at 0 100%, transparent 70%, #000 72%);
    }

    .msg-bubble.received {
        align-self: flex-start;
        background: var(--a-card);
        color: var(--a-text);
        border: 1px solid var(--a-border);
        border-bottom-left-radius: 6px;
        box-shadow: var(--a-sh-sm);
        animation: aBubbleIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) both;
    }

    .msg-bubble.received::after {
        content: '';
        position: absolute;
        left: -8px;
        bottom: 0;
        width: 14px;
        height: 14px;
        background: var(--a-card);
        border-bottom-right-radius: 14px;
        border-left: 1px solid var(--a-border);
        border-bottom: 1px solid var(--a-border);
        z-index: -1;
    }

    .msg-bubble .body { font-size: 0.85rem; }

    .msg-bubble .time {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.28rem;
        margin-top: 0.3rem;
        font-size: 0.64rem;
        font-weight: 500;
        opacity: 0.75;
        letter-spacing: 0.015em;
    }

    .msg-bubble.sent .time { color: rgba(255, 255, 255, 0.92); }
    .msg-bubble.received .time { color: var(--a-muted); }
    .msg-bubble .status-icon i { font-size: 0.62rem; }

    .msg-empty-main {
        position: relative;
        z-index: 1;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.5rem;
        text-align: center;
        color: var(--a-muted);
        animation: aFadeIn 0.4s ease;
    }

    .msg-empty-main i {
        position: relative;
        font-size: 3.2rem;
        color: var(--a-primary);
        opacity: 0.18;
        margin-bottom: 1rem;
    }

    .msg-empty-main h4 {
        margin: 0 0 0.35rem;
        font-size: 1rem;
        font-weight: 700;
        color: var(--a-text);
        letter-spacing: -0.015em;
    }

    .msg-empty-main p {
        margin: 0;
        font-size: 0.82rem;
        max-width: 340px;
        line-height: 1.6;
    }

    .msg-empty-main .btn-compose-empty {
        margin-top: 1rem;
        padding: 0.65rem 1.4rem;
        border-radius: 50px;
        border: none;
        background: var(--a-aurora);
        color: #fff;
        font-weight: 700;
        font-size: 0.78rem;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 8px 22px -10px rgba(99, 102, 241, 0.9);
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .msg-empty-main .btn-compose-empty:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 14px 32px -10px rgba(99, 102, 241, 0.9);
    }

    /* ─── Compose ─── */
    .msg-compose {
        position: relative;
        z-index: 1;
        padding: 0.75rem 1.15rem 0.95rem;
        background: var(--a-card);
        border-top: 1px solid var(--a-border);
        flex-shrink: 0;
    }

    .msg-compose-wrap {
        position: relative;
        display: flex;
        align-items: flex-end;
        gap: 0.55rem;
        padding: 0.35rem 0.4rem 0.35rem 0.95rem;
        background: var(--a-soft);
        border: 1px solid var(--a-border);
        border-radius: 16px;
        transition: all 0.22s ease;
    }

    .msg-compose-wrap::before {
        content: '›';
        position: absolute;
        left: 0.55rem;
        top: 50%;
        transform: translateY(-50%);
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--a-primary);
        opacity: 0.55;
        pointer-events: none;
        transition: opacity 0.22s ease;
    }

    .msg-compose-wrap:focus-within {
        border-color: var(--a-primary);
        background: var(--a-card);
        box-shadow: 0 0 0 4px var(--a-primary-soft);
    }
    .msg-compose-wrap:focus-within::before {
        opacity: 1;
    }

    .msg-compose-inputs {
        flex: 1;
        min-width: 0;
        padding: 0.35rem 0 0.35rem 0.85rem;
    }

    .msg-compose-inputs input {
        width: 100%;
        border: none;
        background: transparent;
        outline: none;
        color: var(--a-text);
        font-size: 0.85rem;
        font-family: inherit;
        padding: 0.28rem 0;
    }
    .msg-compose-inputs input::placeholder {
        color: var(--a-muted);
        opacity: 0.7;
    }

    .msg-compose-actions {
        display: flex;
        align-items: center;
        gap: 0.15rem;
        flex-shrink: 0;
    }

    .msg-compose-actions button {
        width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: var(--a-muted);
        cursor: pointer;
        font-size: 0.82rem;
        transition: all 0.2s ease;
    }
    .msg-compose-actions button:hover {
        background: var(--a-primary-soft);
        color: var(--a-primary);
    }

    .msg-send-btn {
        width: 40px !important;
        height: 40px !important;
        border-radius: 12px !important;
        background: var(--a-aurora) !important;
        color: #fff !important;
        font-size: 0.85rem !important;
        box-shadow: 0 8px 20px -8px rgba(99, 102, 241, 0.9);
        transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
    }
    .msg-send-btn:hover {
        transform: translateY(-2px) scale(1.05);
        color: #fff !important;
        box-shadow: 0 12px 28px -8px rgba(99, 102, 241, 0.9);
    }
    .msg-send-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none !important;
    }

    /* ═══════════════════════════════════════════════
       TOAST
    ═══════════════════════════════════════════════ */
    .msg-toast {
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        z-index: 99999;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.85rem 1rem 1.05rem;
        background: var(--a-card);
        border: 1px solid var(--a-border);
        border-radius: 16px;
        box-shadow: var(--a-sh-lg);
        max-width: 380px;
        transform: translateX(140%);
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        font-family: 'Inter', sans-serif;
        overflow: hidden;
        isolation: isolate;
    }

    .msg-toast.show {
        transform: translateX(0);
    }

    .msg-toast::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--a-aurora);
    }

    .msg-toast::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--a-aurora);
        transform-origin: left;
        animation: aToastTimer 5s linear forwards;
    }

    .msg-toast-icon {
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: var(--a-aurora-soft);
        font-size: 1.05rem;
        border: 1px solid var(--a-border);
    }

    .msg-toast-content { flex: 1; min-width: 0; }

    .msg-toast-title {
        font-size: 0.79rem;
        font-weight: 700;
        color: var(--a-text);
        margin-bottom: 0.1rem;
        letter-spacing: -0.005em;
    }

    .msg-toast-msg {
        font-size: 0.73rem;
        color: var(--a-muted);
        line-height: 1.4;
        word-break: break-word;
    }

    .msg-toast-close {
        width: 26px;
        height: 26px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: var(--a-muted);
        cursor: pointer;
        font-size: 0.72rem;
        flex-shrink: 0;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .msg-toast-close:hover {
        background: var(--a-soft);
        color: var(--a-text);
    }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════ */
    @media (max-width: 992px) {
        .msg-sidebar { width: 280px; min-width: 240px; }
        .msg-bubble { max-width: 80%; }
    }

    @media (max-width: 768px) {
        .msg-hero { padding: 1rem 1.15rem; border-radius: var(--a-r-lg); }
        .msg-hero-orb { width: 40px; height: 40px; font-size: 0.95rem; }
        .msg-hero-title { font-size: 1.05rem; }
        .msg-hero-actions { width: 100%; }
        .msg-hero-btn { flex: 1; justify-content: center; }

        .messenger-container {
            flex-direction: column;
            height: calc(100vh - 220px);
            min-height: 500px;
            border-radius: var(--a-r-lg);
        }

        .msg-sidebar {
            width: 100%;
            min-width: 0;
            max-height: 230px;
            border-right: none;
            border-bottom: 1px solid var(--a-border);
        }

        .msg-avatar { width: 38px; height: 38px; font-size: 0.8rem; }
        .msg-church-name { font-size: 0.79rem; }
        .msg-church-last { font-size: 0.7rem; }

        .msg-messages { padding: 0.9rem 1rem; }
        .msg-bubble { max-width: 86%; font-size: 0.81rem; padding: 0.58rem 0.9rem 0.5rem; }
        .msg-bubble .body { font-size: 0.81rem; }

        .msg-compose { padding: 0.6rem 0.75rem 0.7rem; }
        .msg-send-btn { width: 36px !important; height: 36px !important; }

        .msg-toast {
            left: 1rem;
            right: 1rem;
            bottom: 1rem;
            max-width: none;
        }
    }

    @media (max-width: 480px) {
        .msg-hero-title { font-size: 0.98rem; }
        .msg-chat-name { font-size: 0.83rem; }
        .msg-empty-main i { font-size: 2.4rem; }
        .msg-empty-main h4 { font-size: 0.92rem; }
    }
</style>

{{-- ============================================= --}}
{{-- APP WRAPPER --}}
{{-- ============================================= --}}
<div class="msg-app">

    {{-- HERO --}}
    <div class="msg-hero">
        <div class="msg-hero-inner">
            <div class="msg-hero-left">
                <div class="msg-hero-orb">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <div class="msg-hero-copy">
                    <h1 class="msg-hero-title">
                        <span data-i18n="messages_title">Messages</span>
                    </h1>
                    <p class="msg-hero-sub" data-i18n="messages_desc">Communicate with other churches in your network</p>
                    <span class="msg-hero-badge">
                        <span class="dot"></span>
                        <span id="heroUnreadBadge">
                            <span data-i18n="unread_messages">{{ $unreadCount ?? 0 }} unread messages</span>
                        </span>
                    </span>
                </div>
            </div>
            <div class="msg-hero-actions">
                <button type="button" class="msg-hero-btn primary" onclick="toggleCompose()">
                    <i class="fas fa-feather"></i>
                    <span data-i18n="new_message">New Message</span>
                </button>
                <button type="button" class="msg-hero-btn ghost" onclick="refreshMessages()">
                    <i class="fas fa-arrows-rotate"></i>
                    <span data-i18n="refresh_label">Refresh</span>
                </button>
            </div>
        </div>
    </div>

    {{-- MESSENGER SHELL --}}
    <div class="messenger-container">

        {{-- SIDEBAR --}}
        <aside class="msg-sidebar">
            <div class="msg-sidebar-header">
                <h5 class="msg-sidebar-title">
                    <i class="fas fa-inbox"></i>
                    <span data-i18n="conversations">Conversations</span>
                    <span class="msg-badge-total" id="totalUnreadBadge">{{ $unreadCount ?? 0 }}</span>
                </h5>
                <button type="button" class="msg-icon-btn" onclick="refreshMessages()" title="Refresh">
                    <i class="fas fa-arrows-rotate"></i>
                </button>
            </div>

            <div class="msg-sidebar-search">
                <div class="msg-search-wrap">
                    <i class="fas fa-magnifying-glass"></i>
                    <input type="text" id="searchChurches" placeholder="{{ __('Search churches...') }}" onkeyup="filterChurches(this.value)">
                </div>
            </div>

            <div class="msg-church-list" id="churchList">
                @forelse($allChurches ?? [] as $church)
                    <div class="msg-church-item" data-church-id="{{ $church->id }}" onclick="loadConversation({{ $church->id }})">
                        <div class="msg-avatar" style="background: {{ $church->avatar_color ?? 'linear-gradient(135deg, #6366F1, #8B5CF6)' }};">
                            {{ $church->initials ?? strtoupper(substr($church->name ?? 'U', 0, 1)) }}
                            <span class="online-dot"></span>
                        </div>
                        <div class="msg-church-info">
                            <div class="msg-church-name">{{ $church->name ?? 'Unknown Church' }}</div>
                            <div class="msg-church-last" id="lastMsg-{{ $church->id }}">
                                <span data-i18n="no_messages_yet">No messages yet</span>
                            </div>
                        </div>
                        <div class="msg-church-meta">
                            <div class="msg-church-time" id="lastTime-{{ $church->id }}"></div>
                            @php $unread = $church->unread_count ?? 0; @endphp
                            @if($unread > 0)
                                <span class="msg-church-unread" id="unreadBadge-{{ $church->id }}">{{ $unread }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="msg-sidebar-empty">
                        <i class="fas fa-church"></i>
                        <p data-i18n="no_churches_found">No other churches found</p>
                    </div>
                @endforelse
            </div>
        </aside>

        {{-- MAIN --}}
        <main class="msg-main">

            <div class="msg-main-header" id="chatHeader">
                <div class="msg-avatar" id="chatAvatar" style="background: var(--a-aurora);">
                    <i class="fas fa-church"></i>
                </div>
                <div class="msg-chat-info">
                    <div class="msg-chat-name" id="chatName">
                        <span data-i18n="select_church">Select a Church</span>
                    </div>
                    <div class="msg-chat-status" id="chatStatus">
                        <span class="status-dot"></span>
                        <span data-i18n="choose_church_message">Choose a church to start messaging</span>
                    </div>
                </div>
                <button type="button" class="msg-icon-btn" onclick="toggleCompose()" title="New Message">
                    <i class="fas fa-feather"></i>
                </button>
            </div>

            <div class="msg-messages" id="messageList">
                <div class="msg-empty-main" id="emptyState">
                    <i class="fas fa-paper-plane"></i>
                    <h4 data-i18n="no_messages_selected">No messages selected</h4>
                    <p data-i18n="click_church_view">Click on a church from the sidebar to view the conversation</p>
                </div>
            </div>

            {{-- Compose (no subject input, no subject button) --}}
            <div class="msg-compose" id="msgCompose">
                <form id="messageForm" onsubmit="sendMessage(event)">
                    <input type="hidden" id="receiverId" value="">
                    <div class="msg-compose-wrap">
                        <div class="msg-compose-inputs">
                            <input type="text" id="messageInput" placeholder="{{ __('Type a message...') }}" required />
                        </div>
                        <div class="msg-compose-actions">
                            <button type="submit" class="msg-send-btn" id="sendBtn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

{{-- ============================================= --}}
{{-- TOAST --}}
{{-- ============================================= --}}
<div class="msg-toast" id="msgToast">
    <div class="msg-toast-icon" id="toastIcon">📨</div>
    <div class="msg-toast-content">
        <div class="msg-toast-title" id="toastTitle" data-i18n="new_message_title">New Message</div>
        <div class="msg-toast-msg" id="toastMessage" data-i18n="new_message_body">You have a new message</div>
    </div>
    <button type="button" class="msg-toast-close" onclick="closeToast()">
        <i class="fas fa-times"></i>
    </button>
</div>

{{-- ============================================= --}}
{{-- SCRIPTS --}}
{{-- ============================================= --}}
<script>
    // ============================================
    // STATE
    // ============================================
    let currentChurchId = null;
    let currentChurchName = '';
    let toastTimeout = null;

    // ============================================
    // TOAST
    // ============================================
    function showToast(title, message, icon = '📨') {
        const toast = document.getElementById('msgToast');
        if (!toast) return;

        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastIcon').textContent = icon;

        toast.classList.remove('show');
        void toast.offsetWidth;
        toast.classList.add('show');

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(function() {
            toast.classList.remove('show');
        }, 5000);
    }

    function closeToast() {
        const toast = document.getElementById('msgToast');
        if (toast) toast.classList.remove('show');
    }

    // ============================================
    // TOGGLE COMPOSE
    // ============================================
    function toggleCompose() {
        const receiverId = document.getElementById('receiverId').value;
        if (!receiverId) {
            const msg = window.t ? window.t('select_church_first') : 'Please select a church first';
            showToast(msg, window.t ? window.t('click_church_sidebar') : 'Click on a church from the sidebar', '💬');
            return;
        }

        const input = document.getElementById('messageInput');
        input.focus();
        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        input.style.animation = 'none';
        void input.offsetWidth;
        input.style.animation = 'aFadeUp 0.4s ease';
    }

    // ============================================
    // SIDEBAR HELPERS
    // ============================================
    function scrollChurchIntoView(churchId) {
        const item = document.querySelector(`.msg-church-item[data-church-id="${churchId}"]`);
        if (!item) return;
        item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function flashChurchItem(churchId) {
        const item = document.querySelector(`.msg-church-item[data-church-id="${churchId}"]`);
        if (!item) return;
        item.classList.remove('flash');
        void item.offsetWidth;
        item.classList.add('flash');
        setTimeout(() => item.classList.remove('flash'), 1300);
    }

    // ============================================
    // LOAD CONVERSATION
    // ============================================
    function loadConversation(churchId) {
        currentChurchId = churchId;

        document.querySelectorAll('.msg-church-item').forEach(el => {
            el.classList.remove('active');
            if (el.dataset.churchId == churchId) {
                el.classList.add('active');
                currentChurchName = el.querySelector('.msg-church-name').textContent;
            }
        });

        const church = document.querySelector(`.msg-church-item[data-church-id="${churchId}"]`);
        if (church) {
            const avatar = church.querySelector('.msg-avatar');
            const avatarBg = avatar.style.background;
            const avatarText = avatar.textContent.trim();

            document.getElementById('chatAvatar').style.background = avatarBg || 'var(--a-aurora)';
            document.getElementById('chatAvatar').textContent = avatarText || '?';
            document.getElementById('chatName').textContent = currentChurchName;
            const loadingMsg = window.t ? window.t('loading_messages') : 'Loading messages...';
            document.getElementById('chatStatus').innerHTML = `
                <span class="status-dot"></span> ${loadingMsg}
            `;
            document.getElementById('chatStatus').className = 'msg-chat-status';
        }

        document.getElementById('receiverId').value = churchId;

        const list = document.getElementById('messageList');
        const loadingMsg = window.t ? window.t('loading_messages') : 'Loading messages...';
        list.innerHTML = `
            <div class="msg-empty-main">
                <i class="fas fa-spinner" style="animation: aSpin 1s linear infinite; opacity: 0.35;"></i>
                <h4>${loadingMsg}</h4>
            </div>
        `;

        fetch(`/messages/conversation/${churchId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderMessages(data.messages);
                    const count = data.messages ? data.messages.length : 0;
                    const countMsg = count > 0 ? `${count} messages` : (window.t ? window.t('no_messages_yet') : 'No messages yet');
                    document.getElementById('chatStatus').innerHTML = `
                        <span class="status-dot"></span> ${countMsg}
                    `;
                    document.getElementById('chatStatus').className = 'msg-chat-status online';

                    if (data.messages && data.messages.length > 0) {
                        const lastMsg = data.messages[data.messages.length - 1];
                        const lastMsgEl = document.getElementById(`lastMsg-${churchId}`);
                        if (lastMsgEl) {
                            const msgBody = lastMsg.body || '';
                            lastMsgEl.textContent = msgBody.length > 50 ? msgBody.substring(0, 50) + '...' : msgBody;
                        }
                        const lastTimeEl = document.getElementById(`lastTime-${churchId}`);
                        if (lastTimeEl && lastMsg.created_at) {
                            const date = new Date(lastMsg.created_at);
                            lastTimeEl.textContent = date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                        }
                    }

                    const badge = document.getElementById(`unreadBadge-${churchId}`);
                    if (badge) {
                        badge.style.animation = 'aBubbleIn 0.3s ease reverse';
                        setTimeout(() => badge.remove(), 300);
                    }

                    updateTotalUnread();
                    updateHeroBadge();
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                const failedMsg = window.t ? window.t('failed_load_messages') : 'Failed to load messages';
                const retryMsg = window.t ? window.t('retry') : 'Retry';
                document.getElementById('messageList').innerHTML = `
                    <div class="msg-empty-main">
                        <i class="fas fa-triangle-exclamation" style="color:#f43f5e;opacity:0.5;"></i>
                        <h4>${failedMsg}</h4>
                        <p>${error.message}</p>
                        <button class="btn-compose-empty" onclick="loadConversation(${churchId})">
                            <i class="fas fa-arrows-rotate"></i> ${retryMsg}
                        </button>
                    </div>
                `;
                const errorMsg = window.t ? window.t('error_loading_messages') : 'Error loading messages';
                document.getElementById('chatStatus').innerHTML = `<span class="status-dot"></span> ${errorMsg}`;
                document.getElementById('chatStatus').className = 'msg-chat-status';
            });
    }

    // ============================================
    // RENDER MESSAGES — no subject
    // ============================================
    function renderMessages(messages, scrollToBottom = true) {
        const list = document.getElementById('messageList');
        const churchId = '{{ Auth::user()->church_id }}';

        if (!messages || messages.length === 0) {
            const noMsg = window.t ? window.t('no_messages_yet') : 'No messages yet';
            const startConvo = window.t ? window.t('start_conversation') : `Start a conversation with ${currentChurchName}`;
            list.innerHTML = `
                <div class="msg-empty-main">
                    <i class="fas fa-comment-dots"></i>
                    <h4>${noMsg}</h4>
                    <p>${startConvo}</p>
                </div>
            `;
            return;
        }

        let html = '';
        let lastDate = '';

        messages.forEach((msg, index) => {
            const isSent = msg.sender_church_id == churchId;
            const msgDate = new Date(msg.created_at);
            const dateStr = msgDate.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });

            if (dateStr !== lastDate) {
                html += `<div class="msg-date-divider"><span>${dateStr}</span></div>`;
                lastDate = dateStr;
            }

            const timeStr = msgDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            const delay = Math.min(index * 30, 320);

            // ⭐ Body only — no subject
            html += `
                <div class="msg-bubble ${isSent ? 'sent' : 'received'}" data-msg-id="${msg.id}" style="animation-delay: ${delay}ms;">
                    <div class="body">${escapeHtml(msg.body)}</div>
                    <div class="time">
                        ${timeStr}
                        ${isSent ? '<span class="status-icon"><i class="fas fa-check"></i></span>' : ''}
                    </div>
                </div>
            `;
        });

        list.innerHTML = html;

        if (scrollToBottom) {
            setTimeout(() => {
                list.scrollTop = list.scrollHeight;
            }, 100);
        }
    }

    // ============================================
    // APPEND NEW MESSAGE — no subject
    // ============================================
    function appendNewMessage(msg) {
        const list = document.getElementById('messageList');
        const churchId = '{{ Auth::user()->church_id }}';
        const isSent = msg.sender_church_id == churchId;

        const emptyState = list.querySelector('.msg-empty-main');
        if (emptyState) list.innerHTML = '';

        const lastDateEl = list.querySelector('.msg-date-divider:last-child');
        const msgDate = new Date(msg.created_at || Date.now());
        const dateStr = msgDate.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
        let lastDate = '';
        if (lastDateEl) lastDate = lastDateEl.textContent.trim();

        if (lastDate !== dateStr) {
            const divider = document.createElement('div');
            divider.className = 'msg-date-divider';
            divider.innerHTML = `<span>${dateStr}</span>`;
            list.appendChild(divider);
        }

        const timeStr = msgDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const bubble = document.createElement('div');
        bubble.className = `msg-bubble ${isSent ? 'sent' : 'received'}`;
        bubble.dataset.msgId = msg.id || Date.now();

        // ⭐ Body only — no subject
        bubble.innerHTML = `
            <div class="body">${escapeHtml(msg.body)}</div>
            <div class="time">
                ${timeStr}
                ${isSent ? '<span class="status-icon"><i class="fas fa-check"></i></span>' : ''}
            </div>
        `;

        list.appendChild(bubble);

        if (!isSent) {
            try {
                const audio = new Audio('/sounds/notification.mp3');
                audio.play().catch(() => {});
            } catch (e) {}
        }

        setTimeout(() => { list.scrollTop = list.scrollHeight; }, 100);

        const senderId = msg.sender_church_id == churchId ? msg.receiver_church_id : msg.sender_church_id;
        updateSidebarPreview(senderId, msg.body);
    }

    // ============================================
    // SIDEBAR PREVIEW UPDATER
    // ============================================
    function updateSidebarPreview(churchId, body) {
        const lastMsgEl = document.getElementById(`lastMsg-${churchId}`);
        if (lastMsgEl) {
            const text = (body || '').trim();
            lastMsgEl.textContent = text.length > 50 ? text.substring(0, 50) + '...' : text;
            lastMsgEl.classList.add('has-unread');
        }
        const lastTimeEl = document.getElementById(`lastTime-${churchId}`);
        if (lastTimeEl) {
            lastTimeEl.textContent = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
    }

    // ============================================
    // SEND MESSAGE — no subject
    // ============================================
    function sendMessage(event) {
        event.preventDefault();

        const receiverId = document.getElementById('receiverId').value;
        const body = document.getElementById('messageInput').value.trim();

        if (!body) {
            const msg = window.t ? window.t('type_message') : 'Please type a message';
            showToast(msg, window.t ? window.t('message_empty') : 'Your message cannot be empty', '⚠️');
            const inputEl = document.getElementById('messageInput');
            inputEl.style.animation = 'aShake 0.5s ease';
            setTimeout(() => { inputEl.style.animation = ''; }, 500);
            return;
        }

        if (!receiverId) {
            const msg = window.t ? window.t('select_church_first') : 'Please select a church';
            showToast(msg, window.t ? window.t('click_church_sidebar') : 'Click on a church from the sidebar', '💬');
            return;
        }

        const sendBtn = document.getElementById('sendBtn');
        const originalHtml = sendBtn.innerHTML;
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner" style="animation: aSpin 1s linear infinite;"></i>';

        document.getElementById('messageInput').value = '';

        const optimisticMsg = {
            id: 'temp_' + Date.now(),
            sender_church_id: '{{ Auth::user()->church_id }}',
            receiver_church_id: receiverId,
            body: body,
            created_at: new Date().toISOString(),
            is_new: true
        };
        appendNewMessage(optimisticMsg);

        fetch('{{ route("messages.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                receiver_church_id: receiverId,
                body: body
            })
        })
        .then(response => response.json())
        .then(data => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = originalHtml;

            if (data.success) {
                const sentMsg = window.t ? window.t('message_sent') : 'Message sent!';
                showToast(sentMsg, window.t ? window.t('message_delivered') : 'Your message was delivered successfully', '✅');
            } else {
                const failedMsg = window.t ? window.t('failed_to_send') : 'Failed to send';
                showToast(failedMsg, data.message || (window.t ? window.t('something_wrong') : 'Something went wrong'), '❌');
                if (currentChurchId) loadConversation(currentChurchId);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            sendBtn.disabled = false;
            sendBtn.innerHTML = originalHtml;
            const errMsg = window.t ? window.t('error_sending') : 'Error sending message';
            showToast(errMsg, window.t ? window.t('check_connection') : 'Please check your connection', '❌');
            if (currentChurchId) loadConversation(currentChurchId);
        });
    }

    // ============================================
    // FILTER CHURCHES
    // ============================================
    function filterChurches(query) {
        const items = document.querySelectorAll('.msg-church-item');
        const q = query.toLowerCase().trim();

        items.forEach((item, index) => {
            const name = item.querySelector('.msg-church-name').textContent.toLowerCase();
            const lastMsg = item.querySelector('.msg-church-last').textContent.toLowerCase();
            const match = name.includes(q) || lastMsg.includes(q) || q === '';

            if (match) {
                item.style.display = 'flex';
                item.style.animation = `aSlideIn 0.3s ease ${index * 20}ms both`;
            } else {
                item.style.display = 'none';
            }
        });
    }

    // ============================================
    // UNREAD TOTALS
    // ============================================
    function updateTotalUnread() {
        const badges = document.querySelectorAll('.msg-church-unread');
        let total = 0;
        badges.forEach(b => { total += parseInt(b.textContent) || 0; });

        const badge = document.getElementById('totalUnreadBadge');
        if (badge) {
            const oldValue = parseInt(badge.textContent) || 0;
            badge.textContent = total;
            if (total > oldValue) {
                badge.style.animation = 'none';
                void badge.offsetWidth;
                badge.style.animation = 'aBubbleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            }
            badge.style.display = total > 0 ? 'inline-flex' : 'none';
        }
    }

    function updateHeroBadge() {
        const badges = document.querySelectorAll('.msg-church-unread');
        let total = 0;
        badges.forEach(b => { total += parseInt(b.textContent) || 0; });

        const heroBadge = document.getElementById('heroUnreadBadge');
        if (heroBadge) {
            const label = window.t ? window.t('unread_messages') : 'unread messages';
            heroBadge.textContent = total + ' ' + label;
        }
    }

    // ============================================
    // REFRESH
    // ============================================
    function refreshMessages() {
        const btns = document.querySelectorAll('.msg-icon-btn');
        btns.forEach(btn => {
            btn.style.transform = 'rotate(360deg)';
            setTimeout(() => { btn.style.transform = ''; }, 500);
        });

        if (currentChurchId) {
            loadConversation(currentChurchId);
            const refreshing = window.t ? window.t('refreshing') : 'Refreshing...';
            showToast(refreshing, window.t ? window.t('getting_latest') : 'Getting latest messages', '🔄');
        } else {
            location.reload();
        }
    }

    // ============================================
    // ESCAPE HTML
    // ============================================
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }

    // ============================================
    // AUTO-DISPLAY ON INCOMING MESSAGE — no subject
    // ============================================
    if (window.Echo) {
        const churchId = '{{ Auth::user()->church_id }}';

        window.Echo.channel(`messages.${churchId}`)
            .listen('message.new', (e) => {
                console.log('📨 New message received:', e);

                const fromLabel = window.t ? window.t('from') : 'From';
                showToast(
                    `📨 ${fromLabel} ${e.sender_name}`,
                    e.body.substring(0, 60) + (e.body.length > 60 ? '...' : ''),
                    '📨'
                );

                updateSidebarPreview(e.sender_id, e.body);
                scrollChurchIntoView(e.sender_id);
                flashChurchItem(e.sender_id);

                const isSameChurch = currentChurchId == e.sender_id;

                if (isSameChurch) {
                    const msgData = {
                        id: e.id,
                        sender_church_id: e.sender_id,
                        receiver_church_id: e.receiver_id,
                        body: e.body,
                        created_at: e.timestamp || new Date().toISOString(),
                        is_new: true
                    };
                    appendNewMessage(msgData);
                } else {
                    const draftInput = document.getElementById('messageInput');
                    const draft = draftInput.value.trim();

                    loadConversation(e.sender_id);

                    if (draft) {
                        setTimeout(() => { draftInput.value = draft; }, 400);
                    }
                }

                updateTotalUnread();
                updateHeroBadge();
            });
    }

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            toggleCompose();
            const composeMsg = window.t ? window.t('compose_new') : 'Compose New Message';
            showToast(composeMsg, 'Ctrl+N pressed', '✏️');
        }

        if (e.key === 'Enter' && !e.shiftKey && document.activeElement?.id === 'messageInput') {
            e.preventDefault();
            document.getElementById('messageForm').dispatchEvent(new Event('submit'));
        }

        if (e.key === 'Escape') {
            closeToast();
            document.getElementById('messageInput').blur();
        }

        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            refreshMessages();
        }
    });

    // ============================================
    // INITIALIZE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('💬 Aurora Messenger loading...');

        const items = document.querySelectorAll('.msg-church-item');
        let foundWithMessages = false;

        for (const item of items) {
            const lastMsg = item.querySelector('.msg-church-last');
            const noMsgText = window.t ? window.t('no_messages_yet') : 'No messages yet';
            if (lastMsg && lastMsg.textContent.trim() !== noMsgText) {
                const churchId = item.dataset.churchId;
                if (churchId) {
                    loadConversation(parseInt(churchId));
                    foundWithMessages = true;
                    break;
                }
            }
        }

        if (!foundWithMessages && items.length > 0) {
            const firstItem = items[0];
            const churchId = firstItem.dataset.churchId;
            if (churchId) loadConversation(parseInt(churchId));
        }

        updateTotalUnread();
        updateHeroBadge();

        setTimeout(() => {
            const readyMsg = window.t ? window.t('messenger_ready') : 'Messenger Ready';
            const clickMsg = window.t ? window.t('click_chat') : 'Click a church to start chatting';
            showToast(readyMsg, clickMsg, '💬');
        }, 1000);

        console.log('💬 Aurora Messenger loaded successfully!');
    });
</script>

@endsection