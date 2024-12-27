<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
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

    public function cesar(): static
    {
        return $this->state(fn (array $attributes) => [
            'id' => 1,
            'phone' => '935397628', 
            'picture' => 'images/uploads/picture-cesar.png', 
        ]);
    }

    public function ruben(): static
    {
        return $this->state(fn (array $attributes) => [
            'id' => 2,
            'phone' => '937080878', 
            'picture' => 'images/uploads/picture-ruben.png', 
        ]);
    }
}
