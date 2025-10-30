<?php

declare(strict_types=1);

namespace App\Helper;

use App\Enum\RoleEnum;

trait HasRoles
{
    public function hasRole(string $role): bool
    {
        return match ($role) {
            RoleEnum::ADMIN->value => $this->isAdmin(),
            RoleEnum::TEACHER->value => $this->isTeacher(),
            RoleEnum::STUDENT->value => $this->isStudent(),
            RoleEnum::PARENT->value => $this->isParent(),
            RoleEnum::COMPTABLE->value => $this->isComptable(),
            RoleEnum::ASSISTANT->value => $this->isAssistant(),
            RoleEnum::SURVEILLANT->value => $this->isSurveillant(),
            RoleEnum::DG->value => $this->isDG(),
            default => false,
        };
    }

    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has the superadmin role.
     */
    public function isStudent(): bool
    {
        return $this->role === RoleEnum::STUDENT;
    }

    /**
     * Check if the user has the admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ADMIN;
    }

    /**
     * Check if the user has the teacher role.
     */
    public function isTeacher(): bool
    {
        return $this->role === RoleEnum::TEACHER;
    }

    /**
     * Check if the user has the parent role.
     */
    public function isParent(): bool
    {
        return $this->role === RoleEnum::PARENT;
    }

    public function isComptable(): bool
    {
        return $this->role === RoleEnum::COMPTABLE;
    }

    public function isAssistant(): bool
    {
        return $this->role === RoleEnum::ASSISTANT;
    }

    public function isSurveillant(): bool
    {
        return $this->role === RoleEnum::SURVEILLANT;
    }

    public function isDG(): bool
    {
        return $this->role === RoleEnum::DG;
    }
}
