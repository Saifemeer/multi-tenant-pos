<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ============================================
    // 1. PRODUCTS LIST
    // ============================================
    public function index()
    {
        $products   = Product::with('category')->latest()->get();
        $categories = Category::where('is_active', true)->get();

        return view('tenant.dashboard', compact('products', 'categories'));
    }

    // ============================================
    // 2. PRODUCT STORE
    // ============================================
    public function store(Request $request)
    {
        $tenant = auth()->user()->tenant;

        // ✅ Plan-based product limit check
        if ($tenant->hasReachedProductLimit()) {
            return redirect()->back()->with(
                'error',
                'Aapki "' . ucfirst($tenant->subscription_plan) . '" plan mein sirf ' . $tenant->productLimit() . ' products allowed hain. Zyada products add karne ke liye plan upgrade karein.'
            );
        }
        
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id' => [
    'nullable',
    Rule::exists('categories', 'id')
        ->where(fn ($query) => $query->where(
            'tenant_id',
            auth()->user()->tenant_id
        )),
],
            'sku'           => 'nullable|string|max:255',
            'barcode'       => 'nullable|string|max:255',
            'price'         => 'required|numeric|min:0',
            'cost_price'    => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_alert' => 'nullable|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'   => 'nullable|string',
        ]);

        // ✅ Image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'sku'            => $request->sku ?? 'SKU-' . strtoupper(uniqid()),
            'barcode'        => $request->barcode,
            'price'          => $request->price,
            'cost_price'     => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'low_stock_alert' => $request->low_stock_alert ?? 5,
            'image'          => $imagePath,
            'description'    => $request->description,
        ]);

        return redirect()->back()->with('success', 'Product successfully add ho gaya!');
    }

    // ============================================
    // 3. PRODUCT EDIT FORM
    // ============================================
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('tenant.products.edit', compact('product', 'categories'));
    }

    // ============================================
    // 4. PRODUCT UPDATE
    // ============================================
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'category_id'   => 'nullable|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'cost_price'    => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_alert' => 'nullable|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'   => 'nullable|string',
        ]);

        // ✅ Image update
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Purani image delete karo
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'sku'            => $request->sku ?? $product->sku,
            'barcode'        => $request->barcode ?? $product->barcode,
            'price'          => $request->price,
            'cost_price'     => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'low_stock_alert' => $request->low_stock_alert ?? 5,
            'image'          => $imagePath,
            'description'    => $request->description,
            'is_active'      => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Product successfully update ho gaya!');
    }

    // ============================================
    // 5. PRODUCT DELETE
    // ============================================
    public function destroy(Product $product)
    {
        // Image delete karo
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product delete ho gaya!');
    }

    // ============================================
    // 6. POS SCREEN
    // ============================================
    public function posScreen()
{
    $tenantId = auth()->user()->tenant_id;

    $products = Product::with('category')
                       ->where('tenant_id', $tenantId)  // ✅ ADD
                       ->where('stock_quantity', '>', 0)
                       ->where('is_active', true)
                       ->get();

    $categories = Category::where('tenant_id', $tenantId)  // ✅ ADD
                          ->where('is_active', true)
                          ->get();

    return view('tenant.pos', compact('products', 'categories'));
}

public function checkout(Request $request)
{
    $request->validate([
        'cart'           => 'required|json',
        'payment_method' => 'required|in:cash,card,jazzcash,easypaisa,bank_transfer',
        'discount'       => 'nullable|numeric|min:0',
        'customer_id'    => 'nullable|exists:customers,id',
        'notes'          => 'nullable|string',
    ]);

    $cartItems = json_decode($request->cart, true);

    if (empty($cartItems)) {
        return redirect()->back()->with('error', 'Cart khali hai!');
    }

    $tenantId = auth()->user()->tenant_id;  // ✅ ADD

    try {
        $order = \DB::transaction(function () use ($cartItems, $request, $tenantId) {

            $subtotal = 0;
            $orderItemsData = [];

            foreach ($cartItems as $item) {
                // ✅ tenant_id se product find karo
                $product = Product::where('id', $item['id'])
                                  ->where('tenant_id', $tenantId)
                                  ->firstOrFail();

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception(
                        '"' . $product->name . '" ka stock kam hai! ' .
                        'Available: ' . $product->stock_quantity
                    );
                }

                $itemTotal = $product->price * $item['quantity'];
                $subtotal += $itemTotal;

                $orderItemsData[] = [
                    'product_id'    => $product->id,
                    'product_name'  => $product->name,
                    'product_price' => $product->price,
                    'quantity'      => $item['quantity'],
                    'discount'      => 0,
                    'total'         => $itemTotal,
                ];
            }

            $discount = $request->discount ?? 0;
            $tax      = 0;
            $total    = $subtotal - $discount + $tax;

            $order = \App\Models\Order::create([
                'tenant_id'      => $tenantId,  // ✅ ADD
                'customer_id'    => $request->customer_id,
                'user_id'        => auth()->id(),
                'subtotal'       => $subtotal,
                'tax'            => $tax,
                'discount'       => $discount,
                'total'          => $total,
                'payment_method' => $request->payment_method,
                'status'         => 'completed',
                'notes'          => $request->notes,
            ]);

            $order->items()->createMany($orderItemsData);

            // ✅ Stock update - tenant check ke saath
            foreach ($cartItems as $item) {
                Product::where('id', $item['id'])
                       ->where('tenant_id', $tenantId)
                       ->decrement('stock_quantity', $item['quantity']);
            }

            return $order;
        });

        return redirect()->route('tenant.pos')
            ->with('success', 'Bill successfully generate ho gaya! Order #' . $order->order_number);

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', $e->getMessage());
    }
}

    // ============================================
    // 8. STOCK ADJUST (Manual stock update)
    // ============================================
    public function adjustStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer',
            'type'     => 'required|in:add,subtract',
            'reason'   => 'nullable|string',
        ]);

        if ($request->type === 'add') {
            $product->increment('stock_quantity', $request->quantity);
        } else {
            if ($product->stock_quantity < $request->quantity) {
                return back()->with('error', 'Stock itna nahi hai!');
            }
            $product->decrement('stock_quantity', $request->quantity);
        }

        return back()->with('success', 'Stock successfully update ho gaya!');
    }
}