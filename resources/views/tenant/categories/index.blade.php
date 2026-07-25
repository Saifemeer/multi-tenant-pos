@extends('layouts.tenant')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Manage your product categories')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Add Category Form -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 h-fit animate-slide-in">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-purple-500/15 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-white">Add Category</h3>
                <p class="text-xs text-gray-500">Create a new product category</p>
            </div>
        </div>

        <form action="{{ route('tenant.categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Category Name</label>
                <input type="text" name="name" required class="input-modern" placeholder="e.g. Electronics, Beverages">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Color</label>
                <div class="flex gap-2 flex-wrap">
                    @foreach(['#ef4444','#f59e0b','#10b981','#3b82f6','#8b5cf6','#ec4899','#f97316','#06b6d4'] as $color)
                    <label class="cursor-pointer">
                        <input type="radio" name="color" value="{{ $color }}" class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                        <div class="w-8 h-8 rounded-lg border-2 border-transparent peer-checked:border-white peer-checked:scale-110 transition-all" style="background: {{ $color }}"></div>
                    </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add Category
            </button>
        </form>
    </div>

    <!-- Categories List -->
    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden animate-fade-in">
        <div class="px-6 py-5 border-b border-gray-800">
            <h3 class="text-base font-bold text-white">All Categories</h3>
            <p class="text-xs text-gray-500 mt-0.5">{{ $categories->count() }} categories</p>
        </div>

        <div class="divide-y divide-gray-800/50">
            @forelse($categories as $category)
            <div class="flex items-center justify-between px-6 py-4 table-row">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 rounded-full" style="background: {{ $category->color ?? '#6b7280' }}"></div>
                    <div>
                        <p class="font-semibold text-white text-sm">{{ $category->name }}</p>
                        <p class="text-xs text-gray-500">{{ $category->products_count ?? 0 }} products</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('tenant.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger text-xs px-3 py-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <p class="text-gray-400 font-semibold">No categories yet</p>
                <p class="text-gray-600 text-sm mt-1">Add your first category</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection