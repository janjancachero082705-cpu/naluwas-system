@extends('layouts.app')

@section('header', 'Profile Settings')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-circle"></i> Profile Settings</h5>
                </div>
                <div class="card-body">
                    <!-- Profile Picture Section -->
                    <div class="text-center mb-4">
                        <div class="profile-picture-wrapper">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ auth()->user()->profile_picture_url }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="profile-picture-preview">
                            @else
                                <div class="profile-picture-placeholder" 
                                     style="background: {{ auth()->user()->avatar_color }};">
                                    {{ auth()->user()->initials }}
                                </div>
                            @endif
                            <div class="upload-overlay" onclick="document.getElementById('profilePictureInput').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                        </div>
                        
                        <input type="file" id="profilePictureInput" accept="image/*" style="display:none;">
                        
                        @if(auth()->user()->profile_picture)
                            <button class="btn btn-danger btn-sm mt-3" id="removeProfilePicture">
                                <i class="fas fa-trash"></i> Remove Photo
                            </button>
                        @endif
                        
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Click the camera icon to upload. Max 2MB (JPG, PNG, GIF, SVG)
                            </small>
                        </div>
                    </div>

                    <hr>

                    <!-- Profile Form -->
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('POST')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                    </form>

                    <hr>

                    <!-- Change Password Section -->
                    <h6 class="mt-4">Change Password</h6>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('POST')
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile picture upload
    const fileInput = document.getElementById('profilePictureInput');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File is too large! Maximum size is 2MB.');
                this.value = '';
                return;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
            if (!allowedTypes.includes(file.type)) {
                alert('Invalid file type! Please upload JPG, PNG, GIF, or SVG.');
                this.value = '';
                return;
            }

            const formData = new FormData();
            formData.append('profile_picture', file);
            formData.append('_token', csrfToken);

            // Show loading state
            const overlay = document.querySelector('.upload-overlay');
            const originalHtml = overlay.innerHTML;
            overlay.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('{{ route("profile.picture.upload") }}', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Reload page to show new picture
                    location.reload();
                } else {
                    alert(data.message || 'Upload failed');
                    overlay.innerHTML = originalHtml;
                }
            })
            .catch(() => {
                alert('Something went wrong!');
                overlay.innerHTML = originalHtml;
            });

            this.value = '';
        });
    }

    // Remove profile picture
    const removeBtn = document.getElementById('removeProfilePicture');
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to remove your profile picture?')) return;

            fetch('{{ route("profile.picture.remove") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Failed to remove');
                }
            })
            .catch(() => {
                alert('Something went wrong!');
            });
        });
    }
});
</script>
@endpush
@endsection