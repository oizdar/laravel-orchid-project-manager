<?php

namespace Tests\Feature;

use App\Enums\PermissionsEnum;
use App\Models\Project;
use App\Models\User;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class ProjectViewScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testProjectViewUnaccessibleWithoutProperPermission()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        $screen = $this->screen('platform.project.view')
            ->parameters(['id' => $project->id])
            ->actingAs($user);

        $screen->display()->assertStatus(403);
    }

    public function testProjectViewAccessibleWithProperPermission()
    {
        $user = User::factory()
            ->withPermisions([PermissionsEnum::PLATFORM_INDEX->value, PermissionsEnum::PROJECTS_VIEW->value])
            ->create();
        $project = Project::factory()->create();

        $screen = $this->screen('platform.project.view')
            ->parameters(['id' => $project->id])
            ->actingAs($user);

        $screen->display()->assertStatus(200);
    }

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
