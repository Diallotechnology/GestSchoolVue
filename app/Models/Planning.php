<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Planning
 *
 * @property int $id
 * @property int $matiere_id
 * @property int $classe_id
 * @property string $debut
 * @property string $fin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Classe $classe
 * @property-read string $date_format
 * @property-read Matiere $matiere
 * @method static \Database\Factories\PlanningFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Planning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning query()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereMatiereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Planning withoutTrashed()
 * @property int $teacher_id
 * @property string $type
 * @property-read string $delai_format
 * @property-read Teacher $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Planning whereType($value)
 * @property int $periode_id
 * @property string $salle
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @property-read \App\Models\Periode $periode
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Planning whereSalle($value)
 * @mixin \Eloquent
 */
final class Planning extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['debut', 'fin', 'classe_id', 'matiere_id', 'teacher_id', 'type', 'periode_id', 'salle'];

    protected $casts = [
        'debut' => 'datetime',
        'fin' => 'datetime',
    ];

    /**
     * Get the matiere that owns the Planning
     */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    /**
     * Get the classe that owns the Planning
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Get the teacher that owns the Planning
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the periode that owns the Planning
     */
    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }
}
