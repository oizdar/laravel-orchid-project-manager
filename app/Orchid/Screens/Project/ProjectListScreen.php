<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Orchid\Layouts\Project\ProjectListLayout;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ProjectListScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'projects.view'
        ];
    }

    public function query(): iterable
    {
        return [
            'projects' => Project::filters()->defaultSort('id', 'DESC')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Projects List';
    }

    public function description(): ?string
    {
        return 'All projects';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        $links = [];

        if(Auth::user()->hasAccess('projects.edit')) {
          $links[] = Link::make('Create new')
              ->icon('pencil')
              ->route('platform.project.create');
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
            ProjectListLayout::class
        ];
    }
}
