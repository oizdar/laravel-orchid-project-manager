<?php

namespace App\Orchid\Layouts\Project;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class ProjectEditLayout extends Rows
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'projects';

    /**
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('project.subject')
                ->title('Subject')
                ->required()
                ->min(6)
                ->max(255)
                ->help('Enter the subject of new project'),
            TextArea::make('project.description')
                ->title('Description')
                ->rows(7)
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
        ];
    }
}
