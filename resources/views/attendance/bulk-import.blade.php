@extends('layouts.sidebar')

@section('header', 'Bulk Import Attendance')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 py-3">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-upload"></i> Bulk Import Attendance</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('sunday-attendance.process-bulk') }}" method="POST">
                        @csrf
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This will allow you to input attendance for multiple Sundays at once.
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar"></i> Generate Attendance Form
                            </button>
                            <a href="{{ route('sunday-attendance.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection