<div class="filament-hidden">

![Filament ERP Projects](https://raw.githubusercontent.com/jeffersongoncalves/filament-erp-projects/3.x/art/jeffersongoncalves-filament-erp-projects.png)

</div>

# Filament ERP Projects

Filament v5 panel resources for the [Laravel ERP projects module](https://github.com/jeffersongoncalves/laravel-erp-projects) — projects, tasks and timesheets.

This package is the UI layer for the `jeffersongoncalves/laravel-erp-projects` domain package (namespace `JeffersonGoncalves\Erp\Projects\`). It wires the project models into ready-to-use Filament resources, with a submittable timesheet that can be billed to a sales invoice.

## Features

- **Project resources** — Projects, tasks and activity types
- **Timesheets** — Timesheets with a details relation manager and Submit/Cancel lifecycle
- **Billing** — Create a sales invoice from a submitted timesheet (cross-module)
- **Dashboard widget** — `ProjectStatsWidget` with project and task counts
- **Configurable** — Swap resource classes, change the navigation group or assign a cluster via config

## Compatibility

| Package | PHP | Filament | Laravel |
|---------|-----|----------|---------|
| `^3.0`  | `^8.2` | `^5.0` | `^11.0 \| ^12.0 \| ^13.0` |

## Installation

Install the package via Composer:

```bash
composer require jeffersongoncalves/filament-erp-projects
```

Register the plugin on a Filament panel:

```php
use JeffersonGoncalves\FilamentErp\Projects\FilamentErpProjectsPlugin;

$panel->plugin(
    FilamentErpProjectsPlugin::make()
        ->navigationGroup('ERP — Projects'),
);
```

## Resources

| Resource | Purpose |
|----------|---------|
| `ActivityTypeResource` | Activity types (billing rate) |
| `ProjectResource` | Projects |
| `TaskResource` | Tasks |
| `TimesheetResource` | Timesheets (+ Details RM, Submit/Cancel, Create Sales Invoice) |

The timesheet resource exposes **Submit** and **Cancel** record actions that drive the domain document lifecycle. A submitted timesheet also exposes a **Create Sales Invoice** action that bills the logged time to a downstream sales invoice.

## Widgets

| Widget | Purpose |
|--------|---------|
| `ProjectStatsWidget` | Project and task counts |

## Configuration

Publish the config to swap resource classes, change the navigation group, or adjust widgets:

```bash
php artisan vendor:publish --tag="filament-erp-projects-config"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
