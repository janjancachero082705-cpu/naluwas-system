@extends('layouts.app')

@section('header', 'Choir Ministry')

@section('content')
<style>
    /* ============================================
       CLEAN UI - SAME STYLE AS MEMBER PAGE
    ============================================ */
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
    .stat-icon.green { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.blue { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    
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
    
    /* Voice Filter Bar */
    .voice-filter-bar {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 0.7rem 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    
    .filter-label {
        font-size: 0.65rem;
        font-weight: 600;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .filter-label i {
        color: #10b981;
    }
    
    .voice-filters {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
    }
    
    .voice-filter-btn {
        padding: 0.25rem 0.8rem;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
    }
    
    .voice-filter-btn:hover {
        background: rgba(16, 185, 129, 0.1);
        border-color: #10b981;
        color: #10b981;
    }
    
    .voice-filter-btn.active {
        background: linear-gradient(135deg, #10b981, #059669);
        border-color: #10b981;
        color: white;
    }
    
    .members-count {
        font-size: 0.6rem;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
    }
    
    /* Table Container */
    .table-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .table-container .card-header-custom {
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .table-container .card-header-custom h6 {
        color: var(--text-primary);
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
    }
    
    .table-container .card-header-custom h6 i {
        color: #10b981;
        margin-right: 6px;
    }
    
    .table {
        margin-bottom: 0;
        width: 100%;
        background: var(--card-bg);
        border-collapse: collapse;
    }
    
    .table thead th {
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-muted) !important;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 0.7rem 1rem;
        white-space: nowrap;
    }
    
    .table thead th i {
        margin-right: 4px;
        font-size: 0.6rem;
    }
    
    .table tbody td {
        padding: 0.6rem 1rem;
        vertical-align: middle;
        color: var(--text-primary) !important;
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        font-size: 0.8rem;
    }
    
    .table tbody tr {
        transition: all 0.15s ease;
    }
    
    .table tbody tr:hover {
        background: var(--bg-tertiary) !important;
    }
    
    .table tbody tr:hover td {
        background: var(--bg-tertiary) !important;
    }
    
    /* Member Avatar - Same as Member Table */
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
    
    .member-name-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .member-name-text {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.85rem;
        margin-bottom: 1px;
    }
    
    .member-sub-text {
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    /* Voice Badge - Green accent */
    .voice-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 600;
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }
    
    .voice-badge i {
        font-size: 0.5rem;
        opacity: 0.7;
    }
    
    .voice-badge.soprano {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.2);
    }
    
    .voice-badge.alto {
        background: rgba(139, 92, 246, 0.12);
        color: #8b5cf6;
        border-color: rgba(139, 92, 246, 0.2);
    }
    
    .voice-badge.tenor {
        background: rgba(59, 130, 246, 0.12);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.2);
    }
    
    .voice-badge.bass {
        background: rgba(239, 68, 68, 0.12);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }
    
    /* Action Buttons - Same as Member Table */
    .action-buttons {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }
    
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
    }
    
    .btn-icon-action:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        transform: translateY(-1px);
    }
    
    .btn-icon-action.edit:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-color: #10b981;
    }
    
    .btn-icon-action.delete:hover {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }
    
    .btn-add-in-table {
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        padding: 0.2rem 0.8rem;
        border-radius: 6px;
        font-size: 0.6rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
        text-decoration: none;
        position: relative;
        z-index: 5;
    }
    
    .btn-add-in-table:hover {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border-color: #10b981;
        transform: translateY(-1px);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2.5rem;
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
        font-size: 0.6rem;
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
        font-size: 0.6rem;
        padding: 3px 8px;
        transition: all 0.2s ease;
    }
    
    .page-link:hover {
        background: var(--bg-tertiary);
        border-color: #10b981;
        color: #10b981;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981, #059669);
        border-color: #10b981;
        color: white;
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
        .voice-filter-bar {
            flex-direction: column;
            align-items: flex-start;
        }
        .voice-filters {
            width: 100%;
            justify-content: center;
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
        .table thead th,
        .table tbody td {
            padding: 0.4rem 0.6rem;
            font-size: 0.65rem;
        }
        .member-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.6rem;
        }
        .member-name-text {
            font-size: 0.75rem;
        }
        .pagination-container {
            flex-direction: column;
            text-align: center;
        }
        .action-buttons {
            gap: 3px;
        }
        .btn-icon-action {
            width: 24px;
            height: 24px;
            font-size: 0.55rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Hero Section - Green -->
    <div class="choir-hero">
        <div class="hero-left">
            <h1><i class="fas fa-music"></i> Choir Ministry</h1>
            <p>Manage and organize your church choir members</p>
        </div>
        <a href="{{ route('choir-members.create') }}" class="btn-hero">
            <i class="fas fa-user-plus"></i> Add Choir Member
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4>Total Members</h4>
                <div class="stat-value">{{ $totalChoirMembers ?? $choir_members->total() ?? $choir_members->count() ?? 0 }}</div>
                <div class="stat-trend">Lifting voices in praise</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div class="stat-info">
                <h4>Active Members</h4>
                <div class="stat-value">{{ $activeCount ?? $choir_members->count() ?? 0 }}</div>
                <div class="stat-trend">Regular attendees</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-church"></i></div>
            <div class="stat-info">
                <h4>Voice Parts</h4>
                <div class="stat-value">{{ $voicePartsCount ?? 4 }}</div>
                <div class="stat-trend">SATB arrangement</div>
            </div>
        </div>
    </div>

    <!-- Voice Filter Bar -->
    <div class="voice-filter-bar">
        <div class="filter-label">
            <i class="fas fa-filter"></i> Filter by Voice Part:
        </div>
        <div class="voice-filters" id="voiceFilters">
            <button class="voice-filter-btn active" data-voice="all">All Voices</button>
            <button class="voice-filter-btn" data-voice="soprano">🎵 Soprano</button>
            <button class="voice-filter-btn" data-voice="alto">🎵 Alto</button>
            <button class="voice-filter-btn" data-voice="tenor">🎵 Tenor</button>
            <button class="voice-filter-btn" data-voice="bass">🎵 Bass</button>
        </div>
        <div class="members-count">
            <i class="fas fa-users me-1"></i> <span id="visibleCount">0</span> members
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <div class="card-header-custom">
            <h6>
                <i class="fas fa-users"></i> Choir Members List
                <span style="font-weight: 400; font-size: 0.7rem; color: var(--text-muted); margin-left: 6px;">
                    ({{ $choir_members->count() ?? 0 }} members)
                </span>
            </h6>
        </div>
        <div class="table-responsive">
            <table class="table" id="choirMembersTable">
                <thead>
                    <tr>
                        <th style="width: 50px;"><i class="fas fa-hashtag"></i> No.</th>
                        <th><i class="fas fa-user"></i> Member</th>
                        <th><i class="fas fa-microphone-alt"></i> Voice Part</th>
                        <th><i class="fas fa-birthday-cake"></i> Birthday</th>
                        <th><i class="fas fa-calendar-alt"></i> Age</th>
                        <th style="width: 100px;"><i class="fas fa-cog"></i> Actions</th>
                    </tr>
                </thead>
                <tbody id="choirMembersBody">
                    @forelse($choir_members as $index => $member)
                    @php
                        $age = $member->birthday ? \Carbon\Carbon::parse($member->birthday)->age : null;
                        $voicePart = strtolower($member->voice_part ?? '');
                        $voiceClass = $voicePart ?: 'default';
                    @endphp
                    <tr data-voice="{{ $voicePart }}">
                        <td class="text-muted" style="font-size: 0.75rem;">{{ $choir_members->firstItem() + $index }}</td>
                        <td>
                            <div class="member-name-cell">
                                <div class="member-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="member-name-text">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                                    @if($member->email)
                                        <div class="member-sub-text">{{ $member->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="voice-badge {{ $voiceClass }}">
                                <i class="fas fa-microphone-alt"></i>
                                {{ ucfirst($member->voice_part ?? 'Choir Member') }}
                            </span>
                        </td>
                        <td style="font-size: 0.75rem;">
                            @if($member->birthday)
                                {{ \Carbon\Carbon::parse($member->birthday)->format('M d, Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td style="font-size: 0.75rem;">
                            @if($age)
                                {{ $age }} years
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('choir-members.edit', $member->id) }}" class="btn-icon-action edit" title="Edit Member">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('choir-members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this choir member permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-action delete" title="Remove Member">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-music"></i>
                                <h5>No Choir Members Yet</h5>
                                <p>Start building your choir ministry by adding members</p>
                                <a href="{{ route('choir-members.create') }}" class="btn-add-in-table" style="padding: 0.4rem 1.5rem; font-size: 0.7rem; margin-top: 0.5rem;">
                                    <i class="fas fa-user-plus me-2"></i> Add First Choir Member
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($choir_members) && $choir_members->count() > 0 && method_exists($choir_members, 'hasPages') && $choir_members->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Showing <strong>{{ $choir_members->firstItem() }}</strong> to <strong>{{ $choir_members->lastItem() }}</strong> of <strong>{{ $choir_members->total() }}</strong> members
            </div>
            {{ $choir_members->links() }}
        </div>
        @elseif(isset($choir_members) && $choir_members->count() > 0)
        <div class="pagination-container">
            <div class="pagination-info">
                Showing <strong>{{ $choir_members->count() }}</strong> choir members
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const memberRows = document.querySelectorAll('#choirMembersBody tr');
        const visibleCountSpan = document.getElementById('visibleCount');
        
        function updateVisibleCount() {
            const visibleRows = document.querySelectorAll('#choirMembersBody tr:not([style*="display: none"])').length;
            if (visibleCountSpan) {
                visibleCountSpan.textContent = visibleRows;
            }
        }
        
        function filterMembers() {
            const activeVoiceBtn = document.querySelector('.voice-filter-btn.active');
            const activeVoice = activeVoiceBtn ? activeVoiceBtn.getAttribute('data-voice') : 'all';
            
            memberRows.forEach(row => {
                const voice = row.getAttribute('data-voice') || '';
                const matchesVoice = activeVoice === 'all' || voice === activeVoice;
                
                if (matchesVoice) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateVisibleCount();
        }
        
        // Voice filter buttons
        document.querySelectorAll('.voice-filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.voice-filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                filterMembers();
            });
        });
        
        // Initial update
        updateVisibleCount();
    });
</script>
@endsection