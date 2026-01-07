<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['area_name' => 'Bandung Utara', 'distance_km' => 8.5],
            ['area_name' => 'Bandung Selatan', 'distance_km' => 12.0],
            ['area_name' => 'Bandung Timur', 'distance_km' => 15.5],
            ['area_name' => 'Bandung Barat', 'distance_km' => 10.0],
            ['area_name' => 'Cimahi', 'distance_km' => 18.0],
            ['area_name' => 'Cinambo', 'distance_km' => 5.0],
            ['area_name' => 'Ujungberung', 'distance_km' => 20.0],
            ['area_name' => 'Arcamanik', 'distance_km' => 12.5],
            ['area_name' => 'Antapani', 'distance_km' => 9.0],
            ['area_name' => 'Cicaheum', 'distance_km' => 7.5]
        ];

        foreach ($areas as $area) {
            DB::table('delivery_areas')->insert([
                'area_name' => $area['area_name'],
                'distance_km' => $area['distance_km'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
