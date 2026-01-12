<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function rand;
use function uniqid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
final class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference' => uniqid(),
            'classe_id' => rand(1, 5),
            'tuteur_id' => rand(1, 5),
            'scolarite' => rand(500000, 100000),
            'frais' => rand(55000, 60000),
            'sexe' => $this->faker->randomElement(['Homme', 'Femme']),
            'prenom' => $this->faker->firstName(),
            'nom' => $this->faker->lastName(),
            'contact' => $this->faker->phoneNumber(),
            'naissance' => $this->faker->date(),
        ];
    }
}
