<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Sirf MySQL pe chalao — SQLite (tests ke liye) columns dynamically
        // typed hote hain, isliye ye ALTER command wahan zaroori nahi
        if (DB::connection()->getDriverName() === 'mysql') {
            // ENUM ko VARCHAR mein badal do — zyada flexible, future mein naye plans add karna aasan hoga
            DB::statement("ALTER TABLE tenants MODIFY subscription_plan VARCHAR(255) NULL");
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE tenants MODIFY subscription_plan ENUM('free','basic','premium') NULL");
        }
    }
};