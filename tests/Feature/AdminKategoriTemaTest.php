<?php

namespace Tests\Feature;

use App\Models\KategoriTema;
use App\Models\Tema;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminKategoriTemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_kategori_tema_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/theme-categories');

        $response->assertStatus(200);
        $response->assertSee('Manajemen Kategori Tema');
    }

    public function test_admin_can_create_kategori_tema(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/theme-categories', [
            'nama' => 'Tradisional Sunda',
            'slug' => 'tradisional_sunda',
            'urutan' => 6,
            'is_active' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('kategori_temas', [
            'nama' => 'Tradisional Sunda',
            'slug' => 'tradisional_sunda',
            'urutan' => 6,
            'is_active' => 1,
        ]);
    }

    public function test_admin_can_update_kategori_tema(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat = KategoriTema::create([
            'nama' => 'Tradisional Bali',
            'slug' => 'tradisional_bali',
            'urutan' => 7,
            'is_active' => 1,
        ]);

        $response = $this->actingAs($admin)->put("/admin/theme-categories/{$cat->id}", [
            'nama' => 'Tradisional Bali Eksklusif',
            'slug' => 'tradisional_bali',
            'urutan' => 8,
            'is_active' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('kategori_temas', [
            'id' => $cat->id,
            'nama' => 'Tradisional Bali Eksklusif',
            'urutan' => 8,
        ]);
    }

    public function test_cannot_delete_kategori_with_attached_themes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat = KategoriTema::create([
            'nama' => 'Minimalis Modern',
            'slug' => 'minimalis_modern',
            'urutan' => 1,
            'is_active' => 1,
        ]);

        Tema::create([
            'name' => 'Aufilla Mocha',
            'code' => 'aufilla-mocha',
            'category' => 'minimalis_modern',
            'kategori_tema_id' => $cat->id,
            'tingkatan' => 'standar',
            'harga_tambahan' => 0,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/theme-categories/{$cat->id}");

        $response->assertStatus(422);
        $response->assertJson(['success' => false]);

        $this->assertDatabaseHas('kategori_temas', [
            'id' => $cat->id,
        ]);
    }

    public function test_can_delete_empty_kategori(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $cat = KategoriTema::create([
            'nama' => 'Empty Category',
            'slug' => 'empty_category',
            'urutan' => 99,
            'is_active' => 1,
        ]);

        $response = $this->actingAs($admin)->delete("/admin/theme-categories/{$cat->id}");

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('kategori_temas', [
            'id' => $cat->id,
        ]);
    }
}
