<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case PADRE = 'padre';
    case PROFESOR = 'profesor';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
