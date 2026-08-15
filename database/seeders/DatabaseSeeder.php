<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
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

        $this->call(ContentSeeder::class);
    }
}
