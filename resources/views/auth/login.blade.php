<!DOCTYPE html>
<html lang="en" id="html-theme">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SaaS POS</title>
    <script>
        try { if (localStorage.getItem('theme') === 'dark') document.documentElement.classList.add('dark'); } catch (e) {}
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: {
                colors: {
                    paper: { DEFAULT: '#FAF8F2', dim: '#F1EDE2' },
                    ink: { DEFAULT: '#161B22', soft: '#2A3240' },
                    till: { 50: '#EAF6F1', 100: '#CFEBE0', 400: '#159C74', 500: '#0E7A5C', 600: '#0B6049', 700: '#084A39' },
                    stamp: { DEFAULT: '#FF5A36', dim: '#FFE4DA' },
                },
                fontFamily: {
                    display: ['"Space Grotesk"', 'sans-serif'],
                    body: ['"Inter"', 'sans-serif'],
                    mono: ['"IBM Plex Mono"', 'monospace'],
                },
            } }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: .08s; opacity: 0; }
        .delay-2 { animation-delay: .16s; opacity: 0; }
        .delay-3 { animation-delay: .24s; opacity: 0; }

        .input-field { transition: all 0.2s ease; }
        .input-field:focus { box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.16); }

        @keyframes spin-slow { to { transform: rotate(360deg); } }
        .spinner { width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.35); border-top-color: white; border-radius: 50%; animation: spin-slow 0.6s linear infinite; display: none; }
        .btn-login.loading .spinner { display: block; }
        .btn-login.loading .btn-text { display: none; }

        .custom-checkbox {
            width: 18px; height: 18px; border-radius: 6px; cursor: pointer;
            appearance: none; -webkit-appearance: none; position: relative;
        }
        .custom-checkbox:checked { background: #0E7A5C; border-color: #0E7A5C; }
        .custom-checkbox:checked::after {
            content: ''; position: absolute; top: 2px; left: 5px; width: 5px; height: 9px;
            border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg);
        }

        .barcode { background-image: repeating-linear-gradient(90deg, currentColor 0 2px, transparent 2px 5px, currentColor 5px 6px, transparent 6px 11px); }
    </style>
</head>
<body class="bg-paper dark:bg-ink text-ink dark:text-paper flex items-center justify-center min-h-screen p-4 transition-colors duration-300">

    <div class="w-full max-w-md relative z-10">

        <div class="flex justify-between items-center mb-8 animate-fade-in">
            <a href="/" class="inline-flex items-center gap-2.5">
                <span class="w-10 h-10 rounded-lg bg-till-500 text-white grid place-items-center font-mono text-sm font-semibold">P</span>
                <span class="font-display font-700 text-xl tracking-tight">SaaS<span class="text-till-500">POS</span></span>
            </a>

            <button onclick="toggleTheme()" aria-label="Toggle theme" class="w-10 h-10 grid place-items-center rounded-full border border-ink/15 dark:border-paper/15 bg-white dark:bg-paper/5 hover:scale-105 active:scale-95 transition-all">
                <svg id="sun-icon" class="w-4 h-4 text-amber-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <svg id="moon-icon" class="w-4 h-4 text-till-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>
        </div>

        <div class="bg-white dark:bg-paper/[0.04] border border-ink/10 dark:border-paper/10 shadow-xl shadow-ink/5 p-8 rounded-2xl animate-fade-in delay-1">

            <div class="text-center mb-8">
                <div class="font-mono text-xs uppercase tracking-widest text-till-500 mb-2">Welcome back</div>
                <h2 class="font-display font-700 text-2xl tracking-tight">Sign in to your counter</h2>
                <p class="text-sm mt-2 text-ink/55 dark:text-paper/55">Pick up right where you left off</p>
            </div>

            @if ($errors->any())
                <div class="p-4 rounded-xl text-sm mb-6 flex items-start gap-3 bg-red-500/10 border border-red-500/25 text-red-600 dark:text-red-400">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <p class="font-semibold text-[13px]">Login failed</p>
                        <p class="text-xs mt-0.5 opacity-80">{{ $errors->first() }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="ml-auto opacity-50 hover:opacity-100 transition-opacity flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5" id="loginForm">
                @csrf

                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-mono font-semibold uppercase tracking-wider text-ink/50 dark:text-paper/50">
                        <svg class="w-3.5 h-3.5 text-till-500/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email Address
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-ink/35 dark:text-paper/35">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="input-field w-full pl-12 pr-4 py-3.5 rounded-xl text-sm font-medium outline-none bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 focus:border-till-500 placeholder:text-ink/35 dark:placeholder:text-paper/30"
                               placeholder="owner@business.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-mono font-semibold uppercase tracking-wider text-ink/50 dark:text-paper/50">
                        <svg class="w-3.5 h-3.5 text-till-500/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Password
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-ink/35 dark:text-paper/35">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" id="passwordInput" required
                               class="input-field w-full pl-12 pr-12 py-3.5 rounded-xl text-sm font-medium outline-none bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 focus:border-till-500 placeholder:text-ink/35 dark:placeholder:text-paper/30"
                               placeholder="Enter your password">
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-4 text-ink/35 dark:text-paper/35 hover:text-till-500 transition-colors" onclick="togglePassword()">
                            <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-3 text-sm cursor-pointer select-none text-ink/60 dark:text-paper/60">
                        <input type="checkbox" name="remember" id="remember" class="custom-checkbox border-2 border-ink/20 dark:border-paper/20">
                        Keep me signed in
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-till-500 hover:text-till-600 font-medium">Forgot password?</a>
                </div>

                <button type="submit" id="loginBtn"
                        class="btn-login w-full bg-till-500 hover:bg-till-600 text-white font-bold py-4 rounded-xl text-sm flex items-center justify-center gap-2 cursor-pointer transition-all duration-300 shadow-lg shadow-till-500/20 hover:-translate-y-0.5">
                    <span class="btn-text flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Sign In to Dashboard
                    </span>
                    <div class="spinner"></div>
                </button>
            </form>
        </div>

        <div class="text-center mt-8 space-y-3 animate-fade-in delay-2">
            <p class="text-sm text-ink/60 dark:text-paper/60">
                New to SaaS POS?
                <a href="{{ route('business.register') }}" class="font-semibold text-till-500 hover:text-till-600 transition-colors">Create your free account →</a>
            </p>
            <p class="text-xs text-ink/35 dark:text-paper/35">&copy; {{ date('Y') }} SaaS POS. All rights reserved.</p>
        </div>

        <div class="flex items-center justify-center gap-6 mt-6 animate-fade-in delay-3 text-ink/40 dark:text-paper/40">
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-till-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-[10px] font-mono font-semibold">SSL Secured</span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-till-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span class="text-[10px] font-mono font-semibold">256-bit Encrypted</span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-stamp" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span class="text-[10px] font-mono font-semibold">99.9% Uptime</span>
            </div>
        </div>
    </div>

    <script>
        function updateIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById('sun-icon').classList.toggle('hidden', isDark);
            document.getElementById('moon-icon').classList.toggle('hidden', !isDark);
        }
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            try { localStorage.setItem('theme', isDark ? 'dark' : 'light'); } catch (e) {}
            updateIcons();
        }
        updateIcons();

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

        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>
</body>
</html>