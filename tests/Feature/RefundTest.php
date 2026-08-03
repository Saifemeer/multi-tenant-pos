<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RefundTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function refunding_an_order_restores_stock()
    {
        $tenant = Tenant::create([
            'company_name' => 'Refund Shop', 'slug' => 'refund-shop', 'email' => 'refund@example.com',
            'currency' => 'PKR', 'subscription_plan' => 'business',
            'subscription_status' => 'active', 'is_active' => true,
        ]);

        $admin = User::create([
            'tenant_id' => $tenant->id, 'name' => 'Admin', 'email' => 'refund-admin@example.com',
            'password' => Hash::make('password123'), 'role' => 'admin', 'is_active' => true,
        ]);

        $product = Product::create([
            'tenant_id' => $tenant->id, 'name' => 'Refundable Item', 'sku' => 'SKU-200',
            'price' => 100, 'stock_quantity' => 5, 'is_active' => true,
        ]);

        $order = Order::create([
            'tenant_id' => $tenant->id, 'user_id' => $admin->id,
            'order_number' => 'ORD-TEST-001',
            'subtotal' => 200, 'total' => 200,
            'payment_method' => 'cash', 'status' => 'completed',
        ]);

        OrderItem::create([
            'tenant_id' => $tenant->id, 'order_id' => $order->id,
            'product_id' => $product->id, 'product_name' => $product->name,
            'product_price' => 100, 'quantity' => 2, 'total' => 200,
        ]);

        $response = $this->actingAs($admin)->post("/tenant/orders/{$order->id}/refund", [
            'reason' => 'Customer returned item',
        ]);

        $response->assertRedirect();

        // ✅ Stock wapas 5 se 7 hona chahiye (2 wapas add hue)
        $this->assertEquals(7, $product->fresh()->stock_quantity);

        // ✅ Order status "refunded" hona chahiye
        $this->assertEquals('refunded', $order->fresh()->status);
    }
}