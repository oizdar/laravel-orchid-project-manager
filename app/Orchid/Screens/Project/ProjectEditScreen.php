<?php

namespace App\Orchid\Screens\Project;

use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ProjectEditScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create Project';
    }

    public function description(): ?string
    {
        return 'You can create new project here';
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
                ->method('createProject')
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
                Input::make('subject')
                    ->title('Subject')
                    ->required()
                    ->min(6)
                    ->max(255)
                    ->help('Enter the subject of new project'),
                TextArea::make('description')
                    ->title('Description')
                    ->required()
                    ->placeholder('Project description.')
                    ->help('Enter short description of new Project'),
                DateTimer::make('startDate')
                    ->title('Start Date')
                    ->format('Y-m-d')
                    ->required()
                    ->placeholder('Project starts on')
                    ->help('Select date when project will start'),
                DateTimer::make('endDate')
                    ->title('End Date')
                    ->format('Y-m-d')
                    ->placeholder('Project planned until')
                    ->help('Select when do you plan to complete project'),

            ])
        ];
    }

    public function createProject(Request $request)
    {
        $request->validate([
            'subject' => 'required|min:6|max:255',
            'description' => 'required|min:10|max:255',
            'startDate'   => 'required|date|after_or_equal:today',
            'endDate'   => 'nullable|date|after:startDate',
        ]);
    }
}
