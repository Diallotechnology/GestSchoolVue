<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 5),
            'student_id' => rand(1, 5),
            'classe_id' => rand(1, 5),
            'type' => rand(1, 2) === 1 ? 'Inscription' : 'Scolarité',
            'mode' => rand(1, 3) === 1 ? 'Virement' : 'Chèque',
            'adresse' => rand(1, 2) === 1 ? 'adresse' : 'contact',
            'motif' => $this->faker->sentence(),
            'montant' => rand(75000, 300000),
        ];
    }
}
