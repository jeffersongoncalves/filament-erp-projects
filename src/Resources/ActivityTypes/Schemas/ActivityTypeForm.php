<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('default_costing_rate')
                            ->label('Default Costing Rate')
                            ->numeric()
                            ->default(0),
                        TextInput::make('default_billing_rate')
                            ->label('Default Billing Rate')
                            ->numeric()
                            ->default(0),
                        Toggle::make('disabled')
                            ->label('Disabled')
                            ->default(false),
                    ])->columns(2),
            ]);
    }
}
