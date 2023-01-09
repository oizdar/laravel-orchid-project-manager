<?php

namespace Tests\Feature;

use App\Enums\PermissionsEnum;
use App\Models\Project;
use App\Models\User;
use Orchid\Support\Testing\ScreenTesting;
use Tests\FeatureTestCase;

class ProjectEditScreenTest extends FeatureTestCase
{
    use ScreenTesting;

    public function testProjectCreateUnaccessibleWithoutProperPermission()
    {
        $user = User::factory()->create();
        $screen = $this->screen('platform.project.create')->actingAs($user);

        $screen->display()->assertStatus(403);

    }

    public function testProjectEditUnaccessibleWithoutProperPermission()
    {
        $user = User::factory()->create();
        $project = Project::latest()->first();

        $screen = $this->screen('platform.project.edit')
            ->parameters(['id' => $project->id])
            ->actingAs($user);

        $screen->display()->assertStatus(403);

    }

    public function testProjectCreateAccessibleWithProperPermission()
    {
        $user = User::factory()
            ->withPermisions([PermissionsEnum::PLATFORM_INDEX->value, PermissionsEnum::PROJECTS_EDIT->value])
            ->create();
        $screen = $this->screen('platform.project.create')->actingAs($user);

        $screen->display()->assertStatus(200);
    }

    public function testProjectEditAccessibleWithProperPermission()
    {
        $user = User::factory()
            ->withPermisions([PermissionsEnum::PLATFORM_INDEX->value, PermissionsEnum::PROJECTS_EDIT->value])
            ->create();
        $project = Project::latest()->first();

        $screen = $this->screen('platform.project.edit')
            ->parameters(['id' => $project->id])
            ->actingAs($user);

        $screen->display()->assertStatus(200);
    }

    public function testProjectCreate()
    {
        $screen = $this->screen('platform.project.create')->actingAs($this->admin);
        $screen->display()
            ->assertSeeInOrder([
                'Create New Project',
                'You can create new project here',
                'Subject',
                'Description',
                'Start Date',
                'End Date',
                ]);

        $project = Project::factory()->create();
        $screen->method('create', [
                'project' => $project
            ]);

        $this->assertDatabaseHas('projects', [
            'subject' => $project->subject,
            'description' => $project->description,
        ]);
    }

    public function testProjectEdit()
    {
        $project = Project::latest()->first();

        $screenEdit = $this->screen('platform.project.edit')
            ->parameters(['id' => $project->id])
            ->actingAs($this->admin);

        $screenEdit->display()
            ->assertSeeInOrder([
                'Edit Project',
                'Update project information',
                'Subject',
                $project->subject,
                'Description',
                $project->description,
                'Start Date',
                $project->start_date,
                'End Date',
            ]);


        $project->end_date = fake()->dateTimeBetween($project->start_date, '+1month')->format('Y-m-d');

        $screenEdit->method('update', ['project' => [
            'subject' => $project->subject,
            'description' => $project->description,
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
        ]]);

        $this->assertDatabaseHas('projects', [
            'subject' => $project->subject,
            'description' => $project->description,
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
        ]);
    }

    public function testProjectRemove()
    {
        $project = Project::all()->random();

        $screenEdit = $this->screen('platform.project.edit')->parameters(['id' => $project->id])->actingAs($this->admin);
        $screenEdit->display()
            ->assertSeeInOrder([
                'Edit Project',
                'Update project information',
                'Subject',
                $project->subject,
                'Description',
                $project->description,
                'Start Date',
                $project->start_date,
                'End Date',
            ]);

        $screenEdit->method('remove', ['project' => $project]);

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }


}
