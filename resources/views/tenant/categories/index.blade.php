@extends('layouts.tenant')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Saamaan ko categories mein organize karein')

@push('styles')
<style>
    .category-page {
        --cat-surface: #111827;
        --cat-surface-soft: #151f31;
        --cat-input: #0c1320;
        --cat-border: rgba(148, 163, 184, 0.16);
        --cat-border-strong: rgba(148, 163, 184, 0.28);
        --cat-text: #f8fafc;
        --cat-muted: #94a3b8;
        --cat-faint: #64748b;
        --cat-primary: #0E7A5C;
    }

    .category-panel {
        overflow: hidden;
        background: var(--cat-surface);
        border: 1px solid var(--cat-border);
        border-radius: 16px;
    }

    .category-panel-header {
        padding: 20px;
        border-bottom: 1px solid var(--cat-border);
    }

    .category-kicker {
        margin: 0 0 5px;
        color: #4fb894;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .category-title {
        margin: 0;
        color: var(--cat-text);
        font-size: 16px;
        font-weight: 800;
    }

    .category-description {
        margin: 5px 0 0;
        color: var(--cat-muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .category-form-body {
        padding: 20px;
    }

    .category-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        color: var(--cat-muted);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }

    .category-help {
        color: var(--cat-faint);
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0;
        text-transform: none;
    }

    .category-input {
        width: 100%;
        padding: 11px 13px;
        color: var(--cat-text);
        background: var(--cat-input);
        border: 1px solid var(--cat-border);
        border-radius: 9px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .category-input::placeholder {
        color: var(--cat-faint);
    }

    .category-input:focus {
        border-color: var(--cat-primary);
        box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.14);
    }

    .category-input.is-invalid {
        border-color: #ef4444;
    }

    .category-primary-btn {
        display: inline-flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 15px;
        color: #ffffff;
        background: #0E7A5C;
        border: 1px solid #0E7A5C;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
    }

    .category-primary-btn:hover {
        background: #0B6049;
        transform: translateY(-1px);
    }

    .category-primary-btn:active {
        transform: translateY(0);
    }

    .category-color-input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        pointer-events: none;
    }

    .category-color-swatch {
        display: block;
        width: 31px;
        height: 31px;
        border: 2px solid transparent;
        border-radius: 9px;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .category-color-swatch:hover {
        transform: scale(1.08);
    }

    .category-color-input:checked + .category-color-swatch {
        border-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.45);
        transform: scale(1.08);
    }

    .category-summary-card {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        margin-top: 18px;
        background: var(--cat-surface-soft);
        border: 1px solid var(--cat-border);
        border-radius: 10px;
    }

    .category-summary-card p {
        margin: 0;
    }

    .category-search-wrap {
        position: relative;
        width: 230px;
    }

    .category-search-icon {
        position: absolute;
        top: 50%;
        left: 11px;
        color: var(--cat-faint);
        transform: translateY(-50%);
        pointer-events: none;
    }

    .category-search {
        width: 100%;
        min-height: 39px;
        padding: 0 36px 0 35px;
        color: var(--cat-text);
        background: var(--cat-input);
        border: 1px solid var(--cat-border);
        border-radius: 8px;
        font-size: 12px;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .category-search::placeholder {
        color: var(--cat-faint);
    }

    .category-search:focus {
        border-color: var(--cat-primary);
        box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.13);
    }

    .category-clear-search {
        position: absolute;
        top: 50%;
        right: 9px;
        display: grid;
        width: 22px;
        height: 22px;
        place-items: center;
        color: var(--cat-faint);
        background: transparent;
        border: 0;
        border-radius: 5px;
        cursor: pointer;
        transform: translateY(-50%);
    }

    .category-clear-search:hover {
        color: var(--cat-text);
        background: var(--cat-surface-soft);
    }

    .category-list {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 12px;
        padding: 16px;
    }

    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px;
        background: var(--cat-surface-soft);
        border: 1px solid var(--cat-border);
        border-radius: 11px;
        transition: border-color 0.2s ease, background 0.2s ease, transform 0.2s ease;
    }

    .category-item:hover {
        background: #19253a;
        border-color: var(--cat-border-strong);
        transform: translateY(-1px);
    }

    .category-item[hidden] {
        display: none !important;
    }

    .category-color-dot {
        width: 12px;
        height: 12px;
        flex-shrink: 0;
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.06);
    }

    .category-name {
        max-width: 180px;
        margin: 0;
        overflow: hidden;
        color: var(--cat-text);
        font-size: 13px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .category-meta {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 4px;
        color: var(--cat-faint);
        font-size: 11px;
    }

    .category-product-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 8px;
        color: var(--cat-muted);
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--cat-border);
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .category-delete-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 9px;
        color: #fca5a5;
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.17);
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .category-delete-btn:hover {
        background: rgba(239, 68, 68, 0.16);
    }

    .category-empty {
        padding: 64px 20px;
        text-align: center;
    }

    .category-empty-icon {
        display: grid;
        width: 48px;
        height: 48px;
        place-items: center;
        margin: 0 auto 14px;
        color: #7dd3b0;
        background: rgba(14, 122, 92, 0.13);
        border-radius: 12px;
    }

    .category-error-box {
        padding: 12px;
        margin-bottom: 18px;
        color: #fecaca;
        background: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.22);
        border-radius: 9px;
        font-size: 12px;
        line-height: 1.65;
    }

    .category-no-results {
        padding: 55px 20px;
        text-align: center;
    }

    @media (min-width: 768px) {
        .category-list {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .category-panel-header {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .category-search-wrap {
            width: 100%;
        }

        .category-item {
            padding: 12px;
        }

        .category-name {
            max-width: 125px;
        }
    }
</style>
@endpush

@section('content')
@php
    $categoryColors = [
        '#ef4444',
        '#f59e0b',
        '#10b981',
        '#3b82f6',
        '#0E7A5C',
        '#8b5cf6',
        '#ec4899',
        '#f97316',
        '#06b6d4',
        '#84cc16',
    ];

    $selectedColor = old('color', '#0E7A5C');
    $categoryCount = $categories->count();

    $totalProducts = $categories->sum(
        fn ($category) => (int) ($category->products_count ?? 0)
    );
@endphp

<div class="category-page">

    {{-- Small Summary --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="category-kicker">Product organization</p>
            <h2 class="category-title text-lg">Manage product categories</h2>
            <p class="category-description">
                Create categories to keep your products organized and easier to find at the POS.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-2 rounded-xl border border-white/[0.08] bg-white/[0.03] px-3 py-2 text-xs text-gray-400">
                <span class="font-bold text-white">{{ $categoryCount }}</span>
                Categories
            </span>

            <span class="inline-flex items-center gap-2 rounded-xl border border-white/[0.08] bg-white/[0.03] px-3 py-2 text-xs text-gray-400">
                <span class="font-bold text-white">{{ $totalProducts }}</span>
                Products organized
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Add Category Form --}}
        <section class="category-panel h-fit lg:sticky lg:top-24">
            <div class="category-panel-header">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-till-500/15 text-till-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v14m7-7H5"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="category-title">Category Add Karein</h3>
                        <p class="category-description">Milte julte saamaan ke liye ek group banayein.</p>
                    </div>
                </div>
            </div>

            <div class="category-form-body">
                @if($errors->any())
                    <div class="category-error-box">
                        <p class="mb-1 font-bold">Ye check karein:</p>

                        @foreach($errors->all() as $error)
                            <div>• {{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('tenant.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label for="categoryName" class="category-label">
                            Category Ka Naam
                        </label>

                        <input
                            id="categoryName"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            maxlength="100"
                            autocomplete="off"
                            placeholder="misaal ke tor par: Electronics"
                            class="category-input @error('name') is-invalid @enderror"
                        >

                        @error('name')
                            <p class="mt-2 text-[11px] text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="category-label">
                            Category Ka Rang
                            <span class="category-help">Label ka rang chunein</span>
                        </label>

                        <div class="flex flex-wrap gap-3">
                            @foreach($categoryColors as $color)
                                <label class="relative" title="{{ $color }}">
                                    <input
                                        type="radio"
                                        name="color"
                                        value="{{ $color }}"
                                        class="category-color-input"
                                        {{ $selectedColor === $color ? 'checked' : '' }}
                                    >

                                    <span
                                        class="category-color-swatch"
                                        style="background-color: {{ $color }};"
                                    ></span>
                                </label>
                            @endforeach
                        </div>

                        @error('color')
                            <p class="mt-2 text-[11px] text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="category-primary-btn">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v14m7-7H5"/>
                        </svg>
                        Category Add Karein
                    </button>
                </form>

                <div class="category-summary-card">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-till-500/10 text-till-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-white">Categories simple rakhein</p>
                        <p class="mt-1 text-[11px] leading-relaxed text-gray-500">
                            Aise naam rakhein jo aapka cashier checkout par aasani se pehchan sake.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Category List --}}
        <section class="category-panel lg:col-span-2">
            <div class="category-panel-header flex items-center justify-between gap-4">
                <div>
                    <h3 class="category-title">Sari Categories</h3>
                    <p class="category-description">
                        <span id="visibleCategoryCount">{{ $categoryCount }}</span>
                        categories dikhayi ja rahi hain, kul {{ $categoryCount }} mein se
                    </p>
                </div>

                @if($categoryCount > 0)
                    <div class="category-search-wrap">
                        <svg class="category-search-icon h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                        </svg>

                        <input
                            id="categorySearch"
                            type="search"
                            class="category-search"
                            placeholder="Categories search karein..."
                            autocomplete="off"
                        >

                        <button id="clearCategorySearch" type="button" class="category-clear-search hidden" title="Search saaf karein">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            @if($categoryCount > 0)
                <div id="categoriesList" class="category-list">
                    @foreach($categories as $category)
                        @php
                            $categoryColor = $category->color ?? '#0E7A5C';
                            $productsCount = (int) ($category->products_count ?? 0);
                        @endphp

                        <article
                            class="category-item"
                            data-category-item
                            data-category-name="{{ strtolower($category->name) }}"
                        >
                            <div class="flex min-w-0 items-center gap-3">
                                <span
                                    class="category-color-dot"
                                    style="background-color: {{ $categoryColor }};"
                                ></span>

                                <div class="min-w-0">
                                    <p class="category-name">{{ $category->name }}</p>

                                    <p class="category-meta">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>

                                        {{ $productsCount }} {{ Str::plural('product', $productsCount) }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-shrink-0 items-center gap-2">
                                <span class="category-product-badge">
                                    {{ $productsCount }} items
                                </span>

                                <form
                                    action="{{ route('tenant.categories.destroy', $category) }}"
                                    method="POST"
                                    class="delete-category-form"
                                    data-category-name="{{ $category->name }}"
                                    data-products-count="{{ $productsCount }}"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="category-delete-btn" title="Category delete karein">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>

                                        <span class="hidden sm:inline">Delete Karein</span>
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Search Empty State --}}
                <div id="noCategoryResults" class="category-no-results hidden">
                    <div class="category-empty-icon">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <p class="font-bold text-white">Koi category nahi mili</p>
                    <p class="mt-1 text-xs text-gray-500">Koi aur category naam try karein.</p>

                    <button
                        id="clearCategorySearchEmpty"
                        type="button"
                        class="mt-4 rounded-lg border border-white/[0.10] bg-white/[0.03] px-3 py-2 text-xs font-semibold text-gray-300 hover:bg-white/[0.06]"
                    >
                        Search Saaf Karein
                    </button>
                </div>
            @else
                <div class="category-empty">
                    <div class="category-empty-icon">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>

                    <p class="font-bold text-white">Abhi tak koi category nahi</p>
                    <p class="mt-1 text-xs text-gray-500">
                        Bayen taraf form se apni pehli category add karein.
                    </p>

                    <button
                        type="button"
                        id="focusCategoryInput"
                        class="mt-5 rounded-lg bg-till-600 px-4 py-2 text-xs font-bold text-white hover:bg-till-500"
                    >
                        Pehli Category Add Karein
                    </button>
                </div>
            @endif
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const searchInput = document.getElementById('categorySearch');
    const clearSearchButton = document.getElementById('clearCategorySearch');
    const clearSearchEmptyButton = document.getElementById('clearCategorySearchEmpty');
    const noResults = document.getElementById('noCategoryResults');
    const visibleCount = document.getElementById('visibleCategoryCount');
    const categoryItems = Array.from(document.querySelectorAll('[data-category-item]'));

    function filterCategories() {
        if (!searchInput) return;

        const query = searchInput.value.trim().toLowerCase();
        let visible = 0;

        categoryItems.forEach(item => {
            const categoryName = item.dataset.categoryName || '';
            const matches = categoryName.includes(query);

            item.hidden = !matches;

            if (matches) {
                visible++;
            }
        });

        if (visibleCount) {
            visibleCount.textContent = visible;
        }

        if (noResults) {
            noResults.classList.toggle(
                'hidden',
                visible > 0 || categoryItems.length === 0
            );
        }

        if (clearSearchButton) {
            clearSearchButton.classList.toggle('hidden', !query);
        }
    }

    function clearSearch() {
        if (!searchInput) return;

        searchInput.value = '';
        filterCategories();
        searchInput.focus();
    }

    searchInput?.addEventListener('input', filterCategories);

    clearSearchButton?.addEventListener('click', clearSearch);
    clearSearchEmptyButton?.addEventListener('click', clearSearch);

    document.getElementById('focusCategoryInput')?.addEventListener('click', function () {
        document.getElementById('categoryName')?.focus();
    });

    document.querySelectorAll('.delete-category-form').forEach(form => {
        form.addEventListener('submit', function (event) {
            const categoryName = this.dataset.categoryName || 'ye category';
            const productsCount = Number(this.dataset.productsCount || 0);

            let message = `"${categoryName}" delete karni hai?`;

            if (productsCount > 0) {
                message += `\n\nIs category mein abhi ${productsCount} saamaan hai.`;
                message += '\nDelete karne se saamaan ki organization par asar par sakta hai.';
            }

            message += '\n\nYe action wapas nahi ho sakta.';

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    @if($errors->any())
        document.getElementById('categoryName')?.focus();
    @endif
})();
</script>
@endpush