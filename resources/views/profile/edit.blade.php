@extends('layouts.app')

@section('title', 'Profile')
@section('header', 'Profile')
@section('subheader', 'Manage your photo, details and password')

@section('content')
@php
    $u = Auth::user();
    $imagePath = $u->profile_picture ? parse_url(asset('storage/' . $u->profile_picture), PHP_URL_PATH) : null;
    $initial = strtoupper(substr($u->name, 0, 1));
    $err = fn ($k) => $errors->first($k) ?: $errors->updatePassword->first($k);
@endphp

<style>
    /* ===== PROFILE v2 (pf2) ===== */
    @keyframes pf2Up { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
    @keyframes pf2Spin { to { transform: rotate(360deg); } }

    .pf2 { max-width: 1100px; margin: 0 auto; }
    .pf2-alert { display: flex; gap: 10px; align-items: flex-start; padding: 12px 16px; border-radius: 14px; margin-bottom: 18px; font-size: .88rem; font-weight: 600; animation: pf2Up .4s ease both; }
    .pf2-alert.ok  { background: rgba(34,197,94,.12); color: #16A34A; }
    .pf2-alert.err { background: rgba(239,68,68,.10); color: #DC2626; }
    .pf2-alert ul { margin: 0; padding-left: 18px; }

    .pf2-grid { display: grid; grid-template-columns: 340px minmax(0, 1fr); gap: 24px; align-items: start; }
    .pf2-main { display: grid; gap: 24px; min-width: 0; }

    .pf2-card { background: var(--bg-card, #fff); border: 1px solid var(--border-color, #E3E8F5); border-radius: 20px; overflow: hidden; animation: pf2Up .55s cubic-bezier(.2,.7,.2,1) both; transition: box-shadow .25s ease, transform .25s ease; }
    .pf2-card:hover { box-shadow: 0 14px 34px rgba(12, 20, 69, .08); }
    .pf2-main .pf2-card:nth-child(1) { animation-delay: .12s; }
    .pf2-main .pf2-card:nth-child(2) { animation-delay: .2s; }

    .pf2-me { position: sticky; top: 90px; text-align: center; padding-bottom: 22px; }
    .pf2-cover { height: 110px; background: linear-gradient(135deg, #0BA5C0 0%, #3157D5 55%, #7C5CF0 100%); position: relative; overflow: hidden; }
    .pf2-cover::after { content: ""; position: absolute; inset: 0; background: radial-gradient(circle at 80% 20%, rgba(255,255,255,.35), transparent 45%); }

    .pf2-avatar { position: relative; width: 112px; height: 112px; margin: -56px auto 0; }
    .pf2-av-inner { width: 100%; height: 100%; border-radius: 50%; display: grid; place-items: center; overflow: hidden; font-size: 2.6rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, #0BA5C0, #3157D5); border: 5px solid var(--bg-card, #fff); box-shadow: 0 10px 26px rgba(12, 20, 69, .2); }
    .pf2-av-inner img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .pf2-cam { position: absolute; right: 2px; bottom: 4px; width: 36px; height: 36px; display: grid; place-items: center; border-radius: 50%; background: var(--primary-btn, #0BA5C0); color: #fff; border: 3px solid var(--bg-card, #fff); cursor: pointer; transition: transform .2s ease; }
    .pf2-cam:hover { transform: scale(1.12) rotate(-8deg); }

    .pf2-me h2 { font-size: 1.2rem; font-weight: 800; letter-spacing: -.3px; margin: 14px 16px 2px; color: var(--text-main); overflow-wrap: anywhere; }
    .pf2-me .mail { font-size: .84rem; color: var(--text-muted); margin: 0 16px; overflow-wrap: anywhere; }
    .pf2-chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin: 16px 16px 0; }
    .pf2-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: .74rem; font-weight: 700; background: var(--primary-soft, rgba(18,196,222,.12)); color: var(--text-main); }
    .pf2-chip i { color: var(--primary-btn, #0BA5C0); }
    .pf2-tip { margin: 18px 18px 0; padding-top: 16px; border-top: 1px dashed var(--border-color, #E3E8F5); font-size: .76rem; color: var(--text-muted); line-height: 1.5; }

    .pf2-head { display: flex; align-items: center; gap: 14px; padding: 20px 24px; border-bottom: 1px solid var(--border-color, #E3E8F5); }
    .pf2-ico { width: 44px; height: 44px; flex: 0 0 auto; display: grid; place-items: center; border-radius: 14px; font-size: 1.05rem; color: #fff; background: linear-gradient(135deg, #0BA5C0, #3157D5); box-shadow: 0 8px 18px rgba(11,165,192,.28); }
    .pf2-ico.rose { background: linear-gradient(135deg, #f43f5e, #ec4899); box-shadow: 0 8px 18px rgba(244,63,94,.28); }
    .pf2-head h3 { font-size: 1.02rem; font-weight: 800; margin: 0; color: var(--text-main); }
    .pf2-head p { font-size: .8rem; color: var(--text-muted); margin: 2px 0 0; }
    .pf2-body { padding: 24px; }
    .pf2-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .pf2-row .full { grid-column: 1 / -1; }

    .pf2-field { margin-bottom: 18px; }
    .pf2-field:last-of-type { margin-bottom: 0; }
    .pf2-field label { display: block; font-size: .7rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 7px; }
    .pf2-input { position: relative; display: flex; align-items: center; }
    .pf2-input .lead { position: absolute; left: 15px; font-size: .85rem; color: var(--text-muted); transition: color .15s ease; pointer-events: none; }
    .pf2-input input { width: 100%; height: 48px; padding: 0 44px 0 42px; border-radius: 14px; border: 1.5px solid var(--border-color, #E3E8F5); background: var(--bg-hover, #F1F4FB); color: var(--text-main); font: inherit; font-size: .92rem; font-weight: 500; transition: border-color .15s ease, box-shadow .15s ease, background .15s ease; }
    .pf2-input input::placeholder { color: var(--text-muted); opacity: .7; }
    .pf2-input input:focus { outline: 0; background: var(--bg-card, #fff); border-color: var(--primary-btn, #0BA5C0); box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary-btn, #0BA5C0) 18%, transparent); }
    .pf2-input:focus-within .lead { color: var(--primary-btn, #0BA5C0); }
    .pf2-field.bad .pf2-input input { border-color: #DC2626; }
    .pf2-input .eye { position: absolute; right: 8px; width: 34px; height: 34px; display: grid; place-items: center; border: 0; border-radius: 10px; background: transparent; color: var(--text-muted); cursor: pointer; transition: background .15s ease; }
    .pf2-input .eye:hover { background: var(--primary-soft, rgba(18,196,222,.12)); }
    .pf2-msg { font-size: .76rem; font-weight: 600; margin: 6px 2px 0; min-height: 0; }
    .pf2-msg.bad { color: #DC2626; }

    .pf2-meter { display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px; margin-top: 10px; }
    .pf2-meter span { height: 5px; border-radius: 3px; background: var(--border-color, #E3E8F5); transition: background .2s ease; }

    .pf2-foot { display: flex; align-items: center; justify-content: flex-end; gap: 14px; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border-color, #E3E8F5); }
    .pf2-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; height: 46px; padding: 0 22px; border: 0; border-radius: 14px; font: inherit; font-size: .9rem; font-weight: 700; color: #fff; cursor: pointer; background: linear-gradient(135deg, #0BA5C0, #3157D5); box-shadow: 0 10px 22px rgba(11,165,192,.28); transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease; }
    .pf2-btn:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(11,165,192,.34); }
    .pf2-btn:active { transform: scale(.98); }
    .pf2-btn.rose { background: linear-gradient(135deg, #f43f5e, #ec4899); box-shadow: 0 10px 22px rgba(244,63,94,.26); }
    .pf2-btn.busy { opacity: .75; pointer-events: none; }
    .pf2-btn.busy i { animation: pf2Spin .8s linear infinite; }

    @media (max-width: 991.98px) {
        .pf2-grid { grid-template-columns: 1fr; gap: 16px; }
        .pf2-me { position: static; }
        .pf2-main { gap: 16px; }
    }
    @media (max-width: 575.98px) {
        .pf2-card { border-radius: 16px; }
        .pf2-head { padding: 14px 16px; }
        .pf2-body { padding: 16px; }
        .pf2-row { grid-template-columns: 1fr; gap: 14px; }
        .pf2-input input { font-size: 16px; }
        .pf2-foot { justify-content: stretch; }
        .pf2-foot .pf2-btn { width: 100%; }
    }
    @media (prefers-reduced-motion: reduce) { .pf2 *, .pf2-card { animation: none !important; transition: none !important; } }
</style>

<div class="pf2">

    @if(session('success'))
        <div class="pf2-alert ok"><i class="fas fa-circle-check"></i><span>{{ session('success') }}</span></div>
    @endif
    @if(session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div class="pf2-alert ok"><i class="fas fa-circle-check"></i><span>Saved.</span></div>
    @endif
    @if($errors->any())
        <div class="pf2-alert err">
            <i class="fas fa-circle-exclamation"></i>
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="pf2-grid">

        <aside>
            <section class="pf2-card pf2-me">
                <div class="pf2-cover"></div>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    @method('PUT')
                    <div class="pf2-avatar">
                        <div class="pf2-av-inner" id="avatarInner">
                            @if($imagePath)
                                <img src="{{ $imagePath }}" alt="Profile photo" onerror="this.remove(); document.getElementById('avatarInner').textContent='{{ $initial }}';">
                            @else
                                {{ $initial }}
                            @endif
                        </div>
                        <label for="profile_picture" class="pf2-cam" title="Change photo"><i class="fas fa-camera"></i></label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg, image/jpg" hidden onchange="submitAvatarForm(event)">
                    </div>
                </form>

                <h2>{{ $u->name }}</h2>
                <p class="mail">{{ $u->email }}</p>

                <div class="pf2-chips">
                    <span class="pf2-chip"><i class="fas fa-church"></i> {{ $u->church->name ?? 'No congregation set' }}</span>
                    @if($u->created_at)
                        <span class="pf2-chip"><i class="fas fa-calendar-check"></i> Joined {{ $u->created_at->format('M Y') }}</span>
                    @endif
                </div>

                <p class="pf2-tip"><i class="fas fa-camera"></i> JPG or PNG, up to 2 MB. Your photo saves as soon as you pick it.</p>
            </section>
        </aside>

        <div class="pf2-main">

            <section class="pf2-card">
                <div class="pf2-head">
                    <span class="pf2-ico"><i class="fas fa-id-card"></i></span>
                    <div><h3>Profile Information</h3><p>Update your account's profile information and email address.</p></div>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" class="pf2-body" data-busy>
                    @csrf
                    @method('PUT')
                    <div class="pf2-row">
                        <div class="pf2-field {{ $errors->has('name') ? 'bad' : '' }}">
                            <label for="name">Full name</label>
                            <div class="pf2-input"><i class="fas fa-user lead"></i>
                                <input type="text" id="name" name="name" value="{{ old('name', $u->name) }}" required autocomplete="name">
                            </div>
                            @if($errors->has('name'))<p class="pf2-msg bad">{{ $errors->first('name') }}</p>@endif
                        </div>
                        <div class="pf2-field {{ $errors->has('email') ? 'bad' : '' }}">
                            <label for="email">Email address</label>
                            <div class="pf2-input"><i class="fas fa-envelope lead"></i>
                                <input type="email" id="email" name="email" value="{{ old('email', $u->email) }}" required autocomplete="username">
                            </div>
                            @if($errors->has('email'))<p class="pf2-msg bad">{{ $errors->first('email') }}</p>@endif
                        </div>
                        <div class="pf2-field full {{ $errors->has('church_name') ? 'bad' : '' }}">
                            <label for="church_name">Church / congregation</label>
                            <div class="pf2-input"><i class="fas fa-church lead"></i>
                                <input type="text" id="church_name" name="church_name" value="{{ old('church_name', $u->church->name ?? '') }}" placeholder="e.g. TINC - Manila">
                            </div>
                            @if($errors->has('church_name'))<p class="pf2-msg bad">{{ $errors->first('church_name') }}</p>@endif
                        </div>
                    </div>
                    <div class="pf2-foot">
                        <button type="submit" class="pf2-btn"><i class="fas fa-floppy-disk"></i> Save changes</button>
                    </div>
                </form>
            </section>

            <section class="pf2-card">
                <div class="pf2-head">
                    <span class="pf2-ico rose"><i class="fas fa-key"></i></span>
                    <div><h3>Update Password</h3><p>Use a long, random password to stay secure.</p></div>
                </div>
                <form action="{{ route('profile.password') }}" method="POST" class="pf2-body" data-busy>
                    @csrf
                    @method('PUT')

                    <div class="pf2-field full {{ $err('current_password') ? 'bad' : '' }}">
                        <label for="current_password">Current password</label>
                        <div class="pf2-input"><i class="fas fa-lock lead"></i>
                            <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                            <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                        </div>
                        @if($err('current_password'))<p class="pf2-msg bad">{{ $err('current_password') }}</p>@endif
                    </div>

                    <div class="pf2-row" style="margin-top:18px;">
                        <div class="pf2-field {{ $err('password') ? 'bad' : '' }}">
                            <label for="new_password">New password</label>
                            <div class="pf2-input"><i class="fas fa-lock lead"></i>
                                <input type="password" id="new_password" name="password" required minlength="8" autocomplete="new-password">
                                <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                            </div>
                            <div class="pf2-meter" id="pwMeter"><span></span><span></span><span></span><span></span></div>
                            <p class="pf2-msg" id="pwText">{{ $err('password') }}</p>
                        </div>
                        <div class="pf2-field">
                            <label for="confirm_password">Confirm new password</label>
                            <div class="pf2-input"><i class="fas fa-lock lead"></i>
                                <input type="password" id="confirm_password" name="password_confirmation" required minlength="8" autocomplete="new-password">
                                <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
                            </div>
                            <p class="pf2-msg" id="pwMatch"></p>
                        </div>
                    </div>

                    <div class="pf2-foot">
                        <button type="submit" class="pf2-btn rose"><i class="fas fa-key"></i> Update password</button>
                    </div>
                </form>
            </section>
        </div>
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

    document.querySelectorAll('form[data-busy]').forEach(function (f) {
        f.addEventListener('submit', function () {
            var b = f.querySelector('.pf2-btn');
            if (!b) return;
            b.classList.add('busy');
            var i = b.querySelector('i'); if (i) i.className = 'fas fa-spinner';
        });
    });

    document.querySelectorAll('[data-eye]').forEach(function (b) {
        b.addEventListener('click', function () {
            var input = b.parentElement.querySelector('input');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            b.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

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
            if (s >= 0) { txt.textContent = labels[s]; txt.style.color = colors[s]; }
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