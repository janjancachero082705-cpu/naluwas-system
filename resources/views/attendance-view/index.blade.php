@extends('layouts.app')

@section('header', 'Attendance Records')

@section('content')
<style>
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }
    
    [data-theme="dark"] .stat-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-icon.primary { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .stat-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-icon.danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
    
    .stat-info {
        flex: 1;
    }
    
    .stat-info h4 {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin: 0 0 4px 0;
        font-weight: 600;
    }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }
    
    .stat-trend {
        font-size: 0.65rem;
        color: var(--text-muted);
        margin-top: 4px;
    }
    
    /* Date Selector */
    .date-selector-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    
    .date-selector-card .form-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .date-input-group {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .date-input-group .form-control {
        width: auto;
        min-width: 200px;
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 12px;
        padding: 8px 12px;
        cursor: pointer;
    }
    
    .date-input-group .form-control:focus {
        background: var(--input-bg);
        border-color: #3b82f6;
        color: var(--text-primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    
    .quick-btn {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.75rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .quick-btn:hover {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
        transform: translateY(-1px);
    }
    
    .total-badge {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        padding: 8px 16px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    /* ========== TABLE STYLES ========== */
    .table-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    
    .table-container .card-header-custom {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        background: #f8fafc;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    [data-theme="dark"] .table-container .card-header-custom {
        background: #1e293b;
    }
    
    .table-container .card-header-custom h6 {
        margin: 0;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .table {
        margin-bottom: 0;
        width: 100%;
        background: var(--card-bg);
        border-collapse: collapse;
    }
    
    .table thead th {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 1rem 1rem;
        font-family: monospace;
        white-space: nowrap;
    }
    
    [data-theme="dark"] .table thead th {
        background: #1e293b;
        border-bottom: 1px solid #334155;
        color: #94a3b8;
    }
    
    .table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        background: var(--card-bg);
        color: var(--text-primary);
        font-size: 0.85rem;
    }
    
    [data-theme="dark"] .table tbody td {
        border-bottom: 1px solid #1e293b;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background: #fafbfc;
    }
    
    .table tbody tr:hover td {
        background: transparent;
    }
    
    [data-theme="dark"] .table tbody tr:hover {
        background: #1e293b;
    }
    
    .member-avatar {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        color: white;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-present {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
    }
    
    .status-absent {
        background: rgba(239, 68, 68, 0.12);
        color: #ef4444;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .stat-value {
            font-size: 1.3rem;
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            font-size: 1.1rem;
        }
        .table thead th,
        .table tbody td {
            padding: 0.6rem 0.8rem;
            font-size: 0.7rem;
        }
        .member-avatar {
            width: 32px;
            height: 32px;
            font-size: 0.65rem;
        }
        .status-badge {
            font-size: 0.6rem;
            padding: 3px 8px;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h2 mb-1 fw-bold" style="color: var(--text-primary);">
                <i class="fas fa-calendar-check text-primary me-2"></i>Attendance Records
            </h1>
            <p class="mb-0" style="color: var(--text-muted);">View and analyze church attendance data</p>
        </div>
        <a href="{{ route('sunday-attendance.index', ['date' => $selectedDate ?? date('Y-m-d')]) }}" class="btn btn-primary" style="border-radius: 40px; padding: 10px 24px;">
            <i class="fas fa-pen-alt me-2"></i>Input Attendance
        </a>
    </div>

    <!-- Date Selector Card -->
    <div class="date-selector-card">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="form-label"><i class="fas fa-calendar-day me-1"></i> Select Date</div>
                <div class="date-input-group">
                    <input type="date" id="dateSelector" class="form-control" value="{{ $selectedDate ?? date('Y-m-d') }}">
                    <div class="d-flex gap-2">
                        <button class="quick-btn" onclick="selectToday()">Today</button>
                        <button class="quick-btn" onclick="selectLastSunday()">Last Sunday</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="total-badge">
                    <i class="fas fa-church"></i>
                    {{ \Carbon\Carbon::parse($selectedDate ?? date('Y-m-d'))->format('F d, Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4>Total Members</h4>
                <div class="stat-value">{{ number_format($totalMembers ?? 0) }}</div>
                <div class="stat-trend">Registered in church</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <h4>Present Today</h4>
                <div class="stat-value">{{ number_format($presentCount ?? 0) }}</div>
                <div class="stat-trend">Attended service</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <h4>Absent Today</h4>
                <div class="stat-value">{{ number_format($absentCount ?? 0) }}</div>
                <div class="stat-trend">Did not attend</div>
            </div>
        </div>
    </div>

    <!-- Member Attendance Details Table -->
    <div class="table-container">
        <div class="card-header-custom">
            <h6><i class="fas fa-users text-primary me-2"></i>Attendance Details</h6>
            @if(isset($selectedDate))
            <small style="color: var(--text-muted); font-size: 0.7rem;">
                {{ \Carbon\Carbon::parse($selectedDate)->format('l, F d, Y') }}
            </small>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th>Member Information</th>
                        <th>Age</th>
                        <th>Status</th>
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
                    @endphp
                    <tr>
                        <td class="text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="member-avatar">
                                    {{ strtoupper(substr($member->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? '', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                                    @if(($member->is_choir ?? false))
                                        <small class="text-muted"><i class="fas fa-music"></i> Choir Member</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $age }}</td>
                        <td>
                            @if($status == 'Present')
                                <span class="status-badge status-present"><i class="fas fa-check-circle"></i> Present</span>
                            @else
                                <span class="status-badge status-absent"><i class="fas fa-times-circle"></i> Absent</span>
                            @endif
                        </td>
                        <td>{{ $notes ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-users"></i>
                            <p class="mb-0">No members found. Please add members first.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(($members ?? collect())->count() > 0)
        <div class="text-center py-2 border-top">
            <small class="text-muted">Total members: {{ $members->count() }}</small>
        </div>
        @endif
    </div>
</div>

<script>
    // =============================================
    // AUTO-SUBMIT ON DATE CHANGE
    // =============================================
    const dateSelector = document.getElementById('dateSelector');
    
    if (dateSelector) {
        dateSelector.addEventListener('change', function() {
            window.location.href = "{{ route('attendance-view.index') }}?date=" + this.value;
        });
    }
    
    // =============================================
    // QUICK SELECT FUNCTIONS
    // =============================================
    function selectToday() {
        let today = new Date().toISOString().split('T')[0];
        window.location.href = "{{ route('attendance-view.index') }}?date=" + today;
    }
    
    function selectLastSunday() {
        let today = new Date();
        let lastSunday = new Date(today.setDate(today.getDate() - today.getDay()));
        let dateStr = lastSunday.toISOString().split('T')[0];
        window.location.href = "{{ route('attendance-view.index') }}?date=" + dateStr;
    }
</script>
@endsection