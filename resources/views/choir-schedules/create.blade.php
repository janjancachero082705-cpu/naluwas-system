@extends('layouts.sidebar')

@section('header', 'Schedule Choir Practice')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Practice Schedule</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('choir-schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Practice Date <span class="text-danger">*</span></label>
                                <input type="date" name="practice_date" class="form-control @error('practice_date') is-invalid @enderror" required>
                                @error('practice_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                   placeholder="e.g., Music Room, Main Sanctuary" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Repertoire / Songs to Practice</label>
                            <textarea name="repertoire" class="form-control @error('repertoire') is-invalid @enderror" 
                                      rows="3" placeholder="List the songs or pieces to be practiced..."></textarea>
                            @error('repertoire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                      rows="2" placeholder="Any special instructions or reminders..."></textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_mandatory" class="form-check-input" id="mandatory" value="1">
                            <label class="form-check-label" for="mandatory">
                                Mandatory Attendance <span class="text-danger">*</span>
                                <small class="text-muted d-block">All choir members must attend this practice</small>
                            </label>
                        </div>
                        
                        <div class="text-end">
                            <a href="{{ route('choir-schedules.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Schedule Practice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection