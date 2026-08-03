@extends('layouts.tenant')

@section('title', 'Refund Logs')
@section('page-title', 'Refund Audit Log')
@section('page-subtitle', 'Review all refunds processed by your team')

@section('content')

@php $tenant = auth()->user()->tenant; @endphp

<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden animate-fade-in">
    <div class="px-6 py-5 border-b border-gray-800 flex items-center justify-between">
        <div>
            <h3 class="text-base font-bold text-white">All Refunds</h3>
            <p class="text-xs text-gray-500 mt-0.5">{{ $logs->total() }} total refunds</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase">Order #</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Refunded By</th>
                    <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Reason</th>
                    <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                    <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Reviewed</th>
                    <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50">
                @forelse($logs as $log)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <span class="font-bold text-blue-400 text-sm">{{ $log->order->order_number ?? 'N/A' }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-sm text-white">{{ $log->refundedBy->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ $log->refundedBy->role ?? '' }}</p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <p class="text-sm text-gray-400 max-w-xs truncate" title="{{ $log->reason }}">{{ $log->reason }}</p>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <span class="font-bold text-red-400 text-sm">{{ $tenant->formatMoney($log->order->total ?? 0) }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($log->is_reviewed)
                            <span class="text-xs px-2 py-1 rounded-lg bg-emerald-500/10 text-emerald-400">
                                ✓ {{ $log->reviewedBy->name ?? '' }}
                            </span>
                        @else
                            <form action="{{ route('tenant.refund-logs.mark-reviewed', $log) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs text-amber-400 hover:underline font-semibold">
                                    Mark Reviewed
                                </button>
                            </form>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <p class="text-sm text-gray-400">{{ $log->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-600">{{ $log->created_at->format('h:i A') }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <p class="text-gray-400 font-semibold">Koi refund nahi hua abhi tak</p>
                        <p class="text-gray-600 text-sm mt-1">Jab bhi koi refund process hoga, yahan dikhega</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-800">
        {{ $logs->links() }}
    </div>
    @endif
</div>

@endsection