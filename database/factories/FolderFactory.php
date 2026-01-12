<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Folder>
 */
final class FolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'folderable_type' => $this->faker->randomElement(['App\Models\Course', 'App\Models\Devoir']),
            'folderable_id' => rand(1, 10),
            'nom' => $this->faker->name(),
        ];
    }
}
