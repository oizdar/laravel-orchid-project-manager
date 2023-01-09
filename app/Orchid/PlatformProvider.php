<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Enums\PermissionsEnum;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Projects list')
                ->icon('table')
                ->route('platform.projects')
                ->title('Projects')
                ->permission(PermissionsEnum::PROJECTS_VIEW->value),

            Menu::make('Create Project')
                ->icon('rocket')
                ->route('platform.project.create')
                ->permission(PermissionsEnum::PROJECTS_EDIT->value),

            Menu::make('Tasks list')
                ->icon('task')
                ->route('platform.tasks')
                ->title('Tasks')
                ->permission(PermissionsEnum::TASKS_VIEW->value),

            Menu::make('Create Task')
                ->icon('event')
                ->route('platform.task.create')
                ->permission(PermissionsEnum::TASKS_EDIT->value),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission(PermissionsEnum::PLATFORM_SYSTEMS_USERS->value)
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission(PermissionsEnum::PLATFORM_SYSTEMS_USERS->value),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission(PermissionsEnum::PLATFORM_SYSTEMS_ROLES->value, __('Roles'))
                ->addPermission(PermissionsEnum::PLATFORM_SYSTEMS_USERS->value, __('Users'))
                ->addPermission(PermissionsEnum::PROJECTS_VIEW->value, __('View Pojects'))
                ->addPermission(PermissionsEnum::PROJECTS_EDIT->value, __('Edit Pojects'))
                ->addPermission(PermissionsEnum::PROJECTS_DELETE->value, __('Edit Pojects'))
                ->addPermission(PermissionsEnum::TASKS_VIEW->value, __('View Tasks'))
                ->addPermission(PermissionsEnum::TASKS_EDIT->value, __('Edit Tasks')),
        ];
    }
}
