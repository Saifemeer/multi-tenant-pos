<!DOCTYPE html>
<html lang="en" id="html-theme" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Business | SaaS POS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * { font-family: 'Inter', sans-serif; }

        /* Dynamic Theme Palette Engine */
        :root {
            --bg-app: #f8fafc;
            --bg-card: rgba(255, 255, 255, 0.75);
            --border-color: rgba(226, 232, 240, 0.8);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --input-icon: #94a3b8;
            --category-card-bg: #ffffff;
            --category-card-hover: #f1f5f9;
            --shadow-glass: 0 8px 32px 0 rgba(31, 38, 135, 0.04);
        }

        .dark {
            --bg-app: #030712;
            --bg-card: rgba(17, 24, 39, 0.7);
            --border-color: rgba(31, 41, 55, 0.65);
            --text-main: #f9fafb;
            --text-muted: #9ca3af;
            --input-bg: #0b0f19;
            --input-border: #1f2937;
            --input-icon: #4b5563;
            --category-card-bg: #0b0f19;
            --category-card-hover: #111827;
            --shadow-glass: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        body {
            background-color: var(--bg-app);
            color: var(--text-main);
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Fluid Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-fadeInUp { animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-float { animation: float 4s ease-in-out infinite; }
        
        .gradient-mesh {
            background: linear-gradient(-45deg, #3b82f6, #4f46e5, #8b5cf6, #ec4899);
            background-size: 400% 400%;
            animation: gradient-shift 12s ease infinite;
        }

        /* Glassmorphic Components */
        .glass-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-glass);
            transition: background 0.4s, border-color 0.4s, box-shadow 0.4s;
        }

        /* Form Control Engine */
        .input-modern {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-main);
            padding: 12px 16px 12px 44px;
            border-radius: 14px;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }
        .input-modern:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            transform: translateY(-1px);
        }
        .input-modern::placeholder { color: var(--text-muted); opacity: 0.7; }
        
        select.input-modern {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }
        
        .category-card {
            padding: 14px 12px;
            border: 1px solid var(--input-border);
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            background: var(--category-card-bg);
        }
        .category-card:hover {
            background: var(--category-card-hover);
            border-color: var(--text-muted);
            transform: translateY(-3px);
        }
        .category-card.selected {
            border-color: #3b82f6;
            border-width: 2px;
            background: rgba(59, 130, 246, 0.08);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4 relative overflow-x-hidden">

    <!-- Theme Configuration Float Toggle -->
    <button onclick="toggleTheme()" class="absolute top-6 right-6 p-3 rounded-full glass-card hover:scale-110 active:scale-95 cursor-pointer transition-all duration-300 z-50">
        <svg id="sun-icon" class="w-5 h-5 text-amber-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <svg id="moon-icon" class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
    </button>

    <div class="w-full max-w-xl animate-fadeInUp z-10 my-6">

        <!-- Branded Hero Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3.5 group">
                <div class="w-14 h-14 gradient-mesh rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20 animate-float">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-3.5xl font-black tracking-tight bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 bg-clip-text text-transparent">SaaS POS</span>
            </div>
        </div>

        <!-- Structural Content Container -->
        <div class="glass-card p-8 rounded-[32px]">
            
            <div class="text-center mb-8">
                <h2 class="text-2.5xl font-extrabold tracking-tight" style="color: var(--text-main);">Register Your Business</h2>
                <p class="text-sm mt-2" style="color: var(--text-muted);">Set up your secure store dashboard in under a minute</p>
            </div>

            <!-- Validation Framework Stack -->
            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-sm mb-6 backdrop-blur-md">
                    <ul class="space-y-1.5">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span class="font-medium text-red-500/90 dark:text-red-400">{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('business.register.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Input Component: Business Name -->
                <div>
                    <label class="block text-xs font-bold tracking-wider uppercase mb-2" style="color: var(--text-muted);">Business Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5" style="color: var(--input-icon);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" required
                               class="input-modern"
                               placeholder="e.g. Elite Fashion Store">
                    </div>
                </div>

                <!-- Input Component: Business Category Grid -->
                <div>
                    <label class="block text-xs font-bold tracking-wider uppercase mb-3" style="color: var(--text-muted);">Business Category</label>
                    
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
                        <div class="category-card {{ old('business_category') == $type['value'] ? 'selected' : '' }}"
                             onclick="selectCategory('{{ $type['value'] }}', this)">
                            <svg class="w-6 h-6 mx-auto mb-2" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"/>
                            </svg>
                            <p class="text-xs font-semibold" style="color: var(--text-main);">{{ $type['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                    
                    @error('business_category')
                        <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Component: Owner Name -->
                <div>
                    <label class="block text-xs font-bold tracking-wider uppercase mb-2" style="color: var(--text-muted);">Owner Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5" style="color: var(--input-icon);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="input-modern"
                               placeholder="e.g. Ahmed Khan">
                    </div>
                </div>

                <!-- Input Component: Email Address -->
                <div>
                    <label class="block text-xs font-bold tracking-wider uppercase mb-2" style="color: var(--text-muted);">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5" style="color: var(--input-icon);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="input-modern"
                               placeholder="owner@business.com">
                    </div>
                </div>

                <!-- Input Component: Password -->
                <div>
                    <label class="block text-xs font-bold tracking-wider uppercase mb-2" style="color: var(--text-muted);">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5" style="color: var(--input-icon);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" name="password" required
                               class="input-modern"
                               placeholder="Minimum 8 characters">
                    </div>
                </div>

                <!-- Input Component: Confirm Password -->
                <div>
                    <label class="block text-xs font-bold tracking-wider uppercase mb-2" style="color: var(--text-muted);">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <svg class="w-5 h-5" style="color: var(--input-icon);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <input type="password" name="password_confirmation" required
                               class="input-modern"
                               placeholder="Re-enter your password">
                    </div>
                </div>

                <!-- Action Execution Engine -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3.5 rounded-xl
                               shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 hover:scale-[1.015] active:scale-[0.99]
                               transition-all duration-300 text-sm flex items-center justify-center gap-2 cursor-pointer mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Get Started Instantly
                </button>
            </form>
        </div>

        <!-- System Routing Footer Link Architecture -->
        <p class="text-center text-sm mt-6" style="color: var(--text-muted);">
            Already managing an enterprise? 
            <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-400 font-bold transition-colors ml-1">
                Sign in to workspace
            </a>
        </p>

        <p class="text-center text-xs mt-4 opacity-60" style="color: var(--text-muted);">
            &copy; {{ date('Y') }} SaaS POS. Encrypted enterprise interface layer.
        </p>
    </div>

    <script>
        // System Category Selection Handler
        function selectCategory(value, element) {
            document.getElementById('business_category').value = value;
            document.querySelectorAll('.category-card').forEach(card => {
                card.classList.remove('selected');
            });
            element.classList.add('selected');
        }

        // Realtime Universal Theme Synchronizer Engine
        function toggleTheme() {
            const html = document.getElementById('html-theme');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Init System Theme Presets On Dom Mounted
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            const html = document.getElementById('html-theme');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');

            if (savedTheme === 'light') {
                html.classList.remove('dark');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                html.classList.add('dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>