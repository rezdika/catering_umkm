<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class KurirSeeder extends Seeder
{
    public function run(): void
    {
        // Create Kurir User if not exists
        if (!User::where('email', 'kurir@catering.com')->exists()) {
            User::create([
                'name' => 'Kurir Pengiriman',
                'email' => 'kurir@catering.com',
                'phone' => '081234567894',
                'password' => Hash::make('kurir123'),
                'role' => 'kurir',
                'is_active' => true,
                'email_verified_at' => now()
            ]);
        }
    }
}