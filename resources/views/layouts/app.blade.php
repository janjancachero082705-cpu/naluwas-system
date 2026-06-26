<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TINC Church System') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --bg-primary: #f5f7fa;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.04);
            --card-hover-shadow: 0 8px 30px rgba(0,0,0,0.08);
            --sidebar-bg: #ffffff;
            --sidebar-text: #475569;
            --sidebar-text-muted: #94a3b8;
            --sidebar-hover: rgba(59,130,246,0.05);
            --sidebar-active-bg: rgba(59,130,246,0.08);
            --sidebar-border: #e2e8f0;
            --user-section-bg: #f8fafc;
            --input-bg: #ffffff;
            --input-border: #e2e8f0;
            --modal-bg: #ffffff;
            --header-bg: #ffffff;
            --header-border: #e2e8f0;
            --header-shadow: 0 1px 3px rgba(0,0,0,0.04);
            --alert-success-bg: #ecfdf5;
            --alert-success-text: #065f46;
            --alert-danger-bg: #fef2f2;
            --alert-danger-text: #991b1b;
            --alert-warning-bg: #fffbeb;
            --alert-warning-text: #78350f;
            --alert-info-bg: #eff6ff;
            --alert-info-text: #1e3a5f;
            --hover-bg: #f1f5f9;
            --gradient-primary: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-info: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            --notification-bg: #ffffff;
            --notification-shadow: 0 10px 40px rgba(0,0,0,0.1);
            --finance-income: #10b981;
            --finance-expense: #ef4444;
            --finance-balance: #4F46E5;
        }

        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #1a2332;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --border-color: #334155;
            --card-bg: #1e293b;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.2);
            --card-hover-shadow: 0 8px 30px rgba(0,0,0,0.3);
            --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #020617 100%);
            --sidebar-text: #94a3b8;
            --sidebar-text-muted: #475569;
            --sidebar-hover: rgba(59,130,246,0.15);
            --sidebar-active-bg: rgba(59,130,246,0.2);
            --sidebar-border: rgba(255,255,255,0.05);
            --user-section-bg: rgba(2,6,23,0.95);
            --input-bg: #1a2332;
            --input-border: #334155;
            --modal-bg: #1e293b;
            --header-bg: #1e293b;
            --header-border: #334155;
            --header-shadow: 0 1px 3px rgba(0,0,0,0.2);
            --alert-success-bg: #052e16;
            --alert-success-text: #86efac;
            --alert-danger-bg: #450a0a;
            --alert-danger-text: #fca5a5;
            --alert-warning-bg: #451a03;
            --alert-warning-text: #fcd34d;
            --alert-info-bg: #172554;
            --alert-info-text: #93c5fd;
            --hover-bg: #1e293b;
            --notification-bg: #1e293b;
            --notification-shadow: 0 10px 40px rgba(0,0,0,0.4);
            --finance-income: #34d399;
            --finance-expense: #f87171;
            --finance-balance: #818cf8;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, system-ui, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ===== ANIMATED BACKGROUND ===== */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.4;
            pointer-events: none;
        }
        
        .animated-bg .circle {
            position: absolute;
            border-radius: 50%;
            background: var(--gradient-primary);
            animation: float 20s infinite ease-in-out;
            opacity: 0.15;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(60px, -40px) scale(1.1); }
            50% { transform: translate(-40px, 60px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }

        /* ===== SIDEBAR ===== */
        .sidebar-container {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: var(--sidebar-bg);
            overflow-y: auto;
            overflow-x: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 1px solid var(--sidebar-border);
        }

        .sidebar-container::-webkit-scrollbar {
            width: 3px;
        }
        .sidebar-container::-webkit-scrollbar-track {
            background: var(--border-color);
        }
        .sidebar-container::-webkit-scrollbar-thumb {
            background: var(--text-muted);
            border-radius: 10px;
        }

        /* ===== LOGO ===== */
        .logo-section {
            padding: 1.5rem 1.2rem;
            border-bottom: 1px solid var(--sidebar-border);
            flex-shrink: 0;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-upload-trigger {
            position: relative;
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            cursor: pointer;
        }

        .logo-img {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            display: block;
        }

        .logo-icon-fallback {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            box-shadow: 0 2px 12px rgba(79,70,229,0.25);
            transition: all 0.3s ease;
        }

        .logo-text h2 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.5px;
        }
        .logo-text p {
            font-size: 0.6rem;
            color: var(--text-muted);
            margin: 0;
        }

        /* ===== NAVIGATION ===== */
        .nav-menu { 
            padding: 0.8rem 0.8rem; 
            flex: 1; 
        }
        
        .nav-section { 
            margin-bottom: 1.2rem; 
        }

        .nav-section-title {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            padding: 0.3rem 0.7rem 0.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.55rem 0.8rem;
            margin: 2px 0;
            border-radius: 10px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.82rem;
            position: relative;
        }

        .nav-item i {
            width: 20px;
            font-size: 0.95rem;
            text-align: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .nav-item:hover { 
            background: var(--sidebar-hover); 
            color: #4F46E5; 
        }
        .nav-item:hover i { 
            color: #4F46E5; 
        }

        .nav-item.active {
            background: var(--sidebar-active-bg);
            color: #4F46E5;
            border-left: 3px solid #4F46E5;
        }
        .nav-item.active i { 
            color: #4F46E5; 
        }

        .nav-badge {
            margin-left: auto;
            background: rgba(79,70,229,0.1);
            padding: 1px 8px;
            border-radius: 20px;
            font-size: 0.6rem;
            color: #4F46E5;
            font-weight: 700;
        }

        .nav-badge.finance {
            background: rgba(16,185,129,0.15);
            color: #10b981;
        }

        /* ===== USER SECTION ===== */
        .user-section {
            margin-top: auto;
            background: var(--user-section-bg);
            border-top: 1px solid var(--sidebar-border);
            padding: 0.8rem;
            flex-shrink: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.4rem 0.6rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
        }

        .user-avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .user-avatar-img {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #4F46E5;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .user-role {
            font-size: 0.6rem;
            color: var(--text-muted);
        }

        .logout-btn {
            width: 100%;
            padding: 0.5rem;
            border-radius: 10px;
            background: rgba(239,68,68,0.06);
            border: 1px solid rgba(239,68,68,0.1);
            color: #dc2626;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: rgba(239,68,68,0.12);
            transform: translateY(-1px);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            background: var(--bg-primary);
            transition: background 0.4s ease;
        }

        /* ===== TOP HEADER ===== */
        .top-header {
            background: var(--header-bg);
            border-bottom: 1px solid var(--header-border);
            box-shadow: var(--header-shadow);
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            transition: all 0.3s ease;
            gap: 1rem;
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,0.85);
        }

        [data-theme="dark"] .top-header {
            background: rgba(30,41,59,0.85);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-left h1 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .header-breadcrumb {
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        /* ===== NOTIFICATION BUTTON ===== */
        .header-notif {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .header-notif:hover {
            background: rgba(79,70,229,0.08);
            color: #4F46E5;
            border-color: #4F46E5;
            transform: scale(1.05);
        }

        .notif-dot {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
            color: white;
            font-weight: 700;
            border: 2px solid var(--header-bg);
            animation: pulse-dot 2s infinite;
        }

        .notif-dot.has-messages {
            background: #D97706;
            animation: pulse-dot 1s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        /* ===== NOTIFICATION DROPDOWN ===== */
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 380px;
            max-height: 480px;
            background: var(--notification-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: var(--notification-shadow);
            overflow: hidden;
            display: none;
            z-index: 1050;
            animation: dropdownSlideDown 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .notification-dropdown.show {
            display: block !important;
        }

        @keyframes dropdownSlideDown {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .dropdown-header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-tertiary);
        }

        .dropdown-header span:first-child {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .dropdown-header .notif-total {
            background: var(--gradient-primary);
            color: white;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .dropdown-list {
            max-height: 340px;
            overflow-y: auto;
            padding: 4px 0;
        }

        .dropdown-list::-webkit-scrollbar {
            width: 4px;
        }
        .dropdown-list::-webkit-scrollbar-track {
            background: var(--border-color);
        }
        .dropdown-list::-webkit-scrollbar-thumb {
            background: var(--text-muted);
            border-radius: 10px;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 12px 18px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-color);
            position: relative;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: var(--hover-bg);
        }

        .notification-item.unread {
            background: rgba(79,70,229,0.04);
        }

        .notification-item.unread::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--gradient-primary);
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.9rem;
        }

        .notification-icon.info {
            background: rgba(59,130,246,0.12);
            color: #3b82f6;
        }

        .notification-icon.success {
            background: rgba(16,185,129,0.12);
            color: #10b981;
        }

        .notification-icon.warning {
            background: rgba(245,158,11,0.12);
            color: #f59e0b;
        }

        .notification-icon.danger {
            background: rgba(239,68,68,0.12);
            color: #ef4444;
        }

        .notification-icon.birthday {
            background: linear-gradient(135deg, rgba(236,72,153,0.15), rgba(244,63,94,0.15));
            color: #ec4899;
        }

        .notification-icon.message {
            background: rgba(217,119,6,0.12);
            color: #D97706;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .notification-message {
            font-size: 0.78rem;
            color: var(--text-secondary);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-time {
            font-size: 0.65rem;
            color: var(--text-muted);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .notification-time i {
            font-size: 0.6rem;
        }

        .dropdown-footer {
            padding: 10px 18px;
            border-top: 1px solid var(--border-color);
            text-align: center;
            background: var(--bg-tertiary);
        }

        .dropdown-footer a {
            color: #4F46E5;
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .dropdown-footer a:hover {
            color: #7C3AED;
            text-decoration: underline;
        }

        .dropdown-empty {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .dropdown-empty i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
            opacity: 0.5;
        }

        /* ===== TOAST NOTIFICATIONS ===== */
        .toast-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 380px;
        }

        .toast-notification {
            background: var(--notification-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 18px;
            box-shadow: var(--notification-shadow);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: toastSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: right;
            min-width: 300px;
            border-left: 4px solid #4F46E5;
        }

        .toast-notification.hiding {
            animation: toastSlideOut 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes toastSlideIn {
            from {
                opacity: 0;
                transform: translateX(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes toastSlideOut {
            from {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateX(40px) scale(0.95);
            }
        }

        .toast-notification.success {
            border-left-color: #10b981;
        }
        .toast-notification.error {
            border-left-color: #ef4444;
        }
        .toast-notification.warning {
            border-left-color: #f59e0b;
        }
        .toast-notification.info {
            border-left-color: #3b82f6;
        }
        .toast-notification.message {
            border-left-color: #D97706;
        }

        .toast-icon {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.8rem;
        }

        .toast-icon.success {
            background: rgba(16,185,129,0.12);
            color: #10b981;
        }
        .toast-icon.error {
            background: rgba(239,68,68,0.12);
            color: #ef4444;
        }
        .toast-icon.warning {
            background: rgba(245,158,11,0.12);
            color: #f59e0b;
        }
        .toast-icon.info {
            background: rgba(59,130,246,0.12);
            color: #3b82f6;
        }
        .toast-icon.message {
            background: rgba(217,119,6,0.12);
            color: #D97706;
        }

        .toast-body {
            flex: 1;
        }

        .toast-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .toast-message {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 0.8rem;
            transition: all 0.2s ease;
        }

        .toast-close:hover {
            color: var(--text-primary);
            transform: rotate(90deg);
        }

        /* ===== USER PROFILE ===== */
        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--hover-bg);
            border: 1px solid var(--border-color);
        }

        .header-user:hover {
            background: var(--sidebar-hover);
            transform: scale(1.02);
        }

        .header-avatar {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
            color: white;
            flex-shrink: 0;
        }

        .header-avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .header-user-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .header-user-role {
            font-size: 0.6rem;
            color: var(--text-muted);
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
            font-weight: 500;
            font-size: 0.8rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success { 
            background: var(--alert-success-bg); 
            color: var(--alert-success-text); 
            border-left: 4px solid #10b981; 
        }
        .alert-danger { 
            background: var(--alert-danger-bg); 
            color: var(--alert-danger-text); 
            border-left: 4px solid #ef4444; 
        }
        .alert-warning { 
            background: var(--alert-warning-bg); 
            color: var(--alert-warning-text); 
            border-left: 4px solid #f59e0b; 
        }
        .alert-info { 
            background: var(--alert-info-bg); 
            color: var(--alert-info-text); 
            border-left: 4px solid #3b82f6; 
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            color: var(--text-primary);
        }

        .card:hover {
            box-shadow: var(--card-hover-shadow);
            transform: translateY(-2px);
        }

        /* ===== FORM CONTROLS ===== */
        .form-control, .form-select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-primary);
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            font-size: 0.85rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        .form-control::placeholder { 
            color: var(--text-muted); 
        }

        /* ===== MODAL ===== */
        .modal-content {
            background: var(--modal-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.2rem 1.5rem;
        }
        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        /* ===== TABLES ===== */
        .table { 
            color: var(--text-primary); 
        }
        .table thead th { 
            border-bottom: 2px solid var(--border-color); 
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td, .table th { 
            border-color: var(--border-color); 
            padding: 0.8rem 1rem;
            vertical-align: middle;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background: rgba(0,0,0,0.02);
        }

        /* ===== TOAST ===== */
        .logo-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            padding: 14px 22px;
            border-radius: 14px;
            font-size: 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            z-index: 9999;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-color);
        }

        .logo-toast.show { 
            transform: translateY(0); 
            opacity: 1; 
        }
        .logo-toast.success { 
            border-left: 4px solid #10b981; 
        }
        .logo-toast.error { 
            border-left: 4px solid #ef4444; 
        }

        /* ===== FLOATING DARK MODE ===== */
        .fab-theme {
            position: fixed;
            bottom: 28px;
            right: 28px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            z-index: 9998;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fab-theme:hover {
            transform: scale(1.08) rotate(15deg);
            box-shadow: 0 4px 24px rgba(0,0,0,0.12);
            color: #4F46E5;
            border-color: #4F46E5;
        }

        [data-theme="dark"] .fab-theme {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            color: white;
            box-shadow: 0 4px 20px rgba(245,158,11,0.4);
        }

        [data-theme="dark"] .fab-theme:hover {
            box-shadow: 0 8px 32px rgba(245,158,11,0.55);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .sidebar-container { width: 220px; }
            .main-content { margin-left: 220px; }
        }

        @media (max-width: 768px) {
            .sidebar-container {
                transform: translateX(-100%);
                width: 280px;
                position: fixed;
                z-index: 1050;
            }
            .sidebar-container.mobile-open { 
                transform: translateX(0); 
            }
            .main-content { 
                margin-left: 0; 
            }
            .content-area { 
                padding: 1rem; 
            }
            .top-header { 
                padding: 0 1rem; 
            }
            .header-user-info { 
                display: none; 
            }
            .header-left h1 { 
                font-size: 0.95rem; 
            }
            .fab-theme { 
                bottom: 16px; 
                right: 16px; 
                width: 44px; 
                height: 44px; 
                font-size: 1rem; 
            }
            .logo-toast { 
                bottom: 80px; 
                right: 16px; 
                left: 16px; 
            }
            .notification-dropdown {
                width: calc(100vw - 32px);
                right: -16px;
                top: calc(100% + 8px);
            }
            .toast-container {
                max-width: calc(100vw - 32px);
                right: 16px;
            }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .content-area { 
            animation: fadeInUp 0.5s ease; 
        }

        /* ===== PROFILE PICTURE UPLOAD STYLES ===== */
        .profile-picture-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .profile-picture-wrapper .upload-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #4F46E5;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            border: 3px solid var(--bg-secondary);
            transition: all 0.3s ease;
        }

        .profile-picture-wrapper .upload-overlay:hover {
            transform: scale(1.1);
            background: #7C3AED;
        }

        .profile-picture-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4F46E5;
            transition: all 0.3s ease;
        }

        .profile-picture-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: white;
            border: 4px solid #4F46E5;
            transition: all 0.3s ease;
        }

        /* Profile Picture in Header */
        .header-profile-img {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            object-fit: cover;
        }

        .header-profile-initials {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
            color: white;
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
    
    // Get unread messages count for notification badge
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

    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="circle" style="width: 350px; height: 350px; top: 5%; left: -100px; animation-delay: 0s;"></div>
        <div class="circle" style="width: 200px; height: 200px; bottom: 15%; right: -50px; animation-delay: 5s;"></div>
        <div class="circle" style="width: 150px; height: 150px; top: 50%; left: 20%; animation-delay: 2s;"></div>
        <div class="circle" style="width: 280px; height: 280px; bottom: 10%; left: 25%; animation-delay: 8s;"></div>
        <div class="circle" style="width: 120px; height: 120px; top: 25%; right: 15%; animation-delay: 3s;"></div>
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
        <!-- Logo -->
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
                    <div class="logo-upload-overlay">
                        <i class="fas fa-camera" id="logoOverlayIcon"></i>
                    </div>
                </div>
                <div class="logo-text">
                    <h2>{{ $churchName }}</h2>
                    <p>{{ $tagline }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="nav-menu">
            <div class="nav-section">
                <div class="nav-section-title">
                    <i class="fas fa-th-large"></i> Main Menu
                </div>

                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>

                <a href="{{ route('members.index') }}" class="nav-item {{ request()->routeIs('members.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Members
                </a>

                <a href="{{ route('finance.index') }}" class="nav-item {{ request()->routeIs('finance.*') ? 'active' : '' }}">
                    <i class="fas fa-coins"></i> Finance
                    <span class="nav-badge finance">
                        <i class="fas fa-arrow-trend-up"></i>
                    </span>
                </a>

                <a href="{{ route('sunday-attendance.index') }}" class="nav-item {{ request()->routeIs('sunday-attendance.*') ? 'active' : '' }}">
                    <i class="fas fa-church"></i> Sunday Service
                </a>

                <a href="{{ route('inventory.index') }}" class="nav-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                    <i class="fas fa-boxes"></i> Inventory
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">
                    <i class="fas fa-music"></i> Choir Ministry
                </div>

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
                <div class="nav-section-title">
                    <i class="fas fa-chart-line"></i> Reports
                </div>

                <a href="{{ route('reports.analytics') }}" class="nav-item {{ request()->routeIs('reports.analytics') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Reports & Analytics
                </a>
            </div>
        </nav>

        <!-- User Section with Profile Picture -->
        <div class="user-section">
            <div class="user-info">
                @if($user && $user->profile_picture)
                    <img src="{{ $user->profile_picture_url }}" 
                         alt="{{ $user->name }}" 
                         class="user-avatar-img">
                @else
                    <div class="user-avatar-sm" style="background: {{ $user?->avatar_color ?? '#4F46E5' }};">
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
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <h1>@yield('header', 'Dashboard')</h1>
                <div class="header-breadcrumb">
                    <i class="fas fa-home"></i>
                    <span>/</span>
                    <span>@yield('header', 'Dashboard')</span>
                </div>
            </div>

            <div class="header-right">
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
                            <span>🔔 Notifications</span>
                            <span class="notif-total" id="notifTotalCount">{{ $unreadMsgCount }}</span>
                        </div>
                        <div class="dropdown-list" id="notificationList">
                            <div class="dropdown-empty">
                                <i class="fas fa-bell-slash"></i>
                                <span>No notifications</span>
                            </div>
                        </div>
                        <div class="dropdown-footer">
                            <a href="{{ route('finance.index') }}">📨 Go to Messages</a>
                        </div>
                    </div>
                </div>

                <!-- User Profile with Profile Picture -->
                <div class="header-user" id="userProfileBtn">
                    @if($user && $user->profile_picture)
                        <img src="{{ $user->profile_picture_url }}" 
                             alt="{{ $user->name }}" 
                             class="header-profile-img">
                    @else
                        <div class="header-profile-initials" style="background: {{ $user?->avatar_color ?? '#4F46E5' }};">
                            {{ $user?->initials ?? 'A' }}
                        </div>
                    @endif
                    <div class="header-user-info">
                        <span class="header-user-name">{{ $user->name ?? 'Administrator' }}</span>
                        <span class="header-user-role">{{ $user->role ?? 'Administrator' }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> {{ session('info') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- ===== SCRIPTS ===== -->
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
        const logoToastIcon = document.getElementById('logoToastIcon');
        const logoOverlayIcon = document.getElementById('logoOverlayIcon');

        if (logoTrigger) {
            logoTrigger.addEventListener('click', () => logoFileInput.click());
        }

        if (logoFileInput) {
            logoFileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;

                logoTrigger.classList.add('uploading');
                logoOverlayIcon.className = 'fas fa-spinner';

                const formData = new FormData();
                formData.append('logo', file);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

                fetch('{{ route("settings.logo.update") }}', {
                    method: 'POST',
                    body: formData,
                })
                .then(res => res.json())
                .then(data => {
                    logoTrigger.classList.remove('uploading');
                    logoOverlayIcon.className = 'fas fa-camera';

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
                        showToast('success', '<i class="fas fa-check-circle"></i>', 'Logo updated successfully!');
                    } else {
                        showToast('error', '<i class="fas fa-times-circle"></i>', data.message || 'Upload failed.');
                    }
                })
                .catch(() => {
                    logoTrigger.classList.remove('uploading');
                    logoOverlayIcon.className = 'fas fa-camera';
                    showToast('error', '<i class="fas fa-times-circle"></i>', 'Something went wrong.');
                });

                this.value = '';
            });
        }

        function showToast(type, iconHtml, message) {
            logoToast.className = 'logo-toast ' + type;
            logoToastIcon.outerHTML = '<span id="logoToastIcon">' + iconHtml + '</span>';
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

        // ===== TOAST SYSTEM =====
        const toastContainer = document.getElementById('toastContainer');

        function showToastNotification(type, title, message, duration = 4000) {
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
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="this.closest('.toast-notification').remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }, duration);
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
                this.fetchMessages();
                this.setupEventListeners();
                setInterval(() => this.fetchNotifications(), 60000);
                setInterval(() => this.fetchMessages(), 30000);
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
                                showToastNotification(
                                    notif.type || 'info',
                                    notif.title,
                                    notif.message,
                                    5000
                                );
                            });
                        }
                    }
                } catch (error) {
                    console.log('Failed to fetch notifications:', error);
                }
            }

            async fetchMessages() {
                try {
                    const response = await fetch('{{ route("messages.unread-count") }}');
                    const data = await response.json();
                    
                    if (data.unread_count > 0) {
                        this.updateBadge(data.unread_count);
                        showToastNotification(
                            'message',
                            '📨 New Message Received',
                            `You have ${data.unread_count} unread message${data.unread_count > 1 ? 's' : ''}`,
                            5000
                        );
                    }
                } catch (error) {
                    console.log('Failed to fetch messages:', error);
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
                if (this.isOpen) {
                    this.closeDropdown();
                } else {
                    this.openDropdown();
                }
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

                const messageNotif = {
                    icon: 'fa-envelope',
                    type: 'message',
                    title: '📨 Messages',
                    message: `You have unread messages`,
                    time: 'Just now',
                    link: '{{ route("finance.index") }}'
                };

                const unreadCount = this.notifCount.textContent;
                if (unreadCount > 0) {
                    notifications.unshift(messageNotif);
                }

                if (notifications.length === 0) {
                    this.notifList.innerHTML = `
                        <div class="dropdown-empty">
                            <i class="fas fa-bell-slash"></i>
                            <span>All caught up!</span>
                            <small style="display: block; font-size: 0.7rem; margin-top: 4px; opacity: 0.6;">No new notifications</small>
                        </div>
                    `;
                    return;
                }

                this.notifList.innerHTML = notifications.map(notif => `
                    <div class="notification-item ${notif.read ? '' : 'unread'}" 
                         onclick="location.href='${notif.link || '#'}'">
                        <div class="notification-icon ${notif.type || 'info'}">
                            <i class="fas ${notif.icon || 'fa-bell'}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${this.escapeHtml(notif.title)}</div>
                            <div class="notification-message">${this.escapeHtml(notif.message)}</div>
                            <div class="notification-time">
                                <i class="fas fa-clock"></i> ${this.escapeHtml(notif.time || 'Just now')}
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text || '';
                return div.innerHTML;
            }

            updateBadge(count) {
                const notifDot = this.notifCount;
                const totalSpan = this.totalCountSpan;
                
                if (count > 0) {
                    const displayCount = count > 99 ? '99+' : count;
                    notifDot.textContent = displayCount;
                    notifDot.style.display = 'flex';
                    notifDot.classList.add('has-messages');
                    if (totalSpan) {
                        totalSpan.textContent = displayCount;
                    }
                } else {
                    notifDot.style.display = 'none';
                    notifDot.classList.remove('has-messages');
                    if (totalSpan) {
                        totalSpan.textContent = '0';
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            new NotificationManager();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>