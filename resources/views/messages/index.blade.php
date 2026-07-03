@extends('layouts.app')

@section('header', 'Messages')

@section('content')
<style>
    /* ============================================
       FACEBOOK MESSENGER STYLE
       ============================================ */

    /* ─── Container ─── */
    .messenger-container {
        display: flex;
        height: calc(100vh - 180px);
        min-height: 550px;
        max-height: 750px;
        border-radius: 16px;
        overflow: hidden;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    }

    /* ============================================
       SIDEBAR - CHAT LIST
       ============================================ */
    .msg-sidebar {
        width: 360px;
        min-width: 300px;
        background: var(--bg-secondary);
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
    }

    .msg-sidebar-header {
        padding: 16px 20px 12px;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }

    .msg-sidebar-header .header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .msg-sidebar-header h5 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .msg-sidebar-header h5 i {
        color: #4F46E5;
        font-size: 20px;
    }

    .msg-sidebar-header .badge-total {
        font-size: 11px;
        background: #4F46E5;
        color: white;
        padding: 2px 12px;
        border-radius: 20px;
        font-weight: 600;
        margin-left: 8px;
    }

    .msg-sidebar-header .header-actions button {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 16px;
    }

    .msg-sidebar-header .header-actions button:hover {
        background: var(--hover-bg);
        color: #4F46E5;
    }

    /* ─── Search ─── */
    .msg-sidebar-search {
        padding: 10px 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .msg-sidebar-search input {
        width: 100%;
        padding: 10px 16px 10px 44px;
        border-radius: 30px;
        border: none;
        background: var(--bg-input);
        color: var(--text-primary);
        font-size: 13px;
        outline: none;
        transition: all 0.3s ease;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 16px center;
        background-size: 18px;
    }

    .msg-sidebar-search input:focus {
        background-color: var(--bg-input-focus);
        box-shadow: 0 0 0 2px rgba(79,70,229,0.1);
    }

    /* ─── Chat List ─── */
    .msg-church-list {
        flex: 1;
        overflow-y: auto;
        padding: 4px 0;
    }

    .msg-church-list::-webkit-scrollbar {
        width: 4px;
    }
    .msg-church-list::-webkit-scrollbar-track {
        background: transparent;
    }
    .msg-church-list::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }

    .msg-church-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.15s ease;
        position: relative;
        border-bottom: 1px solid var(--border-color);
    }

    .msg-church-item:hover {
        background: var(--hover-bg);
    }

    .msg-church-item.active {
        background: rgba(79, 70, 229, 0.08);
        border-left: 3px solid #4F46E5;
    }

    .msg-church-item .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: white;
        flex-shrink: 0;
        position: relative;
    }

    .msg-church-item .avatar .online-dot {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #10b981;
        border: 3px solid var(--bg-secondary);
    }

    .msg-church-item .info {
        flex: 1;
        min-width: 0;
    }

    .msg-church-item .name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .msg-church-item .last-msg {
        font-size: 13px;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 2px;
    }

    .msg-church-item .meta {
        flex-shrink: 0;
        text-align: right;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
    }

    .msg-church-item .time {
        font-size: 11px;
        color: var(--text-muted);
    }

    .msg-church-item .unread-count {
        background: #ef4444;
        color: white;
        font-size: 11px;
        font-weight: 700;
        min-width: 22px;
        height: 22px;
        padding: 0 8px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .msg-empty-state {
        padding: 40px 20px;
        text-align: center;
        color: var(--text-muted);
    }

    .msg-empty-state i {
        font-size: 48px;
        opacity: 0.3;
        margin-bottom: 12px;
        display: block;
    }

    .msg-empty-state p {
        font-size: 14px;
    }

    /* ============================================
       MAIN CHAT - CONVERSATION
       ============================================ */
    .msg-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: var(--bg-primary);
        position: relative;
    }

    /* ─── Chat Header ─── */
    .msg-main-header {
        padding: 12px 20px;
        background: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
        min-height: 68px;
    }

    .msg-main-header .chat-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: white;
        flex-shrink: 0;
    }

    .msg-main-header .chat-info {
        flex: 1;
    }

    .msg-main-header .chat-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .msg-main-header .chat-status {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .msg-main-header .chat-status.online {
        color: #10b981;
    }

    .msg-main-header .chat-status .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .msg-main-header .chat-status.online .status-dot {
        background: #10b981;
    }

    .msg-main-header .chat-actions button {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 18px;
    }

    .msg-main-header .chat-actions button:hover {
        background: var(--hover-bg);
        color: #4F46E5;
    }

    /* ─── Messages List ─── */
    .msg-messages {
        flex: 1;
        overflow-y: auto;
        padding: 16px 20px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        background: var(--bg-primary);
    }

    .msg-messages::-webkit-scrollbar {
        width: 5px;
    }
    .msg-messages::-webkit-scrollbar-track {
        background: transparent;
    }
    .msg-messages::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }

    /* ─── Date Divider ─── */
    .msg-date-divider {
        text-align: center;
        margin: 12px 0 16px;
        position: relative;
    }

    .msg-date-divider span {
        font-size: 11px;
        color: var(--text-muted);
        background: var(--bg-primary);
        padding: 0 16px;
        display: inline-block;
        position: relative;
        z-index: 1;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .msg-date-divider::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: var(--border-color);
    }

    /* ─── Message Bubbles ─── */
    .msg-bubble {
        max-width: 70%;
        padding: 10px 16px;
        border-radius: 18px;
        animation: msgSlideIn 0.25s ease;
        position: relative;
        word-wrap: break-word;
        line-height: 1.5;
        font-size: 14px;
    }

    .msg-bubble.sent {
        align-self: flex-end;
        background: #4F46E5;
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 1px 4px rgba(79,70,229,0.2);
    }

    .msg-bubble.received {
        align-self: flex-start;
        background: var(--bg-secondary);
        color: var(--text-primary);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--border-color);
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }

    .msg-bubble .subject {
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 4px;
        opacity: 0.9;
    }

    .msg-bubble .body {
        font-size: 14px;
    }

    .msg-bubble .time {
        font-size: 10px;
        opacity: 0.7;
        margin-top: 4px;
        text-align: right;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
    }

    .msg-bubble.sent .time {
        color: rgba(255,255,255,0.7);
    }

    .msg-bubble.received .time {
        color: var(--text-muted);
    }

    .msg-bubble .status-icon {
        font-size: 12px;
    }

    .msg-bubble.new-message {
        animation: newMessagePop 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes msgSlideIn {
        from { opacity: 0; transform: translateY(8px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes newMessagePop {
        0% { opacity: 0; transform: scale(0.85) translateY(15px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }

    /* ─── Empty State ─── */
    .msg-empty-state-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        padding: 40px;
        text-align: center;
    }

    .msg-empty-state-main i {
        font-size: 64px;
        opacity: 0.15;
        margin-bottom: 16px;
    }

    .msg-empty-state-main h4 {
        color: var(--text-primary);
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .msg-empty-state-main p {
        font-size: 14px;
        max-width: 320px;
        color: var(--text-muted);
    }

    .msg-empty-state-main .btn-compose-empty {
        margin-top: 16px;
        padding: 12px 32px;
        border-radius: 40px;
        border: none;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .msg-empty-state-main .btn-compose-empty:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79,70,229,0.3);
    }

    /* ─── Compose ─── */
    .msg-compose {
        padding: 10px 16px 14px;
        background: var(--bg-secondary);
        border-top: 1px solid var(--border-color);
        flex-shrink: 0;
        display: block !important;
    }

    .msg-compose .compose-wrapper {
        display: flex;
        gap: 10px;
        align-items: flex-end;
        background: var(--bg-input);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        padding: 4px 6px 4px 16px;
        transition: all 0.3s ease;
    }

    .msg-compose .compose-wrapper:focus-within {
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.08);
    }

    .msg-compose .compose-inputs {
        flex: 1;
        padding: 6px 0;
    }

    .msg-compose .compose-inputs .subject-input {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 4px;
        margin-bottom: 4px;
        display: none;
    }

    .msg-compose .compose-inputs .subject-input.show {
        display: block;
    }

    .msg-compose .compose-inputs input {
        width: 100%;
        border: none;
        background: transparent;
        padding: 4px 0;
        font-size: 14px;
        color: var(--text-primary);
        outline: none;
    }

    .msg-compose .compose-inputs input::placeholder {
        color: var(--text-muted);
    }

    .msg-compose .compose-inputs .subject-input input {
        font-weight: 600;
        font-size: 13px;
    }

    .msg-compose .compose-actions {
        display: flex;
        gap: 4px;
        align-items: center;
        padding: 4px 0;
    }

    .msg-compose .compose-actions button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .msg-compose .compose-actions button:hover {
        background: var(--hover-bg);
        color: #4F46E5;
    }

    .msg-compose .btn-send-msg {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: white;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 12px rgba(79,70,229,0.3);
    }

    .msg-compose .btn-send-msg:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 20px rgba(79,70,229,0.4);
    }

    .msg-compose .btn-send-msg:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* ─── Animations ─── */
    .msg-church-item.updated {
        animation: sidebarHighlight 0.5s ease;
    }

    @keyframes sidebarHighlight {
        0% { background: rgba(79, 70, 229, 0.15); }
        100% { background: transparent; }
    }

    /* ─── Responsive ─── */
    @media (max-width: 768px) {
        .messenger-container {
            flex-direction: column;
            height: calc(100vh - 160px);
            min-height: 400px;
            border-radius: 12px;
        }
        .msg-sidebar {
            width: 100%;
            max-height: 250px;
            border-right: none;
            border-bottom: 1px solid var(--border-color);
        }
        .msg-sidebar-header h5 { font-size: 16px; }
        .msg-church-item { padding: 10px 14px; }
        .msg-church-item .avatar { width: 40px; height: 40px; font-size: 14px; }
        .msg-main-header { padding: 10px 16px; min-height: 58px; }
        .msg-main-header .chat-avatar { width: 36px; height: 36px; font-size: 14px; }
        .msg-main-header .chat-name { font-size: 14px; }
        .msg-messages { padding: 12px 14px; }
        .msg-bubble { max-width: 90%; font-size: 13px; padding: 8px 12px; border-radius: 14px; }
        .msg-compose { padding: 8px 12px 12px; }
        .msg-compose .btn-send-msg { width: 38px; height: 38px; font-size: 16px; }
    }

    @media (max-width: 480px) {
        .messenger-container { height: calc(100vh - 140px); }
        .msg-sidebar { max-height: 200px; }
        .msg-sidebar-header { padding: 10px 14px; }
        .msg-sidebar-header h5 { font-size: 14px; }
        .msg-sidebar-search input { font-size: 12px; padding: 8px 12px 8px 38px; background-size: 16px; background-position: 14px center; }
        .msg-church-item { padding: 8px 10px; }
        .msg-church-item .avatar { width: 34px; height: 34px; font-size: 12px; }
        .msg-bubble { max-width: 95%; font-size: 12px; padding: 6px 10px; border-radius: 12px; }
        .msg-compose .btn-send-msg { width: 34px; height: 34px; font-size: 14px; }
    }
</style>

<div class="messenger-container">
    <!-- ============================================
    SIDEBAR - CHAT LIST
    ============================================ -->
    <div class="msg-sidebar">
        <div class="msg-sidebar-header">
            <div class="header-top">
                <h5>
                    <i class="fas fa-comment-dots"></i> Chats
                    <span class="badge-total" id="totalUnreadBadge">{{ $unreadCount ?? 0 }}</span>
                </h5>
                <div class="header-actions">
                    <button onclick="refreshMessages()" title="Refresh">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="msg-sidebar-search">
            <input type="text" id="searchChurches" placeholder="Search churches..." onkeyup="filterChurches(this.value)">
        </div>

        <div class="msg-church-list" id="churchList">
            @forelse($allChurches ?? [] as $church)
                <div class="msg-church-item" data-church-id="{{ $church->id }}" onclick="loadConversation({{ $church->id }})">
                    <div class="avatar" style="background: {{ $church->avatar_color ?? '#4F46E5' }};">
                        {{ $church->initials ?? strtoupper(substr($church->name ?? 'U', 0, 1)) }}
                        <span class="online-dot"></span>
                    </div>
                    <div class="info">
                        <div class="name">{{ $church->name ?? 'Unknown Church' }}</div>
                        <div class="last-msg" id="lastMsg-{{ $church->id }}">No messages yet</div>
                    </div>
                    <div class="meta">
                        <div class="time" id="lastTime-{{ $church->id }}"></div>
                        @php
                            $unread = $church->unread_count ?? 0;
                        @endphp
                        @if($unread > 0)
                            <span class="unread-count" id="unreadBadge-{{ $church->id }}">{{ $unread }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="msg-empty-state">
                    <i class="fas fa-church"></i>
                    <p>No other churches found</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ============================================
    MAIN CHAT - CONVERSATION
    ============================================ -->
    <div class="msg-main">
        <!-- Chat Header -->
        <div class="msg-main-header" id="chatHeader">
            <div class="chat-avatar" id="chatAvatar" style="background: #4F46E5;">
                <i class="fas fa-church"></i>
            </div>
            <div class="chat-info">
                <div class="chat-name" id="chatName">Select a Church</div>
                <div class="chat-status" id="chatStatus">
                    <span class="status-dot"></span> Choose a church to start messaging
                </div>
            </div>
            <div class="chat-actions">
                <button onclick="toggleCompose()" title="New Message">
                    <i class="fas fa-pen"></i>
                </button>
            </div>
        </div>

        <!-- Messages -->
        <div class="msg-messages" id="messageList">
            <div class="msg-empty-state-main" id="emptyState">
                <i class="fas fa-inbox"></i>
                <h4>No messages selected</h4>
                <p>Click on a church from the sidebar to view conversation</p>
            </div>
        </div>

        <!-- Compose -->
        <div class="msg-compose" id="msgCompose">
            <form id="messageForm" onsubmit="sendMessage(event)">
                <input type="hidden" id="receiverId" value="">
                <div class="compose-wrapper">
                    <div class="compose-inputs">
                        <div class="subject-input" id="subjectContainer">
                            <input type="text" id="subjectInput" placeholder="Subject" />
                        </div>
                        <input type="text" id="messageInput" placeholder="Type a message..." required />
                    </div>
                    <div class="compose-actions">
                        <button type="button" onclick="toggleSubject()" title="Add subject">
                            <i class="fas fa-tag"></i>
                        </button>
                        <button type="submit" class="btn-send-msg" id="sendBtn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // ============================================
    // STATE
    // ============================================
    let currentChurchId = null;
    let currentChurchName = '';
    let isComposeOpen = false;
    let subjectVisible = false;

    // ============================================
    // TOGGLE SUBJECT
    // ============================================
    function toggleSubject() {
        subjectVisible = !subjectVisible;
        const container = document.getElementById('subjectContainer');
        container.classList.toggle('show');
        if (subjectVisible) {
            document.getElementById('subjectInput').focus();
        }
    }

    // ============================================
    // TOGGLE COMPOSE
    // ============================================
    function toggleCompose() {
        const compose = document.getElementById('msgCompose');
        isComposeOpen = !isComposeOpen;
        if (isComposeOpen && !document.getElementById('receiverId').value) {
            showToast('Please select a church first.', 'warning');
        }
    }

    // ============================================
    // LOAD CONVERSATION - AUTO DISPLAY MESSAGES
    // ============================================
    function loadConversation(churchId) {
        currentChurchId = churchId;

        // Update active state
        document.querySelectorAll('.msg-church-item').forEach(el => {
            el.classList.remove('active');
            if (el.dataset.churchId == churchId) {
                el.classList.add('active');
                currentChurchName = el.querySelector('.name').textContent;
            }
        });

        // Update header
        const church = document.querySelector(`.msg-church-item[data-church-id="${churchId}"]`);
        if (church) {
            const avatar = church.querySelector('.avatar');
            const avatarBg = avatar.style.background;
            const avatarText = avatar.textContent.trim();

            document.getElementById('chatAvatar').style.background = avatarBg || '#4F46E5';
            document.getElementById('chatAvatar').textContent = avatarText || '?';
            document.getElementById('chatName').textContent = currentChurchName;
            document.getElementById('chatStatus').innerHTML = `
                <span class="status-dot"></span> Loading messages...
            `;
            document.getElementById('chatStatus').className = 'chat-status';
        }

        // Set receiver for compose
        document.getElementById('receiverId').value = churchId;

        // Show loading
        const list = document.getElementById('messageList');
        list.innerHTML = `
            <div class="msg-empty-state-main">
                <i class="fas fa-spinner fa-spin" style="font-size:32px;opacity:0.5;"></i>
                <h4>Loading messages...</h4>
            </div>
        `;

        // Fetch messages
        fetch(`/messages/conversation/${churchId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderMessages(data.messages);
                    const count = data.messages ? data.messages.length : 0;
                    document.getElementById('chatStatus').innerHTML = `
                        <span class="status-dot"></span> ${count > 0 ? `${count} messages` : 'No messages yet'}
                    `;
                    document.getElementById('chatStatus').className = 'chat-status online';

                    // Update last message in sidebar
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

                    // Remove unread badge
                    const badge = document.getElementById(`unreadBadge-${churchId}`);
                    if (badge) badge.remove();

                    updateTotalUnread();
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                document.getElementById('messageList').innerHTML = `
                    <div class="msg-empty-state-main">
                        <i class="fas fa-exclamation-triangle" style="font-size:32px;color:#ef4444;opacity:0.5;"></i>
                        <h4>Failed to load messages</h4>
                        <p>${error.message}</p>
                        <button class="btn-compose-empty" onclick="loadConversation(${churchId})">
                            <i class="fas fa-sync-alt"></i> Retry
                        </button>
                    </div>
                `;
                document.getElementById('chatStatus').innerHTML = `<span class="status-dot"></span> Error loading messages`;
                document.getElementById('chatStatus').className = 'chat-status';
            });
    }

    // ============================================
    // RENDER MESSAGES
    // ============================================
    function renderMessages(messages, scrollToBottom = true) {
        const list = document.getElementById('messageList');
        const churchId = '{{ Auth::user()->church_id }}';

        if (!messages || messages.length === 0) {
            list.innerHTML = `
                <div class="msg-empty-state-main">
                    <i class="fas fa-comment-dots"></i>
                    <h4>No messages yet</h4>
                    <p>Start a conversation with ${currentChurchName}</p>
                </div>
            `;
            return;
        }

        let html = '';
        let lastDate = '';

        messages.forEach((msg) => {
            const isSent = msg.sender_church_id == churchId;
            const msgDate = new Date(msg.created_at);
            const dateStr = msgDate.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });

            if (dateStr !== lastDate) {
                html += `<div class="msg-date-divider"><span>${dateStr}</span></div>`;
                lastDate = dateStr;
            }

            const timeStr = msgDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            html += `
                <div class="msg-bubble ${isSent ? 'sent' : 'received'}" data-msg-id="${msg.id}">
                    ${msg.subject ? `<div class="subject">${escapeHtml(msg.subject)}</div>` : ''}
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
    // APPEND NEW MESSAGE (REAL-TIME)
    // ============================================
    function appendNewMessage(msg) {
        const list = document.getElementById('messageList');
        const churchId = '{{ Auth::user()->church_id }}';
        const isSent = msg.sender_church_id == churchId;

        const emptyState = list.querySelector('.msg-empty-state-main');
        if (emptyState) {
            list.innerHTML = '';
        }

        const lastDateEl = list.querySelector('.msg-date-divider:last-child');
        const msgDate = new Date(msg.created_at || Date.now());
        const dateStr = msgDate.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
        let lastDate = '';
        if (lastDateEl) {
            lastDate = lastDateEl.textContent.trim();
        }

        if (lastDate !== dateStr) {
            const divider = document.createElement('div');
            divider.className = 'msg-date-divider';
            divider.innerHTML = `<span>${dateStr}</span>`;
            list.appendChild(divider);
        }

        const timeStr = msgDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        const bubble = document.createElement('div');
        bubble.className = `msg-bubble ${isSent ? 'sent' : 'received'} new-message`;
        bubble.dataset.msgId = msg.id || Date.now();

        bubble.innerHTML = `
            ${msg.subject ? `<div class="subject">${escapeHtml(msg.subject)}</div>` : ''}
            <div class="body">${escapeHtml(msg.body)}</div>
            <div class="time">
                ${timeStr}
                ${isSent ? '<span class="status-icon"><i class="fas fa-check"></i></span>' : ''}
            </div>
        `;

        list.appendChild(bubble);

        setTimeout(() => {
            list.scrollTop = list.scrollHeight;
        }, 100);

        // Update sidebar
        const senderId = msg.sender_church_id == churchId ? msg.receiver_church_id : msg.sender_church_id;
        const lastMsgEl = document.getElementById(`lastMsg-${senderId}`);
        if (lastMsgEl) {
            const msgBody = msg.body || '';
            lastMsgEl.textContent = msgBody.length > 50 ? msgBody.substring(0, 50) + '...' : msgBody;
        }
        const lastTimeEl = document.getElementById(`lastTime-${senderId}`);
        if (lastTimeEl) {
            lastTimeEl.textContent = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }

        // Update unread badge if not currently viewing
        if (currentChurchId != senderId) {
            const item = document.querySelector(`.msg-church-item[data-church-id="${senderId}"]`);
            if (item) {
                let badge = document.getElementById(`unreadBadge-${senderId}`);
                if (!badge) {
                    const meta = item.querySelector('.meta');
                    if (meta) {
                        badge = document.createElement('span');
                        badge.className = 'unread-count';
                        badge.id = `unreadBadge-${senderId}`;
                        meta.appendChild(badge);
                    }
                }
                if (badge) {
                    const current = parseInt(badge.textContent) || 0;
                    badge.textContent = current + 1;
                }
                updateTotalUnread();
            }
        }
    }

    // ============================================
    // SEND MESSAGE
    // ============================================
    function sendMessage(event) {
        event.preventDefault();

        const receiverId = document.getElementById('receiverId').value;
        const subject = document.getElementById('subjectInput').value.trim();
        const body = document.getElementById('messageInput').value.trim();

        if (!body) {
            showToast('Please type a message.', 'warning');
            return;
        }

        if (!receiverId) {
            showToast('Please select a church to send to.', 'warning');
            return;
        }

        const sendBtn = document.getElementById('sendBtn');
        const originalHtml = sendBtn.innerHTML;
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        // Clear input immediately
        document.getElementById('messageInput').value = '';
        document.getElementById('subjectInput').value = '';
        document.getElementById('subjectContainer').classList.remove('show');
        subjectVisible = false;

        // Optimistic UI - add message immediately
        const optimisticMsg = {
            id: 'temp_' + Date.now(),
            sender_church_id: '{{ Auth::user()->church_id }}',
            receiver_church_id: receiverId,
            subject: subject || null,
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
                subject: subject,
                body: body
            })
        })
        .then(response => response.json())
        .then(data => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = originalHtml;

            if (data.success) {
                showToast('Message sent!', 'success');
            } else {
                showToast(data.message || 'Failed to send.', 'error');
                if (currentChurchId) {
                    loadConversation(currentChurchId);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            sendBtn.disabled = false;
            sendBtn.innerHTML = originalHtml;
            showToast('Error sending message.', 'error');
            if (currentChurchId) {
                loadConversation(currentChurchId);
            }
        });
    }

    // ============================================
    // FILTER CHURCHES
    // ============================================
    function filterChurches(query) {
        const items = document.querySelectorAll('.msg-church-item');
        const q = query.toLowerCase().trim();

        items.forEach(item => {
            const name = item.querySelector('.name').textContent.toLowerCase();
            item.style.display = name.includes(q) || q === '' ? 'flex' : 'none';
        });
    }

    // ============================================
    // UPDATE TOTAL UNREAD
    // ============================================
    function updateTotalUnread() {
        const badges = document.querySelectorAll('.unread-count');
        let total = 0;
        badges.forEach(b => {
            total += parseInt(b.textContent) || 0;
        });

        const badge = document.getElementById('totalUnreadBadge');
        if (badge) {
            badge.textContent = total;
            badge.style.display = total > 0 ? 'inline-block' : 'none';
        }
    }

    // ============================================
    // REFRESH MESSAGES
    // ============================================
    function refreshMessages() {
        if (currentChurchId) {
            loadConversation(currentChurchId);
        } else {
            // If no church selected, just reload the page
            location.reload();
        }
    }

    // ============================================
    // TOAST
    // ============================================
    function showToast(message, type = 'info') {
        if (window.showToastNotification) {
            window.showToastNotification(type, type === 'success' ? '✅ Success' : '⚠️ Notice', message);
        } else {
            alert(message);
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
    // REAL-TIME MESSAGE LISTENER
    // ============================================
    if (window.Echo) {
        const churchId = '{{ Auth::user()->church_id }}';

        window.Echo.channel(`messages.${churchId}`)
            .listen('message.new', (e) => {
                console.log('📨 New message received:', e);

                if (window.showToastNotification) {
                    window.showToastNotification(
                        'message',
                        `📨 New Message from ${e.sender_name}`,
                        e.subject + ': ' + e.body.substring(0, 100),
                        5000
                    );
                }

                // Auto-display new message
                if (currentChurchId == e.sender_id || currentChurchId == e.receiver_id) {
                    const msgData = {
                        id: e.id,
                        sender_church_id: e.sender_id,
                        receiver_church_id: e.receiver_id,
                        subject: e.subject,
                        body: e.body,
                        created_at: e.timestamp || new Date().toISOString(),
                        is_new: true
                    };
                    appendNewMessage(msgData);
                }

                // Update sidebar
                const item = document.querySelector(`.msg-church-item[data-church-id="${e.sender_id}"]`);
                if (item) {
                    const lastMsg = document.getElementById(`lastMsg-${e.sender_id}`);
                    if (lastMsg) {
                        const msgBody = e.body || '';
                        lastMsg.textContent = msgBody.length > 50 ? msgBody.substring(0, 50) + '...' : msgBody;
                    }

                    const lastTime = document.getElementById(`lastTime-${e.sender_id}`);
                    if (lastTime) {
                        lastTime.textContent = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    }

                    if (currentChurchId != e.sender_id) {
                        let badge = document.getElementById(`unreadBadge-${e.sender_id}`);
                        if (!badge) {
                            const meta = item.querySelector('.meta');
                            if (meta) {
                                badge = document.createElement('span');
                                badge.className = 'unread-count';
                                badge.id = `unreadBadge-${e.sender_id}`;
                                meta.appendChild(badge);
                            }
                        }
                        if (badge) {
                            const current = parseInt(badge.textContent) || 0;
                            badge.textContent = current + 1;
                        }
                    }

                    item.classList.add('updated');
                    setTimeout(() => item.classList.remove('updated'), 1000);
                    updateTotalUnread();
                }

                // Update header notification badge
                const headerBadge = document.getElementById('notifCount');
                if (headerBadge) {
                    const current = parseInt(headerBadge.textContent) || 0;
                    headerBadge.textContent = current + 1;
                    headerBadge.style.display = 'flex';
                    headerBadge.classList.add('has-messages');
                }
            });
    }

    // ============================================
    // KEYBOARD SHORTCUTS
    // ============================================
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            toggleCompose();
        }

        if (e.key === 'Enter' && !e.shiftKey && document.activeElement?.id === 'messageInput') {
            e.preventDefault();
            document.getElementById('messageForm').dispatchEvent(new Event('submit'));
        }
    });

    // ============================================
    // AUTO-LOAD FIRST CHURCH WITH MESSAGES
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's a church with messages
        const items = document.querySelectorAll('.msg-church-item');
        let foundWithMessages = false;

        for (const item of items) {
            const lastMsg = item.querySelector('.last-msg');
            if (lastMsg && lastMsg.textContent !== 'No messages yet') {
                const churchId = item.dataset.churchId;
                if (churchId) {
                    loadConversation(parseInt(churchId));
                    foundWithMessages = true;
                    break;
                }
            }
        }

        // If no church with messages, load the first one
        if (!foundWithMessages && items.length > 0) {
            const firstItem = items[0];
            const churchId = firstItem.dataset.churchId;
            if (churchId) {
                loadConversation(parseInt(churchId));
            }
        }

        console.log('💬 Messenger loaded successfully!');
    });
</script>
@endsection