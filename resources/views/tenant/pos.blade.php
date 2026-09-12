<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>POS Counter | {{ auth()->user()->tenant->company_name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        till: { 50: '#EAF6F1', 100: '#CFEBE0', 200: '#9FD7C0', 300: '#6CC2A0', 400: '#3DAB80', 500: '#0E7A5C', 600: '#0B6049', 700: '#084A39', 800: '#063A2D', 900: '#052C23' },
                    },
                }
            }
        }
    </script>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --bg: #0b0f19;
            --surface: #111827;
            --surface-soft: #151f31;
            --surface-hover: #19253a;
            --input: #0c1320;

            --border: rgba(148, 163, 184, 0.16);
            --border-strong: rgba(148, 163, 184, 0.28);

            --text: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;

            --primary: #0E7A5C;
            --primary-hover: #0B6049;
            --primary-soft: rgba(14, 122, 92, 0.14);

            --success: #34d399;
            --success-soft: rgba(16, 185, 129, 0.12);

            --warning: #fbbf24;
            --warning-soft: rgba(245, 158, 11, 0.12);

            --danger: #f87171;
            --danger-soft: rgba(239, 68, 68, 0.12);
        }

        * {
            box-sizing: border-box;
            font-family: "Inter", sans-serif;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            color: var(--text);
            background: var(--bg);
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.28);
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.46);
        }

        /* =========================
           NAVBAR
        ========================== */
        .pos-navbar {
            position: sticky;
            top: 0;
            z-index: 40;
            min-height: 65px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 0 20px;
            background: rgba(11, 15, 25, 0.94);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(14px);
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            color: var(--text-secondary);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--text);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-divider {
            width: 1px;
            height: 24px;
            background: var(--border);
        }

        .pos-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pos-brand-icon {
            width: 35px;
            height: 35px;
            display: grid;
            place-items: center;
            color: white;
            background: var(--primary);
            border-radius: 10px;
        }

        .pos-brand-title {
            margin: 0;
            color: var(--text);
            font-size: 14px;
            font-weight: 800;
        }

        .pos-brand-subtitle {
            margin: 2px 0 0;
            color: var(--text-muted);
            font-size: 10px;
            font-weight: 600;
        }

        .online-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #6ee7b7;
            font-size: 11px;
            font-weight: 700;
        }

        .online-status i {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--success);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            color: white;
            background: var(--primary);
            border-radius: 50%;
            font-size: 11px;
            font-weight: 800;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 10px;
            color: #fca5a5;
            background: var(--danger-soft);
            border: 1px solid rgba(239, 68, 68, 0.18);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.18);
        }

        /* =========================
           LAYOUT
        ========================== */
        .pos-shell {
            display: block;
            padding: 12px;
        }

        .pos-panel {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
        }

        .products-panel {
            margin-bottom: 12px;
        }

        .panel-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
        }

        .panel-title {
            margin: 0;
            color: var(--text);
            font-size: 15px;
            font-weight: 800;
        }

        .panel-subtitle {
            margin: 4px 0 0;
            color: var(--text-muted);
            font-size: 11px;
        }

        .small-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 8px;
            color: var(--text-secondary);
            background: var(--surface-soft);
            border: 1px solid var(--border);
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .live-badge {
            color: #7dd3b0;
            background: var(--primary-soft);
            border-color: rgba(14, 122, 92, 0.24);
        }

        /* =========================
           SEARCH
        ========================== */
        .search-wrap {
            position: relative;
            margin-top: 14px;
        }

        .search-wrap svg {
            position: absolute;
            top: 50%;
            left: 12px;
            color: var(--text-muted);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 11px 78px 11px 38px;
            color: var(--text);
            background: var(--input);
            border: 1px solid var(--border);
            border-radius: 9px;
            outline: none;
            font-size: 13px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.14);
        }

        .search-shortcut {
            position: absolute;
            top: 50%;
            right: 11px;
            padding: 3px 6px;
            color: var(--text-secondary);
            background: var(--surface-soft);
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 10px;
            font-weight: 700;
            transform: translateY(-50%);
        }

        .clear-search {
            position: absolute;
            top: 50%;
            right: 42px;
            color: var(--text-muted);
            background: transparent;
            border: 0;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .clear-search:hover {
            color: var(--text);
        }

        /* =========================
           PRODUCT GRID
        ========================== */
        .products-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 14px;
        }

        .product-card {
            min-height: 122px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 13px;
            overflow: hidden;
            color: var(--text);
            background: var(--surface-soft);
            border: 1px solid var(--border);
            border-radius: 11px;
            text-align: left;
            cursor: pointer;
            transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease;
        }

        .product-card:hover:not(:disabled) {
            background: var(--surface-hover);
            border-color: rgba(14, 122, 92, 0.5);
            transform: translateY(-2px);
        }

        .product-card:active:not(:disabled) {
            transform: scale(0.98);
        }

        .product-card:disabled {
            opacity: 0.52;
            cursor: not-allowed;
        }

        .product-sku {
            margin: 0 0 6px;
            color: var(--text-muted);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 10px;
        }

        .product-name {
            display: -webkit-box;
            margin: 0;
            overflow: hidden;
            color: var(--text);
            font-size: 13px;
            font-weight: 700;
            line-height: 1.4;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .stock-pill {
            display: inline-flex;
            align-items: center;
            width: max-content;
            padding: 4px 7px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .stock-ok {
            color: #6ee7b7;
            background: var(--success-soft);
        }

        .stock-low {
            color: #fcd34d;
            background: var(--warning-soft);
        }

        .stock-out {
            color: #fca5a5;
            background: var(--danger-soft);
        }

        .product-price {
            color: #7dd3b0;
            font-size: 13px;
            font-weight: 800;
        }

        /* =========================
           CART
        ========================== */
        .cart-list {
            padding: 12px;
            overflow-y: auto;
        }

        .cart-item {
            padding: 12px;
            margin-bottom: 9px;
            background: var(--surface-soft);
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .cart-item:hover {
            border-color: var(--border-strong);
        }

        .cart-item-name {
            max-width: 230px;
            margin: 0;
            overflow: hidden;
            color: var(--text);
            font-size: 13px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cart-item-price {
            margin: 3px 0 0;
            color: var(--text-muted);
            font-size: 11px;
        }

        .cart-remove {
            display: grid;
            width: 28px;
            height: 28px;
            place-items: center;
            color: var(--text-muted);
            background: transparent;
            border: 0;
            border-radius: 7px;
            cursor: pointer;
        }

        .cart-remove:hover {
            color: #fca5a5;
            background: var(--danger-soft);
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            color: var(--text-secondary);
            background: var(--input);
            border: 1px solid var(--border);
            border-radius: 7px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.18s ease, color 0.18s ease;
        }

        .qty-btn:hover {
            color: white;
            background: var(--surface-hover);
            border-color: var(--border-strong);
        }

        .cart-summary {
            flex-shrink: 0;
            border-top: 1px solid var(--border);
            background: rgba(12, 19, 32, 0.62);
        }

        .cart-summary-scroll {
            max-height: 360px;
            padding: 16px;
            overflow-y: auto;
        }

        .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 9px;
            color: var(--text-secondary);
            font-size: 13px;
        }

        .summary-divider {
            height: 1px;
            margin: 13px 0;
            background: var(--border);
        }

        .total-label {
            color: var(--text-secondary);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .total-items {
            margin: 3px 0 0;
            color: var(--text-muted);
            font-size: 11px;
        }

        .grand-total {
            color: var(--text);
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.8px;
        }

        /* =========================
           FORM / PAYMENT
        ========================== */
        .form-label {
            display: block;
            margin-bottom: 7px;
            color: var(--text-secondary);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            padding: 10px 11px;
            color: var(--text);
            background: var(--input);
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            font-size: 13px;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 122, 92, 0.13);
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 7px;
            color: var(--text-secondary);
            background: var(--surface-soft);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .payment-option:hover {
            color: var(--text);
            background: var(--surface-hover);
        }

        .payment-option.active {
            color: #7dd3b0;
            background: var(--primary-soft);
            border-color: rgba(14, 122, 92, 0.52);
        }

        .points-box {
            padding: 11px;
            margin-top: 8px;
            background: var(--surface-soft);
            border: 1px solid var(--border);
            border-radius: 9px;
        }

        .checkout-wrap {
            padding: 0 16px 16px;
        }

        .checkout-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 14px 16px;
            color: #052e22;
            background: var(--success);
            border: 0;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: transform 0.18s ease, filter 0.18s ease;
        }

        .checkout-btn:hover:not(:disabled) {
            filter: brightness(1.07);
            transform: translateY(-1px);
        }

        .checkout-btn:disabled {
            color: var(--text-muted);
            background: var(--surface-soft);
            cursor: not-allowed;
        }

        /* =========================
           EMPTY STATES / TOAST
        ========================== */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 250px;
            padding: 30px;
            text-align: center;
        }

        .empty-icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            margin-bottom: 13px;
            color: #7dd3b0;
            background: var(--primary-soft);
            border-radius: 12px;
        }

        .empty-state h3 {
            margin: 0;
            color: var(--text);
            font-size: 14px;
            font-weight: 700;
        }

        .empty-state p {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 12px;
        }

        .toast {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 9px;
            max-width: 330px;
            padding: 12px 14px;
            border-radius: 10px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            font-size: 13px;
            font-weight: 600;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        .toast-success {
            color: #a7f3d0;
            background: #102c25;
            border: 1px solid rgba(16, 185, 129, 0.28);
        }

        .toast-error {
            color: #fecaca;
            background: #351820;
            border: 1px solid rgba(239, 68, 68, 0.28);
        }

        .server-alert {
            margin: 12px;
            padding: 11px 12px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
        }

        .server-alert.success {
            color: #a7f3d0;
            background: var(--success-soft);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .server-alert.error {
            color: #fecaca;
            background: var(--danger-soft);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* =========================
           DESKTOP
        ========================== */
        @media (min-width: 640px) {
            .products-list {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            body {
                height: 100vh;
                overflow: hidden;
            }

            .pos-shell {
                display: grid;
                grid-template-columns: minmax(0, 1.35fr) minmax(380px, 0.85fr);
                gap: 14px;
                height: calc(100vh - 65px);
                padding: 14px;
                overflow: hidden;
            }

            .products-panel {
                height: 100%;
                margin-bottom: 0;
            }

            .cart-panel {
                height: 100%;
            }

            .products-list {
                flex: 1;
                min-height: 0;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                overflow-y: auto;
            }

            .cart-list {
                flex: 1;
                min-height: 0;
                overflow-y: auto;
            }
        }

        @media (min-width: 1280px) {
            .products-list {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .pos-navbar {
                padding: 0 12px;
            }

            .products-list {
                padding: 10px;
            }

            .panel-header {
                padding: 13px;
            }

            .product-card {
                min-height: 112px;
                padding: 11px;
            }

            .cart-summary-scroll {
                max-height: none;
            }
        }
    </style>
</head>

<body data-currency-symbol="{{ auth()->user()->tenant->currencySymbol() }}">

    {{-- ==================== TOP NAV ==================== --}}
    <nav class="pos-navbar">

        <div class="flex min-w-0 items-center gap-2 sm:gap-3">
            @unless(auth()->user()->isCashier())
                <a href="{{ route('tenant.dashboard') }}" class="nav-link" title="Dashboard par wapas jayein">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>

                    <span class="hidden sm:inline">Dashboard</span>
                </a>

                <span class="nav-divider"></span>
            @endunless

            <a href="{{ route('tenant.orders.index') }}" class="nav-link" title="Orders dekhein">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>

                <span class="hidden sm:inline">Orders</span>
            </a>

            <span class="nav-divider hidden sm:block"></span>

            <div class="pos-brand">
                <div class="pos-brand-icon">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>

                <div class="hidden sm:block">
                    <p class="pos-brand-title">POS Counter</p>
                    <p class="pos-brand-subtitle">{{ auth()->user()->tenant->company_name }}</p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <div class="online-status hidden md:flex">
                <i></i>
                System chalu hai
            </div>

            <div class="hidden text-right sm:block">
                <p class="text-xs font-semibold text-white">{{ auth()->user()->name }}</p>
                <p class="mt-0.5 text-[10px] capitalize text-slate-500">{{ auth()->user()->role }}</p>
            </div>

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout-btn" title="Logout karein">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>

                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    {{-- ==================== POS WORKSPACE ==================== --}}
    <main class="pos-shell">

        {{-- PRODUCTS --}}
        <section class="pos-panel products-panel">

            <div class="panel-header">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="panel-title">Saamaan</h1>

                            <span class="small-badge">
                                {{ $products->count() }} mojood
                            </span>
                        </div>

                        <p class="panel-subtitle">
                            Saamaan par click karein, sale mein shamil ho jayega.
                        </p>
                    </div>

                    <p class="hidden pt-1 text-[11px] text-slate-500 sm:block">
                        Search ke liye F2 dabayein
                    </p>
                </div>

                <div class="search-wrap">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-5.2-5.2m2.2-5.3a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"/>
                    </svg>

                    <input
                        type="search"
                        id="productSearch"
                        class="search-input"
                        placeholder="Naam, SKU ya barcode se search karein..."
                        autocomplete="off"
                    >

                    <button id="clearSearch" type="button" class="clear-search hidden" title="Search saaf karein">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <span class="search-shortcut">F2</span>
                </div>
            </div>

            <div id="productsGrid" class="products-list">
                @forelse($products as $product)
                    @php
                        $stock = (int) $product->stock_quantity;

                        $stockClass = $stock <= 0
                            ? 'stock-out'
                            : ($stock <= 5 ? 'stock-low' : 'stock-ok');

                        $stockLabel = $stock <= 0
                            ? 'Stock khatam'
                            : 'Stock: ' . $stock;
                    @endphp

                    <button
                        type="button"
                        class="product-card {{ $stock <= 0 ? 'opacity-50' : '' }}"
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}"
                        data-product-price="{{ (float) $product->price }}"
                        data-product-stock="{{ $stock }}"
                        data-product-sku="{{ $product->sku ?? '' }}"
                        @disabled($stock <= 0)
                    >
                        <div>
                            <p class="product-sku">{{ $product->sku ?: 'SKU nahi' }}</p>
                            <p class="product-name">{{ $product->name }}</p>
                        </div>

                        <div class="mt-3 flex items-center justify-between gap-2">
                            <span class="stock-pill {{ $stockClass }}">
                                {{ $stockLabel }}
                            </span>

                            <span class="product-price">
                                {{ auth()->user()->tenant->formatMoney($product->price, 0) }}
                            </span>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full empty-state">
                        <div class="empty-icon">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>

                        <h3>Koi saamaan mojood nahi</h3>
                        <p>Sale banane se pehle inventory dashboard se saamaan add karein.</p>
                    </div>
                @endforelse

                <div id="noProductResults" class="col-span-full empty-state hidden">
                    <div class="empty-icon">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M21 21l-5-5m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <h3>Koi saamaan nahi mila</h3>
                    <p>Koi aur naam, SKU, ya barcode try karein.</p>
                </div>
            </div>
        </section>

        {{-- CART --}}
        <section class="pos-panel cart-panel">

            <div class="panel-header flex items-start justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="panel-title">Yeh Sale</h2>
                        <span class="small-badge live-badge">LIVE</span>
                    </div>

                    <p class="panel-subtitle">
                        Saamaan add karein aur payment complete karein.
                    </p>
                </div>

                <button
                    type="button"
                    id="clearCartButton"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-red-500/20 bg-red-500/10 px-2.5 py-2 text-[11px] font-bold text-red-300 transition hover:bg-red-500/15"
                >
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Saaf Karein
                </button>
            </div>

            @if(session('success'))
                <div class="server-alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="server-alert error">
                    {{ session('error') }}
                </div>
            @endif

            <div id="cartContainer" class="cart-list">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.63.63-.18 1.7.71 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>

                    <h3>Cart khali hai</h3>
                    <p>Bayen taraf se saamaan select karein, yahan add ho jayega.</p>
                </div>
            </div>

            {{-- CART SUMMARY --}}
            <div class="cart-summary">

                <div class="cart-summary-scroll">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong id="subtotal">{{ auth()->user()->tenant->formatMoney(0) }}</strong>
                    </div>

                    <div id="discountRow" class="summary-row hidden">
                        <span class="text-emerald-400">Points ka discount</span>
                        <strong id="discountAmount" class="text-emerald-400">
                            -{{ auth()->user()->tenant->formatMoney(0) }}
                        </strong>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="total-label">Kul Rakam</p>
                            <p id="itemsCount" class="total-items">0 items in cart</p>
                        </div>

                        <strong id="grandTotal" class="grand-total">
                            {{ auth()->user()->tenant->formatMoney(0) }}
                        </strong>
                    </div>

                    <div class="summary-divider"></div>

                    {{-- Customer --}}
                    <div>
                        <label for="customerSelect" class="form-label">
                            Customer <span class="normal-case tracking-normal text-slate-600">(zaroori nahi)</span>
                        </label>

                        <select id="customerSelect" class="form-input">
                            <option value="">Aam Customer</option>

                            @foreach($customers as $customer)
                                <option
                                    value="{{ $customer->id }}"
                                    data-points="{{ $customer->loyalty_points }}"
                                >
                                    {{ $customer->name }} ({{ $customer->loyalty_points }} points)
                                </option>
                            @endforeach
                        </select>

                        <div id="pointsRedeemBox" class="points-box hidden">
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-[11px] text-slate-400">
                                    Mojooda points:
                                    <strong id="availablePoints" class="text-white">0</strong>
                                </span>

                                <span class="text-[10px] text-slate-600">
                                    1 point = {{ auth()->user()->tenant->currencySymbol() }} 1
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <input
                                    type="number"
                                    id="redeemPointsInput"
                                    min="50"
                                    step="1"
                                    value="0"
                                    placeholder="Points use karein"
                                    class="form-input"
                                >

                                <span class="whitespace-nowrap text-[11px] text-slate-400">
                                    = <span id="redeemValue">0</span> off
                                </span>
                            </div>

                            <p id="redeemMessage" class="mt-2 text-[10px] text-slate-500">
                                Kam se kam 50 points zaroori hain.
                            </p>
                        </div>
                    </div>

                    {{-- Payment --}}
                    <div class="mt-4">
                        <label class="form-label">Payment Ka Tareeqa</label>

                        <div class="payment-grid">
                            <button type="button" class="payment-option active" data-payment="cash">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Cash
                            </button>

                            <button type="button" class="payment-option" data-payment="card">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                </svg>
                                Card
                            </button>

                            <button type="button" class="payment-option" data-payment="jazzcash">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                JazzCash
                            </button>

                            <button type="button" class="payment-option" data-payment="credit">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2 2v14a2 2 0 002 2v14a2 2 0 002 2z"/>
                                </svg>
                                Credit / Udhaar
                            </button>
                        </div>

                        <p id="creditWarning" class="mt-2 hidden text-[11px] text-amber-300">
                            Credit sale banane se pehle customer select karein.
                        </p>
                    </div>
                </div>

                {{-- Checkout Form --}}
                <div class="checkout-wrap">
                    <form id="checkoutForm" action="{{ route('tenant.pos.checkout') }}" method="POST">
                        @csrf

                        <input type="hidden" name="cart" id="cartHiddenInput">
                        <input type="hidden" name="payment_method" id="paymentMethodInput" value="cash">
                        <input type="hidden" name="customer_id" id="customerIdInput">
                        <input type="hidden" name="redeem_points" id="redeemPointsHiddenInput" value="0">

                        <button type="submit" id="checkoutButton" class="checkout-btn" disabled>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>

                            <span id="checkoutButtonText">Add items to checkout</span>
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <script>
        let cart = [];
        let selectedPayment = 'cash';

        const CURRENCY = document.body.dataset.currencySymbol || 'Rs.';

        const cartContainer = document.getElementById('cartContainer');
        const productSearch = document.getElementById('productSearch');
        const clearSearch = document.getElementById('clearSearch');
        const noProductResults = document.getElementById('noProductResults');

        const subtotalElement = document.getElementById('subtotal');
        const grandTotalElement = document.getElementById('grandTotal');
        const itemsCountElement = document.getElementById('itemsCount');

        const cartHiddenInput = document.getElementById('cartHiddenInput');
        const paymentMethodInput = document.getElementById('paymentMethodInput');
        const customerIdInput = document.getElementById('customerIdInput');
        const redeemPointsHiddenInput = document.getElementById('redeemPointsHiddenInput');

        const checkoutButton = document.getElementById('checkoutButton');
        const checkoutButtonText = document.getElementById('checkoutButtonText');

        const customerSelect = document.getElementById('customerSelect');
        const pointsRedeemBox = document.getElementById('pointsRedeemBox');
        const availablePointsElement = document.getElementById('availablePoints');
        const redeemPointsInput = document.getElementById('redeemPointsInput');
        const redeemValueElement = document.getElementById('redeemValue');
        const redeemMessage = document.getElementById('redeemMessage');

        const discountRow = document.getElementById('discountRow');
        const discountAmount = document.getElementById('discountAmount');
        const creditWarning = document.getElementById('creditWarning');

        function formatMoney(amount) {
            const numericAmount = Number(amount || 0);

            return `${CURRENCY} ${numericAmount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`;
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function getSubtotal() {
            return cart.reduce((total, item) => {
                return total + (Number(item.price) * Number(item.quantity));
            }, 0);
        }

        function getSelectedCustomerPoints() {
            const selectedOption = customerSelect.options[customerSelect.selectedIndex];

            return Number(selectedOption?.dataset?.points || 0);
        }

        function getRedeemPoints() {
            const customerId = customerSelect.value;
            const availablePoints = getSelectedCustomerPoints();
            const subtotal = getSubtotal();

            if (!customerId || availablePoints < 50 || subtotal <= 0) {
                return 0;
            }

            let requestedPoints = Number(redeemPointsInput.value || 0);

            if (requestedPoints < 50) {
                return 0;
            }

            requestedPoints = Math.min(requestedPoints, availablePoints);
            requestedPoints = Math.min(requestedPoints, Math.floor(subtotal));

            return requestedPoints;
        }

        function updateRedeemPreview() {
            const rawPoints = Number(redeemPointsInput.value || 0);
            const availablePoints = getSelectedCustomerPoints();
            const effectivePoints = getRedeemPoints();

            if (rawPoints > availablePoints) {
                redeemPointsInput.value = availablePoints;
            }

            redeemValueElement.textContent = effectivePoints;
            redeemPointsHiddenInput.value = effectivePoints;

            if (rawPoints > 0 && rawPoints < 50) {
                redeemMessage.textContent = 'Kam se kam 50 points darj karein.';
                redeemMessage.style.color = '#fcd34d';
            } else if (effectivePoints > 0) {
                redeemMessage.textContent = `${effectivePoints} points is sale mein use honge.`;
                redeemMessage.style.color = '#6ee7b7';
            } else {
                redeemMessage.textContent = 'Kam se kam 50 points zaroori hain.';
                redeemMessage.style.color = '';
            }

            updateTotals();
            syncCheckoutButton();
        }

        function updateTotals() {
            const subtotal = getSubtotal();
            const discount = getRedeemPoints();
            const total = Math.max(subtotal - discount, 0);

            subtotalElement.textContent = formatMoney(subtotal);
            grandTotalElement.textContent = formatMoney(total);

            if (discount > 0) {
                discountRow.classList.remove('hidden');
                discountAmount.textContent = `-${formatMoney(discount)}`;
            } else {
                discountRow.classList.add('hidden');
            }
        }

        function syncCheckoutButton() {
            const customerId = customerSelect.value;
            const subtotal = getSubtotal();

            const creditWithoutCustomer = selectedPayment === 'credit' && !customerId;

            creditWarning.classList.toggle('hidden', !creditWithoutCustomer);

            if (cart.length === 0) {
                checkoutButton.disabled = true;
                checkoutButtonText.textContent = 'Checkout ke liye saamaan add karein';
                return;
            }

            if (creditWithoutCustomer) {
                checkoutButton.disabled = true;
                checkoutButtonText.textContent = 'Credit sale ke liye customer select karein';
                return;
            }

            checkoutButton.disabled = false;
            checkoutButtonText.textContent = `Sale Complete Karein · ${formatMoney(subtotal - getRedeemPoints())}`;
        }

        function renderCart() {
            if (cart.length === 0) {
                cartContainer.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.63.63-.18 1.7.71 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>

                        <h3>Cart khali hai</h3>
                        <p>Bayen taraf se saamaan select karein, yahan add ho jayega.</p>
                    </div>
                `;

                cartHiddenInput.value = '';
                itemsCountElement.textContent = '0 cheezein cart mein';

                updateTotals();
                syncCheckoutButton();

                return;
            }

            let totalItems = 0;
            let html = '';

            cart.forEach(item => {
                const quantity = Number(item.quantity);
                const price = Number(item.price);
                const itemTotal = price * quantity;

                totalItems += quantity;

                html += `
                    <div class="cart-item">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="cart-item-name">${escapeHtml(item.name)}</p>
                                <p class="cart-item-price">
                                    ${formatMoney(price)} × ${quantity}
                                </p>
                            </div>

                            <button
                                type="button"
                                class="cart-remove"
                                data-cart-action="remove"
                                data-item-id="${item.id}"
                                title="Item hatayein"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <div class="quantity-control">
                                <button
                                    type="button"
                                    class="qty-btn"
                                    data-cart-action="decrease"
                                    data-item-id="${item.id}"
                                >
                                    −
                                </button>

                                <span class="w-6 text-center text-sm font-bold">${quantity}</span>

                                <button
                                    type="button"
                                    class="qty-btn"
                                    data-cart-action="increase"
                                    data-item-id="${item.id}"
                                >
                                    +
                                </button>
                            </div>

                            <strong class="text-sm text-till-300">
                                ${formatMoney(itemTotal)}
                            </strong>
                        </div>
                    </div>
                `;
            });

            cartContainer.innerHTML = html;

            cartHiddenInput.value = JSON.stringify(cart);
            itemsCountElement.textContent = `${totalItems} cheezein cart mein`;

            updateTotals();
            syncCheckoutButton();
        }

        function addToCart(id, name, price, maxStock) {
            id = Number(id);
            price = Number(price);
            maxStock = Number(maxStock);

            const existingItem = cart.find(item => Number(item.id) === id);

            if (existingItem) {
                if (Number(existingItem.quantity) >= maxStock) {
                    showToast(`"${name}" ka stock khatam ho gaya`, 'error');
                    return;
                }

                existingItem.quantity++;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    quantity: 1,
                    maxStock: maxStock
                });
            }

            renderCart();
            showToast(`${name} cart mein add ho gaya`, 'success');
        }

        function removeItem(id) {
            cart = cart.filter(item => Number(item.id) !== Number(id));
            renderCart();
        }

        function changeQuantity(id, change) {
            const item = cart.find(item => Number(item.id) === Number(id));

            if (!item) {
                return;
            }

            const newQuantity = Number(item.quantity) + Number(change);

            if (newQuantity <= 0) {
                removeItem(id);
                return;
            }

            if (newQuantity > Number(item.maxStock)) {
                showToast(`"${item.name}" ka poora stock cart mein hai`, 'error');
                return;
            }

            item.quantity = newQuantity;
            renderCart();
        }

        function clearCart() {
            if (!cart.length) {
                return;
            }

            cart = [];
            renderCart();
            showToast('Cart saaf kar diya gaya', 'success');
        }

        function selectPayment(method) {
            selectedPayment = method;
            paymentMethodInput.value = method;

            document.querySelectorAll('[data-payment]').forEach(button => {
                button.classList.toggle('active', button.dataset.payment === method);
            });

            syncCheckoutButton();
        }

        function onCustomerChange() {
            const customerId = customerSelect.value;
            const availablePoints = getSelectedCustomerPoints();

            customerIdInput.value = customerId;

            if (customerId && availablePoints >= 50) {
                pointsRedeemBox.classList.remove('hidden');

                availablePointsElement.textContent = availablePoints;
                redeemPointsInput.max = availablePoints;
            } else {
                pointsRedeemBox.classList.add('hidden');

                redeemPointsInput.value = 0;
                redeemPointsHiddenInput.value = 0;
            }

            updateRedeemPreview();
            syncCheckoutButton();
        }

        function filterProducts() {
            const query = productSearch.value.trim().toLowerCase();
            const products = document.querySelectorAll('.product-card[data-product-id]');

            let visibleCount = 0;

            products.forEach(product => {
                const name = (product.dataset.productName || '').toLowerCase();
                const sku = (product.dataset.productSku || '').toLowerCase();

                const matches = name.includes(query) || sku.includes(query);

                product.hidden = !matches;

                if (matches) {
                    visibleCount++;
                }
            });

            noProductResults.classList.toggle('hidden', visibleCount > 0 || products.length === 0);
            clearSearch.classList.toggle('hidden', !query);
        }

        function showToast(message, type = 'success') {
            document.querySelectorAll('.toast').forEach(toast => toast.remove());

            const toast = document.createElement('div');

            toast.className = `toast ${type === 'success' ? 'toast-success' : 'toast-error'}`;

            const icon = type === 'success'
                ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>`;

            toast.innerHTML = `
                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icon}
                </svg>
                <span>${escapeHtml(message)}</span>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(20px)';

                setTimeout(() => toast.remove(), 250);
            }, 2400);
        }

        /* Product Click */
        document.querySelectorAll('.product-card[data-product-id]').forEach(button => {
            button.addEventListener('click', function () {
                if (this.disabled) {
                    return;
                }

                addToCart(
                    this.dataset.productId,
                    this.dataset.productName,
                    this.dataset.productPrice,
                    this.dataset.productStock
                );
            });
        });

        /* Cart Actions */
        cartContainer.addEventListener('click', function (event) {
            const button = event.target.closest('[data-cart-action]');

            if (!button) {
                return;
            }

            const itemId = button.dataset.itemId;
            const action = button.dataset.cartAction;

            if (action === 'remove') {
                removeItem(itemId);
            }

            if (action === 'increase') {
                changeQuantity(itemId, 1);
            }

            if (action === 'decrease') {
                changeQuantity(itemId, -1);
            }
        });

        /* Search */
        productSearch.addEventListener('input', filterProducts);

        clearSearch.addEventListener('click', function () {
            productSearch.value = '';
            filterProducts();
            productSearch.focus();
        });

        /* Clear Cart */
        document.getElementById('clearCartButton').addEventListener('click', clearCart);

        /* Customer */
        customerSelect.addEventListener('change', onCustomerChange);

        /* Loyalty points */
        redeemPointsInput.addEventListener('input', updateRedeemPreview);

        /* Payment methods */
        document.querySelectorAll('[data-payment]').forEach(button => {
            button.addEventListener('click', function () {
                selectPayment(this.dataset.payment);
            });
        });

        /* Checkout validation */
        document.getElementById('checkoutForm').addEventListener('submit', function (event) {
            if (!cart.length) {
                event.preventDefault();
                showToast('Checkout se pehle saamaan add karein.', 'error');
                return;
            }

            if (selectedPayment === 'credit' && !customerSelect.value) {
                event.preventDefault();
                showToast('Credit sale ke liye customer select karein.', 'error');
                return;
            }

            cartHiddenInput.value = JSON.stringify(cart);
            paymentMethodInput.value = selectedPayment;
            customerIdInput.value = customerSelect.value;
            redeemPointsHiddenInput.value = getRedeemPoints();
        });

        /* Keyboard shortcuts */
        document.addEventListener('keydown', function (event) {
            if (event.key === 'F2') {
                event.preventDefault();
                productSearch.focus();
            }

            if (event.key === 'Escape') {
                if (productSearch.value) {
                    productSearch.value = '';
                    filterProducts();
                    return;
                }

                if (cart.length) {
                    clearCart();
                }
            }
        });

        /* Auto hide server alerts */
        document.querySelectorAll('.server-alert').forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';

                setTimeout(() => alert.remove(), 300);
            }, 4500);
        });

        /* First render */
        renderCart();
    </script>
</body>
</html>