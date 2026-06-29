<?php

it('loads the filament-erp-projects config file', function () {
    expect(config('filament-erp-projects'))->toBeArray();
});

it('has a default navigation group', function () {
    expect(config('filament-erp-projects.navigation_group'))->toBe('ERP — Projects');
});

it('registers all resources in config', function () {
    $resources = config('filament-erp-projects.resources');

    expect($resources)->toBeArray()
        ->toHaveKeys([
            'activity_type',
            'project',
            'task',
            'timesheet',
        ]);
});

it('registers the dashboard widgets in config', function () {
    expect(config('filament-erp-projects.widgets'))->toBeArray()
        ->toHaveKeys(['project_stats']);
});
