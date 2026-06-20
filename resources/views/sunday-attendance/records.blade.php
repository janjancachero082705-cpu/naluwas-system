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
    
    .stat-icon.primary { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .stat-icon.success { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.danger { background: linear-gradient(135deg, #ef4444, #f87171); }
    
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
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .stat-trend {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 2px;
    }
    
    /* Date Selector */
    .date-selector-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
    }
    
    .date-selector-card .form-label {
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
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
        border-radius: 8px;
        padding: 6px 12px;
        cursor: pointer;
        font-size: 0.8rem;
    }
    
    .date-input-group .form-control:focus {
        background: var(--input-bg);
        border-color: #10b981;
        color: var(--text-primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .quick-btn {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.7rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .quick-btn:hover {
        background: #10b981;
        border-color: #10b981;
        color: white;
        transform: translateY(-1px);
    }
    
    .total-badge {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        padding: 6px 14px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid var(--border-color);
    }
    
    .total-badge i {
        color: #10b981;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .table-container .card-header-custom h6 {
        margin: 0;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .table-container .card-header-custom h6 i {
        color: #10b981;
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
        color: var(--text-muted);
        font-size: 0.65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 0.7rem 1rem;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 0.6rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
    }
    
    .table tbody tr {
        transition: all 0.15s ease;
    }
    
    .table tbody tr:hover {
        background: var(--bg-tertiary);
    }
    
    .table tbody tr:hover td {
        background: transparent;
    }
    
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
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
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
        opacity: 0.3;
        color: #10b981;
    }
    
    .empty-state p {
        font-size: 0.8rem;
    }
    
    .btn-back-attendance {
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
        text-decoration: none;
    }
    
    .btn-back-attendance:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        text-decoration: none;
        color: var(--text-primary);
        border-color: #10b981;
    }
    
    .btn-back-attendance i {
        color: #10b981;
    }
    
    /* Custom Alert */
    .custom-alert-overlay {
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
    
    .custom-alert-overlay.active {
        display: flex;
    }
    
    .custom-alert {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 1.8rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        animation: slideUp 0.3s ease;
        text-align: center;
        border: 1px solid var(--border-color);
    }
    
    .custom-alert-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.8rem;
    }
    
    .custom-alert-icon i {
        font-size: 1.8rem;
        color: #ef4444;
    }
    
    .custom-alert h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.3rem;
    }
    
    .custom-alert p {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    
    .custom-alert .alert-date {
        background: var(--bg-tertiary);
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.2rem;
        display: inline-block;
        border: 1px solid var(--border-color);
    }
    
    .custom-alert .alert-date i {
        color: #f59e0b;
        margin-right: 6px;
    }
    
    .btn-alert-close {
        padding: 0.6rem 1.8rem;
        background: var(--text-primary);
        color: var(--card-bg);
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-alert-close:hover {
        opacity: 0.85;
        transform: translateY(-1px);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.96);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .stat-value {
            font-size: 1.2rem;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
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
        .status-badge {
            font-size: 0.55rem;
            padding: 2px 6px;
        }
        .custom-alert {
            padding: 1.5rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h2 mb-1 fw-bold" style="color: var(--text-primary); font-size: 1.3rem;">
                <i class="fas fa-calendar-check me-2" style="color: #10b981;"></i>Attendance Records
            </h1>
            <p class="mb-0" style="color: var(--text-muted); font-size: 0.8rem;">View and analyze church attendance data</p>
        </div>
        <a href="{{ route('sunday-attendance.index', ['date' => $selectedDate ?? date('Y-m-d')]) }}" class="btn-back-attendance">
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
            <h6><i class="fas fa-users me-2"></i>Attendance Details</h6>
            @if(isset($selectedDate))
            <small style="color: var(--text-muted); font-size: 0.65rem;">
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
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 0.85rem;">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                                    @if(($member->is_choir ?? false))
                                        <small class="text-muted" style="font-size: 0.6rem;"><i class="fas fa-music" style="color: #10b981;"></i> Choir Member</small>
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
        <div class="text-center py-2 border-top" style="border-color: var(--border-color);">
            <small class="text-muted" style="font-size: 0.65rem;">Total members: {{ $members->count() }}</small>
        </div>
        @endif
    </div>
</div>

<!-- Custom Alert -->
<div class="custom-alert-overlay" id="customAlert">
    <div class="custom-alert">
        <div class="custom-alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h3>Only Sundays Allowed</h3>
        <p>Attendance records can only be viewed for Sundays. Please select a Sunday date.</p>
        <div class="alert-date">
            <i class="fas fa-calendar-day"></i>
            <span id="alertSelectedDate">Select a date</span>
        </div>
        <button class="btn-alert-close" onclick="closeCustomAlert()">
            <i class="fas fa-check me-1"></i> OK, I Understand
        </button>
    </div>
</div>

<script>
    // =============================================
    // CUSTOM ALERT FUNCTIONS
    // =============================================
    function showCustomAlert(date) {
        const overlay = document.getElementById('customAlert');
        const dateSpan = document.getElementById('alertSelectedDate');
        
        if (date) {
            const d = new Date(date);
            dateSpan.textContent = d.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        } else {
            dateSpan.textContent = 'Invalid date selected';
        }
        
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeCustomAlert() {
        const overlay = document.getElementById('customAlert');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        
        const dateSelector = document.getElementById('dateSelector');
        const currentDate = "{{ $selectedDate ?? date('Y-m-d') }}";
        if (dateSelector && currentDate) {
            dateSelector.value = currentDate;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('customAlert');
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCustomAlert();
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && overlay.classList.contains('active')) {
                closeCustomAlert();
            }
        });
    });
    
    // =============================================
    // DATE SELECTOR - ONLY SUNDAYS
    // =============================================
    const dateSelector = document.getElementById('dateSelector');
    
    function getNearestSunday(date) {
        let d = new Date(date);
        d.setDate(d.getDate() + (7 - d.getDay()) % 7);
        return d;
    }
    
    if (dateSelector) {
        const currentDate = dateSelector.value;
        if (currentDate) {
            const selectedDate = new Date(currentDate);
            if (selectedDate.getDay() !== 0) {
                const nearestSunday = getNearestSunday(selectedDate);
                const dateStr = nearestSunday.toISOString().split('T')[0];
                window.location.href = "{{ route('sunday-attendance.records') }}?date=" + dateStr;
            }
        }
        
        dateSelector.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            if (selectedDate.getDay() !== 0) {
                showCustomAlert(this.value);
                const currentDate = "{{ $selectedDate ?? date('Y-m-d') }}";
                this.value = currentDate;
            } else {
                window.location.href = "{{ route('sunday-attendance.records') }}?date=" + this.value;
            }
        });
    }
    
    // =============================================
    // QUICK SELECT FUNCTIONS
    // =============================================
    function selectToday() {
        let today = new Date();
        if (today.getDay() !== 0) {
            today.setDate(today.getDate() + (7 - today.getDay()) % 7);
        }
        let dateStr = today.toISOString().split('T')[0];
        window.location.href = "{{ route('sunday-attendance.records') }}?date=" + dateStr;
    }
    
    function selectLastSunday() {
        let today = new Date();
        let lastSunday = new Date(today.setDate(today.getDate() - today.getDay()));
        let dateStr = lastSunday.toISOString().split('T')[0];
        window.location.href = "{{ route('sunday-attendance.records') }}?date=" + dateStr;
    }
</script>
@endsection