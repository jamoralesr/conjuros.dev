<?php

namespace App\Enums;

enum AuthorType: string
{
    case Human = 'human';
    case Ai = 'ai';

    public function label(): string
    {
        return match ($this) {
            self::Human => 'Humano',
            self::Ai => 'IA',
        };
    }
}
