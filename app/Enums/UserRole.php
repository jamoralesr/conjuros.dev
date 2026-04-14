<?php

namespace App\Enums;

enum UserRole: string
{
    case Member = 'member';
    case Author = 'author';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Member => 'Miembro',
            self::Author => 'Autor',
            self::Admin => 'Administrador',
        };
    }
}
