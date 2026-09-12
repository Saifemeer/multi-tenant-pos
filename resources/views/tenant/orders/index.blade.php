@extends('layouts.tenant')

@section('title', 'Orders')
@section('page-title', 'Orders Ki History')
@section('page-subtitle', 'Mukammal ho chuki sales dekhein aur manage karein')

@section('content')
@php
    $tenant = auth()->user()->tenant;

    $todaySales = $todaySales ?? 0;
    $todayOrders = $todayOrders ?? 0;
    $monthSales = $monthSales ?? 0;
    $monthOrders = $monthOrders ?? 0;
    $totalOrders = $totalOrders ?? 0;
    $avgOrder = $avgOrder ?? 0;
@endphp

<div class="space-y-6">

    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                    TODAY
                </span>
            </div>

            <p class="truncate text-xl font-black text-emerald-400 sm:text-2xl">
                {{ $tenant->formatMoney($todaySales, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                aaj {{ $todayOrders }} order
            </p>
        </div>

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 19V5m0 14h16M8 16v-4m4 4V8m4 8v-6"/>
                    </svg>
                </div>

                <span class="rounded-full bg-till-500/10 px-2 py-1 text-[10px] font-bold text-till-400">
                    MONTH
                </span>
            </div>

            <p class="truncate text-xl font-black text-till-400 sm:text-2xl">
                {{ $tenant->formatMoney($monthSales, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                is mahine {{ $monthOrders }} order
            </p>
        </div>

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-500/15 text-sky-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>

                <span class="rounded-full bg-sky-500/10 px-2 py-1 text-[10px] font-bold text-sky-400">
                    ALL TIME
                </span>
            </div>

            <p class="text-2xl font-black text-white">
                {{ number_format($totalOrders) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Total mukammal ki gayi sales
            </p>
        </div>

        <div class="rounded-2xl border border-white/[0.08] bg-[#111827] p-5">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-amber-500/10 px-2 py-1 text-[10px] font-bold text-amber-400">
                    AVERAGE
                </span>
            </div>

            <p class="truncate text-xl font-black text-amber-400 sm:text-2xl">
                {{ $tenant->formatMoney($avgOrder, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Har order ki average qeemat
            </p>
        </div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#111827]">

        <div class="flex flex-col gap-4 border-b border-white/[0.07] p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-white">Halia Orders</h2>

                    <span class="rounded-full bg-white/[0.05] px-2.5 py-1 text-[10px] font-bold text-gray-400">
                        {{ $orders->total() }} total
                    </span>
                </div>

                <p class="mt-1 text-xs text-gray-500">
                    Is page par <span id="visibleOrderCount">{{ $orders->count() }}</span> orders dikha rahe hain.
                </p>
            </div>

            @if($orders->count() > 0)
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                        </svg>

                        <input
                            id="orderSearch"
                            type="search"
                            placeholder="Order ya customer search karein..."
                            class="w-full rounded-xl border border-white/[0.09] bg-[#0c1320] py-2.5 pl-10 pr-4 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 sm:w-60"
                        >
                    </div>

                    <select
                        id="orderStatusFilter"
                        class="rounded-xl border border-white/[0.09] bg-[#0c1320] px-3 py-2.5 text-sm text-gray-300 outline-none focus:border-till-500"
                    >
                        <option value="all">Sara Status</option>
                        <option value="completed">Mukammal</option>
                        <option value="refunded">Refund Ho Gaya</option>
                        <option value="pending">Pending</option>
                    </select>

                    <button
                        id="clearOrderFilters"
                        type="button"
                        class="hidden px-2 text-xs font-semibold text-till-400 hover:text-till-300"
                    >
                        Saaf Karein
                    </button>
                </div>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[1050px] w-full">
                <thead>
                    <tr class="border-b border-white/[0.07] bg-white/[0.015]">
                        <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Order
                        </th>

                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Customer
                        </th>

                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Saamaan
                        </th>

                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Payment
                        </th>

                        <th class="px-4 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Total
                        </th>

                        <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Receipt
                        </th>

                        <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Action
                        </th>

                        <th class="px-6 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                            Tareekh
                        </th>
                    </tr>
                </thead>

                <tbody id="ordersTableBody">
                    @forelse($orders as $order)
                        @php
                            $customerName = optional($order->customer)->name ?? 'Aam Customer';

                            $searchText = strtolower(
                                $order->order_number . ' ' .
                                $customerName . ' ' .
                                ($order->payment_method ?? '') . ' ' .
                                ($order->status ?? '')
                            );
                        @endphp

                        <tr
                            class="order-row border-b border-white/[0.05] transition hover:bg-white/[0.02]"
                            data-order-row
                            data-search="{{ $searchText }}"
                            data-status="{{ strtolower($order->status) }}"
                        >
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-bold text-till-400">
                                        {{ $order->order_number }}
                                    </p>

                                    <p class="mt-1 text-[10px] text-gray-600">
                                        Transaction ID
                                    </p>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-till-500/15 text-[10px] font-bold text-till-300">
                                        {{ strtoupper(substr($customerName, 0, 2)) }}
                                    </div>

                                    <div>
                                        <p class="max-w-[150px] truncate text-sm font-semibold text-white">
                                            {{ $customerName }}
                                        </p>

                                        <p class="mt-0.5 text-[10px] text-gray-600">
                                            {{ $order->customer ? 'Registered customer' : 'Aam sale' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/[0.04] px-2.5 py-1.5 text-xs font-semibold text-gray-300">
                                    <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>

                                    {{ $order->items->count() }} saamaan
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-lg border border-white/[0.07] bg-white/[0.03] px-2.5 py-1.5 text-[11px] font-semibold capitalize text-gray-300">
                                    {{ $order->payment_method }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-right">
                                <p class="text-sm font-bold text-white">
                                    {{ $tenant->formatMoney($order->total) }}
                                </p>
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($order->status === 'completed')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-[11px] font-semibold text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                        Mukammal
                                    </span>
                                @elseif($order->status === 'refunded')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/10 px-2.5 py-1 text-[11px] font-semibold text-red-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                        Refund Ho Gaya
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-2.5 py-1 text-[11px] font-semibold text-amber-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                <a
                                    href="{{ route('tenant.receipts.view', $order) }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-[11px] font-semibold transition
                                        {{ $order->status === 'refunded'
                                            ? 'text-gray-500 hover:bg-white/[0.04] hover:text-gray-300'
                                            : 'bg-till-500/10 text-till-400 hover:bg-till-500/15 hover:text-till-300' }}"
                                >
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>

                                    Dekhein
                                </a>
                            </td>

                            <td class="px-4 py-4 text-center">
                                @if($order->status === 'completed' && !auth()->user()->isCashier())
                                    <button
                                        type="button"
                                        data-refund-trigger
                                        data-order-id="{{ $order->id }}"
                                        data-order-number="{{ $order->order_number }}"
                                        data-refund-url="{{ url('/tenant/orders/' . $order->id . '/refund') }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-red-500/20 bg-red-500/10 px-2.5 py-1.5 text-[11px] font-semibold text-red-400 transition hover:bg-red-500/15"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Refund Karein
                                    </button>
                                @elseif($order->status === 'completed')
                                    <span class="text-xs font-medium text-gray-600">
                                        Manager se kahein
                                    </span>
                                @elseif($order->status === 'refunded')
                                    <span class="text-xs font-medium text-gray-600">
                                        Refund Ho Gaya
                                    </span>
                                @else
                                    <span class="text-xs text-gray-700">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <p class="text-xs font-medium text-gray-300">
                                    {{ $order->created_at->format('d M Y') }}
                                </p>

                                <p class="mt-1 text-[10px] text-gray-600">
                                    {{ $order->created_at->format('h:i A') }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-20 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>

                                    <h3 class="text-sm font-bold text-white">Abhi tak koi order nahi</h3>

                                    <p class="mt-2 text-xs leading-relaxed text-gray-500">
                                        POS counter se sale mukammal karne ke baad orders yahan nazar aayenge.
                                    </p>

                                    <a
                                        href="{{ route('tenant.pos') }}"
                                        class="mt-5 rounded-xl bg-till-600 px-4 py-2.5 text-xs font-bold text-white hover:bg-till-500"
                                    >
                                        POS Counter Kholein
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noOrderResults" class="hidden">
                        <td colspan="9" class="px-6 py-20 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>

                                <h3 class="text-sm font-bold text-white">Koi milta julta order nahi mila</h3>

                                <p class="mt-2 text-xs text-gray-500">
                                    Apna search text badlein ya status filter saaf karein.
                                </p>

                                <button
                                    id="clearOrderFiltersEmpty"
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

        @if($orders->hasPages())
            <div class="flex flex-col gap-3 border-t border-white/[0.07] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-500">
                    <span class="font-semibold text-gray-300">{{ $orders->firstItem() ?? 0 }}</span>
                    –
                    <span class="font-semibold text-gray-300">{{ $orders->lastItem() ?? 0 }}</span>
                    of
                    <span class="font-semibold text-gray-300">{{ $orders->total() }}</span>
                    orders dikha rahe hain
                </p>

                <div class="flex items-center gap-2">
                    @if($orders->onFirstPage())
                        <span class="rounded-lg border border-white/[0.06] bg-white/[0.02] px-3 py-2 text-xs font-semibold text-gray-600">
                            Pichla
                        </span>
                    @else
                        <a
                            href="{{ $orders->previousPageUrl() }}"
                            class="rounded-lg border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 transition hover:bg-white/[0.07] hover:text-white"
                        >
                            Pichla
                        </a>
                    @endif

                    <span class="px-2 text-xs text-gray-500">
                        Page {{ $orders->currentPage() }} / {{ $orders->lastPage() }}
                    </span>

                    @if($orders->hasMorePages())
                        <a
                            href="{{ $orders->nextPageUrl() }}"
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

{{-- Refund Modal --}}
<div id="refundModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">

    <button
        type="button"
        data-close-refund-modal
        class="absolute inset-0 cursor-default"
        aria-label="Refund modal band karein"
        style="background-color: rgba(2, 6, 23, 0.82); backdrop-filter: blur(5px);"
    ></button>

    <div
        class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl border border-gray-700 shadow-2xl"
        style="background-color: #111827 !important; color: #f8fafc !important;"
        role="dialog"
        aria-modal="true"
        aria-labelledby="refundModalTitle"
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
                    <h3 id="refundModalTitle" class="text-base font-bold text-white">
                        Order Refund Karein
                    </h3>

                    <p class="mt-1 text-xs text-gray-400">
                        Order:
                        <span id="refundOrderNumber" class="font-semibold text-white"></span>
                    </p>
                </div>
            </div>

            <button
                type="button"
                data-close-refund-modal
                class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white"
                aria-label="Modal band karein"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <div class="mb-5 rounded-xl border border-amber-500/20 bg-amber-500/10 p-3 text-xs leading-relaxed text-amber-200">
                <strong class="block text-amber-300">Zaroori:</strong>
                Saamaan ka stock wapas ho jayega aur ye refund audit log mein add ho jayega.
                Ye action wapas nahi ho sakta.
            </div>

            <form id="refundForm" method="POST">
                @csrf

                <div>
                    <label for="refundReason" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                        Refund Ki Wajah
                    </label>

                    <textarea
                        id="refundReason"
                        name="reason"
                        rows="4"
                        required
                        placeholder="Misaal: Customer ne item wapas kar diya ya ghalat product scan ho gaya."
                        class="w-full resize-none rounded-xl border border-gray-700 bg-[#0c1320] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-red-500"
                    ></textarea>
                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        data-close-refund-modal
                        class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-sm font-semibold text-gray-300 hover:bg-gray-700 hover:text-white"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-500"
                    >
                        Refund Confirm Karein
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
    const searchInput = document.getElementById('orderSearch');
    const statusFilter = document.getElementById('orderStatusFilter');
    const clearFiltersButton = document.getElementById('clearOrderFilters');
    const clearFiltersEmptyButton = document.getElementById('clearOrderFiltersEmpty');
    const noResultsRow = document.getElementById('noOrderResults');
    const visibleCount = document.getElementById('visibleOrderCount');

    const orderRows = Array.from(document.querySelectorAll('[data-order-row]'));

    const modal = document.getElementById('refundModal');
    const refundForm = document.getElementById('refundForm');
    const refundOrderNumber = document.getElementById('refundOrderNumber');
    const refundReason = document.getElementById('refundReason');

    function applyOrderFilters() {
        if (!searchInput || !statusFilter) {
            return;
        }

        const query = searchInput.value.trim().toLowerCase();
        const selectedStatus = statusFilter.value;

        let visible = 0;

        orderRows.forEach(row => {
            const searchValue = row.dataset.search || '';
            const orderStatus = row.dataset.status || '';

            const searchMatches = !query || searchValue.includes(query);
            const statusMatches = selectedStatus === 'all' || orderStatus === selectedStatus;

            const shouldShow = searchMatches && statusMatches;

            row.hidden = !shouldShow;

            if (shouldShow) {
                visible++;
            }
        });

        if (visibleCount) {
            visibleCount.textContent = visible;
        }

        const filtersActive = query || selectedStatus !== 'all';

        clearFiltersButton?.classList.toggle('hidden', !filtersActive);

        if (noResultsRow && orderRows.length > 0) {
            noResultsRow.classList.toggle('hidden', visible > 0);
        }
    }

    function clearOrderFilters() {
        if (searchInput) {
            searchInput.value = '';
        }

        if (statusFilter) {
            statusFilter.value = 'all';
        }

        applyOrderFilters();
        searchInput?.focus();
    }

    searchInput?.addEventListener('input', applyOrderFilters);
    statusFilter?.addEventListener('change', applyOrderFilters);

    clearFiltersButton?.addEventListener('click', clearOrderFilters);
    clearFiltersEmptyButton?.addEventListener('click', clearOrderFilters);

    function openRefundModal(button) {
        if (!modal) {
            return;
        }

        refundOrderNumber.textContent = button.dataset.orderNumber || '';
        refundForm.action = button.dataset.refundUrl || '';
        refundReason.value = '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

        setTimeout(() => refundReason.focus(), 100);
    }

    function closeRefundModal() {
        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    document.querySelectorAll('[data-refund-trigger]').forEach(button => {
        button.addEventListener('click', function () {
            openRefundModal(this);
        });
    });

    document.querySelectorAll('[data-close-refund-modal]').forEach(button => {
        button.addEventListener('click', closeRefundModal);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeRefundModal();
        }
    });
})();
</script>
@endpush