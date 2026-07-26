<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ENUM ko VARCHAR mein badal do — zyada flexible, future mein naye plans add karna aasan hoga
        DB::statement("ALTER TABLE tenants MODIFY subscription_plan VARCHAR(255) NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tenants MODIFY subscription_plan ENUM('free','basic','premium') NULL");
    }
};