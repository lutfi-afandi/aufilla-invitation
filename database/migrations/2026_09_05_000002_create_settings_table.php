<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general')->index();
            $table->timestamps();
        });

        // Seed default initial settings
        $defaults = [
            // General / Brand
            ['key' => 'app_name', 'value' => 'Aufilla Invitation', 'group' => 'general'],
            ['key' => 'app_tagline', 'value' => 'Undangan Pernikahan Digital Elegan & Modern', 'group' => 'general'],
            ['key' => 'app_logo', 'value' => null, 'group' => 'general'],
            ['key' => 'app_logo_dark', 'value' => null, 'group' => 'general'],
            ['key' => 'app_favicon', 'value' => null, 'group' => 'general'],
            ['key' => 'app_og_image', 'value' => null, 'group' => 'general'],

            // Contact & Social
            ['key' => 'contact_whatsapp', 'value' => '6281234567890', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'support@aufilla.com', 'group' => 'contact'],
            ['key' => 'contact_instagram', 'value' => 'aufilla.invitation', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia', 'group' => 'contact'],

            // SEO & Meta
            ['key' => 'meta_description', 'value' => 'Buat undangan pernikahan digital premium, elegan, dan mudah digunakan. Bagikan momen kebahagiaan Anda tanpa batas dengan Aufilla Invitation.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'undangan pernikahan digital, undangan online, undangan website, buat undangan digital, aufilla invitation, undangan premium', 'group' => 'seo'],
            ['key' => 'meta_author', 'value' => 'Aufilla Invitation', 'group' => 'seo'],

            // FAQs (JSON)
            [
                'key' => 'faqs',
                'value' => json_encode([
                    [
                        'pertanyaan' => 'Berapa lama proses pembuatan undangan?',
                        'jawaban' => 'Undangan Anda langsung aktif dan siap digunakan seketika setelah pendaftaran selesai. Anda bisa langsung mengisi data mempelai, acara, dan menyebarkan undangan.',
                    ],
                    [
                        'pertanyaan' => 'Apakah bisa kirim undangan tanpa batas ke tamu?',
                        'jawaban' => 'Ya, Anda dapat menambahkan daftar tamu dan membagikan tautan undangan khusus untuk masing-masing nama tamu tanpa batasan.',
                    ],
                    [
                        'pertanyaan' => 'Apakah musik latar bisa diganti dengan lagu sendiri?',
                        'jawaban' => 'Tentu saja! Anda dapat mengunggah file musik MP3 favorit Anda sendiri atau memilih dari koleksi musik yang kami sediakan.',
                    ],
                    [
                        'pertanyaan' => 'Bagaimana cara tamu mengirimkan amplop digital / kado fisik?',
                        'jawaban' => 'Tamu dapat mentransfer amplop digital langsung ke nomor rekening/e-wallet Anda dan mengonfirmasi kiriman kado fisik ke alamat pengiriman yang tertera di undangan.',
                    ],
                    [
                        'pertanyaan' => 'Apakah tema undangan bisa disesuaikan dengan konsep adat?',
                        'jawaban' => 'Kami menyediakan beragam kategori tema mulai dari Minimalis Modern, Tradisional Jawa, Tradisional Minang, Islami, hingga Eksklusif Floral yang dapat dipilih sesuai tema pernikahan Anda.',
                    ],
                ]),
                'group' => 'faq',
            ],
        ];

        $now = now();
        foreach ($defaults as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        DB::table('settings')->insert($defaults);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
