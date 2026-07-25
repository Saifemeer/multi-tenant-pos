@extends('layouts.tenant')

@section('title', 'Orders')
@section('page-title', 'Order History')
@section('page-subtitle', 'View all completed transactions')

@section('content')

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-fade-in">
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Today Sales</p>
        <p class="text-2xl font-black text-emerald-400 mt-2">Rs. {{ number_format($todaySales ?? 0) }}</p>
        <p class="text-xs text-gray-600 mt-1">{{ $todayOrders ?? 0 }} orders</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">This Month</p>
        <p class="text-2xl font-black text-blue-400 mt-2">Rs. {{ number_format($monthSales ?? 0) }}</p>
        <p class="text-xs text-gray-600 mt-1">{{ $monthOrders ?? 0 }} orders</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Total Orders</p>
        <p class="text-2xl font-black text-white mt-2">{{ $totalOrders ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Avg Order Value</p>
        <p class="text-2xl font-black text-amber-400 mt-2">Rs. {{ number_format($avgOrder ?? 0) }}</p>
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
                        <span class="font-bold text-white text-sm">Rs. {{ number_format($order->total, 2) }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                            {{ $order->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400' : 
                               ($order->status === 'refunded' ? 'bg-red-500/10 text-red-400' : 'bg-amber-500/10 text-amber-400') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $order->status === 'completed' ? 'bg-emerald-400' : ($order->status === 'refunded' ? 'bg-red-400' : 'bg-amber-400') }}"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="text-sm text-gray-400">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-600">{{ $order->created_at->format('h:i A') }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-16 text-center">
                        <p class="text-gray-400 font-semibold">No orders yet</p>
                        <p class="text-gray-600 text-sm mt-1">Orders will appear here after POS checkout</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection