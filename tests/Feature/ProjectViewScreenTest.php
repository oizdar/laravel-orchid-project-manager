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
                'Id',
                $project->id,
                'Project Description',
                $project->description,
                'Start Date',
                $project->start_date,
                'End Date',
                $project->end_date,
                'Created',
                'Updated',
            ]);
    }
}
