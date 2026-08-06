@extends('layouts.app')

@section('header', 'Reports & Analytics')

@php
use Carbon\Carbon;
@endphp

@section('content')
<style>
    /* ============================================
       MODERN ANALYTICS DESIGN
    ============================================ */
    
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
    
    :root {
        --analytics-primary: #4F46E5;
        --analytics-success: #10B981;
        --analytics-danger: #EF4444;
        --analytics-purple: #8B5CF6;
        --analytics-orange: #F97316;
        --gradient-blue: linear-gradient(135deg, #4F46E5, #7C3AED);
        --gradient-green: linear-gradient(135deg, #10B981, #34D399);
        --gradient-red: linear-gradient(135deg, #EF4444, #F87171);
        --gradient-purple: linear-gradient(135deg, #8B5CF6, #A78BFA);
        --gradient-orange: linear-gradient(135deg, #F59E0B, #FBBF24);
        --shadow-card-lg: 0 20px 60px rgba(0,0,0,0.08);
        --shadow-card-hover: 0 24px 80px rgba(0,0,0,0.12);
    }
    
    /* Hero Section */
    .analytics-hero {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 50%, #EC4899 100%);
        border-radius: 20px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(79, 70, 229, 0.3);
    }
    
    .analytics-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 80%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulseGlow 8s ease-in-out infinite;
    }
    
    .analytics-hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: pulseGlow 10s ease-in-out infinite reverse;
    }
    
    @keyframes pulseGlow {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 1; }
    }
    
    .analytics-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .analytics-hero .hero-left {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    
    .analytics-hero h1 {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin: 0;
        font-family: 'Inter', sans-serif;
    }
    
    .analytics-hero h1 i {
        margin-right: 12px;
        opacity: 0.8;
    }
    
    .analytics-hero p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 0.9rem;
    }
    
    .analytics-hero .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.15);
        padding: 0.5rem 1.2rem;
        border-radius: 50px;
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .analytics-hero .hero-actions {
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
    }
    
    .btn-hero-secondary:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    /* Stats Grid */
    .analytics-stats {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    
    .stat-card-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-card);
    }
    
    .stat-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--gradient-blue);
    }
    
    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-card-hover);
        border-color: transparent;
    }
    
    .stat-card-modern .stat-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.5rem;
    }
    
    .stat-card-modern .stat-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        font-weight: 700;
        margin: 0;
    }
    
    .stat-card-modern .stat-icon-wrap {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-card-modern .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    
    .stat-card-modern .stat-change {
        font-size: 0.65rem;
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }
    
    .stat-card-modern .stat-change.positive { color: var(--analytics-success); }
    .stat-card-modern .stat-change.negative { color: var(--analytics-danger); }
    
    .stat-card-modern.green::before { background: var(--gradient-green); }
    .stat-card-modern.red::before { background: var(--gradient-red); }
    .stat-card-modern.blue::before { background: var(--gradient-blue); }
    .stat-card-modern.purple::before { background: var(--gradient-purple); }
    .stat-card-modern.orange::before { background: var(--gradient-orange); }
    
    .stat-card-modern.green .stat-icon-wrap { background: var(--gradient-green); }
    .stat-card-modern.red .stat-icon-wrap { background: var(--gradient-red); }
    .stat-card-modern.blue .stat-icon-wrap { background: var(--gradient-blue); }
    .stat-card-modern.purple .stat-icon-wrap { background: var(--gradient-purple); }
    .stat-card-modern.orange .stat-icon-wrap { background: var(--gradient-orange); }
    
    /* Cards */
    .card-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
    }
    
    .card-modern:hover {
        box-shadow: var(--shadow-card-hover);
    }
    
    .card-modern .card-header-custom {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-modern .card-header-custom h6 {
        margin: 0;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .card-modern .card-header-custom h6 i {
        margin-right: 8px;
        color: var(--analytics-primary);
    }
    
    .card-modern .card-body {
        padding: 1.5rem;
    }
    
    /* Table */
    .table-modern {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        padding: 0.75rem 1rem;
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: var(--text-muted);
        border-bottom: 2px solid var(--border-color);
        text-align: left;
    }
    
    .table-modern tbody td {
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }
    
    .table-modern tbody tr:hover {
        background: var(--bg-tertiary);
    }
    
    /* Badges */
    .badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.25rem 0.8rem;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 700;
    }
    
    .badge-modern.income {
        background: rgba(16, 185, 129, 0.12);
        color: #10B981;
    }
    
    .badge-modern.expense {
        background: rgba(239, 68, 68, 0.12);
        color: #EF4444;
    }
    
    .badge-modern.choir {
        background: rgba(245, 158, 11, 0.12);
        color: #F59E0B;
    }
    
    .badge-modern.member {
        background: rgba(79, 70, 229, 0.12);
        color: #4F46E5;
    }
    
    /* Member Items */
    .member-item-modern {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0.7rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .member-item-modern:last-child {
        border-bottom: none;
    }
    
    .member-item-modern .member-avatar {
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
    }
    
    .member-item-modern .member-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-primary);
    }
    
    .member-item-modern .member-meta {
        font-size: 0.65rem;
        color: var(--text-muted);
    }
    
    /* Schedule Card */
    .schedule-card-modern {
        background: var(--bg-tertiary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .schedule-card-modern .schedule-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.5rem 1.2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.85rem;
        color: white;
        background: var(--gradient-purple);
    }
    
    .schedule-card-modern .schedule-detail {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    /* Chart */
    .chart-modern {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-card);
    }
    
    .chart-modern .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.2rem;
    }
    
    .chart-modern .chart-header h5 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .chart-modern .chart-header h5 i {
        color: var(--analytics-primary);
        margin-right: 8px;
    }
    
    .chart-modern .chart-body {
        height: 280px;
        position: relative;
    }
    
    /* Two Column Grid */
    .analytics-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    /* ============================================
       EXPORT MODAL STYLES
    ============================================ */
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
        background: var(--card-bg);
        border-radius: 20px;
        padding: 2rem;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        border: 1px solid var(--border-color);
    }
    
    .export-modal-content .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .export-modal-content .modal-header-custom h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
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
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .export-modal-content .modal-header-custom .close-btn:hover {
        color: var(--text-primary);
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
        color: var(--text-muted);
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
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
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
        color: var(--text-primary);
        margin: 0;
        cursor: pointer;
        text-transform: none;
        letter-spacing: 0;
    }
    
    .export-section-group .checkbox-item label i {
        margin-right: 6px;
        font-size: 0.8rem;
    }
    
    .export-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
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
        background: var(--gradient-blue);
        color: white;
        box-shadow: 0 4px 16px rgba(79,70,229,0.3);
    }
    
    .btn-export-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(79,70,229,0.4);
    }
    
    .btn-export-print {
        background: var(--gradient-green);
        color: white;
        box-shadow: 0 4px 16px rgba(16,185,129,0.3);
    }
    
    .btn-export-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(16,185,129,0.4);
    }
    
    .btn-export-cancel {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }
    
    .btn-export-cancel:hover {
        background: var(--hover-bg);
        transform: translateY(-2px);
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
        color: var(--text-primary);
        margin: 0;
        cursor: pointer;
    }
    
    /* ============================================
       PDF EXPORT CONTENT STYLES
    ============================================ */
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
    }
    
    .pdf-export-wrapper .pdf-section .pdf-section-title i {
        color: #4F46E5;
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
    
    .pdf-export-wrapper .pdf-badge.choir {
        background: #fef3c7;
        color: #92400e;
    }
    
    .pdf-export-wrapper .pdf-badge.member {
        background: #e0e7ff;
        color: #3730a3;
    }
    
    .pdf-export-wrapper .pdf-member-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 6px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .pdf-export-wrapper .pdf-member-item:last-child {
        border-bottom: none;
    }
    
    .pdf-export-wrapper .pdf-member-avatar {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #4F46E5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        font-weight: 700;
    }
    
    .pdf-export-wrapper .pdf-member-name {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a2e;
    }
    
    .pdf-export-wrapper .pdf-member-meta {
        font-size: 12px;
        color: #6b7280;
    }
    
    .pdf-export-wrapper .pdf-schedule {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .pdf-export-wrapper .pdf-schedule .pdf-schedule-badge {
        background: #8B5CF6;
        color: white;
        padding: 6px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
    }
    
    .pdf-export-wrapper .pdf-schedule .pdf-schedule-detail {
        font-size: 13px;
        color: #4b5563;
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
    
    /* Chart container for PDF */
    .pdf-chart-container {
        width: 100%;
        height: 250px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 15px;
        position: relative;
    }
    
    .pdf-chart-container canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .analytics-stats {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .analytics-grid-2 {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .analytics-hero {
            padding: 1.5rem;
        }
        
        .analytics-hero h1 {
            font-size: 1.3rem;
        }
        
        .analytics-hero .hero-content {
            flex-direction: column;
            text-align: center;
        }
        
        .analytics-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }
        
        .stat-card-modern .stat-value {
            font-size: 1.3rem;
        }
        
        .schedule-card-modern {
            flex-direction: column;
            text-align: center;
        }
        
        .btn-hero-primary,
        .btn-hero-secondary {
            width: 100%;
            justify-content: center;
        }
        
        .export-section-group .checkbox-grid {
            grid-template-columns: 1fr;
        }
        
        .export-actions {
            flex-direction: column;
        }
        
        .pdf-export-wrapper .pdf-stats-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    @media (max-width: 480px) {
        .analytics-stats {
            grid-template-columns: 1fr 1fr;
            gap: 0.6rem;
        }
        
        .stat-card-modern .stat-value {
            font-size: 1.1rem;
        }
        
        .stat-card-modern .stat-icon-wrap {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
        
        .pdf-export-wrapper .pdf-stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- ============================================ -->
<!-- MAIN CONTENT -->
<!-- ============================================ -->
<div class="container-fluid px-0" id="reportContent">
    <!-- Hero Section -->
    <div class="analytics-hero">
        <div class="hero-content">
            <div class="hero-left">
                <h1><i class="fas fa-chart-line"></i> Reports & Analytics</h1>
                <p>Complete church financial and ministry analytics dashboard</p>
                <div class="hero-badge">
                    <i class="fas fa-circle" style="color: #34D399; font-size: 0.5rem;"></i>
                    {{ \Carbon\Carbon::now()->format('F d, Y') }} • {{ \Carbon\Carbon::now()->format('h:i A') }}
                </div>
            </div>
            <div class="hero-actions no-print">
                <a href="{{ route('dashboard') }}" class="btn-hero-secondary">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <button class="btn-hero-primary" onclick="openExportModal()">
                    <i class="fas fa-download"></i> Export Report
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="analytics-stats" id="statsSection">
        <div class="stat-card-modern green">
            <div class="stat-top">
                <span class="stat-label">Total Income</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-down"></i></div>
            </div>
            <div class="stat-value" id="totalIncome">₱{{ number_format($totalIncome ?? 0, 2) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-arrow-up"></i> Money received
            </div>
        </div>
        
        <div class="stat-card-modern red">
            <div class="stat-top">
                <span class="stat-label">Total Expenses</span>
                <div class="stat-icon-wrap"><i class="fas fa-arrow-up"></i></div>
            </div>
            <div class="stat-value" id="totalExpense">₱{{ number_format($totalExpense ?? 0, 2) }}</div>
            <div class="stat-change negative">
                <i class="fas fa-arrow-down"></i> Money spent
            </div>
        </div>
        
        <div class="stat-card-modern blue">
            <div class="stat-top">
                <span class="stat-label">Net Balance</span>
                <div class="stat-icon-wrap"><i class="fas fa-scale-balanced"></i></div>
            </div>
            <div class="stat-value {{ ($balance ?? 0) >= 0 ? '' : 'text-danger' }}" id="netBalance">
                {{ ($balance ?? 0) >= 0 ? '₱' : '-₱' }}{{ number_format(abs($balance ?? 0), 2) }}
            </div>
            <div class="stat-change {{ ($balance ?? 0) >= 0 ? 'positive' : 'negative' }}">
                <i class="fas fa-{{ ($balance ?? 0) >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                {{ ($balance ?? 0) >= 0 ? 'Surplus' : 'Deficit' }}
            </div>
        </div>
        
        <div class="stat-card-modern purple">
            <div class="stat-top">
                <span class="stat-label">Total Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            </div>
            <div class="stat-value" id="totalMembers">{{ number_format($totalMembers ?? 0) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-users"></i> Church family
            </div>
        </div>
        
        <div class="stat-card-modern orange">
            <div class="stat-top">
                <span class="stat-label">Choir Members</span>
                <div class="stat-icon-wrap"><i class="fas fa-music"></i></div>
            </div>
            <div class="stat-value" id="choirMembers">{{ number_format($choirMembers ?? 0) }}</div>
            <div class="stat-change positive">
                <i class="fas fa-microphone"></i> Voices of praise
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="chart-modern" id="chartSection">
        <div class="chart-header">
            <h5><i class="fas fa-chart-line"></i> Income vs Expenses (Last 6 Months)</h5>
            <span class="badge-modern member"><i class="fas fa-calendar"></i> 6 Months</span>
        </div>
        <div class="chart-body">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    <!-- Two Column Grid -->
    <div class="analytics-grid-2" id="gridSection">
        <!-- Recent Transactions -->
        <div class="card-modern" id="transactionsCard">
            <div class="card-header-custom">
                <h6><i class="fas fa-history"></i> Recent Transactions</h6>
                <span class="badge-modern member">{{ count($recentTransactions ?? []) }} entries</span>
            </div>
            <div class="card-body" style="padding: 0;">
                <div style="max-height: 350px; overflow-y: auto;">
                    <table class="table-modern" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($recentTransactions ?? []) as $transaction)
                            <tr>
                                <td>{{ Carbon::parse($transaction->date ?? $transaction->created_at)->format('M d') }}</td>
                                <td>{{ $transaction->description ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge-modern {{ $transaction->type == 'income' ? 'income' : 'expense' }}">
                                        {{ ucfirst($transaction->type ?? 'expense') }}
                                    </span>
                                </td>
                                <td style="text-align: right; font-weight: 700; color: {{ $transaction->type == 'income' ? '#10B981' : '#EF4444' }};">
                                    {{ $transaction->type == 'income' ? '+' : '-' }} ₱{{ number_format($transaction->amount ?? 0, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                                    <i class="fas fa-receipt" style="font-size: 1.5rem; display: block; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                                    No transactions found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Members & Birthdays -->
        <div>
            <div class="card-modern" id="membersCard">
                <div class="card-header-custom">
                    <h6><i class="fas fa-users"></i> Recent Members</h6>
                    <span class="badge-modern member">{{ count($recentMembers ?? []) }} new</span>
                </div>
                <div class="card-body" id="membersList">
                    @forelse(($recentMembers ?? []) as $member)
                    <div class="member-item-modern">
                        <div class="member-avatar">
                            {{ strtoupper(substr($member->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="member-info">
                            <div class="member-name">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                            <div class="member-meta">Joined {{ Carbon::parse($member->created_at)->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 1.5rem; color: var(--text-muted);">
                        <i class="fas fa-users" style="font-size: 1.5rem; display: block; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                        No members found
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="card-modern" id="birthdaysCard" style="margin-bottom: 0;">
                <div class="card-header-custom">
                    <h6><i class="fas fa-birthday-cake"></i> Upcoming Birthdays</h6>
                    <span class="badge-modern choir">{{ count($upcomingBirthdays ?? []) }} celebrating</span>
                </div>
                <div class="card-body" id="birthdaysList">
                    @forelse(($upcomingBirthdays ?? []) as $birthday)
                    <div class="member-item-modern">
                        <div class="member-avatar" style="background: var(--gradient-orange);">
                            <i class="fas fa-cake-candles"></i>
                        </div>
                        <div class="member-info">
                            <div class="member-name">{{ $birthday->first_name ?? '' }} {{ $birthday->last_name ?? '' }}</div>
                            <div class="member-meta">{{ Carbon::parse($birthday->birthday)->format('F d') }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 1.5rem; color: var(--text-muted);">
                        <i class="fas fa-birthday-cake" style="font-size: 1.5rem; display: block; opacity: 0.3; margin-bottom: 0.5rem;"></i>
                        No upcoming birthdays
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Choir Schedule -->
    <div class="card-modern" id="choirCard">
        <div class="card-header-custom">
            <h6><i class="fas fa-music"></i> Upcoming Choir Schedule</h6>
            <span class="badge-modern choir"><i class="fas fa-clock"></i> This Week</span>
        </div>
        <div class="card-body">
            <div class="schedule-card-modern">
                <div class="schedule-info">
                    <div class="schedule-badge">
                        <i class="fas fa-layer-group"></i> {{ $choirGroupName ?? 'Worship Team' }}
                    </div>
                    <div class="schedule-detail">
                        <i class="fas fa-users"></i> {{ $choirMembersCount ?? 0 }} members
                    </div>
                    <div class="schedule-detail">
                        <i class="fas fa-calendar-alt"></i> 
                        @php 
                            $nextSun = Carbon::now(); 
                            if ($nextSun->dayOfWeek != Carbon::SUNDAY) $nextSun = $nextSun->next(Carbon::SUNDAY); 
                        @endphp
                        {{ $nextSun->format('F d, Y') }}
                    </div>
                </div>
                <a href="{{ route('choir-schedules.index') }}" class="btn-hero-primary no-print" style="background: var(--gradient-purple); color: white; padding: 0.5rem 1.5rem;">
                    <i class="fas fa-arrow-right"></i> View Schedule
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- EXPORT MODAL -->
<!-- ============================================ -->
<div class="export-modal-overlay" id="exportModal">
    <div class="export-modal-content">
        <div class="modal-header-custom">
            <h3><i class="fas fa-file-export"></i> Export Report</h3>
            <button class="close-btn" onclick="closeExportModal()">&times;</button>
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">
                Select the sections you want to include in your report. Each section will appear organized in the PDF.
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
                    <input type="checkbox" class="section-checkbox" value="chart" checked>
                    <label><i class="fas fa-chart-line"></i> Chart</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="transactions" checked>
                    <label><i class="fas fa-list"></i> Transactions</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="members" checked>
                    <label><i class="fas fa-users"></i> Members</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="birthdays" checked>
                    <label><i class="fas fa-birthday-cake"></i> Birthdays</label>
                </div>
                <div class="checkbox-item">
                    <input type="checkbox" class="section-checkbox" value="choir" checked>
                    <label><i class="fas fa-music"></i> Choir</label>
                </div>
            </div>
        </div>
        
        <div style="padding: 0.8rem 1rem; background: rgba(79,70,229,0.05); border-radius: 10px; border: 1px solid rgba(79,70,229,0.1); margin-bottom: 1.5rem;">
            <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0;">
                <i class="fas fa-info-circle" style="color: #4F46E5;"></i> 
                Only the sections you select will appear in the exported PDF. Each section will be organized by category.
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

<!-- ============================================ -->
<!-- PDF EXPORT CONTAINER (Hidden, used for generation) -->
<!-- ============================================ -->
<div class="pdf-export-wrapper" id="pdfExportContainer">
    <div class="pdf-header">
        <h1>Reports & Analytics</h1>
        <p>Complete church financial and ministry analytics</p>
        <div class="pdf-date">Generated: {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</div>
    </div>
    
    <div id="pdfContent">
        <!-- Stats Section -->
        <div class="pdf-section" id="pdf-stats">
            <div class="pdf-section-title"><i class="fas fa-chart-pie"></i> Statistics Overview</div>
            <div class="pdf-stats-grid" id="pdfStatsGrid">
                <!-- Filled by JavaScript -->
            </div>
        </div>
        
        <!-- Chart Section -->
        <div class="pdf-section" id="pdf-chart" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-chart-line"></i> Income vs Expenses Chart</div>
            <div class="pdf-chart-container" id="pdfChartContainer">
                <canvas id="pdfChartCanvas"></canvas>
            </div>
        </div>
        
        <!-- Transactions Section -->
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
                    </tr>
                </thead>
                <tbody id="pdfTransactionsBody">
                    <!-- Filled by JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Members Section -->
        <div class="pdf-section" id="pdf-members" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-users"></i> Recent Members</div>
            <div id="pdfMembersList">
                <!-- Filled by JavaScript -->
            </div>
        </div>
        
        <!-- Birthdays Section -->
        <div class="pdf-section" id="pdf-birthdays" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-birthday-cake"></i> Upcoming Birthdays</div>
            <div id="pdfBirthdaysList">
                <!-- Filled by JavaScript -->
            </div>
        </div>
        
        <!-- Choir Section -->
        <div class="pdf-section" id="pdf-choir" style="display:none;">
            <div class="pdf-section-title"><i class="fas fa-music"></i> Choir Schedule</div>
            <div class="pdf-schedule">
                <span class="pdf-schedule-badge" id="pdfChoirName">Worship Team</span>
                <span class="pdf-schedule-detail" id="pdfChoirMembers">0 members</span>
                <span class="pdf-schedule-detail" id="pdfChoirSchedule">Next: {{ isset($nextSun) ? $nextSun->format('F d, Y') : '' }}</span>
            </div>
        </div>
    </div>
    
    <div class="pdf-footer">
        Generated by <strong>TINC Church Management System</strong> • {{ \Carbon\Carbon::now()->format('Y') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ============================================
    // EXPORT MODAL FUNCTIONS
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
    // PDF CHART
    // ============================================
    let pdfChartInstance = null;
    
    function renderPDFChart() {
        const canvas = document.getElementById('pdfChartCanvas');
        if (!canvas) return;
        
        const months = @json($months ?? []);
        const incomeData = @json($incomeData ?? []);
        const expenseData = @json($expenseData ?? []);
        
        if (months.length === 0) {
            document.getElementById('pdfChartContainer').innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:#999;font-size:14px;">No chart data available</div>';
            return;
        }
        
        const ctx = canvas.getContext('2d');
        
        if (pdfChartInstance) {
            pdfChartInstance.destroy();
        }
        
        pdfChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Income',
                        data: incomeData,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Expenses',
                        data: expenseData,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#EF4444',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { size: 12, weight: '600' },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
    
    // ============================================
    // BUILD PDF CONTENT
    // ============================================
    function buildPDFContent(sections) {
        // Stats
        if (sections.includes('stats')) {
            document.getElementById('pdf-stats').style.display = 'block';
            const grid = document.getElementById('pdfStatsGrid');
            const stats = [
                { label: 'Total Income', value: document.getElementById('totalIncome')?.innerText || '₱0', change: 'Money received', positive: true },
                { label: 'Total Expenses', value: document.getElementById('totalExpense')?.innerText || '₱0', change: 'Money spent', positive: false },
                { label: 'Net Balance', value: document.getElementById('netBalance')?.innerText || '₱0', change: 'Surplus', positive: true },
                { label: 'Total Members', value: document.getElementById('totalMembers')?.innerText || '0', change: 'Church family', positive: true },
                { label: 'Choir Members', value: document.getElementById('choirMembers')?.innerText || '0', change: 'Voices of praise', positive: true }
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
        
        // Chart
        if (sections.includes('chart')) {
            document.getElementById('pdf-chart').style.display = 'block';
            setTimeout(function() {
                renderPDFChart();
            }, 100);
        } else {
            document.getElementById('pdf-chart').style.display = 'none';
        }
        
        // Transactions
        if (sections.includes('transactions')) {
            document.getElementById('pdf-transactions').style.display = 'block';
            const body = document.getElementById('pdfTransactionsBody');
            const rows = document.querySelectorAll('#transactionsTable tbody tr');
            let html = '';
            rows.forEach(row => {
                if (row.querySelector('td') && !row.innerText.includes('No transactions')) {
                    const cells = row.querySelectorAll('td');
                    const type = cells[2]?.innerText.trim() || '';
                    const isIncome = type.includes('Income');
                    html += `
                        <tr>
                            <td>${cells[0]?.innerText || ''}</td>
                            <td>${cells[1]?.innerText || ''}</td>
                            <td>${type}</td>
                            <td><span class="pdf-badge ${isIncome ? 'income' : 'expense'}">${isIncome ? 'Income' : 'Expense'}</span></td>
                            <td style="text-align:right; font-weight:700; color:${isIncome ? '#10B981' : '#EF4444'};">${cells[3]?.innerText || ''}</td>
                        </tr>
                    `;
                }
            });
            body.innerHTML = html || '<tr><td colspan="5" style="text-align:center; color:#999; padding:20px;">No transactions found</td></tr>';
        } else {
            document.getElementById('pdf-transactions').style.display = 'none';
        }
        
        // Members
        if (sections.includes('members')) {
            document.getElementById('pdf-members').style.display = 'block';
            const list = document.getElementById('pdfMembersList');
            const items = document.querySelectorAll('#membersList .member-item-modern');
            let html = '';
            items.forEach(item => {
                const name = item.querySelector('.member-name')?.innerText || '';
                const meta = item.querySelector('.member-meta')?.innerText || '';
                const initial = name.substring(0, 2).toUpperCase() || '?';
                html += `
                    <div class="pdf-member-item">
                        <div class="pdf-member-avatar">${initial}</div>
                        <div>
                            <div class="pdf-member-name">${name}</div>
                            <div class="pdf-member-meta">${meta}</div>
                        </div>
                    </div>
                `;
            });
            list.innerHTML = html || '<p style="color:#999; text-align:center; padding:15px;">No members found</p>';
        } else {
            document.getElementById('pdf-members').style.display = 'none';
        }
        
        // Birthdays
        if (sections.includes('birthdays')) {
            document.getElementById('pdf-birthdays').style.display = 'block';
            const list = document.getElementById('pdfBirthdaysList');
            const items = document.querySelectorAll('#birthdaysList .member-item-modern');
            let html = '';
            items.forEach(item => {
                const name = item.querySelector('.member-name')?.innerText || '';
                const meta = item.querySelector('.member-meta')?.innerText || '';
                const initial = name.substring(0, 2).toUpperCase() || '?';
                html += `
                    <div class="pdf-member-item">
                        <div class="pdf-member-avatar" style="background:#F59E0B;">${initial}</div>
                        <div>
                            <div class="pdf-member-name">${name}</div>
                            <div class="pdf-member-meta">🎂 ${meta}</div>
                        </div>
                    </div>
                `;
            });
            list.innerHTML = html || '<p style="color:#999; text-align:center; padding:15px;">No upcoming birthdays</p>';
        } else {
            document.getElementById('pdf-birthdays').style.display = 'none';
        }
        
        // Choir
        if (sections.includes('choir')) {
            document.getElementById('pdf-choir').style.display = 'block';
            const name = document.querySelector('.schedule-badge')?.innerText?.trim() || 'Worship Team';
            const members = document.querySelector('.schedule-detail')?.innerText?.trim() || '0 members';
            const schedule = document.querySelector('.schedule-detail:last-child')?.innerText?.trim() || '';
            document.getElementById('pdfChoirName').textContent = name;
            document.getElementById('pdfChoirMembers').textContent = members;
            document.getElementById('pdfChoirSchedule').textContent = schedule ? 'Next: ' + schedule : '';
        } else {
            document.getElementById('pdf-choir').style.display = 'none';
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
                confirmButtonColor: '#4F46E5',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
            return;
        }
        
        closeExportModal();
        
        buildPDFContent(sections);
        const container = document.getElementById('pdfExportContainer');
        container.style.display = 'block';
        
        setTimeout(function() {
            Swal.fire({
                title: 'Preparing Print...',
                text: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); },
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
            
            setTimeout(() => {
                Swal.close();
                window.print();
                setTimeout(() => {
                    container.style.display = 'none';
                }, 1000);
            }, 500);
        }, 300);
    }
    
    function exportPDF() {
        const sections = getSelectedSections();
        if (sections.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Selection',
                text: 'Please select at least one section to export.',
                confirmButtonColor: '#4F46E5',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
            return;
        }
        
        closeExportModal();
        
        buildPDFContent(sections);
        const container = document.getElementById('pdfExportContainer');
        container.style.display = 'block';
        
        setTimeout(function() {
            Swal.fire({
                title: 'Generating PDF...',
                text: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); },
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
            
            const opt = {
                margin:        [10, 10, 10, 10],
                filename:     'TINC_Church_Report_' + new Date().toISOString().slice(0,10) + '.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { 
                    scale: 2, 
                    useCORS: true,
                    letterRendering: true,
                    logging: false,
                    backgroundColor: '#ffffff'
                },
                jsPDF:        { 
                    unit: 'mm', 
                    format: 'a4', 
                    orientation: 'portrait' 
                }
            };
            
            html2pdf().set(opt).from(container).save().then(function() {
                container.style.display = 'none';
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'PDF Exported!',
                    text: 'Your report has been downloaded successfully.',
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            }).catch(function(err) {
                container.style.display = 'none';
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Export Failed',
                    text: err.message || 'Something went wrong. Please try again.',
                    confirmButtonColor: '#EF4444',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            });
        }, 300);
    }
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExportModal();
        }
    });
    
    document.getElementById('exportModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeExportModal();
        }
    });
    
    // ============================================
    // MAIN CHART
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('financeChart');
        if (canvas) {
            const months = @json($months ?? []);
            const incomeData = @json($incomeData ?? []);
            const expenseData = @json($expenseData ?? []);
            
            if (months.length > 0) {
                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Income',
                                data: incomeData,
                                borderColor: '#10B981',
                                backgroundColor: 'rgba(16, 185, 129, 0.05)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#10B981',
                                pointBorderColor: 'white',
                                pointBorderWidth: 2
                            },
                            {
                                label: 'Expenses',
                                data: expenseData,
                                borderColor: '#EF4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.05)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#EF4444',
                                pointBorderColor: 'white',
                                pointBorderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: { 
                                        size: 11,
                                        weight: '600'
                                    },
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary').trim(),
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                titleColor: 'white',
                                bodyColor: 'white',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: (ctx) => `${ctx.dataset.label}: ₱${ctx.parsed.y.toLocaleString()}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: v => '₱' + v.toLocaleString(),
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--text-muted').trim()
                                },
                                grid: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--border-color').trim()
                                }
                            },
                            x: {
                                grid: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--border-color').trim()
                                },
                                ticks: {
                                    color: getComputedStyle(document.documentElement).getPropertyValue('--text-muted').trim()
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
        }
    });
</script>
@endsection