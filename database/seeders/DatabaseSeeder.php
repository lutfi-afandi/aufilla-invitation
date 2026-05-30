<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        User::factory()->create([
            'username' => 'lutfi',
            'email' => 'lutfi@example.com',
            'role' => 'client',
            'password' => bcrypt('admin123'),
        ]);

        \App\Models\Theme::create([
            'name' => 'Demo Theme 1',
            'code' => 'demo1',
            'thumbnail' => '/assets/img/thumbnail-tema/demo1.png',
            'is_active' => true,
        ]);
    }
}
