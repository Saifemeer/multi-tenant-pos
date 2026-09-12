@extends('layouts.tenant')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('page-subtitle', 'Update karein: ' . $product->name)

@section('content')
@php $tenant = auth()->user()->tenant; @endphp

<div class="max-w-2xl mx-auto">

    <div class="flex items-center gap-4 mb-6 animate-fade-in">
        <a href="{{ route('tenant.products.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Saamaan Par Wapas Jayein
        </a>
    </div>

    <div class="glass rounded-2xl overflow-hidden animate-fade-in delay-1">
        <div class="p-6 border-b border-white/[0.06]">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-gradient-to-br from-till-500/20 to-purple-500/10 rounded-2xl flex items-center justify-center border border-till-500/20">
                    <svg class="w-5 h-5 text-till-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-[15px] font-bold text-white">Saamaan Edit Karein</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Inventory item ki detail update karein</p>
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

            <form action="{{ route('tenant.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-till-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Saamaan Ka Naam
                    </label>
                    <input type="text" name="name" required value="{{ old('name', $product->name) }}"
                           class="input-modern"
                           placeholder="misaal ke tor par: Nike Air Max, MacBook Pro">
                </div>

                <!-- Category -->
                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-till-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Category
                    </label>
                    <select name="category_id" class="input-modern">
                        <option value="">— Category Select Karein —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- SKU / Barcode -->
                <div class="space-y-2">
                    <label class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-till-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            SKU / Barcode
                        </span>
                        <span class="text-[10px] text-gray-600 font-normal normal-case">Zaroori Nahi</span>
                    </label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                           class="input-modern"
                           placeholder="Khaali chhorne par khud ban jayega">
                </div>

                <!-- Price + Stock -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-2">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-emerald-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Price ({{ $tenant->currency }})
                        </label>
                        <input type="number" name="price" step="0.01" required value="{{ old('price', $product->price) }}"
                               class="input-modern"
                               placeholder="0.00">
                    </div>
                    <div class="space-y-2">
                        <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 text-blue-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                            Stock Ki Miqdar
                        </label>
                        <input type="number" name="stock_quantity" required value="{{ old('stock_quantity', $product->stock_quantity) }}"
                               class="input-modern"
                               placeholder="0">
                    </div>
                </div>

                <!-- Cost Price -->
                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-violet-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Cost Price ({{ $tenant->currency }})
                        <span class="text-[10px] text-gray-600 font-normal normal-case">Zaroori Nahi — profit track karne ke liye</span>
                    </label>
                    <input type="number" name="cost_price" step="0.01" value="{{ old('cost_price', $product->cost_price) }}"
                           class="input-modern"
                           placeholder="0.00">
                </div>

                <!-- Low Stock Alert -->
                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-amber-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        Kam Stock Alert Kis Par
                    </label>
                    <input type="number" name="low_stock_alert" value="{{ old('low_stock_alert', $product->low_stock_alert) }}"
                           class="input-modern"
                           placeholder="5">
                    <p class="text-[10px] text-gray-600 mt-1">Jab stock is number se kam hoga to aapko alert milega</p>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-gray-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Tafseel
                        <span class="text-[10px] text-gray-600 font-normal normal-case">Zaroori Nahi</span>
                    </label>
                    <textarea name="description" rows="3" class="input-modern">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Image -->
                <div class="space-y-2">
                    <label class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-gray-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Saamaan Ki Tasveer
                        <span class="text-[10px] text-gray-600 font-normal normal-case">Zaroori Nahi</span>
                    </label>
                    @if($product->image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 rounded-xl object-cover border border-white/[0.08]">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="input-modern">
                </div>

                <!-- Active Toggle -->
                <div class="flex items-center gap-3 p-3 rounded-xl bg-white/[0.02] border border-white/[0.06]">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 rounded accent-till-500">
                    <label for="is_active" class="text-sm text-gray-300 cursor-pointer">
                        Saamaan active hai (POS aur inventory mein nazar aayega)
                    </label>
                </div>

                <div class="border-t border-white/[0.04] pt-1"></div>

                <div class="flex gap-3">
                    <a href="{{ route('tenant.products.index') }}" class="btn-secondary flex-1 justify-center">Cancel</a>
                    <button type="submit" class="btn-primary flex-1 justify-center group">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Changes Save Karein
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection