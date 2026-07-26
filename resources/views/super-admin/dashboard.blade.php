@extends('layouts.super-admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Super Admin Dashboard</h1>
        <a href="{{ route('super-admin.tenants.index') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
            Manage Tenants
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Tenants</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_tenants'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Active Tenants</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['active_tenants'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Inactive Tenants</p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $stats['inactive_tenants'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Users</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Orders (Platform)</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_orders'] }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Total Revenue (Platform)</p>
            <p class="text-2xl font-bold text-indigo-600 mt-1">PKR {{ number_format($stats['total_revenue'], 2) }}</p>
        </div>

    </div>

    {{-- Trials Expiring Soon --}}
    @if($expiringTrials->count())
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-8">
        <h2 class="text-sm font-semibold text-yellow-800 mb-3">⚠️ Trials Expiring Soon (within 3 days)</h2>
        <ul class="space-y-1">
            @foreach($expiringTrials as $t)
                <li class="text-sm text-yellow-700">
                    {{ $t->company_name }} — expires {{ $t->trial_ends_at->diffForHumans() }}
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Recent Tenants --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Recently Registered Tenants</h2>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentTenants as $tenant)
                <div class="px-5 py-4 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $tenant->company_name }}</p>
                        <p class="text-xs text-gray-500">{{ $tenant->business_category }} · {{ $tenant->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        {{ $tenant->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $tenant->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            @empty
                <p class="px-5 py-6 text-sm text-gray-500">No tenants yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection