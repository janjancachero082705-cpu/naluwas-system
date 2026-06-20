@extends('layouts.app')

@section('header', 'Manage Choir Groups')

@section('content')
<style>
    /* ============================================
       CLEAN UI - SAME STYLE AS OTHER PAGES
    ============================================ */
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .stat-icon {
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
    
    .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .stat-icon.blue { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .stat-icon.green { background: linear-gradient(135deg, #10b981, #34d399); }
    
    .stat-info {
        flex: 1;
    }
    
    .stat-info h4 {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin: 0 0 3px 0;
        font-weight: 600;
    }
    
    .stat-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .stat-trend {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    
    /* Hero Section - Green */
    .choir-hero {
        background: linear-gradient(135deg, #10b981, #059669);
        border-radius: 12px;
        padding: 1.2rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        position: relative;
        overflow: hidden;
    }
    
    .choir-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .choir-hero h1 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: white;
        position: relative;
        z-index: 1;
    }
    
    .choir-hero h1 i {
        margin-right: 8px;
    }
    
    .choir-hero p {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 0.75rem;
        position: relative;
        z-index: 1;
    }
    
    .hero-left {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .btn-hero {
        background: white;
        color: #059669;
        border-radius: 8px;
        padding: 0.4rem 1.2rem;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        position: relative;
        z-index: 1;
    }
    
    .btn-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        color: #059669;
        text-decoration: none;
    }
    
    /* Cards */
    .card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .card-header h5 {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }
    
    .card-header h5 i {
        color: #10b981;
        margin-right: 6px;
    }
    
    .card-body {
        padding: 1.2rem;
    }
    
    /* Form Controls */
    .form-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .form-control, .form-select, textarea {
        width: 100%;
        padding: 0.5rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus, textarea:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .form-control::placeholder, textarea::placeholder {
        color: var(--text-muted);
    }
    
    textarea {
        resize: vertical;
        min-height: 60px;
    }
    
    .form-check-input {
        width: 16px;
        height: 16px;
        margin-top: 0.15rem;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background: var(--input-bg);
        cursor: pointer;
    }
    
    .form-check-input:checked {
        background-color: #10b981;
        border-color: #10b981;
    }
    
    .form-check-label {
        font-size: 0.8rem;
        color: var(--text-primary);
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(16,185,129,0.3);
        color: white;
    }
    
    .btn-secondary {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        padding: 0.4rem 1rem;
        border-radius: 8px;
        color: var(--text-secondary);
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-secondary:hover {
        background: var(--hover-bg);
        transform: translateY(-1px);
    }
    
    .btn-sm {
        padding: 0.25rem 0.6rem;
        font-size: 0.6rem;
        border-radius: 6px;
    }
    
    .btn-outline-warning {
        background: transparent;
        border: 1px solid #f59e0b;
        color: #f59e0b;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.6rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .btn-outline-warning:hover {
        background: #f59e0b;
        color: white;
    }
    
    .btn-outline-danger {
        background: transparent;
        border: 1px solid #ef4444;
        color: #ef4444;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.6rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .btn-outline-danger:hover {
        background: #ef4444;
        color: white;
    }
    
    /* Group Cards */
    .group-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }
    
    .group-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .color-preview {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-block;
        flex-shrink: 0;
    }
    
    .group-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }
    
    .group-desc {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin: 0;
    }
    
    /* Member Chips */
    .member-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: var(--bg-tertiary);
        border-radius: 20px;
        font-size: 0.7rem;
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        transition: all 0.15s ease;
    }
    
    .member-chip:hover {
        background: var(--hover-bg);
    }
    
    .member-chip .remove-btn {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 0;
        font-size: 0.6rem;
        transition: all 0.2s ease;
    }
    
    .member-chip .remove-btn:hover {
        color: #ef4444;
    }
    
    .role-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    
    .role-dot.singer { background: #10b981; }
    .role-dot.guitarist { background: #f59e0b; }
    .role-dot.bassist { background: #3b82f6; }
    .role-dot.drummer { background: #ef4444; }
    .role-dot.default { background: #8b5cf6; }
    
    /* Rotation Order */
    .rotation-container {
        background: var(--bg-tertiary);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .rotation-item {
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        padding: 0.8rem 1rem;
        transition: all 0.15s ease;
        cursor: grab;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .rotation-item:last-child {
        border-bottom: none;
    }
    
    .rotation-item:hover {
        background: var(--bg-tertiary);
    }
    
    .rotation-item.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    
    .drag-handle {
        cursor: grab;
        color: var(--text-muted);
        font-size: 0.9rem;
        transition: color 0.2s ease;
        padding: 4px;
    }
    
    .drag-handle:hover {
        color: var(--text-primary);
    }
    
    .rotation-item .position-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.7rem;
        color: white;
        flex-shrink: 0;
    }
    
    .rotation-item .color-preview-sm {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        display: inline-block;
        flex-shrink: 0;
    }
    
    .rotation-item .group-name-text {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--text-primary);
    }
    
    .rotation-item .member-count-text {
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .rotation-item .position-label {
        font-size: 0.6rem;
        background: var(--bg-tertiary);
        padding: 2px 10px;
        border-radius: 20px;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }
    
    /* Alerts */
    .alert {
        padding: 0.8rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }
    
    .alert-info {
        background: rgba(16, 185, 129, 0.08);
        border-color: rgba(16, 185, 129, 0.15);
    }
    
    .alert-info i { color: #10b981; }
    
    .alert-success {
        background: rgba(16, 185, 129, 0.08);
        border-color: rgba(16, 185, 129, 0.15);
    }
    
    .alert-success i { color: #10b981; }
    
    .alert-danger {
        background: rgba(239, 68, 68, 0.08);
        border-color: rgba(239, 68, 68, 0.15);
    }
    
    .alert-danger i { color: #ef4444; }
    
    .btn-close {
        background: none;
        border: none;
        color: var(--text-muted);
        font-size: 0.8rem;
        cursor: pointer;
        margin-left: auto;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .btn-close:hover {
        background: var(--hover-bg);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        opacity: 0.3;
        color: #10b981;
    }
    
    .empty-state h5 {
        color: var(--text-primary);
        margin-bottom: 0.3rem;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .empty-state p {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    /* Modal */
    .modal-content {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
    }
    
    .modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .modal-header .modal-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .modal-header .modal-title i {
        color: #10b981;
        margin-right: 6px;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
    }
    
    .badge-success {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
    }
    
    .badge-info {
        background: rgba(59, 130, 246, 0.12);
        color: #3b82f6;
    }
    
    .badge-secondary {
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }
    
    /* Tips Card */
    .tips-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .tips-list li {
        padding: 0.3rem 0;
        font-size: 0.75rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .tips-list li i {
        color: #10b981;
        font-size: 0.8rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .stat-value {
            font-size: 1.1rem;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        .choir-hero {
            text-align: center;
            padding: 1rem 1.2rem;
            flex-direction: column;
        }
        .choir-hero h1 {
            font-size: 1rem;
        }
        .hero-left {
            align-items: center;
        }
        .btn-hero {
            width: 100%;
            justify-content: center;
        }
        .rotation-item {
            flex-wrap: wrap;
        }
        .member-chip {
            font-size: 0.6rem;
            padding: 3px 8px;
        }
        .group-card .row {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Hero Section - Green -->
    <div class="choir-hero">
        <div class="hero-left">
            <h1><i class="fas fa-layer-group"></i> Choir Groups</h1>
            <p>Create groups and set rotation order for automatic scheduling</p>
        </div>
        <a href="{{ route('choir-schedules.index') }}" class="btn-hero">
            <i class="fas fa-arrow-left me-2"></i> Back to Schedule
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-layer-group"></i></div>
            <div class="stat-info">
                <h4>Total Groups</h4>
                <div class="stat-value">{{ $groups->count() }}</div>
                <div class="stat-trend">Active groups</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4>Total Members</h4>
                <div class="stat-value">{{ isset($unassignedMembers) ? $groups->sum(function($g) { return $g->members->count(); }) + $unassignedMembers->count() : $groups->sum(function($g) { return $g->members->count(); }) }}</div>
                <div class="stat-trend">Assigned to groups</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <h4>Assigned Members</h4>
                <div class="stat-value">{{ $groups->sum(function($g) { return $g->members->count(); }) }}</div>
                <div class="stat-trend">In rotation</div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
    </div>
    @endif

    <div class="row">
        <!-- Create Group Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus-circle"></i> Create New Group</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('choir-schedules.groups.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Group Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Worship Team A" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Color</label>
                            <div class="d-flex gap-3 align-items-center">
                                <input type="color" name="color" class="form-control" style="width: 60px; height: 38px; padding: 2px;" value="#10b981">
                                <span class="text-muted" style="font-size: 0.7rem;">Choose a distinctive color</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Optional description for this group"></textarea>
                        </div>

                        <button type="submit" class="btn-primary w-100">
                            <i class="fas fa-plus me-2"></i> Create Group
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card">
                <div class="card-body">
                    <h6 class="fw-bold mb-2" style="font-size: 0.85rem; color: var(--text-primary);">
                        <i class="fas fa-lightbulb me-2" style="color: #f59e0b;"></i>How Rotation Works
                    </h6>
                    <ul class="tips-list">
                        <li><i class="fas fa-1"></i> Create your groups (A, B, C, etc.)</li>
                        <li><i class="fas fa-2"></i> Assign members to each group</li>
                        <li><i class="fas fa-3"></i> Set rotation order by dragging below</li>
                        <li><i class="fas fa-4"></i> System auto-rotates every Sunday</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Groups List and Rotation Order -->
        <div class="col-lg-8">
            <!-- Rotation Order Section -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-sort-amount-down-alt"></i> Group Rotation Order</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Drag and drop</strong> to set the rotation order. Groups will rotate in this order every Sunday.
                            <br>
                            <small class="text-muted">Example: Group C → A → E → B → D</small>
                        </div>
                    </div>

                    <div id="rotation-order-container">
                        <div id="rotation-list" class="rotation-container">
                            @forelse($groups as $index => $group)
                            <div class="rotation-item" data-group-id="{{ $group->id }}" data-position="{{ $index }}">
                                <div class="drag-handle">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                <div class="position-badge" style="background: {{ $group->color ?? '#10b981' }};">
                                    {{ $index + 1 }}
                                </div>
                                <div class="color-preview-sm" style="background: {{ $group->color ?? '#10b981' }};"></div>
                                <div class="flex-grow-1">
                                    <div class="group-name-text">{{ $group->name }}</div>
                                    <div class="member-count-text">
                                        <i class="fas fa-users me-1"></i>{{ $group->members->count() }} members
                                    </div>
                                </div>
                                <span class="position-label">Position {{ $index + 1 }}</span>
                            </div>
                            @empty
                            <div class="empty-state">
                                <i class="fas fa-layer-group"></i>
                                <p>No groups yet. Create your first group above.</p>
                            </div>
                            @endforelse
                        </div>

                        @if($groups->count() > 0)
                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn-primary" onclick="saveRotationOrder()">
                                <i class="fas fa-save me-2"></i> Save Rotation Order
                            </button>
                            <button type="button" class="btn-secondary" onclick="resetRotationOrder()">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Existing Groups List -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-list"></i> Manage Members per Group</h5>
                    <span class="badge badge-info">{{ $groups->count() }} Groups</span>
                </div>
                <div class="card-body">
                    @if(isset($unassignedMembers) && $unassignedMembers->count() > 0)
                    <div class="alert alert-info alert-dismissible fade show">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>{{ $unassignedMembers->count() }} members</strong> are not assigned to any group.
                            Please assign them below.
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
                    </div>
                    @endif

                    @forelse($groups as $group)
                    <div class="group-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="color-preview" style="background: {{ $group->color ?? '#10b981' }};"></div>
                                <div>
                                    <h5 class="group-name">{{ $group->name }}</h5>
                                    @if($group->description)
                                        <p class="group-desc">{{ $group->description }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <button class="btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editGroupModal{{ $group->id }}" title="Edit Group">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-outline-danger btn-sm" onclick="deleteGroup({{ $group->id }}, '{{ $group->name }}')" title="Delete Group">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge badge-info">
                                <i class="fas fa-users me-1"></i> {{ $group->members->count() }} Members
                            </span>
                            <span class="badge badge-success">
                                <i class="fas fa-microphone-alt me-1"></i> {{ $group->members->whereNotNull('choir_role')->count() }} Roles
                            </span>
                            <span class="badge {{ $group->is_active ? 'badge-success' : 'badge-secondary' }}">
                                <i class="fas {{ $group->is_active ? 'fa-check-circle' : 'fa-minus-circle' }} me-1"></i>
                                {{ $group->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <hr style="border-color: var(--border-color);">

                        <h6 class="fw-bold mb-2" style="font-size: 0.8rem; color: var(--text-primary);">
                            <i class="fas fa-users me-2"></i>Members in this group
                            <span class="badge badge-secondary ms-2">{{ $group->members->count() }}</span>
                        </h6>

                        <div class="d-flex flex-wrap gap-2 mb-3" id="membersList{{ $group->id }}">
                            @if($group->members->count() > 0)
                                @foreach($group->members as $member)
                                <div class="member-chip" id="member-{{ $member->id }}">
                                    <span class="role-dot {{ strtolower($member->choir_role ?? 'default') }}"></span>
                                    <span>{{ $member->first_name }} {{ $member->last_name }}</span>
                                    <small class="text-muted">({{ $member->choir_role ?? 'Singer' }})</small>
                                    <button class="remove-btn" onclick="removeMemberFromGroup({{ $member->id }})" title="Remove from group">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted" style="font-size: 0.75rem;">No members assigned to this group yet.</p>
                            @endif
                        </div>

                        <div class="row g-2">
                            <div class="col">
                                <select class="form-select form-select-sm" id="memberSelect{{ $group->id }}">
                                    <option value="">Select member to add...</option>
                                    @if(isset($unassignedMembers) && $unassignedMembers->count() > 0)
                                        @foreach($unassignedMembers as $member)
                                            @if(!$group->members->contains($member->id))
                                            <option value="{{ $member->id }}">
                                                {{ $member->first_name }} {{ $member->last_name }} 
                                                ({{ $member->choir_role ?? 'Singer' }})
                                            </option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="" disabled>No unassigned members available</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-auto">
                                <button class="btn-primary btn-sm" onclick="addMemberToGroup({{ $group->id }})">
                                    <i class="fas fa-plus"></i> Add Member
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editGroupModal{{ $group->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('choir-schedules.groups.update', $group->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="fas fa-edit"></i> Edit Group: {{ $group->name }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Group Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Color</label>
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="color" name="color" class="form-control" style="width: 60px; height: 38px; padding: 2px;" value="{{ $group->color ?? '#10b981' }}">
                                                <div class="color-preview" style="background: {{ $group->color ?? '#10b981' }};"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="2">{{ $group->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $group->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label">
                                                    <i class="fas fa-check-circle me-1" style="color: #10b981;"></i>
                                                    Active (Include in rotation)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <i class="fas fa-layer-group"></i>
                        <h5>No Groups Yet</h5>
                        <p>Create your first choir group to start scheduling.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    let sortable;
    let originalOrder = [];

    document.addEventListener('DOMContentLoaded', function() {
        const rotationList = document.getElementById('rotation-list');

        if (rotationList && rotationList.children.length > 0) {
            originalOrder = Array.from(rotationList.children).map(item => item.dataset.groupId);

            sortable = new Sortable(rotationList, {
                animation: 300,
                handle: '.drag-handle',
                ghostClass: 'dragging',
                onEnd: function() {
                    updatePositions();
                }
            });
        }
    });

    function updatePositions() {
        const items = document.querySelectorAll('#rotation-list .rotation-item');
        items.forEach((item, index) => {
            const positionBadge = item.querySelector('.position-badge');
            const positionLabel = item.querySelector('.position-label');

            if (positionBadge) {
                positionBadge.textContent = index + 1;
            }
            if (positionLabel) {
                positionLabel.textContent = `Position ${index + 1}`;
            }
        });
    }

    function saveRotationOrder() {
        const items = document.querySelectorAll('#rotation-list .rotation-item');
        const order = Array.from(items).map(item => item.dataset.groupId);

        if (order.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Groups',
                text: 'Please create groups first.',
                confirmButtonColor: '#10b981',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
            return;
        }

        Swal.fire({
            title: 'Save Rotation Order?',
            text: 'This will update all Sunday schedules based on the new rotation order.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel',
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Updating...',
                    text: 'Please wait while we update the schedules.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); },
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });

                fetch('{{ route("choir-schedules.update-rotation") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Rotation order saved! Schedules updated.',
                            timer: 2000,
                            showConfirmButton: false,
                            background: 'var(--card-bg)',
                            color: 'var(--text-primary)'
                        }).then(() => {
                            window.location.href = '{{ route("choir-schedules.index") }}';
                        });
                    } else {
                        throw new Error(data.message || 'Failed to save');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message,
                        confirmButtonColor: '#10b981',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                });
            }
        });
    }

    function resetRotationOrder() {
        if (originalOrder.length === 0) return;

        Swal.fire({
            title: 'Reset Rotation Order?',
            text: 'This will restore the original rotation order.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, reset',
            cancelButtonText: 'Cancel',
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                const rotationList = document.getElementById('rotation-list');
                const items = Array.from(rotationList.children);
                items.sort((a, b) => originalOrder.indexOf(a.dataset.groupId) - originalOrder.indexOf(b.dataset.groupId));
                items.forEach(item => rotationList.appendChild(item));
                updatePositions();
                Swal.fire({
                    icon: 'success',
                    title: 'Reset Complete',
                    text: 'Rotation order has been reset.',
                    timer: 1500,
                    showConfirmButton: false,
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            }
        });
    }

    function addMemberToGroup(groupId) {
        let select = document.getElementById(`memberSelect${groupId}`);
        let memberId = select.value;

        if (!memberId) {
            Swal.fire({
                icon: 'warning',
                title: 'No Member Selected',
                text: 'Please select a member to add.',
                confirmButtonColor: '#10b981',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
            return;
        }

        let button = event?.target;
        let originalText = button ? button.innerHTML : '';

        if (button) {
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            button.disabled = true;
        }

        fetch('{{ route("choir-schedules.assign-member") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ member_id: memberId, group_id: groupId })
        })
        .then(response => response.json())
        .then(data => {
            if (button) {
                button.innerHTML = originalText;
                button.disabled = false;
            }
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Member Added!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false,
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                }).then(() => { location.reload(); });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to add member',
                    confirmButtonColor: '#10b981',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            }
        })
        .catch(() => {
            if (button) {
                button.innerHTML = originalText;
                button.disabled = false;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong.',
                confirmButtonColor: '#10b981',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
        });
    }

    function removeMemberFromGroup(memberId) {
        Swal.fire({
            title: 'Remove Member?',
            text: 'This member will be removed from the group.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove',
            cancelButtonText: 'Cancel',
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Removing...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); },
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });

                fetch(`{{ url('choir-schedules/remove-member') }}/${memberId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false,
                            background: 'var(--card-bg)',
                            color: 'var(--text-primary)'
                        }).then(() => { location.reload(); });
                    } else {
                        throw new Error(data.message || 'Failed to remove member');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message,
                        confirmButtonColor: '#10b981',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                });
            }
        });
    }

    function deleteGroup(groupId, groupName) {
        Swal.fire({
            title: 'Delete Group?',
            html: `Are you sure you want to delete <strong>${groupName}</strong>?<br><br><span style="color: #f59e0b;">⚠️ Members will be unassigned but not deleted.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete group',
            cancelButtonText: 'Cancel',
            background: 'var(--card-bg)',
            color: 'var(--text-primary)'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('choir-schedules/groups') }}/${groupId}`;
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                let closeButton = alert.querySelector('.btn-close');
                if (closeButton) closeButton.click();
            });
        }, 5000);
    });
</script>
@endsection