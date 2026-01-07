<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Paket Nasi',
                'slug' => 'paket-nasi',
                'description' => 'Paket nasi lengkap dengan lauk pauk pilihan'
            ],
            [
                'name' => 'Lauk Pauk',
                'slug' => 'lauk-pauk',
                'description' => 'Berbagai macam lauk pauk segar dan lezat'
            ],
            [
                'name' => 'Sayuran',
                'slug' => 'sayuran',
                'description' => 'Sayuran segar dan bergizi'
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'description' => 'Minuman segar dan menyehatkan'
            ],
            [
                'name' => 'Snack',
                'slug' => 'snack',
                'description' => 'Camilan dan kue-kue lezat'
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
