<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'business_category',
        'slug',
        'email',
        'phone',
        'logo',
        'address',
        'currency',
        'subscription_plan',
        'stripe_customer_id',
        'stripe_subscription_id',
        'subscription_status',
        'is_active',
        'trial_ends_at',
    ];

    protected $casts = [
        'is_active'     => 'boolean',
        'trial_ends_at' => 'datetime',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // ============================================
    // HELPERS
    // ============================================
// ✅ Plan ki config nikalo
// ✅ Currency symbol nikalo
    public function currencySymbol(): string
    {
        return match ($this->currency) {
            'USD' => '$',
            'AED' => 'AED',
            default => 'Rs.',
        };
    }

    // ✅ Formatted amount (symbol + number) — sabse zyada use hoga views mein
    public function formatMoney($amount, int $decimals = 2): string
    {
        return $this->currencySymbol() . ' ' . number_format((float) $amount, $decimals);
    }
    
    public function planConfig(): array
    {
        return config('plans.' . $this->subscription_plan, config('plans.starter'));
    }

    // ✅ Product limit check karo
    public function hasReachedProductLimit(): bool
    {
        $limit = $this->planConfig()['max_products'];

        if ($limit === null) {
            return false; // unlimited
        }

        return $this->products()->count() >= $limit;
    }

    public function productLimit(): ?int
    {
        return $this->planConfig()['max_products'];
    }

    // ✅ Reports access check karo
    public function canAccessReports(): bool
    {
        return $this->planConfig()['reports'] === true;
    }
    // ✅ Staff limit reach ho gayi hai kya
    public function hasReachedUserLimit(): bool
    {
        $limit = $this->planConfig()['max_users'];

        if ($limit === null) {
            return false;
        }

        return $this->users()->count() >= $limit;
    }

    public function userLimit(): ?int
    {
        return $this->planConfig()['max_users'];
    }

    // ✅ Starter plan mein bilkul staff add nahi kar sakte
    public function canManageStaff(): bool
    {
        return $this->userLimit() !== 1;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function hasPlan(string $plan): bool
    {
        return $this->subscription_plan === $plan;
    }

    // ✅ Free plan hai ya paid
    public function isFreePlan(): bool
    {
        return $this->subscription_plan === 'starter';
    }

    // ✅ Subscription active/valid hai (paid plans ke liye)
    public function hasActiveSubscription(): bool
    {
        return in_array($this->subscription_status, ['trialing', 'active']);
    }

    // ✅ Plan ki Stripe Price ID nikalo
    public function stripePriceId(): ?string
    {
        return match ($this->subscription_plan) {
            'business'   => config('services.stripe.prices.business'),
            'enterprise' => config('services.stripe.prices.enterprise'),
            default      => null,
        };

        
    }
}