<?php

declare(strict_types=1);

namespace App\Enum;

enum RoleEnum: string
{
    case ADMIN = 'Administrateur';
    case TEACHER = 'Professeur';
    case STUDENT = 'Etudiant';
    case PARENT = 'Parent';
    case COMPTABLE = 'Comptable';
    case ASSISTANT = 'Assistant';
    case SURVEILLANT = 'Surveillant';
    case DG = 'DG';

    public static function all(): array
    {
        return array_map(function (self $role) {
            return [
                'id' => $role->value,
                'nom' => $role->value
            ];
        }, self::cases());
    }
}
