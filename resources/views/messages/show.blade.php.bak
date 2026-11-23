@extends('layouts.app')

@section('header', 'Message Details')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    /* ═══════════════════════════════════════════════
       AURORA — Message Detail Redesign
    ═══════════════════════════════════════════════ */
    .md-app {
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

        --a-sh-sm: 0 1px 2px rgba(15, 23, 42, 0.05);
        --a-sh-md: 0 12px 32px -14px rgba(15, 23, 42, 0.18);
        --a-sh-lg: 0 30px 70px -28px rgba(99, 102, 241, 0.42);

        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        color: var(--a-text);
        max-width: 880px;
        margin: 0 auto;
    }

    [data-theme="dark"] .md-app {
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

    .md-app * { box-sizing: border-box; }

    /* ─── Animations ─── */
    @keyframes mdFadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes mdFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes mdRing {
        0%   { transform: scale(0.9); opacity: 0.9; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    @keyframes mdAuroraShift {
        0%, 100% { background-position: 0% 50%; }
        50%      { background-position: 100% 50%; }
    }
    @keyframes mdPulseDot {
        0%, 100% { transform: scale(1); opacity: 1; }
        50%      { transform: scale(1.2); opacity: 0.75; }
    }

    /* ═══════════════════════════════════════════════
       HERO — Floating capsule
    ═══════════════════════════════════════════════ */
    .md-hero {
        position: relative;
        padding: 1.15rem 1.4rem;
        border-radius: 28px;
        background: var(--a-aurora);
        background-size: 200% 200%;
        animation: mdAuroraShift 12s ease infinite, mdFadeUp 0.5s ease both;
        color: #fff;
        margin-bottom: 1.25rem;
        box-shadow: var(--a-sh-lg);
        overflow: hidden;
        isolation: isolate;
    }

    .md-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 5%;
        right: 5%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.9), transparent);
        opacity: 0.7;
    }

    .md-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 15% 10%, rgba(255,255,255,0.22), transparent 40%),
            radial-gradient(circle at 85% 90%, rgba(255,255,255,0.12), transparent 45%);
        pointer-events: none;
        z-index: -1;
    }

    .md-hero-inner {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
    }

    /* Gradient orb with pulse ring */
    .md-hero-orb {
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
        font-size: 1.05rem;
        color: #fff;
    }
    .md-hero-orb::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        animation: mdRing 2.8s ease-out infinite;
    }

    .md-hero-copy {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        min-width: 0;
        flex: 1;
    }

    .md-hero-title {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        line-height: 1.15;
        word-break: break-word;
    }

    .md-hero-sub {
        margin: 0;
        font-size: 0.79rem;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 400;
        line-height: 1.4;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.4rem;
    }

    .md-hero-sub .dot-sep {
        opacity: 0.5;
        font-size: 0.6rem;
    }

    .md-hero-sub i {
        font-size: 0.72rem;
        opacity: 0.9;
    }

    /* Unread chip on hero */
    .md-hero-unread {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.3rem;
        padding: 0.25rem 0.7rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.22);
        border: 1px solid rgba(255, 255, 255, 0.28);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        width: fit-content;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .md-hero-unread .dot {
        position: relative;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #FEF3C7;
        box-shadow: 0 0 8px rgba(254, 243, 199, 0.9);
    }
    .md-hero-unread .dot::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        border: 1.5px solid rgba(254, 243, 199, 0.5);
        animation: mdRing 2.2s ease-out infinite;
    }

    /* ═══════════════════════════════════════════════
       MAIN CARD — Glass shell with gradient halo
    ═══════════════════════════════════════════════ */
    .md-card {
        position: relative;
        background: var(--a-card);
        border: 1px solid var(--a-border);
        border-radius: 24px;
        padding: 1.75rem 2rem;
        box-shadow: var(--a-sh-md);
        animation: mdFadeUp 0.55s ease 0.08s both;
        overflow: hidden;
    }

    /* Gradient halo */
    .md-card::before {
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
       SENDER BLOCK
    ═══════════════════════════════════════════════ */
    .md-sender {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.1rem 1.25rem;
        background: var(--a-aurora-soft);
        border: 1px solid var(--a-border);
        border-radius: 18px;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    /* Aurora rail */
    .md-sender::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: var(--a-aurora);
    }

    /* Circle avatar with ring glow */
    .md-avatar {
        position: relative;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 1.15rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        background: var(--a-aurora);
        box-shadow: 0 8px 20px -10px rgba(99, 102, 241, 0.6);
    }

    .md-avatar .online-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: var(--a-green);
        border: 2.5px solid var(--a-card);
        box-shadow: 0 0 0 2px var(--a-green-glow);
        animation: mdPulseDot 2s ease-in-out infinite;
    }

    .md-sender-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .md-sender-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--a-text);
        letter-spacing: -0.015em;
        line-height: 1.2;
    }

    .md-sender-meta {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: var(--a-muted);
        font-weight: 500;
        flex-wrap: wrap;
    }

    .md-sender-meta .role-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.15rem 0.6rem;
        border-radius: 20px;
        background: var(--a-primary-soft-2);
        color: var(--a-primary);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .md-sender-meta .role-chip i { font-size: 0.58rem; }

    /* ═══════════════════════════════════════════════
       SUBJECT LINE
    ═══════════════════════════════════════════════ */
    .md-subject-block {
        margin-bottom: 1.25rem;
        padding-bottom: 1.1rem;
        border-bottom: 1px dashed var(--a-border);
    }

    .md-subject-label {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--a-muted);
        margin-bottom: 0.45rem;
    }

    .md-subject-label i {
        font-size: 0.6rem;
        color: var(--a-primary);
    }

    .md-subject {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--a-text);
        letter-spacing: -0.02em;
        line-height: 1.3;
        word-break: break-word;
    }

    /* ═══════════════════════════════════════════════
       MESSAGE BODY
    ═══════════════════════════════════════════════ */
    .md-body {
        position: relative;
        font-size: 0.95rem;
        line-height: 1.75;
        color: var(--a-text);
        padding: 1.25rem 1.35rem;
        background: var(--a-soft);
        border-radius: 16px;
        border: 1px solid var(--a-border);
        white-space: pre-wrap;
        word-wrap: break-word;
        overflow-wrap: anywhere;
        margin-bottom: 1.75rem;
    }

    /* Subtle quote-bar */
    .md-body::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 3px;
        border-radius: 3px;
        background: var(--a-aurora);
        opacity: 0.55;
    }

    /* ═══════════════════════════════════════════════
       ACTIONS
    ═══════════════════════════════════════════════ */
    .md-actions {
        display: flex;
        gap: 0.55rem;
        flex-wrap: wrap;
        padding-top: 1.25rem;
        border-top: 1px solid var(--a-border);
    }

    .md-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.15rem;
        border-radius: 50px;
        font-size: 0.79rem;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        white-space: nowrap;
        letter-spacing: -0.005em;
    }

    .md-btn:active {
        transform: scale(0.97);
    }

    /* Back — ghost */
    .md-btn.back {
        background: var(--a-soft);
        color: var(--a-text);
        border-color: var(--a-border);
    }
    .md-btn.back:hover {
        background: var(--a-card);
        color: var(--a-primary);
        border-color: var(--a-primary);
        transform: translateY(-1px);
    }

    /* Mark Read — aurora gradient */
    .md-btn.primary {
        background: var(--a-aurora);
        background-size: 150% 150%;
        color: #fff;
        box-shadow: 0 8px 22px -10px rgba(99, 102, 241, 0.9);
    }
    .md-btn.primary:hover {
        transform: translateY(-2px);
        color: #fff;
        box-shadow: 0 14px 32px -10px rgba(99, 102, 241, 0.9);
    }

    /* Archive — neutral */
    .md-btn.archive {
        background: var(--a-card);
        color: var(--a-muted);
        border-color: var(--a-border);
    }
    .md-btn.archive:hover {
        background: var(--a-primary-soft);
        color: var(--a-primary);
        border-color: transparent;
        transform: translateY(-1px);
    }

    /* Delete — danger */
    .md-btn.delete {
        background: rgba(244, 63, 94, 0.1);
        color: var(--a-rose);
        border-color: transparent;
    }
    .md-btn.delete:hover {
        background: rgba(244, 63, 94, 0.18);
        color: var(--a-rose);
        transform: translateY(-1px);
    }

    /* Right-align the back button */
    .md-actions .md-btn.back {
        margin-right: auto;
    }

    /* ═══════════════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════════════ */
    @media (max-width: 768px) {
        .md-hero {
            padding: 1rem 1.15rem;
            border-radius: 22px;
        }
        .md-hero-orb { width: 42px; height: 42px; font-size: 0.95rem; }
        .md-hero-title { font-size: 1.05rem; }

        .md-card {
            padding: 1.25rem 1.15rem;
            border-radius: 20px;
        }

        .md-sender {
            padding: 0.95rem 1rem;
            gap: 0.85rem;
        }
        .md-avatar { width: 46px; height: 46px; font-size: 1rem; }
        .md-sender-name { font-size: 0.92rem; }

        .md-subject { font-size: 1.05rem; }

        .md-body {
            font-size: 0.9rem;
            padding: 1.05rem 1.15rem;
            border-radius: 14px;
        }

        .md-actions .md-btn {
            flex: 1;
            justify-content: center;
            min-width: 130px;
        }
        .md-actions .md-btn.back { margin-right: 0; }
    }

    @media (max-width: 480px) {
        .md-hero-title { font-size: 0.98rem; }
        .md-subject { font-size: 1rem; }
        .md-actions .md-btn { font-size: 0.75rem; padding: 0.55rem 0.9rem; }
    }
</style>

<div class="md-app">
    @php
        $isSender = $message->sender_church_id == Auth::user()->church_id;
        $otherChurch = $isSender ? $message->receiver : $message->sender;
        $isUnread = !$message->is_read && !$isSender;
    @endphp

    {{-- ═══════════════════════════════════ --}}
    {{-- HERO                               --}}
    {{-- ═══════════════════════════════════ --}}
    <div class="md-hero">
        <div class="md-hero-inner">
            <div class="md-hero-orb">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="md-hero-copy">
                <h1 class="md-hero-title">{{ $message->subject }}</h1>
                <p class="md-hero-sub">
                    <i class="fas fa-clock"></i>
                    <span>{{ $message->created_at->format('F d, Y g:i A') }}</span>
                    <span class="dot-sep">●</span>
                    <i class="fas fa-{{ $isSender ? 'arrow-up' : 'arrow-down' }}"></i>
                    <span>{{ $isSender ? 'Sent to' : 'Received from' }} <strong>{{ $otherChurch->name ?? 'Unknown' }}</strong></span>
                </p>
                @if($isUnread)
                    <span class="md-hero-unread">
                        <span class="dot"></span>
                        Unread Message
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════ --}}
    {{-- MAIN CARD                          --}}
    {{-- ═══════════════════════════════════ --}}
    <div class="md-card">

        {{-- Sender Block --}}
        <div class="md-sender">
            <div class="md-avatar" style="background: {{ $otherChurch->color ?? 'linear-gradient(135deg, #6366F1, #8B5CF6)' }};">
                {{ strtoupper(substr($otherChurch->name ?? 'U', 0, 1)) }}
                <span class="online-dot"></span>
            </div>
            <div class="md-sender-info">
                <div class="md-sender-name">{{ $otherChurch->name ?? 'Unknown Church' }}</div>
                <div class="md-sender-meta">
                    <span class="role-chip">
                        <i class="fas fa-{{ $isSender ? 'paper-plane' : 'inbox' }}"></i>
                        {{ $isSender ? 'Recipient' : 'Sender' }}
                    </span>
                    <span>•</span>
                    <span>{{ $message->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        {{-- Subject --}}
        <div class="md-subject-block">
            <div class="md-subject-label">
                <i class="fas fa-tag"></i>
                Subject
            </div>
            <div class="md-subject">{{ $message->subject }}</div>
        </div>

        {{-- Body --}}
        <div class="md-body">{{ $message->body }}</div>

        {{-- Actions --}}
        <div class="md-actions">
            <a href="{{ route('messages.index') }}" class="md-btn back">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            @if(!$isSender)
                <button type="button" onclick="markRead({{ $message->id }})" class="md-btn primary">
                    <i class="fas fa-check"></i> Mark as Read
                </button>
            @endif

            <button type="button" onclick="archiveMessage({{ $message->id }})" class="md-btn archive">
                <i class="fas fa-archive"></i> Archive
            </button>

            <button type="button" onclick="deleteMessage({{ $message->id }})" class="md-btn delete">
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    </div>
</div>

<script>
    // ============================================
    // MARK AS READ
    // ============================================
    function markRead(id) {
        fetch(`/messages/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    // ============================================
    // ARCHIVE
    // ============================================
    function archiveMessage(id) {
        if (!confirm('Archive this message?')) return;

        fetch(`/messages/${id}/archive`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(() => window.location.href = '{{ route("messages.index") }}');
    }

    // ============================================
    // DELETE
    // ============================================
    function deleteMessage(id) {
        if (!confirm('Delete this message permanently?')) return;

        fetch(`/messages/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(() => window.location.href = '{{ route("messages.index") }}');
    }
</script>

@endsection