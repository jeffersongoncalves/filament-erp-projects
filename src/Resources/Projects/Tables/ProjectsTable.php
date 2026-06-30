<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Tables;

use Filament\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Projects\Enums\ProjectStatus;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project_name')
                    ->label('Project Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof ProjectStatus ? $state->value : (string) $state)
                    ->color(fn ($state): string => match ($state) {
                        ProjectStatus::Open => 'info',
                        ProjectStatus::Completed => 'success',
                        ProjectStatus::Cancelled => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('customer_name')
                    ->label('Customer')
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('percent_complete')
                    ->label('% Complete')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_billable_amount')
                    ->label('Billable')
                    ->numeric()
                    ->toggleable(),
                TextColumn::make('expected_end_date')
                    ->label('End Date')
                    ->date()
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

        foreach (ProjectStatus::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
