<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display sales and product analytics.
     */
    public function index(Request $request)
    {
         
        $tenant = auth()->user()->tenant;

        if (!$tenant->canAccessReports()) {
            return redirect()->route('tenant.dashboard')
                ->with('error', 'Reports & Analytics sirf Business ya Enterprise plan mein available hai. Apna plan upgrade karein.');
        }

        $todayRevenue = Order::completed()
            ->whereDate('created_at', today())
            ->sum('total');

        $weekRevenue = Order::completed()
            ->whereBetween('created_at', [
                now()->copy()->startOfWeek(),
                now()->copy()->endOfWeek(),
            ])
            ->sum('total');

        $monthRevenue = Order::completed()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $totalRevenue = Order::completed()->sum('total');

        // Top-selling products based on completed orders.
        $topProducts = Product::withSum([
            'orderItems as total_sold' => function ($query) {
                $query->whereHas('order', function ($orderQuery) {
                    $orderQuery->where('status', 'completed');
                });
            },
        ], 'quantity')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        // Revenue chart for the last seven days.
        $chartLabels = [];
        $chartData = [];

        for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {
            $date = Carbon::today()->subDays($daysAgo);

            $chartLabels[] = $date->format('d M');

            $chartData[] = (float) Order::completed()
                ->whereDate('created_at', $date)
                ->sum('total');
        }

        return view('tenant.reports.index', compact(
            'todayRevenue',
            'weekRevenue',
            'monthRevenue',
            'totalRevenue',
            'topProducts',
            'chartLabels',
            'chartData'
        ));
    }
}