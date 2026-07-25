<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ Today Stats
        $todaySales    = Order::today()->completed()->sum('total');
        $todayOrders   = Order::today()->completed()->count();

        // ✅ This Month Stats
        $monthSales    = Order::thisMonth()->completed()->sum('total');
        $monthOrders   = Order::thisMonth()->completed()->count();

        // ✅ Inventory Stats
        $totalProducts = Product::count();
        $lowStock      = Product::lowStock()->count();
        $outOfStock    = Product::outOfStock()->count();

        // ✅ Customers
        $totalCustomers = Customer::count();

        // ✅ Recent Orders
        $recentOrders = Order::with(['customer', 'cashier', 'items'])
                             ->latest()
                             ->take(5)
                             ->get();

        // ✅ Top Products (Most Sold)
        $topProducts = Product::withCount(['orderItems as total_sold' => function ($q) {
                                    $q->select(\DB::raw('SUM(quantity)'));
                                }])
                               ->orderByDesc('total_sold')
                               ->take(5)
                               ->get();

        // ✅ Last 7 Days Sales Chart
        $salesChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $salesChart[] = [
                'date'  => $date->format('d M'),
                'sales' => Order::whereDate('created_at', $date)
                                ->completed()
                                ->sum('total'),
            ];
        }
// ✅ Yeh line add karo — products pass karo view mein
        $products = Product::latest()->get();

        $categories = Category::withCount('products')->where('is_active', true)->get();

        return view('tenant.dashboard', compact(
            'todaySales', 'todayOrders',
            'monthSales', 'monthOrders',
            'totalProducts', 'lowStock', 'outOfStock',
            'totalCustomers', 'recentOrders',
            'topProducts', 'salesChart',
            'products', 'categories'
        ));
    }
}