<?php

namespace Tests\Feature;

use App\Enums\PermissionsEnum;
use App\Enums\TaskStatusesEnum;
use App\Models\Task;
use App\Models\User;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class TaskViewScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testTaskViewUnaccessibleWithoutProperPermission()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $screen = $this->screen('platform.task.view')
            ->parameters(['id' => $task->id])
            ->actingAs($user);

        $screen->display()->assertStatus(403);
    }

    public function testTaskViewAccessibleWithProperPermission()
    {
        $user = User::factory()
            ->withPermisions([PermissionsEnum::PLATFORM_INDEX->value, PermissionsEnum::TASKS_VIEW->value])
            ->create();

        $task = Task::factory()->create();

        $screen = $this->screen('platform.task.view')
            ->parameters(['id' => $task->id])
            ->actingAs($user);
        $screen->display()->assertStatus(200);
    }

    public function testProjectView()
    {
        $task = Task::factory()->create();

        $screen = $this->screen('platform.task.view')
            ->parameters(['id' => $task->id])
            ->actingAs($this->admin);

        $screen->display()
            ->assertSeeInOrder([
                $task->name,
                'Id',
                $task->id,
                'Status',
                TaskStatusesEnum::from($task->status)->name,
                'Task Description',
                $task->description,
                'Start Date',
                $task->start_date,
                'End Date',
                $task->end_date,
                'Owner',
                $task->user->name,
                'Project',
                $task->project->subject,
                'Created',
                'Updated',
            ]);
    }
}
