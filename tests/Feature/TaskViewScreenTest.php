<?php

namespace Tests\Feature;

use App\Models\Task;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class TaskViewScreenTest extends FeatureTestCase
{
    use ScreenTesting;

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
                $task->status,
                'Task Description',
                $task->description,
                'Start Date',
                $task->start_date,
                'End Date',
                $task->end_date,
                'Created',
                'Updated',
            ]);
    }
}
