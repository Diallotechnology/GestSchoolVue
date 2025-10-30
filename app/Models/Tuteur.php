<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read string $delai_format
 * @property-read string $montant_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\TuteurFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tuteur whereUpdatedAt($value)
 * @mixin \Eloquent
 */
final class Tuteur extends Model
{
    use DateFormat;

    protected $fillable = ['nom', 'prenom', 'contact'];

    protected $appends = ['full_name'];

    public static function getCachedList(bool $force = false): Collection
    {
        return self::memoizedCache('teacher_list', function () {
            return self::query()
                ->select('id', 'nom', 'prenom')
                ->get();
        }, ttl: null, forceRefresh: $force);
    }

    protected static array $cacheKeys = [
        'count_tuteurs',
        'teacher_list',
    ];

    /**
     * Get all of the students for the Tuteur
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
