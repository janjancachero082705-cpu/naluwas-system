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
    
    /* Hero Buttons */
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
    
    .btn-hero-export {
        background: var(--gradient-primary);
        box-shadow: var(--shadow-glow);
        color: white;
    }
    
    .btn-hero-export:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(79, 70, 229, 0.4);
        color: white;
    }
    
    /* Stats Grid */
    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    
    .stat-card-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
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
        color: #6b7280;
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
        color: #1a1a2e;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    
    .stat-card-premium .stat-change {
        font-size: 0.65rem;
        color: #6b7280;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
        padding: 2px 8px;
        border-radius: 20px;
        background: #f9fafb;
    }
    
    .stat-card-premium .stat-change.positive { color: #10B981; }
    .stat-card-premium .stat-change.negative { color: #EF4444; }
    
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
    
    /* Summary Banner */
    .summary-banner-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
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
        color: #6b7280;
        font-weight: 700;
    }
    
    .summary-banner-premium .amount {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1a1a2e;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
    }
    
    .summary-banner-premium .small {
        font-size: 0.7rem;
        color: #6b7280;
    }
    
    /* Category Grid */
    .category-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .category-card-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
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
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .category-header-premium h6 {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
        color: #1a1a2e;
        font-family: 'Inter', sans-serif;
    }
    
    .category-header-premium h6 i {
        margin-right: 8px;
    }
    
    .category-header-premium .date-range-badge {
        font-size: 0.6rem;
        color: #6b7280;
        background: #ffffff;
        padding: 2px 10px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .category-header-premium .date-range-badge i {
        font-size: 0.55rem;
        color: #4F46E5;
    }
    
    .category-item-premium {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }
    
    .category-item-premium:hover {
        background: #f9fafb;
        transform: translateX(4px);
    }
    
    .category-name-premium {
        font-size: 0.8rem;
        font-weight: 500;
        color: #1a1a2e;
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
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 0.85rem;
        border-top: 2px solid #e5e7eb;
        color: #1a1a2e;
        font-family: 'Inter', sans-serif;
    }
    
    /* Table Container */
    .table-container-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
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
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .table-header-premium h6 {
        color: #1a1a2e;
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
        background: #ffffff;
        border-collapse: collapse;
    }
    
    .table-premium thead th {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        color: #6b7280 !important;
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
        color: #1a1a2e !important;
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.8rem;
    }
    
    .table-premium tbody tr {
        transition: all 0.15s ease;
    }
    
    .table-premium tbody tr:hover {
        background: #f9fafb !important;
    }
    
    .table-premium tbody tr:hover td {
        background: #f9fafb !important;
    }
    
    .table-premium tbody tr.clickable-row {
        cursor: pointer;
    }
    
    .table-premium tbody tr.clickable-row:hover {
        background: rgba(79, 70, 229, 0.05) !important;
        transform: scale(1.01);
        transition: all 0.2s ease;
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
    
    .amount-positive-premium { color: #10B981 !important; }
    .amount-negative-premium { color: #EF4444 !important; }
    
    /* Modal Styles */
    .modal-content-premium {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-profile-hover);
    }
    
    .modal-header-premium {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    
    .modal-header-premium .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        font-family: 'Inter', sans-serif;
    }
    
    .modal-header-premium p {
        color: #6b7280;
        font-size: 0.75rem;
        margin: 0;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
    }
    
    /* Category Pills */
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
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        color: #4b5563;
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
    
    .form-label-premium {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: 'Inter', sans-serif;
    }
    
    .form-control-premium {
        width: 100%;
        padding: 0.5rem 0.8rem;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
        color: #1a1a2e;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    
    .form-control-premium:focus {
        outline: none;
        border-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .input-group-text-premium {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        color: #1a1a2e;
        font-size: 0.8rem;
        border-radius: 10px 0 0 10px;
    }
    
    .btn-secondary-premium {
        background: #f9fafb;
        color: #1a1a2e;
        border: 1px solid #e5e7eb;
        padding: 0.4rem 1.2rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }
    
    .btn-secondary-premium:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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
    
    /* Edit Modal - FULLY CLICKABLE */
    .edit-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(6px);
        z-index: 100001;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .edit-modal-overlay.active {
        display: flex !important;
    }
    
    .edit-modal-content {
        background: #ffffff;
        border-radius: 24px;
        padding: 35px;
        max-width: 580px;
        width: 100%;
        max-height: 95vh;
        overflow-y: auto;
        box-shadow: 0 30px 80px rgba(0,0,0,0.35);
        border: none;
        position: relative;
        z-index: 100002;
        animation: modalSlideIn 0.3s ease;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .edit-modal-content .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .edit-modal-content .modal-header-custom h3 {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        font-family: 'Inter', sans-serif;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .edit-modal-content .modal-header-custom h3 i {
        color: #4F46E5;
        font-size: 22px;
    }
    
    .edit-modal-content .modal-header-custom .close-btn {
        background: none;
        border: none;
        font-size: 28px;
        color: #9ca3af;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0 8px;
        line-height: 1;
    }
    
    .edit-modal-content .modal-header-custom .close-btn:hover {
        color: #1a1a2e;
        transform: rotate(90deg);
    }
    
    /* FULLY CLICKABLE FORM FIELDS */
    .edit-modal-content .form-group {
        margin-bottom: 18px;
    }
    
    .edit-modal-content .form-group label {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 6px;
        font-family: 'Inter', sans-serif;
        cursor: default;
    }
    
    .edit-modal-content .form-group label i {
        margin-right: 6px;
        color: #4F46E5;
        width: 16px;
    }
    
    /* Make ALL input fields clickable */
    .edit-modal-content .form-group .editable-field,
    .edit-modal-content .form-group input,
    .edit-modal-content .form-group textarea,
    .edit-modal-content .form-group select {
        width: 100% !important;
        padding: 12px 16px !important;
        border: 2px solid #d1d5db !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        color: #1a1a2e !important;
        background: #ffffff !important;
        transition: all 0.25s ease !important;
        outline: none !important;
        box-sizing: border-box !important;
        font-family: 'Inter', sans-serif !important;
        cursor: text !important;
        -webkit-appearance: none !important;
        appearance: none !important;
    }
    
    .edit-modal-content .form-group .editable-field:hover,
    .edit-modal-content .form-group input:hover,
    .edit-modal-content .form-group textarea:hover,
    .edit-modal-content .form-group select:hover {
        border-color: #4F46E5 !important;
        background: #fafaff !important;
    }
    
    .edit-modal-content .form-group .editable-field:focus,
    .edit-modal-content .form-group input:focus,
    .edit-modal-content .form-group textarea:focus,
    .edit-modal-content .form-group select:focus {
        border-color: #4F46E5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
        background: #ffffff !important;
    }
    
    .edit-modal-content .form-group textarea.editable-field,
    .edit-modal-content .form-group textarea {
        resize: vertical !important;
        min-height: 70px !important;
        line-height: 1.6 !important;
    }
    
    .edit-modal-content .form-group input[type="date"].editable-field,
    .edit-modal-content .form-group input[type="date"] {
        cursor: pointer !important;
        min-height: 48px !important;
    }
    
    .edit-modal-content .form-group input[type="number"].editable-field,
    .edit-modal-content .form-group input[type="number"] {
        -moz-appearance: textfield !important;
    }
    
    .edit-modal-content .form-group input[type="number"]::-webkit-outer-spin-button,
    .edit-modal-content .form-group input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
        margin: 0 !important;
    }
    
    /* Amount input wrapper */
    .edit-modal-content .amount-input-wrapper {
        display: flex !important;
        align-items: center !important;
        border: 2px solid #d1d5db !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        transition: all 0.25s ease !important;
        overflow: hidden !important;
    }
    
    .edit-modal-content .amount-input-wrapper:hover {
        border-color: #4F46E5 !important;
        background: #fafaff !important;
    }
    
    .edit-modal-content .amount-input-wrapper:focus-within {
        border-color: #4F46E5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
    }
    
    .edit-modal-content .amount-input-wrapper .currency-symbol {
        padding: 12px 16px !important;
        background: #f9fafb !important;
        color: #6b7280 !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        border-right: 2px solid #d1d5db !important;
        flex-shrink: 0 !important;
        font-family: 'Inter', sans-serif !important;
    }
    
    .edit-modal-content .amount-input-wrapper input {
        width: 100% !important;
        padding: 12px 16px !important;
        border: none !important;
        font-size: 15px !important;
        color: #1a1a2e !important;
        background: transparent !important;
        outline: none !important;
        box-sizing: border-box !important;
        font-family: 'Inter', sans-serif !important;
        cursor: text !important;
    }
    
    .edit-modal-content .amount-input-wrapper input:hover {
        background: transparent !important;
    }
    
    .edit-modal-content .amount-input-wrapper input:focus {
        background: transparent !important;
    }
    
    /* Type select dropdown */
    .edit-modal-content .type-select-wrapper {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }
    
    .edit-modal-content .type-select-wrapper select {
        flex: 1 !important;
        padding: 12px 16px !important;
        border: 2px solid #d1d5db !important;
        border-radius: 12px !important;
        font-size: 15px !important;
        color: #1a1a2e !important;
        background: #ffffff !important;
        transition: all 0.25s ease !important;
        outline: none !important;
        cursor: pointer !important;
        font-family: 'Inter', sans-serif !important;
        min-height: 48px !important;
        -webkit-appearance: none !important;
        appearance: none !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 16px center !important;
        padding-right: 40px !important;
    }
    
    .edit-modal-content .type-select-wrapper select:hover {
        border-color: #4F46E5 !important;
        background-color: #fafaff !important;
    }
    
    .edit-modal-content .type-select-wrapper select:focus {
        border-color: #4F46E5 !important;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
    }
    
    .edit-modal-content .type-badge-display {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 8px 18px !important;
        border-radius: 20px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        white-space: nowrap !important;
        font-family: 'Inter', sans-serif !important;
        flex-shrink: 0 !important;
    }
    
    .edit-modal-content .type-badge-display.income {
        background: rgba(16, 185, 129, 0.12) !important;
        color: #10B981 !important;
    }
    
    .edit-modal-content .type-badge-display.expense {
        background: rgba(239, 68, 68, 0.12) !important;
        color: #EF4444 !important;
    }
    
    /* Edit Modal Buttons */
    .edit-modal-actions {
        display: flex !important;
        gap: 12px !important;
        margin-top: 25px !important;
        padding-top: 22px !important;
        border-top: 2px solid #f0f0f0 !important;
    }
    
    .edit-modal-actions .btn-action {
        flex: 1 !important;
        padding: 14px 20px !important;
        border-radius: 14px !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        border: none !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        font-family: 'Inter', sans-serif !important;
        min-height: 52px !important;
    }
    
    .edit-modal-actions .btn-action:hover {
        transform: translateY(-2px) !important;
    }
    
    .edit-modal-actions .btn-action:active {
        transform: scale(0.97) !important;
    }
    
    .btn-save-edit {
        background: linear-gradient(135deg, #10B981, #34D399) !important;
        color: white !important;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3) !important;
        flex: 2 !important;
    }
    
    .btn-save-edit:hover {
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.4) !important;
    }
    
    .btn-cancel-edit {
        background: #f3f4f6 !important;
        color: #1a1a2e !important;
        border: 2px solid #d1d5db !important;
        flex: 1 !important;
    }
    
    .btn-cancel-edit:hover {
        background: #e5e7eb !important;
    }
    
    .btn-delete-from-edit {
        background: linear-gradient(135deg, #EF4444, #F87171) !important;
        color: white !important;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.25) !important;
        flex: 1 !important;
    }
    
    .btn-delete-from-edit:hover {
        box-shadow: 0 8px 32px rgba(239, 68, 68, 0.35) !important;
    }
    
    /* Export Modal */
    .export-modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 99999;
        align-items: center;
        justify-content: center;
    }
    
    .export-modal-overlay.active {
        display: flex;
    }
    
    .export-modal-content {
        background: #ffffff;
        border-radius: 20px;
        padding: 2rem;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        border: 1px solid #e5e7eb;
    }
    
    .export-modal-content .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .export-modal-content .modal-header-custom h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        font-family: 'Inter', sans-serif;
    }
    
    .export-modal-content .modal-header-custom h3 i {
        color: #4F46E5;
        margin-right: 8px;
    }
    
    .export-modal-content .modal-header-custom .close-btn {
        background: none;
        border: none;
        font-size: 1.8rem;
        color: #9ca3af;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .export-modal-content .modal-header-custom .close-btn:hover {
        color: #1a1a2e;
        transform: rotate(90deg);
    }
    
    .export-section-group {
        margin-bottom: 1.5rem;
    }
    
    .export-section-group label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #6b7280;
        display: block;
        margin-bottom: 0.5rem;
        font-family: 'Inter', sans-serif;
    }
    
    .export-section-group .checkbox-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }
    
    .export-section-group .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.5rem 0.8rem;
        border-radius: 10px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .export-section-group .checkbox-item:hover {
        border-color: #4F46E5;
        background: rgba(79,70,229,0.05);
    }
    
    .export-section-group .checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #4F46E5;
        cursor: pointer;
        flex-shrink: 0;
    }
    
    .export-section-group .checkbox-item label {
        font-size: 0.75rem;
        font-weight: 500;
        color: #1a1a2e;
        margin: 0;
        cursor: pointer;
        text-transform: none;
        letter-spacing: 0;
    }
    
    .export-section-group .checkbox-item label i {
        margin-right: 6px;
        font-size: 0.8rem;
    }
    
    .select-all-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.5rem 0.8rem;
        border-radius: 10px;
        background: rgba(79,70,229,0.05);
        border: 1px solid rgba(79,70,229,0.15);
        margin-bottom: 1rem;
        cursor: pointer;
    }
    
    .select-all-row input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #4F46E5;
        cursor: pointer;
    }
    
    .select-all-row label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
        cursor: pointer;
    }
    
    .export-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .export-actions .btn-export {
        flex: 1;
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-family: 'Inter', sans-serif;
    }
    
    .btn-export-pdf {
        background: var(--gradient-primary);
        color: white;
        box-shadow: 0 4px 16px rgba(79,70,229,0.3);
    }
    
    .btn-export-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(79,70,229,0.4);
    }
    
    .btn-export-print {
        background: var(--gradient-success);
        color: white;
        box-shadow: 0 4px 16px rgba(16,185,129,0.3);
    }
    
    .btn-export-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(16,185,129,0.4);
    }
    
    .btn-export-cancel {
        background: #f9fafb;
        color: #1a1a2e;
        border: 1px solid #e5e7eb;
    }
    
    .btn-export-cancel:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
    }
    
    /* Transaction Summary */
    .transaction-summary-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
    }
    
    .summary-item-premium {
        background: #f9fafb;
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        border: 1px solid #e5e7eb;
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
    
    .filter-tabs-premium {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0.75rem;
    }
    
    .filter-tab-premium {
        padding: 0.4rem 1.2rem;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        background: transparent;
        color: #4b5563;
        font-size: 0.7rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }
    
    .filter-tab-premium:hover {
        background: #f9fafb;
        color: #1a1a2e;
        transform: translateY(-2px);
    }
    
    .filter-tab-premium.active {
        background: #10B981;
        color: white;
        border-color: #10B981;
        box-shadow: 0 4px 16px rgba(16, 185, 129, 0.3);
    }
    
    .search-bar-premium {
        max-width: 320px;
    }
    
    .search-bar-premium .input-group-text {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: #6b7280;
        font-size: 0.75rem;
    }
    
    .search-bar-premium .form-control {
        background: #ffffff;
        border-left: none;
        border-radius: 0 10px 10px 0;
        padding: 0.4rem 0.8rem;
        font-size: 0.75rem;
    }
    
    .search-bar-premium .form-control:focus {
        border-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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
    
    .action-btns-premium {
        display: flex;
        gap: 4px;
        align-items: center;
        justify-content: center;
    }
    
    .btn-edit-premium {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: transparent;
        color: #3B82F6;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
    
    .btn-edit-premium:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3B82F6;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
    }
    
    .btn-delete-premium {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: transparent;
        color: #EF4444;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }
    
    .btn-delete-premium:hover {
        background: rgba(239, 68, 68, 0.1);
        border-color: #EF4444;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.15);
    }
    
    .category-badge-premium {
        background: #f9fafb;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 0.65rem;
        border: 1px solid #e5e7eb;
        color: #4b5563;
    }
    
    .amount-preview-premium {
        background: #f9fafb;
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        margin-top: 1rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .amount-preview-premium:hover {
        border-color: #10B981;
    }
    
    .alert-success-premium {
        background: rgba(16, 185, 129, 0.08);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.15);
        border-radius: 10px;
        padding: 0.6rem 1rem;
    }
    
    .alert-info-premium {
        background: rgba(59, 130, 246, 0.08);
        color: #1a1a2e;
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
    
    /* PDF Export */
    .pdf-export-wrapper {
        display: none;
        background: white;
        padding: 30px;
        max-width: 1100px;
        margin: 0 auto;
        font-family: 'Inter', Arial, sans-serif;
    }
    
    .pdf-export-wrapper .pdf-header {
        text-align: center;
        padding-bottom: 20px;
        margin-bottom: 25px;
        border-bottom: 2px solid #4F46E5;
    }
    
    .pdf-export-wrapper .pdf-header h1 {
        font-size: 24px;
        font-weight: 800;
        color: #4F46E5;
        margin: 0 0 5px 0;
    }
    
    .pdf-export-wrapper .pdf-header p {
        color: #666;
        margin: 0;
        font-size: 14px;
    }
    
    .pdf-export-wrapper .pdf-header .pdf-date {
        font-size: 12px;
        color: #999;
        margin-top: 5px;
    }
    
    .pdf-export-wrapper .pdf-section {
        margin-bottom: 25px;
        page-break-inside: avoid;
    }
    
    .pdf-export-wrapper .pdf-section .pdf-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #4F46E5;
        padding-bottom: 8px;
        margin-bottom: 12px;
        border-bottom: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .pdf-export-wrapper .pdf-section .pdf-section-title i {
        color: #4F46E5;
    }
    
    .pdf-export-wrapper .pdf-section .pdf-section-title .pdf-date-badge {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        background: #f9fafb;
        padding: 2px 12px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
    }
    
    .pdf-export-wrapper .pdf-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    
    .pdf-export-wrapper .pdf-stat-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 15px 20px;
        text-align: center;
    }
    
    .pdf-export-wrapper .pdf-stat-card .pdf-stat-value {
        font-size: 22px;
        font-weight: 800;
        color: #1a1a2e;
    }
    
    .pdf-export-wrapper .pdf-stat-card .pdf-stat-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .pdf-export-wrapper .pdf-stat-card .pdf-stat-change {
        font-size: 11px;
        font-weight: 600;
        margin-top: 4px;
    }
    
    .pdf-export-wrapper .pdf-stat-card .pdf-stat-change.positive { color: #10B981; }
    .pdf-export-wrapper .pdf-stat-card .pdf-stat-change.negative { color: #EF4444; }
    
    .pdf-export-wrapper .pdf-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    
    .pdf-export-wrapper .pdf-table thead th {
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
        padding: 8px 12px;
        text-align: left;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        letter-spacing: 0.5px;
    }
    
    .pdf-export-wrapper .pdf-table tbody td {
        padding: 8px 12px;
        border-bottom: 1px solid #f0f0f0;
        color: #1a1a2e;
    }
    
    .pdf-export-wrapper .pdf-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .pdf-export-wrapper .pdf-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .pdf-export-wrapper .pdf-badge.income {
        background: #d1fae5;
        color: #065f46;
    }
    
    .pdf-export-wrapper .pdf-badge.expense {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .pdf-export-wrapper .pdf-footer {
        text-align: center;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
        font-size: 12px;
        color: #999;
    }
    
    .pdf-export-wrapper .pdf-footer strong {
        color: #4F46E5;
    }
    
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
        
        .modal-body {
            padding: 1rem;
        }
        
        .search-bar-premium {
            max-width: 100%;
        }
        
        .export-section-group .checkbox-grid {
            grid-template-columns: 1fr;
        }
        
        .export-actions {
            flex-direction: column;
        }
        
        .edit-modal-content {
            padding: 25px 20px;
            border-radius: 20px;
        }
        
        .edit-modal-actions {
            flex-direction: column;
        }
        
        .edit-modal-actions .btn-action {
            flex: none;
            width: 100%;
        }
        
        .edit-modal-content .type-select-wrapper {
            flex-direction: column;
            align-items: stretch;
        }
        
        .edit-modal-content .type-select-wrapper select {
            flex: none;
        }
        
        .edit-modal-content .type-badge-display {
            align-self: flex-start;
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
        
        .edit-modal-content {
            padding: 20px 16px;
        }
        
        .edit-modal-content .modal-header-custom h3 {
            font-size: 18px;
        }
    }
</style>

{{-- ============================================= --}}
{{-- MAIN CONTENT --}}
{{-- ============================================= --}}
<div class="container-fluid px-0" id="reportContent">
    {{-- HERO SECTION --}}
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
                <button class="btn-hero btn-hero-export" onclick="openExportModal()">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="stats-grid-premium" id="statsSection">
        <div class="stat-card-premium green">
            <div class="stat-top">
                <span class="stat-label">Total Income</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-down"></i></div>
            </div>
            <div class="stat-value amount-positive-premium" id="totalIncome">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="stat-change positive"><i class="fas fa-arrow-up"></i> All time</div>
        </div>
        
        <div class="stat-card-premium red">
            <div class="stat-top">
                <span class="stat-label">Total Expenses</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-up"></i></div>
            </div>
            <div class="stat-value amount-negative-premium" id="totalExpense">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            <div class="stat-change negative"><i class="fas fa-arrow-down"></i> All time</div>
        </div>
        
        <div class="stat-card-premium blue">
            <div class="stat-top">
                <span class="stat-label">Net Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-calculator"></i></div>
            </div>
            <div class="stat-value {{ ($balance ?? 0) >= 0 ? 'amount-positive-premium' : 'amount-negative-premium' }}" id="netBalance">
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
            <div class="stat-value {{ ($allTimeBalance ?? 0) >= 0 ? 'amount-positive-premium' : 'amount-negative-premium' }}" id="churchBalance">
                {{ ($allTimeBalance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($allTimeBalance ?? 0), 2) }}
            </div>
            <div class="stat-change {{ ($allTimeBalance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                {{ ($allTimeBalance ?? 0) >= 0 ? '↑ Available' : '↓ Shortfall' }}
            </div>
        </div>
    </div>

    {{-- SUMMARY BANNER --}}
    <div class="summary-banner-premium" id="summarySection">
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

    {{-- CATEGORY GRID --}}
    <div class="category-grid-premium" id="categorySection">
        <div class="category-card-premium" id="incomeCategoryCard">
            <div class="category-header-premium">
                <h6><i class="fas fa-chart-pie text-success"></i> Income Breakdown</h6>
                <span class="date-range-badge">
                    <i class="fas fa-calendar-alt"></i>
                    @php
                        $incomeDates = [];
                        if(isset($incomeByCategory) && !empty($incomeByCategory)) {
                            if(isset($recentTransactions)) {
                                foreach($recentTransactions as $t) {
                                    if($t->type == 'income' && $t->date) {
                                        $incomeDates[] = $t->date;
                                    }
                                }
                            }
                        }
                        if(!empty($incomeDates)) {
                            sort($incomeDates);
                            $firstIncome = $incomeDates[0];
                            $lastIncome = end($incomeDates);
                            echo \Carbon\Carbon::parse($firstIncome)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($lastIncome)->format('M d, Y');
                        } else {
                            echo 'No records yet';
                        }
                    @endphp
                </span>
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

        <div class="category-card-premium" id="expenseCategoryCard">
            <div class="category-header-premium">
                <h6><i class="fas fa-chart-pie text-danger"></i> Expense Breakdown</h6>
                <span class="date-range-badge">
                    <i class="fas fa-calendar-alt"></i>
                    @php
                        $expenseDates = [];
                        if(isset($expenseByCategory) && !empty($expenseByCategory)) {
                            if(isset($recentTransactions)) {
                                foreach($recentTransactions as $t) {
                                    if($t->type == 'expense' && $t->date) {
                                        $expenseDates[] = $t->date;
                                    }
                                }
                            }
                        }
                        if(!empty($expenseDates)) {
                            sort($expenseDates);
                            $firstExpense = $expenseDates[0];
                            $lastExpense = end($expenseDates);
                            echo \Carbon\Carbon::parse($firstExpense)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($lastExpense)->format('M d, Y');
                        } else {
                            echo 'No records yet';
                        }
                    @endphp
                </span>
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

    {{-- RECENT TRANSACTIONS TABLE --}}
    <div class="table-container-premium" id="transactionsSection">
        <div class="table-header-premium">
            <h6><i class="fas fa-history"></i> Recent Transactions</h6>
            <span style="font-size: 0.65rem; color: #6b7280;">
                Showing latest {{ count($recentTransactions ?? []) }} entries
            </span>
        </div>
        <div class="table-responsive">
            <table class="table-premium table" id="recentTransactionsTable">
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
                        <td style="color: #1a1a2e;">
                            {{ \Carbon\Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}
                        </td>
                        <td style="color: #1a1a2e;">
                            <strong>{{ $transaction->description }}</strong>
                            @if($transaction->type == 'income' && $transaction->donor_name)
                                <div class="small text-muted"><i class="fas fa-user me-1"></i> Donor: {{ $transaction->donor_name }}</div>
                            @elseif($transaction->type == 'expense' && $transaction->recipient)
                                <div class="small text-muted"><i class="fas fa-user me-1"></i> Recipient: {{ $transaction->recipient }}</div>
                            @endif
                        </td>
                        <td style="color: #1a1a2e;">
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
                        <td style="color: #6b7280;">
                            {{ $transaction->remarks ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color: #6b7280;">
                            <i class="fas fa-receipt fa-2x mb-2 d-block" style="color: #6b7280;"></i>
                            <p class="mb-0" style="color: #6b7280;">No transactions yet</p>
                            <small style="color: #6b7280;">Click "Income" or "Expense" to get started</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- EXPORT MODAL --}}
{{-- ============================================ --}}
<div class="export-modal-overlay" id="exportModal">
    <div class="export-modal-content">
        <div class="modal-header-custom">
            <h3><i class="fas fa-file-export"></i> Export Inventory Report</h3>
            <button class="close-btn" onclick="closeExportModal()">&times;</button>
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <p style="color: #6b7280; font-size: 0.85rem; margin: 0;">
                Select the sections you want to include in your inventory report.
            </p>
        </div>
        
        <div class="export-section-group">
            <div class="select-all-row" onclick="toggleAllSections()">
                <input type="checkbox" id="selectAll" checked>
                <label for="selectAll"><i class="fas fa-check-circle"></i> Select All Sections</label>
            </div>
            
            <div class="checkbox-grid">
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="stats" checked>
                    <label><i class="fas fa-chart-pie"></i> Stats Cards</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="summary" checked>
                    <label><i class="fas fa-chart-line"></i> Summary</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="categories" checked>
                    <label><i class="fas fa-tags"></i> Categories</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="transactions" checked>
                    <label><i class="fas fa-list"></i> Recent Transactions</label>
                </div>
            </div>
        </div>
        
        <div style="padding: 0.8rem 1rem; background: rgba(79,70,229,0.05); border-radius: 10px; border: 1px solid rgba(79,70,229,0.1); margin-bottom: 1.5rem;">
            <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">
                <i class="fas fa-info-circle" style="color: #4F46E5;"></i> 
                Only the sections you select will appear in the exported PDF.
            </p>
        </div>
        
        <div class="export-actions">
            <button class="btn-export btn-export-cancel" onclick="closeExportModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button class="btn-export btn-export-print" onclick="exportPrint()">
                <i class="fas fa-print"></i> Print
            </button>
            <button class="btn-export btn-export-pdf" onclick="exportPDF()">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- EDIT TRANSACTION MODAL - FULLY CLICKABLE FIELDS --}}
{{-- ============================================ --}}
<div class="edit-modal-overlay" id="editModal">
    <div class="edit-modal-content">
        <div class="modal-header-custom">
            <h3><i class="fas fa-edit"></i> Edit Transaction</h3>
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
        </div>
        
        <form id="editTransactionForm" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="editTransactionId" name="transaction_id">
            
            <!-- DESCRIPTION - Clickable -->
            <div class="form-group">
                <label for="editDescription"><i class="fas fa-tag"></i> Description <span style="color:#EF4444;">*</span></label>
                <input type="text" id="editDescription" name="description" required 
                       class="form-control editable-field" 
                       placeholder="Enter description"
                       autocomplete="off">
            </div>
            
            <!-- CATEGORY - Clickable -->
            <div class="form-group">
                <label for="editCategory"><i class="fas fa-folder"></i> Category <span style="color:#EF4444;">*</span></label>
                <input type="text" id="editCategory" name="category" required 
                       class="form-control editable-field"
                       placeholder="Enter category"
                       autocomplete="off">
            </div>
            
            <!-- AMOUNT - Clickable -->
            <div class="form-group">
                <label for="editAmount"><i class="fas fa-money-bill-wave"></i> Amount (₱) <span style="color:#EF4444;">*</span></label>
                <div class="amount-input-wrapper">
                    <span class="currency-symbol">₱</span>
                    <input type="number" id="editAmount" name="amount" step="0.01" required 
                           placeholder="0.00"
                           autocomplete="off">
                </div>
            </div>
            
            <!-- DATE - Clickable -->
            <div class="form-group">
                <label for="editDate"><i class="fas fa-calendar"></i> Date <span style="color:#EF4444;">*</span></label>
                <input type="date" id="editDate" name="date" required 
                       class="form-control editable-field">
            </div>
            
            <!-- TYPE - Clickable -->
            <div class="form-group">
                <label><i class="fas fa-info-circle"></i> Type</label>
                <div class="type-select-wrapper">
                    <select id="editType" name="type" required>
                        <option value="income">Income</option>
                        <option value="expense">Expense</option>
                    </select>
                    <span id="editTypeDisplay" class="type-badge-display income">
                        <i class="fas fa-arrow-down"></i> Income
                    </span>
                </div>
            </div>
            
            <!-- DONOR NAME - Clickable -->
            <div id="editDonorGroup" class="form-group">
                <label for="editDonorName"><i class="fas fa-user"></i> Donor Name</label>
                <input type="text" id="editDonorName" name="donor_name" 
                       class="form-control editable-field"
                       placeholder="Donor name (optional)"
                       autocomplete="off">
            </div>
            
            <!-- RECIPIENT - Clickable -->
            <div id="editRecipientGroup" class="form-group" style="display:none;">
                <label for="editRecipient"><i class="fas fa-user"></i> Recipient / Beneficiary</label>
                <input type="text" id="editRecipient" name="recipient" 
                       class="form-control editable-field"
                       placeholder="Recipient name (optional)"
                       autocomplete="off">
            </div>
            
            <!-- REMARKS - Clickable -->
            <div class="form-group">
                <label for="editRemarks"><i class="fas fa-pen"></i> Remarks / Notes</label>
                <textarea id="editRemarks" name="remarks" rows="3" 
                          class="form-control editable-field"
                          placeholder="Additional notes..."></textarea>
            </div>
            
            <!-- BUTTONS -->
            <div class="edit-modal-actions">
                <button type="button" class="btn-action btn-cancel-edit" onclick="closeEditModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn-action btn-delete-from-edit" onclick="deleteFromEdit()">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
                <button type="submit" class="btn-action btn-save-edit">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ============================================ --}}
{{-- INCOME MODAL --}}
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
                <div class="modal-body">
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
                <div class="modal-footer">
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
{{-- EXPENSE MODAL --}}
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
                <div class="modal-body">
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
                        <div class="d-flex justify-content-between pt-2 border-top" style="border-top-color: #e5e7eb;">
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
                <div class="modal-footer">
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
{{-- ALL TRANSACTIONS MODAL - WITH EDIT/DELETE & CLICKABLE ROWS --}}
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
                                <th style="width: 100px; text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="transactionsTableBody">
                            @forelse(($transactions ?? [])->sortByDesc('date') as $transaction)
                            <tr data-type="{{ $transaction->type }}" data-search="{{ strtolower($transaction->description . ' ' . ($transaction->category ?? '') . ' ' . ($transaction->remarks ?? '')) }}" data-id="{{ $transaction->id }}" class="clickable-row">
                                <td style="color: #1a1a2e;">
                                    {{ \Carbon\Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d, Y') }}
                                </td>
                                <td style="color: #1a1a2e;">
                                    <strong>{{ $transaction->description }}</strong>
                                    @if($transaction->type == 'income' && $transaction->donor_name)
                                        <div class="small text-muted"><i class="fas fa-user me-1"></i> Donor: {{ $transaction->donor_name }}</div>
                                    @elseif($transaction->type == 'expense' && $transaction->recipient)
                                        <div class="small text-muted"><i class="fas fa-user me-1"></i> Recipient: {{ $transaction->recipient }}</div>
                                    @endif
                                </td>
                                <td style="color: #1a1a2e;">
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
                                <td style="color: #6b7280;">{{ $transaction->remarks ?? '—' }}</td>
                                <td style="text-align: center;">
                                    <div class="action-btns-premium">
                                        <button class="btn-edit-premium" onclick="event.stopPropagation(); openEditModal({{ $transaction->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-delete-premium" onclick="event.stopPropagation(); confirmDelete({{ $transaction->id }})" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4" style="color: #6b7280;">
                                    <i class="fas fa-receipt fa-2x mb-2 d-block" style="color: #6b7280;"></i>
                                    <p class="mb-0" style="color: #6b7280;">No transactions found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Click hint -->
                <div style="margin-top: 0.5rem; font-size: 0.65rem; color: #6b7280; text-align: center;">
                    <i class="fas fa-mouse-pointer me-1"></i> Click on any row to edit the transaction
                </div>
            </div>
            <div class="modal-footer" style="padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; background: #f9fafb;">
                <button type="button" class="btn-primary-premium" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- PDF EXPORT CONTAINER --}}
{{-- ============================================= --}}
<div class="pdf-export-wrapper" id="pdfExportContainer">
    <div class="pdf-header">
        <h1>Inventory Management Report</h1>
        <p>Church financial overview - Income, Expenses, and Transactions</p>
        <div class="pdf-date">Generated: {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</div>
    </div>
    
    <div id="pdfContent">
        <div class="pdf-section" id="pdf-stats">
            <div class="pdf-section-title"><i class="fas fa-chart-pie"></i> Financial Overview</div>
            <div class="pdf-stats-grid" id="pdfStatsGrid"></div>
        </div>
        
        <div class="pdf-section" id="pdf-summary" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-chart-line"></i> Summary</div>
            <div id="pdfSummaryContent"></div>
        </div>
        
        <div class="pdf-section" id="pdf-categories" style="display:none;">
            <div class="pdf-section-title">
                <i class="fas fa-tags"></i> Category Breakdown
                <span class="pdf-date-badge" id="pdfCategoryDateRange">
                    @php
                        $allDates = [];
                        if(isset($recentTransactions)) {
                            foreach($recentTransactions as $t) {
                                if($t->date) {
                                    $allDates[] = $t->date;
                                }
                            }
                        }
                        if(!empty($allDates)) {
                            sort($allDates);
                            echo \Carbon\Carbon::parse($allDates[0])->format('M d, Y') . ' - ' . \Carbon\Carbon::parse(end($allDates))->format('M d, Y');
                        } else {
                            echo 'No records yet';
                        }
                    @endphp
                </span>
            </div>
            <div id="pdfCategoriesContent"></div>
        </div>
        
        <div class="pdf-section" id="pdf-transactions" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-list"></i> Recent Transactions</div>
            <table class="pdf-table" id="pdfTransactionsTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th style="text-align:right;">Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody id="pdfTransactionsBody"></tbody>
            </table>
        </div>
    </div>
    
    <div class="pdf-footer">
        Generated by <strong>TINC Church Management System</strong> • {{ \Carbon\Carbon::now()->format('Y') }}
    </div>
</div>

{{-- ============================================= --}}
{{-- SCRIPTS --}}
{{-- ============================================= --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ============================================
    // CATEGORY SELECTION
    // ============================================
    function selectIncomeCategory(element, category) {
        document.querySelectorAll('#incomeModal .category-pill-premium').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('incomeCategory').value = category;
    }
    
    function selectExpenseCategory(element, category) {
        document.querySelectorAll('#expenseModal .category-pill-premium').forEach(pill => {
            pill.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('expenseCategory').value = category;
    }
    
    // ============================================
    // UPDATE PREVIEWS
    // ============================================
    function updateIncomePreview() {
        let amount = parseFloat(document.getElementById('incomeAmount')?.value) || 0;
        let preview = document.getElementById('incomePreviewAmount');
        if (preview) {
            preview.textContent = '₱' + amount.toFixed(2);
        }
    }
    
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
    
    // ============================================
    // EXPORT MODAL
    // ============================================
    function openExportModal() {
        document.getElementById('exportModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeExportModal() {
        document.getElementById('exportModal').classList.remove('active');
        document.body.style.overflow = '';
    }
    
    function toggleAllSections() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.section-checkbox');
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    }
    
    document.querySelectorAll('.section-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const allChecked = document.querySelectorAll('.section-checkbox:checked').length === document.querySelectorAll('.section-checkbox').length;
            document.getElementById('selectAll').checked = allChecked;
        });
    });
    
    function getSelectedSections() {
        const selected = [];
        document.querySelectorAll('.section-checkbox:checked').forEach(cb => {
            selected.push(cb.value);
        });
        return selected;
    }
    
    // ============================================
    // BUILD PDF CONTENT
    // ============================================
    function buildPDFContent(sections) {
        if (sections.includes('stats')) {
            document.getElementById('pdf-stats').style.display = 'block';
            const grid = document.getElementById('pdfStatsGrid');
            const stats = [
                { label: 'Total Income', value: document.getElementById('totalIncome')?.innerText || '₱0', change: 'Money received', positive: true },
                { label: 'Total Expenses', value: document.getElementById('totalExpense')?.innerText || '₱0', change: 'Money spent', positive: false },
                { label: 'Net Balance', value: document.getElementById('netBalance')?.innerText || '₱0', change: 'Surplus', positive: true },
                { label: 'Church Balance', value: document.getElementById('churchBalance')?.innerText || '₱0', change: 'Available', positive: true }
            ];
            grid.innerHTML = stats.map(s => `
                <div class="pdf-stat-card">
                    <div class="pdf-stat-label">${s.label}</div>
                    <div class="pdf-stat-value">${s.value}</div>
                    <div class="pdf-stat-change ${s.positive ? 'positive' : 'negative'}">${s.change}</div>
                </div>
            `).join('');
        } else {
            document.getElementById('pdf-stats').style.display = 'none';
        }
        
        if (sections.includes('summary')) {
            document.getElementById('pdf-summary').style.display = 'block';
            const summary = document.getElementById('pdfSummaryContent');
            const income = document.getElementById('totalIncome')?.innerText || '₱0';
            const expense = document.getElementById('totalExpense')?.innerText || '₱0';
            const balance = document.getElementById('netBalance')?.innerText || '₱0';
            summary.innerHTML = `
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:15px;">
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px 20px;text-align:center;">
                        <div style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">Total Income</div>
                        <div style="font-size:22px;font-weight:800;color:#10B981;">${income}</div>
                    </div>
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px 20px;text-align:center;">
                        <div style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">Total Expenses</div>
                        <div style="font-size:22px;font-weight:800;color:#EF4444;">${expense}</div>
                    </div>
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px 20px;text-align:center;">
                        <div style="font-size:11px;text-transform:uppercase;color:#6b7280;font-weight:600;">Net Balance</div>
                        <div style="font-size:22px;font-weight:800;color:#4F46E5;">${balance}</div>
                    </div>
                </div>
            `;
        } else {
            document.getElementById('pdf-summary').style.display = 'none';
        }
        
        if (sections.includes('categories')) {
            document.getElementById('pdf-categories').style.display = 'block';
            const content = document.getElementById('pdfCategoriesContent');
            
            let incomeHtml = '<div style="margin-bottom:15px;"><h4 style="font-size:14px;color:#10B981;margin:0 0 10px 0;">Income Categories</h4>';
            const incomeItems = document.querySelectorAll('#incomeCategoryCard .category-item-premium');
            if (incomeItems.length > 0) {
                incomeHtml += '<table class="pdf-table"><thead><tr><th>Category</th><th style="text-align:right;">Amount</th></tr></thead><tbody>';
                incomeItems.forEach(item => {
                    const name = item.querySelector('.category-name-premium')?.innerText || '';
                    const amount = item.querySelector('.category-amount-premium')?.innerText || '₱0.00';
                    if (!name.includes('No income')) {
                        incomeHtml += `<tr><td>${name}</td><td style="text-align:right;color:#10B981;">${amount}</td></tr>`;
                    }
                });
                const total = document.querySelector('#incomeCategoryCard .summary-row-premium .amount-positive-premium')?.innerText || '₱0.00';
                incomeHtml += `<tr style="font-weight:700;border-top:2px solid #e5e7eb;"><td>Total Income</td><td style="text-align:right;color:#10B981;">${total}</td></tr>`;
                incomeHtml += '</tbody></table>';
            } else {
                incomeHtml += '<p style="color:#999;">No income records yet</p>';
            }
            incomeHtml += '</div>';
            
            let expenseHtml = '<div><h4 style="font-size:14px;color:#EF4444;margin:0 0 10px 0;">Expense Categories</h4>';
            const expenseItems = document.querySelectorAll('#expenseCategoryCard .category-item-premium');
            if (expenseItems.length > 0) {
                expenseHtml += '<table class="pdf-table"><thead><tr><th>Category</th><th style="text-align:right;">Amount</th></tr></thead><tbody>';
                expenseItems.forEach(item => {
                    const name = item.querySelector('.category-name-premium')?.innerText || '';
                    const amount = item.querySelector('.category-amount-premium')?.innerText || '₱0.00';
                    if (!name.includes('No expense')) {
                        expenseHtml += `<tr><td>${name}</td><td style="text-align:right;color:#EF4444;">${amount}</td></tr>`;
                    }
                });
                const total = document.querySelector('#expenseCategoryCard .summary-row-premium .amount-negative-premium')?.innerText || '₱0.00';
                expenseHtml += `<tr style="font-weight:700;border-top:2px solid #e5e7eb;"><td>Total Expenses</td><td style="text-align:right;color:#EF4444;">${total}</td></tr>`;
                expenseHtml += '</tbody></table>';
            } else {
                expenseHtml += '<p style="color:#999;">No expense records yet</p>';
            }
            expenseHtml += '</div>';
            
            content.innerHTML = incomeHtml + expenseHtml;
        } else {
            document.getElementById('pdf-categories').style.display = 'none';
        }
        
        if (sections.includes('transactions')) {
            document.getElementById('pdf-transactions').style.display = 'block';
            const body = document.getElementById('pdfTransactionsBody');
            const rows = document.querySelectorAll('#recentTransactionsTable tbody tr');
            let html = '';
            rows.forEach(row => {
                if (row.querySelector('td') && !row.innerText.includes('No transactions')) {
                    const cells = row.querySelectorAll('td');
                    const type = cells[3]?.innerText.trim() || '';
                    const isIncome = type.includes('Income');
                    html += `
                        <tr>
                            <td>${cells[0]?.innerText || ''}</td>
                            <td>${cells[1]?.innerText || ''}</td>
                            <td>${cells[2]?.innerText || ''}</td>
                            <td><span class="pdf-badge ${isIncome ? 'income' : 'expense'}">${isIncome ? 'Income' : 'Expense'}</span></td>
                            <td style="text-align:right; font-weight:700; color:${isIncome ? '#10B981' : '#EF4444'};">${cells[4]?.innerText || ''}</td>
                            <td>${cells[5]?.innerText || ''}</td>
                        </tr>
                    `;
                }
            });
            body.innerHTML = html || '<tr><td colspan="6" style="text-align:center; color:#999; padding:20px;">No transactions found</td></tr>';
        } else {
            document.getElementById('pdf-transactions').style.display = 'none';
        }
    }
    
    // ============================================
    // EXPORT FUNCTIONS
    // ============================================
    function exportPrint() {
        const sections = getSelectedSections();
        if (sections.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one section to export.',
                confirmButtonColor: '#4F46E5'
            });
            return;
        }
        
        closeExportModal();
        buildPDFContent(sections);
        const container = document.getElementById('pdfExportContainer');
        container.style.display = 'block';
        
        Swal.fire({
            title: 'Preparing Print...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        setTimeout(() => {
            Swal.close();
            window.print();
            setTimeout(() => {
                container.style.display = 'none';
            }, 1000);
        }, 500);
    }
    
    function exportPDF() {
        const sections = getSelectedSections();
        if (sections.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one section to export.',
                confirmButtonColor: '#4F46E5'
            });
            return;
        }
        
        closeExportModal();
        buildPDFContent(sections);
        const container = document.getElementById('pdfExportContainer');
        container.style.display = 'block';
        
        Swal.fire({
            title: 'Generating PDF...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        const opt = {
            margin: [10, 10, 10, 10],
            filename: 'Inventory_Report_' + new Date().toISOString().slice(0,10) + '.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, letterRendering: true, logging: false, backgroundColor: '#ffffff' },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        html2pdf().set(opt).from(container).save().then(function() {
            container.style.display = 'none';
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'PDF Exported!',
                text: 'Your inventory report has been downloaded successfully.',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }).catch(function(err) {
            container.style.display = 'none';
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: err.message || 'Something went wrong. Please try again.',
                confirmButtonColor: '#EF4444'
            });
        });
    }
    
    // ============================================
    // EDIT TRANSACTION - FULLY WORKING WITH MONEY UPDATE
    // ============================================
    let currentEditId = null;
    
    function openEditModal(id) {
        currentEditId = id;
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        fetch(`/inventory/transaction/${id}`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.success) {
                    const transaction = data.transaction;
                    
                    // Populate all fields
                    document.getElementById('editTransactionId').value = transaction.id;
                    document.getElementById('editDescription').value = transaction.description || '';
                    document.getElementById('editCategory').value = transaction.category || '';
                    document.getElementById('editAmount').value = transaction.amount || 0;
                    document.getElementById('editDate').value = transaction.date || '';
                    document.getElementById('editType').value = transaction.type || 'income';
                    document.getElementById('editRemarks').value = transaction.remarks || '';
                    
                    // Set type display
                    const typeDisplay = document.getElementById('editTypeDisplay');
                    if (transaction.type === 'income') {
                        typeDisplay.className = 'type-badge-display income';
                        typeDisplay.innerHTML = '<i class="fas fa-arrow-down"></i> Income';
                        document.getElementById('editDonorGroup').style.display = 'block';
                        document.getElementById('editRecipientGroup').style.display = 'none';
                        document.getElementById('editDonorName').value = transaction.donor_name || '';
                        document.getElementById('editRecipient').value = '';
                    } else {
                        typeDisplay.className = 'type-badge-display expense';
                        typeDisplay.innerHTML = '<i class="fas fa-arrow-up"></i> Expense';
                        document.getElementById('editDonorGroup').style.display = 'none';
                        document.getElementById('editRecipientGroup').style.display = 'block';
                        document.getElementById('editRecipient').value = transaction.recipient || '';
                        document.getElementById('editDonorName').value = '';
                    }
                    
                    // Set form action
                    document.getElementById('editTransactionForm').action = `/inventory/transaction/${id}`;
                    
                    // Show the modal
                    const modal = document.getElementById('editModal');
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to load transaction details.',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load transaction details. Please try again.',
                    confirmButtonColor: '#EF4444'
                });
            });
    }
    
    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.remove('active');
        document.body.style.overflow = '';
        currentEditId = null;
    }
    
    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
    
    // Type change handler for edit modal
    document.getElementById('editType')?.addEventListener('change', function() {
        const typeDisplay = document.getElementById('editTypeDisplay');
        if (this.value === 'income') {
            typeDisplay.className = 'type-badge-display income';
            typeDisplay.innerHTML = '<i class="fas fa-arrow-down"></i> Income';
            document.getElementById('editDonorGroup').style.display = 'block';
            document.getElementById('editRecipientGroup').style.display = 'none';
            document.getElementById('editRecipient').value = '';
        } else {
            typeDisplay.className = 'type-badge-display expense';
            typeDisplay.innerHTML = '<i class="fas fa-arrow-up"></i> Expense';
            document.getElementById('editDonorGroup').style.display = 'none';
            document.getElementById('editRecipientGroup').style.display = 'block';
            document.getElementById('editDonorName').value = '';
        }
    });
    
    // Delete from edit modal
    function deleteFromEdit() {
        const id = document.getElementById('editTransactionId').value;
        closeEditModal();
        confirmDelete(id);
    }
    
    // Handle edit form submission - UPDATES MONEY IN ALL RECORDS
    document.getElementById('editTransactionForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const id = document.getElementById('editTransactionId').value;
        
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-HTTP-Method-Override': 'PUT',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if (data.success) {
                closeEditModal();
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: data.message || 'Transaction updated successfully. All financial records have been updated.',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update transaction.',
                    confirmButtonColor: '#EF4444'
                });
            }
        })
        .catch(error => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong. Please try again.',
                confirmButtonColor: '#EF4444'
            });
        });
    });
    
    // ============================================
    // DELETE TRANSACTION
    // ============================================
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Transaction?',
            text: 'This action cannot be undone. Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                
                fetch(`/inventory/transaction/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message || 'Transaction deleted successfully. All financial records have been updated.',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to delete transaction.',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                        confirmButtonColor: '#EF4444'
                    });
                });
            }
        });
    }
    
    // ============================================
    // FILTER TRANSACTIONS
    // ============================================
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
    
    // ============================================
    // SEARCH TRANSACTIONS
    // ============================================
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
    
    // ============================================
    // CLICKABLE ROWS
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#transactionsTableBody .clickable-row').forEach(row => {
            row.addEventListener('click', function(e) {
                if (e.target.closest('.action-btns-premium') || e.target.closest('.btn-edit-premium') || e.target.closest('.btn-delete-premium')) {
                    return;
                }
                const id = this.getAttribute('data-id');
                if (id) {
                    openEditModal(id);
                }
            });
        });
    });
    
    // ============================================
    // INITIALIZE
    // ============================================
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