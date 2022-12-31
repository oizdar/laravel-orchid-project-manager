<?php

namespace App\Orchid\Layouts\Project;

use App\Models\Project;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProjectListLayout extends Table
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
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('subject', 'Subject')
                ->render(function (Project $project) {
                    return Link::make($project->subject)
                        ->route('platform.project.edit', $project);
                })
                ->sort()
                ->filter(),
            TD::make('description', 'Description'),
            TD::make('start_date', 'Start date')
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE),
            TD::make('end_date', 'Due date')
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE),
        ];
    }
}
