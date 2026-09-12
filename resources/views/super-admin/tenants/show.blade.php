@extends('layouts.super-admin')

@section('page-title', $tenant->company_name)
@section('page-subtitle', 'Tenant ki detail aur management')

@section('content')
<div class="w-full">

    <!-- Back Button + Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8 animate-fade-in">
        <div class="flex items-center gap-4">
            <!-- Tenant Avatar -->
            <div class="relative">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-lg font-black text-white shadow-lg transition-transform hover:scale-105"
                     style="background: linear-gradient(135deg, {{ $tenant->is_active ? '#0E7A5C' : '#64748b' }}, {{ $tenant->is_active ? '#159C74' : '#94a3b8' }}); box-shadow: 0 8px 25px {{ $tenant->is_active ? 'rgba(14,122,92,0.3)' : 'rgba(100,116,139,0.2)' }};">
                    {{ strtoupper(substr($tenant->company_name, 0, 2)) }}
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 flex items-center justify-center {{ $tenant->is_active ? 'bg-emerald-400' : 'bg-red-400' }}" style="border-color: var(--bg-body);">
                    @if($tenant->is_active)
                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    @else
                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    @endif
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight" style="color: var(--text-heading);">{{ $tenant->company_name }}</h1>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="text-xs font-medium px-2.5 py-1 rounded-lg inline-flex items-center gap-1" style="background: var(--bg-glass); color: var(--text-secondary); border: 1px solid var(--border);">
                        <svg class="w-3 h-3" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        {{ $tenant->business_category ?? 'General' }}
                    </span>
                    <span class="text-xs" style="color: var(--text-muted);">•</span>
                    <span class="text-xs" style="color: var(--text-muted);">{{ $tenant->email }}</span>
                    <span class="text-xs" style="color: var(--text-muted);">•</span>
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
                </div>
            </div>
        </div>
        <a href="{{ route('super-admin.tenants.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Tenants Par Wapas Jayein
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Users -->
        <div class="stat-card animate-fade-in delay-1 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-sky-500/20 to-blue-500/10 flex items-center justify-center border border-sky-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black tracking-tight" style="color: var(--text-heading);">{{ $stats['total_users'] }}</p>
            <p class="text-xs mt-1 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-sky-400"></span>
                Total Users
            </p>
        </div>

        <!-- Products -->
        <div class="stat-card animate-fade-in delay-2 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-till-500/20 to-purple-500/10 flex items-center justify-center border border-till-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black tracking-tight" style="color: var(--text-heading);">{{ $stats['total_products'] }}</p>
            <p class="text-xs mt-1 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-till-400"></span>
                Saamaan
            </p>
        </div>

        <!-- Orders -->
        <div class="stat-card animate-fade-in delay-3 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-500/10 flex items-center justify-center border border-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black tracking-tight text-amber-400">{{ number_format($stats['total_orders']) }}</p>
            <p class="text-xs mt-1 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-amber-400"></span>
                Total Orders
            </p>
        </div>

        <!-- Revenue -->
        <div class="stat-card animate-fade-in delay-3 group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-500/10 flex items-center justify-center border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-emerald-400">PKR</span>
            </div>
            <p class="text-2xl lg:text-3xl font-black tracking-tight text-emerald-400">{{ number_format($stats['total_revenue'], 0) }}</p>
            <p class="text-xs mt-1 flex items-center gap-1" style="color: var(--text-muted);">
                <span class="w-1 h-1 rounded-full bg-emerald-400"></span>
                Total Revenue
            </p>
        </div>
    </div>

    <!-- Business Info + Actions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-fade-in delay-2">

        <!-- Business Info Card -->
        <div class="lg:col-span-2">
            <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border);">
                <!-- Card Header -->
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom: 1px solid var(--border);">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-till-500/20 to-purple-500/10 flex items-center justify-center border border-till-500/20">
                        <svg class="w-4 h-4 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold" style="color: var(--text-heading);">Business Ki Maloomat</h3>
                        <p class="text-[11px]" style="color: var(--text-muted);">Tenant account ki detail</p>
                    </div>
                </div>
                 <!-- Billing & Subscription Card -->
            <div class="rounded-2xl overflow-hidden mt-6" style="background: var(--bg-card); border: 1px solid var(--border);">
                <div class="px-6 py-4 flex items-center gap-3" style="border-bottom: 1px solid var(--border);">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/10 flex items-center justify-center border border-emerald-500/20">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold" style="color: var(--text-heading);">Billing Aur Subscription</h3>
                        <p class="text-[11px]" style="color: var(--text-muted);">Stripe subscription ki detail</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="rounded-xl p-4" style="background: var(--bg-glass); border: 1px solid var(--border);">
                            <p class="text-[11px] font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Subscription Ka Status</p>
                            @php
                                $billingColors = [
                                    'trialing' => 'background: rgba(59,130,246,0.12); color: #60a5fa;',
                                    'active'   => 'background: var(--success-bg); color: var(--success);',
                                    'past_due' => 'background: var(--danger-bg); color: var(--danger);',
                                    'canceled' => 'background: var(--bg-elevated); color: var(--text-muted);',
                                ];
                                $style = $billingColors[$tenant->subscription_status] ?? $billingColors['canceled'];
                            @endphp
                            <span class="text-[12px] px-2.5 py-1 rounded-full font-medium capitalize inline-block" style="{{ $style }}">
                                {{ str_replace('_', ' ', $tenant->subscription_status ?? 'N/A') }}
                            </span>
                        </div>
                        <div class="rounded-xl p-4" style="background: var(--bg-glass); border: 1px solid var(--border);">
                            <p class="text-[11px] font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Stripe Customer ID</p>
                            <code class="text-[11px]" style="color: var(--text-heading);">{{ $tenant->stripe_customer_id ?? '—' }}</code>
                        </div>
                        <div class="rounded-xl p-4" style="background: var(--bg-glass); border: 1px solid var(--border);">
                            <p class="text-[11px] font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Stripe Subscription ID</p>
                            <code class="text-[11px]" style="color: var(--text-heading);">{{ $tenant->stripe_subscription_id ?? '—' }}</code>
                        </div>
                    </div>

                    @if($tenant->stripe_customer_id)
                    <a href="https://dashboard.stripe.com/test/customers/{{ $tenant->stripe_customer_id }}" target="_blank"
                       class="inline-flex items-center gap-1.5 mt-5 text-sm font-medium" style="color: var(--accent-light);">
                        Stripe Dashboard Mein Dekhein →
                    </a>
                    @endif
                </div>
            </div>
                <!-- Info Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Slug -->
                        <div class="rounded-xl p-4 transition-colors" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                <p class="text-[11px] font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Slug</p>
                            </div>
                            <p class="text-[13px] font-semibold" style="color: var(--text-heading);">
                                <code class="px-2 py-0.5 rounded-lg text-[12px]" style="background: var(--bg-elevated); border: 1px solid var(--border);">{{ $tenant->slug }}</code>
                            </p>
                        </div>

                        <!-- Currency -->
                        <div class="rounded-xl p-4 transition-colors" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-[11px] font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Currency</p>
                            </div>
                            <p class="text-[13px] font-semibold" style="color: var(--text-heading);">{{ $tenant->currency ?? 'PKR' }}</p>
                        </div>

                        <!-- Plan -->
                        <div class="rounded-xl p-4 transition-colors" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <p class="text-[11px] font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Subscription Plan</p>
                            </div>
                            @if($tenant->subscription_plan)
                                <span class="badge badge-info text-[11px]">{{ $tenant->subscription_plan }}</span>
                            @else
                                <p class="text-[13px]" style="color: var(--text-muted);">Koi plan select nahi</p>
                            @endif
                        </div>

                        <!-- Trial Ends -->
                        <div class="rounded-xl p-4 transition-colors" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-[11px] font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Trial Kab Khatam Hoga</p>
                            </div>
                            @if($tenant->trial_ends_at)
                                <p class="text-[13px] font-semibold" style="color: var(--text-heading);">{{ $tenant->trial_ends_at->format('d M Y') }}</p>
                                <p class="text-[10px] mt-0.5" style="color: {{ $tenant->trial_ends_at->isPast() ? 'var(--danger)' : 'var(--text-muted)' }};">
                                    {{ $tenant->trial_ends_at->isPast() ? 'Khatam ho gaya ' : 'Khatam hoga ' }}{{ $tenant->trial_ends_at->diffForHumans() }}
                                </p>
                            @else
                                <p class="text-[13px]" style="color: var(--text-muted);">Koi trial period nahi</p>
                            @endif
                        </div>

                        <!-- Joined Date -->
                        <div class="rounded-xl p-4 transition-colors" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-[11px] font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Shamil Hone Ki Tareekh</p>
                            </div>
                            <p class="text-[13px] font-semibold" style="color: var(--text-heading);">{{ $tenant->created_at->format('d M Y') }}</p>
                            <p class="text-[10px] mt-0.5" style="color: var(--text-muted);">{{ $tenant->created_at->diffForHumans() }}</p>
                        </div>

                        <!-- Email -->
                        <div class="rounded-xl p-4 transition-colors" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-3.5 h-3.5" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <p class="text-[11px] font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Contact Email</p>
                            </div>
                            <p class="text-[13px] font-semibold truncate" style="color: var(--text-heading);">{{ $tenant->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Panel -->
        <div class="lg:col-span-1">
            <div class="rounded-2xl overflow-hidden sticky top-24" style="background: var(--bg-card); border: 1px solid var(--border);">
                <!-- Header -->
                <div class="px-6 py-4" style="border-bottom: 1px solid var(--border);">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber-500/20 to-orange-500/10 flex items-center justify-center border border-amber-500/20">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold" style="color: var(--text-heading);">Foran Ke Kaam</h3>
                            <p class="text-[11px]" style="color: var(--text-muted);">Is tenant ko manage karein</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="p-4 space-y-3">
                    <!-- Toggle Status -->
                    <form action="{{ route('super-admin.tenants.toggle-status', $tenant) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if($tenant->is_active)
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all cursor-pointer group" style="background: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.15); color: var(--danger);" onmouseover="this.style.background='rgba(239,68,68,0.12)';this.style.borderColor='rgba(239,68,68,0.3)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(239,68,68,0.06)';this.style.borderColor='rgba(239,68,68,0.15)';this.style.transform='translateY(0)'">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: rgba(239,68,68,0.1);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-[13px] font-semibold">Tenant Deactivate Karein</p>
                                <p class="text-[10px] opacity-70">Ye business suspend karein</p>
                            </div>
                        </button>
                        @else
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all cursor-pointer group" style="background: rgba(34,197,94,0.06); border: 1px solid rgba(34,197,94,0.15); color: var(--success);" onmouseover="this.style.background='rgba(34,197,94,0.12)';this.style.borderColor='rgba(34,197,94,0.3)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='rgba(34,197,94,0.06)';this.style.borderColor='rgba(34,197,94,0.15)';this.style.transform='translateY(0)'">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: rgba(34,197,94,0.1);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-[13px] font-semibold">Tenant Activate Karein</p>
                                <p class="text-[10px] opacity-70">Ye business enable karein</p>
                            </div>
                        </button>
                        @endif
                    </form>

                    <!-- View as Tenant -->
                    <a href="#" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all group" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.background='var(--accent-glow)';this.style.borderColor='var(--border-accent)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--bg-glass)';this.style.borderColor='var(--border)';this.style.transform='translateY(0)'">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: var(--accent-glow); border: 1px solid var(--border-accent);">
                            <svg class="w-4 h-4" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="text-[13px] font-semibold" style="color: var(--text-heading);">Dashboard Dekhein</p>
                            <p class="text-[10px]" style="color: var(--text-muted);">Tenant ka view dekhein</p>
                        </div>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <!-- Edit Tenant -->
                    <a href="{{ route('super-admin.tenants.edit', $tenant) }}" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all group" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.background='var(--accent-glow)';this.style.borderColor='var(--border-accent)';this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--bg-glass)';this.style.borderColor='var(--border)';this.style.transform='translateY(0)'">
    <div class="w-9 h-9 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: var(--accent-glow); border: 1px solid var(--border-accent);">
        <svg class="w-4 h-4" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
    </div>
    <div class="flex-1 text-left">
        <p class="text-[13px] font-semibold" style="color: var(--text-heading);">Detail Edit Karein</p>
        <p class="text-[10px]" style="color: var(--text-muted);">Tenant ki maloomat badlein</p>
    </div>
    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
</a>

                    <!-- Divider -->
                    <div class="py-1">
                        <div style="height: 1px; background: var(--border);"></div>
                    </div>

                    <!-- Delete -->
                    <form action="{{ route('super-admin.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('⚠️ KHATARNAK ZONE!\n\nYe hamesha ke liye delete kar dega:\n• {{ $tenant->company_name }}\n• Sare users ({{ $stats['total_users'] }})\n• Sara saamaan ({{ $stats['total_products'] }})\n• Sare orders ({{ $stats['total_orders'] }})\n\nYe action WAPAS nahi ho sakta.\n\nConfirm karne ke liye DELETE likhein.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all cursor-pointer group" style="background: rgba(239,68,68,0.04); border: 1px solid rgba(239,68,68,0.1); color: var(--danger);" onmouseover="this.style.background='rgba(239,68,68,0.1)';this.style.borderColor='rgba(239,68,68,0.25)'" onmouseout="this.style.background='rgba(239,68,68,0.04)';this.style.borderColor='rgba(239,68,68,0.1)'">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform" style="background: rgba(239,68,68,0.08);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-[13px] font-semibold">Hamesha Ke Liye Delete Karein</p>
                                <p class="text-[10px] opacity-60">Wapas nahi ho sakta</p>
                            </div>
                        </button>
                    </form>
                </div>

                <!-- Tenant ID Footer -->
                <div class="px-6 py-3" style="border-top: 1px solid var(--border);">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] font-semibold uppercase tracking-wider" style="color: var(--text-muted);">Tenant ID</p>
                        <code class="text-[11px] px-2 py-0.5 rounded-lg" style="background: var(--bg-elevated); border: 1px solid var(--border); color: var(--text-secondary);">#{{ $tenant->id }}</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection