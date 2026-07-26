@extends('layouts.super-admin')

@section('page-title', $tenant->company_name)

@section('content')
<div class="max-w-5xl mx-auto">

    <a href="{{ route('super-admin.tenants.index') }}" class="text-sm text-indigo-600 hover:underline mb-4 inline-block">
        ← Back to Tenants
    </a>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $tenant->company_name }}</h1>
            <p class="text-sm text-gray-500">{{ $tenant->business_category }} · {{ $tenant->email }}</p>
        </div>
        <span class="text-xs px-3 py-1 rounded-full font-medium
            {{ $tenant->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
            {{ $tenant->is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Users</p>
            <p class="text-xl font-bold text-gray-800 mt-1">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Products</p>
            <p class="text-xl font-bold text-gray-800 mt-1">{{ $stats['total_products'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Orders</p>
            <p class="text-xl font-bold text-gray-800 mt-1">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm text-gray-500">Revenue</p>
            <p class="text-xl font-bold text-indigo-600 mt-1">PKR {{ number_format($stats['total_revenue'], 2) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
        <h2 class="font-semibold text-gray-800 mb-3">Business Info</h2>
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-gray-500">Slug</dt>
                <dd class="text-gray-800">{{ $tenant->slug }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Currency</dt>
                <dd class="text-gray-800">{{ $tenant->currency }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Plan</dt>
                <dd class="text-gray-800">{{ $tenant->subscription_plan ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Trial Ends</dt>
                <dd class="text-gray-800">{{ $tenant->trial_ends_at?->format('d M Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-gray-500">Joined</dt>
                <dd class="text-gray-800">{{ $tenant->created_at->format('d M Y') }}</dd>
            </div>
        </dl>
    </div>

    <div class="flex gap-3">
        <form action="{{ route('super-admin.tenants.toggle-status', $tenant) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
                class="px-4 py-2 rounded-lg text-sm font-medium text-white
                {{ $tenant->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }}">
                {{ $tenant->is_active ? 'Deactivate Tenant' : 'Activate Tenant' }}
            </button>
        </form>
    </div>

</div>
@endsection