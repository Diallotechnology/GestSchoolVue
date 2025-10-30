<?php

declare(strict_types=1);

namespace App\Enum;

enum DiplomeEnum: string
{
    case Master = 'Master';
    case DUT = 'DUT';
    case Licence = 'Licence';

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
