<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Models\Task;
use App\Orchid\Layouts\Task\TaskListLayout;
use Illuminate\Http\RedirectResponse;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProjectViewScreen extends Screen
{
    public Project $project;

    public function query(Project $project): iterable
    {
        return [
            'project' => $project,
            'tasksTitle' => 'Project tasks list:',
            'tasks' => $project->tasks
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Project Details';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Edit')
                ->icon('pencil')
                ->route('platform.project.edit', ['id' => $this->project->id]),
            Button::make('Remove')
                ->icon('trash')
                ->confirm('Are you going to delete project: ' . $this->project->subject)
                ->method('remove'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('project', [
                Sight::make('id')->popover('Identifier, a symbol which uniquely identifies an object or record'),
                Sight::make('description', 'Project Description'),
                Sight::make('start_date', 'Start Date'),
                Sight::make('end_date', 'End Date '),
                Sight::make('created_at', 'Created'),
                Sight::make('updated_at', 'Updated'),
            ])->title($this->project->subject),
            TaskListLayout::class
        ];
    }

    public function remove(Project $project): RedirectResponse
    {
        $project->delete();
        Alert::info("You have successfully deleted project: $project->subject" );

        return redirect()->route('platform.projects');
    }
}
