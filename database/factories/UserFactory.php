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

    public function institutionESTG(): static
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

    public function institutionESE(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Escola Superior de Educação',
            'email' => 'ese@ipvc.pt',
            'password' => Hash::make('password'),
            'profile' => 'Institution',
            'account_is_verified' => true,
            'id_institution' => 2, 
        ]);
    }

    public function studentCesar(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'César Sá',
            'email' => 'cesar.sa@gmail.com',
            'password' => Hash::make('password'),
            'profile' => 'Student',
            'account_is_verified' => true,
            'id_student' => 1, 
        ]);
    }

    public function studentRuben(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Ruben Benedito',
            'email' => 'ruben.benedito@gmail.com',
            'password' => Hash::make('password'),
            'profile' => 'Student',
            'account_is_verified' => true,
            'id_student' => 2, 
        ]);
    }

    public function responsibleTiago(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Tiago Silva',
            'email' => 'tiago.silva@gmail.com',
            'password' => Hash::make('password'),
            'profile' => 'Responsible',
            'account_is_verified' => true,
            'id_responsible' => 1, 
        ]);
    }

    public function companyBrandit(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Brandit',
            'email' => 'contact@brandit.com',
            'password' => Hash::make('password'),
            'profile' => 'Company',
            'account_is_verified' => true,
            'id_company' => 1, 
        ]);
    }

    public function companyDigiheart(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Digiheart',
            'email' => 'contact@digiheart.com',
            'password' => Hash::make('password'),
            'profile' => 'Company',
            'account_is_verified' => true,
            'id_company' => 2, 
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