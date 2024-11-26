<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Institution; // Importa a model Institution

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
        // Lista de algumas instituições com seus dados
        $institutions = [
            [
                'acronym' => 'IPVC ESTG',
                'phone' => '258 809 610',
                'address' => 'R. Escola Industrial e Comercial de Nun\'Alvares, 4900-347 Viana do Castelo',
                'logo' => 'ipvc_estg_logo.png',
                'website' => 'https://www.estg.ipvc.pt/',
            ],
            [
                'acronym' => 'IPCA',
                'phone' => '253 802 260',
                'address' => 'R. do Aldão, 4750-810 Barcelos',
                'logo' => 'ipca_logo.png',
                'website' => 'https://www.ipca.pt/',
            ],
            [
                'acronym' => 'Universidade do Porto',
                'phone' => '222 074 800',
                'address' => 'Praça de Gomes Teixeira, 4099-002 Porto',
                'logo' => 'up_logo.png',
                'website' => 'https://www.up.pt/',
            ],
            [
                'acronym' => 'Universidade de Lisboa',
                'phone' => '210 113 400',
                'address' => 'Alameda da Universidade, 1649-004 Lisboa',
                'logo' => 'ul_logo.png',
                'website' => 'https://www.ulisboa.pt/',
            ],
        ];

        // Seleciona uma instituição aleatoriamente
        $institution = $this->faker->randomElement($institutions);

        return [
            'acronym' => $institution['acronym'],
            'phone' => $institution['phone'],
            'address' => $institution['address'],
            'logo' => $institution['logo'],
            'website' => $institution['website'],
        ];
    }
}
