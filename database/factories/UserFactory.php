<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enum\RoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
final class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'userable_type' => $this->faker->randomElement(['App\Models\Student', 'App\Models\Teacher', 'App\Models\Tuteur']),
            'userable_id' => rand(1, 5),
            'sexe' => $this->faker->randomElement(['Homme', 'Femme']),
            'role' => $this->faker->randomElement(RoleEnum::cases()),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'change_password' => true,
            'password' => self::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
