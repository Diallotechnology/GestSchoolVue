<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Personnel
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $contact
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static \Database\Factories\PersonnelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Personnel whereUpdatedAt($value)
 * @property-read mixed $full_name
 * @mixin \Eloquent
 */
final class Personnel extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'contact'];

    protected $appends = ['full_name'];

    public function getCreatedAtAttribute(string $date): string
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->nom . ' ' . $this->prenom,
            set: null
        );
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
