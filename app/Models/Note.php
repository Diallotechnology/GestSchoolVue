<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use App\Helper\DateFormat;
use App\Helper\CacheHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Note
 *
 * @property int $id
 * @property int $student_id
 * @property int $matiere_id
 * @property string $valeur
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $date_format
 * @property-read Matiere $matiere
 * @property-read Student $student
 * @method static \Database\Factories\NoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereMatiereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereValeur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Note withoutTrashed()
 * @property int $user_id
 * @property int $periode_id
 * @property string $type
 * @property-read string $delai_format
 * @property-read Periode $periode
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Note wherePeriodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUserId($value)
 * @property string $diplome
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Note whereDiplome($value)
 * @mixin \Eloquent
 */
final class Note extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['valeur', 'type', 'diplome', 'student_id', 'matiere_id', 'user_id', 'periode_id'];

    public function refreshGlobalCacheVersion(): void
    {
        Cache::forever('global_cache_version', uniqid());
    }

    public function flushRelevantCaches(): void
    {
        // Clé spécifique à l'étudiant
        self::invalidateCache("student_{$this->student_id}_details");

        $periodes = Periode::pluck('id')->toArray();

        if ($this->periode_id) {
            $key = "student_{$this->student_id}_results_{$this->periode_id}_{$this->updated_at->timestamp}";
            self::invalidateCache($key);
            self::flushCacheGroup("results_{$this->student_id}_{$this->periode_id}");
        } else {
            foreach ($periodes as $periode_id) {
                self::flushCacheGroup("results_{$this->student_id}_{$periode_id}");
            }
        }

        self::flushCacheGroup('livewire.data');

        $lastPage = Student::paginate(15)->lastPage();
        for ($i = 1; $i <= $lastPage; $i++) {
            self::invalidateCache($this->buildCacheKey($i));
        }

        // 👇 Flush du cache rows() de l'utilisateur courant
        self::flushCacheGroup("note_rows_user_" . Auth::id());
    }


    protected static function booted()
    {
        self::saved(function ($note) {
            $note->refreshGlobalCacheVersion();
            $note->flushRelevantCaches();
        });

        self::deleted(function ($note) {
            $note->refreshGlobalCacheVersion();
            $note->flushRelevantCaches();
        });
    }

    private function buildCacheKey($page): string
    {
        return 'student_results:' . md5(
            $this->student_id .
                $this->periode_id .
                $page .
                Cache::get('global_cache_version')
        );
    }

    /**
     * Get the student that owns the Note
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the matiere that owns the Note
     */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    /**
     * Get the periode that owns the Note
     */
    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    /**
     * Get the user that owns the Note
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
