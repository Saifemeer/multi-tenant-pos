@extends('layouts.tenant')

@section('title', 'Reports')
@section('page-title', 'Sales Reports')
@section('page-subtitle', 'Business analytics and insights')

@section('content')

@php $tenant = auth()->user()->tenant; @endphp

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-fade-in">
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Today Revenue</p>
        <p class="text-2xl font-black text-emerald-400 mt-2">{{ $tenant->formatMoney($todayRevenue ?? 0, 0) }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">This Week</p>
        <p class="text-2xl font-black text-blue-400 mt-2">{{ $tenant->formatMoney($weekRevenue ?? 0, 0) }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">This Month</p>
       <p class="text-2xl font-black text-purple-400 mt-2">{{ $tenant->formatMoney($monthRevenue ?? 0, 0) }}</p>
    </div>
    <div class="stat-card">
        <p class="text-xs font-semibold text-gray-500 uppercase">Total Revenue</p>
        <p class="text-2xl font-black text-amber-400 mt-2">{{ $tenant->formatMoney($totalRevenue ?? 0, 0) }}</p>
    </div>
</div>

<!-- Chart -->
<div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 mb-8 animate-fade-in delay-1">
    <h3 class="text-base font-bold text-white mb-6">Revenue — Last 7 Days</h3>
    <div style="height: 300px;">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Top Products -->
<div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden animate-fade-in delay-2">
    <div class="px-6 py-5 border-b border-gray-800">
        <h3 class="text-base font-bold text-white">Top Selling Products</h3>
    </div>
    <div class="divide-y divide-gray-800/50">
        @forelse($topProducts ?? [] as $product)
        <div class="flex items-center justify-between px-6 py-4 table-row">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center text-xs font-bold text-blue-400">
                    {{ $loop->iteration }}
                </div>
                <p class="font-semibold text-white text-sm">{{ $product->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-white">{{ $product->total_sold ?? 0 }} sold</p>
                <p class="text-xs text-gray-500">{{ $tenant->formatMoney($product->price) }}</p>
            </div>
        </div>
        @empty
        <div class="py-12 text-center">
            <p class="text-gray-400 font-semibold">No sales data yet</p>
        </div>
        @endforelse
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels ?? ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']) !!},
        datasets: [{
            label: 'Revenue ({{ auth()->user()->tenant->currencySymbol() }})',
            data: {!! json_encode($chartData ?? [0,0,0,0,0,0,0]) !!},
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#3b82f6',
            pointRadius: 5,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { 
                beginAtZero: true, 
                grid: { color: '#1f2937' },
                ticks: { color: '#6b7280' }
            },
            x: { 
                grid: { display: false },
                ticks: { color: '#6b7280' }
            }
        }
    }
});
</script>
@endpush