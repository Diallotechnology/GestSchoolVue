<?php

declare(strict_types=1);

namespace App\Enum;

enum PaymentModeEnum: string
{
    case VIREMENT = 'Virement';
    case CHEQUE = 'Chèque';
    case ESPECES = 'Espèces';
    case ORANGE_MONEY = 'Orange Money';

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
