<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryTypes = [
            [
                'name' => 'Motor',
                'min_quantity' => 10,
                'max_quantity' => 10,
                'base_price' => 15000,
                'price_per_km' => 2000,
                'vehicle_type' => 'motor'
            ],
            [
                'name' => 'Mobil',
                'min_quantity' => 11,
                'max_quantity' => null,
                'base_price' => 25000,
                'price_per_km' => 3000,
                'vehicle_type' => 'mobil'
            ]
        ];

        foreach ($deliveryTypes as $type) {
            DB::table('delivery_types')->insert([
                'name' => $type['name'],
                'min_quantity' => $type['min_quantity'],
                'max_quantity' => $type['max_quantity'],
                'base_price' => $type['base_price'],
                'price_per_km' => $type['price_per_km'],
                'vehicle_type' => $type['vehicle_type'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
