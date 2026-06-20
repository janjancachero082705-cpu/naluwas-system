@extends('layouts.app')

@section('header', 'Choir Schedule')

@section('content')
<style>
    /* ============================================
       CLEAN UI - SAME STYLE AS OTHER PAGES
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
    
    /* Month Selector */
    .month-selector-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .month-selector-container label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .month-selector-container label i {
        color: #10b981;
    }
    
    .month-selector-container select {
        padding: 0.4rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 150px;
    }
    
    .month-selector-container select:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .month-info {
        font-size: 0.7rem;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        border: 1px solid var(--border-color);
    }
    
    /* Rotation Order */
    .rotation-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
    }
    
    .rotation-container h6 {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 0.5rem 0;
    }
    
    .rotation-container h6 i {
        color: #10b981;
        margin-right: 6px;
    }
    
    .rotation-badges {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }
    
    .rotation-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .rotation-badge .position {
        font-weight: 700;
        color: #10b981;
    }
    
    .rotation-arrow {
        color: var(--text-muted);
        font-size: 0.7rem;
    }
    
    .rotation-small {
        font-size: 0.6rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
        display: block;
    }
    
    /* Calendar Container */
    .calendar-container {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
    }
    
    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .calendar-header h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
    }
    
    .calendar-weekday {
        text-align: center;
        padding: 0.5rem;
        font-weight: 700;
        font-size: 0.6rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: var(--bg-tertiary);
        border-radius: 8px;
        color: var(--text-muted);
    }
    
    .calendar-day {
        min-height: 100px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem;
        cursor: default;
        transition: all 0.2s ease;
    }
    
    .calendar-day.clickable {
        cursor: pointer;
    }
    
    .calendar-day.clickable:hover {
        transform: translateY(-2px);
        border-color: #10b981;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .calendar-day.scheduled {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }
    
    .calendar-day.other-month {
        opacity: 0.4;
    }
    
    /* Only apply past-month to months BEFORE current month */
    .calendar-day.past-month {
        opacity: 0.6;
        background: var(--bg-tertiary);
    }
    
    .day-number {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }
    
    .today-badge {
        background: #ef4444;
        color: white;
        padding: 1px 6px;
        border-radius: 20px;
        font-size: 0.5rem;
        font-weight: 600;
    }
    
    .sunday-group-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 4px 6px;
        border-radius: 8px;
        font-size: 0.6rem;
        font-weight: 700;
        color: white;
        margin-top: 4px;
        text-align: center;
    }
    
    .sunday-group-badge i {
        font-size: 0.5rem;
    }
    
    .sunday-group-badge.past {
        opacity: 0.7;
    }
    
    .member-count {
        text-align: center;
        font-size: 0.55rem;
        color: var(--text-muted);
        margin-top: 4px;
    }
    
    .calendar-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: var(--text-muted);
        font-size: 0.6rem;
        opacity: 0.5;
    }
    
    .status-badge-past {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.5rem;
        font-weight: 600;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        margin-top: 4px;
    }
    
    /* Modal Styles */
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
    
    .member-list-card {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .member-list-card .card-header {
        padding: 0.5rem 1rem;
        font-size: 0.7rem;
        font-weight: 700;
        color: white;
        border-bottom: 1px solid var(--border-color);
    }
    
    .member-list-card .card-header.bg-success {
        background: linear-gradient(135deg, #10b981, #059669);
    }
    
    .member-list-card .card-header.bg-primary {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }
    
    .member-list {
        max-height: 300px;
        overflow-y: auto;
        padding: 0.25rem;
    }
    
    .member-list::-webkit-scrollbar {
        width: 4px;
    }
    
    .member-list::-webkit-scrollbar-track {
        background: var(--bg-tertiary);
        border-radius: 10px;
    }
    
    .member-list::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 10px;
    }
    
    .member-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0.8rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.15s ease;
    }
    
    .member-item:hover {
        background: var(--bg-tertiary);
    }
    
    .member-item:last-child {
        border-bottom: none;
    }
    
    .member-item .name {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--text-primary);
    }
    
    .member-item .role {
        font-size: 0.6rem;
        color: var(--text-muted);
    }
    
    .member-item .btn-sm {
        padding: 0.2rem 0.6rem;
        border-radius: 6px;
        font-size: 0.6rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-sm-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .btn-sm-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    
    .btn-sm-danger {
        background: #ef4444;
        color: white;
    }
    
    .btn-sm-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
    }
    
    .search-input {
        width: 100%;
        padding: 0.4rem 0.8rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.75rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
    }
    
    .search-input::placeholder {
        color: var(--text-muted);
    }
    
    /* Empty State in Modal */
    .empty-members {
        text-align: center;
        padding: 1.5rem;
        color: var(--text-muted);
    }
    
    .empty-members i {
        font-size: 1.5rem;
        margin-bottom: 0.3rem;
        opacity: 0.3;
        color: #10b981;
    }
    
    .empty-members p {
        font-size: 0.75rem;
        margin: 0;
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
        .calendar-grid {
            gap: 4px;
        }
        .calendar-day {
            min-height: 70px;
            padding: 0.3rem;
        }
        .day-number {
            font-size: 0.65rem;
        }
        .sunday-group-badge {
            font-size: 0.5rem;
            padding: 2px 4px;
        }
        .member-count {
            font-size: 0.5rem;
        }
        .calendar-header {
            flex-direction: column;
            align-items: stretch;
        }
        .rotation-badges {
            justify-content: center;
        }
        .month-selector-container {
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }
        .month-selector-container select {
            width: 100%;
        }
        .modal-body .row {
            flex-direction: column;
            gap: 1rem;
        }
        .member-item .name {
            font-size: 0.7rem;
        }
        .member-item .btn-sm {
            padding: 0.15rem 0.5rem;
            font-size: 0.55rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <!-- Hero Section - Green -->
    <div class="choir-hero">
        <div class="hero-left">
            <h1><i class="fas fa-calendar-alt"></i> Choir Schedule</h1>
            <p>Auto-rotating choir groups every Sunday</p>
        </div>
        <a href="{{ route('choir-schedules.groups') }}" class="btn-hero">
            <i class="fas fa-layer-group me-2"></i> Manage Groups
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h4>Total Members</h4>
                <div class="stat-value">{{ $totalChoirMembers ?? 0 }}</div>
                <div class="stat-trend">Choir members</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-layer-group"></i></div>
            <div class="stat-info">
                <h4>Active Groups</h4>
                <div class="stat-value">{{ $totalGroups ?? 0 }}</div>
                <div class="stat-trend">Groups rotating</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-calendar-week"></i></div>
            <div class="stat-info">
                <h4>This Month</h4>
                <div class="stat-value">{{ $thisMonthSchedules ?? 0 }}</div>
                <div class="stat-trend">Schedules this month</div>
            </div>
        </div>
    </div>

    <!-- Month Selector -->
    <div class="month-selector-container">
        <label for="monthYearSelect">
            <i class="fas fa-calendar-alt"></i> Select Month:
        </label>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
            <select id="monthYearSelect" onchange="window.location.href='{{ route('choir-schedules.index') }}?month=' + this.value">
                @foreach($availableMonths as $monthOption)
                    <option value="{{ $monthOption['value'] }}" {{ $selectedMonthYear == $monthOption['value'] ? 'selected' : '' }}>
                        {{ $monthOption['label'] }}
                    </option>
                @endforeach
            </select>
            <span class="month-info">
                <i class="fas fa-info-circle"></i> 
                {{ \Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear)->format('F Y') }}
                @if(\Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear)->isCurrentMonth())
                    <span style="color: #10b981;"> (Current)</span>
                @elseif(\Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear)->lt(\Carbon\Carbon::now()->startOfMonth()))
                    <span style="color: var(--text-muted);"> (Past)</span>
                @else
                    <span style="color: #f59e0b;"> (Future)</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Rotation Order -->
    @if(isset($rotationOrder) && count($rotationOrder) > 0)
    <div class="rotation-container">
        <h6><i class="fas fa-chart-line"></i> Group Rotation Order</h6>
        <div class="rotation-badges">
            @foreach($rotationOrder as $pos)
                <span class="rotation-badge">
                    <span class="position">{{ $pos['position'] }}.</span>
                    <span style="color: {{ $pos['color'] }};">{{ $pos['group_name'] }}</span>
                </span>
                @if(!$loop->last) 
                    <span class="rotation-arrow"><i class="fas fa-arrow-right"></i></span>
                @endif
            @endforeach
        </div>
        <span class="rotation-small">Groups rotate in this order every Sunday</span>
    </div>
    @endif

    <!-- Calendar -->
    <div class="calendar-container">
        <div class="calendar-header">
            <h5>{{ \Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear)->format('F Y') }}</h5>
            <div style="font-size: 0.65rem; color: var(--text-muted);">
                @if(\Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear)->isCurrentMonth())
                    <span style="color: #10b981;"><i class="fas fa-circle"></i> Current Month</span>
                @elseif(\Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear)->lt(\Carbon\Carbon::now()->startOfMonth()))
                    <span><i class="fas fa-history"></i> Past Month (View Only)</span>
                @else
                    <span style="color: #f59e0b;"><i class="fas fa-clock"></i> Future Month</span>
                @endif
            </div>
        </div>

        <div class="calendar-grid">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                <div class="calendar-weekday">{{ $day }}</div>
            @endforeach

            @php
                $selectedDate = \Carbon\Carbon::createFromFormat('Y-m', $selectedMonthYear);
                $firstDay = $selectedDate->copy()->startOfMonth();
                $startDay = $firstDay->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                $endDay = $firstDay->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);
                $currentDay = $startDay->copy();
                $today = \Carbon\Carbon::today();
                $isCurrentMonth = $selectedDate->isCurrentMonth();
                // Only treat as past month if it's BEFORE the current month
                $isPastMonth = $selectedDate->lt(\Carbon\Carbon::now()->startOfMonth());
            @endphp

            @while($currentDay <= $endDay)
                @php
                    $isCurrentMonthDay = $currentDay->month == $selectedDate->month && $currentDay->year == $selectedDate->year;
                    $isSunday = $currentDay->dayOfWeek == \Carbon\Carbon::SUNDAY;
                    $isToday = $currentDay->isSameDay($today);
                    $sundayData = collect($sundays)->firstWhere('date', $currentDay->format('Y-m-d'));
                    $hasSchedule = $sundayData && $sundayData['has_schedule'];
                    // Only clickable if current month AND has schedule
                    $isClickable = $isSunday && $isCurrentMonthDay && $hasSchedule && $isCurrentMonth;
                    $isPastSunday = $isSunday && $currentDay->isPast();
                @endphp

                <div class="calendar-day 
                            {{ !$isCurrentMonthDay ? 'other-month' : '' }} 
                            {{ $hasSchedule ? 'scheduled' : '' }}
                            {{ $isClickable ? 'clickable' : '' }}
                            {{ ($isPastMonth && $isCurrentMonthDay) ? 'past-month' : '' }}"
                     onclick="{{ $isClickable ? "openMemberModal('" . $currentDay->format('Y-m-d') . "', '" . $currentDay->format('F d, Y') . "')" : '' }}">

                    <div class="day-number">
                        <span>{{ $currentDay->day }}</span>
                        @if($isToday)
                            <span class="today-badge">Today</span>
                        @endif
                    </div>

                    @if($isSunday && $isCurrentMonthDay)
                        @if($hasSchedule && $sundayData['group'])
                            <div class="sunday-group-badge {{ $isPastSunday ? 'past' : '' }}" style="background: {{ $sundayData['group']->color ?? '#8b5cf6' }};">
                                <i class="fas fa-layer-group"></i>
                                <strong>{{ $sundayData['group']->name ?? 'Group' }}</strong>
                            </div>
                            <div class="member-count">
                                <i class="fas fa-users"></i> {{ count($sundayData['members'] ?? []) }} members
                                @if($isPastSunday)
                                    <span style="display: block; font-size: 0.5rem; color: var(--text-muted);">(Completed)</span>
                                @endif
                            </div>
                        @elseif($isSunday && $isCurrentMonthDay)
                            <div class="calendar-empty">
                                <span>No schedule</span>
                            </div>
                        @endif
                    @elseif($isSunday && !$isCurrentMonthDay)
                        <div class="calendar-empty" style="font-size: 0.5rem;">
                            <span>—</span>
                        </div>
                    @endif
                </div>
                @php $currentDay->addDay(); @endphp
            @endwhile
        </div>
        
        <div style="margin-top: 1rem; padding-top: 0.8rem; border-top: 1px solid var(--border-color); display: flex; gap: 1.5rem; flex-wrap: wrap; font-size: 0.65rem; color: var(--text-muted);">
            <span><span style="display: inline-block; width: 12px; height: 12px; border-radius: 3px; background: rgba(16,185,129,0.2); border: 1px solid #10b981; vertical-align: middle; margin-right: 4px;"></span> Scheduled</span>
            <span><span style="display: inline-block; width: 12px; height: 12px; border-radius: 3px; background: var(--bg-tertiary); border: 1px solid var(--border-color); vertical-align: middle; margin-right: 4px;"></span> No Schedule</span>
            <span><span style="display: inline-block; width: 12px; height: 12px; border-radius: 3px; background: var(--bg-tertiary); border: 1px solid var(--border-color); opacity: 0.4; vertical-align: middle; margin-right: 4px;"></span> Other Month</span>
            @if($isPastMonth)
                <span style="color: var(--text-muted);"><i class="fas fa-lock"></i> Past month - View only</span>
            @endif
        </div>
    </div>
</div>

<!-- Member Modal -->
<div id="memberModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-users"></i> Manage Members for <span id="modalDateLabel"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="member-list-card">
                            <div class="card-header bg-success">Scheduled Members</div>
                            <div class="member-list" id="scheduledMembersList">
                                <div class="empty-members">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    <p>Loading...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="member-list-card">
                            <div class="card-header bg-primary">Available Members</div>
                            <div class="member-list" id="availableMembersList">
                                <input type="text" id="memberSearch" class="search-input" placeholder="🔍 Search members...">
                                <div id="availableMembersContainer">
                                    <div class="empty-members">
                                        <i class="fas fa-spinner fa-spin"></i>
                                        <p>Loading...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentSelectedDate = '';

    function openMemberModal(date, formattedDate) {
        currentSelectedDate = date;
        document.getElementById('modalDateLabel').textContent = formattedDate;

        loadScheduledMembers(date);
        loadAvailableMembers(date);

        new bootstrap.Modal(document.getElementById('memberModal')).show();
    }

    function loadScheduledMembers(date) {
        const container = document.getElementById('scheduledMembersList');
        container.innerHTML = `<div class="empty-members"><i class="fas fa-spinner fa-spin"></i><p>Loading...</p></div>`;

        fetch(`/choir-schedules/get-schedule/${date}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.scheduled_members) {
                    if (data.scheduled_members.length === 0) {
                        container.innerHTML = `
                            <div class="empty-members">
                                <i class="fas fa-users"></i>
                                <p>No members scheduled</p>
                            </div>
                        `;
                    } else {
                        container.innerHTML = data.scheduled_members.map(m => `
                            <div class="member-item">
                                <div>
                                    <div class="name">${m.first_name} ${m.last_name}</div>
                                    <div class="role"><i class="fas fa-microphone-alt me-1"></i> ${m.choir_role || 'Choir Member'}</div>
                                </div>
                                <button class="btn-sm btn-sm-danger" onclick="removeMember(${m.id})">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        `).join('');
                    }
                }
            })
            .catch(() => {
                container.innerHTML = `
                    <div class="empty-members">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Error loading members</p>
                    </div>
                `;
            });
    }

    function loadAvailableMembers(date) {
        const container = document.getElementById('availableMembersContainer');
        container.innerHTML = `<div class="empty-members"><i class="fas fa-spinner fa-spin"></i><p>Loading...</p></div>`;

        fetch(`/choir-schedules/get-schedule/${date}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.available_members) {
                    if (data.available_members.length === 0) {
                        container.innerHTML = `
                            <div class="empty-members">
                                <i class="fas fa-user-check"></i>
                                <p>No available members</p>
                            </div>
                        `;
                    } else {
                        container.innerHTML = data.available_members.map(m => `
                            <div class="member-item">
                                <div>
                                    <div class="name">${m.first_name} ${m.last_name}</div>
                                    <div class="role"><i class="fas fa-microphone-alt me-1"></i> ${m.choir_role || 'Choir Member'}</div>
                                </div>
                                <button class="btn-sm btn-sm-success" onclick="addMember(${m.id})">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        `).join('');
                    }
                }
            })
            .catch(() => {
                container.innerHTML = `
                    <div class="empty-members">
                        <i class="fas fa-exclamation-circle"></i>
                        <p>Error loading members</p>
                    </div>
                `;
            });
    }

    function addMember(memberId) {
        fetch('/choir-schedules/add-member', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                service_date: currentSelectedDate,
                member_id: memberId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Member added successfully',
                    timer: 1500,
                    showConfirmButton: false,
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
                loadScheduledMembers(currentSelectedDate);
                loadAvailableMembers(currentSelectedDate);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Something went wrong',
                    confirmButtonColor: '#ef4444',
                    background: 'var(--card-bg)',
                    color: 'var(--text-primary)'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Network error. Please try again.',
                confirmButtonColor: '#ef4444',
                background: 'var(--card-bg)',
                color: 'var(--text-primary)'
            });
        });
    }

    function removeMember(memberId) {
        Swal.fire({
            title: 'Remove member?',
            text: 'Remove this member from the schedule?',
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
                fetch('/choir-schedules/remove-member', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        service_date: currentSelectedDate,
                        member_id: memberId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: 'Member removed successfully',
                            timer: 1500,
                            showConfirmButton: false,
                            background: 'var(--card-bg)',
                            color: 'var(--text-primary)'
                        });
                        loadScheduledMembers(currentSelectedDate);
                        loadAvailableMembers(currentSelectedDate);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Something went wrong',
                            confirmButtonColor: '#ef4444',
                            background: 'var(--card-bg)',
                            color: 'var(--text-primary)'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Network error. Please try again.',
                        confirmButtonColor: '#ef4444',
                        background: 'var(--card-bg)',
                        color: 'var(--text-primary)'
                    });
                });
            }
        });
    }

    // Search members
    document.getElementById('memberSearch')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const items = document.querySelectorAll('#availableMembersContainer .member-item');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? 'flex' : 'none';
        });
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('memberModal');
            if (modal.classList.contains('show')) {
                bootstrap.Modal.getInstance(modal)?.hide();
            }
        }
    });
</script>
@endsection