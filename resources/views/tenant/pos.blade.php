<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Counter | {{ auth()->user()->tenant->company_name }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 3px; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(12px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes popIn {
            0% { transform: scale(0.8); opacity: 0; }
            70% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        .animate-slide-in { animation: slideIn 0.4s ease-out; }
        .animate-pop { animation: popIn 0.3s ease-out; }
        
        .product-btn {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 16px;
            padding: 16px;
            text-align: left;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100px;
        }
        .product-btn:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        .product-btn:active {
            transform: scale(0.97);
        }
        
        .cart-item {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 12px;
            padding: 12px;
            transition: all 0.2s ease;
            animation: popIn 0.3s ease-out;
        }
        .cart-item:hover {
            border-color: #374151;
        }
        
        .qty-btn {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #1f2937;
            color: #9ca3af;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }
        .qty-btn:hover {
            background: #374151;
            color: white;
        }
        
        .checkout-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            font-weight: 700;
            font-size: 15px;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.3);
        }
        .checkout-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
        }
        .checkout-btn:disabled {
            background: #1f2937;
            color: #4b5563;
            cursor: not-allowed;
            box-shadow: none;
        }
        
        .category-btn {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #1f2937;
            color: #6b7280;
            background: transparent;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .category-btn:hover,
        .category-btn.active {
            background: rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
            color: #60a5fa;
        }
        
        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 100;
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col overflow-hidden">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="bg-gray-900 border-b border-gray-800 px-6 py-4 flex items-center justify-between flex-shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('tenant.dashboard') }}" 
               class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            
            <div class="w-px h-6 bg-gray-700"></div>
            
            <div>
                <h1 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    {{ auth()->user()->tenant->company_name }}
                </h1>
                <p class="text-xs text-gray-500">POS Counter — {{ now()->format('d M Y, h:i A') }}</p>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
            </div>
            <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-sm font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
        </div>
    </nav>

    <!-- ==================== MAIN WORKSPACE ==================== -->
    <div class="flex-1 grid grid-cols-1 lg:grid-cols-12 gap-4 p-4 overflow-hidden">
        
        <!-- LEFT: Products Grid -->
        <div class="lg:col-span-7 bg-gray-900 border border-gray-800 rounded-2xl flex flex-col overflow-hidden">
            
            <!-- Products Header -->
            <div class="p-4 border-b border-gray-800">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-base font-bold text-white">Products</h2>
                    <span class="text-xs text-gray-500 bg-gray-800 px-3 py-1 rounded-full">
                        {{ $products->count() }} available
                    </span>
                </div>
                
                <!-- Search Bar -->
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="productSearch" 
                           placeholder="Search by name, SKU or barcode..."
                           class="w-full bg-gray-800 border border-gray-700 text-white pl-10 pr-4 py-2.5 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500">
                </div>
            </div>

            <!-- Product Buttons Grid -->
            <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 overflow-y-auto flex-1">
                @forelse($products as $product)
                    <button class="product-btn animate-fade-in"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-stock="{{ $product->stock_quantity }}"
                            data-sku="{{ $product->sku }}"
                            onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock_quantity }})">
                        
                        <div>
                            <p class="text-xs text-gray-500 font-mono mb-1">{{ $product->sku ?? 'No SKU' }}</p>
                            <p class="font-bold text-white text-sm leading-snug">{{ $product->name }}</p>
                        </div>
                        
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xs font-medium px-2 py-0.5 rounded-md
                                {{ $product->stock_quantity <= 5 ? 'bg-amber-500/20 text-amber-400' : 'bg-gray-700 text-gray-400' }}">
                                Stock: {{ $product->stock_quantity }}
                            </span>
                            <span class="font-black text-blue-400 text-sm">Rs. {{ number_format($product->price) }}</span>
                        </div>
                    </button>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <div class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <p class="text-gray-400 font-semibold">No products available</p>
                        <p class="text-gray-600 text-sm mt-1">Add products from the dashboard</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- RIGHT: Bill / Cart -->
        <div class="lg:col-span-5 bg-gray-900 border border-gray-800 rounded-2xl flex flex-col overflow-hidden animate-slide-in">
            
            <!-- Bill Header -->
            <div class="p-4 border-b border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-white">Current Bill</h2>
                    <p class="text-xs text-gray-500">Invoice #{{ str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) }}</p>
                </div>
                <button onclick="clearCart()" 
                        class="flex items-center gap-1.5 text-xs text-red-400 hover:text-red-300 bg-red-500/10 hover:bg-red-500/20 px-3 py-1.5 rounded-lg transition-all font-semibold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Clear All
                </button>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="mx-4 mt-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mx-4 mt-4 bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Cart Items -->
            <div id="cart-container" class="flex-1 p-4 space-y-2 overflow-y-auto">
                <div id="empty-cart" class="flex flex-col items-center justify-center h-full py-12 text-center">
                    <div class="w-16 h-16 bg-gray-800 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 font-semibold">Cart is empty</p>
                    <p class="text-gray-600 text-sm mt-1">Click on products to add them</p>
                </div>
            </div>

            <!-- Total + Checkout -->
            <div class="border-t border-gray-800 p-4 space-y-4 bg-gray-900/50">
                
                <!-- Price Breakdown -->
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span id="subtotal" class="text-gray-300 font-medium">Rs. 0.00</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax (0%)</span>
                        <span class="text-gray-300">Rs. 0.00</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-800">
                        <span class="text-base font-bold text-white">Total</span>
                        <span id="grand-total" class="text-2xl font-black text-white">Rs. 0.00</span>
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Payment Method</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" 
                                onclick="selectPayment('cash', this)"
                                class="payment-btn active py-2 px-3 rounded-xl border border-blue-500 bg-blue-500/10 text-blue-400 text-xs font-semibold transition-all">
                            Cash
                        </button>
                        <button type="button" 
                                onclick="selectPayment('card', this)"
                                class="payment-btn py-2 px-3 rounded-xl border border-gray-700 text-gray-500 text-xs font-semibold transition-all hover:border-gray-600 hover:text-gray-300">
                            Card
                        </button>
                        <button type="button" 
                                onclick="selectPayment('jazzcash', this)"
                                class="payment-btn py-2 px-3 rounded-xl border border-gray-700 text-gray-500 text-xs font-semibold transition-all hover:border-gray-600 hover:text-gray-300">
                            JazzCash
                        </button>
                    </div>
                </div>

                <!-- Checkout Form -->
                <form action="{{ route('tenant.pos.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cart" id="cart-hidden-input">
                    <input type="hidden" name="payment_method" id="payment-method" value="cash">
                    
                    <button type="submit" id="checkout-btn" disabled class="checkout-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span id="checkout-btn-text">Add items to checkout</span>
                    </button>
                </form>

                <!-- Items Count -->
                <p class="text-center text-xs text-gray-600" id="items-count">0 items in cart</p>
            </div>
        </div>
    </div>

    <!-- ==================== JAVASCRIPT ==================== -->
     <script>
        let cart = [];
        let selectedPayment = 'cash';

        // ==================== ADD TO CART ====================
       function addToCart(id, name, price, maxStock) {
    // Yahan maxStock aur price ko pakka Number bana rahe hain
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
        // ==================== REMOVE ITEM ====================
        function removeItem(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        // ==================== CHANGE QTY ====================
        function changeQty(id, delta) {
    id = parseInt(id); // ID ko safe side number mein convert kiya
    let item = cart.find(item => parseInt(item.id) === id);
    if (!item) return;

    item.quantity += delta;

    if (item.quantity <= 0) {
        removeItem(id);
        return;
    }

    // Yahan check karein ke dono taraf pure Numbers hoon
    if (parseInt(item.quantity) > parseInt(item.maxStock)) {
        showToast('Maximum stock reached!', 'error');
        item.quantity = parseInt(item.maxStock);
    }

    renderCart();
}

        // ==================== CLEAR CART ====================
        function clearCart() {
            if (cart.length === 0) return;
            cart = [];
            renderCart();
        }

        // ==================== SELECT PAYMENT ====================
        function selectPayment(method, button) {
            selectedPayment = method;
            document.getElementById('payment-method').value = method;

            document.querySelectorAll('.payment-btn').forEach(btn => {
                btn.className = 'payment-btn py-2 px-3 rounded-xl border border-gray-700 text-gray-500 text-xs font-semibold transition-all hover:border-gray-600 hover:text-gray-300';
            });

            button.className = 'payment-btn active py-2 px-3 rounded-xl border border-blue-500 bg-blue-500/10 text-blue-400 text-xs font-semibold transition-all';
        }

        // ==================== RENDER CART ====================
        function renderCart() {
            const container = document.getElementById('cart-container');
            const emptyCart = document.getElementById('empty-cart');
            const grandTotalEl = document.getElementById('grand-total');
            const subtotalEl = document.getElementById('subtotal');
            const hiddenInput = document.getElementById('cart-hidden-input');
            const checkoutBtn = document.getElementById('checkout-btn');
            const checkoutBtnText = document.getElementById('checkout-btn-text');
            const itemsCount = document.getElementById('items-count');

            if (cart.length === 0) {
                container.innerHTML = '';
                container.appendChild(emptyCart);
                grandTotalEl.textContent = 'Rs. 0.00';
                subtotalEl.textContent = 'Rs. 0.00';
                hiddenInput.value = '';
                checkoutBtn.disabled = true;
                checkoutBtnText.textContent = 'Add items to checkout';
                itemsCount.textContent = '0 items in cart';
                return;
            }

            if (emptyCart.parentNode === container) {
                container.removeChild(emptyCart);
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
                                <p class="font-semibold text-white text-sm truncate">${item.name}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Rs. ${item.price.toLocaleString()} each</p>
                            </div>
                            <button onclick="removeItem(${item.id})" type="button" 
                                    class="text-gray-600 hover:text-red-400 transition-colors flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center gap-2">
                                <button onclick="changeQty(${item.id}, -1)" type="button" class="qty-btn">−</button>
                                <span class="text-sm font-bold text-white w-6 text-center">${item.quantity}</span>
                                <button onclick="changeQty(${item.id}, 1)" type="button" class="qty-btn">+</button>
                            </div>
                            <span class="font-bold text-white text-sm">Rs. ${itemTotal.toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;

            const formattedTotal = 'Rs. ' + total.toLocaleString(undefined, { minimumFractionDigits: 2 });
            grandTotalEl.textContent = formattedTotal;
            subtotalEl.textContent = formattedTotal;
            hiddenInput.value = JSON.stringify(cart);
            checkoutBtn.disabled = false;
            checkoutBtnText.textContent = `Checkout — Rs. ${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            itemsCount.textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''} in cart`;
        }

        // ==================== PRODUCT SEARCH ====================
        document.getElementById('productSearch').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const buttons = document.querySelectorAll('.product-btn');

            buttons.forEach(btn => {
                const name = btn.dataset.name.toLowerCase();
                const sku = btn.dataset.sku.toLowerCase();
                const matches = name.includes(query) || sku.includes(query);
                btn.style.display = matches ? '' : 'none';
            });
        });

        // ==================== TOAST NOTIFICATION ====================
        function showToast(message, type = 'success') {
            // Remove existing toasts
            document.querySelectorAll('.toast').forEach(t => t.remove());

            const toast = document.createElement('div');
            toast.className = `toast flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl text-sm font-medium ${
                type === 'success'
                    ? 'bg-emerald-500/20 border border-emerald-500/30 text-emerald-300'
                    : 'bg-red-500/20 border border-red-500/30 text-red-300'
            }`;

            const icon = type === 'success'
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';

            toast.innerHTML = `
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon}</svg>
                <span>${message}</span>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100px)';
                toast.style.transition = 'all 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 2500);
        }

        // ==================== KEYBOARD SHORTCUT ====================
        document.addEventListener('keydown', function(e) {
            // ESC = Clear cart
            if (e.key === 'Escape') clearCart();
            // F2 = Focus search
            if (e.key === 'F2') {
                document.getElementById('productSearch').focus();
                e.preventDefault();
            }
        });
    </script>

</body>
</html>