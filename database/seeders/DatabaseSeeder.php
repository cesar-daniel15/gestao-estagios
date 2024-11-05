<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Institution; // Import da Model das Institution
use App\Models\Course; // Import da Model dos Courses
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

        // Criar 2 instituicoes ficticias
        Institution::factory()->count(2)->create();

        // Criar 3 cursos ficticiois
        Course::factory()->count(3)->create();
    }
}
