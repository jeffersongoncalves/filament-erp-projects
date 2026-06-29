<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Tables;

use Filament\Tables\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ActivityTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('default_costing_rate')
                    ->label('Costing Rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('default_billing_rate')
                    ->label('Billing Rate')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('disabled')
                    ->label('Disabled')
                    ->boolean(),
            ])
            ->defaultSort('name')
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
