@extends('layouts.app')

@section('header', 'Attendance Records')

@section('content')

{{-- ============================================= --}}
{{-- STYLES SECTION --}}
{{-- ============================================= --}}
<style>
    /* ============================================
       MODERN DESIGN - MATCHING FINANCIAL MANAGEMENT
    ============================================ */
    
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    
    :root {
        --gradient-green: linear-gradient(135deg, #10B981, #34D399);
        --gradient-red: linear-gradient(135deg, #EF4444, #F87171);
        --gradient-blue: linear-gradient(135deg, #4F46E5, #7C3AED);
        --gradient-purple: linear-gradient(135deg, #8B5CF6, #A78BFA);
        --gradient-orange: linear-gradient(135deg, #F59E0B, #FBBF24);
        --gradient-pink: linear-gradient(135deg, #EC4899, #F472B6);
        --shadow-glow-green: 0 8px 32px rgba(16, 185, 129, 0.3);
        --shadow-glow-red: 0 8px 32px rgba(239, 68, 68, 0.3);
        --shadow-glow-blue: 0 8px 32px rgba(79, 70, 229, 0.3);
        --shadow-glow-purple: 0 8px 32px rgba(139, 92, 246, 0.3);
        --shadow-card-lg: 0 20px 60px rgba(0,0,0,0.08);
        --shadow-card-hover: 0 24px 80px rgba(0,0,0,0.12);
    }
    
    /* Hero Section - Gradient */
    .records-hero {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(79, 70, 229, 0.3);
    }
    
    .records-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 80%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
        animation: pulseGlow 8s ease-in-out infinite;
    }
    
    .records-hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        pointer-events: none;
        animation: pulseGlow 10s ease-in-out infinite reverse;
    }
    
    @keyframes pulseGlow {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }
    
    .records-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .records-hero .hero-left {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    
    .records-hero h1 {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin: 0;
        letter-spacing: -0.5px;
        font-family: 'Inter', sans-serif;
    }
    
    .records-hero h1 i {
        margin-right: 12px;
        opacity: 0.8;
    }
    
    .records-hero p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 0.9rem;
        font-weight: 400;
    }
    
    .records-hero .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(20px);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .records-hero .hero-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    
    .btn-hero-primary {
        background: white;
        color: #4F46E5;
        border: none;
        padding: 0.6rem 1.8rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
    }
    
    .btn-hero-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        color: #4F46E5;
        text-decoration: none;
    }
    
    .btn-hero-secondary {
        background: rgba(255,255,255,0.15);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 0.6rem 1.8rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
        backdrop-filter: blur(20px);
    }
    
    .btn-hero-secondary:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    /* Stats Grid - Premium */
    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    
    .stat-card-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-card-lg);
    }
    
    .stat-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
    }
    
    .stat-card-premium:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .stat-card-premium .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    
    .stat-card-premium .stat-label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        font-weight: 700;
        margin: 0;
    }
    
    .stat-card-premium .stat-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-card-premium .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    
    .stat-card-premium .stat-change {
        font-size: 0.65rem;
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
        padding: 2px 8px;
        border-radius: 20px;
        background: var(--bg-tertiary);
    }
    
    .stat-card-premium .stat-change.positive { color: #10B981; }
    .stat-card-premium .stat-change.negative { color: #EF4444; }
    
    /* Gradient variants */
    .stat-card-premium.blue::before { background: var(--gradient-blue); }
    .stat-card-premium.green::before { background: var(--gradient-green); }
    .stat-card-premium.red::before { background: var(--gradient-red); }
    
    .stat-card-premium.blue .stat-icon-wrap { background: var(--gradient-blue); box-shadow: var(--shadow-glow-blue); }
    .stat-card-premium.green .stat-icon-wrap { background: var(--gradient-green); box-shadow: var(--shadow-glow-green); }
    .stat-card-premium.red .stat-icon-wrap { background: var(--gradient-red); box-shadow: var(--shadow-glow-red); }
    
    /* Date Selector - Premium */
    .date-selector-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.8rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card-lg);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .date-selector-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-blue);
    }
    
    .date-selector-premium:hover {
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .selector-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-bottom: 0.8rem;
    }
    
    .selector-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Inter', sans-serif;
    }
    
    .selector-title i {
        color: #4F46E5;
    }
    
    .selector-title small {
        font-weight: 400;
        color: var(--text-muted);
        font-size: 0.65rem;
    }
    
    .selector-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .selector-item label {
        display: block;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
        font-family: 'Inter', sans-serif;
    }
    
    .selector-item input {
        width: 200px;
        padding: 0.5rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .selector-item input:focus {
        outline: none;
        border-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .quick-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-quick-premium {
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.65rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-secondary);
        font-family: 'Inter', sans-serif;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-quick-premium:hover {
        background: var(--gradient-green);
        border-color: #10B981;
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-glow-green);
    }
    
    .total-badge-premium {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 6px 16px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid var(--border-color);
        font-family: 'Inter', sans-serif;
    }
    
    .total-badge-premium i {
        color: #10B981;
    }
    
    /* Table Container - Premium */
    .table-container-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card-lg);
        transition: all 0.3s ease;
    }
    
    .table-container-premium:hover {
        box-shadow: var(--shadow-card-hover);
    }
    
    .table-header-premium {
        padding: 0.8rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .table-header-premium h6 {
        color: var(--text-primary);
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Inter', sans-serif;
    }
    
    .table-header-premium h6 i {
        margin-right: 8px;
        color: #10B981;
    }
    
    .badge-count-premium {
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .table-footer-premium {
        padding: 0.6rem 1.5rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        text-align: center;
        font-size: 0.65rem;
        color: var(--text-muted);
    }
    
    .table-footer-premium strong.text-success {
        color: #10B981;
    }
    
    .table-footer-premium strong.text-danger {
        color: #EF4444;
    }
    
    /* Table - Premium */
    .table-premium {
        width: 100%;
        border-collapse: collapse;
        background: var(--card-bg);
    }
    
    .table-premium thead th {
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-muted) !important;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 0.7rem 1.2rem;
        white-space: nowrap;
        font-family: 'Inter', sans-serif;
    }
    
    .table-premium tbody td {
        padding: 0.7rem 1.2rem;
        vertical-align: middle;
        color: var(--text-primary) !important;
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        font-size: 0.8rem;
    }
    
    .table-premium tbody tr {
        transition: all 0.15s ease;
    }
    
    .table-premium tbody tr:hover {
        background: var(--bg-tertiary) !important;
    }
    
    .table-premium tbody tr:hover td {
        background: var(--bg-tertiary) !important;
    }
    
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Member Info */
    .member-info-premium {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .member-avatar-premium {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: var(--gradient-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.7rem;
        flex-shrink: 0;
        font-weight: 700;
        box-shadow: var(--shadow-glow-blue);
    }
    
    .member-avatar-premium.choir {
        background: var(--gradient-orange);
        box-shadow: var(--shadow-glow-orange);
    }
    
    .member-name-premium {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.85rem;
        margin-bottom: 1px;
        font-family: 'Inter', sans-serif;
    }
    
    .member-role-premium {
        font-size: 0.6rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .member-role-premium i {
        color: #F59E0B;
        font-size: 0.55rem;
    }
    
    /* Status Badge - Premium */
    .status-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        font-family: 'Inter', sans-serif;
    }
    
    .status-present-premium {
        background: rgba(16, 185, 129, 0.12);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.15);
    }
    
    .status-present-premium i {
        color: #10B981;
    }
    
    .status-absent-premium {
        background: rgba(239, 68, 68, 0.12);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.15);
    }
    
    .status-absent-premium i {
        color: #EF4444;
    }
    
    /* Empty State */
    .empty-state-premium {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--text-muted);
    }
    
    .empty-state-premium i {
        font-size: 3rem;
        margin-bottom: 0.8rem;
        opacity: 0.3;
        color: #10B981;
    }
    
    .empty-state-premium p {
        font-size: 0.85rem;
        margin: 0;
    }
    
    /* Custom Alert */
    .custom-alert-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(3px);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.25s ease;
    }
    
    .custom-alert-overlay.active {
        display: flex;
    }
    
    .custom-alert {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 2rem;
        max-width: 420px;
        width: 90%;
        box-shadow: var(--shadow-card-hover);
        animation: slideUp 0.3s ease;
        text-align: center;
        border: 1px solid var(--border-color);
    }
    
    .custom-alert-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.8rem;
    }
    
    .custom-alert-icon i {
        font-size: 2rem;
        color: #EF4444;
    }
    
    .custom-alert h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.3rem;
        font-family: 'Inter', sans-serif;
    }
    
    .custom-alert p {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    
    .custom-alert .alert-date {
        background: var(--bg-tertiary);
        padding: 0.4rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.2rem;
        display: inline-block;
        border: 1px solid var(--border-color);
    }
    
    .custom-alert .alert-date i {
        color: #F59E0B;
        margin-right: 6px;
    }
    
    .btn-alert-close {
        padding: 0.6rem 2rem;
        background: var(--gradient-blue);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        box-shadow: var(--shadow-glow-blue);
    }
    
    .btn-alert-close:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(79, 70, 229, 0.4);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .records-hero .hero-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .records-hero .hero-actions {
            width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .records-hero {
            padding: 1.5rem;
            border-radius: 16px;
        }
        
        .records-hero h1 {
            font-size: 1.3rem;
        }
        
        .stats-grid-premium {
            grid-template-columns: 1fr;
            gap: 0.8rem;
        }
        
        .stat-card-premium {
            padding: 1rem;
        }
        
        .stat-card-premium .stat-value {
            font-size: 1.3rem;
        }
        
        .stat-card-premium .stat-icon-wrap {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }
        
        .date-selector-premium {
            padding: 1rem 1.2rem;
        }
        
        .selector-group {
            flex-direction: column;
            align-items: stretch !important;
        }
        
        .selector-item input {
            width: 100%;
        }
        
        .quick-actions {
            width: 100%;
            flex-direction: column;
        }
        
        .btn-quick-premium {
            width: 100%;
            justify-content: center;
        }
        
        .btn-hero-primary,
        .btn-hero-secondary {
            width: 100%;
            justify-content: center;
        }
        
        .table-header-premium {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.4rem 0.6rem;
            font-size: 0.65rem;
        }
        
        .member-avatar-premium {
            width: 28px;
            height: 28px;
            font-size: 0.6rem;
        }
        
        .member-name-premium {
            font-size: 0.75rem;
        }
        
        .status-badge-premium {
            font-size: 0.55rem;
            padding: 2px 8px;
        }
        
        .total-badge-premium {
            font-size: 0.65rem;
            padding: 4px 12px;
        }
    }
    
    @media (max-width: 480px) {
        .records-hero .hero-actions {
            flex-direction: column;
        }
    }
</style>

{{-- ============================================= --}}
{{-- MAIN CONTENT --}}
{{-- ============================================= --}}
<div class="container-fluid px-0">

    {{-- ============================================ --}}
    {{-- HERO SECTION - GRADIENT --}}
    {{-- ============================================ --}}
    <div class="records-hero">
        <div class="hero-content">
            <div class="hero-left">
                <h1><i class="fas fa-calendar-check"></i> Attendance Records</h1>
                <p>View and analyze church attendance data</p>
                <div class="hero-badge">
                    <i class="fas fa-circle" style="color: #34D399; font-size: 0.5rem;"></i>
                    {{ \Carbon\Carbon::parse($selectedDate ?? date('Y-m-d'))->format('F d, Y') }}
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('sunday-attendance.index', ['date' => $selectedDate ?? date('Y-m-d')]) }}" class="btn-hero-primary">
                    <i class="fas fa-pen-alt"></i> Input Attendance
                </a>
                <span class="btn-hero-secondary">
                    <i class="fas fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($selectedDate ?? date('Y-m-d'))->format('l') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- STATS CARDS - PREMIUM --}}
    {{-- ============================================ --}}
    <div class="stats-grid-premium">
        <div class="stat-card-premium blue">
            <div class="stat-top">
                <span class="stat-label">Total Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value">{{ number_format($totalMembers ?? 0) }}</div>
            <div class="stat-change positive"><i class="fas fa-users"></i> Registered</div>
        </div>
        
        <div class="stat-card-premium green">
            <div class="stat-top">
                <span class="stat-label">Present Today</span>
                <div class="stat-icon-wrap"><i class="fas fa-check-circle"></i></div>
            </div>
            <div class="stat-value" style="color: #10B981;">{{ number_format($presentCount ?? 0) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> Attended</div>
        </div>
        
        <div class="stat-card-premium red">
            <div class="stat-top">
                <span class="stat-label">Absent Today</span>
                <div class="stat-icon-wrap"><i class="fas fa-times-circle"></i></div>
            </div>
            <div class="stat-value" style="color: #EF4444;">{{ number_format($absentCount ?? 0) }}</div>
            <div class="stat-change negative"><i class="fas fa-arrow-down"></i> Not attended</div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- DATE SELECTOR - PREMIUM --}}
    {{-- ============================================ --}}
    <div class="date-selector-premium">
        <div class="selector-header">
            <div class="selector-title">
                <i class="fas fa-calendar-week"></i>
                <span>Select Date</span>
                <small><i class="fas fa-info-circle"></i> Only Sundays are selectable</small>
            </div>
            <div class="total-badge-premium">
                <i class="fas fa-church"></i>
                {{ \Carbon\Carbon::parse($selectedDate ?? date('Y-m-d'))->format('F d, Y') }}
            </div>
        </div>
        <div class="selector-group">
            <div class="selector-item">
                <label><i class="fas fa-calendar-day me-1"></i> DATE</label>
                <input type="date" id="dateSelector" value="{{ $selectedDate ?? date('Y-m-d') }}"
                       min="{{ \Carbon\Carbon::now()->subYears(5)->format('Y-m-d') }}"
                       max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
            <div class="quick-actions">
                <button class="btn-quick-premium" onclick="selectToday()">
                    <i class="fas fa-calendar-day"></i> Today
                </button>
                <button class="btn-quick-premium" onclick="selectLastSunday()">
                    <i class="fas fa-calendar-week"></i> Last Sunday
                </button>
                <button class="btn-quick-premium" onclick="selectPrevSunday()">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- ATTENDANCE DETAILS TABLE - PREMIUM --}}
    {{-- ============================================ --}}
    <div class="table-container-premium">
        <div class="table-header-premium">
            <h6>
                <i class="fas fa-users"></i>
                Attendance Details
                <span class="badge-count-premium">{{ $presentCount ?? 0 }} Present / {{ $totalMembers ?? 0 }} Members</span>
            </h6>
            <span style="font-size: 0.65rem; color: var(--text-muted);">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::parse($selectedDate ?? date('Y-m-d'))->format('l, F d, Y') }}
            </span>
        </div>
        <div class="table-responsive">
            <table class="table-premium table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Member Information</th>
                        <th>Age</th>
                        <th style="width: 140px;">Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($members ?? []) as $index => $member)
                    @php
                        $attendance = ($attendances ?? collect())->get($member->id);
                        $status = $attendance ? $attendance->status : 'Absent';
                        $age = $member->birthday ? \Carbon\Carbon::parse($member->birthday)->age : 'N/A';
                        $notes = $attendance ? $attendance->notes : null;
                        $isChoir = $member->is_choir ?? false;
                    @endphp
                    <tr>
                        <td class="text-muted text-center">{{ $index + 1 }}</td>
                        <td>
                            <div class="member-info-premium">
                                <div class="member-avatar-premium {{ $isChoir ? 'choir' : '' }}">
                                    {{ strtoupper(substr($member->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? '', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="member-name-premium">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                                    @if($isChoir)
                                        <div class="member-role-premium"><i class="fas fa-music"></i> Choir Member</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $age }}</td>
                        <td>
                            @if($status == 'Present')
                                <span class="status-badge-premium status-present-premium">
                                    <i class="fas fa-check-circle"></i> Present
                                </span>
                            @else
                                <span class="status-badge-premium status-absent-premium">
                                    <i class="fas fa-times-circle"></i> Absent
                                </span>
                            @endif
                        </td>
                        <td style="color: var(--text-muted);">{{ $notes ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state-premium">
                                <i class="fas fa-users"></i>
                                <p>No members found. Please add members first.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(($members ?? collect())->count() > 0)
        <div class="table-footer-premium">
            <i class="fas fa-users me-1"></i>
            Total members: <strong>{{ $members->count() }}</strong> &nbsp;|&nbsp;
            <i class="fas fa-check-circle me-1" style="color: #10B981;"></i>
            Present: <strong class="text-success">{{ $presentCount ?? 0 }}</strong> &nbsp;|&nbsp;
            <i class="fas fa-times-circle me-1" style="color: #EF4444;"></i>
            Absent: <strong class="text-danger">{{ $absentCount ?? 0 }}</strong>
        </div>
        @endif
    </div>
</div>

{{-- ============================================ --}}
{{-- CUSTOM ALERT - ONLY SUNDAYS --}}
{{-- ============================================ --}}
<div class="custom-alert-overlay" id="customAlert">
    <div class="custom-alert">
        <div class="custom-alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h3>Only Sundays Allowed</h3>
        <p>Attendance records can only be viewed for Sundays. Please select a Sunday date.</p>
        <div class="alert-date">
            <i class="fas fa-calendar-day"></i>
            <span id="alertSelectedDate">Select a date</span>
        </div>
        <button class="btn-alert-close" onclick="closeCustomAlert()">
            <i class="fas fa-check me-1"></i> OK, I Understand
        </button>
    </div>
</div>

{{-- ============================================= --}}
{{-- SCRIPTS SECTION --}}
{{-- ============================================= --}}
<script>
    // =============================================
    // CUSTOM ALERT FUNCTIONS
    // =============================================
    function showCustomAlert(date) {
        const overlay = document.getElementById('customAlert');
        const dateSpan = document.getElementById('alertSelectedDate');
        
        if (date) {
            const d = new Date(date);
            dateSpan.textContent = d.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        } else {
            dateSpan.textContent = 'Invalid date selected';
        }
        
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeCustomAlert() {
        const overlay = document.getElementById('customAlert');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        
        const dateSelector = document.getElementById('dateSelector');
        const currentDate = "{{ $selectedDate ?? date('Y-m-d') }}";
        if (dateSelector && currentDate) {
            dateSelector.value = currentDate;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('customAlert');
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomAlert();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                closeCustomAlert();
            }
        });
    });
    
    // =============================================
    // DATE SELECTOR - ONLY SUNDAYS
    // =============================================
    const dateSelector = document.getElementById('dateSelector');
    
    function getNearestSunday(date) {
        let d = new Date(date);
        d.setDate(d.getDate() + (7 - d.getDay()) % 7);
        return d;
    }
    
    if (dateSelector) {
        const currentDate = dateSelector.value;
        if (currentDate) {
            const selectedDate = new Date(currentDate);
            if (selectedDate.getDay() !== 0) {
                const nearestSunday = getNearestSunday(selectedDate);
                const dateStr = nearestSunday.toISOString().split('T')[0];
                window.location.href = "{{ route('sunday-attendance.records', ['date' => '']) }}" + dateStr;
            }
        }
        
        dateSelector.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            if (selectedDate.getDay() !== 0) {
                showCustomAlert(this.value);
                const currentDate = "{{ $selectedDate ?? date('Y-m-d') }}";
                this.value = currentDate;
            } else {
                window.location.href = "{{ route('sunday-attendance.records', ['date' => '']) }}" + this.value;
            }
        });
    }
    
    // =============================================
    // QUICK SELECT FUNCTIONS
    // =============================================
    function selectToday() {
        let today = new Date();
        if (today.getDay() !== 0) {
            today.setDate(today.getDate() + (7 - today.getDay()) % 7);
        }
        let dateStr = today.toISOString().split('T')[0];
        window.location.href = "{{ route('sunday-attendance.records', ['date' => '']) }}" + dateStr;
    }
    
    function selectLastSunday() {
        let today = new Date();
        let lastSunday = new Date(today);
        lastSunday.setDate(today.getDate() - today.getDay());
        let dateStr = lastSunday.toISOString().split('T')[0];
        window.location.href = "{{ route('sunday-attendance.records', ['date' => '']) }}" + dateStr;
    }
    
    function selectPrevSunday() {
        let currentDate = document.getElementById('dateSelector').value;
        let date = new Date(currentDate);
        date.setDate(date.getDate() - 7);
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        window.location.href = "{{ route('sunday-attendance.records', ['date' => '']) }}" + year + '-' + month + '-' + day;
    }
</script>
@endsection