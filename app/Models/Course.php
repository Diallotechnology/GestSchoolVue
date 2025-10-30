<?php

namespace App\Models;

use App\Helper\HasUniqueReference;
use App\Models\Type;
use App\Models\Folder;
use App\Models\Periode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int $id
 * @property int $type_id
 * @property int $matiere_id
 * @property int $teacher_id
 * @property string $nom
 * @property string|null $reference
 * @property string $description
 * @property string $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Classe> $classes
 * @property-read int|null $classes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read Folder|null $folder
 * @property-read mixed $full_name
 * @property-read string|null $deleted_at
 * @property-read \App\Models\Matiere $matiere
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Periode> $periodes
 * @property-read int|null $periodes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\Teacher $teacher
 * @property-read Type $type
 * @method static \Database\Factories\CourseFactory factory($count = null, $state = [])
 * @method static Builder<static>|Course forUser()
 * @method static Builder<static>|Course newModelQuery()
 * @method static Builder<static>|Course newQuery()
 * @method static Builder<static>|Course query()
 * @method static Builder<static>|Course whereCreatedAt($value)
 * @method static Builder<static>|Course whereDescription($value)
 * @method static Builder<static>|Course whereId($value)
 * @method static Builder<static>|Course whereMatiereId($value)
 * @method static Builder<static>|Course whereNom($value)
 * @method static Builder<static>|Course whereReference($value)
 * @method static Builder<static>|Course whereTeacherId($value)
 * @method static Builder<static>|Course whereTypeId($value)
 * @method static Builder<static>|Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory, HasUniqueReference;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['matiere_id', 'teacher_id', 'type_id', 'nom', 'reference', 'description'];

    protected $appends = ['full_name'];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->reference . ' ' . $this->nom,
            set: null
        );
    }

    public function getCreatedAtAttribute(string $date): string
    {
        return Carbon::parse($date)->format('d/m/Y H:i:s');
    }

    public function getDeletedAtAttribute(?string $date): ?string
    {
        if ($date === null) {
            return null;
        }

        return Carbon::parse($date)->format('d/m/Y H:i:s');
    }

    public function teacher_view(): string
    {
        return $this->teacher ? $this->teacher->prenom . ' ' . $this->teacher->nom : 'inexistant';
    }

    public function type_view(): string
    {
        return $this->type ? $this->type->nom : 'inexistant';
    }

    /**
     * The classes that belong to the Cours
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class);
    }

    /**
     * Get all of the questions for the Cours
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * The periodes that belong to the Cours
     */
    public function periodes(): BelongsToMany
    {
        return $this->belongsToMany(Periode::class);
    }

    /**
     * Get the teacher that owns the Cours
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the matiere that owns the Cours
     */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    /**
     * Get the type that owns the Cours
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get all of the devoirs for the Cours
     */
    public function devoirs(): HasMany
    {
        return $this->hasMany(Devoir::class);
    }

    /**
     * Get the courrier's folder.
     */
    public function folder(): MorphOne
    {
        return $this->morphOne(Folder::class, 'folderable');
    }

    public function scopeForUser(Builder $query)
    {
        $auth = Auth::user();

        return $query->when($auth->isTeacher(), function ($query) use ($auth): void {
            $query->whereIn('id', $auth->userable->cours->pluck('id'));
        })->when($auth->isStudent(), function ($query) use ($auth): void {
            $query->whereIn('id', $auth->userable->classe->cours->pluck('id'));
        });
    }

    protected static array $cacheKeys = [
        'count_cours',
        'courses_by_type_admin',
    ];
}
