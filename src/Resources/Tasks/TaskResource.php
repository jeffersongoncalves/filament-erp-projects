<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Projects\Support\ModelResolver;
use JeffersonGoncalves\FilamentErp\Projects\FilamentErpProjectsPlugin;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Pages\CreateTask;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Pages\EditTask;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Pages\ListTasks;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Schemas\TaskForm;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Tables\TasksTable;

class TaskResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'subject';

    public static function getModel(): string
    {
        return ModelResolver::task();
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
        return TaskForm::configure($form);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
