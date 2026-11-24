<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Welcome') - {{ config('app.name', 'TINC Church System') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/church-logo.png') }}">
    <script>(function(){try{if(localStorage.getItem('theme')==='dark')document.documentElement.setAttribute('data-theme','dark');}catch(e){}})();</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth-v2.css') }}?v={{ @filemtime(public_path('css/auth-v2.css')) }}">
</head>
<body>
<button type="button" class="au-theme" id="themeBtn" aria-label="Toggle dark mode"><i class="fas fa-moon"></i></button>

<main class="au @yield('modifier')">
    <aside class="au-brand">
        <span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span>
        <a class="au-logo" href="{{ url('/') }}">
            <span class="tile"><img src="{{ asset('images/church-logo.png') }}" alt=""></span>
            <span><b>TINC Church</b><small>Church Management System</small></span>
        </a>
        <div class="au-scene">@include('auth.partials.church-scene')</div>
        <blockquote class="au-verse">
            @hasSection('verse')
                @yield('verse')
            @else
                "Come unto me, all ye that labour and are heavy laden, and I will give you rest."<small>Matthew 11:28</small>
            @endif
        </blockquote>
    </aside>

    <section class="au-main">
        <div class="au-card">
            @yield('content')
        </div>
        <p class="au-foot">&copy; {{ date('Y') }} TINC Church System</p>
    </section>
</main>

<script>
    function syncThemeIcon(){document.querySelector('#themeBtn i').className=document.documentElement.getAttribute('data-theme')==='dark'?'fas fa-sun':'fas fa-moon';}
    document.getElementById('themeBtn').addEventListener('click',function(){
        var d=document.documentElement.getAttribute('data-theme')==='dark';
        if(d)document.documentElement.removeAttribute('data-theme');else document.documentElement.setAttribute('data-theme','dark');
        try{localStorage.setItem('theme',d?'light':'dark');}catch(e){}
        syncThemeIcon();
    });
    syncThemeIcon();
    document.querySelectorAll('[data-eye]').forEach(function(b){
        b.addEventListener('click',function(){
            var i=b.parentElement.querySelector('input'),s=i.type==='password';
            i.type=s?'text':'password';
            b.querySelector('i').className=s?'fas fa-eye-slash':'fas fa-eye';
        });
    });
    document.querySelectorAll('form[data-busy]').forEach(function(f){
        f.addEventListener('submit',function(){
            var b=f.querySelector('button[type=submit]');
            if(b){b.disabled=true;b.innerHTML='<i class="fas fa-spinner fa-spin"></i> <span>Please wait...</span>';}
        });
    });
</script>
@stack('scripts')
</body>
</html>