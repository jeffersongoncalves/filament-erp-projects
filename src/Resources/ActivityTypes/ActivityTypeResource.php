<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Projects\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Projects\FilamentErpProjectsPlugin;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages\CreateActivityType;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages\EditActivityType;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages\ListActivityTypes;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Schemas\ActivityTypeForm;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Tables\ActivityTypesTable;

class ActivityTypeResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModel(): string
    {
        return ModelResolver::activityType();
    }

    public static function getNavigationGroup(): ?string
    {
        try {
            return FilamentErpProjectsPlugin::get()->getNavigationGroup();
        } catch (\Throwable) {
            return config('filament-erp-projects.navigation_group', 'ERP — Projects');
        }
    }

    public static function form(Form $form): Form
    {
        return ActivityTypeForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return ActivityTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityTypes::route('/'),
            'create' => CreateActivityType::route('/create'),
            'edit' => EditActivityType::route('/{record}/edit'),
        ];
    }
}
