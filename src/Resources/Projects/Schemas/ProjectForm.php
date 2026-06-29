<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use JeffersonGoncalves\Erp\Projects\Enums\ProjectStatus;

class ProjectForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Section::make('Details')
                    ->schema([
                        TextInput::make('project_name')
                            ->label('Project Name')
                            ->required()
                            ->maxLength(255),
                        Select::make('status')
                            ->label('Status')
                            ->options(self::statusOptions())
                            ->default(ProjectStatus::Open->value)
                            ->required(),
                        TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->maxLength(255),
                        TextInput::make('party_id')
                            ->label('Party')
                            ->numeric()
                            ->integer()
                            ->nullable(),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),
                Section::make('Schedule & Costing')
                    ->schema([
                        DatePicker::make('expected_start_date')
                            ->label('Expected Start Date'),
                        DatePicker::make('expected_end_date')
                            ->label('Expected End Date'),
                        TextInput::make('percent_complete')
                            ->label('Percent Complete')
                            ->numeric()
                            ->default(0),
                        TextInput::make('estimated_costing')
                            ->label('Estimated Costing')
                            ->numeric()
                            ->default(0),
                        TextInput::make('total_billable_amount')
                            ->label('Total Billable Amount')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(false),
                    ])->columns(2),
                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /** @return array<string, string> */
    protected static function statusOptions(): array
    {
        $options = [];

        foreach (ProjectStatus::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
