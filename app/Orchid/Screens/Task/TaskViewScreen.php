<?php

namespace App\Orchid\Screens\Task;

use App\Enums\TaskStatusesEnum;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class TaskViewScreen extends Screen
{
    public Task $task;

    public function permission(): ?iterable
    {
        return [
            'tasks.view'
        ];
    }

    public function query(Task $task): iterable
    {
        return [
            'task' => $task
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Task Details';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $links = [];
        if(Auth::user()->hasAccess('projects.delete')) {
            $links[] = Link::make('Edit')
                ->icon('pencil')
                ->route('platform.task.edit', ['id' => $this->task->id]);
        }

        if(Auth::user()->hasAccess('projects.delete')) {
            $links[] = Button::make('Remove')
                ->icon('trash')
                ->confirm('Are you going to delete task: ' . $this->task->name)
                ->method('remove');

        }

        return $links;

    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('task', [
                Sight::make('id')->popover('Identifier, a symbol which uniquely identifies an object or record'),
                Sight::make('status', 'Status')
                    ->popover('Available statuses: ' . implode(', ', TaskStatusesEnum::names()))
                    ->render(fn () => TaskStatusesEnum::from($this->task->status)->name ),
                Sight::make('description', 'Task Description'),
                Sight::make('start_date', 'Start Date'),
                Sight::make('end_date', 'End Date '),
                Sight::make('owner')->render(function() {
                    return $this->task->user->name ?? 'Not selected';
                }),
                Sight::make('project')->render(function() {
                    return Link::make($this->task->project->subject)
                        ->icon('arrow-right')
                        ->route('platform.project.view', ['id' => $this->task->project->id]);
                }),
                Sight::make('created_at', 'Created'),
                Sight::make('updated_at', 'Updated'),
            ])->title($this->task->name),

        ];
    }

    public function remove(Task $task): RedirectResponse
    {
        $task->delete();
        Alert::info("You have successfully deleted task: $task->name" );

        return redirect()->route('platform.tasks');
    }
}
