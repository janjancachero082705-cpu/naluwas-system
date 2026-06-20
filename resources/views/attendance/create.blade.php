@extends('layouts.sidebar')

@section('header', 'Record Attendance')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-fingerprint me-2"></i> Record New Attendance</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Member *</label>
                            <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                                <option value="">Choose member...</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Service Date *</label>
                            <input type="date" name="service_date" class="form-control @error('service_date') is-invalid @enderror" value="{{ old('service_date', date('Y-m-d')) }}" required>
                            @error('service_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Present" {{ old('status') == 'Present' ? 'selected' : '' }}>✅ Present</option>
                                <option value="Late" {{ old('status') == 'Late' ? 'selected' : '' }}>⏰ Late</option>
                                <option value="Absent" {{ old('status') == 'Absent' ? 'selected' : '' }}>❌ Absent</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role (Optional)</label>
                            <input type="text" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ old('role') }}" placeholder="e.g., Usher, Choir, Pastor">
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Notes (Optional)</label>
                            <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-save me-2"></i> Save Attendance
                            </button>
                            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection