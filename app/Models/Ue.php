<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\CacheHelper;
use App\Helper\DateFormat;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

/**
 *
 *
 * @property int $id
 * @property int $filiere_id
 * @property int $periode_id
 * @property string $nom
 * @property string $code
 * @property int $credit
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Filiere $filiere
 * @property-read mixed $full_name
 * @property-read string $delai_format
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \App\Models\Periode $periode
 * @method static \Database\Factories\UeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereFiliereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Ue extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['classe_id', 'nom', 'code', 'credit'];

    protected static function booted(): void
    {
        static::saved(fn($ue) => $ue->invalidateAllUeCache());
        static::deleted(fn($ue) => $ue->invalidateAllUeCache());
    }

    protected function invalidateAllUeCache(): void
    {
        $this->refreshGlobalCacheVersion();
        $this->flushRelevantCaches();
    }

    public function refreshGlobalCacheVersion(): void
    {
        Cache::forever('global_ues_version', uniqid());
    }

    public function flushRelevantCaches(): void
    {
        // 🧊 Clés statiques
        self::invalidateCache("ues_list_periode_{$this->periode_id}");
        self::invalidateCache('ues_list_all');
        self::invalidateCache('ue_validation_lists');

        // 🔁 Groupes dynamiques
        self::flushCacheGroup("ue_validation_{$this->periode_id}");
        self::flushCacheGroup("livewire.data");
    }


    /**
     * Get the classe that owns the Ue
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }


    /**
     * The matieres that belong to the Ue
     */
    public function matieres(): BelongsToMany
    {
        return $this->belongsToMany(Matiere::class);
    }
}
