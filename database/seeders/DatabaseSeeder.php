<?php

namespace Database\Seeders;

use App\Models\User; 
use App\Models\Institution; 
use App\Models\Course; 
use App\Models\Company; 
use App\Models\Student; 
use App\Models\UnitCurricular; 
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

        // Criar Admin
        $admin = User::factory()->admin()->create();

        // Criar instituições
        $estg = Institution::factory()->estg()->create();
        $ese = Institution::factory()->ese()->create();

        // Criar users da instituicao
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

        // Criar alunos
        $cesar = Student::factory()->cesar()->create();
        $ruben = Student::factory()->ruben()->create();

        // Criar users dos alunos
        $cesarUser = User::factory()->studentCesar()->create();
        $rubenUser = User::factory()->studentRuben()->create();

        // Criar user do responsavel
        $responsibleTiago = User::factory()->responsibleTiago()->create();

        // Criar users das empresas
        $companyBrandit = User::factory()->companyBrandit()->create();
        $companyDigiheart = User::factory()->companyDigiheart()->create();
    }
}
