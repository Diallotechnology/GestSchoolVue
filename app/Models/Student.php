<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use App\Helper\CacheHelper;
use Illuminate\Support\Carbon;
use App\Helper\HasUniqueReference;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Student
 *
 * @property int $id
 * @property int $filiere_id
 * @property int $classe_id
 * @property int $parent_id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property string $naissance
 * @property string|null $reference
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Classe $classe
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read Filiere $filiere
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Note> $notes
 * @property-read int|null $notes_count
 * @property-read User|null $user
 * @method static \Database\Factories\StudentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFiliereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Student withoutTrashed()
 * @property string $sexe
 * @property-read string $delai_format
 * @property-read string $naissance_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Question> $questions
 * @property-read int|null $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSexe($value)
 * @property int $tuteur_id
 * @property int $scolarite
 * @property int $frais
 * @property-read \App\Models\Folder|null $folder
 * @property-read mixed $full_name
 * @property-read string $frais_format
 * @property-read string $montant_format
 * @property-read string $scolarite_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Tuteur $tuteur
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereFrais($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereScolarite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereTuteurId($value)
 * @mixin \Eloquent
 */
final class Student extends Model
{
    use DateFormat, HasUniqueReference;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'prenom', 'sexe', 'naissance', 'reference', 'contact', 'scolarite', 'frais', 'classe_id', 'tuteur_id'];

    protected $appends = ['full_name'];

    protected static array $cacheKeys = [
        'count_students',
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function getScolariteFormatAttribute(): string
    {
        return number_format($this->classe->scolarite - $this->scolarite, 0, ',', ' ') . ' CFA';
    }

    public function getFraisFormatAttribute(): string
    {
        return number_format($this->classe->frais - $this->frais, 0, ',', ' ') . ' CFA';
    }

    public function getNaissanceFormatAttribute(): string
    {
        return Carbon::parse($this->naissance)->format('d/m/Y');
    }

    /**
     * Get the classe that owns the Student
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Get the parent that owns the Student
     */
    public function tuteur(): BelongsTo
    {
        return $this->belongsTo(Tuteur::class);
    }

    /**
     * Get all of the question for the Student
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get all of the notes for the Student
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get all of the scolarites for the Student
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the student's folder.
     */
    public function folder(): MorphOne
    {
        return $this->morphOne(Folder::class, 'folderable');
    }
}
