<?php

use Filament\Actions\Testing\TestAction;
use JeffersonGoncalves\Erp\Accounting\Enums\AccountType;
use JeffersonGoncalves\Erp\Accounting\Enums\RootType;
use JeffersonGoncalves\Erp\Accounting\Models\Account;
use JeffersonGoncalves\Erp\Accounting\Models\SalesInvoice;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\Erp\Core\Models\Company;
use JeffersonGoncalves\Erp\Projects\Models\ActivityType;
use JeffersonGoncalves\Erp\Projects\Models\Project;
use JeffersonGoncalves\Erp\Projects\Models\Timesheet;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Pages\CreateTimesheet;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Pages\EditTimesheet;
use JeffersonGoncalves\FilamentErp\Projects\Resources\Timesheets\Pages\ListTimesheets;
use Livewire\Livewire;

beforeEach(function () {
    filament()->setCurrentPanel(filament()->getPanel('admin'));

    $this->company = Company::factory()->create();

    $this->project = Project::factory()->create([
        'company_id' => $this->company->id,
        'customer_name' => 'Acme Corp',
    ]);
});

function makeTimesheet(): Timesheet
{
    $timesheet = Timesheet::factory()->create([
        'company_id' => test()->company->id,
        'parent_project_id' => test()->project->id,
    ]);

    $activityType = ActivityType::factory()->create(['name' => 'Development']);

    $timesheet->details()->create([
        'activity_type_id' => $activityType->id,
        'hours' => 4,
        'is_billable' => true,
        'billing_rate' => 100,
        'costing_rate' => 40,
    ]);

    return $timesheet->refresh();
}

it('can render the timesheet list page', function () {
    Livewire::test(ListTimesheets::class)->assertSuccessful();
});

it('can render the timesheet create page', function () {
    Livewire::test(CreateTimesheet::class)->assertSuccessful();
});

it('can render the timesheet edit page', function () {
    $timesheet = makeTimesheet();

    Livewire::test(EditTimesheet::class, ['record' => $timesheet->getRouteKey()])
        ->assertSuccessful();
});

it('submits a timesheet through the UI, locking the document', function () {
    $timesheet = makeTimesheet();

    Livewire::test(ListTimesheets::class)
        ->callAction(TestAction::make('submit')->table($timesheet));

    $timesheet->refresh();

    expect($timesheet->docstatus)->toBe(DocStatus::Submitted)
        ->and($timesheet->total_billable_amount)->toBe(400.0);
});

it('creates a sales invoice from a submitted timesheet through the UI', function () {
    $receivable = Account::factory()
        ->ofType(RootType::Asset, AccountType::Receivable)
        ->create(['company_id' => $this->company->id]);

    $income = Account::factory()
        ->ofType(RootType::Income, AccountType::Income)
        ->create(['company_id' => $this->company->id]);

    $timesheet = makeTimesheet();

    // A non-billable line must not produce an invoice line.
    $timesheet->details()->create([
        'hours' => 1,
        'is_billable' => false,
        'billing_rate' => 100,
        'costing_rate' => 40,
    ]);

    $timesheet->refresh();

    Livewire::test(ListTimesheets::class)
        ->callAction(TestAction::make('submit')->table($timesheet));

    expect($timesheet->refresh()->docstatus)->toBe(DocStatus::Submitted);

    Livewire::test(ListTimesheets::class)
        ->callAction(TestAction::make('createSalesInvoice')->table($timesheet), data: [
            'debit_to_id' => $receivable->id,
            'income_account_id' => $income->id,
        ]);

    $timesheet->refresh();

    $invoice = SalesInvoice::query()->find($timesheet->sales_invoice_id);

    expect($invoice)->not->toBeNull()
        ->and($invoice->customer_name)->toBe('Acme Corp')
        ->and($invoice->items)->toHaveCount(1)
        ->and($invoice->items->first()->item_code)->toBe('SERVICE')
        ->and($invoice->items->first()->qty)->toBe(4.0)
        ->and($invoice->items->first()->rate)->toBe(100.0)
        ->and($timesheet->per_billed)->toBe(100.0);
});
