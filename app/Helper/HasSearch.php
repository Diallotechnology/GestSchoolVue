<?php

declare(strict_types=1);

namespace App\Helper;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Model
 */
trait HasSearch
{
    /**
     * Recherche générique sur colonnes locales + relations
     */
    public function scopeSearch(Builder $query, ?string $term, array $columns = []): void
    {
        if (! $term || empty($columns)) {
            return;
        }

        // ✅ ici, on récupère le modèle associé à la requête
        $model = $query->getModel();
        $table = $model->getTable();

        $connection = DB::connection()->getDriverName();

        $localColumns = array_filter($columns, fn ($c) => ! str_contains($c, '.'));

        if ($connection === 'mysql' && ! empty($localColumns)) {
            $indexes = collect(DB::select("SHOW INDEX FROM {$table}"))
                ->where('Index_type', 'FULLTEXT')
                ->pluck('Column_name')
                ->toArray();

            $indexedColumns = array_intersect($localColumns, $indexes);

            if (! empty($indexedColumns)) {
                $query->whereRaw(
                    'MATCH('.implode(',', $indexedColumns).') AGAINST (? IN BOOLEAN MODE)',
                    [$term]
                );
            }
        }

        // Fallback LIKE (local + relations)
        $query->where(function ($q) use ($term, $columns) {
            foreach ($columns as $column) {
                if (str_contains($column, '.')) {
                    [$relation, $field] = explode('.', $column, 2);
                    $q->orWhereHas($relation, function ($sub) use ($field, $term) {
                        $sub->where($field, 'like', "%{$term}%");
                    });
                } else {
                    $q->orWhere($column, 'like', "%{$term}%");
                }
            }
        });
    }
}
