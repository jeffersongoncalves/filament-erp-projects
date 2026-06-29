<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class TimesheetForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Section::make('Details')
                    ->schema([
                        TextInput::make('employee')
                            ->label('Employee')
                            ->maxLength(255),
                        TextInput::make('user')
                            ->label('User')
                            ->maxLength(255),
                        Select::make('parent_project_id')
                            ->label('Project')
                            ->relationship('project', 'project_name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('status')
                            ->label('Status')
                            ->default('Draft')
                            ->maxLength(255),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),
                Section::make('Period & Totals')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Start Date'),
                        DatePicker::make('end_date')
                            ->label('End Date'),
                        TextInput::make('total_hours')
                            ->label('Total Hours')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(false),
                        TextInput::make('total_billable_amount')
                            ->label('Total Billable Amount')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }
}
