<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SaaS POS - Ultimate Business Management Platform</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 10px; }

        /* ========== THEME VARIABLES ========== */
        [data-theme="dark"] {
            --bg-primary: #06070A;
            --bg-secondary: #0C0E14;
            --bg-card: #111318;
            --bg-elevated: #16181F;
            --bg-glass: rgba(255,255,255,0.03);
            --bg-glass-hover: rgba(255,255,255,0.06);
            --border: rgba(255,255,255,0.06);
            --border-hover: rgba(255,255,255,0.12);
            --border-accent: rgba(99,102,241,0.3);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #475569;
            --text-heading: #ffffff;
            --accent: #6366f1;
            --accent-light: #818cf8;
            --accent-glow: rgba(99,102,241,0.15);
            --shadow-card: 0 20px 40px rgba(0,0,0,0.3);
            --shadow-glow: 0 0 40px rgba(99,102,241,0.08);
            --hero-gradient-1: rgba(99,102,241,0.08);
            --hero-gradient-2: rgba(139,92,246,0.08);
            --nav-bg: rgba(6,7,10,0.85);
            --pricing-featured-bg: rgba(99,102,241,0.08);
            --testimonial-text: #d1d5db;
            --footer-bg: transparent;
            --badge-bg: rgba(99,102,241,0.1);
            --check-color: #34d399;
            --star-color: #fbbf24;
        }

        [data-theme="light"] {
            --bg-primary: #f8fafc;
            --bg-secondary: #f1f5f9;
            --bg-card: #ffffff;
            --bg-elevated: #ffffff;
            --bg-glass: rgba(255,255,255,0.7);
            --bg-glass-hover: rgba(255,255,255,0.9);
            --border: rgba(0,0,0,0.08);
            --border-hover: rgba(0,0,0,0.15);
            --border-accent: rgba(99,102,241,0.3);
            --text-primary: #334155;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --text-heading: #0f172a;
            --accent: #6366f1;
            --accent-light: #818cf8;
            --accent-glow: rgba(99,102,241,0.1);
            --shadow-card: 0 20px 40px rgba(0,0,0,0.08);
            --shadow-glow: 0 0 40px rgba(99,102,241,0.06);
            --hero-gradient-1: rgba(99,102,241,0.06);
            --hero-gradient-2: rgba(139,92,246,0.06);
            --nav-bg: rgba(248,250,252,0.85);
            --pricing-featured-bg: rgba(99,102,241,0.05);
            --testimonial-text: #475569;
            --footer-bg: #f1f5f9;
            --badge-bg: rgba(99,102,241,0.08);
            --check-color: #10b981;
            --star-color: #f59e0b;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(20px); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @keyframes spin-slow {
            to { transform: rotate(360deg); }
        }
        @keyframes theme-switch {
            0% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(0.8) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }

        .animate-fade-in { animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-left { animation: fadeInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-right { animation: fadeInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .float { animation: float 6s ease-in-out infinite; }
        .float-reverse { animation: float-reverse 6s ease-in-out infinite; }
        .delay-1 { animation-delay: 0.15s; opacity: 0; }
        .delay-2 { animation-delay: 0.3s; opacity: 0; }
        .delay-3 { animation-delay: 0.45s; opacity: 0; }
        .delay-4 { animation-delay: 0.6s; opacity: 0; }
        .delay-5 { animation-delay: 0.75s; opacity: 0; }

        /* ========== GLASS ========== */
        .glass {
            background: var(--bg-glass);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border);
            transition: background 0.4s ease, border-color 0.4s ease;
        }
        .glass:hover {
            background: var(--bg-glass-hover);
        }

        /* ========== GRADIENT TEXT ========== */
        .gradient-text-blue {
            background: linear-gradient(135deg, #60a5fa, #818cf8, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            background: var(--nav-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border);
            transition: background 0.4s ease, border-color 0.4s ease;
        }
        .nav-link-custom {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s ease;
            position: relative;
        }
        .nav-link-custom:hover { color: var(--text-heading); }
        .nav-link-custom::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        .nav-link-custom:hover::after { width: 100%; }

        /* ========== THEME TOGGLE ========== */
        .theme-toggle {
            width: 56px;
            height: 28px;
            border-radius: 100px;
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            position: relative;
            cursor: pointer;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            padding: 0 3px;
        }
        .theme-toggle-ball {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(99,102,241,0.3);
        }
        [data-theme="light"] .theme-toggle-ball {
            transform: translateX(28px);
            background: linear-gradient(135deg, #f59e0b, #f97316);
            box-shadow: 0 2px 8px rgba(245,158,11,0.3);
        }

        /* ========== BUTTONS ========== */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #6366f1);
            background-size: 200% 100%;
            animation: gradient-shift 3s ease infinite;
            color: white;
            padding: 16px 32px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 30px rgba(99,102,241,0.25), inset 0 1px 0 rgba(255,255,255,0.15);
            position: relative;
            overflow: hidden;
            text-decoration: none;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }
        .btn-primary:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 12px 40px rgba(99,102,241,0.35); }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:active { transform: translateY(0) scale(0.98); }

        .btn-secondary {
            background: var(--bg-glass);
            color: var(--text-heading);
            padding: 16px 32px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            border: 1px solid var(--border);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .btn-secondary:hover { background: var(--bg-glass-hover); transform: translateY(-2px); border-color: var(--border-accent); }

        /* ========== CARDS ========== */
        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px 32px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .feature-card:hover {
            border-color: var(--border-accent);
            transform: translateY(-8px);
            box-shadow: var(--shadow-card), var(--shadow-glow);
        }
        .feature-card:hover::before { opacity: 1; }

        .value-card {
            background: var(--bg-glass);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px 24px;
            transition: all 0.3s ease;
            text-align: center;
        }
        .value-card:hover { background: var(--bg-glass-hover); border-color: var(--border-accent); }

        .testimonial-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 32px;
            transition: all 0.3s ease;
        }
        .testimonial-card:hover { border-color: var(--border-accent); transform: translateY(-4px); box-shadow: var(--shadow-card); }

        .pricing-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 40px 32px;
            transition: all 0.4s ease;
            position: relative;
        }
        .pricing-card.featured {
            border-color: var(--accent);
            background: var(--pricing-featured-bg);
            box-shadow: var(--shadow-glow);
        }
        .pricing-card.featured::before {
            content: 'Most Popular';
            position: absolute;
            top: -12px; left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 4px 20px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
        }
        .pricing-card:hover { transform: translateY(-4px); border-color: var(--border-accent); box-shadow: var(--shadow-card); }

        /* ========== STAT NUMBER ========== */
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ========== HERO ========== */
        .hero-gradient {
            background:
                radial-gradient(ellipse at 20% 50%, var(--hero-gradient-1) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 50%, var(--hero-gradient-2) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 0%, var(--hero-gradient-1) 0%, transparent 50%);
            position: relative;
            transition: background 0.4s ease;
        }
        .hero-gradient::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: conic-gradient(from 0deg at 50% 50%, transparent, rgba(99,102,241,0.02), transparent, rgba(139,92,246,0.02), transparent);
            animation: spin-slow 20s linear infinite;
            pointer-events: none;
        }

        /* ========== FLOATING ELEMENTS ========== */
        .float-element {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .float-element:nth-child(1) {
            width: 300px; height: 300px;
            top: -100px; left: -100px;
            background: radial-gradient(circle, var(--hero-gradient-1) 0%, transparent 70%);
            animation: float 8s ease-in-out infinite;
        }
        .float-element:nth-child(2) {
            width: 200px; height: 200px;
            bottom: -50px; right: -50px;
            background: radial-gradient(circle, var(--hero-gradient-2) 0%, transparent 70%);
            animation: float-reverse 8s ease-in-out infinite;
        }

        /* ========== MARQUEE ========== */
        .marquee-content {
            display: flex;
            animation: marquee 30s linear infinite;
        }
        .marquee-content:hover { animation-play-state: paused; }

        /* ========== MOBILE MENU ========== */
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            background: var(--bg-card);
            border-right: 1px solid var(--border);
        }
        .mobile-menu.open { transform: translateX(0); }

        /* ========== FAQ ========== */
        .faq-item {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .faq-item:hover { border-color: var(--border-hover); }
        .faq-btn {
            width: 100%;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: left;
            color: var(--text-heading);
            font-weight: 600;
            font-size: 15px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .faq-btn:hover { background: var(--bg-glass); }
        .faq-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1), padding 0.3s ease;
            padding: 0 24px;
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.7;
        }
        .faq-content.open {
            padding: 0 24px 20px;
        }
        .faq-icon {
            transition: transform 0.3s ease;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .faq-icon.open { transform: rotate(180deg); }

        /* ========== CTA SECTION ========== */
        .cta-section {
            background: var(--bg-card);
            border: 1px solid var(--border);
        }

        /* ========== SECTION BACKGROUNDS ========== */
        .section-alt {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            transition: background 0.4s ease;
        }

        /* ========== FOOTER ========== */
        .footer-section {
            border-top: 1px solid var(--border);
            transition: background 0.4s ease, border-color 0.4s ease;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .stat-number { font-size: 2.5rem; }
            .feature-card { padding: 24px 20px; }
            .pricing-card { padding: 32px 24px; }
        }

        /* ========== TRANSITIONS ========== */
        .theme-transition,
        .theme-transition *,
        .theme-transition *::before,
        .theme-transition *::after {
            transition: background 0.4s ease, color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease !important;
        }
    </style>
</head>
<body>

    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold" style="color: var(--text-heading);">SaaS<span class="text-indigo-500">POS</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#features" class="nav-link-custom">Features</a>
                    <a href="#how-it-works" class="nav-link-custom">How It Works</a>
                    <a href="#pricing" class="nav-link-custom">Pricing</a>
                    <a href="#testimonials" class="nav-link-custom">Testimonials</a>
                    <a href="#faq" class="nav-link-custom">FAQ</a>
                </div>

                <!-- Right Side -->
                <div class="hidden lg:flex items-center gap-4">
                    <!-- Theme Toggle -->
                    <div class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                        <div class="theme-toggle-ball">
                            <!-- Moon Icon (Dark) -->
                            <svg class="w-3 h-3 text-white moon-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                            </svg>
                            <!-- Sun Icon (Light) -->
                            <svg class="w-3.5 h-3.5 text-white sun-icon hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="text-sm font-medium px-4 py-2 transition-colors" style="color: var(--text-secondary);" onmouseover="this.style.color='var(--text-heading)'" onmouseout="this.style.color='var(--text-secondary)'">Sign In</a>
                    <a href="{{ route('business.register') }}" class="btn-primary text-sm !px-6 !py-3 !gap-2">
                        Get Started Free
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                <!-- Mobile: Theme Toggle + Menu Button -->
                <div class="flex items-center gap-3 lg:hidden">
                    <div class="theme-toggle" onclick="toggleTheme()" title="Toggle theme" style="transform: scale(0.85);">
                        <div class="theme-toggle-ball">
                            <svg class="w-3 h-3 text-white moon-icon" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                            <svg class="w-3.5 h-3.5 text-white sun-icon hidden" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                    <button class="w-10 h-10 rounded-xl flex items-center justify-center border cursor-pointer" style="background: var(--bg-glass); border-color: var(--border);" onclick="toggleMobileMenu()">
                        <svg class="w-5 h-5" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobileMenuOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleMobileMenu()"></div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu fixed top-0 left-0 bottom-0 w-72 z-50 p-6 lg:hidden">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-lg font-bold" style="color: var(--text-heading);">SaaS<span class="text-indigo-500">POS</span></span>
            </div>
            <button onclick="toggleMobileMenu()" class="w-8 h-8 rounded-lg flex items-center justify-center cursor-pointer" style="background: var(--bg-glass); border: 1px solid var(--border);">
                <svg class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-1">
            <a href="#features" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm rounded-xl transition-colors" style="color: var(--text-secondary);">Features</a>
            <a href="#how-it-works" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm rounded-xl transition-colors" style="color: var(--text-secondary);">How It Works</a>
            <a href="#pricing" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm rounded-xl transition-colors" style="color: var(--text-secondary);">Pricing</a>
            <a href="#testimonials" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm rounded-xl transition-colors" style="color: var(--text-secondary);">Testimonials</a>
            <a href="#faq" onclick="toggleMobileMenu()" class="block px-4 py-3 text-sm rounded-xl transition-colors" style="color: var(--text-secondary);">FAQ</a>
        </div>
        <div class="mt-8 space-y-3">
            <a href="{{ route('login') }}" class="block text-center text-sm px-4 py-3 border rounded-xl transition-colors" style="color: var(--text-secondary); border-color: var(--border);">Sign In</a>
            <a href="{{ route('business.register') }}" class="block text-center text-sm text-white bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3 rounded-xl font-semibold">Get Started Free</a>
        </div>
    </div>

    <!-- ==================== HERO SECTION ==================== -->
    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden pt-20">
        <div class="float-element"></div>
        <div class="float-element"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Left -->
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full animate-fade-in" style="background: var(--badge-bg); border: 1px solid var(--border-accent);">
                        <span class="w-2 h-2 bg-indigo-400 rounded-full animate-pulse"></span>
                        <span class="text-xs font-semibold text-indigo-400">🚀 Now in Public Beta</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-[1.1] animate-fade-in delay-1" style="color: var(--text-heading);">
                        Transform Your
                        <span class="gradient-text-blue">Business Operations</span>
                        with One Powerful Platform
                    </h1>

                    <p class="text-lg leading-relaxed max-w-xl animate-fade-in delay-2" style="color: var(--text-secondary);">
                        SaaS POS is the all-in-one point-of-sale and inventory management solution
                        designed for modern businesses. Manage sales, track inventory, analyze reports,
                        and grow your business — all from one dashboard.
                    </p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 animate-fade-in delay-3">
                        <a href="{{ route('business.register') }}" class="btn-primary text-center justify-center">
                            Start Free Trial
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="#demo" class="btn-secondary text-center justify-center">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                            Watch Demo
                        </a>
                    </div>

                    <div class="flex items-center gap-8 pt-4 animate-fade-in delay-4">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 border-2 flex items-center justify-center text-[10px] font-bold text-white" style="border-color: var(--bg-primary);">AK</div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 border-2 flex items-center justify-center text-[10px] font-bold text-white" style="border-color: var(--bg-primary);">SM</div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 border-2 flex items-center justify-center text-[10px] font-bold text-white" style="border-color: var(--bg-primary);">RJ</div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-400 to-rose-500 border-2 flex items-center justify-center text-[10px] font-bold text-white" style="border-color: var(--bg-primary);">+</div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color: var(--text-heading);">1,200+</p>
                            <p class="text-xs" style="color: var(--text-muted);">Happy Business Owners</p>
                        </div>
                    </div>
                </div>

                <!-- Right - Dashboard Preview -->
                <div class="relative animate-fade-right delay-2">
                    <div class="glass rounded-3xl overflow-hidden shadow-2xl" style="box-shadow: var(--shadow-card), var(--shadow-glow);">
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-16 h-2 rounded-full" style="background: var(--border-hover);"></div>
                                    <div class="w-8 h-2 rounded-full" style="background: var(--border-hover);"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-xl p-3" style="background: var(--bg-glass);">
                                    <div class="w-12 h-2 rounded-full mb-2" style="background: var(--border-hover);"></div>
                                    <div class="w-20 h-4 bg-gradient-to-r from-indigo-500/40 to-purple-500/40 rounded-full"></div>
                                </div>
                                <div class="rounded-xl p-3" style="background: var(--bg-glass);">
                                    <div class="w-12 h-2 rounded-full mb-2" style="background: var(--border-hover);"></div>
                                    <div class="w-16 h-4 bg-gradient-to-r from-amber-500/40 to-orange-500/40 rounded-full"></div>
                                </div>
                                <div class="rounded-xl p-3" style="background: var(--bg-glass);">
                                    <div class="w-12 h-2 rounded-full mb-2" style="background: var(--border-hover);"></div>
                                    <div class="w-18 h-4 bg-gradient-to-r from-emerald-500/40 to-teal-500/40 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Chart Mock -->
                            <div class="rounded-xl p-4" style="background: var(--bg-glass);">
                                <div class="flex items-end gap-2 h-24">
                                    <div class="flex-1 bg-indigo-500/30 rounded-t-lg" style="height: 40%;"></div>
                                    <div class="flex-1 bg-indigo-500/40 rounded-t-lg" style="height: 65%;"></div>
                                    <div class="flex-1 bg-indigo-500/50 rounded-t-lg" style="height: 45%;"></div>
                                    <div class="flex-1 bg-indigo-500/60 rounded-t-lg" style="height: 80%;"></div>
                                    <div class="flex-1 bg-indigo-500/50 rounded-t-lg" style="height: 55%;"></div>
                                    <div class="flex-1 bg-indigo-500/70 rounded-t-lg" style="height: 90%;"></div>
                                    <div class="flex-1 bg-indigo-500/80 rounded-t-lg" style="height: 100%;"></div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-lg" style="background: var(--border-hover);"></div>
                                    <div class="flex-1 h-3 rounded-full" style="background: var(--border-hover);"></div>
                                    <div class="w-12 h-3 rounded-full" style="background: var(--border-hover);"></div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded-lg" style="background: var(--border-hover);"></div>
                                    <div class="flex-1 h-3 rounded-full" style="background: var(--border-hover);"></div>
                                    <div class="w-12 h-3 rounded-full" style="background: var(--border-hover);"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Cards -->
                    <div class="absolute -top-4 -right-4 glass rounded-2xl p-3 shadow-xl float" style="width: 140px;">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                            <p class="text-[10px]" style="color: var(--text-muted);">Sales Today</p>
                        </div>
                        <p class="text-lg font-bold mt-1" style="color: var(--text-heading);">Rs. 24,500</p>
                    </div>

                    <div class="absolute -bottom-4 -left-4 glass rounded-2xl p-3 shadow-xl float-reverse" style="width: 150px;">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-indigo-400 rounded-full"></div>
                            <p class="text-[10px]" style="color: var(--text-muted);">Orders</p>
                        </div>
                        <p class="text-lg font-bold mt-1" style="color: var(--text-heading);">48 Active</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TRUSTED BY ==================== -->
    <section class="py-16" style="border-top: 1px solid var(--border);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-semibold uppercase tracking-wider mb-8" style="color: var(--text-muted);">Trusted by innovative businesses worldwide</p>
            <div class="overflow-hidden">
                <div class="flex marquee-content gap-16 items-center">
                    <div class="flex items-center gap-16">
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg><span class="text-sm font-semibold whitespace-nowrap">TechCorp</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg><span class="text-sm font-semibold whitespace-nowrap">ShopFlow</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg><span class="text-sm font-semibold whitespace-nowrap">RetailPro</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h18v18H3z"/></svg><span class="text-sm font-semibold whitespace-nowrap">BizHub</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg><span class="text-sm font-semibold whitespace-nowrap">StockMaster</span></div>
                    </div>
                    <div class="flex items-center gap-16">
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg><span class="text-sm font-semibold whitespace-nowrap">TechCorp</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg><span class="text-sm font-semibold whitespace-nowrap">ShopFlow</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg><span class="text-sm font-semibold whitespace-nowrap">RetailPro</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h18v18H3z"/></svg><span class="text-sm font-semibold whitespace-nowrap">BizHub</span></div>
                        <div class="flex items-center gap-2" style="color: var(--text-muted);"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg><span class="text-sm font-semibold whitespace-nowrap">StockMaster</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FEATURES ==================== -->
    <section id="features" class="py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider px-4 py-1.5 rounded-full" style="background: var(--badge-bg);">Features</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mt-4" style="color: var(--text-heading);">Everything You Need to Run Your Business</h2>
                <p class="mt-4 text-lg" style="color: var(--text-secondary);">From inventory management to sales analytics — all in one beautiful, intuitive platform.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="feature-card scroll-reveal">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500/20 to-purple-500/10 rounded-2xl flex items-center justify-center border border-indigo-500/20 mb-5">
                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2" style="color: var(--text-heading);">Point of Sale</h3>
                    <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Fast, intuitive POS with barcode scanning, multiple payment methods, and instant receipt generation.</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 rounded-2xl flex items-center justify-center border border-emerald-500/20 mb-5">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2" style="color: var(--text-heading);">Inventory Management</h3>
                    <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Real-time stock tracking, low stock alerts, category management, and inventory valuation reports.</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500/20 to-orange-500/10 rounded-2xl flex items-center justify-center border border-amber-500/20 mb-5">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2" style="color: var(--text-heading);">Analytics & Reports</h3>
                    <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Comprehensive dashboards, sales reports, profit analysis, and exportable data for informed decisions.</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="w-12 h-12 bg-gradient-to-br from-sky-500/20 to-blue-500/10 rounded-2xl flex items-center justify-center border border-sky-500/20 mb-5">
                        <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2" style="color: var(--text-heading);">Customer Management</h3>
                    <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Track customer history, manage loyalty programs, and build stronger relationships with clients.</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500/20 to-rose-500/10 rounded-2xl flex items-center justify-center border border-pink-500/20 mb-5">
                        <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2" style="color: var(--text-heading);">Multi-Store Support</h3>
                    <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Manage multiple locations from a single dashboard with centralized inventory and consolidated reports.</p>
                </div>

                <div class="feature-card scroll-reveal">
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500/20 to-purple-500/10 rounded-2xl flex items-center justify-center border border-violet-500/20 mb-5">
                        <svg class="w-6 h-6 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2" style="color: var(--text-heading);">Secure & Reliable</h3>
                    <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Enterprise-grade security, automated backups, 99.9% uptime SLA, and 24/7 customer support.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== HOW IT WORKS ==================== -->
    <section id="how-it-works" class="section-alt py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider px-4 py-1.5 rounded-full" style="background: var(--badge-bg);">How It Works</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mt-4" style="color: var(--text-heading);">Get Started in 3 Simple Steps</h2>
                <p class="mt-4 text-lg" style="color: var(--text-secondary);">No credit card required. No technical skills needed.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <div class="text-center group scroll-reveal">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500/20 to-purple-500/10 rounded-3xl flex items-center justify-center border border-indigo-500/20 mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-3xl font-black gradient-text-blue">1</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3" style="color: var(--text-heading);">Create Your Account</h3>
                    <p class="text-sm leading-relaxed max-w-xs mx-auto" style="color: var(--text-secondary);">Sign up in 30 seconds. No credit card required. Start your free trial immediately.</p>
                </div>

                <div class="text-center group scroll-reveal">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-500/20 to-teal-500/10 rounded-3xl flex items-center justify-center border border-emerald-500/20 mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-3xl font-black text-emerald-400">2</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3" style="color: var(--text-heading);">Set Up Your Store</h3>
                    <p class="text-sm leading-relaxed max-w-xs mx-auto" style="color: var(--text-secondary);">Add your products, categories, prices, and stock quantities in minutes.</p>
                </div>

                <div class="text-center group scroll-reveal">
                    <div class="w-20 h-20 bg-gradient-to-br from-amber-500/20 to-orange-500/10 rounded-3xl flex items-center justify-center border border-amber-500/20 mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-3xl font-black text-amber-400">3</span>
                    </div>
                    <h3 class="text-xl font-bold mb-3" style="color: var(--text-heading);">Start Selling</h3>
                    <p class="text-sm leading-relaxed max-w-xs mx-auto" style="color: var(--text-secondary);">Use our powerful POS system, track inventory, and watch your business grow.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== WHY CHOOSE US ==================== -->
    <section class="py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider px-4 py-1.5 rounded-full" style="background: var(--badge-bg);">Why Choose Us</span>
                    <h2 class="text-3xl sm:text-4xl font-black mt-4 leading-tight" style="color: var(--text-heading);">Built for Modern Business Owners</h2>
                    <p class="mt-4 text-lg" style="color: var(--text-secondary);">We've combined years of retail experience with cutting-edge technology to create the ultimate business management platform.</p>

                    <div class="space-y-6 mt-10">
                        <div class="flex items-start gap-4 scroll-reveal">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold" style="color: var(--text-heading);">99.9% Uptime Guarantee</h4>
                                <p class="text-sm mt-1" style="color: var(--text-muted);">Your business never sleeps, and neither do we. Enterprise-grade infrastructure ensures maximum reliability.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 scroll-reveal">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/15 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold" style="color: var(--text-heading);">Lightning Fast Performance</h4>
                                <p class="text-sm mt-1" style="color: var(--text-muted);">Optimized for speed. Process transactions in milliseconds, even during peak hours.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 scroll-reveal">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/15 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold" style="color: var(--text-heading);">Bank-Level Security</h4>
                                <p class="text-sm mt-1" style="color: var(--text-muted);">Your data is protected with 256-bit encryption, regular backups, and strict access controls.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="value-card scroll-reveal"><div class="stat-number">10K+</div><p class="text-sm mt-2" style="color: var(--text-secondary);">Transactions Daily</p></div>
                    <div class="value-card scroll-reveal"><div class="stat-number">99.9%</div><p class="text-sm mt-2" style="color: var(--text-secondary);">Uptime Guarantee</p></div>
                    <div class="value-card scroll-reveal"><div class="stat-number">4.9★</div><p class="text-sm mt-2" style="color: var(--text-secondary);">User Rating</p></div>
                    <div class="value-card scroll-reveal"><div class="stat-number">50+</div><p class="text-sm mt-2" style="color: var(--text-secondary);">Countries Served</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== PRICING ==================== -->
    <section id="pricing" class="section-alt py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider px-4 py-1.5 rounded-full" style="background: var(--badge-bg);">Pricing</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mt-4" style="color: var(--text-heading);">Simple, Transparent Pricing</h2>
                <p class="mt-4 text-lg" style="color: var(--text-secondary);">Start free and upgrade as you grow. No hidden fees.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto items-start">
                <!-- Starter -->
                <div class="pricing-card scroll-reveal">
                    <h3 class="text-lg font-bold" style="color: var(--text-heading);">Starter</h3>
                    <p class="text-sm mt-1" style="color: var(--text-muted);">Perfect for small businesses</p>
                    <div class="mt-6 mb-8"><span class="text-4xl font-black" style="color: var(--text-heading);">Free</span> <span class="text-sm" style="color: var(--text-muted);">/forever</span></div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Up to 50 Products</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Basic POS</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Inventory Tracking</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Email Support</li>
                    </ul>
                    <a href="{{ route('business.register', ['plan' => 'starter']) }}" class="btn-secondary w-full justify-center text-center">Get Started</a>
                </div>

                <!-- Business -->
                <div class="pricing-card featured scroll-reveal md:-mt-4">
                    <h3 class="text-lg font-bold" style="color: var(--text-heading);">Business</h3>
                    <p class="text-sm mt-1" style="color: var(--text-muted);">Best for growing businesses</p>
                    <div class="mt-6 mb-8"><span class="text-4xl font-black" style="color: var(--text-heading);">$29</span> <span class="text-sm" style="color: var(--text-muted);">/month</span></div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Unlimited Products</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Advanced POS</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Analytics & Reports</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Priority Support</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Multi-User Access</li>
                    </ul>
                    <a href="{{ route('business.register', ['plan' => 'business']) }}" class="btn-primary w-full justify-center text-center">Choose Business</a>
                </div>

                <!-- Enterprise -->
                <div class="pricing-card scroll-reveal">
                    <h3 class="text-lg font-bold" style="color: var(--text-heading);">Enterprise</h3>
                    <p class="text-sm mt-1" style="color: var(--text-muted);">For large organizations</p>
                    <div class="mt-6 mb-8"><span class="text-4xl font-black" style="color: var(--text-heading);">$99</span> <span class="text-sm" style="color: var(--text-muted);">/month</span></div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Everything in Business</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Multi-Store Support</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Custom Integration</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Dedicated Account Manager</li>
                        <li class="flex items-center gap-2 text-sm" style="color: var(--text-secondary);"><svg class="w-4 h-4 flex-shrink-0" style="color: var(--check-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>24/7 Phone Support</li>
                    </ul>
                    <a href="{{ route('business.register', ['plan' => 'enterprise']) }}" class="btn-secondary w-full justify-center text-center">Contact Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TESTIMONIALS ==================== -->
    <section id="testimonials" class="py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider px-4 py-1.5 rounded-full" style="background: var(--badge-bg);">Testimonials</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mt-4" style="color: var(--text-heading);">Trusted by Business Owners</h2>
                <p class="mt-4 text-lg" style="color: var(--text-secondary);">See what our customers have to say about SaaS POS.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="testimonial-card scroll-reveal">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-sm leading-relaxed mb-6" style="color: var(--testimonial-text);">"SaaS POS transformed how we manage our retail store. The inventory tracking alone has saved us thousands in lost stock. Absolutely love it!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-xs font-bold text-white">SK</div>
                        <div><p class="text-sm font-semibold" style="color: var(--text-heading);">Sarah Khan</p><p class="text-xs" style="color: var(--text-muted);">Fashion Boutique Owner</p></div>
                    </div>
                </div>

                <div class="testimonial-card scroll-reveal">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-sm leading-relaxed mb-6" style="color: var(--testimonial-text);">"The analytics features are incredible. I can see exactly what's selling, when, and to whom. This has completely changed my inventory strategy."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-xs font-bold text-white">AR</div>
                        <div><p class="text-sm font-semibold" style="color: var(--text-heading);">Ahmed Raza</p><p class="text-xs" style="color: var(--text-muted);">Electronics Store Manager</p></div>
                    </div>
                </div>

                <div class="testimonial-card scroll-reveal">
                    <div class="flex items-center gap-1 mb-4">
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-4 h-4" style="color: var(--star-color);" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-sm leading-relaxed mb-6" style="color: var(--testimonial-text);">"We run three stores and SaaS POS makes it effortless. Centralized inventory, consolidated reports, and amazing support. Highly recommended!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-xs font-bold text-white">ZM</div>
                        <div><p class="text-sm font-semibold" style="color: var(--text-heading);">Zara Malik</p><p class="text-xs" style="color: var(--text-muted);">Multi-Store Retail Chain</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FAQ ==================== -->
    <section id="faq" class="section-alt py-20 lg:py-32">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-xs font-semibold text-indigo-400 uppercase tracking-wider px-4 py-1.5 rounded-full" style="background: var(--badge-bg);">FAQ</span>
                <h2 class="text-3xl sm:text-4xl font-black mt-4" style="color: var(--text-heading);">Frequently Asked Questions</h2>
            </div>

            <div class="space-y-4">
                <div class="faq-item scroll-reveal">
                    <button class="faq-btn" onclick="toggleFaq(this)">
                        <span>Is there a free trial available?</span>
                        <svg class="w-5 h-5 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content">Yes! We offer a 14-day free trial with full access to all features. No credit card required. You can cancel anytime.</div>
                </div>

                <div class="faq-item scroll-reveal">
                    <button class="faq-btn" onclick="toggleFaq(this)">
                        <span>Can I import my existing products?</span>
                        <svg class="w-5 h-5 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content">Absolutely! You can easily import your products from CSV or Excel files. We also support bulk editing and export features.</div>
                </div>

                <div class="faq-item scroll-reveal">
                    <button class="faq-btn" onclick="toggleFaq(this)">
                        <span>Is my data secure?</span>
                        <svg class="w-5 h-5 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content">Security is our top priority. All data is encrypted with 256-bit SSL, stored in secure data centers, and backed up daily.</div>
                </div>

                <div class="faq-item scroll-reveal">
                    <button class="faq-btn" onclick="toggleFaq(this)">
                        <span>What kind of support do you offer?</span>
                        <svg class="w-5 h-5 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content">We offer 24/7 email support for all plans. Business and Enterprise plans include priority live chat and phone support.</div>
                </div>

                <div class="faq-item scroll-reveal">
                    <button class="faq-btn" onclick="toggleFaq(this)">
                        <span>Can I upgrade or downgrade my plan?</span>
                        <svg class="w-5 h-5 faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-content">Yes! You can upgrade or downgrade your plan at any time. Changes take effect immediately and we'll prorate your billing.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== CTA ==================== -->
    <section class="py-20 lg:py-32">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="cta-section glass rounded-3xl p-12 lg:p-20 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500"></div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight" style="color: var(--text-heading);">Ready to Transform Your Business?</h2>
                <p class="mt-4 text-lg max-w-2xl mx-auto" style="color: var(--text-secondary);">Join thousands of business owners who trust SaaS POS. Start your free trial today — no credit card required.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
                    <a href="{{ route('business.register') }}" class="btn-primary text-lg !px-10 !py-4">
                        Start Free Trial
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#demo" class="btn-secondary text-lg !px-10 !py-4">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/></svg>
                        Schedule a Demo
                    </a>
                </div>
                <p class="text-xs mt-6" style="color: var(--text-muted);">Free 14-day trial • No credit card • Cancel anytime</p>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="footer-section py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 lg:gap-12">
                <div class="md:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-lg font-bold" style="color: var(--text-heading);">SaaS<span class="text-indigo-500">POS</span></span>
                    </div>
                    <p class="text-sm leading-relaxed" style="color: var(--text-muted);">The all-in-one platform for modern business management. Sell smarter, grow faster.</p>
                </div>

                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: var(--text-secondary);">Product</h4>
                    <ul class="space-y-3">
                        <li><a href="#features" class="text-sm transition-colors" style="color: var(--text-muted);">Features</a></li>
                        <li><a href="#pricing" class="text-sm transition-colors" style="color: var(--text-muted);">Pricing</a></li>
                        <li><a href="#testimonials" class="text-sm transition-colors" style="color: var(--text-muted);">Testimonials</a></li>
                        <li><a href="#faq" class="text-sm transition-colors" style="color: var(--text-muted);">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: var(--text-secondary);">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-muted);">About Us</a></li>
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-muted);">Blog</a></li>
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-muted);">Careers</a></li>
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-muted);">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider mb-4" style="color: var(--text-secondary);">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-muted);">Privacy Policy</a></li>
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-muted);">Terms of Service</a></li>
                        <li><a href="#" class="text-sm transition-colors" style="color: var(--text-muted);">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-top: 1px solid var(--border);">
                <p class="text-xs" style="color: var(--text-muted);">© 2024 SaaS POS. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" style="color: var(--text-muted);" class="hover:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" style="color: var(--text-muted);" class="hover:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                    <a href="#" style="color: var(--text-muted);" class="hover:text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== SCRIPTS ==================== -->
    <script>
        // ======== THEME TOGGLE ========
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            // Add transition class
            document.body.classList.add('theme-transition');

            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // Update icons
            updateThemeIcons(newTheme);

            // Remove transition class after animation
            setTimeout(() => document.body.classList.remove('theme-transition'), 500);
        }

        function updateThemeIcons(theme) {
            document.querySelectorAll('.moon-icon').forEach(icon => {
                icon.classList.toggle('hidden', theme === 'light');
            });
            document.querySelectorAll('.sun-icon').forEach(icon => {
                icon.classList.toggle('hidden', theme === 'dark');
            });
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcons(savedTheme);
        });

        // ======== MOBILE MENU ========
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            menu.classList.toggle('open');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        // ======== FAQ ACCORDION ========
        function toggleFaq(btn) {
            const content = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');
            const isOpen = content.classList.contains('open');

            // Close all
            document.querySelectorAll('.faq-content').forEach(c => {
                c.classList.remove('open');
                c.style.maxHeight = '0px';
            });
            document.querySelectorAll('.faq-icon').forEach(i => i.classList.remove('open'));

            // Open clicked if was closed
            if (!isOpen) {
                content.classList.add('open');
                content.style.maxHeight = content.scrollHeight + 20 + 'px';
                icon.classList.add('open');
            }
        }

        // ======== SCROLL REVEAL ========
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('.scroll-reveal').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1)';
                observer.observe(el);
            });
        });

        // ======== SMOOTH SCROLL ========
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ======== NAVBAR SCROLL EFFECT ========
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                nav.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
            } else {
                nav.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>