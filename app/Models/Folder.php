<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Folder
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Document> $documents
 * @property-read int|null $documents_count
 * @property-read Model|Eloquent $folderable
 * @property-read User|null $user
 * @method static \Database\Factories\FolderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Folder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Folder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Folder query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereUpdatedAt($value)
 * @property string $folderable_type
 * @property int $folderable_id
 * @property string $nom
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereFolderableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereFolderableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Folder whereNom($value)
 * @mixin \Eloquent
 * @mixin Eloquent
 */
final class Folder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nom', 'folderable_id', 'folderable_type'];

    /**
     * Get the parent folderable model (Courrier or Depart, Interne).
     */
    public function folderable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the structure that owns the Document
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the documents for the Folder
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function IsCourse(): bool
    {
        return $this->folderable_type === Course::class;
    }

    public function IsDevoir(): bool
    {
        return $this->folderable_type === Devoir::class;
    }
}
