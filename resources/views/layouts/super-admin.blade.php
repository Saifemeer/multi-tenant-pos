<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, viewport-fit=cover"
    >
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title', 'Super Admin') · POS Platform</title>

    <!-- Prevent theme flash -->
    <script>
        (() => {
            try {
                const savedTheme = localStorage.getItem('admin-theme');
                const systemTheme = window.matchMedia('(prefers-color-scheme: light)').matches
                    ? 'light'
                    : 'dark';

                document.documentElement.setAttribute(
                    'data-theme',
                    savedTheme || systemTheme
                );
            } catch (error) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        till: { 50: '#EAF6F1', 100: '#CFEBE0', 200: '#9FD7C0', 300: '#6CC2A0', 400: '#3DAB80', 500: '#0E7A5C', 600: '#0B6049', 700: '#084A39', 800: '#063A2D', 900: '#052C23' },
                    },
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>
        /* =========================================================
           BASE
        ========================================================= */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body,
        button,
        input,
        textarea,
        select {
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            min-width: 320px;
            min-height: 100vh;
            min-height: 100dvh;
            overflow-x: hidden;
            background: var(--bg-body);
            color: var(--text-primary);
            transition:
                background 0.4s ease,
                color 0.4s ease;
        }

        button,
        a,
        input,
        textarea,
        select {
            -webkit-tap-highlight-color: transparent;
        }

        button {
            touch-action: manipulation;
        }

        a,
        button {
            outline: none;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--accent-light);
            outline-offset: 3px;
        }

        img,
        svg {
            max-width: 100%;
        }

        /* =========================================================
           SCROLLBAR
        ========================================================= */
        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(14, 122, 92, 0.35) transparent;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(14, 122, 92, 0.3);
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(14, 122, 92, 0.55);
        }

        /* =========================================================
           THEME VARIABLES
        ========================================================= */
        [data-theme="dark"] {
            color-scheme: dark;

            --bg-body: #06070a;
            --bg-sidebar: #0c0e14;
            --bg-header: rgba(6, 7, 10, 0.86);
            --bg-card: #111318;
            --bg-elevated: #16181f;
            --bg-input: #111827;
            --bg-glass: rgba(255, 255, 255, 0.03);

            --border: rgba(255, 255, 255, 0.065);
            --border-hover: rgba(255, 255, 255, 0.13);
            --border-accent: rgba(14, 122, 92, 0.35);

            --text-heading: #ffffff;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;

            --accent: #0E7A5C;
            --accent-light: #4fb894;
            --accent-glow: rgba(14, 122, 92, 0.15);

            --danger: #f87171;
            --danger-bg: rgba(239, 68, 68, 0.08);

            --success: #4ade80;
            --success-bg: rgba(34, 197, 94, 0.08);

            --warning: #fbbf24;
            --warning-bg: rgba(245, 158, 11, 0.08);
        }

        [data-theme="light"] {
            color-scheme: light;

            --bg-body: #f1f5f9;
            --bg-sidebar: #ffffff;
            --bg-header: rgba(255, 255, 255, 0.88);
            --bg-card: #ffffff;
            --bg-elevated: #f8fafc;
            --bg-input: #f8fafc;
            --bg-glass: rgba(255, 255, 255, 0.75);

            --border: rgba(15, 23, 42, 0.08);
            --border-hover: rgba(15, 23, 42, 0.14);
            --border-accent: rgba(14, 122, 92, 0.28);

            --text-heading: #0f172a;
            --text-primary: #334155;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            --accent: #0E7A5C;
            --accent-light: #0E7A5C;
            --accent-glow: rgba(14, 122, 92, 0.08);

            --danger: #ef4444;
            --danger-bg: rgba(239, 68, 68, 0.06);

            --success: #16a34a;
            --success-bg: rgba(34, 197, 94, 0.07);

            --warning: #d97706;
            --warning-bg: rgba(245, 158, 11, 0.08);
        }

        /* =========================================================
           ANIMATIONS
        ========================================================= */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-16px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulseGlow {
            0%,
            100% {
                box-shadow: 0 0 15px rgba(14, 122, 92, 0.15);
            }

            50% {
                box-shadow: 0 0 30px rgba(14, 122, 92, 0.28);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.55s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-slide-in {
            animation: slideInLeft 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-1 {
            animation-delay: 0.08s;
            opacity: 0;
        }

        .delay-2 {
            animation-delay: 0.16s;
            opacity: 0;
        }

        .delay-3 {
            animation-delay: 0.24s;
            opacity: 0;
        }

        /* =========================================================
           LAYOUT
        ========================================================= */
        .app-shell {
            min-height: 100vh;
            min-height: 100dvh;
        }

        .main-panel {
            width: 100%;
            min-width: 0;
            min-height: 100vh;
            min-height: 100dvh;
            padding-left: 272px;
            display: flex;
            flex-direction: column;
        }

        .page-container {
            width: 100%;
            max-width: 1600px;
            margin-inline: auto;
        }

        .page-main {
            flex: 1 1 auto;
            min-width: 0;
        }

        /* =========================================================
           SIDEBAR
        ========================================================= */
        .sidebar {
            position: fixed;
            inset-block: 0;
            left: 0;
            z-index: 50;

            width: 272px;
            height: 100vh;
            height: 100dvh;

            display: flex;
            flex-direction: column;

            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);

            transition:
                transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                background 0.4s ease,
                border-color 0.4s ease;

            will-change: transform;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 1px;
            height: 100%;
            pointer-events: none;

            background: linear-gradient(
                180deg,
                transparent,
                rgba(14, 122, 92, 0.25),
                transparent
            );
        }

        .sidebar-logo-section {
            flex-shrink: 0;
            padding: 24px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-navigation {
            flex: 1 1 auto;
            min-height: 0;
            padding: 16px;
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        .sidebar-user-section {
            flex-shrink: 0;
            padding: 16px;
            border-top: 1px solid var(--border);
            background: var(--bg-sidebar);
        }

        .sidebar-close-button {
            display: none;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;

            color: var(--text-secondary);
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 12px;

            cursor: pointer;
            transition: all 0.25s ease;
        }

        .sidebar-close-button:hover {
            color: var(--text-heading);
            background: var(--accent-glow);
            border-color: var(--border-accent);
        }

        /* =========================================================
           MOBILE OVERLAY
        ========================================================= */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 40;

            width: 100%;
            height: 100%;

            opacity: 0;
            visibility: hidden;
            pointer-events: none;

            border: 0;
            padding: 0;
            margin: 0;

            background: rgba(2, 6, 23, 0.68);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);

            transition:
                opacity 0.3s ease,
                visibility 0.3s ease;

            cursor: default;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        /* =========================================================
           LOGO
        ========================================================= */
        .logo-icon {
            animation: pulseGlow 3s ease-in-out infinite;
        }

        .avatar-ring {
            padding: 2px;
            flex-shrink: 0;
            border-radius: 50%;

            background: linear-gradient(
                135deg,
                #0E7A5C,
                #159C74,
                #6CC2A0
            );
        }

        /* =========================================================
           NAVIGATION
        ========================================================= */
        .section-label {
            display: flex;
            align-items: center;
            gap: 8px;

            padding-inline: 16px;
            margin-bottom: 8px;

            color: var(--text-muted);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .nav-link {
            position: relative;
            overflow: hidden;

            width: 100%;
            min-height: 44px;
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 10px 16px;
            border: 1px solid transparent;
            border-radius: 12px;

            color: var(--text-secondary);
            background: transparent;

            font-size: 13.5px;
            font-weight: 500;
            text-align: left;
            text-decoration: none;

            cursor: pointer;

            transition:
                color 0.25s ease,
                background 0.25s ease,
                border-color 0.25s ease,
                transform 0.25s ease;
        }

        .nav-link > * {
            position: relative;
            z-index: 1;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;

            opacity: 0;
            border-radius: 11px;

            background: linear-gradient(
                135deg,
                rgba(14, 122, 92, 0.09),
                rgba(21, 156, 116, 0.045)
            );

            transition: opacity 0.25s ease;
        }

        .nav-link:hover {
            color: var(--text-heading);
            transform: translateX(3px);
        }

        .nav-link:hover::before {
            opacity: 1;
        }

        .nav-link:hover svg {
            color: var(--accent-light);
        }

        .nav-link.active {
            color: var(--text-heading);
            border-color: rgba(14, 122, 92, 0.22);

            background: linear-gradient(
                135deg,
                rgba(14, 122, 92, 0.16),
                rgba(21, 156, 116, 0.1)
            );

            box-shadow:
                0 0 20px rgba(14, 122, 92, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;

            width: 3px;
            height: 60%;

            transform: translateY(-50%);
            border-radius: 0 4px 4px 0;

            background: linear-gradient(
                180deg,
                #0E7A5C,
                #159C74
            );
        }

        .nav-link.active svg {
            color: var(--accent-light);
        }

        /* =========================================================
           HEADER
        ========================================================= */
        .header {
            position: sticky;
            top: 0;
            z-index: 30;

            flex-shrink: 0;

            background: var(--bg-header);
            border-bottom: 1px solid var(--border);

            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);

            transition:
                background 0.4s ease,
                border-color 0.4s ease;
        }

        .mobile-menu-button {
            display: none;

            width: 40px;
            height: 40px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;

            color: var(--text-secondary);
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 12px;

            cursor: pointer;
            transition: all 0.25s ease;
        }

        .mobile-menu-button:hover {
            color: var(--text-heading);
            background: var(--accent-glow);
            border-color: var(--border-accent);
        }

        .header-icon-button {
            width: 40px;
            height: 40px;
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--text-secondary);
            background: var(--bg-glass);
            border: 1px solid var(--border);
            border-radius: 12px;

            cursor: pointer;

            transition:
                color 0.25s ease,
                background 0.25s ease,
                border-color 0.25s ease,
                transform 0.25s ease;
        }

        .header-icon-button:hover {
            color: var(--text-heading);
            background: var(--accent-glow);
            border-color: var(--border-accent);
            transform: translateY(-1px);
        }

        .notification-dot {
            position: absolute;
            top: 7px;
            right: 7px;

            width: 7px;
            height: 7px;

            border: 2px solid var(--bg-header);
            border-radius: 50%;

            background: #0E7A5C;
            box-shadow: 0 0 8px rgba(14, 122, 92, 0.7);
        }

        /* =========================================================
           THEME TOGGLE
        ========================================================= */
        .theme-toggle {
            width: 48px;
            height: 28px;
            flex-shrink: 0;

            display: flex;
            align-items: center;

            padding: 3px;

            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 999px;

            cursor: pointer;
            transition: all 0.35s ease;
        }

        .theme-toggle:hover {
            border-color: var(--border-accent);
        }

        .theme-toggle-ball {
            width: 20px;
            height: 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: linear-gradient(
                135deg,
                #0E7A5C,
                #159C74
            );

            box-shadow: 0 2px 8px rgba(14, 122, 92, 0.35);

            transition:
                transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55),
                background 0.35s ease;
        }

        [data-theme="light"] .theme-toggle-ball {
            transform: translateX(20px);

            background: linear-gradient(
                135deg,
                #f59e0b,
                #f97316
            );

            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.35);
        }

        /* =========================================================
           ALERTS
        ========================================================= */
        .alert {
            position: relative;
            overflow: hidden;

            display: flex;
            align-items: center;
            gap: 12px;

            margin-bottom: 24px;
            padding: 16px 20px;

            border-radius: 16px;

            font-size: 14px;

            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 4px;
        }

        .alert-success {
            color: var(--success);
            background: var(--success-bg);
            border: 1px solid rgba(34, 197, 94, 0.16);
        }

        .alert-success::before {
            background: linear-gradient(
                180deg,
                #22c55e,
                #4ade80
            );
        }

        .alert-error {
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.16);
        }

        .alert-error::before {
            background: linear-gradient(
                180deg,
                #ef4444,
                #f87171
            );
        }

        /* =========================================================
           CARDS
        ========================================================= */
        .stat-card,
        .modern-card {
            position: relative;
            min-width: 0;
            overflow: hidden;

            padding: 24px;

            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;

            transition:
                transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                border-color 0.35s ease,
                box-shadow 0.35s ease,
                background 0.35s ease;
        }

        .stat-card::before,
        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            left: 0;

            height: 1px;
            opacity: 0;

            background: linear-gradient(
                90deg,
                transparent,
                rgba(14, 122, 92, 0.45),
                transparent
            );

            transition: opacity 0.35s ease;
        }

        .stat-card:hover,
        .modern-card:hover {
            transform: translateY(-3px);
            border-color: var(--border-accent);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 30px var(--accent-glow);
        }

        .stat-card:hover::before,
        .modern-card:hover::before {
            opacity: 1;
        }

        /* =========================================================
           BADGES
        ========================================================= */
        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 4px 11px;

            border-radius: 999px;

            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-success {
            color: var(--success);
            background: var(--success-bg);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .badge-danger {
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .badge-info {
            color: var(--accent-light);
            background: var(--accent-glow);
            border: 1px solid rgba(14, 122, 92, 0.2);
        }

        .badge-warning {
            color: var(--warning);
            background: var(--warning-bg);
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        /* =========================================================
           INPUTS
        ========================================================= */
        .input-modern,
        .select-modern,
        .textarea-modern {
            width: 100%;

            padding: 12px 16px;

            color: var(--text-heading);
            background: var(--bg-input);
            border: 1px solid var(--border-hover);
            border-radius: 12px;

            font-size: 14px;
            outline: none;

            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background 0.25s ease;
        }

        .input-modern,
        .select-modern {
            min-height: 46px;
        }

        .textarea-modern {
            min-height: 120px;
            resize: vertical;
        }

        .input-modern:focus,
        .select-modern:focus,
        .textarea-modern:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .input-modern::placeholder,
        .textarea-modern::placeholder {
            color: var(--text-muted);
        }

        /* =========================================================
           BUTTONS
        ========================================================= */
        .btn-primary,
        .btn-secondary,
        .btn-danger {
            min-height: 42px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;

            padding: 10px 20px;

            border-radius: 12px;

            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;

            cursor: pointer;

            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                background 0.25s ease,
                border-color 0.25s ease,
                color 0.25s ease;
        }

        .btn-primary {
            color: #ffffff;
            border: 1px solid transparent;

            background: linear-gradient(
                135deg,
                #0E7A5C,
                #159C74
            );

            box-shadow: 0 4px 15px rgba(14, 122, 92, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 122, 92, 0.35);
        }

        .btn-secondary {
            color: var(--text-secondary);
            background: var(--bg-elevated);
            border: 1px solid var(--border-hover);
        }

        .btn-secondary:hover {
            color: var(--text-heading);
            background: var(--accent-glow);
            border-color: var(--border-accent);
        }

        .btn-danger {
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.16);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.14);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .responsive-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        /* =========================================================
           TABLES
        ========================================================= */
        .table-responsive,
        .table-shell {
            width: 100%;
            max-width: 100%;

            overflow-x: auto;
            overscroll-behavior-inline: contain;
            -webkit-overflow-scrolling: touch;

            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 18px;
        }

        .table-responsive table,
        .table-shell table {
            width: 100%;
            min-width: 720px;
            border-collapse: collapse;
        }

        .table-row {
            border-bottom: 1px solid var(--border);
            transition: background 0.2s ease;
        }

        .table-row:hover {
            background: var(--accent-glow);
        }

        /* =========================================================
           MISC
        ========================================================= */
        .glass {
            background: var(--bg-glass);
            border: 1px solid var(--border);

            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }

        .theme-transition *,
        .theme-transition *::before,
        .theme-transition *::after {
            transition:
                background-color 0.4s ease,
                color 0.4s ease,
                border-color 0.4s ease,
                box-shadow 0.4s ease !important;
        }

        /* =========================================================
           TABLET & MOBILE
        ========================================================= */
        @media (max-width: 1023.98px) {
            .main-panel {
                padding-left: 0;
            }

            .sidebar {
                width: min(86vw, 292px);
                max-width: 292px;

                transform: translate3d(-105%, 0, 0);

                box-shadow:
                    25px 0 70px rgba(0, 0, 0, 0.35),
                    0 0 0 1px var(--border);
            }

            .sidebar.is-open {
                transform: translate3d(0, 0, 0);
            }

            .sidebar-close-button {
                display: flex;
            }

            .mobile-menu-button {
                display: flex;
            }

            body.sidebar-open {
                overflow: hidden;
                touch-action: none;
            }
        }

        /* =========================================================
           MOBILE
        ========================================================= */
        @media (max-width: 639.98px) {
            .sidebar-logo-section {
                padding: 18px 16px;
            }

            .sidebar-navigation {
                padding: 14px 12px;
            }

            .sidebar-user-section {
                padding: 14px 12px;
            }

            .nav-link {
                padding: 10px 14px;
            }

            .section-label {
                padding-inline: 14px;
            }

            .alert {
                align-items: flex-start;
                gap: 10px;

                margin-bottom: 18px;
                padding: 14px 16px;

                border-radius: 14px;
            }

            .stat-card,
            .modern-card {
                padding: 18px;
                border-radius: 16px;
            }

            .responsive-actions {
                align-items: stretch;
            }

            .responsive-actions .btn-primary,
            .responsive-actions .btn-secondary,
            .responsive-actions .btn-danger {
                flex: 1 1 100%;
                width: 100%;
            }

            .table-responsive,
            .table-shell {
                border-radius: 14px;
            }

            /* Makes unwrapped tables scrollable on mobile */
            .page-main table:not(.no-mobile-scroll) {
                display: block;
                width: 100%;
                max-width: 100%;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* =========================================================
           DESKTOP
        ========================================================= */
        @media (min-width: 1024px) {
            .sidebar {
                transform: translate3d(0, 0, 0) !important;
            }

            .sidebar-overlay {
                display: none !important;
            }
        }

        /* =========================================================
           TOUCH DEVICES
        ========================================================= */
        @media (hover: none) {
            .nav-link:hover,
            .stat-card:hover,
            .modern-card:hover,
            .btn-primary:hover,
            .header-icon-button:hover {
                transform: none;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Mobile sidebar overlay -->
    <button
        type="button"
        id="sidebarOverlay"
        class="sidebar-overlay"
        onclick="closeSidebar()"
        aria-label="Close navigation menu"
        aria-hidden="true"
        tabindex="-1"
    ></button>

    <div class="app-shell">

        <!-- =====================================================
             SIDEBAR
        ====================================================== -->
        <aside
            id="sidebar"
            class="sidebar"
            aria-label="Super admin navigation"
        >
            <!-- Logo -->
            <div class="sidebar-logo-section">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="relative flex-shrink-0">
                            <div class="logo-icon w-11 h-11 bg-gradient-to-br from-till-500 via-till-400 to-till-600 rounded-2xl flex items-center justify-center shadow-lg shadow-till-500/20 rotate-3 hover:rotate-0 transition-transform duration-300">
                                <svg
                                    class="w-5 h-5 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                    />
                                </svg>
                            </div>

                            <div
                                class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2"
                                style="border-color: var(--bg-sidebar);"
                            ></div>
                        </div>

                        <div class="min-w-0">
                            <p
                                class="font-extrabold text-[15px] tracking-tight truncate"
                                style="color: var(--text-heading);"
                            >
                                Super<span class="text-till-500">Admin</span>
                            </p>

                            <p
                                class="text-[11px] font-medium truncate"
                                style="color: var(--text-muted);"
                            >
                                Platform Control Panel
                            </p>
                        </div>
                    </div>

                    <button
                        type="button"
                        class="sidebar-close-button"
                        onclick="closeSidebar()"
                        aria-label="Close navigation menu"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

                <div class="section-label mt-1 mb-3">Jaiza</div>

                <a href="{{ route('super-admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>

                <div class="section-label mt-6 mb-3">Intezaam</div>

                <a href="{{ route('super-admin.tenants.index') }}"
                   class="nav-link {{ request()->routeIs('super-admin.tenants.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m16 0h-2M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8v-4a1 1 0 011-1h0a1 1 0 011 1v4"/>
                    </svg>
                    Tenants
                    <span class="ml-auto badge badge-info text-[10px] py-0.5 px-2">Sab</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="sidebar-user-section">
                <!-- System Status -->
                <div
                    class="rounded-2xl p-3 mb-4"
                    style="
                        background: var(--bg-glass);
                        border: 1px solid var(--border);
                    "
                >
                    <div class="flex items-center justify-between gap-2 text-[11px]">
                        <span
                            class="truncate"
                            style="color: var(--text-muted);"
                        >
                            System Ka Status
                        </span>

                        <span class="badge badge-success text-[10px] py-0.5 px-2">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1.5"></span>
                            Chalu Hai
                        </span>
                    </div>
                </div>

                <!-- User -->
                <div class="flex items-center gap-3 mb-3">
                    <div class="avatar-ring">
                        <div class="w-9 h-9 bg-gradient-to-br from-till-500 to-till-700 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p
                            class="text-sm font-semibold truncate"
                            style="color: var(--text-heading);"
                        >
                            {{ auth()->user()->name }}
                        </p>

                        <p
                            class="text-[11px] font-medium truncate"
                            style="color: var(--accent-light);"
                        >
                            Super Admin
                        </p>
                    </div>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="nav-link group"
                        style="color: var(--danger);"
                    >
                        <svg
                            class="w-[18px] h-[18px] flex-shrink-0 group-hover:rotate-12 transition-transform"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            />
                        </svg>

                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- =====================================================
             MAIN PANEL
        ====================================================== -->
        <div class="main-panel">

            <!-- Header -->
            <header class="header">
                <div class="page-container px-4 sm:px-6 lg:px-8 py-3.5 sm:py-4">
                    <div class="flex items-center justify-between gap-3">
                        <!-- Header Left -->
                        <div class="flex items-center gap-3 sm:gap-4 min-w-0 flex-1">
                            <button
                                type="button"
                                id="menuButton"
                                class="mobile-menu-button"
                                onclick="openSidebar()"
                                aria-label="Menu kholein"
                                aria-controls="sidebar"
                                aria-expanded="false"
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                </svg>
                            </button>

                            <div class="min-w-0">
                                <h1
                                    class="text-base sm:text-lg font-bold tracking-tight truncate"
                                    style="color: var(--text-heading);"
                                >
                                    @yield('page-title', 'Dashboard')
                                </h1>

                                <p
                                    class="text-[10px] xs:text-[11px] sm:text-xs mt-0.5 flex items-center gap-1.5 min-w-0"
                                    style="color: var(--text-muted);"
                                >
                                    <svg
                                        class="w-3 h-3 flex-shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>

                                    <span class="truncate">
                                        @yield('page-subtitle', now()->format('l, d F Y'))
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Header Right -->
                        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                            <!-- Search -->
                            <button
                                type="button"
                                class="header-icon-button hidden md:flex"
                                aria-label="Search karein"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>
                            </button>

                            <!-- Notifications -->
                            <button
                                type="button"
                                class="header-icon-button hidden sm:flex relative"
                                aria-label="Notifications"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                    />
                                </svg>

                                <span class="notification-dot"></span>
                            </button>

                            <!-- Theme Toggle -->
                            <button
                                type="button"
                                id="themeToggle"
                                class="theme-toggle"
                                onclick="toggleTheme()"
                                aria-label="Switch theme"
                                aria-pressed="false"
                                title="Toggle theme"
                            >
                                <span class="theme-toggle-ball">
                                    <!-- Moon -->
                                    <svg
                                        class="w-3 h-3 text-white moon-icon"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        aria-hidden="true"
                                    >
                                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                                    </svg>

                                    <!-- Sun -->
                                    <svg
                                        class="w-3 h-3 text-white sun-icon hidden"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                        />
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="page-main px-4 py-5 sm:px-6 sm:py-6 lg:px-8 lg:py-8">
                <div class="page-container min-w-0">
                    <!-- Success Alert -->
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            <div
                                class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                                style="background: rgba(34, 197, 94, 0.15);"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm">
                                    Kamyab!
                                </p>

                                <p class="text-xs opacity-80 mt-0.5 break-words">
                                    {{ session('success') }}
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="dismissAlert(this.closest('.alert'))"
                                class="opacity-60 hover:opacity-100 transition-opacity flex-shrink-0"
                                aria-label="Message hatayein"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <!-- Error Alert -->
                    @if(session('error'))
                        <div class="alert alert-error" role="alert">
                            <div
                                class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
                                style="background: rgba(239, 68, 68, 0.15);"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                    />
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm">
                                    Ghalti!
                                </p>

                                <p class="text-xs opacity-80 mt-0.5 break-words">
                                    {{ session('error') }}
                                </p>
                            </div>

                            <button
                                type="button"
                                onclick="dismissAlert(this.closest('.alert'))"
                                class="opacity-60 hover:opacity-100 transition-opacity flex-shrink-0"
                                aria-label="Message hatayein"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer
                class="flex-shrink-0 px-4 py-5 sm:px-6 lg:px-8"
                style="border-top: 1px solid var(--border);"
            >
                <div class="page-container">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
                        <p
                            class="text-[11px]"
                            style="color: var(--text-muted);"
                        >
                            © {{ date('Y') }} SaaS POS — Super Admin Panel
                        </p>

                        <p
                            class="text-[11px]"
                            style="color: var(--text-muted);"
                        >
                            Platform v2.0
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        /* =========================================================
           ELEMENTS
        ========================================================= */
        const root = document.documentElement;
        const body = document.body;

        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const menuButton = document.getElementById('menuButton');
        const sidebarCloseButton = sidebar?.querySelector('.sidebar-close-button');

        const themeToggleButton = document.getElementById('themeToggle');

        const mobileMediaQuery = window.matchMedia('(max-width: 1023.98px)');

        /* =========================================================
           THEME
        ========================================================= */
        function updateThemeIcons(theme) {
            document.querySelectorAll('.moon-icon').forEach(icon => {
                icon.classList.toggle('hidden', theme === 'light');
            });

            document.querySelectorAll('.sun-icon').forEach(icon => {
                icon.classList.toggle('hidden', theme === 'dark');
            });

            if (themeToggleButton) {
                themeToggleButton.setAttribute(
                    'aria-pressed',
                    String(theme === 'light')
                );

                themeToggleButton.setAttribute(
                    'aria-label',
                    theme === 'dark'
                        ? 'Light theme par jayein'
                        : 'Dark theme par jayein'
                );
            }
        }

        function applyTheme(theme, saveTheme = true) {
            const selectedTheme = theme === 'light' ? 'light' : 'dark';

            body.classList.add('theme-transition');

            root.setAttribute('data-theme', selectedTheme);

            if (saveTheme) {
                try {
                    localStorage.setItem('admin-theme', selectedTheme);
                } catch (error) {
                    console.warn('Theme could not be saved.');
                }
            }

            updateThemeIcons(selectedTheme);

            window.setTimeout(() => {
                body.classList.remove('theme-transition');
            }, 450);
        }

        function toggleTheme() {
            const currentTheme = root.getAttribute('data-theme') || 'dark';
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';

            applyTheme(nextTheme);
        }

        updateThemeIcons(
            root.getAttribute('data-theme') || 'dark'
        );

        /* =========================================================
           MOBILE SIDEBAR
        ========================================================= */
        function isMobileView() {
            return mobileMediaQuery.matches;
        }

        function updateSidebarState(open) {
            const shouldOpen = isMobileView() && open;

            sidebar?.classList.toggle('is-open', shouldOpen);
            sidebarOverlay?.classList.toggle('active', shouldOpen);
            body.classList.toggle('sidebar-open', shouldOpen);

            menuButton?.setAttribute(
                'aria-expanded',
                String(shouldOpen)
            );

            sidebarOverlay?.setAttribute(
                'aria-hidden',
                String(!shouldOpen)
            );

            if (sidebar) {
                if (isMobileView()) {
                    sidebar.setAttribute(
                        'aria-hidden',
                        String(!shouldOpen)
                    );

                    if (shouldOpen) {
                        sidebar.removeAttribute('inert');
                    } else {
                        sidebar.setAttribute('inert', '');
                    }
                } else {
                    sidebar.setAttribute('aria-hidden', 'false');
                    sidebar.removeAttribute('inert');
                }
            }
        }

        function openSidebar() {
            if (!isMobileView()) {
                return;
            }

            updateSidebarState(true);

            window.requestAnimationFrame(() => {
                sidebarCloseButton?.focus({
                    preventScroll: true
                });
            });
        }

        function closeSidebar(returnFocus = true) {
            const wasOpen = sidebar?.classList.contains('is-open');

            if (
                returnFocus &&
                wasOpen &&
                sidebar?.contains(document.activeElement)
            ) {
                menuButton?.focus({
                    preventScroll: true
                });
            }

            updateSidebarState(false);
        }

        function toggleSidebar() {
            const sidebarIsOpen = sidebar?.classList.contains('is-open');

            if (sidebarIsOpen) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        /* Close sidebar with Escape */
        document.addEventListener('keydown', event => {
            if (
                event.key === 'Escape' &&
                sidebar?.classList.contains('is-open')
            ) {
                closeSidebar();
            }
        });

        /* Close mobile sidebar after clicking nav link */
        sidebar?.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (isMobileView()) {
                    closeSidebar(false);
                }
            });
        });

        /* Reset sidebar when screen changes */
        function handleViewportChange() {
            updateSidebarState(false);
        }

        if (typeof mobileMediaQuery.addEventListener === 'function') {
            mobileMediaQuery.addEventListener(
                'change',
                handleViewportChange
            );
        } else {
            mobileMediaQuery.addListener(handleViewportChange);
        }

        /* Set correct initial state */
        updateSidebarState(false);

        /* =========================================================
           ALERTS
        ========================================================= */
        function dismissAlert(alert) {
            if (!alert || !alert.isConnected) {
                return;
            }

            alert.style.transition =
                'opacity 0.4s ease, transform 0.4s ease, margin 0.4s ease';

            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';

            window.setTimeout(() => {
                alert.remove();
            }, 400);
        }

        document.querySelectorAll('.alert').forEach(alert => {
            window.setTimeout(() => {
                dismissAlert(alert);
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>