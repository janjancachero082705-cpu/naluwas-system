@extends('layouts.auth3')
@section('title', 'Sign in')

@section('verse')"Come to me, all who are weary, and I will give you rest."<small>Matthew 11:28</small>@endsection

@section('content')
<div class="au-head">
    <h1>Welcome back</h1>
    <p>Sign in to continue. Your church family is waiting.</p>
</div>

@if(session('error') || $errors->any())
    <div class="au-alert" role="alert"><i class="fas fa-circle-exclamation"></i><span>{{ session('error') ?? $errors->first() }}</span></div>
@endif
@if(session('status'))
    <div class="au-alert ok" role="status"><i class="fas fa-circle-check"></i><span>{{ session('status') }}</span></div>
@endif

<form method="POST" action="{{ route('login') }}" id="loginForm">
    @csrf
    <div class="fld">
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " autocomplete="username" required autofocus>
        <label for="email">Email</label>
    </div>

    <div class="fld" style="margin-bottom:6px">
        <input type="password" name="password" id="password" placeholder=" " autocomplete="current-password" required>
        <label for="password">Password</label>
        <button type="button" class="eye" data-eye aria-label="Show password"><i class="fas fa-eye"></i></button>
    </div>
    <div class="hint" id="capsHint" style="display:none;color:var(--danger);margin-bottom:10px"><i class="fas fa-arrow-up"></i> Caps Lock is on</div>

    <div class="au-row" style="margin-top:14px">
        <label class="au-check"><input type="checkbox" name="remember"> Keep me signed in</label>
        @if (Route::has('password.request'))
            <a class="au-link" href="{{ route('password.request') }}">Forgot password?</a>
        @endif
    </div>

    <button type="submit" class="au-btn" id="loginBtn"><span>Sign in</span></button>

    @if (Route::has('register'))
        <p class="au-alt">New here? <a class="au-link" href="{{ route('register') }}" data-switch>Create new account</a></p>
    @endif
</form>
@endsection

@push('scripts')
<script>
    var pw = document.getElementById('password');
    pw.addEventListener('keyup', function (e) {
        document.getElementById('capsHint').style.display = (e.getModifierState && e.getModifierState('CapsLock')) ? 'block' : 'none';
    });
    document.getElementById('loginForm').addEventListener('submit', function () {
        var b = document.getElementById('loginBtn');
        b.disabled = true;
        b.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Signing in...</span>';
    });
</script>
@endpush