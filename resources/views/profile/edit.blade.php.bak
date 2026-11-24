@extends('layouts.app')

@section('title', 'Profile')
@section('header', 'Profile')
@section('subheader', 'Manage your photo, details and password')

@section('content')
@php
    $u = Auth::user();
    $imagePath = $u->profile_picture ? parse_url(asset('storage/' . $u->profile_picture), PHP_URL_PATH) : null;
    $initial = strtoupper(substr($u->name, 0, 1));
@endphp

<div class="pf-wrap">

    @if(session('success'))
        <div class="pf-alert ok"><i class="fas fa-circle-check"></i><span>{{ session('success') }}</span></div>
    @endif
    @if($errors->any())
        <div class="pf-alert err">
            <i class="fas fa-circle-exclamation"></i>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- ===== HERO ===== --}}
    <section class="pf-hero">
        <div class="pf-cover"></div>
        <div class="pf-head">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                @csrf
                @method('PUT')
                <div class="pf-avatar" id="avatarPreview">
                    <div class="pf-av-inner" id="avatarInner">
                        @if($imagePath)
                            <img src="{{ $imagePath }}" alt="Profile photo" onerror="this.remove(); document.getElementById('avatarInner').textContent='{{ $initial }}';">
                        @else
                            {{ $initial }}
                        @endif
                    </div>
                    <label for="profile_picture" class="pf-cam" title="Change photo"><i class="fas fa-camera"></i></label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg, image/jpg" hidden onchange="submitAvatarForm(event)">
                </div>
            </form>

            <div class="pf-id">
                <h2>{{ $u->name }}</h2>
                <p>{{ $u->email }}</p>
                <p class="pf-hint">JPG or PNG, up to 2 MB. Your photo saves as soon as you pick it.</p>
            </div>

            <div class="pf-chips">
                <span class="pf-chip"><i class="fas fa-church"></i> {{ $u->church->name ?? 'No congregation set' }}</span>
                @if($u->created_at)
                    <span class="pf-chip"><i class="fas fa-calendar-check"></i> Joined {{ $u->created_at->format('M Y') }}</span>
                @endif
            </div>
        </div>
    </section>

    {{-- ===== FORMS ===== --}}
    <div class="pf-grid">

        <section class="pf-card">
            <div class="pf-card-head">
                <span class="pf-card-ico"><i class="fas fa-id-card"></i></span>
                <div><h3>User details</h3><p>Shown across your church dashboard</p></div>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="pf-field">
                    <label for="name">Full name</label>
                    <div class="pf-input"><i class="fas fa-user lead"></i>
                        <input type="text" id="name" name="name" value="{{ old('name', $u->name) }}" required autocomplete="name">
                    </div>
                </div>
                <div class="pf-field">
                    <label for="email">Email address</label>
                    <div class="pf-input"><i class="fas fa-envelope lead"></i>
                        <input type="email" id="email" name="email" value="{{ old('email', $u->email) }}" required autocomplete="username">
                    </div>
                </div>
                <div class="pf-field">
                    <label for="church_name">Church / congregation</label>
                    <div class="pf-input"><i class="fas fa-church lead"></i>
                        <input type="text" id="church_name" name="church_name" value="{{ old('church_name', $u->church->name ?? '') }}" placeholder="e.g. TINC - Manila">
                    </div>
                </div>
                <button type="submit" class="pf-btn"><i class="fas fa-floppy-disk"></i> Save changes</button>
            </form>
        </section>

        <section class="pf-card pf-danger">
            <div class="pf-card-head">
                <span class="pf-card-ico rose"><i class="fas fa-key"></i></span>
                <div><h3>Change password</h3><p>Use at least 8 characters</p></div>
            </div>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="pf-field">
                    <label for="current_password">Current password</label>
                    <div class="pf-input"><i class="fas fa-lock lead"></i>
                        <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                        <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="pf-field">
                    <label for="new_password">New password</label>
                    <div class="pf-input"><i class="fas fa-lock lead"></i>
                        <input type="password" id="new_password" name="password" required minlength="8" autocomplete="new-password">
                        <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="meter" id="pwMeter"><span></span><span></span><span></span><span></span></div>
                    <div class="meter-text" id="pwText"></div>
                </div>
                <div class="pf-field">
                    <label for="confirm_password">Confirm new password</label>
                    <div class="pf-input"><i class="fas fa-lock lead"></i>
                        <input type="password" id="confirm_password" name="password_confirmation" required minlength="8" autocomplete="new-password">
                        <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="meter-text" id="pwMatch"></div>
                </div>
                <button type="submit" class="pf-btn rose"><i class="fas fa-key"></i> Update password</button>
            </form>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function submitAvatarForm(event) {
        var f = event.target.files && event.target.files[0];
        if (!f) return;
        if (f.size > 2 * 1024 * 1024) { alert('Please choose an image under 2 MB.'); event.target.value = ''; return; }
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('avatarInner').innerHTML = '<img src="' + e.target.result + '" alt="">';
        };
        reader.readAsDataURL(f);
        document.getElementById('avatarForm').submit();
    }

    // show / hide password
    document.querySelectorAll('[data-eye]').forEach(function (b) {
        b.addEventListener('click', function () {
            var input = b.parentElement.querySelector('input');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            b.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

    // strength meter + match check
    (function () {
        var pw = document.getElementById('new_password'),
            cf = document.getElementById('confirm_password'),
            bars = document.querySelectorAll('#pwMeter span'),
            txt = document.getElementById('pwText'),
            match = document.getElementById('pwMatch');
        var labels = ['Too short', 'Weak', 'Fair', 'Good', 'Strong'],
            colors = ['#f43f5e', '#f43f5e', '#F5B544', '#84cc16', '#16A34A'];
        function score(v) {
            var s = 0;
            if (v.length >= 8) s++;
            if (/[a-z]/.test(v) && /[A-Z]/.test(v)) s++;
            if (/\d/.test(v)) s++;
            if (/[^A-Za-z0-9]/.test(v) || v.length >= 14) s++;
            return v.length ? Math.max(s, v.length < 8 ? 0 : 1) : -1;
        }
        function paint() {
            var s = score(pw.value);
            bars.forEach(function (b, i) { b.style.background = (s >= 0 && i < Math.max(s, 1)) ? colors[s] : ''; });
            txt.textContent = s < 0 ? '' : labels[s];
            txt.style.color = s < 0 ? '' : colors[s];
            if (cf.value) {
                var ok = cf.value === pw.value;
                match.textContent = ok ? 'Passwords match' : 'Passwords do not match yet';
                match.style.color = ok ? '#16A34A' : '#f43f5e';
            } else { match.textContent = ''; }
        }
        pw.addEventListener('input', paint);
        cf.addEventListener('input', paint);
    })();
</script>
@endpush
