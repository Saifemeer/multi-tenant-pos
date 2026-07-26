<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Purana global-unique constraint hatao
            $table->dropUnique(['order_number']);

            // Naya composite-unique constraint: tenant_id + order_number
            $table->unique(['tenant_id', 'order_number']);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['tenant_id', 'order_number']);
            $table->unique('order_number');
        });
    }
};