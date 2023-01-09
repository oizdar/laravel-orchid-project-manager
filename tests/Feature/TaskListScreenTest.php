<?php

namespace Tests\Feature;

use App\Enums\PermissionsEnum;
use App\Models\Task;
use App\Models\User;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class TaskListScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testTaskListUnaccessibleWithoutProperPermission()
    {
        $user = User::factory()->create();
        $screen = $this->screen('platform.tasks')->actingAs($user);

        $screen->display()->assertStatus(403);
    }

    public function testTaskListAccessibleWithProperPermission()
    {
        $user = User::factory()
            ->withPermisions([PermissionsEnum::PLATFORM_INDEX->value, PermissionsEnum::TASKS_VIEW->value])
            ->create();

        $screen = $this->screen('platform.tasks')->actingAs($user);

        $screen->display()->assertStatus(200);
    }

    public function testProjectCreate()
    {
        $task = Task::factory()->create();

        $screen = $this->screen('platform.tasks')->actingAs($this->admin);
        $screen->display()
            ->assertSeeInOrder([
                'Tasks List',
                'All tasks',
                'Name',
                'Status',
                'Start Date',
                'Due Date',
                $task->name,
                $task->status,
                $task->start_date,
                $task->due_date,
                $task->user?->name,
                $task->project->subject,

            ]);
    }
}
