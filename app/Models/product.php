<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'sku',
        'barcode',
        'image',
        'description',
        'price',
        'cost_price',
        'tax_rate',
        'stock_quantity',
        'low_stock_alert',
        'is_active',
        'track_inventory',
    ];

    protected $casts = [
        'price'         => 'decimal:2',
        'cost_price'    => 'decimal:2',
        'tax_rate'      => 'decimal:2',
        'is_active'     => 'boolean',
        'track_inventory' => 'boolean',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    // ============================================
    // HELPERS
    // ============================================

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->low_stock_alert;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    public function getProfit(): float
    {
        return $this->price - ($this->cost_price ?? 0);
    }

    public function getProfitPercentage(): float
    {
        if (!$this->cost_price || $this->cost_price == 0) return 0;
        return round((($this->price - $this->cost_price) / $this->cost_price) * 100, 2);
    }

    public function getTaxAmount(): float
    {
        return ($this->price * $this->tax_rate) / 100;
    }

    public function getPriceWithTax(): float
    {
        return $this->price + $this->getTaxAmount();
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query->whereRaw('stock_quantity <= low_stock_alert');
    }

    public function scopeOutOfStock(Builder $query): Builder
    {
        return $query->where('stock_quantity', '<=', 0);
    }

    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%")
              ->orWhere('barcode', 'like', "%{$search}%");
        });
    }
}