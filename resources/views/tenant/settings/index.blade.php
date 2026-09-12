@extends('layouts.tenant')

@section('title', 'Settings')
@section('page-title', 'Business Settings')
@section('page-subtitle', 'Apni store ki settings aur account manage karein')

@section('content')
@php
    $user = auth()->user();
    $tenant = $user->tenant;

    $planName = ucfirst($tenant->subscription_plan ?? 'Starter');
    $productLimit = $tenant->productLimit();
    $userLimit = $tenant->userLimit();
@endphp

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Page Intro --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-till-400">
                Workspace Ki Settings
            </p>

            <h2 class="mt-1 text-xl font-bold tracking-tight text-white sm:text-2xl">
                Business Settings
            </h2>

            <p class="mt-2 max-w-2xl text-sm text-gray-500">
                Apni business ki detail, currency, aur account ki maloomat update karein.
            </p>
        </div>

        <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/[0.08] bg-white/[0.03] px-3 py-2 text-xs text-gray-400">
            <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
            Workspace Active Hai
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-2xl border border-red-500/25 bg-red-500/10 p-4">
            <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-bold text-red-300">
                        Form ke fields check karein
                    </p>

                    <div class="mt-1 space-y-1 text-xs text-red-200/80">
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Workspace Overview --}}
    <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827]">
        <div class="flex flex-col gap-4 border-b border-white/[0.07] px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-base font-bold text-white">
                        {{ $tenant->company_name }}
                    </h3>

                    <p class="mt-1 text-xs text-gray-500">
                        Aapka SaaS POS business workspace
                    </p>
                </div>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-till-500/10 px-3 py-1.5 text-xs font-bold capitalize text-till-400">
                {{ $planName }} Plan
            </span>
        </div>

        <div class="grid grid-cols-2 divide-x divide-y divide-white/[0.06] sm:grid-cols-4 sm:divide-y-0">
            <div class="p-4">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-600">
                    Currency
                </p>

                <p class="mt-2 text-sm font-bold text-white">
                    {{ $tenant->currency }}
                </p>
            </div>

            <div class="p-4">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-600">
                    Saamaan Ki Had
                </p>

                <p class="mt-2 text-sm font-bold text-white">
                    {{ $productLimit === null ? 'Unlimited' : $productLimit }}
                </p>
            </div>

            <div class="p-4">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-600">
                    Staff Ki Had
                </p>

                <p class="mt-2 text-sm font-bold text-white">
                    {{ $userLimit === null ? 'Unlimited' : $userLimit }}
                </p>
            </div>

            <div class="p-4">
                <p class="text-[10px] font-bold uppercase tracking-wider text-gray-600">
                    Account Ka Role
                </p>

                <p class="mt-2 text-sm font-bold capitalize text-white">
                    {{ $user->role }}
                </p>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

        {{-- Business Information --}}
        <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] lg:col-span-3">
            <div class="border-b border-white/[0.07] px-5 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 9h.01M15 9h.01"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-white">
                            Business Ki Maloomat
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            Ye detail aapki store aur receipts par nazar aati hai.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('tenant.settings.update') }}" method="POST" class="p-5">
                @csrf
                @method('PUT')

                <div class="space-y-4">

                    {{-- Company Name --}}
                    <div>
                        <label for="company_name" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Business Ka Naam <span class="text-red-400">*</span>
                        </label>

                        <input
                            id="company_name"
                            type="text"
                            name="company_name"
                            required
                            value="{{ old('company_name', $tenant->company_name) }}"
                            placeholder="Apna business ka naam"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('company_name') border-red-500 @enderror"
                        >

                        @error('company_name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email and Phone --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="business_email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Business Ka Email
                            </label>

                            <input
                                id="business_email"
                                type="email"
                                name="email"
                                value="{{ old('email', $tenant->email) }}"
                                placeholder="business@email.com"
                                class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('email') border-red-500 @enderror"
                            >
                        </div>

                        <div>
                            <label for="business_phone" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Business Ka Phone
                            </label>

                            <input
                                id="business_phone"
                                type="text"
                                name="phone"
                                value="{{ old('phone', $tenant->phone) }}"
                                placeholder="+92 300 1234567"
                                class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('phone') border-red-500 @enderror"
                            >
                        </div>
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="business_address" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Business Ka Pata
                        </label>

                        <textarea
                            id="business_address"
                            name="address"
                            rows="3"
                            placeholder="Sarak, sheher, mulk"
                            class="w-full resize-none rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('address') border-red-500 @enderror"
                        >{{ old('address', $tenant->address) }}</textarea>

                        @error('address')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Currency --}}
                    <div>
                        <label for="currency" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Default Currency <span class="text-red-400">*</span>
                        </label>

                        <select
                            id="currency"
                            name="currency"
                            required
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none focus:border-till-500 @error('currency') border-red-500 @enderror"
                        >
                            <option value="PKR" {{ old('currency', $tenant->currency) === 'PKR' ? 'selected' : '' }}>
                                PKR — Pakistani Rupee
                            </option>

                            <option value="USD" {{ old('currency', $tenant->currency) === 'USD' ? 'selected' : '' }}>
                                USD — US Dollar
                            </option>

                            <option value="AED" {{ old('currency', $tenant->currency) === 'AED' ? 'selected' : '' }}>
                                AED — UAE Dirham
                            </option>
                        </select>

                        <p class="mt-1.5 text-[11px] text-gray-600">
                            Ye currency prices, sales, reports, aur receipts ke liye use hoti hai.
                        </p>

                        @error('currency')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 border-t border-white/[0.07] pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-gray-600">
                        Apni business ki detail update rakhein.
                    </p>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-till-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-till-500/20 transition hover:bg-till-500"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"/>
                        </svg>
                        Business Ki Detail Save Karein
                    </button>
                </div>
            </form>
        </section>

        {{-- Profile --}}
        <section class="h-fit overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] lg:col-span-2">
            <div class="border-b border-white/[0.07] px-5 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-till-600 text-sm font-bold text-white">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-white">
                            Aapka Profile
                        </h3>

                        <p class="mt-1 text-xs text-gray-500">
                            Account aur login ki detail.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('tenant.settings.profile') }}" method="POST" class="p-5">
                @csrf
                @method('PUT')

                <div class="space-y-4">

                    {{-- User Name --}}
                    <div>
                        <label for="profile_name" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Pura Naam <span class="text-red-400">*</span>
                        </label>

                        <input
                            id="profile_name"
                            type="text"
                            name="name"
                            required
                            value="{{ old('name', $user->name) }}"
                            autocomplete="name"
                            placeholder="Apna pura naam"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('name') border-red-500 @enderror"
                        >

                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- User Email --}}
                    <div>
                        <label for="profile_email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Email Address <span class="text-red-400">*</span>
                        </label>

                        <input
                            id="profile_email"
                            type="email"
                            name="email"
                            required
                            value="{{ old('email', $user->email) }}"
                            autocomplete="email"
                            placeholder="your@email.com"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('email') border-red-500 @enderror"
                        >

                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="border-t border-white/[0.07] pt-4">
                        <label for="profile_password" class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>Naya Password</span>
                            <span class="text-[10px] font-medium normal-case text-gray-600">
                                Zaroori Nahi
                            </span>
                        </label>

                        <div class="relative">
                            <input
                                id="profile_password"
                                type="password"
                                name="password"
                                minlength="8"
                                autocomplete="new-password"
                                placeholder="Password change nahi karna to khaali chhorein"
                                class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 pr-12 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('password') border-red-500 @enderror"
                            >

                            <button
                                id="togglePassword"
                                type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 transition hover:text-gray-300"
                                aria-label="Password dikhayein"
                            >
                                <svg id="eyeOpen" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6.3 0c-1.5 4-5.2 6.5-9.3 6.5S4.2 16 2.7 12C4.2 8 7.9 5.5 12 5.5S19.8 8 21.3 12z"/>
                                </svg>

                                <svg id="eyeClosed" class="hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18M10.6 10.6a2 2 0 002.8 2.8M9.9 5.1A10.7 10.7 0 0112 4.9c4.1 0 7.8 2.5 9.3 6.5a11 11 0 01-2.2 3.5M6.2 6.2C4.7 7.5 3.5 9.1 2.7 11.4c1.5 4 5.2 6.5 9.3 6.5 1.3 0 2.6-.3 3.7-.8"/>
                                </svg>
                            </button>
                        </div>

                        <p class="mt-1.5 text-[11px] text-gray-600">
                            Mehfooz password ke liye kam se kam 8 characters use karein.
                        </p>

                        @error('password')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 border-t border-white/[0.07] pt-5">
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-white/[0.10] bg-white/[0.04] px-4 py-2.5 text-sm font-bold text-gray-200 transition hover:bg-white/[0.08] hover:text-white"
                    >
                        <svg class="h-4 w-4 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"/>
                        </svg>
                        Profile Update Karein
                    </button>
                </div>
            </form>
        </section>
    </div>

    {{-- Danger Zone --}}
    <section class="overflow-hidden rounded-2xl border border-red-500/25 bg-[#111827]">
        <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-base font-bold text-red-400">
                        Khatarnak Zone
                    </h3>

                    <p class="mt-1 max-w-2xl text-xs leading-relaxed text-gray-500">
                        Apna business account hamesha ke liye delete karein — saamaan, sales records,
                        customers, kharchay, staff, aur baqi sara data bhi mit jayega.
                    </p>
                </div>
            </div>

            <button
                type="button"
                id="openDeleteModal"
                class="inline-flex w-fit items-center justify-center gap-2 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-2.5 text-sm font-bold text-red-400 transition hover:bg-red-500/20"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Business Delete Karein
            </button>
        </div>
    </section>
</div>

{{-- Delete Business Modal --}}
<div id="deleteBusinessModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">

    {{-- Overlay --}}
    <button
        type="button"
        data-close-delete-modal
        class="absolute inset-0 cursor-default"
        aria-label="Delete business modal band karein"
        style="background-color: rgba(2, 6, 23, 0.84); backdrop-filter: blur(5px);"
    ></button>

    {{-- Modal --}}
    <div
        class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-red-500/30 bg-[#111827] shadow-2xl"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteBusinessModalTitle"
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
                    <h3 id="deleteBusinessModalTitle" class="text-base font-bold text-white">
                        Business Account Delete Karein
                    </h3>

                    <p class="mt-1 text-xs text-red-300">
                        Ye action hamesha ke liye hai.
                    </p>
                </div>
            </div>

            <button
                type="button"
                data-close-delete-modal
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
                <strong class="text-red-100">{{ $tenant->company_name }}</strong>
                delete karne se store ka sara data hamesha ke liye mit jayega — saamaan, orders,
                customers, reports, staff accounts, aur kharchay.
            </div>

            <form id="deleteBusinessForm" action="{{ route('tenant.settings.destroy') }}" method="POST" class="mt-5">
                @csrf
                @method('DELETE')

                <label for="deleteConfirmation" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                    Confirm karne ke liye <span class="text-red-400">DELETE</span> likhein
                </label>

                <input
                    id="deleteConfirmation"
                    type="text"
                    autocomplete="off"
                    placeholder="DELETE likhein"
                    class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-red-500"
                >

                <p class="mt-2 text-[11px] text-gray-600">
                    Ye confirmation zaroori hai kyunke ye action wapas nahi ho sakta.
                </p>

                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        data-close-delete-modal
                        class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700 hover:text-white"
                    >
                        Cancel
                    </button>

                    <button
                        id="confirmDeleteButton"
                        type="submit"
                        disabled
                        class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition disabled:cursor-not-allowed disabled:opacity-40 enabled:hover:bg-red-500"
                    >
                        Hamesha Ke Liye Delete Karein
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
    const passwordInput = document.getElementById('profile_password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    const deleteModal = document.getElementById('deleteBusinessModal');
    const openDeleteModalButton = document.getElementById('openDeleteModal');
    const deleteConfirmation = document.getElementById('deleteConfirmation');
    const confirmDeleteButton = document.getElementById('confirmDeleteButton');

    togglePassword?.addEventListener('click', function () {
        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword ? 'text' : 'password';

        eyeOpen.classList.toggle('hidden', isPassword);
        eyeClosed.classList.toggle('hidden', !isPassword);

        togglePassword.setAttribute(
            'aria-label',
            isPassword ? 'Password chhupayein' : 'Password dikhayein'
        );
    });

    function openDeleteModal() {
        if (!deleteModal) {
            return;
        }

        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

        deleteConfirmation.value = '';
        confirmDeleteButton.disabled = true;

        setTimeout(() => deleteConfirmation.focus(), 100);
    }

    function closeDeleteModal() {
        if (!deleteModal) {
            return;
        }

        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    openDeleteModalButton?.addEventListener('click', openDeleteModal);

    document.querySelectorAll('[data-close-delete-modal]').forEach(button => {
        button.addEventListener('click', closeDeleteModal);
    });

    deleteConfirmation?.addEventListener('input', function () {
        confirmDeleteButton.disabled = this.value.trim() !== 'DELETE';
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    @if($errors->any())
        setTimeout(() => {
            document.getElementById('company_name')?.focus();
        }, 100);
    @endif
})();
</script>
@endpush