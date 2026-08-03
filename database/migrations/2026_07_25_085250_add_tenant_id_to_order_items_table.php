<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('tenant_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('tenants')
                  ->cascadeOnDelete();
        });

        // ✅ Purane records mein tenant_id fill karo — sirf MySQL pe (production)
        // SQLite (jo tests use karti hain) ye syntax support nahi karta,
        // aur test database hamesha khali shuru hoti hai isliye zaroorat bhi nahi
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement('
                UPDATE order_items
                INNER JOIN orders ON orders.id = order_items.order_id
                SET order_items.tenant_id = orders.tenant_id
            ');
        }
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};