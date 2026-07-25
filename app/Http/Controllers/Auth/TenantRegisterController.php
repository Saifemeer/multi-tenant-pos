<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TenantRegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('tenant.dashboard');
        }
        return view('auth.register-tenant');
    }

    public function register(Request $request)
    {
        $request->validate([
            'company_name'      => 'required|string|max:255',
            'business_category' => 'required|string|max:255',
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:8|confirmed',
        ]);

        $slug = Str::slug($request->company_name);

        if (Tenant::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5);
        }

        // ✅ Tenant banao with business category
        $tenant = Tenant::create([
            'company_name'      => $request->company_name,
            'business_category' => $request->business_category,
            'slug'              => $slug,
            'email'             => $request->email,
            'phone'             => $request->phone ?? null,
            'currency'          => 'PKR',
            'is_active'         => true,
            'trial_ends_at'     => now()->addDays(14),
        ]);

        // ✅ Admin user banao
        $user = User::create([
            'tenant_id' => $tenant->id,
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // ✅ Default categories banao based on business type
        $this->createDefaultCategories($tenant, $request->business_category);

        Auth::login($user);

        return redirect()->route('tenant.dashboard')
            ->with('success', 'Your business "' . $tenant->company_name . '" has been registered successfully!');
    }

    // ✅ Business type ke hisaab se default categories banao
    private function createDefaultCategories(Tenant $tenant, string $businessType): void
    {
        $categoriesMap = [
            'restaurant' => [
                ['name' => 'Appetizers', 'color' => '#f59e0b', 'icon' => 'utensils'],
                ['name' => 'Main Course', 'color' => '#ef4444', 'icon' => 'fire'],
                ['name' => 'Beverages', 'color' => '#3b82f6', 'icon' => 'coffee'],
                ['name' => 'Desserts', 'color' => '#ec4899', 'icon' => 'cake'],
                ['name' => 'Fast Food', 'color' => '#f97316', 'icon' => 'hamburger'],
            ],
            'retail_store' => [
                ['name' => 'Electronics', 'color' => '#3b82f6', 'icon' => 'laptop'],
                ['name' => 'Clothing', 'color' => '#8b5cf6', 'icon' => 'tshirt'],
                ['name' => 'Accessories', 'color' => '#f59e0b', 'icon' => 'gem'],
                ['name' => 'Home & Living', 'color' => '#10b981', 'icon' => 'home'],
                ['name' => 'Beauty', 'color' => '#ec4899', 'icon' => 'sparkles'],
            ],
            'grocery' => [
                ['name' => 'Fruits & Vegetables', 'color' => '#10b981', 'icon' => 'leaf'],
                ['name' => 'Dairy Products', 'color' => '#f59e0b', 'icon' => 'droplet'],
                ['name' => 'Bakery', 'color' => '#f97316', 'icon' => 'bread'],
                ['name' => 'Beverages', 'color' => '#3b82f6', 'icon' => 'coffee'],
                ['name' => 'Snacks', 'color' => '#ef4444', 'icon' => 'cookie'],
                ['name' => 'Household', 'color' => '#8b5cf6', 'icon' => 'home'],
            ],
            'pharmacy' => [
                ['name' => 'Medicines', 'color' => '#ef4444', 'icon' => 'pill'],
                ['name' => 'First Aid', 'color' => '#f59e0b', 'icon' => 'bandage'],
                ['name' => 'Personal Care', 'color' => '#ec4899', 'icon' => 'heart'],
                ['name' => 'Baby Care', 'color' => '#3b82f6', 'icon' => 'baby'],
                ['name' => 'Vitamins', 'color' => '#10b981', 'icon' => 'capsule'],
            ],
            'salon' => [
                ['name' => 'Haircut', 'color' => '#8b5cf6', 'icon' => 'scissors'],
                ['name' => 'Facial', 'color' => '#ec4899', 'icon' => 'sparkles'],
                ['name' => 'Manicure', 'color' => '#f59e0b', 'icon' => 'hand'],
                ['name' => 'Massage', 'color' => '#10b981', 'icon' => 'spa'],
                ['name' => 'Products', 'color' => '#3b82f6', 'icon' => 'bottle'],
            ],
            'gym' => [
                ['name' => 'Monthly Plans', 'color' => '#3b82f6', 'icon' => 'calendar'],
                ['name' => 'Supplements', 'color' => '#10b981', 'icon' => 'capsule'],
                ['name' => 'Equipment', 'color' => '#f59e0b', 'icon' => 'dumbbell'],
                ['name' => 'Personal Training', 'color' => '#ef4444', 'icon' => 'user'],
                ['name' => 'Merchandise', 'color' => '#8b5cf6', 'icon' => 'tshirt'],
            ],
            'other' => [
                ['name' => 'General', 'color' => '#6b7280', 'icon' => 'tag'],
                ['name' => 'Services', 'color' => '#3b82f6', 'icon' => 'wrench'],
                ['name' => 'Products', 'color' => '#10b981', 'icon' => 'box'],
                ['name' => 'Miscellaneous', 'color' => '#f59e0b', 'icon' => 'folder'],
            ],
        ];

        $categories = $categoriesMap[$businessType] ?? $categoriesMap['other'];

        foreach ($categories as $cat) {
            Category::create([
                'tenant_id' => $tenant->id,
                'name'      => $cat['name'],
                'color'     => $cat['color'],
                'icon'      => $cat['icon'],
                'is_active' => true,
            ]);
        }
    }
}