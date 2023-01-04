<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Orchid\Layouts\Project\ProjectEditLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class ProjectEditScreen extends Screen
{
    public Project $project;

    public function permission(): ?iterable
    {
        return [
            'projects.edit'
        ];
    }

    public function query(Project $project): iterable
    {
        return [
            'project' => $project
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->project->exists ? 'Edit Project' : 'Create New Project';
    }

    public function description(): ?string
    {
        return $this->project->exists ? 'Update project information' : 'You can create new project here';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $links = [
            Button::make('Create Project')
                ->icon('rocket')
                ->method('create')
                ->canSee(!$this->project->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->project->exists),
        ];

        if(Auth::user()->hasAccess('projects.delete')) {
            $links[] = Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->confirm("Are you going to delete project: {$this->project->subject} With all its Tasks!!! Are you sure?")
                ->canSee($this->project->exists);
        }

        return $links;
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProjectEditLayout::class
        ];
    }

    public function create(Project $project, Request $request): RedirectResponse
    {
        $this->validateRequest($request);
        $project->fill($request->get('project'))->save();

        Alert::info('Project creating successful');

        return redirect()->route('platform.project.edit', ['id' => $project->id]);
    }

    public function update(Project $project, Request $request): void
    {
        $this->validateRequest($request);
        $project->fill($request->get('project'))->save();

        Alert::info('Project updated successful');
    }

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'project.subject' => 'required|min:6|max:255',
            'project.description' => 'required|min:10|max:255',
            'project.start_date'   => 'required|date|after_or_equal:today',
            'project.end_date'   => 'nullable|date|after:startDate',
        ]);
    }

    public function remove(Project $project): RedirectResponse
    {
        $project->delete();
        Alert::info("You have successfully deleted project: $project->subject" );

        return redirect()->route('platform.projects');
    }
}
