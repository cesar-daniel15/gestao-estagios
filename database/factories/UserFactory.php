<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'profile' => 'Admin',
            'account_is_verified' => true,
        ]);
    }

    public function institution(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Escola Superior de Tecnologia e Gestão',
            'email' => 'estg@ipvc.pt',
            'password' => Hash::make('password'),
            'profile' => 'Institution',
            'account_is_verified' => true,
            'id_institution' => 1,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
