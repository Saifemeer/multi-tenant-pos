@extends('layouts.tenant')

@section('title', 'Customers')
@section('page-title', 'Customers')
@section('page-subtitle', 'Manage your customer database')

@section('content')

@php $tenant = auth()->user()->tenant; @endphp

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 animate-fade-in">
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Total Customers</p>
        <p class="text-2xl font-black text-white mt-2">{{ $totalCustomers }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Total Spending</p>
        <p class="text-2xl font-black text-emerald-400 mt-2">{{ $tenant->formatMoney($totalCustomerSpending, 0) }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Credit Outstanding</p>
        <p class="text-2xl font-black text-amber-400 mt-2">{{ $tenant->formatMoney($totalCreditOutstanding, 0) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Add Customer -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 h-fit animate-slide-in">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-500/15 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-white">Add Customer</h3>
                <p class="text-xs text-gray-500">Register new customer</p>
            </div>
        </div>

        <form action="{{ route('tenant.customers.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Name</label>
                <input type="text" name="name" required class="input-modern" placeholder="Customer name">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Phone</label>
                <input type="text" name="phone" class="input-modern" placeholder="+92 300 1234567">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email <span class="text-gray-600">(Optional)</span></label>
                <input type="email" name="email" class="input-modern" placeholder="customer@email.com">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Address <span class="text-gray-600">(Optional)</span></label>
                <textarea name="address" class="input-modern" rows="2" placeholder="Full address"></textarea>
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add Customer
            </button>
        </form>
    </div>

    <!-- Customers List -->
    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden animate-fade-in">
        <div class="px-6 py-5 border-b border-gray-800">
            <h3 class="text-base font-bold text-white">All Customers</h3>
            <p class="text-xs text-gray-500 mt-0.5">{{ $customers->total() }} registered</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase">Customer</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Phone</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase">Total Spent</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Visits</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Points</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Credit Due</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase w-28">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse($customers as $customer)
                    <tr class="table-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center text-xs font-bold text-gray-400">
                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-white text-sm">{{ $customer->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer->email ?? 'No email' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 hidden sm:table-cell">
                            <span class="text-sm text-gray-400">{{ $customer->phone ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <span class="font-bold text-emerald-400 text-sm">{{ $tenant->formatMoney($customer->total_spent) }}</span>
                        </td>
                        <td class="px-4 py-4 text-center hidden md:table-cell">
                            <span class="text-sm text-gray-400">{{ $customer->visit_count }}</span>
                        </td>
                        <td class="px-4 py-4 text-center hidden lg:table-cell">
                            <span class="text-xs font-semibold px-2 py-1 rounded-lg bg-amber-500/10 text-amber-400">
                                {{ $customer->loyalty_points }} pts
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right hidden lg:table-cell">
                           @if($customer->credit_balance > 0)
    <span class="font-bold text-amber-400 text-sm">{{ $tenant->formatMoney($customer->credit_balance) }}</span>
@else
                                <span class="text-xs text-gray-600">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($customer->credit_balance > 0)
                                <button onclick="openPaymentModal({{ $customer->id }}, '{{ addslashes($customer->name) }}', {{ $customer->credit_balance }})"
                                        class="text-xs text-emerald-400 hover:underline font-semibold">
                                    Record Payment
                                </button>
                            @else
                                <span class="text-xs text-gray-700">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <p class="text-gray-400 font-semibold">No customers yet</p>
                            <p class="text-gray-600 text-sm mt-1">Add your first customer</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 w-full max-w-sm">
        <h3 class="text-base font-bold text-white mb-1">Record Payment</h3>
        <p class="text-sm text-gray-500 mb-4">Customer: <span id="modalCustomerName" class="text-white font-medium"></span></p>

        <form id="paymentForm" method="POST">
            @csrf
            <div class="mb-4">
               <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
    Outstanding: {{ auth()->user()->tenant->currencySymbol() }} <span id="modalOutstanding"></span>
</label>
                <input type="number" name="amount" id="paymentAmountInput" step="0.01" min="0.01" required
                       class="input-modern" placeholder="Amount received">
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="closePaymentModal()" class="btn-secondary flex-1">Cancel</button>
                <button type="submit" class="btn-primary flex-1">Confirm Payment</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openPaymentModal(customerId, customerName, outstanding) {
        document.getElementById('modalCustomerName').textContent = customerName;
        document.getElementById('modalOutstanding').textContent = outstanding.toLocaleString(undefined, {minimumFractionDigits: 2});
        document.getElementById('paymentAmountInput').max = outstanding;
        document.getElementById('paymentForm').action = `/tenant/customers/${customerId}/record-payment`;
        document.getElementById('paymentModal').classList.remove('hidden');
        document.getElementById('paymentModal').classList.add('flex');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.getElementById('paymentModal').classList.remove('flex');
    }
</script>
@endpush