<?php

declare(strict_types=1);

namespace App\Models;

use App\Helper\DateFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Document
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Folder|null $folder
 * @property-read string $date_format
 * @property-read User|null $user
 * @method static \Database\Factories\DocumentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 * @property int $user_id
 * @property int $folder_id
 * @property string $libelle
 * @property string $extension
 * @property string $chemin
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereChemin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFolderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUserId($value)
 * @property-read string $delai_format
 * @property-read mixed $full_name
 * @property-read string $montant_format
 * @mixin \Eloquent
 */
final class Document extends Model
{
    use DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'folder_id',
        'libelle',
        'extension',
        'chemin',
    ];

    /**
     * Get the folder that owns the Document
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Get the user that owns the Document
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function DocLink(): string
    {
        return Storage::url($this->chemin);
    }
}
