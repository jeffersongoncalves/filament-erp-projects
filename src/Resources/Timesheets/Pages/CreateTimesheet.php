<?php

namespace JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\TimesheetResource;

class CreateTimesheet extends CreateRecord
{
    protected static string $resource = TimesheetResource::class;
}
