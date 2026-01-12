<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => rand(1, 2),
            'matiere_id' => rand(1, 5),
            'teacher_id' => rand(1, 5),
            'nom' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(1),
            'reference' => uniqid(),
        ];
    }
}
