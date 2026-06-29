<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Projects;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Projects\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Projects\FilamentErpProjectsPlugin;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Pages\CreateProject;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Pages\EditProject;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Pages\ListProjects;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Schemas\ProjectForm;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Tables\ProjectsTable;

class ProjectResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'project_name';

    public static function getModel(): string
    {
        return ModelResolver::project();
    }

    public static function getNavigationGroup(): ?string
    {
        try {
            return FilamentErpProjectsPlugin::get()->getNavigationGroup();
        } catch (\Throwable) {
            return config('filament-erp-projects.navigation_group', 'ERP — Projects');
        }
    }

    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
