<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'user_id',
        'order_number',
        'subtotal',
        'tax',
        'discount',
        'total',
        'payment_method',
        'status',
        'notes',
        'refunded_by',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax'      => 'decimal:2',
        'discount' => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = static::generateOrderNumber($order->tenant_id);
            }
        });
    }

    // Tenant-specific order number, race-condition safe
    protected static function generateOrderNumber(int $tenantId): string
    {
        return DB::transaction(function () use ($tenantId) {
            // lockForUpdate se concurrent requests mein duplicate number nahi banega
            $count = static::withoutGlobalScope('tenant')
                ->where('tenant_id', $tenantId)
                ->lockForUpdate()
                ->count();

            return 'ORD-' . date('Y') . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }
    public function refundedBy()
    {
        return $this->belongsTo(User::class, 'refunded_by');
    }
}