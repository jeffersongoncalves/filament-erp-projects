<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\ActivityTypeResource;

class ListActivityTypes extends ListRecords
{
    protected static string $resource = ActivityTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
