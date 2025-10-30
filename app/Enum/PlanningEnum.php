<?php

declare(strict_types=1);

namespace App\Enum;

use Illuminate\Support\Collection;

enum PlanningEnum: string
{
    case DEVOIR = 'Devoir';
    case EXAMEN = 'Examen';
    case COURSE = 'Cours';

    public static function all(): array
    {
        return array_map(function (self $item) {
            return [
                'id' => $item->value,
                'nom' => $item->value
            ];
        }, self::cases());
    }
}
