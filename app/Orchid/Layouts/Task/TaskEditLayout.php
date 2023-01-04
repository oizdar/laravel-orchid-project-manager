<?php

namespace App\Orchid\Layouts\Task;

use App\Enums\TaskStatusesEnum;
use App\Models\Project;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class TaskEditLayout extends Rows
{
    protected $target = 'task';

    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('task.name')
                ->title('Task name.')
                ->required()
                ->min(6)
                ->max(255)
                ->help('Enter the name of task'),
            TextArea::make('task.description')
                ->title('Description')
                ->rows(7)
                ->required()
                ->placeholder('Task description.')
                ->help('Enter short description'),
            Select::make('task.status')
                ->title('Status')
                ->options(
                    TaskStatusesEnum::array()
                )
                ->required(),
            Relation::make('task.user_id')
                ->title('Owner')
                ->allowEmpty()
                ->fromModel(User::class, 'name')
                ->searchColumns('name', 'email')
                ->displayAppend('full')
                ->chunk(10)
                ->empty('Not Selected'),
            Relation::make('task.project_id')
                ->title('Project')
                ->fromModel(Project::class, 'subject')
                ->chunk(10)
                ->required(),
            DateTimer::make('task.start_date')
                ->title('Start Date')
                ->format('Y-m-d')
                ->required(),
            DateTimer::make('task.end_date')
                ->title('End Date')
                ->format('Y-m-d')
        ];
    }
}
