<!DOCTYPE html>
<html lang="en" id="html-theme">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Business | SaaS POS</title>
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

        .input-modern {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }
        .input-modern:focus { box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.18); }

        select.input-modern {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        .category-card {
            padding: 14px 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        .category-card:hover { transform: translateY(-2px); }
        .category-card.selected {
            border-color: #0E7A5C !important;
            border-width: 2px !important;
            box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.15);
        }

        .barcode { background-image: repeating-linear-gradient(90deg, currentColor 0 2px, transparent 2px 5px, currentColor 5px 6px, transparent 6px 11px); }
    </style>
</head>
<body class="bg-paper dark:bg-ink text-ink dark:text-paper flex flex-col items-center justify-center min-h-screen p-4 transition-colors duration-300">

    <button onclick="toggleTheme()" aria-label="Toggle theme" class="fixed top-6 right-6 w-11 h-11 grid place-items-center rounded-full border border-ink/15 dark:border-paper/15 bg-white dark:bg-paper/5 hover:scale-105 active:scale-95 transition-all z-50">
        <svg id="sun-icon" class="w-5 h-5 text-amber-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <svg id="moon-icon" class="w-5 h-5 text-till-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
    </button>

    <div class="w-full max-w-xl animate-fadeInUp z-10 my-8">

        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2.5">
                <span class="w-11 h-11 rounded-xl bg-till-500 text-white grid place-items-center font-mono text-base font-semibold">P</span>
                <span class="font-display font-700 text-2xl tracking-tight">SaaS<span class="text-till-500">POS</span></span>
            </a>
        </div>

        <div class="bg-white dark:bg-paper/[0.04] border border-ink/10 dark:border-paper/10 shadow-xl shadow-ink/5 p-8 rounded-2xl">

            <div class="text-center mb-8">
                <div class="font-mono text-xs uppercase tracking-widest text-till-500 mb-2">New account</div>
                <h2 class="font-display font-700 text-2xl tracking-tight">Register your business</h2>
                <p class="text-sm mt-2 text-ink/55 dark:text-paper/55">Set up your store dashboard in under a minute</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/25 text-red-600 dark:text-red-400 p-4 rounded-xl text-sm mb-6">
                    <ul class="space-y-1.5">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                <span class="font-medium">{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('business.register.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Business Name -->
                <div>
                    <label class="block text-xs font-mono font-semibold tracking-wider uppercase mb-2 text-ink/50 dark:text-paper/50">Business Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-ink/35 dark:text-paper/35">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" required
                               class="input-modern bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 text-ink dark:text-paper placeholder:text-ink/35 dark:placeholder:text-paper/30 focus:border-till-500"
                               placeholder="e.g. Elite Fashion Store">
                    </div>
                </div>

                <!-- Business Category -->
                <div>
                    <label class="block text-xs font-mono font-semibold tracking-wider uppercase mb-3 text-ink/50 dark:text-paper/50">Business Category</label>
                    <input type="hidden" name="business_category" id="business_category" value="{{ old('business_category') }}" required>

                    <div class="grid grid-cols-3 gap-3" id="categoryGrid">
                        @php
                            $businessTypes = [
                                ['value' => 'restaurant', 'label' => 'Restaurant', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                                ['value' => 'retail_store', 'label' => 'Retail Store', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                                ['value' => 'grocery', 'label' => 'Grocery', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                                ['value' => 'pharmacy', 'label' => 'Pharmacy', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                                ['value' => 'salon', 'label' => 'Salon', 'icon' => 'M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z'],
                                ['value' => 'gym', 'label' => 'Gym', 'icon' => 'M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4'],
                            ];
                        @endphp

                        @foreach($businessTypes as $type)
                        <div class="category-card border border-ink/15 dark:border-paper/15 bg-paper dark:bg-ink {{ old('business_category') == $type['value'] ? 'selected' : '' }}"
                             onclick="selectCategory('{{ $type['value'] }}', this)">
                            <svg class="w-6 h-6 mx-auto mb-2 text-ink/45 dark:text-paper/45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"/>
                            </svg>
                            <p class="text-xs font-semibold">{{ $type['label'] }}</p>
                        </div>
                        @endforeach
                    </div>

                    @error('business_category')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subscription Plan -->
                <div>
                    <label class="block text-xs font-mono font-semibold tracking-wider uppercase mb-3 text-ink/50 dark:text-paper/50">Choose Your Plan</label>
                    <input type="hidden" name="subscription_plan" id="subscription_plan" value="{{ old('subscription_plan', request('plan', 'starter')) }}" required>

                    <div class="grid grid-cols-3 gap-3" id="planGrid">
                        <div class="category-card border border-ink/15 dark:border-paper/15 bg-paper dark:bg-ink {{ old('subscription_plan', request('plan', 'starter')) == 'starter' ? 'selected' : '' }}"
                             onclick="selectPlan('starter', this)">
                            <p class="text-xs font-mono font-bold">Starter</p>
                            <p class="text-lg font-display font-700 mt-1">Free</p>
                            <p class="text-[10px] mt-1 text-ink/45 dark:text-paper/45">Up to 50 products</p>
                        </div>

                        <div class="category-card border border-ink/15 dark:border-paper/15 bg-paper dark:bg-ink {{ old('subscription_plan', request('plan')) == 'business' ? 'selected' : '' }}"
                             onclick="selectPlan('business', this)">
                            <p class="text-xs font-mono font-bold">Business</p>
                            <p class="text-lg font-display font-700 mt-1">$29<span class="text-[10px] font-normal font-body">/mo</span></p>
                            <p class="text-[10px] mt-1 text-ink/45 dark:text-paper/45">Unlimited + reports</p>
                        </div>

                        <div class="category-card border border-ink/15 dark:border-paper/15 bg-paper dark:bg-ink {{ old('subscription_plan', request('plan')) == 'enterprise' ? 'selected' : '' }}"
                             onclick="selectPlan('enterprise', this)">
                            <p class="text-xs font-mono font-bold">Enterprise</p>
                            <p class="text-lg font-display font-700 mt-1">$99<span class="text-[10px] font-normal font-body">/mo</span></p>
                            <p class="text-[10px] mt-1 text-ink/45 dark:text-paper/45">Multi-store</p>
                        </div>
                    </div>

                    @error('subscription_plan')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Name -->
                <div>
                    <label class="block text-xs font-mono font-semibold tracking-wider uppercase mb-2 text-ink/50 dark:text-paper/50">Owner Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-ink/35 dark:text-paper/35">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="input-modern bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 text-ink dark:text-paper placeholder:text-ink/35 dark:placeholder:text-paper/30 focus:border-till-500"
                               placeholder="e.g. Ahmed Khan">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-mono font-semibold tracking-wider uppercase mb-2 text-ink/50 dark:text-paper/50">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-ink/35 dark:text-paper/35">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="input-modern bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 text-ink dark:text-paper placeholder:text-ink/35 dark:placeholder:text-paper/30 focus:border-till-500"
                               placeholder="owner@business.com">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-mono font-semibold tracking-wider uppercase mb-2 text-ink/50 dark:text-paper/50">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-ink/35 dark:text-paper/35">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" name="password" required
                               class="input-modern bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 text-ink dark:text-paper placeholder:text-ink/35 dark:placeholder:text-paper/30 focus:border-till-500"
                               placeholder="Minimum 8 characters">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-xs font-mono font-semibold tracking-wider uppercase mb-2 text-ink/50 dark:text-paper/50">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-ink/35 dark:text-paper/35">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <input type="password" name="password_confirmation" required
                               class="input-modern bg-paper dark:bg-ink border border-ink/15 dark:border-paper/15 text-ink dark:text-paper placeholder:text-ink/35 dark:placeholder:text-paper/30 focus:border-till-500"
                               placeholder="Re-enter your password">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-till-500 hover:bg-till-600 text-white font-semibold py-3.5 rounded-xl
                               shadow-lg shadow-till-500/20 hover:-translate-y-0.5 active:scale-[0.99]
                               transition-all duration-300 text-sm flex items-center justify-center gap-2 cursor-pointer mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Get Started Instantly
                </button>
            </form>
        </div>

        <p class="text-center text-sm mt-6 text-ink/55 dark:text-paper/55">
            Already managing a store?
            <a href="{{ route('login') }}" class="text-till-500 hover:text-till-600 font-semibold transition-colors ml-1">Sign in to workspace</a>
        </p>

        <p class="text-center text-xs mt-4 text-ink/35 dark:text-paper/35">&copy; {{ date('Y') }} SaaS POS. All rights reserved.</p>
    </div>

    <script>
        function selectCategory(value, element) {
            document.getElementById('business_category').value = value;
            document.querySelectorAll('#categoryGrid .category-card').forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
        }
        function selectPlan(value, element) {
            document.getElementById('subscription_plan').value = value;
            document.querySelectorAll('#planGrid .category-card').forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
        }

        function updateIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById('sun-icon').classList.toggle('hidden', !isDark ? true : false);
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