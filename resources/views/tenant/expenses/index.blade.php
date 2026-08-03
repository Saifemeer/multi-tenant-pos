@extends('layouts.tenant')

@section('title', 'Expenses')
@section('page-title', 'Expense Tracking')
@section('page-subtitle', 'Track your business expenses')

@section('content')
@php $tenant = auth()->user()->tenant; @endphp

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 animate-fade-in">
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">This Week</p>
        <p class="text-2xl font-black text-blue-400 mt-2">{{ $tenant->formatMoney($thisWeekTotal, 0) }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">This Month</p>
        <p class="text-2xl font-black text-amber-400 mt-2">{{ $tenant->formatMoney($thisMonthTotal, 0) }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">All Time</p>
        <p class="text-2xl font-black text-red-400 mt-2">{{ $tenant->formatMoney($totalAllTime, 0) }}</p>
    </div>
</div>

<!-- Category Breakdown (this month) -->
@if($categoryBreakdown->count())
<div class="rounded-2xl p-5 mb-8 animate-fade-in delay-1" style="background: #111318; border: 1px solid rgba(255,255,255,0.06);">
    <h3 class="text-sm font-bold text-white mb-4">This Month by Category</h3>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach($categoryBreakdown as $cat => $total)
            <div class="rounded-xl p-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                <p class="text-[11px] text-gray-500 capitalize">{{ $categories[$cat] ?? $cat }}</p>
                <p class="text-base font-bold text-white mt-1">{{ $tenant->formatMoney($total, 0) }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Add Expense Form -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 h-fit animate-slide-in">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-red-500/15 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-white">Add Expense</h3>
                <p class="text-xs text-gray-500">Record a new business expense</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl text-sm mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('tenant.expenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Title</label>
                <input type="text" name="title" required class="input-modern" placeholder="e.g. Shop Rent - January">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Amount ({{ $tenant->currency }})</label>
                <input type="number" name="amount" step="0.01" required class="input-modern" placeholder="0.00">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Category</label>
                <select name="category" required class="input-modern">
                    <option value="">— Select Category —</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Expense Date</label>
                <input type="date" name="expense_date" required max="{{ now()->format('Y-m-d') }}" value="{{ now()->format('Y-m-d') }}" class="input-modern">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Description <span class="text-gray-600">(Optional)</span></label>
                <textarea name="description" rows="2" class="input-modern" placeholder="Additional notes..."></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Receipt <span class="text-gray-600">(Optional)</span></label>
                <input type="file" name="receipt" accept="image/*,.pdf" class="input-modern">
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add Expense
            </button>
        </form>
    </div>

    <!-- Expenses List -->
    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden animate-fade-in">
        <div class="px-6 py-5 border-b border-gray-800 flex items-center justify-between flex-wrap gap-3">
            <div>
                <h3 class="text-base font-bold text-white">All Expenses</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $expenses->total() }} recorded</p>
            </div>

            <form method="GET" class="flex gap-2">
                <select name="category" onchange="this.form.submit()" class="input-modern text-xs py-2">
                    <option value="">All Categories</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="divide-y divide-gray-800/50">
            @forelse($expenses as $expense)
            <div class="flex items-center justify-between px-6 py-4 table-row">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 bg-red-500/10 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-white text-sm truncate">{{ $expense->title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $categories[$expense->category] ?? $expense->category }} ·
                            {{ $expense->expense_date->format('d M Y') }} ·
                            {{ $expense->user->name ?? 'Unknown' }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="font-bold text-red-400 text-sm">{{ $tenant->formatMoney($expense->amount) }}</span>
                    @if($expense->receipt)
                        <a href="{{ Storage::url($expense->receipt) }}" target="_blank" class="text-xs text-indigo-400 hover:underline">Receipt</a>
                    @endif
                    <form action="{{ route('tenant.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Delete this expense?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-gray-500 hover:text-red-400">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <p class="text-gray-400 font-semibold">No expenses recorded yet</p>
                <p class="text-gray-600 text-sm mt-1">Add your first expense using the form</p>
            </div>
            @endforelse
        </div>

        @if($expenses->hasPages())
        <div class="px-6 py-4 border-t border-gray-800">
            {{ $expenses->links() }}
        </div>
        @endif
    </div>
</div>

@endsection