<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function download(Order $order)
    {
        // Sirf apne tenant ka order
        if ($order->tenant_id !== auth()->user()->tenant_id) {
            abort(403);
        }

        $order->load(['items', 'customer', 'cashier']);
        $tenant = auth()->user()->tenant;

        $pdf = Pdf::loadView('tenant.receipts.pdf', compact('order', 'tenant'))
                   ->setPaper([0, 0, 226.77, 600], 'portrait'); // ~80mm thermal receipt width

        return $pdf->download('receipt-' . $order->order_number . '.pdf');
    }

    public function view(Order $order)
    {
        if ($order->tenant_id !== auth()->user()->tenant_id) {
            abort(403);
        }

        $order->load(['items', 'customer', 'cashier']);
        $tenant = auth()->user()->tenant;

        $pdf = Pdf::loadView('tenant.receipts.pdf', compact('order', 'tenant'))
                   ->setPaper([0, 0, 226.77, 600], 'portrait');

        return $pdf->stream('receipt-' . $order->order_number . '.pdf');
    }
}