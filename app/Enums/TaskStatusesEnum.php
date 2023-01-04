<?php
namespace App\Enums;

enum TaskStatusesEnum: string
{
    case New = 'new';
    case InProgress = 'in-progress';
    case Done = 'done';

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
