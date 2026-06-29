<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Projects\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Projects\FilamentErpProjectsPlugin;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Pages\CreateTimesheet;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Pages\EditTimesheet;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Pages\ListTimesheets;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\RelationManagers\DetailsRelationManager;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Schemas\TimesheetForm;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Tables\TimesheetsTable;

class TimesheetResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'naming_series';

    public static function getModel(): string
    {
        return ModelResolver::timesheet();
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
        return TimesheetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TimesheetsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTimesheets::route('/'),
            'create' => CreateTimesheet::route('/create'),
            'edit' => EditTimesheet::route('/{record}/edit'),
        ];
    }
}
