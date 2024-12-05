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
        User::factory()->create();
    }
}
