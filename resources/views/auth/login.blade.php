<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in - {{ config('app.name', 'TINC Church System') }}</title>

    <script>
        (function () { try { if (localStorage.getItem('theme') === 'dark') document.documentElement.setAttribute('data-theme', 'dark'); } catch (e) {} })();
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- CSS is embedded so the page never depends on the asset URL (tunnels, proxies, subfolders) --}}
    <style>{!! @file_get_contents(public_path('css/auth.css')) !!}</style>
</head>
<body>
@php
    $assetPath = fn ($p) => parse_url(asset($p), PHP_URL_PATH);
    $hasLogo = file_exists(public_path('images/logo1.png'));
@endphp

<main class="auth">

    {{-- ===== FORM ===== --}}
    <section class="form-side">
        <div class="topline">
            <div class="mini-brand"><span class="mark">@if($hasLogo)<img src="{{ $assetPath('images/logo1.png') }}" alt="">@else<i class="fas fa-church"></i>@endif</span> TINC Church</div>
            <button type="button" class="theme-btn" id="themeBtn" aria-label="Toggle dark mode"><i class="fas fa-moon"></i></button>
        </div>

        <div class="form-inner">
            <div class="m-badge" aria-hidden="true"><i class="fas fa-church"></i></div>

            <div class="head">
                <h1>Sign in</h1>
                <p class="lead">Welcome back! Your church family is waiting.</p>
            </div>

            @if(session('error') || $errors->any())
                <div class="alert" role="alert">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ session('error') ?? $errors->first() }}</span>
                </div>
            @endif
            @if(session('status'))
                <div class="alert ok" role="status"><i class="fas fa-circle-check"></i><span>{{ session('status') }}</span></div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="field">
                    <div class="input">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder=" " autocomplete="username" required autofocus>
                        <label for="email">Email</label>
                    </div>
                </div>

                <div class="field">
                    <div class="input">
                        <input type="password" name="password" id="password" placeholder=" " autocomplete="current-password" required>
                        <label for="password">Password</label>
                        <button type="button" class="eye" id="togglePw" aria-label="Show password"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="hint" id="capsHint" style="display:none;color:var(--danger)"><i class="fas fa-arrow-up"></i> Caps Lock is on</div>
                </div>

                <div class="row">
                    <label class="check"><input type="checkbox" name="remember"> Keep me signed in</label>
                    @if (Route::has('password.request'))
                        <a class="link" href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                </div>

                <button type="submit" class="btn" id="loginBtn"><span>Sign in</span></button>

                @if (Route::has('register'))
                    <p class="alt">New here? <a class="link" href="{{ route('register') }}">Create new account</a></p>
                @endif
            </form>

            <p class="m-verse">"Come unto me, all ye that labour and are heavy laden, and I will give you rest."<small>Matthew 11:28</small></p>
        </div>
    </section>

    {{-- ===== BRAND (web) ===== --}}
    <section class="brand-side">
        <div class="scene">@include('auth.partials.church-scene')</div>
        <blockquote class="verse">"Come unto me, all ye that labour and are heavy laden, and I will give you rest."<small>Matthew 11:28</small></blockquote>
    </section>
</main>

<script>
    var pw = document.getElementById('password');
    document.getElementById('togglePw').addEventListener('click', function () {
        var show = pw.type === 'password';
        pw.type = show ? 'text' : 'password';
        this.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });
    pw.addEventListener('keyup', function (e) {
        document.getElementById('capsHint').style.display = (e.getModifierState && e.getModifierState('CapsLock')) ? 'block' : 'none';
    });
    document.getElementById('loginForm').addEventListener('submit', function () {
        var b = document.getElementById('loginBtn');
        b.disabled = true;
        b.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Signing in...</span>';
    });
    function syncThemeIcon() {
        var dark = document.documentElement.getAttribute('data-theme') === 'dark';
        document.querySelector('#themeBtn i').className = dark ? 'fas fa-sun' : 'fas fa-moon';
    }
    document.getElementById('themeBtn').addEventListener('click', function () {
        var dark = document.documentElement.getAttribute('data-theme') === 'dark';
        if (dark) document.documentElement.removeAttribute('data-theme'); else document.documentElement.setAttribute('data-theme', 'dark');
        try { localStorage.setItem('theme', dark ? 'light' : 'dark'); } catch (e) {}
        syncThemeIcon();
    });
    syncThemeIcon();
</script>
</body>
</html>
