<?php

namespace App\Enums;

enum PermissionsEnum: string {
    case PLATFORM_INDEX = 'platform.index';
    case PLATFORM_SYSTEMS_ROLES = 'platform.systems.roles';
    case PLATFORM_SYSTEMS_USERS = 'platform.systems.users';
    case PROJECTS_VIEW = 'projects.view';
    case PROJECTS_EDIT = 'projects.edit';
    case PROJECTS_DELETE = 'projects.delete';
    case TASKS_VIEW = 'tasks.view';
    case TASKS_EDIT = 'tasks.edit';
}
