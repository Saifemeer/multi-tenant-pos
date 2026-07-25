<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('slug')->unique(); // ✅ unique() fixed
            $table->string('email')->unique(); // ✅ unique() fixed
            $table->string('phone')->nullable();
            $table->string('logo')->nullable(); // ✅ ADDED
            $table->string('address')->nullable(); // ✅ ADDED
            $table->string('currency', 10)->default('PKR'); // ✅ ADDED
            $table->enum('subscription_plan', ['free', 'basic', 'pro', 'enterprise'])->default('free'); // ✅ ADDED
            $table->boolean('is_active')->default(true); // ✅ ADDED
            $table->timestamp('trial_ends_at')->nullable(); // ✅ ADDED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};