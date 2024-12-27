<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function brandit(): static
    {
        return $this->state(fn (array $attributes) => [
            'id' => 1,
            'phone' => '253818226',
            'logo' => 'images/uploads/logo-brandit.png', 
            'industry' => 'Tecnologia', 
            'address' => 'Av. Alcaides de Faria 88 - 90, 4750-106 Barcelos', 
            'foundation_date' => '2010-05-15', 
        ]);
    }

    public function digiheart(): static
    {
        return $this->state(fn (array $attributes) => [
            'id' => 2,
            'phone' => '968863320', 
            'logo' => 'images/uploads/logo-digiheart.png',
            'industry' => 'Tecnologia', 
            'address' => 'Largo do Montinho 1, Mazarefes', 
            'foundation_date' => '2015-08-20', 
        ]);
    }
}
