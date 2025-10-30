<?php

declare(strict_types=1);

namespace App\Enum;

enum DevoirEnum: string
{
    case EN_ATTENTE = 'En attente';
    case EN_COURS = 'En cours';
    case TERMINE = 'Terminé';

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
