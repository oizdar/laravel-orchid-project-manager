<?php

namespace App\Orchid\Screens\Task;

use App\Models\Task;
use App\Orchid\Layouts\Task\TaskListLayout;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class TaskListScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'tasks.view'
        ];
    }

    public function query(): iterable
    {
        return [
            'tasks' => Task::filters()
                ->defaultSort('id', 'DESC')
                ->paginate()
        ];
    }

    public function name(): ?string
    {
        return 'Tasks List';
    }

    public function description(): ?string
    {
        return 'All tasks';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        if(Auth::user()->hasAccess('tasks.edit')) {
            return [
                Link::make('Create new')
                    ->icon('pencil')
                    ->route('platform.task.create')
            ];
        }

        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            TaskListLayout::class
        ];
    }
}
