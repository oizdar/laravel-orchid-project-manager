<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProjectEditScreen extends Screen
{
    public Project $project;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
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
        return $this->project->exists ? 'Edit project' : 'Create Project';
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
        return [
            Button::make('Create Project')
                ->icon('rocket')
                ->method('create')
                ->canSee(!$this->project->exists),

            Button::make('Update')
                ->icon('note')
                ->method('update')
                ->canSee($this->project->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->project->exists),
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
            Layout::rows([
                Input::make('project.subject')
                    ->title('Subject')
                    ->required()
                    ->min(6)
                    ->max(255)
                    ->help('Enter the subject of new project'),
                TextArea::make('project.description')
                    ->title('Description')
                    ->required()
                    ->placeholder('Project description.')
                    ->help('Enter short description of new Project'),
                DateTimer::make('project.start_date')
                    ->title('Start Date')
                    ->format('Y-m-d')
                    ->required()
                    ->placeholder('Project starts on')
                    ->help('Select date when project will start'),
                DateTimer::make('project.end_date')
                    ->title('End Date')
                    ->format('Y-m-d')
                    ->placeholder('Project planned until')
                    ->help('Select when do you plan to complete project'),

            ])
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
        Alert::info('You have successfully deleted the project.');

        return redirect()->route('platform.project.create');
    }
}
