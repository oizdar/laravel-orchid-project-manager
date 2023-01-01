<?php

namespace Tests\Feature;

use App\Models\Project;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class ProjectViewScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testProjectView()
    {
        $project = Project::factory()->create();

        $screen = $this->screen('platform.project.view')
            ->parameters(['id' => $project->id])
            ->actingAs($this->admin);

        $screen->display()
            ->assertSeeInOrder([
                $project->subject,
                $project->description,
                'Start Date',
                'End Date',
                $project->start_date,
                $project->due_date,
                'Tasks:'
            ]);
    }
}
