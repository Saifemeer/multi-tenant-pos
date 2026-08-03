<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Stripe\Stripe;
use Stripe\Subscription;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::withCount('users')->latest();

        if ($request->filled('search')) {
            $query->where('company_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('billing_status')) {
            $query->where('subscription_status', $request->billing_status);
        }

        if ($request->filled('plan')) {
            $query->where('subscription_plan', $request->plan);
        }

        $tenants = $query->paginate(15)->withQueryString();

        $activeCount = Tenant::where('is_active', true)->count();
        $inactiveCount = Tenant::where('is_active', false)->count();

        return view('super-admin.tenants.index', compact('tenants', 'activeCount', 'inactiveCount'));
    }

    public function show(Tenant $tenant)
    {
        $stats = [
            'total_users'    => $tenant->users()->count(),
            'total_products' => $tenant->products()->count(),
            'total_orders'   => $tenant->orders()->count(),
            'total_revenue'  => $tenant->orders()->where('status', 'completed')->sum('total'),
        ];

        return view('super-admin.tenants.show', compact('tenant', 'stats'));
    }

    // ✅ Edit form dikhao
    public function edit(Tenant $tenant)
    {
        return view('super-admin.tenants.edit', compact('tenant'));
    }

    // ✅ Tenant details update karo
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('tenants', 'email')->ignore($tenant->id),
            ],
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:1000',
            'business_category' => 'nullable|string|max:255',
            'currency' => 'required|in:PKR,USD,AED',
            'subscription_plan' => 'required|in:starter,business,enterprise',
        ]);

        $tenant->update($validated);

        return redirect()->route('super-admin.tenants.show', $tenant)
            ->with('success', "Tenant \"{$tenant->company_name}\" updated successfully.");
    }

    public function toggleStatus(Tenant $tenant)
    {
        $tenant->update(['is_active' => !$tenant->is_active]);

        $status = $tenant->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Tenant \"{$tenant->company_name}\" has been {$status}.");
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->stripe_subscription_id) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                Subscription::retrieve($tenant->stripe_subscription_id)->cancel();
            } catch (\Exception $e) {
                Log::warning("Failed to cancel Stripe subscription for tenant #{$tenant->id}: " . $e->getMessage());
            }
        }

        $companyName = $tenant->company_name;

        $tenant->delete();

        return redirect()->route('super-admin.tenants.index')
            ->with('success', "Tenant \"{$companyName}\" and its Stripe subscription have been deleted/cancelled.");
    }
}