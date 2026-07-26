@extends('layouts.tenant')

@section('title', 'Staff')
@section('page-title', 'Staff Management')
@section('page-subtitle', 'Manage your team members and their access')

@section('content')

@if(session('success'))
    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-3 rounded-xl text-sm">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl text-sm">
        {{ session('error') }}
    </div>
@endif

@if(!$tenant->canManageStaff())
    <div class="mb-6 bg-amber-500/10 border border-amber-500/30 text-amber-400 p-4 rounded-xl text-sm flex items-center justify-between">
        <span>Staff management sirf Business ya Enterprise plan mein available hai. Abhi aap "{{ ucfirst($tenant->subscription_plan) }}" plan pe hain.</span>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Add Staff Form -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 h-fit animate-slide-in">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-indigo-500/15 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-white">Add Staff Member</h3>
                <p class="text-xs text-gray-500">Invite a manager or cashier</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl text-sm mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('tenant.staff.store') }}" method="POST" class="space-y-4 {{ !$tenant->canManageStaff() ? 'opacity-50 pointer-events-none' : '' }}">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Full Name</label>
                <input type="text" name="name" required class="input-modern" placeholder="e.g. Ali Hassan" value="{{ old('name') }}">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" required class="input-modern" placeholder="staff@email.com" value="{{ old('email') }}">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" required class="input-modern" placeholder="Minimum 8 characters">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Role</label>
                <select name="role" required class="input-modern">
                    <option value="cashier">Cashier</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" {{ !$tenant->canManageStaff() ? 'disabled' : '' }}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Add Staff Member
            </button>
        </form>
    </div>

    <!-- Staff List -->
    <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden animate-fade-in">
        <div class="px-6 py-5 border-b border-gray-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-white">Team Members</h3>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $staff->count() }} {{ $tenant->userLimit() ? '/ ' . $tenant->userLimit() : '' }} members
                </p>
            </div>
        </div>

        <div class="divide-y divide-gray-800/50">
            @forelse($staff as $member)
            <div class="flex items-center justify-between px-6 py-4 table-row">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center text-xs font-bold text-gray-400">
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">{{ $member->name }}</p>
                        <p class="text-xs text-gray-500">{{ $member->email }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-lg capitalize
                        {{ $member->role === 'admin' ? 'bg-indigo-500/15 text-indigo-400' :
                           ($member->role === 'manager' ? 'bg-purple-500/15 text-purple-400' : 'bg-blue-500/15 text-blue-400') }}">
                        {{ $member->role }}
                    </span>

                    <span class="text-xs font-semibold px-2.5 py-1 rounded-lg
                        {{ $member->is_active ? 'bg-emerald-500/15 text-emerald-400' : 'bg-red-500/15 text-red-400' }}">
                        {{ $member->is_active ? 'Active' : 'Inactive' }}
                    </span>

                    @if($member->role !== 'admin' && $member->id !== auth()->id())
                        <form action="{{ route('tenant.staff.toggle-status', $member) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs {{ $member->is_active ? 'text-red-400' : 'text-emerald-400' }} hover:underline">
                                {{ $member->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form action="{{ route('tenant.staff.destroy', $member) }}" method="POST" onsubmit="return confirm('Remove this staff member?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-gray-500 hover:text-red-400 hover:underline">
                                Remove
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="py-16 text-center">
                <p class="text-gray-400 font-semibold">Sirf aap hi ho abhi</p>
                <p class="text-gray-600 text-sm mt-1">Staff add karo apni team banane ke liye</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection