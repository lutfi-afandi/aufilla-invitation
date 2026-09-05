<?php

namespace Tests\Feature;

use App\Models\KategoriTema;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_themes_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/themes');

        $response->assertStatus(200);
        $response->assertSee('Manajemen Tema');
    }

    public function test_admin_can_create_theme_with_category_and_tier(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        KategoriTema::create([
            'nama' => 'Tradisional Jawa',
            'slug' => 'tradisional_jawa',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post('/admin/themes', [
            'name' => 'Jawa Kasunanan',
            'code' => 'jawa-kasunanan',
            'category' => 'tradisional_jawa',
            'tingkatan' => 'premium',
            'harga_tambahan' => 25000,
            'is_privat' => 0,
            'is_active' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('temas', [
            'name' => 'Jawa Kasunanan',
            'code' => 'jawa-kasunanan',
            'category' => 'tradisional_jawa',
            'tingkatan' => 'premium',
            'harga_tambahan' => 25000,
            'is_privat' => 0,
            'is_active' => 1,
        ]);
    }

    public function test_landing_page_only_shows_active_and_public_themes(): void
    {
        Tema::create([
            'name' => 'Public Minimalist',
            'code' => 'public-minimalist',
            'category' => 'minimalis',
            'tingkatan' => 'standar',
            'harga_tambahan' => 0,
            'is_privat' => false,
            'is_active' => true,
        ]);

        Tema::create([
            'name' => 'Private VIP Theme',
            'code' => 'private-vip-theme',
            'category' => 'tradisional_jawa',
            'tingkatan' => 'eksklusif',
            'harga_tambahan' => 100000,
            'is_privat' => true,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Public Minimalist');
        $response->assertDontSee('Private VIP Theme');
    }

    public function test_admin_can_filter_themes_via_ajax(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat = KategoriTema::create([
            'nama' => 'Tradisional Jawa',
            'slug' => 'tradisional_jawa',
            'urutan' => 1,
            'is_active' => true,
        ]);

        Tema::create([
            'name' => 'Jawa Kasunanan',
            'code' => 'jawa-kasunanan',
            'category' => 'tradisional_jawa',
            'kategori_tema_id' => $cat->id,
            'tingkatan' => 'premium',
            'harga_tambahan' => 25000,
            'is_privat' => 0,
            'is_active' => 1,
        ]);

        Tema::create([
            'name' => 'Aufilla Modern',
            'code' => 'aufilla-modern',
            'category' => 'minimalis',
            'tingkatan' => 'standar',
            'harga_tambahan' => 0,
            'is_privat' => 0,
            'is_active' => 1,
        ]);

        // Request with AJAX and category filter
        $response = $this->actingAs($admin)->getJson('/admin/themes?category=tradisional_jawa');

        $response->assertStatus(200);
        $response->assertJsonStructure(['html']);
        $this->assertStringContainsString('Jawa Kasunanan', $response->json('html'));
        $this->assertStringNotContainsString('Aufilla Modern', $response->json('html'));
    }
}
