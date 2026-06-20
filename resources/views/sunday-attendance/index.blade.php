@extends('layouts.app')

@section('header', 'Sunday Service Attendance')

@section('content')
<style>
    /* ============================================
       CLEAN UI - SAME STYLE AS MEMBER PAGE
    ============================================ */
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.2rem;
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
    
    .stat-info h3 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    /* Hero Section */
    .hero-section {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.2rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .hero-left h2 {
        font-weight: 600;
        margin: 0;
        font-size: 1.1rem;
        color: var(--text-primary);
    }
    
    .hero-left h2 i {
        color: #10b981;
    }
    
    .hero-left p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.75rem;
    }
    
    .hero-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .date-badge {
        background: var(--bg-tertiary);
        padding: 6px 16px;
        border-radius: 30px;
        color: var(--text-primary);
        font-size: 0.8rem;
        font-weight: 500;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .date-badge i {
        color: #10b981;
    }
    
    .date-badge .day-name {
        opacity: 0.6;
        font-size: 0.65rem;
    }
    
    .sunday-indicator {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-records {
        padding: 0.5rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
        text-decoration: none;
    }
    
    .btn-records:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        text-decoration: none;
        color: var(--text-primary);
        border-color: #10b981;
    }
    
    .btn-records i {
        color: #10b981;
        transition: transform 0.2s ease;
    }
    
    .btn-records:hover i {
        transform: translateX(3px);
    }
    
    /* Combined Card */
    .combined-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .date-selector-section {
        padding: 1rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
    }
    
    .selector-title {
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.8rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .selector-title i {
        color: #10b981;
    }
    
    .selector-title small {
        font-weight: 400;
        color: var(--text-muted);
        font-size: 0.65rem;
    }
    
    .selector-group {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    
    .selector-item label {
        display: block;
        font-size: 0.6rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
    }
    
    .selector-item input {
        width: 170px;
        padding: 0.5rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .selector-item input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .week-nav {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-week {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
    }
    
    .btn-week:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .btn-week i {
        transition: transform 0.2s ease;
    }
    
    .btn-week-prev:hover i {
        transform: translateX(-3px);
    }
    
    .btn-week-next:hover i {
        transform: translateX(3px);
    }
    
    /* Table Header */
    .table-header {
        padding: 0.8rem 1.2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .table-header h5 {
        margin: 0;
        font-size: 0.85rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-primary);
    }
    
    .table-header h5 i {
        color: #10b981;
    }
    
    .badge-count {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .auto-save-status {
        font-size: 0.6rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--bg-tertiary);
        padding: 3px 12px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
    }
    
    .auto-save-status i {
        font-size: 0.65rem;
    }
    
    .auto-save-status .fa-check-circle {
        color: #10b981;
    }
    
    /* Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table thead th {
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
    
    .data-table tbody td {
        padding: 0.6rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        background: var(--card-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
    }
    
    .data-table tbody tr {
        transition: all 0.15s ease;
    }
    
    .data-table tbody tr:hover {
        background: var(--bg-tertiary);
    }
    
    .data-table tbody tr:hover td {
        background: transparent;
    }
    
    /* Member Info */
    .member-info {
        display: flex;
        align-items: center;
        gap: 10px;
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
    
    .member-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.85rem;
        margin-bottom: 1px;
    }
    
    .member-role {
        font-size: 0.6rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .member-role i {
        color: #10b981;
        font-size: 0.55rem;
    }
    
    /* Status Select */
    .status-select {
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid var(--border-color);
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.75rem;
        cursor: pointer;
        width: 110px;
        transition: all 0.2s;
    }
    
    .status-select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .status-select option[value="Present"] { color: #10b981; }
    .status-select option[value="Absent"] { color: #ef4444; }
    
    .status-select.changed {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.05);
    }
    
    .status-select.saved {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }
    
    /* Notes Input */
    .notes-input {
        width: 100%;
        padding: 4px 10px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.75rem;
        transition: all 0.2s;
    }
    
    .notes-input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .notes-input::placeholder {
        color: var(--text-muted);
    }
    
    .notes-input.changed {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.05);
    }
    
    .notes-input.saved {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }
    
    /* Alerts */
    .alert-box {
        border-radius: 10px;
        padding: 0.8rem 1rem;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.8rem;
        border: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        color: var(--text-primary);
    }
    
    .alert-box i {
        font-size: 1rem;
    }
    
    .alert-box .fa-check-circle { color: #10b981; }
    .alert-box .fa-exclamation-triangle { color: #f59e0b; }
    
    /* Empty State */
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
    
    /* Toast */
    .auto-save-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 10px 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 9999;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.4s ease;
        font-size: 0.8rem;
    }
    
    .auto-save-toast.show {
        transform: translateY(0);
        opacity: 1;
    }
    
    .auto-save-toast.success {
        border-left: 4px solid #10b981;
    }
    
    .auto-save-toast.success i {
        color: #10b981;
    }
    
    .auto-save-toast.error {
        border-left: 4px solid #ef4444;
    }
    
    .auto-save-toast.error i {
        color: #ef4444;
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
    
    .alert-actions {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .selector-group {
            flex-direction: column;
            align-items: stretch !important;
        }
        .selector-item input {
            width: 100%;
        }
        .btn-week {
            width: 100%;
            justify-content: center;
        }
        .week-nav {
            width: 100%;
            flex-direction: column;
        }
        .hero-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }
        .date-badge {
            justify-content: center;
        }
        .btn-records {
            justify-content: center;
        }
        .data-table th, .data-table td {
            padding: 0.5rem 0.6rem;
            font-size: 0.7rem;
        }
        .member-avatar {
            width: 28px;
            height: 28px;
            font-size: 0.6rem;
        }
        .stat-info h3 {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-left">
            <h2><i class="fas fa-church me-2"></i>Sunday Service Attendance</h2>
            <p>Record and manage attendance for Sunday worship services</p>
        </div>
        <div class="hero-actions">
            <div class="date-badge">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</span>
                <span class="day-name">({{ \Carbon\Carbon::parse($selectedDate)->format('l') }})</span>
            </div>
            <span class="sunday-indicator"><i class="fas fa-check-circle"></i> Sunday</span>
            <a href="{{ route('sunday-attendance.records', ['date' => $selectedDate]) }}" class="btn-records">
                View Records <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="alert-box">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-box">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4>Total Members</h4>
                <h3>{{ number_format($totalMembers ?? 0) }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <h4>Present</h4>
                <h3>{{ number_format($presentCount ?? 0) }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <h4>Absent</h4>
                <h3>{{ number_format($absentCount ?? 0) }}</h3>
            </div>
        </div>
    </div>

    <!-- Combined Card -->
    <form id="attendanceForm" action="{{ route('sunday-attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="service_date" id="serviceDate" value="{{ $selectedDate }}">

        <div class="combined-card">
            <div class="date-selector-section">
                <div class="selector-title">
                    <i class="fas fa-calendar-week"></i>
                    <span>Select Date</span>
                    <small><i class="fas fa-info-circle"></i> Only Sundays are selectable</small>
                </div>
                <div class="selector-group">
                    <div class="selector-item">
                        <label><i class="fas fa-calendar-day me-1"></i> DATE</label>
                        <input type="date" id="datePicker" value="{{ $selectedDate }}" 
                               min="{{ \Carbon\Carbon::now()->subYears(5)->format('Y-m-d') }}"
                               max="{{ \Carbon\Carbon::now()->addYears(1)->format('Y-m-d') }}">
                    </div>
                    <div class="week-nav">
                        <button type="button" class="btn-week btn-week-prev" onclick="goToPrevWeek()">
                            <i class="fas fa-chevron-left"></i> Prev Week
                        </button>
                        <button type="button" class="btn-week btn-week-next" onclick="goToNextWeek()">
                            Next Week <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <div class="table-header">
                    <h5>
                        <i class="fas fa-users"></i>
                        Member Attendance
                        <span class="badge-count">{{ $presentCount ?? 0 }} / {{ $totalMembers ?? 0 }} Recorded</span>
                    </h5>
                    <div class="auto-save-status">
                        <i class="fas fa-sync-alt fa-fw" id="autoSaveSpinner"></i>
                        <span id="autoSaveLabel">Auto-save enabled</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No.</th>
                                <th>Member Information</th>
                                <th style="width: 130px;">Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members ?? [] as $index => $member)
                            @php
                                $attendance = ($attendances ?? collect())->get($member->id);
                                $status = $attendance ? $attendance->status : 'Absent';
                                $notes = $attendance ? $attendance->notes : '';
                            @endphp
                            <tr>
                                <td class="text-muted text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="member-info">
                                        <div class="member-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="member-name">{{ $member->first_name }} {{ $member->last_name }}</div>
                                            @if(($member->is_choir ?? false))
                                                <div class="member-role"><i class="fas fa-music"></i> Choir Member</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <select name="attendances[{{ $member->id }}][status]" 
                                            class="status-select" 
                                            data-member="{{ $member->id }}"
                                            onchange="autoSave(this)">
                                        <option value="Present" {{ $status == 'Present' ? 'selected' : '' }}>✅ Present</option>
                                        <option value="Absent" {{ $status == 'Absent' ? 'selected' : '' }}>❌ Absent</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="attendances[{{ $member->id }}][notes]" 
                                           class="notes-input" 
                                           placeholder="Add notes..." 
                                           value="{{ $notes }}"
                                           data-member="{{ $member->id }}"
                                           onchange="autoSave(this)"
                                           onkeyup="autoSaveDebounce(this)">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <p>No members found. Please add members first.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-save-hidden" id="hiddenSubmitBtn" style="display:none;"></button>
    </form>
</div>

<!-- Custom Alert -->
<div class="custom-alert-overlay" id="customAlert">
    <div class="custom-alert">
        <div class="custom-alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <h3>Only Sundays Allowed</h3>
        <p>Attendance can only be recorded on Sundays. Please select a Sunday date.</p>
        <div class="alert-date">
            <i class="fas fa-calendar-day"></i>
            <span id="alertSelectedDate">Select a date</span>
        </div>
        <button class="btn-alert-close" onclick="closeCustomAlert()">
            <i class="fas fa-check me-1"></i> OK, I Understand
        </button>
    </div>
</div>

<!-- Auto-save toast -->
<div class="auto-save-toast" id="autoSaveToast">
    <i class="fas fa-check-circle"></i>
    <span id="autoSaveMessage">Changes saved automatically</span>
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
        
        const datePicker = document.getElementById('datePicker');
        const currentDate = document.getElementById('serviceDate').value;
        if (datePicker && currentDate) {
            datePicker.value = currentDate;
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
    // AUTO-SAVE FUNCTIONALITY
    // =============================================
    let saveTimeout = null;
    let isSaving = false;
    const toast = document.getElementById('autoSaveToast');
    const toastMessage = document.getElementById('autoSaveMessage');
    const spinner = document.getElementById('autoSaveSpinner');
    const autoSaveLabel = document.getElementById('autoSaveLabel');
    
    function showToast(message, type = 'success') {
        toast.className = 'auto-save-toast ' + type;
        toastMessage.textContent = message;
        toast.classList.add('show');
        
        clearTimeout(toast._hideTimeout);
        toast._hideTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }
    
    function autoSave(element) {
        clearTimeout(saveTimeout);
        
        if (element) {
            element.classList.add('changed');
        }
        spinner.className = 'fas fa-spinner fa-spin fa-fw';
        autoSaveLabel.textContent = 'Saving...';
        
        saveTimeout = setTimeout(() => {
            saveAttendance();
        }, 500);
    }
    
    function autoSaveDebounce(element) {
        clearTimeout(saveTimeout);
        
        if (element) {
            element.classList.add('changed');
        }
        spinner.className = 'fas fa-spinner fa-spin fa-fw';
        autoSaveLabel.textContent = 'Saving...';
        
        saveTimeout = setTimeout(() => {
            saveAttendance();
        }, 800);
    }
    
    function saveAttendance() {
        if (isSaving) return;
        
        isSaving = true;
        
        const serviceDate = document.getElementById('serviceDate').value;
        const form = document.getElementById('attendanceForm');
        const statusSelects = form.querySelectorAll('.status-select');
        const notesInputs = form.querySelectorAll('.notes-input');
        
        const attendances = {};
        
        statusSelects.forEach(select => {
            const memberId = select.dataset.member;
            if (!attendances[memberId]) {
                attendances[memberId] = {};
            }
            attendances[memberId]['status'] = select.value;
        });
        
        notesInputs.forEach(input => {
            const memberId = input.dataset.member;
            if (!attendances[memberId]) {
                attendances[memberId] = {};
            }
            attendances[memberId]['notes'] = input.value;
        });
        
        const submitData = new FormData();
        submitData.append('service_date', serviceDate);
        submitData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        Object.keys(attendances).forEach(memberId => {
            submitData.append(`attendances[${memberId}][status]`, attendances[memberId]['status'] || 'Absent');
            submitData.append(`attendances[${memberId}][notes]`, attendances[memberId]['notes'] || '');
        });
        
        fetch('{{ route("sunday-attendance.store") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: submitData
        })
        .then(response => response.json())
        .then(data => {
            isSaving = false;
            
            if (data.success) {
                document.querySelectorAll('.status-select.changed, .notes-input.changed').forEach(el => {
                    el.classList.remove('changed');
                    el.classList.add('saved');
                    setTimeout(() => {
                        el.classList.remove('saved');
                    }, 1000);
                });
                
                spinner.className = 'fas fa-check-circle fa-fw';
                autoSaveLabel.textContent = 'Auto-saved';
                
                if (data.stats) {
                    document.querySelector('.stat-card:nth-child(2) .stat-info h3').textContent = data.stats.present;
                    document.querySelector('.stat-card:nth-child(3) .stat-info h3').textContent = data.stats.absent;
                    document.querySelector('.badge-count').textContent = data.stats.present + ' / ' + data.stats.total + ' Recorded';
                }
                
                showToast(data.message || 'Changes saved automatically', 'success');
            } else {
                showToast(data.message || 'Error saving changes', 'error');
                spinner.className = 'fas fa-exclamation-circle fa-fw';
                autoSaveLabel.textContent = 'Auto-save failed';
            }
            
            setTimeout(() => {
                spinner.className = 'fas fa-sync-alt fa-fw';
                autoSaveLabel.textContent = 'Auto-save enabled';
            }, 3000);
        })
        .catch(error => {
            isSaving = false;
            console.error('Auto-save error:', error);
            showToast('Network error. Please check your connection.', 'error');
            spinner.className = 'fas fa-exclamation-circle fa-fw';
            autoSaveLabel.textContent = 'Auto-save failed';
            
            setTimeout(() => {
                spinner.className = 'fas fa-sync-alt fa-fw';
                autoSaveLabel.textContent = 'Auto-save enabled';
            }, 3000);
        });
    }
    
    // =============================================
    // DATE PICKER - ONLY SUNDAYS
    // =============================================
    const datePicker = document.getElementById('datePicker');
    
    function getNearestSunday(date) {
        let d = new Date(date);
        d.setDate(d.getDate() + (7 - d.getDay()) % 7);
        return d;
    }
    
    if (datePicker) {
        const currentDate = datePicker.value;
        if (currentDate) {
            const selectedDate = new Date(currentDate);
            if (selectedDate.getDay() !== 0) {
                const nearestSunday = getNearestSunday(selectedDate);
                const dateStr = nearestSunday.toISOString().split('T')[0];
                window.location.href = "{{ route('sunday-attendance.index') }}?date=" + dateStr;
            }
        }
        
        datePicker.addEventListener('input', function(e) {
            const selectedDate = new Date(this.value);
            if (selectedDate.getDay() !== 0) {
                showCustomAlert(this.value);
                const currentDate = document.getElementById('serviceDate').value;
                this.value = currentDate;
            } else {
                const date = this.value;
                if (date) {
                    window.location.href = "{{ route('sunday-attendance.index') }}?date=" + date;
                }
            }
        });
    }
    
    function goToPrevWeek() {
        let currentDate = document.getElementById('datePicker').value;
        let date = new Date(currentDate);
        date.setDate(date.getDate() - 7);
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        window.location.href = "{{ route('sunday-attendance.index') }}?date=" + year + '-' + month + '-' + day;
    }
    
    function goToNextWeek() {
        let currentDate = document.getElementById('datePicker').value;
        let date = new Date(currentDate);
        date.setDate(date.getDate() + 7);
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        window.location.href = "{{ route('sunday-attendance.index') }}?date=" + year + '-' + month + '-' + day;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const badge = document.querySelector('.badge-count');
            if (badge) {
                const text = badge.textContent;
                if (text && !text.includes('0 /')) {
                    spinner.className = 'fas fa-check-circle fa-fw';
                    autoSaveLabel.textContent = 'Auto-saved';
                    setTimeout(() => {
                        spinner.className = 'fas fa-sync-alt fa-fw';
                        autoSaveLabel.textContent = 'Auto-save enabled';
                    }, 2000);
                }
            }
        }, 1000);
    });
</script>
@endsection