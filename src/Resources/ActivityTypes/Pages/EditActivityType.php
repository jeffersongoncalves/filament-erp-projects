<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\ActivityTypeResource;

class EditActivityType extends EditRecord
{
    protected static string $resource = ActivityTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
