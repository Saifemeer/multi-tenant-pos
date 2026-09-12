<!DOCTYPE html>
<html lang="en" id="html-theme">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | SaaS POS</title>
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
        .animate-fadeInUp { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .input-modern { transition: all 0.2s ease; }
        .input-modern:focus { box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.16); }
    </style>
</head>
<body class="bg-paper dark:bg-ink text-ink dark:text-paper min-h-screen flex items-center justify-center p-4 transition-colors duration-300">

    <button onclick="toggleTheme()" aria-label="Toggle theme" class="fixed top-6 right-6 w-10 h-10 grid place-items-center rounded-full border border-ink/15 dark:border-paper/15 bg-white dark:bg-paper/5 hover:scale-105 active:scale-95 transition-all">
        <svg id="sun-icon" class="w-4 h-4 text-amber-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <svg id="moon-icon" class="w-4 h-4 text-till-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
    </button>

    <div class="w-full max-w-md animate-fadeInUp">
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-till-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-till-500/25">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div class="font-mono text-xs uppercase tracking-widest text-till-500 mb-2">Account recovery</div>
            <h1 class="font-display font-700 text-2xl tracking-tight">Forgot your password?</h1>
            <p class="text-sm mt-2 text-ink/55 dark:text-paper/55">No worries — enter your email and we'll send you a reset link.</p>
        </div>

        <div class="bg-white dark:bg-paper/[0.04] border border-ink/10 dark:border-paper/10 shadow-xl shadow-ink/5 rounded-2xl p-8">
            @if(session('success'))
                <div class="bg-till-50 dark:bg-till-700/15 border border-till-500/25 text-till-600 dark:text-till-400 p-3 rounded-xl text-sm mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/25 text-red-600 dark:text-red-400 p-3 rounded-xl text-sm mb-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-mono font-semibold text-ink/50 dark:text-paper/50 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="input-modern w-full px-4 py-3 rounded-xl text-sm bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 focus:border-till-500 outline-none placeholder:text-ink/35 dark:placeholder:text-paper/30"
                           placeholder="you@example.com">
                </div>
                <button type="submit"
                        class="w-full bg-till-500 hover:bg-till-600 text-white font-semibold py-3.5 rounded-xl text-sm shadow-lg shadow-till-500/20 hover:-translate-y-0.5 active:scale-[0.99] transition-all duration-300 cursor-pointer">
                    Send Reset Link
                </button>
            </form>
        </div>

        <p class="text-center text-sm mt-6 text-ink/55 dark:text-paper/55">
            <a href="{{ route('login') }}" class="text-till-500 hover:text-till-600 font-semibold">← Back to Login</a>
        </p>
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
    </script>
</body>
</html>