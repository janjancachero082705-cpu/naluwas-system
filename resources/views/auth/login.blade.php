<!DOCTYPE html>
<html lang="en" data-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — TINC Church System</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --gold:     #c9a84c;
            --gold-lt:  #e8c96a;
            --gold-dim: #8a6d28;
            --gold-glow: rgba(201,168,76,0.3);
            --ink:      #0d0c14;
            --ink-2:    #1a1828;
            --ink-3:    #252340;
            --parchment:#faf8f3;
            --parch-2:  #f0ebe0;
            --primary:  #8B5CF6;
            --primary-dark: #7C3AED;
            --primary-light: #A78BFA;
            --primary-glow: rgba(139,92,246,0.2);
        }

        [data-theme="dark"] {
            --bg:        var(--ink);
            --bg-panel:  var(--ink-2);
            --bg-input:  rgba(255,255,255,0.05);
            --bg-input-focus: rgba(255,255,255,0.08);
            --border:    rgba(139,92,246,0.18);
            --border-input: rgba(255,255,255,0.1);
            --border-focus: var(--primary);
            --text-h:    #f0ead8;
            --text-b:    #c8c0b0;
            --text-m:    #7a7260;
            --text-label:#a09880;
            --text-input:#e8e0d0;
            --placeholder: #5a5548;
        }
        [data-theme="light"] {
            --bg:        var(--parchment);
            --bg-panel:  #ffffff;
            --bg-input:  #fafaf8;
            --bg-input-focus: #ffffff;
            --border:    rgba(139,92,246,0.2);
            --border-input: #ddd8ce;
            --border-focus: var(--primary);
            --text-h:    var(--ink);
            --text-b:    #3a3228;
            --text-m:    #7a7260;
            --text-label:#5a5040;
            --text-input:#1a1510;
            --placeholder: #bbb5a8;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            transition: background 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(139,92,246,0.05);
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -30px) scale(1.1); }
            50% { transform: translate(-30px, 50px) scale(0.9); }
            75% { transform: translate(40px, 40px) scale(1.05); }
        }

        .circle-1 { width: 400px; height: 400px; top: -100px; left: -150px; animation-delay: 0s; background: rgba(139,92,246,0.08); }
        .circle-2 { width: 300px; height: 300px; bottom: -100px; right: -100px; animation-delay: 5s; background: rgba(139,92,246,0.06); }
        .circle-3 { width: 200px; height: 200px; top: 40%; left: 10%; animation-delay: 2s; background: rgba(201,168,76,0.06); }
        .circle-4 { width: 350px; height: 350px; bottom: 20%; right: 20%; animation-delay: 8s; background: rgba(139,92,246,0.04); }
        .circle-5 { width: 150px; height: 150px; top: 20%; right: 15%; animation-delay: 3s; background: rgba(201,168,76,0.05); }

        /* Auth Wrap */
        .auth-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 32px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 40px 80px rgba(0,0,0,0.25);
            animation: slideUp 0.7s cubic-bezier(.4,0,.2,1) both;
            background: var(--bg-panel);
        }

        @keyframes slideUp {
            from { opacity:0; transform: translateY(32px); }
            to   { opacity:1; transform: translateY(0); }
        }

        /* Left Panel - Logo Focused */
        .left-panel {
            background: linear-gradient(160deg, #0a0918 0%, #14102a 40%, #1a1230 70%, #0d0c20 100%);
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at center, rgba(139,92,246,0.08) 0%, transparent 60%);
            pointer-events: none;
            animation: pulseGlow 8s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }

        .left-panel::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, var(--primary) 30%, var(--gold) 50%, var(--primary) 70%, transparent 100%);
            opacity: 0.8;
        }

        /* Large Logo Animation */
        .logo-container {
            position: relative;
            z-index: 1;
            margin-bottom: 2rem;
        }

        .logo-wrapper {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 0 auto;
        }

        .logo-wrapper .logo-ring {
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 2px solid rgba(139,92,246,0.2);
            animation: spinRing 20s linear infinite;
        }

        .logo-wrapper .logo-ring:nth-child(2) {
            inset: -20px;
            border-color: rgba(201,168,76,0.15);
            animation-duration: 15s;
            animation-direction: reverse;
        }

        .logo-wrapper .logo-ring:nth-child(3) {
            inset: -30px;
            border-color: rgba(139,92,246,0.1);
            animation-duration: 25s;
        }

        @keyframes spinRing {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo-image {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(139,92,246,0.3);
            box-shadow: 0 0 40px rgba(139,92,246,0.15), 0 0 80px rgba(139,92,246,0.05);
            animation: logoPulse 3s ease-in-out infinite;
            position: relative;
            z-index: 2;
            background: #1a1230;
        }

        @keyframes logoPulse {
            0%, 100% { 
                box-shadow: 0 0 40px rgba(139,92,246,0.15), 0 0 80px rgba(139,92,246,0.05);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 60px rgba(139,92,246,0.25), 0 0 120px rgba(139,92,246,0.08);
                transform: scale(1.02);
            }
        }

        .logo-fallback {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            border: 4px solid rgba(139,92,246,0.3);
            box-shadow: 0 0 40px rgba(139,92,246,0.15);
            animation: logoPulse 3s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        .logo-fallback i {
            filter: drop-shadow(0 0 20px rgba(255,255,255,0.2));
        }

        /* Floating particles around logo */
        .particles {
            position: absolute;
            inset: -50px;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0.3;
            animation: floatParticle 4s ease-in-out infinite;
        }

        .particle:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { top: 5%; right: 15%; animation-delay: 1.2s; }
        .particle:nth-child(3) { bottom: 15%; left: 8%; animation-delay: 2.5s; }
        .particle:nth-child(4) { bottom: 8%; right: 10%; animation-delay: 0.8s; }
        .particle:nth-child(5) { top: 45%; left: 0%; animation-delay: 1.8s; }
        .particle:nth-child(6) { top: 40%; right: 0%; animation-delay: 3s; }

        @keyframes floatParticle {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.2; }
            25% { transform: translate(-10px, -15px) scale(1.5); opacity: 0.6; }
            50% { transform: translate(10px, -5px) scale(0.8); opacity: 0.3; }
            75% { transform: translate(-5px, 10px) scale(1.2); opacity: 0.5; }
        }

        .church-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #f0ead8;
            margin-top: 1rem;
            position: relative;
            z-index: 1;
            letter-spacing: 2px;
        }

        .church-name span {
            color: var(--gold);
        }

        .church-tagline {
            font-size: 0.85rem;
            color: #7a7260;
            position: relative;
            z-index: 1;
            margin-top: 0.3rem;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .divider-line {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--gold));
            margin: 1.5rem auto;
            position: relative;
            z-index: 1;
            border-radius: 2px;
        }

        .panel-verse {
            border-left: 2px solid rgba(139,92,246,0.4);
            padding-left: 1rem;
            position: relative;
            z-index: 1;
            max-width: 280px;
            margin: 0 auto;
        }

        .verse-text {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 0.9rem;
            color: #a89870;
            line-height: 1.6;
            margin-bottom: 0.3rem;
        }

        .verse-ref {
            font-size: 0.7rem;
            color: #5a5040;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Right Panel */
        .right-panel {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: background 0.5s ease;
        }

        .form-head {
            margin-bottom: 2rem;
        }
        .form-head h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-h);
            margin-bottom: 0.3rem;
        }
        .form-head h2 i {
            color: var(--primary);
            margin-right: 8px;
        }
        .form-head p {
            font-size: 0.85rem;
            color: var(--text-m);
        }

        /* Alert */
        .alert-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            font-size: 0.84rem;
            margin-bottom: 1.5rem;
            animation: shake 0.4s ease;
        }
        .alert-box.error {
            background: rgba(220,38,38,0.08);
            border: 1px solid rgba(220,38,38,0.25);
            color: #ef4444;
        }
        .alert-box.success {
            background: rgba(34,197,94,0.08);
            border: 1px solid rgba(34,197,94,0.2);
            color: #22c55e;
        }
        @keyframes shake {
            0%,100%{ transform:translateX(0); }
            25%    { transform:translateX(-4px); }
            75%    { transform:translateX(4px); }
        }

        /* Field */
        .field { margin-bottom: 1.3rem; }
        .field label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-label);
            margin-bottom: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* ===== PASSWORD FIELD WITH EYE INSIDE ===== */
        .input-wrap {
            position: relative;
        }

        .input-wrap .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-m);
            font-size: 0.85rem;
            pointer-events: none;
            transition: color 0.3s;
            z-index: 2;
        }

        .input-wrap input {
            width: 100%;
            padding: 0.8rem 3rem 0.8rem 2.6rem;
            background: var(--bg-input);
            border: 1.5px solid var(--border-input);
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--text-input);
            transition: all 0.3s ease;
            outline: none;
            position: relative;
            z-index: 1;
        }

        .input-wrap input::placeholder { color: var(--placeholder); }
        .input-wrap input:focus {
            background: var(--bg-input-focus);
            border-color: var(--border-focus);
            box-shadow: 0 0 0 4px rgba(139,92,246,0.12);
        }
        .input-wrap input:focus ~ .input-icon,
        .input-wrap:focus-within .input-icon { color: var(--primary); }

        /* Eye button INSIDE the input - positioned on the right */
        .eye-btn-inside {
            position: absolute;
            right: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-m);
            cursor: pointer;
            z-index: 3;
            font-size: 0.9rem;
            padding: 6px;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .eye-btn-inside:hover {
            color: var(--primary);
            background: rgba(139,92,246,0.08);
        }

        .eye-btn-inside:active {
            transform: translateY(-50%) scale(0.9);
        }

        .row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.8rem;
        }
        .check-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--text-m);
            cursor: pointer;
        }
        .check-label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }
        .link-gold {
            font-size: 0.8rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .link-gold:hover { color: var(--primary-light); }

        .btn-submit {
            width: 100%;
            padding: 0.9rem;
            border-radius: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.6s ease;
        }
        .btn-submit:hover::after { left: 100%; }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(139,92,246,0.35);
        }
        .btn-submit:active { transform: translateY(0); }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: var(--text-m);
        }
        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        .form-footer a:hover { color: var(--primary-light); }

        .security-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 1rem;
            font-size: 0.7rem;
            color: var(--text-m);
            opacity: 0.6;
        }

        /* Back Link */
        .back-link {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 50;
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: color 0.3s;
            background: rgba(0,0,0,0.2);
            padding: 8px 16px;
            border-radius: 30px;
            backdrop-filter: blur(10px);
        }
        .back-link:hover { color: var(--gold); }

        /* Theme Toggle Button */
        .fab-theme {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 50;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .fab-theme:hover {
            transform: scale(1.1);
            color: var(--gold);
            border-color: var(--gold);
            background: rgba(255,255,255,0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body { padding: 1rem; }
            .auth-wrap {
                grid-template-columns: 1fr;
                border-radius: 24px;
                margin-top: 3rem;
            }
            .left-panel { padding: 2rem 1.5rem; }
            .right-panel { padding: 2rem 1.5rem; }
            .logo-wrapper {
                width: 120px;
                height: 120px;
            }
            .logo-image, .logo-fallback {
                width: 120px;
                height: 120px;
                font-size: 3rem;
            }
            .logo-wrapper .logo-ring { display: none; }
            .church-name { font-size: 1.8rem; }
            .back-link { top: 0.5rem; left: 0.5rem; padding: 6px 12px; font-size: 0.7rem; }
            .particles { display: none; }
        }

        @media (max-width: 480px) {
            .left-panel { padding: 1.5rem 1rem; }
            .logo-wrapper {
                width: 100px;
                height: 100px;
            }
            .logo-image, .logo-fallback {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }
            .church-name { font-size: 1.4rem; }
            .church-tagline { font-size: 0.7rem; letter-spacing: 2px; }
            .panel-verse { max-width: 100%; }
            .verse-text { font-size: 0.8rem; }
        }
    </style>
</head>
<body>

<div class="bg-animation">
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>
    <div class="circle circle-3"></div>
    <div class="circle circle-4"></div>
    <div class="circle circle-5"></div>
</div>

<a href="{{ url('/') }}" class="back-link">
    <i class="fas fa-arrow-left"></i> Back
</a>

<button class="fab-theme" id="fabThemeToggle" aria-label="Toggle theme">
    <i class="fas fa-moon"></i>
</button>

<div class="auth-wrap" data-aos="fade-up" data-aos-duration="800">
    <!-- Left Panel - Logo Centered -->
    <div class="left-panel">
        <div class="logo-container">
            <div class="logo-wrapper">
                <!-- Animated Rings -->
                <div class="logo-ring"></div>
                <div class="logo-ring"></div>
                <div class="logo-ring"></div>
                
                <!-- Floating Particles -->
                <div class="particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                </div>

                <!-- Logo Image - Changed to logo1.png -->
                @if(file_exists(public_path('images/logo1.png')))
                    <img src="{{ asset('images/logo1.png') }}" alt="TINC Church" class="logo-image">
                @else
                    <div class="logo-fallback">
                        <i class="fas fa-church"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="church-name">
            Naluwas <span>Church</span>
        </div>
        <div class="church-tagline">Management System</div>
        <div class="divider-line"></div>

        <div class="panel-verse">
            <div class="verse-text">"I am the way and the truth and the life."</div>
            <div class="verse-ref">✝ John 14:6</div>
        </div>
    </div>

    <!-- Right Panel / Form -->
    <div class="right-panel">
        <div class="form-head">
            <h2><i class="fas fa-sign-in-alt"></i> Sign In</h2>
            <p>Enter your credentials to continue</p>
        </div>

        @if($errors->any())
            <div class="alert-box error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert-box success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@yourchurch.com"
                        required autofocus>
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password"
                        placeholder="••••••••"
                        required>
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <button type="button" class="eye-btn-inside" id="eyeBtn" aria-label="Toggle password visibility">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <div class="row-between">
                <label class="check-label">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-gold">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>

            <div class="form-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Create one →</a>
            </div>

            <div class="security-note">
                <i class="fas fa-shield-alt"></i>
                Faith-Based Security · Naluwas church System
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();

    // Theme Toggle
    const html = document.documentElement;
    const themeBtn = document.getElementById('fabThemeToggle');
    const savedTheme = localStorage.getItem('tinc-theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);

    themeBtn.addEventListener('click', () => {
        const current = html.getAttribute('data-theme');
        const newTheme = current === 'dark' ? 'light' : 'dark';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('tinc-theme', newTheme);
        updateThemeIcon(newTheme);
    });

    function updateThemeIcon(theme) {
        const icon = themeBtn.querySelector('i');
        if (theme === 'dark') {
            icon.className = 'fas fa-sun';
        } else {
            icon.className = 'fas fa-moon';
        }
    }

    // Eye toggle - Password visibility
    document.getElementById('eyeBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        const inp = document.getElementById('password');
        const ico = document.getElementById('eyeIcon');
        
        if (inp.type === 'password') {
            inp.type = 'text';
            ico.className = 'fas fa-eye-slash';
            this.style.color = 'var(--primary)';
        } else {
            inp.type = 'password';
            ico.className = 'fas fa-eye';
            this.style.color = '';
        }
    });
</script>
</body>
</html>