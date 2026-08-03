<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PlanLimitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function starter_plan_cannot_add_products_beyond_limit()
    {
        $tenant = Tenant::create([
            'company_name' => 'Small Shop', 'slug' => 'small-shop', 'email' => 'small@example.com',
            'currency' => 'PKR', 'subscription_plan' => 'starter', // ✅ Starter plan = 50 product limit
            'subscription_status' => 'active', 'is_active' => true,
        ]);

        $admin = User::create([
            'tenant_id' => $tenant->id, 'name' => 'Admin', 'email' => 'limit-admin@example.com',
            'password' => Hash::make('password123'), 'role' => 'admin', 'is_active' => true,
        ]);

        // ✅ 50 products already bana do (Starter ki limit)
        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'tenant_id' => $tenant->id, 'name' => "Product {$i}",
                'price' => 100, 'stock_quantity' => 10, 'is_active' => true,
            ]);
        }

        // ✅ 51st product add karne ki koshish karo
        $response = $this->actingAs($admin)->post('/tenant/products', [
            'name' => 'One Too Many',
            'price' => 100,
            'stock_quantity' => 10,
        ]);

        // ✅ Product create nahi hona chahiye
        $this->assertDatabaseMissing('products', ['name' => 'One Too Many']);

        // ✅ Total products ab bhi 50 hone chahiye
        $this->assertEquals(50, Product::count());
    }
}