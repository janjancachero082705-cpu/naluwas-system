@extends('layouts.app')

@section('header', 'Messages')

@section('content')
<style>
    /* ============================================
       PREMIUM MESSENGER DESIGN - WITH ANIMATIONS
       ============================================ */

    /* ─── Import Google Fonts ─── */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    /* ─── Enhanced Color Variables ─── */
    :root {
        --msg-primary: #4F46E5;
        --msg-primary-light: #818CF8;
        --msg-primary-dark: #3730A3;
        --msg-primary-gradient: linear-gradient(135deg, #4F46E5, #7C3AED, #6D28D9);
        --msg-secondary: #7C3AED;
        --msg-secondary-light: #A78BFA;
        --msg-success: #10B981;
        --msg-success-light: #34D399;
        --msg-danger: #EF4444;
        --msg-warning: #F59E0B;
        --msg-info: #3B82F6;
        --msg-purple: #8B5CF6;
        --msg-pink: #EC4899;
        --msg-teal: #14B8A6;
        
        /* Gradients */
        --gradient-sent: linear-gradient(135deg, #4F46E5, #7C3AED);
        --gradient-sent-hover: linear-gradient(135deg, #4338CA, #6D28D9);
        --gradient-header: linear-gradient(135deg, #4F46E5, #7C3AED, #6D28D9);
        --gradient-hero: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #6D28D9 100%);
        --gradient-btn: linear-gradient(135deg, #4F46E5, #7C3AED);
        --gradient-btn-hover: linear-gradient(135deg, #4338CA, #6D28D9);
        --gradient-unread: linear-gradient(135deg, #EF4444, #F87171);
        --gradient-online: linear-gradient(135deg, #10B981, #34D399);
        --gradient-avatar: linear-gradient(135deg, #4F46E5, #8B5CF6);
        --gradient-avatar-2: linear-gradient(135deg, #7C3AED, #EC4899);
        --gradient-avatar-3: linear-gradient(135deg, #3B82F6, #14B8A6);
        --gradient-avatar-4: linear-gradient(135deg, #F59E0B, #EF4444);
        
        /* Shadows */
        --shadow-msg-lg: 0 20px 60px rgba(79, 70, 229, 0.12);
        --shadow-msg-hover: 0 24px 80px rgba(79, 70, 229, 0.18);
        --shadow-glow: 0 8px 32px rgba(79, 70, 229, 0.25);
        --shadow-sent: 0 4px 20px rgba(79, 70, 229, 0.25);
        --shadow-btn: 0 4px 16px rgba(79, 70, 229, 0.3);
        --shadow-btn-hover: 0 8px 32px rgba(79, 70, 229, 0.4);
        --shadow-toast: 0 12px 48px rgba(79, 70, 229, 0.15);
        
        /* Borders */
        --border-glow: 1px solid rgba(79, 70, 229, 0.15);
        --border-primary: 2px solid rgba(79, 70, 229, 0.2);
    }

    /* ─── Global Animations ─── */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

    @keyframes shimmer {
        0% { background-position: -200% center; }
        100% { background-position: 200% center; }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes rotateIn {
        from { opacity: 0; transform: rotate(-180deg) scale(0.8); }
        to { opacity: 1; transform: rotate(0) scale(1); }
    }

    @keyframes ripple {
        0% { transform: scale(0); opacity: 0.5; }
        100% { transform: scale(2); opacity: 0; }
    }

    @keyframes glowPulse {
        0%, 100% { box-shadow: 0 0 20px rgba(79, 70, 229, 0.2); }
        50% { box-shadow: 0 0 40px rgba(79, 70, 229, 0.4); }
    }

    @keyframes messageAppear {
        0% { opacity: 0; transform: translateY(20px) scale(0.95); }
        60% { transform: translateY(-5px) scale(1.02); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    @keyframes typingBounce {
        0%, 60%, 100% { transform: translateY(0); opacity: 0.3; }
        30% { transform: translateY(-8px); opacity: 1; }
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(20deg); }
        75% { transform: rotate(-20deg); }
    }

    @keyframes shimmerEffect {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* ─── Container ─── */
    .messenger-container {
        display: flex;
        height: calc(100vh - 180px);
        min-height: 550px;
        max-height: 750px;
        border-radius: 20px;
        overflow: hidden;
        background: var(--card-bg);
        border: 1px solid rgba(79, 70, 229, 0.08);
        box-shadow: var(--shadow-msg-lg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Inter', sans-serif;
        position: relative;
        animation: scaleIn 0.5s ease;
    }

    .messenger-container::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: var(--gradient-hero);
        border-radius: 22px;
        z-index: -1;
        opacity: 0.05;
        animation: glowPulse 3s ease-in-out infinite;
    }

    .messenger-container:hover {
        box-shadow: var(--shadow-msg-hover);
        border-color: rgba(79, 70, 229, 0.15);
        transform: translateY(-2px);
    }

    /* ============================================
       SIDEBAR - CHAT LIST
       ============================================ */
    .msg-sidebar {
        width: 380px;
        min-width: 320px;
        background: var(--card-bg);
        border-right: 1px solid rgba(79, 70, 229, 0.08);
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        position: relative;
        animation: slideInLeft 0.6s ease;
    }

    /* ─── Sidebar Header ─── */
    .msg-sidebar-header {
        padding: 18px 20px 14px;
        border-bottom: 1px solid rgba(79, 70, 229, 0.08);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.04), rgba(124, 58, 237, 0.04));
        position: sticky;
        top: 0;
        z-index: 10;
        backdrop-filter: blur(10px);
    }

    .msg-sidebar-header .header-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .msg-sidebar-header h5 {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Inter', sans-serif;
    }

    .msg-sidebar-header h5 i {
        color: var(--msg-primary);
        font-size: 22px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(124, 58, 237, 0.1));
        padding: 8px;
        border-radius: 12px;
        border: 1px solid rgba(79, 70, 229, 0.08);
        animation: float 3s ease-in-out infinite;
    }

    .msg-sidebar-header .badge-total {
        font-size: 11px;
        background: var(--gradient-hero);
        color: white;
        padding: 2px 14px;
        border-radius: 20px;
        font-weight: 700;
        margin-left: 8px;
        box-shadow: 0 2px 12px rgba(79, 70, 229, 0.35);
        animation: pulse-badge 2s infinite;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }

    .msg-sidebar-header .badge-total:hover {
        transform: scale(1.1);
    }

    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); box-shadow: 0 2px 12px rgba(79, 70, 229, 0.35); }
        50% { transform: scale(1.05); box-shadow: 0 4px 20px rgba(79, 70, 229, 0.5); }
    }

    .msg-sidebar-header .header-actions button {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: 1px solid rgba(79, 70, 229, 0.08);
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .msg-sidebar-header .header-actions button::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: var(--gradient-btn);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .msg-sidebar-header .header-actions button:hover {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.08));
        color: var(--msg-primary);
        transform: rotate(180deg) scale(1.1);
        border-color: rgba(79, 70, 229, 0.2);
    }

    .msg-sidebar-header .header-actions button:active {
        transform: rotate(180deg) scale(0.95);
    }

    /* ─── Search ─── */
    .msg-sidebar-search {
        padding: 10px 16px 14px;
        border-bottom: 1px solid rgba(79, 70, 229, 0.06);
        background: var(--card-bg);
    }

    .msg-sidebar-search .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .msg-sidebar-search .search-icon {
        position: absolute;
        left: 14px;
        color: var(--msg-primary-light);
        font-size: 14px;
        pointer-events: none;
        opacity: 0.6;
        transition: all 0.3s ease;
    }

    .msg-sidebar-search input {
        width: 100%;
        padding: 10px 16px 10px 44px;
        border-radius: 30px;
        border: 1px solid rgba(79, 70, 229, 0.1);
        background: var(--bg-tertiary);
        color: var(--text-primary);
        font-size: 13px;
        outline: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .msg-sidebar-search input:focus {
        border-color: var(--msg-primary);
        background: var(--card-bg);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.06);
        transform: scale(1.02);
    }

    .msg-sidebar-search input:focus + .search-icon {
        opacity: 1;
        transform: scale(1.1);
    }

    .msg-sidebar-search input::placeholder {
        color: var(--text-muted);
        opacity: 0.6;
    }

    /* ─── Chat List ─── */
    .msg-church-list {
        flex: 1;
        overflow-y: auto;
        padding: 4px 0;
        background: var(--card-bg);
    }

    .msg-church-list::-webkit-scrollbar {
        width: 4px;
    }
    .msg-church-list::-webkit-scrollbar-track {
        background: transparent;
    }
    .msg-church-list::-webkit-scrollbar-thumb {
        background: rgba(79, 70, 229, 0.15);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .msg-church-list::-webkit-scrollbar-thumb:hover {
        background: rgba(79, 70, 229, 0.25);
    }

    .msg-church-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border-bottom: 1px solid rgba(79, 70, 229, 0.04);
        background: var(--card-bg);
        animation: slideInLeft 0.5s ease both;
    }

    .msg-church-item:nth-child(1) { animation-delay: 0.05s; }
    .msg-church-item:nth-child(2) { animation-delay: 0.1s; }
    .msg-church-item:nth-child(3) { animation-delay: 0.15s; }
    .msg-church-item:nth-child(4) { animation-delay: 0.2s; }
    .msg-church-item:nth-child(5) { animation-delay: 0.25s; }
    .msg-church-item:nth-child(6) { animation-delay: 0.3s; }
    .msg-church-item:nth-child(7) { animation-delay: 0.35s; }
    .msg-church-item:nth-child(8) { animation-delay: 0.4s; }
    .msg-church-item:nth-child(9) { animation-delay: 0.45s; }
    .msg-church-item:nth-child(10) { animation-delay: 0.5s; }

    .msg-church-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.04), rgba(124, 58, 237, 0.04));
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }

    .msg-church-item:hover {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.04), rgba(124, 58, 237, 0.04));
        transform: translateX(6px) scale(1.01);
        box-shadow: 0 2px 12px rgba(79, 70, 229, 0.05);
    }

    .msg-church-item:hover::before {
        opacity: 1;
    }

    .msg-church-item.active {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.06), rgba(124, 58, 237, 0.06));
        border-left: 4px solid var(--msg-primary);
        box-shadow: inset 0 1px 0 rgba(79, 70, 229, 0.05);
        animation: glowPulse 2s ease-in-out infinite;
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
        box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--gradient-avatar);
    }

    .msg-church-item:hover .avatar {
        transform: scale(1.08) rotate(5deg);
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.25);
    }

    .msg-church-item.active .avatar {
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3);
        animation: glowPulse 2s ease-in-out infinite;
    }

    .msg-church-item .avatar .online-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: var(--gradient-online);
        border: 3px solid var(--card-bg);
        animation: pulse-dot 2s infinite;
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.3);
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); box-shadow: 0 0 12px rgba(16, 185, 129, 0.3); }
        50% { opacity: 0.8; transform: scale(0.9); box-shadow: 0 0 8px rgba(16, 185, 129, 0.15); }
    }

    .msg-church-item .info {
        flex: 1;
        min-width: 0;
    }

    .msg-church-item .name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        transition: color 0.3s ease;
    }

    .msg-church-item:hover .name {
        color: var(--msg-primary);
    }

    .msg-church-item .last-msg {
        font-size: 13px;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 2px;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .msg-church-item .last-msg.has-unread {
        color: var(--msg-primary);
        font-weight: 500;
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
        opacity: 0.6;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .msg-church-item:hover .time {
        opacity: 1;
    }

    .msg-church-item .unread-count {
        background: var(--gradient-unread);
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
        box-shadow: 0 2px 12px rgba(239, 68, 68, 0.3);
        animation: pop-in 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }

    .msg-church-item .unread-count:hover {
        transform: scale(1.1);
    }

    @keyframes pop-in {
        0% { transform: scale(0) rotate(-30deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(5deg); }
        100% { transform: scale(1) rotate(0); opacity: 1; }
    }

    .msg-empty-state {
        padding: 50px 20px;
        text-align: center;
        color: var(--text-muted);
        animation: scaleIn 0.5s ease;
    }

    .msg-empty-state i {
        font-size: 56px;
        opacity: 0.15;
        margin-bottom: 16px;
        display: block;
        color: var(--msg-primary);
        animation: float 4s ease-in-out infinite;
    }

    .msg-empty-state p {
        font-size: 14px;
        opacity: 0.8;
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
        animation: slideInRight 0.6s ease;
    }

    .msg-main::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(79, 70, 229, 0.02) 0%, transparent 50%),
            radial-gradient(circle at 80% 50%, rgba(124, 58, 237, 0.02) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
        animation: shimmerEffect 10s linear infinite;
        background-size: 200% 100%;
    }

    /* ─── Chat Header ─── */
    .msg-main-header {
        padding: 14px 24px;
        background: var(--card-bg);
        border-bottom: 1px solid rgba(79, 70, 229, 0.06);
        display: flex;
        align-items: center;
        gap: 16px;
        flex-shrink: 0;
        min-height: 72px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        position: sticky;
        top: 0;
        z-index: 10;
        position: relative;
        animation: slideInDown 0.5s ease;
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .msg-main-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.1), transparent);
        animation: shimmerEffect 3s linear infinite;
        background-size: 200% 100%;
    }

    .msg-main-header .chat-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 20px;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 2px 12px rgba(79, 70, 229, 0.15);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--gradient-avatar);
        animation: float 4s ease-in-out infinite;
    }

    .msg-main-header .chat-avatar:hover {
        transform: scale(1.1) rotate(10deg);
        box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3);
    }

    .msg-main-header .chat-info {
        flex: 1;
    }

    .msg-main-header .chat-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        transition: color 0.3s ease;
    }

    .msg-main-header .chat-name:hover {
        color: var(--msg-primary);
    }

    .msg-main-header .chat-status {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .msg-main-header .chat-status.online {
        color: var(--msg-success);
    }

    .msg-main-header .chat-status .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .msg-main-header .chat-status.online .status-dot {
        background: var(--gradient-online);
        animation: pulse-dot 2s infinite;
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.2);
    }

    .msg-main-header .chat-actions button {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1px solid rgba(79, 70, 229, 0.08);
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .msg-main-header .chat-actions button::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: var(--gradient-btn);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .msg-main-header .chat-actions button:hover {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.08));
        color: var(--msg-primary);
        transform: translateY(-3px) scale(1.05);
        border-color: rgba(79, 70, 229, 0.15);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
    }

    .msg-main-header .chat-actions button:active {
        transform: translateY(0) scale(0.95);
    }

    /* ─── Messages List ─── */
    .msg-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px 24px;
        display: flex;
        flex-direction: column;
        gap: 2px;
        background: var(--bg-primary);
        position: relative;
        z-index: 1;
    }

    .msg-messages::-webkit-scrollbar {
        width: 5px;
    }
    .msg-messages::-webkit-scrollbar-track {
        background: transparent;
    }
    .msg-messages::-webkit-scrollbar-thumb {
        background: rgba(79, 70, 229, 0.12);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .msg-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(79, 70, 229, 0.2);
    }

    /* ─── Date Divider ─── */
    .msg-date-divider {
        text-align: center;
        margin: 16px 0 20px;
        position: relative;
        animation: scaleIn 0.4s ease;
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
        letter-spacing: 0.8px;
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .msg-date-divider span:hover {
        opacity: 1;
        color: var(--msg-primary);
    }

    .msg-date-divider::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.08), transparent);
        animation: shimmerEffect 4s linear infinite;
        background-size: 200% 100%;
    }

    /* ─── Message Bubbles ─── */
    .msg-bubble {
        max-width: 75%;
        padding: 10px 18px;
        border-radius: 18px;
        animation: messageAppear 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        word-wrap: break-word;
        line-height: 1.6;
        font-size: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Inter', sans-serif;
    }

    .msg-bubble:hover {
        transform: translateY(-2px) scale(1.01);
    }

    .msg-bubble.sent {
        align-self: flex-end;
        background: var(--gradient-sent);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: var(--shadow-sent);
        animation: messageAppear 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .msg-bubble.sent:hover {
        box-shadow: 0 6px 28px rgba(79, 70, 229, 0.35);
        transform: translateY(-2px) scale(1.02);
    }

    .msg-bubble.received {
        align-self: flex-start;
        background: var(--card-bg);
        color: var(--text-primary);
        border-bottom-left-radius: 4px;
        border: 1px solid rgba(79, 70, 229, 0.06);
        box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        animation: messageAppear 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .msg-bubble.received:hover {
        border-color: rgba(79, 70, 229, 0.15);
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        transform: translateY(-2px) scale(1.01);
    }

    .msg-bubble .subject {
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 4px;
        opacity: 0.9;
        letter-spacing: -0.3px;
        color: var(--msg-primary-light);
        animation: slideInLeft 0.3s ease;
    }

    .msg-bubble.sent .subject {
        color: rgba(255,255,255,0.85);
    }

    .msg-bubble .subject i {
        margin-right: 6px;
        font-size: 11px;
        opacity: 0.7;
        color: var(--msg-secondary-light);
        animation: wave 2s ease-in-out infinite;
    }

    .msg-bubble .body {
        font-size: 14px;
        line-height: 1.6;
        animation: scaleIn 0.3s ease;
    }

    .msg-bubble .time {
        font-size: 10px;
        opacity: 0.7;
        margin-top: 6px;
        text-align: right;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        letter-spacing: 0.3px;
        font-weight: 500;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .msg-bubble.sent .time {
        color: rgba(255,255,255,0.75);
    }

    .msg-bubble.received .time {
        color: var(--text-muted);
    }

    .msg-bubble .status-icon {
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .msg-bubble .status-icon .fa-check-double {
        color: var(--msg-primary-light);
        animation: scaleIn 0.3s ease;
    }

    .msg-bubble.sent .status-icon .fa-check {
        color: rgba(255,255,255,0.6);
        animation: scaleIn 0.3s ease;
    }

    .msg-bubble.new-message {
        animation: newMessagePop 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .msg-bubble.new-message.sent {
        animation: newMessagePopSent 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    @keyframes newMessagePop {
        0% { opacity: 0; transform: scale(0.7) translateY(30px) rotate(-5deg); }
        60% { transform: scale(1.05) translateY(-5px) rotate(1deg); }
        100% { opacity: 1; transform: scale(1) translateY(0) rotate(0); }
    }

    @keyframes newMessagePopSent {
        0% { opacity: 0; transform: scale(0.7) translateY(30px) rotate(5deg); }
        60% { transform: scale(1.05) translateY(-5px) rotate(-1deg); }
        100% { opacity: 1; transform: scale(1) translateY(0) rotate(0); }
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
        animation: scaleIn 0.6s ease;
    }

    .msg-empty-state-main i {
        font-size: 72px;
        opacity: 0.1;
        margin-bottom: 20px;
        display: block;
        color: var(--msg-primary);
        animation: float 4s ease-in-out infinite;
    }

    .msg-empty-state-main h4 {
        color: var(--text-primary);
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 8px;
        font-family: 'Inter', sans-serif;
        animation: slideInLeft 0.5s ease;
    }

    .msg-empty-state-main p {
        font-size: 14px;
        max-width: 320px;
        color: var(--text-muted);
        opacity: 0.8;
        line-height: 1.6;
        animation: slideInRight 0.5s ease;
    }

    .msg-empty-state-main .btn-compose-empty {
        margin-top: 20px;
        padding: 12px 36px;
        border-radius: 40px;
        border: none;
        background: var(--gradient-btn);
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Inter', sans-serif;
        box-shadow: var(--shadow-btn);
        border: 1px solid rgba(255,255,255,0.05);
        animation: scaleIn 0.6s ease 0.3s both;
        position: relative;
        overflow: hidden;
    }

    .msg-empty-state-main .btn-compose-empty::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .msg-empty-state-main .btn-compose-empty:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: var(--shadow-btn-hover);
        background: var(--gradient-btn-hover);
    }

    .msg-empty-state-main .btn-compose-empty:hover::after {
        opacity: 1;
    }

    .msg-empty-state-main .btn-compose-empty:active {
        transform: scale(0.97);
    }

    /* ─── Compose ─── */
    .msg-compose {
        padding: 12px 20px 16px;
        background: var(--card-bg);
        border-top: 1px solid rgba(79, 70, 229, 0.06);
        flex-shrink: 0;
        display: block !important;
        box-shadow: 0 -1px 4px rgba(0,0,0,0.02);
        position: relative;
        z-index: 2;
        animation: slideInUp 0.5s ease;
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .msg-compose::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(79, 70, 229, 0.08), transparent);
        animation: shimmerEffect 4s linear infinite;
        background-size: 200% 100%;
    }

    .msg-compose .compose-wrapper {
        display: flex;
        gap: 10px;
        align-items: flex-end;
        background: var(--bg-tertiary);
        border-radius: 24px;
        border: 2px solid rgba(79, 70, 229, 0.06);
        padding: 4px 6px 4px 18px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .msg-compose .compose-wrapper:focus-within {
        border-color: var(--msg-primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.06);
        background: var(--card-bg);
        transform: scale(1.01);
    }

    .msg-compose .compose-inputs {
        flex: 1;
        padding: 6px 0;
    }

    .msg-compose .compose-inputs .subject-input {
        border-bottom: 1px solid rgba(79, 70, 229, 0.06);
        padding-bottom: 4px;
        margin-bottom: 4px;
        display: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .msg-compose .compose-inputs .subject-input.show {
        display: block;
        animation: slideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-15px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .msg-compose .compose-inputs input {
        width: 100%;
        border: none;
        background: transparent;
        padding: 4px 0;
        font-size: 14px;
        color: var(--text-primary);
        outline: none;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .msg-compose .compose-inputs input::placeholder {
        color: var(--text-muted);
        opacity: 0.6;
        transition: opacity 0.3s ease;
    }

    .msg-compose .compose-inputs input:focus::placeholder {
        opacity: 0.3;
    }

    .msg-compose .compose-inputs .subject-input input {
        font-weight: 600;
        font-size: 13px;
        color: var(--msg-primary);
    }

    .msg-compose .compose-inputs .subject-input input::placeholder {
        color: var(--msg-primary-light);
        opacity: 0.5;
    }

    .msg-compose .compose-actions {
        display: flex;
        gap: 2px;
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
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .msg-compose .compose-actions button::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: var(--gradient-btn);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .msg-compose .compose-actions button:hover {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.06), rgba(124, 58, 237, 0.06));
        color: var(--msg-primary);
        transform: rotate(20deg) scale(1.1);
    }

    .msg-compose .compose-actions button:active {
        transform: rotate(0) scale(0.95);
    }

    .msg-compose .btn-send-msg {
        background: var(--gradient-btn);
        color: white;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: var(--shadow-btn);
        border: 1px solid rgba(255,255,255,0.05);
        position: relative;
        overflow: hidden;
    }

    .msg-compose .btn-send-msg::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .msg-compose .btn-send-msg:hover {
        transform: scale(1.08) translateY(-3px);
        box-shadow: var(--shadow-btn-hover);
        background: var(--gradient-btn-hover);
    }

    .msg-compose .btn-send-msg:hover::after {
        opacity: 1;
    }

    .msg-compose .btn-send-msg:active {
        transform: scale(0.92);
        box-shadow: none;
    }

    .msg-compose .btn-send-msg:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    /* ─── Toast Notification ─── */
    .msg-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 99999;
        background: var(--card-bg);
        border: 1px solid rgba(79, 70, 229, 0.08);
        border-radius: 16px;
        padding: 14px 20px;
        box-shadow: var(--shadow-toast);
        display: flex;
        align-items: center;
        gap: 14px;
        transform: translateX(120%);
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 380px;
        border-left: 4px solid var(--msg-primary);
        font-family: 'Inter', sans-serif;
        animation: none;
    }

    .msg-toast.show {
        transform: translateX(0);
        animation: toastSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes toastSlideIn {
        0% { opacity: 0; transform: translateX(120%) scale(0.8); }
        60% { transform: translateX(-10px) scale(1.02); }
        100% { opacity: 1; transform: translateX(0) scale(1); }
    }

    .msg-toast .toast-icon {
        font-size: 1.2rem;
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.08), rgba(124, 58, 237, 0.08));
        color: var(--msg-primary);
        animation: rotateIn 0.5s ease;
    }

    .msg-toast .toast-content {
        flex: 1;
    }

    .msg-toast .toast-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-primary);
        animation: slideInLeft 0.3s ease 0.2s both;
    }

    .msg-toast .toast-message {
        font-size: 0.65rem;
        color: var(--text-muted);
        opacity: 0.8;
        animation: slideInLeft 0.3s ease 0.3s both;
    }

    .msg-toast .toast-close {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 0.9rem;
        padding: 4px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .msg-toast .toast-close:hover {
        color: var(--text-primary);
        transform: rotate(90deg) scale(1.2);
    }

    /* ─── Responsive ─── */
    @media (max-width: 992px) {
        .msg-sidebar {
            width: 340px;
            min-width: 280px;
        }
    }

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
            border-bottom: 1px solid rgba(79, 70, 229, 0.06);
            animation: slideInDown 0.5s ease;
        }

        .msg-sidebar-header h5 { font-size: 16px; }
        .msg-church-item { padding: 10px 14px; }
        .msg-church-item .avatar { width: 40px; height: 40px; font-size: 14px; }

        .msg-main-header { padding: 10px 16px; min-height: 58px; }
        .msg-main-header .chat-avatar { width: 36px; height: 36px; font-size: 14px; }
        .msg-main-header .chat-name { font-size: 14px; }

        .msg-messages { padding: 12px 14px; }
        .msg-bubble { max-width: 90%; font-size: 13px; padding: 8px 14px; border-radius: 14px; }

        .msg-compose { padding: 8px 12px 12px; }
        .msg-compose .btn-send-msg { width: 40px; height: 40px; font-size: 16px; }

        .msg-empty-state-main i { font-size: 48px; }
        .msg-empty-state-main h4 { font-size: 18px; }
        
        .msg-toast {
            max-width: calc(100vw - 32px);
            right: 16px;
            bottom: 16px;
        }
    }

    @media (max-width: 480px) {
        .messenger-container { height: calc(100vh - 140px); }
        .msg-sidebar { max-height: 180px; }
        .msg-sidebar-header { padding: 10px 14px; }
        .msg-sidebar-header h5 { font-size: 14px; }
        .msg-sidebar-search input { font-size: 12px; padding: 8px 12px 8px 38px; }
        .msg-church-item { padding: 8px 10px; }
        .msg-church-item .avatar { width: 34px; height: 34px; font-size: 12px; }
        .msg-bubble { max-width: 95%; font-size: 12px; padding: 6px 12px; border-radius: 12px; }
        .msg-compose .btn-send-msg { width: 36px; height: 36px; font-size: 14px; }
        .msg-compose .compose-wrapper { padding: 2px 4px 2px 12px; }
        .msg-compose .compose-actions button { width: 34px; height: 34px; font-size: 14px; }
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
                    <i class="fas fa-comment-dots"></i> Messages
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
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchChurches" placeholder="Search churches..." onkeyup="filterChurches(this.value)">
            </div>
        </div>

        <div class="msg-church-list" id="churchList">
            @forelse($allChurches ?? [] as $church)
                <div class="msg-church-item" data-church-id="{{ $church->id }}" onclick="loadConversation({{ $church->id }})">
                    <div class="avatar" style="background: {{ $church->avatar_color ?? 'linear-gradient(135deg, #4F46E5, #8B5CF6)' }};">
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
            <div class="chat-avatar" id="chatAvatar" style="background: linear-gradient(135deg, #4F46E5, #8B5CF6);">
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
                <p>Click on a church from the sidebar to view the conversation</p>
            </div>
        </div>

        <!-- Compose -->
        <div class="msg-compose" id="msgCompose">
            <form id="messageForm" onsubmit="sendMessage(event)">
                <input type="hidden" id="receiverId" value="">
                <div class="compose-wrapper">
                    <div class="compose-inputs">
                        <div class="subject-input" id="subjectContainer">
                            <input type="text" id="subjectInput" placeholder="Subject (optional)" />
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

<!-- ============================================
TOAST NOTIFICATION
============================================ -->
<div class="msg-toast" id="msgToast">
    <div class="toast-icon" id="toastIcon">📨</div>
    <div class="toast-content">
        <div class="toast-title" id="toastTitle">New Message</div>
        <div class="toast-message" id="toastMessage">You have a new message</div>
    </div>
    <button class="toast-close" onclick="closeToast()">
        <i class="fas fa-times"></i>
    </button>
</div>

<script>
    // ============================================
    // STATE
    // ============================================
    let currentChurchId = null;
    let currentChurchName = '';
    let isComposeOpen = false;
    let subjectVisible = false;
    let toastTimeout = null;

    // ============================================
    // TOAST NOTIFICATION
    // ============================================
    function showToast(title, message, icon = '📨') {
        const toast = document.getElementById('msgToast');
        if (!toast) return;
        
        document.getElementById('toastTitle').textContent = title;
        document.getElementById('toastMessage').textContent = message;
        document.getElementById('toastIcon').textContent = icon;
        
        // Reset animation
        toast.classList.remove('show');
        void toast.offsetWidth; // Trigger reflow
        toast.classList.add('show');
        
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(function() {
            toast.classList.remove('show');
        }, 5000);
    }

    function closeToast() {
        const toast = document.getElementById('msgToast');
        if (toast) {
            toast.classList.remove('show');
        }
    }

    // ============================================
    // TOGGLE SUBJECT
    // ============================================
    function toggleSubject() {
        subjectVisible = !subjectVisible;
        const container = document.getElementById('subjectContainer');
        container.classList.toggle('show');
        if (subjectVisible) {
            setTimeout(() => {
                document.getElementById('subjectInput').focus();
            }, 400);
        }
    }

    // ============================================
    // TOGGLE COMPOSE
    // ============================================
    function toggleCompose() {
        const receiverId = document.getElementById('receiverId').value;
        if (!receiverId) {
            showToast('Please select a church first', 'Click on a church from the sidebar', '💬');
            return;
        }
        
        const input = document.getElementById('messageInput');
        input.focus();
        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Add animation
        input.style.animation = 'none';
        void input.offsetWidth;
        input.style.animation = 'scaleIn 0.5s ease';
    }

    // ============================================
    // LOAD CONVERSATION - AUTO DISPLAY MESSAGES
    // ============================================
    function loadConversation(churchId) {
        currentChurchId = churchId;

        // Update active state with animation
        document.querySelectorAll('.msg-church-item').forEach(el => {
            el.classList.remove('active');
            if (el.dataset.churchId == churchId) {
                el.classList.add('active');
                currentChurchName = el.querySelector('.name').textContent;
                
                // Add highlight animation
                el.style.animation = 'none';
                void el.offsetWidth;
                el.style.animation = 'slideInLeft 0.5s ease';
            }
        });

        // Update header
        const church = document.querySelector(`.msg-church-item[data-church-id="${churchId}"]`);
        if (church) {
            const avatar = church.querySelector('.avatar');
            const avatarBg = avatar.style.background;
            const avatarText = avatar.textContent.trim();

            document.getElementById('chatAvatar').style.background = avatarBg || 'linear-gradient(135deg, #4F46E5, #8B5CF6)';
            document.getElementById('chatAvatar').textContent = avatarText || '?';
            document.getElementById('chatName').textContent = currentChurchName;
            document.getElementById('chatStatus').innerHTML = `
                <span class="status-dot"></span> Loading messages...
            `;
            document.getElementById('chatStatus').className = 'chat-status';
            
            // Add animation to header
            document.getElementById('chatHeader').style.animation = 'none';
            void document.getElementById('chatHeader').offsetWidth;
            document.getElementById('chatHeader').style.animation = 'slideInDown 0.5s ease';
        }

        // Set receiver for compose
        document.getElementById('receiverId').value = churchId;

        // Show loading
        const list = document.getElementById('messageList');
        list.innerHTML = `
            <div class="msg-empty-state-main">
                <i class="fas fa-spinner fa-spin" style="font-size:32px;opacity:0.5;color:#4F46E5;"></i>
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
                    if (badge) {
                        badge.style.animation = 'scaleIn 0.3s ease reverse';
                        setTimeout(() => badge.remove(), 300);
                    }

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

        messages.forEach((msg, index) => {
            const isSent = msg.sender_church_id == churchId;
            const msgDate = new Date(msg.created_at);
            const dateStr = msgDate.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });

            if (dateStr !== lastDate) {
                html += `<div class="msg-date-divider"><span>${dateStr}</span></div>`;
                lastDate = dateStr;
            }

            const timeStr = msgDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            const delay = index * 50; // Stagger animation

            html += `
                <div class="msg-bubble ${isSent ? 'sent' : 'received'}" data-msg-id="${msg.id}" style="animation-delay: ${delay}ms;">
                    ${msg.subject ? `<div class="subject"><i class="fas fa-tag"></i> ${escapeHtml(msg.subject)}</div>` : ''}
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
            ${msg.subject ? `<div class="subject"><i class="fas fa-tag"></i> ${escapeHtml(msg.subject)}</div>` : ''}
            <div class="body">${escapeHtml(msg.body)}</div>
            <div class="time">
                ${timeStr}
                ${isSent ? '<span class="status-icon"><i class="fas fa-check"></i></span>' : ''}
            </div>
        `;

        list.appendChild(bubble);

        // Add sound effect (optional)
        if (!isSent) {
            // Play notification sound if available
            try {
                const audio = new Audio('/sounds/notification.mp3');
                audio.play().catch(() => {});
            } catch (e) {}
        }

        setTimeout(() => {
            list.scrollTop = list.scrollHeight;
        }, 100);

        // Update sidebar
        const senderId = msg.sender_church_id == churchId ? msg.receiver_church_id : msg.sender_church_id;
        const lastMsgEl = document.getElementById(`lastMsg-${senderId}`);
        if (lastMsgEl) {
            const msgBody = msg.body || '';
            lastMsgEl.textContent = msgBody.length > 50 ? msgBody.substring(0, 50) + '...' : msgBody;
            lastMsgEl.classList.add('has-unread');
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
                    badge.style.animation = 'none';
                    void badge.offsetWidth;
                    badge.style.animation = 'pop-in 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
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
            showToast('Please type a message', 'Your message cannot be empty', '⚠️');
            document.getElementById('messageInput').style.animation = 'shake 0.5s ease';
            setTimeout(() => {
                document.getElementById('messageInput').style.animation = '';
            }, 500);
            return;
        }

        if (!receiverId) {
            showToast('Please select a church', 'Click on a church from the sidebar', '💬');
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
                showToast('Message sent! ✅', 'Your message was delivered successfully', '✅');
                // Update the temp message with real ID if needed
            } else {
                showToast('Failed to send ❌', data.message || 'Something went wrong', '❌');
                if (currentChurchId) {
                    loadConversation(currentChurchId);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            sendBtn.disabled = false;
            sendBtn.innerHTML = originalHtml;
            showToast('Error sending message ❌', 'Please check your connection', '❌');
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

        items.forEach((item, index) => {
            const name = item.querySelector('.name').textContent.toLowerCase();
            const lastMsg = item.querySelector('.last-msg').textContent.toLowerCase();
            const match = name.includes(q) || lastMsg.includes(q) || q === '';
            
            if (match) {
                item.style.display = 'flex';
                item.style.animation = `slideInLeft 0.4s ease ${index * 30}ms both`;
            } else {
                item.style.display = 'none';
            }
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
            const oldValue = parseInt(badge.textContent) || 0;
            badge.textContent = total;
            
            if (total > oldValue) {
                badge.style.animation = 'none';
                void badge.offsetWidth;
                badge.style.animation = 'pulse-badge 2s infinite';
            }
            
            badge.style.display = total > 0 ? 'inline-block' : 'none';
            
            // Update header notification count
            const notifBadge = document.querySelector('.notification-count');
            if (notifBadge) {
                notifBadge.textContent = total;
                notifBadge.style.display = total > 0 ? 'flex' : 'none';
            }
        }
    }

    // ============================================
    // REFRESH MESSAGES
    // ============================================
    function refreshMessages() {
        const btn = document.querySelector('.msg-sidebar-header .header-actions button');
        btn.style.animation = 'rotateIn 0.5s ease';
        setTimeout(() => {
            btn.style.animation = '';
        }, 500);
        
        if (currentChurchId) {
            loadConversation(currentChurchId);
            showToast('Refreshing... 🔄', 'Getting latest messages', '🔄');
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
    // REAL-TIME MESSAGE LISTENER
    // ============================================
    if (window.Echo) {
        const churchId = '{{ Auth::user()->church_id }}';

        window.Echo.channel(`messages.${churchId}`)
            .listen('message.new', (e) => {
                console.log('📨 New message received:', e);

                showToast(
                    `📨 ${e.sender_name}`,
                    e.subject ? `${e.subject}: ${e.body.substring(0, 50)}${e.body.length > 50 ? '...' : ''}` : e.body.substring(0, 60) + (e.body.length > 60 ? '...' : ''),
                    '📨'
                );

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
                        lastMsg.classList.add('has-unread');
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
                            badge.style.animation = 'none';
                            void badge.offsetWidth;
                            badge.style.animation = 'pop-in 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                        }
                    }

                    // Highlight sidebar item
                    item.classList.add('updated');
                    setTimeout(() => item.classList.remove('updated'), 1000);
                    updateTotalUnread();
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
            showToast('Compose New Message', 'Ctrl+N pressed', '✏️');
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
    // AUTO-LOAD FIRST CHURCH WITH MESSAGES
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        console.log('💬 Messenger loading...');
        
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

        // Update total unread count
        updateTotalUnread();

        // Add welcome toast after load
        setTimeout(() => {
            showToast('💬 Messenger Ready', 'Click a church to start chatting', '💬');
        }, 1000);

        console.log('💬 Messenger loaded successfully!');
    });
</script>
@endsection