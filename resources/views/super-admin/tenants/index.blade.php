@extends('layouts.super-admin')

@section('page-title', 'Tenants Management')
@section('page-subtitle', 'Sare registered businesses manage karein')

@section('content')
<div class="w-full">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8 animate-fade-in">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-till-500/20 to-purple-500/10 flex items-center justify-center border border-till-500/20">
                <svg class="w-6 h-6 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3m16 0h-2M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8v-4a1 1 0 011-1h0a1 1 0 011 1v4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight" style="color: var(--text-heading);">Sare Tenants</h1>
                <p class="text-sm mt-0.5" style="color: var(--text-muted);">
                    {{ $tenants->total() }} businesses register hain
                </p>
            </div>
        </div>
        <a href="{{ route('super-admin.dashboard') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Dashboard Par Wapas Jayein
        </a>
    </div>

    <!-- Filters -->
    <div class="animate-fade-in delay-1 mb-6">
        <form method="GET" class="rounded-2xl p-4 flex flex-col sm:flex-row gap-3 flex-wrap" style="background: var(--bg-card); border: 1px solid var(--border);">
            <!-- Search -->
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Company ke naam se search karein..."
                       class="input-modern pl-11 py-3 text-[13px]"
                       style="padding-left: 44px;">
            </div>

            <!-- Status Filter -->
            <div class="relative sm:w-40">
                <select name="status" class="input-modern py-3 text-[13px] appearance-none pr-10 cursor-pointer"
                        style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%230E7A5C' d='M6 9L1 4h10z'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 16px center;">
                    <option value="">Sara Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Billing Status Filter -->
            <div class="relative sm:w-44">
                <select name="billing_status" class="input-modern py-3 text-[13px] appearance-none pr-10 cursor-pointer"
                        style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%230E7A5C' d='M6 9L1 4h10z'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 16px center;">
                    <option value="">Sara Billing Status</option>
                    <option value="trialing" {{ request('billing_status') === 'trialing' ? 'selected' : '' }}>Trial Mein</option>
                    <option value="active" {{ request('billing_status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="past_due" {{ request('billing_status') === 'past_due' ? 'selected' : '' }}>Payment Baqi</option>
                    <option value="canceled" {{ request('billing_status') === 'canceled' ? 'selected' : '' }}>Cancel</option>
                </select>
            </div>

            <!-- Plan Filter -->
            <div class="relative sm:w-40">
                <select name="plan" class="input-modern py-3 text-[13px] appearance-none pr-10 cursor-pointer"
                        style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%230E7A5C' d='M6 9L1 4h10z'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 16px center;">
                    <option value="">Sare Plans</option>
                    <option value="starter" {{ request('plan') === 'starter' ? 'selected' : '' }}>Starter</option>
                    <option value="business" {{ request('plan') === 'business' ? 'selected' : '' }}>Business</option>
                    <option value="enterprise" {{ request('plan') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                </select>
            </div>

            <!-- Filter Button -->
            <button type="submit" class="btn-primary !px-6 !py-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter Karein
            </button>

            <!-- Reset -->
            @if(request('search') || request('status') || request('billing_status') || request('plan'))
            <a href="{{ route('super-admin.tenants.index') }}" class="btn-secondary !px-4 !py-3 text-[13px]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Saaf Karein
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="animate-fade-in delay-2">
        <div class="rounded-2xl overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border);">
            
            <!-- Table Header Info -->
            <div class="px-6 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom: 1px solid var(--border);">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500/20 to-purple-500/10 flex items-center justify-center border border-violet-500/20">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold" style="color: var(--text-heading);">Tenants Ki List</h3>
                        <p class="text-[11px]" style="color: var(--text-muted);">
                            {{ $tenants->firstItem() ?? 0 }}–{{ $tenants->lastItem() ?? 0 }} / {{ $tenants->total() }} dikha rahe hain
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="badge badge-success text-[10px]">{{ $activeCount }} Active</span>
                    <span class="badge badge-danger text-[10px]">{{ $inactiveCount }} Inactive</span>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <th class="text-left px-6 py-4 text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Company</th>
                            <th class="text-left px-4 py-4 text-[11px] font-bold uppercase tracking-wider hidden sm:table-cell" style="color: var(--text-muted);">Category</th>
                            <th class="text-center px-4 py-4 text-[11px] font-bold uppercase tracking-wider hidden md:table-cell" style="color: var(--text-muted);">Users</th>
                            <th class="text-left px-4 py-4 text-[11px] font-bold uppercase tracking-wider hidden lg:table-cell" style="color: var(--text-muted);">Plan</th>
                            <th class="text-left px-4 py-4 text-[11px] font-bold uppercase tracking-wider hidden lg:table-cell" style="color: var(--text-muted);">Billing</th>
                            <th class="text-center px-4 py-4 text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Status</th>
                            <th class="text-left px-4 py-4 text-[11px] font-bold uppercase tracking-wider hidden lg:table-cell" style="color: var(--text-muted);">Shamil Hua</th>
                            <th class="text-center px-4 py-4 text-[11px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                        <tr class="table-row group">
                            <!-- Company -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xs font-bold text-white flex-shrink-0 transition-transform group-hover:scale-105"
                                         style="background: linear-gradient(135deg, {{ $tenant->is_active ? '#0E7A5C' : '#64748b' }}, {{ $tenant->is_active ? '#159C74' : '#94a3b8' }});">
                                        {{ strtoupper(substr($tenant->company_name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[13px] font-semibold truncate" style="color: var(--text-heading);">{{ $tenant->company_name }}</p>
                                        <p class="text-[11px] truncate" style="color: var(--text-muted);">ID: #{{ $tenant->id }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="px-4 py-4 hidden sm:table-cell">
                                <span class="text-[12px] font-medium px-2.5 py-1.5 rounded-lg inline-flex items-center gap-1" style="background: var(--bg-glass); color: var(--text-secondary); border: 1px solid var(--border);">
                                    <svg class="w-3 h-3" style="color: var(--accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    {{ $tenant->business_category ?? 'General' }}
                                </span>
                            </td>

                            <!-- Users Count -->
                            <td class="px-4 py-4 text-center hidden md:table-cell">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl" style="background: var(--bg-glass); border: 1px solid var(--border);">
                                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-[12px] font-bold" style="color: var(--text-heading);">{{ $tenant->users_count }}</span>
                                </div>
                            </td>

                            <!-- Plan -->
                            <td class="px-4 py-4 hidden lg:table-cell">
                                @if($tenant->subscription_plan)
                                <span class="badge badge-info text-[10px] capitalize">{{ $tenant->subscription_plan }}</span>
                                @else
                                <span class="text-[12px]" style="color: var(--text-muted);">—</span>
                                @endif
                            </td>

                            <!-- Billing Status -->
                            <td class="px-4 py-4 hidden lg:table-cell">
                                @php
                                    $billingColors = [
                                        'trialing' => 'background: rgba(59,130,246,0.12); color: #60a5fa; border: 1px solid rgba(59,130,246,0.25);',
                                        'active'   => 'background: var(--success-bg); color: var(--success); border: 1px solid rgba(34,197,94,0.2);',
                                        'past_due' => 'background: var(--danger-bg); color: var(--danger); border: 1px solid rgba(239,68,68,0.2);',
                                        'canceled' => 'background: var(--bg-glass); color: var(--text-muted); border: 1px solid var(--border);',
                                    ];
                                    $style = $billingColors[$tenant->subscription_status] ?? $billingColors['canceled'];
                                @endphp
                                <span class="text-[11px] px-2 py-1 rounded-full font-medium capitalize" style="{{ $style }}">
                                    {{ str_replace('_', ' ', $tenant->subscription_status ?? 'N/A') }}
                                </span>
                            </td>

                            <!-- Status -->
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

                            <!-- Joined -->
                            <td class="px-4 py-4 hidden lg:table-cell">
                                <div>
                                    <p class="text-[12px] font-medium" style="color: var(--text-secondary);">{{ $tenant->created_at->format('d M Y') }}</p>
                                    <p class="text-[10px]" style="color: var(--text-muted);">{{ $tenant->created_at->diffForHumans() }}</p>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-4 text-center">
                                <div class="relative inline-block">
                                    <button onclick="toggleActions(this)" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:scale-105 cursor-pointer" style="background: var(--bg-glass); border: 1px solid var(--border);">
                                        <svg class="w-4 h-4" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Dropdown -->
                                    <div class="action-dropdown hidden absolute right-0 top-full mt-2 w-48 rounded-xl shadow-2xl z-30 overflow-hidden" style="background: var(--bg-card); border: 1px solid var(--border); box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                                        
                                        <!-- View -->
                                        <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="flex items-center gap-3 px-4 py-3 text-[12px] font-medium transition-colors" style="color: var(--text-secondary); border-bottom: 1px solid var(--border);" onmouseover="this.style.background='var(--accent-glow)';this.style.color='var(--text-heading)'" onmouseout="this.style.background='transparent';this.style.color='var(--text-secondary)'">
                                            <svg class="w-4 h-4 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail Dekhein
                                        </a>
                                        
                                        <!-- Toggle Status -->
                                        <form action="{{ route('super-admin.tenants.toggle-status', $tenant) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-[12px] font-medium transition-colors cursor-pointer" style="color: var(--text-secondary); border-bottom: 1px solid var(--border);" onmouseover="this.style.background='var(--accent-glow)';this.style.color='var(--text-heading)'" onmouseout="this.style.background='transparent';this.style.color='var(--text-secondary)'">
                                                @if($tenant->is_active)
                                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                Deactivate Karein
                                                @else
                                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Activate Karein
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <!-- Delete -->
                                        <form action="{{ route('super-admin.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('⚠️ Kya aap pakka hain?\n\nYe tenant aur uska SARA data hamesha ke liye delete kar dega, jaise ke:\n• Users\n• Saamaan\n• Orders\n• Settings\n\nAgar unki active Stripe subscription hai, wo bhi cancel ho jayegi.\n\nYe action wapas nahi ho sakta.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-[12px] font-medium transition-colors cursor-pointer" style="color: var(--danger);" onmouseover="this.style.background='var(--danger-bg)'" onmouseout="this.style.background='transparent'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hamesha Ke Liye Delete Karein
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-20 text-center">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 rounded-3xl flex items-center justify-center" style="background: var(--accent-glow); border: 1px solid var(--border-accent);">
                                        <svg class="w-9 h-9" style="color: var(--accent-light); opacity: 0.4;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21H3"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold" style="color: var(--text-heading);">Koi tenant nahi mila</p>
                                        <p class="text-xs mt-1.5 max-w-[250px] mx-auto leading-relaxed" style="color: var(--text-muted);">
                                            @if(request('search') || request('status') || request('billing_status') || request('plan'))
                                                Apni search ya filters change karke try karein
                                            @else
                                                Naye tenant signups yahan nazar aayenge
                                            @endif
                                        </p>
                                    </div>
                                    @if(request('search') || request('status') || request('billing_status') || request('plan'))
                                    <a href="{{ route('super-admin.tenants.index') }}" class="btn-secondary text-[12px] !px-4 !py-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Filters Saaf Karein
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer / Pagination -->
            @if($tenants->hasPages())
            <div class="px-6 py-4" style="border-top: 1px solid var(--border);">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-[12px]" style="color: var(--text-muted);">
                        <span class="font-semibold" style="color: var(--text-heading);">{{ $tenants->firstItem() }}</span> se 
                        <span class="font-semibold" style="color: var(--text-heading);">{{ $tenants->lastItem() }}</span> / 
                        <span class="font-semibold" style="color: var(--text-heading);">{{ $tenants->total() }}</span> tenants
                    </p>
                    <div class="flex items-center gap-2">
                        {{-- Previous --}}
                        @if($tenants->onFirstPage())
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center opacity-30 cursor-not-allowed" style="background: var(--bg-glass); border: 1px solid var(--border);">
                            <svg class="w-4 h-4" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </span>
                        @else
                        <a href="{{ $tenants->previousPageUrl() }}" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:scale-105" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)';this.style.background='var(--accent-glow)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--bg-glass)'">
                            <svg class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach($tenants->getUrlRange(max(1, $tenants->currentPage()-2), min($tenants->lastPage(), $tenants->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="w-9 h-9 rounded-xl flex items-center justify-center text-[12px] font-bold transition-all hover:scale-105"
                            style="{{ $page == $tenants->currentPage() 
                                ? 'background: linear-gradient(135deg, #0E7A5C, #159C74); color: white; box-shadow: 0 4px 15px rgba(14,122,92,0.3);' 
                                : 'background: var(--bg-glass); border: 1px solid var(--border); color: var(--text-secondary);' }}"
                            @if($page != $tenants->currentPage())
                            onmouseover="this.style.borderColor='var(--border-accent)';this.style.background='var(--accent-glow)'"
                            onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--bg-glass)'"
                            @endif>
                            {{ $page }}
                        </a>
                        @endforeach

                        {{-- Next --}}
                        @if($tenants->hasMorePages())
                        <a href="{{ $tenants->nextPageUrl() }}" class="w-9 h-9 rounded-xl flex items-center justify-center transition-all hover:scale-105" style="background: var(--bg-glass); border: 1px solid var(--border);" onmouseover="this.style.borderColor='var(--border-accent)';this.style.background='var(--accent-glow)'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--bg-glass)'">
                            <svg class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @else
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center opacity-30 cursor-not-allowed" style="background: var(--bg-glass); border: 1px solid var(--border);">
                            <svg class="w-4 h-4" style="color: var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Action Dropdown Toggle
    function toggleActions(btn) {
        document.querySelectorAll('.action-dropdown').forEach(d => {
            if (d !== btn.nextElementSibling) {
                d.classList.add('hidden');
            }
        });
        const dropdown = btn.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.action-dropdown').forEach(d => {
                d.classList.add('hidden');
            });
        }
    });
</script>
@endpush