@extends('layouts.super-admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Platform ka jaiza aur analytics')

@section('content')
<div class="w-full">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-purple-500/10 flex items-center justify-center border border-indigo-500/20">
                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight" style="color: var(--text-heading);">Super Admin Dashboard</h1>
                <p class="text-sm mt-0.5" style="color: var(--text-muted);">Wapas khush aamdeed! Ye raha aapke platform ka jaiza.</p>
            </div>
        </div>
        <a href="{{ route('super-admin.tenants.index') }}" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3"/>
            </svg>
            Tenants Manage Karein
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">

        <!-- Total Tenants -->
        <div class="stat-card animate-fade-in delay-1 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-purple-500/10 flex items-center justify-center border border-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m16 0h-2M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8v-4a1 1 0 011-1h0a1 1 0 011 1v4"/>
                    </svg>
                </div>
                <span class="badge badge-info text-[10px]">All Time</span>
            </div>
            <p class="text-3xl font-black tracking-tight" style="color: var(--text-heading);">{{ $stats['total_tenants'] }}</p>
            <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                Total Tenants
            </p>
        </div>

        <!-- Active Tenants -->
        <div class="stat-card animate-fade-in delay-2 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-500/10 flex items-center justify-center border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                @if($stats['active_tenants'] > 0)
                <div class="flex items-center gap-1 text-emerald-400 text-xs font-semibold px-2 py-1 rounded-lg" style="background: var(--success-bg);">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    Live
                </div>
                @endif
            </div>
            <p class="text-3xl font-black tracking-tight text-emerald-400">{{ $stats['active_tenants'] }}</p>
            <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-emerald-400"></span>
                Active Tenants
            </p>
        </div>

        <!-- Inactive Tenants -->
        <div class="stat-card animate-fade-in delay-3 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500/20 to-rose-500/10 flex items-center justify-center border border-red-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                @if($stats['inactive_tenants'] > 0)
                <span class="badge badge-danger text-[10px]">Attention</span>
                @endif
            </div>
            <p class="text-3xl font-black tracking-tight" style="color: var(--danger);">{{ $stats['inactive_tenants'] }}</p>
            <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full" style="background: var(--danger);"></span>
                Inactive Tenants
            </p>
        </div>

        <!-- Total Users -->
        <div class="stat-card animate-fade-in delay-1 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-500/20 to-blue-500/10 flex items-center justify-center border border-sky-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="badge badge-info text-[10px]">Platform</span>
            </div>
            <p class="text-3xl font-black tracking-tight" style="color: var(--text-heading);">{{ $stats['total_users'] }}</p>
            <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-sky-400"></span>
                Total Users
            </p>
        </div>

        <!-- Total Orders -->
        <div class="stat-card animate-fade-in delay-2 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-500/10 flex items-center justify-center border border-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black tracking-tight text-amber-400">{{ number_format($stats['total_orders']) }}</p>
            <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-amber-400"></span>
                Total Orders (Platform)
            </p>
        </div>

        <!-- Total Revenue -->
        <div class="stat-card animate-fade-in delay-3 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500/20 to-purple-500/10 flex items-center justify-center border border-violet-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-violet-400">PKR</span>
            </div>
            <p class="text-2xl lg:text-3xl font-black tracking-tight text-violet-400">{{ number_format($stats['total_revenue'], 0) }}</p>
            <p class="text-xs mt-1.5 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-violet-400"></span>
                Total Revenue (Platform)
            </p>
        </div>
    </div>

    <!-- Billing Health -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-fade-in delay-1">
        <div class="stat-card">
            <p class="text-xs" style="color: var(--text-muted);">Trial Mein</p>
            <p class="text-2xl font-bold mt-1" style="color: #60a5fa;">{{ $billingStats['trialing'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs" style="color: var(--text-muted);">Active Subscriptions</p>
            <p class="text-2xl font-bold mt-1" style="color: var(--success);">{{ $billingStats['active'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs" style="color: var(--text-muted);">Payment Baqi</p>
            <p class="text-2xl font-bold mt-1" style="color: var(--danger);">{{ $billingStats['past_due'] }}</p>
        </div>
        <div class="stat-card">
            <p class="text-xs" style="color: var(--text-muted);">Cancel Ho Gaya</p>
            <p class="text-2xl font-bold mt-1" style="color: var(--text-muted);">{{ $billingStats['canceled'] }}</p>
        </div>
    </div>

    <!-- Plan Distribution -->
    <div class="rounded-2xl p-5 mb-8 animate-fade-in delay-2" style="background: var(--bg-card); border: 1px solid var(--border);">
        <h2 class="text-sm font-semibold mb-4" style="color: var(--text-heading);">Plan Ki Taqseem</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center">
                <p class="text-2xl font-bold" style="color: var(--text-secondary);">{{ $planStats['starter'] }}</p>
                <p class="text-xs mt-1" style="color: var(--text-muted);">Starter (Free)</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold" style="color: var(--accent-light);">{{ $planStats['business'] }}</p>
                <p class="text-xs mt-1" style="color: var(--text-muted);">Business</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-violet-400">{{ $planStats['enterprise'] }}</p>
                <p class="text-xs mt-1" style="color: var(--text-muted);">Enterprise</p>
            </div>
        </div>
    </div>

    <!-- Past Due — needs attention -->
    @if($pastDueTenants->count())
    <div class="rounded-2xl overflow-hidden mb-8 animate-fade-in delay-2" style="background: var(--danger-bg); border: 1px solid rgba(239,68,68,0.2);">
        <div class="px-6 py-4">
            <h2 class="text-sm font-semibold mb-3" style="color: var(--danger);">🚨 Payment Fail Ho Gaya — Tawajju Chahiye</h2>
            <ul class="space-y-2">
                @foreach($pastDueTenants as $t)
                    <li class="flex items-center justify-between text-sm">
                        <span style="color: var(--text-secondary);">{{ $t->company_name }} — {{ ucfirst($t->subscription_plan ?? 'N/A') }} plan</span>
                        <a href="{{ route('super-admin.tenants.show', $t) }}" class="font-medium" style="color: var(--danger);">Dekhein →</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Trials Expiring Warning -->
    @if($expiringTrials->count())
    <div class="animate-fade-in delay-2 mb-8">
        <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border);">
            <div class="px-6 py-4 flex items-center gap-3" style="border-bottom: 1px solid var(--border); background: rgba(245,158,11,0.04);">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.2);">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-bold" style="color: var(--text-heading);">Trials Jald Khatam Ho Rahe Hain</h3>
                    <p class="text-[11px]" style="color: var(--text-muted);">{{ $expiringTrials->count() }} tenant ka trial 3 din mein khatam ho raha hai</p>
                </div>
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-400"></span>
                </span>
            </div>
            <div class="p-4 space-y-2">
                @foreach($expiringTrials as $t)
                <div class="flex items-center justify-between px-4 py-3 rounded-xl transition-colors" style="background: var(--bg-glass);" onmouseover="this.style.background='var(--accent-glow)'" onmouseout="this.style.background='var(--bg-glass)'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold" style="color: var(--text-heading);">{{ $t->company_name }}</p>
                            <p class="text-[11px]" style="color: var(--text-muted);">Trial khatam hoga: {{ $t->trial_ends_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="badge text-[10px] py-0.5 px-2.5" style="background: rgba(245,158,11,0.1); color: #f59e0b; border: 1px solid rgba(245,158,11,0.2);">
                        <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $t->trial_ends_at->diffForHumans(['parts' => 1]) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions + Recent Tenants -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Quick Actions -->
        <div class="lg:col-span-1 animate-fade-in delay-2">
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border);">
                <div class="px-6 py-4" style="border-bottom: 1px solid var(--border);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500/20 to-purple-500/10 flex items-center justify-center border border-indigo-500/20">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold" style="color: var(--text-heading);">Foran Ke Kaam</h3>
                            <p class="text-[11px]" style="color: var(--text-muted);">Aam kaam</p>
                        </div>
                    </div>
                </div>
              <div class="p-4 space-y-2">
                    <a href="{{ route('super-admin.tenants.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group" style="background: var(--bg-glass);" onmouseover="this.style.background='var(--accent-glow)'" onmouseout="this.style.background='var(--bg-glass)'">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-semibold" style="color: var(--text-heading);">Sare Tenants Dekhein</p>
                            <p class="text-[11px]" style="color: var(--text-muted);">Accounts Manage Karein</p>
                        </div>
                        <svg class="w-4 h-4 flex-shrink-0 group-hover:translate-x-1 transition-transform" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('super-admin.tenants.index', ['billing_status' => 'past_due']) }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group" style="background: var(--bg-glass);" onmouseover="this.style.background='var(--accent-glow)'" onmouseout="this.style.background='var(--bg-glass)'">
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 border border-red-500/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-semibold" style="color: var(--text-heading);">Payment Baqi Wale Tenants</p>
                            <p class="text-[11px]" style="color: var(--text-muted);">Payment ke masail</p>
                        </div>
                        <svg class="w-4 h-4 flex-shrink-0 group-hover:translate-x-1 transition-transform" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Tenants -->
        <div class="lg:col-span-2 animate-fade-in delay-3">
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border);">
                <div class="px-6 py-4 flex items-center justify-between" style="border-bottom: 1px solid var(--border);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500/20 to-purple-500/10 flex items-center justify-center border border-violet-500/20">
                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold" style="color: var(--text-heading);">Abhi Register Hue</h3>
                            <p class="text-[11px]" style="color: var(--text-muted);">Naye tenant signups</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.tenants.index') }}" class="text-xs font-semibold transition-colors flex items-center gap-1" style="color: var(--accent-light);">
                        Sab Dekhein
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <th class="text-left px-6 py-3.5 text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Company</th>
                                <th class="text-left px-4 py-3.5 text-[11px] font-bold uppercase tracking-wider hidden sm:table-cell" style="color: var(--text-muted);">Category</th>
                                <th class="text-left px-4 py-3.5 text-[11px] font-bold uppercase tracking-wider hidden md:table-cell" style="color: var(--text-muted);">Shamil Hua</th>
                                <th class="text-center px-4 py-3.5 text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTenants as $tenant)
                            <tr class="table-row">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                                             style="background: linear-gradient(135deg, {{ $tenant->is_active ? '#6366f1' : '#64748b' }}, {{ $tenant->is_active ? '#8b5cf6' : '#94a3b8' }});">
                                            {{ strtoupper(substr($tenant->company_name, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-[13px] font-semibold truncate" style="color: var(--text-heading);">{{ $tenant->company_name }}</p>
                                            <p class="text-[11px] truncate" style="color: var(--text-muted);">{{ $tenant->email ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 hidden sm:table-cell">
                                    <span class="text-[12px] font-medium px-2.5 py-1 rounded-lg" style="background: var(--bg-glass); color: var(--text-secondary); border: 1px solid var(--border);">
                                        {{ $tenant->business_category ?? 'General' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 hidden md:table-cell">
                                    <p class="text-[12px]" style="color: var(--text-secondary);">{{ $tenant->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    @if($tenant->is_active)
                                        <span class="badge badge-success text-[10px]">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full mr-1 inline-block"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="badge badge-danger text-[10px]">
                                            <span class="w-1.5 h-1.5 rounded-full mr-1 inline-block" style="background: var(--danger);"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 rounded-3xl flex items-center justify-center" style="background: var(--accent-glow); border: 1px solid var(--border-accent);">
                                            <svg class="w-7 h-7" style="color: var(--accent-light); opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold" style="color: var(--text-heading);">Abhi tak koi tenant nahi</p>
                                            <p class="text-xs mt-1" style="color: var(--text-muted);">Nayi signups yahan nazar aayengi</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection