<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tenants'   => Tenant::count(),
            'active_tenants'  => Tenant::where('is_active', true)->count(),
            'inactive_tenants' => Tenant::where('is_active', false)->count(),
            'total_users'     => User::count(),
            'total_orders'    => Order::withoutGlobalScope('tenant')->count(),
            'total_revenue'   => Order::withoutGlobalScope('tenant')
                                    ->where('status', 'completed')
                                    ->sum('total'),
        ];

        $recentTenants = Tenant::latest()->take(5)->get();

        $expiringTrials = Tenant::whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '>', now())
            ->where('trial_ends_at', '<=', now()->addDays(3))
            ->get();

        return view('super-admin.dashboard', compact('stats', 'recentTenants', 'expiringTrials'));
    }
}