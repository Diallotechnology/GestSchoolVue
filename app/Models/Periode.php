<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\CacheHelper;
use App\Helper\DateFormat;
use App\Helper\HasSearch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Periode
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Matiere> $matieres
 * @property-read int|null $matieres_count
 * @method static \Database\Factories\PeriodeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode query()
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Periode whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $course
 * @property-read int|null $course_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ue> $ues
 * @property-read int|null $ues_count
 * @mixin \Eloquent
 */
final class Periode extends Model
{
    use DateFormat;

    protected $fillable = ['nom'];

    public static function getCachedList(bool $forceRefresh = false): Collection
    {
        return self::memoizedCache('periodes_list', function () {
            return self::select('id', 'nom')->get();
        }, ttl: null, forceRefresh: $forceRefresh);
    }


    protected static array $cacheKeys = [
        'periodes_list',
    ];

    /**
     * The cours that belong to the Periode
     */
    public function course(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * Get all of the ues for the Periode
     */
    public function ues(): HasMany
    {
        return $this->hasMany(Ue::class);
    }

    /**
     * Get all of the devoirs for the Periode
     */
    public function devoirs(): HasMany
    {
        return $this->hasMany(Devoir::class);
    }

    /**
     * Get all of the notes for the Periode
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    protected static function booted()
    {
        self::saved(fn() => Cache::forget('periodes_list'));
        self::deleted(fn() => Cache::forget('periodes_list'));
    }
}
