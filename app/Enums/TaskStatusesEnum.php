<?php
namespace App\Enums;

enum TaskStatusesEnum: string
{
    case New = 'new';
    case InProgress = 'in-progress';
    case Done = 'done';

    public static function casesValuesAsArray()
    {

        return array_column(self::cases(), 'value');
    }
}
