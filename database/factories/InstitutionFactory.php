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

    // Indicar a Model associada
    protected $model = Institution::class;

    public function definition(): array
    {
        // Lista de algumas instituições com informações adicionais
        $institutions = [
            'Universidade de Lisboa' => [
                'acronym' => 'UL',
                'email' => 'info@ul.pt',
                'phone' => '218 123 456',
                'address' => 'Campo Grande, 174, 1749-016 Lisboa, Portugal',
                'website' => 'https://www.ul.pt',
            ],
            'Instituto Politécnico do Porto' => [
                'acronym' => 'IPP',
                'email' => 'info@ipp.pt',
                'phone' => '22 123 45 67',
                'address' => 'Rua Dr. António Bernardino de Almeida, 431, 4200-072 Porto, Portugal',
                'website' => 'https://www.ipp.pt',
            ],
            'Universidade do Porto' => [
                'acronym' => 'UP',
                'email' => 'info@up.pt',
                'phone' => '220 123 456',
                'address' => 'Praça de Gomes Teixeira, 4099-002 Porto, Portugal',
                'website' => 'https://www.up.pt',
            ],
            'Universidade Nova de Lisboa' => [
                'acronym' => 'UNL',
                'email' => 'info@novasbe.pt',
                'phone' => '21 393 7000',
                'address' => 'Campus de Campolide, 1099-085 Lisboa, Portugal',
                'website' => 'https://www.unl.pt',
            ],
        ];

        // Seleciona aleatoriamente uma instituição
        $selectedInstitution = $this->faker->randomElement(array_keys($institutions));
        $details = $institutions[$selectedInstitution]; // Pega os detalhes da instituição selecionada

        return [
            'name' => $selectedInstitution, // Nome da instituição
            'acronym' => $details['acronym'], // Acrônimo correspondente ao nome
            'email' => $details['email'], // Email da instituição
            'password' => bcrypt('password'), // Password (hashed)
            'phone' => $details['phone'], // Telefone da instituição
            'address' => $details['address'], // Morada da instituição
            'logo' => $this->faker->imageUrl(640, 480, 'business'), // URL da imagem do logo
            'website' => $details['website'], // Website da instituição
            'token' => $this->faker->unique()->numberBetween(10000, 99999), // Token de 5 dígitos
            'account_is_verified' => $this->faker->boolean, // Conta verificada
            'last_login' => $this->faker->dateTimeBetween('-1 month', 'now'), // Último login
        ];
    }
}
