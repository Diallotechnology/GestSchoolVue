<?php

namespace App\Models;

use App\Models\User;
use App\Helper\CacheHelper;
use Illuminate\Support\Str;
use App\Enum\PaymentModeEnum;
use Illuminate\Support\Carbon;
use App\Helper\HasUniqueReference;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *
 *
 * @property int $id
 * @property string|null $reference
 * @property int $user_id
 * @property int $student_id
 * @property int $classe_id
 * @property string $type
 * @property PaymentModeEnum $mode
 * @property string|null $adresse
 * @property string $motif
 * @property int $montant
 * @property int|null $remise
 * @property string|null $remise_motif
 * @property string $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Classe $classe
 * @property-read string $montant_format
 * @property-read string $remise_format
 * @property-read \App\Models\Student $student
 * @property-read User $user
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereClasseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereRemise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereRemiseMotif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUserId($value)
 * @mixin \Eloquent
 */
class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory, CacheHelper, HasUniqueReference;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'student_id',
        'classe_id',
        'type',
        'mode',
        'adresse',
        'motif',
        'montant',
        'remise_motif',
        'remise',
        'reference',
    ];

    protected $casts = [
        'mode' => PaymentModeEnum::class,
    ];

    /**
     * Format montant in CFA.
     */
    public function getMontantFormatAttribute(): string
    {
        return $this->formatCurrency($this->montant);
    }

    /**
     * Format remise in CFA.
     */
    public function getRemiseFormatAttribute(): string
    {
        return $this->formatCurrency($this->remise);
    }

    /**
     * Generate a unique reference ID with prefix and year.
     */
    public function generateId(string $prefixType)
    {
        $year = now()->format('Y');
        $prefix = $prefixType . $year . '-';

        return DB::transaction(function () use ($prefix) {
            $lastRef = self::where('reference', 'like', "{$prefix}%")
                ->whereNotNull('reference')
                ->latest('id')
                ->lockForUpdate()
                ->value('reference');

            $nextSequence = $this->extractSequence($lastRef, $prefix) + 1;

            $this->reference = $prefix . $nextSequence;
            $this->save();

            return $this;
        });
    }


    /**
     * Format a number into CFA currency.
     */
    private function formatCurrency(?int $amount): string
    {
        return number_format($amount ?? 0, 0, ',', ' ') . ' CFA';
    }

    /**
     * Extract numeric sequence from a reference string.
     */
    private function extractSequence(?string $reference, string $prefix): int
    {
        if (!$reference || !Str::startsWith($reference, $prefix)) {
            return 0;
        }

        return (int) mb_substr($reference, mb_strlen($prefix));
    }


    protected function getCreatedAtAttribute(string $date): string
    {
        return Carbon::parse($date)->format('d/m/Y H:i:s');
    }

    /**
     * Get the user that owns the Scolarite
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the student that owns the Scolarite
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the classe that owns the Scolarite
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    protected static array $cacheKeys = [
        'sum_payments',
    ];
}
