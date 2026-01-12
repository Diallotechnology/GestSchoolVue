<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
final class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => rand(1, 5),
            'user_id' => rand(1, 5),
            'periode_id' => rand(1, 6),
            'type' => $this->faker->randomElement(['Devoir', 'Examen']),
            'diplome' => $this->faker->randomElement(['Licence', 'Master', 'DUT']),
            'matiere_id' => rand(1, 5),
            'valeur' => rand(5, 20),
        ];
    }
}
