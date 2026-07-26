@extends('layouts.super-admin')

@section('page-title', 'Tenants')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">All Tenants</h1>
        <a href="{{ route('super-admin.dashboard') }}" class="text-sm text-indigo-600 hover:underline">
            ← Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" class="flex gap-3 mb-5">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by company name..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-indigo-400">

        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-900">
            Filter
        </button>
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3">Company</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Users</th>
                    <th class="text-left px-5 py-3">Plan</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Joined</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($tenants as $tenant)
                    <tr>
                        <td class="px-5 py-4 font-medium text-gray-800">{{ $tenant->company_name }}</td>
                        <td class="px-5 py-4 text-gray-600">{{ $tenant->business_category }}</td>
                        <td class="px-5 py-4 text-gray-600">{{ $tenant->users_count }}</td>
                        <td class="px-5 py-4 text-gray-600">{{ $tenant->subscription_plan ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <span class="text-xs px-2 py-1 rounded-full font-medium
                                {{ $tenant->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $tenant->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $tenant->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-4 text-right space-x-2">
                            <a href="{{ route('super-admin.tenants.show', $tenant) }}"
                               class="text-indigo-600 hover:underline text-sm">View</a>

                            <form action="{{ route('super-admin.tenants.toggle-status', $tenant) }}"
                                  method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-sm hover:underline
                                    {{ $tenant->is_active ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $tenant->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <form action="{{ route('super-admin.tenants.destroy', $tenant) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure? This will permanently delete this tenant and all its data.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-gray-500 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-gray-500">No tenants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $tenants->links() }}
    </div>

</div>
@endsection