@extends('layouts.app')

@section('header', 'Message Details')

@section('content')
<style>
    .message-detail {
        max-width: 800px;
        margin: 0 auto;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .message-header .subject {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .message-header .meta {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 6px;
    }

    .message-header .meta i {
        margin-right: 4px;
    }

    .message-sender {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        background: var(--bg-tertiary);
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .message-sender .avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
        color: white;
        flex-shrink: 0;
    }

    .message-sender .name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .message-sender .role {
        font-size: 12px;
        color: var(--text-muted);
    }

    .message-body {
        font-size: 15px;
        line-height: 1.7;
        color: var(--text-primary);
        padding: 1rem 0;
        white-space: pre-wrap;
    }

    .message-actions {
        display: flex;
        gap: 10px;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
        flex-wrap: wrap;
    }

    .message-actions .btn {
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-reply {
        background: #4F46E5;
        color: white;
    }

    .btn-reply:hover {
        background: #4338CA;
        color: white;
    }

    .btn-archive {
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    .btn-archive:hover {
        background: var(--hover-bg);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.2);
    }

    .btn-back {
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    .btn-back:hover {
        background: var(--hover-bg);
    }
</style>

<div class="container-fluid px-0 message-detail">
    @php
        $isSender = $message->sender_church_id == Auth::user()->church_id;
        $otherChurch = $isSender ? $message->receiver : $message->sender;
    @endphp

    {{-- Header --}}
    <div class="message-header">
        <div>
            <div class="subject">{{ $message->subject }}</div>
            <div class="meta">
                <i class="fas fa-clock"></i>
                {{ $message->created_at->format('F d, Y g:i A') }}
                <span style="margin:0 8px;">•</span>
                <i class="fas fa-{{ $isSender ? 'arrow-up' : 'arrow-down' }}"></i>
                {{ $isSender ? 'Sent to' : 'Received from' }}
                {{ $otherChurch->name ?? 'Unknown' }}
            </div>
        </div>
        <div>
            @if(!$message->is_read && !$isSender)
                <span class="badge-unread" style="background:#4F46E5;color:white;padding:4px 12px;border-radius:20px;font-size:12px;">
                    <i class="fas fa-circle" style="font-size:8px;margin-right:4px;"></i> Unread
                </span>
            @endif
        </div>
    </div>

    {{-- Sender Info --}}
    <div class="message-sender">
        <div class="avatar" style="background: {{ $otherChurch->color ?? '#4F46E5' }};">
            {{ strtoupper(substr($otherChurch->name ?? 'U', 0, 1)) }}
        </div>
        <div>
            <div class="name">{{ $otherChurch->name ?? 'Unknown Church' }}</div>
            <div class="role">
                {{ $isSender ? 'Recipient' : 'Sender' }}
                <span style="margin:0 6px;">•</span>
                {{ $message->created_at->diffForHumans() }}
            </div>
        </div>
    </div>

    {{-- Message Body --}}
    <div class="message-body">
        {{ $message->body }}
    </div>

    {{-- Actions --}}
    <div class="message-actions">
        <a href="{{ route('messages.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        @if(!$isSender)
            <button onclick="markRead({{ $message->id }})" class="btn btn-reply">
                <i class="fas fa-check"></i> Mark as Read
            </button>
        @endif

        <button onclick="archiveMessage({{ $message->id }})" class="btn btn-archive">
            <i class="fas fa-archive"></i> Archive
        </button>

        <button onclick="deleteMessage({{ $message->id }})" class="btn btn-delete">
            <i class="fas fa-trash"></i> Delete
        </button>
    </div>
</div>

<script>
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