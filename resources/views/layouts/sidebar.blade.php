<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Church OS · Fixed Header & Footer</title>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-body: #f0f2f6;
            --surface: #ffffff;
            --surface-hover: #f5f7fb;
            --text-primary: #1a2636;
            --text-secondary: #4a5a72;
            --text-muted: #8a9bb0;
            --border-light: #e4e9f0;
            --accent: #6c8cbf;
            --accent-light: #e8eef8;
            --accent-dark: #4a6a9a;
            --gradient-start: #6c8cbf;
            --gradient-end: #4a6a9a;
            --shadow-card: 0 8px 24px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 20px 40px -12px rgba(0, 20, 40, 0.12);
            --radius-xl: 16px;
            --radius-lg: 12px;
            --radius-md: 8px;
            --radius-sm: 6px;
            --sidebar-width: 260px;
            --sidebar-bg: #ffffff;
            --sidebar-border: #e8ecf3;
            --badge-bg: #eef3f8;
            --badge-text: #4a5a72;
            --user-bg: #f8fafc;
        }

        [data-theme="dark"] {
            --bg-body: #0d1421;
            --surface: #162032;
            --surface-hover: #1f2b40;
            --text-primary: #e8edf5;
            --text-secondary: #a8bcd4;
            --text-muted: #6a7f99;
            --border-light: #28364a;
            --accent: #8aacd9;
            --accent-light: #1f3048;
            --accent-dark: #6a8ab5;
            --gradient-start: #8aacd9;
            --gradient-end: #6a8ab5;
            --shadow-card: 0 8px 24px rgba(0, 0, 0, 0.4);
            --shadow-hover: 0 20px 40px -12px rgba(0, 0, 0, 0.6);
            --sidebar-bg: #111b2d;
            --sidebar-border: #233045;
            --badge-bg: #1f2c40;
            --badge-text: #a8bcd4;
            --user-bg: #0e1728;
        }

        body {
            font-family: 'Inter', -apple-system, system-ui, sans-serif;
            background: var(--bg-body);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
            transition: background 0.3s, color 0.3s;
            font-size: 14px;
            line-height: 1.5;
        }

        /* ===== SIDEBAR - FIXED HEADER & FOOTER, ONLY NAV SCROLLS ===== */
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
            transition: background 0.3s, border 0.3s, transform 0.3s cubic-bezier(0.2, 0, 0, 1);
        }

        /* --- LOGO - FIXED (never scrolls) --- */
        .logo-area {
            padding: 20px 16px 18px 16px;
            border-bottom: 1px solid var(--sidebar-border);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            background: var(--sidebar-bg);
            z-index: 2;
            min-height: 80px;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(108, 140, 191, 0.3);
            flex-shrink: 0;
        }

        .logo-text h2 {
            font-family: 'Fraunces', serif;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: -0.2px;
            color: var(--text-primary);
            line-height: 1.2;
            margin: 0;
        }

        .logo-text .sub {
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--text-muted);
            font-weight: 600;
            margin: 0;
        }

        /* --- NAVIGATION - ONLY THIS SCROLLS --- */
        .nav-scroll {
            flex: 1 1 auto;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 8px 12px 8px 12px;
            scrollbar-width: thin;
            scrollbar-color: var(--border-light) transparent;
            min-height: 0;
            position: relative;
        }

        .nav-scroll::-webkit-scrollbar {
            width: 3px;
        }
        .nav-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .nav-scroll::-webkit-scrollbar-thumb {
            background: var(--border-light);
            border-radius: 20px;
        }

        .nav-group {
            margin-bottom: 20px;
        }

        .nav-group-title {
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 700;
            padding: 0 8px 10px 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-group-title i {
            font-size: 0.5rem;
            opacity: 0.4;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            border-radius: var(--radius-md);
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.82rem;
            transition: all 0.15s ease;
            text-decoration: none;
            margin: 1px 0;
            position: relative;
            cursor: pointer;
        }

        .nav-item .nav-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            transition: 0.2s;
            flex-shrink: 0;
        }

        .nav-item .nav-icon i {
            font-size: 0.9rem;
            color: var(--text-muted);
            transition: 0.2s;
        }

        .nav-item:hover {
            background: var(--surface-hover);
            color: var(--text-primary);
        }

        .nav-item:hover .nav-icon i {
            color: var(--accent);
        }

        .nav-item.active {
            background: var(--accent-light);
            color: var(--text-primary);
            font-weight: 600;
        }

        .nav-item.active .nav-icon {
            background: var(--accent);
        }

        .nav-item.active .nav-icon i {
            color: white;
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: var(--accent);
            border-radius: 4px;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--badge-bg);
            color: var(--badge-text);
            font-size: 0.55rem;
            font-weight: 700;
            padding: 1px 8px;
            border-radius: 30px;
            font-family: 'IBM Plex Mono', monospace;
        }

        .nav-badge.danger {
            background: #e05a5a18;
            color: #c84a4a;
        }

        .nav-badge.gold {
            background: rgba(194, 154, 59, 0.1);
            color: #b8942e;
        }

        /* --- USER SECTION - FIXED (never scrolls) --- */
        .user-section {
            border-top: 1px solid var(--sidebar-border);
            padding: 14px 12px 16px 12px;
            background: var(--user-bg);
            flex-shrink: 0;
            transition: background 0.2s;
            min-height: 76px;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 8px;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: 0.2s;
        }

        .user-card:hover {
            background: var(--surface-hover);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(108, 140, 191, 0.15);
        }

        .user-meta {
            flex: 1;
            min-width: 0;
        }

        .user-meta .name {
            font-weight: 600;
            font-size: 0.82rem;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .user-meta .role {
            font-size: 0.55rem;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .user-chevron {
            color: var(--text-muted);
            font-size: 0.65rem;
            transition: 0.25s;
            background: var(--surface-hover);
            width: 24px;
            height: 24px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-section.open .user-chevron {
            transform: rotate(180deg);
            background: var(--accent);
            color: white;
        }

        .logout-panel {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.25s ease, margin 0.2s;
            margin-top: 0;
        }

        .user-section.open .logout-panel {
            max-height: 68px;
            opacity: 1;
            margin-top: 10px;
        }

        .logout-btn {
            width: 100%;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            background: rgba(200, 70, 70, 0.04);
            border: 1px solid rgba(200, 70, 70, 0.08);
            color: #b34a4a;
            font-weight: 600;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: rgba(200, 70, 70, 0.08);
            border-color: rgba(200, 70, 70, 0.18);
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
            padding: 28px 36px 40px 36px;
            background: var(--bg-body);
            transition: background 0.3s;
        }

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
            transition: 0.2s;
            position: relative;
        }

        .icon-btn:hover {
            background: var(--surface-hover);
            color: var(--text-primary);
            border-color: var(--accent);
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
            transition: 0.2s;
        }

        .theme-toggle:hover {
            background: var(--surface-hover);
            color: var(--accent);
        }

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
            transition: 0.25s;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
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
            opacity: 0.15;
            color: var(--accent);
        }

        .bottom-card {
            margin-top: 28px;
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            padding: 22px 26px;
            box-shadow: var(--shadow-card);
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
        }

        /* mobile */
        @media (max-width: 820px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                transform: translateX(-100%);
                width: 280px;
                box-shadow: 0 0 40px rgba(0,0,0,0.06);
                height: 100vh;
                z-index: 999;
                transition: transform 0.3s cubic-bezier(0.2, 0, 0, 1);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main {
                padding: 18px 16px 30px;
                width: 100%;
            }

            .top-bar h1 {
                font-size: 1.2rem;
            }

            .mobile-toggle {
                display: flex !important;
                background: var(--surface);
                border: 1px solid var(--border-light);
                border-radius: 40px;
                width: 38px;
                height: 38px;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                color: var(--text-secondary);
                cursor: pointer;
            }

            .top-actions .status-badge span {
                display: none;
            }
        }

        .mobile-toggle {
            display: none;
        }

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
            animation: slideUp 0.3s ease;
            border-left: 3px solid var(--accent);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .toast i {
            font-size: 1rem;
            color: var(--accent);
        }

        /* Scroll shadow indicators */
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
            transition: opacity 0.2s ease;
            z-index: 1;
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

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar" id="sidebar">
    <!-- LOGO - FIXED (never scrolls) -->
    <div class="logo-area">
        <div class="logo-icon"><i class="fas fa-dove"></i></div>
        <div class="logo-text">
            <h2>Tumpagon</h2>
            <div class="sub">CHURCH MANAGEMENT SYSTEM</div>
        </div>
    </div>

    <!-- NAVIGATION - ONLY THIS SCROLLS -->
    <div class="nav-scroll" id="navScroll">
        <div class="nav-group">
            <div class="nav-group-title"><i class="fas fa-th-large"></i> Main</div>
            <a href="#" class="nav-item active">
                <span class="nav-icon"><i class="fas fa-home"></i></span> Dashboard
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-users"></i></span> Members
                <span class="nav-badge">312</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-wallet"></i></span> Finance
                <span class="nav-badge gold"><i class="fas fa-arrow-up" style="font-size:0.4rem;"></i> 12%</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-place-of-worship"></i></span> Services
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title"><i class="fas fa-comment"></i> Connect</div>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-inbox"></i></span> Messages
                <span class="nav-badge danger">8</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-bullhorn"></i></span> Announcements
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title"><i class="fas fa-music"></i> Worship</div>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-microphone-alt"></i></span> Choir
                <span class="nav-badge">24</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-calendar-alt"></i></span> Schedule
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-hands"></i></span> Events
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title"><i class="fas fa-chart-bar"></i> Insights</div>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-chart-pie"></i></span> Analytics
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-file-export"></i></span> Reports
            </a>
        </div>

        <!-- Extra items to demonstrate scrolling -->
        <div class="nav-group">
            <div class="nav-group-title"><i class="fas fa-cog"></i> Settings</div>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-user-cog"></i></span> Profile
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-shield-alt"></i></span> Security
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-palette"></i></span> Appearance
            </a>
        </div>

        <div class="nav-group">
            <div class="nav-group-title"><i class="fas fa-question-circle"></i> Support</div>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-life-ring"></i></span> Help Center
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon"><i class="fas fa-comment-dots"></i></span> Feedback
            </a>
        </div>
    </div>

    <!-- USER - FIXED (never scrolls) -->
    <div class="user-section" id="userSection">
        <div class="user-card" id="userCard">
            <div class="user-avatar"><i class="fas fa-user"></i></div>
            <div class="user-meta">
                <div class="name">renante</div>
                <div class="role">church_admin</div>
            </div>
            <div class="user-chevron"><i class="fas fa-chevron-up"></i></div>
        </div>
        <div class="logout-panel">
            <button class="logout-btn" onclick="alert('Sign out')">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </button>
        </div>
    </div>
</aside>

<!-- ===== MAIN ===== -->
<main class="main">
    <div class="top-bar">
        <div style="display:flex;align-items:center;gap:12px;">
            <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
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

    <div class="card-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-label">Members</div>
            <div class="stat-value">312</div>
            <div class="stat-change"><i class="fas fa-arrow-up" style="color:#2d9c6c;"></i> +12 this month</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-coins"></i></div>
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
            <div class="stat-icon"><i class="fas fa-inbox"></i></div>
            <div class="stat-label">Unread</div>
            <div class="stat-value">8</div>
            <div class="stat-change">3 urgent</div>
        </div>
    </div>

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

<!-- Toast -->
<div class="toast-container" id="toastContainer"></div>

<script>
    (function() {
        // Theme toggle
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

        // Mobile toggle
        const sidebar = document.getElementById('sidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
        }

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 820) {
                if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });

        // User section toggle
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

        // Scroll shadow indicators
        const navScroll = document.getElementById('navScroll');
        if (navScroll) {
            navScroll.addEventListener('scroll', () => {
                const atTop = navScroll.scrollTop <= 2;
                const atBottom = navScroll.scrollHeight - navScroll.scrollTop - navScroll.clientHeight <= 2;
                navScroll.classList.toggle('scrolled-top', !atTop);
                navScroll.classList.toggle('scrolled-bottom', !atBottom);
            });
            // Initial check
            navScroll.dispatchEvent(new Event('scroll'));
        }

        function showToast(msg) {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `<i class="fas fa-check-circle"></i><span style="font-size:0.8rem;font-weight:500;">${msg}</span>`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(16px)';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }

        window.showToast = showToast;
    })();
</script>
</body>
</html>