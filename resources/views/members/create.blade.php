@extends('layouts.app')

@section('header')
    <span data-i18n="add_new_member">Add New Member</span>
@endsection

@section('content')
<style>
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
                <span data-i18n="add_new_member">Add New Member</span>
            </h1>
            <p class="mb-0" style="color: var(--text-muted); font-size: 0.8rem;">
                <i class="fas fa-leaf" style="color: #10b981; font-size: 0.6rem;"></i>
                <span data-i18n="add_member_desc">Add a new member to your church family</span>
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
                        <i class="fas fa-user"></i> <span data-i18n="first_name">First Name</span> <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" placeholder="{{ __('Enter first name') }}" 
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
                        <i class="fas fa-user"></i> <span data-i18n="last_name">Last Name</span> <span style="color: #ef4444;">*</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" name="last_name" placeholder="{{ __('Enter last name') }}" 
                               value="{{ old('last_name') }}" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('last_name')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- ============================================ --}}
                {{-- GENDER --}}
                {{-- ============================================ --}}
                <div class="col-md-6">
                    <label for="gender" class="form-label">
                        <i class="fas fa-venus-mars"></i> <span data-i18n="gender">Gender</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <select class="form-control @error('gender') is-invalid @enderror" 
                                id="gender" name="gender">
                            <option value=""><span data-i18n="select_gender">Select Gender</span></option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>👨 <span data-i18n="male">Male</span></option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>👩 <span data-i18n="female">Female</span></option>
                        </select>
                        <i class="fas fa-venus-mars input-icon"></i>
                    </div>
                    @error('gender')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div style="font-size: 0.7rem; color: #10B981; margin-top: 4px; padding: 4px 8px; background: rgba(16, 185, 129, 0.08); border-radius: 6px;">
                        <i class="fas fa-info-circle"></i> <span data-i18n="selected_label">Selected:</span> <strong id="genderDisplay"><span data-i18n="not_selected">Not selected</span></strong>
                    </div>
                </div>
                
                {{-- Birthday --}}
                <div class="col-md-6">
                    <label for="birthday" class="form-label">
                        <i class="fas fa-birthday-cake"></i> <span data-i18n="birthday">Birthday</span>
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
                
                {{-- Phone --}}
                <div class="col-md-6">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone"></i> <span data-i18n="phone">Phone</span> <span style="color: var(--text-muted); font-weight: 400; text-transform: lowercase;">(<span data-i18n="optional">Optional</span>)</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" placeholder="{{ __('Enter phone number (optional)') }}" 
                               value="{{ old('phone') }}">
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                    @error('phone')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> <span data-i18n="email">Email</span> <span style="color: var(--text-muted); font-weight: 400; text-transform: lowercase;">(<span data-i18n="optional">Optional</span>)</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" placeholder="{{ __('Enter email address (optional)') }}" 
                               value="{{ old('email') }}">
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Address --}}
                <div class="col-12">
                    <label for="address" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> <span data-i18n="address">Address</span>
                    </label>
                    <div class="input-icon-wrapper">
                        <input type="text" class="form-control @error('address') is-invalid @enderror" 
                               id="address" name="address" placeholder="{{ __('Complete address of the member') }}" 
                               value="{{ old('address') }}">
                        <i class="fas fa-home input-icon"></i>
                    </div>
                    @error('address')
                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Roles / Ministries --}}
                <div class="col-12">
                    <label class="form-label">
                        <i class="fas fa-tags"></i> <span data-i18n="roles_ministries">Roles / Ministries</span>
                    </label>
                    <p class="form-text">
                        <i class="fas fa-check-circle"></i> <span data-i18n="select_roles_hint">Select one or more roles for this member</span>
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
                                <span data-i18n="no_roles_available">No roles available. Please contact administrator.</span>
                            </p>
                        @endif
                    </div>
                    
                    <div class="choir-note">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <span data-i18n="choir_note_text">Note: Members with Training Pastor, Palagkanta, Instruments, Singer, Musician, Guitarist, Pianist, Drummer, Bassist, or Choir roles will automatically be added to the Choir Ministry .</span>
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
                    <i class="fas fa-times"></i> <span data-i18n="cancel">Cancel</span>
                </a>
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> <span data-i18n="save_member">Save Member</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Debug: Show selected gender value
    document.addEventListener('DOMContentLoaded', function() {
        const genderSelect = document.getElementById('gender');
        const genderDisplay = document.getElementById('genderDisplay');
        
        if (genderSelect && genderDisplay) {
            // Set initial value
            const initialValue = genderSelect.value;
            if (initialValue === 'male') {
                genderDisplay.textContent = window.t ? window.t('male'): 'Male ';
                genderDisplay.style.color = '#3B82F6';
            } else if (initialValue === 'female') {
                genderDisplay.textContent = window.t ? window.t('female'): 'Female ';
                genderDisplay.style.color = '#EC4899';
            } else {
                genderDisplay.textContent = window.t ? window.t('not_selected') : 'Not selected';
                genderDisplay.style.color = '#10B981';
            }
            
            genderSelect.addEventListener('change', function() {
                const value = this.value;
                if (value === 'male') {
                    genderDisplay.textContent = (window.t ? window.t('male') : 'Male');
                    genderDisplay.style.color = '#3B82F6';
                } else if (value === 'female') {
                    genderDisplay.textContent = (window.t ? window.t('female') : 'Female');
                    genderDisplay.style.color = '#EC4899';
                } else {
                    genderDisplay.textContent = window.t ? window.t('not_selected') : 'Not selected';
                    genderDisplay.style.color = '#10B981';
                }
            });
        }
    });
</script>
@endsection