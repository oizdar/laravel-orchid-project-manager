<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TestCase;

class ProjectEditScreenTest extends TestCase
{
    use ScreenTesting;

    private ?User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin ??= User::factory()
            ->admin()
            ->create();
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
