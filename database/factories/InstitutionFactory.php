<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'id' => 1,
            'acronym' => 'ESTG',
            'phone' => ' 258819700',
            'address' =>'Av. do Atlântico 644 4900, Viana do Castelo',
            'logo' => 'images/uploads/logo-estg.png',
            'website' => 'https://www.ipvc.pt/estg/',
        ];
    }
}
