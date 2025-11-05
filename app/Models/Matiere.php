<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Matiere
 *
 * @property int $id
 * @property string $nom
 * @property int $coeficient
 * @property string $duree
 * @property string $credit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Planning> $plannings
 * @property-read int|null $plannings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Database\Factories\MatiereFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere query()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereCoeficient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereDuree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Matiere withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Periode> $periodes
 * @property-read int|null $periodes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Classe> $classes
 * @property-read int|null $classes_count
 * @property-read string $delai_format
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ue> $ues
 * @property-read int|null $ues_count
 * @method static Builder<static>|Matiere forUser()
 * @mixin \Eloquent
 */
final class Matiere extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'coeficient', 'duree'];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->nom . ' ' . 'coeficient' . ' ' . $this->coeficient,
            set: null
        );
    }

    /**
     * The teachers that belong to the Matiere
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }

    /**
     * Get all of the devoirs for the Matiere
     */
    public function devoirs(): HasMany
    {
        return $this->hasMany(Devoir::class);
    }

    /**
     * Get all of the planning for the Matiere
     */
    public function plannings(): HasMany
    {
        return $this->hasMany(Planning::class);
    }

    /**
     * Get all of the notes for the Matiere
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * The filieres that belong to the Matiere
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class);
    }

    /**
     * The ues that belong to the Matiere
     */
    public function ues(): BelongsToMany
    {
        return $this->belongsToMany(Ue::class);
    }

    public function scopeForUser(Builder $query)
    {
        $auth = Auth::user();

        return $query->select('id', 'nom')->when($auth->isTeacher(), function ($query) use ($auth) {
            return $query->whereIn('id', $auth->userable->matieres->pluck('id'));
        })->when($auth->isStudent(), function ($query) use ($auth) {
            return $query->whereIn('id', $auth->userable->classe->matieres->pluck('id'));
        });
    }
}
