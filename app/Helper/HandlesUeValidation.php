<?php

declare(strict_types=1);

namespace App\Helper;

use App\Models\Student;
use App\Models\Ue;
use Illuminate\Support\Collection;

trait HandlesUeValidation
{
    protected function formatStudentName(Student $student): string
    {
        return sprintf(
            '%s %s Matricule: %s Classe: %s',
            $student->nom,
            $student->prenom,
            $student->reference,
            $student->classe->nom
        );
    }

    protected function calculateOverallAverage(Collection $ueResults): float
    {
        return round($ueResults->pluck('moyenne_ue')->filter()->avg() ?? 0, 2);
    }

    protected function calculateMatiereNotes(Collection $matiereNotes): array
    {
        $types = $matiereNotes->pluck('valeur', 'type');

        $note_classe_value = isset($types['Devoir']) ? (float) ($types['Devoir']) : null;
        $note_examen_value = isset($types['Examen']) ? (float) (2 * $types['Examen']) : null;

        return [
            'note_classe' => $note_classe_value,
            'note_examen' => isset($types['Examen']) ? (float) ($types['Examen']) : null,
            'note_matiere' => ($note_examen_value && $note_classe_value)
                ? round(($note_examen_value + $note_classe_value) / 3, 2)
                : null,
        ];
    }

    protected function calculateUeResults(Collection $matiereResults, Ue $ue): array
    {
        $validNotes = $matiereResults->pluck('note_matiere')->filter();
        $moyenneUE = $validNotes->isNotEmpty()
            ? round($validNotes->sum() / $validNotes->count(), 2)
            : null;

        return [
            'moyenne_ue' => $moyenneUE,
            'note_coefficient' => $moyenneUE ? round($moyenneUE * $ue->credit, 2) : null,
            'isValidated' => $moyenneUE >= 10,
        ];
    }
}
