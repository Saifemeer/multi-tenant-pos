<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

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

        $tenants = $query->paginate(15)->withQueryString();

        return view('super-admin.tenants.index', compact('tenants'));
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

    public function toggleStatus(Tenant $tenant)
    {
        $tenant->update(['is_active' => !$tenant->is_active]);

        $status = $tenant->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Tenant \"{$tenant->company_name}\" has been {$status}.");
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect()->route('super-admin.tenants.index')
            ->with('success', 'Tenant deleted successfully.');
    }
}