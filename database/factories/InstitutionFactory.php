<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Institution; // Import da Model
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

    protected $model = Institution::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company, // Nome da instituição
            'acronym' => strtoupper($this->faker->lexify('???')), // Acronimo (3 letras)
            'email' => $this->faker->unique()->safeEmail, // Email único
            'password' => bcrypt('password'), // Password (hashed)
            'phone' => $this->faker->phoneNumber, // Telefone
            'address' => $this->faker->address, // Morada
            'logo' => $this->faker->imageUrl(640, 480, 'business'), // URL da imagem do logo
            'website' => $this->faker->url, // Website
            'token' => $this->faker->unique()->numberBetween(10000, 99999), // Token de 5 dígitos
            'account_is_verify' => $this->faker->boolean, // Conta verificada
            'last_login' => $this->faker->dateTimeBetween('-1 month', 'now'), // Último login
        ];
    }
}
