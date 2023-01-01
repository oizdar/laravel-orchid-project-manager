<?php
namespace App\Enums;

enum TaskStatusesEnum: string
{
    case New = 'new';
    case InProgress = 'in-progress';
    case Done = 'done';
}
