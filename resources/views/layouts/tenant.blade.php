<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ auth()->user()->tenant->company_name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(99,102,241,0.5); }

        /* Root Variables */
        :root {
            --bg-primary: #06070A;
            --bg-secondary: #0C0E14;
            --bg-card: #111318;
            --bg-elevated: #16181F;
            --border-subtle: rgba(255,255,255,0.06);
            --border-medium: rgba(255,255,255,0.1);
            --accent-primary: #6366f1;
            --accent-secondary: #8b5cf6;
            --accent-glow: rgba(99,102,241,0.15);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #475569;
        }

        body { background: var(--bg-primary); }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(99,102,241,0.1); }
            50% { box-shadow: 0 0 40px rgba(99,102,241,0.2); }
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-4px); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes border-glow {
            0%, 100% { border-color: rgba(99,102,241,0.2); }
            50% { border-color: rgba(99,102,241,0.5); }
        }
        
        .animate-fade-in { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-slide-in { animation: fadeInLeft 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-slide-down { animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .delay-1 { animation-delay: 0.08s; opacity: 0; }
        .delay-2 { animation-delay: 0.16s; opacity: 0; }
        .delay-3 { animation-delay: 0.24s; opacity: 0; }
        .delay-4 { animation-delay: 0.32s; opacity: 0; }
        .delay-5 { animation-delay: 0.40s; opacity: 0; }

        /* Glassmorphism */
        .glass {
            background: rgba(17,19,24,0.8);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--border-subtle);
        }
        .glass-light {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-subtle);
        }

        /* Modern Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #0C0E14 0%, #090B10 100%);
            border-right: 1px solid var(--border-subtle);
        }
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(180deg, transparent, rgba(99,102,241,0.3), transparent);
        }

        /* Nav Links */
        .nav-link {
            display: flex; align-items: center; gap: 12px; padding: 11px 16px;
            border-radius: 12px; font-size: 13.5px; font-weight: 500; color: var(--text-secondary);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); cursor: pointer; text-decoration: none;
            position: relative; overflow: hidden;
        }
        .nav-link::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(139,92,246,0.05));
        }
        .nav-link:hover {
            color: var(--text-primary);
            transform: translateX(4px);
        }
        .nav-link:hover::before { opacity: 1; }
        .nav-link:hover svg { color: var(--accent-primary); }
        
        .nav-link.active {
            color: white;
            background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(139,92,246,0.1));
            border: 1px solid rgba(99,102,241,0.2);
            box-shadow: 0 0 20px rgba(99,102,241,0.08), inset 0 1px 0 rgba(255,255,255,0.05);
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
            border-radius: 0 4px 4px 0;
        }
        .nav-link.active svg { color: #818cf8; }

        /* Input Styles */
        .input-modern {
            background: var(--bg-card);
            border: 1px solid var(--border-medium);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            width: 100%;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
        }
        .input-modern:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 4px var(--accent-glow), 0 0 20px rgba(99,102,241,0.1);
            background: var(--bg-elevated);
        }
        .input-modern::placeholder { color: var(--text-muted); }
        
        select.input-modern {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236366f1' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #6366f1);
            background-size: 200% 100%;
            animation: gradient-shift 3s ease infinite;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 20px rgba(99,102,241,0.3), inset 0 1px 0 rgba(255,255,255,0.15);
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99,102,241,0.4), inset 0 1px 0 rgba(255,255,255,0.2);
        }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:active { transform: translateY(0); }
        
        .btn-secondary {
            background: var(--bg-elevated);
            color: var(--text-secondary);
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid var(--border-medium);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-secondary:hover {
            background: rgba(99,102,241,0.1);
            border-color: rgba(99,102,241,0.3);
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-danger {
            background: rgba(239,68,68,0.08);
            color: #f87171;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(239,68,68,0.15);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-danger:hover {
            background: rgba(239,68,68,0.15);
            border-color: rgba(239,68,68,0.3);
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(239,68,68,0.15);
        }

        /* Stat Cards */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(99,102,241,0.3), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        .stat-card:hover {
            border-color: rgba(99,102,241,0.2);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3), 0 0 30px rgba(99,102,241,0.05);
        }
        .stat-card:hover::before { opacity: 1; }

        /* Table Rows */
        .table-row {
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-subtle);
        }
        .table-row:hover {
            background: rgba(99,102,241,0.03);
        }

        /* Modal */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(8px);
            z-index: 50;
        }
        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            z-index: 60;
            width: 90%;
            max-width: 500px;
        }

        /* Section Label */
        .section-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--text-muted);
            padding: 0 16px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-subtle);
        }

        /* Status Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .badge-success {
            background: rgba(34,197,94,0.1);
            color: #4ade80;
            border: 1px solid rgba(34,197,94,0.2);
        }
        .badge-warning {
            background: rgba(245,158,11,0.1);
            color: #fbbf24;
            border: 1px solid rgba(245,158,11,0.2);
        }
        .badge-danger {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
        }
        .badge-info {
            background: rgba(99,102,241,0.1);
            color: #818cf8;
            border: 1px solid rgba(99,102,241,0.2);
        }

        /* Header with glass effect */
        .header-glass {
            background: rgba(6,7,10,0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border-subtle);
        }

        /* POS Button Special */
        .pos-btn {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            position: relative;
            overflow: hidden;
            animation: pulse-glow 3s ease-in-out infinite;
        }
        .pos-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(from 0deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: spin 4s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Tooltip */
        .tooltip {
            position: relative;
        }
        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%) scale(0.9);
            background: var(--bg-elevated);
            color: white;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s ease;
            border: 1px solid var(--border-subtle);
        }
        .tooltip:hover::after {
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }

        /* Alert styles */
        .alert {
            border-radius: 16px;
            padding: 16px 20px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            position: relative;
            overflow: hidden;
        }
        .alert::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }
        .alert-success {
            background: rgba(34,197,94,0.06);
            border: 1px solid rgba(34,197,94,0.15);
            color: #4ade80;
        }
        .alert-success::before { background: linear-gradient(180deg, #22c55e, #4ade80); }
        
        .alert-error {
            background: rgba(239,68,68,0.06);
            border: 1px solid rgba(239,68,68,0.15);
            color: #f87171;
        }
        .alert-error::before { background: linear-gradient(180deg, #ef4444, #f87171); }

        /* Mobile menu button */
        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .mobile-menu-btn:hover {
            background: rgba(99,102,241,0.1);
            border-color: rgba(99,102,241,0.3);
        }

        /* User avatar ring */
        .avatar-ring {
            padding: 2px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #a78bfa);
            border-radius: 50%;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .mobile-menu-btn { display: flex; }
            .sidebar-mobile-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.6);
                backdrop-filter: blur(4px);
                z-index: 45;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }
            .sidebar-mobile-overlay.active {
                opacity: 1;
                pointer-events: all;
            }
        }

        /* Notification dot */
        .notification-dot {
            width: 8px;
            height: 8px;
            background: #6366f1;
            border-radius: 50%;
            position: absolute;
            top: -2px;
            right: -2px;
            box-shadow: 0 0 8px rgba(99,102,241,0.6);
        }

        /* Subtle grid background */
        .grid-bg {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(99,102,241,0.03) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(139,92,246,0.03) 0%, transparent 50%);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen text-white grid-bg">

    <!-- Mobile Overlay -->
    <div class="sidebar-mobile-overlay lg:hidden" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="flex min-h-screen">
        
        <!-- ==================== SIDEBAR ==================== -->
        <aside id="sidebar" class="sidebar hidden lg:flex flex-col w-[272px] fixed inset-y-0 left-0 z-40 transition-transform duration-300">
            
            <!-- Logo Area -->
            <div class="p-6 border-b border-white/[0.06]">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 via-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/20 rotate-3 hover:rotate-0 transition-transform duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-400 rounded-full border-2 border-[#0C0E14]"></div>
                    </div>
                    <div>
                        <p class="font-extrabold text-white text-[15px] tracking-tight">SaaS POS</p>
                        <p class="text-[11px] text-indigo-400/80 truncate max-w-[160px] font-medium">{{ auth()->user()->tenant->company_name }}</p>
                    </div>
                </div>
            </div>
            
           <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                
                <div class="section-label mt-1 mb-3">Overview</div>
                
               @unless(auth()->user()->isCashier())
                <a href="{{ route('tenant.dashboard') }}" class="nav-link {{ request()->routeIs('tenant.dashboard') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                @endunless
                
                <a href="{{ route('tenant.pos') }}" class="nav-link {{ request()->routeIs('tenant.pos') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    POS Counter
                    <span class="ml-auto badge badge-info text-[10px] py-0.5 px-2">Live</span>
                </a>

                @if(!auth()->user()->isCashier())
                <div class="section-label mt-6 mb-3">Management</div>
                
                <a href="{{ route('tenant.products.index') }}" class="nav-link {{ request()->routeIs('tenant.products.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Products
                </a>
                
                <a href="{{ route('tenant.categories.index') }}" class="nav-link {{ request()->routeIs('tenant.categories.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Categories
                </a>
                
                <a href="{{ route('tenant.orders.index') }}" class="nav-link {{ request()->routeIs('tenant.orders.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Orders
                </a>
                
                <a href="{{ route('tenant.customers.index') }}" class="nav-link {{ request()->routeIs('tenant.customers.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Customers
                </a>
                <a href="{{ route('tenant.expenses.index') }}" class="nav-link {{ request()->routeIs('tenant.expenses.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Expenses
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('tenant.staff.index') }}" class="nav-link {{ request()->routeIs('tenant.staff.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Staff
                    @if(auth()->user()->tenant->userLimit() === 1)
                        <span class="ml-auto badge badge-warning text-[9px] py-0.5 px-1.5">PRO</span>
                    @endif
                </a>
                @endif

                <div class="section-label mt-6 mb-3">Analytics</div>
                
                <a href="{{ route('tenant.reports.index') }}" class="nav-link {{ request()->routeIs('tenant.reports.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Reports
                </a>
                @endif
@if(in_array(auth()->user()->role, ['admin', 'manager']))
                <a href="{{ route('tenant.refund-logs.index') }}" class="nav-link {{ request()->routeIs('tenant.refund-logs.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Refund Logs
                </a>
                @endif
                @if(auth()->user()->role === 'admin')
                <div class="section-label mt-6 mb-3">System</div>
                
                <a href="{{ route('tenant.settings.index') }}" class="nav-link {{ request()->routeIs('tenant.settings.*') ? 'active' : '' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Settings
                </a>
                @endif
            </nav>
            
            <!-- User Section -->
            <div class="p-4 border-t border-white/[0.06]">
                <!-- Quick Stats Mini -->
                <div class="glass-light rounded-2xl p-3 mb-4">
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-gray-500">Plan</span>
                        <span class="badge badge-success text-[10px] py-0.5 px-2 capitalize">{{ auth()->user()->tenant->subscription_plan }}</span>
                    </div>
                    
                </div>
                
                <div class="flex items-center gap-3 mb-3">
                    <div class="avatar-ring">
                        <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-indigo-400/70 capitalize font-medium">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-full text-red-400/80 hover:text-red-300 hover:bg-red-500/8 group">
                        <svg class="w-[18px] h-[18px] group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- ==================== MAIN CONTENT ==================== -->
        <div class="flex-1 lg:ml-[272px]">
            
            <!-- Header -->
            <header class="header-glass px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-btn lg:hidden" onclick="toggleSidebar()">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-lg font-bold text-white tracking-tight">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            @yield('page-subtitle', now()->format('l, d F Y'))
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <!-- Search Button -->
                    <button class="w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center hover:bg-white/[0.08] transition-all tooltip hidden sm:flex" data-tooltip="Search">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                    
                    <!-- Notifications -->
                    <button class="w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center hover:bg-white/[0.08] transition-all relative tooltip hidden sm:flex" data-tooltip="Notifications">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <div class="notification-dot"></div>
                    </button>
                    
                    <!-- POS Button -->
                    <a href="{{ route('tenant.pos') }}" class="pos-btn flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all text-white shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:scale-105 active:scale-95">
                        <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span class="relative z-10 hidden sm:inline">Open POS</span>
                    </a>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-6">
                <!-- Success Alert -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-sm">Success!</p>
                            <p class="text-xs text-emerald-400/70 mt-0.5">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-400/50 hover:text-emerald-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
                
                <!-- Error Alert -->
                @if(session('error'))
                    <div class="alert alert-error">
                        <div class="w-8 h-8 rounded-xl bg-red-500/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-sm">Error!</p>
                            <p class="text-xs text-red-400/70 mt-0.5">{{ session('error') }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-400/50 hover:text-red-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="px-6 py-4 border-t border-white/[0.04] mt-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2">
                    <p class="text-[11px] text-gray-600">© {{ date('Y') }} SaaS POS — All rights reserved</p>
                    <p class="text-[11px] text-gray-700">Built with 💜 for modern businesses</p>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('flex');
            overlay.classList.toggle('active');
            
            // Add slide animation for mobile
            if (!sidebar.classList.contains('hidden')) {
                sidebar.style.transform = 'translateX(0)';
            }
        }

        // Auto-dismiss alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'all 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Add stagger animation to nav links
        document.querySelectorAll('.nav-link').forEach((link, i) => {
            link.style.animationDelay = `${i * 0.03}s`;
        });
    </script>

    @stack('scripts')
</body>
</html>