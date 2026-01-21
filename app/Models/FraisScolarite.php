<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FraisScolarite extends Model
{
    /** @use HasFactory<\Database\Factories\FraisScolariteFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['academic_year_id', 'classe_id', 'montant', 'frais'];

    /**
     * Get the classe that owns the FraisScolarite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /**
     * Get the academic_year that owns the FraisScolarite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function academic_year(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
