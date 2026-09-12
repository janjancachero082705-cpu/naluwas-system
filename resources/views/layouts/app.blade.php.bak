<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::user()?->id ?? 0 }}">

    <title>{{ config('app.name', 'TINC Church System') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* ============================================================
           DESIGN TOKENS
           ============================================================ */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-primary: #F4F6FB;
            --bg-secondary: #FFFFFF;
            --bg-tertiary: #EEF1F7;
            --bg-glass: rgba(255, 255, 255, 0.72);
            --text-primary: #0F1B2D;
            --text-secondary: #566179;
            --text-muted: #93A1B8;
            --border-color: #E3E8F0;
            --border-light: #EFF3F8;
            --card-bg: #FFFFFF;
            --card-shadow: 0 1px 2px rgba(15,27,45,0.04), 0 6px 24px -8px rgba(15,27,45,0.08);
            --card-shadow-lg: 0 4px 12px rgba(15,27,45,0.06), 0 24px 48px -20px rgba(15,27,45,0.18);
            --ink: #0B1E36;
            --ink-2: #132D4D;
            --ink-3: #1E4468;
            --brass: #C89B3C;
            --brass-2: #B9862F;
            --brass-3: #96691F;
            --accent-blue: #4A7AB5;
            --accent-teal: #2AA198;
            --accent-emerald: #16A075;
            --accent-violet: #7C5CB8;
            --accent-rose: #D0554E;
            --accent-amber: #E1A100;
            --gradient-primary: linear-gradient(135deg, #16324F 0%, #0B1E36 100%);
            --gradient-brass: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
            --gradient-success: linear-gradient(135deg, #3E9463 0%, #2A7048 100%);
            --gradient-danger: linear-gradient(135deg, #D0554E 0%, #B03B34 100%);
            --gradient-info: linear-gradient(135deg, #3D74A6 0%, #2B5A85 100%);
            --notification-bg: #FFFFFF;
            --notification-shadow: 0 24px 56px -16px rgba(15,27,45,0.22);
            --font-display: 'Fraunces', Georgia, serif;
            --font-body: 'Inter', -apple-system, BlinkMacSystemFont, system-ui, sans-serif;
            --font-mono: 'IBM Plex Mono', ui-monospace, monospace;
            --dropdown-shadow: 0 24px 56px -12px rgba(15,27,45,0.24);
            --danger-color: #B03B34;
            --danger-hover: #8A2A26;
            --success-color: #2A7048;
            --r-sm: 8px;
            --r-md: 12px;
            --r-lg: 16px;
            --r-xl: 20px;
            --r-2xl: 28px;
            --ease-out: cubic-bezier(0.22, 1, 0.36, 1);
            --ease-soft: cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            --bg-primary: #0B1220;
            --bg-secondary: #131C2C;
            --bg-tertiary: #0F1826;
            --bg-glass: rgba(19, 28, 44, 0.72);
            --text-primary: #E8EEF8;
            --text-secondary: #9BABC4;
            --text-muted: #5E6E88;
            --border-color: #22304A;
            --border-light: #1B2740;
            --card-bg: #131C2C;
            --card-shadow: 0 1px 2px rgba(0,0,0,0.35), 0 6px 24px -8px rgba(0,0,0,0.4);
            --card-shadow-lg: 0 4px 12px rgba(0,0,0,0.3), 0 24px 48px -20px rgba(0,0,0,0.6);
            --notification-bg: #131C2C;
            --notification-shadow: 0 24px 56px -16px rgba(0,0,0,0.65);
        }

        html, body { height: 100%; }

        body {
            font-family: var(--font-body);
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow: hidden;
            height: 100vh;
            transition: background 0.35s var(--ease-soft), color 0.35s var(--ease-soft);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-size: 15px;
            letter-spacing: -0.005em;
        }

        .animated-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            opacity: 0.6;
            pointer-events: none;
            overflow: hidden;
        }
        .animated-bg .circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            animation: floatOrb 30s infinite ease-in-out;
        }
        .animated-bg .circle.c1 { width: 480px; height: 480px; top: -8%; left: -8%; background: linear-gradient(135deg, #4A7AB5, #16324F); }
        .animated-bg .circle.c2 { width: 380px; height: 380px; top: 30%; right: -6%; background: linear-gradient(135deg, #C89B3C, #B9862F); animation-delay: 6s; }
        .animated-bg .circle.c3 { width: 300px; height: 300px; bottom: -6%; left: 30%; background: linear-gradient(135deg, #2AA198, #16A075); animation-delay: 12s; }
        .animated-bg .circle.c4 { width: 260px; height: 260px; top: 55%; left: 15%; background: linear-gradient(135deg, #7C5CB8, #4A7AB5); animation-delay: 3s; }
        .animated-bg .circle.c5 { width: 200px; height: 200px; top: 15%; right: 25%; background: linear-gradient(135deg, #D0554E, #B03B34); animation-delay: 9s; }

        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25%      { transform: translate(60px, -40px) scale(1.1); }
            50%      { transform: translate(-40px, 60px) scale(0.95); }
            75%      { transform: translate(50px, 40px) scale(1.05); }
        }

        /* ============================================================
           PROFILE IMAGE HELPERS (NEW)
           ============================================================ */
        [data-profile-image],
        [data-profile-initials] {
            transition: opacity 0.3s var(--ease-out);
        }
        [data-profile-image].is-loading {
            opacity: 0.5;
        }

        /* ============================================================
           SIDEBAR
           ============================================================ */
        .sidebar-container {
            position: fixed;
            left: 0; top: 0;
            height: 100vh;
            width: 264px;
            background: linear-gradient(180deg, #0B1A2E 0%, #0A1524 100%);
            overflow: hidden;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
            transition: transform 0.4s var(--ease-out);
            box-shadow: 4px 0 32px rgba(0,0,0,0.25);
        }

        .sidebar-container::before {
            content: '';
            position: absolute;
            top: -100px; left: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200,155,60,0.12), transparent 70%);
            pointer-events: none;
        }
        .sidebar-container::after {
            content: '';
            position: absolute;
            bottom: -100px; right: -100px;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(74,122,181,0.10), transparent 70%);
            pointer-events: none;
        }

        .logo-section {
            padding: 1.5rem 1.25rem 1.35rem;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
            position: relative;
            z-index: 2;
        }
        .logo-wrapper { display: flex; align-items: center; gap: 13px; }

        .logo-upload-trigger { position: relative; width: 48px; height: 48px; flex-shrink: 0; cursor: pointer; }
        .logo-img {
            width: 48px; height: 48px;
            border-radius: 14px;
            object-fit: cover;
            box-shadow: 0 6px 20px rgba(200,155,60,0.28);
            border: 1.5px solid rgba(200,155,60,0.35);
            display: block;
            transition: transform 0.3s var(--ease-out), box-shadow 0.3s var(--ease-out);
        }
        .logo-img:hover { transform: scale(1.05); box-shadow: 0 8px 28px rgba(200,155,60,0.4); }

        .logo-icon-fallback {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #0B1A2E;
            box-shadow: 0 6px 20px rgba(200,155,60,0.35);
            position: relative;
            transition: transform 0.3s var(--ease-out);
        }
        .logo-icon-fallback:hover { transform: scale(1.05) rotate(-3deg); }

        .logo-text h2 {
            font-family: var(--font-display);
            font-size: 1.08rem;
            font-weight: 700;
            color: #FFFFFF;
            margin: 0;
            letter-spacing: -0.3px;
            line-height: 1.15;
        }
        .logo-text p {
            font-size: 0.62rem;
            color: #8BA3C2;
            margin: 3px 0 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .nav-menu-wrap { flex: 1; overflow: hidden; position: relative; z-index: 2; }
        .nav-menu {
            height: 100%;
            padding: 1.1rem 0.9rem;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.12) transparent;
        }
        .nav-menu::-webkit-scrollbar { width: 3px; }
        .nav-menu::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 10px; }

        .nav-section { margin-bottom: 1.4rem; }
        .nav-section-title {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            color: #6B85A6;
            padding: 0.3rem 0.75rem 0.6rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-section-title i { color: #C89B3C; font-size: 0.55rem; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.68rem 0.85rem;
            margin: 2px 0;
            border-radius: var(--r-md);
            color: #C5D2E3;
            text-decoration: none;
            transition: all 0.2s var(--ease-out);
            font-weight: 500;
            font-size: 0.85rem;
            position: relative;
            border: 1px solid transparent;
        }
        .nav-item i {
            width: 20px;
            font-size: 0.95rem;
            text-align: center;
            color: #7B92AF;
            transition: all 0.2s var(--ease-out);
            flex-shrink: 0;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.055);
            color: #FFFFFF;
            border-color: rgba(255,255,255,0.06);
            transform: translateX(3px);
        }
        .nav-item:hover i { color: #D3A24C; }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(211,162,76,0.18) 0%, rgba(211,162,76,0.08) 100%);
            color: #FFFFFF;
            font-weight: 600;
            border-color: rgba(211,162,76,0.25);
            box-shadow: inset 0 0 0 1px rgba(211,162,76,0.1), 0 4px 12px rgba(211,162,76,0.12);
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -0.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            border-radius: 0 4px 4px 0;
            background: linear-gradient(180deg, #D3A24C, #B9862F);
            box-shadow: 0 0 12px rgba(211,162,76,0.5);
        }
        .nav-item.active i { color: #D3A24C; }

        .nav-badge {
            margin-left: auto;
            background: rgba(211,162,76,0.15);
            padding: 2px 9px;
            border-radius: 30px;
            font-size: 0.62rem;
            color: #D3A24C;
            font-weight: 700;
            font-family: var(--font-mono);
            border: 1px solid rgba(211,162,76,0.15);
        }
        .nav-badge.finance {
            background: rgba(45,156,108,0.15);
            color: #4DBF8A;
            border-color: rgba(45,156,108,0.15);
        }
        .nav-badge.message-badge {
            background: linear-gradient(135deg, #D0554E, #B03B34);
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 30px;
            font-size: 0.6rem;
            font-weight: 700;
            font-family: var(--font-mono);
            animation: pulseDot 2s infinite;
            border: none;
            box-shadow: 0 0 0 0 rgba(208, 85, 78, 0.6);
        }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.65; }
        }

        /* ============================================================
           CHURCH ADMIN SECTION
           ============================================================ */
        .user-section {
            flex-shrink: 0;
            padding: 0.9rem;
            position: relative;
            z-index: 2;
            background: linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.045));
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .user-section::before {
            content: '';
            position: absolute;
            top: 0; left: 20px; right: 20px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(211,162,76,0.35), transparent);
            pointer-events: none;
        }

        .admin-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
            padding: 1.15rem 0.85rem 1rem;
            border-radius: var(--r-lg);
            background:
                radial-gradient(120% 80% at 50% -10%, rgba(211,162,76,0.14), transparent 60%),
                linear-gradient(160deg, rgba(255,255,255,0.05), rgba(255,255,255,0.015));
            border: 1px solid rgba(211,162,76,0.18);
            overflow: hidden;
            transition: transform 0.35s var(--ease-out), border-color 0.35s var(--ease-out), box-shadow 0.35s var(--ease-out);
            box-shadow: 0 4px 18px -8px rgba(0,0,0,0.4);
        }
        .admin-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(115deg, transparent 25%, rgba(255,255,255,0.07) 45%, transparent 65%);
            transform: translateX(-120%);
            transition: transform 0.9s var(--ease-out);
            pointer-events: none;
        }
        .admin-card:hover {
            transform: translateY(-3px);
            border-color: rgba(211,162,76,0.4);
            box-shadow: 0 12px 30px -12px rgba(211,162,76,0.35), 0 4px 14px -6px rgba(0,0,0,0.4);
        }
        .admin-card:hover::before { transform: translateX(120%); }

        .admin-avatar-wrap {
            position: relative;
            flex-shrink: 0;
            display: inline-block;
            line-height: 0;
        }
        .admin-avatar-img,
        .admin-avatar-initials {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: #0B1A2E;
            border: 2.5px solid rgba(211,162,76,0.55);
            box-shadow: 0 6px 18px -4px rgba(211,162,76,0.45), inset 0 0 0 1px rgba(0,0,0,0.08);
            transition: transform 0.35s var(--ease-out), box-shadow 0.35s var(--ease-out);
        }
        .admin-avatar-img {
            background: #0B1A2E;
            color: #FFFFFF;
        }
        .admin-card:hover .admin-avatar-img,
        .admin-card:hover .admin-avatar-initials {
            transform: scale(1.06);
            box-shadow: 0 10px 26px -6px rgba(211,162,76,0.6), inset 0 0 0 1px rgba(0,0,0,0.08);
        }

        .admin-status-dot {
            position: absolute;
            bottom: 1px;
            right: 1px;
            width: 13px;
            height: 13px;
            background: #16A075;
            border-radius: 50%;
            border: 2.5px solid #0B1A2E;
            box-shadow: 0 0 0 0 rgba(22,160,117,0.7);
            animation: pulseStatus 2.2s infinite;
        }
        @keyframes pulseStatus {
            0%   { box-shadow: 0 0 0 0 rgba(22,160,117,0.6); }
            70%  { box-shadow: 0 0 0 7px rgba(22,160,117,0); }
            100% { box-shadow: 0 0 0 0 rgba(22,160,117,0); }
        }

        .admin-name {
            font-family: var(--font-display);
            font-size: 0.98rem;
            font-weight: 600;
            color: #FFFFFF;
            line-height: 1.2;
            letter-spacing: -0.2px;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-top: 2px;
        }

        .admin-role-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.9px;
            text-transform: uppercase;
            color: #D3A24C;
            background: rgba(211,162,76,0.12);
            border: 1px solid rgba(211,162,76,0.25);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.06);
            transition: all 0.3s var(--ease-out);
        }
        .admin-role-pill i {
            font-size: 0.55rem;
            color: #D3A24C;
        }
        .admin-card:hover .admin-role-pill {
            background: rgba(211,162,76,0.2);
            border-color: rgba(211,162,76,0.45);
            color: #E8C277;
        }
        .admin-card:hover .admin-role-pill i { color: #E8C277; }

        /* ---- Sign Out Button ---- */
        .logout-btn {
            position: relative;
            width: 100%;
            margin-top: 0.75rem;
            padding: 0.72rem 1rem;
            border-radius: var(--r-md);
            background: linear-gradient(135deg, rgba(208,85,78,0.14), rgba(176,59,52,0.08));
            border: 1px solid rgba(208,85,78,0.25);
            color: #F1A29D;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.3s var(--ease-out);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            overflow: hidden;
            box-shadow: 0 2px 10px -4px rgba(176,59,52,0.4);
        }
        .logout-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #D0554E 0%, #B03B34 100%);
            opacity: 0;
            transition: opacity 0.3s var(--ease-out);
            z-index: 0;
        }
        .logout-btn > * { position: relative; z-index: 1; }
        .logout-btn i {
            font-size: 0.85rem;
            transition: transform 0.35s var(--ease-out);
        }
        .logout-btn:hover {
            color: #FFFFFF;
            border-color: rgba(208,85,78,0.6);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px -8px rgba(176,59,52,0.6);
        }
        .logout-btn:hover::before { opacity: 1; }
        .logout-btn:hover i { transform: translateX(4px); }
        .logout-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 10px -6px rgba(176,59,52,0.6);
        }

        /* ============================================================
           MAIN
           ============================================================ */
        .main-content {
            margin-left: 264px;
            height: 100vh;
            overflow-y: auto;
            background: var(--bg-primary);
            transition: background 0.35s var(--ease-soft);
        }
        .main-content::-webkit-scrollbar { width: 5px; }
        .main-content::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

        .top-header {
            background: var(--bg-glass);
            backdrop-filter: saturate(180%) blur(16px);
            -webkit-backdrop-filter: saturate(180%) blur(16px);
            border-bottom: 1px solid var(--border-color);
            padding: 0 1.75rem;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            gap: 1rem;
            flex-shrink: 0;
        }

        .header-left { display: flex; align-items: center; gap: 1rem; }
        .header-left h1 {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.3px;
        }

        .header-right { display: flex; align-items: center; gap: 10px; position: relative; }

        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.64rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 6px 12px;
            border-radius: 30px;
            background: rgba(22,160,117,0.1);
            color: #16805E;
            border: 1px solid rgba(22,160,117,0.18);
            transition: all 0.3s var(--ease-out);
            text-transform: uppercase;
        }
        .live-indicator .pulse {
            display: inline-block;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #16A075;
            animation: pulseDot 1.5s infinite;
            box-shadow: 0 0 0 0 rgba(22,160,117,0.5);
        }
        .live-indicator.disconnected {
            background: rgba(208,85,78,0.1);
            color: #B03B34;
            border-color: rgba(208,85,78,0.2);
        }
        .live-indicator.disconnected .pulse { background: #D0554E; animation: none; }
        .live-indicator.connecting {
            background: rgba(225,161,0,0.1);
            color: #96691F;
            border-color: rgba(225,161,0,0.2);
        }
        .live-indicator.connecting .pulse { background: #E1A100; animation: pulseDot 0.8s infinite; }

        .header-message-btn,
        .header-notif {
            width: 42px; height: 42px;
            border-radius: var(--r-md);
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            transition: all 0.2s var(--ease-out);
            position: relative;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(15,27,45,0.03);
        }
        .header-message-btn:hover,
        .header-notif:hover {
            background: var(--bg-tertiary);
            color: var(--ink-2);
            border-color: var(--ink-3);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px -8px rgba(15,27,45,0.15);
        }

        .msg-dot, .notif-dot {
            position: absolute;
            top: -5px; right: -5px;
            background: linear-gradient(135deg, #D0554E, #B03B34);
            border-radius: 30px;
            min-width: 20px;
            height: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px;
            color: #FFFFFF;
            font-weight: 700;
            padding: 0 6px;
            border: 2px solid var(--bg-glass);
            animation: pulseDot 2s infinite;
            box-shadow: 0 2px 8px rgba(208,85,78,0.4);
        }
        .notif-dot.has-messages {
            background: linear-gradient(135deg, #D3A24C, #B9862F);
            box-shadow: 0 2px 8px rgba(211,162,76,0.4);
        }

        .content-area {
            padding: 1.75rem 2rem 2.5rem;
            animation: fadeInUp 0.5s var(--ease-out);
            max-width: 1600px;
            margin: 0 auto;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .notification-dropdown {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 400px;
            max-height: 520px;
            background: var(--notification-bg);
            border-radius: var(--r-xl);
            border: 1px solid var(--border-color);
            box-shadow: var(--notification-shadow);
            overflow: hidden;
            display: none;
            z-index: 1050;
            animation: dropdownSlide 0.25s var(--ease-out);
        }
        .notification-dropdown.show { display: block !important; }
        @keyframes dropdownSlide {
            from { opacity: 0; transform: translateY(-10px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .dropdown-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center;
            background: var(--bg-tertiary);
        }
        .dropdown-header span:first-child {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-primary);
        }
        .dropdown-header .notif-total {
            background: var(--gradient-primary);
            color: #FFFFFF;
            padding: 3px 11px;
            border-radius: 30px;
            font-size: 0.68rem;
            font-weight: 700;
            font-family: var(--font-mono);
        }

        .dropdown-list { max-height: 360px; overflow-y: auto; padding: 4px 0; }
        .dropdown-list::-webkit-scrollbar { width: 4px; }
        .dropdown-list::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 20px;
            cursor: pointer;
            transition: background 0.15s var(--ease-out);
            border-bottom: 1px solid var(--border-light);
            position: relative;
        }
        .notification-item:hover { background: var(--bg-tertiary); }
        .notification-item.unread { background: rgba(74,122,181,0.04); }
        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--gradient-brass);
        }

        .notification-icon {
            width: 40px; height: 40px;
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 0.9rem;
        }
        .notification-icon.info { background: rgba(74,122,181,0.12); color: #2B5A85; }
        .notification-icon.success { background: rgba(42,112,72,0.12); color: #1E5B39; }
        .notification-icon.warning { background: rgba(225,161,0,0.14); color: #96691F; }
        .notification-icon.danger { background: rgba(208,85,78,0.12); color: #8A2A26; }
        .notification-icon.birthday { background: rgba(211,162,76,0.14); color: #96691F; }
        .notification-icon.message { background: rgba(211,162,76,0.14); color: #96691F; }

        .notification-content { flex: 1; min-width: 0; }
        .notification-title { font-size: 0.84rem; font-weight: 600; color: var(--text-primary); margin-bottom: 3px; }
        .notification-message {
            font-size: 0.78rem;
            color: var(--text-secondary);
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .notification-time {
            font-size: 0.66rem;
            color: var(--text-muted);
            margin-top: 5px;
            display: flex; align-items: center; gap: 4px;
        }

        .dropdown-footer {
            padding: 12px 20px;
            border-top: 1px solid var(--border-color);
            text-align: center;
            background: var(--bg-tertiary);
        }
        .dropdown-footer a {
            color: var(--ink-2);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: color 0.15s var(--ease-out);
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .dropdown-footer a:hover { color: var(--brass-3); }

        .dropdown-empty { padding: 48px 24px; text-align: center; color: var(--text-muted); }
        .dropdown-empty i { font-size: 2.4rem; margin-bottom: 14px; display: block; opacity: 0.35; }

        .toast-container {
            position: fixed;
            top: 86px; right: 24px;
            z-index: 9999;
            display: flex; flex-direction: column; gap: 12px;
            max-width: 400px;
        }
        .toast-notification {
            background: var(--notification-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--r-lg);
            padding: 16px 18px;
            box-shadow: var(--notification-shadow);
            display: flex; align-items: flex-start; gap: 14px;
            animation: toastSlideIn 0.4s var(--ease-out);
            transform-origin: right;
            min-width: 320px;
            border-left: 4px solid var(--ink-2);
        }
        .toast-notification.hiding { animation: toastSlideOut 0.28s var(--ease-out) forwards; }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(40px) scale(0.95); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to { opacity: 0; transform: translateX(40px) scale(0.95); }
        }
        .toast-notification.success { border-left-color: #16A075; }
        .toast-notification.error { border-left-color: #D0554E; }
        .toast-notification.warning { border-left-color: #E1A100; }
        .toast-notification.info { border-left-color: #4A7AB5; }
        .toast-notification.message { border-left-color: #D3A24C; }

        .toast-icon {
            width: 32px; height: 32px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 0.85rem;
        }
        .toast-icon.success { background: rgba(22,160,117,0.12); color: #16805E; }
        .toast-icon.error { background: rgba(208,85,78,0.12); color: #B03B34; }
        .toast-icon.warning { background: rgba(225,161,0,0.14); color: #96691F; }
        .toast-icon.info { background: rgba(74,122,181,0.12); color: #2B5A85; }
        .toast-icon.message { background: rgba(211,162,76,0.14); color: #96691F; }

        .toast-body { flex: 1; }
        .toast-title { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); }
        .toast-message { font-size: 0.76rem; color: var(--text-secondary); margin-top: 3px; }

        .toast-close {
            background: none; border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 0.85rem;
            transition: all 0.2s var(--ease-out);
        }
        .toast-close:hover { color: var(--text-primary); transform: rotate(90deg); }

        .user-dropdown-wrapper { position: relative; cursor: pointer; }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 8px;
            border-radius: var(--r-md);
            transition: all 0.2s var(--ease-out);
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(15,27,45,0.03);
        }
        .user-dropdown-toggle:hover {
            background: var(--bg-tertiary);
            border-color: var(--ink-3);
            box-shadow: 0 6px 16px -8px rgba(15,27,45,0.15);
        }

        .user-dropdown-toggle .arrow {
            margin-left: 4px;
            font-size: 0.7rem;
            color: var(--text-muted);
            transition: transform 0.25s var(--ease-out);
        }
        .user-dropdown-toggle.active .arrow { transform: rotate(180deg); }

        .header-user-info { display: flex; flex-direction: column; line-height: 1.2; }
        .header-user-name { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); }
        .header-user-role { font-size: 0.66rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.3px; font-weight: 600; }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 300px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--r-xl);
            box-shadow: var(--dropdown-shadow);
            padding: 0.5rem;
            display: none;
            z-index: 1060;
            animation: dropdownSlide 0.22s var(--ease-out);
            transform-origin: top right;
        }
        .user-dropdown-menu.show { display: block !important; }

        .dropdown-user-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem;
            border-bottom: 1px solid var(--border-light);
        }
        .dropdown-user-header .avatar-lg {
            width: 48px; height: 48px;
            border-radius: var(--r-md);
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--brass);
        }
        .dropdown-user-header .avatar-lg-initials {
            width: 48px; height: 48px;
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 1.15rem;
            color: #FFFFFF;
            flex-shrink: 0;
            border: 2px solid var(--brass);
        }
        .dropdown-user-header .user-details .name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
        }
        .dropdown-user-header .user-details .email {
            font-size: 0.75rem;
            color: var(--text-muted);
            word-break: break-all;
            margin-top: 2px;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 0.4rem 0.5rem;
        }

        .dropdown-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.65rem 0.85rem;
            border-radius: var(--r-md);
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s var(--ease-out);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .dropdown-menu-item:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }
        .dropdown-menu-item i {
            width: 20px;
            font-size: 0.9rem;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .dropdown-menu-item.danger { color: var(--danger-color); }
        .dropdown-menu-item.danger i { color: var(--danger-color); }
        .dropdown-menu-item.danger:hover { background: rgba(176,59,52,0.08); }

        .dropdown-menu-item .badge {
            margin-left: auto;
            font-size: 0.62rem;
            padding: 3px 9px;
            border-radius: 30px;
            background: var(--gradient-brass);
            color: #FFFFFF;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .modal-content {
            background: var(--modal-bg, var(--card-bg));
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--card-shadow-lg);
        }
        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            background: var(--bg-tertiary);
        }
        .modal-header h5 {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 1.05rem;
        }
        .modal-body { padding: 1.5rem; }
        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        .password-section { padding: 0; }
        .password-section h6 {
            font-weight: 600;
            margin-bottom: 1rem;
            font-family: var(--font-display);
            font-size: 1.05rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .password-section h6 i { color: var(--brass-2); }
        .password-section .form-group { margin-bottom: 1rem; }
        .password-section label {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-bottom: 5px;
            display: block;
        }

        .form-control, .form-select {
            background: var(--input-bg, var(--card-bg));
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            transition: all 0.2s var(--ease-out);
            border-radius: var(--r-md);
            padding: 0.65rem 0.95rem;
            font-size: 0.85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--ink-3);
            box-shadow: 0 0 0 4px rgba(74,122,181,0.1);
            outline: none;
        }
        .form-control::placeholder { color: var(--text-muted); }

        .btn { border-radius: var(--r-md); font-weight: 600; font-size: 0.85rem; padding: 0.55rem 1.25rem; }
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            box-shadow: 0 4px 12px -2px rgba(15,27,45,0.2);
        }
        .btn-primary:hover {
            background: var(--ink-2);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px -4px rgba(15,27,45,0.3);
        }

        .alert {
            padding: 0.95rem 1.15rem;
            border-radius: var(--r-md);
            margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 10px;
            border: none;
            font-weight: 500;
            font-size: 0.83rem;
            animation: slideDown 0.35s var(--ease-out);
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success { background: rgba(22,160,117,0.1); color: #16805E; border-left: 3px solid #16A075; }
        .alert-danger  { background: rgba(208,85,78,0.1);  color: #B03B34; border-left: 3px solid #D0554E; }
        .alert-warning { background: rgba(225,161,0,0.1); color: #96691F; border-left: 3px solid #E1A100; }
        .alert-info    { background: rgba(74,122,181,0.1); color: #2B5A85; border-left: 3px solid #4A7AB5; }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--r-xl);
            box-shadow: var(--card-shadow);
            transition: all 0.3s var(--ease-out);
            color: var(--text-primary);
        }
        .card:hover {
            box-shadow: var(--card-shadow-lg);
            transform: translateY(-3px);
        }

        .table { color: var(--text-primary); }
        .table thead th {
            border-bottom: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 0.9rem 1rem;
        }
        .table td, .table th {
            border-color: var(--border-light);
            padding: 0.9rem 1rem;
            vertical-align: middle;
        }
        .table-striped > tbody > tr:nth-of-type(odd) { background: rgba(0,0,0,0.012); }

        .logo-toast {
            position: fixed;
            bottom: 28px; right: 28px;
            background: var(--card-bg);
            color: var(--text-primary);
            padding: 15px 24px;
            border-radius: var(--r-lg);
            font-size: 0.82rem;
            font-weight: 500;
            display: flex; align-items: center; gap: 12px;
            box-shadow: var(--card-shadow-lg);
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s var(--ease-out);
            border: 1px solid var(--border-color);
        }
        .logo-toast.show { transform: translateY(0); opacity: 1; }
        .logo-toast.success { border-left: 3px solid #16A075; }
        .logo-toast.error { border-left: 3px solid #D0554E; }

        .profile-picture-wrapper { position: relative; display: inline-block; cursor: pointer; }
        .profile-picture-wrapper .upload-overlay {
            position: absolute; bottom: 0; right: 0;
            background: var(--ink-2);
            border-radius: 50%;
            width: 42px; height: 42px;
            display: flex; align-items: center; justify-content: center;
            color: #FFFFFF;
            border: 3px solid var(--card-bg);
            transition: all 0.25s var(--ease-out);
        }
        .profile-picture-wrapper .upload-overlay:hover { transform: scale(1.08); background: var(--ink); }

        .profile-picture-preview {
            width: 150px; height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--brass);
            transition: all 0.25s var(--ease-out);
        }
        .profile-picture-placeholder {
            width: 150px; height: 150px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: #FFFFFF;
            border: 4px solid var(--brass);
        }

        .header-profile-img { width: 34px; height: 34px; border-radius: 10px; object-fit: cover; }
        .header-profile-initials {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
            color: #FFFFFF;
        }

        .updated { animation: updatedPulse 0.6s var(--ease-out); }
        @keyframes updatedPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.06); background: rgba(22,160,117,0.15); }
            100% { transform: scale(1); }
        }

        .new-item { animation: highlightNew 2s var(--ease-out); }
        @keyframes highlightNew {
            0% { background: rgba(74,122,181,0.15); }
            100% { background: transparent; }
        }

        @media (max-width: 1024px) {
            .sidebar-container { width: 224px; }
            .main-content { margin-left: 224px; }
        }
        @media (max-width: 768px) {
            .sidebar-container { transform: translateX(-100%); width: 280px; z-index: 1050; }
            .sidebar-container.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .content-area { padding: 1.1rem; }
            .top-header { padding: 0 1rem; height: 62px; }
            .header-user-info { display: none; }
            .header-left h1 { font-size: 1.05rem; }
            .logo-toast { bottom: 84px; right: 16px; left: 16px; }
            .notification-dropdown { width: calc(100vw - 32px); right: -16px; }
            .toast-container { max-width: calc(100vw - 32px); right: 16px; }
            .live-indicator span:not(.pulse) { display: none; }
            .live-indicator { padding: 6px; }
            .user-dropdown-menu { min-width: 280px; right: -10px; }
        }
    </style>
    @stack('styles')
</head>

<body>
@php
    $churchSettings = \App\Models\ChurchSetting::current();
    $user = Auth::user();
    $churchName = $user?->church?->name ?? $churchSettings?->church_name ?? 'Church Management';
    $tagline = $churchSettings->tagline ?? 'Church Management System';

    $unreadMsgCount = 0;
    if ($user && $user->church_id) {
        try {
            if (class_exists('App\Models\Message')) {
                $unreadMsgCount = \App\Models\Message::where('receiver_church_id', $user->church_id)
                    ->where('is_read', false)
                    ->count();
            }
        } catch (\Exception $e) {
            $unreadMsgCount = 0;
        }
    }

    $totalMemberCount = 0;
    if ($user && $user->church_id) {
        try {
            if (class_exists('App\Models\Member')) {
                $totalMemberCount = \App\Models\Member::where('church_id', $user->church_id)->count();
            }
        } catch (\Exception $e) {
            $totalMemberCount = 0;
        }
    }

    $choirCount = 0;
    if ($user && $user->church_id) {
        try {
            if (class_exists('App\Models\Member')) {
                $choirCount = \App\Models\Member::where('church_id', $user->church_id)
                    ->where('is_choir', true)
                    ->count();
            }
        } catch (\Exception $e) {
            $choirCount = 0;
        }
    }
@endphp

    <div class="animated-bg">
        <div class="circle c1"></div>
        <div class="circle c2"></div>
        <div class="circle c3"></div>
        <div class="circle c4"></div>
        <div class="circle c5"></div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <input type="file" id="logoFileInput" accept="image/*" style="display:none;">

    <div class="logo-toast" id="logoToast">
        <i class="fas fa-circle-check" id="logoToastIcon"></i>
        <span id="logoToastMsg">Logo updated!</span>
    </div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar-container" id="sidebar">
        <div class="logo-section">
            <div class="logo-wrapper">
                <div class="logo-upload-trigger" id="logoTrigger" title="Click to change logo">
                    @if($churchSettings && $churchSettings->logoUrl())
                        <img src="{{ $churchSettings->logoUrl() }}" alt="{{ $churchName }}" class="logo-img" id="logoImg">
                    @else
                        <div class="logo-icon-fallback" id="logoImg">
                            <i class="fas fa-church"></i>
                        </div>
                    @endif
                </div>
                <div class="logo-text">
                    <h2>{{ $churchName }}</h2>
                    <p>{{ $tagline }}</p>
                </div>
            </div>
        </div>

        <div class="nav-menu-wrap">
            <nav class="nav-menu">
                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-th-large"></i> Main</div>

                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('Dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                    </a>

                    <a href="{{ route('members.index') }}" class="nav-item {{ request()->routeIs('Members.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> <span>Members</span>
                    </a>

                    <a href="{{ route('finance.index') }}" class="nav-item {{ request()->routeIs('Finance.*') ? 'active' : '' }}">
                        <i class="fas fa-coins"></i> <span>Finance</span>
                        <span class="nav-badge finance"><i class="fas fa-arrow-trend-up"></i></span>
                    </a>

                    <a href="{{ route('sunday-attendance.index') }}" class="nav-item {{ request()->routeIs('Sunday Attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-church"></i> <span>Sunday Attendance</span>
                    </a>

                    <a href="{{ route('inventory.index') }}" class="nav-item {{ request()->routeIs('Inventory.*') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i> <span>Inventory</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-comment-dots"></i> Communication</div>

                    <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('Messages.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i> <span>Messages</span>
                        @if($unreadMsgCount > 0)
                            <span class="nav-badge message-badge">{{ $unreadMsgCount > 99 ? '99+' : $unreadMsgCount }}</span>
                        @endif
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-music"></i> Choir Ministry</div>

                    <a href="{{ route('choir-members.index') }}" class="nav-item {{ request()->routeIs('Choir Members.*') ? 'active' : '' }}">
                        <i class="fas fa-music"></i> <span>Choir Members</span>
                        @if($choirCount > 0)
                            <span class="nav-badge">{{ $choirCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('choir-schedules.index') }}" class="nav-item {{ request()->routeIs('choir-schedules.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> <span>Schedules</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-chart-line"></i> Reports</div>

                    <a href="{{ route('reports.analytics') }}" class="nav-item {{ request()->routeIs('reports.analytics') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> <span>Reports & Analytics</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- ===== CHURCH ADMIN SECTION ===== -->
        <div class="user-section">
            <div class="admin-card">
                <div class="admin-avatar-wrap" id="sidebar-avatar-wrap">
                    @if($user && $user->profile_picture)
                        {{-- ✅ Profile image with data attribute for JS targeting --}}
                        <img src="{{ $user->profile_picture_url }}"
                             alt="{{ $user->name }}"
                             class="admin-avatar-img"
                             data-profile-image="sidebar"
                             onerror="handleProfileImageError(this, 'sidebar');">
                        {{-- ✅ Hidden fallback initials (shown only if image fails) --}}
                        <div class="admin-avatar-initials"
                             data-profile-initials="sidebar"
                             style="background: linear-gradient(135deg, #D3A24C, #B9862F); display: none;">
                            {{ $user?->initials ?? 'A' }}
                        </div>
                    @else
                        {{-- ✅ No picture: show initials directly --}}
                        <div class="admin-avatar-initials"
                             data-profile-initials="sidebar"
                             style="background: linear-gradient(135deg, #D3A24C, #B9862F);">
                            {{ $user?->initials ?? 'A' }}
                        </div>
                    @endif
                    <span class="admin-status-dot"></span>
                </div>

                <div class="admin-name">{{ $user->name ?? 'Administrator' }}</div>

                <span class="admin-role-pill">
                    <i class="fas fa-crown"></i>
                    {{ ucwords(str_replace('_', ' ', $user->role ?? 'church admin')) }}
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <header class="top-header">
            <div class="header-left">
                <h1>@yield('header', 'Dashboard')</h1>
            </div>

            <div class="header-right">
                <div class="live-indicator connected" id="liveIndicator">
                    <span class="pulse"></span>
                    <span>Live</span>
                </div>

                <a href="{{ route('messages.index') }}" class="header-message-btn" title="Messages">
                    <i class="fas fa-envelope"></i>
                    @if($unreadMsgCount > 0)
                        <span class="msg-dot">{{ $unreadMsgCount > 99 ? '99+' : $unreadMsgCount }}</span>
                    @endif
                </a>

                <div style="position: relative;">
                    <button class="header-notif" id="notificationBell" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notif-dot {{ $unreadMsgCount > 0 ? 'has-messages' : '' }}" id="notifCount" style="{{ $unreadMsgCount > 0 ? 'display: flex;' : 'display: none;' }}">
                            {{ $unreadMsgCount > 0 ? ($unreadMsgCount > 99 ? '99+' : $unreadMsgCount) : '0' }}
                        </span>
                    </button>

                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="dropdown-header">
                            <span>Notifications</span>
                            <span class="notif-total" id="notifTotalCount">{{ $unreadMsgCount }}</span>
                        </div>
                        <div class="dropdown-list" id="notificationList">
                            <div class="dropdown-empty">
                                <i class="fas fa-bell-slash"></i>
                                <span>No notifications</span>
                            </div>
                        </div>
                        <div class="dropdown-footer">
                            <a href="{{ route('messages.index') }}">
                                <i class="fas fa-envelope"></i> <span>Go to Messages</span>
                                @if($unreadMsgCount > 0)
                                    <span class="msg-count-badge">{{ $unreadMsgCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <div class="user-dropdown-wrapper" id="userDropdownWrapper">
                    <div class="user-dropdown-toggle" id="userDropdownToggle">
                        @if($user && $user->profile_picture)
                            <img src="{{ $user->profile_picture_url }}"
                                 alt="{{ $user->name }}"
                                 class="header-profile-img"
                                 data-profile-image="header"
                                 onerror="handleProfileImageError(this, 'header');">
                            <div class="header-profile-initials"
                                 data-profile-initials="header"
                                 style="background: linear-gradient(135deg, {{ $user?->avatar_color ?? '#132D4D' }}, #0B1E36); display: none;">
                                {{ $user?->initials ?? 'A' }}
                            </div>
                        @else
                            <div class="header-profile-initials"
                                 data-profile-initials="header"
                                 style="background: linear-gradient(135deg, {{ $user?->avatar_color ?? '#132D4D' }}, #0B1E36);">
                                {{ $user?->initials ?? 'A' }}
                            </div>
                        @endif
                        <div class="header-user-info">
                            <span class="header-user-name">{{ $user->name ?? 'Administrator' }}</span>
                            <span class="header-user-role">{{ $user->role ?? 'church_admin' }}</span>
                        </div>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>

                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="dropdown-user-header">
                            @if($user && $user->profile_picture)
                                <img src="{{ $user->profile_picture_url }}"
                                     alt="{{ $user->name }}"
                                     class="avatar-lg"
                                     data-profile-image="dropdown"
                                     onerror="handleProfileImageError(this, 'dropdown');">
                                <div class="avatar-lg-initials"
                                     data-profile-initials="dropdown"
                                     style="background: linear-gradient(135deg, {{ $user?->avatar_color ?? '#132D4D' }}, #0B1E36); display: none;">
                                    {{ $user?->initials ?? 'A' }}
                                </div>
                            @else
                                <div class="avatar-lg-initials"
                                     data-profile-initials="dropdown"
                                     style="background: linear-gradient(135deg, {{ $user?->avatar_color ?? '#132D4D' }}, #0B1E36);">
                                    {{ $user?->initials ?? 'A' }}
                                </div>
                            @endif
                            <div class="user-details">
                                <div class="name">{{ $user->name ?? 'Administrator' }}</div>
                                <div class="email">{{ $user->email ?? 'admin@church.com' }}</div>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="dropdown-menu-item">
                            <i class="fas fa-user-cog"></i>
                            <span>My Profile</span>
                        </a>

                        <button class="dropdown-menu-item" id="securitySettingsBtn">
                            <i class="fas fa-shield-alt"></i>
                            <span>Security</span>
                            <span class="badge">Secure</span>
                        </button>

                        <div class="dropdown-divider"></div>

                        <button class="dropdown-menu-item danger" onclick="document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sign Out</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- ===== SECURITY MODAL — PASSWORD ONLY ===== -->
    <div class="modal fade security-settings-modal" id="securitySettingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-shield-alt me-2" style="color: var(--brass-2);"></i>
                        <span>Security</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="password-section">
                        <h6><i class="fas fa-key"></i> Change Password</h6>
                        <form id="passwordChangeForm">
                            @csrf
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" class="form-control" id="currentPassword" required placeholder="Enter current password">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" id="newPassword" required minlength="8" placeholder="Enter new password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" required placeholder="Confirm new password">
                            </div>
                            <div id="passwordStrength" class="mt-2" style="font-size:0.8rem;color:var(--text-muted);">
                                <span>Password Strength:</span>
                                <span id="strengthText">Weak</span>
                                <div class="progress mt-1" style="height:4px;border-radius:10px;background:var(--border-light);">
                                    <div id="strengthBar" class="progress-bar" style="width:0%;background:#B03B34;border-radius:10px;" role="progressbar"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveSecuritySettings">Update Password</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- SCRIPTS -->
    <!-- ============================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.0.2/dist/web/pusher.min.js"></script>

    <script>
        // ============================================
        // PROFILE IMAGE HELPERS (NEW)
        // ============================================

        /**
         * Handle broken profile images — swap to initials fallback.
         */
        function handleProfileImageError(imgEl, key) {
            if (!imgEl) return;
            imgEl.style.display = 'none';
            const fallback = document.querySelector(`[data-profile-initials="${key}"]`);
            if (fallback) {
                fallback.style.display = 'flex';
            }
        }
        window.handleProfileImageError = handleProfileImageError;

        /**
         * Update ALL profile images across the layout.
         * Called after successful AJAX upload on the profile page.
         *
         * @param {string} url - The new profile picture URL (with cache-buster)
         */
        function updateProfileImages(url) {
            if (!url) return;

            // Update every [data-profile-image] element
            document.querySelectorAll('[data-profile-image]').forEach(img => {
                img.classList.add('is-loading');

                // Preload to avoid flicker
                const preload = new Image();
                preload.onload = () => {
                    img.src = url;
                    img.style.display = ''; // show image
                    img.classList.remove('is-loading');

                    // Hide the corresponding initials fallback
                    const key = img.getAttribute('data-profile-image');
                    const fallback = document.querySelector(`[data-profile-initials="${key}"]`);
                    if (fallback) fallback.style.display = 'none';
                };
                preload.onerror = () => {
                    img.classList.remove('is-loading');
                    handleProfileImageError(img, img.getAttribute('data-profile-image'));
                };
                preload.src = url;
            });
        }
        window.updateProfileImages = updateProfileImages;

        /**
         * Remove profile images and show initials (after delete).
         */
        function removeProfileImages() {
            document.querySelectorAll('[data-profile-image]').forEach(img => {
                img.style.display = 'none';
                const key = img.getAttribute('data-profile-image');
                const fallback = document.querySelector(`[data-profile-initials="${key}"]`);
                if (fallback) fallback.style.display = 'flex';
            });
        }
        window.removeProfileImages = removeProfileImages;

        // ============================================
        // USER DROPDOWN
        // ============================================
        const dropdownToggle = document.getElementById('userDropdownToggle');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.toggle('active');
                dropdownMenu.classList.toggle('show');
            });
            document.addEventListener('click', function(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownToggle.classList.remove('active');
                    dropdownMenu.classList.remove('show');
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    dropdownToggle.classList.remove('active');
                    dropdownMenu.classList.remove('show');
                }
            });
        }

        // ============================================
        // SECURITY MODAL (Password only)
        // ============================================
        const securityModal = new bootstrap.Modal(document.getElementById('securitySettingsModal'));
        document.getElementById('securitySettingsBtn')?.addEventListener('click', function() {
            securityModal.show();
            if (dropdownToggle && dropdownMenu) {
                dropdownToggle.classList.remove('active');
                dropdownMenu.classList.remove('show');
            }
        });

        const newPassword = document.getElementById('newPassword');
        const strengthText = document.getElementById('strengthText');
        const strengthBar = document.getElementById('strengthBar');

        if (newPassword) {
            newPassword.addEventListener('input', function() {
                const password = this.value;
                let strength = 0, level = 'Weak', color = '#B03B34', width = 0;
                if (password.length >= 8) strength += 1;
                if (password.match(/[a-z]/)) strength += 1;
                if (password.match(/[A-Z]/)) strength += 1;
                if (password.match(/[0-9]/)) strength += 1;
                if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
                if (strength <= 2) { level = 'Weak'; color = '#B03B34'; width = 20; }
                else if (strength <= 3) { level = 'Medium'; color = '#F5A623'; width = 60; }
                else { level = 'Strong'; color = '#2A7048'; width = 100; }
                strengthText.textContent = level;
                strengthText.style.color = color;
                strengthBar.style.width = width + '%';
                strengthBar.style.background = color;
            });
        }

        document.getElementById('saveSecuritySettings')?.addEventListener('click', function() {
            const currentPw = document.getElementById('currentPassword')?.value;
            const newPw = document.getElementById('newPassword')?.value;
            const confirmPw = document.getElementById('confirmPassword')?.value;

            if (newPw && currentPw) {
                if (newPw !== confirmPw) { showToastNotification('error', 'Error', 'Passwords do not match'); return; }
                if (newPw.length < 8) { showToastNotification('error', 'Error', 'Password must be at least 8 characters'); return; }

                fetch('{{ route("settings.password") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ current_password: currentPw, new_password: newPw, new_password_confirmation: confirmPw })
                }).then(r => r.json()).then(d => {
                    if (d.success) {
                        showToastNotification('success', 'Security', 'Password updated successfully');
                        document.getElementById('currentPassword').value = '';
                        document.getElementById('newPassword').value = '';
                        document.getElementById('confirmPassword').value = '';
                        securityModal.hide();
                    } else {
                        showToastNotification('error', 'Error', d.message || 'Failed to update password');
                    }
                }).catch(() => showToastNotification('error', 'Error', 'Something went wrong'));
            } else {
                securityModal.hide();
            }
        });

        // ============================================
        // TOAST
        // ============================================
        const toastContainer = document.getElementById('toastContainer');

        function showToastNotification(type, title, message, duration = 5000) {
            if (!toastContainer) return;
            const icons = { success: 'fa-check-circle', error: 'fa-times-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle', message: 'fa-envelope' };
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            toast.innerHTML = `
                <div class="toast-icon ${type}"><i class="fas ${icons[type] || 'fa-bell'}"></i></div>
                <div class="toast-body">
                    <div class="toast-title">${escapeHtml(title)}</div>
                    <div class="toast-message">${escapeHtml(message)}</div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-notification').remove()"><i class="fas fa-times"></i></button>
            `;
            toastContainer.appendChild(toast);
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.add('hiding');
                    setTimeout(() => toast.remove(), 300);
                }
            }, duration);
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text || '';
            return div.innerHTML;
        }

        window.showToastNotification = showToastNotification;

        // ============================================
        // AUTO-HIDE ALERTS
        // ============================================
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // ============================================
        // LOGO UPLOAD
        // ============================================
        const logoTrigger = document.getElementById('logoTrigger');
        const logoFileInput = document.getElementById('logoFileInput');
        const logoToast = document.getElementById('logoToast');
        const logoToastMsg = document.getElementById('logoToastMsg');

        if (logoTrigger) logoTrigger.addEventListener('click', () => logoFileInput.click());

        if (logoFileInput) {
            logoFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                const formData = new FormData();
                formData.append('logo', file);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('{{ route("settings.logo.update") }}', { method: 'POST', body: formData })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const wrap = document.getElementById('logoImg');
                        if (wrap.tagName === 'IMG') {
                            wrap.src = data.logo_url + '?t=' + Date.now();
                        } else {
                            const img = document.createElement('img');
                            img.src = data.logo_url + '?t=' + Date.now();
                            img.className = 'logo-img';
                            img.id = 'logoImg';
                            img.alt = 'Logo';
                            wrap.replaceWith(img);
                        }
                        showLogoToast('success', '<i class="fas fa-check-circle"></i>', 'Logo updated successfully!');
                    } else {
                        showLogoToast('error', '<i class="fas fa-times-circle"></i>', data.message || 'Upload failed.');
                    }
                })
                .catch(() => showLogoToast('error', '<i class="fas fa-times-circle"></i>', 'Something went wrong.'));
                this.value = '';
            });
        }

        function showLogoToast(type, iconHtml, message) {
            logoToast.className = 'logo-toast ' + type;
            document.getElementById('logoToastIcon').outerHTML = '<span id="logoToastIcon">' + iconHtml + '</span>';
            logoToastMsg.textContent = message;
            logoToast.classList.add('show');
            setTimeout(() => logoToast.classList.remove('show'), 3500);
        }

        // ============================================
        // MOBILE SIDEBAR TOGGLE
        // ============================================
        if (window.innerWidth <= 768) {
            const sidebar = document.getElementById('sidebar');
            const headerLeft = document.querySelector('.header-left');
            const toggleBtn = document.createElement('button');
            toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            toggleBtn.style.cssText = 'background:var(--card-bg);border:1px solid var(--border-color);border-radius:10px;width:40px;height:40px;display:flex;align-items:center;justify-content:center;color:var(--text-primary);margin-right:0.5rem;cursor:pointer;font-size:1rem;';
            toggleBtn.onclick = () => sidebar.classList.toggle('mobile-open');
            if (headerLeft) headerLeft.prepend(toggleBtn);
        }

        // ============================================
        // NOTIFICATION MANAGER
        // ============================================
        class NotificationManager {
            constructor() {
                this.bell = document.getElementById('notificationBell');
                this.dropdown = document.getElementById('notificationDropdown');
                this.isOpen = false;
                this.setupEventListeners();
            }
            setupEventListeners() {
                if (this.bell) {
                    this.bell.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.toggleDropdown();
                    });
                }
                document.addEventListener('click', (e) => {
                    if (this.dropdown && !this.dropdown.contains(e.target) && !this.bell.contains(e.target)) {
                        this.closeDropdown();
                    }
                });
            }
            toggleDropdown() { this.isOpen ? this.closeDropdown() : this.openDropdown(); }
            openDropdown() {
                if (!this.dropdown) return;
                this.dropdown.classList.add('show');
                this.isOpen = true;
            }
            closeDropdown() {
                if (!this.dropdown) return;
                this.dropdown.classList.remove('show');
                this.isOpen = false;
            }
        }

        // ============================================
        // REVERB (safe init)
        // ============================================
        if (typeof Pusher !== 'undefined' && typeof Echo !== 'undefined') {
            window.Pusher = Pusher;
            try {
                window.Echo = new Echo({
                    broadcaster: 'reverb',
                    key: '{{ env("REVERB_APP_KEY") }}',
                    wsHost: '{{ env("REVERB_HOST", "127.0.0.1") }}',
                    wsPort: {{ env("REVERB_PORT", 8080) }},
                    wssPort: {{ env("REVERB_PORT", 8080) }},
                    forceTLS: false,
                    enabledTransports: ['ws', 'wss'],
                });
                const liveIndicator = document.getElementById('liveIndicator');
                function updateConnectionStatus(status) {
                    if (!liveIndicator) return;
                    liveIndicator.classList.remove('connected', 'disconnected', 'connecting');
                    if (status === 'connected') {
                        liveIndicator.classList.add('connected');
                        liveIndicator.innerHTML = '<span class="pulse"></span><span>Live</span>';
                    } else if (status === 'connecting') {
                        liveIndicator.classList.add('connecting');
                        liveIndicator.innerHTML = '<span class="pulse"></span><span>Connecting...</span>';
                    } else {
                        liveIndicator.classList.add('disconnected');
                        liveIndicator.innerHTML = '<span class="pulse"></span><span>Offline</span>';
                    }
                }
                updateConnectionStatus('connecting');
                if (window.Echo.connector && window.Echo.connector.socket) {
                    window.Echo.connector.socket.on('connect', () => updateConnectionStatus('connected'));
                    window.Echo.connector.socket.on('disconnect', () => updateConnectionStatus('disconnected'));
                }
            } catch (e) {
                console.log('Reverb init skipped:', e.message);
            }
        }

        // ============================================
        // INIT
        // ============================================
        document.addEventListener('DOMContentLoaded', () => {
            new NotificationManager();
        });
    </script>

    @stack('scripts')
</body>
</html>