<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $currentUser = auth()->user();
        $currentTenant = $currentUser->tenant;
    @endphp

    <title>@yield('title', 'Dashboard') | {{ $currentTenant->company_name }}</title>

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

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --app-bg: #0b0f19;
            --app-surface: #111827;
            --app-surface-hover: #182235;
            --app-elevated: #151f31;
            --app-border: rgba(148, 163, 184, 0.15);
            --app-border-strong: rgba(148, 163, 184, 0.25);

            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;

            --primary: #0E7A5C;
            --primary-hover: #0B6049;
            --primary-soft: rgba(14, 122, 92, 0.13);

            --success: #34d399;
            --warning: #fbbf24;
            --danger: #f87171;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--app-bg);
            color: var(--text-primary);
            font-family: "Inter", sans-serif;
            overflow-x: hidden;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.4);
        }

        /* Reusable cards */
        .glass {
            background: var(--app-surface);
            border: 1px solid var(--app-border);
        }

        .glass-light {
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid var(--app-border);
        }

        /* Inputs */
        .input-modern {
            width: 100%;
            padding: 11px 14px;
            color: var(--text-primary);
            background: #0c1320;
            border: 1px solid var(--app-border);
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-modern::placeholder {
            color: var(--text-muted);
        }

        .input-modern:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.14);
        }

        select.input-modern {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 38px;
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            color: #ffffff;
            background: var(--primary);
            border: 1px solid var(--primary);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            color: var(--text-secondary);
            background: var(--app-elevated);
            border: 1px solid var(--app-border);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            color: var(--text-primary);
            background: var(--app-surface-hover);
            border-color: var(--app-border-strong);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.15);
        }

        /* Sidebar */
        .sidebar {
            background: #0d1421;
            border-right: 1px solid var(--app-border);
        }

        .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            color: var(--text-secondary);
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.04);
        }

        .nav-link.active {
            color: #ffffff;
            background: var(--primary-soft);
            border-color: rgba(14, 122, 92, 0.28);
        }

        .nav-link.active svg {
            color: #7dd3b0;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 18px 0 8px;
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .section-label::after {
            content: "";
            height: 1px;
            flex: 1;
            background: var(--app-border);
        }

        /* Cards */
        .stat-card {
            position: relative;
            padding: 22px;
            overflow: hidden;
            background: var(--app-surface);
            border: 1px solid var(--app-border);
            border-radius: 16px;
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .stat-card:hover {
            border-color: rgba(14, 122, 92, 0.35);
            transform: translateY(-2px);
        }

        .table-row {
            border-bottom: 1px solid var(--app-border);
            transition: background 0.2s ease;
        }

        .table-row:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
        }

        .badge-success {
            color: #6ee7b7;
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.18);
        }

        .badge-warning {
            color: #fcd34d;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.18);
        }

        .badge-danger {
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.18);
        }

        .badge-info {
            color: #7dd3b0;
            background: rgba(14, 122, 92, 0.12);
            border: 1px solid rgba(14, 122, 92, 0.18);
        }

        /* Alerts */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 12px;
        }

        .alert-success {
            color: #a7f3d0;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            color: #fecaca;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Modal fallback - transparent issue fix */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 80;
            background: rgba(2, 6, 23, 0.82);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            z-index: 90;
            width: min(92%, 520px);
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            color: #f8fafc !important;
            background: #111827 !important;
            border: 1px solid #334155;
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            transform: translate(-50%, -50%);
        }

        /* Simple animations for existing pages */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-12px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fadeInUp 0.35s ease forwards;
        }

        .animate-slide-in {
            animation: slideInLeft 0.35s ease forwards;
        }

        .animate-slide-down {
            animation: fadeInUp 0.2s ease forwards;
        }

        .delay-1 { animation-delay: 0.05s; opacity: 0; }
        .delay-2 { animation-delay: 0.10s; opacity: 0; }
        .delay-3 { animation-delay: 0.15s; opacity: 0; }
        .delay-4 { animation-delay: 0.20s; opacity: 0; }
        .delay-5 { animation-delay: 0.25s; opacity: 0; }

        @media (max-width: 640px) {
            .stat-card {
                padding: 16px;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen text-slate-100">

    {{-- Mobile Sidebar Overlay --}}
    <div
        id="sidebarOverlay"
        class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm lg:hidden"
        onclick="toggleSidebar()"
    ></div>

    {{-- Sidebar --}}
    <aside
        id="sidebar"
        class="sidebar fixed inset-y-0 left-0 z-50 flex w-[264px] -translate-x-full flex-col transition-transform duration-300 lg:translate-x-0"
    >
        {{-- Company / Logo --}}
        <div class="border-b border-white/[0.07] px-5 py-5">
            <a href="{{ route('tenant.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-600 text-white shadow-lg shadow-till-500/20">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 002 2v14a2 2 0 002 2z"
                        />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-extrabold tracking-tight text-white">SaaS POS</p>
                    <p class="max-w-[165px] truncate text-[11px] font-medium text-slate-500">
                        {{ $currentTenant->company_name }}
                    </p>
                </div>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto p-3">

            <div class="section-label">Jaiza</div>

            @unless($currentUser->isCashier())
                <a
                    href="{{ route('tenant.dashboard') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                        />
                    </svg>
                    Dashboard
                </a>
            @endunless

            <a
                href="{{ route('tenant.pos') }}"
                data-sidebar-link
                class="nav-link {{ request()->routeIs('tenant.pos') ? 'active' : '' }}"
            >
                <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                    />
                </svg>

                POS Counter

                <span class="ml-auto badge badge-info">LIVE</span>
            </a>

            @if(!$currentUser->isCashier())
                <div class="section-label">Intezaam</div>

                <a
                    href="{{ route('tenant.products.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.products.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                        />
                    </svg>
                    Saamaan
                </a>

                <a
                    href="{{ route('tenant.categories.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.categories.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                        />
                    </svg>
                    Categories
                </a>

                <a
                    href="{{ route('tenant.orders.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.orders.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                        />
                    </svg>
                    Orders
                </a>

                <a
                    href="{{ route('tenant.customers.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.customers.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"
                        />
                    </svg>
                    Customers
                </a>

                <a
                    href="{{ route('tenant.expenses.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.expenses.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 002 2v14a2 2 0 002 2z"
                        />
                    </svg>
                    Kharchay
                </a>

                @if($currentUser->role === 'admin')
                    <a
                        href="{{ route('tenant.staff.index') }}"
                        data-sidebar-link
                        class="nav-link {{ request()->routeIs('tenant.staff.*') ? 'active' : '' }}"
                    >
                        <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"
                            />
                        </svg>
                        Staff

                        @if($currentTenant->userLimit() === 1)
                            <span class="ml-auto badge badge-warning">PRO</span>
                        @endif
                    </a>
                @endif

                <div class="section-label">Analytics</div>

                <a
                    href="{{ route('tenant.reports.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.reports.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                        />
                    </svg>
                    Reports
                </a>
            @endif

            @if(in_array($currentUser->role, ['admin', 'manager']))
                <a
                    href="{{ route('tenant.refund-logs.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.refund-logs.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                    </svg>
                    Refund Logs
                </a>
            @endif

            @if($currentUser->role === 'admin')
                <div class="section-label">System</div>

                <a
                    href="{{ route('tenant.settings.index') }}"
                    data-sidebar-link
                    class="nav-link {{ request()->routeIs('tenant.settings.*') ? 'active' : '' }}"
                >
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                        />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>
                    Settings
                </a>
            @endif
        </nav>

        {{-- User / Logout --}}
        <div class="border-t border-white/[0.07] p-4">
            <div class="mb-3 flex items-center gap-3 px-2">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-till-600 text-xs font-bold text-white">
                    {{ strtoupper(substr($currentUser->name, 0, 2)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-white">
                        {{ $currentUser->name }}
                    </p>
                    <p class="truncate text-[11px] capitalize text-slate-500">
                        {{ $currentUser->role }}
                        ·
                        {{ $currentTenant->subscription_plan }}
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="nav-link w-full text-red-400 hover:bg-red-500/10 hover:text-red-300">
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Area --}}
    <div class="min-h-screen lg:ml-[264px]">

        {{-- Header --}}
        <header class="sticky top-0 z-30 border-b border-white/[0.07] bg-[#0b0f19]/95 backdrop-blur-xl">
            <div class="flex min-h-[68px] items-center justify-between px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/[0.08] bg-white/[0.03] text-slate-400 lg:hidden"
                        onclick="toggleSidebar()"
                        aria-label="Menu kholein"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-base font-bold tracking-tight text-white sm:text-lg">
                            @yield('page-title', 'Dashboard')
                        </h1>

                        <p class="mt-0.5 flex items-center gap-1.5 text-[11px] text-slate-500 sm:text-xs">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>

                            @yield('page-subtitle', now()->format('l, d F Y'))
                        </p>
                    </div>
                </div>

                <a
                    href="{{ route('tenant.pos') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-till-600 px-3 py-2.5 text-xs font-bold text-white shadow-lg shadow-till-500/20 transition hover:bg-till-500 sm:px-4 sm:text-sm"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2 2v14a2 2 0 002 2z"
                        />
                    </svg>

                    <span class="hidden sm:inline">POS Kholein</span>
                </a>
            </div>
        </header>

        {{-- Content --}}
        <main class="min-h-[calc(100vh-125px)] p-4 sm:p-6">
            @if(session('success'))
                <div class="alert alert-success">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-500/15 text-emerald-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-bold">Kamyab</p>
                        <p class="mt-0.5 text-xs text-emerald-200/70">
                            {{ session('success') }}
                        </p>
                    </div>

                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-300/60 hover:text-emerald-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-red-500/15 text-red-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                            />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-bold">Kuch ghalat ho gaya</p>
                        <p class="mt-0.5 text-xs text-red-200/70">
                            {{ session('error') }}
                        </p>
                    </div>

                    <button type="button" onclick="this.parentElement.remove()" class="text-red-300/60 hover:text-red-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="border-t border-white/[0.06] px-4 py-4 sm:px-6">
            <div class="flex flex-col gap-1 text-center text-[11px] text-slate-600 sm:flex-row sm:items-center sm:justify-between sm:text-left">
                <p>© {{ date('Y') }} SaaS POS. Tamam huqooq mehfooz hain.</p>
                <p>{{ $currentTenant->company_name }}</p>
            </div>
        </footer>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (window.innerWidth >= 1024) {
                return;
            }

            const isOpen = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        document.querySelectorAll('[data-sidebar-link]').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebarOverlay');

                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebarOverlay').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });

        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-8px)';
                alert.style.transition = 'all 0.3s ease';

                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>