<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Catering',
            'email' => 'admin@catering.com',
            'phone' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        // Create Staff Users
        User::create([
            'name' => 'Staff Dapur',
            'email' => 'dapur@catering.com',
            'phone' => '081234567891',
            'password' => Hash::make('dapur123'),
            'role' => 'staff_dapur',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Admin Keuangan',
            'email' => 'keuangan@catering.com',
            'phone' => '081234567892',
            'password' => Hash::make('keuangan123'),
            'role' => 'admin_keuangan',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Kurir Pengiriman',
            'email' => 'kurir@catering.com',
            'phone' => '081234567894',
            'password' => Hash::make('kurir123'),
            'role' => 'kurir',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        // Create Test User
        User::create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'phone' => '081234567893',
            'password' => Hash::make('user123'),
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now()
        ]);
    }
}