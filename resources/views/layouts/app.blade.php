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
        /* ===== ALL YOUR EXISTING STYLES ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-primary: #F5F6F8;
            --bg-secondary: #ffffff;
            --bg-tertiary: #F0F2F5;
            --text-primary: #16202E;
            --text-secondary: #57616F;
            --text-muted: #98A2B3;
            --border-color: #E4E7EC;
            --card-bg: #ffffff;
            --card-shadow: 0 1px 2px rgba(16,24,39,0.04), 0 1px 3px rgba(16,24,39,0.05);
            --card-hover-shadow: 0 16px 32px -12px rgba(16,24,39,0.14);
            --sidebar-bg: #ffffff;
            --sidebar-text: #57616F;
            --sidebar-text-muted: #98A2B3;
            --sidebar-hover: rgba(19,45,77,0.05);
            --sidebar-active-bg: rgba(19,45,77,0.07);
            --sidebar-border: #E4E7EC;
            --user-section-bg: #F8F9FB;
            --input-bg: #ffffff;
            --input-border: #DDE1E7;
            --modal-bg: #ffffff;
            --header-bg: #ffffff;
            --header-border: #E4E7EC;
            --header-shadow: 0 1px 2px rgba(16,24,39,0.04);
            --alert-success-bg: #EEF6F0;
            --alert-success-text: #1E5B39;
            --alert-danger-bg: #FBEEEE;
            --alert-danger-text: #8A2A26;
            --alert-warning-bg: #FBF3E4;
            --alert-warning-text: #7A5411;
            --alert-info-bg: #EAF1F8;
            --alert-info-text: #1E4566;
            --hover-bg: #F0F2F5;
            --ink: #132D4D;
            --ink-deep: #0B1E36;
            --brass: #B9862F;
            --brass-deep: #96691F;
            --gradient-primary: linear-gradient(135deg, #16324F 0%, #0B1E36 100%);
            --gradient-brass: linear-gradient(135deg, #D3A24C 0%, #B9862F 100%);
            --gradient-success: linear-gradient(135deg, #3E9463 0%, #2A7048 100%);
            --gradient-danger: linear-gradient(135deg, #D0554E 0%, #B03B34 100%);
            --gradient-info: linear-gradient(135deg, #3D74A6 0%, #2B5A85 100%);
            --notification-bg: #ffffff;
            --notification-shadow: 0 20px 48px -16px rgba(16,24,39,0.22);
            --finance-income: #2A7048;
            --finance-expense: #B03B34;
            --finance-balance: #132D4D;
            --font-display: 'Fraunces', Georgia, serif;
            --font-body: 'Inter', -apple-system, BlinkMacSystemFont, system-ui, sans-serif;
            --font-mono: 'IBM Plex Mono', ui-monospace, monospace;
            
            --dropdown-shadow: 0 20px 48px -12px rgba(16,24,39,0.22);
            --danger-color: #B03B34;
            --danger-hover: #8A2A26;
            --success-color: #2A7048;
        }

        [data-theme="dark"] {
            --bg-primary: #0D1520;
            --bg-secondary: #141E2C;
            --bg-tertiary: #101927;
            --text-primary: #EDEFF3;
            --text-secondary: #99A3B3;
            --text-muted: #5E6879;
            --border-color: #253247;
            --card-bg: #141E2C;
            --card-shadow: 0 1px 2px rgba(0,0,0,0.3);
            --card-hover-shadow: 0 16px 36px -12px rgba(0,0,0,0.5);
            --sidebar-bg: #0F1826;
            --sidebar-text: #99A3B3;
            --sidebar-text-muted: #556074;
            --sidebar-hover: rgba(201,153,66,0.10);
            --sidebar-active-bg: rgba(201,153,66,0.14);
            --sidebar-border: rgba(255,255,255,0.06);
            --user-section-bg: #0B1320;
            --input-bg: #101927;
            --input-border: #253247;
            --modal-bg: #141E2C;
            --header-bg: #141E2C;
            --header-border: #253247;
            --header-shadow: 0 1px 2px rgba(0,0,0,0.3);
            --alert-success-bg: #12281C;
            --alert-success-text: #86D3A4;
            --alert-danger-bg: #2E1616;
            --alert-danger-text: #E39B96;
            --alert-warning-bg: #2C2210;
            --alert-warning-text: #E6C077;
            --alert-info-bg: #12233A;
            --alert-info-text: #93C0E6;
            --hover-bg: #1B2635;
            --notification-bg: #141E2C;
            --notification-shadow: 0 20px 48px -16px rgba(0,0,0,0.6);
            --finance-income: #5FC189;
            --finance-expense: #E38680;
            --finance-balance: #9FB6D6;
            --brass: #D3A24C;
            --brass-deep: #E6C077;
            --dropdown-shadow: 0 20px 48px -12px rgba(0,0,0,0.6);
        }

        body {
            font-family: var(--font-body);
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow: hidden;
            height: 100vh;
            transition: background 0.4s ease, color 0.4s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-size: 15px;
        }

        .animated-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: -1;
            opacity: 0.5;
            pointer-events: none;
        }
        .animated-bg .circle {
            position: absolute;
            border-radius: 50%;
            background: var(--gradient-primary);
            animation: float 26s infinite ease-in-out;
            opacity: 0.05;
        }
        .animated-bg .circle.accent {
            background: var(--gradient-brass);
            opacity: 0.06;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -30px) scale(1.08); }
            50% { transform: translate(-30px, 45px) scale(0.94); }
            75% { transform: translate(40px, 35px) scale(1.03); }
        }

        .sidebar-container {
            position: fixed;
            left: 0; top: 0;
            height: 100vh;
            width: 264px;
            background: var(--sidebar-bg);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--sidebar-border);
        }

        .logo-section {
            padding: 1.5rem 1.25rem 1.35rem;
            border-bottom: 1px solid var(--sidebar-border);
            flex-shrink: 0;
            background: var(--sidebar-bg);
            z-index: 2;
        }
        .logo-wrapper { display: flex; align-items: center; gap: 13px; }

        .logo-upload-trigger {
            position: relative;
            width: 46px; height: 46px;
            flex-shrink: 0;
            cursor: pointer;
        }
        .logo-img {
            width: 46px; height: 46px;
            border-radius: 50% 50% 10px 10px;
            object-fit: cover;
            box-shadow: 0 3px 10px rgba(11,30,54,0.18);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            display: block;
        }
        .logo-icon-fallback {
            width: 46px; height: 46px;
            border-radius: 50% 50% 10px 10px;
            background: var(--gradient-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            color: var(--brass-deep);
            box-shadow: 0 3px 12px rgba(11,30,54,0.28);
            transition: all 0.3s ease;
            position: relative;
        }
        .logo-icon-fallback::after {
            content: '';
            position: absolute;
            top: 8px; left: 50%;
            width: 3px; height: 14px;
            background: rgba(201,153,66,0.5);
            transform: translateX(-50%);
        }

        .logo-text h2 {
            font-family: var(--font-display);
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.2px;
            line-height: 1.2;
        }
        .logo-text p {
            font-size: 0.66rem;
            color: var(--text-muted);
            margin: 2px 0 0;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            font-weight: 600;
        }

        .nav-menu-wrap {
            flex: 1;
            overflow: hidden;
            position: relative;
        }
        .nav-menu {
            height: 100%;
            padding: 1rem 0.85rem;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: var(--border-color) transparent;
        }
        .nav-menu::-webkit-scrollbar { width: 3px; }
        .nav-menu::-webkit-scrollbar-track { background: transparent; }
        .nav-menu::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

        .nav-section { margin-bottom: 1.35rem; }

        .nav-section-title {
            font-size: 0.62rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding: 0.3rem 0.75rem 0.55rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.62rem 0.85rem;
            margin: 2px 0;
            border-radius: 9px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.18s ease;
            font-weight: 500;
            font-size: 0.84rem;
            position: relative;
        }
        .nav-item i {
            width: 20px;
            font-size: 0.92rem;
            text-align: center;
            color: var(--text-muted);
            transition: all 0.18s ease;
            flex-shrink: 0;
        }
        .nav-item:hover { background: var(--sidebar-hover); color: var(--ink); }
        [data-theme="dark"] .nav-item:hover { color: var(--brass); }
        .nav-item:hover i { color: var(--ink); }
        [data-theme="dark"] .nav-item:hover i { color: var(--brass); }

        .nav-item.active {
            background: var(--sidebar-active-bg);
            color: var(--ink);
            font-weight: 600;
        }
        [data-theme="dark"] .nav-item.active { color: var(--brass); }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -0.85rem;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            border-radius: 0 4px 4px 0;
            background: var(--brass);
        }
        .nav-item.active i { color: var(--brass-deep); }

        .nav-badge {
            margin-left: auto;
            background: var(--sidebar-active-bg);
            padding: 1px 8px;
            border-radius: 6px;
            font-size: 0.62rem;
            color: var(--ink);
            font-weight: 700;
            font-family: var(--font-mono);
        }
        [data-theme="dark"] .nav-badge { color: var(--brass); }

        .nav-badge.finance {
            background: rgba(42,112,72,0.12);
            color: var(--finance-income);
        }

        .nav-badge.message-badge {
            background: #B03B34;
            color: white;
            padding: 0px 7px;
            border-radius: 6px;
            font-size: 0.62rem;
            font-weight: 700;
            font-family: var(--font-mono);
            animation: pulse-dot 2s infinite;
        }

        .user-section {
            flex-shrink: 0;
            background: var(--user-section-bg);
            border-top: 1px solid var(--sidebar-border);
            padding: 0.85rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.4rem 0.5rem;
            border-radius: 9px;
            margin-bottom: 0.5rem;
        }
        .user-avatar-sm {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.72rem;
            flex-shrink: 0;
        }
        .user-avatar-img {
            width: 36px; height: 36px;
            border-radius: 9px;
            object-fit: cover;
            border: 2px solid var(--brass);
            flex-shrink: 0;
        }
        .user-name { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
        .user-role { font-size: 0.62rem; color: var(--text-muted); }

        .logout-btn {
            width: 100%;
            padding: 0.52rem;
            border-radius: 9px;
            background: rgba(176,59,52,0.06);
            border: 1px solid rgba(176,59,52,0.14);
            color: #B03B34;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .logout-btn:hover { background: rgba(176,59,52,0.12); transform: translateY(-1px); }

        .main-content {
            margin-left: 264px;
            height: 100vh;
            overflow-y: auto;
            background: var(--bg-primary);
            transition: background 0.4s ease;
        }
        .main-content::-webkit-scrollbar { width: 4px; }
        .main-content::-webkit-scrollbar-track { background: transparent; }
        .main-content::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

        .top-header {
            background: var(--header-bg);
            border-bottom: 1px solid var(--header-border);
            box-shadow: var(--header-shadow);
            padding: 0 1.5rem;
            height: 66px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            transition: all 0.3s ease;
            gap: 1rem;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.9);
            flex-shrink: 0;
        }
        [data-theme="dark"] .top-header { background: rgba(20,30,44,0.9); }

        .header-left { display: flex; align-items: center; gap: 1rem; }
        .header-left h1 {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }
        .header-breadcrumb {
            font-size: 0.74rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .header-right { display: flex; align-items: center; gap: 10px; position: relative; }

        .content-area {
            padding: 1.5rem 2rem 2rem;
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.64rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            padding: 5px 11px;
            border-radius: 7px;
            background: rgba(42,112,72,0.09);
            color: #1E5B39;
            border: 1px solid rgba(42,112,72,0.18);
            transition: all 0.3s ease;
            text-transform: uppercase;
        }
        [data-theme="dark"] .live-indicator { color: #5FC189; }
        .live-indicator .pulse {
            display: inline-block;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #2A7048;
            animation: pulse-dot 1.5s infinite;
        }
        .live-indicator.disconnected {
            background: rgba(176,59,52,0.09);
            color: #8A2A26;
            border-color: rgba(176,59,52,0.18);
        }
        .live-indicator.disconnected .pulse { background: #B03B34; animation: none; }
        .live-indicator.connecting {
            background: rgba(185,134,47,0.1);
            color: #7A5411;
            border-color: rgba(185,134,47,0.2);
        }
        .live-indicator.connecting .pulse { background: var(--brass); animation: pulse-dot 0.8s infinite; }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.45; transform: scale(0.78); }
        }

        .header-message-btn {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            transition: all 0.2s ease;
            position: relative;
            text-decoration: none;
        }
        .header-message-btn:hover {
            background: var(--sidebar-active-bg);
            color: var(--ink);
            border-color: var(--ink);
        }
        [data-theme="dark"] .header-message-btn:hover { color: var(--brass); border-color: var(--brass); }
        .header-message-btn .msg-dot {
            position: absolute;
            top: -4px; right: -4px;
            background: #B03B34;
            border-radius: 50%;
            width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px;
            color: white;
            font-weight: 700;
            border: 2px solid var(--header-bg);
            animation: pulse-dot 2s infinite;
        }

        .header-notif {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            transition: all 0.2s ease;
            position: relative;
        }
        .header-notif:hover {
            background: var(--sidebar-active-bg);
            color: var(--ink);
            border-color: var(--ink);
        }
        [data-theme="dark"] .header-notif:hover { color: var(--brass); border-color: var(--brass); }

        .notif-dot {
            position: absolute;
            top: -4px; right: -4px;
            background: #B03B34;
            border-radius: 50%;
            width: 18px; height: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px;
            color: white;
            font-weight: 700;
            border: 2px solid var(--header-bg);
            animation: pulse-dot 2s infinite;
        }
        .notif-dot.has-messages { background: var(--brass-deep); animation: pulse-dot 1s infinite; }

        .notification-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 380px;
            max-height: 480px;
            background: var(--notification-bg);
            border-radius: 14px;
            border: 1px solid var(--border-color);
            box-shadow: var(--notification-shadow);
            overflow: hidden;
            display: none;
            z-index: 1050;
            animation: dropdownSlideDown 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .notification-dropdown.show { display: block !important; }
        @keyframes dropdownSlideDown {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .dropdown-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            display: flex; justify-content: space-between; align-items: center;
            background: var(--bg-tertiary);
        }
        .dropdown-header span:first-child {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 0.92rem;
            color: var(--text-primary);
        }
        .dropdown-header .notif-total {
            background: var(--gradient-primary);
            color: white;
            padding: 2px 10px;
            border-radius: 7px;
            font-size: 0.68rem;
            font-weight: 700;
            font-family: var(--font-mono);
        }

        .dropdown-list { max-height: 340px; overflow-y: auto; padding: 4px 0; }
        .dropdown-list::-webkit-scrollbar { width: 4px; }
        .dropdown-list::-webkit-scrollbar-track { background: transparent; }
        .dropdown-list::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 10px; }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 12px 18px;
            cursor: pointer;
            transition: background 0.15s ease;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }
        .notification-item:last-child { border-bottom: none; }
        .notification-item:hover { background: var(--hover-bg); }
        .notification-item.unread { background: rgba(19,45,77,0.03); }
        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 0; top: 0;
            height: 100%; width: 3px;
            background: var(--brass);
        }

        .notification-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 0.88rem;
        }
        .notification-icon.info { background: rgba(61,116,166,0.12); color: #2B5A85; }
        .notification-icon.success { background: rgba(42,112,72,0.12); color: #1E5B39; }
        .notification-icon.warning { background: rgba(185,134,47,0.14); color: var(--brass-deep); }
        .notification-icon.danger { background: rgba(176,59,52,0.12); color: #8A2A26; }
        .notification-icon.birthday { background: rgba(185,134,47,0.12); color: var(--brass-deep); }
        .notification-icon.message { background: rgba(185,134,47,0.14); color: var(--brass-deep); }

        .notification-content { flex: 1; min-width: 0; }
        .notification-title { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); margin-bottom: 3px; }
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
            margin-top: 4px;
            display: flex; align-items: center; gap: 4px;
        }
        .notification-time i { font-size: 0.6rem; }

        .dropdown-footer {
            padding: 10px 18px;
            border-top: 1px solid var(--border-color);
            text-align: center;
            background: var(--bg-tertiary);
        }
        .dropdown-footer a {
            color: var(--ink);
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 600;
            transition: color 0.15s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        [data-theme="dark"] .dropdown-footer a { color: var(--brass); }
        .dropdown-footer a:hover { color: var(--brass-deep); }
        .dropdown-footer a .msg-count-badge {
            background: #B03B34;
            color: white;
            padding: 1px 9px;
            border-radius: 7px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .dropdown-empty { padding: 40px 20px; text-align: center; color: var(--text-muted); }
        .dropdown-empty i { font-size: 2.2rem; margin-bottom: 12px; display: block; opacity: 0.4; }

        .toast-container {
            position: fixed;
            top: 82px; right: 20px;
            z-index: 9999;
            display: flex; flex-direction: column; gap: 10px;
            max-width: 380px;
        }
        .toast-notification {
            background: var(--notification-bg);
            border: 1px solid var(--border-color);
            border-radius: 11px;
            padding: 14px 16px;
            box-shadow: var(--notification-shadow);
            display: flex; align-items: flex-start; gap: 12px;
            animation: toastSlideIn 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: right;
            min-width: 300px;
            border-left: 3px solid var(--ink);
            cursor: default;
        }
        .toast-notification.hiding { animation: toastSlideOut 0.25s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateX(32px) scale(0.97); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }
        @keyframes toastSlideOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to { opacity: 0; transform: translateX(32px) scale(0.97); }
        }
        .toast-notification.success { border-left-color: #2A7048; }
        .toast-notification.error { border-left-color: #B03B34; }
        .toast-notification.warning { border-left-color: var(--brass); }
        .toast-notification.info { border-left-color: #2B5A85; }
        .toast-notification.message { border-left-color: var(--brass); }

        .toast-icon {
            width: 28px; height: 28px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 0.78rem;
        }
        .toast-icon.success { background: rgba(42,112,72,0.12); color: #1E5B39; }
        .toast-icon.error { background: rgba(176,59,52,0.12); color: #8A2A26; }
        .toast-icon.warning { background: rgba(185,134,47,0.14); color: var(--brass-deep); }
        .toast-icon.info { background: rgba(61,116,166,0.12); color: #2B5A85; }
        .toast-icon.message { background: rgba(185,134,47,0.14); color: var(--brass-deep); }

        .toast-body { flex: 1; }
        .toast-title { font-size: 0.8rem; font-weight: 600; color: var(--text-primary); }
        .toast-message { font-size: 0.75rem; color: var(--text-secondary); margin-top: 2px; }

        .toast-close {
            background: none; border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 0.8rem;
            transition: all 0.2s ease;
        }
        .toast-close:hover { color: var(--text-primary); transform: rotate(90deg); }

        .user-dropdown-wrapper {
            position: relative;
            cursor: pointer;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 10px;
            border-radius: 10px;
            transition: all 0.2s ease;
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            cursor: pointer;
        }
        .user-dropdown-toggle:hover {
            background: var(--sidebar-active-bg);
            border-color: var(--ink);
        }
        [data-theme="dark"] .user-dropdown-toggle:hover {
            border-color: var(--brass);
        }

        .user-dropdown-toggle .arrow {
            margin-left: 4px;
            font-size: 0.7rem;
            color: var(--text-muted);
            transition: transform 0.25s ease;
        }
        .user-dropdown-toggle.active .arrow {
            transform: rotate(180deg);
        }

        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 280px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: var(--dropdown-shadow);
            padding: 0.5rem;
            display: none;
            z-index: 1060;
            animation: dropdownSlideDown 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top right;
        }
        .user-dropdown-menu.show {
            display: block !important;
        }

        .dropdown-user-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 0.75rem 0.9rem;
            border-bottom: 1px solid var(--border-color);
        }
        .dropdown-user-header .avatar-lg {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--brass);
        }
        .dropdown-user-header .avatar-lg-initials {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
            border: 2px solid var(--brass);
        }
        .dropdown-user-header .user-details {
            flex: 1;
            min-width: 0;
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
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 0.4rem 0;
        }

        .dropdown-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.6rem 0.85rem;
            border-radius: 9px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s ease;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .dropdown-menu-item:hover {
            background: var(--hover-bg);
            color: var(--text-primary);
        }
        [data-theme="dark"] .dropdown-menu-item:hover {
            color: var(--brass);
        }
        .dropdown-menu-item i {
            width: 20px;
            font-size: 0.9rem;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .dropdown-menu-item:hover i {
            color: var(--text-secondary);
        }
        [data-theme="dark"] .dropdown-menu-item:hover i {
            color: var(--brass);
        }
        .dropdown-menu-item.danger {
            color: var(--danger-color);
        }
        .dropdown-menu-item.danger i {
            color: var(--danger-color);
        }
        .dropdown-menu-item.danger:hover {
            background: rgba(176,59,52,0.08);
            color: var(--danger-hover);
        }

        .dropdown-menu-item .badge {
            margin-left: auto;
            font-size: 0.6rem;
            padding: 2px 8px;
            border-radius: 6px;
            background: var(--gradient-brass);
            color: white;
            font-weight: 700;
        }

        .language-selector-wrapper {
            padding: 0.3rem 0.5rem;
        }
        .language-selector-wrapper label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 700;
            display: block;
            padding: 0.3rem 0.4rem 0.5rem;
        }
        .language-options {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .language-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 0.7rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid transparent;
            font-size: 0.82rem;
            color: var(--text-secondary);
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .language-option:hover {
            background: var(--hover-bg);
        }
        .language-option.active {
            background: var(--sidebar-active-bg);
            border-color: var(--brass);
            color: var(--text-primary);
        }
        [data-theme="dark"] .language-option.active {
            background: rgba(201,153,66,0.15);
            color: var(--brass);
        }
        .language-option .flag {
            font-size: 1.2rem;
            width: 28px;
            text-align: center;
        }
        .language-option .lang-name {
            flex: 1;
        }
        .language-option .check {
            color: var(--brass);
            font-size: 0.85rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        .language-option.active .check {
            opacity: 1;
        }

        .security-settings-modal .modal-content {
            border-radius: 16px;
            overflow: hidden;
        }
        .security-settings-modal .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.2rem 1.5rem;
            background: var(--bg-tertiary);
        }
        .security-settings-modal .modal-header h5 {
            font-family: var(--font-display);
            font-weight: 600;
        }
        .security-settings-modal .modal-body {
            padding: 1.5rem;
        }
        .security-settings-modal .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        .security-setting-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }
        .security-setting-item:last-child {
            border-bottom: none;
        }
        .security-setting-item .setting-info {
            flex: 1;
        }
        .security-setting-item .setting-info h6 {
            font-weight: 600;
            font-size: 0.9rem;
            margin: 0 0 2px;
            color: var(--text-primary);
        }
        .security-setting-item .setting-info p {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin: 0;
        }
        .security-setting-item .setting-control {
            margin-left: 1rem;
        }

        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
            cursor: pointer;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--border-color);
            border-radius: 24px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }
        .toggle-switch input:checked + .toggle-slider {
            background: var(--brass);
        }
        .toggle-switch input:checked + .toggle-slider::before {
            transform: translateX(20px);
        }

        .password-change-form {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
        .password-change-form .form-group {
            margin-bottom: 1rem;
        }
        .password-change-form label {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-bottom: 4px;
        }

        .alert {
            padding: 0.85rem 1.1rem;
            border-radius: 10px;
            margin-bottom: 1.2rem;
            display: flex; align-items: center; gap: 10px;
            border: none;
            font-weight: 500;
            font-size: 0.82rem;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success { background: var(--alert-success-bg); color: var(--alert-success-text); border-left: 3px solid #2A7048; }
        .alert-danger  { background: var(--alert-danger-bg);  color: var(--alert-danger-text);  border-left: 3px solid #B03B34; }
        .alert-warning { background: var(--alert-warning-bg); color: var(--alert-warning-text); border-left: 3px solid var(--brass); }
        .alert-info    { background: var(--alert-info-bg);    color: var(--alert-info-text);    border-left: 3px solid #2B5A85; }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            transition: box-shadow 0.25s ease, transform 0.25s ease;
            color: var(--text-primary);
        }
        .card:hover { box-shadow: var(--card-hover-shadow); transform: translateY(-2px); }

        .form-control, .form-select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            transition: all 0.2s ease;
            border-radius: 9px;
            padding: 0.6rem 0.9rem;
            font-size: 0.85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--ink);
            box-shadow: 0 0 0 3px rgba(19,45,77,0.1);
        }
        [data-theme="dark"] .form-control:focus, [data-theme="dark"] .form-select:focus {
            border-color: var(--brass);
            box-shadow: 0 0 0 3px rgba(211,162,76,0.14);
        }
        .form-control::placeholder { color: var(--text-muted); }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
        }
        .btn-primary:hover { background: var(--ink-deep); }

        .modal-content {
            background: var(--modal-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
        }
        .modal-header { border-bottom: 1px solid var(--border-color); padding: 1.2rem 1.5rem; }
        .modal-footer { border-top: 1px solid var(--border-color); padding: 1rem 1.5rem; }

        .table { color: var(--text-primary); }
        .table thead th {
            border-bottom: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .table td, .table th { border-color: var(--border-color); padding: 0.8rem 1rem; vertical-align: middle; }
        .table-striped > tbody > tr:nth-of-type(odd) { background: rgba(0,0,0,0.015); }

        .logo-toast {
            position: fixed;
            bottom: 24px; right: 24px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 14px 22px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex; align-items: center; gap: 12px;
            box-shadow: var(--notification-shadow);
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-color);
        }
        .logo-toast.show { transform: translateY(0); opacity: 1; }
        .logo-toast.success { border-left: 3px solid #2A7048; }
        .logo-toast.error { border-left: 3px solid #B03B34; }

        .fab-theme {
            position: fixed;
            bottom: 28px; right: 28px;
            width: 46px; height: 46px;
            border-radius: 50%;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 1.05rem;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 18px rgba(16,24,39,0.1);
            z-index: 9998;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fab-theme:hover {
            transform: scale(1.06);
            color: var(--ink);
            border-color: var(--ink);
        }
        [data-theme="dark"] .fab-theme {
            background: var(--gradient-brass);
            border: none;
            color: #241905;
            box-shadow: 0 4px 20px rgba(211,162,76,0.35);
        }
        [data-theme="dark"] .fab-theme:hover { box-shadow: 0 8px 28px rgba(211,162,76,0.5); }

        .profile-picture-wrapper { position: relative; display: inline-block; cursor: pointer; }
        .profile-picture-wrapper .upload-overlay {
            position: absolute; bottom: 0; right: 0;
            background: var(--ink);
            border-radius: 50%;
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            color: white;
            border: 3px solid var(--bg-secondary);
            transition: all 0.25s ease;
        }
        .profile-picture-wrapper .upload-overlay:hover { transform: scale(1.08); background: var(--ink-deep); }

        .profile-picture-preview {
            width: 150px; height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--brass);
            transition: all 0.25s ease;
        }
        .profile-picture-placeholder {
            width: 150px; height: 150px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: white;
            border: 4px solid var(--brass);
            transition: all 0.25s ease;
        }

        .header-profile-img { width: 32px; height: 32px; border-radius: 9px; object-fit: cover; }
        .header-profile-initials {
            width: 32px; height: 32px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.72rem;
            color: white;
        }

        .updated { animation: updated-pulse 0.5s ease; }
        @keyframes updated-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); background: rgba(42,112,72,0.13); }
            100% { transform: scale(1); }
        }

        .new-item { animation: highlight-new 2s ease; }
        @keyframes highlight-new {
            0% { background: rgba(19,45,77,0.12); }
            100% { background: transparent; }
        }

        .connection-status {
            display: flex; align-items: center; gap: 6px;
            padding: 4px 10px;
            border-radius: 7px;
            font-size: 0.62rem;
            font-weight: 700;
        }
        .connection-status.connected { color: #1E5B39; background: rgba(42,112,72,0.1); }
        .connection-status.disconnected { color: #8A2A26; background: rgba(176,59,52,0.1); }
        .connection-status .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
        .connection-status.connected .dot { background: #2A7048; animation: pulse-dot 1.5s infinite; }
        .connection-status.disconnected .dot { background: #B03B34; animation: none; }

        @media (max-width: 1024px) {
            .sidebar-container { width: 224px; }
            .main-content { margin-left: 224px; }
        }
        @media (max-width: 768px) {
            .sidebar-container { transform: translateX(-100%); width: 280px; position: fixed; z-index: 1050; }
            .sidebar-container.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .content-area { padding: 1rem; }
            .top-header { padding: 0 1rem; }
            .header-user-info { display: none; }
            .header-left h1 { font-size: 1rem; }
            .fab-theme { bottom: 16px; right: 16px; width: 44px; height: 44px; font-size: 1rem; }
            .logo-toast { bottom: 80px; right: 16px; left: 16px; }
            .notification-dropdown { width: calc(100vw - 32px); right: -16px; top: calc(100% + 8px); }
            .toast-container { max-width: calc(100vw - 32px); right: 16px; }
            .live-indicator span { display: none; }
            .user-dropdown-menu { min-width: 260px; right: -10px; }
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
    $currentLang = session('app_locale', $user?->preferred_language ?? 'en');

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
@endphp

    <!-- Ambient Background -->
    <div class="animated-bg">
        <div class="circle" style="width: 380px; height: 380px; top: 5%; left: -120px; animation-delay: 0s;"></div>
        <div class="circle accent" style="width: 180px; height: 180px; bottom: 15%; right: -50px; animation-delay: 5s;"></div>
        <div class="circle" style="width: 140px; height: 140px; top: 50%; left: 22%; animation-delay: 2s;"></div>
        <div class="circle accent" style="width: 260px; height: 260px; bottom: 10%; left: 26%; animation-delay: 8s;"></div>
        <div class="circle" style="width: 110px; height: 110px; top: 25%; right: 15%; animation-delay: 3s;"></div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- File Input -->
    <input type="file" id="logoFileInput" accept="image/*" style="display:none;">

    <!-- Logo Toast -->
    <div class="logo-toast" id="logoToast">
        <i class="fas fa-circle-check" id="logoToastIcon"></i>
        <span id="logoToastMsg">Logo updated!</span>
    </div>

    <!-- Dark Mode Toggle -->
    <button class="fab-theme" id="fabThemeToggle" data-tooltip="Toggle Dark Mode" aria-label="Toggle dark mode">
        <i class="fas fa-moon" id="fabThemeIcon"></i>
    </button>

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
                    <div class="nav-section-title" data-i18n="main_menu"><i class="fas fa-th-large"></i></div>

                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('Dashboard') ? 'active' : '' }}" data-i18n="Dashboard">
                        <i class="fas fa-tachometer-alt"></i> <span data-i18n="Dashboard"></span>
                    </a>

                    <a href="{{ route('members.index') }}" class="nav-item {{ request()->routeIs('Members.*') ? 'active' : '' }}" data-i18n="Members">
                        <i class="fas fa-users"></i> <span data-i18n="Members"></span>
                    </a>

                    <a href="{{ route('finance.index') }}" class="nav-item {{ request()->routeIs('Finance.*') ? 'active' : '' }}" data-i18n="Finance">
                        <i class="fas fa-coins"></i> <span data-i18n="Finance"></span>
                        <span class="nav-badge finance"><i class="fas fa-arrow-trend-up"></i></span>
                    </a>

                    <a href="{{ route('sunday-attendance.index') }}" class="nav-item {{ request()->routeIs('Sunday Attendance.*') ? 'active' : '' }}" data-i18n="Sunday Attendance">
                        <i class="fas fa-church"></i> <span data-i18n="Sunday Attendance"></span>
                    </a>

                    <a href="{{ route('inventory.index') }}" class="nav-item {{ request()->routeIs('Inventory.*') ? 'active' : '' }}" data-i18n="Inventory">
                        <i class="fas fa-boxes"></i> <span data-i18n="Inventory"></span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title" data-i18n="communication"><i class="fas fa-comment-dots"></i></div>

                    <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('Messages.*') ? 'active' : '' }}" data-i18n="Messages">
                        <i class="fas fa-envelope"></i> <span data-i18n="Messages"></span>
                        @if($unreadMsgCount > 0)
                            <span class="nav-badge message-badge">{{ $unreadMsgCount > 99 ? '99+' : $unreadMsgCount }}</span>
                        @endif
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title" data-i18n="choir_ministry"><i class="fas fa-music"></i></div>

                    <a href="{{ route('choir-members.index') }}" class="nav-item {{ request()->routeIs('Choir Members.*') ? 'active' : '' }}" data-i18n="Choir Members">
                        <i class="fas fa-music"></i> <span data-i18n="Choir Members"></span>
                        @php
                            $choirCount = $user?->church_id ? \App\Models\Member::where('church_id', $user->church_id)->where('is_choir', true)->count() : 0;
                        @endphp
                        @if($choirCount > 0)
                            <span class="nav-badge">{{ $choirCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('choir-schedules.index') }}" class="nav-item {{ request()->routeIs('choir-schedules.*') ? 'active' : '' }}" data-i18n="Schedules">
                        <i class="fas fa-calendar-alt"></i> <span data-i18n="Schedules"></span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title" data-i18n="reports"><i class="fas fa-chart-line"></i></div>

                    <a href="{{ route('reports.analytics') }}" class="nav-item {{ request()->routeIs('reports.analytics') ? 'active' : '' }}" data-i18n="Reports & Analytics">
                        <i class="fas fa-chart-pie"></i> <span data-i18n="Reports & Analytics"></span>
                    </a>
                </div>
            </nav>
        </div>

        <div class="user-section">
            <div class="user-info">
                @if($user && $user->profile_picture)
                    <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="user-avatar-img">
                @else
                    <div class="user-avatar-sm" style="background: {{ $user?->avatar_color ?? '#132D4D' }};">
                        {{ $user?->initials ?? 'A' }}
                    </div>
                @endif
                <div>
                    <div class="user-name">{{ $user->name ?? 'Administrator' }}</div>
                    <div class="user-role">{{ $user->role ?? 'Administrator' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span data-i18n="Sign Out"></span>
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
                    <span data-i18n="live"></span>
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
                            <span data-i18n="Notifications"></span>
                            <span class="notif-total" id="notifTotalCount">{{ $unreadMsgCount }}</span>
                        </div>
                        <div class="dropdown-list" id="notificationList">
                            <div class="dropdown-empty">
                                <i class="fas fa-bell-slash"></i>
                                <span data-i18n="no_notifications"></span>
                            </div>
                        </div>
                        <div class="dropdown-footer">
                            <a href="{{ route('messages.index') }}">
                                <i class="fas fa-envelope"></i> <span data-i18n="go_to_messages"></span>
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
                            <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="header-profile-img">
                        @else
                            <div class="header-profile-initials" style="background: {{ $user?->avatar_color ?? '#132D4D' }};">
                                {{ $user?->initials ?? 'A' }}
                            </div>
                        @endif
                        <div class="header-user-info">
                            <span class="header-user-name">{{ $user->name ?? 'Administrator' }}</span>
                            <span class="header-user-role">{{ $user->role ?? 'Administrator' }}</span>
                        </div>
                        <i class="fas fa-chevron-down arrow"></i>
                    </div>

                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <div class="dropdown-user-header">
                            @if($user && $user->profile_picture)
                                <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="avatar-lg">
                            @else
                                <div class="avatar-lg-initials" style="background: {{ $user?->avatar_color ?? '#132D4D' }};">
                                    {{ $user?->initials ?? 'A' }}
                                </div>
                            @endif
                            <div class="user-details">
                                <div class="name">{{ $user->name ?? 'Administrator' }}</div>
                                <div class="email">{{ $user->email ?? 'admin@church.com' }}</div>
                            </div>
                        </div>

                        <div class="language-selector-wrapper">
                            <label data-i18n="language"><i class="fas fa-globe"></i></label>
                            <div class="language-options" id="languageOptions">
                                <button class="language-option {{ $currentLang === 'en' ? 'active' : '' }}" data-lang="en">
                                    <span class="flag">🇬🇧</span>
                                    <span class="lang-name">English</span>
                                    <span class="check"><i class="fas fa-check-circle"></i></span>
                                </button>
                                <button class="language-option {{ $currentLang === 'ceb' ? 'active' : '' }}" data-lang="ceb">
                                    <span class="flag">🇵🇭</span>
                                    <span class="lang-name">Cebuano / Bisaya</span>
                                    <span class="check"><i class="fas fa-check-circle"></i></span>
                                </button>
                                <button class="language-option {{ $currentLang === 'tl' ? 'active' : '' }}" data-lang="tl">
                                    <span class="flag">🇵🇭</span>
                                    <span class="lang-name">Tagalog</span>
                                    <span class="check"><i class="fas fa-check-circle"></i></span>
                                </button>
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>

                        <a href="{{ route('profile.edit') }}" class="dropdown-menu-item" data-i18n="my_profile">
                            <i class="fas fa-user-cog"></i>
                            <span data-i18n="my_profile"></span>
                        </a>

                        <button class="dropdown-menu-item" id="securitySettingsBtn" data-i18n="security_settings">
                            <i class="fas fa-shield-alt"></i>
                            <span data-i18n="security_settings"></span>
                            <span class="badge" data-i18n="secure"></span>
                        </button>

                        <div class="dropdown-divider"></div>

                        <button class="dropdown-menu-item danger" onclick="document.getElementById('logout-form').submit();" data-i18n="sign_out">
                            <i class="fas fa-sign-out-alt"></i>
                            <span data-i18n="sign_out"></span>
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

    <!-- ===== SECURITY SETTINGS MODAL ===== -->
    <div class="modal fade security-settings-modal" id="securitySettingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shield-alt me-2"></i> <span data-i18n="security_settings"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="security-setting-item">
                        <div class="setting-info">
                            <h6 data-i18n="two_factor_auth"></h6>
                            <p data-i18n="two_factor_desc"></p>
                        </div>
                        <div class="setting-control">
                            <label class="toggle-switch">
                                <input type="checkbox" id="twoFactorToggle" {{ ($user?->two_factor_enabled ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="security-setting-item">
                        <div class="setting-info">
                            <h6 data-i18n="session_timeout"></h6>
                            <p data-i18n="session_timeout_desc"></p>
                        </div>
                        <div class="setting-control">
                            <select class="form-select form-select-sm" id="sessionTimeout" style="width:120px;">
                                <option value="15" {{ ($user?->session_timeout ?? 30) == 15 ? 'selected' : '' }}>15 min</option>
                                <option value="30" {{ ($user?->session_timeout ?? 30) == 30 ? 'selected' : '' }}>30 min</option>
                                <option value="60" {{ ($user?->session_timeout ?? 30) == 60 ? 'selected' : '' }}>60 min</option>
                                <option value="120" {{ ($user?->session_timeout ?? 30) == 120 ? 'selected' : '' }}>2 hours</option>
                                <option value="0" {{ ($user?->session_timeout ?? 30) == 0 ? 'selected' : '' }}>Never</option>
                            </select>
                        </div>
                    </div>

                    <div class="password-change-form">
                        <h6 style="font-weight:600;margin-bottom:0.75rem;" data-i18n="change_password"></h6>
                        <form id="passwordChangeForm">
                            @csrf
                            <div class="form-group">
                                <label data-i18n="current_password"></label>
                                <input type="password" class="form-control form-control-sm" id="currentPassword" required>
                            </div>
                            <div class="form-group">
                                <label data-i18n="new_password"></label>
                                <input type="password" class="form-control form-control-sm" id="newPassword" required minlength="8">
                            </div>
                            <div class="form-group">
                                <label data-i18n="confirm_password"></label>
                                <input type="password" class="form-control form-control-sm" id="confirmPassword" required>
                            </div>
                            <div id="passwordStrength" class="mt-2" style="font-size:0.8rem;color:var(--text-muted);">
                                <span data-i18n="password_strength"></span>
                                <span id="strengthText" data-i18n="weak"></span>
                                <div class="progress mt-1" style="height:4px;">
                                    <div id="strengthBar" class="progress-bar" style="width:0%;background:#B03B34;" role="progressbar"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="security-setting-item" style="border-bottom:none;padding-bottom:0;">
                        <div class="setting-info">
                            <h6 data-i18n="active_sessions"></h6>
                            <p data-i18n="active_sessions_desc"></p>
                        </div>
                        <div class="setting-control">
                            <button class="btn btn-sm btn-outline-danger" id="logoutAllSessions" data-i18n="logout_all"></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-i18n="close"></button>
                    <button type="button" class="btn btn-primary" id="saveSecuritySettings" data-i18n="save_changes"></button>
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
        // COMPLETE TRANSLATIONS - ENGLISH, CEBUANO, TAGALOG
        // ============================================
        const translations = {
    en: {
        // ... all existing translations ...
        // Dashboard translations
        welcome_back: 'Welcome back! Here\'s your church overview',
        analytics: 'Analytics',
        total_members: 'Total Members',
        active_members: 'Active members',
        choir_members: 'Choir Members',
        music_ministry: 'Music ministry',
        today_attendance: 'Today\'s Attendance',
        present: 'present',
        monthly_balance: 'Monthly Balance',
        surplus: 'Surplus',
        deficit: 'Deficit',
        income_vs_expenses: 'Income vs Expenses',
        last_6_months: 'Last 6 Months',
        income: 'Income',
        expenses: 'Expenses',
        recent_transactions: 'Recent Transactions',
        view_all: 'View all',
        no_transactions: 'No transactions yet',
        add_transaction: 'Add transaction',
        upcoming_birthdays: 'Upcoming Birthdays',
        this_month: 'This month',
        today_label: 'Today!',
        tomorrow_label: 'Tomorrow!',
        turning_in_days: 'Turning',
        in: 'in',
        days: 'days',
        no_upcoming_birthdays: 'No upcoming birthdays',
        choir_schedule: 'Choir Schedule',
        upcoming_label: 'Upcoming',
        view_full_schedule: 'View Full Schedule',
        no_upcoming_schedule: 'No upcoming schedule',
        create_schedule: 'Create schedule',
        no_members_assigned: 'No members assigned',
        choir: 'Choir',
        today: 'Today',
        update_received: 'Update received',
        real_time_data_updated: 'Real-time data updated',
        // member management translations
        member_management: 'Member Management',
member_management_desc: 'Manage your church members, roles, and choir assignments',
add_member: 'Add Member',
back_to_active: 'Back to Active',
view_deceased: 'View Deceased',
active_members_label: 'Active Members',
choir_members_label: 'Choir Members',
birthdays_this_month: 'Birthdays This Month',
celebrating_soon: 'Celebrating soon',
deceased_label: 'Deceased',
at_rest: 'At rest',
filter_by_ministry: 'Filter by Ministry',
all_members: 'All Members',
total_deceased: 'Total Deceased',
total_active: 'Total Active',
active: 'Active',
deceased: 'Deceased',
member: 'Member',
gender: 'Gender',
roles: 'Roles',
birthday: 'Birthday',
age: 'Age',
actions: 'Actions',
regular: 'Regular',
choir: 'Choir',
showing: 'Showing',
to: 'to',
of: 'of',
no_active_members: 'No Active Members Yet',
no_active_members_desc: 'Get started by adding your first church member to the system.',
add_first_member: 'Add Your First Member',
no_deceased_members: 'No Deceased Members',
no_deceased_members_desc: 'Click the cross button on any active member to move them here.',
deceased_members: 'deceased members',
// SweetAlert translations
delete_member: 'Delete Member?',
delete_member_confirm: 'Are you sure you want to permanently delete <strong>{memberName}</strong>?<br><small>This action cannot be undone.</small>',
yes_delete: 'Yes, delete!',
cancel: 'Cancel',
deleting: 'Deleting...',
please_wait: 'Please wait',
permanently_delete: 'Permanently Delete?',
permanently_delete_confirm: 'Are you sure you want to permanently delete <strong>{memberName}</strong>?<br><small>All records will be lost forever.</small>',
restore_member: 'Restore Member?',
restore_member_confirm: 'Are you sure you want to restore <strong>{memberName}</strong> to active members?',
yes_restore: 'Yes, restore!',
restoring: 'Restoring...',
restored: 'Restored!',
error: 'Error!',
mark_as_deceased: 'Mark as Deceased',
date_of_death: 'Date of Death:',
mark_deceased: 'Mark as Deceased',
processing: 'Processing...',
marked_deceased: 'Marked as Deceased',
mark_deceased_confirm: 'Mark <strong>{memberName}</strong> as deceased?',
deceased_move_note: 'This member will be moved to the Deceased Members section.',
select_death_date: 'Please select the date of death',
// member profile translations
member_profile: 'Member Profile',
id_label: 'ID:',
edit_profile: 'Edit Profile',
back_to_members: 'Back to Members',
restore_to_active: 'Restore to Active',
personal_information: 'Personal Information',
birthday_label: 'Birthday',
years_old: 'years old',
phone_label: 'Phone Number',
email_label: 'Email Address',
address_label: 'Address',
roles_label: 'Roles & Responsibilities',
choir_label: 'Choir',
no_roles_assigned: 'No roles assigned',
add_label: 'Add',
not_specified: 'Not Specified',
male: 'Male',
female: 'Female',
// SweetAlert translations
mark_deceased_profile_confirm: 'Are you sure you want to mark this member as <strong>DECEASED</strong>?',
action_cannot_be_undone: 'This action cannot be undone.',
yes_mark_deceased: 'Yes, Mark Deceased',
restore_active_confirm: 'Are you sure you want to restore this member to ACTIVE status?',
delete_confirm_text: 'Are you sure you want to permanently delete',
delete_warning: 'This action cannot be undone. All data associated with this member will be permanently removed.',
// edit member translation
edit_member: 'Edit Member',
edit_member_information: 'Edit Member Information',
last_updated: 'Last updated:',
first_name: 'First Name',
last_name: 'Last Name',
enter_first_name: 'Enter first name',
enter_last_name: 'Enter last name',
phone_number: 'Phone Number',
email_address: 'Email Address',
enter_phone_number: 'Enter phone number',
enter_email_address: 'Enter email address',
address: 'Address',
enter_address: 'Enter address',
roles_responsibilities: 'Roles & Responsibilities',
assign_roles: 'Assign Roles',
select_multiple_hint: 'Hold',
windows_hint: '(Windows) or',
mac_hint: '(Mac) to select multiple roles',
choir_information: 'Choir Information',
choir_assignment: 'Choir Assignment',
choir_group: 'Choir Group',
no_choir_group: 'No Choir Group',
choir_role: 'Choir Role',
no_choir_role: 'No Choir Role',
singer: 'Singer',
guitarist: 'Guitarist',
bassist: 'Bassist',
drummer: 'Drummer',
update_member: 'Update Member',
view_profile: 'View Profile',
back: 'Back',
cancel: 'Cancel',
select_gender: 'Select Gender',
current_db_value: 'Current value in database:',
unsaved_changes: 'You have unsaved changes. Are you sure you want to leave?',
// add member  translation
add_new_member: 'Add New Member',
add_member_desc: 'Add a new member to your church family',
selected_label: 'Selected:',
not_selected: 'Not selected',
phone: 'Phone',
email: 'Email',
optional: 'Optional',
roles_ministries: 'Roles / Ministries',
select_roles_hint: 'Select one or more roles for this member',
no_roles_available: 'No roles available. Please contact administrator.',
choir_note_text: '<strong>Note:</strong> Members with <strong>Training Pastor, Palagkanta, Instruments, Singer, Musician, Guitarist, Pianist, Drummer, Bassist, or Choir</strong> roles will automatically be added to the <strong>Choir Ministry</strong>.',
save_member: 'Save Member',
// finance 
finance_dashboard: 'Finance Dashboard',
finance_dashboard_desc: 'Track income, expenses, and financial health across all churches',
view_all: 'View All',
refresh: 'Refresh',
total_income: 'Total Income',
total_expenses: 'Total Expenses',
overall_balance: 'Overall Balance',
churches: 'Churches',
connected_churches: 'Connected churches',
select_church: 'Select Church',
choose_church: 'Choose a Church',
viewing: 'Viewing:',
all_churches_label: 'All Churches',
select_church_hint: 'Select a church above to view its detailed financial information.',
balance: 'Balance',
income_categories: 'Income Categories',
expense_categories: 'Expense Categories',
no_income_categories: 'No income categories',
no_expense_categories: 'No expense categories',
monthly_income_expenses: 'Monthly Income vs Expenses',
last_6_months: 'Last 6 months',
income: 'Income',
expenses: 'Expenses',
view_details: 'View Details',
all_churches: 'All churches',
// attendance
sunday_attendance: 'Sunday Service Attendance',
sunday_attendance_desc: 'Record and manage attendance for Sunday worship services',
sunday_service_label: 'Sunday Service',
view_records: 'View Records',
select_date: 'Select Date',
only_sundays: 'Only Sundays are selectable',
auto_save_enabled: 'Auto-save enabled',
date_label: 'DATE',
prev_week: 'Prev Week',
next_week: 'Next Week',
member_attendance: 'Member Attendance',
recorded: 'Recorded',
changes_auto_save: 'Changes auto-save',
member_info: 'Member Information',
status_label: 'Status',
notes_label: 'Notes',
choir_member: 'Choir Member',
present_option: 'Present',
absent_option: 'Absent',
add_notes: 'Add notes...',
no_members_found: 'No members found. Please add members first.',
only_sundays_allowed: 'Only Sundays Allowed',
only_sundays_desc: 'Attendance can only be recorded on Sundays. Please select a Sunday date.',
select_date_label: 'Select a date',
ok_understand: 'OK, I Understand',
changes_saved: 'Changes saved automatically',
saving: 'Saving...',
auto_saved: 'Auto-saved',
save_error: 'Error saving changes',
save_failed: 'Auto-save failed',
network_error: 'Network error. Please check your connection.',
present_label: 'Present',
absent_label: 'Absent',
attended_today: 'Attended today',
not_attended: 'Not attended',
total_members: 'Total Members',
church_family: 'Church family',
// record attendance
attendance_records: 'Attendance Records',
attendance_records_desc: 'View and analyze church attendance data',
input_attendance: 'Input Attendance',
total_members_label: 'Total Members',
registered: 'Registered',
present_today: 'Present Today',
attended: 'Attended',
absent_today: 'Absent Today',
attendance_details: 'Attendance Details',
present_short: 'Present',
members_short: 'Members',
age_label: 'Age',
status_label: 'Status',
notes_label: 'Notes',
present_option: 'Present',
absent_option: 'Absent',
today: 'Today',
last_sunday: 'Last Sunday',
previous: 'Previous',
total_members_footer: 'Total members:',
present_footer: 'Present:',
absent_footer: 'Absent:',
only_sundays_records_desc: 'Attendance records can only be viewed for Sundays. Please select a Sunday date.',
invalid_date: 'Invalid date selected',
select_date_label: 'Select a date',
ok_understand: 'OK, I Understand',
member_info: 'Member Information',
choir_member: 'Choir Member',
no_members_found: 'No members found. Please add members first.',
date_label: 'DATE'
    },
    ceb: {
        // ... all Cebuano translations ...
        welcome_back: 'Welcome back! Ania ang imong church overview',
        analytics: 'Analisis',
        total_members: 'Kabuok nga Miyembro',
        active_members: 'Mga aktibong miyembro',
        choir_members: 'Mga Miyembro sa Koro',
        music_ministry: 'Ministriyo sa musika',
        today_attendance: 'Tubag Karon',
        present: 'tumambong',
        monthly_balance: 'Buwanang Balanse',
        surplus: 'Surplus',
        deficit: 'Kulang',
        income_vs_expenses: 'Kita vs Gastos',
        last_6_months: 'Miaging 6 ka Buwan',
        income: 'Kita',
        expenses: 'Gastos',
        recent_transactions: 'Bag-ong mga Transaksyon',
        view_all: 'Tan-awa tanan',
        no_transactions: 'Wala pay mga transaksyon',
        add_transaction: 'Pagdugang transaksyon',
        upcoming_birthdays: 'Umaabot nga mga Adlawng Natawhan',
        this_month: 'Karong buwana',
        today_label: 'Karon na!',
        tomorrow_label: 'Ugma na!',
        turning_in_days: 'Mag-',
        in: 'sa',
        days: 'ka adlaw',
        no_upcoming_birthdays: 'Walay umaabot nga mga adlawng natawhan',
        choir_schedule: 'Iskedyul sa Koro',
        upcoming_label: 'Umaabot',
        view_full_schedule: 'Tan-awa ang Tibuok Iskedyul',
        no_upcoming_schedule: 'Walay umaabot nga iskedyul',
        create_schedule: 'Paghimo og iskedyul',
        no_members_assigned: 'Walay mga miyembro nga gi-assign',
        choir: 'Koro',
        today: 'Karon',
        update_received: 'Nadawat ang update',
        real_time_data_updated: 'Gi-update ang real-time nga datos',
        // Add to translations.ceb
member_management: 'Pagtuki sa mga Miyembro',
member_management_desc: 'Pagdumala sa imong mga miyembro sa simbahan, mga tahas, ug mga asaynment sa koro',
add_member: 'Pagdugang og Miyembro',
back_to_active: 'Balik sa Aktibo',
view_deceased: 'Tan-awa ang mga Namatay',
active_members_label: 'Aktibong mga Miyembro',
choir_members_label: 'Mga Miyembro sa Koro',
birthdays_this_month: 'Mga Adlawng Natawhan Karong Buwana',
celebrating_soon: 'Nagsaulog sa dili madugay',
deceased_label: 'Namatay',
at_rest: 'Nagpahulay',
filter_by_ministry: 'Pagsala sa Ministriyo',
all_members: 'Tanang Miyembro',
total_deceased: 'Kinasangputan nga Namatay',
total_active: 'Kinasangputan nga Aktibo',
active: 'Aktibo',
deceased: 'Namatay',
member: 'Miyembro',
gender: 'Sekso',
roles: 'Mga Tahas',
birthday: 'Adlawng Natawhan',
age: 'Edad',
actions: 'Mga Aksyon',
regular: 'Regular',
choir: 'Koro',
showing: 'Gipakita',
to: 'hangtod',
of: 'sa',
no_active_members: 'Wala pay Aktibong mga Miyembro',
no_active_members_desc: 'Pagsugod pinaagi sa pagdugang sa imong unang miyembro sa simbahan.',
add_first_member: 'Pagdugang sa Imong Unang Miyembro',
no_deceased_members: 'Walay mga Namatay nga Miyembro',
no_deceased_members_desc: 'I-klik ang cross button sa bisan unsang aktibong miyembro aron ibalhin sila dinhi.',
deceased_members: 'mga namatay nga miyembro',
// SweetAlert Cebuano
delete_member: 'Kuhaon ang Miyembro?',
delete_member_confirm: 'Sigurado ka bang gusto nimo nga permanenteng kuhaon <strong>{memberName}</strong>?<br><small>Kining aksyon dili na mabalik.</small>',
yes_delete: 'Oo, kuhaa!',
cancel: 'Kanselar',
deleting: 'Nag-kuha...',
please_wait: 'Palihug paghulat',
permanently_delete: 'Permanenteng Kuhaon?',
permanently_delete_confirm: 'Sigurado ka bang gusto nimo nga permanenteng kuhaon <strong>{memberName}</strong>?<br><small>Tanang rekord mawala na.</small>',
restore_member: 'Ibalik ang Miyembro?',
restore_member_confirm: 'Sigurado ka bang gusto nimo nga ibalik <strong>{memberName}</strong> sa aktibong mga miyembro?',
yes_restore: 'Oo, ibalik!',
restoring: 'Nag-ibalik...',
restored: 'Naibalik!',
error: 'Sayop!',
mark_as_deceased: 'Markahan nga Namatay',
date_of_death: 'Petsa sa Kamatayon:',
mark_deceased: 'Markahan nga Namatay',
processing: 'Nag-proseso...',
marked_deceased: 'Markahan nga Namatay!',
mark_deceased_confirm: 'Markahan <strong>{memberName}</strong> nga namatay?',
deceased_move_note: 'Kining miyembro ibalhin sa seksyon sa mga Namatay.',
select_death_date: 'Palihug pagpili sa petsa sa kamatayon',
// Table headers
member_table: 'Talaan sa mga Miyembro',
id: 'ID',
name: 'Ngalan',
contact: 'Kontak',
status: 'Kahimtang',
date_added: 'Petsa nga Gidugang',
last_updated: 'Katapusang Gi-update',
view_profile: 'Tan-awa ang Profile',
edit_member: 'Usba ang Miyembro',
delete_member_title: 'Kuhaon ang Miyembro',
restore_member_title: 'Ibalik ang Miyembro',
permanent_delete_title: 'Permanenteng Kuhaon',
// Additional
search_members: 'Pangitaa ang mga Miyembro',
no_results: 'Walay nakit-an nga mga miyembro',
loading: 'Nag-load...',
success: 'Malampuson!',
confirm: 'Kompirmar',
yes: 'Oo',
no: 'Dili',
// member profile translations
member_profile: 'Profile sa Miyembro',
id_label: 'ID:',
edit_profile: 'Usba ang Profile',
back_to_members: 'Balik sa mga Miyembro',
restore_to_active: 'Ibalik sa Aktibo',
personal_information: 'Panguna nga Impormasyon',
birthday_label: 'Adlawng Natawhan',
years_old: 'ka tuig ang panuigon',
phone_label: 'Numero sa Telepono',
email_label: 'Email Address',
address_label: 'Address',
roles_label: 'Mga Tahas ug Responsibilidad',
choir_label: 'Koro',
no_roles_assigned: 'Walay mga tahas nga gi-assign',
add_label: 'Pagdugang',
not_specified: 'Wala Matino',
male: 'Lalaki',
female: 'Babaye',
mark_deceased_profile_confirm: 'Sigurado ka bang gusto nimo nga markahan kini nga miyembro nga <strong>NAMATAY</strong>?',
action_cannot_be_undone: 'Kining aksyon dili na mabalik.',
yes_mark_deceased: 'Oo, Markahan nga Namatay',
restore_active_confirm: 'Sigurado ka bang gusto nimo nga ibalik kini nga miyembro sa AKTIBO nga kahimtang?',
delete_confirm_text: 'Sigurado ka bang gusto nimo nga permanenteng kuhaon',
delete_warning: 'Kining aksyon dili na mabalik. Tanang datos nga naay kalabotan niini nga miyembro mawala na.',
// member edit translation
edit_member: 'Usba ang Miyembro',
edit_member_information: 'Usba ang Impormasyon sa Miyembro',
last_updated: 'Katapusang gi-update:',
first_name: 'Unang Ngalan',
last_name: 'Apelyido',
enter_first_name: 'Isulod ang unang ngalan',
enter_last_name: 'Isulod ang apelyido',
phone_number: 'Numero sa Telepono',
email_address: 'Email Address',
enter_phone_number: 'Isulod ang numero sa telepono',
enter_email_address: 'Isulod ang email address',
address: 'Address',
enter_address: 'Isulod ang address',
roles_responsibilities: 'Mga Tahas ug Responsibilidad',
assign_roles: 'Pag-assign og mga Tahas',
select_multiple_hint: 'Paghawak',
windows_hint: '(Windows) o',
mac_hint: '(Mac) aron makapili og daghang mga tahas',
choir_information: 'Impormasyon sa Koro',
choir_assignment: 'Asaynment sa Koro',
choir_group: 'Grupo sa Koro',
no_choir_group: 'Walay Grupo sa Koro',
choir_role: 'Tahas sa Koro',
no_choir_role: 'Walay Tahas sa Koro',
singer: 'Manganta',
guitarist: 'Gitara',
bassist: 'Bass',
drummer: 'Drummer',
update_member: 'I-update ang Miyembro',
view_profile: 'Tan-awa ang Profile',
back: 'Balik',
cancel: 'Kanselar',
select_gender: 'Pagpili og Sekso',
current_db_value: 'Kasalukuyang value sa database:',
unsaved_changes: 'Naay mga wala ma-save nga mga pagbag-o. Sigurado ka bang gusto nimo nga mobiya?',
// add member translation
add_new_member: 'Pagdugang og Bag-ong Miyembro',
add_member_desc: 'Pagdugang og bag-ong miyembro sa imong pamilya sa simbahan',
selected_label: 'Napili:',
not_selected: 'Wala mapili',
phone: 'Telepono',
email: 'Email',
optional: 'Opsyonal',
roles_ministries: 'Mga Tahas / Ministriyo',
select_roles_hint: 'Pagpili og usa o daghang mga tahas alang niini nga miyembro',
no_roles_available: 'Walay mga tahas nga magamit. Palihug kontaka ang administrador.',
choir_note_text: '<strong>Nota:</strong> Ang mga miyembro nga naay <strong>Training Pastor, Palagkanta, Instruments, Singer, Musician, Guitarist, Pianist, Drummer, Bassist, o Choir</strong> nga mga tahas awtomatikong idugang sa <strong>Choir Ministry</strong>.',
save_member: 'I-save ang Miyembro',
// finance
finance_dashboard: 'Dashboard sa Pinansyal',
finance_dashboard_desc: 'Subayon ang kita, gastos, ug kahimsog sa pinansyal sa tanang simbahan',
view_all: 'Tan-awa Tanan',
refresh: 'I-refresh',
total_income: 'Kinatibuk-ang Kita',
total_expenses: 'Kinatibuk-ang Gastos',
overall_balance: 'Kinatibuk-ang Balanse',
churches: 'Mga Simbahan',
connected_churches: 'Mga konektado nga simbahan',
select_church: 'Pagpili og Simbahan',
choose_church: 'Pagpili og Simbahan',
viewing: 'Nagtan-aw:',
all_churches_label: 'Tanang Simbahan',
select_church_hint: 'Pagpili og simbahan sa taas aron makita ang detalyado nga impormasyon sa pinansyal.',
balance: 'Balanse',
income_categories: 'Mga Kategoriya sa Kita',
expense_categories: 'Mga Kategoriya sa Gastos',
no_income_categories: 'Walay mga kategoriya sa kita',
no_expense_categories: 'Walay mga kategoriya sa gastos',
monthly_income_expenses: 'Binulan nga Kita vs Gastos',
last_6_months: 'Miaging 6 ka buwan',
income: 'Kita',
expenses: 'Gastos',
view_details: 'Tan-awa ang mga Detalye',
all_churches: 'Tanang simbahan',
// attendance
sunday_attendance: 'Pagtambong sa Serbisyo sa Domingo',
sunday_attendance_desc: 'Pagrekord ug pagdumala sa pagtambong sa mga serbisyo sa pagsimba sa Domingo',
sunday_service_label: 'Serbisyo sa Domingo',
view_records: 'Tan-awa ang mga Rekord',
select_date: 'Pagpili og Petsa',
only_sundays: 'Mga Domingo lamang ang mapilian',
auto_save_enabled: 'Gi-enable ang auto-save',
date_label: 'PETSA',
prev_week: 'Miaging Semana',
next_week: 'Sunod nga Semana',
member_attendance: 'Pagtambong sa mga Miyembro',
recorded: 'Narekord',
changes_auto_save: 'Mga pagbag-o auto-save',
member_info: 'Impormasyon sa Miyembro',
status_label: 'Kahimtang',
notes_label: 'Mga Nota',
choir_member: 'Miyembro sa Koro',
present_option: 'Tumambong',
absent_option: 'Wala',
add_notes: 'Pagdugang og nota...',
no_members_found: 'Walay mga miyembro nga nakit-an. Palihug pagdugang og mga miyembro una.',
only_sundays_allowed: 'Mga Domingo Lamang ang Gitugotan',
only_sundays_desc: 'Ang pagtambong ma-rekord lamang sa mga Domingo. Palihug pagpili og petsa sa Domingo.',
select_date_label: 'Pagpili og petsa',
ok_understand: 'OK, Nasabtan Nako',
changes_saved: 'Malampusong na-save ang mga pagbag-o',
saving: 'Nag-save...',
auto_saved: 'Na-auto-save',
save_error: 'Sayop sa pag-save',
save_failed: 'Napakyas ang auto-save',
network_error: 'Sayop sa network. Palihug susiha ang imong koneksyon.',
present_label: 'Tumambong',
absent_label: 'Wala',
attended_today: 'Nakatambong karon',
not_attended: 'Wala nakatambong',
total_members: 'Kabuok nga Miyembro',
church_family: 'Pamilya sa simbahan',
// record attendance
attendance_records: 'Mga Rekord sa Pagtambong',
attendance_records_desc: 'Tan-awa ug analisaha ang datos sa pagtambong sa simbahan',
input_attendance: 'Pag-input sa Pagtambong',
total_members_label: 'Kabuok nga Miyembro',
registered: 'Narekord',
present_today: 'Tumambong Karon',
attended: 'Nakatambong',
absent_today: 'Wala Karon',
attendance_details: 'Mga Detalye sa Pagtambong',
present_short: 'Tumambong',
members_short: 'Miyembro',
age_label: 'Edad',
status_label: 'Kahimtang',
notes_label: 'Mga Nota',
present_option: 'Tumambong',
absent_option: 'Wala',
today: 'Karon',
last_sunday: 'Miaging Domingo',
previous: 'Miagi',
total_members_footer: 'Kabuok nga miyembro:',
present_footer: 'Tumambong:',
absent_footer: 'Wala:',
only_sundays_records_desc: 'Ang mga rekord sa pagtambong makita lamang sa mga Domingo. Palihug pagpili og petsa sa Domingo.',
invalid_date: 'Dili balido nga petsa',
select_date_label: 'Pagpili og petsa',
ok_understand: 'OK, Nasabtan Nako',
member_info: 'Impormasyon sa Miyembro',
choir_member: 'Miyembro sa Koro',
no_members_found: 'Walay mga miyembro nga nakit-an. Palihug pagdugang og mga miyembro una.',
date_label: 'PETSA'

    },
    tl: {
        // ... all Tagalog translations ...
        welcome_back: 'Welcome back! Narito ang iyong church overview',
        analytics: 'Analisis',
        total_members: 'Kabuuang Miyembro',
        active_members: 'Mga aktibong miyembro',
        choir_members: 'Mga Miyembro ng Koro',
        music_ministry: 'Ministeryo ng musika',
        today_attendance: 'Pagdalo Ngayon',
        present: 'dumalo',
        monthly_balance: 'Buwanang Balanse',
        surplus: 'Sobra',
        deficit: 'Kulang',
        income_vs_expenses: 'Kita vs Gastos',
        last_6_months: 'Huling 6 na Buwan',
        income: 'Kita',
        expenses: 'Gastos',
        recent_transactions: 'Mga Bagong Transaksyon',
        view_all: 'Tingnan lahat',
        no_transactions: 'Wala pang mga transaksyon',
        add_transaction: 'Magdagdag ng transaksyon',
        upcoming_birthdays: 'Mga Paparating na Kaarawan',
        this_month: 'Ngayong buwan',
        today_label: 'Ngayon na!',
        tomorrow_label: 'Bukas na!',
        turning_in_days: 'Mag-',
        in: 'sa',
        days: 'na araw',
        no_upcoming_birthdays: 'Walang paparating na kaarawan',
        choir_schedule: 'Iskedyul ng Koro',
        upcoming_label: 'Paparating',
        view_full_schedule: 'Tingnan ang Buong Iskedyul',
        no_upcoming_schedule: 'Walang paparating na iskedyul',
        create_schedule: 'Gumawa ng iskedyul',
        no_members_assigned: 'Walang mga miyembro na naka-assign',
        choir: 'Koro',
        today: 'Ngayon',
        update_received: 'Natanggap ang update',
        real_time_data_updated: 'Na-update ang real-time na datos',
        // Add to translations.tl
member_management: 'Pamamahala ng mga Miyembro',
member_management_desc: 'Pamahalaan ang iyong mga miyembro ng simbahan, mga tungkulin, at mga asignasyon sa koro',
add_member: 'Magdagdag ng Miyembro',
back_to_active: 'Bumalik sa Aktibo',
view_deceased: 'Tingnan ang mga Yumao',
active_members_label: 'Aktibong mga Miyembro',
choir_members_label: 'Mga Miyembro ng Koro',
birthdays_this_month: 'Mga Kaarawan Ngayong Buwan',
celebrating_soon: 'Magdiriwang sa lalong madaling panahon',
deceased_label: 'Yumao',
at_rest: 'Nagpapahinga',
filter_by_ministry: 'Salain ayon sa Ministeryo',
all_members: 'Lahat ng Miyembro',
total_deceased: 'Kabuuang Yumao',
total_active: 'Kabuuang Aktibo',
active: 'Aktibo',
deceased: 'Yumao',
member: 'Miyembro',
gender: 'Kasarian',
roles: 'Mga Tungkulin',
birthday: 'Kaarawan',
age: 'Edad',
actions: 'Mga Aksyon',
regular: 'Regular',
choir: 'Koro',
showing: 'Ipinapakita',
to: 'hanggang',
of: 'ng',
no_active_members: 'Walang Aktibong mga Miyembro',
no_active_members_desc: 'Magsimula sa pamamagitan ng pagdagdag ng iyong unang miyembro ng simbahan sa sistema.',
add_first_member: 'Idagdag ang Iyong Unang Miyembro',
no_deceased_members: 'Walang mga Yumao na Miyembro',
no_deceased_members_desc: 'I-click ang cross button sa anumang aktibong miyembro upang ilipat sila dito.',
deceased_members: 'mga yumaong miyembro',
// SweetAlert Tagalog
delete_member: 'Tanggalin ang Miyembro?',
delete_member_confirm: 'Sigurado ka bang gusto mong permanenteng tanggalin <strong>{memberName}</strong>?<br><small>Ang aksyon na ito ay hindi na maibabalik.</small>',
yes_delete: 'Oo, tanggalin!',
cancel: 'Kanselahin',
deleting: 'Tinatanggal...',
please_wait: 'Mangyaring maghintay',
permanently_delete: 'Permanenteng Tanggalin?',
permanently_delete_confirm: 'Sigurado ka bang gusto mong permanenteng tanggalin <strong>{memberName}</strong>?<br><small>Lahat ng rekord ay mawawala na.</small>',
restore_member: 'Ibalik ang Miyembro?',
restore_member_confirm: 'Sigurado ka bang gusto mong ibalik <strong>{memberName}</strong> sa aktibong mga miyembro?',
yes_restore: 'Oo, ibalik!',
restoring: 'Ibinabalik...',
restored: 'Naibalik!',
error: 'Error!',
mark_as_deceased: 'Markahan bilang Yumao',
date_of_death: 'Petsa ng Kamatayan:',
mark_deceased: 'Markahan bilang Yumao',
processing: 'Nagproseso...',
marked_deceased: 'Minarkahan bilang Yumao!',
mark_deceased_confirm: 'Markahan <strong>{memberName}</strong> bilang yumao?',
deceased_move_note: 'Ang miyembrong ito ay ililipat sa seksyon ng mga Yumao.',
select_death_date: 'Mangyaring pumili ng petsa ng kamatayan',
// Table headers
member_table: 'Talaan ng mga Miyembro',
id: 'ID',
name: 'Pangalan',
contact: 'Kontak',
status: 'Katayuan',
date_added: 'Petsa ng Pagdagdag',
last_updated: 'Huling Na-update',
view_profile: 'Tingnan ang Profile',
edit_member: 'Baguhin ang Miyembro',
delete_member_title: 'Tanggalin ang Miyembro',
restore_member_title: 'Ibalik ang Miyembro',
permanent_delete_title: 'Permanenteng Tanggalin',
// Additional
search_members: 'Maghanap ng mga Miyembro',
no_results: 'Walang nakitang mga miyembro',
loading: 'Naglo-load...',
success: 'Matagumpay!',
confirm: 'Kumpirmahin',
yes: 'Oo',
no: 'Hindi',
//member profile translations
member_profile: 'Profile ng Miyembro',
id_label: 'ID:',
edit_profile: 'Baguhin ang Profile',
back_to_members: 'Bumalik sa mga Miyembro',
restore_to_active: 'Ibalik sa Aktibo',
personal_information: 'Personal na Impormasyon',
birthday_label: 'Kaarawan',
years_old: 'taong gulang',
phone_label: 'Numero ng Telepono',
email_label: 'Email Address',
address_label: 'Address',
roles_label: 'Mga Tungkulin at Responsibilidad',
choir_label: 'Koro',
no_roles_assigned: 'Walang mga tungkulin na naka-assign',
add_label: 'Magdagdag',
not_specified: 'Hindi Natukoy',
male: 'Lalaki',
female: 'Babae',
mark_deceased_profile_confirm: 'Sigurado ka bang gusto mong markahan ang miyembrong ito bilang <strong>YUMATO</strong>?',
action_cannot_be_undone: 'Ang aksyon na ito ay hindi na maibabalik.',
yes_mark_deceased: 'Oo, Markahan bilang Yumao',
restore_active_confirm: 'Sigurado ka bang gusto mong ibalik ang miyembrong ito sa AKTIBO na katayuan?',
delete_confirm_text: 'Sigurado ka bang gusto mong permanenteng tanggalin',
delete_warning: 'Ang aksyon na ito ay hindi na maibabalik. Lahat ng datos na may kaugnayan sa miyembrong ito ay tuluyang mawawala.',
// member edit translation
edit_member: 'Baguhin ang Miyembro',
edit_member_information: 'Baguhin ang Impormasyon ng Miyembro',
last_updated: 'Huling na-update:',
first_name: 'Unang Pangalan',
last_name: 'Apelyido',
enter_first_name: 'Ilagay ang unang pangalan',
enter_last_name: 'Ilagay ang apelyido',
phone_number: 'Numero ng Telepono',
email_address: 'Email Address',
enter_phone_number: 'Ilagay ang numero ng telepono',
enter_email_address: 'Ilagay ang email address',
address: 'Address',
enter_address: 'Ilagay ang address',
roles_responsibilities: 'Mga Tungkulin at Responsibilidad',
assign_roles: 'Mag-assign ng mga Tungkulin',
select_multiple_hint: 'Pigilan',
windows_hint: '(Windows) o',
mac_hint: '(Mac) upang pumili ng maraming tungkulin',
choir_information: 'Impormasyon ng Koro',
choir_assignment: 'Asignasyon sa Koro',
choir_group: 'Grupo ng Koro',
no_choir_group: 'Walang Grupo ng Koro',
choir_role: 'Tungkulin sa Koro',
no_choir_role: 'Walang Tungkulin sa Koro',
singer: 'Mang-aawit',
guitarist: 'Gitara',
bassist: 'Bass',
drummer: 'Drummer',
update_member: 'I-update ang Miyembro',
view_profile: 'Tingnan ang Profile',
back: 'Bumalik',
cancel: 'Kanselahin',
select_gender: 'Pumili ng Kasarian',
current_db_value: 'Kasalukuyang value sa database:',
unsaved_changes: 'May mga hindi na-save na pagbabago. Sigurado ka bang gusto mong umalis?',
//add member translation
add_new_member: 'Magdagdag ng Bagong Miyembro',
add_member_desc: 'Magdagdag ng bagong miyembro sa iyong pamilya ng simbahan',
selected_label: 'Napili:',
not_selected: 'Hindi napili',
phone: 'Telepono',
email: 'Email',
optional: 'Opsyonal',
roles_ministries: 'Mga Tungkulin / Ministeryo',
select_roles_hint: 'Pumili ng isa o higit pang mga tungkulin para sa miyembrong ito',
no_roles_available: 'Walang mga tungkulin na magagamit. Mangyaring makipag-ugnayan sa administrator.',
choir_note_text: '<strong>Tandaan:</strong> Ang mga miyembro na may <strong>Training Pastor, Palagkanta, Instruments, Singer, Musician, Guitarist, Pianist, Drummer, Bassist, o Choir</strong> na mga tungkulin ay awtomatikong idadagdag sa <strong>Choir Ministry</strong>.',
save_member: 'I-save ang Miyembro',
//finance
finance_dashboard: 'Dashboard ng Pinansyal',
finance_dashboard_desc: 'Subaybayan ang kita, gastos, at kalusugan ng pinansyal sa lahat ng simbahan',
view_all: 'Tingnan Lahat',
refresh: 'I-refresh',
total_income: 'Kabuuang Kita',
total_expenses: 'Kabuuang Gastos',
overall_balance: 'Kabuuang Balanse',
churches: 'Mga Simbahan',
connected_churches: 'Mga konektadong simbahan',
select_church: 'Pumili ng Simbahan',
choose_church: 'Pumili ng Simbahan',
viewing: 'Tinitingnan:',
all_churches_label: 'Lahat ng Simbahan',
select_church_hint: 'Pumili ng simbahan sa itaas upang makita ang detalyadong impormasyon ng pinansyal.',
balance: 'Balanse',
income_categories: 'Mga Kategorya ng Kita',
expense_categories: 'Mga Kategorya ng Gastos',
no_income_categories: 'Walang mga kategorya ng kita',
no_expense_categories: 'Walang mga kategorya ng gastos',
monthly_income_expenses: 'Buwanang Kita vs Gastos',
last_6_months: 'Huling 6 na buwan',
income: 'Kita',
expenses: 'Gastos',
view_details: 'Tingnan ang mga Detalye',
all_churches: 'Lahat ng simbahan',
// attendance
sunday_attendance: 'Pagdalo sa Serbisyo sa Linggo',
sunday_attendance_desc: 'I-record at pamahalaan ang pagdalo sa mga serbisyo ng pagsamba sa Linggo',
sunday_service_label: 'Serbisyo sa Linggo',
view_records: 'Tingnan ang mga Rekord',
select_date: 'Pumili ng Petsa',
only_sundays: 'Mga Linggo lamang ang mapipili',
auto_save_enabled: 'Naka-enable ang auto-save',
date_label: 'PETSA',
prev_week: 'Nakaraang Linggo',
next_week: 'Susunod na Linggo',
member_attendance: 'Pagdalo ng mga Miyembro',
recorded: 'Narekord',
changes_auto_save: 'Mga pagbabago auto-save',
member_info: 'Impormasyon ng Miyembro',
status_label: 'Katayuan',
notes_label: 'Mga Nota',
choir_member: 'Miyembro ng Koro',
present_option: 'Dumalo',
absent_option: 'Wala',
add_notes: 'Magdagdag ng nota...',
no_members_found: 'Walang mga miyembro na natagpuan. Mangyaring magdagdag ng mga miyembro muna.',
only_sundays_allowed: 'Mga Linggo Lamang ang Pinapayagan',
only_sundays_desc: 'Ang pagdalo ay maire-record lamang sa mga Linggo. Mangyaring pumili ng petsa sa Linggo.',
select_date_label: 'Pumili ng petsa',
ok_understand: 'OK, Naiintindihan Ko',
changes_saved: 'Matagumpay na na-save ang mga pagbabago',
saving: 'Nagse-save...',
auto_saved: 'Na-auto-save',
save_error: 'Error sa pag-save',
save_failed: 'Nabigo ang auto-save',
network_error: 'Error sa network. Mangyaring suriin ang iyong koneksyon.',
present_label: 'Dumalo',
absent_label: 'Wala',
attended_today: 'Dumalo ngayon',
not_attended: 'Hindi dumalo',
total_members: 'Kabuuang Miyembro',
church_family: 'Pamilya ng simbahan',
// record attendance
attendance_records: 'Mga Rekord ng Pagdalo',
attendance_records_desc: 'Tingnan at suriin ang datos ng pagdalo sa simbahan',
input_attendance: 'Mag-input ng Pagdalo',
total_members_label: 'Kabuuang Miyembro',
registered: 'Narekord',
present_today: 'Dumalo Ngayon',
attended: 'Dumalo',
absent_today: 'Wala Ngayon',
attendance_details: 'Mga Detalye ng Pagdalo',
present_short: 'Dumalo',
members_short: 'Miyembro',
age_label: 'Edad',
status_label: 'Katayuan',
notes_label: 'Mga Nota',
present_option: 'Dumalo',
absent_option: 'Wala',
today: 'Ngayon',
last_sunday: 'Nakaraang Linggo',
previous: 'Nakaraan',
total_members_footer: 'Kabuuang miyembro:',
present_footer: 'Dumalo:',
absent_footer: 'Wala:',
only_sundays_records_desc: 'Ang mga rekord ng pagdalo ay makikita lamang sa mga Linggo. Mangyaring pumili ng petsa sa Linggo.',
invalid_date: 'Hindi wastong petsa',
select_date_label: 'Pumili ng petsa',
ok_understand: 'OK, Naiintindihan Ko',
member_info: 'Impormasyon ng Miyembro',
choir_member: 'Miyembro ng Koro',
no_members_found: 'Walang mga miyembro na natagpuan. Mangyaring magdagdag ng mga miyembro muna.',
date_label: 'PETSA'
    }
};

        // ============================================
        // LANGUAGE MANAGEMENT
        // ============================================
        let currentLanguage = localStorage.getItem('tinc-language') || '{{ $currentLang }}' || 'en';

        function t(key) {
            const translation = translations[currentLanguage]?.[key];
            if (translation) return translation;
            const englishTranslation = translations.en[key];
            if (englishTranslation) return englishTranslation;
            return key;
        }

        function applyTranslations() {
            // Update all elements with data-i18n attribute
            document.querySelectorAll('[data-i18n]').forEach(element => {
                const key = element.getAttribute('data-i18n');
                const translation = t(key);
                
                const hasIcon = element.querySelector('i');
                
                if (element.textContent.trim() === '') {
                    element.textContent = translation;
                } else {
                    const textNodes = Array.from(element.childNodes).filter(node => node.nodeType === 3);
                    
                    if (textNodes.length > 0) {
                        textNodes.forEach(node => {
                            node.textContent = translation;
                        });
                    } else if (hasIcon) {
                        const textNode = document.createTextNode(' ' + translation);
                        element.appendChild(textNode);
                    } else {
                        element.textContent = translation;
                    }
                }
            });
            
            // Update all elements with data-i18n-placeholder
            document.querySelectorAll('[data-i18n-placeholder]').forEach(element => {
                const key = element.getAttribute('data-i18n-placeholder');
                element.placeholder = t(key);
            });
            
            // Update HTML lang attribute
            document.documentElement.lang = currentLanguage;
            
            // Update chart labels if chart exists
            if (window.financeChart) {
                updateChartLabels();
            }
        }

        // ============================================
        // USER DROPDOWN TOGGLE
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
        // LANGUAGE SELECTOR
        // ============================================
        document.querySelectorAll('.language-option').forEach(btn => {
            btn.addEventListener('click', function() {
                const lang = this.dataset.lang;

                document.querySelectorAll('.language-option').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                currentLanguage = lang;
                localStorage.setItem('tinc-language', lang);

                applyTranslations();

                const liveSpan = document.querySelector('.live-indicator span:last-child');
                if (liveSpan) {
                    liveSpan.textContent = t('live');
                }

                showToastNotification('success', 'Language Updated', t('language_updated'));

                fetch('{{ route("settings.language") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ locale: lang })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        showToastNotification('error', 'Error', 'Failed to save language preference');
                    }
                })
                .catch(() => {
                    showToastNotification('error', 'Error', 'Failed to save language preference');
                });

                dropdownToggle.classList.remove('active');
                dropdownMenu.classList.remove('show');
            });
        });

        // ============================================
        // SECURITY SETTINGS MODAL
        // ============================================
        const securityModal = new bootstrap.Modal(document.getElementById('securitySettingsModal'));
        document.getElementById('securitySettingsBtn').addEventListener('click', function() {
            securityModal.show();
            dropdownToggle.classList.remove('active');
            dropdownMenu.classList.remove('show');
        });

        // Password strength checker
        const newPassword = document.getElementById('newPassword');
        const strengthText = document.getElementById('strengthText');
        const strengthBar = document.getElementById('strengthBar');

        if (newPassword) {
            newPassword.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                let level = 'weak';
                let color = '#B03B34';
                let width = 0;

                if (password.length >= 8) strength += 1;
                if (password.match(/[a-z]/)) strength += 1;
                if (password.match(/[A-Z]/)) strength += 1;
                if (password.match(/[0-9]/)) strength += 1;
                if (password.match(/[^a-zA-Z0-9]/)) strength += 1;

                if (strength <= 2) { level = 'weak'; color = '#B03B34'; width = 20; }
                else if (strength <= 3) { level = 'medium'; color = '#F5A623'; width = 60; }
                else { level = 'strong'; color = '#2A7048'; width = 100; }

                strengthText.textContent = t(level);
                strengthText.style.color = color;
                strengthBar.style.width = width + '%';
                strengthBar.style.background = color;
            });
        }

        // Two-Factor Toggle
        document.getElementById('twoFactorToggle')?.addEventListener('change', function() {
            const enabled = this.checked;
            fetch('{{ route("settings.two-factor") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ enabled: enabled })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToastNotification('success', 'Security', enabled ? t('two_factor_enabled') : t('two_factor_disabled'));
                }
            })
            .catch(() => {
                showToastNotification('error', 'Error', 'Failed to update two-factor authentication');
            });
        });

        // Session Timeout
        document.getElementById('sessionTimeout')?.addEventListener('change', function() {
            const timeout = parseInt(this.value);
            fetch('{{ route("settings.session-timeout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ timeout: timeout })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToastNotification('success', 'Security', t('session_timeout_updated'));
                }
            })
            .catch(() => {
                showToastNotification('error', 'Error', 'Failed to update session timeout');
            });
        });

        // Logout All Sessions
        document.getElementById('logoutAllSessions')?.addEventListener('click', function() {
            if (confirm('Are you sure you want to log out all other sessions?')) {
                fetch('{{ route("settings.logout-all") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToastNotification('success', 'Security', t('all_sessions_logged_out'));
                    }
                })
                .catch(() => {
                    showToastNotification('error', 'Error', 'Failed to logout all sessions');
                });
            }
        });

        // Save Security Settings (Password)
        document.getElementById('saveSecuritySettings')?.addEventListener('click', function() {
            const currentPw = document.getElementById('currentPassword')?.value;
            const newPw = document.getElementById('newPassword')?.value;
            const confirmPw = document.getElementById('confirmPassword')?.value;

            if (newPw && currentPw) {
                if (newPw !== confirmPw) {
                    showToastNotification('error', 'Error', 'Passwords do not match');
                    return;
                }
                if (newPw.length < 8) {
                    showToastNotification('error', 'Error', 'Password must be at least 8 characters');
                    return;
                }

                fetch('{{ route("settings.password") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        current_password: currentPw,
                        new_password: newPw,
                        new_password_confirmation: confirmPw
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToastNotification('success', 'Security', t('password_updated'));
                        document.getElementById('currentPassword').value = '';
                        document.getElementById('newPassword').value = '';
                        document.getElementById('confirmPassword').value = '';
                        securityModal.hide();
                    } else {
                        showToastNotification('error', 'Error', data.message || 'Failed to update password');
                    }
                })
                .catch(() => {
                    showToastNotification('error', 'Error', 'Something went wrong');
                });
            } else {
                securityModal.hide();
            }
        });

        // ============================================
        // TOAST NOTIFICATIONS
        // ============================================
        const toastContainer = document.getElementById('toastContainer');

        function showToastNotification(type, title, message, duration = 5000) {
            if (!toastContainer) return;

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-times-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle',
                message: 'fa-envelope'
            };

            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            toast.innerHTML = `
                <div class="toast-icon ${type}">
                    <i class="fas ${icons[type] || 'fa-bell'}"></i>
                </div>
                <div class="toast-body">
                    <div class="toast-title">${escapeHtml(title)}</div>
                    <div class="toast-message">${escapeHtml(message)}</div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-notification').remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            toastContainer.appendChild(toast);

            const timeoutId = setTimeout(() => {
                if (toast.parentNode) {
                    toast.classList.add('hiding');
                    setTimeout(() => toast.remove(), 300);
                }
            }, duration);

            toast.addEventListener('click', (e) => {
                if (e.target.closest('.toast-close')) return;
                clearTimeout(timeoutId);
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text || '';
            return div.innerHTML;
        }

        window.showToastNotification = showToastNotification;

        // ============================================
        // FINANCE CHART
        // ============================================
        function initializeChart() {
            const canvas = document.getElementById('financeChart');
            if (!canvas) return;

            const monthsData = @json($months ?? []);
            const incomeData = @json($incomeData ?? []);
            const expenseData = @json($expenseData ?? []);

            let months = Array.isArray(monthsData) && monthsData.length > 0 ? monthsData : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            let income = Array.isArray(incomeData) && incomeData.length > 0 ? incomeData : [0, 0, 0, 0, 0, 0];
            let expense = Array.isArray(expenseData) && expenseData.length > 0 ? expenseData : [0, 0, 0, 0, 0, 0];

            while (income.length < months.length) income.push(0);
            while (expense.length < months.length) expense.push(0);

            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
            const tickColor = isDark ? 'rgba(255,255,255,0.4)' : '#888';

            const chart = new Chart(canvas, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: t('income'),
                            data: income,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.05)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#10B981',
                            pointBorderColor: isDark ? '#1e1e1e' : '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6
                        },
                        {
                            label: t('expenses'),
                            data: expense,
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.05)',
                            borderWidth: 2,
                            borderDash: [5, 3],
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#EF4444',
                            pointBorderColor: isDark ? '#1e1e1e' : '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: { size: 11, weight: '600' },
                                color: getComputedStyle(document.documentElement).getPropertyValue('--text-primary').trim(),
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: isDark ? '#2a2a2a' : '#fff',
                            titleColor: isDark ? '#e0e0e0' : '#1e293b',
                            bodyColor: isDark ? '#aaa' : '#475569',
                            borderColor: isDark ? 'rgba(255,255,255,0.1)' : '#e2e8f0',
                            borderWidth: 1,
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(ctx) {
                                    return ctx.dataset.label + ': ₱' + ctx.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₱' + value.toLocaleString();
                                },
                                font: { size: 11 },
                                color: tickColor
                            },
                            grid: {
                                color: gridColor,
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: { size: 11 },
                                color: tickColor
                            },
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });

            window.financeChart = chart;
            return chart;
        }

        function updateChartLabels() {
            const chart = window.financeChart;
            if (!chart) return;
            
            chart.data.datasets[0].label = t('income');
            chart.data.datasets[1].label = t('expenses');
            chart.update();
        }

        // ============================================
        // THEME CHANGE FOR CHART
        // ============================================
        const themeObserver = new MutationObserver(function() {
            const chart = window.financeChart;
            if (!chart) return;
            
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
            const tickColor = isDark ? 'rgba(255,255,255,0.4)' : '#888';
            
            chart.options.scales.y.grid.color = gridColor;
            chart.options.scales.y.ticks.color = tickColor;
            chart.options.scales.x.ticks.color = tickColor;
            chart.update();
        });

        themeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-theme']
        });

        // ============================================
        // REVERB REAL-TIME BROADCASTING
        // ============================================
        window.Pusher = Pusher;

        const echoConfig = {
            broadcaster: 'reverb',
            key: '{{ env("REVERB_APP_KEY") }}',
            wsHost: '{{ env("REVERB_HOST", "127.0.0.1") }}',
            wsPort: {{ env("REVERB_PORT", 8080) }},
            wssPort: {{ env("REVERB_PORT", 8080) }},
            forceTLS: false,
            enabledTransports: ['ws', 'wss'],
        };

        window.Echo = new Echo(echoConfig);

        const liveIndicator = document.getElementById('liveIndicator');

        function updateConnectionStatus(status) {
            if (!liveIndicator) return;
            liveIndicator.classList.remove('connected', 'disconnected', 'connecting');
            if (status === 'connected') {
                liveIndicator.classList.add('connected');
                liveIndicator.innerHTML = `<span class="pulse"></span><span>${t('live')}</span>`;
            } else if (status === 'connecting') {
                liveIndicator.classList.add('connecting');
                liveIndicator.innerHTML = '<span class="pulse"></span><span>Connecting...</span>';
            } else {
                liveIndicator.classList.add('disconnected');
                liveIndicator.innerHTML = '<span class="pulse"></span><span>Offline</span>';
            }
        }

        updateConnectionStatus('connecting');

        if (window.Echo) {
            window.Echo.channel('attendance')
                .listen('attendance.updated', (e) => {
                    showToastNotification('success', 'Attendance Updated',
                        `${e.church || 'Church'}: ${e.present || 0} present, ${e.absent || 0} absent`);
                    updateAttendanceStats(e);
                });

            window.Echo.channel('finances')
                .listen('balance.updated', (e) => {
                    const amount = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(e.balance || 0);
                    showToastNotification('success', 'Balance Updated',
                        `${e.eglesia_name || 'Church'}: ${amount}`);
                    updateBalanceStats(e);
                });

            window.Echo.channel('choir')
                .listen('schedule.updated', (e) => {
                    showToastNotification('info', 'Choir Schedule', e.message || 'Schedule updated');
                    updateChoirSchedule(e);
                });

            const userId = document.querySelector('meta[name="user-id"]')?.content || '{{ Auth::user()?->id ?? 0 }}';

            if (userId && userId !== '0') {
                window.Echo.channel(`messages.{{ Auth::user()->church_id }}`)
                    .listen('message.new', (e) => {
                        const msgDot = document.querySelector('.header-message-btn .msg-dot');
                        const sidebarBadge = document.querySelector('.nav-item .message-badge');

                        if (msgDot) {
                            const current = parseInt(msgDot.textContent) || 0;
                            msgDot.textContent = current + 1;
                            msgDot.style.display = 'flex';
                        }
                        if (sidebarBadge) {
                            const current = parseInt(sidebarBadge.textContent) || 0;
                            sidebarBadge.textContent = current + 1;
                        }

                        const badge = document.getElementById('notifCount');
                        if (badge) {
                            const current = parseInt(badge.textContent) || 0;
                            badge.textContent = current + 1;
                            badge.style.display = 'flex';
                            badge.classList.add('has-messages');
                        }

                        showToastNotification(
                            'message',
                            `New Message from ${e.sender_name}`,
                            e.subject + ': ' + e.body.substring(0, 100),
                            6000
                        );
                    });
            }

            if (window.Echo.connector && window.Echo.connector.socket) {
                window.Echo.connector.socket.on('connect', () => updateConnectionStatus('connected'));
                window.Echo.connector.socket.on('disconnect', () => updateConnectionStatus('disconnected'));
            }
        }

        function updateAttendanceStats(e) {
            const present = e.present || e.presentCount || 0;
            const absent = e.absent || e.absentCount || 0;
            const total = e.total || e.totalMembers || 0;
            const visitors = e.visitors || e.visitorCount || 0;

            ['stat-present', 'stat-absent', 'stat-total', 'stat-visitors'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    const val = id === 'stat-present' ? present :
                               id === 'stat-absent' ? absent :
                               id === 'stat-total' ? total : visitors;
                    el.textContent = val;
                    el.classList.add('updated');
                    setTimeout(() => el.classList.remove('updated'), 2000);
                }
            });

            const percentEl = document.getElementById('stat-present-percent');
            if (percentEl) {
                const percent = total > 0 ? Math.round((present / total) * 100) : 0;
                percentEl.textContent = percent + '% attendance rate';
            }
        }

        function updateBalanceStats(e) {
            const balanceEl = document.getElementById(`balance-${e.eglesia_id}`);
            if (balanceEl) {
                const amount = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(e.balance || 0);
                balanceEl.textContent = amount;
                balanceEl.classList.add('updated');
                setTimeout(() => balanceEl.classList.remove('updated'), 2000);
            }
        }

        function updateChoirSchedule(e) {
            if (e.action === 'created') {
                const list = document.getElementById('choir-schedule-list');
                if (list) {
                    const item = document.createElement('li');
                    item.className = 'list-group-item new-item';
                    item.innerHTML = `
                        <strong>${e.event_name || 'New Event'}</strong><br>
                        ${e.date || 'TBD'} at ${e.time || 'TBD'}<br>
                        ${e.location || 'Location TBD'}
                        <span class="badge bg-success float-end">New</span>
                    `;
                    list.prepend(item);
                    setTimeout(() => item.classList.remove('new-item'), 5000);
                }
            }
        }

        window.showToastNotification = showToastNotification;
        window.updateAttendanceStats = updateAttendanceStats;
        window.updateBalanceStats = updateBalanceStats;
        window.updateChoirSchedule = updateChoirSchedule;
        window.updateConnectionStatus = updateConnectionStatus;
        window.t = t;
        window.applyTranslations = applyTranslations;
        window.initializeChart = initializeChart;
        window.updateChartLabels = updateChartLabels;
    </script>

    <!-- ============================================ -->
    <!-- ADDITIONAL SCRIPTS -->
    <!-- ============================================ -->
    <script>
        // ===== THEME TOGGLE =====
        const fabToggle = document.getElementById('fabThemeToggle');
        const fabIcon = document.getElementById('fabThemeIcon');
        const htmlElement = document.documentElement;

        const savedTheme = localStorage.getItem('tinc-theme') || 'light';
        htmlElement.setAttribute('data-theme', savedTheme);

        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                fabIcon.className = 'fas fa-sun';
                fabToggle.setAttribute('data-tooltip', 'Switch to Light Mode');
            } else {
                fabIcon.className = 'fas fa-moon';
                fabToggle.setAttribute('data-tooltip', 'Switch to Dark Mode');
            }
        }
        updateThemeIcon(savedTheme);

        fabToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('tinc-theme', newTheme);
            updateThemeIcon(newTheme);
        });

        // ===== AUTO-HIDE ALERTS =====
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // ===== LOGO UPLOAD =====
        const logoTrigger = document.getElementById('logoTrigger');
        const logoFileInput = document.getElementById('logoFileInput');
        const logoToast = document.getElementById('logoToast');
        const logoToastMsg = document.getElementById('logoToastMsg');

        if (logoTrigger) {
            logoTrigger.addEventListener('click', () => logoFileInput.click());
        }

        if (logoFileInput) {
            logoFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('logo', file);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('{{ route("settings.logo.update") }}', {
                    method: 'POST',
                    body: formData,
                })
                .then(res => res.json())
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
                .catch(() => {
                    showLogoToast('error', '<i class="fas fa-times-circle"></i>', 'Something went wrong.');
                });

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

        // ===== MOBILE SIDEBAR =====
        if (window.innerWidth <= 768) {
            const sidebar = document.getElementById('sidebar');
            const headerLeft = document.querySelector('.header-left');
            const toggleBtn = document.createElement('button');
            toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
            toggleBtn.style.cssText = 'background: none; border: none; font-size: 1.2rem; color: var(--text-primary); margin-right: 0.5rem; cursor: pointer; padding: 4px;';
            toggleBtn.onclick = () => sidebar.classList.toggle('mobile-open');
            if (headerLeft) headerLeft.prepend(toggleBtn);
        }

        // ===== NOTIFICATION MANAGER =====
        class NotificationManager {
            constructor() {
                this.bell = document.getElementById('notificationBell');
                this.dropdown = document.getElementById('notificationDropdown');
                this.notifList = document.getElementById('notificationList');
                this.notifCount = document.getElementById('notifCount');
                this.totalCountSpan = document.getElementById('notifTotalCount');
                this.isOpen = false;
                this.init();
            }

            init() {
                this.fetchNotifications();
                this.setupEventListeners();
                setInterval(() => this.fetchNotifications(), 60000);
            }

            async fetchNotifications() {
                try {
                    const response = await fetch('{{ route("notifications.get") }}');
                    const data = await response.json();

                    if (data.success) {
                        this.updateBadge(data.count);
                        this.renderNotifications(data.notifications || []);

                        if (data.new_notifications && data.new_notifications.length > 0) {
                            data.new_notifications.forEach(notif => {
                                showToastNotification(notif.type || 'info', notif.title, notif.message, 5000);
                            });
                        }
                    }
                } catch (error) {
                    console.log('Failed to fetch notifications:', error);
                }
            }

            setupEventListeners() {
                if (this.bell) {
                    this.bell.addEventListener('click', (e) => {
                        e.stopPropagation();
                        this.toggleDropdown();
                    });
                }

                document.addEventListener('click', (e) => {
                    if (this.dropdown && !this.dropdown.contains(e.target) &&
                        !this.bell.contains(e.target)) {
                        this.closeDropdown();
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.isOpen) {
                        this.closeDropdown();
                    }
                });
            }

            toggleDropdown() {
                if (this.isOpen) { this.closeDropdown(); } else { this.openDropdown(); }
            }

            openDropdown() {
                if (!this.dropdown) return;
                this.dropdown.classList.add('show');
                this.isOpen = true;
                this.markAllAsRead();
            }

            closeDropdown() {
                if (!this.dropdown) return;
                this.dropdown.classList.remove('show');
                this.isOpen = false;
            }

            async markAllAsRead() {
                try {
                    await fetch('{{ route("notifications.mark-read") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    this.updateBadge(0);
                } catch (error) {
                    console.log('Failed to mark notifications as read:', error);
                }
            }

            renderNotifications(notifications) {
                if (!this.notifList) return;

                const unreadCount = this.notifCount.textContent;

                if (notifications.length === 0 && (unreadCount === '0' || unreadCount === '')) {
                    this.notifList.innerHTML = `
                        <div class="dropdown-empty">
                            <i class="fas fa-bell-slash"></i>
                            <span>All caught up</span>
                            <small style="display: block; font-size: 0.7rem; margin-top: 4px; opacity: 0.6;">No new notifications</small>
                        </div>
                    `;
                    return;
                }

                this.notifList.innerHTML = notifications.map(notif => `
                    <div class="notification-item ${notif.read ? '' : 'unread'}"
                         onclick="window.location.href='${notif.link || '#'}'">
                        <div class="notification-icon ${notif.type || 'info'}">
                            <i class="fas ${notif.icon || 'fa-bell'}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${escapeHtml(notif.title)}</div>
                            <div class="notification-message">${escapeHtml(notif.message)}</div>
                            <div class="notification-time">
                                <i class="fas fa-clock"></i> ${escapeHtml(notif.time || 'Just now')}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            updateBadge(count) {
                const notifDot = this.notifCount;
                const totalSpan = this.totalCountSpan;

                if (count > 0) {
                    const displayCount = count > 99 ? '99+' : count;
                    notifDot.textContent = displayCount;
                    notifDot.style.display = 'flex';
                    notifDot.classList.add('has-messages');
                    if (totalSpan) { totalSpan.textContent = displayCount; }
                } else {
                    notifDot.style.display = 'none';
                    notifDot.classList.remove('has-messages');
                    if (totalSpan) { totalSpan.textContent = '0'; }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyTranslations();
            
            // Initialize chart if it exists
            if (document.getElementById('financeChart')) {
                initializeChart();
            }
            
            new NotificationManager();
            
            const liveSpan = document.querySelector('.live-indicator span:last-child');
            if (liveSpan) {
                liveSpan.textContent = t('live');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>