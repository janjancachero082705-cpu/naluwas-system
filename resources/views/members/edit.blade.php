@extends('layouts.sidebar')

@section('header', 'Edit Member')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-user-edit me-2 text-primary"></i>Edit Member
                    </h5>
                    <p class="text-muted small mt-2">Update member information and assign ministries/roles</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('members.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control form-control-lg rounded-3 @error('first_name') is-invalid @enderror" value="{{ old('first_name', $member->first_name) }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control form-control-lg rounded-3 @error('last_name') is-invalid @enderror" value="{{ old('last_name', $member->last_name) }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Birthday</label>
                                <input type="date" name="birthday" class="form-control form-control-lg rounded-3 @error('birthday') is-invalid @enderror" value="{{ old('birthday', $member->birthday) }}">
                                @error('birthday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Address</label>
                            <textarea name="address" class="form-control rounded-3 @error('address') is-invalid @enderror" rows="2" placeholder="Enter address">{{ old('address', $member->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Ministry Roles Selection - Card Style --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-3">
                                <i class="fas fa-tags me-2 text-primary"></i>Ministries / Roles
                                <span class="text-danger">*</span>
                                <small class="text-muted d-block mt-1">Select one or more ministries for this member</small>
                            </label>
                            
                            <div class="row g-3">
                                @foreach($roles as $role)
                                    @php
                                        $isChecked = in_array($role->id, $memberRoles);
                                    @endphp
                                    <div class="col-md-4">
                                        <div class="role-card">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" 
                                                   {{ $isChecked ? 'checked' : '' }}>
                                            <label for="role_{{ $role->id }}" class="role-card-label">
                                                <div class="role-card-icon">
                                                    <i class="{{ $role->icon }}"></i>
                                                </div>
                                                <div class="role-card-info">
                                                    <h6 class="role-card-title">{{ $role->name }}</h6>
                                                    <p class="role-card-desc">{{ $isChecked ? 'Currently assigned' : 'Click to assign' }}</p>
                                                </div>
                                                <div class="role-card-check">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('members.index') }}" class="btn btn-secondary rounded-3 px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-3 px-4">
                                <i class="fas fa-save me-2"></i>Update Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Role Card Styles */
    .role-card {
        position: relative;
        margin-bottom: 0.5rem;
    }
    
    .role-card input[type="checkbox"] {
        display: none;
    }
    
    .role-card-label {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .role-card-label::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(139, 92, 246, 0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .role-card-label:hover {
        transform: translateY(-2px);
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .role-card-label:hover::before {
        opacity: 1;
    }
    
    .role-card-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #e0e7ff, #ede9fe);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #4f46e5;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    
    .role-card-info {
        flex: 1;
    }
    
    .role-card-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 2px 0;
    }
    
    .role-card-desc {
        font-size: 0.65rem;
        color: #94a3b8;
        margin: 0;
    }
    
    .role-card-check {
        width: 24px;
        height: 24px;
        border-radius: 20px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    
    /* Selected State */
    .role-card input[type="checkbox"]:checked + .role-card-label {
        background: linear-gradient(135deg, #eff6ff, #f5f3ff);
        border-color: #818cf8;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }
    
    .role-card input[type="checkbox"]:checked + .role-card-label .role-card-icon {
        background: linear-gradient(135deg, #818cf8, #c084fc);
        color: white;
    }
    
    .role-card input[type="checkbox"]:checked + .role-card-label .role-card-check {
        background: #10b981;
    }
    
    .role-card input[type="checkbox"]:checked + .role-card-label .role-card-check i {
        font-size: 0.7rem;
    }
    
    /* Form Styles */
    .form-control-lg {
        font-size: 0.95rem;
        padding: 0.625rem 1rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #818cf8;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
    }
    
    .card {
        border-radius: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .role-card-label {
            padding: 10px 12px;
        }
        
        .role-card-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
        }
        
        .role-card-title {
            font-size: 0.8rem;
        }
    }
</style>

@push('scripts')
<script>
    // Add ripple effect on card click
    document.querySelectorAll('.role-card-label').forEach(label => {
        label.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            const x = e.clientX - e.target.offsetLeft;
            const y = e.clientY - e.target.offsetTop;
            
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
</script>

<style>
    .ripple {
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(79, 70, 229, 0.15);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        from {
            transform: scale(0);
            opacity: 0.5;
        }
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>
@endpush

@endsection