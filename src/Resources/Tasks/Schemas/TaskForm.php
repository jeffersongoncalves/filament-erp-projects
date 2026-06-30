<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\Erp\Projects\Enums\TaskPriority;
use JeffersonGoncalves\Erp\Projects\Enums\TaskStatus;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Details')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255),
                        Select::make('project_id')
                            ->label('Project')
                            ->relationship('project', 'project_name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('status')
                            ->label('Status')
                            ->options(self::statusOptions())
                            ->default(TaskStatus::Open->value)
                            ->required(),
                        Select::make('priority')
                            ->label('Priority')
                            ->options(self::priorityOptions())
                            ->default(TaskPriority::Medium->value)
                            ->required(),
                        Select::make('parent_task_id')
                            ->label('Parent Task')
                            ->relationship('parentTask', 'subject')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Toggle::make('is_group')
                            ->label('Is Group')
                            ->default(false),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])->columns(2),
                Section::make('Schedule')
                    ->schema([
                        DatePicker::make('exp_start_date')
                            ->label('Expected Start Date'),
                        DatePicker::make('exp_end_date')
                            ->label('Expected End Date'),
                        TextInput::make('progress')
                            ->label('Progress')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /** @return array<string, string> */
    protected static function statusOptions(): array
    {
        $options = [];

        foreach (TaskStatus::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }

    /** @return array<string, string> */
    protected static function priorityOptions(): array
    {
        $options = [];

        foreach (TaskPriority::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
