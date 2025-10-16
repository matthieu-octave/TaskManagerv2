<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(), // Génère un nom d'entreprise
            'email' => $this->faker->unique()->safeEmail(), // Génère un email unique
            'phone' => $this->faker->phoneNumber(), // Génère un numéro de téléphone
        ];
    }
}
