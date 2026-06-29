<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Concerns;

use JeffersonGoncalves\FilamentErp\Core\Concerns\HasErpPluginConfig;

trait HasErpProjectsPluginConfig
{
    use HasErpPluginConfig;

    protected function getConfigKey(): string
    {
        return 'filament-erp-projects';
    }

    protected function getDefaultNavigationGroup(): string
    {
        return 'ERP — Projects';
    }
}
