@extends('layouts.app')

@section('header', 'Member Profile')

@section('content')
<style>
    /* ============================================
       MODERN PROFILE DESIGN - CLEAN VERSION
    ============================================ */
    
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    
    :root {
        --profile-primary: #4F46E5;
        --profile-primary-light: #818CF8;
        --profile-primary-dark: #4338CA;
        --profile-success: #10B981;
        --profile-warning: #F59E0B;
        --profile-danger: #EF4444;
        --profile-purple: #8B5CF6;
        --profile-pink: #EC4899;
        --gradient-primary: linear-gradient(135deg, #4F46E5, #7C3AED);
        --shadow-profile-lg: 0 20px 60px rgba(0,0,0,0.08);
        --shadow-profile-hover: 0 24px 80px rgba(0,0,0,0.12);
        --shadow-glow: 0 8px 32px rgba(79, 70, 229, 0.3);
    }
    
    /* ============================================
       HERO SECTION
    ============================================ */
    .profile-hero {
        background: var(--gradient-primary);
        border-radius: 20px;
        padding: 1.8rem 2.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-glow);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .profile-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: heroPulse 6s ease-in-out infinite;
    }
    
    .profile-hero::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 40%;
        height: 180%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: heroPulse 8s ease-in-out infinite reverse;
    }
    
    @keyframes heroPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 1; }
    }
    
    .profile-hero .hero-left {
        display: flex;
        align-items: center;
        gap: 1.2rem;
        position: relative;
        z-index: 1;
    }
    
    .profile-hero .hero-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        border: 3px solid rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }
    
    .profile-hero .hero-text h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        margin: 0;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
    }
    
    .profile-hero .hero-text .hero-sub {
        color: rgba(255,255,255,0.8);
        font-size: 0.8rem;
        margin: 2px 0 0 0;
    }
    
    .profile-hero .hero-text .hero-sub i {
        margin-right: 6px;
    }
    
    .profile-hero .hero-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    
    .btn-hero {
        padding: 0.45rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.7rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    
    .btn-hero-white {
        background: white;
        color: #4F46E5;
    }
    
    .btn-hero-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        color: #4F46E5;
        text-decoration: none;
    }
    
    .btn-hero-ghost {
        background: rgba(255,255,255,0.15);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .btn-hero-ghost:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    /* ============================================
       QUICK ACTIONS - HORIZONTAL
    ============================================ */
    .quick-actions-horizontal {
        display: flex;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    
    .quick-action-btn {
        flex: 1;
        min-width: 120px;
        padding: 0.8rem 1rem;
        border-radius: 12px;
        border: 1.5px solid var(--border-color);
        background: var(--card-bg);
        text-align: center;
        text-decoration: none;
        color: var(--text-secondary);
        transition: all 0.3s ease;
        font-size: 0.7rem;
        font-weight: 600;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        cursor: pointer;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-profile-lg);
    }
    
    .quick-action-btn i {
        font-size: 1.3rem;
    }
    
    .quick-action-btn.attendance {
        border-color: rgba(16, 185, 129, 0.3);
        color: #10B981;
    }
    
    .quick-action-btn.attendance:hover {
        border-color: #10B981;
        background: rgba(16, 185, 129, 0.05);
    }
    
    .quick-action-btn.deceased {
        border-color: rgba(239, 68, 68, 0.3);
        color: #EF4444;
    }
    
    .quick-action-btn.deceased:hover {
        border-color: #EF4444;
        background: rgba(239, 68, 68, 0.05);
    }
    
    .quick-action-btn.edit {
        border-color: rgba(139, 92, 246, 0.3);
        color: #8B5CF6;
    }
    
    .quick-action-btn.edit:hover {
        border-color: #8B5CF6;
        background: rgba(139, 92, 246, 0.05);
    }
    
    .quick-action-btn.restore {
        border-color: rgba(16, 185, 129, 0.3);
        color: #10B981;
    }
    
    .quick-action-btn.restore:hover {
        border-color: #10B981;
        background: rgba(16, 185, 129, 0.05);
    }
    
    /* ============================================
       MAIN LAYOUT - LEFT (Name) + RIGHT (Info)
    ============================================ */
    .profile-main-layout {
        display: flex;
        gap: 1.5rem;
    }
    
    .profile-left {
        flex: 0 0 280px;
        min-width: 220px;
    }
    
    .profile-right {
        flex: 1;
        min-width: 0;
    }
    
    /* ============================================
       LEFT CARD - Name & Basic Info
    ============================================ */
    .name-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
        height: 100%;
        text-align: center;
        padding: 2rem 1.5rem;
    }
    
    .name-card:hover {
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .name-card .avatar-large {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.4rem;
        color: white;
        font-weight: 800;
        margin: 0 auto 0.8rem;
        box-shadow: var(--shadow-glow);
    }
    
    .name-card .member-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        font-family: 'Inter', sans-serif;
    }
    
    .name-card .member-id {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin: 4px 0 8px 0;
    }
    
    .name-card .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .name-card .status-badge.active {
        background: rgba(16, 185, 129, 0.12);
        color: #10B981;
    }
    
    .name-card .status-badge.active::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10B981;
        animation: pulse 2s infinite;
    }
    
    .name-card .status-badge.deceased {
        background: rgba(239, 68, 68, 0.12);
        color: #EF4444;
    }
    
    .name-card .gender-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 10px;
    }
    
    .name-card .gender-badge.male {
        background: rgba(59, 130, 246, 0.12);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .name-card .gender-badge.female {
        background: rgba(236, 72, 153, 0.12);
        color: #EC4899;
        border: 1px solid rgba(236, 72, 153, 0.2);
    }
    
    .name-card .gender-badge.unspecified {
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }
    
    .name-card .gender-badge i {
        font-size: 0.75rem;
    }
    
    .name-divider {
        width: 40px;
        height: 3px;
        background: var(--gradient-primary);
        border-radius: 4px;
        margin: 12px auto;
    }
    
    /* ============================================
       RIGHT CARD - Personal Information
    ============================================ */
    .info-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .info-card:hover {
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .info-card .card-header {
        padding: 0.8rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .info-card .card-header h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .info-card .card-header h6 i {
        margin-right: 8px;
        color: #4F46E5;
    }
    
    .info-card .card-header .member-since {
        font-size: 0.5rem;
        font-weight: 600;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        padding: 2px 10px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
    }
    
    .info-card .card-body {
        padding: 1.2rem 1.5rem;
    }
    
    /* Info Items */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 0.6rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .info-item .info-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
        color: white;
    }
    
    .info-item .info-icon.purple { background: var(--gradient-primary); }
    .info-item .info-icon.green { background: linear-gradient(135deg, #10B981, #34D399); }
    .info-item .info-icon.orange { background: linear-gradient(135deg, #F59E0B, #FBBF24); }
    .info-item .info-icon.pink { background: linear-gradient(135deg, #EC4899, #F472B6); }
    .info-item .info-icon.blue { background: linear-gradient(135deg, #3B82F6, #60A5FA); }
    .info-item .info-icon.teal { background: linear-gradient(135deg, #14B8A6, #2DD4BF); }
    .info-item .info-icon.roles { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    
    .info-item .info-content {
        flex: 1;
        min-width: 0;
    }
    
    .info-item .info-label {
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        font-weight: 700;
        margin: 0;
    }
    
    .info-item .info-value {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        word-break: break-word;
    }
    
    /* Role Tags */
    .role-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 16px;
        font-size: 0.6rem;
        font-weight: 500;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        transition: all 0.2s ease;
        margin: 2px 3px 2px 0;
    }
    
    .role-tag i {
        font-size: 0.45rem;
        opacity: 0.6;
    }
    
    .role-tag:hover {
        transform: translateY(-1px);
        border-color: #4F46E5;
        color: #4F46E5;
    }
    
    .role-tag.choir {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }
    
    [data-theme="dark"] .role-tag.choir {
        background: #78350f;
        color: #fde68a;
        border-color: #92400e;
    }
    
    .no-roles {
        color: var(--text-muted);
        font-weight: 400;
        font-size: 0.8rem;
    }
    
    .no-roles a {
        margin-left: 8px;
        font-size: 0.65rem;
        color: #4F46E5;
        text-decoration: none;
    }
    
    .no-roles a:hover {
        text-decoration: underline;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }
    
    /* ============================================
       CUSTOM SWEETALERT STYLES - ENHANCED DELETE
    ============================================ */
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
    
    .swal2-custom-delete .swal2-icon .swal2-x-mark {
        display: none !important;
    }
    
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
    
    [data-theme="dark"] .swal2-custom-delete .swal2-title {
        color: #f1f5f9 !important;
    }
    
    .swal2-custom-delete .swal2-html-container {
        font-size: 0.9rem !important;
        color: #64748b !important;
        margin-bottom: 1.2rem !important;
        font-family: 'Inter', sans-serif !important;
        line-height: 1.6 !important;
    }
    
    [data-theme="dark"] .swal2-custom-delete .swal2-html-container {
        color: #94a3b8 !important;
    }
    
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
    
    .swal2-custom-delete .swal2-actions {
        gap: 0.8rem !important;
        margin-top: 0.5rem !important;
    }
    
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
    
    .swal2-custom-delete .swal2-confirm:active {
        transform: scale(0.97) !important;
    }
    
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
    
    /* ============================================
       RESPONSIVE
    ============================================ */
    @media (max-width: 992px) {
        .profile-main-layout {
            flex-direction: column;
        }
        .profile-left {
            flex: 1;
            min-width: 0;
        }
        .profile-hero {
            flex-direction: column;
            align-items: flex-start;
        }
        .profile-hero .hero-actions {
            width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .profile-hero {
            padding: 1.2rem;
        }
        .profile-hero .hero-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }
        .profile-hero .hero-text h1 {
            font-size: 1.2rem;
        }
        .quick-actions-horizontal {
            flex-direction: column;
        }
        .quick-action-btn {
            flex-direction: row;
            justify-content: center;
            gap: 8px;
            padding: 0.6rem;
            min-width: 0;
        }
        .quick-action-btn i {
            font-size: 1rem;
            margin-bottom: 0;
        }
        .name-card .avatar-large {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
        }
        .name-card .member-name {
            font-size: 1.1rem;
        }
        .info-card .card-body {
            padding: 1rem;
        }
        .info-card .card-header {
            padding: 0.6rem 1rem;
        }
        .swal2-custom-delete {
            padding: 1.5rem 1rem !important;
            margin: 0 0.5rem !important;
        }
        .swal2-custom-delete .swal2-icon {
            width: 60px !important;
            height: 60px !important;
            padding: 15px !important;
        }
        .swal2-custom-delete .swal2-icon .swal2-icon-content {
            font-size: 2rem !important;
        }
        .swal2-custom-delete .swal2-title {
            font-size: 1.2rem !important;
        }
        .swal2-custom-delete .swal2-actions {
            flex-direction: column !important;
            width: 100% !important;
        }
        .swal2-custom-delete .swal2-confirm,
        .swal2-custom-delete .swal2-cancel {
            width: 100% !important;
            justify-content: center !important;
        }
    }
    
    @media (max-width: 480px) {
        .profile-hero .hero-left {
            flex-direction: column;
            text-align: center;
            width: 100%;
        }
        .name-card {
            padding: 1.2rem;
        }
        .name-card .avatar-large {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid px-0">

    <!-- ============================================
         HERO SECTION - Member Profile Title
    ============================================ -->
    <div class="profile-hero">
        <div class="hero-left">
            <div class="hero-avatar">
                <i class="fas fa-user-circle" style="font-size: 2.2rem;"></i>
            </div>
            <div class="hero-text">
                <h1>Member Profile</h1>
                <p class="hero-sub">
                    <i class="fas fa-id-card"></i>
                    ID: #{{ str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                    &nbsp;·&nbsp;
                    <span class="badge-status-modern {{ $member->is_deceased ? 'deceased' : 'active' }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 2px 12px; border-radius: 20px; font-size: 0.6rem; font-weight: 700; text-transform: uppercase;">
                        {{ $member->is_deceased ? 'Deceased' : 'Active' }}
                    </span>
                </p>
            </div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('members.edit', $member->id) }}" class="btn-hero btn-hero-white">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
            <a href="{{ route('members.index') }}" class="btn-hero btn-hero-ghost">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- ============================================
         QUICK ACTIONS - HORIZONTAL
    ============================================ -->
    <div class="quick-actions-horizontal">
        <a href="{{ route('attendance.create', ['member_id' => $member->id]) }}" class="quick-action-btn attendance">
            <i class="fas fa-calendar-check"></i>
            <span>Record Attendance</span>
        </a>

        @if(!$member->is_deceased)
        <a href="#" class="quick-action-btn deceased" onclick="confirmDeceased({{ $member->id }})">
            <i class="fas fa-cross"></i>
            <span>Mark Deceased</span>
        </a>
        @endif

        <a href="{{ route('members.edit', $member->id) }}" class="quick-action-btn edit">
            <i class="fas fa-user-edit"></i>
            <span>Edit Details</span>
        </a>

        @if($member->is_deceased)
        <a href="#" class="quick-action-btn restore" onclick="confirmRestore({{ $member->id }})">
            <i class="fas fa-undo-alt"></i>
            <span>Restore to Active</span>
        </a>
        @endif
    </div>

    <!-- ============================================
         MAIN LAYOUT
    ============================================ -->
    <div class="profile-main-layout">

        <!-- ============================================
             LEFT SIDE - NAME CARD
        ============================================ -->
        <div class="profile-left">
            <div class="name-card">
                <div class="avatar-large">
                    {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
                </div>
                <h2 class="member-name">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</h2>
                <p class="member-id"><i class="fas fa-id-card"></i> ID: #{{ str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT) }}</p>
                
                <div class="name-divider"></div>
                
                <div>
                    <span class="status-badge {{ $member->is_deceased ? 'deceased' : 'active' }}">
                        {{ $member->is_deceased ? 'Deceased' : 'Active' }}
                    </span>
                </div>
                
                <div>
                    @php
                        $genderValue = $member->gender ?? null;
                        if ($genderValue === 'male') {
                            $genderIcon = 'fa-mars';
                            $genderLabel = 'Male';
                            $genderClass = 'male';
                        } elseif ($genderValue === 'female') {
                            $genderIcon = 'fa-venus';
                            $genderLabel = 'Female';
                            $genderClass = 'female';
                        } else {
                            $genderIcon = 'fa-circle';
                            $genderLabel = 'Not Specified';
                            $genderClass = 'unspecified';
                        }
                    @endphp
                    <span class="gender-badge {{ $genderClass }}">
                        <i class="fas {{ $genderIcon }}"></i>
                        {{ $genderLabel }}
                    </span>
                </div>
            </div>
        </div>

        <!-- ============================================
             RIGHT SIDE - PERSONAL INFORMATION
        ============================================ -->
        <div class="profile-right">
            <div class="info-card">
                <div class="card-header">
                    <h6><i class="fas fa-user-circle"></i> Personal Information</h6>
                    <span class="member-since">
                        <i class="fas fa-clock"></i> 
                        {{ \Carbon\Carbon::parse($member->created_at ?? now())->format('M d, Y') }}
                    </span>
                </div>
                <div class="card-body">

                    <!-- Birthday -->
                    <div class="info-item">
                        <div class="info-icon pink"><i class="fas fa-birthday-cake"></i></div>
                        <div class="info-content">
                            <p class="info-label">Birthday</p>
                            <p class="info-value">
                                {{ $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('F d, Y') : 'N/A' }}
                                @if($member->birthday)
                                    <span style="font-size: 0.65rem; font-weight: 400; color: var(--text-muted);">
                                        ({{ \Carbon\Carbon::parse($member->birthday)->age }} years old)
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="info-item">
                        <div class="info-icon green"><i class="fas fa-phone"></i></div>
                        <div class="info-content">
                            <p class="info-label">Phone Number</p>
                            <p class="info-value">{{ $member->phone ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="info-item">
                        <div class="info-icon orange"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <p class="info-label">Email Address</p>
                            <p class="info-value">{{ $member->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="info-item">
                        <div class="info-icon teal"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <p class="info-label">Address</p>
                            <p class="info-value">{{ $member->address ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="info-item">
                        <div class="info-icon roles"><i class="fas fa-tags"></i></div>
                        <div class="info-content">
                            <p class="info-label">Roles & Responsibilities</p>
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
                                                <i class="fas fa-music"></i> Choir
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="no-roles">
                                        No roles assigned
                                        <a href="{{ route('members.edit', $member->id) }}">
                                            <i class="fas fa-plus"></i> Add
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
function confirmDeceased(memberId) {
    Swal.fire({
        title: '⚠️ Mark as Deceased?',
        html: `
            <div style="text-align: left;">
                <p>Are you sure you want to mark this member as <strong>DECEASED</strong>?</p>
                <div class="mb-3">
                    <label class="form-label" style="display: block; text-align: left; margin-bottom: 5px;">Date of Death:</label>
                    <input type="date" id="date_deceased_input" class="swal2-input" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #d1d5db;" max="${new Date().toISOString().split('T')[0]}" required>
                </div>
                <small style="color: #6b7280;">This action cannot be undone.</small>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Mark Deceased',
        cancelButtonText: 'Cancel',
        background: 'var(--card-bg)',
        color: 'var(--text-primary)',
        preConfirm: () => {
            const dateDeceased = document.getElementById('date_deceased_input').value;
            if (!dateDeceased) {
                Swal.showValidationMessage('Please select the date of death');
                return false;
            }
            return { date_deceased: dateDeceased };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const dateDeceased = result.value.date_deceased;
            
            Swal.fire({
                title: 'Processing...',
                html: '<div class="loading-spinner"></div><p class="mt-2">Please wait</p>',
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
                        title: '✅ Marked as Deceased',
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
                    title: '❌ Error!',
                    text: error.message,
                    confirmButtonColor: '#ef4444',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            });
        }
    });
}

function confirmRestore(memberId) {
    Swal.fire({
        title: '🔄 Restore Member?',
        text: 'Are you sure you want to restore this member to ACTIVE status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Restore!',
        cancelButtonText: 'Cancel',
        background: 'var(--card-bg)',
        color: 'var(--text-primary)'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Restoring...',
                html: '<div class="loading-spinner"></div><p class="mt-2">Please wait</p>',
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
                        title: '✅ Restored!',
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
                    title: '❌ Error!',
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
// ENHANCED DELETE CONFIRMATION - BEAUTIFUL DESIGN
// ============================================
function confirmDelete(memberId, memberName) {
    const memberDisplay = memberName || 'this member';
    
    Swal.fire({
        title: 'Delete Member',
        html: `
            <div style="text-align: left;">
                <p style="margin-bottom: 0.5rem;">
                    Are you sure you want to permanently delete 
                    <span class="member-name-highlight" style="color: #EF4444; font-weight: 700; background: #fef2f2; padding: 2px 12px; border-radius: 6px; display: inline-block;">
                        ${memberDisplay}
                    </span>
                    ?
                </p>
                <div class="warning-box" style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 10px; padding: 0.8rem 1rem; margin-top: 0.8rem; font-size: 0.8rem; color: #92400e; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 1rem; color: #f59e0b;"></i>
                    <span>This action cannot be undone. All data associated with this member will be permanently removed.</span>
                </div>
            </div>
        `,
        icon: 'error',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Delete Member',
        cancelButtonText: '<i class="fas fa-times"></i> Cancel',
        customClass: {
            popup: 'swal2-custom-delete',
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel',
            icon: 'swal2-icon',
            title: 'swal2-title',
            htmlContainer: 'swal2-html-container',
            actions: 'swal2-actions'
        },
        backdrop: `
            rgba(0,0,0,0.5)
            left top
            no-repeat
        `,
        showClass: {
            popup: 'animate__animated animate__fadeInUp animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutDown animate__faster'
        },
        timerProgressBar: true,
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show processing state
            Swal.fire({
                title: 'Deleting Member...',
                html: `
                    <div style="text-align: center; padding: 1rem 0;">
                        <div style="width: 48px; height: 48px; border: 4px solid #e5e7eb; border-top-color: #EF4444; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 1rem;"></div>
                        <p style="color: #64748b; font-size: 0.9rem;">Please wait while we remove the member</p>
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
            
            // Submit the form
            document.getElementById(`delete-form-${memberId}`).submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.profile-card-modern, .name-card, .info-card');
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
</script>
@endsection