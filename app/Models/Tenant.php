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
        'phone',         // ✅ space hata diya
        'logo',          // ✅ ADDED
        'address',       // ✅ ADDED
        'currency',      // ✅ ADDED
        'subscription_plan', // ✅ ADDED
        'is_active',     // ✅ ADDED
        'trial_ends_at', // ✅ ADDED
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
        return $this->hasMany(User::class); // ✅ uppercase User
    }

    public function products()
    {
        return $this->hasMany(Product::class); // ✅ ADDED
    }

    public function categories()
    {
        return $this->hasMany(Category::class); // ✅ ADDED
    }

    public function customers()
    {
        return $this->hasMany(Customer::class); // ✅ ADDED
    }

    public function orders()
    {
        return $this->hasMany(Order::class); // ✅ ADDED
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class); // ✅ ADDED
    }

    public function subscription()
    {
        return $this->hasOne(TenantSubscription::class)->latest(); // ✅ ADDED
    }

    // ============================================
    // HELPERS
    // ============================================

    // Tenant active hai ya nahi
    public function isActive(): bool
    {
        return $this->is_active;
    }

    // Trial mein hai ya nahi
    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    // Plan check karna
    public function hasPlan(string $plan): bool
    {
        return $this->subscription_plan === $plan;
    }
}