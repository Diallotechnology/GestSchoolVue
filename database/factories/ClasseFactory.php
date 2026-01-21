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
            'niveau' => rand(1, 3),
            'diplome' => $this->faker->randomElement(['Licence', 'Master']),
        ];
    }
}
