@extends('layouts.sidebar')

@section('header')
    <span data-i18n="practice_details">Practice Details</span>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Practice Info Card -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><span data-i18n="practice_information">Practice Information</span></h5>
                </div>
                <div class="card-body">
                    <p><strong><span data-i18n="date_label">📅 Date:</span></strong> {{ $practice->formatted_date }}</p>
                    <p><strong><span data-i18n="time_label">🕒 Time:</span></strong> {{ $practice->time_range }}</p>
                    <p><strong><span data-i18n="location_label">📍 Location:</span></strong> {{ $practice->location }}</p>
                    <p><strong><span data-i18n="status_label">🎵 Status:</span></strong> 
                        @if($practice->is_mandatory)
                            <span class="badge bg-danger"><span data-i18n="mandatory_attendance">Mandatory Attendance</span></span>
                        @else
                            <span class="badge bg-info"><span data-i18n="regular_practice">Regular Practice</span></span>
                        @endif
                    </p>
                    @if($practice->repertoire)
                        <hr>
                        <p><strong><span data-i18n="repertoire_label">📝 Repertoire:</span></strong></p>
                        <p class="text-muted">{{ $practice->repertoire }}</p>
                    @endif
                    @if($practice->notes)
                        <hr>
                        <p><strong><span data-i18n="notes_label">💡 Notes:</span></strong></p>
                        <p class="text-muted">{{ $practice->notes }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Attendance Summary -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><span data-i18n="attendance_summary">Attendance Summary</span></h5>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" style="height: 200px;"></canvas>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-success">{{ $presentCount }}</h4>
                            <small><span data-i18n="present_label">Present</span></small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-danger">{{ $absentCount }}</h4>
                            <small><span data-i18n="absent_label">Absent</span></small>
                        </div>
                        <div class="col-6 mt-2">
                            <h4 class="text-warning">{{ $lateCount }}</h4>
                            <small><span data-i18n="late_label">Late</span></small>
                        </div>
                        <div class="col-6 mt-2">
                            <h4 class="text-info">{{ $excusedCount }}</h4>
                            <small><span data-i18n="excused_label">Excused</span></small>
                        </div>
                        <div class="col-12 mt-3">
                            <strong><span data-i18n="total_members_label">Total Members:</span></strong> {{ $choirMembers->count() }}<br>
                            <strong><span data-i18n="not_marked_label">Not Marked:</span></strong> {{ $notMarkedCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Attendance Marking Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><span data-i18n="mark_attendance">Mark Attendance</span></h5>
                </div>
                <div class="card-body">
                    <form id="attendanceForm">
                        @csrf
                        <div class="table-responsive" style="max-height: 500px;">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><span data-i18n="member_label">Member</span></th>
                                        <th><span data-i18n="voice_part">Voice Part</span></th>
                                        <th><span data-i18n="status_label">Status</span></th>
                                        <th><span data-i18n="notes_label">Notes</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($choirMembers as $member)
                                    <tr>
                                        <td>
                                            <strong>{{ $member->first_name }} {{ $member->last_name }}</strong>
                                        </td>
                                        <td>{{ $member->voice_part ?? '—' }}</td>
                                        <td>
                                            <select class="form-control form-control-sm status-select" 
                                                    data-member-id="{{ $member->id }}"
                                                    style="width: 120px;">
                                                <option value="">— <span data-i18n="select">Select</span> —</option>
                                                <option value="Present" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Present' ? 'selected' : '' }}>✓ <span data-i18n="present">Present</span></option>
                                                <option value="Absent" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Absent' ? 'selected' : '' }}>✗ <span data-i18n="absent">Absent</span></option>
                                                <option value="Late" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Late' ? 'selected' : '' }}>⏰ <span data-i18n="late">Late</span></option>
                                                <option value="Excused" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Excused' ? 'selected' : '' }}>📝 <span data-i18n="excused">Excused</span></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm notes-input" 
                                                   data-member-id="{{ $member->id }}"
                                                   placeholder="{{ __('Optional notes') }}"
                                                   value="{{ isset($attendances[$member->id]) ? $attendances[$member->id]->notes : '' }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-primary" id="saveAttendanceBtn">
                                <i class="fas fa-save"></i> <span data-i18n="save_all_changes">Save All Changes</span>
                            </button>
                            <a href="{{ route('choir-schedules.print-attendance', $practice->id) }}" class="btn btn-secondary" target="_blank">
                                <i class="fas fa-print"></i> <span data-i18n="print_attendance_sheet">Print Attendance Sheet</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Attendance Chart
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                window.t ? window.t('present') : 'Present', 
                window.t ? window.t('absent') : 'Absent', 
                window.t ? window.t('late') : 'Late', 
                window.t ? window.t('excused') : 'Excused'
            ],
            datasets: [{
                data: [{{ $presentCount }}, {{ $absentCount }}, {{ $lateCount }}, {{ $excusedCount }}],
                backgroundColor: ['#10B981', '#EF4444', '#F59E0B', '#8B5CF6'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Save Attendance Function
    document.getElementById('saveAttendanceBtn').addEventListener('click', function() {
        const statuses = document.querySelectorAll('.status-select');
        const notes = document.querySelectorAll('.notes-input');
        const attendances = [];
        
        statuses.forEach(select => {
            const memberId = select.dataset.memberId;
            const status = select.value;
            if (status) {
                const noteInput = Array.from(notes).find(n => n.dataset.memberId === memberId);
                attendances.push({
                    member_id: memberId,
                    status: status,
                    notes: noteInput ? noteInput.value : ''
                });
            }
        });
        
        if (attendances.length === 0) {
            alert(window.t ? window.t('select_attendance_status') : 'Please select at least one attendance status.');
            return;
        }
        
        fetch('{{ route("choir-schedules.attendance.bulk", $practice->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ attendances: attendances })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    });
</script>
@endsection