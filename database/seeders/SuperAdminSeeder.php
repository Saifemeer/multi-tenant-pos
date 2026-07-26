<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'tenant_id' => null,
                'name'      => 'Super Admin',
                'password'  => Hash::make('12345678'),
                'role'      => 'super_admin',
                'is_active' => true,
            ]
        );
    }
}