<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Tables;

use Filament\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Projects\Enums\TaskPriority;
use JeffersonGoncalves\Erp\Projects\Enums\TaskStatus;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.project_name')
                    ->label('Project')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof TaskStatus ? $state->value : (string) $state)
                    ->color(fn ($state): string => match ($state) {
                        TaskStatus::Open => 'gray',
                        TaskStatus::Working => 'info',
                        TaskStatus::PendingReview => 'warning',
                        TaskStatus::Overdue => 'danger',
                        TaskStatus::Completed => 'success',
                        TaskStatus::Cancelled => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof TaskPriority ? $state->value : (string) $state)
                    ->color(fn ($state): string => match ($state) {
                        TaskPriority::Low => 'gray',
                        TaskPriority::Medium => 'info',
                        TaskPriority::High => 'warning',
                        TaskPriority::Urgent => 'danger',
                        default => 'gray',
                    }),
                IconColumn::make('is_group')
                    ->label('Group')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('progress')
                    ->label('Progress')
                    ->numeric()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(self::statusOptions()),
                SelectFilter::make('priority')
                    ->label('Priority')
                    ->options(self::priorityOptions()),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
