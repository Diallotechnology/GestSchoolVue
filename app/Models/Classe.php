<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\CacheHelper;
use App\Helper\DateFormat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Classe
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Student> $students
 * @property-read int|null $students_count
 * @method static \Database\Factories\ClasseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Classe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classe withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Classe withoutTrashed()
 * @property int $filiere_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read Filiere $filiere
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Illuminate\Database\Eloquent\Builder|Classe whereFiliereId($value)
 * @property int $scolarite
 * @property int $frais
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $courses
 * @property-read int|null $courses_count
 * @property-read mixed $full_classe_name
 * @property-read mixed $full_name
 * @property-read string $frais_format
 * @property-read string $montant_format
 * @property-read string $scolarite_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @method static Builder<static>|Classe forUser()
 * @method static Builder<static>|Classe whereFrais($value)
 * @method static Builder<static>|Classe whereScolarite($value)
 * @mixin \Eloquent
 */
final class Classe extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'scolarite', 'frais', 'filiere_id'];

    protected $appends = ['full_classe_name'];

    protected function fullClasseName(): Attribute
    {
        return Attribute::make(
            get: fn() => 'Filière: ' . $this->filiere->nom . ' | Classe: ' . $this->nom,
        );
    }

    public function getScolariteFormatAttribute(): string
    {
        return number_format($this->scolarite, 0, ',', ' ') . ' CFA';
    }

    public function getFraisFormatAttribute(): string
    {
        return number_format($this->frais, 0, ',', ' ') . ' CFA';
    }

    /**
     * Get all of the students for the Classe
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * The course that belong to the Classe
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * Get all of the devoirs for the Classe
     */
    public function devoirs(): HasMany
    {
        return $this->hasMany(Devoir::class);
    }

    /**
     * The matieres that belong to the Filiere
     */
    public function matieres(): BelongsToMany
    {
        return $this->belongsToMany(Matiere::class);
    }

    /**
     * The teachers that belong to the Filiere
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }

    /**
     * Get the filiere that owns the Classe
     */
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    /**
     * Get all of the scolarites for the Classe
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeForUser(Builder $query): Builder
    {
        $auth = Auth::user();

        return match (true) {
            $auth->isTeacher() => $query->whereIn('id', $auth->userable->classes->pluck('id')),
            $auth->isStudent() => $query->where('id', $auth->userable->classe_id),
            $auth->isAdmin() => $query,
            default => $query->whereRaw('1 = 0'), // Aucun résultat si rôle non autorisé
        };
    }


    /**
     * Liste des classes avec leur filière en cache + memoization.
     */
    public static function getCachedList(bool $force = false): Collection
    {
        return self::memoizedCache('classe_with_filiere_list', function () {
            return self::query()
                ->select('id', 'nom', 'filiere_id')
                ->with('filiere:id,nom')
                ->get();
        }, ttl: null, forceRefresh: $force);
    }

    protected static array $cacheKeys = [
        'classe_with_filiere_list',
        'count_classes',
    ];

    protected static function booted(): void
    {
        static::bootHasCachedModel();
    }
}
