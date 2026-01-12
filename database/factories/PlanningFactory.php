<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Matiere;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Planning>
 */
final class PlanningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Semaine actuelle + 2 semaines
        // $startDate = Carbon::now()->startOfWeek();
        // $endDate = Carbon::now()->addWeeks(2)->endOfWeek();

        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $debut = $this->faker->dateTimeBetween($startDate, $endDate);
        // On s'assure que c'est un jour de semaine (lundi à vendredi)
        while (Carbon::parse($debut)->isWeekend()) {
            $debut = $this->faker->dateTimeBetween($startDate, $endDate);
        }

        // Durée aléatoire (1h30 ou 2h)
        $duree = $this->faker->randomElement([90, 120]);
        $fin = Carbon::parse($debut)->addMinutes($duree);

        // Heure entre 8h et 17h
        // $debut->setTime(rand(8, 16), $this->faker->randomElement([0, 15, 30, 45]));
        $debut = Carbon::parse($debut)->setTime(rand(8, 16), $this->faker->randomElement([0, 15, 30, 45]));

        $fin = Carbon::parse($debut)->addMinutes($duree);

        return [
            'matiere_id' => Matiere::inRandomOrder()->first()?->id ?? 1,
            'classe_id' => 1,
            'teacher_id' => rand(1, 5),
            'periode_id' => rand(1, 2),
            'salle' => 'Salle '.rand(1, 20),
            'type' => $this->faker->randomElement(['Cours', 'Cours', 'Cours', 'Devoir', 'Examen']),
            'debut' => $debut,
            'fin' => $fin,
        ];
        // return [
        //     'matiere_id' => \rand(1, 5),
        //     'classe_id' => 1,
        //     'teacher_id' => \rand(1, 5),
        //     'periode_id' => rand(1, 5),
        //     'salle' => rand(1, 20),
        //     'type' => $this->faker->randomElement(['Devoir', 'Examen', 'Cours']),
        //     'debut' => $this->faker->dateTimeInInterval('0 years', '-2 days'),
        //     'fin' => $this->faker->dateTimeInInterval('0 years', '+2 days'),
        // ];
    }
}
