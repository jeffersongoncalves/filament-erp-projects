<?php

use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\Erp\Projects\Enums\TaskPriority;
use JeffersonGoncalves\Erp\Projects\Enums\TaskStatus;
use JeffersonGoncalves\Erp\Projects\Models\Project;
use JeffersonGoncalves\Erp\Projects\Models\Task;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Pages\CreateTask;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Pages\EditTask;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Tasks\Pages\ListTasks;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();
    $this->project = Project::factory()->create(['company_id' => $this->company->id]);
});

it('can render the task list page', function () {
    Livewire::test(ListTasks::class)->assertSuccessful();
});

it('can render the task create page', function () {
    Livewire::test(CreateTask::class)->assertSuccessful();
});

it('can render the task edit page', function () {
    $task = Task::factory()->create([
        'project_id' => $this->project->id,
        'company_id' => $this->company->id,
    ]);

    Livewire::test(EditTask::class, ['record' => $task->getRouteKey()])
        ->assertSuccessful();
});

it('can create a task through the form', function () {
    Livewire::test(CreateTask::class)
        ->fillForm([
            'subject' => 'Design homepage',
            'project_id' => $this->project->id,
            'status' => TaskStatus::Open->value,
            'priority' => TaskPriority::High->value,
            'company_id' => $this->company->id,
            'progress' => 0,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $task = Task::query()->where('subject', 'Design homepage')->first();

    expect($task)->not->toBeNull()
        ->and($task->status)->toBe(TaskStatus::Open)
        ->and($task->priority)->toBe(TaskPriority::High);
});
