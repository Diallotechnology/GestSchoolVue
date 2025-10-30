<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\DevoirEnum;
use App\Helper\DateFormat;
use App\Helper\HasUniqueReference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Devoir
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $cours_id
 * @property int $classe_id
 * @property int $matiere_id
 * @property string $description
 * @property string $delai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Classe $classe
 * @property-read Cours $cours
 * @property-read string $date_format
 * @property-read Matiere $matiere
 * @property-read Teacher $teacher
 * @method static \Database\Factories\DevoirFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir query()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereCoursId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereDelai($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereMatiereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir withoutTrashed()
 * @property int $periode_id
 * @property string|null $reference
 * @property string $type
 * @property DevoirEnum $etat
 * @property-read Folder|null $folder
 * @property-read string $delai_format
 * @property-read Periode $periode
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereEtat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Devoir whereType($value)
 * @property int $course_id
 * @property-read \App\Models\Course $course
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Devoir whereCourseId($value)
 * @mixin \Eloquent
 */
final class Devoir extends Model
{
    use DateFormat, HasUniqueReference;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'etat', 'type', 'reference', 'delai', 'matiere_id', 'classe_id', 'course_id', 'teacher_id', 'periode_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'etat' => DevoirEnum::class,
    ];

    /**
     * Get the teacher that owns the Devoir
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the matiere that owns the Devoir
     */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    /**
     * Get the course that owns the Devoir
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the classe that owns the Devoir
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Get the devoir's folder.
     */
    public function folder(): MorphOne
    {
        return $this->morphOne(Folder::class, 'folderable');
    }

    /**
     * Get the periode that owns the Devoir
     */
    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function Complet(): bool
    {
        return $this->etat === DevoirEnum::TERMINE;
    }

    public function Pending(): bool
    {
        return $this->etat === DevoirEnum::EN_ATTENTE;
    }

    public function Progress(): bool
    {
        return $this->etat === DevoirEnum::EN_COURS;
    }
}
