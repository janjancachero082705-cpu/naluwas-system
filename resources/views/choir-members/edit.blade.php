@extends('layouts.app')

@section('header', 'Edit Choir Member')

@section('content')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        overflow: hidden;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .card-header-custom::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .card-header-custom h4 {
        margin: 0;
        font-size: 1.2rem;
        font-weight: 700;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-header-custom p {
        margin: 0.5rem 0 0 0;
        font-size: 0.8rem;
        opacity: 0.9;
        color: white;
    }
    
    .card-body-custom {
        padding: 1.5rem;
    }
    
    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }
    
    .form-group-full {
        grid-column: span 2;
    }
    
    .form-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .form-label i {
        font-size: 0.7rem;
        width: 16px;
    }
    
    .required {
        color: #ef4444;
        margin-left: 2px;
    }
    
    .form-control, .form-select, textarea {
        width: 100%;
        padding: 0.7rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background: var(--input-bg);
        color: var(--text-primary);
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus, textarea:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
    }
    
    textarea {
        resize: vertical;
        min-height: 80px;
    }
    
    /* Voice Part Selector */
    .voice-selector {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .voice-option {
        flex: 1;
        min-width: 80px;
        padding: 0.7rem 0.5rem;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: var(--bg-tertiary);
        border: 2px solid var(--border-color);
        color: var(--text-secondary);
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .voice-option i {
        display: block;
        font-size: 1.2rem;
        margin-bottom: 0.3rem;
    }
    
    .voice-option:hover {
        border-color: #f59e0b;
        background: rgba(245, 158, 11, 0.05);
    }
    
    .voice-option.selected {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        border-color: #f59e0b;
        color: white;
    }
    
    /* Checkbox */
    .checkbox-wrapper {
        background: var(--bg-tertiary);
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid var(--border-color);
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }
    
    .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #f59e0b;
    }
    
    .form-check-label {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .form-check-label i {
        color: #f59e0b;
        margin-right: 5px;
    }
    
    /* Button Group */
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }
    
    .btn-cancel {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-secondary);
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex: 1;
    }
    
    .btn-cancel:hover {
        background: var(--hover-bg);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .form-group-full {
            grid-column: span 1;
        }
        .voice-selector {
            flex-wrap: wrap;
        }
        .voice-option {
            min-width: calc(50% - 0.5rem);
        }
        .button-group {
            flex-direction: column;
        }
        .card-body-custom {
            padding: 1rem;
        }
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-edit"></i> Edit Choir Member
            </h4>
            <p>Update choir member information</p>
        </div>
        
        <div class="card-body-custom">
            <form action="{{ route('choir-members.update', $choir_member->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <!-- First Name -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i> First Name <span class="required">*</span>
                        </label>
                        <input type="text" name="first_name" class="form-control" required 
                               value="{{ $choir_member->first_name }}" placeholder="Enter first name">
                    </div>
                    
                    <!-- Last Name -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Last Name <span class="required">*</span>
                        </label>
                        <input type="text" name="last_name" class="form-control" required 
                               value="{{ $choir_member->last_name }}" placeholder="Enter last name">
                    </div>
                    
                    <!-- Birthday -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-birthday-cake"></i> Birthday
                        </label>
                        <input type="date" name="birthday" class="form-control" 
                               value="{{ $choir_member->birthday }}">
                    </div>
                    
                    <!-- Voice Part -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-microphone-alt"></i> Voice Part
                        </label>
                        <div class="voice-selector">
                            <div class="voice-option {{ $choir_member->voice_part == 'Soprano' ? 'selected' : '' }}" 
                                 data-voice="Soprano" onclick="selectVoice(this, 'Soprano')">
                                <i class="fas fa-microphone-alt"></i> Soprano
                            </div>
                            <div class="voice-option {{ $choir_member->voice_part == 'Alto' ? 'selected' : '' }}" 
                                 data-voice="Alto" onclick="selectVoice(this, 'Alto')">
                                <i class="fas fa-microphone-alt"></i> Alto
                            </div>
                            <div class="voice-option {{ $choir_member->voice_part == 'Tenor' ? 'selected' : '' }}" 
                                 data-voice="Tenor" onclick="selectVoice(this, 'Tenor')">
                                <i class="fas fa-microphone-alt"></i> Tenor
                            </div>
                            <div class="voice-option {{ $choir_member->voice_part == 'Bass' ? 'selected' : '' }}" 
                                 data-voice="Bass" onclick="selectVoice(this, 'Bass')">
                                <i class="fas fa-microphone-alt"></i> Bass
                            </div>
                        </div>
                        <input type="hidden" name="voice_part" id="voicePart" value="{{ $choir_member->voice_part }}">
                    </div>
                    
                    <!-- Address - Full Width -->
                    <div class="form-group-full">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Address
                        </label>
                        <textarea name="address" rows="2" class="form-control" 
                                  placeholder="Complete address of the member">{{ $choir_member->address }}</textarea>
                    </div>
                    
                    <!-- Choir Status -->
                    <div class="form-group-full">
                        <div class="checkbox-wrapper">
                            <div class="form-check">
                                <input type="checkbox" name="is_choir" class="form-check-input" value="1" 
                                       {{ $choir_member->is_choir ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    <i class="fas fa-music"></i> Choir Member
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Button Group -->
                <div class="button-group">
                    <a href="{{ route('choir-members.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Update Choir Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Voice Selection
    function selectVoice(element, voice) {
        // Remove selected class from all voice options
        document.querySelectorAll('.voice-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        // Add selected class to clicked option
        element.classList.add('selected');
        // Set hidden input value
        document.getElementById('voicePart').value = voice;
    }
</script>
@endsection