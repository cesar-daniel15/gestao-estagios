<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Institution; // Importa a model Institution
use App\Models\User; // Importa a model User

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institution>
 */
class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // Indicar a model associada
    protected $model = Institution::class;

    public function definition(): array
    {
        
    }
}
