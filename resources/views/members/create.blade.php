@extends('layouts.app')

@section('header', 'Add New Member')

@section('content')
<style>
    /* ============================================
       FORM STYLES WITH GREEN ACCENTS
    ============================================ */
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        max-width: 750px;
        margin: 0 auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        position: relative;
        overflow: hidden;
    }
    
    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #10b981, #34d399, #059669);
    }
    
    .form-card .form-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .form-card .form-label i {
        color: #10b981;
        font-size: 0.65rem;
        width: 16px;
        text-align: center;
    }
    
    .form-card .form-control,
    .form-card .form-select {
        background: var(--input-bg);
        border: 1.5px solid var(--input-border);
        color: var(--text-primary);
        border-radius: 10px;
        padding: 0.65rem 1rem;
        font-size: 0.85rem;
        transition: all 0.25s ease;
    }
    
    .form-card .form-control:focus,
    .form-card .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: var(--input-bg);
    }
    
    .form-card .form-control.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }
    
    .form-card .form-control::placeholder {
        color: var(--text-muted);
        opacity: 0.7;
    }
    
    .form-card .form-text {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .form-card .form-text i {
        color: #10b981;
        font-size: 0.6rem;
    }
    
    /* Role Checkbox Group */
    .role-checkbox-group {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 0.6rem;
        margin-top: 0.5rem;
    }
    
    .role-checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.55rem 0.9rem;
        background: var(--bg-tertiary);
        border: 1.5px solid var(--border-color);
        border-radius: 10px;
        transition: all 0.25s ease;
        cursor: pointer;
        position: relative;
    }
    
    .role-checkbox:hover {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }
    
    .role-checkbox:has(input:checked) {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.08);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.12);
    }
    
    .role-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #10b981;
        cursor: pointer;
        flex-shrink: 0;
        border-radius: 4px;
        transition: all 0.2s ease;
    }
    
    .role-checkbox input[type="checkbox"]:checked {
        transform: scale(1.05);
    }
    
    .role-checkbox .role-label {
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
    }
    
    .role-checkbox .role-label i {
        font-size: 0.7rem;
        color: var(--text-muted);
        width: 18px;
        text-align: center;
        transition: all 0.2s ease;
    }
    
    .role-checkbox:has(input:checked) .role-label i {
        color: #10b981;
    }
    
    /* Choir Note */
    .choir-note {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border: 1px solid #6ee7b7;
        border-radius: 10px;
        padding: 0.9rem 1.2rem;
        margin-top: 0.8rem;
        font-size: 0.78rem;
        color: #065f46;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    
    [data-theme="dark"] .choir-note {
        background: linear-gradient(135deg, #064e3b, #065f46);
        border-color: #059669;
        color: #6ee7b7;
    }
    
    .choir-note i {
        font-size: 1rem;
        color: #10b981;
        margin-top: 2px;
        flex-shrink: 0;
    }
    
    [data-theme="dark"] .choir-note i {
        color: #34d399;
    }
    
    .choir-note strong {
        color: #047857;
    }
    
    [data-theme="dark"] .choir-note strong {
        color: #34d399;
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 0.8rem;
        margin-top: 1.8rem;
        padding-top: 1.5rem;
        border-top: 1.5px solid var(--border-color);
    }
    
    .btn-cancel {
        background: var(--bg-tertiary);
        color: var(--text-secondary);
        border: 1.5px solid var(--border-color);
        padding: 0.55rem 1.8rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        justify-content: center;
    }
    
    .btn-cancel:hover {
        background: var(--hover-bg);
        color: var(--text-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #059669, #10b981, #34d399);
        color: white;
        border: none;
        padding: 0.55rem 2.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex: 2;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .btn-save::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: all 0.5s ease;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.35);
        color: white;
    }
    
    .btn-save:hover::after {
        left: 100%;
    }
    
    .btn-save:active {
        transform: translateY(0);
    }
    
    /* Input with icon wrapper */
    .input-icon-wrapper {
        position: relative;
    }
    
    .input-icon-wrapper .form-control {
        padding-left: 2.5rem;
    }
    
    .input-icon-wrapper .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.8rem;
        pointer-events: none;
        transition: all 0.2s ease;
    }
    
    .input-icon-wrapper .form-control:focus ~ .input-icon,
    .input-icon-wrapper .form-control:focus + .input-icon {
        color: #10b981;
    }
    
    /* Error messages */
    .invalid-feedback {
        font-size: 0.7rem;
        color: #ef4444;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .invalid-feedback i {
        font-size: 0.6rem;
    }
    
    /* Header icon */
    .header-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.12), rgba(5, 150, 105, 0.08));
        border-radius: 10px;
        color: #10b981;
        font-size: 1.1rem;
    }
    
    .h2 .header-icon {
        margin-right: 10px;
    }
    
    /* Validation Styles */
    .form-control.is-valid {
        border-color: #10b981;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .form-control.is-invalid {
        border-color: #ef4444;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef4444' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .role-checkbox-group {
            grid-template-columns: 1fr 1fr;
        }
        .form-card {
            padding: 1.2rem;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn-cancel,
        .btn-save {
            flex: 1;
            width: 100%;
        }
        .h2 {
            font-size: 1.1rem !important;
        }
    }
    
    @media (max-width: 480px) {
        .role-checkbox-group {
            grid-template-columns: 1fr;
        }
        .form-card {
            padding: 1rem;
            border-radius: 12px;
        }
        .form-card .form-label {
            font-size: 0.6rem;
        }
        .role-checkbox {
            padding: 0.4rem 0.7rem;
        }
        .role-checkbox .role-label {
            font-size: 0.7rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h1 class="h2 mb-1 fw-bold" style="color: var(--text-primary); font-size: 1.3rem;">
                <span class="header-icon"><i class="fas fa-user-plus"></i></span>
                Add New Member
            </h1>
            <p class="mb-0" style="color: var(--text-muted); font-size: 0.8rem;">
                <i class="fas fa-leaf" style="color: #10b981; font-size: 0.6rem;"></i>
                Add a new member to your church family
            </p>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            
            <div class="row g-4">
                {{-- First Name --}}
                <div class="col-md-6">
                    <label for="first_name" class="form-label">
                        <i class="fas fa-user"></i> First Name <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" placeholder="Enter first name" 
                               value="{{ old('first_name') }}" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('first_name')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Last Name --}}
                <div class="col-md-6">
                    <label for="last_name" class="form-label">
                        <i class="fas fa-user"></i> Last Name <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" name="last_name" placeholder="Enter last name" 
                               value="{{ old('last_name') }}" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('last_name')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Birthday --}}
                <div class="col-md-6">
                    <label for="birthday" class="form-label">
                        <i class="fas fa-birthday-cake"></i> Birthday
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="date" class="form-control @error('birthday') is-invalid @enderror" 
                               id="birthday" name="birthday" value="{{ old('birthday') }}">
                        <i class="fas fa-calendar-alt input-icon"></i>
                    </div>
                    @error('birthday')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Address --}}
                <div class="col-md-6">
                    <label for="address" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Address
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                               id="address" name="address" placeholder="Complete address of the member" 
                               value="{{ old('address') }}">
                        <i class="fas fa-home input-icon"></i>
                    </div>
                    @error('address')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Phone (Optional) --}}
                <div class="col-md-6">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone"></i> Phone <span style="color: var(--text-muted); font-weight: 400; text-transform: lowercase;">(Optional)</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" placeholder="Enter phone number (optional)" 
                               value="{{ old('phone') }}">
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                    @error('phone')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Roles / Ministries --}}
                <div class="col-12">
                    <label class="form-label">
                        <i class="fas fa-tags"></i> Roles / Ministries
                    </label>
                    <p class="form-text">
                        <i class="fas fa-check-circle"></i> Select one or more roles for this member
                    </p>
                    
                    <div class="role-checkbox-group">
                        @if(isset($roles) && $roles->count() > 0)
                            @foreach($roles as $role)
                                <label class="role-checkbox">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                           {{ is_array(old('roles')) && in_array($role->id, old('roles')) ? 'checked' : '' }}>
                                    <span class="role-label">
                                        <i class="fas {{ $role->icon ?? 'fa-tag' }}"></i>
                                        {{ $role->name }}
                                    </span>
                                </label>
                            @endforeach
                        @else
                            <p class="text-muted" style="grid-column: span 2; text-align: center; padding: 0.5rem;">
                                <i class="fas fa-info-circle" style="color: #10b981;"></i>
                                No roles available. Please contact administrator.
                            </p>
                        @endif
                    </div>
                    
                    {{-- Choir Note --}}
                    <div class="choir-note">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Note:</strong> Members with <strong>Training Pastor, Palagkanta, Instruments, Singer, Musician, Guitarist, Pianist, Drummer, Bassist, or Choir</strong> roles will automatically be added to the <strong>Choir Ministry</strong>.
                        </div>
                    </div>
                    
                    @error('roles')
                        <div class="invalid-feedback d-block"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            {{-- Form Actions --}}
            <div class="form-actions">
                <a href="{{ route('members.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection