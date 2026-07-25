<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // ✅ ADDED
            $table->string('name');
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable(); // ✅ ADDED
            $table->string('image')->nullable(); // ✅ ADDED
            $table->text('description')->nullable(); // ✅ ADDED
            $table->decimal('price', 10, 2); // Selling price
            $table->decimal('cost_price', 10, 2)->nullable(); // ✅ ADDED — Purchase price
            $table->decimal('tax_rate', 5, 2)->default(0); // ✅ ADDED — Tax %
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_alert')->default(5);
            $table->boolean('is_active')->default(true); // ✅ ADDED
            $table->boolean('track_inventory')->default(true); // ✅ ADDED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};