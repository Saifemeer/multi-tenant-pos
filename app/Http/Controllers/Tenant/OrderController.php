<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

   /**
     * Refund/void a completed order — koi bhi role (cashier included)
     * immediately process kar sakta hai. Reason zaroori hai, aur
     * har refund audit ke liye RefundLog mein record hota hai.
     */
    public function refund(Request $request, Order $order)
    {
        $tenantId = Auth::user()->tenant_id;

        if ($order->tenant_id !== $tenantId) {
            abort(403);
        }

        if ($order->status !== 'completed') {
            return back()->with('error', 'Sirf completed orders refund kiye ja sakte hain.');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($order, $tenantId, $request) {

            // ✅ Stock wapas add karo
            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)
                       ->where('tenant_id', $tenantId)
                       ->increment('stock_quantity', $item->quantity);
            }

            // ✅ Customer stats reverse karo
            if ($order->customer_id) {
                $customer = Customer::where('id', $order->customer_id)
                                     ->where('tenant_id', $tenantId)
                                     ->lockForUpdate()
                                     ->first();

                if ($customer) {
                    $customer->update([
                        'total_spent'    => max(0, $customer->total_spent - $order->total),
                        'visit_count'    => max(0, $customer->visit_count - 1),
                        'loyalty_points' => max(0, $customer->loyalty_points + $order->points_redeemed - $order->points_earned),
                    ]);

                    if ($order->payment_method === 'credit') {
                        $customer->decrement('credit_balance', min($order->total, $customer->credit_balance));
                    }
                }
            }

            $order->update([
                'status'      => 'refunded',
                'refunded_by' => Auth::id(),
            ]);

            // ✅ Audit log banao — accountability ke liye, blocking nahi
            \App\Models\RefundLog::create([
                'tenant_id'   => $tenantId,
                'order_id'    => $order->id,
                'refunded_by' => Auth::id(),
                'reason'      => $request->reason,
                'is_reviewed' => false,
            ]);
        });

        return back()->with('success', 'Order #' . $order->order_number . ' refund ho gaya. Stock wapas add ho gaya.');
    }

    /**
     * Admin/Manager ke liye — sab refunds ka audit log dekhna.
     */
    public function refundLogs()
    {
        if (!in_array(Auth::user()->role, ['admin', 'manager'], true)) {
            abort(403);
        }

        $tenantId = Auth::user()->tenant_id;

        $logs = \App\Models\RefundLog::with(['order', 'refundedBy', 'reviewedBy'])
            ->where('tenant_id', $tenantId)
            ->latest()
            ->paginate(15);

        return view('tenant.orders.refund-logs', compact('logs'));
    }

    /**
     * Refund log ko "reviewed" mark karna — sirf record ke liye,
     * koi transaction affect nahi hoti.
     */
    public function markReviewed(\App\Models\RefundLog $refundLog)
    {
        if (!in_array(Auth::user()->role, ['admin', 'manager'], true)) {
            abort(403);
        }

        if ($refundLog->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $refundLog->update([
            'is_reviewed' => true,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Refund review ho gaya.');
    }
}