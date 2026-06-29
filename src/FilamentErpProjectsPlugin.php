<?php

namespace JeffersonGoncalves\FilamentErp\Projects;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\FilamentErp\Projects\Concerns\HasErpProjectsPluginConfig;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\ActivityTypeResource;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\ProjectResource;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\TaskResource;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\TimesheetResource;

class FilamentErpProjectsPlugin implements Plugin
{
    use HasErpProjectsPluginConfig;

    public function getId(): string
    {
        return 'filament-erp-projects';
    }

    public function register(Panel $panel): void
    {
        $panel->resources($this->resolveResources([
            'activity_type' => ActivityTypeResource::class,
            'project' => ProjectResource::class,
            'task' => TaskResource::class,
            'timesheet' => TimesheetResource::class,
        ]));

        $panel->widgets($this->resolveWidgets());
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
