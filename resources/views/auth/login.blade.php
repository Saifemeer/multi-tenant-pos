<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SaaS POS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* ===== THEME VARIABLES ===== */
        [data-theme="dark"] {
            --bg-body: #06070A;
            --bg-card: rgba(17,19,24,0.8);
            --bg-input: #111827;
            --bg-input-focus: #16181F;
            --border-card: rgba(255,255,255,0.06);
            --border-input: rgba(255,255,255,0.1);
            --border-focus: #6366f1;
            --text-heading: #ffffff;
            --text-body: #94a3b8;
            --text-muted: #475569;
            --text-label: #9ca3af;
            --text-placeholder: #4b5563;
            --icon-color: #6b7280;
            --link-color: #818cf8;
            --link-hover: #a5b4fc;
            --error-bg: rgba(239,68,68,0.08);
            --error-border: rgba(239,68,68,0.2);
            --error-text: #f87171;
            --divider-text: #4b5563;
            --divider-line: rgba(255,255,255,0.06);
            --social-bg: rgba(255,255,255,0.03);
            --social-border: rgba(255,255,255,0.08);
            --social-hover: rgba(255,255,255,0.06);
            --glow-1: rgba(99,102,241,0.08);
            --glow-2: rgba(139,92,246,0.06);
            --checkbox-border: rgba(255,255,255,0.15);
        }
        [data-theme="light"] {
            --bg-body: #f1f5f9;
            --bg-card: rgba(255,255,255,0.9);
            --bg-input: #f8fafc;
            --bg-input-focus: #ffffff;
            --border-card: rgba(0,0,0,0.08);
            --border-input: rgba(0,0,0,0.12);
            --border-focus: #6366f1;
            --text-heading: #0f172a;
            --text-body: #64748b;
            --text-muted: #94a3b8;
            --text-label: #475569;
            --text-placeholder: #94a3b8;
            --icon-color: #9ca3af;
            --link-color: #6366f1;
            --link-hover: #4f46e5;
            --error-bg: rgba(239,68,68,0.06);
            --error-border: rgba(239,68,68,0.15);
            --error-text: #ef4444;
            --divider-text: #94a3b8;
            --divider-line: rgba(0,0,0,0.08);
            --social-bg: rgba(0,0,0,0.02);
            --social-border: rgba(0,0,0,0.08);
            --social-hover: rgba(0,0,0,0.05);
            --checkbox-border: rgba(0,0,0,0.2);
            --glow-1: rgba(99,102,241,0.06);
            --glow-2: rgba(139,92,246,0.04);
        }

        body {
            background: var(--bg-body);
            transition: background 0.4s ease;
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(2deg); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(15px) rotate(-2deg); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        @keyframes pulse-soft {
            0%, 100% { box-shadow: 0 0 20px rgba(99,102,241,0.15); }
            50% { box-shadow: 0 0 40px rgba(99,102,241,0.25); }
        }
        @keyframes spin-slow {
            to { transform: rotate(360deg); }
        }
        @keyframes check-bounce {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .animate-fade-in { animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }

        /* ===== BACKGROUND EFFECTS ===== */
        .bg-effects {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }
        .bg-effects::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            top: -15%; left: -10%;
            background: radial-gradient(circle, var(--glow-1) 0%, transparent 70%);
            animation: float 10s ease-in-out infinite;
        }
        .bg-effects::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            bottom: -15%; right: -10%;
            background: radial-gradient(circle, var(--glow-2) 0%, transparent 70%);
            animation: float-reverse 10s ease-in-out infinite;
        }

        /* ===== CARD ===== */
        .login-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border-card);
            transition: all 0.4s ease;
        }

        /* ===== INPUT ===== */
        .input-field {
            background: var(--bg-input);
            border: 1px solid var(--border-input);
            color: var(--text-heading);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .input-field:focus {
            background: var(--bg-input-focus);
            border-color: var(--border-focus);
            box-shadow: 0 0 0 4px rgba(99,102,241,0.12);
        }
        .input-field::placeholder {
            color: var(--text-placeholder);
        }

        /* ===== BUTTON ===== */
        .btn-login {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #6366f1);
            background-size: 200% 100%;
            animation: gradient-shift 3s ease infinite;
            box-shadow: 0 8px 25px rgba(99,102,241,0.3), inset 0 1px 0 rgba(255,255,255,0.15);
            position: relative;
            overflow: hidden;
        }
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 12px 35px rgba(99,102,241,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .btn-login:hover::before { left: 100%; }
        .btn-login:active { transform: translateY(0) scale(0.99); }

        /* ===== SOCIAL BUTTONS ===== */
        .social-btn {
            background: var(--social-bg);
            border: 1px solid var(--social-border);
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            background: var(--social-hover);
            border-color: var(--border-focus);
            transform: translateY(-2px);
        }

        /* ===== CHECKBOX ===== */
        .custom-checkbox {
            width: 18px; height: 18px;
            border: 2px solid var(--checkbox-border);
            border-radius: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            position: relative;
            background: transparent;
        }
        .custom-checkbox:checked {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-color: #6366f1;
        }
        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 2px; left: 5px;
            width: 5px; height: 9px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            animation: check-bounce 0.3s ease;
        }
        .custom-checkbox:focus {
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }

        /* ===== THEME TOGGLE ===== */
        .theme-toggle {
            width: 48px; height: 26px;
            border-radius: 100px;
            background: var(--social-bg);
            border: 1px solid var(--social-border);
            position: relative;
            cursor: pointer;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            padding: 0 3px;
        }
        .theme-toggle-ball {
            width: 20px; height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(99,102,241,0.3);
        }
        [data-theme="light"] .theme-toggle-ball {
            transform: translateX(22px);
            background: linear-gradient(135deg, #f59e0b, #f97316);
            box-shadow: 0 2px 6px rgba(245,158,11,0.3);
        }

        /* ===== PASSWORD TOGGLE ===== */
        .password-toggle {
            color: var(--icon-color);
            cursor: pointer;
            transition: color 0.2s ease;
            padding: 4px;
            border-radius: 8px;
        }
        .password-toggle:hover {
            color: var(--link-color);
        }

        /* ===== DIVIDER ===== */
        .divider-line {
            height: 1px;
            background: var(--divider-line);
            flex: 1;
        }

        /* ===== LOADING SPINNER ===== */
        .spinner {
            width: 20px; height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin-slow 0.6s linear infinite;
            display: none;
        }
        .btn-login.loading .spinner { display: block; }
        .btn-login.loading .btn-text { display: none; }

        /* ===== TRANSITIONS ===== */
        .theme-transition * {
            transition: background 0.4s ease, color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease !important;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <!-- Background Effects -->
    <div class="bg-effects"></div>

    <!-- Main Container -->
    <div class="w-full max-w-md relative z-10">

        <!-- Theme Toggle (Top Right) -->
        <div class="flex justify-end mb-6 animate-fade-in">
            <div class="theme-toggle" onclick="toggleTheme()" title="Toggle theme">
                <div class="theme-toggle-ball">
                    <svg class="w-3 h-3 text-white moon-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                    <svg class="w-3 h-3 text-white sun-icon hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Logo -->
        <div class="text-center mb-8 animate-fade-in delay-1">
            <div class="inline-flex items-center gap-3">
                <div class="relative">
                    <div class="w-13 h-13 bg-gradient-to-br from-indigo-500 via-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25 rotate-3 hover:rotate-0 transition-transform duration-500" style="animation: pulse-soft 3s ease-in-out infinite;">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-emerald-400 rounded-full border-2 flex items-center justify-center" style="border-color: var(--bg-body);">
                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-black tracking-tight" style="color: var(--text-heading);">SaaS<span class="text-indigo-500">POS</span></span>
                    <p class="text-[10px] font-medium tracking-wider uppercase" style="color: var(--text-muted);">Business Platform</p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="login-card p-8 rounded-3xl shadow-2xl animate-fade-in delay-2">

            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black" style="color: var(--text-heading);">Welcome Back 👋</h2>
                <p class="text-sm mt-2" style="color: var(--text-body);">Sign in to continue to your dashboard</p>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="p-4 rounded-2xl text-sm mb-6 flex items-start gap-3 animate-fade-in" style="background: var(--error-bg); border: 1px solid var(--error-border); color: var(--error-text);">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5" style="background: var(--error-border);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-[13px]">Login Failed</p>
                        <p class="text-xs mt-0.5 opacity-80">{{ $errors->first() }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="ml-auto opacity-50 hover:opacity-100 transition-opacity flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-3 mb-6">
                <button type="button" class="social-btn flex items-center justify-center gap-2.5 py-3 rounded-xl text-sm font-semibold" style="color: var(--text-body);">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </button>
                <button type="button" class="social-btn flex items-center justify-center gap-2.5 py-3 rounded-xl text-sm font-semibold" style="color: var(--text-body);">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    GitHub
                </button>
            </div>

            <!-- Divider -->
            <div class="flex items-center gap-4 mb-6">
                <div class="divider-line"></div>
                <span class="text-xs font-semibold uppercase tracking-wider" style="color: var(--divider-text);">or continue with email</span>
                <div class="divider-line"></div>
            </div>

            <!-- Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider" style="color: var(--text-label);">
                        <svg class="w-3.5 h-3.5 text-indigo-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none transition-colors" style="color: var(--icon-color);">
                            <svg class="w-5 h-5 group-focus-within:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="input-field w-full pl-12 pr-4 py-3.5 rounded-xl text-sm font-medium outline-none"
                               placeholder="owner@business.com">
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider" style="color: var(--text-label);">
                            <svg class="w-3.5 h-3.5 text-indigo-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Password
                        </label>
                        <a href="#" class="text-[11px] font-semibold transition-colors" style="color: var(--link-color);" onmouseover="this.style.color='var(--link-hover)'" onmouseout="this.style.color='var(--link-color)'">
                            Forgot password?
                        </a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none" style="color: var(--icon-color);">
                            <svg class="w-5 h-5 group-focus-within:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" name="password" id="passwordInput" required
                               class="input-field w-full pl-12 pr-12 py-3.5 rounded-xl text-sm font-medium outline-none"
                               placeholder="Enter your password">
                        <button type="button" class="password-toggle absolute inset-y-0 right-0 flex items-center pr-4" onclick="togglePassword()">
                            <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="remember" id="remember" class="custom-checkbox">
                    <label for="remember" class="text-sm cursor-pointer select-none" style="color: var(--text-body);">
                        Keep me signed in
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="loginBtn"
                        class="btn-login w-full text-white font-bold py-4 rounded-xl text-sm flex items-center justify-center gap-2 cursor-pointer transition-all duration-300">
                    <span class="btn-text flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Sign In to Dashboard
                    </span>
                    <div class="spinner"></div>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 space-y-3 animate-fade-in delay-3">
            <p class="text-sm" style="color: var(--text-body);">
                New to SaaS POS?
                <a href="{{ route('business.register') }}" class="font-bold transition-colors" style="color: var(--link-color);" onmouseover="this.style.color='var(--link-hover)'" onmouseout="this.style.color='var(--link-color)'">
                    Create your free account →
                </a>
            </p>
            <p class="text-xs" style="color: var(--text-muted);">
                &copy; {{ date('Y') }} SaaS POS. All rights reserved.
            </p>
        </div>

        <!-- Trust Badges -->
        <div class="flex items-center justify-center gap-6 mt-6 animate-fade-in delay-4">
            <div class="flex items-center gap-1.5" style="color: var(--text-muted);">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-[10px] font-semibold">SSL Secured</span>
            </div>
            <div class="flex items-center gap-1.5" style="color: var(--text-muted);">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span class="text-[10px] font-semibold">256-bit Encrypted</span>
            </div>
            <div class="flex items-center gap-1.5" style="color: var(--text-muted);">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span class="text-[10px] font-semibold">99.9% Uptime</span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // ===== THEME TOGGLE =====
        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';

            document.body.classList.add('theme-transition');
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateIcons(next);
            setTimeout(() => document.body.classList.remove('theme-transition'), 500);
        }

        function updateIcons(theme) {
            document.querySelectorAll('.moon-icon').forEach(i => i.classList.toggle('hidden', theme === 'light'));
            document.querySelectorAll('.sun-icon').forEach(i => i.classList.toggle('hidden', theme === 'dark'));
        }

        // Load saved theme
        const saved = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', saved);
        updateIcons(saved);

        // ===== PASSWORD TOGGLE =====
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        // ===== LOADING STATE =====
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>