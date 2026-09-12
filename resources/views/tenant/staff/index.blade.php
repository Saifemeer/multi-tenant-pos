@extends('layouts.tenant')

@section('title', 'Staff')
@section('page-title', 'Staff Management')
@section('page-subtitle', 'Apni team aur unki access manage karein')

@section('content')
@php
    $tenant = auth()->user()->tenant;

    $canManageStaff = $tenant->canManageStaff();
    $staffCount = $staff->count();
    $userLimit = $tenant->userLimit();

    $hasUserLimit = $userLimit !== null;
    $staffLimitReached = $hasUserLimit && $staffCount >= $userLimit;

    $remainingSlots = $hasUserLimit
        ? max(0, $userLimit - $staffCount)
        : null;
@endphp

<div class="space-y-6">

    {{-- Page Intro --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-till-400">
                Team Ki Access
            </p>

            <h2 class="mt-1 text-xl font-bold tracking-tight text-white sm:text-2xl">
                Apna Staff Manage Karein
            </h2>

            <p class="mt-2 max-w-2xl text-sm text-gray-500">
                Managers aur cashiers add karein, access control karein, aur business ko mehfooz rakhein.
            </p>
        </div>

        <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/[0.08] bg-white/[0.03] px-3 py-2 text-xs text-gray-400">
            <svg class="h-4 w-4 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>

            {{ $staffCount }} team member
        </div>
    </div>

    {{-- Plan / Limit Warning --}}
    @if(!$canManageStaff)
        <div class="flex flex-col gap-4 rounded-2xl border border-amber-500/25 bg-amber-500/10 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-bold text-amber-300">
                        Staff management aapke current plan mein mojood nahi
                    </p>

                    <p class="mt-1 text-xs leading-relaxed text-amber-100/70">
                        Abhi aap use kar rahe hain
                        <span class="font-semibold capitalize text-amber-200">
                            {{ $tenant->subscription_plan }}
                        </span>
                        plan. Managers aur cashiers add karne ke liye Business ya Enterprise plan lein.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('tenant.settings.index') }}"
                class="inline-flex w-fit items-center justify-center gap-2 rounded-xl border border-amber-500/30 bg-amber-500/10 px-4 py-2.5 text-xs font-bold text-amber-300 transition hover:bg-amber-500/20"
            >
                Plan Ki Settings Dekhein
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @elseif($staffLimitReached)
        <div class="flex flex-col gap-4 rounded-2xl border border-red-500/25 bg-red-500/10 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-bold text-red-300">
                        Staff member ki had poori ho gayi
                    </p>

                    <p class="mt-1 text-xs leading-relaxed text-red-100/70">
                        Aapka plan zyada se zyada
                        <span class="font-semibold text-red-200">{{ $userLimit }}</span>
                        team member allow karta hai.
                        Koi inactive member remove karein ya plan upgrade karein.
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Team Stats --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        {{-- Total Staff --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"/>
                    </svg>
                </div>

                <span class="rounded-full bg-till-500/10 px-2 py-1 text-[10px] font-bold text-till-400">
                    TEAM
                </span>
            </div>

            <p class="text-2xl font-black tracking-tight text-white">
                {{ $staffCount }}
                @if($hasUserLimit)
                    <span class="text-base font-bold text-gray-600">/ {{ $userLimit }}</span>
                @endif
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Aapke workspace mein total users
            </p>
        </article>

        {{-- Active Staff --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                    ACTIVE
                </span>
            </div>

            <p class="text-2xl font-black tracking-tight text-emerald-400">
                {{ $staff->where('is_active', true)->count() }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Abhi access rakhne wale members
            </p>
        </article>

        {{-- Available Slots --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/15 text-violet-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 5v14m7-7H5"/>
                    </svg>
                </div>

                <span class="rounded-full bg-violet-500/10 px-2 py-1 text-[10px] font-bold text-violet-400">
                    SLOTS
                </span>
            </div>

            <p class="text-2xl font-black tracking-tight text-violet-400">
                {{ $hasUserLimit ? $remainingSlots : '∞' }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                {{ $hasUserLimit ? 'Team member ke khaali slots' : 'Is plan par koi staff had nahi' }}
            </p>
        </article>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Add Staff Form --}}
        <section class="h-fit overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] lg:sticky lg:top-24">

            <div class="border-b border-white/[0.07] px-5 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-white">Staff Member Add Karein</h3>
                        <p class="mt-1 text-xs text-gray-500">
                            Manager ya cashier invite karein.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-5">
                @if($errors->any())
                    <div class="mb-5 rounded-xl border border-red-500/25 bg-red-500/10 p-3 text-xs leading-relaxed text-red-200">
                        <p class="mb-1 font-bold text-red-300">
                            Ye errors theek karein:
                        </p>

                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if(!$canManageStaff)
                    <div class="rounded-xl border border-amber-500/20 bg-amber-500/10 p-4 text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                            </svg>
                        </div>

                        <p class="mt-3 text-sm font-bold text-amber-300">
                            Upgrade zaroori hai
                        </p>

                        <p class="mt-1 text-xs leading-relaxed text-amber-100/70">
                            Staff management sirf Business aur Enterprise plans par mojood hai.
                        </p>
                    </div>
                @elseif($staffLimitReached)
                    <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-center">
                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                            </svg>
                        </div>

                        <p class="mt-3 text-sm font-bold text-red-300">
                            Team ki had poori ho gayi
                        </p>

                        <p class="mt-1 text-xs leading-relaxed text-red-100/70">
                            Naya member add karne se pehle koi maujooda member remove karein.
                        </p>
                    </div>
                @else
                    <form action="{{ route('tenant.staff.store') }}" method="POST" class="space-y-4">
                        @csrf

                        {{-- Full Name --}}
                        <div>
                            <label for="staffName" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Pura Naam <span class="text-red-400">*</span>
                            </label>

                            <input
                                id="staffName"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                                placeholder="misaal ke tor par: Ali Hassan"
                                class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('name') border-red-500 @enderror"
                            >

                            @error('name')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="staffEmail" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Email Address <span class="text-red-400">*</span>
                            </label>

                            <input
                                id="staffEmail"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                placeholder="staff@email.com"
                                class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('email') border-red-500 @enderror"
                            >

                            @error('email')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="staffPassword" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Aarzi Password <span class="text-red-400">*</span>
                            </label>

                            <input
                                id="staffPassword"
                                type="password"
                                name="password"
                                required
                                minlength="8"
                                autocomplete="new-password"
                                placeholder="Kam se kam 8 characters"
                                class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('password') border-red-500 @enderror"
                            >

                            <p class="mt-1.5 text-[11px] text-gray-600">
                                Ye password staff member ko mehfooz tareeqe se dein.
                            </p>

                            @error('password')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div>
                            <label for="staffRole" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Access Ka Role <span class="text-red-400">*</span>
                            </label>

                            <select
                                id="staffRole"
                                name="role"
                                required
                                class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none focus:border-till-500 @error('role') border-red-500 @enderror"
                            >
                                <option value="cashier" {{ old('role', 'cashier') === 'cashier' ? 'selected' : '' }}>
                                    Cashier
                                </option>

                                <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>
                                    Manager
                                </option>
                            </select>

                            @error('role')
                                <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Role Description --}}
                        <div id="roleDescription" class="rounded-xl border border-white/[0.07] bg-white/[0.025] p-3">
                            <div class="flex items-start gap-2.5">
                                <div class="mt-0.5 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg bg-blue-500/10 text-blue-400">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p id="roleDescriptionTitle" class="text-xs font-bold text-white">
                                        Cashier Ki Access
                                    </p>

                                    <p id="roleDescriptionText" class="mt-1 text-[11px] leading-relaxed text-gray-500">
                                        POS counter use kar sakta hai aur customer sales kar sakta hai.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-till-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-till-500/20 transition hover:bg-till-500"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v14m7-7H5"/>
                            </svg>

                            Staff Member Add Karein
                        </button>
                    </form>
                @endif
            </div>
        </section>

        {{-- Team Members List --}}
        <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] lg:col-span-2">

            {{-- Header --}}
            <div class="flex flex-col gap-4 border-b border-white/[0.07] p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-white">Team Ke Members</h3>

                        <span class="rounded-full bg-white/[0.05] px-2.5 py-1 text-[10px] font-bold text-gray-400">
                            {{ $staffCount }}
                            @if($hasUserLimit)
                                / {{ $userLimit }}
                            @endif
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        <span id="visibleStaffCount">{{ $staffCount }}</span> team members dikha rahe hain.
                    </p>
                </div>

                @if($staffCount > 0)
                    <div class="relative w-full sm:w-60">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                        </svg>

                        <input
                            id="staffSearch"
                            type="search"
                            placeholder="Team members search karein..."
                            class="w-full rounded-xl border border-white/[0.09] bg-[#0c1320] py-2.5 pl-10 pr-4 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500"
                        >
                    </div>
                @endif
            </div>

            {{-- Staff Members --}}
            <div id="staffList" class="divide-y divide-white/[0.05]">
                @forelse($staff as $member)
                    @php
                        $memberName = $member->name ?? 'Nagumnaam User';
                        $memberEmail = $member->email ?? '';
                        $memberRole = $member->role ?? 'cashier';
                        $memberActive = (bool) $member->is_active;

                        $searchText = strtolower(
                            $memberName . ' ' .
                            $memberEmail . ' ' .
                            $memberRole . ' ' .
                            ($memberActive ? 'active' : 'inactive')
                        );
                    @endphp

                    <article
                        class="staff-row flex flex-col gap-4 px-5 py-4 transition hover:bg-white/[0.02] sm:flex-row sm:items-center sm:justify-between"
                        data-staff-row
                        data-search="{{ $searchText }}"
                    >
                        <div class="flex min-w-0 items-center gap-3">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full
                                {{ $memberRole === 'admin'
                                    ? 'bg-till-500/20 text-till-300'
                                    : ($memberRole === 'manager'
                                        ? 'bg-violet-500/15 text-violet-300'
                                        : 'bg-blue-500/15 text-blue-300') }}
                                text-xs font-bold"
                            >
                                {{ strtoupper(substr($memberName, 0, 2)) }}
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="max-w-[190px] truncate text-sm font-bold text-white">
                                        {{ $memberName }}

                                        @if($member->id === auth()->id())
                                            <span class="ml-1 text-[10px] font-semibold text-till-400">
                                                (Aap)
                                            </span>
                                        @endif
                                    </p>

                                    @if($memberRole === 'admin')
                                        <span class="rounded-full bg-till-500/15 px-2 py-1 text-[10px] font-bold text-till-400">
                                            ADMIN
                                        </span>
                                    @elseif($memberRole === 'manager')
                                        <span class="rounded-full bg-violet-500/15 px-2 py-1 text-[10px] font-bold text-violet-400">
                                            MANAGER
                                        </span>
                                    @else
                                        <span class="rounded-full bg-blue-500/15 px-2 py-1 text-[10px] font-bold text-blue-400">
                                            CASHIER
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-1 max-w-[250px] truncate text-xs text-gray-500">
                                    {{ $memberEmail }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 sm:justify-end">
                            {{-- Status --}}
                            @if($memberActive)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-emerald-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-red-400">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                    Inactive
                                </span>
                            @endif

                            {{-- Actions --}}
                            @if($memberRole !== 'admin' && $member->id !== auth()->id())
                                <form action="{{ route('tenant.staff.toggle-status', $member) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-lg border px-2.5 py-1.5 text-[11px] font-semibold transition
                                            {{ $memberActive
                                                ? 'border-red-500/20 bg-red-500/10 text-red-400 hover:bg-red-500/15'
                                                : 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/15' }}"
                                    >
                                        @if($memberActive)
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.36 18.36A9 9 0 005.64 5.64m12.72 12.72A9 9 0 015.64 5.64"/>
                                            </svg>
                                            Deactivate Karein
                                        @else
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Activate Karein
                                        @endif
                                    </button>
                                </form>

                                <button
                                    type="button"
                                    data-remove-staff
                                    data-member-name="{{ $memberName }}"
                                    data-remove-url="{{ route('tenant.staff.destroy', $member) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-white/[0.08] bg-white/[0.03] px-2.5 py-1.5 text-[11px] font-semibold text-gray-400 transition hover:border-red-500/30 hover:bg-red-500/10 hover:text-red-400"
                                >
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remove Karein
                                </button>
                            @elseif($memberRole === 'admin')
                                <span class="text-xs font-medium text-gray-600">
                                    Owner ka account
                                </span>
                            @else
                                <span class="text-xs font-medium text-gray-600">
                                    Yehi user
                                </span>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-20 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"/>
                                </svg>
                            </div>

                            <h3 class="text-sm font-bold text-white">
                                Koi team member nahi mila
                            </h3>

                            <p class="mt-2 text-xs leading-relaxed text-gray-500">
                                Sales aur business ke kaam mein madad ke liye staff add karein.
                            </p>
                        </div>
                    </div>
                @endforelse

                {{-- Search Empty State --}}
                @if($staffCount > 0)
                    <div id="noStaffResults" class="hidden px-6 py-20 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <h3 class="text-sm font-bold text-white">
                                Koi milta julta staff member nahi mila
                            </h3>

                            <p class="mt-2 text-xs text-gray-500">
                                Naam, email, ya role se search try karein.
                            </p>

                            <button
                                id="clearStaffSearch"
                                type="button"
                                class="mt-5 rounded-xl border border-white/[0.10] bg-white/[0.03] px-4 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/[0.06]"
                            >
                                Search Saaf Karein
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>

{{-- Remove Staff Modal --}}
<div id="removeStaffModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">

    {{-- Overlay --}}
    <button
        type="button"
        data-close-remove-modal
        class="absolute inset-0 cursor-default"
        aria-label="Remove staff modal band karein"
        style="background-color: rgba(2, 6, 23, 0.82); backdrop-filter: blur(5px);"
    ></button>

    {{-- Modal --}}
    <div
        class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-gray-700 shadow-2xl"
        style="background-color: #111827 !important; color: #f8fafc !important;"
        role="dialog"
        aria-modal="true"
        aria-labelledby="removeStaffModalTitle"
    >
        <div class="flex items-start justify-between gap-4 border-b border-gray-700 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>

                <div>
                    <h3 id="removeStaffModalTitle" class="text-base font-bold text-white">
                        Staff Member Remove Karein
                    </h3>

                    <p class="mt-1 text-xs text-gray-400">
                        Member:
                        <span id="removeStaffName" class="font-semibold text-white"></span>
                    </p>
                </div>
            </div>

            <button
                type="button"
                data-close-remove-modal
                class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-gray-400 transition hover:bg-gray-700 hover:text-white"
                aria-label="Modal band karein"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-3 text-xs leading-relaxed text-red-200">
                Ye team member aapke business workspace ki access khatam kar dega.
                Ye action wapas nahi ho sakta.
            </div>

            <form id="removeStaffForm" method="POST" class="mt-6">
                @csrf
                @method('DELETE')

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        data-close-remove-modal
                        class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700 hover:text-white"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-500"
                    >
                        Member Remove Karein
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const staffSearch = document.getElementById('staffSearch');
    const visibleStaffCount = document.getElementById('visibleStaffCount');
    const noStaffResults = document.getElementById('noStaffResults');
    const clearStaffSearch = document.getElementById('clearStaffSearch');

    const staffRows = Array.from(document.querySelectorAll('[data-staff-row]'));

    const roleSelect = document.getElementById('staffRole');
    const roleDescriptionTitle = document.getElementById('roleDescriptionTitle');
    const roleDescriptionText = document.getElementById('roleDescriptionText');

    const removeModal = document.getElementById('removeStaffModal');
    const removeStaffForm = document.getElementById('removeStaffForm');
    const removeStaffName = document.getElementById('removeStaffName');

    function filterStaff() {
        if (!staffSearch) {
            return;
        }

        const query = staffSearch.value.trim().toLowerCase();
        let visible = 0;

        staffRows.forEach(row => {
            const searchText = row.dataset.search || '';
            const matches = searchText.includes(query);

            row.classList.toggle('hidden', !matches);

            if (matches) {
                visible++;
            }
        });

        if (visibleStaffCount) {
            visibleStaffCount.textContent = visible;
        }

        if (noStaffResults && staffRows.length > 0) {
            noStaffResults.classList.toggle('hidden', visible > 0);
        }
    }

    function clearStaffFilter() {
        if (!staffSearch) {
            return;
        }

        staffSearch.value = '';
        filterStaff();
        staffSearch.focus();
    }

    function updateRoleDescription() {
        if (!roleSelect || !roleDescriptionTitle || !roleDescriptionText) {
            return;
        }

        if (roleSelect.value === 'manager') {
            roleDescriptionTitle.textContent = 'Manager Ki Access';
            roleDescriptionText.textContent =
                'Business management tools, reports, customers, orders, aur POS operations ki access.';
        } else {
            roleDescriptionTitle.textContent = 'Cashier Ki Access';
            roleDescriptionText.textContent =
                'Sirf POS counter use kar sakta hai aur customer sales kar sakta hai.';
        }
    }

    function openRemoveModal(button) {
        if (!removeModal) {
            return;
        }

        removeStaffName.textContent = button.dataset.memberName || '';
        removeStaffForm.action = button.dataset.removeUrl || '';

        removeModal.classList.remove('hidden');
        removeModal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }

    function closeRemoveModal() {
        if (!removeModal) {
            return;
        }

        removeModal.classList.add('hidden');
        removeModal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    staffSearch?.addEventListener('input', filterStaff);
    clearStaffSearch?.addEventListener('click', clearStaffFilter);

    roleSelect?.addEventListener('change', updateRoleDescription);
    updateRoleDescription();

    document.querySelectorAll('[data-remove-staff]').forEach(button => {
        button.addEventListener('click', function () {
            openRemoveModal(this);
        });
    });

    document.querySelectorAll('[data-close-remove-modal]').forEach(button => {
        button.addEventListener('click', closeRemoveModal);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeRemoveModal();
        }
    });

    @if($errors->any() && $canManageStaff && !$staffLimitReached)
        setTimeout(() => {
            document.getElementById('staffName')?.focus();
        }, 100);
    @endif
})();
</script>
@endpush