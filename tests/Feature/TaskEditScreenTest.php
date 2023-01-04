<?php

namespace Tests\Feature;

use App\Enums\TaskStatusesEnum;
use App\Models\Task;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class TaskEditScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testTaskCreate()
    {
        $screen = $this->screen('platform.task.create')->actingAs($this->admin);
        $screen->display()
            ->assertSeeInOrder([
                'Create New Task',
                'You can create new task here',
                'Task name',
                'Description',
                'Status',
                'New',
                'Owner',
                'Project',
                'Start Date',
                'End Date',
                ]);

        $task = Task::factory()->create();
        $screen->method('create', [
                'task' => $task
            ]);

        $this->assertDatabaseHas('tasks', [
            'name' => $task->name,
            'description' => $task->description,
            'status' => $task->status,
            'user_id' => $task->user->id,
            'project_id' => $task->project->id,

        ]);
    }

    public function testTaskEdit()
    {
        $task = Task::latest()->first();

        $screenEdit = $this->screen('platform.task.edit')
            ->parameters(['id' => $task->id])
            ->actingAs($this->admin);

        $screenEdit->display()
            ->assertSeeInOrder([
                'Edit Task',
                'Update task information',
                'Name',
                $task->name,
                'Description',
                'Status',
                $task->status,
                'Owner',
                "{$task->user->name} ({$task->user->email})",
                'Project',
                $task->project->name,
                'Start Date',
                $task->start_date,
                'End Date',
            ]);


        $taskNew = Task::factory()->definition();
        $screenEdit->method('update', ['task' => $taskNew]);

        $this->assertDatabaseHas('tasks', $taskNew);
    }

    public function testTaskRemove()
    {
        $task = Task::all()->random();

        $screenEdit = $this->screen('platform.task.edit')->parameters(['id' => $task->id])->actingAs($this->admin);
        $screenEdit->display()
            ->assertSeeInOrder([
                'Edit Task',
                'Update task information',
                'name',
                $task->name,
                'Description',
                $task->description,
                'Start Date',
                $task->start_date,
                'End Date',
            ]);

        $screenEdit->method('remove', ['task' => $task]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
