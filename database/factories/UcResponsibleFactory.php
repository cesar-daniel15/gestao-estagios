<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UcResponsible>
 */
class UcResponsibleFactory extends Factory
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

    public function tiago(): static
    {
        return $this->state(fn (array $attributes) => [
            'id' => 1,
            'phone' => '914567890', 
            'picture' => 'images/uploads/picture-tiago.png', 
        ]);
    }
}
