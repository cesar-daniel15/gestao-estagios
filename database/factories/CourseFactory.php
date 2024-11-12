<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course; // Import da Model
use App\Models\Institution; // Importa da Model Institution

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // Indicar a Model associada
    protected $model = Course::class;
    
    public function definition(): array
    {
       // Lista de alguns nomes de cursos e os seus acronimos
        $courses = [
            'Ciência da Computação' => 'CC',
            'Psicologia' => 'PSI',
            'Engenharia Mecânica' => 'EM',
            'Biologia' => 'BIO',
        ];

        // Seleciona um curso e o seu acronimo
        $courseName = $this->faker->unique()->randomElement(array_keys($courses));
        $acronym = $courses[$courseName];

        return [
            'institution_id' => Institution::inRandomOrder()->first()->id, // Id da instituicao
            'name' => $courseName, // Nome do curso
            'acronym' => $acronym, // Acronimo do curso
        ];
    }
}
