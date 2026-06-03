<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('packages')->insert([
            [
                'name' => 'Basic',
                'price' => 35000.00,
                'active_days' => 90, // 3 Bulan
                'max_gallery_photos' => 5,
                'has_love_story' => false,
                'can_custom_music' => false,
                'is_priority_support' => false,
                'description' => 'Paket ekonomis dengan fitur dasar untuk menyebarkan undangan digital dengan mudah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premium',
                'price' => 50000.00,
                'active_days' => 180, // 6 Bulan
                'max_gallery_photos' => 10,
                'has_love_story' => true,
                'can_custom_music' => false,
                'is_priority_support' => false,
                'description' => 'Pilihan tepat dengan masa aktif lebih lama dan fitur ekstra untuk melengkapi momen spesial Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VIP',
                'price' => 80000.00,
                'active_days' => 36500, // 100 Tahun (Permanen)
                'max_gallery_photos' => 999, // Unlimited
                'has_love_story' => true,
                'can_custom_music' => true,
                'is_priority_support' => true,
                'description' => 'Paket paling lengkap tanpa batasan. Aktif selamanya dengan dukungan penuh dan kebebasan kustomisasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
