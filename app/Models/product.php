<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Product extends Model // ✅ uppercase 'P'
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'category_id', // ✅ ADDED
        'name',
        'sku',
        'barcode',     // ✅ ADDED
        'image',       // ✅ ADDED
        'description', // ✅ ADDED
        'price',
        'cost_price',  // ✅ ADDED
        'tax_rate',    // ✅ ADDED
        'stock_quantity',
        'low_stock_alert',
        'is_active',   // ✅ ADDED
        'track_inventory', // ✅ ADDED
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'cost_price'    => 'decimal:2',
        'tax_rate'      => 'decimal:2',
        'is_active'     => 'boolean',
        'track_inventory' => 'boolean',
    ];

    // ============================================
    // MULTI-TENANT GLOBAL SCOPE
    // ============================================

    protected static function booted()
    {
        // Sirf apne tenant ka data dikhao
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::check() && Auth::user()->tenant_id) {
                $builder->where('products.tenant_id', Auth::user()->tenant_id);
            }
        });

        // Create hote waqt tenant_id auto set karo
        static::creating(function ($product) {
            if (Auth::check() && !$product->tenant_id) {
                $product->tenant_id = Auth::user()->tenant_id;
            }
        });
    }

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function tenant()
    {
        return $this->belongsTo(Tenant::class); // ✅ typo fix
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // ✅ ADDED
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class); // ✅ ADDED
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class); // ✅ ADDED
    }

    // ============================================
    // HELPERS
    // ============================================

    // Low stock hai ya nahi
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_alert;
    }

    // Out of stock hai ya nahi
    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    // Profit calculate karo
    public function getProfit(): float
    {
        return $this->price - ($this->cost_price ?? 0);
    }

    // Profit percentage
    public function getProfitPercentage(): float
    {
        if (!$this->cost_price || $this->cost_price == 0) return 0;
        return round((($this->price - $this->cost_price) / $this->cost_price) * 100, 2);
    }

    // Tax amount calculate karo
    public function getTaxAmount(): float
    {
        return ($this->price * $this->tax_rate) / 100;
    }

    // Price with tax
    public function getPriceWithTax(): float
    {
        return $this->price + $this->getTaxAmount();
    }

    // ============================================
    // SCOPES
    // ============================================

    // Active products
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Low stock products
    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereRaw('stock_quantity <= low_stock_alert');
    }

    // Out of stock
    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('stock_quantity', '<=', 0);
    }

    // By category
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    // Search
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('barcode', 'like', "%{$search}%");
        });
    }
}