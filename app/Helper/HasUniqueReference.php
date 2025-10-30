<?php

declare(strict_types=1);

namespace App\Helper;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait HasUniqueReference
{
    public static function bootHasUniqueReference()
    {
        static::creating(function ($model) {
            $prefix = $model->resolveReferencePrefix().Carbon::today()->format('Y').'-';

            DB::transaction(function () use ($model, $prefix) {
                $last = self::where('reference', 'like', $prefix.'%')
                    ->whereNotNull('reference')
                    ->lockForUpdate()
                    ->latest('id')
                    ->first(['reference']);

                $sequence = 0;
                if ($last) {
                    $sequence = (int) mb_substr($last->reference, mb_strlen($prefix));
                }

                $sequence++;
                $model->reference = $prefix.$sequence;
            });
        });
    }

    /**
     * Résout le préfixe pour le modèle courant.
     */
    protected function resolveReferencePrefix(): string
    {
        $map = config('references');

        return $map[static::class] ?? 'REF';
    }
}
