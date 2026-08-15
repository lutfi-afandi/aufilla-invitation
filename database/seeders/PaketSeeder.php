<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paket;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'name' => 'Trial',
                'price' => 0.00,
                'active_days' => 3,
                'max_gallery_photos' => 5,
                'has_love_story' => true,
                'can_custom_music' => true,
                'is_priority_support' => false,
                'description' => 'Paket uji coba gratis 3 hari untuk mencoba fitur pembuatan undangan.',
            ],
            [
                'name' => 'Basic',
                'price' => 35000.00,
                'active_days' => 90, // 3 Bulan
                'max_gallery_photos' => 5,
                'has_love_story' => false,
                'can_custom_music' => false,
                'is_priority_support' => false,
                'description' => 'Paket ekonomis dengan fitur dasar untuk menyebarkan undangan digital dengan mudah.',
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
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::updateOrCreate(['name' => $paket['name']], $paket);
        }
    }
}
