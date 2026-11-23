@php
    $user = auth()->user();
    $image = $user && $user->profile_picture ? asset('storage/' . $user->profile_picture) : null;
    $name = $user ? $user->name : 'Admin';
    $initial = strtoupper(substr($name, 0, 1));
    
    // Kunin ang initial kung naay duha ka words (e.g. John Doe -> JD)
    $parts = explode(' ', $name);
    if (count($parts) > 1) {
        $initial = strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
    }
@endphp

@if($image)
    <img src="{{ $image }}" 
         alt="{{ $name }}" 
         class="{{ $imgClass ?? '' }}" 
         data-profile-image="{{ $key ?? 'default' }}"
         onerror="window.handleProfileImageError(this, '{{ $key ?? 'default' }}')">
    <div class="{{ $initialsClass ?? '' }}" 
         data-profile-initials="{{ $key ?? 'default' }}" 
         style="display: none; background: {{ $background ?? 'var(--ink-2)' }};">
        {{ $initial }}
    </div>
@else
    <div class="{{ $initialsClass ?? '' }}" 
         data-profile-initials="{{ $key ?? 'default' }}" 
         style="display: flex; background: {{ $background ?? 'var(--ink-2)' }};">
        {{ $initial }}
    </div>
@endif