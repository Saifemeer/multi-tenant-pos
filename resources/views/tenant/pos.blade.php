<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Counter | {{ auth()->user()->tenant->company_name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg:#0b1020;
            --bg-2:#0f1530;
            --panel:#121a36;
            --panel-2:#0e1530;
            --border:#1e2748;
            --border-2:#2a3566;
            --text:#e6ecff;
            --muted:#8a93b8;
            --muted-2:#6b7599;
            --brand:#4f8cff;
            --brand-2:#6aa2ff;
            --brand-glow:rgba(79,140,255,.18);
            --success:#22c58a;
            --success-2:#34d39a;
            --danger:#ef5a6b;
            --amber:#f5b544;
        }
        *{font-family:'Inter',sans-serif;}
        html,body{background:radial-gradient(1200px 600px at 10% -10%,rgba(79,140,255,.08),transparent 60%),radial-gradient(900px 500px at 100% 0%,rgba(34,197,138,.06),transparent 60%),var(--bg);}

        ::-webkit-scrollbar{width:8px;height:8px;}
        ::-webkit-scrollbar-track{background:transparent;}
        ::-webkit-scrollbar-thumb{background:#26305a;border-radius:8px;}
        ::-webkit-scrollbar-thumb:hover{background:#33407a;}

        @keyframes fadeIn{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:none;}}
        @keyframes slideIn{from{opacity:0;transform:translateX(14px);}to{opacity:1;transform:none;}}
        @keyframes popIn{0%{transform:scale(.9);opacity:0;}70%{transform:scale(1.03);}100%{transform:scale(1);opacity:1;}}
        .animate-fade-in{animation:fadeIn .35s ease-out both;}
        .animate-slide-in{animation:slideIn .35s ease-out both;}
        .animate-pop{animation:popIn .28s ease-out both;}

        .panel{
            background:linear-gradient(180deg,var(--panel) 0%,var(--panel-2) 100%);
            border:1px solid var(--border);
            border-radius:20px;
            box-shadow:0 20px 40px -30px rgba(0,0,0,.6),inset 0 1px 0 rgba(255,255,255,.02);
        }

        .product-btn{
            position:relative;
            background:linear-gradient(180deg,#141c3d,#101736);
            border:1px solid var(--border);
            border-radius:16px;
            padding:14px;
            text-align:left;
            transition:transform .18s ease,border-color .18s ease,box-shadow .18s ease,background .18s ease;
            cursor:pointer;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            min-height:118px;
            overflow:hidden;
        }
        .product-btn::before{
            content:"";
            position:absolute;inset:0;
            background:radial-gradient(120% 60% at 0% 0%,rgba(79,140,255,.12),transparent 60%);
            opacity:0;transition:opacity .2s ease;
            pointer-events:none;
        }
        .product-btn:hover{
            border-color:var(--brand);
            transform:translateY(-3px);
            box-shadow:0 14px 30px -12px rgba(79,140,255,.35);
        }
        .product-btn:hover::before{opacity:1;}
        .product-btn:active{transform:scale(.97);}
        .product-btn.out{opacity:.5;filter:grayscale(.3);cursor:not-allowed;}
        .product-btn.out:hover{transform:none;border-color:var(--border);box-shadow:none;}

        .cart-item{
            background:#111a3a;
            border:1px solid var(--border);
            border-radius:14px;
            padding:12px 12px 10px;
            transition:border-color .18s ease,background .18s ease;
            animation:popIn .28s ease-out;
        }
        .cart-item:hover{border-color:var(--border-2);background:#132048;}

        .qty-btn{
            width:30px;height:30px;
            display:flex;align-items:center;justify-content:center;
            border-radius:9px;
            background:#1a2350;color:#c9d2ff;
            font-weight:700;font-size:15px;line-height:1;
            transition:background .15s ease,color .15s ease,transform .1s ease;
            cursor:pointer;border:1px solid #26305a;
        }
        .qty-btn:hover{background:#2a3874;color:#fff;}
        .qty-btn:active{transform:scale(.92);}

        .checkout-btn{
            width:100%;
            padding:16px 18px;
            background:linear-gradient(135deg,var(--success),var(--success-2));
            color:#062018;
            font-weight:800;font-size:15px;letter-spacing:.2px;
            border-radius:14px;border:none;cursor:pointer;
            transition:transform .2s ease,box-shadow .2s ease,filter .2s ease;
            display:flex;align-items:center;justify-content:center;gap:10px;
            box-shadow:0 10px 30px -10px rgba(34,197,138,.5);
        }
        .checkout-btn:hover:not(:disabled){transform:translateY(-2px);filter:brightness(1.05);box-shadow:0 16px 34px -10px rgba(34,197,138,.55);}
        .checkout-btn:disabled{background:#1a2350;color:#5e6795;cursor:not-allowed;box-shadow:none;}

        .pay-chip{
            display:flex;align-items:center;justify-content:center;gap:6px;
            padding:10px 8px;border-radius:12px;
            border:1px solid var(--border);
            background:#111a3a;color:var(--muted);
            font-size:12.5px;font-weight:600;
            cursor:pointer;transition:all .18s ease;
        }
        .pay-chip:hover{border-color:var(--border-2);color:#dfe5ff;background:#132048;}
        .pay-chip.active{
            border-color:var(--brand);
            background:linear-gradient(180deg,rgba(79,140,255,.18),rgba(79,140,255,.06));
            color:var(--brand-2);
            box-shadow:0 6px 18px -8px rgba(79,140,255,.6);
        }

        .toast{position:fixed;top:22px;right:22px;z-index:100;animation:slideIn .28s ease-out;}

        .kbd{
            display:inline-flex;align-items:center;justify-content:center;
            padding:2px 6px;border-radius:6px;
            background:#111a3a;border:1px solid var(--border-2);
            font-size:11px;color:#c9d2ff;font-weight:600;
            font-family:'JetBrains Mono',ui-monospace,monospace;
        }

        .divider{height:1px;background:linear-gradient(90deg,transparent,var(--border),transparent);}
        .stock-pill{font-size:11px;font-weight:600;padding:3px 8px;border-radius:999px;}
        .stock-ok{background:rgba(34,197,138,.12);color:#5ee1ac;}
        .stock-low{background:rgba(245,181,68,.14);color:#f5c56e;}
        .stock-out{background:rgba(239,90,107,.14);color:#ff8a97;}
    </style>
</head>
<body class="h-screen text-white flex flex-col overflow-hidden" style="color:var(--text);" data-currency-symbol="{{ auth()->user()->tenant->currencySymbol() }}">

    <!-- NAVBAR -->
    <nav class="px-5 py-3 flex items-center justify-between flex-shrink-0 border-b"
         style="background:rgba(15,21,48,.75);backdrop-filter:blur(10px);border-color:var(--border);">
       <div class="flex items-center gap-3">
            @unless(auth()->user()->isCashier())
            <a href="{{ route('tenant.dashboard') }}"
               class="flex items-center gap-2 px-2.5 py-2 rounded-xl transition-colors group"
               style="color:var(--muted);">
                <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium hidden sm:inline">Dashboard</span>
            </a>
            <div class="w-px h-7" style="background:var(--border);"></div>
            @endunless

            <!-- ✅ NAYA: Orders link — sab roles ke liye visible -->
            <a href="{{ route('tenant.orders.index') }}"
               class="flex items-center gap-2 px-2.5 py-2 rounded-xl transition-colors group"
               style="color:var(--muted);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="text-sm font-medium hidden sm:inline">Orders</span>
            </a>
            <div class="w-px h-7" style="background:var(--border);"></div>

            

        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-1.5 text-[11.5px]" style="color:var(--muted);">
                <span>Shortcuts:</span>
                <span class="kbd">F2</span><span>Search</span>
                <span class="kbd">Esc</span><span>Clear</span>
            </div>

            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="text-[11px] capitalize" style="color:var(--muted);">{{ auth()->user()->role }}</p>
            </div>
            <div class="w-9 h-9 rounded-full flex items-center justify-center text-[12.5px] font-bold text-white"
                 style="background:linear-gradient(135deg,#4f8cff,#7a5cff);">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 px-3 py-2 rounded-xl transition-all text-sm font-semibold"
                        style="background:rgba(239,90,107,.1);border:1px solid rgba(239,90,107,.25);color:#ff8a97;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden sm:inline">Sign Out</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- MAIN WORKSPACE -->
    <div class="flex-1 grid grid-cols-1 lg:grid-cols-12 gap-4 p-4 overflow-hidden min-h-0">

        <!-- LEFT: Products -->
        <div class="lg:col-span-7 panel flex flex-col overflow-hidden min-h-0 animate-fade-in">

            <!-- Products Header -->
            <div class="p-4 border-b flex-shrink-0" style="border-color:var(--border);">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <h2 class="text-[15px] font-bold">Products</h2>
                        <span class="text-[11px] px-2.5 py-0.5 rounded-full"
                              style="background:#111a3a;border:1px solid var(--border-2);color:var(--muted);">
                            {{ $products->count() }} available
                        </span>
                    </div>
                    <span class="hidden sm:inline text-[11.5px]" style="color:var(--muted);">
                        Tap a product to add to bill
                    </span>
                </div>

                <!-- Search Bar -->
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="productSearch"
                           placeholder="Search by name, SKU or barcode…"
                           class="w-full pl-10 pr-16 py-3 rounded-xl text-sm focus:outline-none focus:ring-2 placeholder-gray-500"
                           style="background:#101636;border:1px solid var(--border);color:#e6ecff;--tw-ring-color:var(--brand);">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 kbd">F2</span>
                </div>
            </div>

            <!-- Product Grid -->
            <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 p-4 overflow-y-auto flex-1 min-h-0">
                @forelse($products as $product)
                    @php
                        $stock = (int)$product->stock_quantity;
                        $stockClass = $stock <= 0 ? 'stock-out' : ($stock <= 5 ? 'stock-low' : 'stock-ok');
                        $stockLabel = $stock <= 0 ? 'Out of stock' : 'Stock · '.$stock;
                    @endphp
                    <button class="product-btn animate-fade-in {{ $stock <= 0 ? 'out' : '' }}"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-stock="{{ $product->stock_quantity }}"
                            data-sku="{{ $product->sku }}"
                            @if($stock > 0)
                            onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock_quantity }})"
                            @else disabled @endif>

                        <div>
                            <p class="text-[10.5px] font-mono mb-1" style="color:var(--muted-2);">{{ $product->sku ?? 'No SKU' }}</p>
                            <p class="font-bold text-[13.5px] leading-snug line-clamp-2">{{ $product->name }}</p>
                        </div>

                        <div class="flex items-center justify-between mt-3">
                            <span class="stock-pill {{ $stockClass }}">{{ $stockLabel }}</span>
                            <span class="font-black text-[14px]" style="color:var(--brand-2);">
    {{ auth()->user()->tenant->formatMoney($product->price, 0) }}
</span>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                             style="background:#111a3a;border:1px solid var(--border);">
                            <svg class="w-8 h-8" style="color:var(--muted-2);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <p class="font-semibold" style="color:#c9d2ff;">No products available</p>
                        <p class="text-sm mt-1" style="color:var(--muted);">Add products from the dashboard</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- RIGHT: Bill / Cart -->
        <div class="lg:col-span-5 panel flex flex-col overflow-hidden min-h-0 animate-slide-in">

            <!-- Bill Header -->
            <div class="p-4 border-b flex items-center justify-between flex-shrink-0" style="border-color:var(--border);">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-[15px] font-bold">Current Bill</h2>
                        <span class="text-[10.5px] px-2 py-0.5 rounded-full"
                              style="background:rgba(79,140,255,.12);color:var(--brand-2);border:1px solid rgba(79,140,255,.3);">
                            LIVE
                        </span>
                    </div>
                    <p class="text-[11.5px] mt-0.5" style="color:var(--muted);">
                        Invoice #{{ str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) }}
                    </p>
                </div>
                <button onclick="clearCart()"
                        class="flex items-center gap-1.5 text-[12px] px-3 py-2 rounded-lg transition-all font-semibold"
                        style="background:rgba(239,90,107,.1);border:1px solid rgba(239,90,107,.2);color:#ff8a97;">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Clear
                </button>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mx-4 mt-4 p-3 rounded-xl text-sm flex items-center gap-2 flex-shrink-0"
                     style="background:rgba(34,197,138,.1);border:1px solid rgba(34,197,138,.3);color:#5ee1ac;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mx-4 mt-4 p-3 rounded-xl text-sm flex items-center gap-2 flex-shrink-0"
                     style="background:rgba(239,90,107,.1);border:1px solid rgba(239,90,107,.3);color:#ff8a97;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Cart Items (independently scrollable) -->
            <div id="cart-container" class="flex-1 p-4 space-y-2 overflow-y-auto min-h-0">
                <div id="empty-cart" class="flex flex-col items-center justify-center h-full py-12 text-center">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                         style="background:#111a3a;border:1px solid var(--border);">
                        <svg class="w-8 h-8" style="color:var(--muted-2);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="font-semibold" style="color:#c9d2ff;">Cart is empty</p>
                    <p class="text-sm mt-1" style="color:var(--muted);">Click on products to add them</p>
                </div>
            </div>

            <!-- Total + Checkout (always visible, never pushed off-screen) -->
            <div class="border-t flex flex-col flex-shrink-0" style="border-color:var(--border);background:rgba(11,16,32,.5);max-height:60vh;">

                <!-- Scrollable middle section: price, customer, payment -->
                <div class="overflow-y-auto p-4 space-y-4 min-h-0">

                    <!-- Price Breakdown -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span style="color:var(--muted);">Subtotal</span>
                            <span id="subtotal" class="font-medium" style="color:#dfe5ff;">{{ auth()->user()->tenant->formatMoney(0) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span style="color:var(--muted);">Tax (0%)</span>
                            <span style="color:#dfe5ff;">Rs. 0.00</span>
                        </div>
                        <div class="divider my-1"></div>
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-[11.5px] uppercase tracking-wider" style="color:var(--muted);">Grand Total</span>
                                <p class="text-[11px]" id="items-count" style="color:var(--muted-2);">0 items in cart</p>
                            </div>
                           <span id="grand-total" class="text-3xl font-black leading-none">{{ auth()->user()->tenant->formatMoney(0) }}</span>
                        </div>
                    </div>

                    <!-- Customer Selection -->
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider mb-2" style="color:var(--muted);">
                            Customer (Optional)
                        </label>
                        <select id="customerSelect" onchange="onCustomerChange()"
                                class="w-full px-3 py-2.5 rounded-xl text-sm"
                                style="background:#101636;border:1px solid var(--border);color:#e6ecff;">
                            <option value="">Walk-in Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" data-points="{{ $customer->loyalty_points }}">
                                    {{ $customer->name }} ({{ $customer->loyalty_points }} points)
                                </option>
                            @endforeach
                        </select>

                        <div id="pointsRedeemBox" class="hidden mt-2 p-3 rounded-xl" style="background:#111a3a;border:1px solid var(--border);">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[11.5px]" style="color:var(--muted);">Available points: <span id="availablePoints">0</span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="number" id="redeemPointsInput" min="0" value="0"
                                       placeholder="Points to redeem"
                                       class="flex-1 px-3 py-2 rounded-lg text-sm"
                                       style="background:#0e1530;border:1px solid var(--border);color:#e6ecff;"
                                       oninput="updateRedeemPreview()">
                                <span class="text-[11px]" style="color:var(--muted);">= {{ auth()->user()->tenant->currencySymbol() }} <span id="redeemValue">0</span> off</span>
                            </div>
                            <p class="text-[10.5px] mt-1.5" style="color:var(--muted-2);">Minimum 50 points required to redeem</p>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider mb-2" style="color:var(--muted);">
                            Payment Method
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" onclick="selectPayment('cash', this)" class="pay-chip active" data-pay="cash">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Cash
                            </button>
                            <button type="button" onclick="selectPayment('card', this)" class="pay-chip" data-pay="card">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>
                                </svg>
                                Card
                            </button>
                            <button type="button" onclick="selectPayment('jazzcash', this)" class="pay-chip" data-pay="jazzcash">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                JazzCash
                            </button>
                            <button type="button" onclick="selectPayment('credit', this)" class="pay-chip" data-pay="credit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Credit (Udhaar)
                            </button>
                        </div>
                        <p id="creditWarning" class="hidden text-[11px] mt-2 px-1" style="color:#f5c56e;">
                            ⚠️ Udhaar dene ke liye upar customer select karna zaroori hai.
                        </p>
                    </div>

                </div>

                <!-- Checkout button — hamesha bottom pe fixed, kabhi neeche nahi jayega -->
                <div class="p-4 pt-0 flex-shrink-0">
                    <form action="{{ route('tenant.pos.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart" id="cart-hidden-input">
                        <input type="hidden" name="payment_method" id="payment-method" value="cash">
                        <input type="hidden" name="customer_id" id="customer-id-input">
                        <input type="hidden" name="redeem_points" id="redeem-points-input" value="0">

                        <button type="submit" id="checkout-btn" disabled class="checkout-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span id="checkout-btn-text">Add items to checkout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT (UNCHANGED LOGIC) -->
    <script>
       let cart = [];
        let selectedPayment = 'cash';
        const CURRENCY = document.body.dataset.currencySymbol || 'Rs.';

        function addToCart(id, name, price, maxStock) {
            maxStock = parseInt(maxStock);
            price = parseFloat(price);
            id = parseInt(id);

            let existingItem = cart.find(item => parseInt(item.id) === id);

            if (existingItem) {
                if (existingItem.quantity >= maxStock) {
                    showToast('Stock limit reached for "' + name + '"', 'error');
                    return;
                }
                existingItem.quantity++;
            } else {
                cart.push({ id, name, price, quantity: 1, maxStock });
            }

            renderCart();
            showToast(name + ' added to cart', 'success');
        }

        function removeItem(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function changeQty(id, delta) {
            id = parseInt(id);
            let item = cart.find(item => parseInt(item.id) === id);
            if (!item) return;

            item.quantity += delta;

            if (item.quantity <= 0) {
                removeItem(id);
                return;
            }

            if (parseInt(item.quantity) > parseInt(item.maxStock)) {
                showToast('Maximum stock reached!', 'error');
                item.quantity = parseInt(item.maxStock);
            }

            renderCart();
        }

        function clearCart() {
            if (cart.length === 0) return;
            cart = [];
            renderCart();
        }

        function selectPayment(method, button) {
            selectedPayment = method;
            document.getElementById('payment-method').value = method;
            document.querySelectorAll('.pay-chip').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            validateCreditRequirement();
        }

        function renderCart() {
            const container = document.getElementById('cart-container');
            const grandTotalEl = document.getElementById('grand-total');
            const subtotalEl = document.getElementById('subtotal');
            const hiddenInput = document.getElementById('cart-hidden-input');
            const checkoutBtn = document.getElementById('checkout-btn');
            const checkoutBtnText = document.getElementById('checkout-btn-text');
            const itemsCount = document.getElementById('items-count');

            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full py-12 text-center">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                             style="background:#111a3a;border:1px solid var(--border);">
                            <svg class="w-8 h-8" style="color:var(--muted-2);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <p class="font-semibold" style="color:#c9d2ff;">Cart is empty</p>
                        <p class="text-sm mt-1" style="color:var(--muted);">Click on products to add them</p>
                    </div>`;
                grandTotalEl.textContent = 'Rs. 0.00';
                subtotalEl.textContent = 'Rs. 0.00';
                hiddenInput.value = '';
                checkoutBtn.disabled = true;
                checkoutBtnText.textContent = 'Add items to checkout';
                itemsCount.textContent = '0 items in cart';
                return;
            }

            let total = 0;
            let totalItems = 0;
            let html = '';

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                totalItems += item.quantity;

                html += `
                    <div class="cart-item">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-[13.5px] truncate">${item.name}</p>
                                <p class="text-[11.5px] mt-0.5" style="color:var(--muted);">${CURRENCY} ${item.price.toLocaleString()} × ${item.quantity}</p>
                            </div>
                            <button onclick="removeItem(${item.id})" type="button"
                                    class="flex-shrink-0 mt-0.5 p-1 rounded-md transition-colors"
                                    style="color:var(--muted-2);"
                                    onmouseover="this.style.color='#ff8a97'"
                                    onmouseout="this.style.color='var(--muted-2)'">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-2">
                                <button onclick="changeQty(${item.id}, -1)" type="button" class="qty-btn">−</button>
                                <span class="text-sm font-bold w-7 text-center">${item.quantity}</span>
                                <button onclick="changeQty(${item.id}, 1)" type="button" class="qty-btn">+</button>
                            </div>
                           <span class="font-black text-[14px]" style="color:var(--brand-2);">
                                ${CURRENCY} ${itemTotal.toLocaleString(undefined, {minimumFractionDigits: 2})}
                            </span>
                        </div>
                    </div>`;
            });

            container.innerHTML = html;

            const formattedTotal = CURRENCY + ' ' + total.toLocaleString(undefined, { minimumFractionDigits: 2 });
            grandTotalEl.textContent = formattedTotal;
            subtotalEl.textContent = formattedTotal;
            hiddenInput.value = JSON.stringify(cart);
            checkoutBtn.disabled = false;
            checkoutBtnText.textContent = `Checkout · ${formattedTotal}`;
            itemsCount.textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''} in cart`;
        }

        document.getElementById('productSearch').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.product-btn').forEach(btn => {
                const name = (btn.dataset.name || '').toLowerCase();
                const sku = (btn.dataset.sku || '').toLowerCase();
                const matches = name.includes(query) || sku.includes(query);
                btn.style.display = matches ? '' : 'none';
            });
        });

        function showToast(message, type = 'success') {
            document.querySelectorAll('.toast').forEach(t => t.remove());
            const toast = document.createElement('div');
            const isSuccess = type === 'success';
            toast.className = 'toast flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl text-sm font-medium';
            toast.style.background = isSuccess ? 'rgba(34,197,138,.15)' : 'rgba(239,90,107,.15)';
            toast.style.border = isSuccess ? '1px solid rgba(34,197,138,.35)' : '1px solid rgba(239,90,107,.35)';
            toast.style.color = isSuccess ? '#5ee1ac' : '#ff8a97';
            toast.style.backdropFilter = 'blur(10px)';

            const icon = isSuccess
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';

            toast.innerHTML = `<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon}</svg><span>${message}</span>`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') clearCart();
            if (e.key === 'F2') {
                document.getElementById('productSearch').focus();
                e.preventDefault();
            }
        });

        // Live clock
        setInterval(() => {
            const el = document.getElementById('live-clock');
            if (!el) return;
            const d = new Date();
            const opts = { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit', hour12:true };
            el.textContent = d.toLocaleString('en-GB', opts);
        }, 30000);

        // ==================== LOYALTY POINTS ====================
        function onCustomerChange() {
            const select = document.getElementById('customerSelect');
            const customerId = select.value;
            const selectedOption = select.options[select.selectedIndex];
            const points = parseInt(selectedOption.dataset.points || 0);

            document.getElementById('customer-id-input').value = customerId;

            const box = document.getElementById('pointsRedeemBox');
            if (customerId && points >= 50) {
                box.classList.remove('hidden');
                document.getElementById('availablePoints').textContent = points;
                document.getElementById('redeemPointsInput').max = points;
            } else {
                box.classList.add('hidden');
                document.getElementById('redeemPointsInput').value = 0;
                document.getElementById('redeem-points-input').value = 0;
                updateRedeemPreview();
            }

            validateCreditRequirement();
        }

        function validateCreditRequirement() {
            const paymentMethod = document.getElementById('payment-method').value;
            const customerId = document.getElementById('customer-id-input').value;
            const warning = document.getElementById('creditWarning');
            const checkoutBtn = document.getElementById('checkout-btn');

            if (paymentMethod === 'credit' && !customerId) {
                warning.classList.remove('hidden');
                checkoutBtn.disabled = true;
            } else {
                warning.classList.add('hidden');
                if (cart.length > 0) {
                    checkoutBtn.disabled = false;
                }
            }
        }

        function updateRedeemPreview() {
            const input = document.getElementById('redeemPointsInput');
            let points = parseInt(input.value) || 0;
            const max = parseInt(input.max) || 0;

            if (points > max) points = max;
            if (points < 0) points = 0;

            document.getElementById('redeemValue').textContent = points; // 1 point = Rs. 1
            document.getElementById('redeem-points-input').value = points;
        }
    </script>

</body>
</html>