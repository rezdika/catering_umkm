<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'minimum_order_quantity',
                'value' => '10',
                'description' => 'Minimum total quantity for order (total porsi)'
            ],
            [
                'key' => 'max_delivery_distance',
                'value' => '20',
                'description' => 'Maximum delivery distance in kilometers'
            ],
            [
                'key' => 'order_cutoff_time',
                'value' => '15:00',
                'description' => 'Cut-off time for same day order (format: HH:MM)'
            ],
            [
                'key' => 'min_delivery_days',
                'value' => '1',
                'description' => 'Minimum days for delivery (1 = next day, 2 = day after tomorrow)'
            ],
            [
                'key' => 'company_name',
                'value' => "D'Yummy Catering",
                'description' => 'Company name'
            ],
            [
                'key' => 'company_phone',
                'value' => '+62 821-2609-9407',
                'description' => 'Company phone number'
            ],
            [
                'key' => 'company_email',
                'value' => 'rezdika31@gmail.com',
                'description' => 'Company email address'
            ],
            [
                'key' => 'bank_account_bca',
                'value' => '1234567890',
                'description' => 'BCA Bank Account Number'
            ],
            [
                'key' => 'bank_account_bca_name',
                'value' => 'D\'Yummy Catering',
                'description' => 'BCA Account Holder Name'
            ],
            [
                'key' => 'bank_account_bni',
                'value' => '0987654321',
                'description' => 'BNI Bank Account Number'
            ],
            [
                'key' => 'bank_account_bni_name',
                'value' => 'D\'Yummy Catering',
                'description' => 'BNI Account Holder Name'
            ]
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'description' => $setting['description'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
