<?php

namespace Tests\Feature;

use App\Models\Task;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class TaskListScreenTest extends FeatureTestCase
{
    use ScreenTesting;

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
