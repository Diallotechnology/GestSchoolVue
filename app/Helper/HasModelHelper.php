<?php

declare(strict_types=1);

namespace App\Helper;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait HasModelHelper
{
    /**
     * Format montant in CFA.
     */
    public function getMontantFormatAttribute(): string
    {
        return $this->formatCurrency((int) ($this->montant));
    }

    /**
     * Format avance in CFA.
     */
    public function getCreditFormatAttribute(): string
    {
        return $this->formatCurrency($this->credit);
    }

    public function getFraisFormatAttribute(): string
    {
        return $this->formatCurrency($this->frais);
    }

    public function user_activity(string $action): void
    {
        Auth::user()->Journals()->create(['action' => $action]);
    }

    /**
     * Format a number into CFA currency.
     */
    public function formatCurrency(int|float|null $amount): string
    {
        return number_format($amount ?? 0, 0, ',', ' ').' CFA';
    }

    // protected function getCreatedAtAttribute(string $date): string
    // {
    //     return Carbon::parse($date)->format('d/m/Y H:i:s');
    // }

    // protected function getDateFormatAttribute(): string
    // {
    //     return Carbon::parse($this->date)->format('d/m/Y');
    // }

    /**
     * Scope a query to only include popular users.
     */
    #[Scope]
    protected function scopeByUser(Builder $query)
    {
        return $query->where('user_id', Auth::user()->id);
    }

    protected function Name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nom.' '.$this->prenom,
            set: null
        );
    }
}
