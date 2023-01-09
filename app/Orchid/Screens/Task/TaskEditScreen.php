<?php

namespace App\Orchid\Screens\Task;

use App\Enums\PermissionsEnum;
use App\Enums\TaskStatusesEnum;
use App\Models\Task;
use App\Orchid\Layouts\Task\TaskEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class TaskEditScreen extends Screen
{
    public Task $task;

    public function permission(): ?iterable
    {
        return [
            PermissionsEnum::TASKS_EDIT->value
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
        return $this->task->exists ? 'Edit Task' : 'Create New Task';
    }

    public function description(): ?string
    {
        return $this->task->exists ? 'Update task information' : 'You can create new task here';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $links = [
            Button::make('Create Task')
                ->icon('rocket')
                ->method('create')
                ->canSee(!$this->task->exists),

            Button::make('Update Task')
                ->icon('note')
                ->method('update')
                ->canSee($this->task->exists),
        ];

        if(Auth::user()->hasAccess('tasks.delete')) {
            $links[] = Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->confirm('Are you going to delete task: ' . $this->task->name)
                ->canSee($this->task->exists);
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
            TaskEditLayout::class
        ];
    }

    public function create(Task $task, Request $request): RedirectResponse
    {
        $this->validateRequest($request);
        $task->fill($request->get('task'))->save();

        Alert::info('Task creating successful');

        return redirect()->route('platform.task.view', ['id' => $task->id]);
    }

    public function update(Task $task, Request $request): RedirectResponse
    {
        $this->validateRequest($request);
        $task->fill($request->get('task'))->save();

        Alert::info('Task updated successful');

        return redirect()->route('platform.task.view', ['id' => $task->id]);
    }

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'task.name' => 'required|min:6|max:255',
            'task.description' => 'required|min:10|max:255',
            'task.status' => new Enum(TaskStatusesEnum::class),
            'task.user_id' => 'nullable|exists:users,id',
            'task.project_id' => 'exists:projects,id',
            'task.start_date'   => 'required|date|after_or_equal:today',
            'task.end_date'   => 'nullable|date|after:startDate',
        ]);
    }

    public function remove(Task $task): RedirectResponse
    {
        $task->delete();
        Alert::info("You have successfully deleted task: $task->name" );

        return redirect()->route('platform.tasks');
    }
}
