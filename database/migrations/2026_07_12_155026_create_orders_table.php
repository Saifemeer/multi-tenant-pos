<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Cashier
            $table->string('order_number')->unique(); // ✅ Auto-generated: ORD-2024-0001
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('payment_method', [
                'cash', 'card', 'jazzcash', 'easypaisa', 'bank_transfer', 'credit'
            ])->default('cash');
            $table->enum('status', [
                'pending', 'completed', 'refunded', 'cancelled'
            ])->default('completed');
            $table->text('notes')->nullable(); // ✅ Order notes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};