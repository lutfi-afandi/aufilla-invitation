<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/buat-undangan');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $cat = \App\Models\KategoriTema::create([
            'nama' => 'Minimalis',
            'slug' => 'minimalis',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $theme = \App\Models\Tema::create([
            'name' => 'Aufilla Test',
            'code' => 'aufilla-test',
            'category' => 'minimalis',
            'kategori_tema_id' => $cat->id,
            'tingkatan' => 'standar',
            'harga_tambahan' => 0,
            'is_active' => true,
        ]);
        \App\Models\Paket::create([
            'name' => 'Trial',
            'price' => 0,
            'active_days' => 7,
            'max_wa_send' => 5,
            'max_gallery_photos' => 3,
            'has_love_story' => false,
            'can_custom_music' => true,
            'is_priority_support' => false,
        ]);

        $response = $this->post('/buat-undangan', [
            'pria_nama' => 'Romeo',
            'wanita_nama' => 'Juliet',
            'username' => 'romeojuliet',
            'slug' => 'romeo-dan-juliet',
            'email' => 'romeo@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'theme_id' => $theme->id,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/client/dashboard');
    }
}
