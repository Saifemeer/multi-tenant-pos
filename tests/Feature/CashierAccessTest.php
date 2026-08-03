<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CashierAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cashier_cannot_access_products_management_page()
    {
        // Tests/Feature/CashierAccessTest.php

$tenant = Tenant::create([
    'company_name' => 'Test Shop',
    'slug' => 'test-shop',
    'email' => 'shop@example.com',
    'currency' => 'PKR',
    'subscription_plan' => 'starter', // <-- Change 'business' to a valid value
    'subscription_status' => 'active',
    'is_active' => true,
]);

        $cashier = User::create([
            'tenant_id' => $tenant->id, 'name' => 'Cashier User', 'email' => 'cashier@example.com',
            'password' => Hash::make('password123'), 'role' => 'cashier', 'is_active' => true,
        ]);

        $response = $this->actingAs($cashier)->get('/tenant/products');

        // ✅ Cashier ko 403 Forbidden milna chahiye
        $response->assertForbidden();
    }

    /** @test */
    public function cashier_can_access_pos_screen()
    {
        $tenant = Tenant::create([
            'company_name' => 'Test Shop 2', 'slug' => 'test-shop-2', 'email' => 'shop2@example.com',
            'currency' => 'PKR', 'subscription_plan' => 'business',
            'subscription_status' => 'active', 'is_active' => true,
        ]);

        $cashier = User::create([
            'tenant_id' => $tenant->id, 'name' => 'Cashier User', 'email' => 'cashier2@example.com',
            'password' => Hash::make('password123'), 'role' => 'cashier', 'is_active' => true,
        ]);

        $response = $this->actingAs($cashier)->get('/tenant/pos');

        // ✅ POS screen access hona chahiye (cashier ka core kaam yehi hai)
        $response->assertOk();
    }
}