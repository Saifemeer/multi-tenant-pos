<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_yearly', 10, 2)->default(0);
            $table->integer('max_products')->default(50);
            $table->integer('max_users')->default(2);
            $table->integer('max_orders_per_month')->default(100);
            $table->boolean('has_reports')->default(false);
            $table->boolean('has_inventory')->default(true);
            $table->boolean('has_customers')->default(false);
            $table->boolean('has_expenses')->default(false);
            $table->boolean('has_whatsapp')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tenant_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')
                  ->constrained('tenants')
                  ->onDelete('cascade');
            $table->foreignId('plan_id')
                  ->constrained('subscription_plans');
            $table->enum('status', [
                'active', 'cancelled', 'expired', 'trial'
            ])->default('trial');
            $table->enum('billing_cycle', [
                'monthly', 'yearly'
            ])->default('monthly');
            $table->decimal('amount', 10, 2);
            $table->timestamp('starts_at')->nullable(); // ✅ nullable kiya
            $table->timestamp('ends_at')->nullable();   // ✅ nullable kiya
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
};