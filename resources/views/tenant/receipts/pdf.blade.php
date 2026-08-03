<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #000;
            padding: 12px;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 2px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        table th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 3px 0;
        }
        table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .totals-row td {
            padding: 2px 0;
        }
        .grand-total {
            font-size: 12px;
            font-weight: bold;
        }
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>
<body>

    <div class="center">
        <p class="company-name">{{ $tenant->company_name }}</p>
        @if($tenant->address)
            <p>{{ $tenant->address }}</p>
        @endif
        @if($tenant->phone)
            <p>Tel: {{ $tenant->phone }}</p>
        @endif
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Receipt #:</td>
            <td class="right bold">{{ $order->order_number }}</td>
        </tr>
        <tr>
            <td>Date:</td>
            <td class="right">{{ $order->created_at->format('d M Y, h:i A') }}</td>
        </tr>
        <tr>
            <td>Cashier:</td>
            <td class="right">{{ $order->cashier->name ?? 'N/A' }}</td>
        </tr>
        @if($order->customer)
        <tr>
            <td>Customer:</td>
            <td class="right">{{ $order->customer->name }}</td>
        </tr>
        @endif
        <tr>
            <td>Payment:</td>
            <td class="right" style="text-transform: capitalize;">{{ str_replace('_', ' ', $order->payment_method) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Price</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="right">{{ $item->quantity }}</td>
                <td class="right">{{ number_format($item->product_price, 0) }}</td>
                <td class="right">{{ number_format($item->total, 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table>
        <tr class="totals-row">
            <td>Subtotal</td>
            <td class="right">{{ $tenant->currencySymbol() }} {{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @if($order->discount > 0)
        <tr class="totals-row">
            <td>Discount</td>
            <td class="right">- {{ $tenant->currencySymbol() }} {{ number_format($order->discount, 2) }}</td>
        </tr>
        @endif
        @if($order->tax > 0)
        <tr class="totals-row">
            <td>Tax</td>
            <td class="right">{{ $tenant->currencySymbol() }} {{ number_format($order->tax, 2) }}</td>
        </tr>
        @endif
        <tr class="totals-row grand-total">
            <td>TOTAL</td>
            <td class="right">{{ $tenant->currencySymbol() }} {{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p style="margin-top: 4px; color: #666;">Powered by SaaS POS</p>
    </div>

</body>
</html>