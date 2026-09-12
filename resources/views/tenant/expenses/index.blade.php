@extends('layouts.tenant')

@section('title', 'Expenses')
@section('page-title', 'Kharchay Ki Tracking')
@section('page-subtitle', 'Apne business ke kharchay track aur manage karein')

@section('content')
@php
    $tenant = auth()->user()->tenant;

    $thisWeekTotal = $thisWeekTotal ?? 0;
    $thisMonthTotal = $thisMonthTotal ?? 0;
    $totalAllTime = $totalAllTime ?? 0;

    $categoryBreakdown = collect($categoryBreakdown ?? []);
    $breakdownMax = max(1, (float) ($categoryBreakdown->max() ?? 1));

    $expenseCountOnPage = $expenses->count();

    // Preserve category filter while navigating pagination.
    $expenses->appends(request()->query());
@endphp

<div class="space-y-6">

    {{-- Page Intro --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.16em] text-till-400">
                Maali Tracking
            </p>

            <h2 class="mt-1 text-xl font-bold tracking-tight text-white sm:text-2xl">
                Business Ke Kharchay
            </h2>

            <p class="mt-2 max-w-2xl text-sm text-gray-500">
                Roz marra ke business kharchay record karein aur category ke hisab se monthly kharch dekhein.
            </p>
        </div>

        <button
            id="focusExpenseForm"
            type="button"
            class="inline-flex w-fit items-center gap-2 rounded-xl bg-till-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-till-500/20 transition hover:bg-till-500"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 5v14m7-7H5"/>
            </svg>
            Kharcha Add Karein
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        {{-- This Week --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6"/>
                    </svg>
                </div>

                <span class="rounded-full bg-till-500/10 px-2 py-1 text-[10px] font-bold text-till-400">
                    THIS WEEK
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-till-400 sm:text-2xl">
                {{ $tenant->formatMoney($thisWeekTotal, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Is hafte ke record kiye gaye kharchay
            </p>
        </article>

        {{-- This Month --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-amber-500/10 px-2 py-1 text-[10px] font-bold text-amber-400">
                    THIS MONTH
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-amber-400 sm:text-2xl">
                {{ $tenant->formatMoney($thisMonthTotal, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Is mahine ka kharch
            </p>
        </article>

        {{-- All Time --}}
        <article class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-red-500/10 px-2 py-1 text-[10px] font-bold text-red-400">
                    ALL TIME
                </span>
            </div>

            <p class="truncate text-xl font-black tracking-tight text-red-400 sm:text-2xl">
                {{ $tenant->formatMoney($totalAllTime, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Total record kiye gaye business kharchay
            </p>
        </article>
    </div>

    {{-- Monthly Category Breakdown --}}
    @if($categoryBreakdown->isNotEmpty())
        <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827]">
            <div class="flex flex-col gap-3 border-b border-white/[0.07] px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-white">
                            Is Mahine Ki Category Ke Hisab Se
                        </h3>

                        <span class="rounded-full bg-white/[0.05] px-2 py-1 text-[10px] font-bold text-gray-400">
                            {{ $categoryBreakdown->count() }} categories
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Dekhein aapka zyada kharch kahan ja raha hai.
                    </p>
                </div>

                <p class="text-sm font-bold text-amber-400">
                    {{ $tenant->formatMoney($thisMonthTotal, 0) }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-2 xl:grid-cols-4">
                @foreach($categoryBreakdown as $categoryKey => $total)
                    @php
                        $percentage = min(
                            100,
                            round(((float) $total / $breakdownMax) * 100)
                        );
                    @endphp

                    <div class="rounded-xl border border-white/[0.07] bg-white/[0.025] p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="truncate text-xs font-semibold capitalize text-gray-400">
                                    {{ $categories[$categoryKey] ?? $categoryKey }}
                                </p>

                                <p class="mt-2 truncate text-lg font-black text-white">
                                    {{ $tenant->formatMoney($total, 0) }}
                                </p>
                            </div>

                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-red-500/10 text-red-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-white/[0.06]">
                            <div
                                class="h-full rounded-full bg-red-500"
                                style="width: {{ $percentage }}%;"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Add Expense Form --}}
        <section class="h-fit overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] lg:sticky lg:top-24">

            <div class="border-b border-white/[0.07] px-5 py-5">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-white">Kharcha Add Karein</h3>
                        <p class="mt-1 text-xs text-gray-500">
                            Naya business kharcha record karein.
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

                <form
                    action="{{ route('tenant.expenses.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-4"
                >
                    @csrf

                    {{-- Title --}}
                    <div>
                        <label for="expenseTitle" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Kharche Ka Unwan <span class="text-red-400">*</span>
                        </label>

                        <input
                            id="expenseTitle"
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            required
                            placeholder="misaal ke tor par: Dukaan ka kiraya - January"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-red-500 @error('title') border-red-500 @enderror"
                        >

                        @error('title')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div>
                        <label for="expenseAmount" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Raqam ({{ $tenant->currency }}) <span class="text-red-400">*</span>
                        </label>

                        <input
                            id="expenseAmount"
                            type="number"
                            name="amount"
                            step="0.01"
                            min="0.01"
                            value="{{ old('amount') }}"
                            required
                            inputmode="decimal"
                            placeholder="0.00"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-red-500 @error('amount') border-red-500 @enderror"
                        >

                        @error('amount')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="expenseCategory" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Category <span class="text-red-400">*</span>
                        </label>

                        <select
                            id="expenseCategory"
                            name="category"
                            required
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none focus:border-red-500 @error('category') border-red-500 @enderror"
                        >
                            <option value="">Category select karein</option>

                            @foreach($categories as $key => $label)
                                <option
                                    value="{{ $key }}"
                                    {{ old('category') === $key ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error('category')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Date --}}
                    <div>
                        <label for="expenseDate" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Kharche Ki Tareekh <span class="text-red-400">*</span>
                        </label>

                        <input
                            id="expenseDate"
                            type="date"
                            name="expense_date"
                            required
                            max="{{ now()->format('Y-m-d') }}"
                            value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                            class="w-full rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none focus:border-red-500 @error('expense_date') border-red-500 @enderror"
                        >

                        @error('expense_date')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="expenseDescription" class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>Tafseel</span>
                            <span class="text-[10px] font-medium normal-case text-gray-600">Optional</span>
                        </label>

                        <textarea
                            id="expenseDescription"
                            name="description"
                            rows="3"
                            placeholder="Is kharche ke bare mein koi note likhein..."
                            class="w-full resize-none rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-red-500 @error('description') border-red-500 @enderror"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Receipt --}}
                    <div>
                        <label class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>Receipt</span>
                            <span class="text-[10px] font-medium normal-case text-gray-600">
                                Zaroori Nahi · Image ya PDF
                            </span>
                        </label>

                        <input
                            id="receiptInput"
                            type="file"
                            name="receipt"
                            accept="image/*,.pdf"
                            class="hidden"
                        >

                        <label
                            for="receiptInput"
                            class="flex cursor-pointer items-center gap-3 rounded-xl border border-dashed border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-gray-400 transition hover:border-red-500/50 hover:bg-white/[0.02]"
                        >
                            <svg class="h-5 w-5 flex-shrink-0 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.9A5 5 0 0116.9 6H17a4 4 0 010 8h-1m-4-5v9m0 0l-3-3m3 3l3-3"/>
                            </svg>

                            <span id="receiptFileName" class="truncate">
                                Receipt file upload karein
                            </span>
                        </label>

                        @error('receipt')
                            <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-red-500/15 transition hover:bg-red-500"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v14m7-7H5"/>
                        </svg>

                        Kharcha Add Karein
                    </button>
                </form>
            </div>
        </section>

        {{-- Expense List --}}
        <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827] lg:col-span-2">

            {{-- List Header --}}
            <div class="flex flex-col gap-4 border-b border-white/[0.07] p-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-base font-bold text-white">Sare Kharchay</h3>

                        <span class="rounded-full bg-white/[0.05] px-2.5 py-1 text-[10px] font-bold text-gray-400">
                            {{ $expenses->total() }} recorded
                        </span>
                    </div>

                    <p class="mt-1 text-xs text-gray-500">
                        Is page par <span id="visibleExpenseCount">{{ $expenseCountOnPage }}</span> kharchay dikha rahe hain.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    @if($expenseCountOnPage > 0)
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                            </svg>

                            <input
                                id="expenseSearch"
                                type="search"
                                placeholder="Kharcha search karein..."
                                class="w-full rounded-xl border border-white/[0.09] bg-[#0c1320] py-2.5 pl-10 pr-4 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 sm:w-56"
                            >
                        </div>
                    @endif

                    <form method="GET" class="flex items-center gap-2">
                        <select
                            name="category"
                            onchange="this.form.submit()"
                            class="rounded-xl border border-white/[0.09] bg-[#0c1320] px-3 py-2.5 text-sm text-gray-300 outline-none focus:border-till-500"
                        >
                            <option value="">Sari Categories</option>

                            @foreach($categories as $key => $label)
                                <option
                                    value="{{ $key }}"
                                    {{ request('category') === $key ? 'selected' : '' }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @if(request('category'))
                            <a
                                href="{{ route('tenant.expenses.index') }}"
                                class="rounded-lg px-2 py-2 text-xs font-semibold text-till-400 hover:text-till-300"
                            >
                                Saaf Karein
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- Expenses --}}
            <div id="expensesList" class="divide-y divide-white/[0.05]">
                @forelse($expenses as $expense)
                    @php
                        $expenseTitle = $expense->title ?? 'Bina Unwan Kharcha';
                        $expenseCategory = $categories[$expense->category] ?? $expense->category;
                        $expenseDate = $expense->expense_date
                            ? $expense->expense_date->format('d M Y')
                            : 'Tareekh nahi';

                        $recordedBy = optional($expense->user)->name ?? 'Nagumnaam user';

                        $searchText = strtolower(
                            $expenseTitle . ' ' .
                            $expenseCategory . ' ' .
                            ($expense->description ?? '') . ' ' .
                            $recordedBy
                        );
                    @endphp

                    <article
                        class="expense-row flex flex-col gap-4 px-5 py-4 transition hover:bg-white/[0.02] sm:flex-row sm:items-center sm:justify-between"
                        data-expense-row
                        data-search="{{ $searchText }}"
                    >
                        <div class="flex min-w-0 items-start gap-3">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-red-500/10 text-red-400">
                                <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="max-w-[250px] truncate text-sm font-bold text-white">
                                        {{ $expenseTitle }}
                                    </p>

                                    <span class="rounded-full bg-white/[0.05] px-2 py-1 text-[10px] font-semibold capitalize text-gray-400">
                                        {{ $expenseCategory }}
                                    </span>
                                </div>

                                @if($expense->description)
                                    <p class="mt-1 max-w-xl truncate text-xs text-gray-500">
                                        {{ $expense->description }}
                                    </p>
                                @endif

                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-gray-600">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $expenseDate }}
                                    </span>

                                    <span class="inline-flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 12c2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4 1.8 4 4 4zm-7 8c0-3.3 3.1-6 7-6s7 2.7 7 6"/>
                                        </svg>
                                        {{ $recordedBy }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 sm:flex-nowrap">
                            <div class="mr-2 text-left sm:text-right">
                                <p class="text-sm font-black text-red-400">
                                    {{ $tenant->formatMoney($expense->amount) }}
                                </p>

                                <p class="mt-1 text-[10px] text-gray-600">
                                    Kharche ki raqam
                                </p>
                            </div>

                            @if($expense->receipt)
                                <a
                                    href="{{ Storage::url($expense->receipt) }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-till-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-till-400 transition hover:bg-till-500/15 hover:text-till-300"
                                >
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Receipt
                                </a>
                            @endif

                            <button
                                type="button"
                                data-delete-expense
                                data-expense-title="{{ $expenseTitle }}"
                                data-delete-url="{{ route('tenant.expenses.destroy', $expense) }}"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-500/20 bg-red-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-red-400 transition hover:bg-red-500/15"
                            >
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Karein
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-20 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-red-500/10 text-red-400">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            <h3 class="text-sm font-bold text-white">Abhi tak koi kharcha record nahi</h3>

                            <p class="mt-2 text-xs leading-relaxed text-gray-500">
                                Bayen taraf form se apna pehla kharcha add karein.
                            </p>

                            <button
                                id="focusExpenseFormEmpty"
                                type="button"
                                class="mt-5 rounded-xl bg-red-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-red-500"
                            >
                                Pehla Kharcha Add Karein
                            </button>
                        </div>
                    </div>
                @endforelse

                {{-- Search Empty State --}}
                @if($expenseCountOnPage > 0)
                    <div id="noExpenseResults" class="hidden px-6 py-20 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center">
                            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>

                            <h3 class="text-sm font-bold text-white">Koi milta julta kharcha nahi mila</h3>

                            <p class="mt-2 text-xs text-gray-500">
                                Koi aur unwan, category, ya tafseel try karein.
                            </p>

                            <button
                                id="clearExpenseSearchEmpty"
                                type="button"
                                class="mt-5 rounded-xl border border-white/[0.10] bg-white/[0.03] px-4 py-2 text-xs font-semibold text-gray-300 hover:bg-white/[0.06]"
                            >
                                Search Saaf Karein
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Pagination --}}
            @if($expenses->hasPages())
                <div class="flex flex-col gap-3 border-t border-white/[0.07] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-gray-500">
                        <span class="font-semibold text-gray-300">{{ $expenses->firstItem() ?? 0 }}</span>
                        –
                        <span class="font-semibold text-gray-300">{{ $expenses->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-gray-300">{{ $expenses->total() }}</span>
                        kharchay dikha rahe hain
                    </p>

                    <div class="flex items-center gap-2">
                        @if($expenses->onFirstPage())
                            <span class="rounded-lg border border-white/[0.06] bg-white/[0.02] px-3 py-2 text-xs font-semibold text-gray-600">
                                Pichla
                            </span>
                        @else
                            <a
                                href="{{ $expenses->previousPageUrl() }}"
                                class="rounded-lg border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/[0.07] hover:text-white"
                            >
                                Pichla
                            </a>
                        @endif

                        <span class="px-2 text-xs text-gray-500">
                            Page {{ $expenses->currentPage() }} / {{ $expenses->lastPage() }}
                        </span>

                        @if($expenses->hasMorePages())
                            <a
                                href="{{ $expenses->nextPageUrl() }}"
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

{{-- Delete Expense Modal --}}
<div id="deleteExpenseModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">

    {{-- Backdrop --}}
    <button
        type="button"
        data-close-delete-modal
        class="absolute inset-0 cursor-default"
        aria-label="Delete modal band karein"
        style="background-color: rgba(2, 6, 23, 0.82); backdrop-filter: blur(5px);"
    ></button>

    {{-- Modal Panel --}}
    <div
        class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-gray-700 shadow-2xl"
        style="background-color: #111827 !important; color: #f8fafc !important;"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteExpenseModalTitle"
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
                    <h3 id="deleteExpenseModalTitle" class="text-base font-bold text-white">
                        Kharcha Delete Karein
                    </h3>

                    <p class="mt-1 text-xs text-gray-400">
                        <span id="deleteExpenseTitle" class="font-semibold text-white"></span>
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
                Ye kharche ka record aur uski receipt hamesha ke liye hatai jayegi.
                Ye action wapas nahi ho sakta.
            </div>

            <form id="deleteExpenseForm" method="POST" class="mt-6">
                @csrf
                @method('DELETE')

                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        data-close-delete-modal
                        class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700 hover:text-white"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-500"
                    >
                        Kharcha Delete Karein
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
    const expenseSearch = document.getElementById('expenseSearch');
    const visibleExpenseCount = document.getElementById('visibleExpenseCount');
    const noExpenseResults = document.getElementById('noExpenseResults');
    const clearExpenseSearchEmpty = document.getElementById('clearExpenseSearchEmpty');

    const expenseRows = Array.from(
        document.querySelectorAll('[data-expense-row]')
    );

    const receiptInput = document.getElementById('receiptInput');
    const receiptFileName = document.getElementById('receiptFileName');

    const deleteModal = document.getElementById('deleteExpenseModal');
    const deleteExpenseForm = document.getElementById('deleteExpenseForm');
    const deleteExpenseTitle = document.getElementById('deleteExpenseTitle');

    function filterExpenses() {
        if (!expenseSearch) {
            return;
        }

        const query = expenseSearch.value.trim().toLowerCase();
        let visible = 0;

        expenseRows.forEach(row => {
            const searchText = row.dataset.search || '';
            const matches = searchText.includes(query);

            row.classList.toggle('hidden', !matches);

            if (matches) {
                visible++;
            }
        });

        if (visibleExpenseCount) {
            visibleExpenseCount.textContent = visible;
        }

        if (noExpenseResults && expenseRows.length > 0) {
            noExpenseResults.classList.toggle('hidden', visible > 0);
        }
    }

    function clearExpenseSearch() {
        if (!expenseSearch) {
            return;
        }

        expenseSearch.value = '';
        filterExpenses();
        expenseSearch.focus();
    }

    expenseSearch?.addEventListener('input', filterExpenses);

    clearExpenseSearchEmpty?.addEventListener('click', clearExpenseSearch);

    receiptInput?.addEventListener('change', function () {
        if (!receiptFileName) {
            return;
        }

        if (this.files && this.files.length > 0) {
            receiptFileName.textContent = this.files[0].name;
        } else {
            receiptFileName.textContent = 'Receipt file upload karein';
        }
    });

    function focusExpenseForm() {
        const titleInput = document.getElementById('expenseTitle');

        titleInput?.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        setTimeout(() => titleInput?.focus(), 350);
    }

    document.getElementById('focusExpenseForm')?.addEventListener('click', focusExpenseForm);
    document.getElementById('focusExpenseFormEmpty')?.addEventListener('click', focusExpenseForm);

    function openDeleteModal(button) {
        if (!deleteModal) {
            return;
        }

        deleteExpenseTitle.textContent = button.dataset.expenseTitle || 'this expense';
        deleteExpenseForm.action = button.dataset.deleteUrl || '';

        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        if (!deleteModal) {
            return;
        }

        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    document.querySelectorAll('[data-delete-expense]').forEach(button => {
        button.addEventListener('click', function () {
            openDeleteModal(this);
        });
    });

    document.querySelectorAll('[data-close-delete-modal]').forEach(button => {
        button.addEventListener('click', closeDeleteModal);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });

    @if($errors->any())
        setTimeout(() => {
            document.getElementById('expenseTitle')?.focus();
        }, 100);
    @endif
})();
</script>
@endpush