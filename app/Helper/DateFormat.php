<?php

declare(strict_types=1);

namespace App\Helper;

use Closure;
use DateInterval;
use DateTimeInterface;
use App\Helper\CacheHelper;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

trait DateFormat
{
    use HasFactory, CacheHelper;

    public function getDelaiFormatAttribute(): string
    {
        return Carbon::parse($this->delai)->format('d/m/Y');
    }

    public function getMontantFormatAttribute(): string
    {
        return number_format($this->montant, 0, ',', ' ') . ' CFA';
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->nom . ' ' . $this->prenom,
            set: null
        );
    }


    public function teacher_view(): string
    {
        return $this->teacher ? $this->teacher->prenom . ' ' . $this->teacher->nom : 'inexistant';
    }

    public function parent_view(): string
    {
        return $this->tuteur ? $this->tuteur->prenom . ' ' . $this->tuteur->nom : 'inexistant';
    }

    public function student_view(): string
    {
        return $this->student ? $this->student->prenom . ' ' . $this->student->nom : 'inexistant';
    }

    public function classe_view(): string
    {
        return $this->classe ? $this->classe->nom : 'inexistant';
    }

    public function filiere_view(): string
    {
        return $this->classe ? $this->classe->filiere->nom : 'inexistant';
    }

    public function periode_view(): string
    {
        return $this->classe ? $this->classe->nom : 'inexistant';
    }

    public function generateId(string $prefix_type)
    {
        $currentYear = Carbon::today()->format('Y');
        $prefix = $prefix_type . $currentYear . '-';

        return DB::transaction(function () use ($prefix) {
            // Verrouille le dernier identifiant de courrier enregistré dans la base de données pour la mise à jour
            $lastCourrier = self::where('reference', 'like', $prefix . '%')->whereNotNull('reference')
                ->latest('id')
                ->lockForUpdate()
                ->first(['reference']);
            // Si aucun identifiant de courrier n'a été enregistré, définit le numéro de séquence à 0
            $sequence = 0;
            if ($lastCourrier) {
                // Récupère le numéro de séquence de l'identifiant de courrier précédent
                $sequence = (int) mb_substr($lastCourrier->reference, mb_strlen($prefix));
            }
            // Incrémente le numéro de séquence et génère le nouvel identifiant de courrier
            $sequence++;
            $newCourrierNumber = $prefix . $sequence;
            // Met à jour le numéro de courrier de l'instance courante
            $this->reference = $newCourrierNumber;
            $this->save();

            return $this;
        });
    }

    protected function getCreatedAtAttribute(string $date): string
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}
