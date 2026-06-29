<?php

use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\Erp\Projects\Enums\ProjectStatus;
use JeffersonGoncalves\Erp\Projects\Models\Project;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Pages\CreateProject;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Pages\EditProject;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Projects\Pages\ListProjects;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
});

it('can render the project list page', function () {
    Livewire::test(ListProjects::class)->assertSuccessful();
});

it('can render the project create page', function () {
    Livewire::test(CreateProject::class)->assertSuccessful();
});

it('can render the project edit page', function () {
    $project = Project::factory()->create(['company_id' => $this->company->id]);

    Livewire::test(EditProject::class, ['record' => $project->getRouteKey()])
        ->assertSuccessful();
});

it('can create a project through the form', function () {
    Livewire::test(CreateProject::class)
        ->fillForm([
            'project_name' => 'Website Revamp',
            'status' => ProjectStatus::Open->value,
            'customer_name' => 'Acme Corp',
            'company_id' => $this->company->id,
            'percent_complete' => 0,
            'estimated_costing' => 5000,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $project = Project::query()->where('project_name', 'Website Revamp')->first();

    expect($project)->not->toBeNull()
        ->and($project->status)->toBe(ProjectStatus::Open)
        ->and($project->customer_name)->toBe('Acme Corp');
});
