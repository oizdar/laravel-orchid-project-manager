<?php

namespace App\Orchid\Layouts\Task;

use App\Models\Task;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TaskListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tasks';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Name')
                ->render(function (Task $task) {
                    return Link::make($task->name)
                        ->route('platform.task.view', ['id' => $task->id]);
                })
                ->sort()
                ->filter()
                ->cantHide(),
            TD::make('description', 'Description')
                ->defaultHidden()
                ->width('500px'),
            TD::make('status', 'Status')
                ->alignCenter(),
            TD::make('start_date', 'Start Date')
                ->width('110px')
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE),
            TD::make('end_date', 'Due Date')
                ->width('110px')
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE),
            TD::make('user', 'User')
                ->render(function (Task $task) {
                    return Link::make($task->user->name)
                        ->route('platform.task.view', ['id' => $task->id]);
                })
                ->sort()
                ->filter(),
            TD::make('project', 'Project')
                ->render(function (Task $task) {
                    return Link::make($task->project->subject);
//                        ->route('platform.task.view', $project);
                })
                ->sort()
                ->filter(),
        ];
    }
}
