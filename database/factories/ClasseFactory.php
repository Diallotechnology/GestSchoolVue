<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function rand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classe>
 */
final class ClasseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'filiere_id' => rand(1, 2),
            'nom' => $this->faker->companySuffix(),
            'scolarite' => rand(1000000, 300000),
            'frais' => rand(50000, 70000),
        ];
    }
}
