<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function rand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matiere>
 */
final class MatiereFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->randomElement(['comptabilité', 'marketing', 'économie', 'informatique', 'programmation', 'finance', 'Anglais']),
            'coeficient' => rand(1, 4),
            'duree' => rand(10, 40),
        ];
    }
}
