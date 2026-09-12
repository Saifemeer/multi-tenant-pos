@extends('layouts.tenant')

@section('title', 'Saamaan Dashboard')
@section('page-title', 'Saamaan Dashboard')
@section('page-subtitle', now()->format('l, d F Y'))

@section('content')
@php
    $tenant = auth()->user()->tenant;

    $productCount = $products->count();

    $lowStockCount = $products
        ->filter(fn ($product) => $product->stock_quantity > 0 && $product->stock_quantity <= $product->low_stock_alert)
        ->count();

    $outOfStockCount = $products
        ->filter(fn ($product) => $product->stock_quantity <= 0)
        ->count();

    $inventoryValue = $products->sum(
        fn ($product) => (float) $product->price * (int) $product->stock_quantity
    );

    $productLimit = $tenant->productLimit();
    $limitReached = $productLimit !== null && $tenant->hasReachedProductLimit();
@endphp

<div class="space-y-6">

    {{-- Product Limit Alert --}}
    @if($productLimit !== null)
        <div class="flex items-center gap-3 rounded-xl border px-4 py-3 text-sm
            {{ $limitReached
                ? 'border-red-500/30 bg-red-500/10 text-red-300'
                : 'border-white/[0.08] bg-white/[0.03] text-gray-400' }}">

            <svg class="w-5 h-5 flex-shrink-0 {{ $limitReached ? 'text-red-400' : 'text-till-400' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
            </svg>

            <p>
                Saamaan ka istemal:
                <span class="font-bold {{ $limitReached ? 'text-red-200' : 'text-white' }}">
                    {{ $productCount }} / {{ $productLimit }}
                </span>

                @if($limitReached)
                    <span>— Product limit poori ho gayi. Zyada saamaan add karne ke liye apna plan upgrade karein.</span>
                @endif
            </p>
        </div>
    @endif

    {{-- Top Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-till-400">
                Saamaan ka Intezaam
            </p>

            <h2 class="mt-1 text-xl font-bold text-white">
                Saamaan aur Stock
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Saamaan manage karein, stock check karein, aur inventory export karein.
            </p>
        </div>

        @if($limitReached)
            <button type="button"
                    disabled
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-700 px-4 py-2.5 text-sm font-semibold text-gray-400 cursor-not-allowed">
                Product Limit Poori
            </button>
        @else
            <button type="button"
                    data-open-product-modal
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-till-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-till-500/20 transition hover:bg-till-500">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/>
                </svg>

                Saamaan Add Karein
            </button>
        @endif
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        {{-- Total Products --}}
        <div class="rounded-2xl border border-white/[0.07] bg-[#111318] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>

                <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                    SAAMAAN
                </span>
            </div>

            <p class="text-3xl font-black text-white">{{ $productCount }}</p>
            <p class="mt-2 text-xs text-gray-500">Total saamaan catalog mein</p>
        </div>

        {{-- Low Stock --}}
        <div class="rounded-2xl border border-white/[0.07] bg-[#111318] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/15 text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 9v2m0 4h.01m-6.94 4h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                    </svg>
                </div>

                @if($lowStockCount > 0)
                    <span class="rounded-full bg-amber-500/10 px-2 py-1 text-[10px] font-bold text-amber-400">
                        DEKHEIN
                    </span>
                @endif
            </div>

            <p class="text-3xl font-black text-amber-400">{{ $lowStockCount }}</p>
            <p class="mt-2 text-xs text-gray-500">Saamaan dobara mangwana hai</p>
        </div>

        {{-- Out of Stock --}}
        <div class="rounded-2xl border border-white/[0.07] bg-[#111318] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500/15 text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M18.36 18.36A9 9 0 005.64 5.64m12.72 12.72A9 9 0 015.64 5.64"/>
                    </svg>
                </div>

                @if($outOfStockCount > 0)
                    <span class="rounded-full bg-red-500/10 px-2 py-1 text-[10px] font-bold text-red-400">
                        FAURI
                    </span>
                @endif
            </div>

            <p class="text-3xl font-black text-red-400">{{ $outOfStockCount }}</p>
            <p class="mt-2 text-xs text-gray-500">Saamaan khatam ho gaya</p>
        </div>

        {{-- Inventory Value --}}
        <div class="rounded-2xl border border-white/[0.07] bg-[#111318] p-5">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/15 text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 8c-1.66 0-3 .9-3 2s1.34 2 3 2 3 .9 3 2-1.34 2-3 2m0-8c1.11 0 2.08.4 2.6 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.4-2.6-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[10px] font-bold text-emerald-400">
                    {{ $tenant->currency }}
                </span>
            </div>

            <p class="truncate text-2xl font-black text-emerald-400 lg:text-3xl">
                {{ $tenant->formatMoney($inventoryValue, 0) }}
            </p>

            <p class="mt-2 text-xs text-gray-500">Total inventory ki qeemat</p>
        </div>
    </div>

    {{-- Product Table --}}
    <div class="overflow-hidden rounded-2xl border border-white/[0.07] bg-[#111318]">

        {{-- Table Header + Filters --}}
        <div class="flex flex-col gap-4 border-b border-white/[0.06] p-5 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Saamaan ki Inventory</h3>
                <p class="mt-1 text-xs text-gray-500">
                    <span id="visibleCount">{{ $productCount }}</span> mein se {{ $productCount }} saamaan dikha rahe hain
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                    </svg>

                    <input id="searchInput"
                           type="search"
                           placeholder="Saamaan search karein..."
                           class="w-full rounded-xl border border-white/[0.08] bg-[#0b0d12] py-2.5 pl-10 pr-4 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 sm:w-56">
                </div>

                <select id="categoryFilter"
                        class="rounded-xl border border-white/[0.08] bg-[#0b0d12] px-3 py-2.5 text-sm text-gray-300 outline-none focus:border-till-500">
                    <option value="">Sari Categories</option>

                    @foreach(($categories ?? collect()) as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <select id="stockFilter"
                        class="rounded-xl border border-white/[0.08] bg-[#0b0d12] px-3 py-2.5 text-sm text-gray-300 outline-none focus:border-till-500">
                    <option value="all">Sara Stock</option>
                    <option value="in_stock">Stock Mojood</option>
                    <option value="low_stock">Kam Stock</option>
                    <option value="out_of_stock">Stock Khatam</option>
                </select>

                <button id="clearFilters"
                        type="button"
                        class="hidden px-2 text-xs font-semibold text-till-400 hover:text-till-300">
                    Saaf Karein
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px]">
                <thead>
                    <tr class="border-b border-white/[0.06] bg-white/[0.015]">
                        <th class="px-6 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Saamaan</th>
                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Category</th>
                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">SKU</th>
                        <th class="px-4 py-4 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">Price</th>
                        <th class="px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Stock</th>
                        <th class="px-4 py-4 text-left text-[10px] font-bold uppercase tracking-wider text-gray-500">Status</th>
                        <th class="w-16 px-4 py-4 text-center text-[10px] font-bold uppercase tracking-wider text-gray-500">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        @php
                            $stockStatus = 'in_stock';
                            $stockLabel = 'Stock Mojood';

                            if ($product->stock_quantity <= 0) {
                                $stockStatus = 'out_of_stock';
                                $stockLabel = 'Stock Khatam';
                            } elseif ($product->stock_quantity <= $product->low_stock_alert) {
                                $stockStatus = 'low_stock';
                                $stockLabel = 'Kam Stock';
                            }

                            $categoryName = optional($product->category)->name;
                            $categoryColor = optional($product->category)->color ?: '#4fb894';

                            $searchValue = strtolower(
                                $product->name . ' ' .
                                ($product->sku ?? '') . ' ' .
                                ($categoryName ?? '')
                            );
                        @endphp

                        <tr class="product-row border-b border-white/[0.05] transition hover:bg-white/[0.02]"
                            data-search="{{ $searchValue }}"
                            data-category="{{ $product->category_id ?? '' }}"
                            data-stock="{{ $stockStatus }}"
                            data-export-name="{{ $product->name }}"
                            data-export-category="{{ $categoryName ?? 'Uncategorized' }}"
                            data-export-sku="{{ $product->sku ?? '' }}"
                            data-export-price="{{ $product->price }}"
                            data-export-stock="{{ $product->stock_quantity }}"
                            data-export-status="{{ $stockLabel }}">

                            {{-- Product --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-till-500/10 text-till-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="max-w-[200px] truncate text-sm font-semibold text-white">
                                            {{ $product->name }}
                                        </p>

                                        <p class="mt-1 text-[11px] text-gray-600">
                                            Add hua: {{ $product->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-4 py-4">
                                @if($product->category)
                                    <span class="inline-flex max-w-[150px] items-center gap-2 rounded-full border border-white/[0.07] bg-white/[0.03] px-2.5 py-1 text-[11px] font-semibold text-gray-300">
                                        <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full"
                                              style="background: {{ $categoryColor }}"></span>

                                        <span class="truncate">{{ $categoryName }}</span>
                                    </span>
                                @else
                                    <span class="text-xs text-gray-600">Category nahi</span>
                                @endif
                            </td>

                            {{-- SKU --}}
                            <td class="px-4 py-4">
                                <code class="text-xs text-gray-500">
                                    {{ $product->sku ?: '—' }}
                                </code>
                            </td>

                            {{-- Price --}}
                            <td class="px-4 py-4 text-right">
                                <span class="text-sm font-bold text-white">
                                    {{ $tenant->formatMoney($product->price, 0) }}
                                </span>
                            </td>

                            {{-- Stock --}}
                            <td class="px-4 py-4 text-center">
                                <span class="text-sm font-black
                                    {{ $stockStatus === 'out_of_stock'
                                        ? 'text-red-400'
                                        : ($stockStatus === 'low_stock'
                                            ? 'text-amber-400'
                                            : 'text-emerald-400') }}">
                                    {{ $product->stock_quantity }}
                                </span>

                                @if($stockStatus === 'low_stock')
                                    <p class="mt-1 text-[10px] text-gray-600">
                                        Alert: {{ $product->low_stock_alert }}
                                    </p>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">
                                @if($stockStatus === 'in_stock')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-[11px] font-semibold text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                        Stock Mojood
                                    </span>
                                @elseif($stockStatus === 'low_stock')
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-2.5 py-1 text-[11px] font-semibold text-amber-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                        Kam Stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-500/10 px-2.5 py-1 text-[11px] font-semibold text-red-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                                        Stock Khatam
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-4 text-center">
                                <div class="relative inline-block">
                                    <button type="button"
                                            data-menu-toggle
                                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-white/[0.07] bg-white/[0.02] text-gray-400 transition hover:border-till-500/40 hover:text-white"
                                            aria-label="Saamaan ke actions"
                                            aria-expanded="false">

                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/>
                                        </svg>
                                    </button>

                                    <div class="action-menu absolute right-0 top-full z-30 mt-2 hidden w-36 overflow-hidden rounded-xl border border-white/[0.10] bg-[#111827] text-left shadow-2xl shadow-black/50">
                                        <a href="{{ route('tenant.products.edit', $product) }}"
                                           class="flex items-center gap-2 px-3 py-2.5 text-xs text-gray-300 transition hover:bg-white/[0.05] hover:text-white">

                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11.8 15H9v-2.8l8.6-8.6z"/>
                                            </svg>

                                            Edit Karein
                                        </a>

                                        <form action="{{ route('tenant.products.destroy', $product) }}"
                                              method="POST"
                                              onsubmit="return confirm('Ye saamaan delete karna hai?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="flex w-full items-center gap-2 px-3 py-2.5 text-xs text-red-400 transition hover:bg-red-500/10">

                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.9 12.1A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>

                                                Delete Karein
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>

                                    <h4 class="text-sm font-bold text-white">Abhi tak koi saamaan add nahi hua</h4>
                                    <p class="mt-2 text-xs leading-relaxed text-gray-500">
                                        Inventory manage karne ke liye apna pehla saamaan add karein.
                                    </p>

                                    @if(!$limitReached)
                                        <button type="button"
                                                data-open-product-modal
                                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-till-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-till-500">
                                            Pehla Saamaan Add Karein
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    {{-- No Filter Results --}}
                    <tr id="noResultsRow" class="hidden">
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-till-500/10 text-till-400">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                              d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>

                                <h4 class="text-sm font-bold text-white">Koi milta julta saamaan nahi mila</h4>
                                <p class="mt-2 text-xs text-gray-500">
                                    Koi aur search try karein ya filters saaf karein.
                                </p>

                                <button id="clearFiltersEmpty"
                                        type="button"
                                        class="mt-5 rounded-xl border border-white/[0.10] bg-white/[0.03] px-4 py-2 text-xs font-semibold text-gray-300 hover:bg-white/[0.06]">
                                    Filters Saaf Karein
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($productCount > 0)
            <div class="flex flex-col gap-3 border-t border-white/[0.06] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-500">
                    <span id="showingCount">{{ $productCount }}</span> saamaan is waqt dikh rahe hain
                </p>

                <button type="button"
                        id="exportTable"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 transition hover:border-till-500/40 hover:bg-white/[0.06] hover:text-white">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.6a1 1 0 01.7.3l5.4 5.4a1 1 0 01.3.7V19a2 2 0 01-2 2z"/>
                    </svg>

                    CSV Export Karein
                </button>
            </div>
        @endif
    </div>
</div>

{{-- =========================================================
    ADD PRODUCT MODAL
    Background is explicitly defined so it will NOT be transparent.
========================================================= --}}
@if(!$limitReached)
    <div id="productModal"
         class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">

        {{-- Dark Overlay --}}
        <div class="absolute inset-0"
             data-close-product-modal
             style="background-color: rgba(2, 6, 23, 0.82) !important; backdrop-filter: blur(5px);">
        </div>

        {{-- Modal Box --}}
        <div class="relative z-10 max-h-[calc(100vh-2rem)] w-full max-w-xl overflow-y-auto rounded-2xl border border-gray-700 shadow-2xl"
             style="background-color: #111827 !important; color: #f8fafc !important;">

            {{-- Modal Header --}}
            <div class="flex items-start justify-between gap-4 border-b border-gray-700 px-6 py-5"
                 style="background-color: #111827 !important;">

                <div>
                    <h3 class="text-lg font-bold text-white">
                        Naya Saamaan Add Karein
                    </h3>

                    <p class="mt-1 text-sm text-gray-400">
                        Inventory mein add karne ke liye saamaan ki detail darj karein.
                    </p>
                </div>

                <button type="button"
                        data-close-product-modal
                        class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-gray-400 transition hover:bg-gray-700 hover:text-white">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-6" style="background-color: #111827 !important;">

                @if($errors->any())
                    <div class="mb-5 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-300">
                        <p class="mb-2 font-bold">Ye errors theek karein:</p>

                        <ul class="list-inside list-disc space-y-1 text-xs">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tenant.products.store') }}" method="POST">
                    @csrf

                    {{-- Product Name --}}
                    <div class="mb-4">
                        <label for="name" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Saamaan Ka Naam <span class="text-red-400">*</span>
                        </label>

                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               placeholder="misaal ke tor par: Nike Air Max"
                               class="w-full rounded-xl border border-gray-700 bg-[#0b0d12] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('name') border-red-500 @enderror">
                    </div>

                    {{-- Category --}}
                    <div class="mb-4">
                        <label for="category_id" class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>Category</span>
                            <span class="text-[10px] font-normal normal-case text-gray-600">Zaroori Nahi</span>
                        </label>

                        <select id="category_id"
                                name="category_id"
                                class="w-full rounded-xl border border-gray-700 bg-[#0b0d12] px-4 py-3 text-sm text-white outline-none focus:border-till-500 @error('category_id') border-red-500 @enderror">
                            <option value="">Category select karein</option>

                            @foreach(($categories ?? collect()) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SKU --}}
                    <div class="mb-4">
                        <label for="sku" class="mb-2 flex items-center justify-between text-xs font-bold uppercase tracking-wider text-gray-400">
                            <span>SKU / Barcode</span>
                            <span class="text-[10px] font-normal normal-case text-gray-600">
                                Khaali chhorne par khud ban jayega
                            </span>
                        </label>

                        <input id="sku"
                               type="text"
                               name="sku"
                               value="{{ old('sku') }}"
                               placeholder="e.g. NK-AMX-001"
                               class="w-full rounded-xl border border-gray-700 bg-[#0b0d12] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('sku') border-red-500 @enderror">
                    </div>

                    {{-- Price and Stock --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="price" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Price ({{ $tenant->currency }}) <span class="text-red-400">*</span>
                            </label>

                            <input id="price"
                                   type="number"
                                   name="price"
                                   step="0.01"
                                   min="0"
                                   value="{{ old('price') }}"
                                   required
                                   placeholder="0.00"
                                   class="w-full rounded-xl border border-gray-700 bg-[#0b0d12] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('price') border-red-500 @enderror">
                        </div>

                        <div>
                            <label for="stock_quantity" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                                Shuru Ka Stock <span class="text-red-400">*</span>
                            </label>

                            <input id="stock_quantity"
                                   type="number"
                                   name="stock_quantity"
                                   min="0"
                                   value="{{ old('stock_quantity', 0) }}"
                                   required
                                   placeholder="0"
                                   class="w-full rounded-xl border border-gray-700 bg-[#0b0d12] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('stock_quantity') border-red-500 @enderror">
                        </div>
                    </div>

                    {{-- Low Stock Alert --}}
                    <div class="mt-4">
                        <label for="low_stock_alert" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">
                            Kam Stock Alert Kis Par
                        </label>

                        <input id="low_stock_alert"
                               type="number"
                               name="low_stock_alert"
                               min="0"
                               value="{{ old('low_stock_alert', 5) }}"
                               placeholder="5"
                               class="w-full rounded-xl border border-gray-700 bg-[#0b0d12] px-4 py-3 text-sm text-white outline-none placeholder:text-gray-600 focus:border-till-500 @error('low_stock_alert') border-red-500 @enderror">

                        <p class="mt-2 text-xs text-gray-500">
                            Jab stock is number tak pohanchega to aapko alert milega.
                        </p>
                    </div>

                    {{-- Modal Buttons --}}
                    <div class="mt-7 flex flex-col-reverse gap-3 border-t border-gray-700 pt-5 sm:flex-row sm:justify-end">
                        <button type="button"
                                data-close-product-modal
                                class="rounded-xl border border-gray-700 bg-gray-800 px-5 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-700 hover:text-white">
                            Cancel Karein
                        </button>

                        <button type="submit"
                                class="rounded-xl bg-till-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-till-500/20 transition hover:bg-till-500">
                            Saamaan Add Karein
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
(function () {
    const modal = document.getElementById('productModal');

    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const stockFilter = document.getElementById('stockFilter');

    const clearFilters = document.getElementById('clearFilters');
    const clearFiltersEmpty = document.getElementById('clearFiltersEmpty');

    const visibleCount = document.getElementById('visibleCount');
    const showingCount = document.getElementById('showingCount');
    const noResultsRow = document.getElementById('noResultsRow');

    const productRows = Array.from(document.querySelectorAll('.product-row'));
    const exportButton = document.getElementById('exportTable');

    /* =========================
       PRODUCT MODAL
    ========================== */
    function openProductModal() {
        if (!modal) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

        setTimeout(() => {
            document.getElementById('name')?.focus();
        }, 100);
    }

    function closeProductModal() {
        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    document.querySelectorAll('[data-open-product-modal]').forEach(button => {
        button.addEventListener('click', openProductModal);
    });

    document.querySelectorAll('[data-close-product-modal]').forEach(button => {
        button.addEventListener('click', closeProductModal);
    });

    /* =========================
       PRODUCT FILTERS
    ========================== */
    function applyFilters() {
        const search = (searchInput?.value || '').trim().toLowerCase();
        const category = categoryFilter?.value || '';
        const stock = stockFilter?.value || 'all';

        let visible = 0;

        productRows.forEach(row => {
            const searchMatch = !search || row.dataset.search.includes(search);
            const categoryMatch = !category || row.dataset.category === category;
            const stockMatch = stock === 'all' || row.dataset.stock === stock;

            const show = searchMatch && categoryMatch && stockMatch;

            row.classList.toggle('hidden', !show);

            if (show) visible++;
        });

        if (visibleCount) visibleCount.textContent = visible;
        if (showingCount) showingCount.textContent = visible;

        const filtersActive = search || category || stock !== 'all';

        if (clearFilters) {
            clearFilters.classList.toggle('hidden', !filtersActive);
        }

        if (noResultsRow && productRows.length > 0) {
            noResultsRow.classList.toggle('hidden', visible > 0);
        }
    }

    function resetFilters() {
        if (searchInput) searchInput.value = '';
        if (categoryFilter) categoryFilter.value = '';
        if (stockFilter) stockFilter.value = 'all';

        applyFilters();
    }

    searchInput?.addEventListener('input', applyFilters);
    categoryFilter?.addEventListener('change', applyFilters);
    stockFilter?.addEventListener('change', applyFilters);

    clearFilters?.addEventListener('click', resetFilters);
    clearFiltersEmpty?.addEventListener('click', resetFilters);

    /* =========================
       ACTION DROPDOWN
    ========================== */
    function closeAllMenus() {
        document.querySelectorAll('.action-menu').forEach(menu => {
            menu.classList.add('hidden');
        });

        document.querySelectorAll('[data-menu-toggle]').forEach(button => {
            button.setAttribute('aria-expanded', 'false');
        });
    }

    document.addEventListener('click', function (event) {
        const toggleButton = event.target.closest('[data-menu-toggle]');

        if (toggleButton) {
            const menu = toggleButton.parentElement.querySelector('.action-menu');
            const isHidden = menu.classList.contains('hidden');

            closeAllMenus();

            if (isHidden) {
                menu.classList.remove('hidden');
                toggleButton.setAttribute('aria-expanded', 'true');
            }

            return;
        }

        if (!event.target.closest('.action-menu')) {
            closeAllMenus();
        }
    });

    /* =========================
       ESC KEY
    ========================== */
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeProductModal();
            closeAllMenus();
        }
    });

    /* =========================
       EXPORT FILTERED PRODUCTS
    ========================== */
    function escapeCsv(value) {
        return `"${String(value ?? '').replace(/"/g, '""')}"`;
    }

    exportButton?.addEventListener('click', function () {
        const visibleRows = productRows.filter(row => !row.classList.contains('hidden'));

        if (!visibleRows.length) {
            alert('Export karne ke liye koi saamaan mojood nahi.');
            return;
        }

        const csvRows = [
            ['Saamaan', 'Category', 'SKU', 'Price', 'Stock', 'Status']
        ];

        visibleRows.forEach(row => {
            csvRows.push([
                row.dataset.exportName,
                row.dataset.exportCategory,
                row.dataset.exportSku,
                row.dataset.exportPrice,
                row.dataset.exportStock,
                row.dataset.exportStatus
            ]);
        });

        const csvContent = '\uFEFF' + csvRows
            .map(row => row.map(escapeCsv).join(','))
            .join('\n');

        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });

        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');

        link.href = url;
        link.download = 'inventory-export.csv';

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);
    });

    /* Validation errors hon to modal automatic khul jaye */
    @if($errors->any() && !$limitReached)
        openProductModal();
    @endif
})();
</script>
@endpush