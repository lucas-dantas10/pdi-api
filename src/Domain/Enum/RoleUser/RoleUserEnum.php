<?php

namespace App\Domain\Enum\RoleUser;

enum RoleUserEnum: int
{
    case ROLE_COMMON = 1;
    case ROLE_SHOPKEEPER = 2;

    public static function getById(int $id): RoleUserEnum
    {
        return match ($id) {
            1 => self::ROLE_COMMON,
            2 => self::ROLE_SHOPKEEPER,
            default => throw new \InvalidArgumentException('Invalid role id'),
        };
    }
}
