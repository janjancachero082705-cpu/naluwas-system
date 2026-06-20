<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TINC Church System - Church Management Software</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
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
            background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -30px) scale(1.1); }
            50% { transform: translate(-30px, 50px) scale(0.9); }
            75% { transform: translate(40px, 40px) scale(1.05); }
        }

        .circle-1 { width: 400px; height: 400px; top: -100px; left: -150px; animation-delay: 0s; }
        .circle-2 { width: 300px; height: 300px; bottom: -100px; right: -100px; animation-delay: 5s; }
        .circle-3 { width: 200px; height: 200px; top: 40%; left: 10%; animation-delay: 2s; }
        .circle-4 { width: 350px; height: 350px; bottom: 20%; right: 20%; animation-delay: 8s; }
        .circle-5 { width: 150px; height: 150px; top: 20%; right: 15%; animation-delay: 3s; }
        .circle-6 { width: 250px; height: 250px; bottom: 40%; left: 30%; animation-delay: 10s; }

        /* Hero Content */
        .hero-wrapper {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .hero-card {
            max-width: 700px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 48px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.3);
        }

        .logo-icon i {
            font-size: 2.5rem;
            color: white;
        }

        .hero-card h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1rem;
        }

        .hero-card .tagline {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .feature-badge {
            background: #f1f5f9;
            padding: 0.5rem 1rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .feature-badge i {
            color: #667eea;
            font-size: 0.7rem;
        }

        .btn-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.5);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #e2e8f0;
            padding: 0.9rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            color: #475569;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
        }

        /* Stats */
        .stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: #667eea;
        }

        .stat-label {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 20;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            color: white;
            font-size: 1.2rem;
        }

        .theme-toggle:hover {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.3);
        }

        /* Responsive */
        @media (max-width: 640px) {
            .hero-card { padding: 2rem 1.5rem; margin: 1rem; }
            .hero-card h1 { font-size: 1.8rem; }
            .btn-group { flex-direction: column; }
            .btn-primary, .btn-outline { justify-content: center; }
            .stats { flex-direction: column; gap: 1rem; }
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
    <div class="circle circle-6"></div>
</div>

<button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
    <i class="fas fa-moon"></i>
</button>

<div class="hero-wrapper">
    <div class="hero-card" data-aos="fade-up" data-aos-duration="800">
        <div class="logo-icon">
            <i class="fas fa-church"></i>
        </div>
        <h1>TINC Church System</h1>
        <p class="tagline">
            A complete church management solution for every iglesia — manage members, 
            attendance, choir schedules, inventory, and finances in one sacred space.
        </p>

        <div class="features">
            <span class="feature-badge"><i class="fas fa-users"></i> Member Management</span>
            <span class="feature-badge"><i class="fas fa-calendar-check"></i> Attendance Tracking</span>
            <span class="feature-badge"><i class="fas fa-music"></i> Choir Ministry</span>
            <span class="feature-badge"><i class="fas fa-boxes"></i> Inventory Control</span>
            <span class="feature-badge"><i class="fas fa-chart-line"></i> Financial Reports</span>
        </div>

        <div class="btn-group">
            <a href="{{ route('register') }}" class="btn-primary">
                <i class="fas fa-church"></i> Register Your Church
            </a>
            <a href="{{ route('login') }}" class="btn-outline">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </a>
        </div>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-number">6+</div>
                <div class="stat-label">Core Modules</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Faith-First</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Available</div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();

    // Theme Toggle
    const html = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
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
</script>
</body>
</html>
