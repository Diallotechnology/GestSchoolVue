<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property string $libelle
 * @property int $montant
 * @property string $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read string $delai_format
 * @property-read string $montant_format
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereMontant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depense whereUserId($value)
 * @mixin \Eloquent
 */
final class Depense extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['libelle', 'montant', 'user_id'];

    /**
     * Get the user that owns the Depense
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMontantFormatAttribute(): string
    {
        return number_format($this->montant, 0, ',', ' ') . ' CFA';
    }

    protected static array $cacheKeys = [
        'sum_depenses',
    ];
}
