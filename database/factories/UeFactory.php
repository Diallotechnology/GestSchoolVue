<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function rand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ue>
 */
final class UeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'UE'.$this->faker->unique()->numberBetween(100, 999), // Code unique de l'UE (par exemple, UE101)
            'nom' => $this->faker->words(3, true), // Libellé aléatoire pour l'UE
            'credit' => $this->faker->numberBetween(1, 6), // Nombre de crédits (entre 1 et 6)
            'filiere_id' => rand(1, 5),
            'periode_id' => rand(1, 5),
        ];
    }
}
