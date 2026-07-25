<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display order history with filters and statistics.
     */
    public function index(Request $request)
    {
        $query = Order::with([
            'customer',
            'cashier',
            'items',
        ]);

        // Search by order number, customer name or phone.
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter.
        if (
            $request->filled('status') &&
            in_array($request->status, [
                'pending',
                'completed',
                'refunded',
                'cancelled',
            ], true)
        ) {
            $query->where('status', $request->status);
        }

        // Payment method filter.
        if (
            $request->filled('payment_method') &&
            in_array($request->payment_method, [
                'cash',
                'card',
                'jazzcash',
                'easypaisa',
                'bank_transfer',
                'credit',
            ], true)
        ) {
            $query->where('payment_method', $request->payment_method);
        }

        // Date range filters.
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Dashboard statistics for the current tenant.
        $todaySales = Order::completed()
            ->whereDate('created_at', today())
            ->sum('total');

        $todayOrders = Order::completed()
            ->whereDate('created_at', today())
            ->count();

        $monthSales = Order::completed()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $monthOrders = Order::completed()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalOrders = Order::count();

        $avgOrder = Order::completed()->avg('total') ?? 0;

        return view('tenant.orders.index', compact(
            'orders',
            'todaySales',
            'todayOrders',
            'monthSales',
            'monthOrders',
            'totalOrders',
            'avgOrder'
        ));
    }

    /**
     * Display a single order with its complete invoice data.
     */
    public function show(Order $order)
    {
        $order->load([
            'customer',
            'cashier',
            'items.product',
        ]);

        return view('tenant.orders.show', compact('order'));
    }
}