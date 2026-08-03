@extends('layouts.tenant')

@section('title', 'Orders')
@section('page-title', 'Order History')
@section('page-subtitle', 'View all completed transactions')

@section('content')

@php $tenant = auth()->user()->tenant; @endphp

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-fade-in">
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Today Sales</p>
        <p class="text-2xl font-black text-emerald-400 mt-2">{{ $tenant->formatMoney($todaySales ?? 0, 0) }}</p>
        <p class="text-xs text-gray-600 mt-1">{{ $todayOrders ?? 0 }} orders</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">This Month</p>
        <p class="text-2xl font-black text-blue-400 mt-2">{{ $tenant->formatMoney($monthSales ?? 0, 0) }}</p>
        <p class="text-xs text-gray-600 mt-1">{{ $monthOrders ?? 0 }} orders</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Total Orders</p>
        <p class="text-2xl font-black text-white mt-2">{{ $totalOrders ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Avg Order Value</p>
        <p class="text-2xl font-black text-amber-400 mt-2">{{ $tenant->formatMoney($avgOrder ?? 0, 0) }}</p>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden animate-fade-in delay-1">
    <div class="px-6 py-5 border-b border-gray-800 flex items-center justify-between">
        <h3 class="text-base font-bold text-white">Recent Orders</h3>
        <span class="text-xs text-gray-500 bg-gray-800 px-3 py-1 rounded-full">{{ $orders->total() }} orders</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase">Order #</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Customer</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Items</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Payment</th>
                    <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Receipt</th>
                    <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Action</th>
                    <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @forelse($orders as $order)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <span class="font-bold text-blue-400 text-sm">{{ $order->order_number }}</span>
                    </td>
                    <td class="px-4 py-4 hidden sm:table-cell">
                        <span class="text-sm text-white">{{ $order->customer->name ?? 'Walk-in' }}</span>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <span class="text-sm text-gray-400">{{ $order->items->count() }} items</span>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <span class="text-xs font-semibold px-2 py-1 rounded-lg bg-gray-800 text-gray-300 capitalize">{{ $order->payment_method }}</span>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <span class="font-bold text-white text-sm">{{ $tenant->formatMoney($order->total) }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                            {{ $order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400' : 
                               ($order->status === 'refunded' ? 'bg-red-500/10 text-red-400' : 'bg-amber-500/10 text-amber-400') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $order->status === 'completed' ? 'bg-emerald-400' : ($order->status === 'refunded' ? 'bg-red-400' : 'bg-amber-400') }}"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <a href="{{ route('tenant.receipts.view', $order) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 text-xs text-indigo-400 hover:text-indigo-300 hover:underline font-semibold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            View
                        </a>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($order->status === 'completed')
                            <button onclick="openRefundModal({{ $order->id }}, '{{ $order->order_number }}')"
                                    class="text-xs text-red-400 hover:underline font-semibold">
                                Refund
                            </button>
                        @elseif($order->status === 'refunded')
                            <span class="text-xs text-gray-600">Refunded</span>
                        @else
                            <span class="text-xs text-gray-700">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-600">{{ $order->created_at->format('h:i A') }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-16 text-center">
                        <p class="text-gray-400 font-semibold">No orders yet</p>
                        <p class="text-gray-600 text-sm mt-1">Orders will appear here after POS checkout</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 w-full max-w-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-red-500/15 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-white">Refund Order</h3>
                <p class="text-xs text-gray-500">Order <span id="refundOrderNumber" class="text-white font-medium"></span></p>
            </div>
        </div>

        <p class="text-xs text-gray-400 bg-gray-800/50 border border-gray-700 rounded-lg p-2.5 mb-4">
            Stock wapas add ho jayega aur ye action record ho jayega. Ye undo nahi ho sakta.
        </p>

        <form id="refundForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Refund Reason</label>
                <textarea name="reason" required rows="3" class="input-modern" placeholder="e.g. Customer ne product return kiya, galat item scan hua..."></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="closeRefundModal()" class="btn-secondary flex-1">Cancel</button>
                <button type="submit" class="btn-danger flex-1">Confirm Refund</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRefundModal(orderId, orderNumber) {
        document.getElementById('refundOrderNumber').textContent = orderNumber;
        document.getElementById('refundForm').action = `/tenant/orders/${orderId}/refund`;
        document.getElementById('refundModal').classList.remove('hidden');
        document.getElementById('refundModal').classList.add('flex');
    }

    function closeRefundModal() {
        document.getElementById('refundModal').classList.add('hidden');
        document.getElementById('refundModal').classList.remove('flex');
    }
</script>
@endpush
@endsection