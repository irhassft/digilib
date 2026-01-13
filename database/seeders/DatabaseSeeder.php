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
        // Panggil RoleSeeder
        $this->call(RoleSeeder::class);

        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => '$2y$12$g3oVUOfIXOjuCp3Xk01/eejzro5OkOgG/uO.LU5tkIRogmlDhRiVS', // password dummy
            ]
        );
    }
}
