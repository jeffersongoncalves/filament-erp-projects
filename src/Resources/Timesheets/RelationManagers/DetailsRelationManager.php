<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\RelationManagers;

use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $title = 'Time Logs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('activity_type_id')
                    ->label('Activity Type')
                    ->relationship('activityType', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('task_id')
                    ->label('Task')
                    ->relationship('task', 'subject')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'project_name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                DateTimePicker::make('from_time')
                    ->label('From'),
                DateTimePicker::make('to_time')
                    ->label('To'),
                TextInput::make('hours')
                    ->label('Hours')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_billable')
                    ->label('Billable')
                    ->default(true),
                TextInput::make('billing_rate')
                    ->label('Billing Rate')
                    ->numeric()
                    ->default(0),
                TextInput::make('billing_amount')
                    ->label('Billing Amount')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('activityType.name')
                    ->label('Activity Type')
                    ->toggleable(),
                TextColumn::make('task.subject')
                    ->label('Task')
                    ->toggleable(),
                TextColumn::make('hours')
                    ->label('Hours')
                    ->numeric(),
                IconColumn::make('is_billable')
                    ->label('Billable')
                    ->boolean(),
                TextColumn::make('billing_rate')
                    ->label('Rate')
                    ->numeric(),
                TextColumn::make('billing_amount')
                    ->label('Amount')
                    ->numeric(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ]);
    }
}
