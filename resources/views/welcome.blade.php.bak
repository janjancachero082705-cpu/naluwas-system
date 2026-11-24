<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TINC Church System - Church Management Software</title>
    <link rel="icon" type="image/png" href="{{ asset('images/church-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @if (file_exists(public_path('css/logo-anim.css')))
        <link rel="stylesheet" href="{{ asset('css/logo-anim.css') }}?v={{ filemtime(public_path('css/logo-anim.css')) }}">
    @endif
    <script>
        try { document.documentElement.setAttribute('data-theme', localStorage.getItem('tinc-theme') || 'light'); } catch (e) {}
    </script>
    <style>
        :root{--blue:#3B6BE8;--blue-d:#2f58c4;--green:#5fb800;--ink:#1c1d21;--mut:#6b7280;--card:#fff;--chip:#fff;--chip-b:#dbe3f6;--line:#e6eaf5;
              --bg:#eef2ff;--g1:rgba(59,107,232,.16);--g2:rgba(143,212,0,.18)}
        [data-theme="dark"]{--ink:#eef1fb;--mut:#a3adc7;--card:#161d3b;--chip:#1d2548;--chip-b:#2c3763;--line:#2a345c;
              --bg:#0d1230;--g1:rgba(59,107,232,.28);--g2:rgba(95,184,0,.16)}
        *{box-sizing:border-box}
        @view-transition{navigation:auto}
        html,body{margin:0;min-height:100%}
        body{font-family:'Poppins',system-ui,sans-serif;color:var(--ink);-webkit-font-smoothing:antialiased;
            background:radial-gradient(900px 520px at 8% -5%,var(--g1),transparent 62%),radial-gradient(760px 520px at 100% 105%,var(--g2),transparent 62%),var(--bg);
            background-attachment:fixed;transition:background-color .3s,color .3s}
        .wrap{max-width:1120px;margin:0 auto;padding:22px 24px 28px;min-height:100vh;display:flex;flex-direction:column;transition:opacity .35s ease,transform .35s ease}
        body.leaving .wrap{opacity:0;transform:translateY(-10px) scale(.99)}

        .nav{display:flex;align-items:center;justify-content:space-between;gap:12px}
        .brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:var(--ink);font-weight:600;font-size:16px}
        .brand img{width:44px;height:auto;mix-blend-mode:multiply}
        [data-theme="dark"] .brand img{mix-blend-mode:normal;background:#fff;border-radius:10px;padding:2px}

        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;height:46px;padding:0 24px;border-radius:12px;font:inherit;font-size:14px;font-weight:500;
            text-decoration:none;cursor:pointer;border:1px solid transparent;transition:transform .15s,box-shadow .25s,background .25s}
        .btn.pri{color:#fff;background:linear-gradient(135deg,#4f80f2,#2f58c4);box-shadow:0 12px 22px -10px rgba(47,88,196,.65)}
        .btn.pri:hover{transform:translateY(-1px);box-shadow:0 16px 26px -10px rgba(47,88,196,.7)}
        .btn.alt{color:var(--blue);background:var(--chip);border-color:var(--chip-b)}
        .btn.alt:hover{background:rgba(59,107,232,.1)}
        .btn.sm{height:38px;padding:0 18px;font-size:13px}
        .btn:active{transform:scale(.985)}

        .hero{flex:1;display:grid;grid-template-columns:1.05fr .95fr;gap:44px;align-items:center;padding:28px 0 8px}
        .hero h1{margin:0 0 14px;font-size:clamp(30px,4.4vw,48px);line-height:1.1;font-weight:700;letter-spacing:-.03em}
        .hero p.lead{margin:0 0 20px;max-width:480px;font-size:14.5px;line-height:1.7;color:var(--mut)}
        .chips{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:26px;max-width:500px}
        .chip{display:inline-flex;align-items:center;gap:8px;padding:7px 13px;border-radius:999px;font-size:12px;font-weight:500;color:var(--ink);
            background:var(--chip);border:1px solid var(--chip-b)}
        .chip i{font-size:11px;color:var(--blue)}
        .chip:nth-child(even) i{color:var(--green)}
        .cta{display:flex;flex-wrap:wrap;gap:12px}

        .art{position:relative;border-radius:30px;padding:34px 26px 26px;display:flex;justify-content:center;overflow:hidden;border:1px solid rgba(255,255,255,.9);
            background:radial-gradient(rgba(59,107,232,.13) 1.2px,transparent 1.5px) 0 0/18px 18px,radial-gradient(circle at 30% 12%,#fff 0,#eef3ff 55%,#e0e8fb 100%);
            box-shadow:0 34px 70px -28px rgba(47,88,196,.4)}
        [data-theme="dark"] .art{border-color:#2a345c;background:radial-gradient(rgba(255,255,255,.07) 1.2px,transparent 1.5px) 0 0/18px 18px,radial-gradient(circle at 30% 12%,#27316a 0,#1a2147 60%,#141a3a 100%)}
        .art::before{content:"";position:absolute;width:240px;height:240px;right:-90px;top:-90px;border-radius:50%;background:radial-gradient(circle,rgba(143,212,0,.32),transparent 70%)}
        .art::after{content:"";position:absolute;width:280px;height:280px;left:-110px;bottom:-110px;border-radius:50%;background:radial-gradient(circle,rgba(59,107,232,.26),transparent 70%)}
        .art svg{position:relative;z-index:1;width:100%;max-width:330px;height:auto}
        .float{animation:float 5.5s ease-in-out infinite}
        @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-6px)}}

        .stats{display:grid;grid-template-columns:repeat(3,1fr);margin-top:36px;border-radius:20px;background:var(--card);border:1px solid var(--line);
            box-shadow:0 14px 30px -22px rgba(47,88,196,.4)}
        .stat{padding:18px 12px;text-align:center}
        .stat+.stat{border-left:1px solid var(--line)}
        .stat b{display:block;font-size:24px;font-weight:700;letter-spacing:-.02em;background:linear-gradient(135deg,#3B6BE8,#5fb800);-webkit-background-clip:text;background-clip:text;color:transparent}
        .stat span{font-size:12px;color:var(--mut)}
        .foot{margin-top:22px;text-align:center;font-size:12px;color:var(--mut)}

        .theme-toggle{position:fixed;right:20px;bottom:20px;z-index:20;width:44px;height:44px;border-radius:50%;border:1px solid var(--chip-b);background:var(--chip);color:var(--ink);
            cursor:pointer;font-size:16px;display:grid;place-items:center;box-shadow:0 10px 24px -12px rgba(47,88,196,.5);transition:transform .2s}
        .theme-toggle:hover{transform:scale(1.08)}

        .hero .txt>*{animation:up .6s cubic-bezier(.2,.8,.2,1) both}
        .hero .txt>*:nth-child(2){animation-delay:.07s}.hero .txt>*:nth-child(3){animation-delay:.14s}.hero .txt>*:nth-child(4){animation-delay:.21s}
        .hero .art{animation:up .7s .1s cubic-bezier(.2,.8,.2,1) both}
        @keyframes up{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
        @media (prefers-reduced-motion:reduce){.float,.hero .txt>*,.hero .art{animation:none}.wrap{transition:none}}

        @media (max-width:900px){
            .hero{grid-template-columns:1fr;gap:26px;padding-top:12px}
            .art{order:-1;max-width:400px;margin:0 auto;width:100%;padding:26px 20px 20px}
            .hero .txt{text-align:center}
            .hero p.lead,.chips{margin-left:auto;margin-right:auto}
            .chips,.cta{justify-content:center}
        }
        @media (max-width:520px){.stats{grid-template-columns:1fr}.stat+.stat{border-left:0;border-top:1px solid var(--line)}}
    </style>
</head>
<body>
<button class="theme-toggle" id="themeToggle" aria-label="Toggle theme"><i class="fas fa-moon"></i></button>

<div class="wrap">
    <header class="nav">
        <a class="brand" href="{{ url('/') }}"><img src="{{ asset('images/church-logo.png') }}" alt="" width="44" height="38"><span>TINC Church System</span></a>
        <a class="btn alt sm" href="{{ route('login') }}" data-go>Sign In</a>
    </header>

    <main class="hero">
        <div class="txt">
            <h1>TINC Church System</h1>
            <p class="lead">A complete church management solution for every iglesia. Manage members, attendance, choir schedules, inventory, and finances in one sacred space.</p>
            <div class="chips">
                <span class="chip"><i class="fas fa-users"></i> Member Management</span>
                <span class="chip"><i class="fas fa-calendar-check"></i> Attendance Tracking</span>
                <span class="chip"><i class="fas fa-music"></i> Choir Ministry</span>
                <span class="chip"><i class="fas fa-boxes-stacked"></i> Inventory Control</span>
                <span class="chip"><i class="fas fa-chart-line"></i> Financial Reports</span>
            </div>
            <div class="cta">
                <a class="btn pri" href="{{ route('register') }}" data-go><i class="fas fa-church"></i> Register Your Church</a>
                <a class="btn alt" href="{{ route('login') }}" data-go><i class="fas fa-right-to-bracket"></i> Sign In</a>
            </div>
        </div>

        <div class="art" aria-hidden="true">
            <svg viewBox="0 0 360 420" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="w-w" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#fff"/><stop offset="1" stop-color="#e3eafc"/></linearGradient>
                    <linearGradient id="w-r" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#6d94f5"/><stop offset="1" stop-color="#2f58c4"/></linearGradient>
                </defs>
                <circle cx="180" cy="230" r="150" fill="#fff" opacity=".65"/>
                <ellipse cx="180" cy="392" rx="170" ry="30" fill="#cdeb94" opacity=".55"/>
                <ellipse cx="180" cy="396" rx="120" ry="14" fill="#000" opacity=".06"/>
                <circle cx="58" cy="352" r="22" fill="#9ed84a"/><rect x="55" y="362" width="6" height="26" rx="3" fill="#6c9a2d"/>
                <circle cx="302" cy="356" r="18" fill="#9ed84a"/><rect x="299" y="364" width="6" height="22" rx="3" fill="#6c9a2d"/>
                <g transform="translate(0 16)">
                    <polygon points="84,214 180,172 276,214" fill="url(#w-r)"/>
                    <rect x="100" y="214" width="160" height="126" fill="url(#w-w)"/>
                    <rect x="154" y="118" width="52" height="112" fill="url(#w-w)"/>
                    <polygon points="146,122 180,80 214,122" fill="url(#w-r)"/>
                    <circle cx="180" cy="58" r="24" fill="#8fd400" opacity=".22"/>
                    <path d="M180 44v34M168 57h24" stroke="#7ed321" stroke-width="6" stroke-linecap="round"/>
                    <circle cx="180" cy="168" r="14" fill="#fff" stroke="#6d94f5" stroke-width="4"/>
                    <path d="M180 160v16M172 168h16" stroke="#6d94f5" stroke-width="3" stroke-linecap="round"/>
                    <rect x="114" y="250" width="22" height="42" rx="11" fill="#fff" stroke="#6d94f5" stroke-width="4"/>
                    <rect x="224" y="250" width="22" height="42" rx="11" fill="#fff" stroke="#6d94f5" stroke-width="4"/>
                    <path d="M158 340v-38a22 22 0 0 1 44 0v38z" fill="url(#w-r)"/>
                    <rect x="144" y="340" width="72" height="9" rx="3" fill="#c5d2f3"/>
                </g>
                <g class="float">
                    <rect x="46" y="6" width="268" height="36" rx="18" fill="#fff"/>
                    <circle cx="68" cy="24" r="8" fill="#8fd400"/>
                    <text x="84" y="28.5" font-family="Poppins,sans-serif" font-size="12.5" font-weight="500" fill="#1c1d21">yourchurch.churchsystem.com</text>
                </g>
                <path transform="translate(58 130)" d="M0 -8L2 -2L8 0L2 2L0 8L-2 2L-8 0L-2 -2Z" fill="#3B6BE8" opacity=".7"/>
                <path transform="translate(306 168)" d="M0 -9L2.5 -2.5L9 0L2.5 2.5L0 9L-2.5 2.5L-9 0L-2.5 -2.5Z" fill="#8fd400"/>
            </svg>
        </div>
    </main>

    <section class="stats">
        <div class="stat"><b>6+</b><span>Core Modules</span></div>
        <div class="stat"><b>100%</b><span>Faith-First</span></div>
        <div class="stat"><b>24/7</b><span>Available</span></div>
    </section>

    <footer class="foot">&copy; {{ date('Y') }} TINC Church System</footer>
</div>

<script>
(function () {
    var html = document.documentElement, btn = document.getElementById('themeToggle');
    function icon(t) { btn.querySelector('i').className = 'fas ' + (t === 'dark' ? 'fa-sun' : 'fa-moon'); }
    icon(html.getAttribute('data-theme') || 'light');
    btn.addEventListener('click', function () {
        var n = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', n);
        try { localStorage.setItem('tinc-theme', n); } catch (e) {}
        icon(n);
    });

    document.querySelectorAll('[data-go]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
            e.preventDefault();
            var href = a.href;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) { location.href = href; return; }
            try { sessionStorage.setItem('auSwap', '1'); } catch (x) {}
            document.body.classList.add('leaving');
            setTimeout(function () { location.href = href; }, 340);
        });
    });
    window.addEventListener('pageshow', function (e) { if (e.persisted) document.body.classList.remove('leaving'); });
})();
</script>
</body>
</html>