<?php

namespace App\Enums;

enum ContentAccess: string
{
    case Free = 'free';
    case Pro = 'pro';

    public function label(): string
    {
        return match ($this) {
            self::Free => 'Libre',
            self::Pro => 'Pro',
        };
    }
}
