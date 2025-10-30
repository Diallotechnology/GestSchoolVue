<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use App\Helper\CacheHelper;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Type
 *
 * @property int $id
 * @property string $nom
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read string $date_format
 * @method static \Database\Factories\TypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Type onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Type withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Type withoutTrashed()
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $course
 * @property-read int|null $course_count
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @mixin \Eloquent
 */
final class Type extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom'];

    public static function getCachedList(bool $force = false): Collection
    {
        return self::memoizedCache('type_list', function () {
            return self::query()
                ->select('id', 'nom')
                ->get();
        }, ttl: null, forceRefresh: $force);
    }

    protected static array $cacheKeys = [
        'type_list'
    ];

    /**
     * Get all of the cours for the Type
     */
    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
