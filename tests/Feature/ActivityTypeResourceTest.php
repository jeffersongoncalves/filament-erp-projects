<?php

use JeffersonGoncalves\Erp\Projects\Models\ActivityType;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages\CreateActivityType;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages\EditActivityType;
use JeffersonGoncalves\FilamentErp\Projects\Resources\ActivityTypes\Pages\ListActivityTypes;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));
});

it('can render the activity type list page', function () {
    Livewire::test(ListActivityTypes::class)->assertSuccessful();
});

it('can render the activity type create page', function () {
    Livewire::test(CreateActivityType::class)->assertSuccessful();
});

it('can render the activity type edit page', function () {
    $activityType = ActivityType::factory()->create();

    Livewire::test(EditActivityType::class, ['record' => $activityType->getRouteKey()])
        ->assertSuccessful();
});

it('can create an activity type through the form', function () {
    Livewire::test(CreateActivityType::class)
        ->fillForm([
            'name' => 'Development',
            'default_costing_rate' => 40,
            'default_billing_rate' => 100,
            'disabled' => false,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $activityType = ActivityType::query()->where('name', 'Development')->first();

    expect($activityType)->not->toBeNull()
        ->and($activityType->default_costing_rate)->toBe(40.0)
        ->and($activityType->default_billing_rate)->toBe(100.0);
});
