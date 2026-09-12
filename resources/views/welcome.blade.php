<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS POS — Apni Dukaan Smart Tareeqe Se Chalayein</title>

    <script>
        try {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        } catch (error) {}
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
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
                    boxShadow: {
                        receipt: '0 30px 60px -20px rgba(22, 27, 34, 0.35)',
                    },
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }

        /* Receipt torn-edge */
        .torn-bottom {
            -webkit-mask-image: linear-gradient(#000, #000), radial-gradient(circle at 8px 0, transparent 8px, #000 8.5px);
            -webkit-mask-size: 100% calc(100% - 8px), 16px 8px;
            -webkit-mask-position: top left, bottom left;
            -webkit-mask-repeat: no-repeat, repeat-x;
            mask-image: linear-gradient(#000, #000), radial-gradient(circle at 8px 0, transparent 8px, #000 8.5px);
            mask-size: 100% calc(100% - 8px), 16px 8px;
            mask-position: top left, bottom left;
            mask-repeat: no-repeat, repeat-x;
        }

        /* Initial hidden states — GSAP (see script at the bottom) animates these in */
        .print-line { opacity: 0; transform: translateY(-6px); }
        .receipt-unroll { overflow: hidden; height: 0; }
        .hero-in { opacity: 0; transform: translateY(20px); }
        .receipt-stamp-hidden { opacity: 0; transform: scale(0) rotate(-20deg); }
        .marquee-track { will-change: transform; }

        /* Scroll reveal — driven by GSAP ScrollTrigger */
        .reveal { opacity: 0; transform: translateY(22px); }
        .stagger > * { opacity: 0; transform: translateY(16px); }

        .barcode { background-image: repeating-linear-gradient(90deg, currentColor 0 2px, transparent 2px 5px, currentColor 5px 6px, transparent 6px 11px); }

        details summary::-webkit-details-marker { display: none; }

        @media (prefers-reduced-motion: reduce) {
            .print-line, .receipt-unroll, .reveal, .stagger > *, .hero-in, .receipt-stamp-hidden { opacity: 1 !important; transform: none !important; height: auto !important; }
        }
    </style>
</head>

<body class="bg-paper dark:bg-ink text-ink dark:text-paper font-body antialiased transition-colors duration-300">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 border-b border-ink/10 dark:border-paper/10 bg-paper/90 dark:bg-ink/90 backdrop-blur-md">
        <div class="w-[min(1180px,calc(100%-40px))] mx-auto flex items-center justify-between min-h-[72px] gap-6">
            <a href="/" class="flex items-center gap-2 font-display font-700 text-lg tracking-tight">
                <span class="w-9 h-9 rounded-lg bg-till-500 text-paper grid place-items-center font-mono text-sm">P</span>
                SaaS<span class="text-till-500">POS</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 font-mono text-[13px] uppercase tracking-wide text-ink/60 dark:text-paper/60">
                <a href="#features" class="hover:text-till-500 transition-colors">Features</a>
                <a href="#how-it-works" class="hover:text-till-500 transition-colors">Kaise Kaam Karta Hai</a>
                <a href="#pricing" class="hover:text-till-500 transition-colors">Qeemat</a>
                <a href="#faq" class="hover:text-till-500 transition-colors">Sawalat</a>
            </nav>

            <div class="flex items-center gap-2">
                <button id="themeToggle" aria-label="Theme badlein" class="w-10 h-10 grid place-items-center rounded-lg border border-ink/15 dark:border-paper/15 hover:bg-ink/5 dark:hover:bg-paper/10 transition-colors">
                    <svg class="dark:hidden" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                    <svg class="hidden dark:block" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.8A8.5 8.5 0 1111.2 3 6.7 6.7 0 0021 12.8z"/></svg>
                </button>

                <a href="{{ route('login') }}" class="hidden md:inline-flex px-3 py-2 font-mono text-[13px] text-ink/60 dark:text-paper/60 hover:text-ink dark:hover:text-paper transition-colors">Login</a>
                <a href="{{ route('business.register') }}" class="hidden md:inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-till-500 hover:bg-till-600 text-paper font-semibold text-sm transition-all hover:-translate-y-0.5 shadow-lg shadow-till-500/20">
                    Free Shuru Karein
                </a>

                <button id="menuToggle" aria-label="Menu kholein" aria-expanded="false" class="md:hidden w-10 h-10 grid place-items-center rounded-lg border border-ink/15 dark:border-paper/15">
                    <svg width="19" height="19" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
            </div>
        </div>

        <div id="mobileMenu" hidden class="md:hidden border-t border-ink/10 dark:border-paper/10 px-5 py-4 space-y-1 font-mono text-sm">
            <a href="#features" class="block py-3 border-b border-ink/10 dark:border-paper/10">Features</a>
            <a href="#how-it-works" class="block py-3 border-b border-ink/10 dark:border-paper/10">Kaise Kaam Karta Hai</a>
            <a href="#pricing" class="block py-3 border-b border-ink/10 dark:border-paper/10">Qeemat</a>
            <a href="#faq" class="block py-3 border-b border-ink/10 dark:border-paper/10">Sawalat</a>
            <a href="{{ route('login') }}" class="block py-3">Login</a>
            <a href="{{ route('business.register') }}" class="block mt-3 text-center px-4 py-3 rounded-lg bg-till-500 text-paper font-semibold">Free Shuru Karein</a>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section class="relative overflow-hidden py-20 md:py-28 border-b border-ink/10 dark:border-paper/10">
            <div class="w-[min(1180px,calc(100%-40px))] mx-auto grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="hero-in hero-badge inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-till-50 dark:bg-till-700/20 text-till-600 dark:text-till-400 font-mono text-xs uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-till-500 animate-pulse"></span>
                        Har sale ka hisaab, pakka
                    </div>

                    <h1 class="hero-in hero-title mt-5 font-display font-700 text-[42px] sm:text-[54px] md:text-[60px] leading-[1.05] tracking-tight max-w-xl">
                        Apni dukaan aasani se chalayein, munafa khud dekhein.
                    </h1>

                    <p class="hero-in hero-desc mt-6 max-w-md text-ink/65 dark:text-paper/65 text-[17px] leading-relaxed">
                        SaaS POS aapki har sale, har saamaan, aur har rupay ka hisaab seedha rakhta hai —
                        taake aapka counter tez chale aur hisaab kitab saaf rahe.
                    </p>

                    <div class="hero-in hero-cta mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('business.register') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-lg bg-till-500 hover:bg-till-600 text-paper font-semibold text-sm transition-all hover:-translate-y-0.5 shadow-lg shadow-till-500/25">
                            Free Trial Shuru Karein
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6l6 6-6 6"/></svg>
                        </a>
                        <a href="#features" class="inline-flex items-center px-6 py-3.5 rounded-lg border border-ink/15 dark:border-paper/20 font-semibold text-sm hover:bg-ink/5 dark:hover:bg-paper/10 transition-colors">
                            Features Dekhein
                        </a>
                    </div>

                    <p class="hero-in hero-note mt-6 flex items-center gap-2 text-xs font-mono text-ink/50 dark:text-paper/50">
                        <svg width="15" height="15" fill="none" stroke="currentColor" class="text-till-500" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Card ki zaroorat nahi — 10 minute se kam mein shuru karein
                    </p>
                </div>

                <!-- Animated receipt -->
                <div class="relative flex justify-center">
                    <div class="float w-[300px] sm:w-[330px]">
                        <div class="receipt-unroll [--receipt-h:480px] bg-white text-ink shadow-receipt rounded-t-md">
                            <div class="torn-bottom bg-white px-6 pt-7 pb-6 font-mono text-[12px] leading-relaxed">
                                <p class="print-line text-center font-semibold text-[14px] tracking-widest">SAAS POS</p>
                                <p class="print-line text-center text-ink/40 text-[10px]">Main Counter · Karachi</p>
                                <p class="print-line text-center text-ink/40 text-[10px] mb-3">Thu 24 Oct · 09:41</p>

                                <div class="print-line border-t border-dashed border-ink/25 my-2"></div>

                                <div class="print-line flex justify-between"><span>Espresso beans 1kg</span><span>2,400</span></div>
                                <div class="print-line flex justify-between"><span>Ceramic mug ×2</span><span>1,850</span></div>
                                <div class="print-line flex justify-between"><span>Pour-over kit</span><span>3,600</span></div>
                                <div class="print-line flex justify-between"><span>Points ka discount</span><span>-500</span></div>

                                <div class="print-line border-t border-dashed border-ink/25 my-2"></div>

                                <div class="print-line flex justify-between font-semibold text-[13px]"><span>TOTAL</span><span>Rs. 7,350</span></div>
                                <div class="print-line flex justify-between text-ink/40"><span>Payment — Card</span><span>Mukammal</span></div>

                                <div class="print-line border-t border-dashed border-ink/25 my-3"></div>
                                <div class="print-line h-6 barcode text-ink/70"></div>
                                <p class="print-line text-center mt-2 text-[10px] text-ink/40">Khareedari ka shukriya</p>
                            </div>
                        </div>
                    </div>

                    <div class="receipt-stamp receipt-stamp-hidden absolute -bottom-6 -right-2 sm:right-4 bg-stamp text-white text-xs font-mono font-semibold px-3 py-2 rounded-md shadow-lg">
                        +12% aaj
                    </div>
                </div>
            </div>
        </section>

        <!-- Logo marquee -->
        <div class="py-6 border-b border-ink/10 dark:border-paper/10 overflow-hidden">
            <div class="flex whitespace-nowrap marquee-track font-mono text-xs uppercase tracking-[0.2em] text-ink/35 dark:text-paper/35 gap-14 w-max">
                <span class="flex gap-14">
                    <span>Boutiques</span><span>Cafés</span><span>Pharmacies</span><span>Hardware Stores</span><span>Bakeries</span><span>Electronics Shops</span><span>Salons</span>
                </span>
                <span class="flex gap-14" aria-hidden="true">
                    <span>Boutiques</span><span>Cafés</span><span>Pharmacies</span><span>Hardware Stores</span><span>Bakeries</span><span>Electronics Shops</span><span>Salons</span>
                </span>
            </div>
        </div>

        <!-- Features -->
        <section id="features" class="py-24 md:py-28">
            <div class="w-[min(1180px,calc(100%-40px))] mx-auto">
                <div class="reveal max-w-xl mb-14">
                    <div class="font-mono text-xs uppercase tracking-widest text-till-500">01 · Sab kuch ek counter par</div>
                    <h2 class="mt-3 font-display font-700 text-[34px] md:text-[42px] tracking-tight leading-tight">Aisay tools jo aapki team har shift mein use karti hai.</h2>
                    <p class="mt-4 text-ink/60 dark:text-paper/60 text-[16px] leading-relaxed">Ek simple POS system jo counter ke liye bana hai, meeting room ke liye nahi.</p>
                </div>

                <div class="stagger grid md:grid-cols-3 gap-8">
                    <article class="pt-6 border-t-2 border-ink/10 dark:border-paper/15 hover:border-till-500 transition-colors duration-300">
                        <div class="w-11 h-11 rounded-lg bg-till-50 dark:bg-till-700/20 text-till-500 grid place-items-center mb-5">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="font-display font-600 text-lg mb-2">Tez Point Of Sale</h3>
                        <p class="text-ink/60 dark:text-paper/60 text-sm leading-relaxed">Scan karein, discount dein, aur qatar ko pata chalne se pehle receipt print ho jaye — ek busy counter ke liye bana hai.</p>
                    </article>

                    <article class="pt-6 border-t-2 border-ink/10 dark:border-paper/15 hover:border-till-500 transition-colors duration-300">
                        <div class="w-11 h-11 rounded-lg bg-till-50 dark:bg-till-700/20 text-till-500 grid place-items-center mb-5">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="font-display font-600 text-lg mb-2">Sahi Inventory</h3>
                        <p class="text-ink/60 dark:text-paper/60 text-sm leading-relaxed">Har sale ke sath stock khud update ho jata hai, khatam hone se pehle alert deta hai, aur har location par sync rehta hai.</p>
                    </article>

                    <article class="pt-6 border-t-2 border-ink/10 dark:border-paper/15 hover:border-till-500 transition-colors duration-300">
                        <div class="w-11 h-11 rounded-lg bg-till-50 dark:bg-till-700/20 text-till-500 grid place-items-center mb-5">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6"/></svg>
                        </div>
                        <h3 class="font-display font-600 text-lg mb-2">Saaf Reports</h3>
                        <p class="text-ink/60 dark:text-paper/60 text-sm leading-relaxed">Aaj ki sales, sabse zyada bikne wala saamaan, aur paisa kahan gaya — asaan numbers mein, mushkil dashboards mein nahi.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section id="how-it-works" class="py-24 md:py-28 bg-paper-dim dark:bg-paper/[0.03] border-y border-ink/10 dark:border-paper/10">
            <div class="w-[min(1180px,calc(100%-40px))] mx-auto">
                <div class="reveal max-w-xl mx-auto text-center mb-16">
                    <div class="font-mono text-xs uppercase tracking-widest text-till-500">02 · Setup</div>
                    <h2 class="mt-3 font-display font-700 text-[34px] md:text-[42px] tracking-tight">Sirf 3 steps mein dukaan shuru karein.</h2>
                </div>

                <div class="stagger grid md:grid-cols-3 gap-10 relative">
                    <div class="hidden md:block absolute top-5 left-[16.5%] right-[16.5%] border-t border-dashed border-ink/20 dark:border-paper/20"></div>

                    <article class="relative text-center md:text-left">
                        <div class="mx-auto md:mx-0 w-10 h-10 rounded-full bg-paper dark:bg-ink border border-till-500 text-till-500 font-mono font-semibold grid place-items-center mb-5 relative z-10">1</div>
                        <h3 class="font-display font-600 text-lg mb-2">Apna Workspace Kholein</h3>
                        <p class="text-ink/60 dark:text-paper/60 text-sm leading-relaxed">Apni store register karein, currency aur tax rules set karein, apna staff invite karein.</p>
                    </article>
                    <article class="relative text-center md:text-left">
                        <div class="mx-auto md:mx-0 w-10 h-10 rounded-full bg-paper dark:bg-ink border border-till-500 text-till-500 font-mono font-semibold grid place-items-center mb-5 relative z-10">2</div>
                        <h3 class="font-display font-600 text-lg mb-2">Apna Saamaan Add Karein</h3>
                        <p class="text-ink/60 dark:text-paper/60 text-sm leading-relaxed">Spreadsheet se saamaan import karein ya khud prices aur stock ke sath add karein.</p>
                    </article>
                    <article class="relative text-center md:text-left">
                        <div class="mx-auto md:mx-0 w-10 h-10 rounded-full bg-paper dark:bg-ink border border-till-500 text-till-500 font-mono font-semibold grid place-items-center mb-5 relative z-10">3</div>
                        <h3 class="font-display font-600 text-lg mb-2">Apni Pehli Sale Karein</h3>
                        <p class="text-ink/60 dark:text-paper/60 text-sm leading-relaxed">Har sale seedha aapke dashboard mein aa jati hai — din ke aakhir mein hisaab milane ki zaroorat nahi.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Pricing -->
        <section id="pricing" class="py-24 md:py-28">
            <div class="w-[min(1180px,calc(100%-40px))] mx-auto">
                <div class="reveal max-w-xl mx-auto text-center mb-16">
                    <div class="font-mono text-xs uppercase tracking-widest text-till-500">03 · Qeemat</div>
                    <h2 class="mt-3 font-display font-700 text-[34px] md:text-[42px] tracking-tight">Seedhi qeemat, koi chhupi shart nahi.</h2>
                    <p class="mt-4 text-ink/60 dark:text-paper/60">Free shuru karein, jab dusra counter khule tab upgrade karein.</p>
                </div>

                <div class="stagger grid md:grid-cols-3 gap-6 items-stretch">
                    <article class="flex flex-col p-8 rounded-2xl border border-ink/10 dark:border-paper/15 bg-white dark:bg-paper/[0.03]">
                        <h3 class="font-display font-600 text-xl mb-2">Starter</h3>
                        <p class="text-ink/55 dark:text-paper/55 text-sm mb-6 min-h-[42px]">Nayi dukaanon ke liye jo abhi shuru ho rahi hain.</p>
                        <div class="font-display font-700 text-4xl mb-6 tracking-tight">Free<span class="text-sm font-normal text-ink/50 dark:text-paper/50 font-body"> / hamesha</span></div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-ink/65 dark:text-paper/65">
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>50 saamaan tak</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Basic point of sale</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Inventory tracking</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Email support</li>
                        </ul>
                        <a href="{{ route('business.register', ['plan' => 'starter']) }}" class="text-center px-4 py-3 rounded-lg border border-ink/15 dark:border-paper/20 font-semibold text-sm hover:bg-ink/5 dark:hover:bg-paper/10 transition-colors">Shuru Karein</a>
                    </article>

                    <article class="flex flex-col p-8 rounded-2xl border-2 border-till-500 bg-white dark:bg-paper/[0.05] relative shadow-xl shadow-till-500/10 md:-translate-y-2">
                        <span class="absolute -top-3 left-8 px-3 py-1 rounded-full bg-till-500 text-white text-xs font-mono font-semibold">Tajweez Kiya Gaya</span>
                        <h3 class="font-display font-600 text-xl mb-2 mt-1">Business</h3>
                        <p class="text-ink/55 dark:text-paper/55 text-sm mb-6 min-h-[42px]">Barhti hui teams ke liye jinhein asli reports chahiye.</p>
                        <div class="font-display font-700 text-4xl mb-6 tracking-tight">$29<span class="text-sm font-normal text-ink/50 dark:text-paper/50 font-body"> / mahina</span></div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-ink/65 dark:text-paper/65">
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Unlimited saamaan</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Advanced POS features</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Sales aur munafa ki reports</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Multi-user access</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Priority support</li>
                        </ul>
                        <a href="{{ route('business.register', ['plan' => 'business']) }}" class="text-center px-4 py-3 rounded-lg bg-till-500 hover:bg-till-600 text-white font-semibold text-sm transition-all hover:-translate-y-0.5 shadow-lg shadow-till-500/25">Business Chunein</a>
                    </article>

                    <article class="flex flex-col p-8 rounded-2xl border border-ink/10 dark:border-paper/15 bg-white dark:bg-paper/[0.03]">
                        <h3 class="font-display font-600 text-xl mb-2">Enterprise</h3>
                        <p class="text-ink/55 dark:text-paper/55 text-sm mb-6 min-h-[42px]">Kai stores chalane wale business ke liye.</p>
                        <div class="font-display font-700 text-4xl mb-6 tracking-tight">$99<span class="text-sm font-normal text-ink/50 dark:text-paper/50 font-body"> / mahina</span></div>
                        <ul class="space-y-3 mb-8 flex-1 text-sm text-ink/65 dark:text-paper/65">
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Business plan ki har cheez</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Multi-store management</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Custom integrations</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Dedicated account manager</li>
                            <li class="flex gap-2"><span class="text-till-500 font-bold">✓</span>Priority phone support</li>
                        </ul>
                        <a href="{{ route('business.register', ['plan' => 'enterprise']) }}" class="text-center px-4 py-3 rounded-lg border border-ink/15 dark:border-paper/20 font-semibold text-sm hover:bg-ink/5 dark:hover:bg-paper/10 transition-colors">Sales Se Baat Karein</a>
                    </article>
                </div>
            </div>
        </section>

        <!-- Testimonial -->
        <section class="py-24 md:py-28 bg-paper-dim dark:bg-paper/[0.03] border-y border-ink/10 dark:border-paper/10">
            <div class="w-[min(1180px,calc(100%-40px))] mx-auto grid md:grid-cols-[0.8fr_1.2fr] gap-16 items-center">
                <div class="reveal">
                    <div class="font-mono text-xs uppercase tracking-widest text-till-500">Customer Ki Kahani</div>
                    <p class="font-display font-600 text-lg mt-4">Sarah Khan</p>
                    <p class="text-ink/55 dark:text-paper/55 text-sm">Maalik, Fashion Boutique</p>
                    <p class="text-ink/55 dark:text-paper/55 text-sm mt-1">Retail business jo SaaS POS par chal rahi hai.</p>
                </div>
                <blockquote class="reveal font-display font-600 text-[26px] md:text-[34px] leading-snug tracking-tight">
                    "SaaS POS ne hamare roz marra ke kaam kaafi asaan kar diye hain. Ab hamein stock, sales, aur zaroori cheezon ka saaf pata chalta hai."
                </blockquote>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="py-24 md:py-28">
            <div class="w-[min(1180px,calc(100%-40px))] mx-auto">
                <div class="reveal max-w-xl mx-auto text-center mb-14">
                    <div class="font-mono text-xs uppercase tracking-widest text-till-500">Sawalat</div>
                    <h2 class="mt-3 font-display font-700 text-[34px] md:text-[42px] tracking-tight">Dukaan shuru karne se pehle koi sawal?</h2>
                </div>

                <div class="reveal max-w-2xl mx-auto divide-y divide-ink/10 dark:divide-paper/10">
                    <details class="group py-5">
                        <summary class="flex items-center justify-between gap-4 cursor-pointer font-semibold text-[15px] list-none">
                            Kya free trial mojood hai?
                            <span class="text-till-500 text-xl group-open:rotate-45 transition-transform shrink-0">+</span>
                        </summary>
                        <p class="mt-3 text-sm text-ink/60 dark:text-paper/60 leading-relaxed max-w-xl">Ji haan. Paid plan chunne se pehle 14 din ki free trial se platform explore karein. Card ki zaroorat nahi.</p>
                    </details>

                    <details class="group py-5">
                        <summary class="flex items-center justify-between gap-4 cursor-pointer font-semibold text-[15px] list-none">
                            Kya main apna maujooda saamaan import kar sakta hoon?
                            <span class="text-till-500 text-xl group-open:rotate-45 transition-transform shrink-0">+</span>
                        </summary>
                        <p class="mt-3 text-sm text-ink/60 dark:text-paper/60 leading-relaxed max-w-xl">Ji haan. CSV ya Excel file se apna maujooda saamaan chand minute mein SaaS POS mein import karein.</p>
                    </details>

                    <details class="group py-5">
                        <summary class="flex items-center justify-between gap-4 cursor-pointer font-semibold text-[15px] list-none">
                            Kya mera business data mehfooz hai?
                            <span class="text-till-500 text-xl group-open:rotate-45 transition-transform shrink-0">+</span>
                        </summary>
                        <p class="mt-3 text-sm text-ink/60 dark:text-paper/60 leading-relaxed max-w-xl">Aapka data encrypted connections, sakht access control, aur regular automated backups se mehfooz hai.</p>
                    </details>

                    <details class="group py-5">
                        <summary class="flex items-center justify-between gap-4 cursor-pointer font-semibold text-[15px] list-none">
                            Kya main kai stores manage kar sakta hoon?
                            <span class="text-till-500 text-xl group-open:rotate-45 transition-transform shrink-0">+</span>
                        </summary>
                        <p class="mt-3 text-sm text-ink/60 dark:text-paper/60 leading-relaxed max-w-xl">Ji haan, Enterprise plan par — har location ki reports aur inventory ek jagah dekh sakte hain.</p>
                    </details>

                    <details class="group py-5">
                        <summary class="flex items-center justify-between gap-4 cursor-pointer font-semibold text-[15px] list-none">
                            Kya main baad mein apna plan badal sakta hoon?
                            <span class="text-till-500 text-xl group-open:rotate-45 transition-transform shrink-0">+</span>
                        </summary>
                        <p class="mt-3 text-sm text-ink/60 dark:text-paper/60 leading-relaxed max-w-xl">Ji haan. Jab bhi zaroorat ho plan upgrade ya downgrade karein — koi long-term lock-in nahi.</p>
                    </details>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="pb-24 md:pb-28">
            <div class="w-[min(1180px,calc(100%-40px))] mx-auto">
                <div class="reveal relative overflow-hidden text-center rounded-2xl border border-ink/10 dark:border-paper/15 bg-ink dark:bg-till-700/10 text-paper px-8 py-16 md:py-20">
                    <div class="absolute inset-0 opacity-[0.06] barcode"></div>
                    <h2 class="relative font-display font-700 text-[32px] md:text-[44px] tracking-tight max-w-xl mx-auto">Din ka hisaab aasan banane ke liye tayyar hain?</h2>
                    <p class="relative mt-4 max-w-md mx-auto text-paper/65 text-[15px] leading-relaxed">Apni sales, stock, aur reports ek hi jagah laayein.</p>
                    <div class="relative mt-8 flex justify-center flex-wrap gap-3">
                        <a href="{{ route('business.register') }}" class="px-6 py-3.5 rounded-lg bg-till-500 hover:bg-till-400 text-white font-semibold text-sm transition-all hover:-translate-y-0.5">Free Trial Shuru Karein</a>
                        <a href="mailto:hello@saaspos.com?subject=Schedule%20a%20SaaS%20POS%20Demo" class="px-6 py-3.5 rounded-lg border border-paper/25 hover:bg-paper/10 font-semibold text-sm transition-colors">Demo Book Karein</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="py-9 border-t border-ink/10 dark:border-paper/10">
        <div class="w-[min(1180px,calc(100%-40px))] mx-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <a href="/" class="flex items-center gap-2 font-display font-700">
                <span class="w-9 h-9 rounded-lg bg-till-500 text-paper grid place-items-center font-mono text-sm">P</span>
                SaaS<span class="text-till-500">POS</span>
            </a>
            <p class="text-ink/50 dark:text-paper/50 text-sm">© {{ date('Y') }} SaaS POS. Tamam huqooq mehfooz hain.</p>
            <div class="flex gap-5 font-mono text-xs uppercase tracking-wide text-ink/50 dark:text-paper/50">
                <a href="#features" class="hover:text-till-500 transition-colors">Features</a>
                <a href="#pricing" class="hover:text-till-500 transition-colors">Qeemat</a>
                <a href="#faq" class="hover:text-till-500 transition-colors">Support</a>
            </div>
        </div>
    </footer>

    <script>
        // Theme toggle
        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            try { localStorage.setItem('theme', isDark ? 'dark' : 'light'); } catch (e) {}
        });

        // Mobile menu
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        menuToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.hasAttribute('hidden');
            if (isOpen) {
                mobileMenu.setAttribute('hidden', '');
                menuToggle.setAttribute('aria-expanded', 'false');
            } else {
                mobileMenu.removeAttribute('hidden');
                menuToggle.setAttribute('aria-expanded', 'true');
            }
        });
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.setAttribute('hidden', '');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });
    </script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script>
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion || typeof gsap === 'undefined') {
            // CSS already shows everything at full opacity via the reduced-motion
            // media query / GSAP-missing fallback — nothing else to do.
        } else {
            gsap.registerPlugin(ScrollTrigger);

            // ---- Hero entrance ----
            const heroTl = gsap.timeline({ defaults: { ease: 'power3.out' } });

            heroTl
                .to('.hero-badge', { opacity: 1, y: 0, duration: 0.5 })
                .to('.hero-title', { opacity: 1, y: 0, duration: 0.7 }, '-=0.3')
                .to('.hero-desc', { opacity: 1, y: 0, duration: 0.6 }, '-=0.4')
                .to('.hero-cta', { opacity: 1, y: 0, duration: 0.6 }, '-=0.35')
                .to('.hero-note', { opacity: 1, y: 0, duration: 0.5 }, '-=0.3')
                .to('.receipt-unroll', { height: 480, duration: 1, ease: 'power2.inOut' }, '-=0.65')
                .to('.print-line', { opacity: 1, y: 0, duration: 0.35, stagger: 0.07 }, '-=0.75')
                .to('.receipt-stamp', { opacity: 1, scale: 1, rotate: 6, duration: 0.5, ease: 'back.out(2)' }, '-=0.15');

            // Gentle infinite float on the whole receipt, once it's unrolled
            gsap.to('.float', {
                y: -10,
                duration: 2.5,
                ease: 'sine.inOut',
                repeat: -1,
                yoyo: true,
                delay: 1.2,
            });

            // ---- Logo marquee ----
            gsap.to('.marquee-track', {
                xPercent: -50,
                duration: 22,
                ease: 'none',
                repeat: -1,
            });

            // ---- Scroll-triggered section reveals ----
            gsap.utils.toArray('.reveal').forEach((el) => {
                gsap.to(el, {
                    opacity: 1,
                    y: 0,
                    duration: 0.7,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 85%',
                        once: true,
                    },
                });
            });

            // ---- Scroll-triggered staggered groups (feature cards, steps, pricing) ----
            gsap.utils.toArray('.stagger').forEach((group) => {
                gsap.to(group.children, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6,
                    ease: 'power2.out',
                    stagger: 0.09,
                    scrollTrigger: {
                        trigger: group,
                        start: 'top 85%',
                        once: true,
                    },
                });
            });
        }
    </script>
</body>
</html>