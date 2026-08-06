@extends('layouts.app')

@section('header', 'Finance Dashboard')

@section('content')

{{-- ============================================= --}}
{{-- STYLES SECTION --}}
{{-- ============================================= --}}
<style>
    /* ============================================
       MODERN DESIGN - MATCHING MEMBER PROFILE STYLE
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
    
    /* Hero Section - Same as Member */
    .finance-hero {
        background: var(--gradient-primary);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-glow);
    }
    
    .finance-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: heroPulse 6s ease-in-out infinite;
    }
    
    .finance-hero::after {
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
    
    .finance-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .finance-hero .hero-left {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .finance-hero h1 {
        font-size: 1.8rem;
        font-weight: 800;
        color: white;
        margin: 0;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
    }
    
    .finance-hero h1 i {
        margin-right: 12px;
        opacity: 0.8;
    }
    
    .finance-hero .hero-sub {
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
        margin: 0;
    }
    
    .finance-hero .hero-actions {
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
    
    /* Stats Grid - Premium Cards (Same as Member) */
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
    
    /* Filter Card - Same as Member */
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
    
    /* Church Detail Card - Premium */
    .church-detail-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .church-detail-premium:hover {
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .church-detail-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }
    
    .church-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.2rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .church-detail-header .church-name-large {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .church-detail-header .church-name-large i {
        color: #4F46E5;
        margin-right: 10px;
    }
    
    .church-detail-header .date-badge {
        font-size: 0.65rem;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        padding: 4px 14px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
    }
    
    .church-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.2rem;
    }
    
    .church-detail-item {
        background: var(--bg-tertiary);
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .church-detail-item:hover {
        transform: translateY(-2px);
        border-color: var(--profile-primary);
    }
    
    .church-detail-item .label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-muted);
        font-weight: 700;
    }
    
    .church-detail-item .value {
        font-size: 1.3rem;
        font-weight: 700;
        margin-top: 0.2rem;
        font-family: 'Inter', sans-serif;
    }
    
    .church-detail-item .value.income {
        color: #10B981;
    }
    
    .church-detail-item .value.expense {
        color: #EF4444;
    }
    
    .church-detail-item .value.balance {
        color: #4F46E5;
    }
    
    .church-detail-item .value.balance.positive {
        color: #10B981;
    }
    
    .church-detail-item .value.balance.negative {
        color: #EF4444;
    }
    
    .church-detail-item .sub-text {
        font-size: 0.6rem;
        color: var(--text-muted);
        font-weight: 600;
        margin-top: 2px;
    }
    
    .category-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        padding-top: 1.2rem;
        border-top: 1px solid var(--border-color);
    }
    
    .category-section .cat-label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .category-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
    }
    
    .category-tag {
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 500;
        border: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        transition: all 0.2s ease;
    }
    
    .category-tag:hover {
        transform: translateY(-1px);
    }
    
    .category-tag.income-tag {
        background: rgba(16, 185, 129, 0.1);
        color: #10B981;
        border-color: rgba(16, 185, 129, 0.2);
    }
    
    .category-tag.expense-tag {
        background: rgba(239, 68, 68, 0.1);
        color: #EF4444;
        border-color: rgba(239, 68, 68, 0.2);
    }
    
    /* Chart Container - Premium */
    .chart-container-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
    }
    
    .chart-container-premium:hover {
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .chart-container-premium .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .chart-container-premium .chart-header h6 {
        font-size: 0.75rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        font-family: 'Inter', sans-serif;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .chart-container-premium .chart-header h6 i {
        font-size: 0.9rem;
        color: #10B981;
    }
    
    .chart-legend-premium {
        display: flex;
        gap: 20px;
        margin-bottom: 12px;
    }
    
    .leg-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.7rem;
        color: var(--text-muted);
        font-weight: 500;
    }
    
    .leg-dot {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }
    
    .chart-box {
        height: 240px;
        position: relative;
    }
    
    .chart-box canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* All Churches Grid - Premium Cards */
    .all-churches-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .church-mini-card-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        box-shadow: var(--shadow-profile-lg);
        cursor: default;
    }
    
    .church-mini-card-premium:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .church-mini-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gradient-primary);
        border-radius: 16px 16px 0 0;
    }
    
    .church-mini-card-premium .church-name {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.3rem;
        font-family: 'Inter', sans-serif;
    }
    
    .church-mini-card-premium .church-name i {
        color: #4F46E5;
        margin-right: 8px;
    }
    
    .church-mini-card-premium .mini-balance {
        font-size: 1.3rem;
        font-weight: 800;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.3px;
    }
    
    .church-mini-card-premium .mini-balance.positive {
        color: #10B981;
    }
    
    .church-mini-card-premium .mini-balance.negative {
        color: #EF4444;
    }
    
    .church-mini-card-premium .mini-details {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
        font-size: 0.65rem;
        color: var(--text-muted);
        flex-wrap: wrap;
    }
    
    .church-mini-card-premium .mini-details span {
        background: var(--bg-tertiary);
        padding: 2px 10px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .church-mini-card-premium .mini-details span i {
        font-size: 0.5rem;
    }
    
    .church-mini-card-premium .status-dot {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    
    .church-mini-card-premium .status-dot.surplus {
        background: #10B981;
        box-shadow: 0 0 12px rgba(16, 185, 129, 0.3);
    }
    
    .church-mini-card-premium .status-dot.deficit {
        background: #EF4444;
        box-shadow: 0 0 12px rgba(239, 68, 68, 0.3);
    }
    
    .btn-view-church-premium {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 8px;
        background: rgba(79, 70, 229, 0.08);
        color: #4F46E5;
        font-size: 0.65rem;
        font-weight: 600;
        border: 1px solid rgba(79, 70, 229, 0.15);
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        margin-top: 8px;
    }
    
    .btn-view-church-premium:hover {
        background: #4F46E5;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
        text-decoration: none;
    }
    
    /* Empty State - Same as Member */
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
        font-family: 'Inter', sans-serif;
    }
    
    .empty-state-modern p {
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }
    
    .empty-state-modern .btn-add-modern {
        padding: 0.6rem 2rem;
        font-size: 0.8rem;
    }
    
    .btn-add-modern {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }
    
    .btn-add-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(79, 70, 229, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .info-message-modern {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        color: var(--text-secondary);
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-message-modern i {
        color: #4F46E5;
        font-size: 1.1rem;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid-premium {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .finance-hero .hero-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .finance-hero .hero-actions {
            width: 100%;
        }
        
        .category-section {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .finance-hero {
            padding: 1.5rem;
        }
        
        .finance-hero h1 {
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
        
        .church-detail-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .all-churches-grid-premium {
            grid-template-columns: 1fr 1fr;
        }
        
        .chart-box {
            height: 180px;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid-premium {
            grid-template-columns: 1fr;
        }
        
        .church-detail-grid {
            grid-template-columns: 1fr;
        }
        
        .all-churches-grid-premium {
            grid-template-columns: 1fr;
        }
        
        .filter-card-modern .row {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-select-modern {
            width: 100%;
        }
        
        .total-badge-modern {
            justify-content: center;
        }
        
        .church-detail-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

{{-- ============================================= --}}
{{-- MAIN CONTENT --}}
{{-- ============================================= --}}
<div class="container-fluid px-0">

    {{-- ============================================ --}}
    {{-- HERO SECTION - SAME AS MEMBER --}}
    {{-- ============================================ --}}
    <div class="finance-hero">
        <div class="hero-content">
            <div class="hero-left">
                <h1><i class="fas fa-coins"></i> Finance Dashboard</h1>
                <p class="hero-sub">
                    <i class="fas fa-circle" style="color: #34D399; font-size: 0.4rem; vertical-align: middle;"></i>
                    Track income, expenses, and financial health across all churches
                </p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('finance.index') }}?church=all" class="btn-hero btn-hero-white">
                    <i class="fas fa-chart-simple"></i> View All
                </a>
                <a href="{{ route('finance.index') }}" class="btn-hero btn-hero-ghost">
                    <i class="fas fa-sync-alt"></i> Refresh
                </a>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- STATS CARDS - SAME AS MEMBER --}}
    {{-- ============================================ --}}
    <div class="stats-grid-premium">
        <div class="stat-card-premium green">
            <div class="stat-top">
                <span class="stat-label">Total Income</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-down"></i></div>
            </div>
            <div class="stat-value">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> All churches</div>
        </div>
        
        <div class="stat-card-premium red">
            <div class="stat-top">
                <span class="stat-label">Total Expenses</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-up"></i></div>
            </div>
            <div class="stat-value">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            <div class="stat-change negative"><i class="fas fa-arrow-down"></i> All churches</div>
        </div>
        
        <div class="stat-card-premium blue">
            <div class="stat-top">
                <span class="stat-label">Overall Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-scale-balanced"></i></div>
            </div>
            <div class="stat-value" style="color: {{ ($overallBalance ?? 0) >= 0 ? '#10B981' : '#EF4444' }}">
                ₱{{ number_format(abs($overallBalance ?? 0), 2) }}
            </div>
            <div class="stat-change {{ ($overallBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                {{ ($overallBalance ?? 0) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
            </div>
        </div>
        
        <div class="stat-card-premium purple">
            <div class="stat-top">
                <span class="stat-label">Churches</span>
                <div class="stat-icon-wrap"><i class="fas fa-church"></i></div>
            </div>
            <div class="stat-value">{{ $churches->count() ?? 0 }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> Connected churches</div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- FILTER SECTION - SAME AS MEMBER CARDS --}}
    {{-- ============================================ --}}
    <div class="filter-card-modern">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="filter-label-modern"><i class="fas fa-church me-1"></i> Select Church</span>
                <select id="churchSelect" class="filter-select-modern" onchange="window.location.href='{{ route('finance.index') }}?church=' + this.value">
                    <option value="">-- Choose a Church --</option>
                    @foreach($churches as $church)
                        <option value="{{ $church->id }}" {{ ($selectedChurchId ?? '') == $church->id ? 'selected' : '' }}>
                            {{ $church->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <span class="total-badge-modern">
                    <i class="fas fa-building"></i>
                    @if($selectedChurch)
                        Viewing: <strong>{{ $selectedChurch->name }}</strong>
                    @else
                        All Churches
                    @endif
                </span>
            </div>
        </div>
    </div>

    @if($selectedChurch)
        {{-- ============================================ --}}
        {{-- CHURCH DETAIL - FILTERED BY SELECTED CHURCH --}}
        {{-- ============================================ --}}
        <div class="church-detail-premium">
            <div class="church-detail-header">
                <div class="church-name-large">
                    <i class="fas fa-church"></i> {{ $selectedChurch->name }}
                </div>
                <span class="date-badge">
                    <i class="fas fa-calendar-alt"></i> {{ now()->format('F d, Y') }}
                </span>
            </div>
            
            <div class="church-detail-grid">
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-arrow-down" style="color: #10B981;"></i> Total Income</div>
                    <div class="value income">₱{{ number_format($churchIncome ?? 0, 2) }}</div>
                </div>
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-arrow-up" style="color: #EF4444;"></i> Total Expenses</div>
                    <div class="value expense">₱{{ number_format($churchExpenses ?? 0, 2) }}</div>
                </div>
                <div class="church-detail-item">
                    <div class="label"><i class="fas fa-scale-balanced" style="color: #4F46E5;"></i> Balance</div>
                    <div class="value balance {{ ($churchBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                        ₱{{ number_format(abs($churchBalance ?? 0), 2) }}
                    </div>
                    <div class="sub-text">
                        {{ ($churchBalance ?? 0) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
                    </div>
                </div>
            </div>
            
            <div class="category-section">
                <div>
                    <span class="cat-label"><i class="fas fa-tags" style="color: #10B981;"></i> Income Categories</span>
                    <div class="category-tags">
                        @forelse($incomeTypes ?? [] as $type)
                            <span class="category-tag income-tag">
                                {{ $type->category ?? 'Uncategorized' }}: ₱{{ number_format($type->total, 2) }}
                            </span>
                        @empty
                            <span style="font-size: 0.7rem; color: var(--text-muted);">No income categories</span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <span class="cat-label"><i class="fas fa-tags" style="color: #EF4444;"></i> Expense Categories</span>
                    <div class="category-tags">
                        @forelse($expenseTypes ?? [] as $type)
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

        {{-- CHART - FILTERED BY SELECTED CHURCH --}}
        <div class="chart-container-premium">
            <div class="chart-header">
                <h6>
                    <i class="fas fa-chart-line"></i> Monthly Income vs Expenses - {{ $selectedChurch->name }}
                </h6>
                <span style="font-size: 0.65rem; color: var(--text-muted);">Last 6 months</span>
            </div>
            <div class="chart-legend-premium">
                <span class="leg-item">
                    <span class="leg-dot" style="background: #10B981;"></span> Income
                </span>
                <span class="leg-item">
                    <span class="leg-dot" style="background: #EF4444; border: 2px dashed #EF4444; background: none; width: 20px; height: 2px; border-radius: 0;"></span> Expenses
                </span>
            </div>
            <div class="chart-box">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    @else
        {{-- ============================================ --}}
        {{-- ALL CHURCHES OVERVIEW (When No Church Selected) --}}
        {{-- ============================================ --}}
        <div class="info-message-modern">
            <i class="fas fa-info-circle"></i>
            Select a church above to view its detailed financial information.
        </div>
        
        <div class="all-churches-grid-premium">
            @foreach($churchBalances ?? [] as $data)
            <div class="church-mini-card-premium">
                <div class="status-dot {{ $data['status'] }}"></div>
                <div class="church-name">
                    <i class="fas fa-church"></i> {{ $data['church']->name }}
                </div>
                <div class="mini-balance {{ $data['status'] == 'surplus' ? 'positive' : 'negative' }}">
                    ₱{{ number_format(abs($data['balance']), 2) }}
                    {{ $data['balance'] >= 0 ? '↑' : '↓' }}
                </div>
                <div class="mini-details">
                    <span><i class="fas fa-arrow-down" style="color: #10B981;"></i> ₱{{ number_format($data['income'], 2) }}</span>
                    <span><i class="fas fa-arrow-up" style="color: #EF4444;"></i> ₱{{ number_format($data['expense'], 2) }}</span>
                </div>
                <a href="{{ route('finance.index') }}?church={{ $data['church']->id }}" class="btn-view-church-premium">
                    <i class="fas fa-eye"></i> View Details
                </a>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ============================================= --}}
{{-- SCRIPTS SECTION --}}
{{-- ============================================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // CHART - FILTERED BY SELECTED CHURCH
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
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.07)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#10B981',
                            pointBorderColor: ptBorder,
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#10B981',
                            pointHoverBorderColor: ptBorder,
                            pointHoverBorderWidth: 2
                        },
                        {
                            label: 'Expenses',
                            data: expenseData,
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.05)',
                            borderWidth: 2,
                            borderDash: [5, 3],
                            fill: true,
                            tension: 0.4,
                            pointRadius: 3,
                            pointBackgroundColor: '#EF4444',
                            pointBorderColor: ptBorder,
                            pointBorderWidth: 2,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: '#EF4444',
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
    });
</script>
@endsection