<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            // PAKET NASI (category_id: 1)
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Ayam Goreng',
                'slug' => 'paket-nasi-ayam-goreng',
                'description' => 'Nasi putih dengan ayam goreng crispy dan lalapan segar',
                'price' => 25000,
                'stock' => 50,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Ayam Bakar',
                'slug' => 'paket-nasi-ayam-bakar',
                'description' => 'Ayam bakar bumbu kecap dengan nasi dan sambal',
                'price' => 28000,
                'stock' => 40,
                'tags' => json_encode(['bestseller', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Ayam Kecap',
                'slug' => 'paket-nasi-ayam-kecap',
                'description' => 'Ayam kecap manis dengan nasi putih hangat',
                'price' => 26000,
                'stock' => 35,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Ayam Crispy',
                'slug' => 'paket-nasi-ayam-crispy',
                'description' => 'Ayam crispy renyah dengan saus spesial',
                'price' => 30000,
                'stock' => 30,
                'tags' => json_encode(['baru', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Rendang',
                'slug' => 'paket-nasi-rendang',
                'description' => 'Rendang daging sapi dengan bumbu tradisional',
                'price' => 35000,
                'stock' => 25,
                'tags' => json_encode(['rekomendasi', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Soto Ayam',
                'slug' => 'paket-nasi-soto-ayam',
                'description' => 'Soto ayam kuning dengan lontong dan kerupuk',
                'price' => 22000,
                'stock' => 45,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Gudeg',
                'slug' => 'paket-nasi-gudeg',
                'description' => 'Gudeg khas Yogya dengan ayam dan telur',
                'price' => 24000,
                'stock' => 30,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Ikan Bakar',
                'slug' => 'paket-nasi-ikan-bakar',
                'description' => 'Ikan bakar segar dengan sambal dan lalapan',
                'price' => 32000,
                'stock' => 20,
                'tags' => json_encode(['promo', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Liwet Ayam',
                'slug' => 'paket-nasi-liwet-ayam',
                'description' => 'Nasi liwet dengan ayam suwir dan sambal',
                'price' => 23000,
                'stock' => 35,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 1,
                'name' => 'Paket Nasi Ayam Sambal Matah',
                'slug' => 'paket-nasi-ayam-sambal-matah',
                'description' => 'Ayam dengan sambal matah khas Bali',
                'price' => 27000,
                'stock' => 25,
                'tags' => json_encode(['sale', 'halal'])
            ],

            // LAUK PAUK (category_id: 2)
            [
                'category_id' => 2,
                'name' => 'Ayam Goreng',
                'slug' => 'ayam-goreng',
                'description' => 'Ayam goreng crispy dengan bumbu rempah',
                'price' => 18000,
                'stock' => 60,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Ayam Bakar',
                'slug' => 'ayam-bakar',
                'description' => 'Ayam bakar bumbu kecap manis',
                'price' => 20000,
                'stock' => 50,
                'tags' => json_encode(['bestseller', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Ayam Kecap',
                'slug' => 'ayam-kecap',
                'description' => 'Ayam dengan saus kecap manis gurih',
                'price' => 19000,
                'stock' => 45,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Ayam Crispy',
                'slug' => 'ayam-crispy',
                'description' => 'Ayam crispy dengan saus spesial',
                'price' => 22000,
                'stock' => 40,
                'tags' => json_encode(['baru', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Rendang Daging',
                'slug' => 'rendang-daging',
                'description' => 'Rendang daging sapi bumbu tradisional',
                'price' => 28000,
                'stock' => 30,
                'tags' => json_encode(['rekomendasi', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Semur Daging',
                'slug' => 'semur-daging',
                'description' => 'Semur daging empuk dengan bumbu manis',
                'price' => 25000,
                'stock' => 35,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Daging Lada Hitam',
                'slug' => 'daging-lada-hitam',
                'description' => 'Daging sapi dengan saus lada hitam',
                'price' => 26000,
                'stock' => 25,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Ikan Goreng',
                'slug' => 'ikan-goreng',
                'description' => 'Ikan segar goreng dengan bumbu kuning',
                'price' => 16000,
                'stock' => 40,
                'tags' => json_encode(['promo', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Ikan Bakar',
                'slug' => 'ikan-bakar',
                'description' => 'Ikan bakar dengan sambal dan lalapan',
                'price' => 18000,
                'stock' => 35,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 2,
                'name' => 'Telur Balado',
                'slug' => 'telur-balado',
                'description' => 'Telur rebus dengan sambal balado pedas',
                'price' => 12000,
                'stock' => 50,
                'tags' => json_encode(['sale', 'halal'])
            ],

            // SAYURAN (category_id: 3)
            [
                'category_id' => 3,
                'name' => 'Capcay',
                'slug' => 'capcay',
                'description' => 'Tumis sayuran segar dengan saus tiram',
                'price' => 15000,
                'stock' => 40,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Tumis Kangkung',
                'slug' => 'tumis-kangkung',
                'description' => 'Kangkung tumis dengan bumbu terasi',
                'price' => 12000,
                'stock' => 50,
                'tags' => json_encode(['bestseller', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Tumis Buncis',
                'slug' => 'tumis-buncis',
                'description' => 'Buncis segar tumis dengan bawang putih',
                'price' => 13000,
                'stock' => 45,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Sayur Asem',
                'slug' => 'sayur-asem',
                'description' => 'Sayur asem segar dengan jagung dan labu',
                'price' => 14000,
                'stock' => 35,
                'tags' => json_encode(['baru', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Sayur Sop Ayam',
                'slug' => 'sayur-sop-ayam',
                'description' => 'Sop ayam dengan sayuran segar',
                'price' => 16000,
                'stock' => 30,
                'tags' => json_encode(['rekomendasi', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Sayur Lodeh',
                'slug' => 'sayur-lodeh',
                'description' => 'Lodeh sayuran dengan santan kelapa',
                'price' => 15000,
                'stock' => 40,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Tumis Jamur',
                'slug' => 'tumis-jamur',
                'description' => 'Jamur tiram tumis dengan saus tiram',
                'price' => 14000,
                'stock' => 35,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Tumis Tauge',
                'slug' => 'tumis-tauge',
                'description' => 'Tauge segar tumis dengan tahu',
                'price' => 10000,
                'stock' => 50,
                'tags' => json_encode(['promo', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Orek Tempe',
                'slug' => 'orek-tempe',
                'description' => 'Tempe orek dengan kacang panjang',
                'price' => 12000,
                'stock' => 45,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 3,
                'name' => 'Kentang Balado',
                'slug' => 'kentang-balado',
                'description' => 'Kentang goreng dengan sambal balado',
                'price' => 13000,
                'stock' => 40,
                'tags' => json_encode(['sale', 'halal'])
            ],

            // MINUMAN (category_id: 4)
            [
                'category_id' => 4,
                'name' => 'Air Mineral',
                'slug' => 'air-mineral',
                'description' => 'Air mineral segar dalam kemasan',
                'price' => 3000,
                'stock' => 100,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Teh Manis',
                'slug' => 'teh-manis',
                'description' => 'Teh manis hangat tradisional',
                'price' => 5000,
                'stock' => 80,
                'tags' => json_encode(['bestseller', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Teh Tawar',
                'slug' => 'teh-tawar',
                'description' => 'Teh tawar hangat tanpa gula',
                'price' => 4000,
                'stock' => 70,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Es Teh',
                'slug' => 'es-teh',
                'description' => 'Es teh manis segar dengan es batu',
                'price' => 6000,
                'stock' => 60,
                'tags' => json_encode(['baru', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Es Jeruk',
                'slug' => 'es-jeruk',
                'description' => 'Es jeruk segar dengan potongan jeruk',
                'price' => 7000,
                'stock' => 50,
                'tags' => json_encode(['rekomendasi', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Es Lemon Tea',
                'slug' => 'es-lemon-tea',
                'description' => 'Teh dengan perasan lemon segar',
                'price' => 8000,
                'stock' => 45,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Es Buah',
                'slug' => 'es-buah',
                'description' => 'Es buah segar dengan berbagai buah',
                'price' => 10000,
                'stock' => 30,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Jus Jeruk',
                'slug' => 'jus-jeruk',
                'description' => 'Jus jeruk murni tanpa pengawet',
                'price' => 9000,
                'stock' => 35,
                'tags' => json_encode(['promo', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Jus Mangga',
                'slug' => 'jus-mangga',
                'description' => 'Jus mangga manis segar alami',
                'price' => 10000,
                'stock' => 30,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 4,
                'name' => 'Kopi Hitam',
                'slug' => 'kopi-hitam',
                'description' => 'Kopi hitam pekat tanpa gula',
                'price' => 6000,
                'stock' => 40,
                'tags' => json_encode(['sale', 'halal'])
            ],

            // SNACK (category_id: 5)
            [
                'category_id' => 5,
                'name' => 'Risoles',
                'slug' => 'risoles',
                'description' => 'Risoles isi sayuran dan daging cincang',
                'price' => 8000,
                'stock' => 30,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Pastel',
                'slug' => 'pastel',
                'description' => 'Pastel goreng isi sayuran segar',
                'price' => 7000,
                'stock' => 35,
                'tags' => json_encode(['bestseller', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Lemper',
                'slug' => 'lemper',
                'description' => 'Lemper ayam dengan ketan gurih',
                'price' => 6000,
                'stock' => 40,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Dadar Gulung',
                'slug' => 'dadar-gulung',
                'description' => 'Dadar gulung isi kelapa manis',
                'price' => 5000,
                'stock' => 45,
                'tags' => json_encode(['baru', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Kue Sus',
                'slug' => 'kue-sus',
                'description' => 'Kue sus isi vla vanilla lembut',
                'price' => 10000,
                'stock' => 25,
                'tags' => json_encode(['rekomendasi', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Donat',
                'slug' => 'donat',
                'description' => 'Donat empuk dengan berbagai topping',
                'price' => 8000,
                'stock' => 30,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Brownies',
                'slug' => 'brownies',
                'description' => 'Brownies coklat lembut dan legit',
                'price' => 12000,
                'stock' => 20,
                'tags' => json_encode(['hot', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Puding',
                'slug' => 'puding',
                'description' => 'Puding susu dengan berbagai rasa',
                'price' => 9000,
                'stock' => 25,
                'tags' => json_encode(['promo', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Kroket',
                'slug' => 'kroket',
                'description' => 'Kroket kentang isi daging cincang',
                'price' => 7000,
                'stock' => 35,
                'tags' => json_encode(['favorit', 'halal'])
            ],
            [
                'category_id' => 5,
                'name' => 'Lumpia',
                'slug' => 'lumpia',
                'description' => 'Lumpia goreng isi rebung dan ayam',
                'price' => 6000,
                'stock' => 40,
                'tags' => json_encode(['sale', 'halal'])
            ]
        ];

        foreach ($menus as $menu) {
            DB::table('menus')->insert([
                'category_id' => $menu['category_id'],
                'name' => $menu['name'],
                'slug' => $menu['slug'],
                'description' => $menu['description'],
                'price' => $menu['price'],
                'image' => null, // Will be added by admin later
                'stock' => $menu['stock'],
                'tags' => $menu['tags'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}