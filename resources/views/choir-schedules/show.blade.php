@extends('layouts.sidebar')

@section('header', 'Practice Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Practice Info Card -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Practice Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>📅 Date:</strong> {{ $practice->formatted_date }}</p>
                    <p><strong>🕒 Time:</strong> {{ $practice->time_range }}</p>
                    <p><strong>📍 Location:</strong> {{ $practice->location }}</p>
                    <p><strong>🎵 Status:</strong> 
                        @if($practice->is_mandatory)
                            <span class="badge bg-danger">Mandatory Attendance</span>
                        @else
                            <span class="badge bg-info">Regular Practice</span>
                        @endif
                    </p>
                    @if($practice->repertoire)
                        <hr>
                        <p><strong>📝 Repertoire:</strong></p>
                        <p class="text-muted">{{ $practice->repertoire }}</p>
                    @endif
                    @if($practice->notes)
                        <hr>
                        <p><strong>💡 Notes:</strong></p>
                        <p class="text-muted">{{ $practice->notes }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Attendance Summary -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Attendance Summary</h5>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart" style="height: 200px;"></canvas>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-success">{{ $presentCount }}</h4>
                            <small>Present</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-danger">{{ $absentCount }}</h4>
                            <small>Absent</small>
                        </div>
                        <div class="col-6 mt-2">
                            <h4 class="text-warning">{{ $lateCount }}</h4>
                            <small>Late</small>
                        </div>
                        <div class="col-6 mt-2">
                            <h4 class="text-info">{{ $excusedCount }}</h4>
                            <small>Excused</small>
                        </div>
                        <div class="col-12 mt-3">
                            <strong>Total Members:</strong> {{ $choirMembers->count() }}<br>
                            <strong>Not Marked:</strong> {{ $notMarkedCount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Attendance Marking Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Mark Attendance</h5>
                </div>
                <div class="card-body">
                    <form id="attendanceForm">
                        @csrf
                        <div class="table-responsive" style="max-height: 500px;">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Member</th>
                                        <th>Voice Part</th>
                                        <th>Status</th>
                                        <th>Notes</th>
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
                                                <option value="">— Select —</option>
                                                <option value="Present" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Present' ? 'selected' : '' }}>✓ Present</option>
                                                <option value="Absent" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Absent' ? 'selected' : '' }}>✗ Absent</option>
                                                <option value="Late" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Late' ? 'selected' : '' }}>⏰ Late</option>
                                                <option value="Excused" {{ isset($attendances[$member->id]) && $attendances[$member->id]->status == 'Excused' ? 'selected' : '' }}>📝 Excused</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm notes-input" 
                                                   data-member-id="{{ $member->id }}"
                                                   placeholder="Optional notes"
                                                   value="{{ isset($attendances[$member->id]) ? $attendances[$member->id]->notes : '' }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            }</table>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-primary" id="saveAttendanceBtn">
                                <i class="fas fa-save"></i> Save All Changes
                            </button>
                            <a href="{{ route('choir-schedules.print-attendance', $practice->id) }}" class="btn btn-secondary" target="_blank">
                                <i class="fas fa-print"></i> Print Attendance Sheet
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
            labels: ['Present', 'Absent', 'Late', 'Excused'],
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
            alert('Please select at least one attendance status.');
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