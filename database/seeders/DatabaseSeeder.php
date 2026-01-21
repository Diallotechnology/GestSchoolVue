<?php

namespace Database\Seeders;

use App\Models\Ue;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Note;
use App\Models\Type;
use App\Models\User;
use App\Enum\RoleEnum;
use App\Models\Classe;
use App\Models\Course;
use App\Models\Devoir;
use App\Models\Folder;
use App\Models\Tuteur;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Payment;
use App\Models\Periode;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Document;
use App\Models\Planning;
use App\Enum\DiplomeEnum;
use App\Models\Personnel;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer les périodes (Semestres)
        $periodes = collect();
        for ($i = 1; $i <= 6; $i++) {
            $periodes->push(Periode::factory()->create(['nom' => "Semestre $i"]));
        }

        // Créer le personnel (administration)
        Personnel::factory()->create();

        // Créer les types de cours (TD, TP)
        Type::factory()->create(['nom' => 'TD']);
        Type::factory()->create(['nom' => 'TP']);

        // Créer les filières
        Filiere::factory()->create(['nom' => 'IG']);
        Filiere::factory()->create(['nom' => 'GRH']);
        $teacher = Teacher::factory(10)->create();
        $matiere = Matiere::factory()->createMany([
            ['nom' => 'Mathématiques', 'coeficient' => 2, 'duree' => 20],
            ['nom' => 'Anglais', 'coeficient' => 2, 'duree' => 20],
            ['nom' => 'Informatique', 'coeficient' => 3, 'duree' => 20],
            ['nom' => 'Comptabilité', 'coeficient' => 2, 'duree' => 20],
            ['nom' => 'Architecture', 'coeficient' => 2, 'duree' => 20],
        ]);
        Tuteur::factory(5)->create();
        // Créer les classes avec 5 matières et 20 cours associés à chaque classe
        $classes = Classe::factory(5)->hasCourses(5)->create()->each(function ($classe) use ($matiere) {
            $classe->matieres()->attach($matiere->random(5));
        });

        // Créer les enseignants avec matières et classes
        Teacher::factory(10)->create()->each(function ($teac) use ($matiere, $classes) {
            $teac->matieres()->attach($matiere->random(5));
            $teac->classes()->attach($classes->random(2)->pluck('id')->toArray());
        });

        // Créer des utilisateurs avec leurs rôles spécifiques
        User::factory()->create([
            'name' => 'Etudiant',
            'email' => 'etudiant@gmail.com',
            'userable_type' => 'App\Models\Student',
            'userable_id' => 1,
            'role' => RoleEnum::STUDENT,
        ]);

        User::factory()->create([
            'name' => 'Enseignant',
            'email' => 'teacher@gmail.com',
            'userable_type' => 'App\Models\Teacher',
            'userable_id' => 1,
            'role' => RoleEnum::TEACHER,
        ]);

        $user = User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@gmail.com',
            'userable_type' => 'App\Models\Personnel',
            'userable_id' => 1, // L'ID du premier personnel créé
            'role' => RoleEnum::ADMIN,
        ]);

        User::factory(5)->create();

        // Crée UE par période (1 et 2), avec 2 matières chacune
        // $ues = collect();

        // foreach ([1, 2] as $periodeId) {
        //     $ues->push(
        //         Ue::factory()->create([
        //             'nom' => 'UE 1',
        //             'periode_id' => $periodeId,
        //             'filiere_id' => 1,
        //             'code' => uniqid(),
        //             'credit' => 10,
        //         ])
        //     )->last()->matieres()->attach($matiere->random(2));

        //     $ues->push(
        //         Ue::factory()->create([
        //             'nom' => 'UE 2',
        //             'periode_id' => $periodeId,
        //             'filiere_id' => 1,
        //             'code' => uniqid(),
        //             'credit' => 10,
        //         ])
        //     )->last()->matieres()->attach($matiere->random(2));
        // }

        // Crée un user
        $user = User::factory()->create();

        // Crée les étudiants et génère les notes liées aux matières d'UE
        // Student::factory(5)->create()->each(function ($student) use ($ues, $user) {
        //     foreach ([1, 2] as $periodeId) {
        //         // Récupère toutes les matières des UE de cette période
        //         $periodeMatieres = $ues->where('periode_id', $periodeId)
        //             ->flatMap(fn($ue) => $ue->matieres)
        //             ->unique('id');

        //         foreach ($periodeMatieres as $matiere) {
        //             foreach (['Examen', 'Devoir'] as $type) {
        //                 Note::create([
        //                     'valeur' => rand(0, 20),
        //                     'type' => $type,
        //                     'diplome' => DiplomeEnum::Licence,
        //                     'student_id' => $student->id,
        //                     'matiere_id' => $matiere->id,
        //                     'user_id' => $user->id,
        //                     'periode_id' => $periodeId,
        //                 ]);
        //             }
        //         }
        //     }
        // });

        // // Créer des dossiers, documents et plannings
        // Folder::factory(10)->create();
        // Document::factory(10)->create();
        // Payment::factory(20)->create();

        // // Planning::factory()
        // //     ->count(100)
        // //     ->create();

        // $jours = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        // $creneaux = [
        //     ['08:00', '09:30'],
        //     ['09:45', '11:15'],
        //     ['11:30', '13:00'],
        //     ['14:00', '15:30'],
        //     ['15:45', '17:15'],
        // ];

        // foreach ([1, 2] as $semestre) {
        //     $startOfWeek = Carbon::now()->startOfYear()->addMonths(($semestre - 1) * 6);

        //     foreach ($jours as $jour) {
        //         foreach ($creneaux as $creneau) {
        //             $debut = Carbon::parse($startOfWeek)->next($jour)->setTimeFromTimeString($creneau[0]);
        //             $fin = Carbon::parse($startOfWeek)->next($jour)->setTimeFromTimeString($creneau[1]);

        //             // 90% Cours, 5% Devoir, 5% Examen
        //             $rand = rand(1, 100);
        //             if ($rand <= 90) {
        //                 $type = 'Cours';
        //             } elseif ($rand <= 95) {
        //                 $type = 'Devoir';
        //             } else {
        //                 $type = 'Examen';
        //             }

        //             Planning::create([
        //                 'matiere_id' => rand(1, 5),
        //                 'classe_id' => 1,
        //                 'teacher_id' => rand(1, 5),
        //                 'periode_id' => 1,
        //                 'type' => $type,
        //                 'salle' => rand(1, 20),
        //                 'debut' => $debut,
        //                 'fin' => $fin,
        //             ]);
        //         }
        //     }
        // }

        // // Créer des cours et assigner les périodes et classes
        // $cours = Course::factory(5)->create()->each(function ($cours) use ($periodes, $classes) {
        //     $cours->classes()->attach($classes->random(2)->pluck('id')->toArray());
        //     $cours->periodes()->attach($periodes->random(2)->pluck('id')->toArray());
        // });

        // // Créer des devoirs et les assigner à des classes aléatoires
        // Devoir::factory(5)->create()->each(function ($devoir) use ($classes, $cours, $teacher) {
        //     $devoir->classe()->associate($classes->random(1)->pluck('id')->toArray());
        //     $devoir->course()->associate($cours->random(1)->pluck('id')->toArray());
        //     $devoir->teacher()->associate($teacher->random(1)->pluck('id')->toArray());
        // });
    }
}
