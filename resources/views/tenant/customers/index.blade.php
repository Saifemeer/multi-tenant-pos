@extends('layouts.tenant')

@section('title', 'Customers')
@section('page-title', 'Customers')
@section('page-subtitle', 'Apne customers ka record aur credit balance manage karein')

@section('content')
@php
    $tenant = auth()->user()->tenant;

    $customerCount = $totalCustomers ?? $customers->total();
    $totalCustomerSpending = $totalCustomerSpending ?? 0;
    $totalCreditOutstanding = $totalCreditOutstanding ?? 0;

    $pageCustomerCount = $customers->count();
@endphp

<div class="space-y-6">

    {{-- Page Intro --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-till-400">
                Customer ka Intezaam
            </p>

            <h2 class="mt-1 text-xl font-bold tracking-tight text-white sm:text-2xl">
                Customer Directory
            </h2>

            <p class="mt-2 max-w-2xl text-sm text-gray-500">
                Customer ka record, loyalty points, purchase history, aur baqi credit organized rakhein.
            </p>
        </div>

        <div class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/[0.08] bg-white/[0.03] px-3 py-2 text-xs text-gray-400">
            <svg class="h-4 w-4 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"/>
            </svg>

            {{ number_format($customerCount) }} registered customers
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        {{-- Total Customers --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"/>
                    </svg>
                </div>

                <span class="rounded-full bg-till-500/10 px-2 py-1 text-[10px] font-bold text-till-400">
                    CUSTOMERS
                </span>
            </div>

            <p class="text-2xl font-black tracking-tight text-white">
                {{ number_format($customerCount) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Total registered customer profiles
            </p>
        </article>

        {{-- Total Spending --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                    SALES
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-emerald-400 sm:text-2xl">
                {{ $tenant->formatMoney($totalCustomerSpending, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Registered customers ki total kharch
            </p>
        </article>

        {{-- Credit Outstanding --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-amber-500/10 px-2 py-1 text-[10px] font-bold text-amber-400">
                    CREDIT DUE
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-amber-400 sm:text-2xl">
                {{ $tenant->formatMoney($totalCreditOutstanding, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Customers se aana wali baqi payment
            </p>
        </article>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Add Customer --}}
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
                        <h3 class="text-base font-bold text-white">Customer Add Karein</h3>
                        <p class="mt-1 text-xs text-gray-500">
                            Baar baar aane wale customers ke liye profile banayein.
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

                <form action="{{ route('tenant.customers.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label for="customerName" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Customer Ka Naam <span class="text-red-400">*</span>
                        </label>

                        <input
                            id="customerName"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            placeholder="misaal ke tor par: Ahmed Khan"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('name') border-red-500 @enderror"
                        >

                        @error('name')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="customerPhone" class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>Phone Number</span>
                            <span class="text-[10px] font-medium normal-case text-gray-600">Zaroori Nahi</span>
                        </label>

                        <input
                            id="customerPhone"
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            placeholder="+92 300 1234567"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('phone') border-red-500 @enderror"
                        >

                        @error('phone')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="customerEmail" class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>Email Address</span>
                            <span class="text-[10px] font-medium normal-case text-gray-600">Zaroori Nahi</span>
                        </label>

                        <input
                            id="customerEmail"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            placeholder="customer@email.com"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('email') border-red-500 @enderror"
                        >

                        @error('email')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="customerAddress" class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>Pata</span>
                            <span class="text-[10px] font-medium normal-case text-gray-600">Zaroori Nahi</span>
                        </label>

                        <textarea
                            id="customerAddress"
                            name="address"
                            rows="3"
                            autocomplete="street-address"
                            placeholder="Customer ka pata"
                            class="w-full resize-none rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('address') border-red-500 @enderror"
                        >{{ old('address') }}</textarea>

                        @error('address')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-till-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-till-500/20 transition hover:bg-till-500"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v14m7-7H5"/>
                        </svg>

                        Customer Add Karein
                    </button>
                </form>

                <div class="mt-5 flex items-start gap-3 rounded-xl border border-white/[0.07] bg-white/[0.025] p-3">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-till-500/10 text-till-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-white">Customers kyun add karein?</p>
                        <p class="mt-1 text-[11px] leading-relaxed text-gray-500">
                            Customer profile se loyalty points, credit sale, aur purchase tracking ho sakti hai.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Customer List --}}
        <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] lg:col-span-2">

            {{-- List Header --}}
            <div class="flex flex-col gap-4 border-b border-white/[0.07] p-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-white">Sare Customers</h3>

                        <span class="rounded-full bg-white/[0.05] px-2.5 py-1 text-[10px] font-bold text-gray-400">
                            {{ $customers->total() }} registered
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Is page par <span id="visibleCustomerCount">{{ $pageCustomerCount }}</span> customers dikha rahe hain.
                    </p>
                </div>

                @if($pageCustomerCount > 0)
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                            </svg>

                            <input
                                id="customerSearch"
                                type="search"
                                placeholder="Naam, phone ya email se search karein..."
                                class="w-full rounded-xl border border-white/[0.09] bg-[#0c1320] py-2.5 pl-10 pr-4 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 sm:w-60"
                            >
                        </div>

                        <select
                            id="creditFilter"
                            class="rounded-xl border border-white/[0.09] bg-[#0c1320] px-3 py-2.5 text-sm text-gray-300 outline-none focus:border-till-500"
                        >
                            <option value="all">Sare Customers</option>
                            <option value="with_credit">Credit Baqi</option>
                            <option value="no_credit">Koi Credit Nahi</option>
                        </select>

                        <button
                            id="clearCustomerFilters"
                            type="button"
                            class="hidden px-2 text-xs font-semibold text-till-400 hover:text-till-300"
                        >
                            Saaf Karein
                        </button>
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[950px] w-full">
                    <thead>
                        <tr class="border-b border-white/[0.07] bg-white/[0.015]">
                            <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                Customer
                            </th>

                            <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                Contact
                            </th>

                            <th class="px-4 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                Total Kharch
                            </th>

                            <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                Aamad
                            </th>

                            <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                Loyalty
                            </th>

                            <th class="px-4 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                Credit Baqi
                            </th>

                            <th class="w-36 px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody id="customersTableBody">
                        @forelse($customers as $customer)
                            @php
                                $creditBalance = (float) ($customer->credit_balance ?? 0);
                                $hasCredit = $creditBalance > 0;

                                $customerName = $customer->name ?? 'Nagumnaam Customer';
                                $customerPhone = $customer->phone ?? '';
                                $customerEmail = $customer->email ?? '';

                                $searchText = strtolower(
                                    $customerName . ' ' .
                                    $customerPhone . ' ' .
                                    $customerEmail
                                );
                            @endphp

                            <tr
                                class="customer-row border-b border-white/[0.05] transition hover:bg-white/[0.02]"
                                data-customer-row
                                data-search="{{ $searchText }}"
                                data-credit="{{ $hasCredit ? 'with_credit' : 'no_credit' }}"
                            >
                                {{-- Customer --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-till-500/15 text-xs font-bold text-till-300">
                                            {{ strtoupper(substr($customerName, 0, 2)) }}
                                        </div>

                                        <div class="min-w-0">
                                            <p class="max-w-[180px] truncate text-sm font-bold text-white">
                                                {{ $customerName }}
                                            </p>

                                            <p class="mt-1 max-w-[180px] truncate text-[11px] text-gray-500">
                                                {{ $customerEmail ?: 'Email nahi' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Contact --}}
                                <td class="px-4 py-4">
                                    @if($customerPhone)
                                        <div class="inline-flex items-center gap-2 text-sm text-gray-300">
                                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.3a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.21l-2.2 1.1a11 11 0 005.5 5.5l1.1-2.2a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.7.95V19a2 2 0 01-2 2h-1C9.4 21 3 14.6 3 6V5z"/>
                                            </svg>

                                            {{ $customerPhone }}
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-600">Phone nahi</span>
                                    @endif
                                </td>

                                {{-- Total Spent --}}
                                <td class="px-4 py-4 text-right">
                                    <p class="text-sm font-bold text-emerald-400">
                                        {{ $tenant->formatMoney($customer->total_spent ?? 0) }}
                                    </p>
                                </td>

                                {{-- Visits --}}
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center rounded-lg bg-white/[0.04] px-2.5 py-1.5 text-xs font-semibold text-gray-300">
                                        {{ number_format($customer->visit_count ?? 0) }}
                                    </span>
                                </td>

                                {{-- Loyalty --}}
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center gap-1 rounded-lg bg-amber-500/10 px-2.5 py-1.5 text-xs font-semibold text-amber-400">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11.05 2.93c.3-.92 1.6-.92 1.9 0l1.07 3.29a1 1 0 00.95.69h3.46c.97 0 1.37 1.24.59 1.81l-2.8 2.03a1 1 0 00-.36 1.12l1.07 3.29c.3.92-.76 1.69-1.54 1.12l-2.8-2.03a1 1 0 00-1.18 0l-2.8 2.03c-.78.57-1.84-.2-1.54-1.12l1.07-3.29a1 1 0 00-.36-1.12L3 8.72c-.78-.57-.38-1.81.59-1.81h3.46a1 1 0 00.95-.69l1.05-3.29z"/>
                                        </svg>

                                        {{ number_format($customer->loyalty_points ?? 0) }}
                                    </span>
                                </td>

                                {{-- Credit --}}
                                <td class="px-4 py-4 text-right">
                                    @if($hasCredit)
                                        <div>
                                            <p class="text-sm font-bold text-amber-400">
                                                {{ $tenant->formatMoney($creditBalance) }}
                                            </p>

                                            <p class="mt-1 text-[10px] text-amber-500/70">
                                                Baqi hai
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-600">Koi credit nahi</span>
                                    @endif
                                </td>

                                {{-- Action --}}
                                <td class="px-4 py-4 text-center">
                                    @if($hasCredit)
                                        <button
                                            type="button"
                                            data-payment-trigger
                                            data-customer-name="{{ $customerName }}"
                                            data-credit="{{ $creditBalance }}"
                                            data-payment-url="{{ url('/tenant/customers/' . $customer->id . '/record-payment') }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-emerald-400 transition hover:bg-emerald-500/15"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>

                                            Payment Record Karein
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-700">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="mx-auto flex max-w-sm flex-col items-center">
                                        <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0"/>
                                            </svg>
                                        </div>

                                        <h3 class="text-sm font-bold text-white">Abhi tak koi customer nahi</h3>

                                        <p class="mt-2 text-xs leading-relaxed text-gray-500">
                                            Bayen taraf form se apna pehla customer add karein.
                                        </p>

                                        <button
                                            id="focusCustomerForm"
                                            type="button"
                                            class="mt-5 rounded-xl bg-till-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-till-500"
                                        >
                                            Pehla Customer Add Karein
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        {{-- Search / Filter Empty State --}}
                        <tr id="noCustomerResults" class="hidden">
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>

                                    <h3 class="text-sm font-bold text-white">Koi milta julta customer nahi mila</h3>

                                    <p class="mt-2 text-xs text-gray-500">
                                        Koi aur search try karein ya credit filter badlein.
                                    </p>

                                    <button
                                        id="clearCustomerFiltersEmpty"
                                        type="button"
                                        class="mt-5 rounded-xl border border-white/[0.10] bg-white/[0.03] px-4 py-2 text-xs font-semibold text-gray-300 hover:bg-white/[0.06]"
                                    >
                                        Filters Saaf Karein
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($customers->hasPages())
                <div class="flex flex-col gap-3 border-t border-white/[0.07] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-gray-500">
                        <span class="font-semibold text-gray-300">{{ $customers->firstItem() ?? 0 }}</span>
                        –
                        <span class="font-semibold text-gray-300">{{ $customers->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-gray-300">{{ $customers->total() }}</span>
                        customers dikha rahe hain
                    </p>

                    <div class="flex items-center gap-2">
                        @if($customers->onFirstPage())
                            <span class="rounded-lg border border-white/[0.06] bg-white/[0.02] px-3 py-2 text-xs font-semibold text-gray-600">
                                Pichla
                            </span>
                        @else
                            <a
                                href="{{ $customers->previousPageUrl() }}"
                                class="rounded-lg border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/[0.07] hover:text-white"
                            >
                                Pichla
                            </a>
                        @endif

                        <span class="px-2 text-xs text-gray-500">
                            Page {{ $customers->currentPage() }} / {{ $customers->lastPage() }}
                        </span>

                        @if($customers->hasMorePages())
                            <a
                                href="{{ $customers->nextPageUrl() }}"
                                class="rounded-lg border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/[0.07] hover:text-white"
                            >
                                Agla
                            </a>
                        @else
                            <span class="rounded-lg border border-white/[0.06] bg-white/[0.02] px-3 py-2 text-xs font-semibold text-gray-600">
                                Agla
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </section>
    </div>
</div>

{{-- Payment Modal --}}
<div id="paymentModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">

    {{-- Backdrop --}}
    <button
        type="button"
        data-close-payment-modal
        class="absolute inset-0 cursor-default"
        aria-label="Payment modal band karein"
        style="background-color: rgba(2, 6, 23, 0.82); backdrop-filter: blur(5px);"
    ></button>

    {{-- Modal --}}
    <div
        class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-gray-700 shadow-2xl"
        style="background-color: #111827 !important; color: #f8fafc !important;"
        role="dialog"
        aria-modal="true"
        aria-labelledby="paymentModalTitle"
    >
        <div class="flex items-start justify-between gap-4 border-b border-gray-700 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div>
                    <h3 id="paymentModalTitle" class="text-base font-bold text-white">
                        Payment Record Karein
                    </h3>

                    <p class="mt-1 text-xs text-gray-400">
                        Customer:
                        <span id="modalCustomerName" class="font-semibold text-white"></span>
                    </p>
                </div>
            </div>

            <button
                type="button"
                data-close-payment-modal
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
            <div class="mb-5 rounded-xl border border-amber-500/20 bg-amber-500/10 p-3">
                <p class="text-xs font-semibold text-amber-300">
                    Baqi Credit
                </p>

                <p class="mt-1 text-xl font-black text-amber-400">
                    <span id="modalOutstanding"></span>
                </p>

                <p class="mt-1 text-[11px] text-amber-200/70">
                    Is customer se mili raqam darj karein.
                </p>
            </div>

            <form id="paymentForm" method="POST">
                @csrf

                <div>
                    <label for="paymentAmountInput" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                        Payment Ki Raqam
                    </label>

                    <input
                        id="paymentAmountInput"
                        type="number"
                        name="amount"
                        step="0.01"
                        min="0.01"
                        required
                        inputmode="decimal"
                        placeholder="0.00"
                        class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-emerald-500"
                    >

                    <p id="paymentValidationError" class="mt-2 hidden text-xs text-red-400"></p>
                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        data-close-payment-modal
                        class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700 hover:text-white"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-500"
                    >
                        Payment Confirm Karein
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
    const searchInput = document.getElementById('customerSearch');
    const creditFilter = document.getElementById('creditFilter');
    const clearFiltersButton = document.getElementById('clearCustomerFilters');
    const clearFiltersEmptyButton = document.getElementById('clearCustomerFiltersEmpty');

    const noResultsRow = document.getElementById('noCustomerResults');
    const visibleCount = document.getElementById('visibleCustomerCount');

    const customerRows = Array.from(document.querySelectorAll('[data-customer-row]'));

    const modal = document.getElementById('paymentModal');
    const paymentForm = document.getElementById('paymentForm');
    const paymentAmountInput = document.getElementById('paymentAmountInput');
    const modalCustomerName = document.getElementById('modalCustomerName');
    const modalOutstanding = document.getElementById('modalOutstanding');
    const paymentValidationError = document.getElementById('paymentValidationError');

    const currencySymbol = @json($tenant->currencySymbol());

    let currentOutstanding = 0;

    function formatMoney(amount) {
        return `${currencySymbol} ${Number(amount || 0).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`;
    }

    function applyCustomerFilters() {
        if (!searchInput || !creditFilter) {
            return;
        }

        const query = searchInput.value.trim().toLowerCase();
        const selectedCreditFilter = creditFilter.value;

        let visible = 0;

        customerRows.forEach(row => {
            const searchValue = row.dataset.search || '';
            const creditStatus = row.dataset.credit || '';

            const searchMatches = !query || searchValue.includes(query);

            const creditMatches =
                selectedCreditFilter === 'all' ||
                creditStatus === selectedCreditFilter;

            const shouldShow = searchMatches && creditMatches;

            row.hidden = !shouldShow;

            if (shouldShow) {
                visible++;
            }
        });

        if (visibleCount) {
            visibleCount.textContent = visible;
        }

        const filtersActive = query || selectedCreditFilter !== 'all';

        clearFiltersButton?.classList.toggle('hidden', !filtersActive);

        if (noResultsRow && customerRows.length > 0) {
            noResultsRow.classList.toggle('hidden', visible > 0);
        }
    }

    function clearCustomerFilters() {
        if (searchInput) {
            searchInput.value = '';
        }

        if (creditFilter) {
            creditFilter.value = 'all';
        }

        applyCustomerFilters();
        searchInput?.focus();
    }

    searchInput?.addEventListener('input', applyCustomerFilters);
    creditFilter?.addEventListener('change', applyCustomerFilters);

    clearFiltersButton?.addEventListener('click', clearCustomerFilters);
    clearFiltersEmptyButton?.addEventListener('click', clearCustomerFilters);

    document.getElementById('focusCustomerForm')?.addEventListener('click', function () {
        document.getElementById('customerName')?.focus();
    });

    function openPaymentModal(button) {
        if (!modal) {
            return;
        }

        const customerName = button.dataset.customerName || '';
        const outstanding = Number(button.dataset.credit || 0);
        const paymentUrl = button.dataset.paymentUrl || '';

        currentOutstanding = outstanding;

        modalCustomerName.textContent = customerName;
        modalOutstanding.textContent = formatMoney(outstanding);

        paymentForm.action = paymentUrl;

        paymentAmountInput.value = '';
        paymentAmountInput.max = outstanding;
        paymentAmountInput.placeholder = `Ziyada se ziyada ${formatMoney(outstanding)}`;

        paymentValidationError.classList.add('hidden');
        paymentValidationError.textContent = '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

        setTimeout(() => paymentAmountInput.focus(), 100);
    }

    function closePaymentModal() {
        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    document.querySelectorAll('[data-payment-trigger]').forEach(button => {
        button.addEventListener('click', function () {
            openPaymentModal(this);
        });
    });

    document.querySelectorAll('[data-close-payment-modal]').forEach(button => {
        button.addEventListener('click', closePaymentModal);
    });

    paymentAmountInput?.addEventListener('input', function () {
        const enteredAmount = Number(this.value || 0);

        if (enteredAmount > currentOutstanding) {
            paymentValidationError.textContent =
                `Payment ${formatMoney(currentOutstanding)} se zyada nahi ho sakti.`;

            paymentValidationError.classList.remove('hidden');
        } else {
            paymentValidationError.classList.add('hidden');
        }
    });

    paymentForm?.addEventListener('submit', function (event) {
        const enteredAmount = Number(paymentAmountInput.value || 0);

        if (enteredAmount <= 0) {
            event.preventDefault();

            paymentValidationError.textContent = 'Sahi payment raqam darj karein.';
            paymentValidationError.classList.remove('hidden');

            return;
        }

        if (enteredAmount > currentOutstanding) {
            event.preventDefault();

            paymentValidationError.textContent =
                `Payment ${formatMoney(currentOutstanding)} se zyada nahi ho sakti.`;

            paymentValidationError.classList.remove('hidden');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closePaymentModal();
        }
    });

    @if($errors->any())
        document.getElementById('customerName')?.focus();
    @endif
})();
</script>
@endpush