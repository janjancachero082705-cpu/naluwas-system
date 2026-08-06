@extends('layouts.app')

@section('header', 'Edit Member')

@section('content')
<style>
    /* ============================================
       PREMIUM EDIT FORM DESIGN
    ============================================ */
    
    /* Import Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
    
    .edit-hero {
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        border-radius: 24px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(79, 70, 229, 0.3);
    }
    
    .edit-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        animation: heroPulse 6s ease-in-out infinite;
    }
    
    .edit-hero::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 40%;
        height: 180%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: heroPulse 8s ease-in-out infinite reverse;
    }
    
    @keyframes heroPulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 1; }
    }
    
    .edit-hero .hero-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .edit-hero .hero-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .edit-hero .hero-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        border: 3px solid rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        font-weight: 800;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    }
    
    .edit-hero .hero-text h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: white;
        margin: 0;
        font-family: 'Inter', sans-serif;
        letter-spacing: -0.5px;
    }
    
    .edit-hero .hero-text .hero-sub {
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
        margin: 4px 0 0 0;
    }
    
    .edit-hero .hero-text .hero-sub i {
        margin-right: 6px;
    }
    
    .edit-hero .hero-actions {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }
    
    .btn-hero-edit {
        padding: 0.5rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    
    .btn-hero-edit-white {
        background: white;
        color: #4F46E5;
    }
    
    .btn-hero-edit-white:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        color: #4F46E5;
        text-decoration: none;
    }
    
    .btn-hero-edit-ghost {
        background: rgba(255,255,255,0.15);
        color: white;
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .btn-hero-edit-ghost:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }
    
    .edit-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .edit-card:hover {
        box-shadow: 0 24px 80px rgba(0,0,0,0.12);
    }
    
    .edit-card-header {
        padding: 1.2rem 1.8rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-tertiary);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.8rem;
    }
    
    .edit-card-header h5 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-primary);
        font-family: 'Inter', sans-serif;
    }
    
    .edit-card-header h5 i {
        color: #4F46E5;
        margin-right: 10px;
    }
    
    .edit-card-header .member-id-badge {
        font-size: 0.7rem;
        color: var(--text-muted);
        background: var(--bg-tertiary);
        padding: 4px 14px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        font-weight: 600;
    }
    
    .edit-card-body {
        padding: 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
        display: block;
        font-family: 'Inter', sans-serif;
    }
    
    .form-label .required {
        color: #EF4444;
        margin-left: 3px;
    }
    
    .form-label i {
        margin-right: 6px;
        opacity: 0.6;
    }
    
    .form-control {
        background: var(--bg-tertiary);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.7rem 1rem;
        color: var(--text-primary);
        font-size: 0.85rem;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        width: 100%;
    }
    
    .form-control:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.08);
        background: var(--card-bg);
        outline: none;
    }
    
    .form-control.is-invalid {
        border-color: #EF4444;
    }
    
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.08);
    }
    
    .form-control::placeholder {
        color: var(--text-muted);
        opacity: 0.5;
    }
    
    .invalid-feedback {
        color: #EF4444;
        font-size: 0.75rem;
        margin-top: 0.3rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .invalid-feedback i {
        font-size: 0.7rem;
    }
    
    select.form-control[multiple] {
        min-height: 120px;
        padding: 0.4rem;
    }
    
    select.form-control[multiple] option {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        margin-bottom: 2px;
    }
    
    select.form-control[multiple] option:checked {
        background: #4F46E5 linear-gradient(0deg, #4F46E5 0%, #4F46E5 100%);
        color: white;
    }
    
    select.form-control[multiple] option:hover {
        background: var(--bg-tertiary);
    }
    
    .form-text {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-top: 0.3rem;
        opacity: 0.7;
    }
    
    .form-text i {
        margin-right: 4px;
    }
    
    .choir-section {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.04), rgba(79, 70, 229, 0.04));
        border-radius: 16px;
        padding: 1.5rem;
        border: 2px solid rgba(139, 92, 246, 0.08);
        margin-top: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .choir-section:hover {
        border-color: rgba(139, 92, 246, 0.15);
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.05);
    }
    
    .choir-section .choir-title {
        font-size: 0.8rem;
        font-weight: 700;
        color: #8B5CF6;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Inter', sans-serif;
    }
    
    .choir-section .choir-title i {
        font-size: 1rem;
    }
    
    .choir-section .form-label {
        color: #8B5CF6;
    }
    
    .btn-back-edit {
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        border: 2px solid var(--border-color);
        background: transparent;
        color: var(--text-muted);
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }
    
    .btn-back-edit:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateX(-3px);
        border-color: var(--text-primary);
    }
    
    .btn-update-edit {
        padding: 0.7rem 2.5rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        border: none;
        background: linear-gradient(135deg, #4F46E5, #7C3AED);
        color: white;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(79, 70, 229, 0.25);
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.3px;
    }
    
    .btn-update-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 32px rgba(79, 70, 229, 0.35);
        color: white;
    }
    
    .btn-update-edit:active {
        transform: scale(0.97);
    }
    
    .btn-update-edit i {
        font-size: 0.9rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-color);
    }
    
    @media (max-width: 768px) {
        .edit-hero {
            padding: 1.5rem;
        }
        
        .edit-hero .hero-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .edit-hero .hero-actions {
            width: 100%;
        }
        
        .edit-hero .hero-left {
            width: 100%;
        }
        
        .edit-hero .hero-avatar {
            width: 55px;
            height: 55px;
            font-size: 1.4rem;
        }
        
        .edit-hero .hero-text h1 {
            font-size: 1.3rem;
        }
        
        .edit-card-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .edit-card-body {
            padding: 1.2rem;
        }
        
        .choir-section {
            padding: 1rem;
        }
        
        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }
        
        .btn-update-edit {
            justify-content: center;
            padding: 0.7rem 1.5rem;
        }
        
        .btn-back-edit {
            justify-content: center;
        }
    }
    
    @media (max-width: 480px) {
        .edit-hero .hero-avatar {
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }
        
        .edit-hero .hero-text h1 {
            font-size: 1.1rem;
        }
        
        .edit-card-body {
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid px-0">
    <div class="edit-hero">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-avatar">
                    {{ strtoupper(substr($member->first_name ?? 'M', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'M', 0, 1)) }}
                </div>
                <div class="hero-text">
                    <h1>Edit Member</h1>
                    <p class="hero-sub">
                        <i class="fas fa-user"></i>
                        {{ $member->first_name ?? '' }} {{ $member->last_name ?? '' }}
                        <span style="opacity: 0.5; margin: 0 6px;">·</span>
                        <i class="fas fa-id-card"></i>
                        ID: #{{ str_pad($member->id ?? 0, 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('members.show', $member->id) }}" class="btn-hero-edit btn-hero-edit-ghost">
                    <i class="fas fa-eye"></i> View Profile
                </a>
                <a href="{{ route('members.index') }}" class="btn-hero-edit btn-hero-edit-white">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="edit-card">
                <div class="edit-card-header">
                    <h5>
                        <i class="fas fa-user-edit"></i> Edit Member Information
                    </h5>
                    <span class="member-id-badge">
                        <i class="fas fa-clock"></i> Last updated: {{ $member->updated_at ? \Carbon\Carbon::parse($member->updated_at)->diffForHumans() : 'Never' }}
                    </span>
                </div>
                <div class="edit-card-body">
                    <form action="{{ route('members.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3" style="font-family: 'Inter', sans-serif;">
                                    <i class="fas fa-user-circle me-2"></i> Personal Information
                                </h6>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i> First Name <span class="required">*</span>
                                    </label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                           value="{{ old('first_name', $member->first_name) }}" placeholder="Enter first name" required>
                                    @error('first_name')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user"></i> Last Name <span class="required">*</span>
                                    </label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                                           value="{{ old('last_name', $member->last_name) }}" placeholder="Enter last name" required>
                                    @error('last_name')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-birthday-cake"></i> Birthday
                                    </label>
                                    <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror" 
                                           value="{{ old('birthday', $member->birthday ? \Carbon\Carbon::parse($member->birthday)->format('Y-m-d') : '') }}">
                                    @error('birthday')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- ============================================
                                 GENDER - FIXED
                            ============================================ -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars"></i> Gender
                                    </label>
                                    <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>👨 Male</option>
                                        <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>👩 Female</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                    <!-- Debug: Show current database value -->
                                    <div style="font-size: 0.7rem; color: #EF4444; margin-top: 4px; background: rgba(239, 68, 68, 0.08); padding: 4px 10px; border-radius: 6px;">
                                        <i class="fas fa-database"></i> Current value in database: <strong>{{ $member->gender ?? 'null' }}</strong>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-phone"></i> Phone Number
                                    </label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $member->phone) }}" placeholder="Enter phone number">
                                    @error('phone')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-envelope"></i> Email Address
                                    </label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $member->email) }}" placeholder="Enter email address">
                                    @error('email')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-map-marker-alt"></i> Address
                                    </label>
                                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                           value="{{ old('address', $member->address) }}" placeholder="Enter address">
                                    @error('address')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold text-primary mb-3" style="font-family: 'Inter', sans-serif;">
                                    <i class="fas fa-tags me-2"></i> Roles & Responsibilities
                                </h6>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-shield-alt"></i> Assign Roles
                                    </label>
                                    <select name="roles[]" class="form-control @error('roles') is-invalid @enderror" multiple>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ in_array($role->id, $memberRoles ?? []) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle"></i> Hold <strong>Ctrl</strong> (Windows) or <strong>Cmd</strong> (Mac) to select multiple roles
                                    </div>
                                    @error('roles')
                                        <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold text-purple mb-3" style="font-family: 'Inter', sans-serif; color: #8B5CF6;">
                                    <i class="fas fa-music me-2"></i> Choir Information
                                </h6>
                            </div>
                            
                            <div class="col-12">
                                <div class="choir-section">
                                    <div class="choir-title">
                                        <i class="fas fa-users"></i> Choir Assignment
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-layer-group"></i> Choir Group
                                                </label>
                                                <select name="choir_group_id" class="form-control @error('choir_group_id') is-invalid @enderror">
                                                    <option value="">No Choir Group</option>
                                                    @foreach($choirGroups ?? [] as $group)
                                                        <option value="{{ $group->id }}" {{ old('choir_group_id', $member->choir_group_id) == $group->id ? 'selected' : '' }}>
                                                            {{ $group->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('choir_group_id')
                                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-microphone-alt"></i> Choir Role
                                                </label>
                                                <select name="choir_role" class="form-control @error('choir_role') is-invalid @enderror">
                                                    <option value="">No Choir Role</option>
                                                    <option value="Singer" {{ old('choir_role', $member->choir_role) == 'Singer' ? 'selected' : '' }}>🎤 Singer</option>
                                                    <option value="Guitarist" {{ old('choir_role', $member->choir_role) == 'Guitarist' ? 'selected' : '' }}>🎸 Guitarist</option>
                                                    <option value="Bassist" {{ old('choir_role', $member->choir_role) == 'Bassist' ? 'selected' : '' }}>🎸 Bassist</option>
                                                    <option value="Drummer" {{ old('choir_role', $member->choir_role) == 'Drummer' ? 'selected' : '' }}>🥁 Drummer</option>
                                                </select>
                                                @error('choir_role')
                                                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('members.index') }}" class="btn-back-edit">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('members.show', $member->id) }}" class="btn-back-edit" style="border-color: #4F46E5; color: #4F46E5;">
                                    <i class="fas fa-eye"></i> View Profile
                                </a>
                                <button type="submit" class="btn-update-edit">
                                    <i class="fas fa-save"></i> Update Member
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const invalidFields = document.querySelectorAll('.is-invalid');
        if (invalidFields.length > 0) {
            invalidFields[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            invalidFields[0].focus();
        }
        
        let formChanged = false;
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                formChanged = true;
            });
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
                return e.returnValue;
            }
        });
        
        form.addEventListener('submit', function() {
            formChanged = false;
        });
        
        const card = document.querySelector('.edit-card');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>
@endsection