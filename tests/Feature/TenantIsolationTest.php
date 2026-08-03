<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_tenant_cannot_see_another_tenants_products()
    {
        // ✅ Do alag tenants banao
        $tenantA = Tenant::create([
            'company_name' => 'Tenant A Shop',
            'slug' => 'tenant-a-shop',
            'email' => 'a@example.com',
            'currency' => 'PKR',
            'subscription_plan' => 'business',
            'subscription_status' => 'active',
            'is_active' => true,
        ]);

        $tenantB = Tenant::create([
            'company_name' => 'Tenant B Shop',
            'slug' => 'tenant-b-shop',
            'email' => 'b@example.com',
            'currency' => 'PKR',
            'subscription_plan' => 'business',
            'subscription_status' => 'active',
            'is_active' => true,
        ]);

        // ✅ Tenant A ka product banao
        $productA = Product::create([
            'tenant_id' => $tenantA->id,
            'name' => 'Tenant A Secret Product',
            'sku' => 'SKU-A-001',
            'price' => 500,
            'stock_quantity' => 10,
            'is_active' => true,
        ]);

        // ✅ Tenant B ka admin user banao
        $userB = User::create([
            'tenant_id' => $tenantB->id,
            'name' => 'Tenant B Admin',
            'email' => 'admin-b@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // ✅ Tenant B ke user se login karke Products page dekho
        $response = $this->actingAs($userB)->get('/tenant/products');

        // ✅ Assert: Tenant A ka product kabhi nahi dikhna chahiye
        $response->assertDontSee('Tenant A Secret Product');
    }

    /** @test */
    public function global_scope_prevents_cross_tenant_data_leak_at_query_level()
    {
        $tenantA = Tenant::create([
            'company_name' => 'Shop A', 'slug' => 'shop-a', 'email' => 'a2@example.com',
            'currency' => 'PKR', 'subscription_plan' => 'business',
            'subscription_status' => 'active', 'is_active' => true,
        ]);

        $tenantB = Tenant::create([
            'company_name' => 'Shop B', 'slug' => 'shop-b', 'email' => 'b2@example.com',
            'currency' => 'PKR', 'subscription_plan' => 'business',
            'subscription_status' => 'active', 'is_active' => true,
        ]);

        Product::create([
            'tenant_id' => $tenantA->id, 'name' => 'Product A',
            'price' => 100, 'stock_quantity' => 5, 'is_active' => true,
        ]);

        $userB = User::create([
            'tenant_id' => $tenantB->id, 'name' => 'User B', 'email' => 'userb@example.com',
            'password' => Hash::make('password123'), 'role' => 'admin', 'is_active' => true,
        ]);

        $this->actingAs($userB);

        // ✅ Direct query bhi sirf apne tenant ka data dena chahiye (global scope check)
        $this->assertEquals(0, Product::count());
    }
}