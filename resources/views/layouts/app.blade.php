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
            
            /* NEW: Language & Security variables */
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

        /* ===== AMBIENT BACKGROUND ===== */
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

        /* ===== SIDEBAR - FIXED ===== */
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

        /* ===== LOGO - FIXED ===== */
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

        /* ===== NAVIGATION ===== */
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

        /* ===== USER SECTION ===== */
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

        /* ===== MAIN CONTENT ===== */
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

        /* ===== TOP HEADER ===== */
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

        /* ===== CONTENT AREA ===== */
        .content-area {
            padding: 1.5rem 2rem 2rem;
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== LIVE INDICATOR ===== */
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

        /* ===== MESSAGE BUTTON ===== */
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

        /* ===== NOTIFICATION BUTTON ===== */
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

        /* ===== NOTIFICATION DROPDOWN ===== */
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

        /* ===== TOAST NOTIFICATIONS ===== */
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

        /* ===== USER DROPDOWN (NEW) ===== */
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

        /* ===== LANGUAGE SELECTOR ===== */
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

        /* ===== SECURITY SETTINGS MODAL ===== */
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

        /* ===== TOGGLE SWITCH ===== */
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

        /* ===== ALERTS ===== */
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

        /* ===== CARDS ===== */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            transition: box-shadow 0.25s ease, transform 0.25s ease;
            color: var(--text-primary);
        }
        .card:hover { box-shadow: var(--card-hover-shadow); transform: translateY(-2px); }

        /* ===== FORM CONTROLS ===== */
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

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
        }
        .btn-primary:hover { background: var(--ink-deep); }

        /* ===== MODAL ===== */
        .modal-content {
            background: var(--modal-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
        }
        .modal-header { border-bottom: 1px solid var(--border-color); padding: 1.2rem 1.5rem; }
        .modal-footer { border-top: 1px solid var(--border-color); padding: 1rem 1.5rem; }

        /* ===== TABLES ===== */
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

        /* ===== LOGO TOAST ===== */
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

        /* ===== FLOATING THEME TOGGLE ===== */
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

        /* ===== PROFILE PICTURE UPLOAD ===== */
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

        /* ===== RESPONSIVE ===== */
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
        <!-- Logo - FIXED -->
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

        <!-- Navigation - SCROLLABLE -->
        <div class="nav-menu-wrap">
            <nav class="nav-menu">
                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-th-large"></i> Main Menu</div>

                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>

                    <a href="{{ route('members.index') }}" class="nav-item {{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Members
                    </a>

                    <a href="{{ route('finance.index') }}" class="nav-item {{ request()->routeIs('finance.*') ? 'active' : '' }}">
                        <i class="fas fa-coins"></i> Finance
                        <span class="nav-badge finance"><i class="fas fa-arrow-trend-up"></i></span>
                    </a>

                    <a href="{{ route('sunday-attendance.index') }}" class="nav-item {{ request()->routeIs('sunday-attendance.*') ? 'active' : '' }}">
                        <i class="fas fa-church"></i> Sunday Service
                    </a>

                    <a href="{{ route('inventory.index') }}" class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                        <i class="fas fa-boxes"></i> Inventory
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-comment-dots"></i> Communication</div>

                    <a href="{{ route('messages.index') }}" class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i> Messages
                        @if($unreadMsgCount > 0)
                            <span class="nav-badge message-badge">{{ $unreadMsgCount > 99 ? '99+' : $unreadMsgCount }}</span>
                        @endif
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-music"></i> Choir Ministry</div>

                    <a href="{{ route('choir-members.index') }}" class="nav-item {{ request()->routeIs('choir-members.*') ? 'active' : '' }}">
                        <i class="fas fa-music"></i> Choir Members
                        @php
                            $choirCount = $user?->church_id ? \App\Models\Member::where('church_id', $user->church_id)->where('is_choir', true)->count() : 0;
                        @endphp
                        @if($choirCount > 0)
                            <span class="nav-badge">{{ $choirCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('choir-schedules.index') }}" class="nav-item {{ request()->routeIs('choir-schedules.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Schedules
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title"><i class="fas fa-chart-line"></i> Reports</div>

                    <a href="{{ route('reports.analytics') }}" class="nav-item {{ request()->routeIs('reports.analytics') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i> Reports &amp; Analytics
                    </a>
                </div>
            </nav>
        </div>

        <!-- User Section - FIXED -->
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
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">
        <!-- Top Header - FIXED -->
        <header class="top-header">
            <div class="header-left">
                <h1>@yield('header', 'Dashboard')</h1>
            </div>

            <div class="header-right">
                <!-- Live Connection Status -->
                <div class="live-indicator connected" id="liveIndicator">
                    <span class="pulse"></span>
                    <span>Live</span>
                </div>

                <!-- Message Button -->
                <a href="{{ route('messages.index') }}" class="header-message-btn" title="Messages">
                    <i class="fas fa-envelope"></i>
                    @if($unreadMsgCount > 0)
                        <span class="msg-dot">{{ $unreadMsgCount > 99 ? '99+' : $unreadMsgCount }}</span>
                    @endif
                </a>

                <!-- Notifications -->
                <div style="position: relative;">
                    <button class="header-notif" id="notificationBell" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notif-dot {{ $unreadMsgCount > 0 ? 'has-messages' : '' }}" id="notifCount" style="{{ $unreadMsgCount > 0 ? 'display: flex;' : 'display: none;' }}">
                            {{ $unreadMsgCount > 0 ? ($unreadMsgCount > 99 ? '99+' : $unreadMsgCount) : '0' }}
                        </span>
                    </button>

                    <!-- Notification Dropdown -->
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
                                <i class="fas fa-envelope"></i> Go to Messages
                                @if($unreadMsgCount > 0)
                                    <span class="msg-count-badge">{{ $unreadMsgCount }}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ===== NEW: USER DROPDOWN WITH LANGUAGE & SECURITY ===== -->
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

                    <!-- User Dropdown Menu -->
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <!-- User Header -->
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

                        <!-- Language Selector -->
                        <div class="language-selector-wrapper">
                            <label><i class="fas fa-globe"></i> Language / Pinulongan</label>
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

                        <!-- Profile Link -->
                        <a href="{{ route('profile.edit') }}" class="dropdown-menu-item">
                            <i class="fas fa-user-cog"></i>
                            <span>My Profile</span>
                        </a>

                        <!-- Security Settings -->
                        <button class="dropdown-menu-item" id="securitySettingsBtn">
                            <i class="fas fa-shield-alt"></i>
                            <span>Security Settings</span>
                            <span class="badge">Secure</span>
                        </button>

                        <div class="dropdown-divider"></div>

                        <!-- Sign Out -->
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-dropdown">
                            @csrf
                            <button type="submit" class="dropdown-menu-item danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content - SCROLLABLE -->
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
                    <h5 class="modal-title"><i class="fas fa-shield-alt me-2"></i> Security Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Two-Factor Authentication -->
                    <div class="security-setting-item">
                        <div class="setting-info">
                            <h6>Two-Factor Authentication</h6>
                            <p>Add an extra layer of security to your account</p>
                        </div>
                        <div class="setting-control">
                            <label class="toggle-switch">
                                <input type="checkbox" id="twoFactorToggle" {{ ($user?->two_factor_enabled ?? false) ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Session Timeout -->
                    <div class="security-setting-item">
                        <div class="setting-info">
                            <h6>Session Timeout</h6>
                            <p>Automatically log out after inactivity</p>
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

                    <!-- Change Password -->
                    <div class="password-change-form">
                        <h6 style="font-weight:600;margin-bottom:0.75rem;">Change Password</h6>
                        <form id="passwordChangeForm">
                            @csrf
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" class="form-control form-control-sm" id="currentPassword" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control form-control-sm" id="newPassword" required minlength="8">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control form-control-sm" id="confirmPassword" required>
                            </div>
                            <div id="passwordStrength" class="mt-2" style="font-size:0.8rem;color:var(--text-muted);">
                                <span>Password strength:</span>
                                <span id="strengthText">Weak</span>
                                <div class="progress mt-1" style="height:4px;">
                                    <div id="strengthBar" class="progress-bar" style="width:0%;background:#B03B34;" role="progressbar"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Active Sessions -->
                    <div class="security-setting-item" style="border-bottom:none;padding-bottom:0;">
                        <div class="setting-info">
                            <h6>Active Sessions</h6>
                            <p>Manage where you're currently logged in</p>
                        </div>
                        <div class="setting-control">
                            <button class="btn btn-sm btn-outline-danger" id="logoutAllSessions">Logout All</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveSecuritySettings">Save Changes</button>
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
                    if (data.success) {
                        showToastNotification('success', 'Language Updated', 'Language changed successfully');
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
                let level = 'Weak';
                let color = '#B03B34';
                let width = 0;

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
                    showToastNotification('success', 'Security', enabled ? 'Two-factor authentication enabled' : 'Two-factor authentication disabled');
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
                    showToastNotification('success', 'Security', 'Session timeout updated successfully');
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
                        showToastNotification('success', 'Security', 'All other sessions logged out');
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
                        showToastNotification('success', 'Security', 'Password updated successfully');
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
        window.updateAttendanceStats = updateAttendanceStats;
        window.updateBalanceStats = updateBalanceStats;
        window.updateChoirSchedule = updateChoirSchedule;
        window.updateConnectionStatus = updateConnectionStatus;
    </script>

    <!-- ============================================ -->
    <!-- ADDITIONAL SCRIPTS (Your Existing Code) -->
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
            new NotificationManager();
        });
    </script>

    @stack('scripts')
</body>
</html>