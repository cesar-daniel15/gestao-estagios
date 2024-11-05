<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Institution; // Import da Model
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Criar 3 instituicoes ficticias
        Institution::factory()->count(3)->create();
    }
}
