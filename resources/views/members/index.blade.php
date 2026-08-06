@extends('layouts.app')

@section('header', 'Member Management')

@section('content')

{{-- ============================================= --}}
{{-- STYLES SECTION --}}
{{-- ============================================= --}}
<style>
    /* ============================================
       MODERN DESIGN - MATCHING PROFILE STYLE
    ============================================ */
    
    /* Import Google Fonts */
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
    
    /* Hero Section - Same as Profile */
    .member-hero {
        background: var(--gradient-primary);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-glow);
    }
    
    .member-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: heroPulse 6s ease-in-out infinite;
    }
    
    .member-hero::after {
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
    
    .member-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .member-hero .hero-left {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .member-hero h1 {
        font-size: 1.8rem;
        font-weight: 800;
        color: white;
        margin: 0;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
    }
    
    .member-hero h1 i {
        margin-right: 12px;
        opacity: 0.8;
    }
    
    .member-hero .hero-sub {
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
        margin: 0;
    }
    
    .member-hero .hero-actions {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    
    .btn-hero {
        padding: 0.5rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
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
    
    /* Stats Grid - Premium Cards (Same as Profile) */
    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
        box-shadow: var(--shadow-profile-lg);
    }
    
    .stat-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-primary);
    }
    
    .stat-card-premium:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-profile-hover);
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
    .stat-card-premium.green::before { background: linear-gradient(135deg, #10B981, #34D399); }
    .stat-card-premium.blue::before { background: var(--gradient-primary); }
    .stat-card-premium.purple::before { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    .stat-card-premium.orange::before { background: linear-gradient(135deg, #F59E0B, #FBBF24); }
    .stat-card-premium.red::before { background: linear-gradient(135deg, #EF4444, #F87171); }
    
    .stat-card-premium.green .stat-icon-wrap { background: linear-gradient(135deg, #10B981, #34D399); }
    .stat-card-premium.blue .stat-icon-wrap { background: var(--gradient-primary); }
    .stat-card-premium.purple .stat-icon-wrap { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    .stat-card-premium.orange .stat-icon-wrap { background: linear-gradient(135deg, #F59E0B, #FBBF24); }
    .stat-card-premium.red .stat-icon-wrap { background: linear-gradient(135deg, #EF4444, #F87171); }
    
    /* Filter Section - Same as Profile Cards */
    .filter-card-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
    }
    
    .filter-card-modern:hover {
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .filter-label-modern {
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
        display: block;
    }
    
    .filter-select-modern {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        color: var(--text-primary);
        font-size: 0.8rem;
        cursor: pointer;
        min-width: 200px;
        transition: all 0.2s ease;
    }
    
    .filter-select-modern:focus {
        outline: none;
        border-color: var(--profile-primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    
    .filter-select-modern option {
        background: var(--card-bg);
        color: var(--text-primary);
    }
    
    .total-badge-modern {
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border-color);
    }
    
    /* Tabs - Same as Profile Style */
    .member-tabs-modern {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0;
        border-bottom: 2px solid var(--border-color);
    }
    
    .member-tab-modern {
        padding: 0.6rem 1.5rem;
        border-radius: 12px 12px 0 0;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        background: transparent;
        color: var(--text-muted);
        border: none;
        position: relative;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }
    
    .member-tab-modern:hover {
        color: var(--text-primary);
    }
    
    .member-tab-modern.active {
        color: var(--text-primary);
    }
    
    .member-tab-modern.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-primary);
        border-radius: 3px 3px 0 0;
    }
    
    .member-tab-modern .badge-modern {
        margin-left: 8px;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        padding: 1px 8px;
        border-radius: 20px;
        font-size: 0.55rem;
        font-weight: 600;
    }
    
    .member-tab-modern.active .badge-modern {
        background: var(--gradient-primary);
        color: white;
    }
    
    /* Table Container - Same as Profile Cards */
    .table-container-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
    }
    
    .table-container-modern:hover {
        box-shadow: var(--shadow-profile-hover);
    }
    
    .table-modern {
        margin-bottom: 0;
        color: var(--text-primary);
        background: var(--card-bg);
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        background: var(--bg-tertiary);
        border-bottom: 2px solid var(--border-color);
        color: var(--text-muted);
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 0.8rem 1.2rem;
        white-space: nowrap;
        font-family: 'Inter', sans-serif;
    }
    
    .table-modern tbody td {
        padding: 0.7rem 1.2rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
    }
    
    .table-modern tbody tr {
        transition: all 0.15s ease;
        cursor: pointer;
    }
    
    .table-modern tbody tr:hover {
        background: var(--bg-tertiary);
    }
    
    .table-modern tbody tr:hover td {
        background: transparent;
    }
    
    /* Member Avatar - Same as Profile */
    .member-avatar-modern {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--bg-tertiary);
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: var(--text-muted);
        flex-shrink: 0;
        transition: all 0.2s ease;
        font-weight: 600;
    }
    
    .member-avatar-modern.deceased {
        opacity: 0.5;
        border-color: #ef4444;
        background: #fef2f2;
        color: #ef4444;
    }
    
    .member-name-modern {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-primary);
        margin-bottom: 2px;
    }
    
    .member-phone-modern {
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .deceased-date-modern {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    
    /* Gender Badge - Small for index */
    .gender-badge-small {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
    }
    
    .gender-badge-small.male {
        background: rgba(59, 130, 246, 0.12);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.15);
    }
    
    .gender-badge-small.female {
        background: rgba(236, 72, 153, 0.12);
        color: #EC4899;
        border: 1px solid rgba(236, 72, 153, 0.15);
    }
    
    .gender-badge-small.unspecified {
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }
    
    .gender-badge-small i {
        font-size: 0.5rem;
    }
    
    /* Role Tags - Same as Profile */
    .role-tag-modern {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .role-tag-modern i {
        font-size: 0.5rem;
        opacity: 0.6;
    }
    
    .role-tag-modern:hover {
        transform: translateY(-1px);
        border-color: var(--profile-primary);
    }
    
    .role-tag-modern.choir {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }
    
    [data-theme="dark"] .role-tag-modern.choir {
        background: #78350f;
        color: #fde68a;
        border-color: #92400e;
    }
    
    .role-tag-modern.deceased-tag {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fca5a5;
    }
    
    [data-theme="dark"] .role-tag-modern.deceased-tag {
        background: #7f1d1d;
        color: #fca5a5;
        border-color: #991b1b;
    }
    
    /* Action Buttons - Same as Profile */
    .btn-icon-action-modern {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.7rem;
        position: relative;
        z-index: 5;
    }
    
    .btn-icon-action-modern:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-profile-lg);
    }
    
    .btn-icon-action-modern.delete:hover {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }
    
    .btn-icon-action-modern.deceased:hover {
        background: #f1f5f9;
        color: #64748b;
        border-color: #e2e8f0;
    }
    
    .btn-icon-action-modern.restore:hover {
        background: #ecfdf5;
        color: #10b981;
        border-color: #a7f3d0;
    }
    
    .btn-icon-action-modern.view:hover {
        background: #eff6ff;
        color: #3b82f6;
        border-color: #bfdbfe;
    }
    
    .action-buttons-modern {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }
    
    /* Add Button - Same as Profile */
    .btn-add-modern {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 0.4rem 1.2rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        position: relative;
        z-index: 5;
        font-family: 'Inter', sans-serif;
    }
    
    .btn-add-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
        color: white;
        text-decoration: none;
    }
    
    /* Table Sections */
    .table-section-modern {
        display: none;
    }
    
    .table-section-modern.active-section {
        display: block;
    }
    
    /* Pagination - Same as Profile */
    .pagination-container-modern {
        padding: 0.8rem 1.2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        background: var(--card-bg);
    }
    
    .pagination-info-modern {
        font-size: 0.65rem;
        color: var(--text-muted);
    }
    
    .pagination-modern {
        margin: 0;
        gap: 4px;
    }
    
    .pagination-modern .page-link {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-secondary);
        font-size: 0.65rem;
        padding: 4px 12px;
        transition: all 0.2s ease;
    }
    
    .pagination-modern .page-link:hover {
        background: var(--bg-tertiary);
        border-color: var(--border-color);
        color: var(--text-primary);
        transform: translateY(-1px);
    }
    
    .pagination-modern .page-item.active .page-link {
        background: var(--gradient-primary);
        border-color: var(--profile-primary);
        color: white;
    }
    
    /* Empty State - Same as Profile */
    .empty-state-modern {
        text-align: center;
        padding: 3rem 1.5rem;
        color: var(--text-muted);
    }
    
    .empty-state-modern i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }
    
    .empty-state-modern h5 {
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .empty-state-modern p {
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }
    
    .empty-state-modern .btn-add-modern {
        padding: 0.6rem 2rem;
        font-size: 0.8rem;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid-premium {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .member-hero .hero-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .member-hero .hero-actions {
            width: 100%;
        }
    }
    
    @media (max-width: 768px) {
        .member-hero {
            padding: 1.5rem;
        }
        
        .member-hero h1 {
            font-size: 1.3rem;
        }
        
        .stats-grid-premium {
            grid-template-columns: 1fr 1fr;
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
        
        .member-tab-modern {
            flex: 1;
            text-align: center;
            font-size: 0.65rem;
            padding: 0.5rem 0.8rem;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 0.5rem 0.8rem;
            font-size: 0.65rem;
        }
        
        .action-buttons-modern {
            gap: 3px;
        }
        
        .btn-icon-action-modern {
            width: 28px;
            height: 28px;
            font-size: 0.6rem;
        }
        
        .member-avatar-modern {
            width: 28px;
            height: 28px;
            font-size: 0.6rem;
        }
        
        .pagination-container-modern {
            flex-direction: column;
            text-align: center;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid-premium {
            grid-template-columns: 1fr;
        }
        
        .profile-header-left {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

{{-- ============================================= --}}
{{-- MAIN CONTENT --}}
{{-- ============================================= --}}
<div class="container-fluid px-0">

    {{-- ============================================ --}}
    {{-- HERO SECTION - SAME AS PROFILE --}}
    {{-- ============================================ --}}
    <div class="member-hero">
        <div class="hero-content">
            <div class="hero-left">
                <h1><i class="fas fa-users"></i> Member Management</h1>
                <p class="hero-sub">
                    <i class="fas fa-circle" style="color: #34D399; font-size: 0.4rem; vertical-align: middle;"></i>
                    Manage your church members, roles, and choir assignments
                </p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('members.create') }}" class="btn-hero btn-hero-white">
                    <i class="fas fa-user-plus"></i> Add Member
                </a>
                <a href="{{ route('members.index', ['role' => 'all']) }}" class="btn-hero btn-hero-ghost">
                    <i class="fas fa-sync-alt"></i> Reset Filters
                </a>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- STATS CARDS - SAME AS PROFILE --}}
    {{-- ============================================ --}}
    <div class="stats-grid-premium">
        <div class="stat-card-premium green">
            <div class="stat-top">
                <span class="stat-label">Active Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value">{{ number_format($totalMembers ?? $members->total() ?? 0) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> Active members</div>
        </div>
        
        <div class="stat-card-premium purple">
            <div class="stat-top">
                <span class="stat-label">Choir Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-music"></i></div>
            </div>
            <div class="stat-value">{{ number_format($choirCount ?? 0) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> Music ministry</div>
        </div>
        
        <div class="stat-card-premium orange">
            <div class="stat-top">
                <span class="stat-label">Birthdays This Month</span>
                <div class="stat-icon-wrap"><i class="fas fa-birthday-cake"></i></div>
            </div>
            <div class="stat-value">{{ number_format($birthdaysThisMonth ?? 0) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> Celebrating soon</div>
        </div>
        
        <div class="stat-card-premium red">
            <div class="stat-top">
                <span class="stat-label">Deceased</span>
                <div class="stat-icon-wrap"><i class="fas fa-cross"></i></div>
            </div>
            <div class="stat-value">{{ number_format($deceasedCount ?? 0) }}</div>
            <div class="stat-change negative"><i class="fas fa-arrow-down"></i> At rest</div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- FILTER SECTION - SAME AS PROFILE CARDS --}}
    {{-- ============================================ --}}
    <div class="filter-card-modern">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="filter-label-modern"><i class="fas fa-filter me-1"></i> Filter by Ministry</span>
                <select id="roleFilter" class="filter-select-modern" onchange="window.location.href=this.value">
                    <option value="{{ route('members.index', ['role' => 'all']) }}" {{ ($currentFilter ?? 'all') == 'all' ? 'selected' : '' }}>
                        📋 All Members
                    </option>
                    @php
                        $uniqueRoles = collect($allRoles ?? [])->unique('name')->values()->all();
                    @endphp
                    @foreach($uniqueRoles as $role)
                        <option value="{{ route('members.index', ['role' => $role->slug ?? $role]) }}" {{ ($currentFilter ?? '') == ($role->slug ?? $role) ? 'selected' : '' }}>
                            {{ $role->name ?? ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <span class="total-badge-modern">
                    <i class="fas fa-church"></i>
                    Total Active: {{ number_format($members->total() ?? 0) }}
                </span>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- TABS NAVIGATION - SAME AS PROFILE --}}
    {{-- ============================================ --}}
    <div class="member-tabs-modern">
        <button class="member-tab-modern active" onclick="switchTable('active')">
            <i class="fas fa-user-friends me-2"></i>Active
            <span class="badge-modern">{{ number_format($members->total() ?? 0) }}</span>
        </button>
        <button class="member-tab-modern" onclick="switchTable('deceased')">
            <i class="fas fa-cross me-2"></i>Deceased
            <span class="badge-modern">{{ number_format($deceasedCount ?? 0) }}</span>
        </button>
    </div>

    {{-- ============================================ --}}
    {{-- ACTIVE MEMBERS TABLE --}}
    {{-- ============================================ --}}
    <div id="activeMembersTable" class="table-section-modern active-section">
        <div class="table-container-modern">
            <div class="table-responsive">
                <table class="table-modern table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Member</th>
                            <th style="width: 80px;">Gender</th>
                            <th>Roles</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $index => $member)
                            @php
                                $age = $member->birthday ? \Carbon\Carbon::parse($member->birthday)->age : null;
                                $birthdayDate = $member->birthday ? \Carbon\Carbon::parse($member->birthday) : null;
                                $isBirthdayThisWeek = false;
                                if ($birthdayDate) {
                                    $today = \Carbon\Carbon::today();
                                    $birthdayThisYear = \Carbon\Carbon::create($today->year, $birthdayDate->month, $birthdayDate->day);
                                    $daysUntil = $today->diffInDays($birthdayThisYear, false);
                                    $isBirthdayThisWeek = ($daysUntil >= 0 && $daysUntil <= 7);
                                }
                                
                                $memberRoles = $member->roles ?? [];
                                $uniqueRoles = collect($memberRoles)->unique('name')->values()->all();
                                
                                // Gender display
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
                                    $genderLabel = '—';
                                    $genderClass = 'unspecified';
                                }
                            @endphp
                            <tr class="member-row" 
                                data-member-id="{{ $member->id }}" 
                                data-member-name="{{ addslashes($member->first_name . ' ' . $member->last_name) }}"
                                data-member-birthday="{{ $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('F d, Y') : '' }}"
                                data-member-age="{{ $age ?? '' }}"
                                data-member-address="{{ $member->address ?? '' }}"
                                data-member-phone="{{ $member->phone ?? '' }}"
                                data-member-roles="{{ json_encode($uniqueRoles) }}"
                                data-member-ischoir="{{ $member->is_choir ? 'true' : 'false' }}"
                                data-member-isdeceased="{{ $member->is_deceased ? 'true' : 'false' }}">
                                
                                <td class="text-muted">{{ $members->firstItem() + $index }}</td>
                                
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="member-avatar-modern">
                                            {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="member-name-modern">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                                @if($isBirthdayThisWeek) <span style="font-size: 0.7rem;">🎂</span> @endif
                                            </div>
                                            @if($member->phone)
                                                <div class="member-phone-modern"><i class="fas fa-phone"></i> {{ $member->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Gender Column --}}
                                <td>
                                    <span class="gender-badge-small {{ $genderClass }}">
                                        <i class="fas {{ $genderIcon }}"></i>
                                        {{ $genderLabel }}
                                    </span>
                                    @if($genderValue === null)
                                        <span style="font-size: 0.5rem; color: #EF4444; margin-left: 2px;">(null)</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($uniqueRoles as $role)
                                            <span class="role-tag-modern"><i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}</span>
                                        @empty
                                            <span class="role-tag-modern"><i class="fas fa-user"></i> Regular</span>
                                        @endforelse
                                        @if($member->is_choir)
                                            <span class="role-tag-modern choir"><i class="fas fa-music"></i> Choir</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <td>@if($member->birthday) {{ \Carbon\Carbon::parse($member->birthday)->format('M d') }} @else <span class="text-muted">—</span> @endif</td>
                                <td>@if($age) {{ $age }} @else <span class="text-muted">—</span> @endif</td>
                                
                                <td>
                                    <div class="action-buttons-modern">
                                        <a href="{{ route('members.show', $member->id) }}" class="btn-icon-action-modern view" title="View Profile" onclick="event.stopPropagation();">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('members.edit', $member->id) }}" class="btn-icon-action-modern" title="Edit Member" onclick="event.stopPropagation();">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(!$member->is_deceased)
                                        <button type="button" class="btn-icon-action-modern deceased" title="Mark as Deceased" 
                                                onclick="event.stopPropagation(); openDeceasedModal({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-cross"></i>
                                        </button>
                                        @endif
                                        <button type="button" class="btn-icon-action-modern delete" title="Delete Member" 
                                                onclick="event.stopPropagation(); confirmDelete({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state-modern">
                                        <i class="fas fa-users"></i>
                                        <h5>No Members Yet</h5>
                                        <p>Get started by adding your first church member to the system.</p>
                                        <a href="{{ route('members.create') }}" class="btn-add-modern">
                                            <i class="fas fa-plus me-2"></i>Add Your First Member
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($members->hasPages())
            <div class="pagination-container-modern">
                <div class="pagination-info-modern">
                    Showing <strong>{{ $members->firstItem() }}</strong> to <strong>{{ $members->lastItem() }}</strong> of <strong>{{ $members->total() }}</strong> members
                </div>
                {{ $members->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- DECEASED MEMBERS TABLE --}}
    {{-- ============================================ --}}
    <div id="deceasedMembersTable" class="table-section-modern">
        <div class="table-container-modern">
            <div class="table-responsive">
                <table class="table-modern table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Member</th>
                            <th style="width: 80px;">Gender</th>
                            <th>Roles</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deceasedMembers ?? [] as $index => $member)
                            @php
                                $ageAtDeath = null;
                                if ($member->birthday && $member->date_deceased) {
                                    $birthDate = \Carbon\Carbon::parse($member->birthday);
                                    $deathDate = \Carbon\Carbon::parse($member->date_deceased);
                                    $ageAtDeath = $birthDate->diffInYears($deathDate);
                                }
                                
                                $memberRoles = $member->roles ?? [];
                                $uniqueRoles = collect($memberRoles)->unique('name')->values()->all();
                                
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
                                    $genderLabel = '—';
                                    $genderClass = 'unspecified';
                                }
                            @endphp
                            <tr class="member-row" 
                                data-member-id="{{ $member->id }}" 
                                data-member-name="{{ addslashes($member->first_name . ' ' . $member->last_name) }}"
                                data-member-birthday="{{ $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('F d, Y') : '' }}"
                                data-member-age="{{ $ageAtDeath ?? '' }}"
                                data-member-address="{{ $member->address ?? '' }}"
                                data-member-phone="{{ $member->phone ?? '' }}"
                                data-member-roles="{{ json_encode($uniqueRoles) }}"
                                data-member-ischoir="{{ $member->is_choir ? 'true' : 'false' }}"
                                data-member-isdeceased="true">
                                
                                <td class="text-muted">{{ ($deceasedMembers->currentPage() - 1) * $deceasedMembers->perPage() + $index + 1 }}</td>
                                
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="member-avatar-modern deceased">
                                            <i class="fas fa-cross"></i>
                                        </div>
                                        <div>
                                            <div class="member-name-modern">{{ $member->first_name }} {{ $member->last_name }}</div>
                                            <div class="deceased-date-modern">
                                                <i class="fas fa-cross me-1"></i> {{ \Carbon\Carbon::parse($member->date_deceased)->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Gender Column for Deceased --}}
                                <td>
                                    <span class="gender-badge-small {{ $genderClass }}">
                                        <i class="fas {{ $genderIcon }}"></i>
                                        {{ $genderLabel }}
                                    </span>
                                    @if($genderValue === null)
                                        <span style="font-size: 0.5rem; color: #EF4444; margin-left: 2px;">(null)</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($uniqueRoles as $role)
                                            <span class="role-tag-modern"><i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}</span>
                                        @empty
                                            <span class="role-tag-modern"><i class="fas fa-user"></i> Regular</span>
                                        @endforelse
                                        @if($member->is_choir)
                                            <span class="role-tag-modern choir"><i class="fas fa-music"></i> Choir</span>
                                        @endif
                                        <span class="role-tag-modern deceased-tag"><i class="fas fa-cross"></i> Deceased</span>
                                    </div>
                                </td>
                                
                                <td>@if($member->birthday) {{ \Carbon\Carbon::parse($member->birthday)->format('M d') }} @else <span class="text-muted">—</span> @endif</td>
                                <td>@if($ageAtDeath) {{ $ageAtDeath }} @else <span class="text-muted">—</span> @endif</td>
                                
                                <td>
                                    <div class="action-buttons-modern">
                                        <button type="button" class="btn-icon-action-modern restore" title="Restore to Active" 
                                                onclick="event.stopPropagation(); confirmRestore({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                        <button type="button" class="btn-icon-action-modern delete" title="Delete Permanently" 
                                                onclick="event.stopPropagation(); confirmDeletePermanent({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                    <form id="restore-form-{{ $member->id }}" action="{{ route('members.restore', $member->id) }}" method="POST" style="display: none;">
                                        @csrf @method('PUT')
                                    </form>
                                    <form id="delete-deceased-form-{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state-modern">
                                        <i class="fas fa-cross"></i>
                                        <h5>No Deceased Members</h5>
                                        <p>Click the cross button <i class="fas fa-cross"></i> on any active member to move them here.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($deceasedMembers) && $deceasedMembers instanceof \Illuminate\Pagination\LengthAwarePaginator && $deceasedMembers->hasPages())
            <div class="pagination-container-modern">
                <div class="pagination-info-modern">
                    Showing <strong>{{ $deceasedMembers->firstItem() }}</strong> to <strong>{{ $deceasedMembers->lastItem() }}</strong> of <strong>{{ $deceasedMembers->total() }}</strong> deceased members
                </div>
                {{ $deceasedMembers->links('pagination::bootstrap-5') }}
            </div>
            @elseif(isset($deceasedMembers) && $deceasedMembers->count() > 0)
            <div class="pagination-container-modern">
                <div class="pagination-info-modern">
                    Showing <strong>{{ $deceasedMembers->count() }}</strong> deceased members
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- SCRIPTS SECTION --}}
{{-- ============================================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // =============================================
    // TABLE SWITCHING FUNCTION
    // =============================================
    function switchTable(tableType) {
        const tabs = document.querySelectorAll('.member-tab-modern');
        tabs.forEach(tab => tab.classList.remove('active'));
        
        if (tableType === 'active') {
            tabs[0].classList.add('active');
            document.getElementById('activeMembersTable').classList.add('active-section');
            document.getElementById('deceasedMembersTable').classList.remove('active-section');
        } else {
            tabs[1].classList.add('active');
            document.getElementById('deceasedMembersTable').classList.add('active-section');
            document.getElementById('activeMembersTable').classList.remove('active-section');
        }
        
        window.location.hash = tableType;
    }
    
    // =============================================
    // DELETE ACTIVE MEMBER
    // =============================================
    function confirmDelete(memberId, memberName) {
        Swal.fire({
            title: 'Delete Member?',
            html: `Are you sure you want to permanently delete <strong>${memberName}</strong>?<br><small>This action cannot be undone.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel',
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    html: '<div class="loading-spinner"></div><p class="mt-2">Please wait</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: 'var(--card-bg)'
                });
                document.getElementById(`delete-form-${memberId}`).submit();
            }
        });
    }
    
    // =============================================
    // DELETE DECEASED MEMBER (PERMANENT)
    // =============================================
    function confirmDeletePermanent(memberId, memberName) {
        Swal.fire({
            title: 'Permanently Delete?',
            html: `Are you sure you want to permanently delete <strong>${memberName}</strong>?<br><small>All records will be lost forever.</small>`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel',
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    html: '<div class="loading-spinner"></div><p class="mt-2">Please wait</p>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    background: 'var(--card-bg)'
                });
                document.getElementById(`delete-deceased-form-${memberId}`).submit();
            }
        });
    }
    
    // =============================================
    // RESTORE DECEASED MEMBER
    // =============================================
    function confirmRestore(memberId, memberName) {
        Swal.fire({
            title: 'Restore Member?',
            html: `Are you sure you want to restore <strong>${memberName}</strong> to active members?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, restore!',
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Restored!',
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
                        title: 'Error!',
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                });
            }
        });
    }
    
    // =============================================
    // MARK AS DECEASED MODAL
    // =============================================
    function openDeceasedModal(memberId, memberName) {
        Swal.fire({
            title: 'Mark as Deceased',
            html: `
                <div style="text-align: left;">
                    <p>Mark <strong>${memberName}</strong> as deceased?</p>
                    <div class="mb-3">
                        <label class="form-label" style="display: block; text-align: left; margin-bottom: 5px;">Date of Death:</label>
                        <input type="date" id="date_deceased_input" class="swal2-input" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #d1d5db;" max="${new Date().toISOString().split('T')[0]}" required>
                    </div>
                    <small style="color: #6b7280;">This member will be moved to the Deceased Members section.</small>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#6b7280',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Mark as Deceased',
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ date_deceased: dateDeceased })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Marked as Deceased',
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
                        title: 'Error!',
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                });
            }
        });
    }
    
    // =============================================
    // INITIALIZE ON PAGE LOAD
    // =============================================
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.substring(1);
        if (hash === 'deceased') { 
            switchTable('deceased');
        }
    });
</script>
@endsection