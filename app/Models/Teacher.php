<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use App\Helper\CacheHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Teacher
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property int|null $salaire
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cours> $cours
 * @property-read int|null $cours_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Devoir> $devoirs
 * @property-read int|null $devoirs_count
 * @property-read string $date_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Student> $students
 * @property-read int|null $students_count
 * @property-read User|null $user
 * @method static \Database\Factories\TeacherFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereSalaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Teacher withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Classe> $classes
 * @property-read int|null $classes_count
 * @property-read string $delai_format
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Planning> $plannings
 * @property-read int|null $plannings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Question> $questions
 * @property-read int|null $questions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $course
 * @property-read int|null $course_count
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @method static Builder<static>|Teacher forUser()
 * @mixin \Eloquent
 */
final class Teacher extends Model
{
    use DateFormat;

    protected $fillable = ['nom', 'prenom', 'contact'];

    protected $appends = ['full_name'];


    public static function getCachedList(bool $force = false): Collection
    {
        return self::memoizedCache('teacher_list', function () {
            return self::query()
                ->select('id', 'nom', 'prenom', 'contact')
                ->get();
        }, ttl: null, forceRefresh: $force);
    }

    protected static array $cacheKeys = [
        'count_teachers',
        'teacher_list',
    ];

    /**
     * Get all of the devoirs for the Teacher
     */
    public function devoirs(): HasMany
    {
        return $this->hasMany(Devoir::class);
    }

    /**
     * Get all of the plannings for the Teacher
     */
    public function plannings(): HasMany
    {
        return $this->hasMany(Planning::class);
    }

    /**
     * Get all of the course for the Teacher
     */
    public function course(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get all of the questions for the Teacher
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * The matieres that belong to the Teacher
     */
    public function matieres(): BelongsToMany
    {
        return $this->belongsToMany(Matiere::class);
    }

    /**
     * The classes that belong to the Teacher
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class);
    }

    public function scopeForUser(Builder $query)
    {
        $auth = Auth::user();

        return $query->when($auth->isStudent(), function ($query) use ($auth): void {
            $query->whereIn('id', $auth->userable->classe->teachers->pluck('id'));
        })->when($auth->isTeacher(), function ($query) use ($auth): void {
            $query->where('id', $auth->userable_id);
        });
    }
}
