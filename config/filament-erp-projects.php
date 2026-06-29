<?php

use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\ActivityTypeResource;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\ProjectResource;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\TaskResource;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\TimesheetResource;
use JeffersonGoncalves\FilamentErp\Projects\Widgets\ProjectStatsWidget;

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation Group
    |--------------------------------------------------------------------------
    |
    | The navigation group under which all ERP projects resources are listed in
    | the Filament panel. Override per-plugin with ->navigationGroup('...').
    |
    */

    'navigation_group' => 'ERP — Projects',

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | The Filament resource classes registered by the plugin. Each entry can be
    | swapped for a custom resource extending the default one.
    |
    */

    'resources' => [
        'activity_type' => ActivityTypeResource::class,
        'project' => ProjectResource::class,
        'task' => TaskResource::class,
        'timesheet' => TimesheetResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    |
    | The Filament widgets registered by the plugin on the panel dashboard.
    |
    */

    'widgets' => [
        'project_stats' => ProjectStatsWidget::class,
    ],

];
