<?php

declare(strict_types=1);

namespace App\Helper;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Trait HasUniversalDates
 *
 * Gère automatiquement l'affichage et la manipulation
 * cohérente de tous les attributs de type "date" dans un modèle Eloquent.
 *
 * ✅ Gère les types : date, datetime, immutable_date, immutable_datetime, timestamp...
 * ✅ Retourne un format d'affichage cohérent selon le type d'attribut
 * ✅ Permet d'accéder aux valeurs brutes via *_raw (ex : created_at_raw)
 * ✅ Compatible avec tous les casts et attributs Laravel
 */
trait HasDateFormat
{
    /** @use HasFactory<\Database\Factories\CamionFactory> */
    use HasFactory, HasModelHelper, HasSearch;

    /**
     * Liste des types de cast considérés comme "date".
     */
    protected static array $dateCastKeywords = [
        'date',
        'datetime',
        'immutable_date',
        'immutable_datetime',
        'timestamp',
        'immutable_timestamp',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    /**
     * Liste des attributs qui doivent être affichés avec l'heure.
     * (tout ce qui n'est PAS ici sera affiché en "date seule")
     *
     * Exemple : ['deleted_at', 'end_at', 'published_at']
     *
     * @var array<string>
     */
    protected array $withTimeAttributes = [];

    /**
     * Permet d'accéder aux versions brutes (ex: created_at_raw, end_at_raw).
     */
    public function __get($key)
    {
        if (str_ends_with($key, '_raw')) {
            $attr = mb_substr($key, 0, -4);
            if (in_array($attr, $this->resolvedDateAttributes(), true)) {
                return $this->asImmutable($attr);
            }
        }

        return parent::__get($key);
    }

    /**
     * Intercepte l'accès aux attributs pour afficher les dates formatées.
     */
    public function getAttribute($key)
    {
        if (in_array($key, $this->resolvedDateAttributes(), true) && array_key_exists($key, $this->attributes)) {
            return $this->formatForDisplay($this->asImmutable($key), $key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Retourne un tableau avec toutes les dates formatées + leurs valeurs brutes.
     */
    public function toFormattedArray(): array
    {
        $formatted = [];

        foreach ($this->resolvedDateAttributes() as $attribute) {
            $date = $this->asImmutable($attribute);
            $formatted[$attribute] = $this->formatForDisplay($date, $attribute);
            $formatted[$attribute.'_raw'] = $date ? $date->toISOString() : null;
        }

        return $formatted;
    }

    /**
     * Retourne la liste complète des attributs considérés comme "date"
     * (Eloquent + casts personnalisés)
     */
    protected function resolvedDateAttributes(): array
    {
        $dates = $this->getDates(); // created_at, updated_at, etc.

        $castKeys = array_filter(
            $this->getCasts() ?? [],
            function ($cast) {
                foreach (self::$dateCastKeywords as $kw) {
                    if (str_contains($cast, $kw)) {
                        return true;
                    }
                }

                return false;
            },
            ARRAY_FILTER_USE_KEY
        );

        return array_unique(array_merge($dates, array_keys($castKeys)));
    }

    /**
     * Retourne la date formatée selon qu'elle doit afficher le temps ou non.
     */
    protected function formatForDisplay(?CarbonImmutable $date, string $attribute): ?string
    {
        if (! $date) {
            return null;
        }

        // Si l'attribut fait partie de ceux qui doivent afficher l'heure
        $format = in_array($attribute, $this->withTimeAttributes, true)
            ? 'd/m/Y H:i:s'
            : 'd/m/Y';

        return $date->format($format);
    }

    // surcharger formatForDisplay dans ton modèle pour modifier la logique uniquement pour ce modèle
    // protected function formatForDisplay(?CarbonImmutable $date, string $attribute): ?string
    // {
    //     if (! $date) return null;

    //     // Ex. ici tu veux que created_at ait toujours l'heure
    //     if ($attribute === 'created_at') {
    //         return $date->format('d/m/Y H:i:s');
    //     }

    //     return parent::formatForDisplay($date, $attribute);
    // }

    /**
     * Convertit un attribut en instance CarbonImmutable.
     */
    protected function asImmutable(string $attribute): ?CarbonImmutable
    {
        if (! array_key_exists($attribute, $this->attributes) || is_null($this->attributes[$attribute])) {
            return null;
        }

        $value = $this->attributes[$attribute];

        return $value instanceof CarbonImmutable
            ? $value
            : CarbonImmutable::parse($value);
    }
}
