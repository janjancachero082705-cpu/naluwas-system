@extends('layouts.app')

@section('header', 'Inventory Management')

@section('content')

{{-- ============================================= --}}
{{-- STYLES SECTION --}}
{{-- ============================================= --}}
<style>
    /* ============================================
       MODERN DESIGN - WITH GRADIENT COLORS
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
        --gradient-success: linear-gradient(135deg, #10B981, #34D399);
        --gradient-danger: linear-gradient(135deg, #EF4444, #F87171);
        --gradient-info: linear-gradient(135deg, #3B82F6, #60A5FA);
        --gradient-multi: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
        --shadow-profile-lg: 0 20px 60px rgba(0,0,0,0.08);
        --shadow-profile-hover: 0 24px 80px rgba(0,0,0,0.12);
        --shadow-glow: 0 8px 32px rgba(79, 70, 229, 0.3);
        --shadow-success: 0 8px 32px rgba(16, 185, 129, 0.3);
        --shadow-danger: 0 8px 32px rgba(239, 68, 68, 0.3);
        --shadow-info: 0 8px 32px rgba(59, 130, 246, 0.3);
    }
    
    /* Hero Section - MULTI-COLOR GRADIENT */
    .finance-hero {
        background: var(--gradient-multi);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(79, 70, 229, 0.3);
    }
    
    .finance-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 80%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
        animation: heroPulse 8s ease-in-out infinite;
    }
    
    .finance-hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        pointer-events: none;
        animation: heroPulse 10s ease-in-out infinite reverse;
    }
    
    @keyframes heroPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
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
        color: rgba(255,255,255,0.85);
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
    
    /* Hero Buttons - Premium Design with GRADIENTS */
    .btn-hero {
        padding: 0.6rem 1.6rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        border: none;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.3px;
        position: relative;
        overflow: hidden;
        color: white;
    }
    
    .btn-hero::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transition: width 0.6s ease, height 0.6s ease, top 0.6s ease, left 0.6s ease;
    }
    
    .btn-hero:active::after {
        width: 300px;
        height: 300px;
        top: -100px;
        left: -100px;
    }
    
    /* Income Button - GREEN GRADIENT */
    .btn-hero-income {
        background: var(--gradient-success);
        box-shadow: var(--shadow-success);
        color: white;
    }
    
    .btn-hero-income:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    /* Expense Button - RED GRADIENT */
    .btn-hero-expense {
        background: var(--gradient-danger);
        box-shadow: var(--shadow-danger);
        color: white;
    }
    
    .btn-hero-expense:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(239, 68, 68, 0.4);
        color: white;
    }
    
    /* Transactions Button - WHITE */
    .btn-hero-transactions {
        background: #ffffff;
        color: #4F46E5;
        box-shadow: 0 8px 32px rgba(255, 255, 255, 0.3);
    }
    
    .btn-hero-transactions:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(255, 255, 255, 0.5);
        color: #4F46E5;
        background: #f1f5f9;
    }
    
    /* Stats Grid - Premium Cards */
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
    
    /* Gradient variants for stat cards */
    .stat-card-premium.green::before { background: var(--gradient-success); }
    .stat-card-premium.blue::before { background: var(--gradient-primary); }
    .stat-card-premium.purple::before { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    .stat-card-premium.orange::before { background: linear-gradient(135deg, #F59E0B, #FBBF24); }
    .stat-card-premium.red::before { background: var(--gradient-danger); }
    
    .stat-card-premium.green .stat-icon-wrap { background: var(--gradient-success); box-shadow: var(--shadow-success); }
    .stat-card-premium.blue .stat-icon-wrap { background: var(--gradient-primary); box-shadow: var(--shadow-glow); }
    .stat-card-premium.purple .stat-icon-wrap { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    .stat-card-premium.orange .stat-icon-wrap { background: linear-gradient(135deg, #F59E0B, #FBBF24); }
    .stat-card-premium.red .stat-icon-wrap { background: var(--gradient-danger); box-shadow: var(--shadow-danger); }
    
    /* Summary Banner - Premium */
    .summary-banner-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.8rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    
    .summary-banner-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-primary);
    }
    
    .summary-banner-premium:hover {
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .summary-banner-premium h4 {
        margin: 0 0 4px 0;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        font-weight: 700;
    }
    
    .summary-banner-premium .amount {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
    }
    
    .summary-banner-premium .small {
        font-size: 0.7rem;
        color: var(--text-muted);
    }
    
    /* Category Grid - Premium */
    .category-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .category-card-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
    }
    
    .category-card-premium:hover {
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .category-header-premium {
        padding: 0.8rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .category-header-premium h6 {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .category-header-premium h6 i {
        margin-right: 8px;
    }
    
    .category-header-premium h6 .text-success { color: #10B981 !important; }
    .category-header-premium h6 .text-danger { color: #EF4444 !important; }
    
    .category-item-premium {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .category-item-premium:hover {
        background: var(--bg-tertiary);
        transform: translateX(4px);
    }
    
    .category-name-premium {
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .category-amount-premium {
        font-weight: 700;
        font-size: 0.85rem;
        font-family: 'Inter', sans-serif;
    }
    
    .category-amount-premium.income { color: #10B981; }
    .category-amount-premium.expense { color: #EF4444; }
    
    .summary-row-premium {
        padding: 0.7rem 1.5rem;
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 0.85rem;
        border-top: 2px solid var(--border-color);
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    /* Table Container - Premium */
    .table-container-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-profile-lg);
        transition: all 0.3s ease;
    }
    
    .table-container-premium:hover {
        box-shadow: var(--shadow-profile-hover);
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
    
    .table-premium {
        margin-bottom: 0;
        width: 100%;
        background: var(--card-bg);
        border-collapse: collapse;
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
    
    .type-badge-premium {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
    }
    
    .badge-income-premium {
        background: rgba(16, 185, 129, 0.12);
        color: #10B981 !important;
    }
    
    .badge-expense-premium {
        background: rgba(239, 68, 68, 0.12);
        color: #EF4444 !important;
    }
    
    /* Modal Styles - Premium */
    .modal-content-premium {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-profile-hover);
    }
    
    .modal-header-premium {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .modal-header-premium .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .modal-header-premium p {
        color: var(--text-muted);
        font-size: 0.75rem;
        margin: 0;
    }
    
    /* Category Pills - Premium */
    .category-pills-premium {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .category-pill-premium {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        text-align: center;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
    }
    
    .category-pill-premium i {
        font-size: 0.6rem;
    }
    
    .category-pill-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #10B981;
    }
    
    .category-pill-premium.selected {
        background: #10B981;
        border-color: #10B981;
        color: white;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    }
    
    /* Amount Preview - Premium */
    .amount-preview-premium {
        background: var(--bg-tertiary);
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        margin-top: 1rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    
    .amount-preview-premium:hover {
        border-color: #10B981;
    }
    
    /* Transaction Summary - Premium */
    .transaction-summary-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
    }
    
    .summary-item-premium {
        background: var(--bg-tertiary);
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }
    
    .summary-item-premium:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-profile-hover);
        border-color: transparent;
    }
    
    .summary-icon-premium {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }
    
    .summary-icon-premium.income-bg { background: var(--gradient-success); }
    .summary-icon-premium.expense-bg { background: var(--gradient-danger); }
    .summary-icon-premium.balance-bg { background: var(--gradient-primary); }
    .summary-icon-premium.total-bg { background: linear-gradient(135deg, #8B5CF6, #A78BFA); }
    
    /* Filter Tabs - Premium */
    .filter-tabs-premium {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 0.75rem;
    }
    
    .filter-tab-premium {
        padding: 0.4rem 1.2rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        background: transparent;
        color: var(--text-secondary);
        font-size: 0.7rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }
    
    .filter-tab-premium:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        transform: translateY(-2px);
    }
    
    .filter-tab-premium.active {
        background: #10B981;
        color: white;
        border-color: #10B981;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    }
    
    /* Search Bar - Premium */
    .search-bar-premium {
        max-width: 320px;
    }
    
    .search-bar-premium .input-group-text {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    .search-bar-premium .form-control {
        background: var(--input-bg);
        border-left: none;
        border-radius: 0 10px 10px 0;
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
    }
    
    .search-bar-premium .form-control:focus {
        border-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    /* Buttons - Premium with Gradients */
    .btn-secondary-premium {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }
    
    .btn-secondary-premium:hover {
        background: var(--hover-bg);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .btn-primary-premium {
        background: var(--gradient-primary);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        box-shadow: var(--shadow-glow);
    }
    
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(79, 70, 229, 0.4);
        color: white;
    }
    
    .btn-success-premium {
        background: var(--gradient-success);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        box-shadow: var(--shadow-success);
    }
    
    .btn-success-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(16, 185, 129, 0.4);
        color: white;
    }
    
    .btn-danger-premium {
        background: var(--gradient-danger);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        box-shadow: var(--shadow-danger);
    }
    
    .btn-danger-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(239, 68, 68, 0.4);
        color: white;
    }
    
    .btn-danger-premium:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    
    /* Form Styles - Premium */
    .form-label-premium {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 700;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
    }
    
    .form-label-premium i {
        font-size: 0.65rem;
    }
    
    .form-control-premium {
        width: 100%;
        padding: 0.5rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    
    .form-control-premium:focus {
        outline: none;
        border-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .form-control-premium::placeholder {
        color: var(--text-muted);
    }
    
    .input-group-text-premium {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        font-size: 0.8rem;
        border-radius: 10px 0 0 10px;
    }
    
    /* Alert Styles */
    .alert-success-premium {
        background: rgba(16, 185, 129, 0.08);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.15);
        border-radius: 10px;
        padding: 0.6rem 1rem;
    }
    
    .alert-info-premium {
        background: rgba(59, 130, 246, 0.08);
        color: var(--text-primary);
        border: 1px solid rgba(59, 130, 246, 0.15);
        border-radius: 10px;
        padding: 0.6rem 1rem;
    }
    
    .alert-danger-premium {
        background: rgba(239, 68, 68, 0.08);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.15);
        border-radius: 10px;
        padding: 0.6rem 1rem;
    }
    
    /* Badge */
    .category-badge-premium {
        background: var(--bg-tertiary);
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 0.65rem;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    
    /* Amount Styles */
    .amount-positive-premium { color: #10B981 !important; }
    .amount-negative-premium { color: #EF4444 !important; }
    
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
        
        .btn-hero {
            flex: 1;
            justify-content: center;
        }
    }
    
    @media (max-width: 768px) {
        .finance-hero {
            padding: 1.5rem;
            border-radius: 16px;
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
        
        .category-grid-premium {
            grid-template-columns: 1fr;
        }
        
        .summary-banner-premium {
            flex-direction: column;
            text-align: center;
            padding: 1rem 1.2rem;
        }
        
        .transaction-summary-premium {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .summary-item-premium {
            padding: 0.6rem 0.8rem;
        }
        
        .table-premium thead th,
        .table-premium tbody td {
            padding: 0.4rem 0.6rem;
            font-size: 0.65rem;
        }
        
        .modal-header-premium {
            padding: 0.8rem 1rem;
        }
        
        .modal-body-premium {
            padding: 1rem;
        }
        
        .search-bar-premium {
            max-width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .stats-grid-premium {
            grid-template-columns: 1fr;
        }
        
        .transaction-summary-premium {
            grid-template-columns: 1fr;
        }
        
        .btn-hero {
            width: 100%;
            justify-content: center;
        }
    }
</style>

{{-- ============================================= --}}
{{-- MAIN CONTENT --}}
{{-- ============================================= --}}
<div class="container-fluid px-0">

    {{-- ============================================ --}}
    {{-- HERO SECTION - MULTI-COLOR GRADIENT --}}
    {{-- ============================================ --}}
    <div class="finance-hero">
        <div class="hero-content">
            <div class="hero-left">
                <h1><i class="fas fa-boxes"></i> Inventory Management</h1>
                <p class="hero-sub">
                    <i class="fas fa-circle" style="color: #34D399; font-size: 0.4rem; vertical-align: middle;"></i>
                    Track church finances, income, expenses, and donations
                </p>
            </div>
            <div class="hero-actions">
                <button class="btn-hero btn-hero-income" data-bs-toggle="modal" data-bs-target="#incomeModal">
                    <i class="fas fa-plus-circle"></i> Income
                </button>
                <button class="btn-hero btn-hero-expense" data-bs-toggle="modal" data-bs-target="#expenseModal">
                    <i class="fas fa-minus-circle"></i> Expense
                </button>
                <button class="btn-hero btn-hero-transactions" data-bs-toggle="modal" data-bs-target="#transactionsModal">
                    <i class="fas fa-list"></i> All Transactions
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- STATS CARDS - PREMIUM --}}
    {{-- ============================================ --}}
    <div class="stats-grid-premium">
        <div class="stat-card-premium green">
            <div class="stat-top">
                <span class="stat-label">Total Income</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-down"></i></div>
            </div>
            <div class="stat-value amount-positive-premium">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> All time</div>
        </div>
        
        <div class="stat-card-premium red">
            <div class="stat-top">
                <span class="stat-label">Total Expenses</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-up"></i></div>
            </div>
            <div class="stat-value amount-negative-premium">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            <div class="stat-change negative"><i class="fas fa-arrow-down"></i> All time</div>
        </div>
        
        <div class="stat-card-premium blue">
            <div class="stat-top">
                <span class="stat-label">Net Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-calculator"></i></div>
            </div>
            <div class="stat-value {{ ($balance ?? 0) >= 0 ? 'amount-positive-premium' : 'amount-negative-premium' }}">
                {{ ($balance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($balance ?? 0), 2) }}
            </div>
            <div class="stat-change {{ ($balance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                {{ ($balance ?? 0) >= 0 ? '↑ Surplus' : '↓ Deficit' }}
            </div>
        </div>
        
        <div class="stat-card-premium purple">
            <div class="stat-top">
                <span class="stat-label">Church Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-church"></i></div>
            </div>
            <div class="stat-value {{ ($allTimeBalance ?? 0) >= 0 ? 'amount-positive-premium' : 'amount-negative-premium' }}">
                {{ ($allTimeBalance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($allTimeBalance ?? 0), 2) }}
            </div>
            <div class="stat-change {{ ($allTimeBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                {{ ($allTimeBalance ?? 0) >= 0 ? '↑ Available' : '↓ Shortfall' }}
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- SUMMARY BANNER - PREMIUM --}}
    {{-- ============================================ --}}
    <div class="summary-banner-premium">
        <div>
            <h4><i class="fas fa-chart-line me-1" style="color: #10B981;"></i> Financial Summary</h4>
            <div class="amount">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="small">Total Income</div>
        </div>
        <div style="text-align: right;">
            <div class="small">Expenses: ₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            <div class="small" style="font-weight: 700; color: {{ ($balance ?? 0) >= 0 ? '#10B981' : '#EF4444' }};">
                Net: {{ ($balance ?? 0) >= 0 ? '+' : '' }}₱{{ number_format($balance ?? 0, 2) }}
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- CATEGORY GRID - PREMIUM --}}
    {{-- ============================================ --}}
    <div class="category-grid-premium">
        <div class="category-card-premium">
            <div class="category-header-premium">
                <h6><i class="fas fa-chart-pie text-success"></i> Income Breakdown</h6>
            </div>
            @forelse(($incomeByCategory ?? []) as $category => $amount)
                <div class="category-item-premium">
                    <span class="category-name-premium">{{ $category }}</span>
                    <span class="category-amount-premium income">₱{{ number_format($amount, 2) }}</span>
                </div>
            @empty
                <div class="category-item-premium">
                    <span class="category-name-premium">No income records yet</span>
                    <span class="category-amount-premium income">₱0.00</span>
                </div>
            @endforelse
            <div class="summary-row-premium">
                <span>Total Income</span>
                <span class="amount-positive-premium">₱{{ number_format($allTimeIncome ?? 0, 2) }}</span>
            </div>
        </div>

        <div class="category-card-premium">
            <div class="category-header-premium">
                <h6><i class="fas fa-chart-pie text-danger"></i> Expense Breakdown</h6>
            </div>
            @forelse(($expenseByCategory ?? []) as $category => $amount)
                <div class="category-item-premium">
                    <span class="category-name-premium">{{ $category }}</span>
                    <span class="category-amount-premium expense">₱{{ number_format($amount, 2) }}</span>
                </div>
            @empty
                <div class="category-item-premium">
                    <span class="category-name-premium">No expense records yet</span>
                    <span class="category-amount-premium expense">₱0.00</span>
                </div>
            @endforelse
            <div class="summary-row-premium">
                <span>Total Expenses</span>
                <span class="amount-negative-premium">₱{{ number_format($allTimeExpense ?? 0, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- RECENT TRANSACTIONS TABLE - PREMIUM --}}
    {{-- ============================================ --}}
    <div class="table-container-premium">
        <div class="table-header-premium">
            <h6><i class="fas fa-history"></i> Recent Transactions</h6>
            <span style="font-size: 0.65rem; color: var(--text-muted);">
                Showing latest {{ count($recentTransactions ?? []) }} entries
            </span>
        </div>
        <div class="table-responsive">
            <table class="table-premium table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentTransactions ?? collect()) as $transaction)
                    <tr>
                        <td style="color: var(--text-primary);">
                            {{ \Carbon\Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}
                        </td>
                        <td style="color: var(--text-primary);">
                            <strong>{{ $transaction->description }}</strong>
                            @if($transaction->type == 'income' && $transaction->donor_name)
                                <div class="small text-muted"><i class="fas fa-user me-1"></i> Donor: {{ $transaction->donor_name }}</div>
                            @elseif($transaction->type == 'expense' && $transaction->recipient)
                                <div class="small text-muted"><i class="fas fa-user me-1"></i> Recipient: {{ $transaction->recipient }}</div>
                            @endif
                        </td>
                        <td style="color: var(--text-primary);">
                            <span class="category-badge-premium">{{ $transaction->category ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="type-badge-premium {{ $transaction->type == 'income' ? 'badge-income-premium' : 'badge-expense-premium' }}">
                                <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }} me-1"></i>
                                {{ $transaction->type == 'income' ? 'Income' : 'Expense' }}
                            </span>
                        </td>
                        <td>
                            <strong class="{{ $transaction->type == 'income' ? 'amount-positive-premium' : 'amount-negative-premium' }}">
                                {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount, 2) }}
                            </strong>
                        </td>
                        <td style="color: var(--text-muted);">
                            {{ $transaction->remarks ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color: var(--text-muted);">
                            <i class="fas fa-receipt fa-2x mb-2 d-block" style="color: var(--text-muted);"></i>
                            <p class="mb-0" style="color: var(--text-muted);">No transactions yet</p>
                            <small style="color: var(--text-muted);">Click "Income" or "Expense" to get started</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- INCOME MODAL - PREMIUM --}}
{{-- ============================================ --}}
<div class="modal fade" id="incomeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-premium">
            <div class="modal-header modal-header-premium">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-arrow-down me-2" style="color: #10B981;"></i>
                        Record Income
                    </h5>
                    <p>Add money received by the church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 1.5rem;">
                    <input type="hidden" name="type" value="income">
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-tag"></i> Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control-premium" required 
                               placeholder="e.g., Sunday Offering, Tithes, Special Donation">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-folder"></i> Category <span class="text-danger">*</span></label>
                        <div class="category-pills-premium">
                            <div class="category-pill-premium selected" data-category="Sunday Offering" onclick="selectIncomeCategory(this, 'Sunday Offering')">
                                <i class="fas fa-church"></i> Sunday Offering
                            </div>
                            <div class="category-pill-premium" data-category="Tithes" onclick="selectIncomeCategory(this, 'Tithes')">
                                <i class="fas fa-hand-holding-heart"></i> Tithes
                            </div>
                            <div class="category-pill-premium" data-category="Special Donation" onclick="selectIncomeCategory(this, 'Special Donation')">
                                <i class="fas fa-gift"></i> Special Donation
                            </div>
                            <div class="category-pill-premium" data-category="Building Fund" onclick="selectIncomeCategory(this, 'Building Fund')">
                                <i class="fas fa-building"></i> Building Fund
                            </div>
                            <div class="category-pill-premium" data-category="Missions" onclick="selectIncomeCategory(this, 'Missions')">
                                <i class="fas fa-globe"></i> Missions
                            </div>
                            <div class="category-pill-premium" data-category="Benevolence" onclick="selectIncomeCategory(this, 'Benevolence')">
                                <i class="fas fa-hands-helping"></i> Benevolence
                            </div>
                            <div class="category-pill-premium" data-category="Thanksgiving" onclick="selectIncomeCategory(this, 'Thanksgiving')">
                                <i class="fas fa-hands-praying"></i> Thanksgiving
                            </div>
                            <div class="category-pill-premium" data-category="Rental Income" onclick="selectIncomeCategory(this, 'Rental Income')">
                                <i class="fas fa-home"></i> Rental Income
                            </div>
                            <div class="category-pill-premium" data-category="Other Income" onclick="selectIncomeCategory(this, 'Other Income')">
                                <i class="fas fa-ellipsis-h"></i> Other Income
                            </div>
                        </div>
                        <input type="hidden" name="category" id="incomeCategory" value="Sunday Offering">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-premium"><i class="fas fa-money-bill-wave"></i> Amount (₱) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text-premium">₱</span>
                                <input type="number" name="amount" step="0.01" class="form-control-premium" required 
                                       placeholder="0.00" id="incomeAmount" oninput="updateIncomePreview()" 
                                       style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-premium"><i class="fas fa-calendar"></i> Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control-premium" value="{{ date('Y-m-d') }}" 
                                   max="{{ date('Y-m-d') }}" required>
                            <small class="text-muted" style="font-size: 0.6rem; display: block; margin-top: 3px;">
                                <i class="fas fa-info-circle"></i> Only past or today's date allowed
                            </small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-user"></i> Donor Name</label>
                        <input type="text" name="donor_name" class="form-control-premium" placeholder="Optional - Name of the donor">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-pen"></i> Remarks / Notes</label>
                        <textarea name="remarks" class="form-control-premium" rows="2" placeholder="Additional notes about this income..." style="min-height: 50px;"></textarea>
                    </div>
                    
                    <div class="amount-preview-premium alert-success-premium">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-calculator me-2"></i> Amount to Record:</span>
                            <strong id="incomePreviewAmount" class="fs-5" style="color: #10B981;">₱0.00</strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); background: var(--bg-tertiary);">
                    <button type="button" class="btn-secondary-premium" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn-success-premium">
                        <i class="fas fa-save me-1"></i> Save Income
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- EXPENSE MODAL - PREMIUM --}}
{{-- ============================================ --}}
<div class="modal fade" id="expenseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-premium">
            <div class="modal-header modal-header-premium">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-arrow-up me-2" style="color: #EF4444;"></i>
                        Record Expense
                    </h5>
                    <p>Record money spent by the church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 1.5rem;">
                    <input type="hidden" name="type" value="expense">
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-tag"></i> Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" class="form-control-premium" required 
                               placeholder="e.g., Outreach Program, Church Supplies">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-folder"></i> Category <span class="text-danger">*</span></label>
                        <div class="category-pills-premium">
                            <div class="category-pill-premium selected" data-category="Church Help" onclick="selectExpenseCategory(this, 'Church Help')">
                                <i class="fas fa-hands-helping"></i> Church Help
                            </div>
                            <div class="category-pill-premium" data-category="Outreach" onclick="selectExpenseCategory(this, 'Outreach')">
                                <i class="fas fa-hand-holding-heart"></i> Outreach
                            </div>
                            <div class="category-pill-premium" data-category="Donation to Others" onclick="selectExpenseCategory(this, 'Donation to Others')">
                                <i class="fas fa-gift"></i> Donation
                            </div>
                            <div class="category-pill-premium" data-category="Maintenance" onclick="selectExpenseCategory(this, 'Maintenance')">
                                <i class="fas fa-tools"></i> Maintenance
                            </div>
                            <div class="category-pill-premium" data-category="Utilities" onclick="selectExpenseCategory(this, 'Utilities')">
                                <i class="fas fa-bolt"></i> Utilities
                            </div>
                            <div class="category-pill-premium" data-category="Staff Salary" onclick="selectExpenseCategory(this, 'Staff Salary')">
                                <i class="fas fa-user-tie"></i> Staff Salary
                            </div>
                            <div class="category-pill-premium" data-category="Equipment" onclick="selectExpenseCategory(this, 'Equipment')">
                                <i class="fas fa-microphone"></i> Equipment
                            </div>
                            <div class="category-pill-premium" data-category="Events" onclick="selectExpenseCategory(this, 'Events')">
                                <i class="fas fa-calendar-check"></i> Events
                            </div>
                            <div class="category-pill-premium" data-category="Other Expense" onclick="selectExpenseCategory(this, 'Other Expense')">
                                <i class="fas fa-ellipsis-h"></i> Other Expense
                            </div>
                        </div>
                        <input type="hidden" name="category" id="expenseCategory" value="Church Help">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-premium"><i class="fas fa-money-bill-wave"></i> Amount (₱) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text-premium">₱</span>
                                <input type="number" name="amount" step="0.01" class="form-control-premium" required 
                                       placeholder="0.00" id="expenseAmount" oninput="updateExpensePreview()"
                                       style="border-radius: 0 10px 10px 0;">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-premium"><i class="fas fa-calendar"></i> Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control-premium" value="{{ date('Y-m-d') }}" 
                                   max="{{ date('Y-m-d') }}" required>
                            <small class="text-muted" style="font-size: 0.6rem; display: block; margin-top: 3px;">
                                <i class="fas fa-info-circle"></i> Only past or today's date allowed
                            </small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-user"></i> Recipient / Beneficiary</label>
                        <input type="text" name="recipient" class="form-control-premium" placeholder="Optional - Who received this amount?">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-premium"><i class="fas fa-pen"></i> Remarks / Notes</label>
                        <textarea name="remarks" class="form-control-premium" rows="2" placeholder="Additional notes about this expense..." style="min-height: 50px;"></textarea>
                    </div>
                    
                    <div class="amount-preview-premium alert-info-premium">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-wallet me-2"></i> Current Balance:</span>
                            <strong id="currentBalance" style="font-family: 'Inter', sans-serif;">₱{{ number_format($allTimeBalance ?? 0, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-minus-circle me-2" style="color: #EF4444;"></i> Amount to Deduct:</span>
                            <strong id="expensePreviewAmount" style="color: #EF4444; font-family: 'Inter', sans-serif;">₱0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top" style="border-top-color: var(--border-color);">
                            <span><i class="fas fa-calculator me-2"></i> Remaining Balance:</span>
                            <strong id="remainingBalance" class="fs-5" style="color: #10B981; font-family: 'Inter', sans-serif;">₱{{ number_format($allTimeBalance ?? 0, 2) }}</strong>
                        </div>
                    </div>
                    
                    @if(($allTimeBalance ?? 0) <= 0)
                        <div class="alert-danger-premium" style="margin-top: 0.8rem;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Insufficient balance! Current balance: ₱{{ number_format($allTimeBalance ?? 0, 2) }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer" style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); background: var(--bg-tertiary);">
                    <button type="button" class="btn-secondary-premium" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn-danger-premium" id="expenseSubmitBtn" {{ ($allTimeBalance ?? 0) <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-save me-1"></i> Save Expense
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- ALL TRANSACTIONS MODAL - PREMIUM --}}
{{-- ============================================ --}}
<div class="modal fade" id="transactionsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content modal-content-premium">
            <div class="modal-header modal-header-premium">
                <div>
                    <h5 class="modal-title">
                        <i class="fas fa-list me-2" style="color: #10B981;"></i>
                        All Transactions
                    </h5>
                    <p>Complete financial history of your church</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <!-- Filter Tabs -->
                <div class="filter-tabs-premium mb-3">
                    <button class="filter-tab-premium active" onclick="filterTransactions('all', event)">All Transactions</button>
                    <button class="filter-tab-premium" onclick="filterTransactions('income', event)"><i class="fas fa-arrow-down me-1" style="color: #10B981;"></i> Income</button>
                    <button class="filter-tab-premium" onclick="filterTransactions('expense', event)"><i class="fas fa-arrow-up me-1" style="color: #EF4444;"></i> Expense</button>
                </div>
                
                <!-- Summary Stats -->
                <div class="transaction-summary-premium mb-3">
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium income-bg"><i class="fas fa-arrow-down"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Total Income</span>
                            <span class="summary-value amount-positive-premium">₱{{ number_format($allTimeIncome ?? 0, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium expense-bg"><i class="fas fa-arrow-up"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Total Expenses</span>
                            <span class="summary-value amount-negative-premium">₱{{ number_format($allTimeExpense ?? 0, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium balance-bg"><i class="fas fa-calculator"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Net Balance</span>
                            <span class="summary-value {{ ($allTimeBalance ?? 0) >= 0 ? 'amount-positive-premium' : 'amount-negative-premium' }}">
                                {{ ($allTimeBalance ?? 0) >= 0 ? '+' : '-' }} ₱{{ number_format(abs($allTimeBalance ?? 0), 2) }}
                            </span>
                        </div>
                    </div>
                    <div class="summary-item-premium">
                        <div class="summary-icon-premium total-bg"><i class="fas fa-receipt"></i></div>
                        <div class="summary-info">
                            <span class="summary-label">Total Transactions</span>
                            <span class="summary-value" id="totalTransactions">{{ count($transactions ?? []) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="search-bar-premium mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" id="transactionSearch" class="form-control-premium" 
                               placeholder="Search transactions..." 
                               onkeyup="searchTransactions()"
                               style="border-left: none; border-radius: 0 10px 10px 0;">
                    </div>
                </div>
                
                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table-premium table" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            @forelse(($transactions ?? [])->sortByDesc('date') as $transaction)
                            <tr data-type="{{ $transaction->type }}" data-search="{{ strtolower($transaction->description . ' ' . ($transaction->category ?? '') . ' ' . ($transaction->remarks ?? '')) }}">
                                <td style="color: var(--text-primary);">
                                    {{ \Carbon\Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}
                                </td>
                                <td style="color: var(--text-primary);">
                                    <strong>{{ $transaction->description }}</strong>
                                    @if($transaction->type == 'income' && $transaction->donor_name)
                                        <div class="small text-muted"><i class="fas fa-user me-1"></i> Donor: {{ $transaction->donor_name }}</div>
                                    @elseif($transaction->type == 'expense' && $transaction->recipient)
                                        <div class="small text-muted"><i class="fas fa-user me-1"></i> Recipient: {{ $transaction->recipient }}</div>
                                    @endif
                                </td>
                                <td style="color: var(--text-primary);">
                                    <span class="category-badge-premium">{{ $transaction->category ?? 'Uncategorized' }}</span>
                                </td>
                                <td>
                                    <span class="type-badge-premium {{ $transaction->type == 'income' ? 'badge-income-premium' : 'badge-expense-premium' }}">
                                        <i class="fas {{ $transaction->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }} me-1"></i>
                                        {{ $transaction->type == 'income' ? 'Income' : 'Expense' }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="{{ $transaction->type == 'income' ? 'amount-positive-premium' : 'amount-negative-premium' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount, 2) }}
                                    </strong>
                                </td>
                                <td style="color: var(--text-muted);">{{ $transaction->remarks ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: var(--text-muted);">
                                    <i class="fas fa-receipt fa-2x mb-2 d-block" style="color: var(--text-muted);"></i>
                                    <p class="mb-0" style="color: var(--text-muted);">No transactions found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color); background: var(--bg-tertiary);">
                <button class="btn-secondary-premium btn-sm" onclick="exportToCSV()" style="padding: 0.3rem 0.8rem;">
                    <i class="fas fa-file-excel me-1"></i> Export CSV
                </button>
                <button class="btn-secondary-premium btn-sm" onclick="window.print()" style="padding: 0.3rem 0.8rem;">
                    <i class="fas fa-print me-1"></i> Print
                </button>
                <button type="button" class="btn-primary-premium" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- SCRIPTS SECTION --}}
{{-- ============================================= --}}
<script>
    // Income Category Selection
    function selectIncomeCategory(element, category) {
        document.querySelectorAll('#incomeModal .category-pill-premium').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('incomeCategory').value = category;
    }
    
    // Expense Category Selection
    function selectExpenseCategory(element, category) {
        document.querySelectorAll('#expenseModal .category-pill-premium').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('expenseCategory').value = category;
    }
    
    // Update Income Preview
    function updateIncomePreview() {
        let amount = parseFloat(document.getElementById('incomeAmount')?.value) || 0;
        let preview = document.getElementById('incomePreviewAmount');
        if (preview) {
            preview.textContent = '₱' + amount.toFixed(2);
        }
    }
    
    // Update Expense Preview
    function updateExpensePreview() {
        let amount = parseFloat(document.getElementById('expenseAmount')?.value) || 0;
        let currentBalance = {{ $allTimeBalance ?? 0 }};
        let remainingBalance = currentBalance - amount;
        
        let previewAmount = document.getElementById('expensePreviewAmount');
        let remainingSpan = document.getElementById('remainingBalance');
        let submitBtn = document.getElementById('expenseSubmitBtn');
        
        if (previewAmount) {
            previewAmount.textContent = '₱' + amount.toFixed(2);
        }
        
        if (remainingSpan) {
            remainingSpan.textContent = (remainingBalance >= 0 ? '₱' : '-₱') + Math.abs(remainingBalance).toFixed(2);
            remainingSpan.style.color = remainingBalance >= 0 ? '#10B981' : '#EF4444';
        }
        
        if (submitBtn) {
            if (amount > currentBalance && currentBalance > 0) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.5';
            } else {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            }
        }
    }
    
    // Filter Transactions
    function filterTransactions(type, event) {
        if (event) {
            document.querySelectorAll('.filter-tab-premium').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');
        }
        
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (type === 'all') {
                row.style.display = '';
                visibleCount++;
            } else if (row.getAttribute('data-type') === type) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        const totalSpan = document.getElementById('totalTransactions');
        if (totalSpan) {
            totalSpan.textContent = visibleCount;
        }
    }
    
    // Search Transactions
    function searchTransactions() {
        const searchTerm = document.getElementById('transactionSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            const searchData = row.getAttribute('data-search') || '';
            if (searchData.includes(searchTerm) || searchTerm === '') {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        const totalSpan = document.getElementById('totalTransactions');
        if (totalSpan) {
            totalSpan.textContent = visibleCount;
        }
    }
    
    // Export to CSV
    function exportToCSV() {
        const rows = document.querySelectorAll('#transactionsTableBody tr');
        let csvContent = "Date,Description,Category,Type,Amount,Notes\n";
        
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const cells = row.querySelectorAll('td');
                const rowData = [];
                cells.forEach(cell => {
                    let text = cell.innerText.replace(/,/g, ';');
                    rowData.push(text);
                });
                csvContent += rowData.join(',') + "\n";
            }
        });
        
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.download = 'transactions_export.csv';
        link.click();
        URL.revokeObjectURL(url);
    }
    
    // Initialize on modal open
    document.getElementById('incomeModal')?.addEventListener('shown.bs.modal', function() {
        updateIncomePreview();
    });
    
    document.getElementById('expenseModal')?.addEventListener('shown.bs.modal', function() {
        updateExpensePreview();
    });
    
    document.getElementById('transactionsModal')?.addEventListener('shown.bs.modal', function() {
        document.getElementById('transactionSearch').value = '';
        filterTransactions('all');
    });
</script>
@endsection