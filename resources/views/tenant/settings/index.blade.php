@extends('layouts.tenant')

@section('title', 'Settings')
@section('page-title', 'Business Settings')
@section('page-subtitle', 'Manage your store configuration')

@section('content')

<div class="max-w-2xl space-y-6 animate-fade-in">
    
    <!-- Business Info -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <h3 class="text-base font-bold text-white mb-6">Business Information</h3>
        
        <form action="{{ route('tenant.settings.update') }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Business Name</label>
                <input type="text" name="company_name" value="{{ auth()->user()->tenant->company_name }}" class="input-modern">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->tenant->email }}" class="input-modern">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ auth()->user()->tenant->phone }}" class="input-modern">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Address</label>
                <textarea name="address" class="input-modern" rows="2">{{ auth()->user()->tenant->address }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Currency</label>
                <select name="currency" class="input-modern">
                    <option value="PKR" {{ auth()->user()->tenant->currency == 'PKR' ? 'selected' : '' }}>PKR (Pakistani Rupee)</option>
                    <option value="USD" {{ auth()->user()->tenant->currency == 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                    <option value="AED" {{ auth()->user()->tenant->currency == 'AED' ? 'selected' : '' }}>AED (UAE Dirham)</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Save Changes
            </button>
        </form>
    </div>
    
    <!-- Profile -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">
        <h3 class="text-base font-bold text-white mb-6">Your Profile</h3>
        
        <form action="{{ route('tenant.settings.profile') }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" class="input-modern">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" class="input-modern">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">New Password <span class="text-gray-600">(Leave empty to keep current)</span></label>
                <input type="password" name="password" class="input-modern" placeholder="Enter new password">
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Update Profile
            </button>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-gray-900 border border-red-900/30 rounded-2xl p-6">
        <h3 class="text-base font-bold text-red-400 mb-2">Danger Zone</h3>
        <p class="text-xs text-gray-500 mb-4">Permanently delete your business account and all data</p>
        <button onclick="confirm('Are you sure? This cannot be undone!') && document.getElementById('delete-form').submit()"
                class="btn-danger">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Delete Business Account
        </button>
        <form id="delete-form" action="{{ route('tenant.settings.destroy') }}" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>
</div>

@endsection