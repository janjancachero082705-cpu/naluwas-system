<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Church OS · Dark Sidebar</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <style>
        /* ============================================================
           ROOT VARIABLES
           ============================================================ */
        :root {
            /* ---- SIDEBAR — DARKER BLUE ---- */
            --sidebar-bg: #0b1a2e;
            --sidebar-surface: #10233d;
            --sidebar-surface-hover: #1a3152;
            --sidebar-border: rgba(255, 255, 255, 0.06);
            --sidebar-text: #ffffff;
            --sidebar-text-muted: #8aa8d0;
            --sidebar-text-primary: #ffffff;
            --sidebar-accent: #d4a853;
            --sidebar-accent-glow: rgba(212, 168, 83, 0.25);
            --sidebar-active-bg: rgba(212, 168, 83, 0.12);
            --sidebar-icon-bg: rgba(255, 255, 255, 0.03);
            --sidebar-icon-hover: rgba(212, 168, 83, 0.18);
            --sidebar-badge-bg: rgba(212, 168, 83, 0.15);
            --sidebar-badge-text: #d4a853;
            --sidebar-user-bg: rgba(255, 255, 255, 0.02);

            /* ---- MAIN CONTENT ---- */
            --bg-body: #f0f2f6;
            --surface: #ffffff;
            --surface-hover: #f5f7fb;
            --text-primary: #1a2636;
            --text-secondary: #4a5a72;
            --text-muted: #8a9bb0;
            --border-light: #e4e9f0;
            --accent: #4a7ab5;
            --accent-light: #e8eef8;
            --accent-dark: #2a5a8a;
            --shadow-card: 0 8px 24px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 20px 40px -12px rgba(0, 20, 40, 0.12);

            /* ---- Shared ---- */
            --radius-xl: 16px;
            --radius-lg: 12px;
            --radius-md: 8px;
            --radius-sm: 6px;
            --sidebar-width: 276px;
            --header-height: 68px;
            --transition: 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        /* ---- DARK MODE for main content ONLY ---- */
        [data-theme="dark"] {
            --bg-body: #0d1520;
            --surface: #141e2c;
            --surface-hover: #1b2635;
            --text-primary: #e8edf5;
            --text-secondary: #a8bcd4;
            --text-muted: #6a7f99;
            --border-light: #253247;
            --accent: #5a8ac4;
            --accent-light: #1f3048;
            --accent-dark: #3a6a9a;
            --shadow-card: 0 8px 24px rgba(0, 0, 0, 0.4);
            --shadow-hover: 0 20px 40px -12px rgba(0, 0, 0, 0.6);
        }

        /* ---- RESET ---- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, system-ui, sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            transition: background 0.4s, color 0.4s;
            font-size: 14px;
            line-height: 1.5;
            overflow: hidden;
            height: 100vh;
        }

        /* ============================================================
           SIDEBAR — DARKER BLUE
           ============================================================ */
        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            z-index: 100;
            overflow: hidden;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 4px 0 40px rgba(0, 0, 0, 0.5);
            color: var(--sidebar-text);
        }

        /* Subtle gradient accent overlay */
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(ellipse at 20% 0%, rgba(212, 168, 83, 0.05) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 100%, rgba(74, 122, 181, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .sidebar>* {
            position: relative;
            z-index: 1;
        }

        /* ---- Logo ---- */
        .logo-area {
            padding: 22px 20px 18px 20px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
            background: transparent;
            min-height: 82px;
            position: relative;
        }

        .logo-area::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 24px;
            right: 24px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--sidebar-accent), transparent);
            opacity: 0.2;
        }

        .logo-icon {
            width: 46px;
            height: 46px;
            border-radius: var(--radius-lg);
            background: linear-gradient(135deg, var(--sidebar-accent), #b8923a);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0b1a2e;
            font-size: 20px;
            box-shadow: 0 4px 16px rgba(212, 168, 83, 0.3);
            flex-shrink: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo-icon:hover {
            transform: scale(1.06) rotate(-2deg);
            box-shadow: 0 6px 24px rgba(212, 168, 83, 0.4);
        }

        .logo-text h2 {
            font-family: 'Fraunces', serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: -0.3px;
            color: var(--sidebar-text-primary);
            line-height: 1.2;
            margin: 0;
        }

        .logo-text .sub {
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1.6px;
            color: var(--sidebar-text-muted);
            font-weight: 700;
            margin: 0;
            opacity: 0.8;
        }

        /* ---- Nav Scroll ---- */
        .nav-scroll {
            flex: 1 1 auto;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 14px 12px 14px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.06) transparent;
            min-height: 0;
            position: relative;
        }

        .nav-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .nav-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .nav-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
        }

        /* ---- Nav Groups ---- */
        .nav-group {
            margin-bottom: 20px;
        }

        .nav-group-title {
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--sidebar-text-muted);
            font-weight: 700;
            padding: 0 10px 10px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0.7;
        }

        .nav-group-title i {
            font-size: 0.5rem;
            opacity: 0.5;
            color: var(--sidebar-accent);
        }

        .nav-group-title .title-line {
            flex: 1;
            height: 1px;
            background: var(--sidebar-border);
            opacity: 0.4;
        }

        /* ---- Nav Items ---- */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 14px;
            border-radius: var(--radius-md);
            color: var(--sidebar-text);
            font-weight: 500;
            font-size: 0.82rem;
            transition: all 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            text-decoration: none;
            margin: 1px 0;
            position: relative;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .nav-item .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--sidebar-icon-bg);
            transition: all 0.3s ease;
            flex-shrink: 0;
            border: 1px solid transparent;
        }

        .nav-item .nav-icon i {
            font-size: 0.85rem;
            color: var(--sidebar-text-muted);
            transition: all 0.3s ease;
        }

        .nav-item .nav-text {
            flex: 1;
            transition: color 0.2s;
        }

        .nav-item:hover {
            background: var(--sidebar-surface-hover);
            color: var(--sidebar-text-primary);
            border-color: rgba(255, 255, 255, 0.04);
            transform: translateX(2px);
        }

        .nav-item:hover .nav-icon {
            background: var(--sidebar-icon-hover);
            border-color: rgba(212, 168, 83, 0.2);
            transform: scale(1.05);
        }

        .nav-item:hover .nav-icon i {
            color: var(--sidebar-accent);
        }

        .nav-item.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-text-primary);
            font-weight: 600;
            border-color: rgba(212, 168, 83, 0.2);
            box-shadow: 0 2px 12px rgba(212, 168, 83, 0.06);
        }

        .nav-item.active .nav-icon {
            background: linear-gradient(135deg, rgba(212, 168, 83, 0.2), rgba(212, 168, 83, 0.08));
            border-color: var(--sidebar-accent);
            box-shadow: 0 0 20px rgba(212, 168, 83, 0.1);
        }

        .nav-item.active .nav-icon i {
            color: var(--sidebar-accent);
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: var(--sidebar-accent);
            border-radius: 4px;
            box-shadow: 0 0 12px rgba(212, 168, 83, 0.3);
        }

        .nav-item .nav-arrow {
            color: var(--sidebar-text-muted);
            font-size: 0.5rem;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .nav-item:hover .nav-arrow {
            opacity: 0.5;
            transform: translateX(2px);
            color: var(--sidebar-accent);
        }

        /* ---- Badges ---- */
        .nav-badge {
            margin-left: auto;
            background: var(--sidebar-badge-bg);
            color: var(--sidebar-badge-text);
            font-size: 0.55rem;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 30px;
            font-family: 'IBM Plex Mono', monospace;
            transition: all 0.2s ease;
            border: 1px solid rgba(212, 168, 83, 0.1);
        }

        .nav-badge.danger {
            background: rgba(224, 90, 90, 0.15);
            color: #e07a7a;
            border-color: rgba(224, 90, 90, 0.15);
        }

        .nav-badge.gold {
            background: rgba(212, 168, 83, 0.15);
            color: var(--sidebar-accent);
            border-color: rgba(212, 168, 83, 0.15);
        }

        .nav-badge.success {
            background: rgba(45, 156, 108, 0.15);
            color: #4dbf8a;
            border-color: rgba(45, 156, 108, 0.15);
        }

        .nav-item:hover .nav-badge {
            transform: scale(1.05);
        }

        /* ---- User Section ---- */
        .user-section {
            border-top: 1px solid var(--sidebar-border);
            padding: 14px 14px 16px 14px;
            background: var(--sidebar-user-bg);
            flex-shrink: 0;
            transition: background 0.2s;
            min-height: 78px;
            position: relative;
        }

        .user-section::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 20px;
            right: 20px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--sidebar-accent), transparent);
            opacity: 0.12;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 10px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .user-card:hover {
            background: var(--sidebar-surface-hover);
            border-color: rgba(255, 255, 255, 0.04);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--sidebar-accent), #b8923a);
            color: #0b1a2e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
            box-shadow: 0 2px 12px rgba(212, 168, 83, 0.25);
            transition: all 0.3s ease;
            position: relative;
        }

        .user-avatar::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: #2d9c6c;
            border-radius: 50%;
            border: 2px solid var(--sidebar-bg);
        }

        .user-card:hover .user-avatar {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(212, 168, 83, 0.35);
        }

        .user-meta {
            flex: 1;
            min-width: 0;
        }

        .user-meta .name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--sidebar-text-primary);
            line-height: 1.2;
        }

        .user-meta .role {
            font-size: 0.55rem;
            color: var(--sidebar-text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .user-chevron {
            color: var(--sidebar-text-muted);
            font-size: 0.65rem;
            transition: all 0.3s ease;
            background: var(--sidebar-icon-bg);
            width: 26px;
            height: 26px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--sidebar-border);
        }

        .user-card:hover .user-chevron {
            background: var(--sidebar-icon-hover);
            border-color: rgba(212, 168, 83, 0.2);
            color: var(--sidebar-accent);
        }

        .user-section.open .user-chevron {
            transform: rotate(180deg);
            background: var(--sidebar-accent);
            border-color: var(--sidebar-accent);
            color: #0b1a2e;
        }

        .logout-panel {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.35s ease, margin 0.3s;
            margin-top: 0;
        }

        .user-section.open .logout-panel {
            max-height: 72px;
            opacity: 1;
            margin-top: 12px;
        }

        .logout-btn {
            width: 100%;
            padding: 9px 14px;
            border-radius: var(--radius-sm);
            background: rgba(212, 168, 83, 0.06);
            border: 1px solid rgba(212, 168, 83, 0.1);
            color: var(--sidebar-accent);
            font-weight: 600;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(212, 168, 83, 0.12);
            border-color: rgba(212, 168, 83, 0.25);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(212, 168, 83, 0.08);
        }

        .logout-btn i {
            transition: transform 0.3s;
        }

        .logout-btn:hover i {
            transform: translateX(-3px);
        }

        /* ============================================================
           MAIN CONTENT
           ============================================================ */
        .main {
            flex: 1;
            padding: 28px 36px 40px 36px;
            background: var(--bg-body);
            transition: background 0.4s;
            overflow-y: auto;
            height: 100vh;
        }

        .main::-webkit-scrollbar {
            width: 5px;
        }
        .main::-webkit-scrollbar-track {
            background: transparent;
        }
        .main::-webkit-scrollbar-thumb {
            background: var(--border-light);
            border-radius: 20px;
        }

        /* ---- Top Bar ---- */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .top-bar h1 {
            font-family: 'Fraunces', serif;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: -0.3px;
            color: var(--text-primary);
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            padding: 4px 14px 4px 10px;
            border-radius: 40px;
            border: 1px solid var(--border-light);
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--text-secondary);
            box-shadow: var(--shadow-card);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2d9c6c;
            display: inline-block;
            animation: pulse-dot 1.8s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.3; transform: scale(0.7); }
        }

        .icon-btn {
            background: var(--surface);
            border: 1px solid var(--border-light);
            border-radius: 40px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.25s;
            position: relative;
            box-shadow: var(--shadow-card);
        }

        .icon-btn:hover {
            background: var(--surface-hover);
            color: var(--text-primary);
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .icon-btn .badge-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #c84a4a;
            color: white;
            font-size: 0.5rem;
            font-weight: 700;
            padding: 0 5px;
            border-radius: 30px;
            border: 2px solid var(--surface);
            min-width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle {
            background: var(--surface);
            border: 1px solid var(--border-light);
            border-radius: 40px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.25s;
            box-shadow: var(--shadow-card);
        }

        .theme-toggle:hover {
            background: var(--surface-hover);
            color: var(--accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        /* ---- Cards ---- */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 18px;
            margin-top: 18px;
        }

        .stat-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 18px 20px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            transition: 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), transparent);
            opacity: 0.3;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-4px);
        }

        .stat-card .stat-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .stat-card .stat-value {
            font-family: 'Fraunces', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 4px 0 2px;
        }

        .stat-card .stat-change {
            font-size: 0.7rem;
            color: var(--text-secondary);
        }

        .stat-card .stat-icon {
            float: right;
            font-size: 1.6rem;
            opacity: 0.12;
            color: var(--accent);
        }

        /* ---- Bottom Card ---- */
        .bottom-card {
            margin-top: 28px;
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            padding: 22px 26px;
            box-shadow: var(--shadow-card);
            transition: 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .bottom-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .bottom-card h3 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .bottom-card p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: 4px;
        }

        .tag-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .tag {
            background: var(--surface-hover);
            padding: 4px 14px;
            border-radius: 40px;
            font-size: 0.75rem;
            color: var(--text-secondary);
            border: 1px solid var(--border-light);
            transition: 0.2s;
        }

        .tag:hover {
            background: var(--accent-light);
            border-color: var(--accent);
            color: var(--text-primary);
        }

        /* ============================================================
           TOAST
           ============================================================ */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            max-width: 340px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            background: var(--surface);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            padding: 12px 16px;
            box-shadow: var(--shadow-hover);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideUp 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border-left: 3px solid var(--accent);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .toast i {
            font-size: 1rem;
            color: var(--accent);
        }

        /* ============================================================
           MOBILE
           ============================================================ */
        @media (max-width: 820px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                transform: translateX(-100%);
                width: 280px;
                box-shadow: 0 0 60px rgba(0, 0, 0, 0.8);
                height: 100vh;
                z-index: 999;
                transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main {
                padding: 18px 16px 30px;
                width: 100%;
                height: 100vh;
            }

            .top-bar h1 {
                font-size: 1.2rem;
            }

            .top-actions .status-badge span {
                display: none;
            }
        }

        /* ---- Scroll shadow indicators for nav ---- */
        .nav-scroll {
            position: relative;
        }

        .nav-scroll::before,
        .nav-scroll::after {
            content: '';
            position: sticky;
            left: 0;
            right: 0;
            height: 16px;
            pointer-events: none;
            display: block;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2;
        }

        .nav-scroll::before {
            top: 0;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, transparent 100%);
            margin-bottom: -16px;
        }

        .nav-scroll::after {
            bottom: 0;
            background: linear-gradient(0deg, var(--sidebar-bg) 0%, transparent 100%);
            margin-top: -16px;
        }

        .nav-scroll.scrolled-top::before {
            opacity: 1;
        }

        .nav-scroll.scrolled-bottom::after {
            opacity: 1;
        }
    </style>
</head>
<body>

    <!-- ============================================================
    SIDEBAR — ALWAYS DARK
    ============================================================ -->
    <aside class="sidebar" id="sidebar">

        <!-- LOGO -->
        <div class="logo-area">
            <div class="logo-icon"><i class="fas fa-dove"></i></div>
            <div class="logo-text">
                <h2>Tumpagon</h2>
                <div class="sub">CHURCH MANAGEMENT</div>
            </div>
        </div>

        <!-- NAVIGATION -->
        <div class="nav-scroll" id="navScroll">

            <!-- MAIN -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-th-large"></i> Main
                    <span class="title-line"></span>
                </div>
                <a href="#" class="nav-item active">
                    <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
                    <span class="nav-text">Dashboard</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-user-group"></i></span>
                    <span class="nav-text">Members</span>
                    <span class="nav-badge">312</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-sack-dollar"></i></span>
                    <span class="nav-text">Finance</span>
                    <span class="nav-badge gold"><i class="fas fa-arrow-up" style="font-size:0.4rem;"></i> 12%</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-church"></i></span>
                    <span class="nav-text">Sunday Service</span>
                    <span class="nav-badge success">Live</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-warehouse"></i></span>
                    <span class="nav-text">Inventory</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </div>

            <!-- COMMUNICATION -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-comment-dots"></i> Communication
                    <span class="title-line"></span>
                </div>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-envelope"></i></span>
                    <span class="nav-text">Messages</span>
                    <span class="nav-badge danger">8</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-bullhorn"></i></span>
                    <span class="nav-text">Announcements</span>
                    <span class="nav-badge">3</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-paper-plane"></i></span>
                    <span class="nav-text">Email</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </div>

            <!-- CHOIR MINISTRY -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-music"></i> Choir Ministry
                    <span class="title-line"></span>
                </div>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-people-group"></i></span>
                    <span class="nav-text">Choir Members</span>
                    <span class="nav-badge">24</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-calendar-days"></i></span>
                    <span class="nav-text">Schedules</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-microphone"></i></span>
                    <span class="nav-text">Practice</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-arrows-rotate"></i></span>
                    <span class="nav-text">Rotation</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </div>

            <!-- REPORTS -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-chart-pie"></i> Reports
                    <span class="title-line"></span>
                </div>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-file-lines"></i></span>
                    <span class="nav-text">Attendance Reports</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-file-invoice"></i></span>
                    <span class="nav-text">Financial Reports</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-chart-simple"></i></span>
                    <span class="nav-text">Analytics</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-download"></i></span>
                    <span class="nav-text">Export Data</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </div>

            <!-- SETTINGS -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-gear"></i> Settings
                    <span class="title-line"></span>
                </div>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-user"></i></span>
                    <span class="nav-text">Profile</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-lock"></i></span>
                    <span class="nav-text">Security</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-paintbrush"></i></span>
                    <span class="nav-text">Appearance</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-building-columns"></i></span>
                    <span class="nav-text">Church Settings</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </div>

            <!-- SUPPORT -->
            <div class="nav-group">
                <div class="nav-group-title">
                    <i class="fas fa-headset"></i> Support
                    <span class="title-line"></span>
                </div>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-circle-question"></i></span>
                    <span class="nav-text">Help Center</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-comment"></i></span>
                    <span class="nav-text">Feedback</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <a href="#" class="nav-item">
                    <span class="nav-icon"><i class="fas fa-circle-info"></i></span>
                    <span class="nav-text">About</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
            </div>

        </div>

        <!-- USER SECTION -->
        <div class="user-section" id="userSection">
            <div class="user-card" id="userCard">
                <div class="user-avatar"><i class="fas fa-user"></i></div>
                <div class="user-meta">
                    <div class="name">Renante</div>
                    <div class="role">Church Admin</div>
                </div>
                <div class="user-chevron"><i class="fas fa-chevron-up"></i></div>
            </div>
            <div class="logout-panel">
                <button class="logout-btn" onclick="showToast('Signed out successfully')">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </button>
            </div>
        </div>
    </aside>

    <!-- ============================================================
    MAIN CONTENT
    ============================================================ -->
    <main class="main">

        <!-- TOP BAR — mobile toggle button removed -->
        <div class="top-bar">
            <div style="display:flex;align-items:center;gap:12px;">
                <h1>Dashboard</h1>
            </div>
            <div class="top-actions">
                <div class="status-badge">
                    <span class="status-dot"></span>
                    <span>Live</span>
                </div>
                <button class="icon-btn"><i class="fas fa-envelope"></i><span class="badge-dot">3</span></button>
                <button class="icon-btn"><i class="fas fa-bell"></i><span class="badge-dot">5</span></button>
                <button class="theme-toggle" id="themeToggle"><i class="fas fa-moon" id="themeIcon"></i></button>
            </div>
        </div>

        <!-- STATS -->
        <div class="card-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-group"></i></div>
                <div class="stat-label">Members</div>
                <div class="stat-value">312</div>
                <div class="stat-change"><i class="fas fa-arrow-up" style="color:#2d9c6c;"></i> +12 this month</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-sack-dollar"></i></div>
                <div class="stat-label">Offering</div>
                <div class="stat-value">₱14.2k</div>
                <div class="stat-change"><i class="fas fa-arrow-up" style="color:#2d9c6c;"></i> 8% vs last week</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-church"></i></div>
                <div class="stat-label">Attendance</div>
                <div class="stat-value">187</div>
                <div class="stat-change">86% capacity</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                <div class="stat-label">Unread</div>
                <div class="stat-value">8</div>
                <div class="stat-change">3 urgent</div>
            </div>
        </div>

        <!-- BOTTOM CARD -->
        <div class="bottom-card">
            <h3>Today's Service</h3>
            <p>10:30 AM · Main Sanctuary · <span style="color:var(--accent);font-weight:600;">Live</span></p>
            <div class="tag-group">
                <span class="tag">Worship</span>
                <span class="tag">Prayer</span>
                <span class="tag">Teaching</span>
                <span class="tag">Fellowship</span>
            </div>
        </div>

    </main>

    <!-- TOAST CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- ============================================================
    SCRIPTS
    ============================================================ -->
    <script>
        (function() {
            'use strict';

            // ---- THEME TOGGLE ----
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const html = document.documentElement;
            let currentTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-theme', currentTheme);
            updateIcon(currentTheme);

            themeToggle.addEventListener('click', () => {
                const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                updateIcon(next);
                showToast(next === 'dark' ? 'Dark mode' : 'Light mode');
            });

            function updateIcon(theme) {
                themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }

            // ---- MOBILE SIDEBAR ----
            // Mobile toggle button has been removed.
            // Sidebar opens automatically when clicking anywhere on the left edge on mobile (optional) —
            // or you can re-add a toggle later if needed.

            // ---- USER SECTION TOGGLE ----
            const userCard = document.getElementById('userCard');
            const userSection = document.getElementById('userSection');
            if (userCard && userSection) {
                userCard.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userSection.classList.toggle('open');
                });
                document.addEventListener('click', () => {
                    userSection.classList.remove('open');
                });
            }

            // ---- SCROLL SHADOW INDICATORS ----
            const navScroll = document.getElementById('navScroll');
            if (navScroll) {
                navScroll.addEventListener('scroll', () => {
                    const atTop = navScroll.scrollTop <= 2;
                    const atBottom = navScroll.scrollHeight - navScroll.scrollTop - navScroll.clientHeight <= 2;
                    navScroll.classList.toggle('scrolled-top', !atTop);
                    navScroll.classList.toggle('scrolled-bottom', !atBottom);
                });
                navScroll.dispatchEvent(new Event('scroll'));
            }

            // ---- TOAST ----
            function showToast(msg) {
                const container = document.getElementById('toastContainer');
                if (!container) return;
                const toast = document.createElement('div');
                toast.className = 'toast';
                toast.innerHTML = `<i class="fas fa-check-circle"></i><span style="font-size:0.8rem;font-weight:500;">${msg}</span>`;
                container.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(16px) scale(0.97)';
                    setTimeout(() => toast.remove(), 350);
                }, 2200);
            }

            window.showToast = showToast;

        })();
    </script>

</body>
</html>