@extends('layouts.app')

@section('header', 'Sunday Service Attendance')

@section('content')
<style>
    /* ============================================
       GLOBAL VARIABLES FOR BOTH MODES
    ============================================ */
    
    /* Light Mode Default */
    :root {
        --text-primary: #1f2937;
        --text-muted: #6b7280;
        --text-secondary: #4b5563;
        --border-color: #e5e7eb;
        --bg-primary: #ffffff;
        --bg-secondary: #f9fafb;
        --bg-tertiary: #f3f4f6;
        --card-bg: #ffffff;
        --hover-bg: #f3f4f6;
        --input-bg: #ffffff;
    }
    
    /* Dark Mode Override */
    [data-theme="dark"] {
        --text-primary: #f3f4f6;
        --text-muted: #9ca3af;
        --text-secondary: #d1d5db;
        --border-color: #4a4a5a;
        --bg-primary: #1e1e2e;
        --bg-secondary: #2a2a3a;
        --bg-tertiary: #2d2d3d;
        --card-bg: #1e1e2e;
        --hover-bg: #3a3a4a;
        --input-bg: #2a2a3a;
    }
    
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
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    [data-theme="dark"] .stat-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
    .stat-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
    
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
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }
    
    .stat-trend {
        font-size: 0.65rem;
        color: var(--text-muted);
        margin-top: 4px;
    }
    
    /* Selected Date Banner */
    .selected-date-banner {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 16px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        color: white;
    }
    
    .selected-date-banner strong {
        font-size: 1rem;
    }
    
    /* Calendar Container */
    .calendar-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    
    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .calendar-header h5 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-primary);
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
    }
    
    .calendar-weekday {
        text-align: center;
        padding: 10px;
        font-weight: 700;
        font-size: 0.7rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .calendar-day {
        min-height: 85px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--card-bg);
    }
    
    .calendar-day:hover {
        background: var(--hover-bg);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .calendar-day.selected {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
        border-color: #3b82f6;
    }
    
    .calendar-day.selected .day-number {
        color: white;
    }
    
    .calendar-day.sunday {
        background: rgba(245, 158, 11, 0.06);
        border-color: rgba(245, 158, 11, 0.2);
    }
    
    [data-theme="dark"] .calendar-day.sunday {
        background: rgba(245, 158, 11, 0.1);
    }
    
    .calendar-day.sunday.selected {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }
    
    .calendar-day.other-month {
        opacity: 0.4;
    }
    
    .day-number {
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 6px;
        color: var(--text-primary);
    }
    
    .day-badge {
        font-size: 0.6rem;
        padding: 3px 8px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 600;
    }
    
    .day-badge.recorded {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
    }
    
    .day-badge.pending {
        background: rgba(239, 68, 68, 0.12);
        color: #ef4444;
    }
    
    /* Chart Container */
    .chart-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    
    .chart-container h6 {
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .chart-box {
        height: 280px;
        position: relative;
    }
    
    /* ========== ENHANCED TABLE STYLES ========== */
    .table-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    
    .table-container .card-header-custom {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border-color);
        background: #f8fafc;
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
        color: var(--text-primary);
        background: var(--card-bg);
        border-collapse: collapse;
    }
    
    /* Table Header - Clean & Modern */
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
    
    /* Table Cells */
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
    
    /* Row Hover Effect */
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
    
    /* Member Avatar */
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
    
    /* Status Select */
    .status-select {
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.75rem;
        cursor: pointer;
        width: 120px;
        transition: all 0.2s ease;
    }
    
    [data-theme="dark"] .status-select {
        border: 1px solid #334155;
    }
    
    .status-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Notes Input */
    .notes-input {
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.75rem;
        width: 100%;
        transition: all 0.2s ease;
    }
    
    [data-theme="dark"] .notes-input {
        border: 1px solid #334155;
    }
    
    .notes-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .notes-input::placeholder {
        color: var(--text-muted);
    }
    
    /* Visitors Section */
    .visitor-row {
        background: rgba(245, 158, 11, 0.04);
        border-radius: 14px;
        padding: 12px;
        margin-bottom: 10px;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
    }
    
    .visitor-row:hover {
        background: rgba(245, 158, 11, 0.08);
    }
    
    .visitor-row .form-control {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 0.8rem;
    }
    
    .visitor-row .form-control:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .visitor-row .form-control::placeholder {
        color: var(--text-muted);
    }
    
    /* Buttons */
    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 12px 32px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        color: white;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-outline-custom {
        background: transparent;
        border: 1px solid #e2e8f0;
        color: var(--text-primary);
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    [data-theme="dark"] .btn-outline-custom {
        border: 1px solid #334155;
    }
    
    .btn-outline-custom:hover {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        color: white;
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 0.7rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
    }
    
    /* Form Controls */
    .form-control {
        background: var(--input-bg);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .form-control-sm {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
    }
    
    /* Real-time notification toast */
    .realtime-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        transform: translateX(400px);
        transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 9999;
        max-width: 350px;
        font-size: 0.9rem;
    }
    
    .realtime-toast.show {
        transform: translateX(0);
    }
    
    .realtime-toast .toast-icon {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }
        .calendar-day {
            min-height: 65px;
        }
        .day-number {
            font-size: 0.7rem;
        }
        .day-badge {
            font-size: 0.5rem;
            padding: 2px 6px;
        }
        .selected-date-banner {
            flex-direction: column;
            text-align: center;
        }
        .visitor-row .row {
            gap: 8px;
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
        .status-select {
            width: 100px;
            padding: 6px 8px;
            font-size: 0.65rem;
        }
        .realtime-toast {
            top: 10px;
            right: 10px;
            left: 10px;
            max-width: none;
            font-size: 0.8rem;
            padding: 12px 16px;
        }
    }
</style>

<div class="container-fluid px-0">
    
    <!-- Selected Date Banner -->
    <div class="selected-date-banner">
        <div>
            <i class="fas fa-church me-2"></i>
            <strong>{{ \Carbon\Carbon::parse($selectedDate)->format('l, F d, Y') }}</strong>
            <span class="ms-2 opacity-75">| Manage attendance for this service</span>
        </div>
        <div>
            <span class="badge bg-light text-dark px-3 py-2">
                <i class="fas fa-sync-alt me-1" id="live-indicator"></i> Live
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4>Total Members</h4>
                <div class="stat-value" id="stat-total">{{ number_format($totalMembers ?? 0) }}</div>
                <div class="stat-trend">Registered members</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <h4>Present</h4>
                <div class="stat-value" id="stat-present">{{ number_format($presentCount ?? 0) }}</div>
                <div class="stat-trend" id="stat-present-percent">{{ $totalMembers > 0 ? round(($presentCount / $totalMembers) * 100, 1) : 0 }}% attendance rate</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon danger"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <h4>Absent</h4>
                <div class="stat-value" id="stat-absent">{{ number_format($absentCount ?? 0) }}</div>
                <div class="stat-trend">Not attended</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-user-plus"></i></div>
            <div class="stat-info">
                <h4>Visitors</h4>
                <div class="stat-value" id="stat-visitors">{{ number_format($visitorCount ?? 0) }}</div>
                <div class="stat-trend">Guest attendees</div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="chart-container">
                <h6><i class="fas fa-chart-pie text-primary me-2"></i>Attendance Distribution</h6>
                <div class="chart-box">
                    <canvas id="attendancePieChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <h6><i class="fas fa-chart-line text-primary me-2"></i>Weekly Attendance Trend</h6>
                <div class="chart-box">
                    <canvas id="attendanceTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="calendar-container">
        <div class="calendar-header">
            <h5>
                <i class="fas fa-calendar-alt text-primary me-2"></i>
                {{ \Carbon\Carbon::create($year ?? date('Y'), $month ?? date('m'), 1)->format('F Y') }}
            </h5>
            <div class="d-flex gap-2">
                <button onclick="changeMonth(-1)" class="btn-outline-custom">
                    <i class="fas fa-chevron-left"></i> Prev
                </button>
                <button onclick="changeMonth(1)" class="btn-outline-custom">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
        
        <div class="calendar-grid">
            <div class="calendar-weekday">Sun</div>
            <div class="calendar-weekday">Mon</div>
            <div class="calendar-weekday">Tue</div>
            <div class="calendar-weekday">Wed</div>
            <div class="calendar-weekday">Thu</div>
            <div class="calendar-weekday">Fri</div>
            <div class="calendar-weekday">Sat</div>
            
            @foreach($calendarData ?? [] as $week)
                @foreach($week as $day)
                    <div class="calendar-day {{ !$day['isCurrentMonth'] ? 'other-month' : '' }} {{ $day['isSunday'] ? 'sunday' : '' }} {{ $day['isSelected'] ? 'selected' : '' }}"
                         onclick="selectDate('{{ $day['date'] }}')">
                        <div class="day-number">{{ $day['day'] }}</div>
                        @if($day['isSunday'] && $day['hasRecord'])
                            <div class="day-badge recorded"><i class="fas fa-check-circle"></i> Recorded</div>
                        @elseif($day['isSunday'] && !$day['hasRecord'])
                            <div class="day-badge pending"><i class="fas fa-clock"></i> Pending</div>
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Attendance Form -->
    <form action="{{ route('sunday-attendance.store') }}" method="POST">
        @csrf
        <input type="hidden" name="service_date" value="{{ $selectedDate }}">

        <!-- Member Attendance Table - ENHANCED -->
        <div class="table-container">
            <div class="card-header-custom">
                <h6><i class="fas fa-users text-primary me-2"></i>Member Attendance</h6>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Member Information</th>
                            <th style="width: 140px;">Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody id="attendance-table-body">
                        @forelse($members ?? [] as $index => $member)
                        @php
                            $attendance = ($attendances ?? collect())->get($member->id);
                            $status = $attendance ? $attendance->status : 'Absent';
                        @endphp
                        <tr data-member-id="{{ $member->id }}">
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="member-avatar">
                                        {{ strtoupper(substr($member->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? '', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="color: var(--text-primary);">{{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}</div>
                                        @if(($member->is_choir ?? false))
                                            <small class="text-muted"><i class="fas fa-music"></i> Choir Member</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <select name="attendances[{{ $member->id }}][status]" class="status-select">
                                    <option value="Present" {{ $status == 'Present' ? 'selected' : '' }}>✅ Present</option>
                                    <option value="Absent" {{ $status == 'Absent' ? 'selected' : '' }}>❌ Absent</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="attendances[{{ $member->id }}][notes]" class="notes-input" placeholder="Add notes..." value="{{ $attendance ? $attendance->notes : '' }}">
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-users fa-2x text-muted mb-2 d-block opacity-50"></i>
                                    <p class="text-muted mb-0">No members found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Visitors Section -->
        <div class="table-container">
            <div class="card-header-custom">
                <h6><i class="fas fa-user-plus text-primary me-2"></i>Visitors ( <span id="visitor-count-display">{{ $visitorCount ?? 0 }}</span> )</h6>
            </div>
            <div class="p-3" id="visitors-container">
                @forelse($visitors ?? [] as $index => $visitor)
                <div class="visitor-row">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="visitors[{{ $index }}][name]" class="form-control form-control-sm" placeholder="Visitor Name" value="{{ $visitor->visitor_name ?? '' }}">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="visitors[{{ $index }}][notes]" class="form-control form-control-sm" placeholder="Notes (e.g., Guest of family)" value="{{ $visitor->notes ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm w-100 remove-visitor">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4" id="no-visitors-message">
                    <i class="fas fa-user-plus fa-2x mb-2 d-block opacity-50"></i>
                    <p class="mb-0">No visitors added yet</p>
                    <small class="text-muted">Click the button below to add visitors</small>
                </div>
                @endforelse
            </div>
            <div class="p-3 border-top" style="border-color: var(--border-color);">
                <button type="button" id="add-visitor" class="btn-outline-custom">
                    <i class="fas fa-plus-circle me-2"></i> Add Visitor
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center mt-4">
            <button type="submit" class="btn-save">
                <i class="fas fa-save me-2"></i> Save Attendance Record
            </button>
        </div>
    </form>
</div>

<!-- Hidden template for new visitor -->
<div id="new-visitor-template" style="display:none;">
    <div class="visitor-row">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="visitors[__INDEX__][name]" class="form-control form-control-sm" placeholder="Visitor Name">
            </div>
            <div class="col-md-5">
                <input type="text" name="visitors[__INDEX__][notes]" class="form-control form-control-sm" placeholder="Notes (e.g., Guest of family)">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm w-100 remove-visitor">
                    <i class="fas fa-trash-alt"></i> Remove
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Real-time Toast Notification -->
<div id="realtime-toast" class="realtime-toast">
    <i class="fas fa-bell toast-icon"></i>
    <span id="toast-message">Attendance updated!</span>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- ============================================
     LARAVEL ECHO SETUP - REAL-TIME BROADCASTING
     ============================================ -->
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pusher-js@8.0.2/dist/web/pusher.min.js"></script>

<script>
    // ============================================
    // CONFIGURE LARAVEL ECHO FOR REVERB
    // ============================================
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: '{{ env("REVERB_APP_KEY") }}',
        wsHost: '{{ env("REVERB_HOST", "127.0.0.1") }}',
        wsPort: {{ env("REVERB_PORT", 8080) }},
        wssPort: {{ env("REVERB_PORT", 8080) }},
        forceTLS: false,
        enabledTransports: ['ws', 'wss'],
    });

    // ============================================
    // LISTEN FOR ATTENDANCE UPDATES
    // ============================================
    let pieChart = null;
    let trendChart = null;

    // Initialize charts
    function initCharts() {
        // Pie Chart
        const pieCtx = document.getElementById('attendancePieChart');
        if (pieCtx && !pieChart) {
            pieChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Present', 'Absent', 'Visitors'],
                    datasets: [{
                        data: [
                            {{ $presentCount ?? 0 }}, 
                            {{ $absentCount ?? 0 }}, 
                            {{ $visitorCount ?? 0 }}
                        ],
                        backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { 
                                font: { size: 11 }, 
                                usePointStyle: true, 
                                boxWidth: 8, 
                                color: 'var(--text-primary)' 
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw || 0;
                                    const total = {{ ($presentCount ?? 0) + ($absentCount ?? 0) + ($visitorCount ?? 0) }};
                                    const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        // Line Chart
        const lineCtx = document.getElementById('attendanceTrendChart');
        if (lineCtx && !trendChart) {
            const weeklyData = @json($weeklyAttendance ?? []);
            trendChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: weeklyData.map(w => w.week),
                    datasets: [{
                        label: 'Attendance',
                        data: weeklyData.map(w => w.count),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.05)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { callbacks: { label: (ctx) => `Attendance: ${ctx.raw}` } }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            grid: { color: 'var(--border-color)' }, 
                            ticks: { stepSize: 5, font: { size: 10 }, color: 'var(--text-primary)' } 
                        },
                        x: { 
                            ticks: { font: { size: 10 }, color: 'var(--text-primary)' }, 
                            grid: { display: false } 
                        }
                    }
                }
            });
        }
    }

    // Update charts with new data
    function updateCharts(present, absent, visitors, weeklyData) {
        if (pieChart) {
            pieChart.data.datasets[0].data = [present, absent, visitors];
            pieChart.update();
        }

        if (trendChart && weeklyData) {
            trendChart.data.labels = weeklyData.map(w => w.week);
            trendChart.data.datasets[0].data = weeklyData.map(w => w.count);
            trendChart.update();
        }
    }

    // Show real-time notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('realtime-toast');
        const toastMessage = document.getElementById('toast-message');
        
        const colors = {
            success: 'linear-gradient(135deg, #10b981, #059669)',
            info: 'linear-gradient(135deg, #3b82f6, #2563eb)',
            warning: 'linear-gradient(135deg, #f59e0b, #d97706)'
        };
        
        toast.style.background = colors[type] || colors.success;
        toastMessage.textContent = message;
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    // Update live indicator
    function flashLiveIndicator() {
        const indicator = document.getElementById('live-indicator');
        if (indicator) {
            indicator.style.color = '#10b981';
            setTimeout(() => {
                indicator.style.color = '';
            }, 500);
        }
    }

    // ============================================
    // LISTEN FOR ATTENDANCE UPDATES
    // ============================================
    window.Echo.channel('attendance')
        .listen('attendance.updated', (e) => {
            console.log('📊 Attendance updated in real-time:', e);
            
            // Update statistics
            const present = e.present || e.presentCount || 0;
            const absent = e.absent || e.absentCount || 0;
            const total = e.total || e.totalMembers || 0;
            const visitors = e.visitors || e.visitorCount || 0;
            
            // Update stat cards
            document.getElementById('stat-present').textContent = present;
            document.getElementById('stat-absent').textContent = absent;
            document.getElementById('stat-total').textContent = total;
            document.getElementById('stat-visitors').textContent = visitors;
            
            // Update percentage
            const percent = total > 0 ? Math.round((present / total) * 100, 1) : 0;
            document.getElementById('stat-present-percent').textContent = percent + '% attendance rate';
            
            // Update visitor count display
            const visitorDisplay = document.getElementById('visitor-count-display');
            if (visitorDisplay) {
                visitorDisplay.textContent = visitors;
            }
            
            // Update charts if we have weekly data
            if (e.weekly_data) {
                updateCharts(present, absent, visitors, e.weekly_data);
            } else {
                // Just update pie chart
                updateCharts(present, absent, visitors, null);
            }
            
            // Show notification
            const church = e.church || e.churchName || 'Church';
            showToast(`📊 ${church}: ${present} present, ${absent} absent`);
            
            // Flash the live indicator
            flashLiveIndicator();
        });

    // ============================================
    // CALENDAR FUNCTIONS
    // ============================================
    let visitorCounter = {{ ($visitors ?? collect())->count() }};
    
    function selectDate(date) {
        window.location.href = "{{ route('sunday-attendance.index') }}?date=" + date;
    }
    
    function changeMonth(direction) {
        let year = {{ $year ?? date('Y') }};
        let month = {{ $month ?? date('m') }};
        let date = new Date(year, month - 1, 1);
        date.setMonth(date.getMonth() + direction);
        window.location.href = "{{ route('sunday-attendance.index') }}?year=" + date.getFullYear() + "&month=" + (date.getMonth() + 1);
    }
    
    // ============================================
    // ADD VISITOR
    // ============================================
    const addVisitorBtn = document.getElementById('add-visitor');
    if (addVisitorBtn) {
        addVisitorBtn.addEventListener('click', function() {
            const container = document.getElementById('visitors-container');
            const noVisitorMsg = document.getElementById('no-visitors-message');
            if (noVisitorMsg) {
                noVisitorMsg.remove();
            }
            
            const template = document.getElementById('new-visitor-template');
            const newRow = template.cloneNode(true);
            newRow.id = '';
            newRow.style.display = 'block';
            
            let html = newRow.innerHTML;
            html = html.replace(/__INDEX__/g, visitorCounter);
            newRow.innerHTML = html;
            
            container.appendChild(newRow);
            visitorCounter++;
            
            const removeBtn = newRow.querySelector('.remove-visitor');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    newRow.remove();
                    // Update visitor count
                    const rows = document.querySelectorAll('.visitor-row');
                    document.getElementById('visitor-count-display').textContent = rows.length;
                });
            }
        });
    }
    
    // ============================================
    // REMOVE VISITOR BUTTONS
    // ============================================
    document.querySelectorAll('.remove-visitor').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('.visitor-row');
            row.remove();
            // Update visitor count
            const rows = document.querySelectorAll('.visitor-row');
            document.getElementById('visitor-count-display').textContent = rows.length;
        });
    });

    // ============================================
    // INITIALIZE CHARTS
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        initCharts();
        
        // Show a welcome toast
        setTimeout(() => {
            showToast('🔄 Real-time attendance updates active!', 'info');
        }, 2000);
    });
</script>
@endsection