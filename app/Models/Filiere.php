<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use App\Helper\CacheHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * App\Models\Filiere
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Student> $students
 * @property-read int|null $students_count
 * @method static \Database\Factories\FiliereFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere query()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Filiere withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Classe> $classes
 * @property-read int|null $classes_count
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Planning> $plannings
 * @property-read int|null $plannings_count
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ue> $ues
 * @property-read int|null $ues_count
 * @mixin \Eloquent
 */
final class Filiere extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom'];

    /**
     * Get all of the plannings for the Filiere
     */
    public function plannings(): HasMany
    {
        return $this->hasMany(Planning::class);
    }

    /**
     * Get all of the classes for the Filiere
     */
    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    /**
     * Get all of the students for the Filiere
     */
    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(Student::class, Classe::class);
    }

    /**
     * Get all of the ues for the Filiere
     */
    public function ues(): HasMany
    {
        return $this->hasMany(Ue::class);
    }

    protected static array $cacheKeys = [
        'count_filieres',
    ];

    protected static function booted(): void
    {
        static::bootHasCachedModel();
    }
}
