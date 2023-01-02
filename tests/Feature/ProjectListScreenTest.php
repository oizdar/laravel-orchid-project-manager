<?php

namespace Tests\Feature;

use App\Models\Project;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class ProjectListScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testProjectCreate()
    {
        $project = Project::factory()->create();

        $screen = $this->screen('platform.projects')->actingAs($this->admin);
        $screen->display()
            ->assertSeeInOrder([
                'Projects List',
                'All projects',
                'Subject',
                'Description',
                'Start Date',
                'End Date',
                $project->subject,
                $project->description,
                $project->start_date,
                $project->due_date
            ]);
    }
}
