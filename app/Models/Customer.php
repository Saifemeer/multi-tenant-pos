<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'email',
        'address',
        'total_spent',
        'credit_balance',
        'visit_count',
        'loyalty_points',
    ];

    protected $casts = [
        'total_spent'    => 'decimal:2',
        'credit_balance' => 'decimal:2',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}