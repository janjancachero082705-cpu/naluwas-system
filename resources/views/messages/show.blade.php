@extends('layouts.app')

@section('header', 'Message Details')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/message-detail.css') }}?v={{ filemtime(public_path('css/message-detail.css')) }}">
@endpush

@section('content')

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

@endsection

@push('scripts')
<script>
    window.MSG = {
        indexUrl: @json(route('messages.index'))
    };
</script>
<script src="{{ asset('js/message-detail.js') }}?v={{ filemtime(public_path('js/message-detail.js')) }}"></script>
@endpush
