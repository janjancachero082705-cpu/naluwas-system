@extends('layouts.app')

@section('header', 'Messages')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}?v={{ filemtime(public_path('css/messages.css')) }}">
@endpush

@section('content')

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

@endsection

@push('scripts')
<script>
    window.MSG = {
        churchId: @json(Auth::user()->church_id),
        storeUrl: @json(route('messages.store'))
    };
</script>
<script src="{{ asset('js/messages.js') }}?v={{ filemtime(public_path('js/messages.js')) }}"></script>
@endpush
