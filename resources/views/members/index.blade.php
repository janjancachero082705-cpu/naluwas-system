@extends('layouts.app')

@section('header', 'Member Management')

@section('content')

{{-- ============================================= --}}
{{-- STYLES SECTION --}}
{{-- ============================================= --}}
<style>
    /* ============================================
       STATS GRID CARDS
    ============================================ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-mini-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
    }
    
    .stat-mini-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .stat-mini-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-mini-icon.primary { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .stat-mini-icon.success { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-mini-icon.warning { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .stat-mini-icon.info { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    
    .stat-mini-info { flex: 1; }
    
    .stat-mini-info h4 {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin: 0 0 3px 0;
        font-weight: 600;
    }
    
    .stat-mini-number {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.1;
    }
    
    /* ============================================
       FILTER SECTION
    ============================================ */
    .filter-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-label {
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
        display: block;
    }
    
    .filter-select {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: var(--text-primary);
        font-size: 0.8rem;
        cursor: pointer;
        min-width: 200px;
    }
    
    .filter-select option {
        background: var(--card-bg);
        color: var(--text-primary);
    }
    
    .total-badge {
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border-color);
    }
    
    /* ============================================
       TABLE STYLES
    ============================================ */
    .table-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .table {
        margin-bottom: 0;
        color: var(--text-primary);
        background: var(--card-bg);
        border-collapse: collapse;
    }
    
    .table thead th {
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-muted);
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 0.8rem 1rem;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 0.7rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
    }
    
    .table tbody tr {
        transition: all 0.15s ease;
        cursor: pointer;
    }
    
    .table tbody tr:hover {
        background: var(--bg-tertiary);
    }
    
    .table tbody tr:hover td {
        background: transparent;
    }
    
    /* ============================================
       MEMBER AVATAR
    ============================================ */
    .member-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--bg-tertiary);
        border: 1.5px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        color: var(--text-muted);
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    
    .member-avatar i {
        font-size: 0.7rem;
    }
    
    .member-avatar.deceased {
        opacity: 0.6;
    }
    
    .member-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-primary);
        margin-bottom: 2px;
    }
    
    .member-phone {
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .deceased-date {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    
    /* Role Tags */
    .role-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }
    
    .role-tag i {
        font-size: 0.5rem;
        opacity: 0.6;
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
    
    /* Deceased Badge */
    .deceased-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }
    
    .deceased-badge i {
        font-size: 0.5rem;
    }
    
    /* Action Buttons */
    .btn-icon-action {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.65rem;
        position: relative;
        z-index: 5;
    }
    
    .btn-icon-action:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        transform: translateY(-1px);
    }
    
    .btn-icon-action.delete:hover {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }
    
    .btn-icon-action.deceased:hover {
        background: #f1f5f9;
        color: #64748b;
        border-color: #e2e8f0;
    }
    
    .btn-icon-action.restore:hover {
        background: #ecfdf5;
        color: #10b981;
        border-color: #a7f3d0;
    }
    
    .action-buttons {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }
    
    /* Add Member Button */
    .btn-add-in-table {
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        padding: 0.35rem 0.9rem;
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
        position: relative;
        z-index: 5;
    }
    
    .btn-add-in-table:hover {
        background: var(--text-primary);
        color: var(--card-bg);
        border-color: var(--text-primary);
        transform: translateY(-1px);
    }
    
    /* Tabs */
    .member-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .member-tab {
        padding: 0.5rem 1.2rem;
        border-radius: 10px 10px 0 0;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        background: transparent;
        color: var(--text-muted);
        border: none;
        position: relative;
        transition: all 0.2s ease;
    }
    
    .member-tab:hover {
        color: var(--text-primary);
    }
    
    .member-tab.active {
        color: var(--text-primary);
    }
    
    .member-tab.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: var(--text-primary);
    }
    
    .member-tab .badge {
        margin-left: 6px;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        padding: 1px 6px;
        border-radius: 20px;
        font-size: 0.55rem;
        font-weight: 600;
    }
    
    [data-theme="dark"] .member-tab .badge {
        background: var(--bg-tertiary);
        color: var(--text-muted);
    }
    
    .member-tab.active .badge {
        background: var(--text-primary);
        color: var(--card-bg);
    }
    
    /* Table Sections */
    .table-section {
        display: none;
    }
    
    .table-section.active-section {
        display: block;
    }
    
    /* Pagination */
    .pagination-container {
        padding: 0.7rem 1.2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        background: var(--card-bg);
    }
    
    .pagination-info {
        font-size: 0.65rem;
        color: var(--text-muted);
    }
    
    .pagination {
        margin: 0;
        gap: 3px;
    }
    
    .page-link {
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-secondary);
        font-size: 0.65rem;
        padding: 4px 10px;
        transition: all 0.2s ease;
    }
    
    .page-link:hover {
        background: var(--bg-tertiary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    
    .page-item.active .page-link {
        background: var(--text-primary);
        border-color: var(--text-primary);
        color: var(--card-bg);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2.5rem;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.8rem;
        opacity: 0.3;
    }
    
    .empty-state h5 {
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-state p {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    /* ============================================
       MEMBER DETAILS MODAL - MINIMAL DESIGN
    ============================================ */
    .member-modal-overlay {
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
    
    .member-modal-overlay.active {
        display: flex;
    }
    
    .member-modal {
        background: var(--card-bg);
        border-radius: 16px;
        max-width: 480px;
        width: 95%;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        animation: slideUp 0.3s ease;
    }
    
    .member-modal::-webkit-scrollbar {
        width: 4px;
    }
    
    .member-modal::-webkit-scrollbar-track {
        background: var(--bg-tertiary);
        border-radius: 10px;
    }
    
    .member-modal::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    
    .modal-header-custom {
        padding: 1.5rem 2rem 1rem;
        text-align: center;
        position: relative;
        border-bottom: 1px solid var(--border-color);
    }
    
    .modal-header-custom .close-modal {
        position: absolute;
        top: 0.8rem;
        right: 1rem;
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 1.2rem;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-header-custom .close-modal:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }
    
    .modal-avatar-large {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--bg-tertiary);
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: var(--text-muted);
        margin: 0 auto 0.5rem;
    }
    
    .modal-avatar-large i {
        font-size: 1.8rem;
    }
    
    .modal-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        text-align: center;
        margin-bottom: 0.1rem;
    }
    
    .modal-status {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.7rem;
    }
    
    .modal-body-custom {
        padding: 1.2rem 2rem 1.5rem;
    }
    
    .modal-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.6rem;
    }
    
    .modal-info-item {
        padding: 0.6rem 0.8rem;
        background: var(--bg-tertiary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .modal-info-item .label {
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 0.15rem;
    }
    
    .modal-info-item .label i {
        font-size: 0.5rem;
        margin-right: 4px;
    }
    
    .modal-info-item .value {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .modal-roles {
        display: flex;
        flex-wrap: wrap;
        gap: 0.4rem;
        margin-top: 0.2rem;
    }
    
    .modal-role-tag {
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }
    
    .modal-role-tag.choir {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }
    
    [data-theme="dark"] .modal-role-tag.choir {
        background: #78350f;
        color: #fde68a;
        border-color: #92400e;
    }
    
    .modal-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1.2rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    .modal-btn {
        flex: 1;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-secondary);
    }
    
    .modal-btn:hover {
        transform: translateY(-1px);
    }
    
    .modal-btn.edit {
        background: var(--text-primary);
        color: var(--card-bg);
        border-color: var(--text-primary);
    }
    
    .modal-btn.edit:hover {
        opacity: 0.85;
    }
    
    .modal-btn.deceased {
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border-color: var(--border-color);
    }
    
    .modal-btn.deceased:hover {
        background: #f1f5f9;
        color: #64748b;
    }
    
    .modal-btn.delete {
        color: #ef4444;
        border-color: #fecaca;
    }
    
    .modal-btn.delete:hover {
        background: #fef2f2;
        border-color: #fca5a5;
    }
    
    @media (max-width: 640px) {
        .modal-info-grid {
            grid-template-columns: 1fr;
        }
        .modal-actions {
            flex-direction: column;
        }
        .modal-header-custom {
            padding: 1.2rem 1.5rem 0.8rem;
        }
        .modal-body-custom {
            padding: 1rem 1.5rem 1.2rem;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        
        .stat-mini-number { font-size: 1.2rem; }
        .stat-mini-icon { width: 40px; height: 40px; font-size: 1rem; }
        
        .pagination-container { flex-direction: column; }
        
        .member-tab {
            flex: 1;
            text-align: center;
            font-size: 0.65rem;
            padding: 0.4rem 0.6rem;
        }
        
        .table thead th,
        .table tbody td {
            padding: 0.5rem 0.6rem;
            font-size: 0.65rem;
        }
        
        .action-buttons { gap: 3px; }
        
        .btn-icon-action {
            width: 26px;
            height: 26px;
            font-size: 0.6rem;
        }
        
        .member-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.6rem;
        }
        
        .member-avatar i {
            font-size: 0.6rem;
        }
        
        .btn-add-in-table {
            padding: 0.25rem 0.6rem;
            font-size: 0.6rem;
        }
    }
</style>

{{-- ============================================= --}}
{{-- MAIN CONTENT --}}
{{-- ============================================= --}}
<div class="container-fluid px-0">
    
    {{-- HEADER SECTION --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h2 mb-1 fw-bold" style="color: var(--text-primary);">
                <i class="fas fa-users me-2" style="color: var(--text-muted);"></i>Church Members
            </h1>
            <p class="mb-0" style="color: var(--text-muted);">Manage your church family and their ministries</p>
        </div>
    </div>

    {{-- STATISTICS CARDS --}}
    <div class="stats-grid">
        <div class="stat-mini-card">
            <div class="stat-mini-icon primary"><i class="fas fa-users"></i></div>
            <div class="stat-mini-info">
                <h4>Active Members</h4>
                <div class="stat-mini-number">{{ number_format($totalMembers ?? $members->total() ?? 0) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon success"><i class="fas fa-music"></i></div>
            <div class="stat-mini-info">
                <h4>Choir Members</h4>
                <div class="stat-mini-number">{{ number_format($choirCount ?? 0) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon warning"><i class="fas fa-birthday-cake"></i></div>
            <div class="stat-mini-info">
                <h4>Birthdays This Month</h4>
                <div class="stat-mini-number">{{ number_format($birthdaysThisMonth ?? 0) }}</div>
            </div>
        </div>

        <div class="stat-mini-card">
            <div class="stat-mini-icon info"><i class="fas fa-church"></i></div>
            <div class="stat-mini-info">
                <h4>Active Ministries</h4>
                <div class="stat-mini-number">{{ number_format($activeMinistries ?? count($allRoles ?? [])) }}</div>
            </div>
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="filter-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span class="filter-label"><i class="fas fa-filter me-1"></i> Filter by Ministry</span>
                <select id="roleFilter" class="filter-select" onchange="window.location.href=this.value">
                    <option value="{{ route('members.index', ['role' => 'all']) }}" {{ ($currentFilter ?? 'all') == 'all' ? 'selected' : '' }}>
                        📋 All Members
                    </option>
                    @php
                        // Get unique roles by name, removing duplicates
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
                <div class="total-badge">
                    <i class="fas fa-church"></i>
                    Total Active: {{ number_format($members->total() ?? 0) }}
                </div>
            </div>
        </div>
    </div>

    {{-- TABS NAVIGATION --}}
    <div class="member-tabs">
        <button class="member-tab active" onclick="switchTable('active')">
            <i class="fas fa-user-friends me-2"></i>Active
            <span class="badge">{{ number_format($members->total() ?? 0) }}</span>
        </button>
        <button class="member-tab" onclick="switchTable('deceased')">
            <i class="fas fa-cross me-2"></i>Deceased
            <span class="badge">{{ number_format($deceasedCount ?? 0) }}</span>
        </button>
    </div>

    {{-- ============================================= --}}
    {{-- ACTIVE MEMBERS TABLE --}}
    {{-- ============================================= --}}
    <div id="activeMembersTable" class="table-section active-section">
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No.</th>
                            <th>Member Information</th>
                            <th>Roles</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th style="width: 110px;">
                                <a href="{{ route('members.create') }}" class="btn-add-in-table">
                                    <i class="fas fa-plus"></i> Add
                                </a>
                            </th>
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
                                
                                // Get unique roles
                                $memberRoles = $member->roles ?? [];
                                $uniqueRoles = collect($memberRoles)->unique('name')->values()->all();
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
                                
                                {{-- Member Info Column --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-wrapper">
                                            <div class="member-avatar {{ $member->is_deceased ? 'deceased' : '' }}">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="member-name">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                                @if($isBirthdayThisWeek) <span style="font-size: 0.7rem;">🎂</span> @endif
                                            </div>
                                            @if($member->phone)
                                                <div class="member-phone"><i class="fas fa-phone"></i> {{ $member->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Roles Column --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($uniqueRoles as $role)
                                            <span class="role-tag"><i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}</span>
                                        @empty
                                            <span class="role-tag"><i class="fas fa-user"></i> Regular</span>
                                        @endforelse
                                        @if($member->is_choir)
                                            <span class="role-tag choir"><i class="fas fa-music"></i> Choir</span>
                                        @endif
                                    </div>
                                </td>
                                
                                {{-- Birthday Column --}}
                                <td>@if($member->birthday) {{ \Carbon\Carbon::parse($member->birthday)->format('M d') }} @else <span class="text-muted">—</span> @endif</td>
                                
                                {{-- Age Column --}}
                                <td>@if($age) {{ $age }} @else <span class="text-muted">—</span> @endif</td>
                                
                                {{-- Actions Column --}}
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('members.edit', $member->id) }}" class="btn-icon-action" title="Edit Member" onclick="event.stopPropagation();">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(!$member->is_deceased)
                                        <button type="button" class="btn-icon-action deceased" title="Mark as Deceased" 
                                                onclick="event.stopPropagation(); openDeceasedModal({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-cross"></i>
                                        </button>
                                        @endif
                                        <button type="button" class="btn-icon-action delete" title="Delete Member" 
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
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <h5>No Members Yet</h5>
                                        <p>Get started by adding your first church member to the system.</p>
                                        <a href="{{ route('members.create') }}" class="btn-add-in-table" style="padding: 0.5rem 1.5rem; font-size: 0.75rem; margin-top: 0.5rem;">
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
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <strong>{{ $members->firstItem() }}</strong> to <strong>{{ $members->lastItem() }}</strong> of <strong>{{ $members->total() }}</strong> members
                </div>
                {{ $members->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- DECEASED MEMBERS TABLE --}}
    {{-- ============================================= --}}
    <div id="deceasedMembersTable" class="table-section">
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;">No.</th>
                            <th>Member Information</th>
                            <th>Roles</th>
                            <th>Birthday</th>
                            <th>Age</th>
                            <th style="width: 80px;">Actions</th>
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
                                
                                {{-- Member Info Column --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-wrapper">
                                            <div class="member-avatar deceased">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="member-name">{{ $member->first_name }} {{ $member->last_name }}</div>
                                            <div class="deceased-date">
                                                <i class="fas fa-cross me-1"></i> {{ \Carbon\Carbon::parse($member->date_deceased)->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Roles Column --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @forelse($uniqueRoles as $role)
                                            <span class="role-tag"><i class="fas fa-tag"></i> {{ $role['name'] ?? $role }}</span>
                                        @empty
                                            <span class="role-tag"><i class="fas fa-user"></i> Regular</span>
                                        @endforelse
                                        @if($member->is_choir)
                                            <span class="role-tag choir"><i class="fas fa-music"></i> Choir</span>
                                        @endif
                                    </div>
                                </td>
                                
                                {{-- Birthday Column --}}
                                <td>@if($member->birthday) {{ \Carbon\Carbon::parse($member->birthday)->format('M d') }} @else <span class="text-muted">—</span> @endif</td>
                                
                                {{-- Age Column --}}
                                <td>@if($ageAtDeath) {{ $ageAtDeath }} @else <span class="text-muted">—</span> @endif</td>
                                
                                {{-- Actions Column --}}
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn-icon-action restore" title="Restore to Active" 
                                                onclick="event.stopPropagation(); confirmRestore({{ $member->id }}, '{{ addslashes($member->first_name . ' ' . $member->last_name) }}')">
                                            <i class="fas fa-undo-alt"></i>
                                        </button>
                                        <button type="button" class="btn-icon-action delete" title="Delete Permanently" 
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
                                <td colspan="6">
                                    <div class="empty-state">
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
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <strong>{{ $deceasedMembers->firstItem() }}</strong> to <strong>{{ $deceasedMembers->lastItem() }}</strong> of <strong>{{ $deceasedMembers->total() }}</strong> deceased members
                </div>
                {{ $deceasedMembers->links() }}
            </div>
            @elseif(isset($deceasedMembers) && $deceasedMembers->count() > 0)
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <strong>{{ $deceasedMembers->count() }}</strong> deceased members
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- MEMBER DETAILS MODAL --}}
{{-- ============================================= --}}
<div class="member-modal-overlay" id="memberModal">
    <div class="member-modal">
        <div class="modal-header-custom">
            <button class="close-modal" onclick="closeMemberModal()">&times;</button>
            <div class="modal-avatar-large">
                <i class="fas fa-user"></i>
            </div>
            <div class="modal-name" id="modalMemberName">Member Name</div>
            <div class="modal-status" id="modalMemberStatus">Active</div>
        </div>
        <div class="modal-body-custom">
            <div class="modal-info-grid">
                <div class="modal-info-item">
                    <div class="label"><i class="far fa-calendar-alt"></i> Birthday</div>
                    <div class="value" id="modalBirthday">—</div>
                </div>
                <div class="modal-info-item">
                    <div class="label"><i class="far fa-clock"></i> Age</div>
                    <div class="value" id="modalAge">—</div>
                </div>
                <div class="modal-info-item" style="grid-column: span 2;">
                    <div class="label"><i class="fas fa-phone"></i> Phone</div>
                    <div class="value" id="modalPhone">—</div>
                </div>
                <div class="modal-info-item" style="grid-column: span 2;">
                    <div class="label"><i class="fas fa-map-marker-alt"></i> Address</div>
                    <div class="value" id="modalAddress">—</div>
                </div>
                <div class="modal-info-item" style="grid-column: span 2;">
                    <div class="label"><i class="fas fa-tags"></i> Roles</div>
                    <div class="modal-roles" id="modalRoles">
                        <span class="modal-role-tag">Regular Member</span>
                    </div>
                </div>
            </div>
            
            <div class="modal-actions">
                <a href="#" class="modal-btn edit" id="modalEditBtn">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="modal-btn deceased" id="modalDeceasedBtn" onclick="event.stopPropagation(); markDeceasedFromModal()">
                    <i class="fas fa-cross"></i> Deceased
                </button>
                <button class="modal-btn delete" onclick="event.stopPropagation(); deleteFromModal()">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================= --}}
{{-- SCRIPTS SECTION --}}
{{-- ============================================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // =============================================
    // MEMBER DETAILS MODAL - DISPLAY FROM DATA ATTRIBUTES
    // =============================================
    let currentMemberId = null;
    let currentMemberName = '';
    let currentMemberIsDeceased = false;
    
    function openMemberModal(row) {
        // Get data from data attributes
        const memberId = row.dataset.memberId;
        const memberName = row.dataset.memberName;
        const birthday = row.dataset.memberBirthday || '—';
        const age = row.dataset.memberAge || '—';
        const address = row.dataset.memberAddress || '—';
        const phone = row.dataset.memberPhone || '—';
        const isChoir = row.dataset.memberIschoir === 'true';
        const isDeceased = row.dataset.memberIsdeceased === 'true';
        
        let roles = [];
        try {
            roles = JSON.parse(row.dataset.memberRoles) || [];
        } catch (e) {
            roles = [];
        }
        
        currentMemberId = memberId;
        currentMemberName = memberName;
        currentMemberIsDeceased = isDeceased;
        
        // Populate modal
        document.getElementById('modalMemberName').textContent = memberName;
        document.getElementById('modalMemberStatus').textContent = isDeceased ? 'Deceased' : 'Active';
        document.getElementById('modalBirthday').textContent = birthday;
        document.getElementById('modalAge').textContent = age ? age : '—';
        document.getElementById('modalPhone').textContent = phone ? phone : '—';
        document.getElementById('modalAddress').textContent = address;
        document.getElementById('modalEditBtn').href = `/members/${memberId}/edit`;
        
        // Show/hide deceased button
        const deceasedBtn = document.getElementById('modalDeceasedBtn');
        if (isDeceased) {
            deceasedBtn.style.display = 'none';
        } else {
            deceasedBtn.style.display = 'flex';
        }
        
        // Populate roles
        const rolesContainer = document.getElementById('modalRoles');
        rolesContainer.innerHTML = '';
        
        if (roles && roles.length > 0) {
            // Remove duplicates by name
            const uniqueRoles = roles.filter((role, index, self) => 
                index === self.findIndex(r => r.name === role.name)
            );
            
            uniqueRoles.forEach(role => {
                const tag = document.createElement('span');
                tag.className = 'modal-role-tag' + (isChoir ? ' choir' : '');
                tag.textContent = role.name;
                rolesContainer.appendChild(tag);
            });
        } else {
            const tag = document.createElement('span');
            tag.className = 'modal-role-tag';
            tag.textContent = 'Regular Member';
            rolesContainer.appendChild(tag);
        }
        
        if (isChoir) {
            const tag = document.createElement('span');
            tag.className = 'modal-role-tag choir';
            tag.textContent = 'Choir';
            rolesContainer.appendChild(tag);
        }
        
        // Show modal
        document.getElementById('memberModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeMemberModal() {
        document.getElementById('memberModal').classList.remove('active');
        document.body.style.overflow = '';
        currentMemberId = null;
        currentMemberName = '';
        currentMemberIsDeceased = false;
    }
    
    function markDeceasedFromModal() {
        if (currentMemberId) {
            closeMemberModal();
            openDeceasedModal(currentMemberId, currentMemberName);
        }
    }
    
    function deleteFromModal() {
        if (currentMemberId) {
            closeMemberModal();
            confirmDelete(currentMemberId, currentMemberName);
        }
    }
    
    // =============================================
    // TABLE SWITCHING FUNCTION
    // =============================================
    function switchTable(tableType) {
        const tabs = document.querySelectorAll('.member-tab');
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
    // CLICKABLE ROWS - DISPLAY MODAL INSTANTLY
    // =============================================
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.member-row').forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on action buttons or their children
                if (e.target.closest('.btn-icon-action') || e.target.closest('.action-buttons')) {
                    return;
                }
                openMemberModal(this);
            });
        });
    });
    
    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMemberModal();
        }
    });
    
    // Close modal on overlay click
    document.getElementById('memberModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMemberModal();
        }
    });
    
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