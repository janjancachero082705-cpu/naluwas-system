@extends('layouts.sidebar')

@section('header', 'Choir Member Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="avatar-circle mx-auto mb-3">
                            <span class="avatar-text">{{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}</span>
                        </div>
                        <h4>{{ $member->first_name }} {{ $member->last_name }}</h4>
                        <p class="text-muted">{{ $member->choir_role ?? 'Choir Member' }}</p>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted">Voice Part</small>
                                <h6 class="mb-0">{{ $member->voice_part ?? 'Not Assigned' }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <small class="text-muted">Status</small>
                                <h6 class="mb-0">
                                    @if($member->choir_status == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @elseif($member->choir_status == 'Inactive')
                                        <span class="badge bg-danger">Inactive</span>
                                    @else
                                        <span class="badge bg-warning">On Leave</span>
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="border rounded p-2">
                            <small class="text-muted">Attendance Rate</small>
                            <h3 class="mb-0 text-success">{{ round($attendanceRate) }}%</h3>
                            <small>{{ $presentPractices }} / {{ $totalPractices }} practices attended</small>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('choir-members.edit', $member->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Details
                        </a>
                        <a href="mailto:{{ $member->email }}" class="btn btn-info">
                            <i class="fas fa-envelope"></i> Contact Member
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Member Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Email:</strong> {{ $member->email }}</p>
                            <p><strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Joined Choir:</strong> {{ $member->choir_join_date ? \Carbon\Carbon::parse($member->choir_join_date)->format('M d, Y') : 'N/A' }}</p>
                            <p><strong>Birthdate:</strong> {{ $member->birthdate ? \Carbon\Carbon::parse($member->birthdate)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <p><strong>Address:</strong> {{ $member->address ?? 'N/A' }}</p>
                </div>
            </div>
            
            <!-- Practice Attendance History -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Practice Attendance History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Practice Date</th>
                                    <th>Time</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($practiceAttendances as $attendance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($attendance->choirPractice->practice_date)->format('M d, Y') }}</td>
                                    <td>{{ $attendance->choirPractice->start_time }} - {{ $attendance->choirPractice->end_time }}</td>
                                    <td>{{ $attendance->choirPractice->location }}</td>
                                    <td>
                                        @if($attendance->status == 'Present')
                                            <span class="badge bg-success">✓ Present</span>
                                        @elseif($attendance->status == 'Absent')
                                            <span class="badge bg-danger">✗ Absent</span>
                                        @elseif($attendance->status == 'Late')
                                            <span class="badge bg-warning">⏰ Late</span>
                                        @else
                                            <span class="badge bg-info">📝 Excused</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->notes ?? '—' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No attendance records yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.avatar-text {
    font-size: 40px;
    font-weight: bold;
    color: white;
}
</style>
@endsection