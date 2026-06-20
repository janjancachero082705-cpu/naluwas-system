@extends('layouts.app')

@section('header', 'Finance Dashboard')

@section('content')
<style>
    /* ============================================
       FINANCE DASHBOARD - CLEAN & MODERN
    ============================================ */
    
    .finance-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .finance-stat-card {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.1rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .finance-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }
    
    .finance-stat-card .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    
    .finance-stat-card .stat-icon.income {
        background: #E1F5EE;
        color: #0F6E56;
    }
    
    .finance-stat-card .stat-icon.expense {
        background: #FCEBEB;
        color: #A32D2D;
    }
    
    .finance-stat-card .stat-icon.balance {
        background: #EEEDFE;
        color: #534AB7;
    }
    
    .finance-stat-card .stat-icon.churches {
        background: #E6F1FB;
        color: #185FA5;
    }
    
    .finance-stat-card .stat-info {
        flex: 1;
        min-width: 0;
    }
    
    .finance-stat-card .stat-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: var(--text-muted);
        font-weight: 600;
    }
    
    .finance-stat-card .stat-value {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .finance-stat-card .stat-value.positive {
        color: #0F6E56;
    }
    
    .finance-stat-card .stat-value.negative {
        color: #A32D2D;
    }
    
    .finance-stat-card .stat-sub {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    
    /* Church Selector - View Only */
    .church-selector {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .church-selector label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .church-selector label i {
        color: #534AB7;
    }
    
    .church-selector select {
        padding: 0.5rem 1rem;
        border: 0.5px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.85rem;
        min-width: 220px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .church-selector select:focus {
        outline: none;
        border-color: #534AB7;
        box-shadow: 0 0 0 3px rgba(83, 74, 183, 0.1);
    }
    
    .church-selector .selected-church-info {
        margin-left: auto;
        font-size: 0.75rem;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        border: 0.5px solid var(--border-color);
    }
    
    .church-selector .selected-church-info strong {
        color: #534AB7;
    }
    
    /* ============================================
       MESSAGING BUTTON - RIGHT SIDE
    ============================================ */
    .msg-header-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        border: 1px solid #FCD34D;
        color: #92400e;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        margin-left: auto;
    }
    
    .msg-header-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(217, 119, 6, 0.25);
        background: linear-gradient(135deg, #FDE68A, #FCD34D);
    }
    
    .msg-header-btn i {
        font-size: 0.9rem;
        color: #D97706;
    }
    
    .msg-header-btn .msg-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #ef4444;
        border-radius: 50%;
        min-width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        color: white;
        font-weight: 700;
        padding: 0 5px;
        border: 2px solid var(--card-bg);
        animation: pulse-badge 2s infinite;
    }
    
    .msg-header-btn .msg-badge.has-messages {
        background: #ef4444;
    }
    
    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    /* Church Detail Card - View Only */
    .church-detail-card {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .church-detail-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #534AB7, #7C3AED);
    }
    
    .church-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .church-detail-header .church-name-large {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .church-detail-header .church-name-large i {
        color: #534AB7;
        margin-right: 8px;
    }
    
    .church-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.8rem;
    }
    
    .church-detail-item {
        background: var(--bg-tertiary);
        border-radius: 10px;
        padding: 0.8rem;
        text-align: center;
        border: 0.5px solid var(--border-color);
    }
    
    .church-detail-item .label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        color: var(--text-muted);
        font-weight: 600;
    }
    
    .church-detail-item .value {
        font-size: 1.1rem;
        font-weight: 600;
        margin-top: 0.2rem;
    }
    
    .church-detail-item .value.income {
        color: #0F6E56;
    }
    
    .church-detail-item .value.expense {
        color: #A32D2D;
    }
    
    .church-detail-item .value.balance {
        color: #534AB7;
    }
    
    .category-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
        margin-top: 0.5rem;
    }
    
    .category-tag {
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 0.65rem;
        border: 0.5px solid var(--border-color);
        background: var(--bg-tertiary);
        color: var(--text-muted);
    }
    
    .category-tag.income-tag {
        background: #E1F5EE;
        color: #0F6E56;
        border-color: rgba(15, 110, 86, 0.15);
    }
    
    .category-tag.expense-tag {
        background: #FCEBEB;
        color: #A32D2D;
        border-color: rgba(163, 45, 45, 0.15);
    }
    
    /* Chart Container */
    .chart-container {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .chart-container .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .chart-container .chart-header h6 {
        font-size: 0.75rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        display: flex;
        align-items: center;
        gap: 7px;
    }
    
    .chart-container .chart-header h6 i {
        font-size: 0.85rem;
        color: #0F6E56;
    }
    
    .chart-legend {
        display: flex;
        gap: 16px;
        margin-bottom: 8px;
    }
    
    .leg-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.7rem;
        color: var(--text-muted);
    }
    
    .leg-dot {
        width: 10px;
        height: 10px;
        border-radius: 2px;
    }
    
    .chart-box {
        height: 220px;
        position: relative;
    }
    
    .chart-box canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* All Churches Grid - View Only */
    .all-churches-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 0.8rem;
        margin-bottom: 1.5rem;
    }
    
    .church-mini-card {
        background: var(--card-bg);
        border: 0.5px solid var(--border-color);
        border-radius: 10px;
        padding: 0.9rem 1rem;
        transition: all 0.2s ease;
        cursor: default;
        position: relative;
    }
    
    .church-mini-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        border-color: #534AB7;
    }
    
    .church-mini-card .church-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.2rem;
    }
    
    .church-mini-card .church-name i {
        color: #534AB7;
        margin-right: 6px;
    }
    
    .church-mini-card .mini-balance {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .church-mini-card .mini-balance.positive {
        color: #0F6E56;
    }
    
    .church-mini-card .mini-balance.negative {
        color: #A32D2D;
    }
    
    .church-mini-card .mini-details {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.3rem;
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .church-mini-card .mini-details span {
        background: var(--bg-tertiary);
        padding: 1px 8px;
        border-radius: 10px;
        border: 0.5px solid var(--border-color);
    }
    
    .church-mini-card .status-dot {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .church-mini-card .status-dot.surplus {
        background: #0F6E56;
    }
    
    .church-mini-card .status-dot.deficit {
        background: #A32D2D;
    }
    
    /* View Button on Mini Card */
    .btn-view-church {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 6px;
        background: #EEEDFE;
        color: #534AB7;
        font-size: 0.6rem;
        font-weight: 600;
        border: 0.5px solid rgba(83, 74, 183, 0.15);
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        margin-top: 6px;
    }
    
    .btn-view-church:hover {
        background: #534AB7;
        color: white;
        transform: translateY(-1px);
    }
    
    /* ============================================
       PROFESSIONAL MESSAGING OVERLAY
    ============================================ */
    .message-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--bg-primary);
        z-index: 10000;
        animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
    }
    
    .message-overlay.active {
        display: block;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .message-overlay-header {
        position: sticky;
        top: 0;
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        padding: 0.8rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 10;
        backdrop-filter: blur(20px);
        background: rgba(var(--card-bg-rgb, 255, 255, 255), 0.92);
        box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    }
    
    [data-theme="dark"] .message-overlay-header {
        background: rgba(30, 41, 59, 0.92);
    }
    
    .message-overlay-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .btn-back-messages {
        background: none;
        border: none;
        color: var(--text-primary);
        font-size: 0.9rem;
        cursor: pointer;
        padding: 8px 14px;
        border-radius: 10px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
    }
    
    .btn-back-messages:hover {
        background: var(--hover-bg);
        transform: translateX(-2px);
    }
    
    .btn-back-messages i {
        font-size: 0.9rem;
        transition: transform 0.2s ease;
    }
    
    .btn-back-messages:hover i {
        transform: translateX(-3px);
    }
    
    .message-overlay-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .message-overlay-title i {
        color: #D97706;
        font-size: 1.1rem;
    }
    
    .msg-count-badge {
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        color: #92400e;
        padding: 2px 14px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 700;
        border: 1px solid #FCD34D;
    }
    
    .message-overlay-close {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.2rem;
        cursor: pointer;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .message-overlay-close:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }
    
    .message-overlay-body {
        max-width: 820px;
        margin: 0 auto;
        padding: 1.5rem;
    }
    
    /* Message Compose - Professional */
    .msg-compose-overlay {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
    }
    
    .msg-compose-overlay:focus-within {
        box-shadow: 0 4px 30px rgba(83, 74, 183, 0.08);
        border-color: #534AB7;
    }
    
    .msg-compose-overlay .compose-row {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }
    
    .msg-compose-overlay select {
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.85rem;
        flex: 1;
        min-width: 180px;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 12px;
        cursor: pointer;
    }
    
    .msg-compose-overlay select:focus {
        outline: none;
        border-color: #534AB7;
        box-shadow: 0 0 0 4px rgba(83, 74, 183, 0.08);
    }
    
    .msg-compose-overlay textarea {
        flex: 2;
        padding: 0.7rem 1rem;
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.85rem;
        resize: vertical;
        min-height: 60px;
        max-height: 120px;
        transition: all 0.3s ease;
        font-family: inherit;
        line-height: 1.5;
    }
    
    .msg-compose-overlay textarea:focus {
        outline: none;
        border-color: #534AB7;
        box-shadow: 0 0 0 4px rgba(83, 74, 183, 0.08);
    }
    
    .msg-compose-overlay textarea::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }
    
    .btn-send-msg-overlay {
        padding: 0.7rem 2rem;
        border-radius: 12px;
        background: linear-gradient(135deg, #D97706, #F59E0B);
        color: white;
        border: none;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
    }
    
    .btn-send-msg-overlay:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(217, 119, 6, 0.4);
    }
    
    .btn-send-msg-overlay:active {
        transform: translateY(0);
    }
    
    .btn-send-msg-overlay:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    /* Messages List - Professional */
    .msg-list-overlay {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }
    
    .msg-item-overlay {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        position: relative;
    }
    
    .msg-item-overlay:hover {
        border-color: #534AB7;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    
    .msg-item-overlay .msg-content {
        flex: 1;
        min-width: 0;
    }
    
    .msg-item-overlay .msg-sender {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }
    
    .msg-item-overlay .msg-sender i {
        color: #534AB7;
        font-size: 0.8rem;
    }
    
    .msg-item-overlay .msg-sender .sender-badge {
        font-size: 0.55rem;
        background: #EEEDFE;
        color: #534AB7;
        padding: 1px 10px;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    
    .msg-item-overlay .msg-text {
        font-size: 0.88rem;
        color: var(--text-secondary);
        line-height: 1.6;
        word-wrap: break-word;
    }
    
    .msg-item-overlay .msg-time {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .msg-item-overlay .msg-time i {
        font-size: 0.55rem;
    }
    
    .msg-item-overlay .msg-status-badge {
        font-size: 0.6rem;
        padding: 4px 14px;
        border-radius: 20px;
        flex-shrink: 0;
        font-weight: 600;
        margin-top: 2px;
        letter-spacing: 0.3px;
    }
    
    .msg-item-overlay .msg-status-badge.unread {
        background: #EEEDFE;
        color: #534AB7;
        border: 1px solid rgba(83, 74, 183, 0.15);
    }
    
    .msg-item-overlay .msg-status-badge.read {
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }
    
    .msg-item-overlay .msg-actions {
        display: flex;
        gap: 4px;
        flex-shrink: 0;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .msg-item-overlay:hover .msg-actions {
        opacity: 1;
    }
    
    .msg-item-overlay .msg-actions button {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.7rem;
        transition: all 0.2s ease;
    }
    
    .msg-item-overlay .msg-actions button:hover {
        background: var(--bg-tertiary);
        color: #534AB7;
    }
    
    .msg-item-overlay .msg-actions .btn-delete-msg:hover {
        color: #A32D2D;
        background: #FCEBEB;
    }
    
    .msg-item-overlay .msg-actions .btn-mark-read:hover {
        color: #0F6E56;
        background: #E1F5EE;
    }
    
    /* Unread indicator dot */
    .msg-item-overlay .msg-unread-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #534AB7;
        flex-shrink: 0;
        margin-top: 6px;
        animation: pulse-dot 2s infinite;
    }
    
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.2); }
    }
    
    .empty-messages-overlay {
        text-align: center;
        padding: 4rem 1rem;
        color: var(--text-muted);
    }
    
    .empty-messages-overlay i {
        font-size: 4rem;
        display: block;
        margin-bottom: 1rem;
        opacity: 0.2;
        color: #D97706;
    }
    
    .empty-messages-overlay h5 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }
    
    .empty-messages-overlay p {
        font-size: 0.9rem;
        opacity: 0.7;
    }
    
    .empty-messages-overlay .empty-cta {
        margin-top: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.5rem 1.5rem;
        background: linear-gradient(135deg, #FEF3C7, #FDE68A);
        border: 1px solid #FCD34D;
        border-radius: 10px;
        color: #92400e;
        font-weight: 600;
        font-size: 0.8rem;
        cursor: default;
    }
    
    /* Message Toast */
    .msg-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 14px 24px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.12);
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 12px;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        max-width: 380px;
    }
    
    .msg-toast.show {
        transform: translateY(0);
        opacity: 1;
    }
    
    .msg-toast.success {
        border-left: 4px solid #0F6E56;
    }
    
    .msg-toast.error {
        border-left: 4px solid #A32D2D;
    }
    
    .msg-toast i {
        font-size: 1.2rem;
    }
    
    .msg-toast.success i {
        color: #0F6E56;
    }
    
    .msg-toast.error i {
        color: #A32D2D;
    }
    
    .msg-toast .toast-close {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 4px;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    
    .msg-toast .toast-close:hover {
        color: var(--text-primary);
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .finance-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .church-detail-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .all-churches-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 768px) {
        .finance-stats-grid {
            grid-template-columns: 1fr;
        }
        .church-detail-grid {
            grid-template-columns: 1fr;
        }
        .all-churches-grid {
            grid-template-columns: 1fr;
        }
        .church-selector {
            flex-direction: column;
            align-items: stretch;
        }
        .church-selector select {
            width: 100%;
        }
        .church-selector .selected-church-info {
            margin-left: 0;
            text-align: center;
        }
        .msg-header-btn {
            margin-left: 0;
            width: 100%;
            justify-content: center;
        }
        .chart-box {
            height: 180px;
        }
        .msg-compose-overlay .compose-row {
            flex-direction: column;
        }
        .msg-compose-overlay textarea {
            min-height: 50px;
        }
        .btn-send-msg-overlay {
            width: 100%;
            justify-content: center;
        }
        .msg-item-overlay {
            flex-direction: column;
            padding: 1rem;
        }
        .msg-item-overlay .msg-actions {
            opacity: 1;
            align-self: flex-end;
            margin-top: 4px;
        }
        .message-overlay-body {
            padding: 1rem;
        }
        .message-overlay-header {
            padding: 0.6rem 1rem;
        }
        .message-overlay-header-left {
            gap: 0.5rem;
        }
        .btn-back-messages {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
        .message-overlay-title {
            font-size: 0.8rem;
        }
        .msg-item-overlay .msg-status-badge {
            font-size: 0.55rem;
            padding: 2px 10px;
        }
        .msg-toast {
            bottom: 20px;
            right: 20px;
            left: 20px;
            max-width: none;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h2 mb-1 fw-bold" style="color: var(--text-primary); font-size: 1.3rem;">
                <i class="fas fa-coins" style="color: #534AB7; margin-right: 10px;"></i>Finance Dashboard
            </h1>
            <p class="mb-0" style="color: var(--text-muted); font-size: 0.8rem;">
                @if($selectedChurch)
                    Viewing <strong>{{ $selectedChurch->name }}</strong> financial details
                @else
                    Select a church to view its financial details
                @endif
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="finance-stats-grid">
        <div class="finance-stat-card">
            <div class="stat-icon income">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Income</div>
                <div class="stat-value positive">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
                <div class="stat-sub">All churches</div>
            </div>
        </div>
        <div class="finance-stat-card">
            <div class="stat-icon expense">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Expenses</div>
                <div class="stat-value negative">₱{{ number_format($totalExpenses ?? 0, 2) }}</div>
                <div class="stat-sub">All churches</div>
            </div>
        </div>
        <div class="finance-stat-card">
            <div class="stat-icon balance">
                <i class="fas fa-scale-balanced"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Overall Balance</div>
                <div class="stat-value {{ ($totalIncome ?? 0) - ($totalExpenses ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    ₱{{ number_format(abs(($totalIncome ?? 0) - ($totalExpenses ?? 0)), 2) }}
                </div>
                <div class="stat-sub">{{ ($totalIncome ?? 0) - ($totalExpenses ?? 0) >= 0 ? 'Surplus' : 'Deficit' }}</div>
            </div>
        </div>
        <div class="finance-stat-card">
            <div class="stat-icon churches">
                <i class="fas fa-church"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Churches</div>
                <div class="stat-value">{{ $churches->count() ?? 0 }}</div>
                <div class="stat-sub">Connected churches</div>
            </div>
        </div>
    </div>

    <!-- Church Selector with Message Icon -->
    <div class="church-selector">
        <label for="churchSelect">
            <i class="fas fa-church"></i> Select Church:
        </label>
        <select id="churchSelect" onchange="window.location.href='{{ route('finance.index') }}?church=' + this.value">
            <option value="">-- Choose a Church --</option>
            @foreach($churches as $church)
                <option value="{{ $church->id }}" {{ ($selectedChurchId ?? '') == $church->id ? 'selected' : '' }}>
                    {{ $church->name }}
                </option>
            @endforeach
        </select>
        
        @if($selectedChurch)
            <div class="selected-church-info">
                <i class="fas fa-building"></i> Currently viewing: <strong>{{ $selectedChurch->name }}</strong>
            </div>
        @endif

        <!-- Message Button - Right Side -->
        <button class="msg-header-btn" onclick="openMessages()" title="Messages">
            <i class="fas fa-envelope"></i> Messages
            @php
                $unreadCount = $unreadMessages ?? 0;
            @endphp
            @if($unreadCount > 0)
                <span class="msg-badge has-messages">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
            @else
                <span class="msg-badge" style="display: none;">0</span>
            @endif
        </button>
    </div>

    @if($selectedChurch)
        <!-- Church Detail Card -->
        <div class="church-detail-card">
            <div class="church-detail-header">
                <div class="church-name-large">
                    <i class="fas fa-church"></i> {{ $selectedChurch->name }}
                </div>
                <span style="font-size: 0.65rem; color: var(--text-muted); background: var(--bg-tertiary); padding: 3px 10px; border-radius: 20px; border: 0.5px solid var(--border-color);">
                    <i class="fas fa-calendar-alt"></i> {{ now()->format('F d, Y') }}
                </span>
            </div>
            
            <div class="church-detail-grid">
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-arrow-down" style="color: #0F6E56;"></i> Total Income</div>
                    <div class="value income">₱{{ number_format($incomeTypes->sum('total') ?? 0, 2) }}</div>
                </div>
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-arrow-up" style="color: #A32D2D;"></i> Total Expenses</div>
                    <div class="value expense">₱{{ number_format($expenseTypes->sum('total') ?? 0, 2) }}</div>
                </div>
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-scale-balanced" style="color: #534AB7;"></i> Balance</div>
                    <div class="value balance" style="color: {{ (($incomeTypes->sum('total') ?? 0) - ($expenseTypes->sum('total') ?? 0)) >= 0 ? '#0F6E56' : '#A32D2D' }}">
                        ₱{{ number_format(abs(($incomeTypes->sum('total') ?? 0) - ($expenseTypes->sum('total') ?? 0)), 2) }}
                        <span style="font-size: 0.65rem; font-weight: 600; display: block; color: var(--text-muted);">
                            {{ (($incomeTypes->sum('total') ?? 0) - ($expenseTypes->sum('total') ?? 0)) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 0.8rem; padding-top: 0.8rem; border-top: 0.5px solid var(--border-color);">
                <div>
                    <div style="font-size: 0.6rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem;">
                        <i class="fas fa-tags" style="color: #0F6E56;"></i> Income Categories
                    </div>
                    <div class="category-tags">
                        @forelse($incomeTypes as $type)
                            <span class="category-tag income-tag">
                                {{ $type->category ?? 'Uncategorized' }}: ₱{{ number_format($type->total, 2) }}
                            </span>
                        @empty
                            <span style="font-size: 0.7rem; color: var(--text-muted);">No income categories</span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.6rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; margin-bottom: 0.3rem;">
                        <i class="fas fa-tags" style="color: #A32D2D;"></i> Expense Categories
                    </div>
                    <div class="category-tags">
                        @forelse($expenseTypes as $type)
                            <span class="category-tag expense-tag">
                                {{ $type->category ?? 'Uncategorized' }}: ₱{{ number_format($type->total, 2) }}
                            </span>
                        @empty
                            <span style="font-size: 0.7rem; color: var(--text-muted);">No expense categories</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Chart -->
        <div class="chart-container">
            <div class="chart-header">
                <h6>
                    <i class="fas fa-chart-line"></i> Monthly Income vs Expenses
                </h6>
                <span style="font-size: 0.65rem; color: var(--text-muted);">Last 6 months</span>
            </div>
            <div class="chart-legend">
                <span class="leg-item">
                    <span class="leg-dot" style="background: #0F6E56;"></span> Income
                </span>
                <span class="leg-item">
                    <span class="leg-dot" style="background: #A32D2D; border: 1px dashed #A32D2D; background: none; width: 18px; height: 2px; border-radius: 0;"></span> Expenses
                </span>
            </div>
            <div class="chart-box">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    @else
        <!-- All Churches Overview -->
        <div style="margin-bottom: 1rem;">
            <p style="color: var(--text-muted); font-size: 0.8rem;">
                <i class="fas fa-info-circle"></i> Select a church above to view its detailed financial information.
            </p>
        </div>
        
        <div class="all-churches-grid">
            @foreach($churchBalances as $data)
            <div class="church-mini-card">
                <div class="status-dot {{ $data['status'] }}"></div>
                <div class="church-name">
                    <i class="fas fa-church"></i> {{ $data['church']->name }}
                </div>
                <div class="mini-balance {{ $data['status'] == 'surplus' ? 'positive' : 'negative' }}">
                    ₱{{ number_format(abs($data['balance']), 2) }}
                    {{ $data['balance'] >= 0 ? '↑' : '↓' }}
                </div>
                <div class="mini-details">
                    <span><i class="fas fa-arrow-down" style="color: #0F6E56;"></i> ₱{{ number_format($data['income'], 2) }}</span>
                    <span><i class="fas fa-arrow-up" style="color: #A32D2D;"></i> ₱{{ number_format($data['expense'], 2) }}</span>
                </div>
                <a href="{{ route('finance.index') }}?church={{ $data['church']->id }}" class="btn-view-church">
                    <i class="fas fa-eye"></i> View Details
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>

<!-- ============================================ -->
<!-- PROFESSIONAL MESSAGING OVERLAY -->
<!-- ============================================ -->
<div class="message-overlay" id="messageOverlay">
    <div class="message-overlay-header">
        <div class="message-overlay-header-left">
            <button class="btn-back-messages" onclick="closeMessages()">
                <i class="fas fa-arrow-left"></i> Back
            </button>
            <div class="message-overlay-title">
                <i class="fas fa-envelope"></i> Messages
                <span class="msg-count-badge" id="msgCountBadge">
                    @php
                        $unreadCount = $unreadMessages ?? 0;
                    @endphp
                    {{ $unreadCount }} unread
                </span>
            </div>
        </div>
        <button class="message-overlay-close" onclick="closeMessages()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="message-overlay-body">
        <!-- Compose Message -->
        <div class="msg-compose-overlay">
            <form id="messageFormOverlay">
                @csrf
                <input type="hidden" name="sender_church_id" value="{{ auth()->user()->church_id ?? '' }}">
                <div class="compose-row">
                    <select name="receiver_church_id" id="receiverChurchOverlay" required>
                        <option value="">Select recipient church...</option>
                        @foreach($churches as $church)
                            @if($church->id != ($selectedChurch->id ?? ''))
                                <option value="{{ $church->id }}">{{ $church->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <textarea name="message" id="messageInputOverlay" placeholder="Type your message here..." rows="2" required></textarea>
                    <button type="submit" class="btn-send-msg-overlay" id="sendMessageBtnOverlay">
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Messages List -->
        <div class="msg-list-overlay" id="messageListOverlay">
            @php
                $messages = [];
                if ($selectedChurch) {
                    $messages = \App\Models\Message::where('receiver_church_id', $selectedChurch->id)
                        ->orWhere('church_id', $selectedChurch->id)
                        ->orderBy('created_at', 'desc')
                        ->limit(50)
                        ->get();
                }
            @endphp

            @forelse($messages as $msg)
                <div class="msg-item-overlay" data-msg-id="{{ $msg->id }}">
                    <div class="msg-content">
                        <div class="msg-sender">
                            <i class="fas fa-user-circle"></i>
                            {{ $msg->church->name ?? 'Unknown Church' }}
                            @if($msg->church_id == ($selectedChurch->id ?? ''))
                                <span class="sender-badge">You</span>
                            @endif
                            @if(!$msg->is_read && $msg->receiver_church_id == ($selectedChurch->id ?? ''))
                                <span class="msg-unread-dot"></span>
                            @endif
                        </div>
                        <div class="msg-text">{{ $msg->message }}</div>
                        <div class="msg-time">
                            <i class="far fa-clock"></i> {{ $msg->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="msg-status-badge {{ $msg->is_read ? 'read' : 'unread' }}">
                        {{ $msg->is_read ? '✓ Read' : '● New' }}
                    </div>
                    <div class="msg-actions">
                        @if(!$msg->is_read && $msg->receiver_church_id == ($selectedChurch->id ?? ''))
                            <button onclick="markAsReadOverlay({{ $msg->id }})" class="btn-mark-read" title="Mark as read">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        @endif
                        @if($msg->church_id == ($selectedChurch->id ?? ''))
                            <button onclick="deleteMessageOverlay({{ $msg->id }})" class="btn-delete-msg" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-messages-overlay">
                    <i class="fas fa-inbox"></i>
                    <h5>No Messages Yet</h5>
                    <p>Start a conversation with another church!</p>
                    <div class="empty-cta">
                        <i class="fas fa-plus-circle"></i> Compose your first message
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Message Toast -->
<div class="msg-toast" id="msgToast">
    <i class="fas fa-check-circle"></i>
    <span id="msgToastText">Message sent successfully!</span>
    <button class="toast-close" onclick="this.closest('.msg-toast').classList.remove('show')">
        <i class="fas fa-times"></i>
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart code
        const canvas = document.getElementById('financeChart');
        if (canvas) {
            let monthlyData = @json($monthlyData ?? []);
            let months = monthlyData.map(item => item.month);
            let incomeData = monthlyData.map(item => item.income);
            let expenseData = monthlyData.map(item => item.expense);

            if (!Array.isArray(months) || months.length === 0) {
                months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                incomeData = [0, 0, 0, 0, 0, 0];
                expenseData = [0, 0, 0, 0, 0, 0];
            }

            while (incomeData.length < months.length) incomeData.push(0);
            while (expenseData.length < months.length) expenseData.push(0);

            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.06)';
            const tickColor = isDark ? 'rgba(255,255,255,0.4)' : '#888';
            const ttBg = isDark ? '#2a2a2a' : '#ffffff';
            const ttTitle = isDark ? '#e0e0e0' : '#1e293b';
            const ttBody = isDark ? '#aaaaaa' : '#475569';
            const ttBorder = isDark ? 'rgba(255,255,255,0.1)' : '#e2e8f0';
            const ptBorder = isDark ? '#1e1e1e' : '#ffffff';

            new Chart(canvas, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Income',
                            data: incomeData,
                            borderColor: '#0F6E56',
                            backgroundColor: 'rgba(15, 110, 86, 0.07)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#0F6E56',
                            pointBorderColor: ptBorder,
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#0F6E56',
                            pointHoverBorderColor: ptBorder,
                            pointHoverBorderWidth: 2
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: '#A32D2D',
                            backgroundColor: 'rgba(163, 45, 45, 0.05)',
                            borderWidth: 2,
                            borderDash: [5, 3],
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#A32D2D',
                            pointBorderColor: ptBorder,
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#A32D2D',
                            pointHoverBorderColor: ptBorder,
                            pointHoverBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: ttBg,
                            titleColor: ttTitle,
                            bodyColor: ttBody,
                            borderColor: ttBorder,
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.dataset.label + ': ₱' + ctx.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                },
                                font: { size: 10 },
                                color: tickColor
                            },
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 10 },
                                color: tickColor
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }

        // ============================================
        // MESSAGING OVERLAY CONTROLS
        // ============================================
        
        // Open messages overlay
        window.openMessages = function() {
            document.getElementById('messageOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            updateUnreadCount();
        };
        
        // Close messages overlay
        window.closeMessages = function() {
            document.getElementById('messageOverlay').classList.remove('active');
            document.body.style.overflow = '';
        };
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMessages();
            }
        });
        
        // ============================================
        // MESSAGING FUNCTIONALITY
        // ============================================
        const messageForm = document.getElementById('messageFormOverlay');
        const messageInput = document.getElementById('messageInputOverlay');
        const receiverSelect = document.getElementById('receiverChurchOverlay');
        const sendBtn = document.getElementById('sendMessageBtnOverlay');
        const messageList = document.getElementById('messageListOverlay');
        const msgToast = document.getElementById('msgToast');
        const msgToastText = document.getElementById('msgToastText');

        if (messageForm) {
            messageForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const receiverId = receiverSelect.value;
                const message = messageInput.value.trim();
                
                if (!receiverId || !message) {
                    showToast('Please select a church and enter a message.', 'error');
                    return;
                }
                
                sendBtn.disabled = true;
                sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                
                try {
                    const response = await fetch('{{ route("messages.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            receiver_church_id: receiverId,
                            message: message,
                            sender_church_id: {{ auth()->user()->church_id ?? 0 }}
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        // Remove empty message if exists
                        const emptyMsg = messageList.querySelector('.empty-messages-overlay');
                        if (emptyMsg) emptyMsg.remove();
                        
                        // Add message to top of list
                        const messageHtml = `
                            <div class="msg-item-overlay" data-msg-id="${data.message.id}">
                                <div class="msg-content">
                                    <div class="msg-sender">
                                        <i class="fas fa-user-circle"></i>
                                        You
                                        <span class="sender-badge">You</span>
                                        <span class="msg-unread-dot"></span>
                                    </div>
                                    <div class="msg-text">${escapeHtml(message)}</div>
                                    <div class="msg-time">
                                        <i class="far fa-clock"></i> Just now
                                    </div>
                                </div>
                                <div class="msg-status-badge read">✓ Sent</div>
                                <div class="msg-actions">
                                    <button onclick="deleteMessageOverlay(${data.message.id})" class="btn-delete-msg" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        `;
                        messageList.insertAdjacentHTML('afterbegin', messageHtml);
                        
                        // Clear input
                        messageInput.value = '';
                        receiverSelect.value = '';
                        
                        // Update badge count
                        updateUnreadCount();
                        
                        showToast('Message sent successfully!', 'success');
                    } else {
                        showToast(data.message || 'Failed to send message.', 'error');
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                    showToast('Failed to send message. Please try again.', 'error');
                } finally {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send';
                }
            });
        }

        // ============================================
        // HELPER FUNCTIONS
        // ============================================
        
        function showToast(message, type = 'success') {
            const toast = document.getElementById('msgToast');
            const toastText = document.getElementById('msgToastText');
            const icon = toast.querySelector('i');
            
            toast.className = 'msg-toast ' + type;
            toastText.textContent = message;
            
            if (type === 'success') {
                icon.className = 'fas fa-check-circle';
            } else {
                icon.className = 'fas fa-exclamation-circle';
            }
            
            toast.classList.add('show');
            
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function updateUnreadCount() {
            fetch('{{ route("messages.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('msgCountBadge');
                    if (badge) {
                        badge.textContent = data.unread_count + ' unread';
                    }
                    
                    // Update header badge
                    const headerBadge = document.querySelector('.msg-header-btn .msg-badge');
                    if (headerBadge) {
                        if (data.unread_count > 0) {
                            headerBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                            headerBadge.style.display = 'flex';
                            headerBadge.classList.add('has-messages');
                        } else {
                            headerBadge.style.display = 'none';
                            headerBadge.classList.remove('has-messages');
                        }
                    }
                })
                .catch(error => console.error('Error updating unread count:', error));
        }

        window.markAsReadOverlay = function(messageId) {
            fetch('{{ route("messages.mark-read") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message_id: messageId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.msg-item-overlay[data-msg-id="${messageId}"]`);
                    if (item) {
                        const status = item.querySelector('.msg-status-badge');
                        status.className = 'msg-status-badge read';
                        status.textContent = '✓ Read';
                        
                        const dot = item.querySelector('.msg-unread-dot');
                        if (dot) dot.remove();
                        
                        const actions = item.querySelector('.msg-actions');
                        const markBtn = actions.querySelector('.btn-mark-read');
                        if (markBtn) markBtn.remove();
                        
                        updateUnreadCount();
                    }
                    showToast('Message marked as read.', 'success');
                }
            })
            .catch(error => console.error('Error:', error));
        };

        window.deleteMessageOverlay = function(messageId) {
            if (!confirm('Delete this message?')) return;
            
            fetch('{{ route("messages.delete") }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message_id: messageId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(`.msg-item-overlay[data-msg-id="${messageId}"]`);
                    if (item) {
                        item.style.transition = 'all 0.3s ease';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(20px)';
                        setTimeout(() => item.remove(), 300);
                    }
                    updateUnreadCount();
                    showToast('Message deleted.', 'success');
                }
            })
            .catch(error => console.error('Error:', error));
        };
        
        // Update unread count on load
        setTimeout(updateUnreadCount, 500);
    });
</script>
@endsection