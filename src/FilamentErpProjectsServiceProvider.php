<?php

namespace JeffersonGoncalves\FilamentErp\Projects;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentErpProjectsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-erp-projects';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations();
    }
}
