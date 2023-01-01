<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Orchid\Support\Testing\ScreenTesting;
use Tests\TestCase;

class ProjectListScreenTest extends TestCase
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
