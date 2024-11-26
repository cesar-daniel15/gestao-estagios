<?php

namespace Database\Seeders;

use App\Models\User; // Import a Model so Users
use App\Models\Institution; // Import da Model das Institution
use App\Models\Course; // Import da Model dos Courses
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria o usuário Admin específico
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Ajuste a senha conforme necessário
            'profile' => 'Admin',
            'account_is_verified' => true, // Verifica o e-mail
        ]);

        // Criar 2 instituicoes ficticias
        Institution::factory()->count(2)->create();

        // Criar 3 cursos ficticiois
        Course::factory()->count(3)->create();
    }
}
