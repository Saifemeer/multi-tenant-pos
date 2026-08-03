@extends('layouts.tenant')
@section('title', 'Inventory Dashboard')
@section('page-title', 'Inventory Dashboard')
@section('page-subtitle', now()->format('l, d F Y'))
@section('content')
@php $tenant = auth()->user()->tenant; @endphp

@if($tenant->productLimit() !== null)
    <div class="mb-4 text-sm text-gray-600">
        Products: {{ $products->count() }} / {{ $tenant->productLimit() }}
        @if($tenant->hasReachedProductLimit())
            <span class="text-red-600 font-medium">— Limit reached! Upgrade to add more.</span>
        @endif
    </div>
@endif
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    
    <!-- Total Products -->
    <div class="stat-card animate-fade-in delay-1 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500/20 to-purple-500/10 flex items-center justify-center border border-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div class="flex items-center gap-1 text-emerald-400 text-xs font-semibold bg-emerald-400/10 px-2 py-1 rounded-lg">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                Active
            </div>
        </div>
        <p class="text-3xl font-black text-white tracking-tight">{{ $products->count() }}</p>
        <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1">
            <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
            Total items in stock
        </p>
    </div>

    <!-- Low Stock -->
    <div class="stat-card animate-fade-in delay-2 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500/20 to-orange-500/10 flex items-center justify-center border border-amber-500/20 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            @php $lowStockCount = $products->filter(fn($p) => $p->stock_quantity <= $p->low_stock_alert && $p->stock_quantity > 0)->count(); @endphp
            @if($lowStockCount > 0)
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-400"></span>
            </span>
            @endif
        </div>
        <p class="text-3xl font-black text-amber-400 tracking-tight">{{ $lowStockCount }}</p>
        <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1">
            <span class="w-1 h-1 rounded-full bg-amber-400"></span>
            Need restocking soon
        </p>
    </div>

    <!-- Out of Stock -->
    <div class="stat-card animate-fade-in delay-3 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500/20 to-rose-500/10 flex items-center justify-center border border-red-500/20 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            @php $outOfStockCount = $products->filter(fn($p) => $p->stock_quantity <= 0)->count(); @endphp
            @if($outOfStockCount > 0)
            <span class="badge badge-danger text-[10px]">Critical</span>
            @endif
        </div>
        <p class="text-3xl font-black text-red-400 tracking-tight">{{ $outOfStockCount }}</p>
        <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1">
            <span class="w-1 h-1 rounded-full bg-red-400"></span>
            Items out of stock
        </p>
    </div>

   <!-- Inventory Value -->
<div class="stat-card animate-fade-in delay-4 group">
    <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-500/10 flex items-center justify-center border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="text-xs text-emerald-400 font-semibold bg-emerald-400/10 px-2 py-1 rounded-lg">
            {{ $tenant->currency }}
        </div>
    </div>

    <p class="text-2xl lg:text-3xl font-black text-emerald-400 tracking-tight truncate">
        {{ $tenant->formatMoney($products->sum(fn($p) => $p->price * $p->stock_quantity), 0) }}
    </p>

    <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1">
        <span class="w-1 h-1 rounded-full bg-emerald-400"></span>
        Total inventory value
    </p>
</div>
</div>
@if(isset($categories) && $categories->count() > 0)
<div class="mb-8 animate-fade-in delay-3">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-indigo-500/10 flex items-center justify-center border border-indigo-500/15">
                <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white">Product Categories</h3>
                <p class="text-[11px] text-gray-500">{{ $categories->count() }} categories available</p>
            </div>
        </div>
        <button id="categoryFilterReset" onclick="resetCategoryFilter()" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold transition-colors hidden" style="display:none;">
            ✕ Clear Filter
        </button>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach($categories as $category)
        <button class="category-btn glass-light rounded-2xl p-4 hover:border-indigo-500/30 transition-all duration-300 group cursor-pointer text-left"
             data-category="{{ $category->id }}"
             onclick="filterByCategory('{{ $category->id }}', this)">
            <div class="flex items-center gap-2.5 mb-2.5">
                <div class="w-3 h-3 rounded-full ring-2 ring-offset-2 ring-offset-gray-900 transition-transform group-hover:scale-125" style="background: {{ $category->color ?? '#6366f1' }}; ring-color: {{ $category->color ?? '#6366f1' }}40;"></div>
                <p class="text-[13px] font-semibold text-gray-300 group-hover:text-white transition-colors truncate">{{ $category->name }}</p>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-[11px] text-gray-600">{{ $category->products_count }} items</p>
                <svg class="w-3.5 h-3.5 text-gray-600 group-hover:text-indigo-400 transition-all group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </button>
        @endforeach
    </div>
</div>
@endif
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-1 animate-slide-in delay-2">
        <div class="glass rounded-2xl overflow-hidden sticky top-24">
            <div class="p-6 border-b border-white/[0.06]">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-gradient-to-br from-indigo-500/20 to-purple-500/10 rounded-2xl flex items-center justify-center border border-indigo-500/20">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[15px] font-bold text-white">Add New Product</h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">Fill details to add inventory item</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if ($errors->any())
                    <div class="alert alert-error mb-5">
                        <div class="w-8 h-8 rounded-xl bg-red-500/15 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <div class="flex-1">
                            @foreach ($errors->all() as $error)
                                <p class="text-xs">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif
<form action="{{ route('tenant.products.store') }}" method="POST" class="space-y-5">
                    @csrf
                     <!-- Product Name -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-indigo-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            Product Name
                        </label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="input-modern"
                               placeholder="e.g. Nike Air Max, MacBook Pro">
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-indigo-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            Category
                        </label>
                        <select name="category_id" class="input-modern">
                            <option value="">— Select Category —</option>
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5 text-indigo-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                SKU / Barcode
                            </span>
                            <span class="text-[10px] text-gray-600 font-normal normal-case">Optional</span>
                        </label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                               class="input-modern"
                               placeholder="Auto-generated if left empty">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-2">
                            <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5 text-emerald-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                               Price ({{ $tenant->currency }})
                            </label>
                            <input type="number" name="price" step="0.01" required value="{{ old('price') }}"
                                   class="input-modern"
                                   placeholder="0.00">
                        </div>
                        <div class="space-y-2">
                            <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5 text-blue-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                                Stock Qty
                            </label>
                            <input type="number" name="stock_quantity" required value="{{ old('stock_quantity') }}"
                                   class="input-modern"
                                   placeholder="0">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-amber-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            Low Stock Alert At
                        </label>
                        <input type="number" name="low_stock_alert" value="{{ old('low_stock_alert', 5) }}"
                               class="input-modern"
                               placeholder="5">
                        <p class="text-[10px] text-gray-600 mt-1">You'll be alerted when stock falls below this number</p>
                    </div>
                    <div class="border-t border-white/[0.04] pt-1"></div>
                    <button type="submit" class="btn-primary group">
                        <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add to Inventory
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="xl:col-span-2 animate-fade-in delay-3">
        <div class="glass rounded-2xl overflow-hidden">
            <div class="p-6 border-b border-white/[0.06]">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 bg-gradient-to-br from-violet-500/20 to-purple-500/10 rounded-2xl flex items-center justify-center border border-violet-500/20">
                            <svg class="w-5 h-5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <h3 class="text-[15px] font-bold text-white">Stock Inventory</h3>
                            <p class="text-[11px] text-gray-500 mt-0.5">
                                <span id="visibleCount">{{ $products->count() }}</span> of {{ $products->count() }} items
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <div class="relative flex-1 sm:flex-none">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" id="searchInput" placeholder="Search products..."
                                   class="input-modern pl-10 pr-4 py-2.5 text-[13px] sm:w-56"
                                   style="padding-left: 40px;">
                        </div>
                        <div class="relative">
                            <select id="stockFilter" onchange="filterByStock(this.value)" class="input-modern py-2.5 text-[13px] pr-8 w-auto" style="min-width: 120px;">
                                <option value="all">All Stock</option>
                                <option value="in_stock">In Stock</option>
                                <option value="low_stock">Low Stock</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/[0.06]">
                            <th class="text-left px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="text-left px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Category</th>
                            <th class="text-left px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">SKU</th>
                            <th class="text-right px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="text-center px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="text-center px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Status</th>
                            <th class="text-center px-4 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider w-14">Action</th>
                        </tr>
                    </thead>
                    <tbody id="productTable">
                        @forelse($products as $product)
                            @php
                                $stockStatus = 'in_stock';
                                if($product->stock_quantity <= 0) $stockStatus = 'out_of_stock';
                                elseif($product->stock_quantity <= $product->low_stock_alert) $stockStatus = 'low_stock';
                            @endphp
                            <tr class="table-row product-row" 
                                data-category="{{ $product->category_id }}" 
                                data-stock="{{ $stockStatus }}"
                                data-name="{{ strtolower($product->name) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 border transition-colors
                                            {{ $stockStatus === 'out_of_stock' ? 'bg-red-500/5 border-red-500/20' : ($stockStatus === 'low_stock' ? 'bg-amber-500/5 border-amber-500/20' : 'bg-indigo-500/5 border-indigo-500/20') }}">
                                            <svg class="w-4 h-4 {{ $stockStatus === 'out_of_stock' ? 'text-red-400/60' : ($stockStatus === 'low_stock' ? 'text-amber-400/60' : 'text-indigo-400/60') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-white text-[13px] truncate">{{ $product->name }}</p>
                                            <p class="text-[11px] text-gray-600 mt-0.5">{{ $product->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 hidden sm:table-cell">
                                    @if($product->category)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl text-[11px] font-semibold transition-colors"
                                              style="background: {{ $product->category->color ?? '#6366f1' }}12; color: {{ $product->category->color ?? '#818cf8' }}; border: 1px solid {{ $product->category->color ?? '#6366f1' }}25;">
                                            <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $product->category->color ?? '#818cf8' }}"></span>
                                            {{ $product->category->name }}
                                        </span>
                                    @else
                                        <span class="text-[11px] text-gray-600 italic">No category</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 hidden md:table-cell">
                                    <code class="text-[11px] text-gray-500 bg-white/[0.03] border border-white/[0.06] px-2.5 py-1 rounded-lg font-mono">{{ $product->sku ?? '—' }}</code>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-[13px] font-bold text-white">{{ $tenant->formatMoney($product->price, 0) }}</span>
                                    <p class="text-[10px] text-gray-600 mt-0.5">per unit</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center justify-center min-w-[40px] px-3 py-1.5 rounded-xl text-xs font-black
                                            {{ $stockStatus === 'out_of_stock' 
                                                ? 'bg-red-500/10 text-red-400 border border-red-500/20' 
                                                : ($stockStatus === 'low_stock' 
                                                    ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' 
                                                    : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20') }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                        @if($stockStatus === 'low_stock')
                                            <span class="text-[9px] text-amber-500/60 mt-1">min: {{ $product->low_stock_alert }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-center hidden lg:table-cell">
                                    @if($stockStatus === 'out_of_stock')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-semibold bg-red-500/8 text-red-400 border border-red-500/15">
                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                            Out of Stock
                                        </span>
                                    @elseif($stockStatus === 'low_stock')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-semibold bg-amber-500/8 text-amber-400 border border-amber-500/15">
                                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                                            Low Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-semibold bg-emerald-500/8 text-emerald-400 border border-emerald-500/15">
                                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>
                                            In Stock
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="relative inline-block" x-data="{ open: false }">
                                        <button onclick="toggleMenu(this)" class="w-8 h-8 rounded-xl bg-white/[0.03] border border-white/[0.06] flex items-center justify-center hover:bg-white/[0.08] hover:border-indigo-500/30 transition-all">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/></svg>
                                        </button>
                                        <div class="action-menu hidden absolute right-0 top-full mt-1 w-36 bg-gray-900 border border-white/[0.08] rounded-xl shadow-2xl shadow-black/50 z-20 overflow-hidden animate-slide-down">
                                            <a href="{{ route('tenant.products.edit', $product) }}" class="flex items-center gap-2 px-3 py-2.5 text-[12px] text-gray-400 hover:text-white hover:bg-white/[0.04] transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('tenant.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="flex items-center gap-2 px-3 py-2.5 text-[12px] text-red-400/80 hover:text-red-400 hover:bg-red-500/5 transition-colors w-full">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyState">
                                <td colspan="7" class="py-20 text-center">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-indigo-500/10 to-purple-500/5 border border-indigo-500/15 flex items-center justify-center">
                                            <svg class="w-9 h-9 text-indigo-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-300 font-bold text-sm">No products yet</p>
                                            <p class="text-gray-600 text-xs mt-1.5 max-w-[200px] mx-auto leading-relaxed">Start by adding your first product using the form on the left</p>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-indigo-400/60 text-xs mt-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                            Use the form to get started
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->count() > 0)
            <div class="px-6 py-4 border-t border-white/[0.04] flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-[11px] text-gray-600">
                    Showing <span class="text-gray-400 font-semibold" id="showingCount">{{ $products->count() }}</span> products
                </p>
                <div class="flex items-center gap-2">
                    <button onclick="exportTable()" class="btn-secondary text-[11px] py-1.5 px-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('searchInput')?.addEventListener('input', function() {
        applyFilters();
    });
    let activeCategory = null;
   function filterByCategory(categoryId, btn) {
        const resetBtn = document.getElementById('categoryFilterReset');
        if (activeCategory === categoryId) {
            resetCategoryFilter();
            return;
        }
        activeCategory = categoryId;
        document.querySelectorAll('.category-btn').forEach(b => {
            b.classList.remove('ring-2', 'ring-indigo-500/50');
            b.style.borderColor = '';
        });
        if (btn) {
            btn.classList.add('ring-2', 'ring-indigo-500/50');
        }
         resetBtn.style.display = 'inline-flex';
        applyFilters();
    }
    function resetCategoryFilter() {
        activeCategory = null;
        document.querySelectorAll('.category-btn').forEach(b => {
            b.classList.remove('ring-2', 'ring-indigo-500/50');
        });
        document.getElementById('categoryFilterReset').style.display = 'none';
        applyFilters();
    }
    function filterByStock(value) {
        applyFilters();
    }
    function applyFilters() {
        const query = document.getElementById('searchInput')?.value.toLowerCase() || '';
        const stockFilter = document.getElementById('stockFilter')?.value || 'all';
        const rows = document.querySelectorAll('.product-row');
        let visible = 0;
        rows.forEach(row => {
            const name = row.dataset.name || '';
            const category = row.dataset.category || '';
            const stock = row.dataset.stock || '';
            let show = true;
            if (query && !row.textContent.toLowerCase().includes(query)) {
                show = false;
            }
            if (activeCategory && category !== activeCategory) {
                show = false;
            }
            if (stockFilter !== 'all' && stock !== stockFilter) {
                show = false;
            }
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        const visibleEl = document.getElementById('visibleCount');
        const showingEl = document.getElementById('showingCount');
        if (visibleEl) visibleEl.textContent = visible;
        if (showingEl) showingEl.textContent = visible;
    }
    function toggleMenu(btn) {
        document.querySelectorAll('.action-menu').forEach(m => {
            if (m !== btn.nextElementSibling) m.classList.add('hidden');
        });
        btn.nextElementSibling.classList.toggle('hidden');
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.action-menu').forEach(m => m.classList.add('hidden'));
        }
    });
    function exportTable() {
        const rows = document.querySelectorAll('.product-row');
        let csv = 'Product,Category,SKU,Price,Stock,Status\n';
        
        rows.forEach(row => {
            if (row.style.display !== 'none') {
                const cells = row.querySelectorAll('td');
                const name = cells[0]?.querySelector('.font-semibold')?.textContent?.trim() || '';
                const cat = cells[1]?.textContent?.trim() || '';
                const sku = cells[2]?.textContent?.trim() || '';
                const price = cells[3]?.querySelector('.font-bold')?.textContent?.trim() || '';
                const stock = cells[4]?.querySelector('.font-black')?.textContent?.trim() || '';
                const status = cells[5]?.textContent?.trim() || '';
                csv += `"${name}","${cat}","${sku}","${price}","${stock}","${status}"\n`;
            }
        });
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'inventory-export.csv';
        a.click();
        URL.revokeObjectURL(url);
    }
</script>
@endpush