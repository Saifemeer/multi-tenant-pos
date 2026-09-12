@extends('layouts.super-admin')

@section('page-title', 'Edit Tenant')
@section('page-subtitle', $tenant->company_name . ' ki detail update karein')

@section('content')
<div class="w-full max-w-3xl">

    <div class="flex items-center gap-4 mb-8 animate-fade-in">
        <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Tenant Par Wapas Jayein
        </a>
    </div>

    <div class="rounded-2xl overflow-hidden animate-fade-in delay-1" style="background: var(--bg-card); border: 1px solid var(--border);">
        <div class="px-6 py-4" style="border-bottom: 1px solid var(--border);">
            <h3 class="text-sm font-bold" style="color: var(--text-heading);">Tenant Ki Detail Edit Karein</h3>
            <p class="text-[11px] mt-0.5" style="color: var(--text-muted);">Business ki maloomat aur subscription plan update karein</p>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="alert alert-error mb-5">
                    <div class="flex-1">
                        @foreach ($errors->all() as $error)
                            <p class="text-xs">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('super-admin.tenants.update', $tenant) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Company Ka Naam</label>
                        <input type="text" name="company_name" required value="{{ old('company_name', $tenant->company_name) }}" class="input-modern">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Contact Email</label>
                        <input type="email" name="email" required value="{{ old('email', $tenant->email) }}" class="input-modern">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $tenant->phone) }}" class="input-modern">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Business Ki Category</label>
                        <input type="text" name="business_category" value="{{ old('business_category', $tenant->business_category) }}" class="input-modern">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Currency</label>
                        <select name="currency" class="input-modern">
                            <option value="PKR" {{ old('currency', $tenant->currency) === 'PKR' ? 'selected' : '' }}>PKR</option>
                            <option value="USD" {{ old('currency', $tenant->currency) === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="AED" {{ old('currency', $tenant->currency) === 'AED' ? 'selected' : '' }}>AED</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Subscription Plan</label>
                        <select name="subscription_plan" class="input-modern">
                            <option value="starter" {{ old('subscription_plan', $tenant->subscription_plan) === 'starter' ? 'selected' : '' }}>Starter</option>
                            <option value="business" {{ old('subscription_plan', $tenant->subscription_plan) === 'business' ? 'selected' : '' }}>Business</option>
                            <option value="enterprise" {{ old('subscription_plan', $tenant->subscription_plan) === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                        </select>
                        <p class="text-[10.5px] mt-1.5" style="color: var(--text-muted);">⚠️ Plan khud change karne se Stripe billing update nahi hoti.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2" style="color: var(--text-muted);">Pata</label>
                    <textarea name="address" rows="2" class="input-modern">{{ old('address', $tenant->address) }}</textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('super-admin.tenants.show', $tenant) }}" class="btn-secondary flex-1 justify-center">Cancel</a>
                    <button type="submit" class="btn-primary flex-1 justify-center">Changes Save Karein</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection