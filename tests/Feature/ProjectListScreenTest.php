<?php

namespace Tests\Feature;

use App\Enums\PermissionsEnum;
use App\Models\Project;
use App\Models\User;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class ProjectListScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testProjectListUnaccessibleWithoutProperPermission()
    {
        $user = User::factory()->create();
        $screen = $this->screen('platform.projects')->actingAs($user);

        $screen->display()->assertStatus(403);
    }

    public function testProjectListAccessibleWithProperPermission()
    {
        $user = User::factory()
            ->withPermisions([PermissionsEnum::PLATFORM_INDEX->value, PermissionsEnum::PROJECTS_VIEW->value])
            ->create();

        $screen = $this->screen('platform.projects')->actingAs($user);

        $screen->display()->assertStatus(200);
    }

    public function testProjectList()
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
