<?php

namespace Database\Seeders;

use App\Models\User; // Import a Model so Users
use App\Models\Institution; // Import da Model das Institution
use App\Models\Course; // Import da Model dos Courses
use App\Models\Company; 
use App\Models\Student; 
use App\Models\UnitCurricular; // Import da Model das Unidades Curriculares
use App\Models\UcResponsible; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin = User::factory()->admin()->create();

        // Criar instituições
        $estg = Institution::factory()->estg()->create();
        $ese = Institution::factory()->ese()->create();

        $institutionESTG = User::factory()->institutionESTG()->create();
        $institutionESE = User::factory()->institutionESE()->create();

        // Criar courso
        $course = Course::factory()->create();

        // Criar UC
        $unitCurricular = UnitCurricular::factory()->create();

        // Criar empresas
        $brandit = Company::factory()->brandit()->create();
        $digiheart = Company::factory()->digiheart()->create();

        // Criar Responsaveis de UC
        $tiago = UcResponsible::factory()->tiago()->create();

        $cesar = Student::factory()->cesar()->create();
        $ruben = Student::factory()->ruben()->create();

        $cesarUser   = User::factory()->studentCesar()->create();
        $rubenUser   = User::factory()->studentRuben()->create();

        $responsibleTiago = User::factory()->responsibleTiago()->create();

        $companyBrandit = User::factory()->companyBrandit()->create();
        $companyDigiheart = User::factory()->companyDigiheart()->create();
    }
}
