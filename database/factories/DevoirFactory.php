<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function uniqid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Devoir>
 */
final class DevoirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'classe_id' => rand(1, 5),
            'course_id' => rand(1, 5),
            'matiere_id' => rand(1, 5),
            'teacher_id' => rand(1, 5),
            'periode_id' => rand(1, 6),
            'reference' => uniqid(),
            'type' => $this->faker->randomElement(['Devoir', 'Examen']),
            'description' => $this->faker->paragraph(4),
            'delai' => $this->faker->date(),
        ];
    }
}
