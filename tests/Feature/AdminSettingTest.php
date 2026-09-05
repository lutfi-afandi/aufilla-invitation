<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_settings(): void
    {
        $user = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($user)->get('/admin/settings');
        $response->assertStatus(403);
    }

    public function test_admin_can_view_settings_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/settings');

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Website', false);
        $response->assertSee('Identitas & Brand', false);
        $response->assertSee('Kontak & Sosmed', false);
        $response->assertSee('SEO & Meta Share', false);
        $response->assertSee('Daftar FAQ', false);
    }

    public function test_admin_can_update_general_brand_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->postJson('/admin/settings', [
            'group' => 'general',
            'app_name' => 'Royal Wedding Invitation',
            'app_tagline' => 'Platform Undangan Digital Terbaik & Termewah',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertEquals('Royal Wedding Invitation', setting('app_name'));
        $this->assertEquals('Platform Undangan Digital Terbaik & Termewah', setting('app_tagline'));
    }

    public function test_admin_can_update_contact_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->postJson('/admin/settings', [
            'group' => 'contact',
            'contact_whatsapp' => '6289912345678',
            'contact_email' => 'support@royalwedding.com',
            'contact_instagram' => 'royalwedding_id',
            'contact_address' => 'Jl. Pahlawan No. 45, Jakarta',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals('6289912345678', setting('contact_whatsapp'));
        $this->assertEquals('support@royalwedding.com', setting('contact_email'));
        $this->assertEquals('royalwedding_id', setting('contact_instagram'));
    }

    public function test_admin_can_update_seo_settings(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->postJson('/admin/settings', [
            'group' => 'seo',
            'meta_title' => 'Pusat Undangan Pernikahan Mewah',
            'meta_description' => 'Solusi undangan online terbaik di Indonesia.',
            'meta_keywords' => 'undangan digital, wedding website, rsvp online',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals('Pusat Undangan Pernikahan Mewah', setting('meta_title'));
        $this->assertEquals('Solusi undangan online terbaik di Indonesia.', setting('meta_description'));
    }

    public function test_admin_can_update_faqs_array(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $faqsPayload = [
            [
                'pertanyaan' => 'Berapa lama waktu pembuatan undangan?',
                'jawaban' => 'Hanya butuh waktu sekitar 5-10 menit setelah data lengkap.',
            ],
            [
                'pertanyaan' => 'Apakah bisa ganti tema setelah dibuat?',
                'jawaban' => 'Ya, Anda bebas berganti tema kapan saja melalui dashboard.',
            ],
        ];

        $response = $this->actingAs($admin)->postJson('/admin/settings', [
            'group' => 'faq',
            'faqs' => $faqsPayload,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $savedFaqs = setting_json('faqs');
        $this->assertCount(2, $savedFaqs);
        $this->assertEquals('Berapa lama waktu pembuatan undangan?', $savedFaqs[0]['pertanyaan']);
        $this->assertEquals('Ya, Anda bebas berganti tema kapan saja melalui dashboard.', $savedFaqs[1]['jawaban']);
    }

    public function test_landing_page_renders_dynamic_settings_and_faqs(): void
    {
        Setting::set('app_name', 'Megah Undangan');
        Setting::set('app_tagline', 'Kemewahan Dalam Genggaman');
        Setting::set('meta_title', 'Megah Undangan - Terbaik & Terpercaya');
        Setting::set('faqs', [
            [
                'pertanyaan' => 'Pertanyaan Custom 123',
                'jawaban' => 'Jawaban Custom 456',
            ],
        ], 'faq');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Megah Undangan');
        $response->assertSee('Pertanyaan Custom 123');
        $response->assertSee('Jawaban Custom 456');
    }

    public function test_helper_fallback_values(): void
    {
        $this->assertEquals('Default Value', setting('non_existent_key', 'Default Value'));
        $this->assertEquals(['default' => 1], setting_json('non_existent_json', ['default' => 1]));
    }
}
